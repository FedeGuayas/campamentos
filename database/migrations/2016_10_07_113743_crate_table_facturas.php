<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateTableFacturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pago_id')->unsigned();
            $table->integer('representante_id')->unsigned();
            $table->double('total',5,2);
            $table->double('descuento',4,2)->nullable();
            $table->timestamps();
            
            $table->softDeletes();
            $table->foreign('pago_id')->references('id')->on('pagos');
            $table->foreign('representante_id')->references('id')->on('representantes');
                

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('facturas');
    }
}
