<?php
/**
 * @var array $practica
 * @var array $programaciones
 * @var float $valor_docente
 * @var float $auxilio_est
 * @var float $transporte_especial
 * @var array|null $existente
 * @var int $cod_practica
 * @var callable $url
 * @var callable $e
 */
$totalDias = count($programaciones);
$totalLiq = $valor_docente + $auxilio_est + $transporte_especial;
?>

<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-secondary-emphasis mb-1">
            <i class="fa-solid fa-file-invoice-dollar text-warning me-2"></i>Liquidar Docente
        </h2>
        <p class="text-muted mb-0"><?= $e($practica['nombre'] ?? 'Práctica') ?></p>
    </div>
    <a href="<?= $url('/practicas/listarpractica') ?>" class="btn btn-outline-secondary rounded-pill">
        <i class="fa-solid fa-arrow-left me-1"></i>Regresar
    </a>
</div>

<!-- Resumen de Cálculo Automático -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 rounded-4 p-3 text-center" style="background: linear-gradient(135deg, #10b98120, #05966910); border: 1px solid #10b98130 !important;">
            <div class="text-muted small">Días de Práctica</div>
            <div class="fs-2 fw-bold text-success"><?= $totalDias ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 rounded-4 p-3 text-center" style="background: linear-gradient(135deg, #3b82f620, #2563eb10); border: 1px solid #3b82f630 !important;">
            <div class="text-muted small">Viáticos Docente</div>
            <div class="fs-4 fw-bold text-primary">$<?= number_format($valor_docente, 0, ',', '.') ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 rounded-4 p-3 text-center" style="background: linear-gradient(135deg, #f59e0b20, #d9770610); border: 1px solid #f59e0b30 !important;">
            <div class="text-muted small">Auxilio Estudiantes</div>
            <div class="fs-4 fw-bold text-warning">$<?= number_format($auxilio_est, 0, ',', '.') ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 rounded-4 p-3 text-center" style="background: linear-gradient(135deg, #8b5cf620, #7c3aed10); border: 1px solid #8b5cf630 !important;">
            <div class="text-muted small">Transporte Especial</div>
            <div class="fs-4 fw-bold" style="color:#7c3aed">$<?= number_format($transporte_especial, 0, ',', '.') ?></div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #1f2937, #111827); color: #fff;">
    <div class="card-body p-4 text-center">
        <div class="opacity-75 mb-1">Total a Liquidar</div>
        <div class="display-4 fw-bold">$<?= number_format($totalLiq, 0, ',', '.') ?></div>
    </div>
</div>

<!-- Formulario de Liquidación -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-warning text-dark rounded-top-4 fw-semibold">
        <i class="fa-solid fa-pen-to-square me-2"></i>
        <?= $existente ? 'Actualizar Liquidación' : 'Registrar Liquidación' ?>
    </div>
    <div class="card-body p-4">
        <form id="formLiquidar">
            <input type="hidden" name="practica" value="<?= (int)$cod_practica ?>">
            <input type="hidden" name="cod_practica" value="<?= (int)$cod_practica ?>">

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Viáticos Docente ($)</label>
                    <input type="number" class="form-control" name="viatico_docente" step="0.01"
                           value="<?= number_format($valor_docente, 2, '.', '') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Auxilio Estudiantes ($)</label>
                    <input type="number" class="form-control" name="auxilio_estudiante" step="0.01"
                           value="<?= number_format($auxilio_est, 2, '.', '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Transporte Especial ($)</label>
                    <input type="number" class="form-control" name="transporte_especial" step="0.01"
                           value="<?= number_format($transporte_especial, 2, '.', '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Estado de Pago</label>
                    <select class="form-select" name="estado_pago">
                        <option value="Trámite" <?= ($existente['estado'] ?? '') === 'Trámite' ? 'selected' : '' ?>>Trámite</option>
                        <option value="Pagado" <?= ($existente['estado'] ?? '') === 'Pagado' ? 'selected' : '' ?>>Pagado</option>
                        <option value="Rechazado" <?= ($existente['estado'] ?? '') === 'Rechazado' ? 'selected' : '' ?>>Rechazado</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Fecha de Pago</label>
                    <input type="date" class="form-control" name="fecha_pago"
                           value="<?= $e($existente['fecha_pago'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Legalizado</label>
                    <select class="form-select" name="legalizado">
                        <option value="No" <?= ($existente['legalizado'] ?? 'No') === 'No' ? 'selected' : '' ?>>No</option>
                        <option value="Si" <?= ($existente['legalizado'] ?? 'No') === 'Si' ? 'selected' : '' ?>>Si</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">F. Legalización</label>
                    <input type="date" class="form-control" name="fecha_legalizado"
                           value="<?= $e($existente['fecha_legalizado'] ?? '') ?>">
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-end mt-4">
                <button type="button" class="btn btn-warning rounded-pill px-5 fw-semibold" onclick="guardarLiquidacion()">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    <?= $existente ? 'Actualizar' : 'Liquidar' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function guardarLiquidacion() {
    const data = $('#formLiquidar').serialize();
    const url = SIPA_BASE + '/liquidarpracticas/guardarliquidarpracticas';
    $.post(url, data, function(resp) {
        Swal.fire('¡Éxito!', resp, 'success').then(() => {
            window.location.href = SIPA_BASE + '/liquidarpracticas/listarliquidacion';
        });
    }).fail(xhr => Swal.fire('Error', xhr.responseText || 'No se pudo guardar', 'error'));
}
</script>
