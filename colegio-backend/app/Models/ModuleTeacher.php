<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleTeacher extends Model
{
    use HasFactory;

    // Nombre exacto de la tabla intermedia en la base de datos[cite: 3]
    protected $table = 'module_teachers';

    // Llaves foráneas que relacionan un módulo con un docente[cite: 3]
    protected $fillable = [
        'module_id',  // FK hacia modules.id[cite: 3]
        'teacher_id', // FK hacia tachers.id[cite: 3]
    ];

    // Obtiene el módulo asociado a este registro[cite: 3]
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    // Obtiene el docente asociado a este registro (usa teacher_id como FK)[cite: 3]
    public function tacher(): BelongsTo
    {
        return $this->belongsTo(Tacher::class, 'teacher_id');
    }
}