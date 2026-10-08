<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1">Conductores</h2>
        <div class="subtitle text-muted">Conductores disponibles para la logística de las prácticas</div>
    </div>
    <a href="<?= $url('/conductor/agregarconductor') ?>" class="btn btn-sipa">
        <i class="fa-solid fa-plus-circle me-1"></i> Agregar conductor
    </a>
</div>

<div class="table-responsive">
    <table class="table table-sipa sipa-datatable align-middle">
        <thead>
            <tr><th>Nombre</th><th>Identificación</th><th>Teléfono</th><th>Dirección</th><th class="text-center">Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($conductores as $conductor): ?>
                <tr>
                    <td><?= $e(trim(($conductor['nombre'] ?? '') . ' ' . ($conductor['apellido'] ?? ''))) ?></td>
                    <td><?= $e($conductor['identificacion'] ?? '') ?></td>
                    <td><?= $e($conductor['telefono'] ?? '') ?></td>
                    <td><?= $e($conductor['direccion'] ?? '') ?></td>
                    <td class="text-center">
                        <a href="<?= $url('/conductor/editarconductor?id=' . (int)$conductor['id_conductor']) ?>" class="btn-action-edit" title="Editar"><i class="fa-solid fa-pen-to-square"></i></a>
                        <button type="button" class="btn-action-delete border-0 btn-delete-conductor" data-id="<?= (int)$conductor['id_conductor'] ?>" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$(document).on('click', '.btn-delete-conductor', function() {
    const id = $(this).data('id');
    Swal.fire({title: '¿Eliminar conductor?', text: 'Esta acción no se puede deshacer.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Eliminar', cancelButtonText: 'Cancelar'}).then(result => {
        if (!result.isConfirmed) return;
        $.post('<?= $url('/conductor/eliminarconductor') ?>', {conductor_id: id})
            .done(() => window.location.reload())
            .fail(() => Swal.fire('Error', 'No se pudo eliminar el conductor.', 'error'));
    });
});
</script>
