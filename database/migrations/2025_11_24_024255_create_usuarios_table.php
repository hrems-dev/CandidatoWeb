<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_usuario', 100)->unique();
            $table->string('password');
            $table->string('email', 150)->unique()->nullable();
            $table->enum('rol', ['admin', 'candidato', 'usuario'])->default('usuario');
            $table->timestamp('ultimo_acceso')->nullable();
            $table->unsignedTinyInteger('intentos_fallidos')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre_usuario');
            $table->index('email');
            $table->index('rol');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
