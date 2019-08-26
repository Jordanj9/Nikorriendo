<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCambiosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cambios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lavadora_vieja');
            $table->bigInteger('lavadora_id')->unsigned();
            $table->foreign('lavadora_id')->references('id')->on('lavadoras')->onDelete('cascade');
            $table->bigInteger('solicitudcambio_id')->unsigned();
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
        Schema::dropIfExists('cambios');
    }

}
