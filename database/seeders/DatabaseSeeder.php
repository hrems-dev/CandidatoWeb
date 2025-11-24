<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Noticia;
use App\Models\Cita;
use App\Models\Contacto;
use App\Models\Comentario;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\InfoCandidato;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Crear usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Crear usuarios personalizados
        Usuario::create([
            'nombre_usuario' => 'juanperez',
            'password' => bcrypt('password123'),
            'email' => 'juan@candidatos.com',
            'rol' => 'candidato',
            'estado' => true,
        ]);

        Usuario::create([
            'nombre_usuario' => 'mariagarcia',
            'password' => bcrypt('password123'),
            'email' => 'maria@candidatos.com',
            'rol' => 'candidato',
            'estado' => true,
        ]);

        // Crear personas
        Persona::create([
            'nombre' => 'Carlos',
            'apellido' => 'López',
            'email' => 'carlos@example.com',
            'telefono' => '987654321',
            'estado' => true,
        ]);

        Persona::create([
            'nombre' => 'Ana',
            'apellido' => 'Martínez',
            'email' => 'ana@example.com',
            'telefono' => '987654322',
            'estado' => true,
        ]);

        // Crear candidatos
        $usuario1 = Usuario::first();
        InfoCandidato::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez García',
            'usuario_id' => $usuario1->id,
            'profesion' => 'Abogado Especialista en Derecho Laboral',
            'correo' => 'juan.perez@candidatos.com',
            'telefono' => '987654321',
            'celular' => '987654321',
            'direccion' => 'Calle Principal 123',
            'ciudad' => 'Lima',
            'pais' => 'Perú',
            'fecha_nacimiento' => '1985-05-15',
            'num_colegiatura' => 'CAL-12345',
            'anos_experiencia' => 15,
            'biografia' => 'Abogado con 15 años de experiencia en derecho laboral y administrativo.',
            'linkedin' => 'https://linkedin.com/in/juanperez',
            'sitio_web' => 'https://juanperez.com',
            'tarifa_consulta' => 150.00,
            'calificacion_promedio' => 4.8,
            'total_consultas' => 25,
            'estado' => true,
        ]);

        // Crear noticias
        for ($i = 1; $i <= 5; $i++) {
            Noticia::create([
                'titulo' => "Noticia Importante $i",
                'contenido' => "Este es el contenido de la noticia $i. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                'tipo' => collect(['noticia', 'actividad', 'evento'])->random(),
                'estado' => 'publicado',
                'fecha_publicacion' => now()->subDays($i),
                'vistas' => rand(50, 500),
            ]);
        }

        // Crear citas
        for ($i = 1; $i <= 3; $i++) {
            Cita::create([
                'nombre' => "Cliente $i",
                'email' => "cliente$i@example.com",
                'telefono' => '987654' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'tipo_consulta' => collect(['asesoría legal', 'trámite administrativo', 'defensa penal', 'derechos laborales', 'familia', 'otro'])->random(),
                'descripcion' => "Descripción de la consulta del cliente $i",
                'fecha_solicitud' => now()->subDays($i),
                'estado' => collect(['pendiente', 'aceptada'])->random(),
                'documento_identidad' => '12345678',
                'ubicacion' => 'Lima, Perú',
            ]);
        }

        // Crear contactos
        for ($i = 1; $i <= 3; $i++) {
            Contacto::create([
                'nombre' => "Persona de Contacto $i",
                'email' => "contacto$i@example.com",
                'telefono' => '987654' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'asunto' => "Asunto del mensaje $i",
                'mensaje' => "Este es el mensaje de contacto número $i",
                'estado' => 'nuevo',
            ]);
        }

        // Crear comentarios
        $persona = Persona::first();
        if ($persona) {
            for ($i = 1; $i <= 3; $i++) {
                Comentario::create([
                    'nombre' => "Comentarista $i",
                    'email' => "comentario$i@example.com",
                    'contenido' => "Este es un comentario de prueba número $i",
                    'calificacion' => rand(1, 5),
                    'estado' => 'aprobado',
                    'ubicacion' => 'Lima, Perú',
                ]);
            }
        }
    }
}
