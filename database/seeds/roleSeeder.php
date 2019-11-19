<?php

use App\Role;
use Illuminate\Database\Seeder;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id'=>1,
            'nombre'=>'cliente',
            'poder'=>1
        ]);
        Role::create([
            'id'=>2,
            'nombre'=>'empleado',
            'poder'=>2
        ]);
        Role::create([
            'id'=>3,
            'nombre'=>'gerente',
            'poder'=>3
        ]);
    }
}
