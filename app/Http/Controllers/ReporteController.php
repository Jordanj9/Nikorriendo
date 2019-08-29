<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Lavadora;
use App\Persona;
use App\Bodega;
use App\Sucursal;
use App\Permiso;
use App\Cambios;
use App\Solicitudcambio;
use App\Estado_mantenimiento;
use App\Mantenimiento;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReporteController extends Controller {

    public function reporteGeneral() {
        $sucursales = Sucursal::all()->pluck('nombre', 'id');
        $lavadoras_aux = Lavadora::all();
        $lavadoras = [];
        if (count($lavadoras_aux) > 0) {
            foreach ($lavadoras_aux as $l) {
                $lavadoras[$l->id] = $l->serial . ' - ' . $l->marca . ' - BODEGA:' . $l->bodega->nombre . ' - SUCURSAL:' . $l->bodega->sucursal->nombre;
            }
        }
        $lavadoras = collect($lavadoras);
        return view('reporte.general')
                        ->with('location', 'reporte')
                        ->with('sucursales', $sucursales);
    }

    /**
     * show all resource from a sucursal
     *
     * @param  int  $sucursal_id
     * @return \Illuminate\Http\Response
     */
    public function getPersonas($id) {
        $sucursal = Sucursal::find($id);
        $per = $sucursal->personas;
        $per = $per->sortBy('primer_nombre');
        if (count($per) > 0) {
            $personas = null;
            foreach ($per as $i) {
                if ($i->tipo == "MENSAJERO" && $i->estado == "ACTIVO") {
                    $obj["id"] = $i->id;
                    $obj["value"] = $i->primer_nombre . ' ' . $i->segundo_nombre . ' ' . $i->primer_apellido . ' ' . $i->segundo_apellido . ' -CARGO:' . $i->tipo . ' -SUCURSAL:' . $i->sucursal->nombre;
                    $personas[] = $obj;
                }
            }
            return json_encode($personas);
        } else {
            return "null";
        }
    }

    /**
     * show all resource from a persona
     *
     * @param  int  $persona_id
     * @return \Illuminate\Http\Response
     */
    public function getLavadoras($id) {
        $persona = Persona::find($id);
        $lav = $persona->lavadoras;
        if (count($lav) > 0) {
            $lavadoras = null;
            foreach ($lav as $i) {
                $obj["id"] = $i->id;
                $obj["value"] = $i->serial . ' - ' . $i->marca . ' - BODEGA:' . $i->bodega->nombre . ' - SUCURSAL:' . $i->bodega->sucursal->nombre . ' - ESTADO:' . $i->estado_lavadora;
                $lavadoras[] = $obj;
            }
            return json_encode($lavadoras);
        } else {
            return "null";
        }
    }

    /**
     * 
     * @param string $estado estado del servicio
     * @param date $fechai fecha inicio del rango
     * @param date $fechaf fecha fin del rango
     * @param int $sucursal_id sucursal NULL
     * @param int $persona_id persona NULL
     * @param int $lavadora_id lavadora NULL
     * @return json servicios
     */
    public function getServicios($estado, $fi, $ff, $suc, $per, $lav) {
        $ser = collect();
        if ($per != "null" || $lav != "null") {
            $persona = Persona::find($per);
            if ($persona != null) {
                if ($lav != null) {
                    $ser = Servicio::whereHas('lavadoras', function(Builder $query) use ($lav) {
                                $query->Where('id', $lav);
                            })->whereBetween('created_at', [$fi, $ff])->where('persona_id', $persona->id)->get();
                } else {
                    $ser = DB::table('servicios')->whereBetween('created_at', [$fi, $ff])->where('persona_id', $persona->id)->get();
                }
            } else {
                return "null";
            }
        } elseif ($suc != "null") {
            $ser = DB::table('servicios')->whereBetween('created_at', [$fi, $ff])->where('sucursal_id', $suc)->get();
        } else {
            $ser = DB::table('servicios')->whereBetween('created_at', [$fi, $ff])->get();
        }
        $servicios = collect();
        if (count($ser) > 0) {
            foreach ($ser as $item) {
                if ($estado != "TODO") {
                    if ($item->estado == $estado) {
                        $o = Servicio::find($item->id);
                        $servicios[] = $o;
                    }
                } else {
                    $o = Servicio::find($item->id);
                    $servicios[] = $o;
                }
            }
            $start = strtotime($fi);
            $end = strtotime($ff);
            $total = null;
            if (count($servicios) > 0) {
                while ($start < $end) {
                    $to = [
                        'total' => 0,
                        'cant' => 0
                    ];
                    $cont = 0;
                    foreach ($servicios as $i) {
                        $l = date("Y-m-d", $start);
                        $c = explode("-", $l);
                        $k = explode("-", $i->created_at);
                        if ($k[1] == $c[1]) {
                            $to["total"] = $to["total"] + $i->total;
                            $to["cant"] = $to["cant"] + $cont++;
                        }
                    }
                    $total[$l] = $to;
                    $m[] = strftime('%b %Y', $start);
                    $start = strtotime("+1 month", $start);
                }
                if ($total != null) {
                    $plata = $cantidad = null;
                    foreach ($total as $key => $value) {
                        $plata[] = $value["total"];
                        $cantidad[] = $value["cant"];
                    }
                }
                $service = null;
                foreach ($servicios as $i) {
                    $obj["id"] = $i->id;
                    if ($i->persona_id != null) {
                        $obj["men"] = $i->persona->primer_nombre . " " . $i->persona->primer_apellido;
                    } else {
                        $obj["men"] = "SIN ASIGNAR";
                    }
                    $obj["tel_cli"] = $i->cliente->telefono;
                    $obj["cli"] = $i->cliente->nombre;
                    $obj["dir"] = $i->direccion;
                    $obj["bar"] = $i->barrio->nombre;
                    if ($i->fechaentrega != null) {
                        $obj["fechae"] = $i->fechaentrega;
                    } else {
                        $obj["fechae"] = "SIN ENTREGAR";
                    }
                    if ($i->fechafin != null) {
                        $obj["fechaf"] = $i->fechafin;
                    } else {
                        $obj["fechaf"] = "SIN ENTREGAR";
                    }
                    if ($i->fecharecogido != null) {
                        $obj["fecharec"] = $i->fecharecogido;
                    } else {
                        $obj["fecharec"] = "SIN RECOGER";
                    }
                    $obj["est"] = $i->estado;
                    $obj["cre"] = $i->created_at;
                    $service['data'][] = $obj;
                }
                $service["meses"] = $m;
                $service["total"] = $plata;
                $service["cant"] = $cantidad;
                return json_encode($service);
            } else {
                return "null";
            }
        } else {
            return "null";
        }
    }

}
