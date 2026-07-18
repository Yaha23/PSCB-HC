<?php

namespace Database\Factories;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class MedicoFactory extends Factory
{
    public function definition(): array
    {
        return [
        'user_id' => User::factory(),
        'nombres' => $this->faker->firstName(),
        'apellidos' => $this->faker->lastName(),
        'email' => $this->faker->unique()->safeEmail(),
        'DNI' => $this->faker->numerify('########'),
        'fecha_nacimiento' => $this->faker->date(),
        'telefono' => $this->faker->numerify('9########'),
        'direccion' => $this->faker->address(),
        'estado' => 'activo',
        'especialidad' => 'medicina general',
    ];
    }
}