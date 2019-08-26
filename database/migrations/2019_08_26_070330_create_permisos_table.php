<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('permisos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo', 15);
            $table->bigInteger('persona_id')->unsigned();
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->bigInteger('servicio_id')->unsigned()->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->bigInteger('solicitudcambio_id')->unsigned()->nullable();
            $table->foreign('solicitudcambio_id')->references('id')->on('solicitudcambios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('permisos');
    }

}
