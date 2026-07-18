<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignoVital extends Model
{
    protected $table = 'signos_vitales';
    
    protected $fillable = [
        'consulta_id',
        'peso',
        'talla',
        'presion_arterial',
        'frecuencia_cardiaca',
        'temperatura',
        'frecuencia_respiratoria',
        'saturacion',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}