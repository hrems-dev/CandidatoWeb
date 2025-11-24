<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('apellido', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
            $table->index('email');
            $table->index('estado');
            $table->fullText(['nombre', 'apellido']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
