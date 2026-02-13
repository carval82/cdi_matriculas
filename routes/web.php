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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('grupos', GrupoController::class);
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('acudientes', AcudienteController::class);
    Route::resource('matriculas', MatriculaController::class);
    Route::resource('pagos', PagoController::class);

    Route::resource('docentes', DocenteController::class);

    Route::get('/acudientes-buscar', [AcudienteController::class, 'buscar'])->name('acudientes.buscar');

    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
    Route::get('/asistencias/reporte', [AsistenciaController::class, 'reporte'])->name('asistencias.reporte');

    Route::get('/pagos/{pago}/recibo', [PagoController::class, 'recibo'])->name('pagos.recibo');

    Route::get('/establecimiento', [EstablecimientoController::class, 'edit'])->name('establecimiento.edit');
    Route::put('/establecimiento', [EstablecimientoController::class, 'update'])->name('establecimiento.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/acerca', function () {
        return view('acerca');
    })->name('acerca');
});

require __DIR__.'/auth.php';
