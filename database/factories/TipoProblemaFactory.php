<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoProblema>
 */
class TipoProblemaFactory extends Factory
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
            'prioridad' => $this->faker->numberBetween(1,5),
            'estado' => $this->faker->randomElement(['Activo', 'Inactivo'])
        ];
    }
}
