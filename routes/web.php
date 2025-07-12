<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CategoriaAdminController;
use App\Http\Controllers\Admin\ComentarioAdminController;
/* ─────────────────  Página de bienvenida  ──────────────── */
Route::get('/', function () {
    return view('welcome');
});

/* ─────────────────  Dashboard de Breeze (requiere login) ─ */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* ─────────────────  Noticias y comentarios  ────────────── */
/* -> Todos los visitantes pueden ver noticias.
   -> Comentarios y perfil SÍ requieren login.               */
Route::resource('noticias', NoticiaController::class);

/* Perfil de usuario (solo logueados) */
Route::middleware('auth')->group(function () {

    Route::get('/profile',  [ProfileController::class, 'edit' ])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

    /* Comentarios (solo usuarios autenticados) */
    Route::post('/noticias/{noticia}/comentarios', [ComentarioController::class, 'store'])
          ->name('comentarios.store');
    
});

/* ─────────────────  Panel de administración  ───────────── */
/* -> Requiere estar autenticado Y rol admin                 */
Route::prefix('/admin')->name('admin.')->middleware(['auth','admin'])->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Categorías (CRUD)
    Route::resource('categorias', CategoriaAdminController::class);

    // Comentarios pendientes de aprobación
    Route::get('comentarios', [ComentarioAdminController::class,'index'])->name('comentarios.index');
    Route::put('comentarios/{comentario}/aprobar', [ComentarioAdminController::class,'aprobar'])->name('comentarios.aprobar');
    Route::put('comentarios/{comentario}/rechazar', [ComentarioAdminController::class,'rechazar'])->name('comentarios.rechazar');
       
});

/* ─────────────────  Rutas generadas por Breeze  ────────── */
require __DIR__.'/auth.php';
