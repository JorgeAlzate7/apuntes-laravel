<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes</title>
</head>
<body>
    <p>
        <a href="{{ route('modules.index') }}">Módulos</a> |
        <a href="{{ route('tachers.index') }}">Docentes</a> |
        <a href="{{ route('estudents.index') }}">Estudiantes</a> |
        <a href="{{ route('module-teachers.index') }}">Asignaciones</a>
    </p>

    <h1>Estudiantes</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <h3>Crear estudiante</h3>
    <form action="{{ route('estudents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <select name="module_id" required>
            <option value="">-- Selecciona módulo --</option>
            @foreach ($modules as $module)
                <option value="{{ $module['id'] }}">{{ $module['codigo'] }} - {{ $module['nombre'] }}</option>
            @endforeach
        </select>
        <input type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" required>
        <input type="text" name="apellidos" placeholder="Apellidos" value="{{ old('apellidos') }}" required>
        <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
        <input type="file" name="expediente" required>
        <button type="submit">Guardar y subir expediente</button>
    </form>

    <hr>

    <h3>Listado de estudiantes</h3>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Editar datos</th>
                <th>Expediente</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($estudents as $estudent)
                <tr>
                    <td>{{ $estudent['id'] }}</td>
                    <td>
                        <form action="{{ route('estudents.update', $estudent['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <select name="module_id" required>
                                @foreach ($modules as $module)
                                    <option value="{{ $module['id'] }}" {{ (string) $module['id'] === (string) $estudent['module_id'] ? 'selected' : '' }}>
                                        {{ $module['codigo'] }} - {{ $module['nombre'] }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" name="nombre" value="{{ $estudent['nombre'] }}" required>
                            <input type="text" name="apellidos" value="{{ $estudent['apellidos'] }}" required>
                            <input type="date" name="fecha_nacimiento" value="{{ $estudent['fecha_nacimiento'] }}" required>
                            <button type="submit">Actualizar</button>
                        </form>
                    </td>
                    <td>
                        @if (!empty($estudent['expediente']))
                            <a href="{{ $estudent['expediente'] }}" target="_blank">Ver archivo</a>
                        @else
                            Sin archivo
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('estudents.destroy', $estudent['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar estudiante?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No hay estudiantes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>