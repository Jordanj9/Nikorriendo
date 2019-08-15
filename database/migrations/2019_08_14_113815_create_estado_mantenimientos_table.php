<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_mantenimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('estado',['PENDIENTE','REALIZADO'])->default('PENDIENTE');
            $table->bigInteger('lavadora_id')->unsigned();
            $table->foreign('lavadora_id')->references('id')->on('lavadoras')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estado_mantenimientos');
    }
}
