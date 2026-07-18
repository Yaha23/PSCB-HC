<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente;
use App\Models\Consulta;

class Cita extends Model
{
    protected $fillable = [
    'paciente_id',
    'medico_id',
    'fecha',
    'hora',
    'motivo',
    'estado'
];
    public function medico()
{
    return $this->belongsTo(User::class, 'medico_id');
}

public function paciente()
{
    return $this->belongsTo(Paciente::class);
}

public function consulta()
{
    return $this->hasOne(Consulta::class);
}
}
