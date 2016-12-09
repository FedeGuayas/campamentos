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
            'codigo'=>'002-002',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'PISCINA OLIMPICA',
            'codigo'=>'001-002',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'MIRAFLORES',
            'codigo'=>'003-002',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'4 MOSQUETEROS',
            'codigo'=>'005-002',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'POLIDEPORTIVO',
            'codigo'=>'004-002',
            'activated'=>'1',
        ]);
    }


}
