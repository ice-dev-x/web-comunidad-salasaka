@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Comentarios pendientes</h1>

    <a href="{{ route('admin.index') }}"
           class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
           ← Volver
        </a>

    @if($pendientes->isEmpty())
        <p class="text-gray-600">No hay comentarios en revisión.</p>
    @else
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-xs sm:text-sm">
                <thead class="bg-gray-100 sticky top-0">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Noticia</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Usuario</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Comentario</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600 w-40">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($pendientes as $c)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">
                                <a href="{{ route('noticias.show',$c->noticia_id) }}"
                                   class="text-blue-600 hover:underline">
                                    #{{ $c->noticia_id }}
                                </a>
                            </td>
                            <td class="px-4 py-2">{{ $c->usuario->name }}</td>
                            <td class="px-4 py-2">{{ Str::limit($c->contenido, 60) }}</td>
                            <td class="px-4 py-2">
                                <div class="flex gap-2">
                                    {{-- Aprobar --}}
                                    <form action="{{ route('admin.comentarios.aprobar',$c->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button
                                            class="px-2 sm:px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-[11px] sm:text-xs">
                                            Aprobar
                                        </button>
                                    </form>

                                    {{-- Rechazar --}}
                                    <form action="{{ route('admin.comentarios.rechazar',$c->id) }}" method="POST"
                                          onsubmit="return confirm('¿Rechazar este comentario?');">
                                        @csrf @method('PUT')
                                        <button
                                            class="px-2 sm:px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-[11px] sm:text-xs">
                                            Rechazar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if ($pendientes->hasPages())
            <div class="mt-4">
                {{ $pendientes->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    @endif
</div>
@endsection
