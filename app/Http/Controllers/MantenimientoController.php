<?php

namespace App\Http\Controllers;

use App\Estado_mantenimiento;
use App\Lavadora;
use App\Mantenimiento;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $persona = Persona::where('identificacion',Auth::user()->identificacion)->first();

        if($persona == null){
            flash("usted no puede <strong>" . 'realizar' . "</strong> tal operación en nuestro sistema, solo es permitido para los tecnicos")->warning();
            return redirect()->route('admin.mantenimiento');
        }

        $aux = Estado_mantenimiento::where([
                      ['estado','PENDIENTE']
                    ])->get();

        //estos son los mantenimientos que se encuentran por realizar
        $mantenimientos = null;
        $mantenimientos = collect($mantenimientos);

        if(count($aux)>0){
            foreach ($aux as $item) {
                if($item->lavadora->bodega->sucursal_id == $persona->sucursal_id){
                    $mantenimientos[$item->id] = $item->lavadora->serial.' - '.$item->lavadora->marca.' FECHA '.$item->created_at;
                }
            }
        }

        if(count($mantenimientos) > 0){
            return view('mantenimiento.mantenimiento.facturar')
                ->with('location','mantenimiento')
                ->with('mantenimientos',$mantenimientos)
                ->with('persona',$persona);
        }else{
            flash("no <strong>" . 'hay' . "</strong> mantenimientos por realizar en esta sucursal")->warning();
            return redirect()->route('admin.mantenimiento');
        }


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
     * @param  \App\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Mantenimiento $mantenimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Mantenimiento $mantenimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mantenimiento $mantenimiento)
    {
        //
    }
}
