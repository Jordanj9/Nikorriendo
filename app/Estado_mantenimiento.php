<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado_mantenimiento extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'lavadora_id','estado','created_at', 'updated_at'
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

    public function mantenimiento(){
        return $this->hasMany(Mantenimiento::class);
    }
}
