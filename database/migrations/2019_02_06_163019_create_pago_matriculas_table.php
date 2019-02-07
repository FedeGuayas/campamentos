<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_matriculas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inscripcion_id')->unsigned(); //inscripcion de referencia para el pago de la matricula
            $table->integer('user_id')->unsigned(); //ususario que cobro la matricula
            $table->integer('user_delete')->unsigned()->nullable(); //ususario que cobro la matricula
            $table->integer('escenario_id')->unsigned();//pto_cobro donde se cobro la matricula
            $table->integer('factura_id')->unsigned(); //factura que se genear con este cobro
            $table->double('matricula',5,2); //costo de la matricula
            $table->char('anio',4); //año del cobro
            $table->timestamps();

            $table->softDeletes();

            $table->foreign('inscripcion_id')->references('id')->on('inscripcions');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('escenario_id')->references('id')->on('escenarios');
            $table->foreign('factura_id')->references('id')->on('facturas');

            $table->unique(['inscripcion_id','anio']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pago_matriculas');

    }
}
