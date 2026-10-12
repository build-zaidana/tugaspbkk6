<?php $__env->startSection('title', 'Profil Jurusan'); ?>

<?php $__env->startSection('content'); ?>
<section class="relative min-h-screen flex items-center overflow-hidden">

    <img src="<?php echo e(asset('images/bg-campus.png')); ?>" class="absolute inset-0 w-full h-full object-cover"></div>

    <div class="relative z-10 max-w-3xl mx-auto w-full px-8 pt-24 text-center">
        <h1 class="font-serif text-4xl sm:text-5xl font-semibold leading-tight mb-8">
            <?php echo e($nama_departemen); ?>

        </h1>

        <p class="text-gray-200 leading-relaxed mb-6">
            <?php echo e($deskripsi); ?>

        </p>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\naaiy\Herd\test1\resources\views/about.blade.php ENDPATH**/ ?>