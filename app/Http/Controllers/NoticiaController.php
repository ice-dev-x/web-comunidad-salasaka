<?php

namespace App\Http\Controllers;
use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noticias = Noticia::orderBy('created_at', 'desc')->get();
    return view('noticias.index', compact('noticias'));
        //return view('noticias.index'); //Cuando alguien visite /noticias, muestra la vista resources/views/noticias/index.blade.php
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'Acceso no autorizado');
    }
        return view('noticias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'Acceso no autorizado');
        }
        // Validación rápida
    $request->validate([
        'titulo' => 'required|string|max:255',
        'contenido' => 'required|string',
        'autor' => 'nullable|string|max:100',
        'imagen' => 'nullable|image|max:2048', // máximo 2MB
    ]);

    // Guardar en la base de datos
    /*Noticia::create([
        'titulo' => $request->titulo,
        'contenido' => $request->contenido,
        'autor' => $request->autor,
        'publicado' => true
    ]);*/
    $noticia = new Noticia();
    $noticia->titulo = $request->titulo;
    $noticia->contenido = $request->contenido;
    $noticia->autor = $request->autor;
    // Guardar imagen si se subió
    if ($request->hasFile('imagen')) {
    $ruta = $request->file('imagen')->store('noticias', 'public');
    $noticia->imagen = $ruta;
    }
     $noticia->save();

    return redirect()->route('noticias.index')->with('success', 'Noticia creada correctamente.');
    } 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $noticia = Noticia::findOrFail($id);
    return view('noticias.show', compact('noticia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->check() || auth()->user()->rol !== 'admin') {
    abort(403, 'Acceso no autorizado');
    }
        $noticia = Noticia::findOrFail($id);
        return view('noticias.edit', compact('noticia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->check() || auth()->user()->rol !== 'admin') {
    abort(403, 'Acceso no autorizado');
    }
        $request->validate([
        'titulo' => 'required|string|max:255',
        'contenido' => 'required|string',
        'autor' => 'nullable|string|max:100',
        'imagen' => 'nullable|image|max:2048',
        ]);
    $noticia = Noticia::findOrFail($id);
    $noticia->update($request->all());
    // Actualizar imagen si se sube una nueva
    if ($request->hasFile('imagen')) {
        // Eliminar imagen anterior si existe
        if ($noticia->imagen && \Storage::disk('public')->exists($noticia->imagen)) {
            \Storage::disk('public')->delete($noticia->imagen);
        }

        // Guardar nueva imagen
        $ruta = $request->file('imagen')->store('noticias', 'public');
        $noticia->imagen = $ruta;
    }

    $noticia->save();

    return redirect()->route('noticias.index')->with('success', 'Noticia actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->check() || auth()->user()->rol !== 'admin') {
    abort(403, 'Acceso no autorizado');
    }
        $noticia = Noticia::findOrFail($id);
    $noticia->delete();

    return redirect()->route('noticias.index')->with('success', 'Noticia eliminada.');
    }
}
