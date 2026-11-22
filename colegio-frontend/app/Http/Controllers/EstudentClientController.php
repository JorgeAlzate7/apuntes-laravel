<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EstudentClientController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url');
    }

    // Lista estudiantes y carga los módulos para el formulario
    public function index()
    {
        $estudentsRes = Http::get("{$this->baseUrl}/estudents");
        $modulesRes = Http::get("{$this->baseUrl}/modules");

        return view('estudents.index', [
            'estudents' => $estudentsRes->successful() ? $estudentsRes->json() : [],
            'modules'   => $modulesRes->successful() ? $modulesRes->json() : [],
        ]);
    }

    // Envía datos + archivo 'expediente' al backend (el backend sube a Cloudinary)
    public function store(Request $request)
    {
        $request->validate([
            'module_id'        => 'required',
            'nombre'           => 'required|string|max:255',
            'apellidos'        => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'expediente'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('expediente');

        $response = Http::attach(
            'expediente',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post("{$this->baseUrl}/estudents", [
            'module_id'        => $request->input('module_id'),
            'nombre'           => $request->input('nombre'),
            'apellidos'        => $request->input('apellidos'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
        ]);

        if ($response->failed()) {
            return back()
                ->withInput()
                ->withErrors(['api' => 'Error al crear estudiante: ' . $response->body()]);
        }

        return redirect()->route('estudents.index')->with('success', 'Estudiante creado y expediente subido.');
    }

    // Actualiza datos básicos de un estudiante en el backend
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'module_id'        => 'required',
            'nombre'           => 'required|string|max:255',
            'apellidos'        => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
        ]);

        $response = Http::put("{$this->baseUrl}/estudents/{$id}", $validated);

        if ($response->failed()) {
            return back()->withErrors(['api' => 'Error al actualizar estudiante: ' . $response->body()]);
        }

        return redirect()->route('estudents.index')->with('success', 'Estudiante actualizado correctamente.');
    }

    // Elimina un estudiante en el backend
    public function destroy(int $id)
    {
        $response = Http::delete("{$this->baseUrl}/estudents/{$id}");

        if ($response->failed()) {
            return back()->withErrors(['api' => 'Error al eliminar estudiante: ' . $response->body()]);
        }

        return redirect()->route('estudents.index')->with('success', 'Estudiante eliminado correctamente.');
    }
}