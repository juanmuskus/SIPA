<div class="content-header d-flex justify-content-between align-items-center">
    <div>
        <h2 class="text-secondary-emphasis fw-bold">Bienvenidos al Sistemas de Prácticas Académicas "Sipa"</h2>
        <div class="subtitle text-success fw-semibold">Módulo de Administrador</div>
    </div>
</div>

<div class="hero-banner mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3 class="fw-bold text-success-emphasis mb-2">Panel de Control General</h3>
            <p class="text-secondary mb-0">
                Desde aquí puede gestionar los usuarios del sistema, calendarios académicos vigentes, catálogo de rutas, recursos especiales y revisar las liquidaciones de prácticas aprobadas.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="<?= $url('/usuarios/agregarusuario') ?>" class="btn btn-sipa me-2">
                <i class="fa-solid fa-user-plus me-1"></i> Nuevo Usuario
            </a>
            <a href="<?= $url('/practicas/listarpractica') ?>" class="btn btn-outline-success">
                <i class="fa-solid fa-list-check me-1"></i> Ver Prácticas
            </a>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle bg-success text-white">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <span class="text-muted small">Gestión</span>
                    <h5 class="fw-bold mb-0">Usuarios</h5>
                </div>
            </div>
            <a href="<?= $url('/usuarios/listarusuario') ?>" class="stretched-link text-decoration-none small text-success mt-2 d-inline-block">Ver listado &rarr;</a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle bg-primary text-white">
                    <i class="fa-solid fa-calendar"></i>
                </div>
                <div>
                    <span class="text-muted small">Periodos</span>
                    <h5 class="fw-bold mb-0">Calendario</h5>
                </div>
            </div>
            <a href="<?= $url('/calendar/listarcalendar') ?>" class="stretched-link text-decoration-none small text-primary mt-2 d-inline-block">Ver calendario &rarr;</a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle bg-warning text-white">
                    <i class="fa-solid fa-route"></i>
                </div>
                <div>
                    <span class="text-muted small">Destinos</span>
                    <h5 class="fw-bold mb-0">Rutas</h5>
                </div>
            </div>
            <a href="<?= $url('/rutas/listarruta') ?>" class="stretched-link text-decoration-none small text-warning mt-2 d-inline-block">Ver rutas &rarr;</a>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-light-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle bg-info text-white">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <span class="text-muted small">Finanzas</span>
                    <h5 class="fw-bold mb-0">Liquidación</h5>
                </div>
            </div>
            <a href="<?= $url('/practicas/listarpractica') ?>" class="stretched-link text-decoration-none small text-info mt-2 d-inline-block">Liquidar docentes &rarr;</a>
        </div>
    </div>
</div>
