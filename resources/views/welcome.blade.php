<!DOCTYPE html>
<html lang="es-PE">

<head>
    @include("/include/head")
</head>

<body>
    <!-- Incluye la barra de navegación -->
    @include("/include/header")
    <!-- Contenido de la página -->
    @guest
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ url('/login') }}" class="btn btn-primary" role="button" aria-label="Abrir formulario de inicio de sesión">
            Iniciar sesión
        </a>
    </div>
    
    @endguest
    <!--inicio de pagina-->
    @include("/content/info-inicio")
    <!--nosotros-->
    @include("/content/nosotros")

</body>

</html>
