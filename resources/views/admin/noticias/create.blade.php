@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6">
        {{-- Título --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Crear Nueva Noticia</h1>

        {{-- Mostrar errores de validación --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario de creación --}}
        <form action="{{ route('admin.noticias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Campo Título --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="titulo" value="{{ old('titulo') }}"
                    class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            {{-- Campo Contenido --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                <textarea id="contenido" name="contenido" rows="6"
                    class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500">{{ old('contenido') }}</textarea>
            </div>

            {{-- Autor y Categoría --}}
            <div class="grid md:grid-cols-2 gap-4">
                {{-- Autor --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Autor</label>
                    <input type="text" name="autor" value="{{ old('autor') }}"
                        class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                {{-- Categoría --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select name="categoria_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Seleccione…</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Imagen --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen (JPG/PNG, máx. 2 MB)</label>
                <input type="file" name="imagen" accept="image/jpeg,image/png"
                    class="w-full border-gray-300 rounded-md shadow-sm file:mr-4 file:py-2 file:px-4
                          file:rounded-md file:border-0 file:bg-blue-600 file:text-white
                          hover:file:bg-blue-700" required>
            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.noticias.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancelar</a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>

    {{-- Script TinyMCE --}}
    <script src="https://cdn.tiny.cloud/1/36zv4ollhnu75iqqzyykhvx6ucuicltdx5byl2arz50s1i8j/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            tinymce.init({
                selector: '#contenido',
                menubar: false,
                plugins: 'lists link image table code',
                toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code',
                height: 400
            });

            // Forzar que el contenido del editor se copie al textarea antes de enviar el formulario
            const form = document.querySelector('form');
            form.addEventListener('submit', () => tinymce.triggerSave());
        });
    </script>
</div>
@endsection
