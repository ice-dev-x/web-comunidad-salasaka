<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Noticias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <div class="container">
        <h1 class="mb-4">Listado de Noticias</h1>
         <p>¡Bienvenido al módulo de noticias de la Comunidad Salasaka!</p>


        {{-- Aquí luego mostraremos la lista real --}}
        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($noticias->isEmpty())
    <p>No hay noticias registradas.</p>
@else
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Fecha</th>
            
            <th>Acciones</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($noticias as $noticia)
            <tr class="align-middle">
                <td>
            @if($noticia->imagen)
                <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen de la noticia" width="100">
            @else
                Sin imagen
            @endif
                </td>
                <td>{{ $noticia->titulo }}</td>
                <td>{{ $noticia->autor ?? 'Anónimo' }}</td>
                <td>{{ $noticia->created_at->format('d/m/Y') }}</td>
                <!--<td>@if($noticia->imagen)<img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen" width="100">@endif </td>-->
                <td>
                    <div class="d-flex flex-wrap gap-1">
                    <a href="{{ route('noticias.show', $noticia->id) }}" class="btn btn-sm btn-info">Ver</a>
                    @auth
                    @if (Auth::user()->rol === 'admin')
                    <a href="{{ route('noticias.edit', $noticia->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('noticias.destroy', $noticia->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Estás seguro?')" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                    @endif
                @endauth
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endif
       
        @auth
    @if (Auth::user()->rol === 'admin')
        <a href="{{ route('noticias.create') }}" class="btn btn-primary">Crear nueva noticia</a>
    @endif
@endauth

    </div>
    
</body>
</html>
