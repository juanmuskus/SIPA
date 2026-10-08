<div class="content-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="fw-bold text-dark">Listado de Usuarios</h2>
        <div class="subtitle text-muted">Gestión de cuentas y roles de acceso al sistema</div>
    </div>
    <a href="<?= $url('/usuarios/agregarusuario') ?>" class="btn btn-sipa">
        <i class="fa-solid fa-user-plus me-1"></i> Agregar Usuario
    </a>
</div>

<div class="table-responsive">
    <table class="table table-sipa sipa-datatable align-middle">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Usuario</th>
                <th>Nombre Programa</th>
                <th>Rol</th>
                <th class="text-center" style="width: 100px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td class="fw-medium"><?= $e($u['nombre']) ?></td>
                    <td><?= $e($u['apellidos']) ?></td>
                    <td><code><?= $e($u['usuario']) ?></code></td>
                    <td><span class="badge bg-light text-dark border"><?= $e($u['programa_nombre']) ?></span></td>
                    <td>
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                            <?= $e($u['rol_nombre'] ?? 'Sin Rol') ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-1">
                            <a href="<?= $url('/usuarios/editarusuario?id=' . $u['id_usuario']) ?>" 
                               class="btn-action-edit" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" 
                                    class="btn-action-delete btn-delete-user border-0" 
                                    data-id="<?= $u['id_usuario'] ?>" 
                                    data-name="<?= $e($u['nombre'] . ' ' . $u['apellidos']) ?>" 
                                    title="Eliminar">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $(document).on('click', '.btn-delete-user', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');

        Swal.fire({
            title: 'Confirmar Usuario',
            text: '¿Está seguro de borrar el usuario: ' + name + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1d9d74',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= $url('/usuarios/eliminarusuario') ?>', { usuario_id: id }, function() {
                    Swal.fire({
                        title: 'Eliminado',
                        text: 'El usuario ha sido eliminado correctamente.',
                        icon: 'success',
                        confirmButtonColor: '#1d9d74'
                    }).then(() => {
                        window.location.reload();
                    });
                }).fail(function() {
                    Swal.fire('Error', 'No se pudo eliminar el usuario', 'error');
                });
            }
        });
    });
});
</script>
