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
        'id', 'lavadora_vieja', 'lavadora_id', 'solicitudcambio_id', 'created_at', 'updated_at'
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
        return $this->belongsTo(Lavadora::class);
    }

    public function lavadora_antes(){
        return $this->belongsTo(Lavadora::class,'lavadora_vieja');
    }

    public function solicitudcambio() {
        return $this->belongsTo(Solicitudcambio::class);
    }

    public function persona() {
        return $this->belongsTo(Persona::class);
    }

}
