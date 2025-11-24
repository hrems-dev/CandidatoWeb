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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->string('usuario')->nullable()->comment('Email del admin que realizó la acción');
            $table->string('tabla')->comment('Tabla afectada');
            $table->unsignedBigInteger('registro_id')->comment('ID del registro modificado');
            $table->enum('accion', ['crear', 'actualizar', 'eliminar', 'restaurar', 'aceptar', 'rechazar'])->comment('Tipo de acción');
            $table->json('datos_anterior')->nullable()->comment('Valores anteriores');
            $table->json('datos_nuevo')->nullable()->comment('Valores nuevos');
            $table->string('direccion_ip')->nullable();
            $table->string('navegador')->nullable();
            $table->timestamps();
            
            $table->index('tabla');
            $table->index('registro_id');
            $table->index('accion');
            $table->index('usuario');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
