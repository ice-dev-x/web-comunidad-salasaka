<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class NoticiaAdminController extends Controller
{
    public function index()
    {
        $noticias = Noticia::latest()->paginate(6);
        return view('admin.noticias.index', compact('noticias'));
    }
    /* Formulario crear */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('admin.noticias.create', compact('categorias'));
    }

    /* Guardar */
    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'contenido'    => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'autor'        => 'required|nullable|string|max:100',
            'imagen'       => 'required|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $noticia = Noticia::create($request->only(
            'titulo','contenido','categoria_id','autor'
        ));

        if ($request->hasFile('imagen')) {
            $noticia->imagen = $request->file('imagen')
                                       ->store('noticias', 'public');
            $noticia->save();
        }

        return redirect()->route('admin.index')
                         ->with('success','Noticia creada');
    }

    /* Formulario editar */
    public function edit(Noticia $noticia)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('admin.noticias.edit', compact('noticia','categorias'));
    }

    /* Actualizar */
    public function update(Request $request, Noticia $noticia)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'contenido'    => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'autor'        => 'required|nullable|string|max:100',
            'imagen'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $noticia->update($request->only(
            'titulo','contenido','categoria_id','autor'
        ));

        if ($request->hasFile('imagen')) {
            if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
                Storage::disk('public')->delete($noticia->imagen);
            }
            $noticia->imagen = $request->file('imagen')
                                       ->store('noticias', 'public');
            $noticia->save();
        }

        return back()->with('success','Noticia actualizada');
    }

    /* Eliminar */
    public function destroy(Noticia $noticia)
    {
        if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
            Storage::disk('public')->delete($noticia->imagen);
        }
        $noticia->delete();

        return redirect()->route('admin.index')
                         ->with('success','Noticia eliminada');
    }
}
