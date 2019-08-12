<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'direccion', 'sucursal_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];

    public function sucursal() {
        return $this->belongsTo(Sucursal::class);
    }

}
