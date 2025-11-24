<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->onDelete('cascade');
            $table->enum('tipo', ['cita', 'comentario', 'publicacion', 'sistema', 'recordatorio'])->default('sistema');
            $table->string('titulo', 250);
            $table->text('descripcion');
            $table->string('enlace', 500)->nullable();
            $table->boolean('leida')->default(false);
            $table->timestamp('fecha_notificacion')->useCurrent();
            $table->timestamp('fecha_leida')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('usuario_id');
            $table->index('tipo');
            $table->index('leida');
            $table->index('estado');
            $table->index('fecha_notificacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
