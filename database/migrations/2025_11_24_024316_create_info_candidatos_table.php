<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_candidatos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('profesion', 150);
            $table->string('correo', 150)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('direccion', 250)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('pais', 100)->default('Perú');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('num_colegiatura', 50)->nullable();
            $table->unsignedTinyInteger('anos_experiencia')->nullable();
            $table->text('biografia')->nullable();
            $table->string('foto_perfil', 500)->nullable();
            $table->string('linkedin', 250)->nullable();
            $table->string('sitio_web', 250)->nullable();
            $table->text('horario_atencion')->nullable()->comment('JSON: {dia: {inicio, fin}}');
            $table->decimal('tarifa_consulta', 10, 2)->nullable();
            $table->decimal('calificacion_promedio', 3, 2)->default(0.00);
            $table->unsignedBigInteger('total_consultas')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('usuario_id');
            $table->index('correo');
            $table->index('ciudad');
            $table->index('calificacion_promedio');
            $table->index('estado');
            $table->fullText(['nombre', 'apellido', 'profesion', 'biografia']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_candidatos');
    }
};
