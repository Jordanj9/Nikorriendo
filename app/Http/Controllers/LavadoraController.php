<?php

namespace App\Http\Controllers;

use App\Bodega;
use App\Lavadora;
use App\Sucursal;
use Illuminate\Http\Request;

class LavadoraController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $lavadoras = Lavadora::all();
        return view('estructura.lavadora.list')
                        ->with('location', 'estructura')
                        ->with('lavadoras', $lavadoras);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $bodegas = Bodega::all()->pluck('nombre', 'id');
        return view('estructura.lavadora.create')
                        ->with('location', 'estructura')
                        ->with('bodegas', $bodegas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $existe = Lavadora::where([['serial', $request->serial], ['bodega_id', $request->bodega_id]])->first();
        if ($existe != null) {
            flash(" <strong> Atención!.</strong>  El serial <strong>" . $request->serial . "</strong> ya fue asignado a una lavadora.")->warning();
            return redirect()->route('lavadora.create');
        }
        $lavadora = new Lavadora($request->all());
        foreach ($lavadora->attributesToArray() as $key => $value) {
            $lavadora->$key = strtoupper($value);
        }
        $result = $lavadora->save();
        if ($result) {
            flash("La lavadora <strong>" . $lavadora->nombre . "</strong> fue almacenado(a) de forma exitosa!")->success();
            return redirect()->route('lavadora.index');
        } else {
            flash("La lavadora <strong>" . $lavadora->nombre . "</strong> no pudo ser almacenado(a). Error: " . $result)->error();
            return redirect()->route('lavadora.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lavadora  $lavadora
     * @return \Illuminate\Http\Response
     */
    public function show(Lavadora $lavadora) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lavadora  $lavadora
     * @return \Illuminate\Http\Response
     */
    public function edit(Lavadora $lavadora) {
        $bodegas = Bodega::all()->pluck('nombre', 'id');
        return view('estructura.lavadora.edit')
                        ->with('location', 'estructura')
                        ->with('lavadora', $lavadora)
                        ->with('bodegas', $bodegas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lavadora  $lavadora
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lavadora $lavadora) {
        foreach ($lavadora->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $lavadora->$key = strtoupper($request->$key);
            }
        }

        $result = $lavadora->save();

        if ($result) {
            flash("La lavadora <strong>" . $lavadora->serial . "</strong> fue modificado(a) de forma exitosa!")->success();
            return redirect()->route('lavadora.index');
        } else {
            flash("La lavadadora <strong>" . $lavadora->serial . "</strong> no pudo ser modificado(a). Error: " . $result)->error();
            return redirect()->route('lavadora.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lavadora  $lavadora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lavadora $lavadora) {
        $serial = $lavadora->serial;
        $lavadora->estado_lavadora = 'INACTIVA';
        $result = $lavadora->save();

        if ($result) {
            return response()->json([
                        'status' => 'ok',
                        'message' => "la lavadora " . $serial . " fue dada de baja de forma exitosa!"
            ]);
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => "la lavadora " . $serial . " no pudo ser dada de baja. Error: $result"
            ]);
        }
    }

}
