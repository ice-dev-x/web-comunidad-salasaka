<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1>{{ $noticia->titulo }}</h1>
        <p><strong>Autor:</strong> {{ $noticia->autor ?? 'Anónimo' }}</p>
        <p><strong>Fecha:</strong> {{ $noticia->created_at->format('d/m/Y') }}</p>
        <hr>
        <p>{{ $noticia->contenido }}</p>
        <a href="{{ route('noticias.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</body>
</html>
