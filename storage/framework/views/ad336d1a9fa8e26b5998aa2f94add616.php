<?php $__env->startSection('title', 'Dispositivos · Sistema Consumo'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold">Dispositivos</h1>
<p class="mt-1 text-sm text-slate-400">Registra o elimina aparatos. El uso diario se captura en la sección Consumo.</p>

<div class="mt-5 grid gap-5 lg:grid-cols-[380px_1fr]">
    <form method="POST" action="<?php echo e(route('devices.store')); ?>" class="card space-y-4">
        <?php echo csrf_field(); ?>
        <h2 class="text-lg font-bold text-amber-400">Nuevo dispositivo</h2>
        <div>
            <label class="label" for="name">Nombre</label>
            <input class="input" id="name" name="name" required maxlength="60" value="<?php echo e(old('name')); ?>">
        </div>
        <div>
            <label class="label" for="brand">Marca / modelo (opcional)</label>
            <input class="input" id="brand" name="brand" maxlength="60" value="<?php echo e(old('brand')); ?>">
        </div>
        <div class="grid grid-cols-3 gap-2">
            <div>
                <label class="label" for="watts">Watts</label>
                <input class="input" id="watts" name="watts" type="number" step="0.01" min="0" value="<?php echo e(old('watts')); ?>">
            </div>
            <div>
                <label class="label" for="volts">Volts</label>
                <input class="input" id="volts" name="volts" type="number" step="0.01" min="0" value="<?php echo e(old('volts', 127)); ?>">
            </div>
            <div>
                <label class="label" for="amps">Amperes</label>
                <input class="input" id="amps" name="amps" type="number" step="0.01" min="0" value="<?php echo e(old('amps')); ?>">
            </div>
        </div>
        <p class="text-xs text-slate-400">Si no conoces los watts, captura volts y amperes: el sistema los calcula (W = V × A).</p>
        <?php if($groups->count()): ?>
        <div>
            <label class="label" for="group_id">Compartir con familia</label>
            <select class="input" id="group_id" name="group_id">
                <option value="">Dispositivo personal</option>
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($g->id); ?>"><?php echo e($g->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <?php endif; ?>
        <label class="flex items-start gap-2 text-sm text-slate-200">
            <input type="checkbox" name="always_plugged" value="1" class="mt-1">
            <span>Queda enchufado todo el día (consumo fantasma). El sistema estima automáticamente los watts en espera.</span>
        </label>
        <div>
            <label class="label" for="notes">Notas (opcional)</label>
            <textarea class="input" id="notes" name="notes" rows="2" maxlength="300"><?php echo e(old('notes')); ?></textarea>
        </div>
        <button class="btn btn-primary w-full">Registrar dispositivo</button>
    </form>

    <section class="card">
        <h2 class="text-lg font-bold text-amber-400">Registrados (<?php echo e($devices->count()); ?>)</h2>
        <div class="mt-3 overflow-x-auto">
            <table class="data">
                <thead>
                <tr><th>Dispositivo</th><th>Potencia</th><th>Fantasma</th><th>Pertenece a</th><th></th></tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <span class="font-semibold"><?php echo e($device->name); ?></span>
                            <?php if($device->brand): ?><span class="block text-xs text-slate-400"><?php echo e($device->brand); ?></span><?php endif; ?>
                        </td>
                        <td><?php echo e(round($energy->deviceWatts($device), 2)); ?> W</td>
                        <td>
                            <?php if($device->always_plugged): ?>
                                <span class="text-amber-300"><?php echo e(round($energy->estimateStandbyWatts($device), 2)); ?> W en espera</span>
                            <?php else: ?>
                                <span class="text-slate-500">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($device->group?->name ? 'Familia: '.$device->group->name : 'Dispositivo personal'); ?></td>
                        <td class="text-right">
                            <form method="POST" action="<?php echo e(route('devices.destroy', $device)); ?>"
                                  onsubmit="return confirm('¿Eliminar <?php echo e($device->name); ?>? Su historial se conserva en reportes.')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-ghost">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-slate-400">Todavía no hay dispositivos registrados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gamec\Desktop\sistema-consumo-laravel-v3\sistema-consumo\resources\views/devices/index.blade.php ENDPATH**/ ?>