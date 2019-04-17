<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsFacturarOtroTableFacturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->string('otro_factura')->after('descuento')->default(\App\Factura::FACTURAR_A_REPRESENTANTE);
            $table->string('fact_nombres')->after('otro_factura')->nullable();
            $table->string('fact_ci')->after('fact_nombres')->nullable();
            $table->string('fact_email')->after('fact_ci')->nullable();
            $table->string('fact_phone')->after('fact_email')->nullable();
            $table->string('fact_direccion')->after('fact_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('otro_factura');
            $table->dropColumn('fact_nombres');
            $table->dropColumn('fact_ci');
            $table->dropColumn('fact_email');
            $table->dropColumn('fact_phone');
            $table->dropColumn('fact_direccion');
        });
    }
}
