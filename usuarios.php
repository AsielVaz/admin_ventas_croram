<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Usuarios" />
    <title>Croram Admin · Usuarios</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" />

    <style>
    :root {
        --us-primary: #2563eb;
        --us-primary-soft: rgba(37,99,235,.07);
        --us-success: #059669;
        --us-success-soft: rgba(5,150,105,.08);
        --us-danger: #dc2626;
        --us-danger-soft: rgba(220,38,38,.07);
        --us-text: #1e293b;
        --us-text-secondary: #64748b;
        --us-text-muted: #94a3b8;
        --us-surface: #ffffff;
        --us-surface-alt: #f8fafc;
        --us-border: #e2e8f0;
        --us-radius: 14px;
        --us-radius-sm: 10px;
        --us-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --us-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--us-font); }

    .us-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--us-text-secondary);
    }
    .us-breadcrumb a { color: var(--us-primary); text-decoration: none; }
    .us-breadcrumb .sep { opacity: .4; }

    .us-card {
        background: var(--us-surface); border: 1px solid var(--us-border);
        border-radius: var(--us-radius); box-shadow: var(--us-shadow);
        overflow: hidden; animation: fadeIn .35s ease both;
    }
    .us-card-header {
        padding: 1rem 1.5rem; border-bottom: 1px solid var(--us-border);
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; flex-wrap: wrap; background: var(--us-surface-alt);
    }
    .us-card-header-left {
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--us-text);
    }
    .us-card-header-left .material-icons-outlined { font-size: 1.2rem; color: var(--us-primary); }
    .us-card-body { padding: 1.25rem 1.5rem; }

    .us-kpi-row {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .us-kpi {
        background: var(--us-surface); border: 1px solid var(--us-border);
        border-radius: var(--us-radius-sm); padding: 1rem 1.15rem;
        display: flex; flex-direction: column; gap: .15rem;
        animation: fadeIn .3s ease both;
    }
    .us-kpi-label { font-size: .7rem; text-transform: uppercase; letter-spacing: .06em; color: var(--us-text-muted); font-weight: 600; }
    .us-kpi-value { font-size: 1.35rem; font-weight: 700; color: var(--us-text); line-height: 1.2; }

    .us-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.1rem; border-radius: var(--us-radius-sm);
        font-size: .82rem; font-weight: 600; font-family: var(--us-font);
        cursor: pointer; border: none; transition: all .2s;
        text-decoration: none; white-space: nowrap;
    }
    .us-btn .material-icons-outlined { font-size: 1rem; }
    .us-btn-primary { background: var(--us-primary); color: #fff; }
    .us-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .us-btn-outline { background: transparent; color: var(--us-text-secondary); border: 1px solid var(--us-border); }
    .us-btn-outline:hover { border-color: var(--us-primary); color: var(--us-primary); }
    .us-btn-info { background: rgba(2,132,199,.08); color: #0284c7; border: 1px solid transparent; }
    .us-btn-info:hover { border-color: #0284c7; }
    .us-btn-sm { padding: .4rem .75rem; font-size: .78rem; }

    .us-status {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .25rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 600;
    }
    .us-status.active { background: var(--us-success-soft); color: var(--us-success); }
    .us-status.inactive { background: var(--us-danger-soft); color: var(--us-danger); }

    .us-actions { display: flex; gap: .4rem; align-items: center; flex-wrap: wrap; }

    /* Napers ID badge */
    .us-napers-id {
        display: inline-block; padding: .15rem .5rem; border-radius: 4px;
        font-size: .8rem; font-weight: 600; letter-spacing: .02em;
        background: var(--us-surface-alt); color: var(--us-text-secondary);
        border: 1px solid var(--us-border); font-variant-numeric: tabular-nums;
    }

    /* DataTables overrides */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: var(--us-radius-sm) !important; border: 1px solid var(--us-border) !important;
        font-family: var(--us-font) !important; font-size: .85rem !important; padding: .45rem .85rem !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--us-primary) !important; box-shadow: 0 0 0 3px var(--us-primary-soft) !important; outline: none !important;
    }
    .dataTables_wrapper .dataTables_length select {
        border-radius: var(--us-radius-sm) !important; border: 1px solid var(--us-border) !important; font-family: var(--us-font) !important;
    }
    table.dataTable thead th {
        background: var(--us-surface-alt) !important; font-weight: 600 !important; font-size: .75rem !important;
        text-transform: uppercase !important; letter-spacing: .04em !important;
        color: var(--us-text-secondary) !important; border-bottom: 1px solid var(--us-border) !important;
        padding: .7rem 1rem !important;
    }
    table.dataTable tbody td {
        font-size: .85rem !important; color: var(--us-text) !important;
        padding: .65rem 1rem !important; vertical-align: middle !important;
        border-bottom: 1px solid var(--us-border) !important;
    }
    table.dataTable tbody tr:hover { background: var(--us-primary-soft) !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--us-primary) !important; color: #fff !important;
        border: none !important; border-radius: 8px !important;
    }
    .dataTables_wrapper .dataTables_info { font-size: .8rem !important; color: var(--us-text-muted) !important; }
    div.dt-buttons .btn {
        border-radius: var(--us-radius-sm) !important; font-family: var(--us-font) !important;
        font-size: .78rem !important; font-weight: 600 !important; padding: .4rem .85rem !important;
    }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminUsuarios.php";
    $adminUsuarios = new AdministradorUsuarios();
    $usuarios = $adminUsuarios->dameUsuarios();
    if (!is_array($usuarios)) $usuarios = [];

    // KPIs
    $totalUsuarios = count($usuarios);
    $activos = 0;
    $inactivos = 0;
    foreach ($usuarios as $u) {
        if (!is_object($u)) continue;
        if (intval($u->estatus ?? 0) == 1) $activos++; else $inactivos++;
    }
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="us-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span style="color:var(--us-text);font-weight:600;">Usuarios</span>
                </div>

                <!-- KPIs -->
                <div class="us-kpi-row">
                    <div class="us-kpi" style="animation-delay:.05s;">
                        <span class="us-kpi-label">Total usuarios</span>
                        <span class="us-kpi-value"><?php echo $totalUsuarios; ?></span>
                    </div>
                    <div class="us-kpi" style="animation-delay:.1s;">
                        <span class="us-kpi-label">Activos</span>
                        <span class="us-kpi-value" style="color:var(--us-success);"><?php echo $activos; ?></span>
                    </div>
                    <div class="us-kpi" style="animation-delay:.15s;">
                        <span class="us-kpi-label">Inactivos</span>
                        <span class="us-kpi-value" style="color:var(--us-danger);"><?php echo $inactivos; ?></span>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="us-card">
                    <div class="us-card-header">
                        <div class="us-card-header-left">
                            <span class="material-icons-outlined">group</span>
                            Lista de usuarios
                        </div>
                        <a href="usuarios-form.php" class="us-btn us-btn-primary">
                            <span class="material-icons-outlined">person_add</span>
                            Agregar usuario
                        </a>
                    </div>
                    <div class="us-card-body" style="padding:.75rem 1.25rem 1.25rem;">
                        <div class="table-responsive">
                            <table id="tablaUsuarios" class="table table-striped table-bordered" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>ID Cliente Napers</th>
                                        <th style="text-align:center;">Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usuarios as $usuario):
                                        if (!is_object($usuario)) continue;
                                        $uid    = intval($usuario->id ?? 0);
                                        $activo = intval($usuario->estatus ?? 0) == 1;
                                    ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($usuario->nombre ?? '', ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                        <td><?php echo htmlspecialchars($usuario->correo ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <span class="us-napers-id"><?php echo htmlspecialchars($usuario->id_cliente ?? '—', ENT_QUOTES, 'UTF-8'); ?></span>
                                        </td>
                                        <td style="text-align:center;">
                                            <span class="us-status <?php echo $activo ? 'active' : 'inactive'; ?>">
                                                <span class="material-icons-outlined" style="font-size:.75rem;">
                                                    <?php echo $activo ? 'check_circle' : 'cancel'; ?>
                                                </span>
                                                <?php echo $activo ? 'Activo' : 'Inactivo'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="us-actions">
                                                <a href="usuarios-form.php?id=<?php echo $uid; ?>" class="us-btn us-btn-outline us-btn-sm">
                                                    <span class="material-icons-outlined">edit</span>
                                                    Editar
                                                </a>
                                                <a href="usuarios-ver.php?id=<?php echo $uid; ?>" class="us-btn us-btn-info us-btn-sm">
                                                    <span class="material-icons-outlined">visibility</span>
                                                    Ver
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
    $(document).ready(function() {
        var table = $('#tablaUsuarios').DataTable({
            lengthChange: true,
            pageLength: 25,
            buttons: ['copy', 'excel', 'pdf', 'print'],
            language: {
                search: 'Buscar:',
                lengthMenu: 'Mostrar _MENU_ registros',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ usuarios',
                infoEmpty: 'Sin usuarios',
                infoFiltered: '(filtrado de _MAX_ totales)',
                zeroRecords: 'No se encontraron usuarios',
                paginate: { first: 'Primero', last: 'Último', next: 'Sig.', previous: 'Ant.' }
            },
            order: [[0, 'asc']]
        });

        table.buttons().container()
            .appendTo('#tablaUsuarios_wrapper .col-md-6:eq(0)');
    });
    </script>

</body>
</html>