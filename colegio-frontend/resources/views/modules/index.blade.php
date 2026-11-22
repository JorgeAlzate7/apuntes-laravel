<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulos - Colegio Frontend</title>
</head>
<body>
    <h1>Módulos</h1>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    {{-- Formulario para CREAR un módulo --}}
    <h3>Crear nuevo módulo</h3>
    <form action="{{ route('modules.store') }}" method="POST">
        @csrf
        <input type="text" name="codigo" placeholder="Código (ej. MOD-02)" value="{{ old('codigo') }}" required>
        <input type="text" name="nombre" placeholder="Nombre del módulo" value="{{ old('nombre') }}" required>
        <button type="submit">Guardar</button>
    </form>

    <hr>

    {{-- Listado de módulos con opción de EDITAR y ELIMINAR --}}
    <h3>Listado de módulos</h3>
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($modules as $module)
                <tr>
                    <td>{{ $module['id'] }}</td>
                    <td>
                        {{-- Formulario para EDITAR este módulo --}}
                        <form action="{{ route('modules.update', $module['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="text" name="codigo" value="{{ $module['codigo'] }}" required>
                            <input type="text" name="nombre" value="{{ $module['nombre'] }}" required>
                            <button type="submit">Actualizar</button>
                        </form>
                    </td>
                    <td>{{ $module['nombre'] }}</td>
                    <td>
                        {{-- Formulario para ELIMINAR este módulo --}}
                        <form action="{{ route('modules.destroy', $module['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este módulo?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay módulos registrados aún.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>