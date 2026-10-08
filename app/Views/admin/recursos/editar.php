<div class="content-header mb-4">
    <h2 class="fw-bold text-center text-dark">Editar Los Recursos Especiales</h2>
</div>

<div class="card border border-success-subtle shadow-sm rounded-4 overflow-hidden mx-auto" style="max-width: 600px;">
    <div class="card-header bg-success-subtle border-bottom border-success-subtle py-3 px-4">
        <h5 class="card-title fw-bold text-success-emphasis mb-0">Datos de los Recursos</h5>
    </div>
    <div class="card-body p-4">
        <form id="formEditarRecurso">
            <input type="hidden" id="id" name="id" value="<?= $e($recurso['id_recursos']) ?>">

            <div class="mb-4">
                <label for="nom" class="form-label">Nombre del Recurso Especial</label>
                <input type="text" class="form-control" id="nom" name="nom" required value="<?= $e($recurso['nombre']) ?>">
            </div>

            <div class="text-center pt-2">
                <button type="submit" id="btnActualizarRec" class="btn btn-sipa px-5 py-2">
                    <i class="fa-solid fa-arrows-rotate me-2"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#formEditarRecurso').on('submit', function(e) {
        e.preventDefault();

        var id = $('#id').val();
        var nom = $('#nom').val().trim();
        if (!nom) return;

        var btn = $('#btnActualizarRec');
        btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Actualizando...');

        $.ajax({
            url: '<?= $url('/recurespeciales/actualizarrecurespeciales') ?>',
            type: 'POST',
            data: { id: id, nom: nom },
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: 'El recurso especial ha sido actualizado correctamente.',
                    confirmButtonColor: '#1d9d74'
                }).then(() => {
                    window.location.href = '<?= $url('/recurespeciales/listarrecurespeciales') ?>';
                });
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-arrows-rotate me-2"></i> Actualizar');
                Swal.fire('Error', 'No se pudo actualizar el recurso.', 'error');
            }
        });
    });
});
</script>
