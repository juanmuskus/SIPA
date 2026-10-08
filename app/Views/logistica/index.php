<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-secondary-emphasis fw-bold mb-1">Módulo de Logística</h2>
        <div class="subtitle text-warning fw-semibold">Gestión de Conductores, Vehículos y Servicios</div>
    </div>
</div>

<div class="hero-banner mb-4" style="background: linear-gradient(135deg, #f59e0b15, #d9770610); border: 1px solid #f59e0b30; border-radius: 12px; padding: 1.5rem;">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3 class="fw-bold text-warning-emphasis mb-2"><i class="fa-solid fa-truck-fast me-2"></i>Panel de Logística</h3>
            <p class="text-secondary mb-0">
                Desde aquí puede registrar y gestionar los conductores, los vehículos disponibles, los servicios de transporte asignados y realizar las liquidaciones de gastos de los conductores.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="<?= $url('/conductor/agregarconductor') ?>" class="btn btn-warning me-2">
                <i class="fa-solid fa-user-plus me-1"></i> Nuevo Conductor
            </a>
            <a href="<?= $url('/liquiconductor/listarliquiconductor') ?>" class="btn btn-outline-warning">
                <i class="fa-solid fa-file-invoice-dollar me-1"></i> Liquidaciones
            </a>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div>
                    <span class="text-muted small">Flota</span>
                    <h5 class="fw-bold mb-0">Conductores</h5>
                </div>
            </div>
            <a href="<?= $url('/conductor/listarconductor') ?>" class="stretched-link text-decoration-none small text-warning mt-2 d-inline-block">Ver conductores &rarr;</a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                    <i class="fa-solid fa-car"></i>
                </div>
                <div>
                    <span class="text-muted small">Parque automotor</span>
                    <h5 class="fw-bold mb-0">Vehículos</h5>
                </div>
            </div>
            <a href="<?= $url('/transporte/listartransporte') ?>" class="stretched-link text-decoration-none small text-purple mt-2 d-inline-block" style="color:#7c3aed">Ver vehículos &rarr;</a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <div>
                    <span class="text-muted small">Asignaciones</span>
                    <h5 class="fw-bold mb-0">Servicios</h5>
                </div>
            </div>
            <a href="<?= $url('/servicio/listarservicio') ?>" class="stretched-link text-decoration-none small text-info mt-2 d-inline-block">Ver servicios &rarr;</a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fa-solid fa-gas-pump"></i>
                </div>
                <div>
                    <span class="text-muted small">Viáticos</span>
                    <h5 class="fw-bold mb-0">Liquidaciones</h5>
                </div>
            </div>
            <a href="<?= $url('/liquiconductor/listarliquiconductor') ?>" class="stretched-link text-decoration-none small text-success mt-2 d-inline-block">Ver liquidaciones &rarr;</a>
        </div>
    </div>
</div>
