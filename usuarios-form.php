<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Croram Admin · Usuario</title>
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
        --uf-primary: #2563eb; --uf-primary-soft: rgba(37,99,235,.07);
        --uf-success: #059669; --uf-danger: #dc2626;
        --uf-text: #1e293b; --uf-text-secondary: #64748b; --uf-text-muted: #94a3b8;
        --uf-surface: #ffffff; --uf-surface-alt: #f8fafc;
        --uf-border: #e2e8f0; --uf-radius: 14px; --uf-radius-sm: 10px;
        --uf-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --uf-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--uf-font); }

    .uf-breadcrumb { display: flex; align-items: center; gap: .75rem; margin-bottom: 1.5rem; font-size: .85rem; color: var(--uf-text-secondary); }
    .uf-breadcrumb a { color: var(--uf-primary); text-decoration: none; }
    .uf-breadcrumb .sep { opacity: .4; }

    .uf-card { background: var(--uf-surface); border: 1px solid var(--uf-border); border-radius: var(--uf-radius); box-shadow: var(--uf-shadow); overflow: hidden; animation: fadeIn .35s ease both; }
    .uf-card-header { padding: 1rem 1.5rem; border-bottom: 1px solid var(--uf-border); display: flex; align-items: center; gap: .5rem; font-weight: 600; font-size: .95rem; color: var(--uf-text); background: var(--uf-surface-alt); }
    .uf-card-header .material-icons-outlined { font-size: 1.2rem; color: var(--uf-primary); }
    .uf-card-body { padding: 1.5rem; }

    .uf-field { margin-bottom: 1.15rem; }
    .uf-field label { display: flex; align-items: center; gap: .3rem; font-size: .78rem; font-weight: 600; color: var(--uf-text-secondary); text-transform: uppercase; letter-spacing: .03em; margin-bottom: .4rem; }
    .uf-field label .material-icons-outlined { font-size: .9rem; }
    .uf-field input, .uf-field select { width: 100%; border-radius: var(--uf-radius-sm); border: 1px solid var(--uf-border); font-family: var(--uf-font); font-size: .875rem; padding: .6rem .9rem; transition: border-color .2s, box-shadow .2s; }
    .uf-field input:focus, .uf-field select:focus { border-color: var(--uf-primary); outline: none; box-shadow: 0 0 0 3px var(--uf-primary-soft); }
    .uf-field .uf-hint { font-size: .73rem; color: var(--uf-text-muted); margin-top: .3rem; }

    .uf-section { display: flex; align-items: center; gap: .5rem; margin: 1.5rem 0 1rem; padding-bottom: .5rem; border-bottom: 2px solid var(--uf-border); font-size: .8rem; font-weight: 700; color: var(--uf-text-secondary); text-transform: uppercase; letter-spacing: .05em; }
    .uf-section .material-icons-outlined { font-size: 1rem; color: var(--uf-primary); }

    .uf-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 1.5rem; }
    .uf-form-grid .uf-full { grid-column: 1 / -1; }
    @media (max-width: 768px) { .uf-form-grid { grid-template-columns: 1fr; } }

    .uf-btn { display: inline-flex; align-items: center; gap: .4rem; padding: .65rem 1.35rem; border-radius: var(--uf-radius-sm); font-size: .85rem; font-weight: 600; font-family: var(--uf-font); cursor: pointer; border: none; transition: all .2s; text-decoration: none; }
    .uf-btn .material-icons-outlined { font-size: 1.1rem; }
    .uf-btn-primary { background: var(--uf-primary); color: #fff; }
    .uf-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .uf-btn-outline { background: transparent; color: var(--uf-text-secondary); border: 1px solid var(--uf-border); }
    .uf-btn-outline:hover { border-color: var(--uf-primary); color: var(--uf-primary); }

    .select2-container--bootstrap-5 .select2-selection { border-radius: var(--uf-radius-sm) !important; min-height: 42px !important; border-color: var(--uf-border) !important; font-family: var(--uf-font) !important; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes spin { from { transform: rotate(0); } to { transform: rotate(360deg); } }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminUsuarios.php";
    include_once "api/adminSets.php";

    $adminUsuarios = new AdministradorUsuarios();
    $adminSets     = new AdministradorSets();
    $usuariosApi   = $adminUsuarios->dameUsuariosApi();
    $setsApi       = $adminSets->dameSetVendedor();

    if (!is_array($usuariosApi)) $usuariosApi = [];
    if (!is_array($setsApi))     $setsApi = [];

    $editar  = 0;
    $usuario = null;

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $usuario = $adminUsuarios->dameUsuario($_GET['id']);
        if (is_object($usuario) && !empty($usuario->id)) {
            $editar = 1;
        }
    }

    // Safe values
    $valNombre    = ($editar && isset($usuario->nombre))     ? htmlspecialchars($usuario->nombre, ENT_QUOTES, 'UTF-8')     : '';
    $valCorreo    = ($editar && isset($usuario->correo))     ? htmlspecialchars($usuario->correo, ENT_QUOTES, 'UTF-8')     : '';
    $valDiasPago  = ($editar && isset($usuario->dias_pago))  ? intval($usuario->dias_pago)  : '';
    $valEstatus   = ($editar && isset($usuario->estatus))    ? intval($usuario->estatus)    : -1;
    $valTipo      = ($editar && isset($usuario->tipo))       ? htmlspecialchars($usuario->tipo, ENT_QUOTES, 'UTF-8')       : '';
    $valAutoOrden = ($editar && isset($usuario->auto_orden)) ? intval($usuario->auto_orden) : -1;
    $valIdCliente = ($editar && isset($usuario->id_cliente)) ? intval($usuario->id_cliente) : 0;
    $valIdSet     = ($editar && isset($usuario->id_set))     ? intval($usuario->id_set)     : 0;
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="uf-breadcrumb">
                    <a href="index.php">Inicio</a><span class="sep">/</span>
                    <a href="usuarios.php">Usuarios</a><span class="sep">/</span>
                    <span style="color:var(--uf-text);font-weight:600;">
                        <?php echo $editar ? 'Editar usuario' : 'Nuevo usuario'; ?>
                    </span>
                </div>

                <div style="max-width:860px;">
                    <div class="uf-card">
                        <div class="uf-card-header">
                            <span class="material-icons-outlined"><?php echo $editar ? 'edit' : 'person_add'; ?></span>
                            <?php echo $editar ? 'Editar usuario' : 'Registrar usuario'; ?>
                        </div>
                        <div class="uf-card-body">
                            <form id="formUsuario">

                                <!-- ═══ Datos personales ═══ -->
                                <div class="uf-section">
                                    <span class="material-icons-outlined">person</span>
                                    Datos personales
                                </div>

                                <div class="uf-form-grid">
                                    <div class="uf-field">
                                        <label><span class="material-icons-outlined">badge</span> Nombre completo</label>
                                        <input type="text" name="nombre" id="nombre" placeholder="Nombre del usuario" value="<?php echo $valNombre; ?>" required />
                                    </div>
                                    <div class="uf-field">
                                        <label><span class="material-icons-outlined">email</span> Email</label>
                                        <input type="email" name="email" id="email" placeholder="correo@ejemplo.com" value="<?php echo $valCorreo; ?>" required />
                                    </div>
                                    <div class="uf-field uf-full">
                                        <label><span class="material-icons-outlined">lock</span> Contraseña</label>
                                        <input type="password" name="pass" id="contrasena" placeholder="<?php echo $editar ? 'Dejar vacío para no cambiar' : 'Contraseña...'; ?>" <?php echo $editar ? '' : 'required'; ?> />
                                        <?php if ($editar): ?>
                                        <p class="uf-hint">Déjalo vacío si no deseas cambiar la contraseña actual.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- ═══ Configuración ═══ -->
                                <div class="uf-section">
                                    <span class="material-icons-outlined">settings</span>
                                    Configuración
                                </div>

                                <div class="uf-form-grid">
                                    <div class="uf-field">
                                        <label><span class="material-icons-outlined">schedule</span> Días de gracia</label>
                                        <input type="number" name="dias_pago" id="dias_pago" min="0" placeholder="Ej: 30" value="<?php echo $valDiasPago; ?>" />
                                        <p class="uf-hint">Número de días que tiene el cliente para realizar su pago.</p>
                                    </div>
                                    <div class="uf-field">
                                        <label><span class="material-icons-outlined">toggle_on</span> Estatus</label>
                                        <select name="estatus" id="estatus">
                                            <option value="" <?php echo ($valEstatus === -1) ? 'selected' : ''; ?>>Selecciona...</option>
                                            <option value="1" <?php echo ($valEstatus === 1) ? 'selected' : ''; ?>>Activo</option>
                                            <option value="0" <?php echo ($valEstatus === 0) ? 'selected' : ''; ?>>Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="uf-field">
                                        <label><span class="material-icons-outlined">admin_panel_settings</span> Tipo de usuario</label>
                                        <select name="tipo" id="tipo">
                                            <option value="" <?php echo empty($valTipo) ? 'selected' : ''; ?>>Selecciona...</option>
                                            <option value="Cliente" <?php echo ($valTipo === 'Cliente') ? 'selected' : ''; ?>>Cliente</option>
                                            <option value="Vendedor" <?php echo ($valTipo === 'Vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                                            <option value="Administrador" <?php echo ($valTipo === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                                        </select>
                                    </div>
                                    <div class="uf-field">
                                        <label><span class="material-icons-outlined">autorenew</span> Órdenes automáticas</label>
                                        <select name="auto_orden" id="auto_orden">
                                            <option value="" <?php echo ($valAutoOrden === -1) ? 'selected' : ''; ?>>Selecciona...</option>
                                            <option value="1" <?php echo ($valAutoOrden === 1) ? 'selected' : ''; ?>>Activar</option>
                                            <option value="0" <?php echo ($valAutoOrden === 0) ? 'selected' : ''; ?>>Desactivar</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- ═══ Integración ═══ -->
                                <div class="uf-section">
                                    <span class="material-icons-outlined">link</span>
                                    Integración
                                </div>

                                <div class="uf-form-grid">
                                    <div class="uf-field uf-full">
                                        <label><span class="material-icons-outlined">cloud</span> Cliente Napers</label>
                                        <select name="id_cliente" id="id_cliente">
                                            <option value="0">Elige un cliente de Napers...</option>
                                            <?php foreach ($usuariosApi as $uApi):
                                                if (!is_object($uApi)) continue;
                                                $uId   = intval($uApi->id ?? 0);
                                                $uName = htmlspecialchars($uApi->displayName ?? '', ENT_QUOTES, 'UTF-8');
                                                $sel   = ($uId == $valIdCliente) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $uId; ?>" <?php echo $sel; ?>><?php echo $uName; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="uf-hint">Vincula este usuario con su cuenta en el sistema Napers.</p>
                                    </div>
                                    <div class="uf-field uf-full">
                                        <label><span class="material-icons-outlined">price_change</span> Set de precios</label>
                                        <select name="id_set" id="id_set">
                                            <option value="0" <?php echo ($valIdSet === 0) ? 'selected' : ''; ?>>Usar precios predeterminados</option>
                                            <?php foreach ($setsApi as $set):
                                                if (!is_object($set)) continue;
                                                $sId   = intval($set->id ?? 0);
                                                $sName = htmlspecialchars($set->nombre ?? '', ENT_QUOTES, 'UTF-8');
                                                $sel   = ($sId == $valIdSet) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $sId; ?>" <?php echo $sel; ?>><?php echo $sName; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p class="uf-hint">Si seleccionas un set, los precios de ese set se usarán en lugar de los predeterminados.</p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div style="display:flex;gap:.75rem;margin-top:1.5rem;justify-content:flex-end;">
                                    <a href="usuarios.php" class="uf-btn uf-btn-outline">
                                        <span class="material-icons-outlined">arrow_back</span> Cancelar
                                    </a>
                                    <button type="submit" class="uf-btn uf-btn-primary" id="btnGuardar">
                                        <span class="material-icons-outlined">save</span>
                                        <?php echo $editar ? 'Actualizar usuario' : 'Guardar usuario'; ?>
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
    var USUARIO_ID = <?php echo json_encode($editar ? intval($usuario->id) : 0); ?>;

    /* ══ Select2 for Napers client ══ */
    $(document).ready(function() {
        $('#id_cliente').select2({
            theme: 'bootstrap-5',
            placeholder: 'Buscar cliente Napers...',
            allowClear: true,
            language: { noResults: function() { return 'No encontrado'; }, searching: function() { return 'Buscando...'; } }
        });
    });

    /* ══ Form submit (original logic) ══ */
    document.getElementById('formUsuario').addEventListener('submit', async function(e) {
        e.preventDefault();

        var btn = document.getElementById('btnGuardar');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-icons-outlined" style="animation:spin 1s linear infinite;">sync</span> Guardando...';

        var formData = new FormData(this);

        if (ES_EDITAR) {
            formData.append('id', USUARIO_ID);
            formData.append('accion', 'modificacion');
        } else {
            formData.append('accion', 'alta');
        }

        try {
            var response = await fetch('api/apiUsuarios.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Error HTTP ' + response.status);

            var data = await response.json();

            Swal.fire({
                title: 'Guardado',
                text: data.mensaje || (ES_EDITAR ? 'Usuario actualizado' : 'Usuario creado'),
                icon: data.tipo || 'success',
                confirmButtonColor: '#059669',
                confirmButtonText: 'Aceptar'
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = 'usuarios.php';
                }
            });

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: err.message || 'No se pudo guardar el usuario.',
                confirmButtonColor: '#dc2626'
            });
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-icons-outlined">save</span> ' +
                (ES_EDITAR ? 'Actualizar usuario' : 'Guardar usuario');
        }
    });
    </script>

</body>
</html>