<div class="content-header mb-4">
    <h2 class="fw-bold text-center text-dark">Agregar Calendario Académico</h2>
</div>

<div class="card border border-success-subtle shadow-sm rounded-4 overflow-hidden mx-auto" style="max-width: 650px;">
    <div class="card-header bg-success-subtle border-bottom border-success-subtle py-3 px-4">
        <h5 class="card-title fw-bold text-success-emphasis mb-0">Datos del Calendario Académico</h5>
    </div>
    <div class="card-body p-4">
        <form id="formCalendario">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="annio" class="form-label">Año</label>
                    <select class="form-select" id="annio" name="annio" required>
                        <option value="">Seleccione una Opción...</option>
                        <?php foreach ($annios as $a): ?>
                            <option value="<?= $e($a['id_annio']) ?>"><?= $e($a['annio']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="periodo" class="form-label">Periodo</label>
                    <select class="form-select" id="periodo" name="periodo" required>
                        <option value="">Seleccione una Opción...</option>
                        <?php foreach ($periodos as $p): ?>
                            <option value="<?= $e($p['id_periodo']) ?>"><?= $e($p['periodo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                </div>
                <div class="col-md-6">
                    <label for="fecha_final" class="form-label">Fecha Final</label>
                    <input type="date" class="form-control" id="fecha_final" name="fecha_final" required>
                </div>
            </div>

            <div class="text-center pt-2">
                <button type="submit" id="btnGuardarCal" class="btn btn-sipa px-5 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#formCalendario').on('submit', function(e) {
        e.preventDefault();

        var data = {
            annio: $('#annio').val(),
            periodo: $('#periodo').val(),
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_final: $('#fecha_final').val()
        };

        var btn = $('#btnGuardarCal');
        btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Guardando...');

        $.ajax({
            url: '<?= $url('/calendar/guardarcalendar') ?>',
            type: 'POST',
            data: data,
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Guardado!',
                    text: 'El calendario ha sido registrado correctamente.',
                    confirmButtonColor: '#1d9d74'
                }).then(() => {
                    window.location.href = '<?= $url('/calendar/listarcalendar') ?>';
                });
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Guardar');
                Swal.fire('Error', 'No se pudo guardar el calendario.', 'error');
            }
        });
    });
});
</script>
