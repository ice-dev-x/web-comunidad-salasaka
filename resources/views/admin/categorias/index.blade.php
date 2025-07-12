@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Categorías</h1>

    <a href="{{ route('admin.categorias.create') }}"
       class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        + Nueva categoría
    </a>

    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2 w-32">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($categorias as $cat)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $cat->id }}</td>
                <td class="px-4 py-2">{{ $cat->nombre }}</td>
                <td class="px-4 py-2 flex gap-2">
                    <a href="{{ route('admin.categorias.edit', $cat->id) }}"
                       class="px-2 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>

                    <form action="{{ route('admin.categorias.destroy', $cat->id) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar categoría?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
