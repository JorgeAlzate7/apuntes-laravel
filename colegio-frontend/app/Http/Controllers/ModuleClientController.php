<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ModuleClientController extends Controller
{
    // URL base del backend (ej. http://colegio-backend.test/api)
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url');
    }

    // GET /modules -> Trae todos los módulos desde el backend y muestra la vista
    public function index()
    {
        $response = Http::get("{$this->baseUrl}/modules");

        // Si el backend respondió bien, sacamos el array JSON; si no, array vacío
        $modules = $response->successful() ? $response->json() : [];

        return view('modules.index', [
            'modules' => $modules,
        ]);
    }

    // POST /modules -> Envía los datos del formulario al backend para crear un módulo
    public function store(Request $request)
    {
        // Valida en el frontend antes de mandar al backend
        $validated = $request->validate([
            'codigo' => 'required|string|max:100',
            'nombre' => 'required|string|max:255',
        ]);

        // Envía la petición POST a http://colegio-backend.test/api/modules
        $response = Http::post("{$this->baseUrl}/modules", $validated);

        if ($response->failed()) {
            return back()
                ->withInput()
                ->withErrors(['api' => 'Error al crear módulo: ' . $response->body()]);
        }

        return redirect()->route('modules.index')->with('success', 'Módulo creado correctamente.');
    }

    // PUT /modules/{id} -> Envía los cambios al backend para actualizar un módulo
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:100',
            'nombre' => 'required|string|max:255',
        ]);

        // Envía PUT a http://colegio-backend.test/api/modules/{id}
        $response = Http::put("{$this->baseUrl}/modules/{$id}", $validated);

        if ($response->failed()) {
            return back()->withErrors(['api' => 'Error al actualizar módulo: ' . $response->body()]);
        }

        return redirect()->route('modules.index')->with('success', 'Módulo actualizado correctamente.');
    }

    // DELETE /modules/{id} -> Pide al backend que elimine el módulo
    public function destroy(int $id)
    {
        // Envía DELETE a http://colegio-backend.test/api/modules/{id}
        $response = Http::delete("{$this->baseUrl}/modules/{$id}");

        if ($response->failed()) {
            return back()->withErrors(['api' => 'Error al eliminar módulo: ' . $response->body()]);
        }

        return redirect()->route('modules.index')->with('success', 'Módulo eliminado correctamente.');
    }
}