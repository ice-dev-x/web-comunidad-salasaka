<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle de Noticia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-6">
    <div class="max-w-3xl mx-auto px-4">

        {{-- Noticia --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            @if($noticia->imagen)
                <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen de la noticia" class="w-full h-auto object-cover">
            @endif
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $noticia->titulo }}</h1>
                <p class="text-sm text-gray-500 mb-4">
                    <span class="font-medium">Autor:</span> {{ $noticia->autor ?? 'Anónimo' }} |
                    <span class="font-medium">Fecha:</span> {{ $noticia->created_at->format('d/m/Y') }}
                </p>
                {{-- Categoría --}}
                <p class="text-sm text-gray-600 mb-4">
                    <strong>Categoría:</strong> {{ $noticia->categoria->nombre }}
                </p>

                {{-- Contenido (renderiza HTML) --}}
                <article class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! $noticia->contenido !!}
                </article>
            </div>
        </div>

        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Comentarios --}}
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            Comentarios ({{ $noticia->comentarios->where('estado', 'aprobado')->count() }})
        </h2>

        <div class="space-y-4 mb-6">
            @forelse ($noticia->comentarios->where('estado', 'aprobado')->sortByDesc('created_at') as $comentario)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800">{{ $comentario->usuario->name }}</span>
                        <span class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-700">{{ $comentario->contenido }}</p>
                </div>
            @empty
                <p class="text-gray-500">
                    Aún no hay comentarios aprobados. ¡Sé el primero en opinar!
                </p>
            @endforelse
        </div>

        {{-- Formulario de comentario --}}
        @auth
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-semibold mb-3">Deja un comentario</h3>
                <form action="{{ route('comentarios.store', $noticia->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <textarea name="contenido" rows="4" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Escribe tu comentario..." required>{{ old('contenido') }}</textarea>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Publicar comentario</button>
                </form>
            </div>
        @else
            <p class="text-gray-600 mt-4">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Inicia sesión</a> para comentar.
            </p>
        @endauth

        {{-- Botón volver --}}
        <a href="{{ route('noticias.index') }}" class="inline-block mt-6 text-gray-600 hover:text-gray-900 hover:underline">← Volver a noticias</a>

    </div>
</body>
</html>
