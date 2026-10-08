<?php
/**
 * @var array $calendario
 * @var array $docentes
 * @var array $auxiliares
 * @var array $asesores
 * @var array $rutas
 * @var array $recursos
 * @var array $facultades
 * @var int $rol
 * @var array $user
 * @var callable $url
 * @var callable $e
 */
$cal = $calendario[0] ?? null;
$editando = is_array($practica ?? null);
$practicaJson = json_encode($practica ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
$programacionesJson = json_encode($programaciones ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
?>

<div class="content-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-secondary-emphasis mb-1">
            <i class="fa-solid <?= $editando ? 'fa-pen-to-square' : 'fa-plus-circle' ?> text-success me-2"></i><?= $editando ? 'Editar Práctica' : 'Agregar Práctica' ?>
        </h2>
        <p class="text-muted mb-0"><?= $editando ? 'Actualice los datos y la programación de la práctica' : 'Complete los datos para registrar una nueva práctica académica' ?></p>
    </div>
    <a href="<?= $url('/practicas/listarpractica') ?>" class="btn btn-outline-secondary rounded-pill">
        <i class="fa-solid fa-arrow-left me-1"></i> Regresar
    </a>
</div>

<?php if (!$cal && !$editando): ?>
<div class="alert alert-warning rounded-4">
    <i class="fa-solid fa-triangle-exclamation me-2"></i>
    <strong>No hay calendario activo.</strong> Solicite al administrador que active un período académico antes de registrar prácticas.
</div>
<?php else: ?>

<?php if (!$cal && $editando): ?>
<div class="alert alert-warning rounded-4">No hay un calendario activo. Puede actualizar esta práctica; su período académico original se conservará.</div>
<?php endif; ?>

<?php if ($cal): ?>
<div class="alert alert-info-subtle rounded-3 mb-4" style="background:#f0fdf4; border:1px solid #bbf7d0; padding:0.75rem 1rem;">
    <i class="fa-solid fa-calendar-check text-success me-2"></i>
    <strong>Período activo:</strong> <?= $e($cal['annio_nombre'] ?? '') ?> – Período <?= $e($cal['periodo_nombre'] ?? '') ?>
    &nbsp; <small class="text-muted">(<?= $e($cal['fecha_inicio']) ?> → <?= $e($cal['fecha_fin']) ?>)</small>
</div>
<?php endif; ?>

<form id="formPractica" class="needs-validation" novalidate>
    <input type="hidden" name="id" value="<?= $editando ? (int)$practica['cod_practica'] : 0 ?>">

    <!-- Datos Generales -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-success text-white rounded-top-4 fw-semibold">
            <i class="fa-solid fa-book me-2"></i>Datos Generales de la Práctica
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nombre de la Práctica *</label>
                    <input type="text" class="form-control" id="nom" name="nom" required placeholder="Ej: Práctica de Campo Ecología" value="<?= $e($practica['nombre'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tipo de Práctica *</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="">-- Seleccionar --</option>
                        <?php foreach (['Prácticas Externas de laboratorio', 'Prácticas de campo', 'Visitas Académicas', 'Intercambio'] as $tipo): ?>
                        <option value="<?= $e($tipo) ?>" <?= ($practica['tipo_practica'] ?? '') === $tipo ? 'selected' : '' ?>><?= $e($tipo) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Docente Solicitante *</label>
                    <select class="form-select" id="nombre" name="nombre" required>
                        <option value="">-- Seleccionar Docente --</option>
                        <?php foreach ($docentes as $d): ?>
                        <option value="<?= $e($d['cod']) ?>" <?= (string)($practica['nom_solicitante'] ?? '') === (string)$d['cod'] ? 'selected' : '' ?>><?= $e($d['ape'] . ' ' . $d['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">N° Estudiantes *</label>
                    <input type="number" class="form-control" id="num" name="num" min="1" required value="<?= $e($practica['num_estudiantes'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Semestre</label>
                    <select class="form-select" id="sem" name="sem">
                        <option value="">-- Sem --</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Académico: Facultad > Departamento > Programa > Asignatura > Grupo -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-primary text-white rounded-top-4 fw-semibold">
            <i class="fa-solid fa-university me-2"></i>Información Académica
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Facultad *</label>
                    <select class="form-select" id="fac" name="fac" required>
                        <option value="">-- Seleccionar Facultad --</option>
                        <?php foreach ($facultades as $fac): ?>
                        <?php $facultadId = $fac['id_facultad'] ?? $fac['ID']; ?>
                        <option value="<?= $e($facultadId) ?>" <?= (string)($practica['facultad'] ?? '') === (string)$facultadId ? 'selected' : '' ?>><?= $e($fac['nombre'] ?? $fac['Facultad'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Departamento *</label>
                    <select class="form-select" id="dep" name="dep" required>
                        <option value="">-- Primero seleccione facultad --</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Programa *</label>
                    <select class="form-select" id="pro" name="pro" required>
                        <option value="">-- Primero seleccione departamento --</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Asignatura *</label>
                    <select class="form-select" id="asigna" name="asigna" required>
                        <option value="">-- Primero seleccione semestre --</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Grupo</label>
                    <select class="form-select" id="gru" name="gru">
                        <option value="">-- Primero seleccione asignatura --</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Justificación y Objetivos -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-info text-white rounded-top-4 fw-semibold">
            <i class="fa-solid fa-align-left me-2"></i>Justificación y Objetivos
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Justificación *</label>
                    <textarea class="form-control" id="jus" name="jus" rows="3" required placeholder="Describa la justificación de la práctica..."><?= $e($practica['justificacion'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Objetivo</label>
                    <textarea class="form-control" id="obj" name="obj" rows="2" placeholder="Objetivo general de la práctica..."><?= $e($practica['objetivo'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Actividades del Docente</label>
                    <textarea class="form-control" id="adoc" name="adoc" rows="2" placeholder="Actividades a desarrollar..."><?= $e($practica['actividad_doc'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Actividades del Estudiante</label>
                    <textarea class="form-control" id="est" name="est" rows="2" placeholder="Actividades del estudiante..."><?= $e($practica['actividad_est'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Programación Diaria -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-warning text-dark rounded-top-4 fw-semibold d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-calendar-days me-2"></i>Programación de Días</span>
            <button type="button" class="btn btn-sm btn-dark" onclick="agregarDia()">
                <i class="fa-solid fa-plus me-1"></i>Agregar Día
            </button>
        </div>
        <div class="card-body p-4">
            <div id="diasContainer">
                <!-- Days will be added dynamically -->
            </div>
            <div class="text-muted small mt-2">
                <i class="fa-solid fa-circle-info me-1"></i>Agregue al menos un día de programación.
            </div>
        </div>
    </div>

    <div class="d-flex gap-3 justify-content-end">
        <a href="<?= $url('/practicas/listarpractica') ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa-solid fa-xmark me-1"></i>Cancelar
        </a>
        <button type="button" class="btn btn-sipa rounded-pill px-5" onclick="guardarPractica()">
            <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Práctica
        </button>
    </div>
</form>

<!-- Template for a day row -->
<template id="templateDia">
    <div class="dia-row border rounded-3 p-3 mb-3" data-dia="__NUM__">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-semibold text-warning mb-0"><i class="fa-solid fa-sun me-2"></i>Día __NUM__</h6>
            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="eliminarDia(this)">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Fecha Salida *</label>
                <input type="date" class="form-control form-control-sm" name="fecha_salida">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Fecha Llegada</label>
                <input type="date" class="form-control form-control-sm" name="fecha_llegada">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Ruta</label>
                <select class="form-select form-select-sm" name="recorrido">
                    <option value="">-- Sin ruta --</option>
                    <?php foreach ($rutas as $r): ?>
                    <option value="<?= $e($r['cod_ruta']) ?>"><?= $e($r['origen'] . ' → ' . $r['destino']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">¿Pernoctado?</label>
                <select class="form-select form-select-sm" name="pernoctado">
                    <option value="No">No</option>
                    <option value="Si">Si</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Lugar de Encuentro</label>
                <input type="text" class="form-control form-control-sm" name="lugar" placeholder="Ej: Parque Principal">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Auxiliar</label>
                <select class="form-select form-select-sm" name="auxiliar">
                    <option value="0">-- Sin auxiliar --</option>
                    <?php foreach ($auxiliares as $ax): ?>
                    <option value="<?= $e($ax['id_participante']) ?>"><?= $e($ax['nombre'] . ' ' . ($ax['apellido'] ?? '')) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Asesor</label>
                <select class="form-select form-select-sm" name="asesor">
                    <option value="0">-- Sin asesor --</option>
                    <?php foreach ($asesores as $as): ?>
                    <option value="<?= $e($as['id_participante']) ?>"><?= $e($as['nombre'] . ' ' . ($as['apellido'] ?? '')) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Recursos Especiales</label>
                <select class="form-select form-select-sm" name="recursos" multiple>
                    <?php foreach ($recursos as $rec): ?>
                    <option value="<?= $e($rec['id_pro']) ?>"><?= $e($rec['nombre']) ?> (<?= '$' . number_format((float)$rec['valor'], 0, ',', '.') ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Observaciones</label>
                <input type="text" class="form-control form-control-sm" name="observaciones" placeholder="Observaciones del día...">
            </div>
        </div>
    </div>
</template>

<script>
let diaCount = 0;

function agregarDia(programacion = null) {
    diaCount++;
    const template = document.getElementById('templateDia').innerHTML.replace(/__NUM__/g, diaCount);
    document.getElementById('diasContainer').insertAdjacentHTML('beforeend', template);

    if (programacion) {
        const row = document.querySelector('#diasContainer .dia-row:last-child');
        const setValue = (name, value) => {
            const input = row.querySelector(`[name="${name}"]`);
            if (input && value !== null && value !== undefined) input.value = String(value).substring(0, 10);
        };
        setValue('fecha_salida', programacion.fecha_salida);
        setValue('fecha_llegada', programacion.fecha_llegada);
        setValue('recorrido', programacion.recorrido);
        setValue('pernoctado', programacion.dias_pernoctados);
        setValue('lugar', programacion.lugar_encuentro);
        setValue('observaciones', programacion.observaciones);

        const participantePorTipo = tipo => (programacion.participantes || []).find(participante => participante.tipo_participante === tipo)?.id_participante ?? '0';
        setValue('auxiliar', participantePorTipo('auxiliar'));
        setValue('asesor', participantePorTipo('asesor'));
        const recursosIds = new Set((programacion.recursos || []).map(recurso => String(recurso.id_pro)));
        row.querySelectorAll('[name="recursos"] option').forEach(option => {
            option.selected = recursosIds.has(String(option.value));
        });
    }
}

function eliminarDia(btn) {
    btn.closest('.dia-row').remove();
}

function cargarOpciones(selector, endpoint, params, valueKey, labelKey, placeholder, selectedValue = '') {
    const $select = $(selector);
    $select.empty().append(new Option('Cargando...', ''));

    return $.getJSON(SIPA_BASE + endpoint, params).then(items => {
        $select.empty().append(new Option(placeholder, ''));
        items.forEach(item => $select.append(new Option(item[labelKey] ?? '', item[valueKey] ?? '')));
        $select.val(String(selectedValue));
    }).fail(() => {
        $select.empty().append(new Option('No se pudieron cargar los datos', ''));
        Swal.fire('Error', 'No se pudieron cargar los datos académicos. Verifique la conexión e inténtelo de nuevo.', 'error');
    });
}

function restaurarDatosAcademicos(practica) {
    const facultad = String(practica.facultad ?? '');
    const departamento = String(practica.departamento ?? '');
    const programa = String(practica.programa ?? '');
    const semestre = String(practica.semestre ?? '');
    const asignatura = String(practica.asignatura ?? '');
    const grupo = String(practica.grupo ?? '');

    $('#fac').val(facultad);
    if (!facultad) return;
    cargarOpciones('#dep', '/practicas/obtenerdepartamento', {facultad}, 'ID', 'Departa', '-- Seleccionar --', departamento)
        .then(() => departamento && cargarOpciones('#pro', '/practicas/obtenerprogramas', {departamento}, 'ID_Programa', 'Programa', '-- Seleccionar --', programa))
        .then(() => programa && cargarOpciones('#sem', '/practicas/obtenersemestre', {programas: programa}, 'sem', 'sem', '-- Sem --', semestre))
        .then(() => programa && semestre && cargarOpciones('#asigna', '/practicas/obtenerasignatura', {semestre, programa}, 'id_asigna', 'asigna', '-- Seleccionar --', asignatura))
        .then(() => asignatura && cargarOpciones('#gru', '/practicas/obtenergrupos', {asignatura}, 'gru', 'gru', '-- Seleccionar --', grupo))
        .catch(() => {});
}

$('#fac').on('change', function() {
    const facultad = $(this).val();
    $('#dep, #pro, #asigna, #gru, #sem').empty().append(new Option('-- Seleccionar --', ''));
    if (facultad) cargarOpciones('#dep', '/practicas/obtenerdepartamento', {facultad}, 'ID', 'Departa', '-- Seleccionar --');
});

$('#dep').on('change', function() {
    const departamento = $(this).val();
    $('#pro, #asigna, #gru, #sem').empty().append(new Option('-- Seleccionar --', ''));
    if (departamento) cargarOpciones('#pro', '/practicas/obtenerprogramas', {departamento}, 'ID_Programa', 'Programa', '-- Seleccionar --');
});

$('#pro').on('change', function() {
    const programa = $(this).val();
    $('#asigna, #gru, #sem').empty().append(new Option('-- Seleccionar --', ''));
    if (programa) cargarOpciones('#sem', '/practicas/obtenersemestre', {programas: programa}, 'sem', 'sem', '-- Sem --');
});

$('#sem').on('change', function() {
    const semestre = $(this).val();
    const programa = $('#pro').val();
    $('#asigna, #gru').empty().append(new Option('-- Seleccionar --', ''));
    if (semestre && programa) cargarOpciones('#asigna', '/practicas/obtenerasignatura', {semestre, programa}, 'id_asigna', 'asigna', '-- Seleccionar --');
});

$('#asigna').on('change', function() {
    const asignatura = $(this).val();
    $('#gru').empty().append(new Option('-- Seleccionar --', ''));
    if (asignatura) cargarOpciones('#gru', '/practicas/obtenergrupos', {asignatura}, 'gru', 'gru', '-- Seleccionar --');
});

$('#gru').on('change', function() {
    const grupo = $(this).val();
    if (!grupo) return;
    $.getJSON(SIPA_BASE + '/practicas/obtenermatriculados', {grupo})
        .done(data => { if (data[0]) $('#num').val(data[0].mat); })
        .fail(() => Swal.fire('Error', 'No se pudo consultar el número de estudiantes del grupo.', 'error'));
});

function guardarPractica() {
    const dias = [];
    document.querySelectorAll('.dia-row').forEach((row, idx) => {
        const get = name => row.querySelector(`[name="${name}"]`)?.value ?? '';
        const recSelects = row.querySelectorAll('[name="recursos"] option:checked');
        const recIds = Array.from(recSelects).map(o => o.value).join(',');
        dias.push([
            String(idx + 1),
            get('recorrido'),
            get('fecha_salida'),
            get('lugar'),
            get('pernoctado'),
            get('fecha_llegada'),
            get('auxiliar'),
            get('asesor'),
            '',
            get('observaciones'),
            '',
            recIds
        ]);
    });

    if (dias.length === 0) {
        Swal.fire('Error', 'Debe agregar al menos un día de programación.', 'error');
        return;
    }

    const datos = {
        nom: $('#nom').val(),
        num: $('#num').val(),
        nombre: $('#nombre').val(),
        jus: $('#jus').val(),
        obj: $('#obj').val(),
        adoc: $('#adoc').val(),
        est: $('#est').val(),
        tipo: $('#tipo').val(),
        sem: $('#sem').val(),
        fac: $('#fac').val(),
        dep: $('#dep').val(),
        pro: $('#pro').val(),
        asigna: $('#asigna').val(),
        gru: $('#gru').val()
    };

    const params = new URLSearchParams();
    params.append('id', document.querySelector('input[name="id"]').value);
    params.append('datos', new URLSearchParams(datos).toString());
    dias.forEach(dia => {
        dia.forEach((val, i) => params.append(`programacion[][${i}]`, val));
    });

    $.ajax({
        url: SIPA_BASE + '/practicas/guardarpractica',
        method: 'POST',
        data: params.toString(),
        contentType: 'application/x-www-form-urlencoded',
        success: function(resp) {
            Swal.fire('¡Guardado!', resp, 'success').then(() => {
                window.location.href = SIPA_BASE + '/practicas/listarpractica';
            });
        },
        error: function(xhr) {
            Swal.fire('Error', xhr.responseText || 'No se pudo guardar', 'error');
        }
    });
}

// Add first day by default
$(document).ready(function() {
    const existingPractice = <?= $practicaJson ?: '[]' ?>;
    const existingProgramaciones = <?= $programacionesJson ?: '[]' ?>;

    if (existingProgramaciones.length > 0) {
        existingProgramaciones.forEach(programacion => agregarDia(programacion));
    } else {
        agregarDia();
    }

    if (existingPractice.cod_practica) restaurarDatosAcademicos(existingPractice);
});
</script>

<?php endif; ?>
