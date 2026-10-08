<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Página no encontrada | SIPA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #f8fafc; display: flex; min-height: 100vh; align-items: center; justify-content: center; }
        .error-card { max-width: 520px; text-align: center; padding: 3rem 2rem; }
        .error-number { font-size: 8rem; font-weight: 800; color: #e5e7eb; line-height: 1; }
        .error-icon { font-size: 4rem; color: #10b981; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon"><i class="fa-solid fa-compass-drafting"></i></div>
        <div class="error-number">404</div>
        <h2 class="fw-bold text-dark mt-2 mb-2">Página no encontrada</h2>
        <p class="text-muted mb-4">
            La ruta <code class="bg-light px-2 py-1 rounded"><?= htmlspecialchars($path ?? '', ENT_QUOTES, 'UTF-8') ?></code>
            no existe en este sistema.
        </p>
        <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill me-2">
            <i class="fa-solid fa-arrow-left me-1"></i> Regresar
        </a>
        <a href="/SIPA/public/" class="btn rounded-pill px-4" style="background:#10b981; color:#fff;">
            <i class="fa-solid fa-house me-1"></i> Inicio
        </a>
    </div>
</body>
</html>
