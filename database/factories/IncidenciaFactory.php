<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incidencia>
 */
class IncidenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dni' => $this->faker->sentence(1),
            'celular' => $this->faker->e164PhoneNumber(),
            'oficina_id' => $this->faker->numberBetween(1,10),
            'tipo_problema_id' => $this->faker->numberBetween(1,10),
        ];
    }
}
