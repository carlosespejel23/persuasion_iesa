<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NoticiaController;
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
    Route::get('/dashboard/edit/{noticia}', [NoticiaController::class, 'edit'])->name('dashboard.edit');
    Route::post('/dashboard/create', [NoticiaController::class, 'save'])->name('dashboard.save');
    Route::get('/dashboard/showAll', [NoticiaController::class, 'showAll'])->name('dashboard.showAll');
    Route::get('/dashboard/show/{noticia}', [NoticiaController::class, 'show'])->name('dashboard.show');
    Route::put('/dashboard/edit/{noticia}', [NoticiaController::class, 'update'])->name('dashboard.update');
    Route::delete('/dashboard/{noticia}/destroy', [NoticiaController::class, 'destroy'])->name('dashboard.destroy');
});

require __DIR__.'/auth.php';
