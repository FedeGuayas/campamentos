<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRepresentantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('persona_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('encuesta_id')->unsigned()->nullable();
            $table->string('foto_ced');
            $table->string('foto');
            $table->timestamps();

            $table->softDeletes();
            $table->foreign('persona_id')->references('id')->on('personas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('encuesta_id')->references('id')->on('encuestas')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::drop('representantes');
    }
}
