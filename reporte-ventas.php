<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Reporte de ventas" />
    <title>Croram Admin &middot; Reporte de ventas</title>
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
        --rv-primary: #2563eb;
        --rv-primary-soft: rgba(37,99,235,.07);
        --rv-success: #059669;
        --rv-success-soft: rgba(5,150,105,.08);
        --rv-danger: #dc2626;
        --rv-warning: #d97706;
        --rv-warning-soft: rgba(217,119,6,.08);
        --rv-info: #0284c7;
        --rv-info-soft: rgba(2,132,199,.08);
        --rv-text: #1e293b;
        --rv-text-secondary: #64748b;
        --rv-text-muted: #94a3b8;
        --rv-surface: #ffffff;
        --rv-surface-alt: #f8fafc;
        --rv-border: #e2e8f0;
        --rv-radius: 14px;
        --rv-radius-sm: 10px;
        --rv-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --rv-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--rv-font); }
    .rv-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.25rem; font-size: .85rem; color: var(--rv-text-secondary);
    }
    .rv-breadcrumb a { color: var(--rv-primary); text-decoration: none; }
    .rv-breadcrumb .sep { opacity: .4; }
    .rv-toolbar {
        background: var(--rv-surface);
        border: 1px solid var(--rv-border);
        border-radius: var(--rv-radius);
        padding: 1rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex; align-items: end; gap: .85rem; flex-wrap: wrap;
        box-shadow: var(--rv-shadow);
    }
    .rv-field { display: flex; flex-direction: column; gap: .35rem; min-width: 180px; }
    .rv-field label {
        font-size: .72rem; text-transform: uppercase; letter-spacing: .05em;
        color: var(--rv-text-muted); font-weight: 700;
    }
    .rv-field input {
        height: 40px; border-radius: var(--rv-radius-sm); border: 1px solid var(--rv-border);
        padding: 0 .8rem; font-family: var(--rv-font); color: var(--rv-text);
    }
    .rv-btn {
        display: inline-flex; align-items: center; gap: .35rem;
        height: 40px; padding: 0 1rem; border-radius: var(--rv-radius-sm);
        border: none; background: var(--rv-primary); color: #fff;
        font-size: .82rem; font-weight: 700; text-decoration: none;
    }
    .rv-btn:hover { background: #1d4ed8; color: #fff; }
    .rv-kpi-row {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(165px, 1fr));
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .rv-kpi {
        background: var(--rv-surface); border: 1px solid var(--rv-border);
        border-radius: var(--rv-radius-sm); padding: 1rem 1.15rem;
        display: flex; flex-direction: column; gap: .15rem; animation: fadeIn .3s ease both;
    }
    .rv-kpi-label {
        font-size: .7rem; text-transform: uppercase; letter-spacing: .06em;
        color: var(--rv-text-muted); font-weight: 600;
    }
    .rv-kpi-value { font-size: 1.35rem; font-weight: 700; color: var(--rv-text); line-height: 1.2; }
    .rv-grid {
        display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(300px, .8fr);
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .rv-card {
        background: var(--rv-surface); border: 1px solid var(--rv-border);
        border-radius: var(--rv-radius); box-shadow: var(--rv-shadow);
        overflow: hidden; animation: fadeIn .35s ease both;
    }
    .rv-card-header {
        padding: 1rem 1.5rem; border-bottom: 1px solid var(--rv-border);
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; flex-wrap: wrap; background: var(--rv-surface-alt);
    }
    .rv-card-header-left {
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--rv-text);
    }
    .rv-card-header-left .material-icons-outlined { font-size: 1.2rem; color: var(--rv-primary); }
    .rv-card-body { padding: 1.25rem 1.5rem; }
    .rv-rank { display: flex; flex-direction: column; gap: .75rem; }
    .rv-rank-item { display: grid; grid-template-columns: 1fr auto; gap: .75rem; align-items: center; }
    .rv-rank-name { font-weight: 700; color: var(--rv-text); font-size: .86rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .rv-rank-meta { color: var(--rv-text-muted); font-size: .76rem; }
    .rv-money { font-weight: 800; color: var(--rv-success); white-space: nowrap; }
    .rv-progress { grid-column: 1 / -1; height: 7px; background: var(--rv-surface-alt); border-radius: 999px; overflow: hidden; }
    .rv-progress span { display: block; height: 100%; background: var(--rv-info); border-radius: inherit; }
    .rv-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .25rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 600; white-space: nowrap;
        background: var(--rv-info-soft); color: var(--rv-info);
    }
    .rv-badge.order { background: var(--rv-primary-soft); color: var(--rv-primary); }
    .rv-badge.cash { background: var(--rv-success-soft); color: var(--rv-success); }
    .rv-badge.credit { background: var(--rv-warning-soft); color: var(--rv-warning); }
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: var(--rv-radius-sm) !important;
        border: 1px solid var(--rv-border) !important;
        font-family: var(--rv-font) !important;
        font-size: .85rem !important;
    }
    table.dataTable thead th {
        background: var(--rv-surface-alt) !important; font-weight: 600 !important;
        font-size: .75rem !important; text-transform: uppercase !important;
        letter-spacing: .04em !important; color: var(--rv-text-secondary) !important;
        border-bottom: 1px solid var(--rv-border) !important; padding: .7rem 1rem !important;
    }
    table.dataTable tbody td {
        font-size: .84rem !important; color: var(--rv-text) !important;
        padding: .65rem 1rem !important; vertical-align: middle !important;
        border-bottom: 1px solid var(--rv-border) !important;
    }
    table.dataTable tbody tr:hover { background: var(--rv-primary-soft) !important; }
    .dataTables_wrapper .dataTables_info { font-size: .8rem !important; color: var(--rv-text-muted) !important; }
    div.dt-buttons .btn {
        border-radius: var(--rv-radius-sm) !important; font-family: var(--rv-font) !important;
        font-size: .78rem !important; font-weight: 600 !important; padding: .4rem .85rem !important;
    }
    @media (max-width: 991px) { .rv-grid { grid-template-columns: 1fr; } }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminOrdenes.php";
    $adminOrdenes = new AdministradorOrdenes();

    $hoy = date('Y-m-d');
    $inicioMes = date('Y-m-01');
    $fechaInicio = $_GET['fecha_inicio'] ?? $inicioMes;
    $fechaFin = $_GET['fecha_fin'] ?? $hoy;

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaInicio)) $fechaInicio = $inicioMes;
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaFin)) $fechaFin = $hoy;
    if ($fechaInicio > $fechaFin) {
        $tmp = $fechaInicio;
        $fechaInicio = $fechaFin;
        $fechaFin = $tmp;
    }

    $ventas = $adminOrdenes->dameReporteVentasDetallado($fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59');
    if (!is_array($ventas)) $ventas = [];

    $totalVentas = 0;
    $totalUnidades = 0;
    $ordenes = [];
    $clientes = [];
    $productos = [];
    $ventasDia = [];

    foreach ($ventas as $venta) {
        if (!is_object($venta)) continue;
        $idOrden = intval($venta->id_orden ?? 0);
        $idCliente = intval($venta->id_cliente ?? 0);
        $idProducto = intval($venta->id_producto ?? 0);
        $cantidad = floatval($venta->cantidad ?? 0);
        $totalLinea = floatval($venta->total_linea ?? 0);
        $fechaDia = substr($venta->fecha_entrega ?? '', 0, 10);

        $totalVentas += $totalLinea;
        $totalUnidades += $cantidad;

        if (!isset($ordenes[$idOrden])) {
            $ordenes[$idOrden] = [
                'total' => 0,
                'pagado' => floatval($venta->total_pagado_orden ?? 0),
                'cliente' => $venta->cliente ?? ('Cliente #' . $idCliente),
                'fecha' => $venta->fecha_entrega ?? '',
                'tipo_pago' => intval($venta->tipo_pago ?? 0),
            ];
        }
        $ordenes[$idOrden]['total'] += $totalLinea;

        if (!isset($clientes[$idCliente])) $clientes[$idCliente] = ['nombre' => $venta->cliente ?? ('Cliente #' . $idCliente), 'total' => 0, 'unidades' => 0, 'ordenes' => []];
        $clientes[$idCliente]['total'] += $totalLinea;
        $clientes[$idCliente]['unidades'] += $cantidad;
        $clientes[$idCliente]['ordenes'][$idOrden] = true;

        if (!isset($productos[$idProducto])) $productos[$idProducto] = ['nombre' => $venta->producto ?? ('Producto #' . $idProducto), 'total' => 0, 'unidades' => 0];
        $productos[$idProducto]['total'] += $totalLinea;
        $productos[$idProducto]['unidades'] += $cantidad;

        if ($fechaDia !== '') {
            if (!isset($ventasDia[$fechaDia])) $ventasDia[$fechaDia] = 0;
            $ventasDia[$fechaDia] += $totalLinea;
        }
    }

    $totalPagado = 0;
    foreach ($ordenes as $orden) $totalPagado += min(floatval($orden['pagado']), floatval($orden['total']));
    $saldo = $totalVentas - $totalPagado;
    $ticketPromedio = count($ordenes) > 0 ? $totalVentas / count($ordenes) : 0;

    uasort($clientes, function($a, $b) { return $b['total'] <=> $a['total']; });
    uasort($productos, function($a, $b) { return $b['total'] <=> $a['total']; });
    ksort($ventasDia);

    $chartLabels = array_keys($ventasDia);
    $chartValues = array_map(function($v) { return round($v, 2); }, array_values($ventasDia));
    $maxCliente = count($clientes) ? max(array_column($clientes, 'total')) : 0;
    $topClientes = array_slice($clientes, 0, 5, true);
    $topProductos = array_slice($productos, 0, 5, true);
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">
                <div class="rv-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span>Reportes</span>
                    <span class="sep">/</span>
                    <span style="color:var(--rv-text);font-weight:600;">Reporte de ventas</span>
                </div>

                <form class="rv-toolbar" method="get">
                    <div class="rv-field">
                        <label for="fecha_inicio">Fecha inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo htmlspecialchars($fechaInicio, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="rv-field">
                        <label for="fecha_fin">Fecha fin</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo htmlspecialchars($fechaFin, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <button class="rv-btn" type="submit">
                        <span class="material-icons-outlined" style="font-size:1rem;">filter_alt</span>
                        Filtrar
                    </button>
                </form>

                <div class="rv-kpi-row">
                    <div class="rv-kpi" style="animation-delay:.05s;">
                        <span class="rv-kpi-label">Ventas</span>
                        <span class="rv-kpi-value" style="color:var(--rv-success);">$<?php echo number_format($totalVentas, 2); ?></span>
                    </div>
                    <div class="rv-kpi" style="animation-delay:.1s;">
                        <span class="rv-kpi-label">Pagado</span>
                        <span class="rv-kpi-value">$<?php echo number_format($totalPagado, 2); ?></span>
                    </div>
                    <div class="rv-kpi" style="animation-delay:.15s;">
                        <span class="rv-kpi-label">Saldo</span>
                        <span class="rv-kpi-value" style="color:var(--rv-warning);">$<?php echo number_format($saldo, 2); ?></span>
                    </div>
                    <div class="rv-kpi" style="animation-delay:.2s;">
                        <span class="rv-kpi-label">Ordenes</span>
                        <span class="rv-kpi-value"><?php echo count($ordenes); ?></span>
                    </div>
                    <div class="rv-kpi" style="animation-delay:.25s;">
                        <span class="rv-kpi-label">Unidades</span>
                        <span class="rv-kpi-value"><?php echo number_format($totalUnidades, 2); ?></span>
                    </div>
                    <div class="rv-kpi" style="animation-delay:.3s;">
                        <span class="rv-kpi-label">Ticket promedio</span>
                        <span class="rv-kpi-value">$<?php echo number_format($ticketPromedio, 2); ?></span>
                    </div>
                </div>

                <div class="rv-grid">
                    <div class="rv-card">
                        <div class="rv-card-header">
                            <div class="rv-card-header-left">
                                <span class="material-icons-outlined">show_chart</span>
                                Ventas por dia
                            </div>
                        </div>
                        <div class="rv-card-body">
                            <div id="ventasPorDia" style="min-height:300px;"></div>
                        </div>
                    </div>

                    <div class="rv-card">
                        <div class="rv-card-header">
                            <div class="rv-card-header-left">
                                <span class="material-icons-outlined">leaderboard</span>
                                Top clientes
                            </div>
                        </div>
                        <div class="rv-card-body">
                            <div class="rv-rank">
                                <?php foreach ($topClientes as $cliente):
                                    $pct = $maxCliente > 0 ? min(100, ($cliente['total'] / $maxCliente) * 100) : 0;
                                ?>
                                <div class="rv-rank-item">
                                    <div>
                                        <div class="rv-rank-name"><?php echo htmlspecialchars($cliente['nombre'], ENT_QUOTES, 'UTF-8'); ?></div>
                                        <div class="rv-rank-meta"><?php echo count($cliente['ordenes']); ?> ordenes &middot; <?php echo number_format($cliente['unidades'], 2); ?> unidades</div>
                                    </div>
                                    <div class="rv-money">$<?php echo number_format($cliente['total'], 2); ?></div>
                                    <div class="rv-progress"><span style="width:<?php echo round($pct, 2); ?>%;"></span></div>
                                </div>
                                <?php endforeach; ?>
                                <?php if (count($topClientes) === 0): ?>
                                <div class="rv-rank-meta">Sin ventas en el periodo seleccionado.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rv-grid">
                    <div class="rv-card">
                        <div class="rv-card-header">
                            <div class="rv-card-header-left">
                                <span class="material-icons-outlined">inventory_2</span>
                                Productos mas vendidos
                            </div>
                        </div>
                        <div class="rv-card-body">
                            <div class="table-responsive">
                                <table class="table table-sm" style="margin:0;">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th style="text-align:right;">Unidades</th>
                                            <th style="text-align:right;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($topProductos as $producto): ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                            <td style="text-align:right;"><?php echo number_format($producto['unidades'], 2); ?></td>
                                            <td style="text-align:right;" class="rv-money">$<?php echo number_format($producto['total'], 2); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php if (count($topProductos) === 0): ?>
                                        <tr><td colspan="3">Sin ventas en el periodo seleccionado.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="rv-card">
                        <div class="rv-card-header">
                            <div class="rv-card-header-left">
                                <span class="material-icons-outlined">payments</span>
                                Cobranza
                            </div>
                        </div>
                        <div class="rv-card-body">
                            <div id="cobranzaChart" style="min-height:240px;"></div>
                        </div>
                    </div>
                </div>

                <div class="rv-card">
                    <div class="rv-card-header">
                        <div class="rv-card-header-left">
                            <span class="material-icons-outlined">receipt_long</span>
                            Detalle de ventas
                        </div>
                    </div>
                    <div class="rv-card-body" style="padding:.75rem 1.25rem 1.25rem;">
                        <div class="table-responsive">
                            <table id="tablaVentas" class="table table-striped table-bordered" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Orden</th>
                                        <th>Cliente</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                        <th>Tipo pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ventas as $venta):
                                        if (!is_object($venta)) continue;
                                        $tipoPago = intval($venta->tipo_pago ?? 0);
                                        $tipoPagoTexto = $tipoPago === 2 ? 'Credito' : ($tipoPago === 1 ? 'Contado' : 'Tipo #' . $tipoPago);
                                        $tipoPagoClase = $tipoPago === 2 ? 'credit' : 'cash';
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(substr($venta->fecha_entrega ?? '', 0, 10), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><span class="rv-badge order">#<?php echo intval($venta->id_orden ?? 0); ?></span></td>
                                        <td><?php echo htmlspecialchars($venta->cliente ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><strong><?php echo htmlspecialchars($venta->producto ?? '', ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                        <td><?php echo number_format(floatval($venta->cantidad ?? 0), 2); ?></td>
                                        <td>$<?php echo number_format(floatval($venta->precio_unitario ?? 0), 2); ?></td>
                                        <td class="rv-money">$<?php echo number_format(floatval($venta->total_linea ?? 0), 2); ?></td>
                                        <td><span class="rv-badge <?php echo $tipoPagoClase; ?>"><?php echo htmlspecialchars($tipoPagoTexto, ENT_QUOTES, 'UTF-8'); ?></span></td>
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

    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/vendors/js/apexcharts.min.js"></script>
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
    var ventasLabels = <?php echo json_encode($chartLabels); ?>;
    var ventasValues = <?php echo json_encode($chartValues); ?>;
    var totalPagado = <?php echo json_encode(round($totalPagado, 2)); ?>;
    var totalSaldo = <?php echo json_encode(round(max(0, $saldo), 2)); ?>;

    document.addEventListener('DOMContentLoaded', function() {
        new ApexCharts(document.querySelector('#ventasPorDia'), {
            chart: { type: 'area', height: 300, toolbar: { show: false }, fontFamily: 'DM Sans, sans-serif' },
            series: [{ name: 'Ventas', data: ventasValues }],
            xaxis: { categories: ventasLabels, labels: { style: { colors: '#64748b' } } },
            yaxis: { labels: { formatter: function(v) { return '$' + Number(v).toLocaleString('es-MX'); } } },
            colors: ['#2563eb'],
            fill: { type: 'gradient', gradient: { opacityFrom: .28, opacityTo: .04 } },
            stroke: { curve: 'smooth', width: 3 },
            dataLabels: { enabled: false },
            tooltip: { y: { formatter: function(v) { return '$' + Number(v).toLocaleString('es-MX', { minimumFractionDigits: 2 }); } } },
            noData: { text: 'Sin datos' }
        }).render();

        new ApexCharts(document.querySelector('#cobranzaChart'), {
            chart: { type: 'donut', height: 240, fontFamily: 'DM Sans, sans-serif' },
            series: [totalPagado, totalSaldo],
            labels: ['Pagado', 'Saldo'],
            colors: ['#059669', '#d97706'],
            legend: { position: 'bottom' },
            dataLabels: {
                formatter: function(v) { return v.toFixed(1) + '%'; }
            },
            tooltip: {
                y: { formatter: function(v) { return '$' + Number(v).toLocaleString('es-MX', { minimumFractionDigits: 2 }); } }
            }
        }).render();

        var table = $('#tablaVentas').DataTable({
            lengthChange: true,
            pageLength: 25,
            buttons: ['copy', 'excel', 'pdf', 'print'],
            language: {
                search: 'Buscar:',
                lengthMenu: 'Mostrar _MENU_ registros',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ lineas',
                infoEmpty: 'Sin ventas',
                infoFiltered: '(filtrado de _MAX_ totales)',
                zeroRecords: 'No se encontraron ventas',
                paginate: { first: 'Primero', last: 'Ultimo', next: 'Sig.', previous: 'Ant.' }
            },
            order: [[0, 'desc'], [1, 'desc']]
        });

        table.buttons().container().appendTo('#tablaVentas_wrapper .col-md-6:eq(0)');
    });
    </script>
</body>
</html>
