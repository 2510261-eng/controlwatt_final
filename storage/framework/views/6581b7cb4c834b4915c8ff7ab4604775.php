<?php $__env->startSection('title', 'Crear cuenta · Sistema Consumo'); ?>
<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-md">
    <h1 class="text-2xl font-bold">Crear cuenta</h1>
    <form method="POST" action="<?php echo e(route('register')); ?>" class="card mt-4 space-y-4">
        <?php echo csrf_field(); ?>
        <div>
            <label class="label" for="name">Nombre</label>
            <input class="input" id="name" name="name" required minlength="3" maxlength="60" value="<?php echo e(old('name')); ?>">
            <p class="mt-1 text-xs text-slate-400">Solo letras, espacios, puntos y guiones.</p>
        </div>
        <div>
            <label class="label" for="email">Correo</label>
            <input class="input" id="email" name="email" type="email" required value="<?php echo e(old('email')); ?>">
        </div>
        <div>
            <label class="label" for="password">Contraseña</label>
            <input class="input" id="password" name="password" type="password" required minlength="8">
            <p class="mt-1 text-xs text-slate-400">Mínimo 8 caracteres, mayúscula, minúscula, número y símbolo.</p>
        </div>
        <div>
            <label class="label" for="password_confirmation">Confirmar contraseña</label>
            <input class="input" id="password_confirmation" name="password_confirmation" type="password" required>
        </div>
        <button class="btn btn-amber w-full">Registrarme</button>
        <p class="text-center text-sm text-slate-400">
            ¿Ya tienes cuenta? <a class="text-emerald-400 hover:underline" href="<?php echo e(route('login')); ?>">Entrar</a>
        </p>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gamec\Desktop\sistema-consumo-laravel-v3\sistema-consumo\resources\views/auth/register.blade.php ENDPATH**/ ?>