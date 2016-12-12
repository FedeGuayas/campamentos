<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name'=>'create_inscripcion',
            'display_name'=>'Create inscripcion',
            'description'=>'Crear Nueva Inscripción en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit_inscripcion',
            'display_name'=>'Editar inscripcion',
            'description'=>'Crear Nueva Inscripción en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'delete_inscripcion',
            'display_name'=>'Eliminar inscripcion',
            'description'=>'Crear Nueva Inscripción en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'create_modulo',
            'display_name'=>'Crear modulo',
            'description'=>'Crear Nuevo modulo en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit_modulo',
            'display_name'=>'Editar modulo',
            'description'=>'Edita modulo en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'eliminar_modulo',
            'display_name'=>'Eliminar modulo',
            'description'=>'Elimira modulo en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'create_program',
            'display_name'=>'Crear programa',
            'description'=>'Crear Nuevo programa en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit_programa',
            'display_name'=>'Editar programa',
            'description'=>'Edita programa en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'eliminar_programa',
            'display_name'=>'Eliminar programa',
            'description'=>'Elimira programa en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'create_inscripcion',
            'display_name'=>'Crear incripcion',
            'description'=>'Crear Nueva inscripcion en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit_inscripcion',
            'display_name'=>'Editar inscripcion',
            'description'=>'Edita inscripcion en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'eliminar_inscripcion',
            'display_name'=>'Eliminar inscripcion',
            'description'=>'Elimira inscripcion en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'create_alumno',
            'display_name'=>'Crear alumno',
            'description'=>'Crear Nueva alumno en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit_alumno',
            'display_name'=>'Editar alumno',
            'description'=>'Edita alumno en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'eliminar_alumno',
            'display_name'=>'Eliminar alumno',
            'description'=>'Elimira alumno en backend',
        ]);DB::table('permissions')->insert([
            'name'=>'create_representante',
            'display_name'=>'Crear representante',
            'description'=>'Crear Nueva representante en backend',
    ]);
        DB::table('permissions')->insert([
            'name'=>'edit_representante',
            'display_name'=>'Editar representante',
            'description'=>'Edita representante en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'eliminar_representante',
            'display_name'=>'Eliminar representante',
            'description'=>'Elimira representante en backend',
        ]);
    }
}
