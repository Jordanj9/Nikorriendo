<?php

namespace App\Http\Controllers;

use App\Permiso;
use App\Solicitudcambio;
use App\Lavadora;
use App\Cambios;
use App\Persona;
use App\Servicio;
use App\Estado_mantenimiento;
use App\Auditoriaservicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SolicitudcambioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        if ($persona != null && session('ROL') != 'ADMINISTRADOR') {
            $soli = Solicitudcambio::all();
            $solicitudes = [];
            $solicitudes = collect($solicitudes);
            if (session('ROL') == 'CENTRAL') {
                if (count($soli) > 0) {
                    foreach ($soli as $sol) {
                        if ($persona->sucursal_id == $sol->servicio->sucursal_id) {
                            $solicitudes[] = $sol;
                        }
                    }
                }
            } else {
                if (count($soli) > 0) {
                    foreach ($soli as $sol) {
                        if ($persona->id == $sol->servicio->persona_id) {
                            $solicitudes[] = $sol;
                        }
                    }
                }
                $persmisos = Permiso::where([
                    ['persona_id', $persona->id],
                    ['tipo', 'CAMBIO']
                ])->get();

                foreach ($persmisos as $item){
                    $solicitud = $item->solicitudcambio;
                    if($solicitud->estado == 'PENDIENTE'){
                        $solicitudes[] = $solicitud;
                    }
                }

            }
        } else {
            $solicitudes = Solicitudcambio::all();
        }


        $solicitudes = $solicitudes->sortByDesc('created_at');

        $per = Persona::all()->sortBy('primer_nombre');
        $personas = null;
        if (count($per) > 0) {
            foreach ($per as $i) {
                if ($i->tipo == "MENSAJERO" && $i->estado == "ACTIVO") {
                    $personas[$i->id] = $i->primer_nombre . ' ' . $i->segundo_nombre . ' ' . $i->primer_apellido . ' ' . $i->segundo_apellido . ' -CARGO:' . $i->tipo . ' -SUCURSAL:' . $i->sucursal->nombre;
                }
            }
        }
        return view('servicio.cambios.list')
                        ->with('location', 'servicio')
                        ->with('personas', $personas)
                        ->with('solicitudes', $solicitudes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $servicio = Servicio::find($request->servicio_id);
        $solicitud = new Solicitudcambio($request->all());
        $hoy = getdate();
        $fecha = $hoy['year'] . '-' . $hoy['mon'] . '-' . $hoy['mday'] . ' ' . $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];
        $fecha = strtotime($fecha);
        $fin = strtotime($servicio->fechafin);
        $pendientes = abs(($fin - $fecha) / 3600);
        $horas = floor($pendientes);
        $minutos = $pendientes - $horas;
        $pendientes = $minutos * 60;
        $minutos = floor($pendientes);
        $segundos = $pendientes - $minutos;
        $segundos = floor($segundos * 60);
        $solicitud->tiempopendiente = $horas . ":" . $minutos . ":" . $segundos;
        $result = $solicitud->save();
        if ($result) {
            $final = strtotime("+1 day", $fin);
            $servicio->fechafin = date("Y-m-d H:i:s", $final);
            $servicio->estado = 'CAMBIO';
            $servicio->save();
            $u = Auth::user();
            $aud = new Auditoriaservicio();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "SOLICITUD DE CAMBIO";
            $str = "CREACIÓN DE SOLICITUD DE CAMBIO. DATOS: ";
            foreach ($solicitud->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Solicitud de cambio para el cliente <strong>" . $servicio->cliente->nombre . "</strong> fue almacenado(a) de forma exitosa!")->success();
            return redirect()->route('solicitud.index');
        } else {
            flash("La Solicitud de cambio para el cliente <strong>" . $servicio->cliente->nombre . "</strong> no pudo ser almacenado(a). Error: " . $result)->error();
            return redirect()->route('solicitud.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Solicitudcambio  $solicitudcambio
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitudcambio $solicitudcambio) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Solicitudcambio  $solicitudcambio
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitudcambio $solicitudcambio) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Solicitudcambio  $solicitudcambio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitudcambio $solicitudcambio) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Solicitudcambio  $solicitudcambio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Solicitudcambio $solicitudcambio) {
        //
    }

    /**
     * Acepta las solicitudes de cambio generada por la central
     *
     * @param type $solicitudcambio_id
     * @return true or false
     */
    public function entregarCambio($id) {
        $solicitud = Solicitudcambio::find($id);
        $u = Auth::user();
        $persona = Persona::where([['identificacion', $u->identificacion], ['tipo', 'MENSAJERO']])->first();
        if ($persona != null) {
            $lavadoras_aux = $persona->lavadoras;
            $lavadoras = [];
            if (count($lavadoras_aux) > 0) {
                foreach ($lavadoras_aux as $l) {
                    if ($l->estado_lavadora == 'DISPONIBLE') {
                        $lavadoras[$l->id] = $l->serial . ' - ' . $l->marca;
                    }
                }
            }
            $lavadoras = collect($lavadoras);
            $lavadoras_aux = $solicitud->servicio->lavadoras;
            foreach ($lavadoras_aux as $i) {
                $lavadoras_ser[$i->id] = $i->serial . ' - ' . $i->marca;
            }
            return view('servicio.cambios.entregar')
                            ->with('location', 'servicio')
                            ->with('lavadoras', $lavadoras)
                            ->with('lavadoras_ser', $lavadoras_ser)
                            ->with('solicitud_id', $id);
        } else {
            flash("Error : esta opción solo es valida para los <strong>" . 'mensajeros' . "</strong> ")->error();
            return back();
        }
    }

    public function guardarCambio(Request $request) {
        $solicitud = Solicitudcambio::find($request->solicitud_id);
        $m = new Solicitudcambio($solicitud->attributesToArray());
        if ($solicitud->servicio->num_lavadoras >= count($request->lavadoras) && count($request->lavadoras) == count($request->lavadoras_ser)) {
            $solicitud->estado = 'FINALIZADO';
            $hoy = getdate();
//            $servicio->fechaentrega = $hoy['year'] . '-' . $hoy['mon'] . '-' . $hoy['mday'] . ' ' . $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];
//            $string = "+" . $servicio->dias . " day";
//            $fecha = strtotime($servicio->fechaentrega);
//            $fin = strtotime($string, $fecha);
//            $servicio->fechafin = date("Y-m-d H:i:s", $fin);
            // Imagen base64 enviada desde javascript en el formulario
            // En este caso, con PHP plano podriamos obtenerla usando :
            // $baseFromJavascript = $_POST['base64'];
            $baseFromJavascript = $request->base_64;
            // Nuestro base64 contiene un esquema Data URI (data:image/png;base64,)
            // que necesitamos remover para poder guardar nuestra imagen
            // Usa explode para dividir la cadena de texto en la , (coma)
            $base_to_php = explode(',', $baseFromJavascript);
            // El segundo item del array base_to_php contiene la información que necesitamos (base64 plano)
            // y usar base64_decode para obtener la información binaria de la imagen
            $data = base64_decode($base_to_php[1]); // BBBFBfj42Pj4....
            $nombre_file = 'firma_entrega_cambio_' . $hoy['year'] . $hoy['mon'] . $hoy['mday'] . $hoy['hours'] . $hoy['minutes'] . $hoy['seconds'] . '.png';
            // Proporciona una locación a la nueva imagen (con el nombre y formato especifico)
            $filepath = public_path() . '/docs/firma_entregas_cambio/' . $nombre_file; // or image.jpg
            // Finalmente guarda la imágen en el directorio especificado y con la informacion dada
            file_put_contents($filepath, $data);
            $solicitud->firma_cliente = $nombre_file;
            $cont = 0;
            $result = $solicitud->save();
            if ($result) {
                $hoy = getdate();
                $fecha = $hoy['year'] . '-' . $hoy['mon'] . '-' . $hoy['mday'] . ' ' . $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];
                $fecha = strtotime($fecha);
                $servicio =$solicitud->servicio;
                $fin = strtotime($servicio->fechafin);
                $pendiente = explode(':',$solicitud->tiempopendiente);
                $newDate = strtotime('+'.$pendiente[0].' hour',$fecha);
                $newDate = strtotime('+'.$pendiente[1].' minute',$newDate);
                $newDate = strtotime('+'.$pendiente[2].' second',$newDate);

                $servicio->fechafin = date("Y-m-d H:i:s", $newDate);
                $servicio->estado = 'ENTREGADO';

                $servicio->save();

                foreach ($request->lavadoras as $value) {
                    $cambio = new Cambios();
                    $cambio->lavadora_vieja = $request->lavadoras_ser[$cont];
                    $cambio->lavadora_id = $value;
                    $cambio->solicitudcambio_id = $solicitud->id;
                    $lav_vieja = Lavadora::find($request->lavadoras_ser[$cont]);
                    $lav_vieja->estado_lavadora = "MANTENIMIENTO";
                    $lav_nue = Lavadora::find($value);
                    $lav_nue->estado_lavadora = "SERVICIO";
                    $lav_nue->estado_bodega = "NO";
                    $cambio->save();
                    $lav_nue->save();
                    $lav_vieja->save();
                    $cont ++;
                }
                foreach ($request->lavadoras_ser as $item) {
                    $mant = new Estado_mantenimiento;
                    $mant->lavadora_id = $item;
                    $mant->save();
                }

                $servicio->lavadoras()->sync($request->lavadoras);

                $aud = new Auditoriaservicio();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ENTREGA";
                $str = "ENTREGA DE CAMBIO. DATOS NUEVOS: ";
                $str2 = " DATOS ANTIGUOS: ";
                foreach ($m->attributesToArray() as $key => $value) {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
                foreach ($solicitud->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str . " - " . $str2;
                $aud->save();
                return response()->json([
                            'status' => 'ok',
                            'message' => "Success : el cambio para la dirección " . $solicitud->servicio->direccion . " fue entregado correctamente",
                ]);
            } else {
                return response()->json([
                            'status' => 'error',
                            'message' => "Error : el cambio para la dirección " . $solicitud->servicio->direccion . " no pudo ser entregado correctamente",
                ]);
            }
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => "Error : tenga en cuenta que debe selecionar el mismo numero de lavadoras solicitadas por el cliente"
            ]);
        }
    }

    public function solicitudCambio($id) {
        $servicio = Servicio::find($id);
        dd($servicio);
    }

}
