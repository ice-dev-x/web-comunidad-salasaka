<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\User;
use App\Models\Comentario;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'totalNoticias'   => Noticia::count(),
            'totalUsuarios'   => User::count(),
            'totalComentarios'=> Comentario::count(),
        ]);
    }
}
