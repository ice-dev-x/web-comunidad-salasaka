@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">

    {{-- Noticia --}}
    <article class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        @if($noticia->imagen)
            <figure>
                <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen de la noticia: {{ $noticia->titulo }}" class="w-full h-auto object-cover">
                <figcaption class="sr-only">{{ $noticia->titulo }}</figcaption>
            </figure>
        @endif
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $noticia->titulo }}</h1>
            <p class="text-sm text-gray-500 mb-4">
                <span class="font-medium">Autor:</span> {{ $noticia->autor ?? 'Anónimo' }} |
                <span class="font-medium">Fecha:</span> {{ $noticia->created_at->format('d/m/Y') }}
            </p>
            <p class="text-sm text-gray-600 mb-4">
                <strong>Categoría:</strong> {{ $noticia->categoria->nombre }}
            </p>

            {{-- Contenido (renderizado seguro) --}}
            <article class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! $noticia->contenido !!}
            </article>
        </div>
    </article>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div role="alert" class="bg-green-100 border border-green-300 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errores --}}
    @if($errors->any())
        <div role="alert" class="bg-red-100 border border-red-300 text-red-800 p-4 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Comentarios --}}
    <section aria-labelledby="comentarios-title">
        <h2 id="comentarios-title" class="text-xl font-semibold text-gray-800 mb-4">
            Comentarios ({{ $noticia->comentarios->where('estado', 'aprobado')->count() }})
        </h2>

        <div class="space-y-4 mb-6">
            @forelse ($noticia->comentarios->where('estado', 'aprobado')->sortByDesc('created_at') as $comentario)
                <article role="comment" class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                    <header class="flex justify-between items-center mb-2">
                        <p class="font-semibold text-gray-800">{{ $comentario->usuario->name }}</p>
                        <time class="text-sm text-gray-500" datetime="{{ $comentario->created_at->toW3cString() }}">
                            {{ $comentario->created_at->diffForHumans() }}
                        </time>
                    </header>
                    <p class="text-gray-700 whitespace-pre-line">{{ $comentario->contenido }}</p>
                </article>
            @empty
                <p class="text-gray-500">
                    Aún no hay comentarios aprobados. ¡Sé el primero en opinar!
                </p>
            @endforelse
        </div>
    </section>

    {{-- Formulario de comentario --}}
    @auth
        <section aria-labelledby="form-comentario-title" class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 id="form-comentario-title" class="text-lg font-semibold mb-3">Deja un comentario</h3>
            <form action="{{ route('comentarios.store', $noticia->id) }}" method="POST" class="space-y-4">
                @csrf
                <textarea name="contenido" rows="4" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Escribe tu comentario..." required>{{ old('contenido') }}</textarea>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Publicar comentario
                </button>
            </form>
        </section>
    @else
        <p class="text-gray-600 mt-4">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Inicia sesión</a> para comentar.
        </p>
    @endauth

    {{-- Botón volver --}}
    <a href="{{ route('noticias.index') }}" class="inline-block mt-6 text-gray-600 hover:text-gray-900 hover:underline" aria-label="Volver al listado de noticias">
        ← Volver a noticias
    </a>

</div>
@endsection
