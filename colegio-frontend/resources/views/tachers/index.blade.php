<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Docentes</title>
</head>
<body>
    <p>
        <a href="{{ route('modules.index') }}">Módulos</a> |
        <a href="{{ route('tachers.index') }}">Docentes</a> |
        <a href="{{ route('estudents.index') }}">Estudiantes</a> |
        <a href="{{ route('module-teachers.index') }}">Asignaciones</a>
    </p>

    <h1>Docentes</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <h3>Crear docente</h3>
    <form action="{{ route('tachers.store') }}" method="POST">
        @csrf
        <input type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" required>
        <input type="text" name="apellido" placeholder="Apellido" value="{{ old('apellido') }}" required>
        <input type="text" name="telefono" placeholder="Teléfono" value="{{ old('telefono') }}" required>
        <input type="text" name="cedula" placeholder="Cédula" value="{{ old('cedula') }}" required>
        <button type="submit">Guardar</button>
    </form>

    <hr>

    <h3>Listado de docentes</h3>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Editar datos</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tachers as $tacher)
                <tr>
                    <td>{{ $tacher['id'] }}</td>
                    <td>
                        <form action="{{ route('tachers.update', $tacher['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="text" name="nombre" value="{{ $tacher['nombre'] }}" required>
                            <input type="text" name="apellido" value="{{ $tacher['apellido'] }}" required>
                            <input type="text" name="telefono" value="{{ $tacher['telefono'] }}" required>
                            <input type="text" name="cedula" value="{{ $tacher['cedula'] }}" required>
                            <button type="submit">Actualizar</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('tachers.destroy', $tacher['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar docente?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No hay docentes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>