<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Lavadora;
use App\Persona;
use App\Cliente;
use App\Auditoriaservicio;
use App\Bodega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $servicios = Servicio::all()->sortBy('estado');
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
        $result_cliente = true;
        $existe = Cliente::where('telefono', $request->telefono_cliente)->first();
        if ($existe == null) {
            dd($existe);
            $cliente = new Cliente();
            $cliente->telefono = $request->telefono_cliente;
            $cliente->barrio = $request->barrio_cliente;
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
            $servicio->num_lavadoras = $request->num_lavadoras;
            $servicio->estado = 'PENDIENTE';
            $servicio->dias = $request->dias;
            $servicio->barrio = $request->barrio_servicio;
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
            $obj["bar"] = $cli->barrio;
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

}
