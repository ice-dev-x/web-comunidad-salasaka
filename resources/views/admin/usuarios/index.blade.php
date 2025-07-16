@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 bg-gray-100">

    {{-- Encabezado --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Gestión de Usuarios</h1>
    <p class="text-gray-600 mb-6">Panel de administración para crear, editar o desactivar usuarios de la comunidad.</p>

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

        <a href="{{ route('admin.usuarios.create') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Nuevo usuario
        </a>
    </div>

    {{-- Filtros --}}
    <form method="GET" class="flex flex-wrap gap-3 bg-white p-4 rounded-lg shadow mb-6">
        <select name="rol" class="border rounded px-7 py-2">
            <option value=""> Rol </option>
            @foreach ([
                \App\Models\User::ROL_ADMIN   => 'Admin',
                \App\Models\User::ROL_EDITOR  => 'Editor',
                \App\Models\User::ROL_USUARIO => 'Usuario',
            ] as $clave => $texto)
                <option value="{{ $clave }}" @selected(request('rol') === $clave)>{{ $texto }}</option>
            @endforeach
        </select>

        <select name="activo" class="border rounded px-7 py-2">
            <option value=""> Estado </option>
            <option value="1" @selected(request('activo')==='1')>Activos</option>
            <option value="0" @selected(request('activo')==='0')>Inactivos</option>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Filtrar</button>
        <a href="{{ route('admin.usuarios.index') }}" class="underline text-sm self-center">Limpiar</a>
    </form>

    {{-- Tabla de usuarios --}}
    @if ($usuarios->count())
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600">#</th>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600">Nombre</th>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600">Email</th>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600">Rol</th>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600">Estado</th>
                        <th class="px-3 sm:px-4 py-3 text-left font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($usuarios as $u)
                        <tr>
                            <td class="px-3 sm:px-4 py-2">{{ $u->id }}</td>
                            <td class="px-3 sm:px-4 py-2">{{ $u->name }}</td>
                            <td class="px-3 sm:px-4 py-2">{{ $u->email }}</td>
                            <td class="px-3 sm:px-4 py-2 capitalize">{{ $u->rol }}</td>
                            <td class="px-3 sm:px-4 py-2">
                                <span class="px-2 py-0.5 rounded-full text-xs
                                    {{ $u->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $u->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            {{-- Botones compactos en móvil --}}
                            <td class="px-3 sm:px-4 py-2">
                                <div class="flex flex-wrap gap-1 sm:gap-2">
                                    <a href="{{ route('admin.usuarios.edit', $u) }}"
                                       class="bg-yellow-500 text-white px-2 sm:px-3 py-1 rounded text-[11px] sm:text-xs">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.usuarios.toggle', $u) }}" method="POST"
                                          class="inline"
                                          onsubmit="return confirm('¿Cambiar estado del usuario?');">
                                        @csrf @method('PATCH')
                                        <button class="bg-indigo-500 text-white px-2 sm:px-3 py-1 rounded text-[11px] sm:text-xs">
                                            {{ $u->activo ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.usuarios.destroy', $u) }}" method="POST"
                                          class="inline"
                                          onsubmit="return confirm('¿Eliminar este usuario?');">
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

        {{-- Paginación solo si hay varias páginas --}}
        @if ($usuarios->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $usuarios->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    @else
        <p class="text-gray-500">No hay usuarios registrados aún.</p>
    @endif
</div>
@endsection
