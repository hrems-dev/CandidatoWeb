<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 250);
            $table->text('descripcion');
            $table->string('slug', 250)->unique();
            $table->string('extracto', 500)->nullable();
            $table->timestamp('fecha_publicacion')->useCurrent();
            $table->unsignedBigInteger('vistas')->default(0);
            $table->unsignedBigInteger('me_gusta')->default(0);
            $table->unsignedBigInteger('compartidos')->default(0);
            $table->foreignId('info_candidato_id')->constrained('info_candidatos')->onDelete('cascade');
            $table->boolean('destacado')->default(false);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('info_candidato_id');
            $table->index('slug');
            $table->index('destacado');
            $table->index('estado');
            $table->index('fecha_publicacion');
            $table->index('vistas');
            $table->fullText(['titulo', 'descripcion', 'extracto']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
