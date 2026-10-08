<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1">Programación de la práctica</h2>
        <div class="subtitle text-muted"><?= $e($practica['nombre'] ?? 'Práctica') ?></div>
    </div>
    <a href="<?= $url('/practicas/listarpractica') ?>" class="btn btn-outline-secondary rounded-pill">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver a prácticas
    </a>
</div>

<?php if (empty($programaciones)): ?>
    <div class="alert alert-info">Esta práctica todavía no tiene días programados.</div>
<?php else: ?>
    <?php foreach ($programaciones as $programacion): ?>
        <section class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-header bg-success-subtle fw-semibold">
                Día <?= $e($programacion['num_dias'] ?? '') ?> · <?= $e(trim(($programacion['origen'] ?? '') . ' - ' . ($programacion['destino'] ?? ''))) ?>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Fecha de salida</dt><dd class="col-sm-3"><?= $e($programacion['fecha_salida'] ?? '') ?></dd>
                    <dt class="col-sm-3">Fecha de llegada</dt><dd class="col-sm-3"><?= $e($programacion['fecha_llegada'] ?? 'Sin fecha') ?></dd>
                    <dt class="col-sm-3">Recorrido</dt><dd class="col-sm-3"><?= $e($programacion['ruta_nombre'] ?? $programacion['recorrido'] ?? '') ?></dd>
                    <dt class="col-sm-3">Sitio</dt><dd class="col-sm-3"><?= $e($programacion['sitio'] ?? '') ?></dd>
                    <dt class="col-sm-3">Lugar de encuentro</dt><dd class="col-sm-3"><?= $e($programacion['lugar_encuentro'] ?? '') ?></dd>
                    <dt class="col-sm-3">Pernoctado</dt><dd class="col-sm-3"><?= $e($programacion['dias_pernoctados'] ?? 'No') ?></dd>
                    <dt class="col-sm-3">Recorrido departamental</dt><dd class="col-sm-3"><?= $e($programacion['departamental'] ?? '') ?></dd>
                    <dt class="col-sm-3">Observaciones</dt><dd class="col-sm-9"><?= $e($programacion['observaciones'] ?? '') ?></dd>
                    <dt class="col-sm-3">Participantes</dt>
                    <dd class="col-sm-9">
                        <?php if (empty($programacion['participantes'])): ?>
                            No hay participantes registrados.
                        <?php else: ?>
                            <?= $e(implode(', ', array_map(static fn(array $participante): string => (string)($participante['nombre'] ?? ''), $programacion['participantes']))) ?>
                        <?php endif; ?>
                    </dd>
                    <dt class="col-sm-3">Recursos especiales</dt>
                    <dd class="col-sm-9">
                        <?php if (empty($programacion['recursos'])): ?>
                            No hay recursos especiales registrados.
                        <?php else: ?>
                            <?= $e(implode(', ', array_map(static fn(array $recurso): string => (string)($recurso['nombre'] ?? '') . ' ($' . number_format((float)($recurso['valor'] ?? 0), 0, ',', '.') . ')', $programacion['recursos']))) ?>
                        <?php endif; ?>
                    </dd>
                </dl>
            </div>
        </section>
    <?php endforeach; ?>
<?php endif; ?>
