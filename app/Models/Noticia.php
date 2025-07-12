<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comentario; // Asegúrate de importar el modelo

class Noticia extends Model
{
    protected $fillable = ['titulo', 'contenido', 'autor', 'publicado'];
    // Relación: una noticia tiene muchos comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
    public function categoria()
    {
    return $this->belongsTo(Categoria::class);
    }

}

