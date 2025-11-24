<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentario_publicacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comentario_id')->constrained('comentarios')->onDelete('cascade');
            $table->foreignId('publicacion_id')->constrained('publicaciones')->onDelete('cascade');
            $table->timestamp('fecha_comentario')->useCurrent();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->unique(['comentario_id', 'publicacion_id'], 'unique_comentario_publicacion');
            $table->index('publicacion_id');
            $table->index('fecha_comentario');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentario_publicacion');
    }
};
