@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Comentarios pendientes</h1>

    @if($pendientes->isEmpty())
        <p class="text-gray-600">No hay comentarios en revisión.</p>
    @else
        <table class="w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Noticia</th>
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">Comentario</th>
                    <th class="px-4 py-2 w-32">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($pendientes as $c)
                <tr class="border-t">
                    <td class="px-4 py-2">
                        <a href="{{ route('noticias.show',$c->noticia_id) }}" class="text-blue-600 hover:underline">
                            #{{ $c->noticia_id }}
                        </a>
                    </td>
                    <td class="px-4 py-2">{{ $c->usuario->name }}</td>
                    <td class="px-4 py-2">{{ Str::limit($c->contenido, 60) }}</td>
                    <td class="px-4 py-2 flex gap-1">
                        <form action="{{ route('admin.comentarios.aprobar',$c->id) }}" method="POST">
                            @csrf @method('PUT')
                            <button class="px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700">
                                ✔️
                            </button>
                        </form>
                        <form action="{{ route('admin.comentarios.rechazar',$c->id) }}" method="POST"
                              onsubmit="return confirm('¿Rechazar comentario?')">
                            @csrf @method('PUT')
                            <button class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">
                                ✖️
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $pendientes->links() }}
        </div>
    @endif
</div>
@endsection
