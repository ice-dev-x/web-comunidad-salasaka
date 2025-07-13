@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 bg-gray-100">

    {{-- Card blanca con sombra y bordes redondeados --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">
            Historia de la Comunidad Salasaka
        </h1>

        {{-- Contenido renderizado sin escapar, con buena tipografía --}}
        <article class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            {!! $historia->contenido !!}
        </article>
    </div>

    {{-- Botón volver --}}
    <a href="{{ route('noticias.index') }}" 
       class="inline-block text-gray-600 hover:text-gray-900 hover:underline">
       ← Volver a noticias
    </a>

</div>
@endsection
