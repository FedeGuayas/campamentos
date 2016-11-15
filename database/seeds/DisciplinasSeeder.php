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
            'disciplina'=>'Gimnasia Rítmica',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Patinaje',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Tennis',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Fútbol',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Gimnasia Artística',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Patinaje Artístico',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Ajedrez',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Atletismo',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Escalada',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Tae Kwon Do',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Básquet',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Boxeo',
            'activated'=>'1',
        ]);
        DB::table('disciplinas')->insert([
            'disciplina'=>'Natación',
            'activated'=>'1',
        ]);
    }
}
