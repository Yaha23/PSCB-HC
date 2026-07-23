<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Horario extends Model
{

    protected $table = 'horarios';


    protected $fillable = [

        'user_id',
        'especialidad',
        'dia_semana',
        'hora_inicio',
        'hora_fin',

    ];



    public function user()
{
    return $this->belongsTo(User::class,'user_id');
}

}