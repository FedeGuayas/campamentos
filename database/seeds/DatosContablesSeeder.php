<?php

use Illuminate\Database\Seeder;

class DatosContablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contables')->insert([
            'cta_ingreso'=>'6252499006133',
            'cta_xcobrar'=>'1110101001',
            'cta_anticipo'=>'2120307999',
            'actividad'=>'Campamentos Deportivos',
        ]);
    }
}
