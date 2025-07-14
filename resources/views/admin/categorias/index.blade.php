@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 bg-gray-100">

    {{-- Encabezado y botón volver --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Gestión de Categorías</h1>
    <p class="text-gray-600 mb-6">Panel de administración para gestionar las categorías.</p>
    
    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="flex flex-wrap gap-3 mb-6">

        <a href="{{ route('admin.index') }}"
           class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
           ← Volver
        </a>
    
    {{-- Botón nueva categoría --}}
    <a href="{{ route('admin.categorias.create') }}"
       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        + Nueva categoría
    </a>
</div>
    {{-- Tabla de categorías --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full text-xs sm:text-sm">
            <thead class="bg-gray-100 sticky top-0">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">ID</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nombre</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 w-40">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($categorias as $cat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $cat->id }}</td>
                        <td class="px-4 py-2">{{ $cat->nombre }}</td>
                        <td class="px-4 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.categorias.edit', $cat->id) }}"
                                   class="px-2 sm:px-3 py-1 bg-yellow-500 text-white rounded text-[11px] sm:text-xs hover:bg-yellow-600">
                                    Editar
                                </a>

                                <form action="{{ route('admin.categorias.destroy', $cat->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar categoría?');"
                                      class="inline">
                                    @csrf @method('DELETE')
                                    <button
                                        class="px-2 sm:px-3 py-1 bg-red-600 text-white rounded text-[11px] sm:text-xs hover:bg-red-700">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
