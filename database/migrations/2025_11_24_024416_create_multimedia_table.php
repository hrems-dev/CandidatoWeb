<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('multimedias', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['imagen', 'video', 'documento', 'audio'])->default('imagen');
            $table->string('nombre', 250);
            $table->string('direccion', 500);
            $table->unsignedBigInteger('tamanio')->nullable()->comment('Tamaño en bytes');
            $table->string('mime_type', 100)->nullable();
            $table->foreignId('publicacion_id')->constrained('publicaciones')->onDelete('cascade');
            $table->unsignedTinyInteger('orden')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('publicacion_id');
            $table->index('tipo');
            $table->index('orden');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('multimedias');
    }
};
