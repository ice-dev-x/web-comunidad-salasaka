@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 bg-gray-100">
    {{-- Menú de pestañas --}}
<div class="mb-6 border-b border-gray-300">
    <nav class="flex space-x-4" aria-label="Tabs">
        <a href="{{ route('noticias.index') }}"
           class="px-3 py-2 font-medium text-sm rounded-t-lg
           {{ request()->routeIs('noticias.index') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
            Noticias
        </a>
        <a href="{{ route('historia.show') }}"
           class="px-3 py-2 font-medium text-sm rounded-t-lg
           {{ request()->routeIs('historia.show') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
            Historia
        </a>
    </nav>
</div>


    

    {{-- Título y descripción --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Noticias de la Comunidad Salasaka</h1>
    <p class="text-gray-600 mb-6">
        ¡Bienvenido al módulo de noticias! Aquí encontrarás información actualizada sobre nuestra comunidad.
    </p>

    {{-- Chips de categorías --}}
    <div class="flex flex-wrap items-center gap-2 mb-4">
        {{-- Todas --}}
        <a href="{{ route('noticias.index', ['categoria' => '']) }}"
           class="px-3 py-1 rounded-full border text-sm
                  {{ request('categoria') == '' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-blue-100' }}">
            Todas
        </a>

        @foreach ($categorias as $cat)
            <a href="{{ route('noticias.index', ['categoria' => $cat->id, 'busqueda' => request('busqueda')]) }}"
               class="px-3 py-1 rounded-full border text-sm
                      {{ request('categoria') == $cat->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-blue-100' }}">
                {{ $cat->nombre }}
            </a>
        @endforeach
    </div>

    {{-- Filtro + búsqueda --}}
    <form action="{{ route('noticias.index') }}" method="GET"
          class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
        {{-- Selector categoría --}}
        <select name="categoria"
                class="p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
            <option value="">Todas las categorías</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nombre }}
                </option>
            @endforeach
        </select>

        {{-- Input búsqueda --}}
        <input type="text" name="busqueda" value="{{ request('busqueda') }}"
               placeholder="Buscar noticias..."
               class="p-2 border border-gray-300 rounded-md w-full focus:outline-none focus:ring focus:border-blue-300">

        {{-- Botón buscar --}}
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
            Buscar
        </button>
    </form>

    {{-- Mensaje de sesión --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Listado de noticias --}}
    @if ($noticias->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach ($noticias as $noticia)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition">
                    @if($noticia->imagen)
                        <img src="{{ asset('storage/' . $noticia->imagen) }}"
                             alt="Imagen de {{ $noticia->titulo }}"
                             class="w-full h-48 object-cover rounded-t-lg">
                    @endif
                    <div class="p-4">
                        <h5 class="text-lg font-semibold text-gray-800">
                            {{ Str::limit($noticia->titulo, 60) }}
                        </h5>
                        <p class="text-sm text-gray-500">
                            <strong>Autor:</strong> {{ $noticia->autor ?? 'Anónimo' }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $noticia->created_at->format('d/m/Y') }}</p>
                        <a href="{{ route('noticias.show', $noticia->id) }}"
                           class="inline-block mt-3 text-blue-600 hover:underline text-sm">
                            Ver detalle
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        @if ($noticias->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $noticias->appends(request()->except('page'))->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    @else
        <p class="text-gray-500">
            @if (request('busqueda'))
                No se encontraron noticias para tu búsqueda.
            @else
                No hay noticias registradas aún.
            @endif
        </p>
    @endif


</div>
@endsection
