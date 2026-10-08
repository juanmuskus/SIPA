<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-secondary-emphasis fw-bold mb-1">Módulo Financiero</h2>
        <div class="subtitle text-info fw-semibold">Gestión de Liquidaciones y Pagos</div>
    </div>
</div>

<div class="hero-banner mb-4" style="background: linear-gradient(135deg, #10b98115, #05966910); border: 1px solid #10b98130; border-radius: 12px; padding: 1.5rem;">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3 class="fw-bold text-success-emphasis mb-2"><i class="fa-solid fa-coins me-2"></i>Panel Financiero</h3>
            <p class="text-secondary mb-0">
                Desde aquí puede revisar el listado de prácticas académicas, procesar las liquidaciones de viáticos para docentes y estudiantes, y gestionar los pagos de servicios de transporte.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="<?= $url('/practicas/listarpractica') ?>" class="btn btn-success me-2">
                <i class="fa-solid fa-list-check me-1"></i> Ver Prácticas
            </a>
            <a href="<?= $url('/liquidarpracticas/listarliquidacion') ?>" class="btn btn-outline-success">
                <i class="fa-solid fa-file-invoice-dollar me-1"></i> Liquidaciones
            </a>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle bg-success text-white">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <span class="text-muted small">Académico</span>
                    <h5 class="fw-bold mb-0">Prácticas</h5>
                </div>
            </div>
            <a href="<?= $url('/practicas/listarpractica') ?>" class="stretched-link text-decoration-none small text-success mt-2 d-inline-block">Ver listado &rarr;</a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle bg-primary text-white">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div>
                    <span class="text-muted small">Viáticos Docentes</span>
                    <h5 class="fw-bold mb-0">Liquidar Prácticas</h5>
                </div>
            </div>
            <a href="<?= $url('/liquidarpracticas/listarliquidacion') ?>" class="stretched-link text-decoration-none small text-primary mt-2 d-inline-block">Liquidar &rarr;</a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle bg-warning text-white">
                    <i class="fa-solid fa-gas-pump"></i>
                </div>
                <div>
                    <span class="text-muted small">Transporte</span>
                    <h5 class="fw-bold mb-0">Viáticos Logística</h5>
                </div>
            </div>
            <a href="<?= $url('/liquiconductor/verliquidacion') ?>" class="stretched-link text-decoration-none small text-warning mt-2 d-inline-block">Ver viáticos &rarr;</a>
        </div>
    </div>
</div>
