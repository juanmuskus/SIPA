<?php
/**
 * @var array|null $liquidacion
 * @var callable $url
 * @var callable $e
 */
$liq = $liquidacion ?? [];
?>

<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-secondary-emphasis mb-1">
            <i class="fa-solid fa-pen text-primary me-2"></i>Editar Pago de Práctica
        </h2>
        <p class="text-muted mb-0"><?= $e($liq['practica_nombre'] ?? 'Liquidación') ?></p>
    </div>
    <a href="<?= $url('/liquidarpracticas/listarliquidacion') ?>" class="btn btn-outline-secondary rounded-pill">
        <i class="fa-solid fa-arrow-left me-1"></i>Regresar
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-primary text-white rounded-top-4 fw-semibold">
        <i class="fa-solid fa-file-invoice-dollar me-2"></i>Datos del Pago
    </div>
    <div class="card-body p-4">
        <form id="formEditarPago">
            <input type="hidden" name="id_liquidar" value="<?= (int)($liq['id_liquidar'] ?? 0) ?>">

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Viáticos Docente ($)</label>
                    <input type="number" class="form-control" name="viatico_docente" step="0.01"
                           value="<?= $e($liq['viaticos'] ?? 0) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Auxilio Estudiantes ($)</label>
                    <input type="number" class="form-control" name="auxilio_estudiante" step="0.01"
                           value="<?= $e($liq['aux_estudiante'] ?? 0) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Transporte Especial ($)</label>
                    <input type="number" class="form-control" name="transporte_especial" step="0.01"
                           value="<?= $e($liq['transporte_especial'] ?? 0) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Estado de Pago</label>
                    <select class="form-select" name="estado_pago">
                        <option value="Trámite" <?= ($liq['estado'] ?? '') === 'Trámite' ? 'selected' : '' ?>>Trámite</option>
                        <option value="Pagado" <?= ($liq['estado'] ?? '') === 'Pagado' ? 'selected' : '' ?>>Pagado</option>
                        <option value="Rechazado" <?= ($liq['estado'] ?? '') === 'Rechazado' ? 'selected' : '' ?>>Rechazado</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Fecha de Pago</label>
                    <input type="date" class="form-control" name="fecha_pago"
                           value="<?= $e($liq['fecha_pago'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Legalizado</label>
                    <select class="form-select" name="legalizado">
                        <option value="No" <?= ($liq['legalizado'] ?? 'No') === 'No' ? 'selected' : '' ?>>No</option>
                        <option value="Si" <?= ($liq['legalizado'] ?? 'No') === 'Si' ? 'selected' : '' ?>>Si</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Fecha Legalización</label>
                    <input type="date" class="form-control" name="fecha_legalizado"
                           value="<?= $e($liq['fecha_legalizado'] ?? '') ?>">
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-end mt-4">
                <a href="<?= $url('/liquidarpracticas/listarliquidacion') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                    Cancelar
                </a>
                <button type="button" class="btn btn-primary rounded-pill px-5" onclick="actualizarPago()">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Actualizar Pago
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function actualizarPago() {
    const data = $('#formEditarPago').serialize();
    $.post(SIPA_BASE + '/liquidarpracticas/actualizarliquidarpracticas', data, function(resp) {
        Swal.fire('¡Actualizado!', resp, 'success').then(() => {
            window.location.href = SIPA_BASE + '/liquidarpracticas/listarliquidacion';
        });
    }).fail(xhr => Swal.fire('Error', xhr.responseText || 'Error al actualizar', 'error'));
}
</script>
