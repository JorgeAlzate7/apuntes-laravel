<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estudent extends Model
{
    use HasFactory;

    // Nombre exacto de la tabla (se especifica porque el modelo está en singular)[cite: 3]
    protected $table = 'estudents';

    // Campos permitidos para asignación masiva según el MER[cite: 3]
    protected $fillable = [
        'module_id',        // Llave foránea que apunta a la tabla modules[cite: 3]
        'nombre',           // Nombre del estudiante[cite: 3]
        'apellidos',        // Apellidos del estudiante[cite: 3]
        'fecha_nacimiento', // Fecha de nacimiento del estudiante[cite: 3]
        'expediente',       // Ruta o referencia del expediente[cite: 3]
    ];

    // Un estudiante pertenece a un solo módulo (relación inversa de hasMany)[cite: 3]
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}