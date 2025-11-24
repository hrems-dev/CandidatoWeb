<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ContactoController;

// API Routes - Públicas (sin autenticación)
Route::prefix('api/v1')->group(function () {

    // ========================================
    // 📌 NOTICIAS - API
    // ========================================
    Route::get('/noticias', [\App\Http\Controllers\NoticiaController::class, 'index']);
    Route::get('/noticias/{id}', [\App\Http\Controllers\NoticiaController::class, 'show']);

    // ========================================
    // 📌 CITAS - API
    // ========================================
    Route::post('/citas', [CitaController::class, 'store']); // Crear nueva cita
    Route::get('/citas', [CitaController::class, 'index']);  // Listar citas públicas
    Route::get('/citas/{id}', [CitaController::class, 'show']); // Ver detalle de cita

    // ========================================
    // 📌 CONTACTOS - API
    // ========================================
    Route::post('/contactos', [ContactoController::class, 'store']); // Enviar mensaje de contacto
    Route::get('/contactos', [ContactoController::class, 'index']);  // Listar mensajes (solo admin)

    // ========================================
    // 📌 COMENTARIOS - API
    // ========================================
    Route::get('/comentarios', [\App\Http\Controllers\ComentarioController::class, 'index']);
    Route::post('/comentarios', [\App\Http\Controllers\ComentarioController::class, 'store']);
    Route::get('/comentarios/{id}', [\App\Http\Controllers\ComentarioController::class, 'show']);
    Route::put('/comentarios/{id}', [\App\Http\Controllers\ComentarioController::class, 'update']);
    Route::delete('/comentarios/{id}', [\App\Http\Controllers\ComentarioController::class, 'destroy']);

    // ========================================
    // 📌 PUBLICACIONES - API
    // ========================================
    Route::get('/publicaciones', [\App\Http\Controllers\PublicacionController::class, 'index']);
    Route::get('/publicaciones/{id}', [\App\Http\Controllers\PublicacionController::class, 'show']);
    Route::post('/publicaciones', [\App\Http\Controllers\PublicacionController::class, 'store']);
    Route::put('/publicaciones/{id}', [\App\Http\Controllers\PublicacionController::class, 'update']);
    Route::delete('/publicaciones/{id}', [\App\Http\Controllers\PublicacionController::class, 'destroy']);

    // ========================================
    // 📌 CANDIDATOS - API
    // ========================================
    Route::get('/candidatos', [\App\Http\Controllers\CandidatoController::class, 'index']);
    Route::get('/candidatos/{id}', [\App\Http\Controllers\CandidatoController::class, 'show']);

    // ========================================
    // 📌 INFO CANDIDATOS - API
    // ========================================
    Route::get('/info-candidatos', [\App\Http\Controllers\InfoCandidatoController::class, 'index']);
    Route::get('/info-candidatos/{id}', [\App\Http\Controllers\InfoCandidatoController::class, 'show']);
    Route::post('/info-candidatos', [\App\Http\Controllers\InfoCandidatoController::class, 'store']);
    Route::put('/info-candidatos/{id}', [\App\Http\Controllers\InfoCandidatoController::class, 'update']);
    Route::delete('/info-candidatos/{id}', [\App\Http\Controllers\InfoCandidatoController::class, 'destroy']);
});

// API Routes - Protegidas (requieren autenticación)
Route::prefix('api/v1')->middleware(['auth:sanctum'])->group(function () {

    // ========================================
    // 📌 ADMIN - NOTICIAS
    // ========================================
    Route::post('/noticias', [\App\Http\Controllers\NoticiaController::class, 'store']);
    Route::put('/noticias/{id}', [\App\Http\Controllers\NoticiaController::class, 'update']);
    Route::delete('/noticias/{id}', [\App\Http\Controllers\NoticiaController::class, 'destroy']);

    // ========================================
    // 📌 ADMIN - CITAS
    // ========================================
    Route::put('/citas/{id}', [CitaController::class, 'update']);
    Route::delete('/citas/{id}', [CitaController::class, 'destroy']);
    Route::post('/citas/{id}/aceptar', [CitaController::class, 'aceptar']);
    Route::post('/citas/{id}/rechazar', [CitaController::class, 'rechazar']);

    // ========================================
    // 📌 ADMIN - CONTACTOS
    // ========================================
    Route::put('/contactos/{id}', [ContactoController::class, 'update']);
    Route::delete('/contactos/{id}', [ContactoController::class, 'destroy']);
    Route::post('/contactos/{id}/responder', [ContactoController::class, 'responder']);
});
