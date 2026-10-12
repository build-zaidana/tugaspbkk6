<?php $__env->startSection('title', 'Rencana Proyek Akhir'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @media (prefers-reduced-motion: reduce) {
        .animate-floatIn {
            animation: none !important;
            opacity: 1 !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="relative min-h-screen overflow-hidden">

    <img src="<?php echo e(asset('images/bg-campus.png')); ?>" class="absolute inset-0 w-full h-full object-cover"></div>

    
    <div class="relative z-10 flex justify-center pt-32 px-6 pb-20">
        <div class="bg-white text-gray-900 rounded-5xl shadow-2xl max-w-2xl w-full p-10 opacity-0 animate-floatIn">

            <p class="text-sm text-gray-500 mb-2">Kelompok <?php echo e($anggota_kelompok ? count($anggota_kelompok) : ''); ?></p>

            <h1 class="font-serif text-3xl sm:text-4xl font-semibold mb-6">
                Rencana Proyek Tugas Akhir
            </h1>

            <div class="mb-4">
                <h2 class="font-semibold text-lg mb-1"><?php echo e($judul_ide); ?></h2>
                <p class="text-sm text-blue-800 mb-4">Sub-tema: <?php echo e($sub_tema); ?></p>
                <p class="text-gray-700 leading-relaxed">
                    <?php echo e($deskripsi); ?>

                </p>
            </div>

            <div class="mt-6">
                <h3 class="font-semibold text-sm mb-2">Anggota Kelompok</h3>
                <ul class="text-sm text-gray-700 list-disc list-inside space-y-1">
                    <?php $__currentLoopData = $anggota_kelompok; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anggota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($anggota); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <div class="flex justify-end mt-8">
                <a href="<?php echo e(route('about')); ?>"
                   class="inline-block bg-gray-900 text-white text-sm font-medium rounded-full px-6 py-3 hover:bg-gray-700 transition">
                    Lihat Selengkapnya
                </a>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\naaiy\Herd\test1\resources\views/project.blade.php ENDPATH**/ ?>