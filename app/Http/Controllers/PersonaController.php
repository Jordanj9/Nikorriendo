<?php

namespace App\Http\Controllers;

use App\Contacto_emergencia;
use App\Persona;
use App\Sucursal;
use App\User;
use Illuminate\Http\Request;

class PersonaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $empleados = Persona::all();
        if (count($empleados) > 0) {
            foreach ($empleados as $item) {
                $item->nombre = $item->primer_nombre . " " . $item->primer_apellido;
            }
        }
        return view('estructura.empleado.list')
                        ->with('location', 'estructura')
                        ->with('empleados', $empleados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Responsesucursales
     */
    public function create() {
        $sucursales = Sucursal::all()->pluck('nombre', 'id');
        return view('estructura.empleado.create')
                        ->with('location', 'estructura')
                        ->with('sucursales', $sucursales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $contacto = new Contacto_emergencia;
        $contacto->nombres = $request->get('nombre_contacto');
        $contacto->parentezco = $request->get('parentezco_contacto');
        $contacto->email = $request->get('email_contacto');
        $contacto->direccion = $request->get('direccion_contacto');
        $contacto->telefono = $request->get('telefono_contacto');
        foreach ($contacto->attributesToArray() as $key => $value) {
            $contacto->$key = strtoupper($value);
        }
        $result2 = $contacto->save();
        $persona = new Persona($request->all());
        $persona->contacto_emergencia_id = $contacto->id;
        foreach ($persona->attributesToArray() as $key => $value) {
            if ($key == 'email') {
                $persona->$key = $value;
                continue;
            }
            $persona->$key = strtoupper($value);
        }
        $result1 = $persona->save();
        if ($result1 && $result2) {
            if (User::where('identificacion', $persona->identificacion)->first() == null) {
                $user = new User();
                $user->identificacion = $persona->identificacion;
                $user->nombres = $persona->primer_nombre . ' ' . $persona->segundo_nombre;
                $user->apellidos = $persona->primer_apellido . ' ' . $persona->segundo_apellido;
                $user->email = $persona->email;
                $user->estado = 'ACTIVO';
                $user->password = bcrypt($user->identificacion);
                $user->save();
            }
            flash("El empleado <strong>" . $persona->nombre . "</strong> fue almacenado(a) de forma exitosa!")->success();
            return redirect()->route('persona.index');
        } else {
            flash("El empleado <strong>" . $persona->nombre . "</strong> no pudo ser almacenado(a). Error: ")->error();
            return redirect()->route('persona.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Persona $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona) {
        return view('estructura.empleado.show')
                        ->with('location', 'estructura')
                        ->with('persona', $persona);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Persona $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona) {
        $sucursales = Sucursal::all()->pluck('nombre', 'id');
        return view('estructura.empleado.edit')
                        ->with('location', 'estructura')
                        ->with('persona', $persona)
                        ->with('sucursales', $sucursales);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Persona $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona) {
        $identificicacion = $persona->identificacion;
        $contacto = Contacto_emergencia::find($request->get('id_contacto'));
        $contacto->nombres = $request->get('nombre_contacto');
        $contacto->parentezco = $request->get('parentezco_contacto');
        $contacto->email = $request->get('email_contacto');
        $contacto->direccion = $request->get('direccion_contacto');
        $contacto->telefono = $request->get('telefono_contacto');
        foreach ($contacto->attributesToArray() as $key => $value) {
            $contacto->$key = strtoupper($value);
        }
        $result2 = $contacto->save();
        foreach ($persona->attributesToArray() as $key => $value) {
            if (isset($request->$key)) {
                if ($key == 'email') {
                    $persona->$key = $request->$key;
                    continue;
                }
                $persona->$key = strtoupper($request->$key);
            }
        }
        $result1 = $persona->save();
        if ($result1 && $result2) {
            $user = User::where('identificacion', $identificicacion)->first();
            $user->identificacion = $persona->identificacion;
            $user->nombres = $persona->primer_nombre . ' ' . $persona->segundo_nombre;
            $user->apellidos = $persona->primer_apellido . ' ' . $persona->segundo_apellido;
            $user->email = $persona->email;
            $user->estado = $persona->estado;
            $user->save();
            flash("El empleado <strong>" . $persona->nombre . "</strong> fue modificado(a) de forma exitosa!")->success();
            return redirect()->route('persona.index');
        } else {
            flash("El empleado <strong>" . $persona->nombre . "</strong> no pudo ser modificado(a). Error: ")->error();
            return redirect()->route('persona.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Persona $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona) {
        $nombre = $persona->primer_nombre . ' ' . $persona->primer_apellido;
        $user = User::where('identificacion', $persona->identificacion)->first();
        /* if(count($bodega->lavadoras) > 0){
          return response()->json([
          'status' => 'warning',
          'message'=>"la bodega " .$nombre. " no pudo ser eliminado(a) porque tiene lavadoras asociadas. Error:"
          ]);
          } */
        $result = $persona->delete();
        $result2 = $user->delete();
        if ($result && $result2) {
            return response()->json([
                        'status' => 'ok',
                        'message' => "el empleado " . $nombre . " fue eliminado(a) de forma exitosa!"
            ]);
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => "el empleado " . $nombre . " no pudo ser eliminado(a). Error:"
            ]);
        }
    }

}
