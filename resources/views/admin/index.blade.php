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
    </div>
</div>
@endsection
