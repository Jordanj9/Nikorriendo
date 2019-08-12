<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'identificacion', 'primer_nombre','segundo_nombre','primer_apellido','segundo_apellido','tipo_sangre','email','telefono','sexo','direccion','contacto_emergencia_id','created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
            //
    ];
    
    public function contacto_emergencia(){
        return $this->hasOne(Contacto_emergencia::class,'contacto_emergencia_id');
       
    }
}
