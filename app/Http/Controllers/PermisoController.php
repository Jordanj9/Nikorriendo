<?php

namespace App\Http\Controllers;

use App\Permiso;
use App\Auditoriaservicio;
use App\Persona;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PermisoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $persona = Persona::where('identificacion', $u->identificacion)->first();
        if ($persona != null && session('ROL') == 'TECNICO') {
            $permisos = Permiso::where('persona_id', $persona->id)->get();
        } else {
            $permisos = Permiso::all();
        }
        return view('servicio.permiso.list')
                        ->with('location', 'servcio')
                        ->with('permisos', $permisos);
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
        $permiso = new Permiso($request->all());
        $result = $permiso->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriaservicio();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "PERMISO";
            $str = "CREACIÓN DE PERMISO. DATOS: ";
            foreach ($permiso->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            if($permiso->tipo == 'SERVICIO'){
                flash("El permiso <strong>" . $permiso->servicio->cliente->nombre . "</strong> fue almacenado(a) de forma exitosa!")->success();
            }else {
                flash("El permiso <strong>" . $permiso->solicitudcambio->servicio->cliente->nombre . "</strong> fue almacenado(a) de forma exitosa!")->success();
            }

            return redirect()->route('servicio.index');
        } else {
            if($permiso->tipo == 'SERVICIO'){
                flash("El permiso <strong>" . $permiso->servicio->cliente->nombre . "</strong> no pudo ser almacenado(a) de forma exitosa!". $result)->error();
            }else {
                flash("El permiso <strong>" . $permiso->solicitudcambio->servicio->cliente->nombre . "</strong> no pudo ser almacenado(a) de forma exitosa!". $result)->error();
            }
            return redirect()->route('solicitud.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function show(Permiso $permiso) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function edit(Permiso $permiso) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permiso $permiso) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permiso $permiso) {
        //
    }

}
