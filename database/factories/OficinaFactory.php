<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Oficina>
 */
class OficinaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->sentence(), 
            'abreviatura' => $this->faker->sentence(3), 
            'nivel' => $this->faker->numberBetween(1,5),
            'prioridad' => $this->faker->numberBetween(1,5),
            'sede_id' => $this->faker->numberBetween(1,10),
            'estado' => $this->faker->randomElement(['Activo', 'Inactivo']), 
            'dependencia_id' =>$this->faker->numberBetween(1,10), 
            'password'=>$this->faker->sentence(5)
        ];
    }
}
