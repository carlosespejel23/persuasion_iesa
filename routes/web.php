<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\DeudorController;
use App\Http\Controllers\ComentarioActualizarDeudaController;
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
    Route::get('/dashboard/create', [NoticiaController::class, 'create'])->name('dashboard.create');
    Route::post('/dashboard/create', [NoticiaController::class, 'save'])->name('dashboard.save');
    Route::get('/dashboard/showAll', [NoticiaController::class, 'showAll'])->name('dashboard.showAll');
    Route::get('/dashboard/show/{noticia}', [NoticiaController::class, 'showComment'])->name('dashboard.showComment');
    Route::post('/dashboard/show/{noticia}', [NoticiaController::class, 'saveComment'])->name('dashboard.saveComment');

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

});

require __DIR__.'/auth.php';
