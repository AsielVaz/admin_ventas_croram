<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Órdenes de Compra" />
    <title>Croram Admin · Órdenes</title>
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
        --or-primary: #2563eb;
        --or-primary-soft: rgba(37,99,235,.07);
        --or-success: #059669;
        --or-success-soft: rgba(5,150,105,.08);
        --or-danger: #dc2626;
        --or-danger-soft: rgba(220,38,38,.07);
        --or-warning: #d97706;
        --or-warning-soft: rgba(217,119,6,.08);
        --or-info: #0284c7;
        --or-info-soft: rgba(2,132,199,.08);
        --or-text: #1e293b;
        --or-text-secondary: #64748b;
        --or-text-muted: #94a3b8;
        --or-surface: #ffffff;
        --or-surface-alt: #f8fafc;
        --or-border: #e2e8f0;
        --or-radius: 14px;
        --or-radius-sm: 10px;
        --or-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --or-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--or-font); }

    .or-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--or-text-secondary);
    }
    .or-breadcrumb a { color: var(--or-primary); text-decoration: none; }
    .or-breadcrumb .sep { opacity: .4; }

    .or-card {
        background: var(--or-surface); border: 1px solid var(--or-border);
        border-radius: var(--or-radius); box-shadow: var(--or-shadow);
        overflow: hidden; animation: fadeIn .35s ease both;
    }
    .or-card-header {
        padding: 1rem 1.5rem; border-bottom: 1px solid var(--or-border);
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; flex-wrap: wrap; background: var(--or-surface-alt);
    }
    .or-card-header-left {
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--or-text);
    }
    .or-card-header-left .material-icons-outlined { font-size: 1.2rem; color: var(--or-primary); }
    .or-card-body { padding: 1.25rem 1.5rem; }

    /* KPIs */
    .or-kpi-row {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .or-kpi {
        background: var(--or-surface); border: 1px solid var(--or-border);
        border-radius: var(--or-radius-sm); padding: 1rem 1.15rem;
        display: flex; flex-direction: column; gap: .15rem;
        animation: fadeIn .3s ease both;
    }
    .or-kpi-label { font-size: .7rem; text-transform: uppercase; letter-spacing: .06em; color: var(--or-text-muted); font-weight: 600; }
    .or-kpi-value { font-size: 1.35rem; font-weight: 700; color: var(--or-text); line-height: 1.2; }

    /* Status badge */
    .or-status {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .25rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 600; white-space: nowrap;
    }
    .or-status.cancelada  { background: var(--or-danger-soft);  color: var(--or-danger); }
    .or-status.entregada  { background: var(--or-success-soft); color: var(--or-success); }
    .or-status.proceso    { background: var(--or-info-soft);    color: var(--or-info); }
    .or-status.aprobada   { background: var(--or-warning-soft); color: var(--or-warning); }
    .or-status.pendiente  { background: var(--or-primary-soft); color: var(--or-primary); }

    /* Buttons */
    .or-btn {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .4rem .75rem; border-radius: var(--or-radius-sm);
        font-size: .78rem; font-weight: 600; font-family: var(--or-font);
        cursor: pointer; border: none; transition: all .2s;
        text-decoration: none; white-space: nowrap;
    }
    .or-btn .material-icons-outlined { font-size: .95rem; }
    .or-btn-primary { background: var(--or-primary); color: #fff; }
    .or-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .or-btn-danger { background: var(--or-danger); color: #fff; }
    .or-btn-danger:hover { background: #b91c1c; color: #fff; }
    .or-btn-info { background: var(--or-info-soft); color: var(--or-info); border: 1px solid transparent; }
    .or-btn-info:hover { border-color: var(--or-info); }
    .or-btn-outline { background: transparent; color: var(--or-text-secondary); border: 1px solid var(--or-border); }
    .or-btn-outline:hover { border-color: var(--or-primary); color: var(--or-primary); }

    .or-actions { display: flex; gap: .35rem; align-items: center; flex-wrap: wrap; }

    /* Sub-table for details */
    .or-subtable {
        background: var(--or-surface-alt); border-radius: 8px;
        padding: .75rem; margin: .25rem 0;
    }
    .or-subtable table { width: 100%; font-size: .82rem; border-collapse: collapse; }
    .or-subtable thead th {
        padding: .4rem .65rem; font-weight: 600; font-size: .7rem;
        text-transform: uppercase; letter-spacing: .03em;
        color: var(--or-text-secondary); border-bottom: 1px solid var(--or-border);
    }
    .or-subtable tbody td {
        padding: .35rem .65rem; color: var(--or-text);
        border-bottom: 1px solid var(--or-border);
    }
    .or-subtable tfoot th {
        padding: .5rem .65rem; font-weight: 700; color: var(--or-primary);
        border-top: 2px solid var(--or-border);
    }

    /* Pagination */
    .or-pagination {
        display: flex; align-items: center; gap: .35rem;
        justify-content: center; padding: 1rem 0 .5rem;
        flex-wrap: wrap; list-style: none; margin: 0;
    }
    .or-pagination li a {
        display: flex; align-items: center; justify-content: center;
        min-width: 36px; height: 36px; padding: 0 .5rem;
        border-radius: 8px; font-size: .82rem; font-weight: 600;
        color: var(--or-text-secondary); text-decoration: none;
        border: 1px solid var(--or-border); transition: all .15s;
        font-family: var(--or-font);
    }
    .or-pagination li a:hover { border-color: var(--or-primary); color: var(--or-primary); }
    .or-pagination li a.active {
        background: var(--or-primary); color: #fff; border-color: var(--or-primary);
    }
    .or-pagination li a.disabled {
        opacity: .4; pointer-events: none;
    }

    /* DataTables overrides */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: var(--or-radius-sm) !important; border: 1px solid var(--or-border) !important;
        font-family: var(--or-font) !important; font-size: .85rem !important; padding: .45rem .85rem !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--or-primary) !important; box-shadow: 0 0 0 3px var(--or-primary-soft) !important; outline: none !important;
    }
    table.dataTable thead th {
        background: var(--or-surface-alt) !important; font-weight: 600 !important; font-size: .75rem !important;
        text-transform: uppercase !important; letter-spacing: .04em !important;
        color: var(--or-text-secondary) !important; border-bottom: 1px solid var(--or-border) !important;
        padding: .7rem 1rem !important;
    }
    table.dataTable tbody td {
        font-size: .84rem !important; color: var(--or-text) !important;
        padding: .6rem 1rem !important; vertical-align: middle !important;
        border-bottom: 1px solid var(--or-border) !important;
    }
    table.dataTable tbody tr:hover { background: var(--or-primary-soft) !important; }
    .dataTables_wrapper .dataTables_info { font-size: .8rem !important; color: var(--or-text-muted) !important; }
    div.dt-buttons .btn {
        border-radius: var(--or-radius-sm) !important; font-family: var(--or-font) !important;
        font-size: .78rem !important; font-weight: 600 !important; padding: .4rem .85rem !important;
    }
    /* Hide DT's own pagination (we use PHP pagination) */
    .dataTables_wrapper .dataTables_paginate { display: none !important; }
    .dataTables_wrapper .dataTables_length { display: none !important; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminOrdenes.php";
    include_once "api/adminAutos.php";
    include_once "api/adminUsuarios.php";

    $adminOrdenes  = new AdministradorOrdenes();
    $adminUsuarios = new AdministradorUsuarios();
    $adminAutos    = new AdministradorAutos();

    $rows = 10;
    if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
        $pagina = (int)$_GET['pagina'];
    } else {
        $pagina = 1;
    }
    $totalOrdenes = $adminOrdenes->contarOrdenes();
    $totalPaginas = ceil($totalOrdenes / $rows);

    $ordenesList = $adminOrdenes->obtenerOrdenesPaginacion(10, $pagina);
    if (!is_array($ordenesList)) $ordenesList = [];
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="or-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span style="color:var(--or-text);font-weight:600;">Órdenes de compra</span>
                </div>

                <!-- KPIs -->
                <div class="or-kpi-row">
                    <div class="or-kpi" style="animation-delay:.05s;">
                        <span class="or-kpi-label">Total órdenes</span>
                        <span class="or-kpi-value"><?php echo intval($totalOrdenes); ?></span>
                    </div>
                    <div class="or-kpi" style="animation-delay:.1s;">
                        <span class="or-kpi-label">Página actual</span>
                        <span class="or-kpi-value"><?php echo $pagina; ?> <span style="font-size:.75rem;font-weight:400;color:var(--or-text-muted);">/ <?php echo $totalPaginas; ?></span></span>
                    </div>
                    <div class="or-kpi" style="animation-delay:.15s;">
                        <span class="or-kpi-label">Mostrando</span>
                        <span class="or-kpi-value"><?php echo count($ordenesList); ?> <span style="font-size:.75rem;font-weight:400;color:var(--or-text-muted);">registros</span></span>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="or-card">
                    <div class="or-card-header">
                        <div class="or-card-header-left">
                            <span class="material-icons-outlined">receipt_long</span>
                            Órdenes de compra
                        </div>
                        <a href="ordenes-crear.php" class="or-btn or-btn-primary">
                            <span class="material-icons-outlined">add_circle</span>
                            Nueva orden
                        </a>
                    </div>
                    <div class="or-card-body" style="padding:.75rem 1.25rem 1.25rem;">
                        <div class="table-responsive">
                            <table id="tablaOrdenes" class="table table-striped table-bordered" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Vehículo</th>
                                        <th>Fecha entrega</th>
                                        <th>Tiempo</th>
                                        <th>Vendedor</th>
                                        <th style="text-align:center;">Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($ordenesList as $orden) {
                                        $productos = $adminOrdenes->dameProductosOrdenCompuestos($orden->id);
                                        $auto      = $adminAutos->obtenerAuto($orden->id_veiculo);
                                        $cliente   = $adminUsuarios->dameUsuario($orden->id_cliente);
                                        $vendedor  = $adminUsuarios->dameUsuario($orden->id_crea);

                                        if (!is_array($productos)) $productos = [];

                                        $oid = intval($orden->id);
                                        $clienteNom  = htmlspecialchars(($cliente->nombre ?? '') . ' ' . ($cliente->apellido ?? ''), ENT_QUOTES, 'UTF-8');
                                        $autoStr     = htmlspecialchars(($auto->marca ?? '') . ' ' . ($auto->modelo ?? '') . ' (' . ($auto->placas ?? '') . ')', ENT_QUOTES, 'UTF-8');
                                        $vendedorNom = htmlspecialchars(($vendedor->nombre ?? '') . ' ' . ($vendedor->apellido ?? ''), ENT_QUOTES, 'UTF-8');
                                        $tiempoMin   = number_format((intval($orden->tiempo_entrega ?? 0) / 60), 2);
                                        $fechaE      = htmlspecialchars($orden->fecha_entrega ?? '—', ENT_QUOTES, 'UTF-8');

                                        // Status
                                        $estatus    = intval($orden->estatus ?? 0);
                                        $statusText  = 'Pendiente';
                                        $statusClass = 'pendiente';
                                        if ($estatus == 9)  { $statusText = 'Cancelada';  $statusClass = 'cancelada'; }
                                        elseif ($estatus == 2) { $statusText = 'Entregada';  $statusClass = 'entregada'; }
                                        elseif ($estatus == 1) { $statusText = 'En proceso'; $statusClass = 'proceso'; }
                                        elseif ($estatus == 99) { $statusText = 'Aprobada';  $statusClass = 'aprobada'; }
                                    ?>
                                    <tr>
                                        <td><strong>#<?php echo $oid; ?></strong></td>
                                        <td><?php echo $clienteNom; ?></td>
                                        <td><?php echo $autoStr; ?></td>
                                        <td><?php echo $fechaE; ?></td>
                                        <td><?php echo $tiempoMin; ?> min</td>
                                        <td><?php echo $vendedorNom; ?></td>
                                        <td style="text-align:center;">
                                            <span class="or-status <?php echo $statusClass; ?>">
                                                <span class="material-icons-outlined" style="font-size:.75rem;">
                                                    <?php
                                                    if ($estatus == 9) echo 'cancel';
                                                    elseif ($estatus == 2) echo 'check_circle';
                                                    elseif ($estatus == 1) echo 'local_shipping';
                                                    elseif ($estatus == 99) echo 'verified';
                                                    else echo 'pending';
                                                    ?>
                                                </span>
                                                <?php echo $statusText; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="or-actions">
                                                <?php if ($estatus == 9): ?>
                                                    <button class="or-btn or-btn-info" onclick="toggleDetalles(<?php echo $oid; ?>)">
                                                        <span class="material-icons-outlined">visibility</span> Detalles
                                                    </button>
                                                <?php elseif ($estatus == 2): ?>
                                                    <button class="or-btn or-btn-info" onclick="toggleDetalles(<?php echo $oid; ?>)">
                                                        <span class="material-icons-outlined">visibility</span> Detalles
                                                    </button>
                                                <?php elseif ($estatus == 1): ?>
                                                    <button class="or-btn or-btn-info" onclick="toggleDetalles(<?php echo $oid; ?>)">
                                                        <span class="material-icons-outlined">visibility</span> Detalles
                                                    </button>
                                                <?php elseif ($estatus == 99): ?>
                                                    <button class="or-btn or-btn-danger" onclick="cancelarOrden(<?php echo $oid; ?>)">
                                                        <span class="material-icons-outlined">cancel</span> Cancelar
                                                    </button>
                                                    <button class="or-btn or-btn-info" onclick="toggleDetalles(<?php echo $oid; ?>)">
                                                        <span class="material-icons-outlined">visibility</span> Detalles
                                                    </button>
                                                <?php else: ?>
                                                    <a href="moderacion.php?id=<?php echo $oid; ?>" class="or-btn or-btn-primary">
                                                        <span class="material-icons-outlined">edit</span> Editar
                                                    </a>
                                                    <button class="or-btn or-btn-danger" onclick="cancelarOrden(<?php echo $oid; ?>)">
                                                        <span class="material-icons-outlined">cancel</span> Cancelar
                                                    </button>
                                                    <button class="or-btn or-btn-info" onclick="toggleDetalles(<?php echo $oid; ?>)">
                                                        <span class="material-icons-outlined">visibility</span> Detalles
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Detail sub-row -->
                                    <tr id="detalles-<?php echo $oid; ?>" style="display:none;">
                                        <td colspan="8" style="padding:.5rem 1rem;">
                                            <div class="or-subtable">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>ID Prod.</th>
                                                            <th>Producto</th>
                                                            <th style="text-align:center;">Cantidad</th>
                                                            <th style="text-align:right;">Precio unit.</th>
                                                            <th style="text-align:right;">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $totalOrden = 0;
                                                        foreach ($productos as $producto) {
                                                            $totalProducto = floatval($producto->cantidad ?? 0) * floatval($producto->precio_unitario ?? 0);
                                                            $totalOrden += $totalProducto;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo intval($producto->id_producto ?? 0); ?></td>
                                                            <td><?php echo htmlspecialchars($producto->name ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td style="text-align:center;"><?php echo intval($producto->cantidad ?? 0); ?></td>
                                                            <td style="text-align:right;">$<?php echo number_format(floatval($producto->precio_unitario ?? 0), 2); ?></td>
                                                            <td style="text-align:right;">$<?php echo number_format($totalProducto, 2); ?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="4" style="text-align:right;">Total</th>
                                                            <th style="text-align:right;">$<?php echo number_format($totalOrden, 2); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination (original PHP logic) -->
                        <ul class="or-pagination">
                            <?php
                            // Previous
                            if ($pagina > 1) {
                                echo '<li><a href="?pagina=' . ($pagina - 1) . '"><span class="material-icons-outlined" style="font-size:1rem;">chevron_left</span></a></li>';
                            } else {
                                echo '<li><a href="javascript:void(0);" class="disabled"><span class="material-icons-outlined" style="font-size:1rem;">chevron_left</span></a></li>';
                            }

                            $maxVisible = 10;
                            if ($totalPaginas <= $maxVisible) {
                                $start = 1; $end = $totalPaginas;
                            } else {
                                if ($pagina <= 6) { $start = 1; $end = 10; }
                                else {
                                    $start = $pagina - 4; $end = $pagina + 5;
                                    if ($end > $totalPaginas) { $end = $totalPaginas; $start = $end - 9; }
                                }
                            }

                            for ($i = $start; $i <= $end; $i++) {
                                $active = ($i == $pagina) ? 'active' : '';
                                echo '<li><a href="?pagina=' . $i . '" class="' . $active . '">' . $i . '</a></li>';
                            }

                            if ($end < $totalPaginas) {
                                echo '<li><a href="javascript:void(0);" class="disabled">...</a></li>';
                                echo '<li><a href="?pagina=' . $totalPaginas . '">' . $totalPaginas . '</a></li>';
                            }

                            // Next
                            if ($pagina < $totalPaginas) {
                                echo '<li><a href="?pagina=' . ($pagina + 1) . '"><span class="material-icons-outlined" style="font-size:1rem;">chevron_right</span></a></li>';
                            } else {
                                echo '<li><a href="javascript:void(0);" class="disabled"><span class="material-icons-outlined" style="font-size:1rem;">chevron_right</span></a></li>';
                            }
                            ?>
                        </ul>

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
    /* ══ DataTable (search + export only, pagination is PHP) ══ */
 

    /* ══ Toggle detalles (original) ══ */
    function toggleDetalles(id) {
        var fila = document.getElementById('detalles-' + id);
        if (fila.style.display === 'none') {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    }

    /* ══ Cancelar orden (original logic) ══ */
    function cancelarOrden(id) {
        Swal.fire({
            title: '¿Cancelar esta orden?',
            text: 'Esta acción no se puede revertir.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, cancelar orden',
            cancelButtonText: 'No, volver'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            var formData = new FormData();
            formData.append('id', id);
            formData.append('accion', 'rechazar');

            fetch('api/apiOrdenes.php', { method: 'POST', body: formData })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.tipo == 'success') {
                        Swal.fire({
                            title: 'Cancelada',
                            text: 'La orden ha sido cancelada.',
                            icon: 'success',
                            confirmButtonColor: '#059669',
                            timer: 1800,
                            showConfirmButton: false
                        }).then(function() { location.reload(); });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al cancelar la orden.',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(function(err) {
                    console.error(err);
                    Swal.fire({ icon: 'error', title: 'Error de conexión', confirmButtonColor: '#dc2626' });
                });
        });
    }
    </script>

</body>
</html>