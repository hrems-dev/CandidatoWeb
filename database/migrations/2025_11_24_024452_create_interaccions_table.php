<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interacciones', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_entidad', ['publicacion', 'candidato', 'pagina']);
            $table->unsignedBigInteger('entidad_id')->nullable();
            $table->enum('tipo_accion', ['vista', 'click', 'me_gusta', 'compartir', 'descarga']);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('fecha_interaccion')->useCurrent();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('tipo_entidad');
            $table->index('entidad_id');
            $table->index('tipo_accion');
            $table->index('fecha_interaccion');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interacciones');
    }
};
