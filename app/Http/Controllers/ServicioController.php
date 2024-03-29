<?php

namespace App\Http\Controllers;

use App\Permiso;
use App\Servicio;
use App\Lavadora;
use App\Persona;
use App\Cliente;
use App\Auditoriaservicio;
use App\Bodega;
use App\Barrio;
use App\Http\Requests\ServicioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServicioController extends Controller {

    public function index() {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        if ($persona != null && session('ROL') != 'ADMINISTRADOR') {
            if (session('ROL') == 'CENTRAL') {
                $servicios = Servicio::where('sucursal_id', $persona->sucursal_id)->get()->sortBy('estado');
            } else {
                $servicios = Servicio::where([
                            ['sucursal_id', $persona->sucursal_id],
                            ['persona_id', $persona->id]
                        ])->get();
            }
        } else {
            $servicios = Servicio::all();
        }
        $servicios = $servicios->sortByDesc('created_at');
        return view('servicio.servicios.list')
                        ->with('location', 'servicio')
                        ->with('servicios', $servicios);
    }

    public function create() {
        $u = Auth::user();
        $persona = Persona::where([['identificacion', $u->identificacion], ['tipo', 'CENTRAL']])->first();
        $existe = false;
        $barrios = Barrio::all()->sortBy('nombre')->pluck('nombre', 'id');
        if ($persona != null || session('ROL') == 'ADMINISTRADOR') {
            if (session('ROL') == 'ADMINISTRADOR') {
                $bodegas = Bodega::all();
                if (count($bodegas) > 0) {
                    foreach ($bodegas as $i) {
                        $disponible = Lavadora::where([['estado_lavadora', 'DISPONIBLE'], ['bodega_id', $i->id]])->get();
                        if (count($disponible) > 0) {
                            $existe = true;
                        }
                    }
                }
                if ($existe) {
                    $mensaje = "SI";
                } else {
                    $mensaje = "Atencion!. No hay lavadoras disponibles en el momento";
                }
            } else {

                $bodegas = Bodega::where('sucursal_id', $persona->sucursal_id)->get();
                if (count($bodegas) > 0) {
                    foreach ($bodegas as $i) {
                        $disponible = Lavadora::where([['estado_lavadora', 'DISPONIBLE'], ['bodega_id', $i->id]])->get();
                        if (count($disponible) > 0) {
                            $existe = true;
                        }
                    }
                }
                if ($existe) {
                    $mensaje = "SI";
                } else {
                    $mensaje = "Atencion!. No hay lavadoras disponibles en el momento";
                }
            }

            return view('servicio.servicios.create')
                            ->with('location', 'servicio')
                            ->with('barrios', $barrios)
                            ->with('mensaje', $mensaje);
        } else {
            flash("Usted no posee permisos para acceder a esta funcionalidad.")->warning();
            return redirect()->route('servicio.index');
        }
    }

    public function store(ServicioRequest $request) {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        $result_cliente = true;
        $existe = Cliente::where('telefono', $request->telefono_cliente)->first();
        if ($existe == null) {
            $cliente = new Cliente();
            $cliente->telefono = $request->telefono_cliente;
            $cliente->barrio_id = $request->barrio_id_cliente;
            $cliente->nombre = $request->nombre;
            $cliente->direccion = $request->direccion;
            $cliente->latitud = $request->latitud_servicio;
            $cliente->longitud = $request->longitud_servicio;
            foreach ($cliente->attributesToArray() as $key => $value) {
                if (isset($cliente->$key)) {
                    $cliente->$key = strtoupper($value);
                }
            }
            $result_cliente = $cliente->save();
        }
        if ($result_cliente) {
            $servicio = new Servicio();
            $servicio->sucursal_id = $persona->sucursal_id;
            $servicio->num_lavadoras = $request->num_lavadoras;
            $servicio->estado = 'PENDIENTE';
            $servicio->dias = $request->dias;
            $servicio->barrio_id = $request->barrio_id_servicio;
            $servicio->direccion = $request->direccion_servicio;
            $servicio->latitud = $request->latitud_servicio;
            $servicio->longitud = $request->longitud_servicio;
            $servicio->total = $servicio->num_lavadoras * $servicio->dias * 7000;
            if (isset($request->id_cliente)) {
                $servicio->cliente_id = $request->id_cliente;
            } else if ($existe) {
                $servicio->cliente_id = $existe->id;
            } else {
                $servicio->cliente_id = $cliente->id;
            }
            foreach ($servicio->attributesToArray() as $key => $value) {
                if (isset($servicio->$key)) {
                    $servicio->$key = strtoupper($value);
                }
            }
            $result_servicio = $servicio->save();

            if ($result_servicio) {
                $u = Auth::user();
                $aud = new Auditoriaservicio();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "INSERTAR";
                $str = "CREACIÓN DE SERVICIO. DATOS: ";
                foreach ($servicio->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str;
                $aud->save();
                flash("El servicio para la dirección  <strong>" . $servicio->direccion . "</strong> fue almacenado(a) de forma exitosa!")->success();
                return redirect()->route('servicio.index');
            } else {
                flash("El servico para la dirección <strong>" . $servicio->direccion . "</strong> no pudo ser almacenado. Error: " . $result_servicio)->error();
                return back()->withInput($request->all());
            }
        } else {
            flash("El servico para la dirección <strong>" . $request->direccion_servicio . "</strong> no pudo ser almacenado. Error: " . $result_cliente)->error();
            return back()->withInput($request->all());
        }
    }

    public function show(Servicio $servicio) {
        return view('servicio.servicios.show')
                        ->with('location', 'servicio')
                        ->with('servicio', $servicio);
    }

    public function showSeriviciosEnMapa($id) {
        $servicio = Servicio::find($id);
        return view('servicio.servicios.showMapa')
                        ->with('location', 'servicio')
                        ->with('servicio', $servicio);
    }

    public function showServicios() {

        return view('servicio.geolocalizacion.list')
                        ->with('location', 'servicio');
    }

    /*
     * agregar un dia mas al servicio que esta en estado 'RECOGER' se finaliza y se crea
     * un new App\Servicio con los datos del servicio que se finaliza 
     * 
     * @param type $servicios
     * @return type boolean 
     */

    public function edit($id) {
        $servicio = Servicio::find($id);
        $m = new Servicio($servicio->attributesToArray());
        $servicio->estado = "FINALIZADO";
        $servicio->firma_entrega_cliente = $servicio->firma_recibido_cliente;
        $hoy = getdate();
        $servicio->fecharecogido = $hoy['year'] . '-' . $hoy['mon'] . '-' . $hoy['mday'] . ' ' . $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];
        $result1 = $servicio->save();
        if ($result1) {
            $nuevo = new Servicio();
            $nuevo->fechaentrega = $servicio->fecharecogido;
            $fecha = strtotime($servicio->fechafin);
            $fin = strtotime("+1 day", $fecha);
            $nuevo->fechafin = date("Y-m-d H:i:s", $fin);
            $nuevo->num_lavadoras = $servicio->num_lavadoras;
            $nuevo->dias = $servicio->dias;
            $nuevo->estado = "ENTREGADO";
            $nuevo->barrio_id = $servicio->barrio_id;
            $nuevo->observacion = $servicio->observacion;
            $nuevo->direccion = $servicio->direccion;
            $nuevo->firma_recibido_cliente = $servicio->firma_recibido_cliente;
            $nuevo->latitud = $servicio->latitud;
            $nuevo->longitud = $servicio->longitud;
            $nuevo->total = $servicio->total;
            $nuevo->cliente_id = $servicio->cliente_id;
            $nuevo->persona_id = $servicio->persona_id;
            $nuevo->sucursal_id = $servicio->sucursal_id;
            $result = $nuevo->save();
            if ($result) {
                $ser_lav = $servicio->lavadoras;
                foreach ($ser_lav as $i) {
                    $lav[] = $i->id;
                }
                $nuevo->lavadoras()->sync($lav);
                $u = Auth::user();
                $aud = new Auditoriaservicio();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "AGREAR OTOR DIA";
                $str = "OTRO DIA AL SERVICIO. DATOS NUEVOS: ";
                $str2 = " DATOS ANTIGUOS: ";
                foreach ($m->attributesToArray() as $key => $value) {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
                foreach ($servicio->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str . " - " . $str2;
                $aud->save();
                $audi = new Auditoriaservicio();
                $audi->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $audi->operacion = "INSERTAR";
                $str3 = "CREACIÓN DE SERVICIO POR UN DIA MAS. DATOS: ";
                foreach ($nuevo->attributesToArray() as $key => $value) {
                    $str3 = $str3 . ", " . $key . ": " . $value;
                }
                $audi->detalles = $str3;
                $audi->save();
                flash("Se agrego un dia mas al servicio <strong>" . $servicio->direccion . "</strong> correctamente!")->success();
                return redirect()->route('servicio.getServiciosPorRecoger');
            } else {
                $servicio->estado = "RECOGER";
                $servicio->fecharecogida = null;
                $servicio->firma_entrega_cliente = null;
                $servicio->save();
                flash("El dia al servicio <strong>" . $servicio->direccion . "</strong> no fue agregado correctamente!.Error:" . $result)->error();
                return redirect()->route('servicio.getServiciosPorRecoger');
            }
        } else {
            flash("El dia al servicio <strong>" . $servicio->direccion . "</strong> no fue agregado correctamente!.Error:" . $result)->error();
            return redirect()->route('servicio.getServiciosPorRecoger');
        }
    }

    public function update(Request $request, Servicio $servicio) {
        //
    }

    public function destroy(Servicio $servicio) {
        $result = false;
        if ($servicio->estado == 'PENDIENTE' || $servicio->estado == 'ASIGNADO') {
            $servicio->estado = 'CANCELADO';
            $result = $servicio->save();
        }
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriaservicio();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "CANCELACION";
            $str = "CANCELACION DE SERVICIO. DATOS: ";
            foreach ($servicio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            return response()->json([
                        'status' => 'ok',
                        'message' => "EL servicio para la direccion " . $servicio->direccion . " fue cancelado(a) de forma exitosa!"
            ]);
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => "El servicio para la direccion " . $servicio->direccion . " no pudo ser cancelado(a). Error:"
            ]);
        }
    }

    public function getClientes($id) {
        $cli = Cliente::where('telefono', $id)->first();
        if ($cli !== null) {
            $obj["id"] = $cli->id;
            $obj["nom"] = $cli->nombre;
            $obj["lat"] = $cli->latitud;
            $obj["lon"] = $cli->longitud;
            $obj["tel"] = $cli->telefono;
            $obj["dir"] = $cli->direccion;
            $obj["bar"] = $cli->barrio_id;
            return json_encode($obj);
        } else {
            return "null";
        }
    }

    function orderMultiDimensionalArray($toOrderArray, $field, $inverse = false) {
        $position = array();
        $newRow = array();
        foreach ($toOrderArray as $key => $row) {
            $position[$key] = $row[$field];
            $newRow[$key] = $row;
        }
        if ($inverse) {
            arsort($position);
        } else {
            asort($position);
        }
        $returnArray = array();
        foreach ($position as $key => $pos) {
            $returnArray[] = $newRow[$key];
        }
        return $returnArray;
    }

    public function getServiciosPendientes() {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        if ($persona != null) {
            if (session('ROL') == 'CENTRAL') {
                $servicios = Servicio::where([['estado', 'PENDIENTE']])->get()->sortBy('estado');
            } else {
                $servicios = Servicio::where([['sucursal_id', $persona->sucursal_id], ['estado', 'PENDIENTE']])->get()->sortBy('estado');
            }
        } else {
            $servicios = Servicio::where([['estado', 'PENDIENTE']])->get()->sortBy('estado');
        }
        return view('servicio.solicitudes_de_servicio.pendientes')
                        ->with('location', 'servicio')
                        ->with('servicios', $servicios);
    }

    public function aceptarServicio($id) {
        $u = Auth::user();
        $servicio = Servicio::find($id);
        $persona = Persona::where([['identificacion', $u->identificacion], ['tipo', 'MENSAJERO']])->first();
        if ($persona != null) {
            $servicio->estado = 'ASIGNADO';
            $servicio->persona_id = $persona->id;
            $result = $servicio->save();
            $u = Auth::user();
            $aud = new Auditoriaservicio();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ASIGNACION";
            $str = "ASIGNACION DE SERVICIO. DATOS: ";
            foreach ($servicio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            if ($result) {
                flash("El servicio para la dirección  <strong>" . $servicio->direccion . "</strong> le fue asignado correctamente!")->success();
                return redirect()->route('servicio.getServiciosPendientes');
            } else {
                flash("El servico para la dirección <strong>" . $servicio->direccion . "</strong> no pudo ser asignado. Error: " . $result)->error();
                return back();
            }
        } else {
            flash("El servico para la dirección <strong>" . $servicio->direccion . "</strong> no pudo ser asignado. Error: no tiene los privilegios suficientes para realizar esta acción ")->error();
            return back();
        }
    }

    public function aceptarServicioJSON($id) {
        $u = Auth::user();
        $servicio = Servicio::find($id);
        $persona = Persona::where([['identificacion', $u->identificacion], ['tipo', 'MENSAJERO']])->first();
        if ($persona != null) {
            $servicio->estado = 'ASIGNADO';
            $servicio->persona_id = $persona->id;
            $result = $servicio->save();
            $u = Auth::user();
            $aud = new Auditoriaservicio();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "ASIGNACION";
            $str = "ASIGNACION DE SERVICIO. DATOS: ";
            foreach ($servicio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            if ($result) {
                return response()->json([
                            'status' => 'ok',
                            'message' => "El servicio para la dirección " . $servicio->direccion . " le fue asignado correctamente!",
                ]);
            } else {
                return response()->json([
                            'status' => 'error',
                            'message' => "El servicio para la dirección " . $servicio->direccion . "no pudo ser asignado. Error: " . $result,
                ]);
            }
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => "El servico para la dirección " . $servicio->direccion . " no pudo ser asignado. Error: no tiene los privilegios suficientes para realizar esta acción ",
            ]);
        }
    }

    public function liberarServicio($id) {
        $u = Auth::user();
        $servicio = Servicio::find($id);
        $persona = Persona::where([
                    ['identificacion', $u->identificacion],
                    ['tipo', 'MENSAJERO']
                ])->first();
        if ($persona != null) {
            $servicio->estado = 'PENDIENTE';
            $servicio->persona_id = null;
            $result = $servicio->save();
            $aud = new Auditoriaservicio();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "LIBERACION";
            $str = "LIBERACION DEL SERVICIO. DATOS: ";
            foreach ($servicio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            if ($result) {
                flash("El servicio para la dirección  <strong>" . $servicio->direccion . "</strong> fue liberado correctamente!")->success();
                return redirect()->route('servicio.getServiciosPorEntregar');
            } else {
                flash("El servico para la dirección <strong>" . $servicio->direccion . "</strong> no pudo ser liberado. Error: " . $result)->error();
                return back();
            }
        } else {
            flash("El servico para la dirección <strong>" . $servicio->direccion . "</strong> no pudo ser liberado. Error: no tiene los privilegios suficientes para realizar esta acción ")->error();
            return back();
        }
    }

    public function getServiciosPorEntregar() {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        if ($persona != null) {
            if (session('ROL') == 'CENTRAL') {
                $servicios = Servicio::where([
                            ['estado', 'ASIGNADO']
                        ])->get();
            } else {
                $servicios = Servicio::where([
                            ['persona_id', $persona->id],
                            ['estado', 'ASIGNADO']
                        ])->get();
            }
        } else {
            $servicios = Servicio::where([
                        ['estado', 'ASIGNADO']
                    ])->get();
        }

        $servicios = $servicios->sortByDesc('created_at');

        return view('servicio.servicios_por_entregar.aceptados')
                        ->with('location', 'servicio')
                        ->with('servicios', $servicios);
    }

    public function entregarServicio($id) {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
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
            return view('servicio.servicios_por_entregar.entregar')
                            ->with('location', 'servicio')
                            ->with('lavadoras', $lavadoras)
                            ->with('servicio_id', $id);
        } else {
            flash("Error : esta opción solo es valida para los <strong>" . 'mensajeros' . "</strong> ")->error();
            return back();
        }
    }

    public function guardarEntrega(Request $request) {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        $servicio = Servicio::find($request->servicio_id);
        $m = new Servicio($servicio->attributesToArray());
        if ($persona != null) {
            if ($servicio->num_lavadoras == count($request->lavadoras)) {
                $servicio->estado = 'ENTREGADO';
                $servicio->persona_id = $persona->id;
                $hoy = getdate();
                $servicio->fechaentrega = $hoy['year'] . '-' . $hoy['mon'] . '-' . $hoy['mday'] . ' ' . $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];
                $string = "+" . $servicio->dias . " day";
                $fecha = strtotime($servicio->fechaentrega);
                $fin = strtotime($string, $fecha);
                $servicio->fechafin = date("Y-m-d H:i:s", $fin);
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

                $nombre_file = 'firma_entrega_' . $hoy['year'] . $hoy['mon'] . $hoy['mday'] . $hoy['hours'] . $hoy['minutes'] . $hoy['seconds'] . '.png';
                ;
                // Proporciona una locación a la nueva imagen (con el nombre y formato especifico)
                $filepath = public_path() . '/docs/firma_entregas/' . $nombre_file; // or image.jpg
                // Finalmente guarda la imágen en el directorio especificado y con la informacion dada
                file_put_contents($filepath, $data);
                $servicio->firma_recibido_cliente = $nombre_file;
                $result = $servicio->save();
                if ($result) {
                    $servicio->lavadoras()->sync($request->lavadoras);
                    foreach ($request->lavadoras as $item) {
                        $lavadora = Lavadora::find($item);
                        $lavadora->estado_lavadora = 'SERVICIO';
                        $lavadora->estado_bodega = 'NO';
                        $lavadora->save();
                    }
                    $aud = new Auditoriaservicio();
                    $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                    $aud->operacion = "ENTREGA";
                    $str = "ENTREGA DEL SERVICIO. DATOS NUEVOS: ";
                    $str2 = " DATOS ANTIGUOS: ";
                    foreach ($m->attributesToArray() as $key => $value) {
                        $str2 = $str2 . ", " . $key . ": " . $value;
                    }
                    foreach ($servicio->attributesToArray() as $key => $value) {
                        $str = $str . ", " . $key . ": " . $value;
                    }
                    $aud->detalles = $str . " - " . $str2;
                    $aud->save();
                    return response()->json([
                                'status' => 'ok',
                                'message' => "Success : el servicio para la dirección " . $servicio->direccion . " fue entregado correctamente",
                    ]);
                } else {
                    return response()->json([
                                'status' => 'error',
                                'message' => "Error : el servicio para la dirección " . $servicio->direccion . " no pudo ser entregado correctamente",
                    ]);
                }
                $aud = new Auditoriaservicio();
                $u = Auth::user();
                $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
                $aud->operacion = "ENTREGA";
                $str = "ENTREGA DEL SERVICIO. DATOS NUEVOS: ";
                $str2 = " DATOS ANTIGUOS: ";
                foreach ($m->attributesToArray() as $key => $value) {
                    $str2 = $str2 . ", " . $key . ": " . $value;
                }
                foreach ($servicio->attributesToArray() as $key => $value) {
                    $str = $str . ", " . $key . ": " . $value;
                }
                $aud->detalles = $str . " - " . $str2;
                $aud->save();
                return response()->json([
                            'status' => 'ok',
                            'message' => "Success : el servicio para la dirección " . $servicio->direccion . " fue entregado correctamente",
                ]);
            } else {

                return response()->json([
                            'status' => 'error',
                            'message' => "Error : tenga en cuenta que debe selecionar el mismo numero de lavadoras solicitadas por el cliente"
                ]);
            }
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => "Error : no tiene los privilegios suficientes para realizar esta acción"
            ]);
        }
    }

    public function getServiciosPorRecoger() {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        if ($persona != null && session('ROL') != 'ADMINISTRADOR') {
            if (session('ROL') == 'CENTRAL') {
                $servicios = Servicio::where([['estado', 'ENTREGADO'], ['sucursal_id', $persona->sucursal_id]])->orWhere([['estado', 'RECOGER'], ['sucursal_id', $persona->sucursal_id]])->get()->sortBy('estado');
            } else {
                $servicios = Servicio::where([['persona_id', $persona->id], ['estado', 'ENTREGADO']])->orWhere([['persona_id', $persona->id], ['estado', 'RECOGER']])->get()->sortBy('estado');
                $persmisos = Permiso::where([['persona_id', $persona->id], ['tipo', 'SERVICIO']])->get();
                foreach ($persmisos as $item) {
                    $service = $item->servicio;
                    if ($service->estado == 'RECOGER') {
                        $servicios[] = $service;
                    }
                }
            }
        } else {
            $servicios = Servicio::where('estado', 'ENTREGADO')->orWhere('estado', 'RECOGER')->get()->sortBy('estado');
        }
        $servicios = $this->cambioEstado($servicios);
        $per = Persona::all()->sortBy('primer_nombre');
        $personas = collect([]);
        if (count($per) > 0) {
            foreach ($per as $i) {
                if ($i->tipo == "MENSAJERO" && $i->estado == "ACTIVO") {
                    $personas[$i->id] = $i->primer_nombre . ' ' . $i->segundo_nombre . ' ' . $i->primer_apellido . ' ' . $i->segundo_apellido . ' -CARGO:' . $i->tipo . ' -SUCURSAL:' . $i->sucursal->nombre;
                }
            }
        }
        $servicios = $servicios->sortBy('fechafin');
        return view('servicio.servicios_por_recoger.entregados')
                        ->with('location', 'servicio')
                        ->with('personas', $personas)
                        ->with('servicios', $servicios);
    }

    public function recogerServicio($id) {
        $servicio = Servicio::find($id);
        if (session('ROL') == 'ADMINISTRADOR' || session('ROL') == 'MENSAJERO') {
            return view('servicio.servicios_por_recoger.recoger')
                            ->with('location', 'servicio')
                            ->with('servicio', $servicio);
        } else {
            flash("Error : esta opción solo es valida para los <strong>" . 'mensajeros' . "</strong> ")->error();
            return back();
        }
    }

    public function guardarRecogida(Request $request) {
        $servicio = Servicio::find($request->servicio_id);
        $m = new Servicio($servicio->attributesToArray());
        $servicio->estado = 'FINALIZADO';
        $hoy = getdate();
        $servicio->fecharecogido = $hoy['year'] . '-' . $hoy['mon'] . '-' . $hoy['mday'] . ' ' . $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];
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
        $nombre_file = 'firma_recogida_' . $hoy['year'] . $hoy['mon'] . $hoy['mday'] . $hoy['hours'] . $hoy['minutes'] . $hoy['seconds'] . '.png';
        // Proporciona una locación a la nueva imagen (con el nombre y formato especifico)
        $filepath = public_path() . '/docs/firma_recogidas/' . $nombre_file; // or image.jpg
        // Finalmente guarda la imágen en el directorio especificado y con la informacion dada
        file_put_contents($filepath, $data);
        $servicio->firma_entrega_cliente = $nombre_file;
        $result = $servicio->save();
        if ($result) {
            $lavadoras = $servicio->lavadoras;
            foreach ($lavadoras as $item) {
                $item->estado_lavadora = 'DISPONIBLE';
                $item->save();
            }
            $aud = new Auditoriaservicio();
            $u = Auth::user();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "RECOGIDA";
            $str = "RECOGIDA DEL SERVICIO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($servicio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            return response()->json([
                        'status' => 'ok',
                        'message' => "Success : el servicio para la dirección " . $servicio->direccion . " fue recogido correctamente",
            ]);
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => "Error : el servicio para la dirección " . $servicio->direccion . " no pudo ser recogido correctamente",
            ]);
        }
    }

    /**
     * recorre uno a uno los servicios y aquellos que la fecha fin sea menor que la fecha actual
     * seran colocados en estado por recorrer
     *
     * @param type $servicios
     * @return type response/Servicios
     */
    public function cambioEstado($servicios) {
        $hoy = getdate();
        $fecha = $hoy['year'] . '-' . $hoy['mon'] . '-' . $hoy['mday'] . ' ' . $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];
        $fecha = strtotime($fecha);
        $servicios_por_recoger = collect([]);
        if (count($servicios) > 0) {
            foreach ($servicios as $item) {
                $fecha_servicio = strtotime($item->fechafin);
                if ($fecha >= $fecha_servicio) {
                    if ($item->estado == 'ENTREGADO') {
                        $item->estado = "RECOGER";
                        $item->save();
                    }

                    $horas = abs(($fecha - strtotime($item->fechafin)) / 3600);
                    $operacion = $horas / 24;
                    $dia = floor($operacion);
                    $operacion = ($operacion - $dia) * 24;
                    $horas = floor($operacion);
                    $operacion = ($operacion - $horas) * 60;
                    $minutos = floor($operacion);
                    $str = '';
                    if ($dia > 0) {
                        $str = '<strong>' . $dia . '</strong> Dia(s) </br>';
                    }

                    if ($horas > 0) {
                        $str .= '<strong>' . $horas . '</strong> Hora(s)</br>';
                    }
                    if ($minutos > 0) {
                        $str .= '<strong>' . $minutos . '</strong> Minuto(s)</br>';
                    }

                    $item->tiempo = $str;

                    $servicios_por_recoger[] = $item;
                } elseif ($item->estado == "RECOGER") {
//                    $horas = abs(($fecha - strtotime($item->fechafin)) / 3600);
//                    $minutos = '0.' . explode(".", $horas)[1];
//                    $horas = floor($horas);
//                    $minutos = floor($minutos * 60);
                    $item->tiempo = "Tiene permiso para recoger antes de tiempo";
                    $servicios_por_recoger[] = $item;
                }
            }
        }
        return $servicios_por_recoger;
    }

    public function getServiciosPorRecogerJSON() {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        if ($persona != null && session('ROL') != 'ADMINISTRADOR') {
            if (session('ROL') == 'CENTRAL') {
                $servicios = Servicio::where([
                            ['estado', 'ENTREGADO'],
                            ['sucursal_id', $persona->sucursal_id]
                        ])->orWhere('estado', 'RECOGER')->get();
            } else {
                $servicios = Servicio::where([
                            ['persona_id', $persona->id],
                            ['estado', 'ENTREGADO']
                        ])->orWhere('estado', 'RECOGER')->get();
                $persmisos = Permiso::where([
                            ['persona_id', $persona->id],
                            ['tipo', 'SERVICIO']
                        ])->get();
                foreach ($persmisos as $item) {
                    $service = $item->servicio;
                    if ($service->estado == 'RECOGER') {
                        $servicios[] = $service;
                    }
                }
            }
        } else {
            $servicios = Servicio::where([
                        ['estado', 'ENTREGADO']
                    ])->orWhere('estado', 'RECOGER')->get()->sortBy('estado');
        }
        $servicios = $this->cambioEstado($servicios);
        foreach ($servicios as $item) {
            $item->barrio = $item->barrio->nombre;
            $item->cliente_nombre = $item->cliente->nombre;
            $item->cliente_telefono = $item->cliente->telefono;
        }
        return json_encode($servicios);
    }

    public function getServiciosPorEntregarJSON() {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        if ($persona != null && session('ROL') != 'ADMINISTRADOR') {
            if (session('ROL') == 'CENTRAL') {
                $servicios = Servicio::where([
                            ['estado', 'ASIGNADO'],
                            ['sucursal_id', $persona->sucursal_id]
                        ])->get()->sortBy('estado');
            } else {
                $servicios = Servicio::where([
                            ['persona_id', $persona->id],
                            ['estado', 'ASIGNADO']
                        ])->get()->sortBy('estado');
            }
        } else {
            $servicios = Servicio::where([
                        ['estado', 'ASIGNADO']
                    ])->orWhere('estado', 'PENDIENTE')->get();
        }
        foreach ($servicios as $item) {
            $item->barrio = $item->barrio->nombre;
            $item->cliente_nombre = $item->cliente->nombre;
            $item->cliente_telefono = $item->cliente->telefono;
        }
        return json_encode($servicios);
    }

    public function getServiciosEntregadosJSON() {

        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        if ($persona != null && session('ROL') != 'ADMINISTRADOR') {
            if (session('ROL') == 'CENTRAL') {
                $servicios = Servicio::where([
                            ['estado', 'ENTREGADO'],
                            ['sucursal_id', $persona->sucursal_id]
                        ])->get()->sortBy('estado');
            } else {
                $servicios = Servicio::where([
                            ['persona_id', $persona->id],
                            ['estado', 'ENTREGADO']
                        ])->get()->sortBy('estado');
            }
        } else {
            $servicios = Servicio::where([
                        ['estado', 'ENTREGADO']
                    ])->get();
        }

        foreach ($servicios as $item) {
            $item->barrio = $item->barrio->nombre;
            $item->cliente_nombre = $item->cliente->nombre;
            $item->cliente_telefono = $item->cliente->telefono;
        }
        return json_encode($servicios);
    }

    public function guardarObservacion(Request $request) {
        $u = Auth::user();
        $servicio = Servicio::find($request->servicio_id);
        $m = new Servicio($servicio->attributesToArray());
        $servicio->observacion = $servicio->observacion . ' <strong>Usuario:</strong>' . $u->nombres . ' ' . $u->apellidos . ' <strong>-Observacion:</strong>: ' . $request->observacion . '</br>';
        $result = $servicio->save();
        if ($result) {
            $aud = new Auditoriaservicio();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "OBSERVACION";
            $str = "OBSERVACION DEL SERVICIO. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($servicio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            flash("La observacion para el servicio para la dirección <strong>" . $servicio->direccion . "</strong> fue agregada exitosamente.")->success();
            return redirect()->route('servicio.index');
        } else {
            flash("La observacion para el servicio para la dirección <strong>" . $servicio->direccion . "</strong> no fue agregada exitosamente. Error:" . $result)->error();
            return redirect()->route('servicio.index');
        }
    }

    /**
     * Da el permiso para recoger el servicio antes del tiempo establecido anteriormente
     *
     * @param \App\Servico $servico
     * @return \Illuminate\Http\Response
     */
    public function cambiorecoger($id) {
        $servicio = Servicio::find($id);
        $m = new Servicio($servicio->attributesToArray());
        $nombre = $servicio->direccion;
        $servicio->estado = 'RECOGER';
        $result = $servicio->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriaservicio();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "PERMISO RECOGER";
            $str = "PERMISO PARA RECOGER SERVICIO ANTES DE LA FECHA FIN. DATOS NUEVOS: ";
            $str2 = " DATOS ANTIGUOS: ";
            foreach ($m->attributesToArray() as $key => $value) {
                $str2 = $str2 . ", " . $key . ": " . $value;
            }
            foreach ($servicio->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str . " - " . $str2;
            $aud->save();
            return response()->json([
                        'status' => 'ok',
                        'message' => "El permiso para el servicio " . $nombre . " fue realizado de forma exitosa!"
            ]);
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => "El permiso para el servicio" . $nombre . " no pudo ser realizado. Error:"
            ]);
        }
    }

}
