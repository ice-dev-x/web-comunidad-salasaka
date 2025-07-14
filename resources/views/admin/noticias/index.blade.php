@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 bg-gray-100">

    {{-- Encabezado --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Gestión de Noticias</h1>
    <p class="text-gray-600 mb-6">Panel de administración para gestionar noticias de la comunidad.</p>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Botones principales --}}
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('admin.index') }}"
           class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
           ← Volver
        </a>

        <a href="{{ route('admin.noticias.create') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Crear nueva noticia
        </a>
    </div>

    {{-- Tabla de noticias --}}
    @if ($noticias->count())
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600">Imagen</th>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600">Título</th>
                        <!-- Autor y Categoría se ocultan en pantallas <640 px -->
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600 hidden sm:table-cell">Autor</th>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600 hidden sm:table-cell">Categoría</th>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600 whitespace-nowrap">Fecha</th>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($noticias as $noticia)
                        <tr>
                            <td class="px-3 sm:px-4 py-2">
                                @if($noticia->imagen)
                                    <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen"
                                         class="w-16 h-12 sm:w-20 sm:h-14 object-cover rounded">
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>

                            {{-- Título truncado a 60 caracteres --}}
                            <td class="px-3 sm:px-4 py-2">
                                {{ Str::limit($noticia->titulo, 60) }}
                            </td>

                            <td class="px-3 sm:px-4 py-2 hidden sm:table-cell">{{ $noticia->autor ?? 'Anónimo' }}</td>
                            <td class="px-3 sm:px-4 py-2 hidden sm:table-cell">{{ $noticia->categoria->nombre ?? 'N/D' }}</td>

                            <td class="px-3 sm:px-4 py-2 whitespace-nowrap">{{ $noticia->created_at->format('d/m/Y') }}</td>

                            {{-- Botones compactos en móvil --}}
                            <td class="px-3 sm:px-4 py-2">
                                <div class="flex flex-wrap gap-1 sm:gap-2">
                                    <a href="{{ route('noticias.show', $noticia->id) }}"
                                       class="bg-blue-500 text-white px-2 sm:px-3 py-1 rounded text-[11px] sm:text-xs">
                                        Ver
                                    </a>
                                    <a href="{{ route('admin.noticias.edit', $noticia->id) }}"
                                       class="bg-yellow-500 text-white px-2 sm:px-3 py-1 rounded text-[11px] sm:text-xs">
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.noticias.destroy', $noticia->id) }}" method="POST"
                                          class="inline" onsubmit="return confirm('¿Eliminar esta noticia?');">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-600 text-white px-2 sm:px-3 py-1 rounded text-[11px] sm:text-xs">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación (solo si hay varias páginas) --}}
        @if ($noticias->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $noticias->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    @else
        <p class="text-gray-500">No hay noticias registradas aún.</p>
    @endif
</div>
@endsection
