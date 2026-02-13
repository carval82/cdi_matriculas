<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\AcudienteController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\EstablecimientoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ─── Solo Admin y Secretaria ───
    Route::middleware('role:admin,secretaria')->group(function () {
        Route::resource('grupos', GrupoController::class);
        Route::resource('acudientes', AcudienteController::class);
        Route::get('/acudientes-buscar', [AcudienteController::class, 'buscar'])->name('acudientes.buscar');
        Route::resource('matriculas', MatriculaController::class);
        Route::resource('pagos', PagoController::class);
        Route::get('/pagos/{pago}/recibo', [PagoController::class, 'recibo'])->name('pagos.recibo');
        Route::resource('docentes', DocenteController::class);
    });

    // ─── Solo Admin ───
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/establecimiento', [EstablecimientoController::class, 'edit'])->name('establecimiento.edit');
        Route::put('/establecimiento', [EstablecimientoController::class, 'update'])->name('establecimiento.update');
        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup', [BackupController::class, 'backup'])->name('backup.create');
        Route::post('/backup/restore', [BackupController::class, 'restore'])->name('backup.restore');
        Route::get('/backup/download/{filename}', [BackupController::class, 'download'])->name('backup.download');
        Route::delete('/backup/{filename}', [BackupController::class, 'destroy'])->name('backup.destroy');
    });

    // ─── Todos los autenticados (admin, secretaria, docente) ───
    Route::resource('estudiantes', EstudianteController::class);

    // ─── Asistencia (todos, pero filtrado por grupo en controller) ───
    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
    Route::get('/asistencias/reporte', [AsistenciaController::class, 'reporte'])->name('asistencias.reporte');

    // ─── Evaluaciones (todos, filtrado por grupo en controller) ───
    Route::get('/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');
    Route::post('/evaluaciones', [EvaluacionController::class, 'store'])->name('evaluaciones.store');
    Route::get('/evaluaciones/estudiante/{estudiante}', [EvaluacionController::class, 'estudiante'])->name('evaluaciones.estudiante');

    // Conceptos evaluativos (admin y docente)
    Route::get('/conceptos-evaluativos', [EvaluacionController::class, 'conceptos'])->name('conceptos.index');
    Route::post('/conceptos-evaluativos', [EvaluacionController::class, 'conceptoStore'])->name('conceptos.store');
    Route::put('/conceptos-evaluativos/{concepto}', [EvaluacionController::class, 'conceptoUpdate'])->name('conceptos.update');
    Route::delete('/conceptos-evaluativos/{concepto}', [EvaluacionController::class, 'conceptoDestroy'])->name('conceptos.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/acerca', function () {
        return view('acerca');
    })->name('acerca');
});

require __DIR__.'/auth.php';
