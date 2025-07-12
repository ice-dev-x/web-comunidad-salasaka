<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\User;
use App\Models\Comentario;
use App\Models\Categoria;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'totalNoticias'   => Noticia::count(),
            'totalUsuarios'   => User::count(),
            'totalComentarios'=> Comentario::count(),
            'totalCategorias'   => Categoria::count(),
            'ultimasNoticias'   => Noticia::latest()->take(5)->get(),// Número de ultimás noticias que se muestran en el Panel de admin
            'pendientesComentarios'=> Comentario::where('estado', 'pendiente')->count(), // nuevo dato
        ]);
    }
}
