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
            'escenario'=>'Estadio Modelo',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'Piscina Olimpica',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'Miraflores',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'4 Mosqueteros',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'4 Polideportivo',
            'activated'=>'1',
        ]);
    }


}
