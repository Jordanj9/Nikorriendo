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
        'id', 'observacion', 'estado', 'num_lavadora', 'tiempopendiente', 'servicio_id', 'created_at', 'updated_at'
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
        return $this->hasMany('App\Cambios');
    }

}
