@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Panel de Administración</h1>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Tarjeta Noticias -->
        <div class="bg-white shadow-lg rounded-lg p-6 border">
            <h2 class="text-xl font-semibold mb-2">Noticias</h2>
            <p class="text-4xl font-bold text-blue-600">{{ $totalNoticias }}</p>
            <a href="{{ route('noticias.index') }}" class="text-blue-500 hover:underline">Ver todas</a>
        </div>

        <!-- Tarjeta Usuarios -->
        <div class="bg-white shadow-lg rounded-lg p-6 border">
            <h2 class="text-xl font-semibold mb-2">Usuarios</h2>
            <p class="text-4xl font-bold text-green-600">{{ $totalUsuarios }}</p>
            {{-- Agrega ruta a lista de usuarios cuando la crees --}}
        </div>
        

        <!-- Tarjeta Comentarios -->
        <div class="bg-white shadow-lg rounded-lg p-6 border">
            <h2 class="text-xl font-semibold mb-2">Comentarios</h2>
            <p class="text-4xl font-bold text-purple-600">{{ $totalComentarios }}</p>
            {{-- Futuro: ruta a moderación de comentarios --}}
        </div>
        <!-- Tarjeta Categorías -->
        <div class="bg-white shadow-lg rounded-lg p-6 border">
            <h2 class="text-xl font-semibold mb-2">Categorías</h2>
            <p class="text-4xl font-bold text-orange-600">{{ $totalCategorias }}</p>
            <a href="{{ route('admin.categorias.index') }}" class="text-blue-500 hover:underline">Gestionar</a>
        </div>
        
        {{-- Últimas noticias (tarjeta coherente) --}}
        <div class="bg-white shadow-lg rounded-lg p-6 border">
            <h2 class="text-xl font-semibold mb-4">Últimas noticias</h2>

            <ul class="divide-y divide-gray-200">
                @forelse ($ultimasNoticias as $n)
                    <li class="py-3 flex justify-between items-start">
                        <a href="{{ route('noticias.show', $n->id) }}"
                        class="font-medium text-gray-800 hover:text-blue-600">
                            {{ Str::limit($n->titulo, 60) }}
                        </a>
                        <span class="text-xs text-gray-500 whitespace-nowrap">
                            {{ $n->created_at->diffForHumans() }}
                        </span>
                    </li>
                @empty
                    <li class="text-gray-500 py-2">Aún no hay noticias.</li>
                @endforelse
            </ul>
        </div>


</div>
@endsection
