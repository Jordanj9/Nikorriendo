<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'municipio', 'departamento', 'direccion', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function bodegas() {
        return $this->hasMany('App\Bodega');
    }

}
