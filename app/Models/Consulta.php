<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'especialidad',
        'fecha_atencion',
        'diagnostico_principal',
        'tratamiento',
        'observaciones',
    ];

    public function paciente()
{
    return $this->belongsTo(Paciente::class);
}

public function medico()
{
    return $this->belongsTo(User::class,'medico_id');
}

public function asistente()
{
    return $this->belongsTo(User::class,'asistente_id');
}

public function signosVitales()
{
    return $this->hasOne(SignoVital::class);
}
}