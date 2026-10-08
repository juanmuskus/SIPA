<?php
/**
 * @var array|null $practica
 * @var array|null $liquidacion
 * @var array $programaciones
 * @var callable $url
 * @var callable $e
 */
$p = $practica ?? [];
$liq = $liquidacion ?? [];
$totalDias = count($programaciones);
?>

<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-secondary-emphasis mb-1">
            <i class="fa-solid fa-file-invoice text-success me-2"></i>Detalle de Liquidación
        </h2>
        <p class="text-muted mb-0">Práctica #<?= $e($p['cod_practica'] ?? '') ?> – <?= $e($p['nombre'] ?? 'Sin nombre') ?></p>
    </div>
    <a href="<?= $url('/practicas/listarpractica') ?>" class="btn btn-outline-secondary rounded-pill">
        <i class="fa-solid fa-arrow-left me-1"></i>Regresar
    </a>
</div>

<!-- Información de la Práctica -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-success text-white rounded-top-4 fw-semibold">
        <i class="fa-solid fa-info-circle me-2"></i>Información General
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="mb-2"><span class="text-muted small">Nombre:</span><br><strong><?= $e($p['nombre'] ?? '') ?></strong></div>
                <div class="mb-2"><span class="text-muted small">Tipo:</span><br><?= $e($p['tipo_practica'] ?? '') ?></div>
                <div class="mb-2"><span class="text-muted small">Asignatura:</span><br><?= $e($p['asignatura'] ?? '') ?></div>
            </div>
            <div class="col-md-6">
                <div class="mb-2"><span class="text-muted small">Estudiantes:</span><br><strong><?= $e($p['num_estudiantes'] ?? 0) ?></strong></div>
                <div class="mb-2"><span class="text-muted small">Días de práctica:</span><br><strong><?= $totalDias ?></strong></div>
                <div class="mb-2"><span class="text-muted small">Grupo:</span><br><?= $e($p['grupo'] ?? '') ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Programación -->
<?php if (!empty($programaciones)): ?>
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-primary text-white rounded-top-4 fw-semibold">
        <i class="fa-solid fa-calendar-days me-2"></i>Programación de Días
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Día</th>
                    <th>Fecha Salida</th>
                    <th>Fecha Llegada</th>
                    <th>Ruta</th>
                    <th>Lugar</th>
                    <th>Pernoctado</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programaciones as $prog): ?>
                <tr>
                    <td><span class="badge bg-primary-subtle text-primary"><?= $e($prog['num_dias']) ?></span></td>
                    <td><?= $e($prog['fecha_salida'] ?? '') ?></td>
                    <td><?= $e($prog['fecha_llegada'] ?? '—') ?></td>
                    <td>
                        <?php if (!empty($prog['origen'])): ?>
                            <small><?= $e($prog['origen']) ?> → <?= $e($prog['destino'] ?? '') ?></small>
                        <?php else: ?>
                            <small class="text-muted">Sin ruta</small>
                        <?php endif; ?>
                    </td>
                    <td><?= $e($prog['lugar_encuentro'] ?? '') ?></td>
                    <td>
                        <span class="badge <?= ($prog['dias_pernoctados'] ?? '') === 'Si' ? 'bg-warning-subtle text-warning' : 'bg-secondary-subtle text-secondary' ?>">
                            <?= $e($prog['dias_pernoctados'] ?? 'No') ?>
                        </span>
                    </td>
                    <td><small><?= $e($prog['observaciones'] ?? '') ?></small></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Liquidación -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-warning text-dark rounded-top-4 fw-semibold">
        <i class="fa-solid fa-money-bill-wave me-2"></i>Datos de Liquidación
    </div>
    <div class="card-body p-4">
        <?php if (!empty($liq)): ?>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card bg-success-subtle border-0 rounded-3 p-3 text-center">
                    <div class="text-muted small">Viáticos Docente</div>
                    <div class="fs-4 fw-bold text-success">$<?= number_format((float)($liq['viaticos'] ?? 0), 0, ',', '.') ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-primary-subtle border-0 rounded-3 p-3 text-center">
                    <div class="text-muted small">Auxilio Estudiantes</div>
                    <div class="fs-4 fw-bold text-primary">$<?= number_format((float)($liq['aux_estudiante'] ?? 0), 0, ',', '.') ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning-subtle border-0 rounded-3 p-3 text-center">
                    <div class="text-muted small">Transporte Especial</div>
                    <div class="fs-4 fw-bold text-warning">$<?= number_format((float)($liq['transporte_especial'] ?? 0), 0, ',', '.') ?></div>
                </div>
            </div>
            <div class="col-12">
                <div class="card bg-dark text-white border-0 rounded-3 p-3 text-center">
                    <div class="small opacity-75">Total Liquidado</div>
                    <div class="fs-3 fw-bold">$<?= number_format(((float)($liq['viaticos'] ?? 0)) + ((float)($liq['aux_estudiante'] ?? 0)) + ((float)($liq['transporte_especial'] ?? 0)), 0, ',', '.') ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <span class="text-muted small">Estado:</span>
                <?php
                $estado = $liq['estado'] ?? 'Trámite';
                $badgeClass = match($estado) { 'Pagado' => 'bg-success', 'Trámite' => 'bg-warning text-dark', default => 'bg-secondary' };
                ?>
                <span class="badge <?= $badgeClass ?> ms-2"><?= $e($estado) ?></span>
            </div>
            <div class="col-md-4">
                <span class="text-muted small">Fecha de Pago:</span>
                <strong class="ms-2"><?= $e($liq['fecha_pago'] ?? '—') ?></strong>
            </div>
            <div class="col-md-4">
                <span class="text-muted small">Legalizado:</span>
                <span class="badge <?= ($liq['legalizado'] ?? 'No') === 'Si' ? 'bg-success' : 'bg-secondary' ?> ms-2">
                    <?= $e($liq['legalizado'] ?? 'No') ?>
                </span>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-warning rounded-3 mb-0">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            Esta práctica aún no tiene liquidación registrada.
            <a href="<?= $url('/liquidarpracticas/liquidarpractica?cod_practica=' . (int)($p['cod_practica'] ?? 0)) ?>" class="alert-link ms-2">
                Liquidar ahora &rarr;
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
