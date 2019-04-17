<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTipoDescuentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_descuentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre'); // Empleado
            $table->unsignedTinyInteger('porciento'); //50, 100
            $table->decimal('multiplicador');// 0.5, 1,  porciento /100
            $table->string('descripcion'); // Descuento por empleado
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
        Schema::drop('tipo_descuentos');
    }
}
