<?php

namespace App\Http\Controllers;

use App\Estado_mantenimiento;
use App\Lavadora;
use App\Mantenimiento;
use App\Persona;
use App\Repuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MantenimientoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $u = Auth::user();
        $persona = Persona::where([['identificacion', $u->identificacion], ['tipo', 'TECNICO']])->first();
        if ($persona != null && session('ROL') != 'ADMINISTRADOR') {
            $mantenimientos = Mantenimiento::where('persona_id', $persona->id)->get();
        } else {
            $mantenimientos = Mantenimiento::all();
        }
        $lav = Lavadora::where([['estado_lavadora', '<>', 'MANTENIMIENTO'], ['estado_lavadora', '<>', 'SERVICIO']])->get();
        if (count($lav) > 0) {
            foreach ($lav as $item) {
                $lavadoras[$item->id] = $item->serial . ' - ' . $item->marca . ' FECHA: ' . $item->created_at;
            }
        }
        return view('mantenimiento.mantenimiento.list')
                        ->with('location', 'mantenimiento')
                        ->with('mantenimientos', $mantenimientos)
                        ->with('lavadoras', $lavadoras);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $repuestos = Repuesto::where([
                    ['stock', '>', '0']
                ])->get();
        $persona = Persona::where('identificacion', Auth::user()->identificacion)->first();

        if ($persona == null) {
            flash("usted no puede <strong>" . 'realizar' . "</strong> tal operación en nuestro sistema, solo es permitido para los tecnicos")->warning();
            return redirect()->route('admin.mantenimiento');
        }

        $aux = Estado_mantenimiento::where([
                    ['estado', 'PENDIENTE']
                ])->get();

        //estos son los mantenimientos que se encuentran por realizar
        $mantenimientos = null;
        $mantenimientos = collect($mantenimientos);

        if (count($aux) > 0) {
            foreach ($aux as $item) {
                if ($item->lavadora->bodega->sucursal_id == $persona->sucursal_id) {
                    $mantenimientos[$item->id] = $item->lavadora->serial . ' - ' . $item->lavadora->marca . ' FECHA ' . $item->created_at;
                }
            }
        }

        if (count($mantenimientos) > 0) {

            return view('mantenimiento.mantenimiento.facturar')
                            ->with('location', 'mantenimiento')
                            ->with('mantenimientos', $mantenimientos)
                            ->with('persona', $persona)
                            ->with('repuestos', $repuestos);
        } else {
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
    public function store(Request $request) {
        $user = Auth::user();
        $persona = Persona::where([
                    ['identificacion', $user->identificacion],
                    ['tipo', 'TECNICO']
                ])->first();


        if ($persona != null) {

            $estado_mantenimiento = Estado_mantenimiento::find($request->estado_mantenimiento_id);
            $estado_mantenimiento->estado = 'REALIZADO';
            $result = $estado_mantenimiento->save();

            $lavadora = $estado_mantenimiento->lavadora;
            $lavadora->estado_lavadora = 'DISPONIBLE';
            $result2 = $lavadora->save();

            if ($result && $result2) {

                $mantenimiento = new Mantenimiento();
                $mantenimiento->persona_id = $persona->id;
                $mantenimiento->total = $request->total;
                $mantenimiento->descripcion = $request->descripcion;
                $mantenimiento->estado_mantenimiento_id = $estado_mantenimiento->id;
                $result3 = $mantenimiento->save();

                if ($result3) {
                    $repuestos = $request->repuestos;

                    foreach ($repuestos as $item) {
                        $repuesto = Repuesto::find($item['id']);
                        $repuesto->stock = $repuesto->stock - 1;
                        $repuesto->save();
                        $mantenimiento->repuestos()->attach($item['id'], ['precio' => $item['precio']]);
                    }

                    return response()->json([
                                'status' => 'ok',
                                'message' => 'mantenimiento almacenado correctamente',
                    ]);
                } else {
                    return response()->json([
                                'status' => 'error',
                                'message' => 'error al intentar guardar el mantenimiento, Error' . $result . $result2
                    ]);
                }
            } else {
                return response()->json([
                            'status' => 'error',
                            'message' => 'error al intentar guardar el mantenimiento, Error' . $result . $result2
                ]);
            }
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => 'usuario no valido, no posees los privilegios suficientes para realizar esta acción',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage, nuevo mantenimiento manual
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request) {
        $mant = new Estado_mantenimiento($request->all());
        $result = $mant->save();
        if ($result) {
            flash("El Mantenimiento para <strong>" . $mant->lavadora->serial . "-" . $mant->lavadora->marca . "</strong> fue almacenado(a) de forma exitosa!")->success();
            return redirect()->route('mantenimiento.index');
        } else {
            flash("El Mantenimiento para <strong>" . $mant->lavadora->serial . "-" . $mant->lavadora->marca . "</strong> no pudo ser almacenado(a) de forma exitosa! Error:" . $result)->error();
            return redirect()->route('mantenimiento.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Mantenimiento $mantenimiento) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Mantenimiento $mantenimiento) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantenimiento $mantenimiento) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $mantenimiento = Estado_mantenimiento::find($id);
        $nombre = $mantenimiento->lavadora->serial . " - " . $mantenimiento->lavadora->marca;
        $result = $mantenimiento->delete();
        if ($result && $result) {
            return response()->json([
                        'status' => 'ok',
                        'message' => "El mantenimiento para la lavadora " . $nombre . " fue eliminado(a) de forma exitosa!"
            ]);
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => "El mantenimiento para la lavadora " . $nombre . " no pudo ser eliminado(a). Error:"
            ]);
        }
    }

}
