<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    // GET /api/modules -> Lista todos los módulos con sus estudiantes y docentes
    public function index()
    {
        $modules = Module::with(['estudents', 'tachers'])->get();
        return response()->json($modules, 200);
    }

    // POST /api/modules -> Crea un nuevo módulo
    public function store(Request $request)
    {
        // Valida que 'codigo' sea obligatorio y único, y 'nombre' obligatorio
        $validated = $request->validate([
            'codigo' => 'required|string|max:100|unique:modules,codigo',
            'nombre' => 'required|string|max:255',
        ]);

        // Guarda el módulo y devuelve código 201 (creado)
        $module = Module::create($validated);
        return response()->json($module, 201);
    }

    // GET /api/modules/{module} -> Muestra un módulo por su ID
    public function show(Module $module)
    {
        $module->load(['estudents', 'tachers']);
        return response()->json($module, 200);
    }

    // PUT/PATCH /api/modules/{module} -> Actualiza un módulo existente
    public function update(Request $request, Module $module)
    {
        // 'sometimes' significa: valida solo si envían ese campo en la petición
        $validated = $request->validate([
            'codigo' => 'sometimes|string|max:100|unique:modules,codigo,' . $module->id,
            'nombre' => 'sometimes|string|max:255',
        ]);

        $module->update($validated);
        return response()->json($module, 200);
    }

    // DELETE /api/modules/{module} -> Elimina un módulo
    public function destroy(Module $module)
    {
        $module->delete();
        return response()->json(['message' => 'Módulo eliminado correctamente'], 200);
    }
}