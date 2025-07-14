@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Editar Historia</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.historia.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
            <textarea id="contenido" name="contenido" rows="10" required
                      class="w-full border border-gray-400 bg-gray-50 rounded-md shadow focus:ring-blue-500 focus:border-blue-500">{!! old('contenido', $historia->contenido ?? '') !!}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Guardar cambios
            </button>
        </div>
    </form>
</div>

<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/36zv4ollhnu75iqqzyykhvx6ucuicltdx5byl2arz50s1i8j/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#contenido',
        menubar: false,
        plugins: 'lists link image table code',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code',
        height: 400,
    });
</script>
@endsection
