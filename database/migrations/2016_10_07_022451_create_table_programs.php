<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('escenario_id')->unsigned();
            $table->integer('disciplina_id')->unsigned();
            $table->integer('modulo_id')->unsigned();
            $table->double('matricula',5,2)->nullable();
            $table->boolean('activated')->default(true);
            $table->timestamps();

            $table->foreign('escenario_id')->references('id')->on('escenarios')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('disciplina_id')->references('id')->on('disciplinas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('modulo_id')->references('id')->on('modulos')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('programs');
    }
}
