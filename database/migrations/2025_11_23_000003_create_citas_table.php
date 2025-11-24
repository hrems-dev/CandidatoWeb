<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('telefono');
            $table->enum('tipo_consulta', [
                'asesoría legal',
                'trámite administrativo',
                'defensa penal',
                'derechos laborales',
                'familia',
                'otro'
            ]);
            $table->text('descripcion');
            $table->dateTime('fecha_solicitud');
            $table->dateTime('fecha_cita')->nullable();
            $table->time('hora_cita')->nullable();
            $table->enum('estado', ['pendiente', 'aceptada', 'rechazada', 'completada', 'cancelada', 'reprogramada'])->default('pendiente');
            $table->text('motivo_rechazo')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('documento_identidad')->nullable();
            $table->json('datos_reprogramacion')->nullable()->comment('Historial de reprogramaciones {fecha_anterior, hora_anterior}');
            $table->dateTime('fecha_respuesta_admin')->nullable()->comment('Fecha cuando el admin respondió');
            $table->timestamps();
            $table->softDeletes();

            $table->index('estado');
            $table->index('tipo_consulta');
            $table->index('fecha_cita');
            $table->index('fecha_solicitud');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
