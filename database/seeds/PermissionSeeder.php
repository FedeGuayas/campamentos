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
            'description'=>'Crear Nuevo modulo',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit_modulo',
            'display_name'=>'Editar modulo',
            'description'=>'Edita modulo',
        ]);
        DB::table('permissions')->insert([
            'name'=>'delete_modulo',
            'display_name'=>'Eliminar modulo',
            'description'=>'Elimira modulo',
        ]);
        DB::table('permissions')->insert([
            'name'=>'create_program',
            'display_name'=>'Crear programa',
            'description'=>'Crear Nuevo programa',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit_program',
            'display_name'=>'Editar programa',
            'description'=>'Edita programa',
        ]);
        DB::table('permissions')->insert([
            'name'=>'delete_program',
            'display_name'=>'Eliminar programa',
            'description'=>'Elimira programa',
        ]);
        DB::table('permissions')->insert([
            'name'=>'create_calendar',
            'display_name'=>'Crear Curso',
            'description'=>'Crear nuevo curso',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit_calendar',
            'display_name'=>'Editar curso',
            'description'=>'Edita curso en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'delete_calendar',
            'display_name'=>'Eliminar curso',
            'description'=>'Eliminar curso en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'create_permission',
            'display_name'=>'Crear incripcion',
            'description'=>'Crear Nueva inscripcion en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit_permission',
            'display_name'=>'Editar inscripcion',
            'description'=>'Edita inscripcion en backend',
        ]);
        DB::table('permissions')->insert([
            'name'=>'delete_permission',
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
            'name'=>'delete_alumno',
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
            'name'=>'delete_representante',
            'display_name'=>'Eliminar representante',
            'description'=>'Elimira representante en backend',
        ]);
        DB::table('permissions')->insert([
        'name'=>'cancel_reserva',
        'display_name'=>'Cancelar Reservación',
        'description'=>'Cancelar reserva al no pagarse',
        ]);
        DB::table('permissions')->insert([
            'name'=>'confirm_reserva',
            'display_name'=>'Confirmar Reserva',
            'description'=>'Confirma la reserva como pagada',
        ]);
    }
}
