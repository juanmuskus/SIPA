<div class="content-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="fw-bold text-dark">Listar Rutas</h2>
        <div class="subtitle text-muted">Rutas disponibles para la programación de prácticas académicas</div>
    </div>
    <a href="<?= $url('/rutas/agregarruta') ?>" class="btn btn-sipa">
        <i class="fa-solid fa-plus-circle me-1"></i> Agregar Ruta
    </a>
</div>

<div class="table-responsive">
    <table class="table table-sipa sipa-datatable align-middle">
        <thead>
            <tr>
                <th>Origen</th>
                <th>Destino</th>
                <th>Ruta</th>
                <th>Sitio</th>
                <th class="text-center" style="width: 100px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rutas as $r): ?>
                <tr>
                    <td class="fw-medium"><?= $e($r['origen']) ?></td>
                    <td class="fw-medium"><?= $e($r['destino']) ?></td>
                    <td><?= $e($r['ruta']) ?></td>
                    <td>
                        <span class="badge <?= ($r['sitio'] === 'Departamento' ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-success-subtle text-success border border-success-subtle') ?>">
                            <?= $e($r['sitio']) ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-1">
                            <a href="<?= $url('/rutas/editarruta?id=' . $r['cod_ruta']) ?>" 
                               class="btn-action-edit" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" 
                                    class="btn-action-delete btn-delete-ruta border-0" 
                                    data-id="<?= $r['cod_ruta'] ?>" 
                                    data-name="<?= $e($r['ruta']) ?>"
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
    $(document).on('click', '.btn-delete-ruta', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');

        Swal.fire({
            title: 'Confirmar Ruta',
            text: '¿Está seguro de borrar la ruta: ' + name + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1d9d74',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= $url('/rutas/eliminarruta') ?>', { ruta_id: id }, function() {
                    Swal.fire({
                        title: 'Eliminado',
                        text: 'La ruta ha sido eliminada con éxito.',
                        icon: 'success',
                        confirmButtonColor: '#1d9d74'
                    }).then(() => {
                        window.location.reload();
                    });
                }).fail(function() {
                    Swal.fire('Error', 'No se pudo eliminar la ruta', 'error');
                });
            }
        });
    });
});
</script>
