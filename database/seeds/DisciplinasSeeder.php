<?php

use Illuminate\Database\Seeder;

class DisciplinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disciplinas')->insert([
            'disciplina'=>'GIMNASIA RITMICA',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'PATINAJE',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'TENIS',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'FUTBOL',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'GIMNASIA ARTISTICA',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'PATINAJE ARTISTICO',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'AJEDREZ',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'ATLETISMO',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'ESCALADA',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'TAE KWON DO',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'BASQUET',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'BOXEO',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'NATACION',
            'activated'=>'1',
        ]);
    }
}
