<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserva_citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas')->onDelete('cascade');
            $table->foreignId('persona_id')->nullable()->constrained('personas')->onDelete('set null');
            $table->string('nombre_persona', 150);
            $table->string('email', 150)->nullable();
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->string('nro_celular', 20);
            $table->text('motivo_consulta')->nullable();
            $table->text('notas_adicionales')->nullable();
            $table->enum('tipo_consulta', ['presencial', 'virtual', 'telefonica'])->default('presencial');
            $table->decimal('costo', 10, 2)->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'completada', 'no_asistio'])->default('pendiente');
            $table->timestamp('fecha_confirmacion')->nullable();
            $table->timestamp('fecha_cancelacion')->nullable();
            $table->text('motivo_cancelacion')->nullable();
            $table->boolean('recordatorio_enviado')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('cita_id');
            $table->index('persona_id');
            $table->index('fecha_cita');
            $table->index('hora_cita');
            $table->index('estado');
            $table->index('tipo_consulta');
            $table->index('nro_celular');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva_citas');
    }
};
