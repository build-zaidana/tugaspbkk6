<!DOCTYPE html>

<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
        @vite('resources/css/academic-lab.css')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="lab-site">
        <nav class="navbar navbar-expand-sm navbar-dark lab-nav">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}"><x-application-logo style="width: 34px; height: 34px" /> Academic Lab<span class="visually-hidden"> — Portal Akademik ITS</span></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Buka navigasi">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMenu">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link px-2" href="/">Home</a>
                        <a class="nav-link px-2" href="/about">About</a>
                        <a class="nav-link px-2" href="/project-idea">Project</a>
                        <a class="nav-link px-2" href="/hitung/10/5/kali">Kalkulator</a>
                        @auth
                            <a class="nav-link px-2" href="{{ route('dashboard') }}">Dashboard</a>
                        @else
                            <a class="nav-link px-2" href="{{ route('login') }}">Login</a>
                            <a class="nav-link px-2" href="{{ route('register') }}">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="container lab-main">
            @yield('content')
        </main>
        <footer class="lab-footer"><div class="container">Academic Lab &middot; Portofolio akademik &amp; eksplorasi Agentic AI</div></footer>

    </body>
</html>

