<?php
/**
 * @var array $programaciones
 * @var callable $url
 * @var callable $e
 */
?>

<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-secondary-emphasis mb-1">
            <i class="fa-solid fa-calendar-days text-warning me-2"></i>Programaciones de Prácticas
        </h2>
        <p class="text-muted mb-0">Listado de días programados por práctica</p>
    </div>
</div>

<?php if (empty($programaciones)): ?>
<div class="alert alert-info rounded-4">
    <i class="fa-solid fa-circle-info me-2"></i>No hay programaciones registradas.
</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-hover align-middle sipa-datatable" id="tbl-prog">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Práctica</th>
                <th>Día</th>
                <th>Ruta</th>
                <th>Fecha Salida</th>
                <th>Fecha Llegada</th>
                <th>Estudiantes</th>
                <th>Pernoctado</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($programaciones as $prog): ?>
            <tr>
                <td><small class="text-muted">#<?= $e($prog['codigo_prog']) ?></small></td>
                <td>
                    <div class="fw-semibold small"><?= $e($prog['practica_nombre'] ?? '') ?></div>
                    <small class="text-muted">Cod: <?= $e($prog['cod_practica']) ?></small>
                </td>
                <td><span class="badge bg-primary-subtle text-primary">Día <?= $e($prog['num_dias']) ?></span></td>
                <td>
                    <?php if (!empty($prog['origen'])): ?>
                        <small><?= $e($prog['origen']) ?> → <?= $e($prog['destino'] ?? '') ?></small>
                    <?php else: ?>
                        <small class="text-muted">—</small>
                    <?php endif; ?>
                </td>
                <td><?= $e($prog['fecha_salida'] ?? '') ?></td>
                <td><?= $e($prog['fecha_llegada'] ?? '—') ?></td>
                <td class="text-center"><span class="badge bg-info-subtle text-info"><?= $e($prog['num_estudiantes'] ?? '') ?></span></td>
                <td>
                    <span class="badge <?= ($prog['dias_pernoctados'] ?? 'No') === 'Si' ? 'bg-warning-subtle text-warning' : 'bg-secondary-subtle text-secondary' ?>">
                        <?= $e($prog['dias_pernoctados'] ?? 'No') ?>
                    </span>
                </td>
                <td><small><?= $e($prog['observaciones'] ?? '') ?></small></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
