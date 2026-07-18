<?php

namespace Database\Factories;
use Illuminate\Support\Str;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          return [
        'nombres' => $this->faker->firstName(),
        'apellidos' => $this->faker->lastName(),
        'DNI' => $this->faker->unique()->numerify('########'),
        'fecha_nacimiento' => $this->faker->date(),
        'genero' => $this->faker->randomElement(['masculino','femenino']),
        'estado_civil' => $this->faker->randomElement(['soltero','casado']),
        'celular' => $this->faker->phoneNumber(),
        'email' => $this->faker->unique()->safeEmail(),
        'direccion' => $this->faker->address(),
        'grupo_sanguineo' => $this->faker->randomElement(['A+','O+','B+']),
    ];

    }
}
