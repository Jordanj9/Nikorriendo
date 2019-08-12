<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $fillable = [
        'id', 'nombre', 'municipio','departamento','direccion' ,'created_at', 'updated_at'
    ];

}
