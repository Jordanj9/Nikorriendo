<?php

namespace App\Http\Controllers;

use App\Solicitudcambio;
use App\Lavadora;
use App\Cambios;
use App\Persona;
use App\Servicio;
use App\Auditoriaservicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SolicitudcambioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $solicitudes = Solicitudcambio::all();
        return view('servicio.cambios.list')
                        ->with('location', 'servicio')
                        ->with('solicitudes', $solicitudes);
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
        $servicio = Servicio::find($request->servicio_id);
        $solicitud = new Solicitudcambio($request->all());
        $hoy = getdate();
        $fecha = $hoy['year'] . '-' . $hoy['mon'] . '-' . $hoy['mday'] . ' ' . $hoy['hours'] . ':' . $hoy['minutes'] . ':' . $hoy['seconds'];
        $fecha = strtotime($fecha);
        $fin = strtotime($servicio->fechafin);
        $pendientes = abs(($fin - $fecha) / 3600);
        $horas = floor($pendientes);
        $minutos = $pendientes - $horas;
        $pendientes = $minutos * 60;
        $minutos = floor($pendientes);
        $segundos = $pendientes - $minutos;
        $segundos = floor($segundos * 60);
        $solicitud->tiempopendiente = $horas . ":" . $minutos . ":" . $segundos;
        $t =strtotime($solicitud->tiempopendiente);
        dd($t);
        $result = $solicitud->save();
        if ($result) {
            $u = Auth::user();
            $aud = new Auditoriaservicio();
            $aud->usuario = "ID: " . $u->identificacion . ",  USUARIO: " . $u->nombres . " " . $u->apellidos;
            $aud->operacion = "SOLICITUD DE CAMBIO";
            $str = "CREACIÓN DE SOLICITUD DE CAMBIO. DATOS: ";
            foreach ($solicitud->attributesToArray() as $key => $value) {
                $str = $str . ", " . $key . ": " . $value;
            }
            $aud->detalles = $str;
            $aud->save();
            flash("La Solicitud de cambio para el cliente <strong>" . $servicio->cliente->nombre . "</strong> fue almacenado(a) de forma exitosa!")->success();
            return redirect()->route('solicitud.index');
        } else {
            flash("La Solicitud de cambio para el cliente <strong>" . $servicio->cliente->nombre . "</strong> no pudo ser almacenado(a). Error: " . $result)->error();
            return redirect()->route('solicitud.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Solicitudcambio  $solicitudcambio
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitudcambio $solicitudcambio) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Solicitudcambio  $solicitudcambio
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitudcambio $solicitudcambio) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Solicitudcambio  $solicitudcambio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitudcambio $solicitudcambio) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Solicitudcambio  $solicitudcambio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Solicitudcambio $solicitudcambio) {
        //
    }

    public function solicitudCambio($id) {
        $servicio = Servicio::find($id);
        dd($servicio);
    }

}
