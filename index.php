<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Dashboard" />
    <title>Croram Admin · Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />

    <style>
    :root {
        --ds-primary: #2563eb;
        --ds-primary-soft: rgba(37,99,235,.07);
        --ds-success: #059669;
        --ds-success-soft: rgba(5,150,105,.08);
        --ds-warning: #d97706;
        --ds-warning-soft: rgba(217,119,6,.08);
        --ds-danger: #dc2626;
        --ds-danger-soft: rgba(220,38,38,.07);
        --ds-text: #1e293b;
        --ds-text-secondary: #64748b;
        --ds-text-muted: #94a3b8;
        --ds-surface: #ffffff;
        --ds-surface-alt: #f8fafc;
        --ds-border: #e2e8f0;
        --ds-radius: 14px;
        --ds-radius-sm: 10px;
        --ds-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --ds-shadow-lg: 0 8px 32px rgba(0,0,0,.1);
        --ds-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--ds-font); }

    .ds-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--ds-text-secondary);
    }
    .ds-breadcrumb a { color: var(--ds-primary); text-decoration: none; }
    .ds-breadcrumb .sep { opacity: .4; }

    .ds-kpi-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(185px, 1fr));
        gap: 1rem; margin-bottom: 1.5rem;
    }
    .ds-kpi {
        background: var(--ds-surface);
        border: 1px solid var(--ds-border);
        border-radius: var(--ds-radius);
        padding: 1.15rem 1.35rem;
        box-shadow: var(--ds-shadow);
        display: flex; flex-direction: column; gap: .2rem;
        transition: box-shadow .2s, transform .2s;
        animation: fadeIn .35s ease both;
    }
    .ds-kpi:hover { box-shadow: var(--ds-shadow-lg); transform: translateY(-2px); }
    .ds-kpi-icon {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; margin-bottom: .25rem;
    }
    .ds-kpi-icon.blue  { background: var(--ds-primary-soft); color: var(--ds-primary); }
    .ds-kpi-icon.green { background: var(--ds-success-soft); color: var(--ds-success); }
    .ds-kpi-icon.amber { background: var(--ds-warning-soft); color: var(--ds-warning); }
    .ds-kpi-icon.red   { background: var(--ds-danger-soft);  color: var(--ds-danger); }
    .ds-kpi-label {
        font-size: .7rem; text-transform: uppercase;
        letter-spacing: .06em; color: var(--ds-text-muted); font-weight: 600;
    }
    .ds-kpi-value { font-size: 1.5rem; font-weight: 700; color: var(--ds-text); line-height: 1.2; }
    .ds-kpi-sub { font-size: .76rem; color: var(--ds-text-muted); }

    .ds-chart-card {
        background: var(--ds-surface);
        border: 1px solid var(--ds-border);
        border-radius: var(--ds-radius);
        box-shadow: var(--ds-shadow);
        overflow: hidden;
        transition: box-shadow .2s, transform .2s;
        animation: fadeIn .35s ease both;
    }
    .ds-chart-card:hover { box-shadow: var(--ds-shadow-lg); transform: translateY(-2px); }
    .ds-chart-header {
        padding: 1rem 1.5rem .5rem;
        display: flex; align-items: center; justify-content: space-between;
    }
    .ds-chart-header h6 { margin: 0; font-size: .9rem; font-weight: 700; color: var(--ds-text); }
    .ds-chart-badge {
        font-size: .7rem; font-weight: 600;
        padding: .25rem .65rem; border-radius: 999px;
        background: var(--ds-primary-soft); color: var(--ds-primary);
    }
    .ds-chart-body { padding: .5rem 1rem 1rem; }
    .ds-chart-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;
    }
    @media (max-width: 991px) { .ds-chart-grid { grid-template-columns: 1fr; } }

    .ds-chart-empty {
        display: flex; align-items: center; justify-content: center;
        min-height: 300px; color: var(--ds-text-muted); font-size: .9rem;
    }

    .ds-page-title {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: .75rem; margin-bottom: 1.5rem;
    }
    .ds-page-title h4 { font-size: 1.35rem; font-weight: 700; color: var(--ds-text); margin: 0; }
    .ds-page-title .subtitle { font-size: .85rem; color: var(--ds-text-secondary); }

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
    include "api/adminOrdenes.php";

    $adminOrdenes = new AdministradorOrdenes();

    $fecha_inicio = date('Y-m-d', strtotime('-60 days'));
    $fecha_fin    = date('Y-m-t');

    $estadisticas          = $adminOrdenes->dameEstadisticasOrdenes($fecha_inicio, $fecha_fin);
    $estadisticasAnio      = $adminOrdenes->dameEstadisticasAnio();
    $estadisticasClientes  = $adminOrdenes->dameEstadisticasVentasUsuarios($fecha_inicio, $fecha_fin);
    $estadisticasAvanzadas = $adminOrdenes->dameEstadisticasAvanzadasClientes($fecha_inicio, $fecha_fin);

    if (!is_array($estadisticas))          $estadisticas = [];
    if (!is_array($estadisticasAnio))      $estadisticasAnio = [];
    if (!is_array($estadisticasClientes))  $estadisticasClientes = [];
    if (!is_array($estadisticasAvanzadas)) $estadisticasAvanzadas = [];

    // KPIs
    $totalVentasMes = 0;
    $totalProductos = 0;
    $totalClientes  = count($estadisticasClientes);
    $saldoPendiente = 0;

    $mesActual  = intval(date('n'));
    $anioActual = intval(date('Y'));
    foreach ($estadisticasAnio as $m) {
        $m = (object)$m;
        if (intval($m->mes ?? 0) === $mesActual && intval($m->anio ?? 0) === $anioActual) {
            $totalVentasMes = floatval($m->total_ganado ?? 0);
        }
    }
    foreach ($estadisticas as $p) {
        $p = (object)$p;
        $totalProductos += intval($p->cantidad_total ?? 0);
    }
    foreach ($estadisticasAvanzadas as $c) {
        $c = (object)$c;
        $saldoPendiente += floatval($c->saldo ?? 0);
    }
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="ds-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span style="color:var(--ds-text);font-weight:600;">Dashboard</span>
                </div>

                <div class="ds-page-title">
                    <div>
                        <h4>Dashboard</h4>
                        <span class="subtitle">Estadísticas de los últimos 60 días · <?php echo date('d M Y'); ?></span>
                    </div>
                </div>

                <!-- KPIs -->
                <div class="ds-kpi-row">
                    <div class="ds-kpi" style="animation-delay:.05s;">
                        <div class="ds-kpi-icon blue"><span class="material-icons-outlined">payments</span></div>
                        <span class="ds-kpi-label">Ventas del mes</span>
                        <span class="ds-kpi-value">$<?php echo number_format($totalVentasMes, 0, '.', ','); ?></span>
                        <span class="ds-kpi-sub">MXN · mes actual</span>
                    </div>
                    <div class="ds-kpi" style="animation-delay:.1s;">
                        <div class="ds-kpi-icon green"><span class="material-icons-outlined">inventory_2</span></div>
                        <span class="ds-kpi-label">Productos vendidos</span>
                        <span class="ds-kpi-value"><?php echo number_format($totalProductos, 0, '.', ','); ?></span>
                        <span class="ds-kpi-sub">últimos 60 días</span>
                    </div>
                    <div class="ds-kpi" style="animation-delay:.15s;">
                        <div class="ds-kpi-icon amber"><span class="material-icons-outlined">groups</span></div>
                        <span class="ds-kpi-label">Clientes activos</span>
                        <span class="ds-kpi-value"><?php echo $totalClientes; ?></span>
                        <span class="ds-kpi-sub">con compras en período</span>
                    </div>
                    <div class="ds-kpi" style="animation-delay:.2s;">
                        <div class="ds-kpi-icon red"><span class="material-icons-outlined">warning</span></div>
                        <span class="ds-kpi-label">Saldo pendiente</span>
                        <span class="ds-kpi-value">$<?php echo number_format($saldoPendiente, 0, '.', ','); ?></span>
                        <span class="ds-kpi-sub">por cobrar</span>
                    </div>
                </div>

                <!-- Charts -->
                <div class="ds-chart-grid">
                    <div class="ds-chart-card" style="animation-delay:.1s;">
                        <div class="ds-chart-header">
                            <h6>Ventas mensuales</h6>
                            <span class="ds-chart-badge">Anual</span>
                        </div>
                        <div class="ds-chart-body"><div id="chartAnio" style="min-height:360px;"></div></div>
                    </div>
                    <div class="ds-chart-card" style="animation-delay:.15s;">
                        <div class="ds-chart-header">
                            <h6>Productos más vendidos</h6>
                            <span class="ds-chart-badge">60 días</span>
                        </div>
                        <div class="ds-chart-body"><div id="productosChart" style="min-height:360px;"></div></div>
                    </div>
                    <div class="ds-chart-card" style="animation-delay:.2s;">
                        <div class="ds-chart-header">
                            <h6>Ventas por cliente</h6>
                            <span class="ds-chart-badge">60 días</span>
                        </div>
                        <div class="ds-chart-body"><div id="ventasClientes" style="min-height:360px;"></div></div>
                    </div>
                    <div class="ds-chart-card" style="animation-delay:.25s;">
                        <div class="ds-chart-header">
                            <h6>Saldo pendiente vs pagado</h6>
                            <span class="ds-chart-badge">Por cliente</span>
                        </div>
                        <div class="ds-chart-body"><div id="estadisticasAvanzadas" style="min-height:360px;"></div></div>
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- BLOCK 1: Pure chart functions — no PHP -->
    <script>
    var fmtMXN  = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', maximumFractionDigits: 0 });
    var fmtMXN2 = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', maximumFractionDigits: 2 });
    var palette = ['#2563eb','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#06b6d4','#84cc16','#f97316','#6366f1','#14b8a6','#e11d48','#a855f7','#0ea5e9','#22c55e'];

    function renderVentasMensuales(id, raw) {
        if (!Array.isArray(raw) || !raw.length) { document.getElementById(id).innerHTML = '<div class="ds-chart-empty">Sin datos.</div>'; return; }
        raw.sort(function(a,b) { return (a.anio - b.anio) || (a.mes - b.mes); });
        var ms = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        new ApexCharts(document.querySelector('#' + id), {
            series: [{ name: 'Ventas', data: raw.map(function(d) { return Number(d.total_ganado) || 0; }) }],
            chart: { type: 'bar', height: 350, fontFamily: 'inherit', toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 8, columnWidth: '55%' } },
            colors: ['#2563eb'],
            fill: { type: 'gradient', gradient: { shade: 'light', type: 'vertical', shadeIntensity: .2, opacityFrom: 1, opacityTo: .85 } },
            dataLabels: { enabled: true, formatter: function(v) { return fmtMXN.format(v); }, offsetY: -22, style: { fontSize: '11px', fontWeight: 600, colors: ['#475569'] } },
            xaxis: { categories: raw.map(function(d) { return ms[Number(d.mes)-1] + ' ' + d.anio; }), labels: { style: { fontSize: '11px', colors: '#64748b' } }, axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { labels: { formatter: function(v) { return fmtMXN.format(v); }, style: { colors: '#94a3b8', fontSize: '11px' } } },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            tooltip: { y: { formatter: function(v) { return fmtMXN2.format(v); } } }
        }).render();
    }

    function renderProductosDonut(id, raw) {
        if (!Array.isArray(raw) || !raw.length) { document.getElementById(id).innerHTML = '<div class="ds-chart-empty">Sin datos.</div>'; return; }
        var lbl = raw.map(function(d) { return d.nombre_producto || 'Prod ' + d.id_producto; });
        var ser = raw.map(function(d) { return Number(d.cantidad_total) || 0; });
        new ApexCharts(document.querySelector('#' + id), {
            series: ser, labels: lbl,
            chart: { type: 'donut', height: 350, fontFamily: 'inherit' },
            colors: palette.slice(0, ser.length),
            stroke: { width: 3, colors: ['#fff'] },
            plotOptions: { pie: { donut: { size: '58%', labels: { show: true, name: { fontSize: '13px', fontWeight: 600 }, value: { fontSize: '22px', fontWeight: 700, formatter: function(v) { return Number(v).toLocaleString('es-MX'); } }, total: { show: true, label: 'Total', formatter: function(w) { return w.globals.seriesTotals.reduce(function(a,b){return a+b;},0).toLocaleString('es-MX'); } } } } } },
            dataLabels: { enabled: true, formatter: function(val, opts) { return lbl[opts.seriesIndex] + ': ' + val.toFixed(1) + '%'; }, style: { fontSize: '11px', fontWeight: 500 }, dropShadow: { enabled: false } },
            legend: { position: 'bottom', fontSize: '12px' },
            tooltip: { y: { formatter: function(v, o) { return 'Cantidad: ' + ser[o.seriesIndex]; } } }
        }).render();
    }

    function renderVentasClientes(id, raw) {
        if (!Array.isArray(raw) || !raw.length) { document.getElementById(id).innerHTML = '<div class="ds-chart-empty">Sin datos.</div>'; return; }
        var lbl = raw.map(function(r) { return r.cliente || 'Cliente #' + (r.id_cliente || ''); });
        var ser = raw.map(function(r) { var n = parseFloat(String(r.monto_acumulado || '0').replace(/,/g, '')); return Number.isFinite(n) ? n : 0; });
        if (ser.every(function(v) { return v === 0; })) { document.getElementById(id).innerHTML = '<div class="ds-chart-empty">Montos en cero.</div>'; return; }
        new ApexCharts(document.querySelector('#' + id), {
            series: ser, labels: lbl,
            chart: { type: 'pie', height: 350, fontFamily: 'inherit' },
            colors: palette.slice(0, ser.length),
            stroke: { width: 2, colors: ['#fff'] },
            dataLabels: { enabled: true, formatter: function(val, opts) { return lbl[opts.seriesIndex] + '\n' + val.toFixed(1) + '% · ' + fmtMXN.format(ser[opts.seriesIndex]); }, style: { fontSize: '11px', fontWeight: 500 }, dropShadow: { enabled: false } },
            legend: { position: 'bottom', fontSize: '12px' },
            tooltip: { y: { formatter: function(v) { return fmtMXN2.format(v); } } }
        }).render();
    }

    function renderSaldoPagado(id, raw) {
        if (!Array.isArray(raw) || !raw.length) { document.getElementById(id).innerHTML = '<div class="ds-chart-empty">Sin datos.</div>'; return; }
        new ApexCharts(document.querySelector('#' + id), {
            series: [
                { name: 'Pagado', data: raw.map(function(r) { return parseFloat(r.total_pagado) || 0; }) },
                { name: 'Saldo pendiente', data: raw.map(function(r) { return parseFloat(r.saldo) || 0; }) }
            ],
            chart: { type: 'bar', stacked: true, height: 380, fontFamily: 'inherit', toolbar: { show: false } },
            colors: ['#10b981', '#ef4444'],
            plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
            dataLabels: { enabled: true, formatter: function(v) { return v > 0 ? fmtMXN.format(v) : ''; }, style: { fontSize: '11px', fontWeight: 600, colors: ['#fff'] } },
            xaxis: { categories: raw.map(function(r) { return r.cliente || ''; }), labels: { rotate: -25, style: { fontSize: '11px', colors: '#64748b' } } },
            yaxis: { labels: { formatter: function(v) { return fmtMXN.format(v); }, style: { colors: '#94a3b8', fontSize: '11px' } } },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            legend: { position: 'top', horizontalAlign: 'center', fontSize: '12px' },
            tooltip: { y: { formatter: function(v) { return fmtMXN2.format(v); } } },
            fill: { opacity: 1 }
        }).render();
    }
    </script>

    <!-- BLOCK 2: Data from PHP -->
    <script>
    try {
        renderVentasMensuales('chartAnio', <?php echo json_encode($estadisticasAnio, JSON_UNESCAPED_UNICODE); ?>);
        renderProductosDonut('productosChart', <?php echo json_encode($estadisticas, JSON_UNESCAPED_UNICODE); ?>);
        renderVentasClientes('ventasClientes', <?php echo json_encode($estadisticasClientes, JSON_UNESCAPED_UNICODE); ?>);
        renderSaldoPagado('estadisticasAvanzadas', <?php echo json_encode($estadisticasAvanzadas, JSON_UNESCAPED_UNICODE); ?>);
    } catch (err) {
        console.error('[Croram Dashboard] Error:', err);
    }
    </script>

</body>
</html>