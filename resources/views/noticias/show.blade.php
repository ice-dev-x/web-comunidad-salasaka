<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        @if($noticia->imagen)
        <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen de la noticia" style="max-width: 100%; height: auto;">
        @endif

        <h1>{{ $noticia->titulo }}</h1>
        <p><strong>Autor:</strong> {{ $noticia->autor ?? 'Anónimo' }}</p>
        <p><strong>Fecha:</strong> {{ $noticia->created_at->format('d/m/Y') }}</p>
        <hr>
        <p>{{ $noticia->contenido }}</p>

        <hr>

        {{-- Sección Comentarios --}}
        <h3>Comentarios</h3>

        @foreach($noticia->comentarios as $comentario)
            <div class="mb-3 p-3 border rounded">
                <strong>{{ $comentario->usuario->name }}</strong> dijo:
                <p>{{ $comentario->contenido }}</p>
                <small class="text-muted">{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
            </div>
        @endforeach

        {{-- Formulario para agregar comentario solo si está autenticado --}}
        @auth
            <form action="{{ route('comentarios.store', $noticia->id) }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <textarea name="contenido" rows="3" class="form-control" placeholder="Escribe tu comentario aquí" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Comentar</button>
            </form>
        @else
            <p><a href="{{ route('login') }}">Inicia sesión</a> para comentar.</p>
        @endauth

        <a href="{{ route('noticias.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</body>
</html>
