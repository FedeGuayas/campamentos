<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('calendar_id')->unsigned();
            $table->integer('alumno_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('factura_id')->unsigned();
            $table->double('matricula',5,2)->nullable();
            $table->double('mensualidad',5,2);
            $table->enum('estado',['Reservada','Pagada','Cancelado'])->default('Pagada');
            
            $table->softDeletes();

            $table->foreign('calendar_id')->references('id')->on('calendars');
            $table->foreign('alumno_id')->references('id')->on('alumnos');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('factura_id')->references('id')->on('facturas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inscripcions');
    }
}
