<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCalendars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('program_id')->unsigned();
            $table->integer('dia_id')->unsigned();
            $table->integer('horario_id')->unsigned();
            $table->integer('cupos');
            $table->integer('contador');
            $table->double('mensualidad',5,2);
            $table->string('nivel',30)->nullable();

            $table->foreign('program_id')->references('id')->on('programs')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dia_id')->references('id')->on('dias')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('horario_id')->references('id')->on('horarios')
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
        Schema::drop('calendars');
    }
}
