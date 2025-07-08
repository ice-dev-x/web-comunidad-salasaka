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
        return view('noticias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación rápida
    $request->validate([
        'titulo' => 'required|string|max:255',
        'contenido' => 'required|string',
        'autor' => 'nullable|string|max:100',
    ]);

    // Guardar en la base de datos
    Noticia::create([
        'titulo' => $request->titulo,
        'contenido' => $request->contenido,
        'autor' => $request->autor,
        'publicado' => true
    ]);

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
         $noticia = Noticia::findOrFail($id);
    return view('noticias.edit', compact('noticia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'titulo' => 'required|string|max:255',
        'contenido' => 'required|string',
        'autor' => 'nullable|string|max:100',
        ]);
    $noticia = Noticia::findOrFail($id);
    $noticia->update($request->all());

    return redirect()->route('noticias.index')->with('success', 'Noticia actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $noticia = Noticia::findOrFail($id);
    $noticia->delete();

    return redirect()->route('noticias.index')->with('success', 'Noticia eliminada.');
    }
}
