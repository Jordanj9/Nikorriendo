<?php

namespace App\Observers;


use App\Servicio;
use App\Events\NewService;

class ServicioObserver
{
    public function created(Servicio $servicio){
         event(new NewService($servicio));
    }
}
