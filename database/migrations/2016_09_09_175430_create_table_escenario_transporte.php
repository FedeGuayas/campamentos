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
            $table->increments('id');
            $table->integer('escenario_id')->unsigned();
            $table->integer('transporte_id')->unsigned();
            $table->tinyInteger('precio')->nullable();
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
        Schema::drop('escenario_transporte');
    }
}
