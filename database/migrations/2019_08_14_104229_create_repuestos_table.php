<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repuestos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',50);
            $table->string('descripcion')->nullable();
            $table->decimal('precio', 8, 2);
            $table->integer('stock');
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
    public function down()
    {
        Schema::dropIfExists('repuestos');
    }
}
