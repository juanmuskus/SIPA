<div class="content-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="fw-bold text-dark">Listar Calendario</h2>
        <div class="subtitle text-muted">Gestión de calendarios y convocatorias para prácticas académicas</div>
    </div>
    <a href="<?= $url('/calendar/agregarcalendar') ?>" class="btn btn-sipa">
        <i class="fa-solid fa-plus-circle me-1"></i> Agregar Calendario
    </a>
</div>

<div class="table-responsive">
    <table class="table table-sipa sipa-datatable align-middle">
        <thead>
            <tr>
                <th>Año</th>
                <th>Periodo</th>
                <th>Fecha Inicio</th>
                <th>Fecha Final</th>
                <th>Estado</th>
                <th class="text-center" style="width: 100px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($calendarios as $c): ?>
                <tr>
                    <td class="fw-bold"><?= $e($c['annio_nombre'] ?? $c['id_annio']) ?></td>
                    <td><span class="badge bg-light text-dark border"><?= $e($c['periodo_nombre'] ?? $c['id_periodo']) ?></span></td>
                    <td><i class="fa-regular fa-calendar-check text-success me-1"></i> <?= $e($c['fecha_inicio']) ?></td>
                    <td><i class="fa-regular fa-calendar-xmark text-danger me-1"></i> <?= $e($c['fecha_fin']) ?></td>
                    <td>
                        <?php if ((int)($c['estado'] ?? 1) === 1): ?>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary border">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex gap-1">
                            <a href="<?= $url('/calendar/editarcalendar?id=' . $c['id']) ?>" 
                               class="btn-action-edit" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" 
                                    class="btn-action-delete btn-delete-cal border-0" 
                                    data-id="<?= $c['id'] ?>" 
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
    $(document).on('click', '.btn-delete-cal', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Confirmar Calendario Académico',
            text: '¿Está seguro de borrar el calendario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1d9d74',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('<?= $url('/calendar/eliminarcalendar') ?>', { calendar_id: id }, function() {
                    Swal.fire({
                        title: 'Eliminado',
                        text: 'El calendario ha sido eliminado.',
                        icon: 'success',
                        confirmButtonColor: '#1d9d74'
                    }).then(() => {
                        window.location.reload();
                    });
                }).fail(function() {
                    Swal.fire('Error', 'No se pudo eliminar el calendario', 'error');
                });
            }
        });
    });
});
</script>
