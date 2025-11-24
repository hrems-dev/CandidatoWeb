<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidato_especialidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('info_candidato_id')->constrained('info_candidatos')->onDelete('cascade');
            $table->foreignId('especialidad_id')->constrained('especialidades')->onDelete('cascade');
            $table->enum('nivel_experiencia', ['junior', 'intermedio', 'senior', 'experto'])->default('intermedio');
            $table->unsignedTinyInteger('anos_experiencia')->default(0);
            $table->text('certificaciones')->nullable()->comment('JSON array de certificaciones');
            $table->text('descripcion')->nullable()->comment('Descripción específica de su experiencia en esta especialidad');
            $table->boolean('es_principal')->default(false)->comment('Indica si es la especialidad principal del candidato');
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->unique(['info_candidato_id', 'especialidad_id'], 'unique_candidato_especialidad');
            $table->index('especialidad_id');
            $table->index('nivel_experiencia');
            $table->index('es_principal');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidato_especialidad');
    }
};
