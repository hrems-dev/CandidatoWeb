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
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->unique();
            $table->text('contenido');
            $table->string('imagen')->nullable();
            $table->enum('tipo', ['noticia', 'actividad', 'evento'])->default('noticia');
            $table->enum('estado', ['borrador', 'publicado', 'archivado'])->default('borrador');
            $table->dateTime('fecha_publicacion')->nullable();
            $table->integer('vistas')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('estado');
            $table->index('tipo');
            $table->index('fecha_publicacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
