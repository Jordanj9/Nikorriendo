<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'precio', 'stock','bodega_id','created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function bodega(){
      return $this->belongsTo(Bodega::class);
    }

    public function mantenimientos(){
        return $this->belongsToMany(Mantenimiento::class,'mantenimiento_repuesto');
    }
}
