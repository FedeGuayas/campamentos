<?php

use Illuminate\Database\Seeder;

class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pagos')->insert([
            'forma'=>'CONTADO',
            'descripcion'=>'Pago en efectivo',
        ]);
        DB::table('pagos')->insert([
            'forma'=>'Tarjeta de Crédito',
            'descripcion'=>'Pago mediante Tarjetas de Credito u Online',
        ]);
    }
}
