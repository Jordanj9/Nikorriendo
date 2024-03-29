<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'telefono', 'nombre', 'direccion', 'barrio', 'latitud', 'longitud', 'barrio_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function servicios() {
        return $this->hasMany(Servicio::class);
    }

    public function barrio() {
        return $this->belongsTo(Barrio::class);
    }

}
