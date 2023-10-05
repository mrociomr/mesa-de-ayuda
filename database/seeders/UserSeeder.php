<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'administrador@gmail.com',
            'password' => bcrypt('administrador')
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Practicante',
            'email' => 'practicante@gmail.com',
            'password' => bcrypt('practicante')
        ])->assignRole('Practicante');
    }
}
