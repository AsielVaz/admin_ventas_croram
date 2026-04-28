<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Productos" />
    <title>Croram Admin · Productos</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <!-- CSS Base -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <!-- DataTables CSS via CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" />

    <style>
    :root {
        --pr-primary: #2563eb;
        --pr-primary-soft: rgba(37,99,235,.07);
        --pr-success: #059669;
        --pr-success-soft: rgba(5,150,105,.08);
        --pr-danger: #dc2626;
        --pr-danger-soft: rgba(220,38,38,.07);
        --pr-warning: #d97706;
        --pr-text: #1e293b;
        --pr-text-secondary: #64748b;
        --pr-text-muted: #94a3b8;
        --pr-surface: #ffffff;
        --pr-surface-alt: #f8fafc;
        --pr-border: #e2e8f0;
        --pr-radius: 14px;
        --pr-radius-sm: 10px;
        --pr-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --pr-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--pr-font); }

    .pr-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--pr-text-secondary);
    }
    .pr-breadcrumb a { color: var(--pr-primary); text-decoration: none; }
    .pr-breadcrumb .sep { opacity: .4; }

    /* Card */
    .pr-card {
        background: var(--pr-surface);
        border: 1px solid var(--pr-border);
        border-radius: var(--pr-radius);
        box-shadow: var(--pr-shadow);
        overflow: hidden;
        animation: fadeIn .35s ease both;
    }
    .pr-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--pr-border);
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; flex-wrap: wrap;
        background: var(--pr-surface-alt);
    }
    .pr-card-header-left {
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--pr-text);
    }
    .pr-card-header-left .material-icons-outlined {
        font-size: 1.2rem; color: var(--pr-primary);
    }
    .pr-card-body { padding: 1.25rem 1.5rem; }

    /* KPI row */
    .pr-kpi-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .pr-kpi {
        background: var(--pr-surface);
        border: 1px solid var(--pr-border);
        border-radius: var(--pr-radius-sm);
        padding: 1rem 1.15rem;
        display: flex; flex-direction: column; gap: .15rem;
        animation: fadeIn .3s ease both;
    }
    .pr-kpi-label {
        font-size: .7rem; text-transform: uppercase;
        letter-spacing: .06em; color: var(--pr-text-muted); font-weight: 600;
    }
    .pr-kpi-value {
        font-size: 1.35rem; font-weight: 700; color: var(--pr-text); line-height: 1.2;
    }

    /* Button */
    .pr-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.1rem; border-radius: var(--pr-radius-sm);
        font-size: .82rem; font-weight: 600; font-family: var(--pr-font);
        cursor: pointer; border: none; transition: all .2s;
        text-decoration: none; white-space: nowrap;
    }
    .pr-btn .material-icons-outlined { font-size: 1rem; }
    .pr-btn-primary { background: var(--pr-primary); color: #fff; }
    .pr-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .pr-btn-success { background: var(--pr-success); color: #fff; }
    .pr-btn-success:hover { background: #047857; color: #fff; }
    .pr-btn-danger { background: var(--pr-danger); color: #fff; }
    .pr-btn-danger:hover { background: #b91c1c; color: #fff; }
    .pr-btn-outline {
        background: transparent; color: var(--pr-text-secondary);
        border: 1px solid var(--pr-border);
    }
    .pr-btn-outline:hover { border-color: var(--pr-primary); color: var(--pr-primary); }
    .pr-btn-sm { padding: .4rem .75rem; font-size: .78rem; }

    /* Status badge */
    .pr-status {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .25rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 600;
    }
    .pr-status.active { background: var(--pr-success-soft); color: var(--pr-success); }
    .pr-status.inactive { background: var(--pr-danger-soft); color: var(--pr-danger); }

    /* Image check */
    .pr-img-check {
        display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px; border-radius: 8px;
    }
    .pr-img-check.yes { background: var(--pr-success-soft); color: var(--pr-success); }
    .pr-img-check.no { background: var(--pr-danger-soft); color: var(--pr-danger); }
    .pr-img-check .material-icons-outlined { font-size: 1rem; }

    /* DataTables overrides */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: var(--pr-radius-sm) !important;
        border: 1px solid var(--pr-border) !important;
        font-family: var(--pr-font) !important;
        font-size: .85rem !important;
        padding: .45rem .85rem !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--pr-primary) !important;
        box-shadow: 0 0 0 3px var(--pr-primary-soft) !important;
        outline: none !important;
    }
    .dataTables_wrapper .dataTables_length select {
        border-radius: var(--pr-radius-sm) !important;
        border: 1px solid var(--pr-border) !important;
        font-family: var(--pr-font) !important;
    }
    table.dataTable thead th {
        background: var(--pr-surface-alt) !important;
        font-weight: 600 !important; font-size: .75rem !important;
        text-transform: uppercase !important; letter-spacing: .04em !important;
        color: var(--pr-text-secondary) !important;
        border-bottom: 1px solid var(--pr-border) !important;
        padding: .7rem 1rem !important;
    }
    table.dataTable tbody td {
        font-size: .85rem !important;
        color: var(--pr-text) !important;
        padding: .65rem 1rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid var(--pr-border) !important;
    }
    table.dataTable tbody tr:hover {
        background: var(--pr-primary-soft) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--pr-primary) !important;
        color: #fff !important;
        border: none !important;
        border-radius: 8px !important;
    }
    .dataTables_wrapper .dataTables_info {
        font-size: .8rem !important;
        color: var(--pr-text-muted) !important;
    }
    div.dt-buttons .btn {
        border-radius: var(--pr-radius-sm) !important;
        font-family: var(--pr-font) !important;
        font-size: .78rem !important;
        font-weight: 600 !important;
        padding: .4rem .85rem !important;
    }

    /* Actions cell */
    .pr-actions {
        display: flex; gap: .4rem; align-items: center; flex-wrap: wrap;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include "partials/barra.php"; ?>
    <!-- Header -->
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminProductos.php";
    $adminProductos = new AdministradorProductos();
    $productos = $adminProductos->obtenerProductos();
    if (!is_array($productos)) $productos = [];

    // KPIs
    $totalProductos = count($productos);
    $activos = 0;
    $inactivos = 0;
    $conImagen = 0;
    foreach ($productos as $p) {
        if (!is_object($p)) continue;
        if (intval($p->estatus ?? 0) == 1) $activos++; else $inactivos++;
        if (!empty($p->image)) $conImagen++;
    }
    ?>

    <!-- ═══ Main Content ═══ -->
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <!-- Breadcrumb -->
                <div class="pr-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span>Catálogos</span>
                    <span class="sep">/</span>
                    <span style="color:var(--pr-text);font-weight:600;">Productos</span>
                </div>

                <!-- KPIs -->
                <div class="pr-kpi-row">
                    <div class="pr-kpi" style="animation-delay:.05s;">
                        <span class="pr-kpi-label">Total productos</span>
                        <span class="pr-kpi-value"><?php echo $totalProductos; ?></span>
                    </div>
                    <div class="pr-kpi" style="animation-delay:.1s;">
                        <span class="pr-kpi-label">Activos</span>
                        <span class="pr-kpi-value" style="color:var(--pr-success);"><?php echo $activos; ?></span>
                    </div>
                    <div class="pr-kpi" style="animation-delay:.15s;">
                        <span class="pr-kpi-label">Inactivos</span>
                        <span class="pr-kpi-value" style="color:var(--pr-danger);"><?php echo $inactivos; ?></span>
                    </div>
                    <div class="pr-kpi" style="animation-delay:.2s;">
                        <span class="pr-kpi-label">Con imagen</span>
                        <span class="pr-kpi-value"><?php echo $conImagen; ?> <span style="font-size:.75rem;font-weight:400;color:var(--pr-text-muted);">/ <?php echo $totalProductos; ?></span></span>
                    </div>
                </div>

                <!-- Products Table Card -->
                <div class="pr-card">
                    <div class="pr-card-header">
                        <div class="pr-card-header-left">
                            <span class="material-icons-outlined">inventory_2</span>
                            Lista de productos
                        </div>
                        <a href="productos-form.php" class="pr-btn pr-btn-primary">
                            <span class="material-icons-outlined">add_circle</span>
                            Agregar producto
                        </a>
                    </div>
                    <div class="pr-card-body" style="padding:.75rem 1.25rem 1.25rem;">
                        <div class="table-responsive">
                            <table id="tablaProductos" class="table table-striped table-bordered" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Código</th>
                                        <th>ID Napers</th>
                                        <th style="text-align:center;">Imagen</th>
                                        <th style="text-align:center;">Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($productos as $producto):
                                        if (!is_object($producto)) continue;
                                        $pid = intval($producto->id ?? 0);
                                        $activo = intval($producto->estatus ?? 0) == 1;
                                        $tieneImg = !empty($producto->image);
                                    ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($producto->name ?? '', ENT_QUOTES, 'UTF-8'); ?></strong>
                                        </td>
                                        <td>
                                            <code style="font-size:.8rem;background:var(--pr-surface-alt);padding:.15rem .4rem;border-radius:4px;">
                                                <?php echo htmlspecialchars($producto->code ?? '—', ENT_QUOTES, 'UTF-8'); ?>
                                            </code>
                                        </td>
                                        <td><?php echo htmlspecialchars($producto->id_napers ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td style="text-align:center;">
                                            <span class="pr-img-check <?php echo $tieneImg ? 'yes' : 'no'; ?>">
                                                <span class="material-icons-outlined"><?php echo $tieneImg ? 'check' : 'close'; ?></span>
                                            </span>
                                        </td>
                                        <td style="text-align:center;">
                                            <span class="pr-status <?php echo $activo ? 'active' : 'inactive'; ?>">
                                                <span class="material-icons-outlined" style="font-size:.75rem;">
                                                    <?php echo $activo ? 'check_circle' : 'cancel'; ?>
                                                </span>
                                                <?php echo $activo ? 'Activo' : 'Inactivo'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="pr-actions">
                                                <a href="productos-form.php?id=<?php echo $pid; ?>"
                                                   class="pr-btn pr-btn-outline pr-btn-sm">
                                                    <span class="material-icons-outlined">edit</span>
                                                    Editar
                                                </a>
                                                <?php if ($activo): ?>
                                                <button onclick="cambiaEstatus(<?php echo $pid; ?>, 0)"
                                                        class="pr-btn pr-btn-danger pr-btn-sm">
                                                    <span class="material-icons-outlined">block</span>
                                                    Desactivar
                                                </button>
                                                <?php else: ?>
                                                <button onclick="cambiaEstatus(<?php echo $pid; ?>, 1)"
                                                        class="pr-btn pr-btn-success pr-btn-sm">
                                                    <span class="material-icons-outlined">check_circle</span>
                                                    Activar
                                                </button>
                                                <?php endif; ?>
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

    <!-- ═══ Scripts ═══ -->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>
    <!-- DataTables via CDN -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    /* ══ DataTable init ══ */
    $(document).ready(function() {
        var table = $('#tablaProductos').DataTable({
            lengthChange: true,
            pageLength: 25,
            buttons: ['copy', 'excel', 'pdf', 'print'],
            language: {
                search: 'Buscar:',
                lengthMenu: 'Mostrar _MENU_ registros',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ productos',
                infoEmpty: 'Sin productos',
                infoFiltered: '(filtrado de _MAX_ totales)',
                zeroRecords: 'No se encontraron productos',
                paginate: { first: 'Primero', last: 'Último', next: 'Sig.', previous: 'Ant.' }
            },
            order: [[0, 'asc']]
        });

        table.buttons().container()
            .appendTo('#tablaProductos_wrapper .col-md-6:eq(0)');
    });

    /* ══ Cambiar estatus ══ */
    function cambiaEstatus(id, estatus) {
        var accion = estatus == 1 ? 'activar' : 'desactivar';
        var color = estatus == 1 ? '#059669' : '#dc2626';

        Swal.fire({
            title: '¿' + (estatus == 1 ? 'Activar' : 'Desactivar') + ' este producto?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: color,
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, ' + accion,
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: 'api/apiProductos.php',
                type: 'POST',
                data: {
                    id: id,
                    estatus: estatus,
                    accion: 'cambioEstatus'
                },
                success: function() {
                    Swal.fire({
                        title: estatus == 1 ? 'Producto activado' : 'Producto desactivado',
                        icon: 'success',
                        confirmButtonColor: '#2563eb',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cambiar el estatus.',
                        confirmButtonColor: '#dc2626'
                    });
                }
            });
        });
    }
    </script>

</body>
</html>