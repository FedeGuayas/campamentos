<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cta_ingreso');
            $table->string('cta_xcobrar');
            $table->string('cta_anticipo');
            $table->string('actividad');

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
        Schema::drop('contables');
    }
}
