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
            'codigo'=>'2002',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'PISCINA OLIMPICA',
            'codigo'=>'1002',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'MIRAFLORES',
            'codigo'=>'3002',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'4 MOSQUETEROS',
            'codigo'=>'5002',
            'activated'=>'1',
        ]);
        DB::table('escenarios')->insert([
            'escenario'=>'POLIDEPORTIVO HUANCAVILCA',
            'codigo'=>'4002',
            'activated'=>'1',
        ]);
    }


}
