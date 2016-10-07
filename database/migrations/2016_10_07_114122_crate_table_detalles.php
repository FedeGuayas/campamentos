<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateTableDetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inscripcion_id')->unsigned();
            $table->integer('descuento_id')->unsigned()->nullable();
            $table->integer('factura_id')->unsigned();
            $table->timestamps();
            $table->string('cantidad');
            $table->string('precio');

            $table->foreign('inscripcion_id')->references('id')->on('inscripcions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('factura_id')->references('id')->on('facturas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('descuento_id')->references('id')->on('descuentos')
                ->onUpdate('cascade')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('detalles');
    }
}
