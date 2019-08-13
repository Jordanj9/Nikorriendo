<?php

namespace App\Http\Controllers;

use App\Lavadora_persona;
use App\Persona;
use App\Lavadora;
use Illuminate\Http\Request;

class LavadoraPersonaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $per = Persona::all()->sortBy('primer_nombre');
        $personas = null;
        if (count($per) > 0) {
            foreach ($per as $i) {
                if ($i->tipo == "MENSAJERO" && $i->estado == "ACTIVO") {
                    $personas[$i->id] = $i->primer_nombre . ' ' . $i->segundo_nombre . ' ' . $i->primer_apellido . ' ' . $i->segundo_apellido . ' -CARGO:' . $i->tipo;
                }
            }
        }
        $lav = Lavadora::all();
        $lavadoras = null;
        if (count($lav) > 0) {
            foreach ($lav as $l) {
                $existe = Lavadora_persona::where('lavadora_id', $l->id)->first();
                if ($existe == null) {
                    $lavadoras[$l->id] = $l->serial . ' - ' . $l->marca . ' - BODEGA:' . $l->bodega->nombre . ' - SUCURSAL:' . $l->bodega->sucursal->nombre;
                }
            }
        }
        if ($personas == null || $lavadoras == null) {
            flash("<strong>Atención!</strong> debe registrar empleados y lavadoras perviamente para poder acceder a esta función.")->warning();
            return redirect()->route('admin.estructura');
        } else {
            return view('estructura.asignar_lavadora.list')
                            ->with('location', 'estructura')
                            ->with('lavadoras', $lavadoras)
                            ->with('personas', $personas);
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lavadora_persona  $lavadora_persona
     * @return \Illuminate\Http\Response
     */
    public function show(Lavadora_persona $lavadora_persona) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lavadora_persona  $lavadora_persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Lavadora_persona $lavadora_persona) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lavadora_persona  $lavadora_persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lavadora_persona $lavadora_persona) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lavadora_persona  $lavadora_persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lavadora_persona $lavadora_persona) {
        //
    }

    /**
     * Show the view privilegios.
     *
     * @return \Illuminate\Http\Response
     */
    public function privilegios() {
        $grupos = Grupousuario::all()->sortBy('nombre')->pluck('nombre', 'id');
        $paginas2 = Pagina::all()->sortBy('nombre');
        $paginas = null;
        foreach ($paginas2 as $p) {
            $paginas[$p->id] = $p->nombre . " ==> " . $p->descripcion;
        }
        return view('usuarios.privilegios.list')
                        ->with('location', 'usuarios')
                        ->with('grupos', $grupos)
                        ->with('paginas', $paginas);
    }

    /**
     * Show the view privilegios.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPrivilegios($id) {
        $grupo = Grupousuario::find($id);
        $paginas = $grupo->paginas;
        $array = null;
        foreach ($paginas as $value) {
            $obj["id"] = $value->id;
            $obj["value"] = $value->nombre . " ==> " . $value->descripcion;
            $array[] = $obj;
        }
        return json_encode($array);
    }

    /**
     * Show the view privilegios.
     *
     * @return \Illuminate\Http\Response
     */
    public function setPrivilegios() {
        if (!isset($_POST["privilegios"])) {
            DB::table('grupousuario_pagina')->where('grupousuario_id', '=', $_POST["id"])->delete();
            flash("<strong>Privilegios </strong> eliminados de forma exitosa!")->success();
            return redirect()->route('grupousuario.privilegios');
        } else {
            $grupo = Grupousuario::find($_POST["id"]);
            $grupo->paginas()->sync($_POST["privilegios"]);
            $grupo->paginas;
            flash("<strong>Privilegios </strong> asignados de forma exitosa!")->success();
            return redirect()->route('grupousuario.privilegios');
        }
    }

}
