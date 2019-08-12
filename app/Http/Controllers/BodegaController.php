<?php

namespace App\Http\Controllers;

use App\Bodega;
use App\Sucursal;
use Illuminate\Http\Request;

class BodegaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $bodegas = Bodega::all();
        return view('estructura.bodega.list')
                        ->with('location', 'estructura')
                        ->with('bodegas', $bodegas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $sucursales = Sucursal::all()->pluck('nombre', 'id');
        return view('estructura.bodega.create')
                        ->with('location', 'estructura')
                        ->with('sucursales', $sucursales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $bodega = new Bodega($request->all());
        foreach ($modulo->attributesToArray() as $key => $value) {
            $modulo->$key = strtoupper($value);
        }
        $result = $modulo->save();
        if ($result) {
            flash("La Bodega <strong>" . $bodega->nombre . "</strong> fue almacenada de forma exitosa!")->success();
            return redirect()->route('bodega.index');
        } else {
            flash("La Bodega <strong>" . $bodega->nombre . "</strong> no pudo ser almacenada. Error: " . $result)->error();
            return redirect()->route('bodega.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function show(Bodega $bodega) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function edit(Bodega $bodega) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bodega $bodega) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bodega $bodega) {
        //
    }

}
