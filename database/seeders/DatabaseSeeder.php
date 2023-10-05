<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Dependencia;
use App\Models\Sede;
use App\Models\Oficina;
use App\Models\TipoSolucion;
use App\Models\TipoProblema;
use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Dependencia::factory(10)->create();
        Sede::factory(10)->create();
        Oficina::factory(10)->create()->each(function ($oficina) use ($faker) {
            $oficina->nombre = $faker->company; // Generar un nombre aleatorio
            $oficina->abreviatura = $faker->lexify('???');
            $oficina->nivel = $faker->randomDigit;
            $oficina->prioridad = $faker->randomDigit;
            $oficina->estado = $faker->randomElement(['activo', 'inactivo']);

            $oficina->password = bcrypt('2023'); // Cambia 'contraseña_secreta' por la contraseña que desees

            $oficina->save();
        });
        TipoSolucion::factory(10)->create();
        TipoProblema::factory(15)->create();
        Incidencia::factory(20)->create();

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

    }
    private function generateRandomName($length)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $randomName = '';

        for ($i = 0; $i < $length; $i++) {
            $randomName .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $randomName;
    }
}
