<?php $__env->startSection('title', 'Dashboard · Sistema Consumo'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold"><span class="text-emerald-400">Sistema</span> <span class="text-amber-400">Consumo</span></h1>
<p class="mt-1 text-sm text-slate-400">Resumen de consumo real registrado. Tarifa $<?php echo e(number_format($rate, 2)); ?>/kWh.</p>

<div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <?php $__currentLoopData = [
        ['Consumo de hoy', $today['total'].' kWh', '$'.number_format($today['cost'], 2).' estimado'],
        ['Consumo del mes', $month['total'].' kWh', '$'.number_format($month['cost'], 2).' estimado'],
        ['Dispositivos', $devices->count(), $pluggedCount.' siempre enchufados'],
        ['Sin luz (mes)', $month['outageHours'].' h', 'descontadas del cálculo'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$t, $v, $s]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <article class="card">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400"><?php echo e($t); ?></p>
        <p class="mt-2 text-2xl font-bold text-emerald-300"><?php echo e($v); ?></p>
        <p class="mt-1 text-xs text-slate-400"><?php echo e($s); ?></p>
    </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="mt-6 grid gap-4 lg:grid-cols-2">
    <section class="card">
        <h2 class="text-lg font-bold text-amber-400">Resumen de hoy</h2>
        <dl class="mt-3 divide-y divide-slate-800 text-sm">
            <?php $__currentLoopData = [
                'Consumo en uso' => $today['active'].' kWh',
                'Consumo fantasma (enchufado sin usar)' => $today['standby'].' kWh',
                'Horas de uso registradas' => $today['hours'].' h',
                'Registros capturados' => $today['records'],
                'Horas sin luz' => $today['outageHours'].' h',
                'Costo estimado' => '$'.number_format($today['cost'], 2),
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center justify-between gap-4 py-2">
                <dt class="text-slate-300"><?php echo e($k); ?></dt><dd class="font-semibold text-slate-50"><?php echo e($v); ?></dd>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </dl>
        <h3 class="mt-4 text-sm font-semibold text-slate-200">Mayor consumo hoy</h3>
        <?php $__empty_1 = true; $__currentLoopData = $today['ranking']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="mt-2 flex items-center justify-between text-sm">
                <span class="text-slate-300"><?php echo e($r['name']); ?> <span class="text-slate-500">· <?php echo e($r['hours']); ?> h</span></span>
                <span class="font-semibold text-amber-300"><?php echo e($r['kwh']); ?> kWh</span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="mt-2 text-sm text-slate-400">Aún no registras uso hoy. Ve a <a class="text-emerald-400 hover:underline" href="<?php echo e(route('consumo.index')); ?>">Consumo</a>.</p>
        <?php endif; ?>
    </section>

    <section class="card">
        <h2 class="text-lg font-bold text-amber-400">Resumen del mes</h2>
        <dl class="mt-3 divide-y divide-slate-800 text-sm">
            <?php $__currentLoopData = [
                'Consumo en uso' => $month['active'].' kWh',
                'Consumo fantasma' => $month['standby'].' kWh',
                'Promedio diario' => round($month['total'] / $month['days'], 3).' kWh',
                'Días considerados' => $month['days'],
                'Registros del mes' => $month['records'],
                'Costo estimado' => '$'.number_format($month['cost'], 2),
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center justify-between gap-4 py-2">
                <dt class="text-slate-300"><?php echo e($k); ?></dt><dd class="font-semibold text-slate-50"><?php echo e($v); ?></dd>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </dl>
        <h3 class="mt-4 text-sm font-semibold text-slate-200">Top 5 del mes</h3>
        <?php $__empty_1 = true; $__currentLoopData = $month['ranking']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="mt-2 flex items-center justify-between text-sm">
                <span class="text-slate-300"><?php echo e($r['name']); ?> <span class="text-slate-500">· <?php echo e($r['hours']); ?> h</span></span>
                <span class="font-semibold text-emerald-300"><?php echo e($r['kwh']); ?> kWh</span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="mt-2 text-sm text-slate-400">Sin registros este mes.</p>
        <?php endif; ?>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gamec\Desktop\sistema-consumo-laravel-v3\sistema-consumo\resources\views/dashboard/index.blade.php ENDPATH**/ ?>