<div class="content-header mb-4">
    <h2 class="fw-bold text-center text-dark">Editar Usuario</h2>
</div>

<div class="card border border-success-subtle shadow-sm rounded-4 overflow-hidden mx-auto" style="max-width: 750px;">
    <div class="card-header bg-success-subtle border-bottom border-success-subtle py-3 px-4">
        <h5 class="card-title fw-bold text-success-emphasis mb-0">Datos del Usuario</h5>
    </div>
    <div class="card-body p-4">
        <form id="formEditarUsuario">
            <input type="hidden" id="id" name="id" value="<?= $e($usuario['id_usuario']) ?>">

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="nom" class="form-label">Nombres</label>
                    <input type="text" class="form-control" id="nom" name="nom" required value="<?= $e($usuario['nombre']) ?>">
                </div>
                <div class="col-md-6">
                    <label for="ape" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="ape" name="ape" required value="<?= $e($usuario['apellidos']) ?>">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="ide" class="form-label">Identificación</label>
                    <input type="number" class="form-control" id="ide" name="ide" required value="<?= $e($usuario['identificacion']) ?>">
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" required value="<?= $e($usuario['correo']) ?>">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required value="<?= $e($usuario['usuario']) ?>">
                </div>
                <div class="col-md-6">
                    <label for="pass" class="form-label">Nueva Contraseña (opcional)</label>
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Dejar en blanco para no cambiar">
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="programa" class="form-label">Nombre del Programa</label>
                    <select class="form-select" id="programa" name="programa">
                        <option value="0">Seleccione un Programa...</option>
                        <?php foreach ($programas as $p): ?>
                            <?php $pId = (string)($p['id'] ?? $p['ID_Programa']); ?>
                            <option value="<?= $e($pId) ?>" <?= ($pId === (string)$usuario['cod_progra_power'] ? 'selected' : '') ?>>
                                <?= $e($p['nombre'] ?? $p['Programa']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="rol" class="form-label">Rol</label>
                    <select class="form-select" id="rol" name="rol" required>
                        <?php foreach ($roles as $r): ?>
                            <option value="<?= $e($r['id_rol']) ?>" <?= ((int)$r['id_rol'] === (int)$usuario['id_rol'] ? 'selected' : '') ?>>
                                <?= $e($r['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="text-center pt-2">
                <button type="submit" id="btnActualizar" class="btn btn-sipa px-5 py-2">
                    <i class="fa-solid fa-arrows-rotate me-2"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#formEditarUsuario').on('submit', function(e) {
        e.preventDefault();

        var data = {
            id: $('#id').val(),
            nom: $('#nom').val().trim(),
            ape: $('#ape').val().trim(),
            ide: $('#ide').val().trim(),
            correo: $('#correo').val().trim(),
            usuario: $('#usuario').val().trim(),
            pass: $('#pass').val(),
            programa: $('#programa').val(),
            rol: $('#rol').val()
        };

        var btn = $('#btnActualizar');
        btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Actualizando...');

        $.ajax({
            url: '<?= $url('/usuarios/actualizarusuario') ?>',
            type: 'POST',
            data: data,
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: 'El usuario ha sido actualizado correctamente.',
                    confirmButtonColor: '#1d9d74'
                }).then(() => {
                    window.location.href = '<?= $url('/usuarios/listarusuario') ?>';
                });
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-arrows-rotate me-2"></i> Actualizar');
                Swal.fire('Error', 'No se pudo actualizar el usuario.', 'error');
            }
        });
    });
});
</script>
