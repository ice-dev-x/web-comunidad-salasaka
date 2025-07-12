<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria; 

class CategoriaAdminController extends Controller
{
    public function index()
        {
            $categorias = Categoria::orderBy('id')->get();
            return view('admin.categorias.index', compact('categorias'));
        }

        public function create()
        {
            return view('admin.categorias.create');
        }

        public function store(Request $r)
        {
            $r->validate(['nombre' => 'required|string|max:100|unique:categorias']);
            Categoria::create($r->only('nombre'));
            return redirect()->route('admin.categorias.index')->with('success','Categoría creada.');
        }

        public function edit(Categoria $categoria)
        {
            return view('admin.categorias.edit', compact('categoria'));
        }

        public function update(Request $r, Categoria $categoria)
        {
            $r->validate(['nombre' => 'required|string|max:100|unique:categorias,nombre,'.$categoria->id]);
            $categoria->update($r->only('nombre'));
            return redirect()->route('admin.categorias.index')->with('success','Actualizada.');
        }

        public function destroy(Categoria $categoria)
        {
            $categoria->delete();
            return back()->with('success','Eliminada.');
        }

}