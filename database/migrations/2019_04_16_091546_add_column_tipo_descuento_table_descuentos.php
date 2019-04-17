<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTipoDescuentoTableDescuentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('descuentos', function (Blueprint $table) {
            $table->integer('tipo_descuento_id')->after('valor')->unsigned()->nullable();
            $table->string('porciento')->after('tipo_descuento_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('descuentos', function (Blueprint $table) {
            $table->dropColumn('tipo_descuento_id');
            $table->dropColumn('porciento');
        });
    }
}
