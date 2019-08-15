<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('fechaentrega')->nullable();
            $table->dateTime('fecharecogido')->nullable();
            $table->dateTime('fechafin')->nullable();
            $table->integer('dias');
            $table->string('estado', 50);
            $table->string('direccion', 100);
            $table->string('firma_recibido_cliente')->nullable();
            $table->string('firma_entrega_personal')->nullable();
            $table->string('firma_entrega_cliente')->nullable();
            $table->string('firma_recogida_personal')->nullable();
            $table->string('latitud');
            $table->string('longitud');
            $table->integer('total');
            $table->bigInteger('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->bigInteger('persona_id')->unsigned();
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('servicio_lavadora', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('servicio_id')->unsigned();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
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
    public function down() {
        Schema::dropIfExists('servicios');
    }

}
