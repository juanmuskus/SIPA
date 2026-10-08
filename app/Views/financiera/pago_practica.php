<?php
/**
 * @var array $liquidaciones
 * @var callable $url
 * @var callable $e
 */
?>

<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-secondary-emphasis mb-1">
            <i class="fa-solid fa-money-bill-wave text-success me-2"></i>Liquidación de Prácticas
        </h2>
        <p class="text-muted mb-0">Viáticos y pagos a docentes por prácticas académicas</p>
    </div>
    <a href="<?= $url('/practicas/listarpractica') ?>" class="btn btn-outline-success rounded-pill">
        <i class="fa-solid fa-list-check me-1"></i>Ver Prácticas
    </a>
</div>

<?php if (empty($liquidaciones)): ?>
<div class="alert alert-info rounded-4">
    <i class="fa-solid fa-circle-info me-2"></i>No hay liquidaciones registradas aún.
</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-hover align-middle sipa-datatable" id="tbl-liquidaciones">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Práctica</th>
                <th>Docente</th>
                <th>Viáticos</th>
                <th>Aux. Estudiantes</th>
                <th>Transporte</th>
                <th>Total</th>
                <th>Estado</th>
                <th>F. Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($liquidaciones as $liq): ?>
            <tr>
                <td><small class="text-muted">#<?= $e($liq['id_liquidar']) ?></small></td>
                <td>
                    <div class="fw-semibold small"><?= $e($liq['practica_nombre'] ?? '') ?></div>
                    <small class="text-muted">Cod: <?= $e($liq['cod_practica']) ?></small>
                </td>
                <td><small><?= $e($liq['docente_nombre'] ?? 'N/A') ?></small></td>
                <td class="text-success fw-semibold">$<?= number_format((float)$liq['viaticos'], 0, ',', '.') ?></td>
                <td class="text-primary fw-semibold">$<?= number_format((float)$liq['aux_estudiante'], 0, ',', '.') ?></td>
                <td class="text-warning fw-semibold">$<?= number_format((float)$liq['transporte_especial'], 0, ',', '.') ?></td>
                <td class="fw-bold">$<?= number_format($liq['total'] ?? 0, 0, ',', '.') ?></td>
                <td>
                    <?php
                    $est = $liq['estado'] ?? 'Trámite';
                    $bc = match($est) { 'Pagado' => 'bg-success-subtle text-success', 'Trámite' => 'bg-warning-subtle text-warning', default => 'bg-secondary-subtle text-secondary' };
                    ?>
                    <span class="badge <?= $bc ?>"><?= $e($est) ?></span>
                </td>
                <td><small><?= $e($liq['fecha_pago'] ?? '—') ?></small></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?= $url('/liquidarpracticas/editarliquidacion?id=' . (int)$liq['id_liquidar']) ?>"
                           class="btn btn-sm btn-outline-primary rounded-pill" title="Editar">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <a href="<?= $url('/practicas/verliquidacion?id=' . (int)$liq['cod_practica']) ?>"
                           class="btn btn-sm btn-outline-info rounded-pill" title="Ver detalle">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
