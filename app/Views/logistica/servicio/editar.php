<div class="content-header mb-4"><h2 class="fw-bold text-dark">Editar servicio</h2></div>
<div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width: 760px;">
    <div class="card-body p-4">
        <form method="post" action="<?= $url('/servicio/actualizarservicio') ?>">
            <input type="hidden" name="id" value="<?= (int)$servicio['cod_servicio'] ?>">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="servicio">Tipo de servicio</label><input class="form-control" id="servicio" name="servicio" value="<?= $e($servicio['tipo'] ?? '') ?>" required maxlength="120"></div>
                <div class="col-md-6"><label class="form-label" for="valor">Valor</label><input class="form-control" id="valor" name="valor" type="number" min="0" step="0.01" value="<?= $e($servicio['valor'] ?? 0) ?>" required></div>
                <div class="col-12"><label class="form-label" for="codigo_prog">Programación</label>
                    <select class="form-select" id="codigo_prog" name="codigo_prog" required>
                        <option value="">Seleccione una programación</option>
                        <?php foreach ($programaciones as $programacion): ?>
                            <option value="<?= (int)$programacion['codigo_prog'] ?>" <?= (int)$programacion['codigo_prog'] === (int)$servicio['codigo_prog'] ? 'selected' : '' ?>>Práctica #<?= $e($programacion['cod_practica']) ?> — Día <?= $e($programacion['num_dias']) ?> — <?= $e($programacion['lugar_encuentro'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12"><label class="form-label" for="observacion">Observación</label><textarea class="form-control" id="observacion" name="observacion" rows="3" maxlength="1000"><?= $e($servicio['observacion'] ?? '') ?></textarea></div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="<?= $url('/servicio/listarservicio') ?>">Cancelar</a>
                <button class="btn btn-sipa" type="submit">Actualizar servicio</button>
            </div>
        </form>
    </div>
</div>
