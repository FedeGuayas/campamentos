<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name'=>'Admin',
            'last_name'=>'Administrador',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin_campamentos'),
            'activated'=>true,
        ]);
//        factory(App\User::class,20)->create();
        
    }
}
