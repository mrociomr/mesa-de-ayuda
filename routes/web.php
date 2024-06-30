<?php

use App\Http\Controllers\AyudaLoginController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\KeysMensajeController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipoSolucionController;
use App\Http\Controllers\TipoProblemaController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\AyudaController;
use App\Http\Controllers\SolucionController;
use App\Http\Controllers\TokenMensajeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\ReporteController;

use App\Http\Controllers\VerificateController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    if (auth()->check()) {
        // El usuario está autenticado, redirige a la página deseada
        return redirect('/dashboard'); // Cambia '/dashboard' a la ruta que desees.
    } else {
        // El usuario no está autenticado, redirige al inicio de sesión
        return redirect()->route('login');
    }
});


Route::get('/dashboard', [ChartsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/template', function () {
    return Inertia::render('Template');
})->middleware(['auth', 'verified'])->name('template');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('/dependencia/{dependencia}', [DependenciaController::class, 'update'])->name('dependencia.update');
    Route::get('/dependencia/{dependencia}/edit', [DependenciaController::class, 'edit'])->name('dependencia.edit');
    Route::resource('dependencia', DependenciaController::class);

    Route::put('/incidencia/{incidencia}', [IncidenciaController::class, 'update'])->name('incidencia.update');
    Route::get('/incidencia/{incidencia}/edit', [IncidenciaController::class, 'edit'])->name('incidencia.edit');
    Route::resource('incidencia', IncidenciaController::class);

    Route::resource('tipo-problema', TipoProblemaController::class);
    Route::resource('tipo-solucion', TipoSolucionController::class);
    Route::resource('sede', SedeController::class);

    Route::put('/oficina/{oficina}', [OficinaController::class, 'update'])->name('oficina.update');
    Route::get('/oficina/{oficina}/edit', [OficinaController::class, 'edit'])->name('oficina.edit');
    Route::resource('/oficina', OficinaController::class);

    Route::get('/solucion/create/{rowId}', [SolucionController::class, 'create'])->name('solucion.create');
    Route::post('/solucion', [SolucionController::class, 'store'])->name('solucion.store');
    Route::get('/solucion', [SolucionController::class, 'index'])->name('solucion.index');

    //Route::put('/token-mensaje/{token-mensaje}', [OficinaController::class, 'update'])->name('oficina.update');
    //Route::get('/token-mensaje/{token-mensaje}/edit', [OficinaController::class, 'edit'])->name('oficina.edit');
    Route::resource('/token-mensaje', TokenMensajeController::class);

    //Route::put('/key-mensaje/{key-mensaje}', [KeysMensajeController::class, 'update'])->name('key-mensaje.update');
    //Route::get('/key-mensaje/{key-mensaje}/edit', [KeysMensajeController::class, 'edit'])->name('key-mensaje.edit');
    Route::resource('/key-mensaje', KeysMensajeController::class);

    Route::resource('users', UserController::class);
    //  Route::resource('/charts', ChartsController::class);
    Route::get('/reporte/{year?}/{mes?}', [ReporteController::class, 'index'])->name('reporte.index');

  //  Route::resource('reporte', ReporteController::class);

    Route::resource('verificate', VerificateController::class);

    // Route::resource('/solucion', SolucionController::class);

});

Route::resource('mensaje', MensajeController::class);
// routes/api.php

Route::middleware(['auth:ayuda'])->group(function () {
    Route::get('/ayuda', [AyudaController::class, 'create'])->name('ayuda.create');
    Route::get('/mi-ticked/{id}', [AyudaController::class, 'miTicked'])->name('miTicked');
    Route::post('/ayuda', [AyudaController::class, 'store'])->name('ayuda.store');
});

Route::get('/loginAyuda', [AyudaLoginController::class, 'showLoginForm'])->name('ayuda.login');
Route::post('/loginAyuda', [AyudaLoginController::class, 'login']);




//    Route::get('/ayuda', [AyudaController::class, 'create'])->name('ayuda.create');
//    Route::post('/ayuda', [AyudaController::class, 'store'])->name('ayuda.store');

require __DIR__ . '/auth.php';
