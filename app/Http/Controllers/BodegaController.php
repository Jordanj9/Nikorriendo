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
        $sucursales= Sucursal::all()->pluck('nombre', 'id');
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
        foreach ($bodega->attributesToArray() as $key => $value) {
            $bodega->$key = strtoupper($value);
        }
        $result = $bodega->save();
        if ($result) {
            flash("La Bodega <strong>" . $bodega->nombre . "</strong> fue almacenado(a) de forma exitosa!")->success();
            return redirect()->route('bodega.index');
        } else {
            flash("La Bodega <strong>" . $bodega->nombre . "</strong> no pudo ser almacenado(a). Error: " . $result)->error();
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
        $sucursales= Sucursal::all()->pluck('nombre', 'id');
        return view('estructura.bodega.edit')
            ->with('location', 'estructura')
            ->with('bodega', $bodega)
            ->with('sucursales',$sucursales);
    }

    /**
     * Update the specified resource in storage.
     *sucursal
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bodega $bodega) {

        foreach ($bodega->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $bodega->$key = strtoupper($request->$key);
            }
        }

        $result = $bodega->save();

        if ($result) {
            flash("La bodega <strong>" . $bodega->nombre . "</strong> fue modificado(a) de forma exitosa!")->success();
            return redirect()->route('bodega.index');
        } else {
            flash("La bodega <strong>" . $bodega->nombre . "</strong> no pudo ser modificado(a). Error: " . $result)->error();
            return redirect()->route('bodega.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bodega  $bodega
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bodega $bodega) {

        $nombre =  $bodega->nombre;
        $result = $bodega->delete();

        if($result){
            return response()->json([
                'status' => 'ok',
                'message'=>"la bodega ". $nombre ." fue eliminado(a) de forma exitosa!"
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message'=>"la bodega " .$nombre. " no pudo ser eliminado(a). Error:"
            ]);
        }
    }

}
