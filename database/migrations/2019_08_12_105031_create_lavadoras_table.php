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
            $table->bigInteger('serial');
            $table->string('marca', 20);
            $table->enum('estado_bodega', ['SI', 'NO']);
            $table->string('estado_lavadora', 30);
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
