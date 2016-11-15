<?php

use Illuminate\Database\Seeder;

class DiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dias')->insert([
            'dia'=>'Lunes, Miercoles y Viernes',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'Lunes a Viernes',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'Martes y Jueves',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'Sábado',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'4 dias a la semana',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'3 Dias a la semana',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'Lunes, Miercoles y Jueves',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'Sábado + 1 dia',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'Martes, Jueves y Viernes',
            'activated'=>'1',
        ]);
    }
}
