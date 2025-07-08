<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1>Editar Noticia</h1>

        <form action="{{ route('noticias.update', $noticia->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="{{ $noticia->titulo }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contenido</label>
                <textarea name="contenido" class="form-control" rows="5" required>{{ $noticia->contenido }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Autor</label>
                <input type="text" name="autor" class="form-control" value="{{ $noticia->autor }}">
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('noticias.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
