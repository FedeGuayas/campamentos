<?php

use Illuminate\Database\Seeder;

class EscenarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('escenarios')->insert([
            'escenario'=>'ESTADIO MODELO',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'PISCINA OLIMPICA',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'MIRAFLORES',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'4 MOSQUETEROS',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'POLIDEPORTIVO',
            'activated'=>'1',
        ]);
    }


}
