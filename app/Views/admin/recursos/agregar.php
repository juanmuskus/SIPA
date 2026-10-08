<div class="content-header mb-4">
    <h2 class="fw-bold text-center text-dark">Agregar Los Recursos Especiales</h2>
</div>

<div class="card border border-success-subtle shadow-sm rounded-4 overflow-hidden mx-auto" style="max-width: 600px;">
    <div class="card-header bg-success-subtle border-bottom border-success-subtle py-3 px-4">
        <h5 class="card-title fw-bold text-success-emphasis mb-0">Datos de los Recursos</h5>
    </div>
    <div class="card-body p-4">
        <form id="formRecurso">
            <div class="mb-4">
                <label for="nom" class="form-label">Nombre del Recurso Especial</label>
                <input type="text" class="form-control" id="nom" name="nom" required placeholder="Ej: Gastos de Reactivos">
            </div>

            <div class="text-center pt-2">
                <button type="submit" id="btnGuardarRec" class="btn btn-sipa px-5 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#formRecurso').on('submit', function(e) {
        e.preventDefault();

        var nom = $('#nom').val().trim();
        if (!nom) return;

        var btn = $('#btnGuardarRec');
        btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Guardando...');

        $.ajax({
            url: '<?= $url('/recurespeciales/guardarrecurespeciales') ?>',
            type: 'POST',
            data: { nom: nom },
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Guardado!',
                    text: 'El recurso especial ha sido guardado correctamente.',
                    confirmButtonColor: '#1d9d74'
                }).then(() => {
                    window.location.href = '<?= $url('/recurespeciales/listarrecurespeciales') ?>';
                });
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-2"></i> Guardar');
                Swal.fire('Error', 'No se pudo guardar el recurso.', 'error');
            }
        });
    });
});
</script>
