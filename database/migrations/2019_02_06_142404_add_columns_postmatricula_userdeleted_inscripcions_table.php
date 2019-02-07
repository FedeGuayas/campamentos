<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsPostmatriculaUserdeletedInscripcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inscripcions', function (Blueprint $table) {
            $table->integer('user_delete')->after('user_edit')->unsigned()->nullable(); //usuario que eliminóla inscripcion
            $table->string('post_matricula')->after('user_delete')->nullable(); // '1' pago la matricula posterior a la inscripcion
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inscripcions', function (Blueprint $table) {
            $table->dropColumn('user_delete');
            $table->dropColumn('post_matricula');
        });
    }
}
