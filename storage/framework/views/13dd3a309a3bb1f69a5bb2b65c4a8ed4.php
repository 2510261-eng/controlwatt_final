<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Sistema Consumo'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'Sistema Consumo: controla y analiza el consumo de energía eléctrica de tu casa.'); ?>">
    <link rel="icon" href="<?php echo e(asset('favicon.svg')); ?>" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body class="min-h-dvh bg-[#0b1015] text-slate-100 antialiased">
<div class="min-h-dvh flex flex-col">
    <header class="border-b border-slate-800 bg-[#0e141b]/95 backdrop-blur sticky top-0 z-30">
        <div class="mx-auto max-w-6xl px-4 py-3 flex items-center justify-between gap-4">
            <a href="<?php echo e(auth()->check() ? route('dashboard') : route('home')); ?>" class="text-lg font-extrabold tracking-tight">
                <span class="text-emerald-400">Sistema</span><span class="text-amber-400">Consumo</span>
            </a>
            <?php if(auth()->guard()->check()): ?>
            <nav class="hidden md:flex items-center gap-1 text-sm">
                <?php $__currentLoopData = [
                    'dashboard' => 'Dashboard',
                    'consumo.index' => 'Consumo',
                    'devices.index' => 'Dispositivos',
                    'reports.index' => 'Reportes',
                    'groups.index' => 'Compartir',
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route($route)); ?>"
                       class="px-3 py-2 rounded-md font-medium transition <?php echo e(request()->routeIs($route) ? 'bg-emerald-500/15 text-emerald-300' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>"><?php echo e($label); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="rounded-md border border-slate-700 px-3 py-2 text-sm font-medium text-slate-200 hover:bg-slate-800">Salir</button>
            </form>
            <?php else: ?>
            <div class="flex gap-2 text-sm">
                <a href="<?php echo e(route('login')); ?>" class="rounded-md px-3 py-2 font-medium text-slate-200 hover:bg-slate-800">Entrar</a>
                <a href="<?php echo e(route('register')); ?>" class="rounded-md bg-amber-500 px-3 py-2 font-semibold text-slate-950 hover:bg-amber-400">Crear cuenta</a>
            </div>
            <?php endif; ?>
        </div>
        <?php if(auth()->guard()->check()): ?>
        <nav class="md:hidden overflow-x-auto border-t border-slate-800 px-3 py-2 flex gap-1 text-sm">
            <?php $__currentLoopData = [
                'dashboard' => 'Dashboard',
                'consumo.index' => 'Consumo',
                'devices.index' => 'Dispositivos',
                'reports.index' => 'Reportes',
                'groups.index' => 'Compartir',
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route($route)); ?>"
                   class="whitespace-nowrap rounded-md px-3 py-2 font-medium <?php echo e(request()->routeIs($route) ? 'bg-emerald-500/15 text-emerald-300' : 'text-slate-300'); ?>"><?php echo e($label); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>
        <?php endif; ?>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-6">
        <?php if(session('status')): ?>
            <div class="mb-4 rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200"><?php echo e(session('status')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="mb-4 rounded-lg border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                <ul class="list-disc pl-5 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="border-t border-slate-800 px-4 py-6 text-center text-xs text-slate-400">
        Sistema Consumo · Tarifa configurada: $<?php echo e(number_format(config('energy.rate'), 2)); ?> por kWh
    </footer>
</div>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Omar\Desktop\control-watt.i\sistema-consumo-laravel-v3\sistema-consumo\resources\views/layouts/app.blade.php ENDPATH**/ ?>