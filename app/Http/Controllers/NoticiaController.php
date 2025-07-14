<?php

namespace App\Http\Controllers;
use App\Models\Noticia;
use Illuminate\Http\Request;
use App\Models\Categoria;
class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* ───── Construir consulta base ───── */
    $query = Noticia::query();

    /* 🔍 Búsqueda por texto */
    if ($request->filled('busqueda')) {
        $query->where(function ($q) use ($request) {
            $q->where('titulo',    'like', '%'.$request->busqueda.'%')
              ->orWhere('contenido','like', '%'.$request->busqueda.'%');
        });
    }

    /* 🏷️ Filtro por categoría */
    if ($request->filled('categoria')) {
        $query->where('categoria_id', $request->categoria);
    }

    /* 📅 Orden y paginación (10 por página) */
    $noticias = $query->latest()                // mismo que orderBy('created_at', 'desc')
                      ->paginate(10)
                      ->appends($request->only(['busqueda', 'categoria']));

    /* 📂 Todas las categorías para el selector */
    $categorias = Categoria::orderBy('nombre')->get();

    /* 📄 Enviar datos a la vista */
    return view('noticias.index', compact('noticias', 'categorias'));
    }
    public function create()
    // Solo admins
    {
        if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'Acceso no autorizado');
    }
        //return view('noticias.create');
    
     // Traer categorías ordenadas alfabéticamente
    $categorias = Categoria::orderBy('nombre')->get();
    // Pasarlas a la vista
    return view('noticias.create', compact('categorias'));
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
        'titulo' => 'required|string|max:255', //required hace que el campo sea obligatorio de llenar
        'contenido' => 'required|string',
        'categoria_id' => 'required|exists:categorias,id',
        'autor' => 'required|nullable|string|max:100',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // ❗️evita avif aquí
        //'imagen' => 'nullable|image|max:2048', // máximo 2MB
        ], [
    // Mensajes personalizados
    'imagen.mimes' => 'Formato de imagen no válido. Solo se permiten JPG, JPEG o PNG.',
    'imagen.image' => 'El archivo debe ser una imagen válida.',
    ]);

    // Guardar en la base de datos
    /*Noticia::create([
        'titulo' => $request->titulo,
        'contenido' => $request->contenido,
        'autor' => $request->autor,
        'publicado' => true
    ]);*/
    //Crear noticia
    $noticia = new Noticia();
    $noticia->titulo = $request->titulo;
    $noticia->contenido = $request->contenido;
    $noticia->categoria_id   = $request->categoria_id;      // ← NUEVO
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
    {  //solo admins
        if (!auth()->check() || auth()->user()->rol !== 'admin') {
    abort(403, 'Acceso no autorizado');
    }
        // Noticia a editar
    $noticia = Noticia::findOrFail($id);

    // Todas las categorías
    $categorias = Categoria::orderBy('nombre')->get();

    // Pasar ambas cosas a la vista
    return view('noticias.edit', compact('noticia', 'categorias'));
    }
    
     
    
    /**
     * Update the specified resource in storage.
     */
    // ───────────── UPDATE ─────────────
public function update(Request $request, string $id)
{
    // Solo admins
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'Acceso no autorizado');
    }

    // VALIDACIÓN
    $request->validate([
        'titulo'       => 'required|string|max:255',
        'contenido'    => 'required|string',
        'categoria_id' => 'required|exists:categorias,id',
        'autor'        => 'required|nullable|string|max:100',
        'imagen'       => 'required|nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'imagen.mimes' => 'Formato no válido. Solo JPG, JPEG o PNG.',
        'imagen.image' => 'El archivo debe ser una imagen válida.',
    ]);

    // Encontrar noticia
    $noticia               = Noticia::findOrFail($id);
    $noticia->titulo       = $request->titulo;
    $noticia->contenido    = $request->contenido;
    $noticia->categoria_id = $request->categoria_id;        // ← NUEVO
    $noticia->autor        = $request->autor;

    // Imagen nueva
    if ($request->hasFile('imagen')) {
        // Borra la antigua si existe
        if ($noticia->imagen && \Storage::disk('public')->exists($noticia->imagen)) {
            \Storage::disk('public')->delete($noticia->imagen);
        }
        $ruta = $request->file('imagen')->store('noticias', 'public');
        $noticia->imagen = $ruta;
    }

    $noticia->save();

    return redirect()->route('noticias.index')
                     ->with('success', 'Noticia actualizada.');
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
