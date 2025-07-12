<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = ['noticia_id', 'user_id', 'contenido', 'estado'];

    // Relación: este comentario pertenece a una noticia
    public function noticia()
    {
        return $this->belongsTo(Noticia::class);
    }

    // Relación: este comentario pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
