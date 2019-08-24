<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudcambiosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('solicitudcambios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('observacion');
            $table->string('estado', 20)->default('PENDIENTE');
            $table->integer('num_lavadora');
            $table->time('tiempopendiente');
            $table->bigInteger('servicio_id')->unsigned();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('solicitudcambios');
    }

}
