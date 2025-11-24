<<<<<<< HEAD
<!-- Meta Tags Básicos -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- CSRF Token (Laravel) -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Título y Descripción -->
<title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Inicio')</title>
<meta name="description" content="@yield('description', 'Descripción de tu aplicación Laravel')">
<meta name="keywords" content="@yield('keywords', 'laravel, tailwind, aplicación web')">
<meta name="author" content="Tu Nombre o Empresa">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('og_title', config('app.name'))">
<meta property="og:description" content="@yield('og_description', 'Descripción de tu aplicación')">
<meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:locale" content="{{ app()->getLocale() }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="@yield('twitter_title', config('app.name'))">
<meta name="twitter:description" content="@yield('twitter_description', 'Descripción de tu aplicación')">
<meta name="twitter:image" content="@yield('twitter_image', asset('images/twitter-image.jpg'))">
<meta name="twitter:creator" content="@tu_usuario">
<meta name="twitter:site" content="@tu_sitio">

<!-- Robots -->
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">

<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
<!-- Favicons -->
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">

<!-- PWA Meta Tags -->
<meta name="theme-color" content="#6366f1">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
<link rel="manifest" href="{{ asset('manifest.json') }}">

<!-- DNS Prefetch -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Fonts (Opcional) -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Tailwind CSS -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Estilos Adicionales -->
@stack('styles')

<!-- Scripts en Head (si es necesario) -->
@stack('head-scripts')
=======
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Percy Mamani - Abogado y Líder Social de Carabaya">
    <title>@yield('title', 'Percy Mamani - Candidato')</title>
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
>>>>>>> 869ef432ba127e564a03478072b13cea3e87aa74
