<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lavadora extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'serial', 'marca', 'estado_bodega', 'estado_lavadora', 'bodega_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function bodega() {
        return $this->belongsTo(Bodega::class);
    }

    public function lavadora_personas() {
        return $this->hasMany('App\Lavadora_persona');
    }

}
