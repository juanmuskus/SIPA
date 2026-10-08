<div class="content-header mb-4">
    <h2 class="fw-bold text-center text-dark">Resetear Contraseña</h2>
    <div class="subtitle text-center text-muted">Asignar una nueva clave de acceso a un usuario</div>
</div>

<div class="card border border-success-subtle shadow-sm rounded-4 overflow-hidden mx-auto" style="max-width: 550px;">
    <div class="card-header bg-success-subtle border-bottom border-success-subtle py-3 px-4">
        <h5 class="card-title fw-bold text-success-emphasis mb-0">Cambio de Contraseña</h5>
    </div>
    <div class="card-body p-4">
        <form id="formResetPass">
            <div class="mb-3">
                <label for="id_usuario" class="form-label">Seleccione Usuario</label>
                <select class="form-select" id="id_usuario" name="id_usuario" required>
                    <option value="">Seleccione un usuario...</option>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?= $e($u['id_usuario']) ?>">
                            <?= $e($u['nombre'] . ' ' . $u['apellidos'] . ' (' . $u['usuario'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="nueva_contrasena" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" required placeholder="Digite la nueva contraseña">
            </div>

            <div class="text-center pt-2">
                <button type="submit" id="btnReset" class="btn btn-sipa px-4 py-2">
                    <i class="fa-solid fa-key me-2"></i> Cambiar Contraseña
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#formResetPass').on('submit', function(e) {
        e.preventDefault();
        var id = $('#id_usuario').val();
        var pass = $('#nueva_contrasena').val();

        if (!id || !pass) return;

        $.post('<?= $url('/usuarios/actualizarcontrasena') ?>', {
            id_usuario: id,
            nueva_contrasena: pass
        }, function() {
            Swal.fire({
                icon: 'success',
                title: 'Contraseña Actualizada',
                text: 'La contraseña ha sido actualizada exitosamente.',
                confirmButtonColor: '#1d9d74'
            }).then(() => {
                window.location.href = '<?= $url('/usuarios/listarusuario') ?>';
            });
        }).fail(function() {
            Swal.fire('Error', 'No se pudo actualizar la contraseña', 'error');
        });
    });
});
</script>
