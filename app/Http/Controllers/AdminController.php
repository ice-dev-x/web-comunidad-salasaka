<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\User;
use App\Models\Comentario;
use App\Models\Categoria;
use App\Models\Historia; 

class AdminController extends Controller
{
    public function index()
    {
                // última fecha de actualización de la historia (o null si no existe)
        $fechaHistoria = optional(
           Historia::query()->latest('updated_at')->first()
        )->updated_at;

        return view('admin.index', [
            'totalNoticias'   => Noticia::count(),
            'totalUsuarios'   => User::count(),
            'totalComentarios'=> Comentario::count(),
            'totalCategorias'   => Categoria::count(),
            'ultimasNoticias'   => Noticia::latest()->take(5)->get(),// Número de ultimás noticias que se muestran en el Panel de admin
            'pendientesComentarios'=> Comentario::where('estado', 'pendiente')->count(), // nuevo dato
            'fechaHistoria'     => $fechaHistoria     // ← nueva
        ]);
    }
}
