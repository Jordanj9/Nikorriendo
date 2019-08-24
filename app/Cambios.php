<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cambios extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'firma_cliente', 'lavadora_vieja', 'lavadora_id', 'solicitudcambio_id', 'persona_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function lavadora() {
        return $this->belongsTo('App\Lavadora');
    }

    public function solicitudcambio() {
        return $this->belongsTo('App\Solicitudcambio');
    }

    public function persona() {
        return $this->belongsTo('App\Persona');
    }

}
