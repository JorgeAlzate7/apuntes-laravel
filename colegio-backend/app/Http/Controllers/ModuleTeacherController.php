<?php

namespace App\Http\Controllers;

use App\Models\ModuleTeacher;
use Illuminate\Http\Request;

class ModuleTeacherController extends Controller
{
    // LISTAR (GET /api/module-teachers): Devuelve todas las asignaciones con su módulo y docente (belongsTo)
    public function index()
    {
        $assignments = ModuleTeacher::with(['module', 'tacher'])->get();
        return response()->json($assignments, 200);
    }

    // CREAR (POST /api/module-teachers): Vincula un módulo (module_id) con un docente (teacher_id)
    public function store(Request $request)
    {
        // Valida que ambos IDs existan en sus respectivas tablas
        $validated = $request->validate([
            'module_id'  => 'required|exists:modules,id',
            'teacher_id' => 'required|exists:tachers,id',
        ]);

        $assignment = ModuleTeacher::create($validated);
        return response()->json($assignment->load(['module', 'tacher']), 201);
    }

    // MOSTRAR UNO (GET /api/module-teachers/{moduleTeacher}): Devuelve una asignación específica
    public function show(ModuleTeacher $moduleTeacher)
    {
        return response()->json($moduleTeacher->load(['module', 'tacher']), 200);
    }

    // ACTUALIZAR (PUT/PATCH /api/module-teachers/{moduleTeacher}): Cambia el módulo o el docente asignado
    public function update(Request $request, ModuleTeacher $moduleTeacher)
    {
        $validated = $request->validate([
            'module_id'  => 'sometimes|exists:modules,id',
            'teacher_id' => 'sometimes|exists:tachers,id',
        ]);

        $moduleTeacher->update($validated);
        return response()->json($moduleTeacher->load(['module', 'tacher']), 200);
    }

    // ELIMINAR (DELETE /api/module-teachers/{moduleTeacher}): Quita la asignación de la tabla intermedia
    public function destroy(ModuleTeacher $moduleTeacher)
    {
        $moduleTeacher->delete();
        return response()->json(['message' => 'Asignación eliminada correctamente'], 200);
    }
}