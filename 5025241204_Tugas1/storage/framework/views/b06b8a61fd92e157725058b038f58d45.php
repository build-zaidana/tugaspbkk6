<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'ITS Academic Profile'); ?></title>

    <!-- Tailwind CSS via CDN (Play CDN, no build step) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        serif: ['Libre Baskerville', 'ui-serif', 'Georgia', 'serif'],
                    },
                    keyframes: {
                        floatIn: {
                            '0%':   { opacity: 0, transform: 'translateY(40px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' },
                        },
                        typing: {
                            '0%':   { width: '0%', visibility: 'hidden' },
                            '100%': { width: '100%' },
                        },
                        blink: {
                            '50%':  { borderColor: 'transparent' },
                            '100%': { borderColor: 'white' },
                        },
                    },
                    animation: {
                        floatIn: 'floatIn 0.8s ease-out forwards',
                        typing: 'typing 2s steps(10), blink .7s infinite',
                    },
                },
            },
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Libre+Baskerville:wght@400;700&display=swap" rel="stylesheet">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<script>
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            header.classList.remove('bg-transparent');
            header.classList.add('bg-black');
        } else {
            header.classList.remove('bg-black');
            header.classList.add('bg-transparent');
        }
    });
</script>

<body class="bg-black text-white font-sans">
    
    <!-- Navbar -->
    <header id="site-header" class="fixed top-0 left-0 right-0 z-20 transition-colors duration-300 bg-transparent">
        <nav class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-8 py-4 sm:py-6">
            <a href="<?php echo e(route('home')); ?>" class="font-serif text-base sm:text-xl font-semibold text-white">
                ITS Academic Profile
            </a>
            <div class="flex items-center gap-3 sm:gap-10 text-xs sm:text-sm">
                <a href="<?php echo e(route('home')); ?>" class="hover:text-gray-300 transition <?php echo e(request()->routeIs('home') ? 'text-white' : 'text-gray-300'); ?>">Home</a>
                <a href="<?php echo e(route('about')); ?>" class="hover:text-gray-300 transition <?php echo e(request()->routeIs('about') ? 'text-white' : 'text-gray-300'); ?>">About</a>
                <a href="<?php echo e(route('project')); ?>" class="hover:text-gray-300 transition <?php echo e(request()->routeIs('project') ? 'text-white' : 'text-gray-300'); ?>">Project</a>
                <a href="<?php echo e(route('calculator')); ?>" class="hover:text-gray-300 transition <?php echo e(request()->routeIs('calculator') ? 'text-white' : 'text-gray-300'); ?>">Calculator</a>
            </div>
        </nav>
    </header>

    <!-- Page Content-->
    <main class="relative min-h-screen">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="relative z-20 bg-black px-8 py-6">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 text-sm text-gray-400">
            <p>&copy; ITS Academic Profile &mdash; PBKK A</p>
            <div class="text-left sm:text-right">
                <p class="text-white">Github</p>
                <p>5025241XXX@student.its.ac.id</p>
            </div>
        </div>
    </footer>

</body>
</html>


<?php /**PATH C:\Users\naaiy\Herd\test1\resources\views/layouts/app.blade.php ENDPATH**/ ?>