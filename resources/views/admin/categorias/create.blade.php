@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6">
    <h1 class="text-xl font-bold mb-6">Crear categoría</h1>

    <form action="{{ route('admin.categorias.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 font-medium">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}"
                   class="w-full p-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
            @error('nombre') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Guardar
        </button>
        <a href="{{ route('admin.categorias.index') }}" class="ml-3 text-gray-600 hover:underline">Cancelar</a>
    </form>
</div>
@endsection
