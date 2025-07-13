<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historia;

class HistoriaController extends Controller
{
    /* Mostrar al público */
    public function show()
    {
        $historia = Historia::first() ?? Historia::create(['contenido' => 'Historia pendiente…']);
        return view('historia.show', compact('historia'));
    }

    /* Formulario de edición (solo admin) */
    public function edit()
    {
        $historia = Historia::first();
        return view('admin.historia.edit', compact('historia'));
    }

    /* Guardar cambios */
    public function update(Request $request)
    {
        $request->validate(['contenido' => 'required|string']);

        $historia = Historia::first();
        $historia->update(['contenido' => $request->contenido]);

        return back()->with('success', 'Historia actualizada correctamente.');
    }
}

