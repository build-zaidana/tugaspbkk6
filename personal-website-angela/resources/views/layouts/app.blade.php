<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Angela Vania Sugiyono — Portfolio')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Alpine.js dipakai khusus untuk toggle menu mobile — ringan, tanpa build step tambahan --}}
    <script defer src="https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans text-sm md:text-base">

    {{-- UC1.2: Navigasi ke tiap halaman --}}
    <header class="sticky top-0 z-50 px-3 pt-3 md:px-6 md:pt-4" x-data="{ open: false }">
        <nav class="window-card mx-auto max-w-6xl">
            <div class="window-titlebar">
                <span class="dot" style="background:#ff5f57"></span>
                <span class="dot" style="background:#febc2e"></span>
                <span class="dot" style="background:#28c840"></span>
                <span class="ml-auto text-[11px] font-tech text-brand-frame/80 tracking-wide">angela-vania.dev</span>
            </div>

            <div class="flex items-center justify-between gap-3 px-4 py-2.5 bg-brand-cream">
                <a href="{{ route('home') }}" class="font-script text-2xl text-brand-pink-dark leading-none">
                    Angela Vania S.
                </a>

                {{-- Menu desktop --}}
                <div class="hidden md:flex items-center gap-5 text-sm font-semibold text-brand-frame">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'is-active text-brand-pink-dark' : '' }}">Home</a>
                    <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.*') ? 'is-active text-brand-pink-dark' : '' }}">Projects</a>
                    <a href="{{ route('collection') }}" class="nav-link {{ request()->routeIs('collection') ? 'is-active text-brand-pink-dark' : '' }}">Collection</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'is-active text-brand-pink-dark' : '' }}">Contact</a>
                    <a href="{{ route('resume.download') }}"
                       class="px-3.5 py-1.5 rounded-full bg-brand-pink-dark text-white text-xs font-bold hover:bg-pink-800 transition-colors">
                        ⬇ Resume
                    </a>
                </div>

                {{-- Tombol hamburger, khusus mobile --}}
                <button @click="open = !open" class="md:hidden text-brand-frame" aria-label="Buka menu">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Menu mobile --}}
            <div x-show="open" x-transition x-cloak class="md:hidden flex flex-col gap-1 px-4 pb-3 bg-brand-cream text-sm font-semibold text-brand-frame border-t border-brand-frame/20">
                <a href="{{ route('home') }}" class="py-2 {{ request()->routeIs('home') ? 'text-brand-pink-dark' : '' }}">Home</a>
                <a href="{{ route('projects.index') }}" class="py-2 {{ request()->routeIs('projects.*') ? 'text-brand-pink-dark' : '' }}">Projects</a>
                <a href="{{ route('collection') }}" class="py-2 {{ request()->routeIs('collection') ? 'text-brand-pink-dark' : '' }}">Collection</a>
                <a href="{{ route('contact') }}" class="py-2 {{ request()->routeIs('contact') ? 'text-brand-pink-dark' : '' }}">Contact</a>
                <a href="{{ route('resume.download') }}" class="py-2 font-bold text-brand-pink-dark">⬇ Download Resume</a>
            </div>
        </nav>
    </header>

    <main class="px-3 md:px-6 py-8 max-w-6xl mx-auto">
        @yield('content')
    </main>

    <footer class="text-center text-xs text-white/80 py-8">
        © {{ date('Y') }} Angela Vania Sugiyono — dibangun dengan Laravel
    </footer>

</body>
</html>
