@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Crear Nuevo Usuario</h1>

        {{-- Mostrar errores --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nombre --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            {{-- Rol --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                <select name="rol"
                    class="w-full border border-gray-400 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @foreach ([
                        \App\Models\User::ROL_ADMIN   => 'Admin',
                        \App\Models\User::ROL_EDITOR  => 'Editor',
                        \App\Models\User::ROL_USUARIO => 'Usuario',
                    ] as $clave => $texto)
                        <option value="{{ $clave }}" @selected(old('rol') === $clave)>{{ $texto }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Contraseña --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password"
                    class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            {{-- Confirmar contraseña --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
                <input type="password" name="password_confirmation"
                    class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            {{-- Activo --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="activo" value="1" @checked(old('activo', true))>
                <span class="text-gray-700">Usuario activo</span>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.usuarios.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancelar</a>
                <button type="submit"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
