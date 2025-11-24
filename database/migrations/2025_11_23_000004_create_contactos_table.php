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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('asunto');
            $table->text('mensaje');
            $table->enum('estado', ['nuevo', 'en_revision', 'respondido', 'archivado'])->default('nuevo');
            $table->text('respuesta_admin')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable()->comment('ID del admin que respondió');
            $table->dateTime('fecha_respuesta')->nullable();
            $table->dateTime('fecha_leida')->nullable()->comment('Fecha cuando el usuario leyó la respuesta');
            $table->timestamps();
            $table->softDeletes();

            $table->index('estado');
            $table->index('created_at');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
