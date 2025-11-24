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
            $table->enum('estado', ['pendiente', 'aceptada', 'rechazada', 'completada', 'cancelada'])->default('pendiente');
            $table->text('motivo_rechazo')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('documento_identidad')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('estado');
            $table->index('tipo_consulta');
            $table->index('fecha_cita');
            $table->index('fecha_solicitud');
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
