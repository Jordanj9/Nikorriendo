<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('telefono', 15);
            $table->string('nombre', 150);
            $table->string('direccion', 100);
            $table->string('barrio', 100);
            $table->string('latitud');
            $table->string('longitud');
            $table->bigInteger('barrio_id')->unsigned();
            $table->foreign('barrio_id')->references('id')->on('barrios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('clientes');
    }

}
