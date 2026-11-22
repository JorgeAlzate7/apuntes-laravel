<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ModuleTeacherClientController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url');
    }

    // Lista asignaciones junto con módulos y docentes para los selects
    public function index()
    {
        $asignacionesRes = Http::get("{$this->baseUrl}/module-teachers");
        $modulesRes = Http::get("{$this->baseUrl}/modules");
        $tachersRes = Http::get("{$this->baseUrl}/tachers");

        return view('module_teachers.index', [
            'asignaciones' => $asignacionesRes->successful() ? $asignacionesRes->json() : [],
            'modules'      => $modulesRes->successful() ? $modulesRes->json() : [],
            'tachers'      => $tachersRes->successful() ? $tachersRes->json() : [],
        ]);
    }

    // Crea la asignación entre un módulo y un docente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id'  => 'required',
            'teacher_id' => 'required',
        ]);

        $response = Http::post("{$this->baseUrl}/module-teachers", $validated);

        if ($response->failed()) {
            return back()
                ->withInput()
                ->withErrors(['api' => 'Error al asignar docente: ' . $response->body()]);
        }

        return redirect()->route('module-teachers.index')->with('success', 'Docente asignado al módulo.');
    }

    // Elimina una asignación en el backend
    public function destroy(int $id)
    {
        $response = Http::delete("{$this->baseUrl}/module-teachers/{$id}");

        if ($response->failed()) {
            return back()->withErrors(['api' => 'Error al quitar asignación: ' . $response->body()]);
        }

        return redirect()->route('module-teachers.index')->with('success', 'Asignación eliminada.');
    }
}