{{-- resources/views/movies/index.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Películas</title>
</head>
<body>
    <h1>Listado de Películas</h1>
    
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Director</th>
                <th>Año</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movies as $movie)
                <tr>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->director }}</td>
                    <td>{{ $movie->year }}</td>
                    <td>{{ $movie->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
