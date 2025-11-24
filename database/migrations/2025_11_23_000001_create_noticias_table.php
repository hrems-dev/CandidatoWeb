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
            $table->string('slug')->unique()->comment('URL amigable');
            $table->text('contenido');
            $table->text('resumen')->nullable()->comment('Extracto para listado público');
            $table->string('imagen')->nullable();
            $table->string('categoria')->nullable()->comment('Categoría de la noticia');
            $table->enum('tipo', ['noticia', 'actividad', 'evento'])->default('noticia');
            $table->enum('estado', ['borrador', 'publicado', 'archivado'])->default('borrador');
            $table->dateTime('fecha_publicacion')->nullable();
            $table->unsignedBigInteger('vistas')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('estado');
            $table->index('tipo');
            $table->index('slug');
            $table->index('categoria');
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
