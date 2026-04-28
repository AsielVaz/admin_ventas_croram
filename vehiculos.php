<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Vehículos" />
    <title>Croram Admin · Vehículos</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" />

    <style>
    :root {
        --vh-primary: #2563eb;
        --vh-primary-soft: rgba(37,99,235,.07);
        --vh-success: #059669;
        --vh-success-soft: rgba(5,150,105,.08);
        --vh-danger: #dc2626;
        --vh-danger-soft: rgba(220,38,38,.07);
        --vh-text: #1e293b;
        --vh-text-secondary: #64748b;
        --vh-text-muted: #94a3b8;
        --vh-surface: #ffffff;
        --vh-surface-alt: #f8fafc;
        --vh-border: #e2e8f0;
        --vh-radius: 14px;
        --vh-radius-sm: 10px;
        --vh-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --vh-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--vh-font); }

    .vh-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--vh-text-secondary);
    }
    .vh-breadcrumb a { color: var(--vh-primary); text-decoration: none; }
    .vh-breadcrumb .sep { opacity: .4; }

    .vh-card {
        background: var(--vh-surface);
        border: 1px solid var(--vh-border);
        border-radius: var(--vh-radius);
        box-shadow: var(--vh-shadow);
        overflow: hidden;
        animation: fadeIn .35s ease both;
    }
    .vh-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--vh-border);
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; flex-wrap: wrap;
        background: var(--vh-surface-alt);
    }
    .vh-card-header-left {
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--vh-text);
    }
    .vh-card-header-left .material-icons-outlined { font-size: 1.2rem; color: var(--vh-primary); }
    .vh-card-body { padding: 1.25rem 1.5rem; }

    /* KPIs */
    .vh-kpi-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .vh-kpi {
        background: var(--vh-surface);
        border: 1px solid var(--vh-border);
        border-radius: var(--vh-radius-sm);
        padding: 1rem 1.15rem;
        display: flex; flex-direction: column; gap: .15rem;
        animation: fadeIn .3s ease both;
    }
    .vh-kpi-label {
        font-size: .7rem; text-transform: uppercase;
        letter-spacing: .06em; color: var(--vh-text-muted); font-weight: 600;
    }
    .vh-kpi-value {
        font-size: 1.35rem; font-weight: 700; color: var(--vh-text); line-height: 1.2;
    }

    /* Buttons */
    .vh-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.1rem; border-radius: var(--vh-radius-sm);
        font-size: .82rem; font-weight: 600; font-family: var(--vh-font);
        cursor: pointer; border: none; transition: all .2s;
        text-decoration: none; white-space: nowrap;
    }
    .vh-btn .material-icons-outlined { font-size: 1rem; }
    .vh-btn-primary { background: var(--vh-primary); color: #fff; }
    .vh-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .vh-btn-danger { background: var(--vh-danger); color: #fff; }
    .vh-btn-danger:hover { background: #b91c1c; color: #fff; }
    .vh-btn-outline {
        background: transparent; color: var(--vh-text-secondary);
        border: 1px solid var(--vh-border);
    }
    .vh-btn-outline:hover { border-color: var(--vh-primary); color: var(--vh-primary); }
    .vh-btn-sm { padding: .4rem .75rem; font-size: .78rem; }

    /* Plate badge */
    .vh-plate {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .2rem .6rem; border-radius: 6px;
        font-size: .8rem; font-weight: 700; letter-spacing: .04em;
        background: var(--vh-surface-alt); color: var(--vh-text);
        border: 1px solid var(--vh-border);
    }

    /* Actions cell */
    .vh-actions { display: flex; gap: .4rem; align-items: center; flex-wrap: wrap; }

    /* DataTables overrides */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: var(--vh-radius-sm) !important;
        border: 1px solid var(--vh-border) !important;
        font-family: var(--vh-font) !important;
        font-size: .85rem !important; padding: .45rem .85rem !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--vh-primary) !important;
        box-shadow: 0 0 0 3px var(--vh-primary-soft) !important; outline: none !important;
    }
    .dataTables_wrapper .dataTables_length select {
        border-radius: var(--vh-radius-sm) !important;
        border: 1px solid var(--vh-border) !important;
        font-family: var(--vh-font) !important;
    }
    table.dataTable thead th {
        background: var(--vh-surface-alt) !important;
        font-weight: 600 !important; font-size: .75rem !important;
        text-transform: uppercase !important; letter-spacing: .04em !important;
        color: var(--vh-text-secondary) !important;
        border-bottom: 1px solid var(--vh-border) !important;
        padding: .7rem 1rem !important;
    }
    table.dataTable tbody td {
        font-size: .85rem !important; color: var(--vh-text) !important;
        padding: .65rem 1rem !important; vertical-align: middle !important;
        border-bottom: 1px solid var(--vh-border) !important;
    }
    table.dataTable tbody tr:hover { background: var(--vh-primary-soft) !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--vh-primary) !important; color: #fff !important;
        border: none !important; border-radius: 8px !important;
    }
    .dataTables_wrapper .dataTables_info {
        font-size: .8rem !important; color: var(--vh-text-muted) !important;
    }
    div.dt-buttons .btn {
        border-radius: var(--vh-radius-sm) !important;
        font-family: var(--vh-font) !important;
        font-size: .78rem !important; font-weight: 600 !important;
        padding: .4rem .85rem !important;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminAutos.php";
    $adminAutos = new AdministradorAutos();
    $autos = $adminAutos->dameAutosConUsuario();
    if (!is_array($autos)) $autos = [];

    // KPIs
    $totalAutos = count($autos);
    $clientesUnicos = [];
    foreach ($autos as $a) {
        if (is_object($a) && !empty($a->nombre)) {
            $clientesUnicos[$a->nombre] = true;
        }
    }
    $totalClientes = count($clientesUnicos);
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="vh-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span>Catálogos</span>
                    <span class="sep">/</span>
                    <span style="color:var(--vh-text);font-weight:600;">Vehículos</span>
                </div>

                <!-- KPIs -->
                <div class="vh-kpi-row">
                    <div class="vh-kpi" style="animation-delay:.05s;">
                        <span class="vh-kpi-label">Total vehículos</span>
                        <span class="vh-kpi-value"><?php echo $totalAutos; ?></span>
                    </div>
                    <div class="vh-kpi" style="animation-delay:.1s;">
                        <span class="vh-kpi-label">Clientes con vehículo</span>
                        <span class="vh-kpi-value"><?php echo $totalClientes; ?></span>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="vh-card">
                    <div class="vh-card-header">
                        <div class="vh-card-header-left">
                            <span class="material-icons-outlined">local_shipping</span>
                            Lista de vehículos
                        </div>
                        <a href="vehiculos-form.php" class="vh-btn vh-btn-primary">
                            <span class="material-icons-outlined">add_circle</span>
                            Agregar vehículo
                        </a>
                    </div>
                    <div class="vh-card-body" style="padding:.75rem 1.25rem 1.25rem;">
                        <div class="table-responsive">
                            <table id="tablaVehiculos" class="table table-striped table-bordered" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Color</th>
                                        <th>Placas</th>
                                        <th>Cliente</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($autos as $auto):
                                        if (!is_object($auto)) continue;
                                        $aid = intval($auto->id ?? 0);
                                    ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($auto->marca ?? '', ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                        <td><?php echo htmlspecialchars($auto->modelo ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($auto->color ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <span class="vh-plate">
                                                <?php echo htmlspecialchars($auto->placas ?? '—', ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($auto->nombre ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <div class="vh-actions">
                                                <a href="vehiculos-form.php?id=<?php echo $aid; ?>"
                                                   class="vh-btn vh-btn-outline vh-btn-sm">
                                                    <span class="material-icons-outlined">edit</span>
                                                    Editar
                                                </a>
                                                <button onclick="eliminarAuto(<?php echo $aid; ?>)"
                                                        class="vh-btn vh-btn-danger vh-btn-sm">
                                                    <span class="material-icons-outlined">delete</span>
                                                    Eliminar
                                                </button>
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
    <!-- DataTables CDN -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    /* ══ DataTable ══ */
    $(document).ready(function() {
        var table = $('#tablaVehiculos').DataTable({
            lengthChange: true,
            pageLength: 25,
            buttons: ['copy', 'excel', 'pdf', 'print'],
            language: {
                search: 'Buscar:',
                lengthMenu: 'Mostrar _MENU_ registros',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ vehículos',
                infoEmpty: 'Sin vehículos',
                infoFiltered: '(filtrado de _MAX_ totales)',
                zeroRecords: 'No se encontraron vehículos',
                paginate: { first: 'Primero', last: 'Último', next: 'Sig.', previous: 'Ant.' }
            },
            order: [[4, 'asc']]
        });

        table.buttons().container()
            .appendTo('#tablaVehiculos_wrapper .col-md-6:eq(0)');
    });

    /* ══ Eliminar auto ══ */
    function eliminarAuto(id) {
        Swal.fire({
            title: '¿Eliminar este vehículo?',
            text: 'Esta acción no se puede revertir.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            var fd = new FormData();
            fd.append('accion', 'baja');
            fd.append('id', id);

            fetch('api/apiAutos.php', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.tipo === 'success') {
                        Swal.fire({
                            title: 'Eliminado',
                            text: 'El vehículo ha sido eliminado.',
                            icon: 'success',
                            confirmButtonColor: '#059669',
                            timer: 1800,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.mensaje || 'No se pudo eliminar.',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(function(err) {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error de conexión.',
                        confirmButtonColor: '#dc2626'
                    });
                });
        });
    }
    </script>

</body>
</html>