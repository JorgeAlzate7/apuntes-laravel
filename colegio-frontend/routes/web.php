<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleClientController;
use App\Http\Controllers\TacherClientController;
use App\Http\Controllers\EstudentClientController;
use App\Http\Controllers\ModuleTeacherClientController;

Route::get('/', function () {
    return redirect()->route('modules.index');
});

// Módulos
Route::get('/modules', [ModuleClientController::class, 'index'])->name('modules.index');
Route::post('/modules', [ModuleClientController::class, 'store'])->name('modules.store');
Route::put('/modules/{id}', [ModuleClientController::class, 'update'])->name('modules.update');
Route::delete('/modules/{id}', [ModuleClientController::class, 'destroy'])->name('modules.destroy');

// Docentes
Route::get('/tachers', [TacherClientController::class, 'index'])->name('tachers.index');
Route::post('/tachers', [TacherClientController::class, 'store'])->name('tachers.store');
Route::put('/tachers/{id}', [TacherClientController::class, 'update'])->name('tachers.update');
Route::delete('/tachers/{id}', [TacherClientController::class, 'destroy'])->name('tachers.destroy');

// Estudiantes
Route::get('/estudents', [EstudentClientController::class, 'index'])->name('estudents.index');
Route::post('/estudents', [EstudentClientController::class, 'store'])->name('estudents.store');
Route::put('/estudents/{id}', [EstudentClientController::class, 'update'])->name('estudents.update');
Route::delete('/estudents/{id}', [EstudentClientController::class, 'destroy'])->name('estudents.destroy');

// Asignación Módulo - Docente
Route::get('/module-teachers', [ModuleTeacherClientController::class, 'index'])->name('module-teachers.index');
Route::post('/module-teachers', [ModuleTeacherClientController::class, 'store'])->name('module-teachers.store');
Route::delete('/module-teachers/{id}', [ModuleTeacherClientController::class, 'destroy'])->name('module-teachers.destroy');
