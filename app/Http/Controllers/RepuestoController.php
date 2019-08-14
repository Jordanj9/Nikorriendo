<?php

namespace App\Http\Controllers;

use App\Bodega;
use App\Repuesto;
use Illuminate\Http\Request;

class RepuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repuestos = Repuesto::all();

        return view('mantenimiento.repuesto.list')
              ->with('location','mantenimiento')
              ->with('repuestos',$repuestos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bodegas = Bodega::all()->pluck('nombre', 'id');
        return view('mantenimiento.repuesto.create')
            ->with('location', 'mantenimiento')
            ->with('bodegas', $bodegas);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $repuesto = new repuesto($request->all());
        foreach ($repuesto->attributesToArray() as $key => $value) {

            $repuesto->$key = strtoupper($value);
        }
        $result = $repuesto->save();
        if ($result) {
            flash("El repuesto <strong>" . $repuesto->nombre . "</strong> fue almacenado(a) de forma exitosa!")->success();
            return redirect()->route('repuesto.index');
        } else {
            flash("El repuesto <strong>" . $repuesto->nombre . "</strong> no pudo ser almacenado(a). Error: " . $result)->error();
            return redirect()->route('repuesto.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function show(Repuesto $repuesto)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Repuesto $repuesto)
    {
        $bodegas = Bodega::all()->pluck('nombre', 'id');
        return view('mantenimiento.repuesto.edit')
            ->with('location', 'estructura')
            ->with('repuesto', $repuesto)
            ->with('bodegas', $bodegas);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repuesto $repuesto)
    {
        foreach ($repuesto->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $repuesto->$key = strtoupper($request->$key);
            }
        }

        $result = $repuesto->save();

        if ($result) {
            flash("El repuesto <strong>" . $repuesto->nombre . "</strong> fue modificado(a) de forma exitosa!")->success();
            return redirect()->route('repuesto.index');
        } else {
            flash("El repuesto <strong>" . $repuesto->nombre . "</strong> no pudo ser modificado(a). Error: " . $result)->error();
            return redirect()->route('repuesto.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Repuesto  $repuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repuesto $repuesto)
    {
        $result = $repuesto->delete();

        if ($result) {
            return response()->json([
                'status' => 'ok',
                'message' => "EL repuesto " . $repuesto->nombre . " fue eliminado(a) de forma exitosa!"
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "El repuesto " . $repuesto->nombre . " no pudo ser eliminado(a). Error:"
            ]);
        }
    }
}
