<?php

namespace App\Http\Controllers;

use App\Barrio;
use Illuminate\Http\Request;

class BarrioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $barrios = Barrio::all();
        return view('estructura.barrio.list')
                        ->with('location', 'estructura')
                        ->with('barrios', $barrios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('estructura.barrio.create')
                        ->with('location', 'estructura');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $barrio = new Barrio($request->all());
        foreach ($barrio->attributesToArray() as $key => $value) {
            $barrio->$key = strtoupper($value);
        }
        $result = $barrio->save();
        if ($result) {
            flash("El Barrio <strong>" . $barrio->nombre . "</strong> fue almacenado(a) de forma exitosa!")->success();
            return redirect()->route('barrio.index');
        } else {
            flash("El Barrio <strong>" . $barrio->nombre . "</strong> no pudo ser almacenado(a). Error: " . $result)->error();
            return redirect()->route('barrio.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Barrio  $barrio
     * @return \Illuminate\Http\Response
     */
    public function show(Barrio $barrio) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Barrio  $barrio
     * @return \Illuminate\Http\Response
     */
    public function edit(Barrio $barrio) {
        return view('estructura.barrio.edit')
                        ->with('location', 'estructura')
                        ->with('barrio', $barrio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Barrio  $barrio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barrio $barrio) {
        foreach ($barrio->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $barrio->$key = strtoupper($request->$key);
            }
        }
        $result = $barrio->save();
        if ($result) {
            flash("El Barrio <strong>" . $barrio->nombre . "</strong> fue modificado(a) de forma exitosa!")->success();
            return redirect()->route('barrio.index');
        } else {
            flash("El Barrio <strong>" . $barrio->nombre . "</strong> no pudo ser modificado(a). Error: " . $result)->error();
            return redirect()->route('barrio.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Barrio  $barrio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barrio $barrio) {
        $nombre = $barrio->nombre;
        if (count($barrio->clientes) > 0 || count($barrio->servicios) > 0) {
            return response()->json([
                        'status' => 'warning',
                        'message' => "El barrio " . $nombre . " no pudo ser eliminado(a) porque tiene relaciones asociadas. Error:"
            ]);
        }
        $result = $barrio->delete();
        if ($result) {
            return response()->json([
                        'status' => 'ok',
                        'message' => "el barrio " . $nombre . " fue eliminado(a) de forma exitosa!"
            ]);
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => "El barrio " . $nombre . " no pudo ser eliminado(a). Error:"
            ]);
        }
    }

}
