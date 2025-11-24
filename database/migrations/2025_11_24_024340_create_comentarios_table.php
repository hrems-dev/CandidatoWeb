<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('mensaje');
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->unsignedTinyInteger('calificacion')->nullable();
            $table->timestamp('fecha_comentario')->useCurrent();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('persona_id');
            $table->index('calificacion');
            $table->index('estado');
            $table->index('fecha_comentario');
            $table->fullText('mensaje');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
