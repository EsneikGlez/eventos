<?php

use Illuminate\Database\Seeder;
use App\User;
class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Gerente',
            'email' =>'gerente@correo.com',
            'password' => Hash::make('gerente'),
            'role_id'=>3
        ]);
        User::create([
            'name' => 'Empleado',
            'email' =>'empleado@correo.com',
            'password' => Hash::make('empleado'),
            'role_id'=>2
        ]);
    }
}
