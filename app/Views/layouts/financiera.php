<?php
/** @var string $content */
/** @var callable $url */
/** @var callable $asset */
/** @var callable $e */
/** @var array|null $user */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $e($title ?? 'SIPA - Módulo Financiero') ?></title>
    <link rel="shortcut icon" href="<?= $asset('/img/uni.png') ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $asset('/css/sipa_modern.css') ?>">
</head>
<body class="sipa-body">

    <nav class="navbar navbar-expand-lg navbar-sipa fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= $url('/inicio/financiera') ?>">
                <img src="<?= $asset('/img/uni.png') ?>" alt="Unicordoba" class="sipa-logo">
                <span class="sipa-brand-title">Sistemas Prácticas Académicas Unicordoba</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarFinContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarFinContent">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="<?= $url('/inicio/financiera') ?>">
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

    <div class="container-fluid sipa-container px-4">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="sidebar-card shadow-sm rounded-4 p-3 mb-4">
                    <div class="sidebar-user-header d-flex align-items-center gap-3 p-2 mb-3 border-bottom pb-3">
                        <div class="avatar-circle" style="background: linear-gradient(135deg, #10b981, #059669);">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark"><?= $e($user['nombre'] ?? 'Financiera') ?></div>
                            <span class="badge bg-info-subtle text-info border border-info-subtle">Financiera</span>
                        </div>
                    </div>

                    <div class="accordion accordion-flush sipa-accordion" id="sidebarMenuFin">
                        <!-- Liquidar Prácticas -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#menuLiqPrac">
                                    <i class="fa-solid fa-graduation-cap text-success me-2"></i> Prácticas
                                </button>
                            </h2>
                            <div id="menuLiqPrac" class="accordion-collapse collapse show" data-bs-parent="#sidebarMenuFin">
                                <div class="accordion-body p-1">
                                    <a href="<?= $url('/practicas/listarpractica') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-list-check text-success me-2"></i> Listar Prácticas
                                    </a>
                                    <a href="<?= $url('/liquidarpracticas/listarliquidacion') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-money-bill-wave text-success me-2"></i> Liquidar Docentes
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Liquidar Logística -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menuLiqLog2">
                                    <i class="fa-solid fa-truck-fast text-success me-2"></i> Logística
                                </button>
                            </h2>
                            <div id="menuLiqLog2" class="accordion-collapse collapse" data-bs-parent="#sidebarMenuFin">
                                <div class="accordion-body p-1">
                                    <a href="<?= $url('/liquiconductor/verliquidacion') ?>" class="sidebar-link">
                                        <i class="fa-solid fa-gas-pump text-success me-2"></i> Viáticos Logística
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
