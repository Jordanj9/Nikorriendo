<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLavadorasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lavadoras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('serial')->unique();
            $table->string('marca', 20);
            $table->enum('estado_bodega', ['SI', 'NO'])->default('SI');
            $table->enum('estado_lavadora', ['SERVICIO','MANTENIMIENTO','DISPONIBLE','INACTIVA'])->default('DISPONIBLE');//SERVICIO, MANTENIMIENTO,DISPONIBLE,INACTIVA
            $table->bigInteger('bodega_id')->unsigned();
            $table->foreign('bodega_id')->references('id')->on('bodegas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('lavadoras');
    }

}
