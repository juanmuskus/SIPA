<?php
/**
 * @var array $liquidacion
 * @var array $conductores
 * @var array $vehiculos
 * @var array $practicas
 * @var callable $url
 * @var callable $e
 */
$liq = $liquidacion ?? [];
?>

<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-secondary-emphasis mb-1">
            <i class="fa-solid fa-pen text-primary me-2"></i>Editar Liquidación de Conductor
        </h2>
    </div>
    <a href="<?= $url('/liquiconductor/listarliquiconductor') ?>" class="btn btn-outline-secondary rounded-pill">
        <i class="fa-solid fa-arrow-left me-1"></i>Regresar
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-primary text-white rounded-top-4 fw-semibold">
        <i class="fa-solid fa-file-invoice-dollar me-2"></i>Datos de la Liquidación
    </div>
    <div class="card-body p-4">
        <form id="formEditLiq">
            <input type="hidden" name="id" value="<?= (int)($liq['id'] ?? 0) ?>">

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Práctica</label>
                    <select class="form-select" name="practica">
                        <?php foreach ($practicas as $pr): ?>
                        <option value="<?= $e($pr['cod_practica']) ?>"
                            <?= (string)($liq['cod_practica'] ?? '') === (string)$pr['cod_practica'] ? 'selected' : '' ?>>
                            #<?= $e($pr['cod_practica']) ?> – <?= $e($pr['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Conductor</label>
                    <select class="form-select" name="conductor">
                        <?php foreach ($conductores as $c): ?>
                        <option value="<?= $e($c['id_conductor']) ?>"
                            <?= (string)($liq['id_conductor'] ?? '') === (string)$c['id_conductor'] ? 'selected' : '' ?>>
                            <?= $e($c['nombre'] . ' ' . $c['apellido']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Vehículo</label>
                    <select class="form-select" name="vehiculo">
                        <?php foreach ($vehiculos as $v): ?>
                        <option value="<?= $e($v['cod_transporte']) ?>"
                            <?= (string)($liq['cod_transporte'] ?? '') === (string)$v['cod_transporte'] ? 'selected' : '' ?>>
                            <?= $e($v['placa']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Combustible ($)</label>
                    <input type="number" class="form-control" name="combustible" step="0.01" value="<?= $e($liq['combustible'] ?? 0) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Peajes ($)</label>
                    <input type="number" class="form-control" name="peajes" step="0.01" value="<?= $e($liq['peajes'] ?? 0) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Viáticos ($)</label>
                    <input type="number" class="form-control" name="viaticos" step="0.01" value="<?= $e($liq['viaticos'] ?? 0) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Imprevistos ($)</label>
                    <input type="number" class="form-control" name="imprevistos" step="0.01" value="<?= $e($liq['imprevistos'] ?? 0) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Estado</label>
                    <select class="form-select" name="pagada">
                        <option value="Trámite" <?= ($liq['pagado'] ?? '') === 'Trámite' ? 'selected' : '' ?>>Trámite</option>
                        <option value="Pagado" <?= ($liq['pagado'] ?? '') === 'Pagado' ? 'selected' : '' ?>>Pagado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Fecha Pago</label>
                    <input type="date" class="form-control" name="fecha_pago" value="<?= $e($liq['fecha_pago'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Legalizado</label>
                    <select class="form-select" name="legalizado">
                        <option value="No" <?= ($liq['legalizado'] ?? 'No') === 'No' ? 'selected' : '' ?>>No</option>
                        <option value="Si" <?= ($liq['legalizado'] ?? 'No') === 'Si' ? 'selected' : '' ?>>Si</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Fecha Legalización</label>
                    <input type="date" class="form-control" name="fecha_legalizado" value="<?= $e($liq['fecha_legalizado'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Observaciones</label>
                    <textarea class="form-control" name="observacion" rows="2"><?= $e($liq['observacion'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-end mt-4">
                <a href="<?= $url('/liquiconductor/listarliquiconductor') ?>" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
                <button type="button" class="btn btn-primary rounded-pill px-5 fw-semibold" onclick="actualizarLiq()">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function actualizarLiq() {
    $.post(SIPA_BASE + '/liquiconductor/actualizarliquiconductor', $('#formEditLiq').serialize(), function(resp) {
        Swal.fire('¡Actualizado!', resp, 'success').then(() => {
            history.back();
        });
    }).fail(xhr => Swal.fire('Error', xhr.responseText || 'Error', 'error'));
}
</script>
