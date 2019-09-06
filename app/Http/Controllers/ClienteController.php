<?php

namespace App\Http\Controllers;

use App\Barrio;
use App\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('estructura.cliente.list')
            ->with('location', 'estructura')
            ->with('clientes', $clientes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        $barrios = Barrio::all()->pluck('nombre','id');
        return view('estructura.cliente.edit')
            ->with('location', 'estructura')
            ->with('barrios',$barrios)
            ->with('cliente', $cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        foreach ($cliente->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                $cliente->$key = strtoupper($request->$key);
            }
        }

        $result = $cliente->save();

        if ($result) {
            flash("El cliente <strong>" . $cliente->nombre . "</strong> fue modificado(a) de forma exitosa!")->success();
            return redirect()->route('cliente.index');
        } else {
            flash("El cliente <strong>" . $cliente->nombre . "</strong> no pudo ser modificado(a). Error: " . $result)->error();
            return redirect()->route('cliente.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
