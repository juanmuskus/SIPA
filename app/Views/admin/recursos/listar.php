<div class="content-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="fw-bold text-dark">Listar Recursos Especiales</h2>
        <div class="subtitle text-muted">Catálogo de recursos especiales asignables a las prácticas académicas</div>
    </div>
    <a href="<?= $url('/recurespeciales/agregarrecurespeciales') ?>" class="btn btn-sipa">
        <i class="fa-solid fa-plus-circle me-1"></i> Agregar Recurso
    </a>
</div>

<div class="table-responsive">
    <table class="table table-sipa sipa-datatable align-middle">
        <thead>
            <tr>
                <th>Nombre del Recurso Especial</th>
                <th class="text-center" style="width: 100px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recursos as $r): ?>
                <tr>
                    <td class="fw-medium">
                        <i class="fa-solid fa-gem text-success me-2"></i> <?= $e($r['nombre']) ?>
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-1">
                            <a href="<?= $url('/recurespeciales/editarrecurespeciales?id=' . $r['id_recursos']) ?>" 
                               class="btn-action-edit" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" 
                                    class="btn-action-delete btn-delete-recurso border-0" 
                                    data-id="<?= $r['id_recursos'] ?>" 
                                    data-name="<?= $e($r['nombre']) ?>"
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
    $(document).on('click', '.btn-delete-recurso', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');

        Swal.fire({
            title: 'Confirmar recurso especial',
            text: '¿Está seguro de borrar el recurso especial: ' + name + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1d9d74',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= $url('/recurespeciales/eliminarrecurespeciales') ?>', { recurso_id: id }, function() {
                    Swal.fire({
                        title: 'Eliminado',
                        text: 'El recurso ha sido eliminado.',
                        icon: 'success',
                        confirmButtonColor: '#1d9d74'
                    }).then(() => {
                        window.location.reload();
                    });
                }).fail(function() {
                    Swal.fire('Error', 'No se pudo eliminar el recurso especial', 'error');
                });
            }
        });
    });
});
</script>
