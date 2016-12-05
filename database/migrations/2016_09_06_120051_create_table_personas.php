<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePersonas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->enum('tipo_doc',['Cedula','Pasaporte'])->default('Cedula');
            $table->char('num_doc', 10)->unique();
            $table->enum('genero',['Masculino','Femenino'])->default('Masculino');
            $table->date('fecha_nac');
            $table->string('email',60)->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono',15)->nullable();
            $table->string('phone',15)->nullable();

            $table->softDeletes();
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
        Schema::drop('personas');
    }
}
