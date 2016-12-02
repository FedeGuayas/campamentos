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
            'dia'=>'LUNES, MIERCOLES Y VIERNES',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'LUNES A VIERNES',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'MARTES Y JUEVES',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'SABADO',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'4 DIAS A LA SEMANA',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'3 DIAS A LA SEMANA',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'LUNES, MIERCOLES y JUEVES',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'SABADO + 1 DIA',
            'activated'=>'1',
        ]);
        DB::table('dias')->insert([
            'dia'=>'MARTES, JUEVES Y VIERNES',
            'activated'=>'1',
        ]);
    }
}
