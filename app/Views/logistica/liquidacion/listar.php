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
            <i class="fa-solid fa-gas-pump text-warning me-2"></i>Liquidaciones de Conductores
        </h2>
        <p class="text-muted mb-0">Gestión de viáticos, combustible y peajes</p>
    </div>
    <a href="<?= $url('/liquiconductor/agregarliquiconductor') ?>" class="btn btn-warning rounded-pill">
        <i class="fa-solid fa-plus me-2"></i>Nueva Liquidación
    </a>
</div>

<?php if (empty($liquidaciones)): ?>
<div class="alert alert-info rounded-4">
    <i class="fa-solid fa-circle-info me-2"></i>No hay liquidaciones de conductores registradas.
</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-hover align-middle sipa-datatable" id="tbl-liq-cond">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Práctica</th>
                <th>Conductor</th>
                <th>Placa</th>
                <th>Combustible</th>
                <th>Peajes</th>
                <th>Viáticos</th>
                <th>Imprevistos</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Legalizado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($liquidaciones as $liq): ?>
            <tr>
                <td><small class="text-muted">#<?= $e($liq['id']) ?></small></td>
                <td><small><?= $e($liq['practica_nombre'] ?? 'N/A') ?></small></td>
                <td><small><?= $e(($liq['conductor_nombre'] ?? '') . ' ' . ($liq['conductor_apellido'] ?? '')) ?></small></td>
                <td><span class="badge bg-dark-subtle text-dark"><?= $e($liq['placa'] ?? '') ?></span></td>
                <td>$<?= number_format((float)$liq['combustible'], 0, ',', '.') ?></td>
                <td>$<?= number_format((float)$liq['peajes'], 0, ',', '.') ?></td>
                <td>$<?= number_format((float)$liq['viaticos'], 0, ',', '.') ?></td>
                <td>$<?= number_format((float)$liq['imprevistos'], 0, ',', '.') ?></td>
                <td class="fw-bold text-success">$<?= number_format($liq['total'] ?? 0, 0, ',', '.') ?></td>
                <td>
                    <?php
                    $pagado = $liq['pagado'] ?? 'Trámite';
                    $bc = match($pagado) { 'Pagado' => 'bg-success-subtle text-success', 'Trámite' => 'bg-warning-subtle text-warning', default => 'bg-secondary-subtle text-secondary' };
                    ?>
                    <span class="badge <?= $bc ?>"><?= $e($pagado) ?></span>
                </td>
                <td>
                    <span class="badge <?= ($liq['legalizado'] ?? 'No') === 'Si' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ?>">
                        <?= $e($liq['legalizado'] ?? 'No') ?>
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?= $url('/liquiconductor/editarliquiconductor?id=' . (int)$liq['id']) ?>"
                           class="btn btn-sm btn-outline-primary rounded-pill" title="Editar">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <button class="btn btn-sm btn-outline-danger rounded-pill"
                                onclick="eliminarLiq(<?= (int)$liq['id'] ?>)"
                                title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<script>
function eliminarLiq(id) {
    Swal.fire({
        title: '¿Eliminar liquidación?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar'
    }).then(result => {
        if (result.isConfirmed) {
            $.post(SIPA_BASE + '/liquiconductor/eliminarliquiconductor', { id: id }, function(resp) {
                Swal.fire('Eliminada', resp, 'success').then(() => location.reload());
            }).fail(xhr => Swal.fire('Error', xhr.responseText || 'Error', 'error'));
        }
    });
}
</script>
