<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Noticia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-6">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Noticia</h1>

            {{-- Errores --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('noticias.update', $noticia->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $noticia->titulo) }}"
                           class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
                    <textarea name="contenido" rows="6" required
                              class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500">{{ old('contenido', $noticia->contenido) }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Autor</label>
                        <input type="text" name="autor" value="{{ old('autor', $noticia->autor) }}"
                               class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select name="categoria_id"
                                class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Seleccione…</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}"
                                        {{ old('categoria_id', $noticia->categoria_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Imagen actual --}}
                @if ($noticia->imagen)
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Imagen actual:</p>
                        <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen actual" class="w-40 h-auto rounded mb-2">
                    </div>
                @endif

                {{-- Nueva imagen --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nueva imagen (opcional)</label>
                    <input type="file" name="imagen" accept="image/jpeg,image/png"
                           class="w-full border-gray-300 rounded-md shadow-sm file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0 file:bg-blue-600 file:text-white
                                  hover:file:bg-blue-700">
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('noticias.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
