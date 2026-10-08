<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1">Vehículos</h2>
        <div class="subtitle text-muted">Vehículos disponibles para el transporte de las prácticas</div>
    </div>
    <a href="<?= $url('/transporte/agregartransporte') ?>" class="btn btn-sipa"><i class="fa-solid fa-plus-circle me-1"></i> Agregar vehículo</a>
</div>
<div class="table-responsive">
    <table class="table table-sipa sipa-datatable align-middle">
        <thead><tr><th>Placa</th><th>Descripción</th><th>Tipo</th><th>Estado</th><th>Capacidad</th><th class="text-center">Acciones</th></tr></thead>
        <tbody>
            <?php foreach ($vehiculos as $vehiculo): ?>
                <tr>
                    <td><?= $e($vehiculo['placa'] ?? '') ?></td>
                    <td><?= $e($vehiculo['descripcion'] ?? '') ?></td>
                    <td><?= $e($vehiculo['tipo_vehiculo'] ?? '') ?></td>
                    <td><?= $e($vehiculo['estado_vehiculo'] ?? '') ?></td>
                    <td><?= $e($vehiculo['capacidad_pasajeros'] ?? '') ?></td>
                    <td class="text-center">
                        <a href="<?= $url('/transporte/editartransporte?id=' . (int)$vehiculo['cod_transporte']) ?>" class="btn-action-edit" title="Editar"><i class="fa-solid fa-pen-to-square"></i></a>
                        <button type="button" class="btn-action-delete border-0 btn-delete-vehiculo" data-id="<?= (int)$vehiculo['cod_transporte'] ?>" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
$(document).on('click', '.btn-delete-vehiculo', function() {
    const id = $(this).data('id');
    Swal.fire({title: '¿Eliminar vehículo?', text: 'Esta acción no se puede deshacer.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Eliminar', cancelButtonText: 'Cancelar'}).then(result => {
        if (!result.isConfirmed) return;
        $.post('<?= $url('/transporte/eliminartransporte') ?>', {transporte_id: id})
            .done(() => window.location.reload())
            .fail(() => Swal.fire('Error', 'No se pudo eliminar el vehículo.', 'error'));
    });
});
</script>
