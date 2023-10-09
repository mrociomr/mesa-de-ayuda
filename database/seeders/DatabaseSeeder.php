<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Dependencia;
use App\Models\Sede;
use App\Models\Oficina;
use App\Models\TipoSolucion;
use App\Models\TipoProblema;
use App\Models\Incidencia;
use App\Models\TokenMensaje;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $tipo_solucion = new TipoSolucion();
        $tipo_solucion->nombre = "Mantenimiento a la PC";
        $tipo_solucion->estado = "Activo";
        $tipo_solucion->save();
        $tipo_solucion2 = new TipoSolucion();
        $tipo_solucion2->nombre = "Cambio de cable de red";
        $tipo_solucion2->estado = "Activo";
        $tipo_solucion2->save();
        $tipo_solucion3 = new TipoSolucion();
        $tipo_solucion3->nombre = "Habilitación de nuevos puntos de red";
        $tipo_solucion3->estado = "Activo";
        $tipo_solucion3->save();
        $tipo_solucion4 = new TipoSolucion();
        $tipo_solucion4->nombre = "Instalación de programas";
        $tipo_solucion4->estado = "Activo";
        $tipo_solucion4->save();
        $tipo_solucion5 = new TipoSolucion();
        $tipo_solucion5->nombre = "Activación de Office";
        $tipo_solucion5->estado = "Activo";
        $tipo_solucion5->save();
        $tipo_solucion6 = new TipoSolucion();
        $tipo_solucion6->nombre = "Activación de Windows";
        $tipo_solucion6->estado = "Activo";
        $tipo_solucion6->save();


        $tipo_problema = new TipoProblema();
        $tipo_problema->nombre = "Problemas con mi PC";
        $tipo_problema->prioridad = 5;
        $tipo_problema->estado = "Activo";
        $tipo_problema->save();
        $tipo_problema2 = new TipoProblema();
        $tipo_problema2->nombre = "Problemas con la impresora";
        $tipo_problema2->prioridad = 5;
        $tipo_problema2->estado = "Activo";
        $tipo_problema2->save();
        $tipo_problema3 = new TipoProblema();
        $tipo_problema3->nombre = "Atasco de papel";
        $tipo_problema3->prioridad = 4;
        $tipo_problema3->estado = "Activo";
        $tipo_problema3->save();
        $tipo_problema4 = new TipoProblema();
        $tipo_problema4->nombre = "Instalación de programas";
        $tipo_problema4->prioridad = 4;
        $tipo_problema4->estado = "Activo";
        $tipo_problema4->save();
        $tipo_problema5 = new TipoProblema();
        $tipo_problema5->nombre = "Problemas con Office";
        $tipo_problema5->prioridad = 4;
        $tipo_problema5->estado = "Activo";
        $tipo_problema5->save();
        $tipo_problema6 = new TipoProblema();
        $tipo_problema6->nombre = "Problemas de red";
        $tipo_problema6->prioridad = 5;
        $tipo_problema6->estado = "Activo";
        $tipo_problema6->save();
        $tipo_problema7 = new TipoProblema();
        $tipo_problema7->nombre = "Problemas con AUTOCAD";
        $tipo_problema7->prioridad = 3;
        $tipo_problema7->estado = "Activo";
        $tipo_problema7->save();
        $tipo_problema8 = new TipoProblema();
        $tipo_problema8->nombre = "Mi PC no enciende";
        $tipo_problema8->prioridad = 5;
        $tipo_problema8->estado = "Activo";
        $tipo_problema8->save();
        $tipo_problema9 = new TipoProblema();
        $tipo_problema9->nombre = "Cambio de tinta y/o tóner";
        $tipo_problema9->prioridad = 3;
        $tipo_problema9->estado = "Activo";
        $tipo_problema9->save();
        $tipo_problema10 = new TipoProblema();
        $tipo_problema10->nombre = "Activación de Windows";
        $tipo_problema10->prioridad = 3;
        $tipo_problema10->estado = "Activo";
        $tipo_problema10->save();
        $tipo_problema11 = new TipoProblema();
        $tipo_problema11->nombre = "Activación de Office";
        $tipo_problema11->prioridad = 4;
        $tipo_problema11->estado = "Activo";
        $tipo_problema11->save();
        $tipo_problema12 = new TipoProblema();
        $tipo_problema12->nombre = "No tengo Internet";
        $tipo_problema12->prioridad = 5;
        $tipo_problema12->estado = "Activo";
        $tipo_problema12->save();
        $tipo_problema13 = new TipoProblema();
        $tipo_problema13->nombre = "Otros";
        $tipo_problema13->prioridad = 5;
        $tipo_problema13->estado = "Activo";
        $tipo_problema13->save();

        $token_mensaje = new TokenMensaje();
        $token_mensaje->name_token = "tu Token aqui";
        $token_mensaje->save();

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
