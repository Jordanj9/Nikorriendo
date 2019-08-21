<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Lavadora;
use App\Persona;
use App\Cliente;
use App\Auditoriaservicio;
use App\Bodega;
use App\Barrio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        if ($persona != null) {
            $servicios = Servicio::where('sucursal_id', $persona->sucursal_id)->get()->sortBy('estado');
        } else {
            $servicios = Servicio::all()->sortBy('estado');
        }
        return view('servicio.servicios.list')
                        ->with('location', 'servicio')
                        ->with('servicios', $servicios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $barrios = Barrio::all()->pluck('nombre', 'id');
        $u = Auth::user();
        $persona = Persona::where([['identificacion', $u->identificacion], ['tipo', 'CENTRAL']])->first();
        $existe = false;
        if ($persona != null) {
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
            return view('servicio.servicios.create')
                            ->with('location', 'servicio')
                            ->with('barrios', $barrios)
                            ->with('mensaje', $mensaje);
        } else {
            flash("Usted no posee permisos para acceder a esta funcionalidad.")->warning();
            return redirect()->route('servicio.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
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

    /**
     * Display the specified resource.
     *
     * @param \App\Servicio $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Servicio $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicio $servicio) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Servicio $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Servicio $servicio) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Servicio $servicio
     * @return \Illuminate\Http\Response
     */
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
            $servicios = Servicio::where([
                        ['sucursal_id', $persona->sucursal_id],
                        ['estado', 'PENDIENTE']
                    ])->get()->sortBy('estado');
        } else {
            $servicios = Servicio::where([
                        ['estado', 'PENDIENTE']
                    ])->get()->sortBy('estado');
        }

        return view('servicio.solicitudes_de_servicio.pendientes')
                        ->with('location', 'servicio')
                        ->with('servicios', $servicios);
    }

    public function aceptarServicio($id) {

        $u = Auth::user();
        $servicio = Servicio::find($id);
        $persona = Persona::where([
                    ['identificacion', $u->identificacion],
                    ['tipo', 'MENSAJERO']
                ])->first();

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
                return redirect()->route('servicio.index');
            } else {
                flash("El servico para la dirección <strong>" . $servicio->direccion . "</strong> no pudo ser asignado. Error: " . $result)->error();
                return back();
            }
        } else {
            flash("El servico para la dirección <strong>" . $servicio->direccion . "</strong> no pudo ser asignado. Error: no tiene los privilegios suficientes para realizar esta acción ")->error();
            return back();
        }
    }

    public function getServiciosPorEntregar() {

        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();

        if ($persona != null) {
            $servicios = Servicio::where([
                        ['persona_id', $persona->id],
                        ['estado', 'ASIGNADO']
                    ])->get()->sortBy('estado');
        } else {
            $servicios = Servicio::where([
                        ['estado', 'ASIGNADO']
                    ])->get()->sortBy('estado');
        }

        return view('servicio.servicios_por_entregar.aceptados')
                        ->with('location', 'servicio')
                        ->with('servicios', $servicios);
    }

    public function entregarServicio($id) {

        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();

        $lavadoras_aux = $persona->lavadoras;

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
    }

}
