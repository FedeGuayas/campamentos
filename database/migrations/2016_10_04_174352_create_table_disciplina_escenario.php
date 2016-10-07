<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDisciplinaEscenario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplina_escenario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('escenario_id')->unsigned();
            $table->integer('disciplina_id')->unsigned();
            $table->integer('horario_id')->unsigned()->nullable();
            $table->integer('dia_id')->unsigned()->nullable();
            $table->integer('modulo_id')->unsigned();

            $table->double('mensualidad',4,2);
            $table->double('matricula',4,2)->nullable();
            $table->integer('contador');
            $table->integer('cupos');
            $table->string('nivel',30)->nullable();
            $table->boolean('activated')->default(true);

            $table->foreign('escenario_id')->references('id')->on('escenarios')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('disciplina_id')->references('id')->on('disciplinas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('horario_id')->references('id')->on('horarios')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('dia_id')->references('id')->on('dias')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('modulo_id')->references('id')->on('modulos')
                ->onUpdate('cascade')->onDelete('cascade');

//            $table->primary(['escenario_id', 'disciplina_id']);

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
        Schema::drop('disciplina_escenario');
    }
}
