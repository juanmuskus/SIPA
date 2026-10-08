<div class="content-header mb-4">
    <h2 class="fw-bold text-dark">Editar conductor</h2>
</div>
<div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width: 700px;">
    <div class="card-body p-4">
        <form method="post" action="<?= $url('/conductor/actualizarconductor') ?>">
            <input type="hidden" name="id" value="<?= (int)$conductor['id_conductor'] ?>">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="nom">Nombre</label><input class="form-control" id="nom" name="nom" value="<?= $e($conductor['nombre'] ?? '') ?>" required maxlength="150"></div>
                <div class="col-md-6"><label class="form-label" for="ape">Apellido</label><input class="form-control" id="ape" name="ape" value="<?= $e($conductor['apellido'] ?? '') ?>" required maxlength="150"></div>
                <div class="col-md-6"><label class="form-label" for="ide">Identificación</label><input class="form-control" id="ide" name="ide" type="number" min="1" value="<?= $e($conductor['identificacion'] ?? '') ?>" required></div>
                <div class="col-md-6"><label class="form-label" for="tel">Teléfono</label><input class="form-control" id="tel" name="tel" type="tel" maxlength="40" value="<?= $e($conductor['telefono'] ?? '') ?>"></div>
                <div class="col-12"><label class="form-label" for="dir">Dirección</label><input class="form-control" id="dir" name="dir" maxlength="255" value="<?= $e($conductor['direccion'] ?? '') ?>"></div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="<?= $url('/conductor/listarconductor') ?>">Cancelar</a>
                <button class="btn btn-sipa" type="submit">Actualizar conductor</button>
            </div>
        </form>
    </div>
</div>
