<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlumnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('persona_id')->unsigned();
            $table->integer('representante_id')->unsigned();
            $table->enum('discapacitado',['SI','NO'])->default('NO');
            $table->string('foto_ced')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('persona_id')->references('id')->on('personas');
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
        Schema::drop('alumnos');
    }
}
