<div class="content-header mb-4"><h2 class="fw-bold text-dark">Agregar vehículo</h2></div>
<div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width: 700px;">
    <div class="card-body p-4">
        <form method="post" action="<?= $url('/transporte/guardartransporte') ?>">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="pla">Placa</label><input class="form-control text-uppercase" id="pla" name="pla" required maxlength="20"></div>
                <div class="col-md-6"><label class="form-label" for="des">Descripción</label><input class="form-control" id="des" name="des" maxlength="255"></div>
                <div class="col-md-4"><label class="form-label" for="tip">Tipo de vehículo</label><input class="form-control" id="tip" name="tip" required maxlength="80"></div>
                <div class="col-md-4"><label class="form-label" for="est">Estado</label><input class="form-control" id="est" name="est" required maxlength="80"></div>
                <div class="col-md-4"><label class="form-label" for="cap">Capacidad de pasajeros</label><input class="form-control" id="cap" name="cap" type="number" min="1" required></div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-secondary" href="<?= $url('/transporte/listartransporte') ?>">Cancelar</a>
                <button class="btn btn-sipa" type="submit">Guardar vehículo</button>
            </div>
        </form>
    </div>
</div>
