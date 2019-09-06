<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactoEmergenciasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contacto_emergencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombres', 80);
            $table->string('parentezco', 30);
            $table->string('telefono', 11);
            $table->string('email')->nullable();
            $table->string('direccion', 80);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contacto_emergencias');
    }

}
