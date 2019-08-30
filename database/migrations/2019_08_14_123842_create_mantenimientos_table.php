<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('persona_id')->unsigned();
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->bigInteger('estado_mantenimiento_id')->unsigned();
            $table->foreign('estado_mantenimiento_id')->references('id')->on('estado_mantenimientos')->onDelete('cascade');
            $table->decimal('total',10,2);
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('mantenimiento_repuesto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('mantenimiento_id')->unsigned();
            $table->foreign('mantenimiento_id')->references('id')->on('mantenimientos')->onDelete('cascade');
            $table->bigInteger('repuesto_id')->unsigned();
            $table->foreign('repuesto_id')->references('id')->on('repuestos')->onDelete('cascade');
            $table->decimal('precio',8,2);
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
        schema::dropIfExists('mantenimiento_repuesto');
        Schema::dropIfExists('mantenimientos');
    }
}
