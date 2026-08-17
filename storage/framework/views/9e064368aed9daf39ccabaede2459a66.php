<?php $__env->startSection('title', 'Iniciar sesión · Sistema Consumo'); ?>
<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-md">
    <h1 class="text-2xl font-bold">Iniciar sesión</h1>
    <form method="POST" action="<?php echo e(route('login')); ?>" class="card mt-4 space-y-4">
        <?php echo csrf_field(); ?>
        <div>
            <label class="label" for="email">Correo</label>
            <input class="input" id="email" name="email" type="email" required autocomplete="email" value="<?php echo e(old('email')); ?>">
        </div>
        <div>
            <label class="label" for="password">Contraseña</label>
            <input class="input" id="password" name="password" type="password" required autocomplete="current-password">
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-300">
            <input type="checkbox" name="remember" value="1"> Mantener sesión
        </label>
        <button class="btn btn-primary w-full">Entrar</button>
        <p class="text-center text-sm text-slate-400">
            ¿Sin cuenta? <a class="text-amber-400 hover:underline" href="<?php echo e(route('register')); ?>">Crear cuenta</a>
        </p>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gamec\Desktop\sistema-consumo-laravel-v3\sistema-consumo\resources\views/auth/login.blade.php ENDPATH**/ ?>