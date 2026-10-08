<div class="content-header mb-4">
    <h2 class="fw-bold text-center text-dark">Agregar Ruta</h2>
</div>

<div class="card border border-success-subtle shadow-sm rounded-4 overflow-hidden mx-auto" style="max-width: 650px;">
    <div class="card-header bg-success-subtle border-bottom border-success-subtle py-3 px-4">
        <h5 class="card-title fw-bold text-success-emphasis mb-0">Datos de la Ruta</h5>
    </div>
    <div class="card-body p-4">
        <form id="formRuta">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="origen" class="form-label">Origen</label>
                    <input type="text" class="form-control" id="origen" name="origen" required placeholder="Origen">
                </div>
                <div class="col-md-6">
                    <label for="destino" class="form-label">Destino</label>
                    <input type="text" class="form-control" id="destino" name="destino" required placeholder="Destino">
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="ruta" class="form-label">Ruta</label>
                    <input type="text" class="form-control" id="ruta" name="ruta" required placeholder="Ej: Monteria-Santarnarta-Tahirona">
                </div>
                <div class="col-md-6">
                    <label for="sitio" class="form-label">Sitio</label>
                    <select class="form-select" id="sitio" name="sitio" required>
                        <option value="Municipio">Municipio</option>
                        <option value="Departamento">Departamento</option>
                    </select>
                </div>
            </div>

            <div class="text-center pt-2">
                <button type="submit" id="btnGuardarRuta" class="btn btn-sipa px-5 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#formRuta').on('submit', function(e) {
        e.preventDefault();

        var data = {
            origen: $('#origen').val().trim(),
            destino: $('#destino').val().trim(),
            ruta: $('#ruta').val().trim(),
            sitio: $('#sitio').val()
        };

        var btn = $('#btnGuardarRuta');
        btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Guardando...');

        $.ajax({
            url: '<?= $url('/rutas/guardarruta') ?>',
            type: 'POST',
            data: data,
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Guardado!',
                    text: 'La ruta ha sido registrada correctamente.',
                    confirmButtonColor: '#1d9d74'
                }).then(() => {
                    window.location.href = '<?= $url('/rutas/listarruta') ?>';
                });
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Guardar');
                Swal.fire('Error', 'No se pudo guardar la ruta.', 'error');
            }
        });
    });
});
</script>
