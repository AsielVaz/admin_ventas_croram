<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Formulario de Oferta" />
    <title>Croram Admin · Oferta</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
    :root {
        --ofr-primary: #2563eb;
        --ofr-primary-soft: rgba(37,99,235,.07);
        --ofr-success: #059669;
        --ofr-warning: #d97706;
        --ofr-warning-soft: rgba(217,119,6,.08);
        --ofr-danger: #dc2626;
        --ofr-text: #1e293b;
        --ofr-text-secondary: #64748b;
        --ofr-text-muted: #94a3b8;
        --ofr-surface: #ffffff;
        --ofr-surface-alt: #f8fafc;
        --ofr-border: #e2e8f0;
        --ofr-radius: 14px;
        --ofr-radius-sm: 10px;
        --ofr-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --ofr-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--ofr-font); }

    .ofr-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--ofr-text-secondary);
    }
    .ofr-breadcrumb a { color: var(--ofr-primary); text-decoration: none; }
    .ofr-breadcrumb .sep { opacity: .4; }

    .ofr-card {
        background: var(--ofr-surface);
        border: 1px solid var(--ofr-border);
        border-radius: var(--ofr-radius);
        box-shadow: var(--ofr-shadow);
        overflow: hidden;
        animation: fadeIn .35s ease both;
    }
    .ofr-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--ofr-border);
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--ofr-text);
        background: var(--ofr-surface-alt);
    }
    .ofr-card-header .material-icons-outlined { font-size: 1.2rem; color: var(--ofr-primary); }
    .ofr-card-body { padding: 1.5rem; }

    .ofr-field { margin-bottom: 1.15rem; }
    .ofr-field label {
        display: flex; align-items: center; gap: .3rem;
        font-size: .78rem; font-weight: 600; color: var(--ofr-text-secondary);
        text-transform: uppercase; letter-spacing: .03em; margin-bottom: .4rem;
    }
    .ofr-field label .material-icons-outlined { font-size: .9rem; }
    .ofr-field input,
    .ofr-field select {
        width: 100%; border-radius: var(--ofr-radius-sm);
        border: 1px solid var(--ofr-border);
        font-family: var(--ofr-font); font-size: .875rem;
        padding: .6rem .9rem; transition: border-color .2s, box-shadow .2s;
    }
    .ofr-field input:focus,
    .ofr-field select:focus {
        border-color: var(--ofr-primary); outline: none;
        box-shadow: 0 0 0 3px var(--ofr-primary-soft);
    }
    .ofr-field input:disabled,
    .ofr-field select:disabled {
        background: var(--ofr-surface-alt); color: var(--ofr-text-muted);
        cursor: not-allowed; opacity: .6;
    }
    .ofr-field .ofr-hint {
        font-size: .73rem; color: var(--ofr-text-muted); margin-top: .3rem;
    }

    /* Section divider */
    .ofr-section {
        display: flex; align-items: center; gap: .5rem;
        margin: 1.5rem 0 1rem; padding-bottom: .5rem;
        border-bottom: 2px solid var(--ofr-border);
        font-size: .8rem; font-weight: 700; color: var(--ofr-text-secondary);
        text-transform: uppercase; letter-spacing: .05em;
    }
    .ofr-section .material-icons-outlined { font-size: 1rem; color: var(--ofr-primary); }

    /* Type selector cards */
    .ofr-type-selector {
        display: grid; grid-template-columns: 1fr 1fr; gap: .75rem;
    }
    .ofr-type-option {
        border: 2px solid var(--ofr-border);
        border-radius: var(--ofr-radius-sm);
        padding: 1rem; cursor: pointer;
        transition: all .2s; text-align: center;
    }
    .ofr-type-option:hover { border-color: var(--ofr-primary); background: var(--ofr-primary-soft); }
    .ofr-type-option.selected {
        border-color: var(--ofr-primary);
        background: var(--ofr-primary-soft);
        box-shadow: 0 0 0 1px var(--ofr-primary);
    }
    .ofr-type-option .material-icons-outlined {
        font-size: 1.8rem; display: block; margin-bottom: .35rem;
    }
    .ofr-type-option .type-label {
        font-size: .82rem; font-weight: 600; color: var(--ofr-text);
    }
    .ofr-type-option .type-desc {
        font-size: .72rem; color: var(--ofr-text-muted); margin-top: .15rem;
    }

    /* Conditional sections */
    .ofr-conditional { transition: opacity .25s, max-height .3s; overflow: hidden; }
    .ofr-conditional.hidden { opacity: .3; pointer-events: none; max-height: 0; margin: 0; padding: 0; }
    .ofr-conditional.visible { opacity: 1; pointer-events: auto; max-height: 500px; }

    .ofr-form-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 0 1.5rem;
    }
    .ofr-form-grid .ofr-full { grid-column: 1 / -1; }
    @media (max-width: 768px) { .ofr-form-grid { grid-template-columns: 1fr; } }

    .ofr-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .65rem 1.35rem; border-radius: var(--ofr-radius-sm);
        font-size: .85rem; font-weight: 600; font-family: var(--ofr-font);
        cursor: pointer; border: none; transition: all .2s; text-decoration: none;
    }
    .ofr-btn .material-icons-outlined { font-size: 1.1rem; }
    .ofr-btn-primary { background: var(--ofr-primary); color: #fff; }
    .ofr-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .ofr-btn-outline {
        background: transparent; color: var(--ofr-text-secondary);
        border: 1px solid var(--ofr-border);
    }
    .ofr-btn-outline:hover { border-color: var(--ofr-primary); color: var(--ofr-primary); }

    .select2-container--bootstrap-5 .select2-selection {
        border-radius: var(--ofr-radius-sm) !important;
        min-height: 42px !important;
        border-color: var(--ofr-border) !important;
        font-family: var(--ofr-font) !important;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin {
        from { transform: rotate(0); } to { transform: rotate(360deg); }
    }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminOfertas.php";
    include_once "api/adminProductos.php";

    $adminProductos = new AdministradorProductos();
    $adminOfertas   = new AdministradorOfertas();
    $productos      = $adminProductos->obtenerProductos();
    if (!is_array($productos)) $productos = [];

    $editar = 0;
    $oferta = null;

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $oferta = $adminOfertas->obtenerOferta($_GET['id']);
        if (is_object($oferta) && !empty($oferta->id)) {
            $editar = 1;
        }
    }

    // Safe values
    $valProdDet    = ($editar && isset($oferta->id_producto_det)) ? intval($oferta->id_producto_det)  : 0;
    $valCantDet    = ($editar && isset($oferta->cantidad_det))    ? intval($oferta->cantidad_det)      : '';
    $valTipo       = ($editar && isset($oferta->tipo))            ? intval($oferta->tipo)              : 1;
    $valProdOf     = ($editar && isset($oferta->id_producto_of))  ? intval($oferta->id_producto_of)    : 0;
    $valCantOf     = ($editar && isset($oferta->cantidad_oferta)) ? intval($oferta->cantidad_oferta)   : '';
    $valPorcOf     = ($editar && isset($oferta->porc_oferta))     ? floatval($oferta->porc_oferta)     : '';
    $valFechaIni   = ($editar && isset($oferta->fecha_inicia))    ? htmlspecialchars($oferta->fecha_inicia, ENT_QUOTES, 'UTF-8') : '';
    $valFechaFin   = ($editar && isset($oferta->fecha_fin))       ? htmlspecialchars($oferta->fecha_fin, ENT_QUOTES, 'UTF-8')    : '';
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="ofr-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <a href="ofertas.php">Ofertas</a>
                    <span class="sep">/</span>
                    <span style="color:var(--ofr-text);font-weight:600;">
                        <?php echo $editar ? 'Editar oferta' : 'Nueva oferta'; ?>
                    </span>
                </div>

                <div style="max-width:860px;">
                    <div class="ofr-card">
                        <div class="ofr-card-header">
                            <span class="material-icons-outlined"><?php echo $editar ? 'edit' : 'add_circle'; ?></span>
                            <?php echo $editar ? 'Editar oferta' : 'Crear nueva oferta'; ?>
                        </div>
                        <div class="ofr-card-body">
                            <form id="formOferta">

                                <!-- ═══ Producto detonante ═══ -->
                                <div class="ofr-section">
                                    <span class="material-icons-outlined">inventory_2</span>
                                    Producto y condición
                                </div>

                                <div class="ofr-form-grid">
                                    <div class="ofr-field">
                                        <label>
                                            <span class="material-icons-outlined">shopping_bag</span>
                                            Producto con oferta
                                        </label>
                                        <select name="producto_det" id="producto_det" required>
                                            <option value="">Seleccionar producto...</option>
                                            <?php foreach ($productos as $p):
                                                if (!is_object($p)) continue;
                                                $pid = intval($p->id ?? 0);
                                                $pnm = htmlspecialchars($p->name ?? '', ENT_QUOTES, 'UTF-8');
                                                $sel = ($pid == $valProdDet) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $pid; ?>" <?php echo $sel; ?>>
                                                <?php echo $pnm; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="ofr-hint">Producto al que se le aplicará la oferta.</p>
                                    </div>

                                    <div class="ofr-field">
                                        <label>
                                            <span class="material-icons-outlined">tag</span>
                                            Cantidad detonante
                                        </label>
                                        <input type="number" name="cantidad_det" id="cantidad_det"
                                               min="1" placeholder="Ej: 5"
                                               value="<?php echo $valCantDet; ?>" required />
                                        <p class="ofr-hint">Cuántas unidades debe comprar para activar la oferta.</p>
                                    </div>
                                </div>

                                <!-- ═══ Tipo de oferta ═══ -->
                                <div class="ofr-section">
                                    <span class="material-icons-outlined">style</span>
                                    Tipo de oferta
                                </div>

                                <div class="ofr-type-selector" id="typeSelector">
                                    <div class="ofr-type-option <?php echo ($valTipo === 1) ? 'selected' : ''; ?>"
                                         data-value="1" onclick="selectType(1)">
                                        <span class="material-icons-outlined" style="color:var(--ofr-primary);">card_giftcard</span>
                                        <div class="type-label">Producto gratis</div>
                                        <div class="type-desc">Regala unidades de un producto al cumplir la condición</div>
                                    </div>
                                    <div class="ofr-type-option <?php echo ($valTipo === 2) ? 'selected' : ''; ?>"
                                         data-value="2" onclick="selectType(2)">
                                        <span class="material-icons-outlined" style="color:var(--ofr-warning);">percent</span>
                                        <div class="type-label">Descuento en porcentaje</div>
                                        <div class="type-desc">Aplica un % de descuento sobre el precio del producto</div>
                                    </div>
                                </div>
                                <input type="hidden" name="tipo_oferta" id="tipo_oferta" value="<?php echo $valTipo; ?>" />

                                <!-- ═══ Campos tipo 1: Producto gratis ═══ -->
                                <div id="seccionGratis" class="ofr-conditional <?php echo ($valTipo === 1) ? 'visible' : 'hidden'; ?>">
                                    <div class="ofr-section">
                                        <span class="material-icons-outlined">redeem</span>
                                        Producto de regalo
                                    </div>
                                    <div class="ofr-form-grid">
                                        <div class="ofr-field">
                                            <label>
                                                <span class="material-icons-outlined">card_giftcard</span>
                                                Producto gratis
                                            </label>
                                            <select name="producto_of" id="producto_of">
                                                <option value="0">Seleccionar producto...</option>
                                                <?php foreach ($productos as $p):
                                                    if (!is_object($p)) continue;
                                                    $pid = intval($p->id ?? 0);
                                                    $pnm = htmlspecialchars($p->name ?? '', ENT_QUOTES, 'UTF-8');
                                                    $sel = ($pid == $valProdOf) ? 'selected' : '';
                                                ?>
                                                <option value="<?php echo $pid; ?>" <?php echo $sel; ?>>
                                                    <?php echo $pnm; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="ofr-field">
                                            <label>
                                                <span class="material-icons-outlined">add_shopping_cart</span>
                                                Cantidad gratis
                                            </label>
                                            <input type="number" name="cantidad_oferta" id="cantidad_oferta"
                                                   min="0" placeholder="Ej: 1"
                                                   value="<?php echo $valCantOf; ?>" />
                                        </div>
                                    </div>
                                </div>

                                <!-- ═══ Campos tipo 2: Descuento ═══ -->
                                <div id="seccionDescuento" class="ofr-conditional <?php echo ($valTipo === 2) ? 'visible' : 'hidden'; ?>">
                                    <div class="ofr-section">
                                        <span class="material-icons-outlined">savings</span>
                                        Descuento
                                    </div>
                                    <div class="ofr-form-grid">
                                        <div class="ofr-field">
                                            <label>
                                                <span class="material-icons-outlined">percent</span>
                                                Porcentaje de descuento
                                            </label>
                                            <input type="number" name="porc_oferta" id="porc_oferta"
                                                   min="0" max="100" step="0.01" placeholder="Ej: 15"
                                                   value="<?php echo $valPorcOf; ?>" />
                                            <p class="ofr-hint">Porcentaje que se descontará del precio unitario.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- ═══ Vigencia ═══ -->
                                <div class="ofr-section">
                                    <span class="material-icons-outlined">date_range</span>
                                    Vigencia
                                </div>
                                <div class="ofr-form-grid">
                                    <div class="ofr-field">
                                        <label>
                                            <span class="material-icons-outlined">event</span>
                                            Fecha inicio
                                        </label>
                                        <input type="date" name="fecha_inicia" id="fecha_inicia"
                                               value="<?php echo $valFechaIni; ?>" required />
                                    </div>
                                    <div class="ofr-field">
                                        <label>
                                            <span class="material-icons-outlined">event_busy</span>
                                            Fecha fin
                                        </label>
                                        <input type="date" name="fecha_fin" id="fecha_fin"
                                               value="<?php echo $valFechaFin; ?>" required />
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div style="display:flex;gap:.75rem;margin-top:1.5rem;justify-content:flex-end;">
                                    <a href="ofertas.php" class="ofr-btn ofr-btn-outline">
                                        <span class="material-icons-outlined">arrow_back</span>
                                        Cancelar
                                    </a>
                                    <button type="submit" class="ofr-btn ofr-btn-primary" id="btnGuardar">
                                        <span class="material-icons-outlined">save</span>
                                        <?php echo $editar ? 'Actualizar oferta' : 'Guardar oferta'; ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include 'partials/footer.php'; ?>
    </main>

    <?php include "partials/theme.php"; ?>

    <!-- Scripts -->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    var ES_EDITAR = <?php echo json_encode($editar); ?>;
    var OFERTA_ID = <?php echo json_encode($editar ? intval($oferta->id) : 0); ?>;

    /* ══ Select2 ══ */
    $(document).ready(function() {
        $('#producto_det, #producto_of').select2({
            theme: 'bootstrap-5',
            placeholder: 'Seleccionar producto...',
            allowClear: true,
            language: {
                noResults: function() { return 'No encontrado'; },
                searching: function() { return 'Buscando...'; }
            }
        });
    });

    /* ══ Type selector ══ */
    function selectType(tipo) {
        // Update hidden input
        document.getElementById('tipo_oferta').value = tipo;

        // Update visual selection
        document.querySelectorAll('.ofr-type-option').forEach(function(el) {
            el.classList.toggle('selected', el.dataset.value == tipo);
        });

        // Toggle sections
        var secGratis    = document.getElementById('seccionGratis');
        var secDescuento = document.getElementById('seccionDescuento');

        if (tipo === 1) {
            secGratis.className    = 'ofr-conditional visible';
            secDescuento.className = 'ofr-conditional hidden';
            // Enable/disable (same logic as original bloquearInputs)
            document.getElementById('producto_of').disabled      = false;
            document.getElementById('cantidad_oferta').disabled  = false;
            document.getElementById('porc_oferta').disabled      = true;
            document.getElementById('porc_oferta').value         = '';
        } else {
            secGratis.className    = 'ofr-conditional hidden';
            secDescuento.className = 'ofr-conditional visible';
            document.getElementById('producto_of').disabled      = true;
            document.getElementById('cantidad_oferta').disabled  = true;
            document.getElementById('porc_oferta').disabled      = false;
            document.getElementById('producto_of').value         = '0';
            document.getElementById('cantidad_oferta').value     = '0';
            // Trigger Select2 update
            $('#producto_of').val('0').trigger('change');
        }
    }

    // Init state on load
    selectType(<?php echo json_encode($valTipo); ?>);

    /* ══ Form submit ══ */
    document.getElementById('formOferta').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validation: fecha_fin >= fecha_inicia
        var fi = document.getElementById('fecha_inicia').value;
        var ff = document.getElementById('fecha_fin').value;
        if (fi && ff && ff < fi) {
            Swal.fire({
                icon: 'warning',
                title: 'Fechas inválidas',
                text: 'La fecha de fin no puede ser anterior a la fecha de inicio.',
                confirmButtonColor: '#2563eb'
            });
            return;
        }

        var btn = document.getElementById('btnGuardar');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-icons-outlined" style="animation:spin 1s linear infinite;">sync</span> Guardando...';

        // Re-enable disabled fields so they get sent
        var disabledFields = this.querySelectorAll(':disabled');
        disabledFields.forEach(function(f) { f.disabled = false; });

        var formData = new FormData(this);

        // Re-disable them after capturing
        disabledFields.forEach(function(f) { f.disabled = true; });

        if (ES_EDITAR) {
            formData.append('id', OFERTA_ID);
            formData.append('accion', 'modificacion');
        } else {
            formData.append('accion', 'alta');
        }

        try {
            var response = await fetch('api/apiOfertas.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Error HTTP ' + response.status);

            var data = await response.json();

            Swal.fire({
                title: data.mensaje || (ES_EDITAR ? 'Oferta actualizada' : 'Oferta guardada'),
                icon: data.tipo || 'success',
                confirmButtonColor: '#059669',
                timer: 1800,
                showConfirmButton: false
            });

            if (data.tipo === 'success') {
                setTimeout(function() {
                    window.location.href = 'ofertas.php';
                }, 1800);
            }

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: err.message || 'No se pudo guardar la oferta.',
                confirmButtonColor: '#dc2626'
            });
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-icons-outlined">save</span> ' +
                (ES_EDITAR ? 'Actualizar oferta' : 'Guardar oferta');
        }
    });
    </script>

</body>
</html>