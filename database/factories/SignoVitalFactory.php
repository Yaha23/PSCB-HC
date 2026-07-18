<?php

namespace Database\Factories;

use App\Models\SignoVital;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SignoVital>
 */
class SignoVitalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            return [
            'peso' => $this->faker->randomFloat(2, 40, 100),
            'talla' => $this->faker->randomFloat(2, 1.40, 1.90),
            'presion_arterial' => $this->faker->randomElement(['120/80','110/70','130/90']),
            'frecuencia_cardiaca' => $this->faker->numberBetween(60,100),
            'temperatura' => $this->faker->randomFloat(1,36,38),
            'frecuencia_respiratoria' => $this->faker->numberBetween(12,20),
        ];
    }
}
