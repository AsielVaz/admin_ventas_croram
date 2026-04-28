<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Reportes" />
    <title>Croram Admin &middot; Reportes</title>
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
        --rp-primary: #1d4ed8;
        --rp-info: #0891b2;
        --rp-success: #059669;
        --rp-warning: #d97706;
        --rp-danger: #dc2626;
        --rp-text: #1e293b;
        --rp-muted: #64748b;
        --rp-soft: #f8fafc;
        --rp-border: #e2e8f0;
        --rp-card: #ffffff;
        --rp-radius: 10px;
        --rp-shadow: 0 1px 3px rgba(15,23,42,.05), 0 12px 28px rgba(15,23,42,.06);
        --rp-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--rp-font); }
    .rp-breadcrumb { display:flex; align-items:center; gap:.65rem; margin-bottom:1rem; font-size:.84rem; color:var(--rp-muted); }
    .rp-breadcrumb a { color:var(--rp-primary); text-decoration:none; }
    .rp-page-title { display:flex; justify-content:space-between; gap:1rem; align-items:end; margin-bottom:1rem; flex-wrap:wrap; }
    .rp-page-title h4 { margin:0; font-weight:800; color:var(--rp-text); }
    .rp-page-title span { color:var(--rp-muted); font-size:.85rem; }
    .rp-toolbar { background:var(--rp-card); border:1px solid var(--rp-border); border-radius:var(--rp-radius); box-shadow:var(--rp-shadow); padding:1rem; display:flex; align-items:end; gap:.8rem; flex-wrap:wrap; margin-bottom:1rem; }
    .rp-field { display:flex; flex-direction:column; gap:.3rem; min-width:175px; }
    .rp-field label { color:var(--rp-muted); font-size:.72rem; text-transform:uppercase; font-weight:800; letter-spacing:.04em; }
    .rp-field input { height:40px; border:1px solid var(--rp-border); border-radius:8px; padding:0 .8rem; color:var(--rp-text); }
    .rp-btn { height:40px; display:inline-flex; align-items:center; gap:.4rem; border:0; border-radius:8px; padding:0 1rem; color:#fff; background:var(--rp-primary); font-weight:800; text-decoration:none; }
    .rp-btn:hover { color:#fff; background:#1e40af; }
    .rp-kpis { display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:.85rem; margin-bottom:1rem; }
    .rp-kpi { background:var(--rp-card); border:1px solid var(--rp-border); border-radius:var(--rp-radius); padding:1rem; box-shadow:var(--rp-shadow); min-height:112px; }
    .rp-kpi .icon { width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; margin-bottom:.6rem; }
    .rp-kpi .icon span { font-size:1.15rem; }
    .rp-kpi .label { color:var(--rp-muted); font-size:.72rem; text-transform:uppercase; font-weight:800; letter-spacing:.04em; }
    .rp-kpi .value { color:var(--rp-text); font-size:1.35rem; font-weight:900; line-height:1.25; overflow-wrap:anywhere; }
    .rp-tabs { display:flex; gap:.5rem; flex-wrap:wrap; margin:0 0 1rem; }
    .rp-tabs a { border:1px solid var(--rp-border); border-radius:8px; background:#fff; color:var(--rp-text); padding:.55rem .8rem; font-weight:800; font-size:.82rem; text-decoration:none; }
    .rp-tabs a:hover { border-color:var(--rp-primary); color:var(--rp-primary); }
    .rp-grid { display:grid; grid-template-columns:minmax(0, 1.15fr) minmax(320px, .85fr); gap:1rem; margin-bottom:1rem; }
    .rp-card { background:var(--rp-card); border:1px solid var(--rp-border); border-radius:var(--rp-radius); box-shadow:var(--rp-shadow); overflow:hidden; margin-bottom:1rem; }
    .rp-card-header { display:flex; align-items:center; justify-content:space-between; gap:.75rem; padding:.95rem 1.1rem; border-bottom:1px solid var(--rp-border); background:var(--rp-soft); }
    .rp-card-title { display:flex; align-items:center; gap:.45rem; color:var(--rp-text); font-size:.95rem; font-weight:900; }
    .rp-card-title .material-icons-outlined { font-size:1.15rem; color:var(--rp-primary); }
    .rp-card-body { padding:1rem; }
    .rp-money { color:var(--rp-success); font-weight:900; white-space:nowrap; }
    .rp-saldo { color:var(--rp-warning); font-weight:900; white-space:nowrap; }
    .rp-badge { display:inline-flex; align-items:center; border-radius:999px; padding:.25rem .6rem; font-size:.72rem; font-weight:800; background:#eff6ff; color:var(--rp-primary); white-space:nowrap; }
    .rp-badge.warn { background:#fffbeb; color:var(--rp-warning); }
    .rp-badge.ok { background:#ecfdf5; color:var(--rp-success); }
    .rp-empty { color:var(--rp-muted); padding:1rem; text-align:center; }
    table.dataTable thead th { background:var(--rp-soft) !important; color:var(--rp-muted) !important; font-size:.72rem !important; text-transform:uppercase !important; letter-spacing:.04em !important; border-bottom:1px solid var(--rp-border) !important; }
    table.dataTable tbody td { font-size:.83rem !important; color:var(--rp-text) !important; vertical-align:middle !important; }
    div.dt-buttons .btn { border-radius:8px !important; font-size:.78rem !important; font-weight:800 !important; }
    @media (max-width:991px) { .rp-grid { grid-template-columns:1fr; } .rp-page-title { align-items:flex-start; } }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminReportes.php";

    function rp_e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
    function rp_money($value) { return '$' . number_format(floatval($value), 2); }
    function rp_num($value) { return number_format(floatval($value), 2); }

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

    $adminReportes = new AdministradorReportes();
    $resumen = $adminReportes->dameResumen($fechaInicio, $fechaFin);
    $ventasDia = $adminReportes->dameVentasPorDia($fechaInicio, $fechaFin);
    $productos = $adminReportes->dameProductosVendidos($fechaInicio, $fechaFin);
    $clientes = $adminReportes->dameClientesVentas($fechaInicio, $fechaFin);
    $cobranza = $adminReportes->dameCobranza($fechaInicio, $fechaFin);
    $devoluciones = $adminReportes->dameDevoluciones($fechaInicio, $fechaFin);
    $estatus = $adminReportes->dameOrdenesPorEstatus($fechaInicio, $fechaFin);
    $tipoPago = $adminReportes->dameVentasPorTipoPago($fechaInicio, $fechaFin);
    $capturistas = $adminReportes->dameCapturistas($fechaInicio, $fechaFin);
    $detalleVentas = $adminReportes->dameDetalleVentas($fechaInicio, $fechaFin);
    $inventario = $adminReportes->dameInventarioProductos();

    if (!is_object($resumen)) $resumen = (object)['ordenes'=>0,'clientes'=>0,'ventas'=>0,'unidades'=>0,'pagado'=>0,'saldo'=>0];
    foreach (['ventasDia','productos','clientes','cobranza','devoluciones','estatus','tipoPago','capturistas','detalleVentas','inventario'] as $lista) {
        if (!is_array($$lista)) $$lista = [];
    }

    $totalDevoluciones = 0;
    $montoDevoluciones = 0;
    foreach ($devoluciones as $dev) {
        $totalDevoluciones += floatval($dev->cantidad ?? 0);
        $montoDevoluciones += floatval($dev->monto_estimado ?? 0);
    }

    $topProductos = array_slice($productos, 0, 10);
    $topClientes = array_slice($clientes, 0, 10);
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">
                <div class="rp-breadcrumb">
                    <a href="index.php">Inicio</a><span>/</span><span style="color:var(--rp-text);font-weight:800;">Reportes</span>
                </div>

                <div class="rp-page-title">
                    <div>
                        <h4>Reportes</h4>
                        <span>Ventas, cobranza, clientes, productos, devoluciones y operacion</span>
                    </div>
                    <span><?php echo rp_e($fechaInicio); ?> al <?php echo rp_e($fechaFin); ?></span>
                </div>

                <form class="rp-toolbar" method="get">
                    <div class="rp-field">
                        <label for="fecha_inicio">Fecha inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo rp_e($fechaInicio); ?>">
                    </div>
                    <div class="rp-field">
                        <label for="fecha_fin">Fecha fin</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo rp_e($fechaFin); ?>">
                    </div>
                    <button class="rp-btn" type="submit"><span class="material-icons-outlined" style="font-size:1rem;">filter_alt</span>Filtrar</button>
                    <a class="rp-btn" href="reporte-ventas.php?fecha_inicio=<?php echo urlencode($fechaInicio); ?>&fecha_fin=<?php echo urlencode($fechaFin); ?>" style="background:var(--rp-info);">
                        <span class="material-icons-outlined" style="font-size:1rem;">receipt_long</span>Ventas detallado
                    </a>
                    <a class="rp-btn" href="api/reporte_pdf.php?fecha_inicio=<?php echo urlencode($fechaInicio); ?>&fecha_fin=<?php echo urlencode($fechaFin); ?>" style="background:var(--rp-danger);">
                        <span class="material-icons-outlined" style="font-size:1rem;">picture_as_pdf</span>Exportar PDF
                    </a>
                </form>

                <div class="rp-tabs">
                    <a href="#ventas">Ventas</a>
                    <a href="#cobranza">Cobranza</a>
                    <a href="#clientes">Clientes</a>
                    <a href="#productos">Productos</a>
                    <a href="#devoluciones">Devoluciones</a>
                    <a href="#operacion">Operacion</a>
                    <a href="#inventario">Inventario</a>
                </div>

                <div class="rp-kpis">
                    <div class="rp-kpi"><div class="icon" style="background:#eff6ff;color:var(--rp-primary);"><span class="material-icons-outlined">payments</span></div><div class="label">Ventas</div><div class="value rp-money"><?php echo rp_money($resumen->ventas ?? 0); ?></div></div>
                    <div class="rp-kpi"><div class="icon" style="background:#ecfdf5;color:var(--rp-success);"><span class="material-icons-outlined">task_alt</span></div><div class="label">Pagado</div><div class="value"><?php echo rp_money($resumen->pagado ?? 0); ?></div></div>
                    <div class="rp-kpi"><div class="icon" style="background:#fffbeb;color:var(--rp-warning);"><span class="material-icons-outlined">pending_actions</span></div><div class="label">Saldo</div><div class="value rp-saldo"><?php echo rp_money($resumen->saldo ?? 0); ?></div></div>
                    <div class="rp-kpi"><div class="icon" style="background:#f0f9ff;color:var(--rp-info);"><span class="material-icons-outlined">shopping_cart</span></div><div class="label">Ordenes</div><div class="value"><?php echo number_format(intval($resumen->ordenes ?? 0)); ?></div></div>
                    <div class="rp-kpi"><div class="icon" style="background:#f5f3ff;color:#7c3aed;"><span class="material-icons-outlined">groups</span></div><div class="label">Clientes</div><div class="value"><?php echo number_format(intval($resumen->clientes ?? 0)); ?></div></div>
                    <div class="rp-kpi"><div class="icon" style="background:#fef2f2;color:var(--rp-danger);"><span class="material-icons-outlined">assignment_return</span></div><div class="label">Devuelto</div><div class="value"><?php echo rp_num($totalDevoluciones); ?></div></div>
                </div>

                <section id="ventas" class="rp-grid">
                    <div class="rp-card">
                        <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">show_chart</span>Ventas por dia</div></div>
                        <div class="rp-card-body"><div id="chartVentasDia" style="min-height:320px;"></div></div>
                    </div>
                    <div class="rp-card">
                        <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">donut_large</span>Ventas por tipo de pago</div></div>
                        <div class="rp-card-body"><div id="chartTipoPago" style="min-height:320px;"></div></div>
                    </div>
                </section>

                <section id="cobranza" class="rp-card">
                    <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">account_balance_wallet</span>Cobranza pendiente</div><span class="rp-badge warn"><?php echo count($cobranza); ?> ordenes</span></div>
                    <div class="rp-card-body">
                        <div class="table-responsive">
                            <table id="tablaCobranza" class="table table-bordered table-striped" style="width:100%;">
                                <thead><tr><th>Orden</th><th>Fecha</th><th>Cliente</th><th>Total</th><th>Pagado</th><th>Saldo</th><th>Tipo pago</th></tr></thead>
                                <tbody>
                                    <?php foreach ($cobranza as $row): ?>
                                    <tr>
                                        <td><span class="rp-badge">#<?php echo intval($row->id_orden ?? 0); ?></span></td>
                                        <td><?php echo rp_e(substr($row->fecha_entrega ?? '', 0, 10)); ?></td>
                                        <td><?php echo rp_e($row->cliente ?? ''); ?></td>
                                        <td class="rp-money"><?php echo rp_money($row->total ?? 0); ?></td>
                                        <td><?php echo rp_money($row->pagado ?? 0); ?></td>
                                        <td class="rp-saldo"><?php echo rp_money($row->saldo ?? 0); ?></td>
                                        <td><?php echo intval($row->tipo_pago ?? 0) === 2 ? 'Credito' : 'Contado'; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section id="clientes" class="rp-grid">
                    <div class="rp-card">
                        <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">leaderboard</span>Top clientes</div></div>
                        <div class="rp-card-body"><div id="chartClientes" style="min-height:340px;"></div></div>
                    </div>
                    <div class="rp-card">
                        <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">groups</span>Clientes por venta</div></div>
                        <div class="rp-card-body">
                            <div class="table-responsive">
                                <table id="tablaClientes" class="table table-bordered table-striped" style="width:100%;">
                                    <thead><tr><th>Cliente</th><th>Ordenes</th><th>Unidades</th><th>Total</th><th>Saldo</th></tr></thead>
                                    <tbody>
                                        <?php foreach ($clientes as $row): ?>
                                        <tr><td><?php echo rp_e($row->cliente ?? ''); ?></td><td><?php echo number_format(intval($row->ordenes ?? 0)); ?></td><td><?php echo rp_num($row->unidades ?? 0); ?></td><td class="rp-money"><?php echo rp_money($row->total ?? 0); ?></td><td class="rp-saldo"><?php echo rp_money($row->saldo ?? 0); ?></td></tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="productos" class="rp-grid">
                    <div class="rp-card">
                        <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">inventory_2</span>Productos mas vendidos</div></div>
                        <div class="rp-card-body"><div id="chartProductos" style="min-height:340px;"></div></div>
                    </div>
                    <div class="rp-card">
                        <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">table_chart</span>Venta por producto</div></div>
                        <div class="rp-card-body">
                            <div class="table-responsive">
                                <table id="tablaProductos" class="table table-bordered table-striped" style="width:100%;">
                                    <thead><tr><th>Producto</th><th>Codigo</th><th>Unidades</th><th>Precio prom.</th><th>Total</th></tr></thead>
                                    <tbody>
                                        <?php foreach ($productos as $row): ?>
                                        <tr><td><?php echo rp_e($row->producto ?? ''); ?></td><td><?php echo rp_e($row->codigo ?? ''); ?></td><td><?php echo rp_num($row->unidades ?? 0); ?></td><td><?php echo rp_money($row->precio_promedio ?? 0); ?></td><td class="rp-money"><?php echo rp_money($row->total ?? 0); ?></td></tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="devoluciones" class="rp-card">
                    <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">assignment_return</span>Devoluciones</div><span class="rp-badge warn"><?php echo rp_money($montoDevoluciones); ?> estimado</span></div>
                    <div class="rp-card-body">
                        <div class="table-responsive">
                            <table id="tablaDevolucionesReporte" class="table table-bordered table-striped" style="width:100%;">
                                <thead><tr><th>Fecha</th><th>Orden</th><th>Cliente</th><th>Producto</th><th>Cantidad</th><th>Monto est.</th><th>Motivo</th></tr></thead>
                                <tbody>
                                    <?php foreach ($devoluciones as $row): ?>
                                    <tr><td><?php echo rp_e(substr($row->fecha_ingresa ?? '', 0, 10)); ?></td><td>#<?php echo intval($row->id_orden ?? 0); ?></td><td><?php echo rp_e($row->cliente ?? ''); ?></td><td><?php echo rp_e($row->producto ?? ''); ?></td><td><?php echo rp_num($row->cantidad ?? 0); ?></td><td class="rp-saldo"><?php echo rp_money($row->monto_estimado ?? 0); ?></td><td><?php echo rp_e($row->motivo ?? ''); ?></td></tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section id="operacion" class="rp-grid">
                    <div class="rp-card">
                        <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">fact_check</span>Ordenes por estatus</div></div>
                        <div class="rp-card-body"><div id="chartEstatus" style="min-height:320px;"></div></div>
                    </div>
                    <div class="rp-card">
                        <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">person_pin</span>Rendimiento por capturista</div></div>
                        <div class="rp-card-body">
                            <div class="table-responsive">
                                <table id="tablaCapturistas" class="table table-bordered table-striped" style="width:100%;">
                                    <thead><tr><th>Capturista</th><th>Ordenes</th><th>Total</th></tr></thead>
                                    <tbody>
                                        <?php foreach ($capturistas as $row): ?>
                                        <tr><td><?php echo rp_e($row->capturista ?? ''); ?></td><td><?php echo number_format(intval($row->ordenes ?? 0)); ?></td><td class="rp-money"><?php echo rp_money($row->total ?? 0); ?></td></tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rp-card">
                    <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">receipt_long</span>Detalle exportable de ventas</div></div>
                    <div class="rp-card-body">
                        <div class="table-responsive">
                            <table id="tablaDetalleVentas" class="table table-bordered table-striped" style="width:100%;">
                                <thead><tr><th>Fecha</th><th>Orden</th><th>Cliente</th><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Total</th><th>Tipo pago</th></tr></thead>
                                <tbody>
                                    <?php foreach ($detalleVentas as $row): ?>
                                    <tr><td><?php echo rp_e(substr($row->fecha_entrega ?? '', 0, 10)); ?></td><td>#<?php echo intval($row->id_orden ?? 0); ?></td><td><?php echo rp_e($row->cliente ?? ''); ?></td><td><?php echo rp_e($row->producto ?? ''); ?></td><td><?php echo rp_num($row->cantidad ?? 0); ?></td><td><?php echo rp_money($row->precio_unitario ?? 0); ?></td><td class="rp-money"><?php echo rp_money($row->total_linea ?? 0); ?></td><td><?php echo intval($row->tipo_pago ?? 0) === 2 ? 'Credito' : 'Contado'; ?></td></tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section id="inventario" class="rp-card">
                    <div class="rp-card-header"><div class="rp-card-title"><span class="material-icons-outlined">warehouse</span>Inventario actual</div><span class="rp-badge ok"><?php echo count($inventario); ?> productos</span></div>
                    <div class="rp-card-body">
                        <div class="table-responsive">
                            <table id="tablaInventario" class="table table-bordered table-striped" style="width:100%;">
                                <thead><tr><th>Producto</th><th>Codigo</th><th>Existencia</th><th>Precio</th><th>Estatus</th></tr></thead>
                                <tbody>
                                    <?php foreach ($inventario as $row): ?>
                                    <tr><td><?php echo rp_e($row->producto ?? ''); ?></td><td><?php echo rp_e($row->codigo ?? ''); ?></td><td><?php echo rp_num($row->existencia ?? 0); ?></td><td><?php echo rp_money($row->precio ?? 0); ?></td><td><?php echo intval($row->estatus ?? 0) === 1 ? 'Activo' : 'Inactivo'; ?></td></tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
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
    var ventasDia = <?php echo json_encode($ventasDia, JSON_UNESCAPED_UNICODE); ?>;
    var tipoPago = <?php echo json_encode($tipoPago, JSON_UNESCAPED_UNICODE); ?>;
    var topProductos = <?php echo json_encode($topProductos, JSON_UNESCAPED_UNICODE); ?>;
    var topClientes = <?php echo json_encode($topClientes, JSON_UNESCAPED_UNICODE); ?>;
    var estatus = <?php echo json_encode($estatus, JSON_UNESCAPED_UNICODE); ?>;
    var fmtMXN = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });
    var palette = ['#1d4ed8','#059669','#d97706','#dc2626','#7c3aed','#0891b2','#ea580c','#16a34a','#be123c','#4338ca'];

    function noData(id) { document.querySelector('#' + id).innerHTML = '<div class="rp-empty">Sin datos en el periodo.</div>'; }
    function renderArea(id, rows) {
        if (!rows.length) return noData(id);
        new ApexCharts(document.querySelector('#' + id), {
            chart: { type:'area', height:320, toolbar:{ show:false }, fontFamily:'DM Sans, sans-serif' },
            series: [{ name:'Ventas', data: rows.map(function(r){ return Number(r.total) || 0; }) }],
            xaxis: { categories: rows.map(function(r){ return r.fecha; }) },
            colors: ['#1d4ed8'],
            fill: { type:'gradient', gradient:{ opacityFrom:.25, opacityTo:.04 } },
            stroke: { width:3, curve:'smooth' },
            dataLabels: { enabled:false },
            tooltip: { y: { formatter: function(v){ return fmtMXN.format(v); } } }
        }).render();
    }
    function renderDonut(id, rows, labelKey, valueKey) {
        if (!rows.length) return noData(id);
        var labels = rows.map(function(r){ return r[labelKey] || 'Sin dato'; });
        var data = rows.map(function(r){ return Number(r[valueKey]) || 0; });
        new ApexCharts(document.querySelector('#' + id), {
            chart: { type:'donut', height:320, fontFamily:'DM Sans, sans-serif' },
            series: data,
            labels: labels,
            colors: palette,
            legend: { position:'bottom' },
            tooltip: { y: { formatter: function(v){ return valueKey === 'total' ? fmtMXN.format(v) : Number(v).toLocaleString('es-MX'); } } }
        }).render();
    }
    function renderBar(id, rows, labelKey, valueKey, money) {
        if (!rows.length) return noData(id);
        new ApexCharts(document.querySelector('#' + id), {
            chart: { type:'bar', height:340, toolbar:{ show:false }, fontFamily:'DM Sans, sans-serif' },
            series: [{ name: money ? 'Total' : 'Ordenes', data: rows.map(function(r){ return Number(r[valueKey]) || 0; }) }],
            xaxis: { categories: rows.map(function(r){ return r[labelKey] || 'Sin dato'; }), labels:{ rotate:-30 } },
            colors: ['#0891b2'],
            plotOptions: { bar: { borderRadius:6, columnWidth:'55%' } },
            dataLabels: { enabled:false },
            tooltip: { y: { formatter: function(v){ return money ? fmtMXN.format(v) : Number(v).toLocaleString('es-MX'); } } }
        }).render();
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderArea('chartVentasDia', ventasDia);
        renderDonut('chartTipoPago', tipoPago, 'tipo_pago', 'total');
        renderBar('chartClientes', topClientes, 'cliente', 'total', true);
        renderBar('chartProductos', topProductos, 'producto', 'unidades', false);
        renderDonut('chartEstatus', estatus, 'estatus', 'ordenes');

        var lang = {
            search: 'Buscar:', lengthMenu: 'Mostrar _MENU_ registros', info: 'Mostrando _START_ a _END_ de _TOTAL_',
            infoEmpty: 'Sin registros', infoFiltered: '(filtrado de _MAX_)', zeroRecords: 'Sin resultados',
            paginate: { first:'Primero', last:'Ultimo', next:'Sig.', previous:'Ant.' }
        };
        ['tablaCobranza','tablaClientes','tablaProductos','tablaDevolucionesReporte','tablaCapturistas','tablaDetalleVentas','tablaInventario'].forEach(function(id) {
            var table = $('#' + id).DataTable({ pageLength: 10, lengthChange: true, buttons: ['copy', 'excel', 'pdf', 'print'], language: lang });
            table.buttons().container().appendTo('#' + id + '_wrapper .col-md-6:eq(0)');
        });
    });
    </script>
</body>
</html>
