<?php $__env->startSection('title', 'Registro de consumo · Sistema Consumo'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold">Consumo</h1>
<p class="mt-1 text-sm text-slate-400">Registra cuánto usaste cada dispositivo: por tiempo total o por ciclos de uso.</p>

<div class="mt-5 grid gap-5 lg:grid-cols-[400px_1fr]">
    <form method="POST" action="<?php echo e(route('consumo.store')); ?>" class="card space-y-4">
        <?php echo csrf_field(); ?>
        <h2 class="text-lg font-bold text-amber-400">Nuevo registro</h2>
        <div>
            <label class="label" for="device_id">Dispositivo</label>
            <select class="input" id="device_id" name="device_id" required>
                <option value="">Selecciona…</option>
                <?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($device->id); ?>"><?php echo e($device->name); ?> · <?php echo e(round($energy->deviceWatts($device))); ?> W</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="label" for="log_date">Fecha</label>
            <input class="input" id="log_date" name="log_date" type="date" required value="<?php echo e($date->format('Y-m-d')); ?>">
        </div>

        <fieldset class="space-y-2">
            <legend class="label">¿Cómo lo quieres registrar?</legend>
            <label class="flex items-center gap-2 text-sm">
                <input type="radio" name="mode" value="time" checked onchange="toggleMode('time')"> Tiempo de uso
            </label>
            <label class="flex items-center gap-2 text-sm">
                <input type="radio" name="mode" value="cycles" onchange="toggleMode('cycles')"> Ciclos de uso (veces × duración)
            </label>
        </fieldset>

        <div id="pane-time" class="space-y-2">
            <label class="label" for="minutes">Minutos de uso (sin límite)</label>
            <input class="input" id="minutes" name="minutes" type="number" min="1" step="1" placeholder="Ej. 90">
            <p class="text-xs text-slate-400">Desde 1 minuto hasta el tiempo total que lo usaste.</p>
        </div>

        <div id="pane-cycles" class="grid grid-cols-2 gap-2" style="display:none">
            <div>
                <label class="label" for="cycles">Ciclos (veces)</label>
                <input class="input" id="cycles" name="cycles" type="number" min="1" step="1" placeholder="Ej. 5">
            </div>
            <div>
                <label class="label" for="cycle_minutes">Minutos por ciclo</label>
                <input class="input" id="cycle_minutes" name="cycle_minutes" type="number" min="1" step="1" placeholder="Ej. 180">
            </div>
            <p class="col-span-2 text-xs text-slate-400">Ejemplo: 5 ciclos de 180 minutos = 15 horas de uso.</p>
        </div>

        <div>
            <label class="label" for="note">Nota (opcional)</label>
            <input class="input" id="note" name="note" maxlength="200">
        </div>
        <button class="btn btn-primary w-full">Guardar registro</button>
    </form>

    <div class="space-y-5">
        <section class="card">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-lg font-bold text-amber-400">Registros del <?php echo e($date->format('d/m/Y')); ?></h2>
                <form method="GET" class="flex gap-2">
                    <input class="input" type="date" name="date" value="<?php echo e($date->format('Y-m-d')); ?>">
                    <button class="btn btn-ghost">Ver</button>
                </form>
            </div>
            <div class="mt-3 overflow-x-auto">
                <table class="data">
                    <thead><tr><th>Dispositivo</th><th>Registro</th><th>Horas</th><th>kWh</th><th>Costo</th><th></th></tr></thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="font-semibold"><?php echo e(optional($log->device)->name ?? 'Dispositivo eliminado'); ?></td>
                            <td><?php echo e($log->mode === 'cycles' ? $log->cycles.' ciclos × '.$log->cycle_minutes.' min' : $log->minutes.' min'); ?></td>
                            <td><?php echo e(round($log->hours(), 2)); ?></td>
                            <td><?php echo e(round($log->kwh, 3)); ?></td>
                            <td>$<?php echo e(number_format($energy->cost($log->kwh), 2)); ?></td>
                            <td class="text-right">
                                <form method="POST" action="<?php echo e(route('consumo.destroy', $log)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-ghost">Quitar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="text-slate-400">Sin registros para esta fecha.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card">
            <h2 class="text-lg font-bold text-amber-400">Apagones</h2>
            <p class="mt-1 text-sm text-slate-300">
                <?php if($openOutage): ?>
                    Apagón en curso desde <?php echo e($openOutage->started_at->format('d/m/Y H:i')); ?>.
                <?php else: ?>
                    Sin apagón en curso.
                <?php endif; ?>
            </p>
            <form method="POST" action="<?php echo e(route('outage.toggle')); ?>" class="mt-3">
                <?php echo csrf_field(); ?>
                <button class="btn <?php echo e($openOutage ? 'btn-amber' : 'btn-ghost'); ?>">
                    <?php echo e($openOutage ? 'Ya regresó la luz (cerrar apagón)' : 'Activar interruptor de apagón'); ?>

                </button>
            </form>

            <form method="POST" action="<?php echo e(route('outage.store')); ?>" class="mt-4 grid gap-2 sm:grid-cols-3">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="label" for="started_at">Inicio</label>
                    <input class="input" id="started_at" name="started_at" type="datetime-local" required>
                </div>
                <div>
                    <label class="label" for="minutes_out">Duración (min)</label>
                    <input class="input" id="minutes_out" name="minutes" type="number" min="1" required>
                </div>
                <div class="flex items-end">
                    <button class="btn btn-ghost w-full">Registrar manual</button>
                </div>
            </form>

            <?php if($outages->count()): ?>
            <ul class="mt-4 space-y-1 text-sm text-slate-300">
                <?php $__currentLoopData = $outages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($o->started_at->format('d/m H:i')); ?> — <?php echo e($o->minutes ? $o->minutes.' min' : 'en curso'); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleMode(mode) {
    document.getElementById('pane-time').style.display = mode === 'time' ? 'block' : 'none';
    document.getElementById('pane-cycles').style.display = mode === 'cycles' ? 'grid' : 'none';
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gamec\Desktop\sistema-consumo-laravel-v3\sistema-consumo\resources\views/consumo/index.blade.php ENDPATH**/ ?>