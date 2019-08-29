<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitudcambio extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'observacion', 'estado', 'num_lavadora', 'tiempopendiente', 'firma_cliente', 'servicio_id', 'persona_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function servicio() {
        return $this->belongsTo('App\Servicio');
    }

    public function cambios() {
        return $this->hasMany(Cambios::class);
    }

    public function permisos() {
        return $this->hasMany('App\Permiso');
    }

    public function persona() {
        return $this->belongsTo('App\Persona');
    }

}
