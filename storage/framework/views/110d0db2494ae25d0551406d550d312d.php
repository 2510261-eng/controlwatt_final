<?php $__env->startSection('title', 'Reportes · Sistema Consumo'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-end justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold">Reportes</h1>
        <p class="mt-1 text-sm text-slate-400">Historial mensual. Los dispositivos eliminados conservan su consumo registrado.</p>
    </div>
    <form method="GET" class="flex flex-wrap items-end gap-2">
        <div>
            <label class="label" for="month">Mes</label>
            <input class="input" id="month" name="month" type="month" value="<?php echo e($month); ?>">
        </div>
        <button class="btn btn-ghost">Filtrar</button>
        <a class="btn btn-ghost" href="<?php echo e(route('reports.export', ['month' => $month])); ?>">Exportar CSV</a>
        <button type="button" class="btn btn-amber" onclick="document.getElementById('charts').showModal()">Ver gráficas</button>
    </form>
</div>

<div class="mt-5 grid gap-4 sm:grid-cols-3">
    <article class="card"><p class="text-xs uppercase text-slate-400">Consumo total</p><p class="mt-2 text-2xl font-bold text-emerald-300"><?php echo e($totalKwh); ?> kWh</p></article>
    <article class="card"><p class="text-xs uppercase text-slate-400">Costo estimado</p><p class="mt-2 text-2xl font-bold text-amber-300">$<?php echo e(number_format($totalCost, 2)); ?></p></article>
    <article class="card"><p class="text-xs uppercase text-slate-400">Dispositivos con registro</p><p class="mt-2 text-2xl font-bold text-slate-100"><?php echo e($rows->count()); ?></p></article>
</div>

<section class="card mt-5 overflow-x-auto">
    <table class="data">
        <thead><tr><th>Dispositivo</th><th>Potencia</th><th>Registros</th><th>Horas</th><th>kWh</th><th>Costo</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="font-semibold">
                    <?php echo e($row['name']); ?>

                    <?php if($row['deleted']): ?><span class="ml-1 rounded bg-slate-700 px-1.5 py-0.5 text-xs text-slate-200">eliminado</span><?php endif; ?>
                </td>
                <td><?php echo e(round($row['watts'], 2)); ?> W</td>
                <td><?php echo e($row['records']); ?></td>
                <td><?php echo e($row['hours']); ?></td>
                <td><?php echo e($row['kwh']); ?></td>
                <td>$<?php echo e(number_format($row['cost'], 2)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="text-slate-400">Sin registros en el periodo seleccionado.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</section>

<dialog id="charts" class="w-[min(95vw,900px)] rounded-xl border border-slate-700 bg-[#0e141b] p-5 text-slate-100 backdrop:bg-black/70">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-bold text-amber-400">Gráficas de consumo · <?php echo e($month); ?></h2>
        <button class="btn btn-ghost" onclick="document.getElementById('charts').close()">Cerrar</button>
    </div>
    <div class="mt-4 grid gap-6">
        <div><h3 class="text-sm font-semibold text-slate-300">kWh por día</h3><canvas id="chartDaily" height="140"></canvas></div>
        <div><h3 class="text-sm font-semibold text-slate-300">kWh por dispositivo</h3><canvas id="chartDevice" height="140"></canvas></div>
    </div>
</dialog>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" defer></script>
<script>
document.getElementById('charts').addEventListener('close', () => {});
window.addEventListener('load', () => {
    const base = { plugins: { legend: { display: false } }, scales: { x: { ticks: { color: '#cbd5e1' } }, y: { ticks: { color: '#cbd5e1' } } } };
    new Chart(document.getElementById('chartDaily'), {
        type: 'line',
        data: { labels: <?php echo json_encode($chartLabels, 15, 512) ?>, datasets: [{ data: <?php echo json_encode($chartValues, 15, 512) ?>, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,.25)', fill: true, tension: .3 }] },
        options: base
    });
    new Chart(document.getElementById('chartDevice'), {
        type: 'bar',
        data: { labels: <?php echo json_encode($deviceLabels, 15, 512) ?>, datasets: [{ data: <?php echo json_encode($deviceValues, 15, 512) ?>, backgroundColor: '#f59e0b' }] },
        options: base
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gamec\Desktop\sistema-consumo-laravel-v3\sistema-consumo\resources\views/reports/index.blade.php ENDPATH**/ ?>