<div class="content-header mb-4">
    <h2 class="fw-bold text-center text-dark">Agregar Usuario</h2>
</div>

<div class="card border border-success-subtle shadow-sm rounded-4 overflow-hidden max-w-700 mx-auto" style="max-width: 750px;">
    <div class="card-header bg-success-subtle border-bottom border-success-subtle py-3 px-4">
        <h5 class="card-title fw-bold text-success-emphasis mb-0">Datos del Usuario</h5>
    </div>
    <div class="card-body p-4">
        <form id="formUsuario">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="nom" class="form-label">Nombres</label>
                    <input type="text" class="form-control" id="nom" name="nom" required placeholder="Nombres">
                </div>
                <div class="col-md-6">
                    <label for="ape" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="ape" name="ape" required placeholder="Apellidos">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="ide" class="form-label">Identificación</label>
                    <input type="number" class="form-control" id="ide" name="ide" required placeholder="Identificación">
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" required placeholder="Correo electrónico">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required placeholder="Nombre de usuario">
                </div>
                <div class="col-md-6">
                    <label for="pass" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="pass" name="pass" required placeholder="Contraseña">
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="programa" class="form-label">Nombre del Programa</label>
                    <select class="form-select" id="programa" name="programa">
                        <option value="0">Seleccione un Programa...</option>
                        <?php foreach ($programas as $p): ?>
                            <option value="<?= $e($p['id'] ?? $p['ID_Programa']) ?>">
                                <?= $e($p['nombre'] ?? $p['Programa']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="rol" class="form-label">Rol</label>
                    <select class="form-select" id="rol" name="rol" required>
                        <?php foreach ($roles as $r): ?>
                            <option value="<?= $e($r['id_rol']) ?>" <?= ((int)$r['id_rol'] === 2 ? 'selected' : '') ?>>
                                <?= $e($r['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="text-center pt-2">
                <button type="submit" id="btnGuardar" class="btn btn-sipa px-5 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#formUsuario').on('submit', function(e) {
        e.preventDefault();

        var data = {
            nom: $('#nom').val().trim(),
            ape: $('#ape').val().trim(),
            ide: $('#ide').val().trim(),
            correo: $('#correo').val().trim(),
            usuario: $('#usuario').val().trim(),
            pass: $('#pass').val(),
            programa: $('#programa').val(),
            rol: $('#rol').val()
        };

        var btn = $('#btnGuardar');
        btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Guardando...');

        $.ajax({
            url: '<?= $url('/usuarios/guardarusuario') ?>',
            type: 'POST',
            data: data,
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Guardado!',
                    text: 'El usuario ha sido registrado correctamente.',
                    confirmButtonColor: '#1d9d74'
                }).then(() => {
                    window.location.href = '<?= $url('/usuarios/listarusuario') ?>';
                });
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Guardar');
                Swal.fire('Error', 'No se pudo guardar el usuario. Verifique los datos.', 'error');
            }
        });
    });
});
</script>
