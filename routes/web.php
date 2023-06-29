<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\DeudorController;
use App\Http\Controllers\ComentarioActualizarDeudaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\EmojiConfigController;
use App\Http\Controllers\NoticiaUserController;
use App\Http\Controllers\PersonasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [NoticiaController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Sección Noticias
    Route::get('/dashboard/create', [NoticiaController::class, 'createPost'])->name('dashboard.create');
    Route::post('/dashboard/create', [NoticiaController::class, 'savePost'])->name('dashboard.save');
    Route::get('/dashboard/showAll', [NoticiaController::class, 'showAll'])->name('dashboard.showAll');
    Route::get('/dashboard/show/{noticia}', [NoticiaController::class, 'createComment'])->name('dashboard.createComment');
    Route::get('/dashboard/{noticia}', [NoticiaController::class, 'showComment'])->name('dashboard.showComment');
    Route::post('/dashboard/show', [NoticiaController::class, 'saveComment'])->name('dashboard.saveComment');

    //Arreglar la ruta de las reacciones
    //Route::post('/dashboard', [PostVoteController::class, 'store']);

    //Sección Deudores
    Route::get('/deudores', [DeudorController::class, 'index'])->name('deudores');
    Route::get('/deudores/show', [DeudorController::class, 'show'])->name('deudores.show');
    Route::get('/deudores/create', [DeudorController::class, 'create'])->name('deudores.create');
    Route::post('/deudores/create', [DeudorController::class, 'save'])->name('deudores.save');
    Route::delete('/deudores/{id}', [DeudorController::class, 'destroy'])->name('deudores.destroy');

    //Sección Deudas
    Route::get('/deudas', [ComentarioActualizarDeudaController::class, 'index'])->name('deudas');
    Route::get('/deudas/{id}', [ComentarioActualizarDeudaController::class, 'showComment'])->name('deudas.show');
    Route::get('/deudas/create/{id}', [ComentarioActualizarDeudaController::class, 'create'])->name('deudas.create');
    Route::post('/deudas/create', [ComentarioActualizarDeudaController::class, 'save'])->name('deudas.save');

    //Sección Pagos
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos');
    Route::get('/pagos/{id}', [PagoController::class, 'edit'])->name('pagos.edit');
    Route::patch('/pagos/{id}', [PagoController::class, 'update'])->name('pagos.update');
    Route::get('/pagos/show/{id}', [PagoController::class, 'showComment'])->name('pagos.showComment');
    Route::get('/pagos/create/{id}', [PagoController::class, 'create'])->name('pagos.create');
    Route::post('/pagos/create', [PagoController::class, 'save'])->name('pagos.save');

    //Sección Configuración
    Route::get('/configuracion', [EmojiConfigController::class, 'edit'])->name('configuracion.edit');
    Route::patch('/configuracion', [EmojiConfigController::class, 'update'])->name('configuracion.update');

    //Sección Personas
    Route::get('/personas', [PersonasController::class, 'index'])->name('personas');
    Route::get('/personas/show', [PersonasController::class, 'show'])->name('personas.show');

    //Perfiles de Personas
    Route::get('/personas/show/user/{id}', [PersonasController::class, 'showProfile'])->name('personas.showProfile');
    Route::get('/personas/showUser/{id}', [PersonasController::class, 'showUser'])->name('personas.showUser');
    Route::get('/personas/showPost/{id}', [PersonasController::class, 'showPost'])->name('personas.showPost');
    Route::get('/personas/showComment/{id}', [PersonasController::class, 'showComment'])->name('personas.showComment');
    Route::get('/personas/createComment/{id}', [PersonasController::class, 'createComment'])->name('personas.createComment');
    Route::post('/personas/createComment', [PersonasController::class, 'saveComment'])->name('personas.saveComment');
    Route::get('/personas/show/deudas/{id}', [PersonasController::class, 'deudas'])->name('personas.deudas');
    Route::get('/personas/showDeuda/{id}', [PersonasController::class, 'showDeuda'])->name('personas.showDeuda');
    Route::get('/personas/showComment/Deuda/{id}', [PersonasController::class, 'showCommentDeudas'])->name('personas.showCommentDeudas');
    Route::get('/personas/showCommentDeuda/{id}', [PersonasController::class, 'showCommentDeuda'])->name('personas.showCommentDeuda');

    //Sección noticias del usuario autenticado
    Route::get('/noticias', [NoticiaUserController::class, 'index'])->name('noticias');
    Route::get('/noticias/showPost', [NoticiaUserController::class,'showPost']);
});

require __DIR__.'/auth.php';
