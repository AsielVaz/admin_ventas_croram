<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Formulario de Vehículo" />
    <title>Croram Admin · Vehículo</title>
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
        --vf-primary: #2563eb;
        --vf-primary-soft: rgba(37,99,235,.07);
        --vf-success: #059669;
        --vf-danger: #dc2626;
        --vf-text: #1e293b;
        --vf-text-secondary: #64748b;
        --vf-text-muted: #94a3b8;
        --vf-surface: #ffffff;
        --vf-surface-alt: #f8fafc;
        --vf-border: #e2e8f0;
        --vf-radius: 14px;
        --vf-radius-sm: 10px;
        --vf-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --vf-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--vf-font); }

    .vf-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--vf-text-secondary);
    }
    .vf-breadcrumb a { color: var(--vf-primary); text-decoration: none; }
    .vf-breadcrumb .sep { opacity: .4; }

    .vf-card {
        background: var(--vf-surface);
        border: 1px solid var(--vf-border);
        border-radius: var(--vf-radius);
        box-shadow: var(--vf-shadow);
        overflow: hidden;
        animation: fadeIn .35s ease both;
    }
    .vf-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--vf-border);
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--vf-text);
        background: var(--vf-surface-alt);
    }
    .vf-card-header .material-icons-outlined { font-size: 1.2rem; color: var(--vf-primary); }
    .vf-card-body { padding: 1.5rem; }

    .vf-field { margin-bottom: 1.15rem; }
    .vf-field label {
        display: flex; align-items: center; gap: .3rem;
        font-size: .78rem; font-weight: 600; color: var(--vf-text-secondary);
        text-transform: uppercase; letter-spacing: .03em; margin-bottom: .4rem;
    }
    .vf-field label .material-icons-outlined { font-size: .9rem; }
    .vf-field input,
    .vf-field select {
        width: 100%; border-radius: var(--vf-radius-sm);
        border: 1px solid var(--vf-border);
        font-family: var(--vf-font); font-size: .875rem;
        padding: .6rem .9rem; transition: border-color .2s, box-shadow .2s;
    }
    .vf-field input:focus,
    .vf-field select:focus {
        border-color: var(--vf-primary); outline: none;
        box-shadow: 0 0 0 3px var(--vf-primary-soft);
    }
    .vf-field input[readonly] {
        background: var(--vf-surface-alt); color: var(--vf-text-secondary);
    }
    .vf-field .vf-hint {
        font-size: .73rem; color: var(--vf-text-muted); margin-top: .3rem;
    }

    /* Capacity visual */
    .vf-capacity-display {
        display: flex; align-items: center; gap: .75rem;
        margin-top: .4rem;
    }
    .vf-capacity-bar {
        flex: 1; height: 8px; background: var(--vf-border);
        border-radius: 999px; overflow: hidden;
    }
    .vf-capacity-bar-fill {
        height: 100%; border-radius: 999px;
        background: linear-gradient(90deg, var(--vf-primary), #3b82f6);
        transition: width .4s ease;
    }
    .vf-capacity-label {
        font-size: .82rem; font-weight: 700; color: var(--vf-text);
        white-space: nowrap;
    }

    .vf-form-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 0 1.5rem;
    }
    .vf-form-grid .vf-full { grid-column: 1 / -1; }
    @media (max-width: 768px) { .vf-form-grid { grid-template-columns: 1fr; } }

    .vf-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .65rem 1.35rem; border-radius: var(--vf-radius-sm);
        font-size: .85rem; font-weight: 600; font-family: var(--vf-font);
        cursor: pointer; border: none; transition: all .2s; text-decoration: none;
    }
    .vf-btn .material-icons-outlined { font-size: 1.1rem; }
    .vf-btn-primary { background: var(--vf-primary); color: #fff; }
    .vf-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .vf-btn-outline {
        background: transparent; color: var(--vf-text-secondary);
        border: 1px solid var(--vf-border);
    }
    .vf-btn-outline:hover { border-color: var(--vf-primary); color: var(--vf-primary); }

    .select2-container--bootstrap-5 .select2-selection {
        border-radius: var(--vf-radius-sm) !important;
        min-height: 42px !important;
        border-color: var(--vf-border) !important;
        font-family: var(--vf-font) !important;
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
    include_once "api/adminAutos.php";
    include_once "api/adminUsuarios.php";

    $adminAutos    = new AdministradorAutos();
    $adminUsuarios = new AdministradorUsuarios();
    $usuarios      = $adminUsuarios->dameUsuarios();
    if (!is_array($usuarios)) $usuarios = [];

    $editar = 0;
    $auto   = null;

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $auto = $adminAutos->obtenerAuto($_GET['id']);
        if (is_object($auto) && !empty($auto->id)) {
            $editar = 1;
        }
    }

    // Safe values
    $valMarca     = ($editar && isset($auto->marca))        ? htmlspecialchars($auto->marca, ENT_QUOTES, 'UTF-8')    : '';
    $valModelo    = ($editar && isset($auto->modelo))       ? htmlspecialchars($auto->modelo, ENT_QUOTES, 'UTF-8')   : '';
    $valColor     = ($editar && isset($auto->color))        ? htmlspecialchars($auto->color, ENT_QUOTES, 'UTF-8')    : '';
    $valPlacas    = ($editar && isset($auto->placas))       ? htmlspecialchars($auto->placas, ENT_QUOTES, 'UTF-8')   : '';
    $valCapacidad = ($editar && isset($auto->capacidad_kg)) ? intval($auto->capacidad_kg) : 0;
    $valTipo      = ($editar && isset($auto->tipo))         ? $auto->tipo : '';
    $valCliente   = ($editar && isset($auto->id_cliente))   ? intval($auto->id_cliente) : 0;

    // Tipos de vehículo con capacidades
    $tiposVehiculo = [
        'Pic - Up'              => 1000,
        'Nissan Estaquitas'     => 2000,
        'Camioneta'             => 5000,
        'Camion caja seca'      => 13000,
        'Camion caja redila'    => 16000,
        'Trailer caja seca'     => 25000,
        'Trailer caja redilas'  => 34000,
        'Trailer Plataforma'    => 34000,
    ];
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="vf-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <a href="vehiculos.php">Vehículos</a>
                    <span class="sep">/</span>
                    <span style="color:var(--vf-text);font-weight:600;">
                        <?php echo $editar ? 'Editar vehículo' : 'Nuevo vehículo'; ?>
                    </span>
                </div>

                <div style="max-width:860px;">
                    <div class="vf-card">
                        <div class="vf-card-header">
                            <span class="material-icons-outlined"><?php echo $editar ? 'edit' : 'add_circle'; ?></span>
                            <?php echo $editar ? 'Editar vehículo' : 'Registrar vehículo'; ?>
                        </div>
                        <div class="vf-card-body">
                            <form id="formVehiculo">
                                <div class="vf-form-grid">

                                    <!-- Marca -->
                                    <div class="vf-field">
                                        <label>
                                            <span class="material-icons-outlined">directions_car</span>
                                            Marca
                                        </label>
                                        <input type="text" name="marca" id="marca"
                                               placeholder="Ej: Ford, Chevrolet, Kenworth"
                                               value="<?php echo $valMarca; ?>" required />
                                    </div>

                                    <!-- Modelo -->
                                    <div class="vf-field">
                                        <label>
                                            <span class="material-icons-outlined">pin</span>
                                            Modelo
                                        </label>
                                        <input type="text" name="modelo" id="modelo"
                                               placeholder="Ej: F-150, NP300, T680"
                                               value="<?php echo $valModelo; ?>" required />
                                    </div>

                                    <!-- Color -->
                                    <div class="vf-field">
                                        <label>
                                            <span class="material-icons-outlined">palette</span>
                                            Color
                                        </label>
                                        <input type="text" name="color" id="color"
                                               placeholder="Ej: Blanco, Rojo"
                                               value="<?php echo $valColor; ?>" />
                                    </div>

                                    <!-- Placas -->
                                    <div class="vf-field">
                                        <label>
                                            <span class="material-icons-outlined">badge</span>
                                            Placas
                                        </label>
                                        <input type="text" name="placas" id="placas"
                                               placeholder="Ej: JMK-1234"
                                               value="<?php echo $valPlacas; ?>" required
                                               style="text-transform:uppercase;font-weight:700;letter-spacing:.04em;" />
                                    </div>

                                    <!-- Tipo -->
                                    <div class="vf-field">
                                        <label>
                                            <span class="material-icons-outlined">local_shipping</span>
                                            Tipo de vehículo
                                        </label>
                                        <select name="tipo" id="tipo" onchange="cambiarPeso(this.value)">
                                            <?php foreach ($tiposVehiculo as $tipo => $cap):
                                                $sel = ($valTipo === $tipo) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'); ?>"
                                                    data-capacidad="<?php echo $cap; ?>" <?php echo $sel; ?>>
                                                <?php echo htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Capacidad -->
                                    <div class="vf-field">
                                        <label>
                                            <span class="material-icons-outlined">fitness_center</span>
                                            Capacidad (kg)
                                        </label>
                                        <input type="number" name="capacidad" id="capacidad"
                                               value="<?php echo $valCapacidad; ?>" readonly />
                                        <div class="vf-capacity-display">
                                            <div class="vf-capacity-bar">
                                                <div class="vf-capacity-bar-fill" id="capacityBar" style="width:0%;"></div>
                                            </div>
                                            <span class="vf-capacity-label" id="capacityLabel">0 ton</span>
                                        </div>
                                        <p class="vf-hint">Se asigna automáticamente según el tipo de vehículo.</p>
                                    </div>

                                    <!-- Cliente -->
                                    <div class="vf-field vf-full">
                                        <label>
                                            <span class="material-icons-outlined">person</span>
                                            Cliente
                                        </label>
                                        <select name="id_cliente" id="id_cliente">
                                            <option value="">Seleccionar cliente...</option>
                                            <?php foreach ($usuarios as $u):
                                                if (!is_object($u)) continue;
                                                $uid  = intval($u->id ?? 0);
                                                $unom = htmlspecialchars($u->nombre ?? '', ENT_QUOTES, 'UTF-8');
                                                $sel  = ($uid == $valCliente) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $uid; ?>" <?php echo $sel; ?>>
                                                <?php echo $unom; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                </div>

                                <!-- Actions -->
                                <div style="display:flex;gap:.75rem;margin-top:1.25rem;justify-content:flex-end;">
                                    <a href="vehiculos.php" class="vf-btn vf-btn-outline">
                                        <span class="material-icons-outlined">arrow_back</span>
                                        Cancelar
                                    </a>
                                    <button type="submit" class="vf-btn vf-btn-primary" id="btnGuardar">
                                        <span class="material-icons-outlined">save</span>
                                        <?php echo $editar ? 'Actualizar vehículo' : 'Guardar vehículo'; ?>
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
    var AUTO_ID = <?php echo json_encode($editar ? intval($auto->id) : 0); ?>;
    var MAX_CAPACIDAD = 34000;

    /* ══ Capacidades por tipo ══ */
    var capacidades = <?php echo json_encode($tiposVehiculo); ?>;

    function cambiarPeso(tipo) {
        var cap = capacidades[tipo] || 0;
        document.getElementById('capacidad').value = cap;
        actualizarBarra(cap);
    }

    function actualizarBarra(cap) {
        var pct = Math.min(100, (cap / MAX_CAPACIDAD) * 100);
        var bar = document.getElementById('capacityBar');
        var lbl = document.getElementById('capacityLabel');
        if (bar) bar.style.width = pct + '%';
        if (lbl) lbl.textContent = (cap / 1000).toFixed(1) + ' ton';
    }

    /* Init capacity bar */
    actualizarBarra(parseInt(document.getElementById('capacidad').value) || 0);

    /* ══ Select2 para cliente ══ */
    $(document).ready(function() {
        $('#id_cliente').select2({
            theme: 'bootstrap-5',
            placeholder: 'Seleccionar cliente...',
            allowClear: true,
            language: {
                noResults: function() { return 'No encontrado'; },
                searching: function() { return 'Buscando...'; }
            }
        });
    });

    /* ══ Form submit ══ */
    document.getElementById('formVehiculo').addEventListener('submit', async function(e) {
        e.preventDefault();

        var btn = document.getElementById('btnGuardar');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-icons-outlined" style="animation:spin 1s linear infinite;">sync</span> Guardando...';

        var formData = new FormData(this);

        if (ES_EDITAR) {
            formData.append('id', AUTO_ID);
            formData.append('accion', 'modificacion');
        } else {
            formData.append('accion', 'alta');
        }

        try {
            var response = await fetch('api/apiAutos.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Error HTTP ' + response.status);

            var data = await response.json();

            Swal.fire({
                title: data.mensaje || (ES_EDITAR ? 'Vehículo actualizado' : 'Vehículo guardado'),
                icon: data.tipo || 'success',
                confirmButtonColor: '#059669',
                timer: 1800,
                showConfirmButton: false
            });

            if (data.tipo === 'success') {
                setTimeout(function() {
                    window.location.href = 'vehiculos.php';
                }, 1800);
            }

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: err.message || 'No se pudo guardar el vehículo.',
                confirmButtonColor: '#dc2626'
            });
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-icons-outlined">save</span> ' +
                (ES_EDITAR ? 'Actualizar vehículo' : 'Guardar vehículo');
        }
    });
    </script>

</body>
</html>