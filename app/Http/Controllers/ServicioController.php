<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Lavadora;
use App\Persona;
use App\Cliente;
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
                    $disponible = Lavadora::where([['estado', 'DISPONIBLE'], ['bodega_id', $i->id]])->get();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicio $servicio) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Servicio $servicio) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio) {
        //
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
