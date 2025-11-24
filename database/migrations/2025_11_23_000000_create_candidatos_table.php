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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('cargo');
            $table->text('biografia')->nullable();
            $table->string('foto')->nullable();
            $table->text('vision')->nullable();
            $table->text('mision')->nullable();
            $table->json('propuestas')->nullable();
            $table->json('estudios')->nullable();
            $table->json('experiencia')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};
