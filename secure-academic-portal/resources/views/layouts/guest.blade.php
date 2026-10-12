<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/academic-lab.css', 'resources/js/app.js'])
    </head>
    <body class="lab-site font-sans antialiased">
        <div class="lab-auth">
            <aside class="lab-auth-story">
                <a href="{{ route('home') }}" class="lab-brand">
                    <x-application-logo class="w-10 h-10" /><span>Academic Lab</span>
                </a>
                <span class="lab-eyebrow">Belajar. Merancang. Berkembang.</span>
                <h1>Ide besar dimulai<br>dari ruang belajar.</h1>
                <p>Satu tempat untuk perjalanan akademikmu: profil, riwayat tugas, dan gagasan proyek Agentic AI.</p>
                <div class="lab-auth-note">Portal portofolio akademik &middot; PBKK</div>
            </aside>
            <main class="lab-auth-form"><div class="lab-auth-card">{{ $slot }}</div></main>
        </div>
    </body>
</html>
