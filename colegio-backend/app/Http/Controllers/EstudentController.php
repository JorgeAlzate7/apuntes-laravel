<?php

namespace App\Http\Controllers;

use App\Models\Estudent;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary; // Herramienta para subir a Cloudinary
use Illuminate\Http\Request;

class EstudentController extends Controller
{
    // GET /api/estudents -> Lista todos los estudiantes con su módulo
    public function index()
    {
        $estudents = Estudent::with('module')->get();
        return response()->json($estudents, 200);
    }

    // POST /api/estudents -> Crea un estudiante y sube su 'expediente' a Cloudinary
    public function store(Request $request)
    {
        // Valida los datos y exige un archivo en 'expediente' (hasta 10 MB)
        $validated = $request->validate([
            'module_id'        => 'required|exists:modules,id',
            'nombre'           => 'required|string|max:255',
            'apellidos'        => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'expediente'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // Sube el archivo recibido a Cloudinary en la carpeta 'colegio/expedientes'
        $uploadedFile = Cloudinary::upload(
            $request->file('expediente')->getRealPath(),
            [
                'folder'        => 'colegio/expedientes',
                'resource_type' => 'auto',
            ]
        );

        // Guarda el estudiante en MySQL guardando la URL segura de Cloudinary en 'expediente'
        $estudent = Estudent::create([
            'module_id'        => $validated['module_id'],
            'nombre'           => $validated['nombre'],
            'apellidos'        => $validated['apellidos'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'expediente'       => $uploadedFile->getSecurePath(),
        ]);

        return response()->json($estudent->load('module'), 201);
    }

    // GET /api/estudents/{estudent} -> Muestra un estudiante y su módulo
    public function show(Estudent $estudent)
    {
        return response()->json($estudent->load('module'), 200);
    }

    // PUT/PATCH /api/estudents/{estudent} -> Actualiza estudiante (y sube nuevo expediente si llega)
    public function update(Request $request, Estudent $estudent)
    {
        $validated = $request->validate([
            'module_id'        => 'sometimes|exists:modules,id',
            'nombre'           => 'sometimes|string|max:255',
            'apellidos'        => 'sometimes|string|max:255',
            'fecha_nacimiento' => 'sometimes|date',
            'expediente'       => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // Toma solo los campos de texto/ID que llegaron
        $dataToUpdate = $request->only([
            'module_id',
            'nombre',
            'apellidos',
            'fecha_nacimiento',
        ]);

        // Si en esta actualización enviaron un archivo nuevo en 'expediente', lo sube a Cloudinary
        if ($request->hasFile('expediente')) {
            $uploadedFile = Cloudinary::upload(
                $request->file('expediente')->getRealPath(),
                [
                    'folder'        => 'colegio/expedientes',
                    'resource_type' => 'auto',
                ]
            );

            // Reemplaza 'expediente' por el nuevo link de Cloudinary
            $dataToUpdate['expediente'] = $uploadedFile->getSecurePath();
        }

        $estudent->update($dataToUpdate);

        return response()->json($estudent->load('module'), 200);
    }

    // DELETE /api/estudents/{estudent} -> Elimina un estudiante
    public function destroy(Estudent $estudent)
    {
        $estudent->delete();
        return response()->json(['message' => 'Estudiante eliminado correctamente'], 200);
    }
}