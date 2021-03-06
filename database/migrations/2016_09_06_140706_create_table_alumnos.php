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
            $table->string('foto_ced');
            $table->string('foto');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('persona_id')->references('id')->on('personas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('representante_id')->references('id')->on('representantes')
                ->onUpdate('restrict')->onDelete('restrict');
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
