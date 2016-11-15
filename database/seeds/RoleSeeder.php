<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'=>'administrator',
            'display_name'=>'Administrador',
            'description'=>'Administrador del sistema',
        ]);
        DB::table('roles')->insert([
            'name'=>'signup',
            'display_name'=>'Registrado para backend',
            'description'=>'Usuario registrado para hacer incscripciones en el backend',
        ]);
        DB::table('roles')->insert([
            'name'=>'planner',
            'display_name'=>'Planificador',
            'description'=>'Usuario encargado de la planificación mensual de los campametos',
        ]);

        DB::table('roles')->insert([
            'name'=>'invited',
            'display_name'=>'Invitado',
            'description'=>'Usuario con permisos limitados en el backend',
        ]);

        DB::table('roles')->insert([
            'name'=>'register',
            'display_name'=>'Usuarios online',
            'description'=>'Usuario registrados con acceso solo al frontend',
        ]);
    }
}
