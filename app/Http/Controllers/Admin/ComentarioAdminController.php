<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioAdminController extends Controller
{
    /** ‑ Pendientes ‑ */
    public function index()
    {
        $pendientes = Comentario::where('estado','pendiente')
                                ->latest()->paginate(10);

        return view('admin.comentarios.index', compact('pendientes'));
    }

    /** ‑ Aprobar ‑ */
    public function aprobar(Comentario $comentario)
    {
        $comentario->update(['estado' => 'aprobado']);
        return back()->with('success','Comentario aprobado.');
    }

    /** ‑ Rechazar ‑ */
    public function rechazar(Comentario $comentario)
    {
        $comentario->update(['estado' => 'rechazado']);
        return back()->with('success','Comentario rechazado.');
    }
}
