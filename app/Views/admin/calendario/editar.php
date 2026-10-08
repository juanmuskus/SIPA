<div class="content-header mb-4">
    <h2 class="fw-bold text-center text-dark">Editar Calendario Académico</h2>
</div>

<div class="card border border-success-subtle shadow-sm rounded-4 overflow-hidden mx-auto" style="max-width: 650px;">
    <div class="card-header bg-success-subtle border-bottom border-success-subtle py-3 px-4">
        <h5 class="card-title fw-bold text-success-emphasis mb-0">Datos del Calendario Académico</h5>
    </div>
    <div class="card-body p-4">
        <form id="formEditarCal">
            <input type="hidden" id="id" name="id" value="<?= $e($calendario['id']) ?>">

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="annio" class="form-label">Año</label>
                    <select class="form-select" id="annio" name="annio" required>
                        <?php foreach ($annios as $a): ?>
                            <option value="<?= $e($a['id_annio']) ?>" <?= ((int)$a['id_annio'] === (int)$calendario['id_annio'] ? 'selected' : '') ?>>
                                <?= $e($a['annio']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="periodo" class="form-label">Periodo</label>
                    <select class="form-select" id="periodo" name="periodo" required>
                        <?php foreach ($periodos as $p): ?>
                            <option value="<?= $e($p['id_periodo']) ?>" <?= ((int)$p['id_periodo'] === (int)$calendario['id_periodo'] ? 'selected' : '') ?>>
                                <?= $e($p['periodo']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado del Calendario</label>
                <select class="form-select" id="estado" name="estado">
                    <option value="1" <?= ((int)$calendario['estado'] === 1 ? 'selected' : '') ?>>1 - Activo</option>
                    <option value="0" <?= ((int)$calendario['estado'] === 0 ? 'selected' : '') ?>>0 - Inactivo</option>
                </select>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required value="<?= $e($calendario['fecha_inicio']) ?>">
                </div>
                <div class="col-md-6">
                    <label for="fecha_final" class="form-label">Fecha Final</label>
                    <input type="date" class="form-control" id="fecha_final" name="fecha_final" required value="<?= $e($calendario['fecha_fin']) ?>">
                </div>
            </div>

            <div class="text-center pt-2">
                <button type="submit" id="btnActualizarCal" class="btn btn-sipa px-5 py-2">
                    <i class="fa-solid fa-arrows-rotate me-2"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#formEditarCal').on('submit', function(e) {
        e.preventDefault();

        var data = {
            id: $('#id').val(),
            annio: $('#annio').val(),
            periodo: $('#periodo').val(),
            estado: $('#estado').val(),
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_final: $('#fecha_final').val()
        };

        var btn = $('#btnActualizarCal');
        btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Actualizando...');

        $.ajax({
            url: '<?= $url('/calendar/actualizarcalendar') ?>',
            type: 'POST',
            data: data,
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: 'El calendario ha sido actualizado con éxito.',
                    confirmButtonColor: '#1d9d74'
                }).then(() => {
                    window.location.href = '<?= $url('/calendar/listarcalendar') ?>';
                });
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-arrows-rotate me-2"></i> Actualizar');
                Swal.fire('Error', 'No se pudo actualizar el calendario.', 'error');
            }
        });
    });
});
</script>
