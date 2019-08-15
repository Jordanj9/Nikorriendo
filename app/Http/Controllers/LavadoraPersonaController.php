<?php

namespace App\Http\Controllers;

use App\Lavadora_persona;
use App\Persona;
use App\Lavadora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    $personas[$i->id] = $i->primer_nombre . ' ' . $i->segundo_nombre . ' ' . $i->primer_apellido . ' ' . $i->segundo_apellido . ' -CARGO:' . $i->tipo . ' -SUCURSAL:' . $i->sucursal->nombre;
                }
            }
        }
        $lav = Lavadora::all();
        $lavadoras = null;
        $lavadoras = collect($lavadoras);
        if (count($lav) > 0) {
            foreach ($lav as $l) {
                $existe = $l->personas->count();
                if ($existe == 0) {
                    $lavadoras[$l->id] = $l->serial . ' - ' . $l->marca . ' - BODEGA:' . $l->bodega->nombre . ' - SUCURSAL:' . $l->bodega->sucursal->nombre;
                }
            }
        }
        if ($personas == null) {
            flash("<strong>Atención!</strong> debe registrar empleados para poder acceder a esta función.")->warning();
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
    public function getAsignadas($id) {
        $persona = Persona::find($id);
        $lavadoras = $persona->lavadoras;
        $array = null;
        foreach ($lavadoras as $value) {
            $obj["id"] = $value->id;
            $obj["value"] = $value->serial . ' - ' . $value->marca . ' - BODEGA:' . $value->bodega->nombre . ' - SUCURSAL:' . $value->bodega->sucursal->nombre;
            $array[] = $obj;
        }
        return json_encode($array);
    }

    /**
     * Show the view privilegios.
     *
     * @return \Illuminate\Http\Response
     */
    public function setAsignadas() {
        if (!isset($_POST["asignadas"])) {
            DB::table('lavadora_personas')->where('persona_id', '=', $_POST["id"])->delete();
            flash("<strong>Lavadoras </strong> eliminadas de forma exitosa!")->success();
            return redirect()->route('lavadora_persona.index');
        } else {
            $persona = Persona::find($_POST["id"]);
            $persona->lavadoras()->sync($_POST["asignadas"]);
            $persona->lavadoras;
            flash("<strong>Lavadoras </strong> asignadas de forma exitosa!")->success();
            return redirect()->route('lavadora_persona.index');
        }
    }

}
