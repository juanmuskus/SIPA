<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1">Servicios de transporte</h2>
        <div class="subtitle text-muted">Servicios asignados a la programación de las prácticas</div>
    </div>
    <a href="<?= $url('/servicio/agregarservicio') ?>" class="btn btn-sipa"><i class="fa-solid fa-plus-circle me-1"></i> Agregar servicio</a>
</div>
<div class="table-responsive">
    <table class="table table-sipa sipa-datatable align-middle">
        <thead><tr><th>Servicio</th><th>Práctica</th><th>Día</th><th>Valor</th><th>Observación</th><th class="text-center">Acciones</th></tr></thead>
        <tbody>
            <?php foreach ($servicios as $servicio): ?>
                <tr>
                    <td><?= $e($servicio['tipo'] ?? '') ?></td>
                    <td><?= $e($servicio['cod_practica'] ?? '') ?></td>
                    <td><?= $e($servicio['num_dias'] ?? '') ?></td>
                    <td><?= $e(number_format((float)($servicio['valor'] ?? 0), 2, ',', '.')) ?></td>
                    <td><?= $e($servicio['observacion'] ?? '') ?></td>
                    <td class="text-center">
                        <a href="<?= $url('/servicio/editarservicio?id=' . (int)$servicio['cod_servicio']) ?>" class="btn-action-edit" title="Editar"><i class="fa-solid fa-pen-to-square"></i></a>
                        <button type="button" class="btn-action-delete border-0 btn-delete-servicio" data-id="<?= (int)$servicio['cod_servicio'] ?>" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
$(document).on('click', '.btn-delete-servicio', function() {
    const id = $(this).data('id');
    Swal.fire({title: '¿Eliminar servicio?', text: 'Esta acción no se puede deshacer.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Eliminar', cancelButtonText: 'Cancelar'}).then(result => {
        if (!result.isConfirmed) return;
        $.post('<?= $url('/servicio/eliminarservicio') ?>', {servicio_id: id})
            .done(() => window.location.reload())
            .fail(() => Swal.fire('Error', 'No se pudo eliminar el servicio.', 'error'));
    });
});
</script>
