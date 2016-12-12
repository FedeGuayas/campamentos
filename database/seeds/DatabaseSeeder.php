<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EscenarioSeeder::class);
        $this->call(DiasSeeder::class);
        $this->call(DisciplinasSeeder::class);
        $this->call(HorariosSeeder::class);
        $this->call(DatosContablesSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
