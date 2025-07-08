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

        {{-- Aquí luego mostraremos la lista real --}}
        <p>¡Bienvenido al módulo de noticias de la Comunidad Salasaka!</p>

        <a href="{{ route('noticias.create') }}" class="btn btn-primary">Crear nueva noticia</a>
    </div>

</body>
</html>
