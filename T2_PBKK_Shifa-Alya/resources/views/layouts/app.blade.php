<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ITS Academic Profile')</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background-color: #ffffff;
            color: #212529;
        }

        .navbar-custom {
            background-color: #111111;
        }

        .navbar-brand {
            color: #ffffff !important;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .nav-link {
            color: #d9d9d9 !important;
            font-weight: 500;
            margin-left: 12px;
            transition: 0.2s;
        }

        .nav-link:hover {
            color: #ffffff !important;
        }

        .page-wrapper {
            min-height: calc(100vh - 120px);
        }

        .card {
            border: 1px solid #e5e5e5;
            border-radius: 14px;
        }

        .footer-custom {
            background-color: #111111;
            color: #ffffff;
            padding: 18px 0;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">

            <a class="navbar-brand" href="{{ route('home') }}">
                ITS Academic Profile
            </a>

            <div class="navbar-nav ms-auto">

                <a class="nav-link" href="{{ route('home') }}">
                    Home
                </a>

                <a class="nav-link"
                   href="{{ route('mahasiswa.profil', ['nrp' => '5025241176']) }}">
                    Mahasiswa
                </a>

                <a class="nav-link" href="{{ route('agent') }}">
                    Agentic AI
                </a>

                <a class="nav-link"
                   href="{{ route('ipk.hitung', ['ipk1' => '3.50', 'ipk2' => '3.80']) }}">
                    Hitung IPK
                </a>

            </div>

        </div>
    </nav>

    <!-- Isi halaman -->
    <main class="page-wrapper">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container text-center">
            <small>
                ITS Academic Profile — Teknik Informatika ITS
            </small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>

</body>
</html>