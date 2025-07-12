<?php

namespace App\Http\Controllers;
use App\Models\Comentario;


use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, $noticiaId)
{
    if (!auth()->check()) {
        abort(403, 'Debes estar autenticado para comentar.');
    }

    $request->validate([
        'contenido' => 'required|string|max:1000',
    ]);

    $comentario = new Comentario();
    $comentario->contenido = $request->contenido;
    $comentario->noticia_id = $noticiaId;
    $comentario->user_id = auth()->id();
    $comentario->estado = 'pendiente'; // 👈 clave: el comentario queda en revisión|Al cambiarlo a "aprobado" todos los comentarios se publican sin moderación 
    $comentario->save();

    return redirect()->route('noticias.show', $noticiaId)->with('success', 'Tu comentario ha sido enviado y está en revisión.');
}

}
