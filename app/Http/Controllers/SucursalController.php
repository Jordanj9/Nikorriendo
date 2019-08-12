<?php

namespace App\Http\Controllers;

use App\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursales = Sucursal::all();
        return view('estructura.sucursal.list')
            ->with('location', 'estructura')
            ->with('sucursales', $sucursales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('estructura.sucursal.create')
            ->with('location', 'estructura');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sucursal = new Sucursal($request->all());
        foreach ($sucursal->attributesToArray() as $key => $value) {
            $sucursal->$key = strtoupper($value);
        }
        $result = $sucursal->save();
        if ($result) {
            flash("El sucursal <strong>" . $sucursal->nombre . "</strong> fue almacenado(a) de forma exitosa!")->success();
            return redirect()->route('sucursal.index');
        } else {
            flash("El sucursal <strong>" . $sucursal->nombre . "</strong> no pudo ser almacenado(a). Error: " . $result)->error();
            return redirect()->route('sucurs.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function show(Sucursal $sucursal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function edit(Sucursal $sucursal)
    {
        return view('estructura.sucursal.edit')
            ->with('location', 'estructura')
            ->with('sucursal', $sucursal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sucursal $sucursal)
    {
        foreach ($sucursal->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $sucursal->$key = strtoupper($request->$key);
            }
        }

        $result = $sucursal->save();

        if ($result) {
            flash("La sucursal <strong>" . $sucursal->nombre . "</strong> fue modificado(a) de forma exitosa!")->success();
            return redirect()->route('sucursal.index');
        } else {
            flash("La sucursal <strong>" . $sucursal->nombre . "</strong> no pudo ser modificado(a). Error: " . $result)->error();
            return redirect()->route('sucursal.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sucursal = Sucursal::find($id);
        $nombre =  $sucursal->nombre;
        $result = $sucursal->delete();

        if($result){
             return response()->json([
                'status' => 'ok',
                 'message'=>"la sucursal ". $nombre ." fue eliminado(a) de forma exitosa!"
             ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message'=>"la sucursal " .$nombre. " no pudo ser eliminado(a). Error:"
            ]);
        }

    }
}
