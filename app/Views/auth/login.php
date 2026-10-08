<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPA - Autenticación</title>
    <link rel="shortcut icon" href="<?= $asset('/img/uni.png') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --sipa-green: #1d9d74;
            --sipa-header-bg: #dff0d8;
            --sipa-header-text: #2e6037;
        }
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }
        .login-topbar {
            background-color: var(--sipa-header-bg);
            border-bottom: 1px solid rgba(46, 96, 55, 0.2);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .login-topbar img {
            height: 48px;
            width: auto;
        }
        .login-topbar h1 {
            color: var(--sipa-header-text);
            font-family: 'Outfit', sans-serif;
            font-size: 1.45rem;
            font-weight: 700;
            margin: 0;
        }
        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .login-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 10px 30px -5px rgba(20, 60, 35, 0.12);
            border: 1px solid #d1fae5;
            transition: transform 0.2s;
        }
        .login-card-header {
            background-color: var(--sipa-header-bg);
            border-bottom: 1px solid rgba(46, 96, 55, 0.15);
            padding: 1.25rem 1.5rem;
            text-align: center;
        }
        .login-card-header h2 {
            font-family: 'Outfit', sans-serif;
            color: var(--sipa-header-text);
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }
        .login-card-body {
            padding: 2rem;
        }
        .form-label-sipa {
            color: #2b5433;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
        }
        .input-sipa {
            border-radius: 10px;
            border: 1.5px solid #cbd5e1;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.2s;
            text-align: center;
        }
        .input-sipa:focus {
            border-color: var(--sipa-green);
            box-shadow: 0 0 0 3px rgba(29, 157, 116, 0.2);
            outline: none;
        }
        .btn-acceder {
            background: #ffffff;
            color: var(--sipa-green);
            border: 2px solid var(--sipa-green);
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            padding: 0.65rem 2rem;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .btn-acceder:hover {
            background: var(--sipa-green);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(29, 157, 116, 0.3);
        }
    </style>
</head>
<body>

    <!-- Top header matching Figure 1 -->
    <header class="login-topbar">
        <img src="<?= $asset('/img/uni.png') ?>" alt="Universidad de Córdoba">
        <h1>Sistemas Prácticas Académicas Unicordoba</h1>
    </header>

    <main class="login-wrapper">
        <div class="login-card">
            <div class="login-card-header">
                <h2>Autenticación Sipa</h2>
            </div>
            <div class="login-card-body">
                <form id="formLogin">
                    <div class="mb-3">
                        <label for="user" class="form-label form-label-sipa">Usuario:</label>
                        <input type="text" class="form-control input-sipa" id="user" name="user" placeholder="Digite el Usuario" required autocomplete="username" autofocus>
                    </div>
                    <div class="mb-4">
                        <label for="pass" class="form-label form-label-sipa">Contraseña:</label>
                        <input type="password" class="form-control input-sipa" id="pass" name="pass" placeholder="Digite la Contraseña" required autocomplete="current-password">
                    </div>
                    <div class="text-center pt-2">
                        <button type="submit" id="acceder" class="btn btn-acceder w-100">
                            <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Acceder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#formLogin').on('submit', function(e) {
                e.preventDefault();
                var user = $('#user').val().trim();
                var pass = $('#pass').val();

                if (!user || !pass) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos requeridos',
                        text: 'Por favor complete su usuario y contraseña',
                        confirmButtonColor: '#1d9d74'
                    });
                    return;
                }

                var btn = $('#acceder');
                btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Verificando...');

                $.ajax({
                    url: '<?= $url('/login/autenticar') ?>',
                    type: 'POST',
                    data: { user: user, pass: pass },
                    success: function(resp) {
                        window.location.href = '<?= $url('/autorizar') ?>';
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Acceder');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de Autenticación',
                            text: 'Los Datos No son Correctos, Ingreselo de Nuevo',
                            confirmButtonColor: '#1d9d74'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
