<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'fechaentrega', 'fecharecogido', 'fechafin', 'dias', 'estado', 'direccion', 'firma_recibido_cliente', 'firma_entrega_personal', 'firma_entrega_cliente', 'firma_recogida_personal', 'latitud', 'longitud', 'total', 'cliente_id', 'persona_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function persona() {
        return $this->belongsTo('App\Persona');
    }

    public function lavadoras() {
        return $this->belongsToMany('App\Lavadora');
    }

}