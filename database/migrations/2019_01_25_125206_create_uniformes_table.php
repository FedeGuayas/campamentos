<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uniformes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->string('talla');
            $table->string('color')->nullable();
            $table->string('img')->nullable();
            $table->smallInteger('stock')->unsigned();
            $table->string('status')->default(\App\Uniforme::AGOTADO);
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
        Schema::drop('uniformes');
    }
}
