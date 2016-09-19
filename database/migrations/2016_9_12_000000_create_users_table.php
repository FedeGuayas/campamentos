<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
//            $table->integer('rols_id')->unsigned();
//            $table->integer('escenario_id')->unsigned();
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('email',80)->unique();
            $table->string('password',60);
            $table->string('nombre',60 );
            $table->string('avatar')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();

//            $table->foreign('rols_id')->references('id')->on('rols');
//            $table->foreign('escenario_id')->references('id')->on('escenarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
