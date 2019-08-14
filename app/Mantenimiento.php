<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'persona_id', 'lavadora_id', 'fecha_entrega', 'total','created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function lavadora(){
        return $this->belongsTo(Lavadora::class);
    }

    public function persona(){
        return $this->belongsTo(Persona::class);
    }

    public function repuestos(){
       return $this->belongsToMany(Repuesto::class,'mantenimiento_repuesto');
    }

}
