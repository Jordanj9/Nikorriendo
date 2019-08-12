<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
       protected $fillable = [
        'id', 'identificacion', 'primer_nombre','segundo_nombre'
     * ,'primer_apellido','segundo_apellido','tipo_sangre','email'
     * ,'telefono','sexo','direccion','contacto_emergencia_id','created_at', 'updated_at'
    ];

     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identificacion',15)->unique();
            $table->string('primer_nombre',30);
            $table->string('segundo_nombre',30)->nullable();
            $table->string('primer_apellido',30);
            $table->string('segundo_apellido',30)->nullable();
            $table->string('tipo_sangre',4);
            $table->string('email',4);
            $table->string('telefono',11);
            $table->enum('sexo',['F','M']);
            $table->string('direccion',50);
            $table->bigInteger('contacto_emergencia_id')->unsigned();
            $table->foreign('contacto_emergencia_id')->references('id')->on('contacto_emergencias')->onDelete('cascade');
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
        Schema::dropIfExists('personas');
    }
}
