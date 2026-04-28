<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Ofertas" />
    <title>Croram Admin · Ofertas</title>
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
        --of-primary: #2563eb;
        --of-primary-soft: rgba(37,99,235,.07);
        --of-success: #059669;
        --of-success-soft: rgba(5,150,105,.08);
        --of-danger: #dc2626;
        --of-danger-soft: rgba(220,38,38,.07);
        --of-warning: #d97706;
        --of-warning-soft: rgba(217,119,6,.08);
        --of-text: #1e293b;
        --of-text-secondary: #64748b;
        --of-text-muted: #94a3b8;
        --of-surface: #ffffff;
        --of-surface-alt: #f8fafc;
        --of-border: #e2e8f0;
        --of-radius: 14px;
        --of-radius-sm: 10px;
        --of-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --of-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--of-font); }

    .of-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--of-text-secondary);
    }
    .of-breadcrumb a { color: var(--of-primary); text-decoration: none; }
    .of-breadcrumb .sep { opacity: .4; }

    .of-card {
        background: var(--of-surface);
        border: 1px solid var(--of-border);
        border-radius: var(--of-radius);
        box-shadow: var(--of-shadow);
        overflow: hidden;
        animation: fadeIn .35s ease both;
    }
    .of-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--of-border);
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; flex-wrap: wrap;
        background: var(--of-surface-alt);
    }
    .of-card-header-left {
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--of-text);
    }
    .of-card-header-left .material-icons-outlined { font-size: 1.2rem; color: var(--of-primary); }
    .of-card-body { padding: 1.25rem 1.5rem; }

    /* KPIs */
    .of-kpi-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .of-kpi {
        background: var(--of-surface);
        border: 1px solid var(--of-border);
        border-radius: var(--of-radius-sm);
        padding: 1rem 1.15rem;
        display: flex; flex-direction: column; gap: .15rem;
        animation: fadeIn .3s ease both;
    }
    .of-kpi-label {
        font-size: .7rem; text-transform: uppercase;
        letter-spacing: .06em; color: var(--of-text-muted); font-weight: 600;
    }
    .of-kpi-value {
        font-size: 1.35rem; font-weight: 700; color: var(--of-text); line-height: 1.2;
    }

    /* Buttons */
    .of-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.1rem; border-radius: var(--of-radius-sm);
        font-size: .82rem; font-weight: 600; font-family: var(--of-font);
        cursor: pointer; border: none; transition: all .2s;
        text-decoration: none; white-space: nowrap;
    }
    .of-btn .material-icons-outlined { font-size: 1rem; }
    .of-btn-primary { background: var(--of-primary); color: #fff; }
    .of-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .of-btn-danger { background: var(--of-danger); color: #fff; }
    .of-btn-danger:hover { background: #b91c1c; color: #fff; }
    .of-btn-outline {
        background: transparent; color: var(--of-text-secondary);
        border: 1px solid var(--of-border);
    }
    .of-btn-outline:hover { border-color: var(--of-primary); color: var(--of-primary); }
    .of-btn-sm { padding: .4rem .75rem; font-size: .78rem; }

    /* Status badge */
    .of-status {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .25rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 600;
    }
    .of-status.active { background: var(--of-success-soft); color: var(--of-success); }
    .of-status.inactive { background: var(--of-danger-soft); color: var(--of-danger); }

    /* Type badge */
    .of-type-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .25rem .6rem; border-radius: 6px;
        font-size: .75rem; font-weight: 600;
    }
    .of-type-badge.free { background: var(--of-primary-soft); color: var(--of-primary); }
    .of-type-badge.discount { background: var(--of-warning-soft); color: var(--of-warning); }
    .of-type-badge.unknown { background: var(--of-surface-alt); color: var(--of-text-muted); }

    /* Actions */
    .of-actions { display: flex; gap: .4rem; align-items: center; flex-wrap: wrap; }

    /* DataTables overrides */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: var(--of-radius-sm) !important;
        border: 1px solid var(--of-border) !important;
        font-family: var(--of-font) !important;
        font-size: .85rem !important; padding: .45rem .85rem !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--of-primary) !important;
        box-shadow: 0 0 0 3px var(--of-primary-soft) !important; outline: none !important;
    }
    .dataTables_wrapper .dataTables_length select {
        border-radius: var(--of-radius-sm) !important;
        border: 1px solid var(--of-border) !important;
        font-family: var(--of-font) !important;
    }
    table.dataTable thead th {
        background: var(--of-surface-alt) !important;
        font-weight: 600 !important; font-size: .75rem !important;
        text-transform: uppercase !important; letter-spacing: .04em !important;
        color: var(--of-text-secondary) !important;
        border-bottom: 1px solid var(--of-border) !important;
        padding: .7rem 1rem !important;
    }
    table.dataTable tbody td {
        font-size: .85rem !important; color: var(--of-text) !important;
        padding: .65rem 1rem !important; vertical-align: middle !important;
        border-bottom: 1px solid var(--of-border) !important;
    }
    table.dataTable tbody tr:hover { background: var(--of-primary-soft) !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--of-primary) !important; color: #fff !important;
        border: none !important; border-radius: 8px !important;
    }
    .dataTables_wrapper .dataTables_info {
        font-size: .8rem !important; color: var(--of-text-muted) !important;
    }
    div.dt-buttons .btn {
        border-radius: var(--of-radius-sm) !important;
        font-family: var(--of-font) !important;
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
    include_once "api/adminOfertas.php";
    $adminOfertas = new AdministradorOfertas();
    $ofertas = $adminOfertas->obtenerOfertas();
    if (!is_array($ofertas)) $ofertas = [];

    // Helper: misma función del original
    function fechaEntre($fecha_inicio, $fecha_fin, $fecha) {
        $fi = strtotime($fecha_inicio);
        $ff = strtotime($fecha_fin);
        $fc = strtotime($fecha);
        if ($fi && $ff && $fc && $fc >= $fi && $fc <= $ff) {
            return "Activo";
        }
        return "Inactivo";
    }

    // KPIs
    $totalOfertas = count($ofertas);
    $activas = 0;
    $inactivas = 0;
    $hoy = date("Y-m-d");
    foreach ($ofertas as $o) {
        if (!is_object($o)) continue;
        if (fechaEntre($o->fecha_inicia ?? '', $o->fecha_fin ?? '', $hoy) === "Activo") {
            $activas++;
        } else {
            $inactivas++;
        }
    }
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="of-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span>Catálogos</span>
                    <span class="sep">/</span>
                    <span style="color:var(--of-text);font-weight:600;">Ofertas</span>
                </div>

                <!-- KPIs -->
                <div class="of-kpi-row">
                    <div class="of-kpi" style="animation-delay:.05s;">
                        <span class="of-kpi-label">Total ofertas</span>
                        <span class="of-kpi-value"><?php echo $totalOfertas; ?></span>
                    </div>
                    <div class="of-kpi" style="animation-delay:.1s;">
                        <span class="of-kpi-label">Activas hoy</span>
                        <span class="of-kpi-value" style="color:var(--of-success);"><?php echo $activas; ?></span>
                    </div>
                    <div class="of-kpi" style="animation-delay:.15s;">
                        <span class="of-kpi-label">Inactivas</span>
                        <span class="of-kpi-value" style="color:var(--of-danger);"><?php echo $inactivas; ?></span>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="of-card">
                    <div class="of-card-header">
                        <div class="of-card-header-left">
                            <span class="material-icons-outlined">local_offer</span>
                            Lista de ofertas
                        </div>
                        <a href="ofertas-form.php" class="of-btn of-btn-primary">
                            <span class="material-icons-outlined">add_circle</span>
                            Agregar oferta
                        </a>
                    </div>
                    <div class="of-card-body" style="padding:.75rem 1.25rem 1.25rem;">
                        <div class="table-responsive">
                            <table id="tablaOfertas" class="table table-striped table-bordered" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Tipo</th>
                                        <th style="text-align:center;">Estado</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ofertas as $oferta):
                                        if (!is_object($oferta)) continue;
                                        $oid = intval($oferta->id ?? 0);

                                        // Tipo de oferta (misma lógica del original)
                                        $tipoRaw = intval($oferta->tipo_oferta ?? 0);
                                        $tipoTexto = 'Desconocido';
                                        $tipoClass = 'unknown';
                                        if ($tipoRaw === 1) { $tipoTexto = 'Producto gratis'; $tipoClass = 'free'; }
                                        elseif ($tipoRaw === 2) { $tipoTexto = 'Descuento %'; $tipoClass = 'discount'; }

                                        // Estado
                                        $estado = fechaEntre($oferta->fecha_inicia ?? '', $oferta->fecha_fin ?? '', $hoy);
                                        $estadoClass = ($estado === 'Activo') ? 'active' : 'inactive';
                                    ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($oferta->product_name ?? '—', ENT_QUOTES, 'UTF-8'); ?></strong>
                                        </td>
                                        <td>
                                            <span class="of-type-badge <?php echo $tipoClass; ?>">
                                                <span class="material-icons-outlined" style="font-size:.8rem;">
                                                    <?php echo ($tipoRaw === 1) ? 'card_giftcard' : (($tipoRaw === 2) ? 'percent' : 'help_outline'); ?>
                                                </span>
                                                <?php echo $tipoTexto; ?>
                                            </span>
                                        </td>
                                        <td style="text-align:center;">
                                            <span class="of-status <?php echo $estadoClass; ?>">
                                                <span class="material-icons-outlined" style="font-size:.75rem;">
                                                    <?php echo ($estado === 'Activo') ? 'check_circle' : 'cancel'; ?>
                                                </span>
                                                <?php echo $estado; ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($oferta->fecha_inicia ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($oferta->fecha_fin ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <div class="of-actions">
                                                <a href="ofertas-form.php?id=<?php echo $oid; ?>"
                                                   class="of-btn of-btn-outline of-btn-sm">
                                                    <span class="material-icons-outlined">edit</span>
                                                    Editar
                                                </a>
                                                <button onclick="eliminarOferta(<?php echo $oid; ?>)"
                                                        class="of-btn of-btn-danger of-btn-sm">
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
        var table = $('#tablaOfertas').DataTable({
            lengthChange: true,
            pageLength: 25,
            buttons: ['copy', 'excel', 'pdf', 'print'],
            language: {
                search: 'Buscar:',
                lengthMenu: 'Mostrar _MENU_ registros',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ ofertas',
                infoEmpty: 'Sin ofertas',
                infoFiltered: '(filtrado de _MAX_ totales)',
                zeroRecords: 'No se encontraron ofertas',
                paginate: { first: 'Primero', last: 'Último', next: 'Sig.', previous: 'Ant.' }
            },
            order: [[2, 'desc'], [3, 'desc']]
        });

        table.buttons().container()
            .appendTo('#tablaOfertas_wrapper .col-md-6:eq(0)');
    });

    /* ══ Eliminar oferta ══ */
    function eliminarOferta(id) {
        Swal.fire({
            title: '¿Eliminar esta oferta?',
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

            fetch('api/apiOfertas.php', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.tipo === 'success') {
                        Swal.fire({
                            title: 'Eliminada',
                            text: 'La oferta ha sido eliminada.',
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
                        title: 'Error de conexión',
                        text: 'No se pudo conectar con el servidor.',
                        confirmButtonColor: '#dc2626'
                    });
                });
        });
    }
    </script>

</body>
</html>