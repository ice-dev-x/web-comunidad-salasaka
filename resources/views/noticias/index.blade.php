<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Noticias</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-6">
    <div class="max-w-6xl mx-auto px-4">
        
        {{-- Título y formulario de búsqueda --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Noticias de la Comunidad Salasaka</h1>
        <p class="text-gray-600 mb-6">¡Bienvenido al módulo de noticias! Aquí encontrarás información actualizada sobre nuestra comunidad.</p>
        <div class="flex flex-wrap items-center gap-2 mb-4">
    {{-- Chip: Todas las categorías --}}
    <a href="{{ route('noticias.index', ['categoria' => '']) }}"
       class="px-3 py-1 rounded-full border text-sm
              {{ request('categoria') == '' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-blue-100' }}">
        Todas
    </a>

    {{-- Chips de cada categoría --}}
    @foreach ($categorias as $cat)
        <a href="{{ route('noticias.index', ['categoria' => $cat->id, 'busqueda' => request('busqueda')]) }}"
           class="px-3 py-1 rounded-full border text-sm
                  {{ request('categoria') == $cat->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-blue-100' }}">
            {{ $cat->nombre }}
        </a>
    @endforeach
</div>

        
        <form action="{{ route('noticias.index') }}" method="GET" class="mb-6 flex flex-col sm:flex-row sm:items-center sm:space-x-3 space-y-2 sm:space-y-0">
        {{-- Selector de categoría --}}
        <select name="categoria" class="p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
        <option value="">Todas las categorías</option>
        @foreach($categorias as $cat)
            <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                {{ $cat->nombre }}
            </option>
        @endforeach
    </select>
        {{-- Campo de búsqueda existente --}}    
        <input type="text" name="busqueda" value="{{ request('busqueda') }}"
                placeholder="Buscar noticias..."
                class="p-2 border border-gray-300 rounded-md w-full sm:w-64 focus:outline-none focus:ring focus:border-blue-300">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Buscar</button>
        </form>
        {{-- Mensaje de sesión --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Noticias en tarjetas --}}
        
@if ($noticias->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @foreach ($noticias as $noticia)
            <div class="bg-white rounded-lg shadow hover:shadow-md transition">
                @if($noticia->imagen)
                    <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen de la noticia" class="w-full h-48 object-cover rounded-t-lg">
                @endif
                <div class="p-4">
                    <h5 class="text-lg font-semibold text-gray-800">{{ $noticia->titulo }}</h5>
                    <p class="text-sm text-gray-500">
                        <strong>Autor:</strong> {{ $noticia->autor ?? 'Anónimo' }}
                    </p>
                    <p class="text-xs text-gray-400">{{ $noticia->created_at->format('d/m/Y') }}</p>
                    <a href="{{ route('noticias.show', $noticia->id) }}" class="inline-block mt-3 text-blue-600 hover:underline text-sm">Ver detalle</a>
                </div>
            </div>
        @endforeach
    </div>
    {{--Paginación--}}
<div class="mt-6 flex justify-center">
    {{ $noticias->appends(['busqueda' => request('busqueda')])->links('vendor.pagination.tailwind') }}
</div> {{--Cierre de Paginación--}}
@else
    @if (request('busqueda'))
        <p class="text-gray-500">No se encontraron noticias para esta búsqueda.</p>
    @else
        <p class="text-gray-500">No hay noticias registradas aún.</p>
    @endif
@endif


        {{-- Panel de administración --}}
        @auth
            @if (Auth::user()->rol === 'admin')
                <hr class="my-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Panel de administración</h2>

                <a href="{{ route('noticias.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition mb-4">
                    + Crear nueva noticia
                </a>

                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Imagen</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Título</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Autor</th>
                                {{-- NUEVA columna --}}
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Categoría</th>
                               

                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Fecha</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($noticias as $noticia)
                                <tr>
                                    <td class="px-4 py-2">
                                        @if($noticia->imagen)
                                            <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen" class="w-20 h-14 object-cover rounded">
                                        @else
                                            <span class="text-gray-400">Sin imagen</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ $noticia->titulo }}</td>
                                    <td class="px-4 py-2">{{ $noticia->autor ?? 'Anónimo' }}</td>
                                    {{-- NUEVA celda --}}
                                    <td class="px-4 py-2">{{ $noticia->categoria->nombre }}</td>
                                    <td class="px-4 py-2">{{ $noticia->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('noticias.show', $noticia->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">Ver</a>
                                            <a href="{{ route('noticias.edit', $noticia->id) }}" class="bg-yellow-400 text-white px-2 py-1 rounded text-xs hover:bg-yellow-500">Editar</a>
                                            <form action="{{ route('noticias.destroy', $noticia->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta noticia?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endauth

    </div>
</body>
</html>
