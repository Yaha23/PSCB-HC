<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = [

        /*
        |--------------------------------------------------------------------------
        | RELACIONES
        |--------------------------------------------------------------------------
        */
        'paciente_id',
        'medico_id',
        'asistente_id',

        /*
        |--------------------------------------------------------------------------
        | DATOS GENERALES
        |--------------------------------------------------------------------------
        */
        'especialidad',
        'fecha_atencion',
        'hora_atencion',

        /*
        |--------------------------------------------------------------------------
        | ANAMNESIS
        |--------------------------------------------------------------------------
        */
        'motivo_consulta',
        'tiempo_enfermedad',
        'apetito',
        'sed',
        'sueno',
        'estado_animo',
        'orina',
        'deposiciones',


        /*
        |--------------------------------------------------------------------------
        | DIAGNÓSTICO
        |--------------------------------------------------------------------------
        */
        'diagnostico_principal',

        /*
        |--------------------------------------------------------------------------
        | TRATAMIENTO
        |--------------------------------------------------------------------------
        */
        'tratamiento',

        /*
        |--------------------------------------------------------------------------
        | ACUERDOS
        |--------------------------------------------------------------------------
        */
        'acuerdos_compromisos',

        /*
        |--------------------------------------------------------------------------
        | EXÁMENES
        |--------------------------------------------------------------------------
        */
        'examenes_auxiliares',

        /*
        |--------------------------------------------------------------------------
        | REFERENCIA
        |--------------------------------------------------------------------------
        */
        'referencia',

       

        /*
        |--------------------------------------------------------------------------
        | OBSERVACIONES
        |--------------------------------------------------------------------------
        */
        'observaciones',

        /*
        |--------------------------------------------------------------------------
        | ESTADO
        |--------------------------------------------------------------------------
        */
        'estado',
    ];

    /**
     * Paciente
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    /**
     * Médico responsable
     */
    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    /**
     * Asistente que registró la atención
     */
    public function asistente()
    {
        return $this->belongsTo(User::class, 'asistente_id');
    }

    /**
     * Signos vitales
     */
    public function signosVitales()
    {
        return $this->hasOne(SignoVital::class);
    }

    /**
     * Documentos médicos
     */
    public function documentos()
    {
        return $this->hasMany(DocumentoMedico::class);
    }
}