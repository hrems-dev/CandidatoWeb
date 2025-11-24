<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Added this line

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('especialidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique();
            $table->text('descripcion')->nullable();
            $table->string('icono', 100)->nullable()->comment('Nombre del icono o clase CSS');
            $table->string('slug', 150)->unique();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('estado');
        });

        // Insertar especialidades iniciales
        DB::table('especialidades')->insert([
            ['nombre' => 'Derecho Civil', 'descripcion' => 'Contratos, propiedad, familia, sucesiones y responsabilidad civil', 'slug' => 'derecho-civil', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Penal', 'descripcion' => 'Defensa penal, delitos, procedimientos judiciales penales', 'slug' => 'derecho-penal', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Laboral', 'descripcion' => 'Relaciones laborales, despidos, beneficios sociales', 'slug' => 'derecho-laboral', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Corporativo', 'descripcion' => 'Constitución de empresas, fusiones, adquisiciones', 'slug' => 'derecho-corporativo', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Tributario', 'descripcion' => 'Impuestos, fiscalización, planificación tributaria', 'slug' => 'derecho-tributario', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho de Familia', 'descripcion' => 'Divorcio, alimentos, tenencia, adopción', 'slug' => 'derecho-familia', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Administrativo', 'descripcion' => 'Contrataciones del estado, procedimientos administrativos', 'slug' => 'derecho-administrativo', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Inmobiliario', 'descripcion' => 'Compraventa, arrendamiento, propiedad horizontal', 'slug' => 'derecho-inmobiliario', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Constitucional', 'descripcion' => 'Amparo, habeas corpus, derechos fundamentales', 'slug' => 'derecho-constitucional', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Comercial', 'descripcion' => 'Empresas, sociedades, comercio', 'slug' => 'derecho-comercial', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Propiedad Intelectual', 'descripcion' => 'Marcas, patentes, derechos de autor', 'slug' => 'propiedad-intelectual', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Ambiental', 'descripcion' => 'Protección ambiental, recursos naturales', 'slug' => 'derecho-ambiental', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('especialidades');
    }
};
