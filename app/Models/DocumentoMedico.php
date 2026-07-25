<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentoMedico extends Model
{
    protected $table = 'documentos_medicos';

    protected $fillable = [
        'consulta_id',
        'nombre',
        'archivo',
        'tipo'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
