<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Doctrine\DBAL;

class ModifyTableEscenarioTransporte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('escenario_transporte', function ($table){
//            Cambiar tipo del precio de tinyInteger a float
            $table->float('precio')->change();

//            Adicionar las relaciones entre las tablas
            $table->foreign('escenario_id')->references('id')->on('escenarios')
             ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('transporte_id')->references('id')->on('transportes')
            ->onUpdate('cascade')->onDelete('cascade');
//            Adicionar indices
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
        Schema::table('escenario_transporte', function ($table){
            $table->dropPrimary(['escenario_id', 'transporte_id']);
        });

    }
}
