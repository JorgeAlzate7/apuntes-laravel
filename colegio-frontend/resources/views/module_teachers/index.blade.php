<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignación Módulos - Docentes</title>
</head>
<body>
    <p>
        <a href="{{ route('modules.index') }}">Módulos</a> |
        <a href="{{ route('tachers.index') }}">Docentes</a> |
        <a href="{{ route('estudents.index') }}">Estudiantes</a> |
        <a href="{{ route('module-teachers.index') }}">Asignaciones</a>
    </p>

    <h1>Asignación de Docentes a Módulos</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <h3>Asignar docente a módulo</h3>
    <form action="{{ route('module-teachers.store') }}" method="POST">
        @csrf
        <select name="module_id" required>
            <option value="">-- Selecciona módulo --</option>
            @foreach ($modules as $module)
                <option value="{{ $module['id'] }}">{{ $module['codigo'] }} - {{ $module['nombre'] }}</option>
            @endforeach
        </select>

        <select name="teacher_id" required>
            <option value="">-- Selecciona docente --</option>
            @foreach ($tachers as $tacher)
                <option value="{{ $tacher['id'] }}">{{ $tacher['nombre'] }} {{ $tacher['apellido'] }} ({{ $tacher['cedula'] }})</option>
            @endforeach
        </select>

        <button type="submit">Asignar</button>
    </form>

    <hr>

    <h3>Asignaciones actuales</h3>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Módulo ID</th>
                <th>Docente ID</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($asignaciones as $asig)
                <tr>
                    <td>{{ $asig['id'] }}</td>
                    <td>{{ $asig['module_id'] }}</td>
                    <td>{{ $asig['teacher_id'] }}</td>
                    <td>
                        <form action="{{ route('module-teachers.destroy', $asig['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Quitar asignación?')">Quitar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No hay asignaciones registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>