<?php
/**
 * @var array $conductores
 * @var array $vehiculos
 * @var array $practicas
 * @var callable $url
 * @var callable $e
 */
?>

<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-secondary-emphasis mb-1">
            <i class="fa-solid fa-plus-circle text-warning me-2"></i>Registrar Liquidación de Conductor
        </h2>
    </div>
    <a href="<?= $url('/liquiconductor/listarliquiconductor') ?>" class="btn btn-outline-secondary rounded-pill">
        <i class="fa-solid fa-arrow-left me-1"></i>Regresar
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-warning text-dark rounded-top-4 fw-semibold">
        <i class="fa-solid fa-file-invoice-dollar me-2"></i>Datos de la Liquidación
    </div>
    <div class="card-body p-4">
        <form id="formLiqConductor">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Práctica *</label>
                    <select class="form-select" name="practica" required>
                        <option value="">-- Seleccionar --</option>
                        <?php foreach ($practicas as $pr): ?>
                        <option value="<?= $e($pr['cod_practica']) ?>"><?= $e('#' . $pr['cod_practica'] . ' - ' . $pr['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Conductor *</label>
                    <select class="form-select" name="conductor" required>
                        <option value="">-- Seleccionar --</option>
                        <?php foreach ($conductores as $c): ?>
                        <option value="<?= $e($c['id_conductor']) ?>"><?= $e($c['nombre'] . ' ' . $c['apellido']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Vehículo *</label>
                    <select class="form-select" name="vehiculo" required>
                        <option value="">-- Seleccionar --</option>
                        <?php foreach ($vehiculos as $v): ?>
                        <option value="<?= $e($v['cod_transporte']) ?>"><?= $e($v['placa'] . ' – ' . ($v['descripcion'] ?? '')) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Combustible ($)</label>
                    <input type="number" class="form-control" name="combustible" step="0.01" min="0" value="0" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Peajes ($)</label>
                    <input type="number" class="form-control" name="peajes" step="0.01" min="0" value="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Viáticos ($)</label>
                    <input type="number" class="form-control" name="viaticos" step="0.01" min="0" value="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Imprevistos ($)</label>
                    <input type="number" class="form-control" name="imprevistos" step="0.01" min="0" value="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Estado de Pago</label>
                    <select class="form-select" name="estado_pago">
                        <option value="Trámite">Trámite</option>
                        <option value="Pagado">Pagado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Fecha de Pago</label>
                    <input type="date" class="form-control" name="fecha_pago">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Legalizado</label>
                    <select class="form-select" name="legalizado">
                        <option value="No">No</option>
                        <option value="Si">Si</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Fecha Legalización</label>
                    <input type="date" class="form-control" name="fecha_legalizado">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Observaciones</label>
                    <textarea class="form-control" name="observacion" rows="2" placeholder="Observaciones adicionales..."></textarea>
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-end mt-4">
                <a href="<?= $url('/liquiconductor/listarliquiconductor') ?>" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
                <button type="button" class="btn btn-warning rounded-pill px-5 fw-semibold" onclick="guardarLiq()">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function guardarLiq() {
    $.post(SIPA_BASE + '/liquiconductor/guardarliquiconductor', $('#formLiqConductor').serialize(), function(resp) {
        Swal.fire('¡Guardado!', resp, 'success').then(() => {
            window.location.href = SIPA_BASE + '/liquiconductor/listarliquiconductor';
        });
    }).fail(xhr => Swal.fire('Error', xhr.responseText || 'Error', 'error'));
}
</script>
