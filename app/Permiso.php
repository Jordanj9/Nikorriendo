<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tipo', 'persona_id', 'servicio_id', 'solicitudcambio_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function persona() {
        return $this->belongsTo('App\Persona');
    }

    public function servicio() {
        return $this->belongsTo('App\Servicio');
    }

    public function solicitudcambio() {
        return $this->belongsTo('App\Solicitucambio');
    }

}
