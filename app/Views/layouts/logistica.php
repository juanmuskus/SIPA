<?php
/** @var string $content */
/** @var callable $url */
/** @var callable $asset */
/** @var callable $e */
/** @var array|null $user */
/** @var int|null $roleId */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $e($title ?? 'SIPA - Módulo de Logística') ?></title>
    <link rel="shortcut icon" href="<?= $asset('/img/profile.png') ?>">

    <!-- Google Fonts & Font Awesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Custom Modern SIPA CSS -->
    <link rel="stylesheet" href="<?= $asset('/css/sipa_modern.css') ?>">
</head>
<body class="sipa-body">

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-sipa fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $url('/inicio/logistica') ?>">
                <img class="sipa-logo" src="<?= $asset('/img/logo_.svg') ?>" alt="Logo SIPA">
                <span class="sipa-brand-title">Sistemas Información Prácticas Académicas</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLogContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarLogContent">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="<?= $url('/inicio/logistica') ?>">
                            <i class="fa-solid fa-house text-success me-1"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-danger btn-sm px-3 rounded-pill" href="<?= $url('/logout') ?>">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container-fluid sipa-container px-4">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="sidebar-card shadow-sm rounded-4 p-3 mb-4">
                    <div class="sidebar-user-header d-flex align-items-center gap-3 p-2 mb-3 border-bottom pb-3">
                        <div class="avatar-circle" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark"><?= $e($user['nombre'] ?? 'Logística') ?></div>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Logística</span>
                        </div>
                    </div>

                    <div class="accordion accordion-flush sipa-accordion" id="sidebarMenuLog">
                        <!-- Conductores -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#menuConductores">
                                    <i class="fa-solid fa-id-card text-success me-2"></i> Conductores
                                </button>
                            </h2>
                            <div id="menuConductores" class="accordion-collapse collapse show" data-bs-parent="#sidebarMenuLog">
                                <div class="accordion-body p-1">
                                    <a href="<?= $url('/conductor/agregarconductor') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-user-plus text-success me-2"></i> Agregar Conductor
                                    </a>
                                    <a href="<?= $url('/conductor/listarconductor') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-list text-success me-2"></i> Listar Conductores
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Vehículos -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menuVehiculos">
                                    <i class="fa-solid fa-car text-success me-2"></i> Vehículos
                                </button>
                            </h2>
                            <div id="menuVehiculos" class="accordion-collapse collapse" data-bs-parent="#sidebarMenuLog">
                                <div class="accordion-body p-1">
                                    <a href="<?= $url('/transporte/agregartransporte') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-plus-circle text-success me-2"></i> Agregar Vehículo
                                    </a>
                                    <a href="<?= $url('/transporte/listartransporte') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-list-check text-success me-2"></i> Listar Vehículos
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Servicios -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menuServicios">
                                    <i class="fa-solid fa-handshake text-success me-2"></i> Servicios
                                </button>
                            </h2>
                            <div id="menuServicios" class="accordion-collapse collapse" data-bs-parent="#sidebarMenuLog">
                                <div class="accordion-body p-1">
                                    <a href="<?= $url('/servicio/agregarservicio') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-plus-circle text-success me-2"></i> Agregar Servicio
                                    </a>
                                    <a href="<?= $url('/servicio/listarservicio') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-clipboard-list text-success me-2"></i> Listar Servicios
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Liquidaciones -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menuLiqLog">
                                    <i class="fa-solid fa-file-invoice-dollar text-success me-2"></i> Liquidaciones
                                </button>
                            </h2>
                            <div id="menuLiqLog" class="accordion-collapse collapse" data-bs-parent="#sidebarMenuLog">
                                <div class="accordion-body p-1">
                                    <a href="<?= $url('/liquiconductor/agregarliquiconductor') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-plus-circle text-success me-2"></i> Registrar Liquidación
                                    </a>
                                    <a href="<?= $url('/liquiconductor/listarliquiconductor') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-gas-pump text-success me-2"></i> Listar Liquidaciones
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-lg-9 col-md-8">
                <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                <main class="main-content-card shadow-sm rounded-4 p-4">
                    <?= $content ?>
                </main>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.SIPA_BASE = '<?= $url('') ?>';
        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('.sipa-datatable').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                    },
                    pageLength: 10,
                    responsive: true
                });
            }
        });
    </script>
</body>
</html>
