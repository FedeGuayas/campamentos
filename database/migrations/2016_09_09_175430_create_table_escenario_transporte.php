<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEscenarioTransporte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escenario_transporte', function (Blueprint $table) {
            $table->integer('escenario_id')->unsigned();
            $table->integer('transporte_id')->unsigned();
            $table->double('precio',4,2);
            $table->timestamps();

            $table->foreign('escenario_id')->references('id')->on('escenarios')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('transporte_id')->references('id')->on('transportes')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['escenario_id', 'transporte_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('escenario_transporte');
    }
}
