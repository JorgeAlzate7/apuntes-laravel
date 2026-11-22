<?php

namespace App\Http\Controllers;

use App\Models\Tacher;
use Illuminate\Http\Request;

class TacherController extends Controller
{
    // GET /api/tachers -> Lista todos los docentes con sus módulos
    public function index()
    {
        $tachers = Tacher::with('modules')->get();
        return response()->json($tachers, 200);
    }

    // POST /api/tachers -> Crea un nuevo docente
    public function store(Request $request)
    {
        // 'cedula' debe ser única para no repetir docentes
        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'cedula'   => 'required|string|max:50|unique:tachers,cedula',
        ]);

        $tacher = Tacher::create($validated);
        return response()->json($tacher, 201);
    }

    // GET /api/tachers/{tacher} -> Muestra un docente por su ID
    public function show(Tacher $tacher)
    {
        return response()->json($tacher->load('modules'), 200);
    }

    // PUT/PATCH /api/tachers/{tacher} -> Actualiza los datos de un docente
    public function update(Request $request, Tacher $tacher)
    {
        $validated = $request->validate([
            'nombre'   => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'telefono' => 'sometimes|string|max:50',
            'cedula'   => 'sometimes|string|max:50|unique:tachers,cedula,' . $tacher->id,
        ]);

        $tacher->update($validated);
        return response()->json($tacher, 200);
    }

    // DELETE /api/tachers/{tacher} -> Elimina un docente
    public function destroy(Tacher $tacher)
    {
        $tacher->delete();
        return response()->json(['message' => 'Docente eliminado correctamente'], 200);
    }
}