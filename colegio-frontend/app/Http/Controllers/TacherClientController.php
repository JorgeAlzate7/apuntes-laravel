<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TacherClientController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url');
    }

    // Lista todos los docentes desde el backend
    public function index()
    {
        $response = Http::get("{$this->baseUrl}/tachers");
        $tachers = $response->successful() ? $response->json() : [];

        return view('tachers.index', [
            'tachers' => $tachers,
        ]);
    }

    // Envía los datos de un nuevo docente al backend
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'cedula'   => 'required|string|max:50',
        ]);

        $response = Http::post("{$this->baseUrl}/tachers", $validated);

        if ($response->failed()) {
            return back()
                ->withInput()
                ->withErrors(['api' => 'Error al crear docente: ' . $response->body()]);
        }

        return redirect()->route('tachers.index')->with('success', 'Docente creado correctamente.');
    }

    // Actualiza un docente existente en el backend
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'cedula'   => 'required|string|max:50',
        ]);

        $response = Http::put("{$this->baseUrl}/tachers/{$id}", $validated);

        if ($response->failed()) {
            return back()->withErrors(['api' => 'Error al actualizar docente: ' . $response->body()]);
        }

        return redirect()->route('tachers.index')->with('success', 'Docente actualizado correctamente.');
    }

    // Elimina un docente en el backend
    public function destroy(int $id)
    {
        $response = Http::delete("{$this->baseUrl}/tachers/{$id}");

        if ($response->failed()) {
            return back()->withErrors(['api' => 'Error al eliminar docente: ' . $response->body()]);
        }

        return redirect()->route('tachers.index')->with('success', 'Docente eliminado correctamente.');
    }
}