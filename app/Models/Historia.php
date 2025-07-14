<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    protected $table = 'historias'; // Asegúrate que el nombre coincide con la migración

    protected $fillable = [
        'titulo',
        'contenido',
    ];
}
