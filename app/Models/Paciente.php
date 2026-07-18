<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellidos',
        'DNI',
        'fecha_nacimiento',
        'genero',
        'estado_civil',
        'celular',
        'email',
        'direccion',
        'grupo_sanguineo'
    ];

    // UN PACIENTE TIENE MUCHAS CONSULTAS
    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}