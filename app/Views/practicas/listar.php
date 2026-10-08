<?php /** @var array $practicas @var int $rol @var callable $url @var callable $e */ ?>

<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-secondary-emphasis mb-1">
            <i class="fa-solid fa-list-check text-success me-2"></i>Listado de Prácticas
        </h2>
        <p class="text-muted mb-0">Gestión de prácticas académicas registradas</p>
    </div>
    <?php if ($rol <= 2): ?>
    <a href="<?= $url('/practicas/agregarpractica') ?>" class="btn btn-sipa">
        <i class="fa-solid fa-plus me-2"></i>Nueva Práctica
    </a>
    <?php endif; ?>
</div>

<?php if (empty($practicas)): ?>
<div class="alert alert-info rounded-4">
    <i class="fa-solid fa-circle-info me-2"></i>No hay prácticas registradas.
</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-hover align-middle sipa-datatable" id="tbl-practicas">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Programa</th>
                <th>Docente</th>
                <th>Estudiantes</th>
                <th>Estado Liq.</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($practicas as $p): ?>
            <tr>
                <td><span class="badge bg-secondary-subtle text-secondary"><?= $e($p['cod_practica']) ?></span></td>
                <td>
                    <div class="fw-semibold"><?= $e($p['nombre']) ?></div>
                    <small class="text-muted"><?= $e($p['asignatura'] ?? '') ?></small>
                </td>
                <td><small><?= $e($p['tipo_practica'] ?? 'N/A') ?></small></td>
                <td><small><?= $e($p['programa_nombre'] ?? $p['programa'] ?? 'N/A') ?></small></td>
                <td><small><?= $e($p['docente_nombre'] ?? 'N/A') ?></small></td>
                <td class="text-center"><span class="badge bg-info-subtle text-info"><?= $e($p['num_estudiantes'] ?? 0) ?></span></td>
                <td>
                    <?php
                    $estadoLiq = $p['estado_liq'] ?? null;
                    $badgeClass = match ($estadoLiq) {
                        'Pagado'  => 'bg-success-subtle text-success',
                        'Trámite' => 'bg-warning-subtle text-warning',
                        default   => 'bg-secondary-subtle text-secondary',
                    };
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= $e($estadoLiq ?? 'Sin liquidar') ?></span>
                </td>
                <td>
                    <div class="d-flex gap-1 flex-wrap">
                        <?php if ($rol <= 2): ?>
                        <a class="btn btn-sm btn-outline-primary rounded-pill"
                           href="<?= $url('/practicas/editarpractica?id=' . (int)$p['cod_practica']) ?>"
                           title="Editar práctica">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a class="btn btn-sm btn-outline-secondary rounded-pill"
                           href="<?= $url('/programacion/listarprogramacion?id=' . (int)$p['cod_practica']) ?>"
                           title="Ver programación">
                            <i class="fa-solid fa-calendar-days"></i>
                        </a>
                        <?php endif; ?>
                        <a href="<?= $url('/practicas/verliquidacion?id=' . (int)$p['cod_practica']) ?>"
                           class="btn btn-sm btn-outline-success rounded-pill" title="Ver Liquidación">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </a>
                        <?php if ($rol === 1 || $rol === 4): ?>
                        <a href="<?= $url('/liquidarpracticas/liquidarpractica?cod_practica=' . (int)$p['cod_practica']) ?>"
                           class="btn btn-sm btn-outline-warning rounded-pill" title="Liquidar">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<script>
</script>
