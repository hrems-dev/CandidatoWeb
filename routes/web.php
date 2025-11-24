<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

// ========================================
// 📌 RUTAS PÚBLICAS
// ========================================

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/candidato', function () {
    return view('candidato.index');
})->name('candidato.index');

// Noticias públicas
Route::get('/noticias', [\App\Http\Controllers\NoticiaPublicaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{slug}', [\App\Http\Controllers\NoticiaPublicaController::class, 'show'])->name('noticias.show');
Route::get('/noticias/buscar', [\App\Http\Controllers\NoticiaPublicaController::class, 'buscar'])->name('noticias.buscar');
Route::get('/noticias/tipo/{tipo}', [\App\Http\Controllers\NoticiaPublicaController::class, 'porTipo'])->name('noticias.porTipo');

// Comentarios públicos
Route::get('/comentarios', [\App\Http\Controllers\ComentarioPublicoController::class, 'index'])->name('comentarios.index');
Route::post('/comentarios', [\App\Http\Controllers\ComentarioPublicoController::class, 'store'])->name('comentarios.store');
Route::post('/comentarios/{id}/like', [\App\Http\Controllers\ComentarioPublicoController::class, 'like'])->name('comentarios.like');

// Citas públicas
Route::get('/citas', function () {
    return view('citas.index');
})->name('citas.index');
Route::post('/citas', [\App\Http\Controllers\CitaController::class, 'store'])->name('citas.store');

// Contacto público
Route::get('/contacto', function () {
    return view('contacto.index');
})->name('contacto.index');
Route::post('/contacto', [\App\Http\Controllers\ContactoController::class, 'store'])->name('contacto.store');

// ========================================
// 📌 RUTAS DE ADMINISTRACIÓN
// ========================================

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Gestión de Citas
    Route::get('/citas', function () {
        return view('admin.citas.index');
    })->name('admin.citas.index');

    Route::get('/citas/{id}', function ($id) {
        return view('admin.citas.show', ['id' => $id]);
    })->name('admin.citas.show');

    // Gestión de Noticias
    Route::get('/noticias', function () {
        return view('admin.noticias.index');
    })->name('admin.noticias.index');

    Route::get('/noticias/crear', function () {
        return view('admin.noticias.create');
    })->name('admin.noticias.create');

    Route::get('/noticias/{id}/editar', function ($id) {
        return view('admin.noticias.edit', ['id' => $id]);
    })->name('admin.noticias.edit');

    // Gestión de Comentarios
    Route::get('/comentarios', function () {
        return view('admin.comentarios.index');
    })->name('admin.comentarios.index');

    // Gestión de Contactos
    Route::get('/contactos', function () {
        return view('admin.contactos.index');
    })->name('admin.contactos.index');

});

// ========================================
// 📌 RUTAS DE USUARIO AUTENTICADO
// ========================================

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
