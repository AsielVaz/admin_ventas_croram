<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Moderación de Órdenes" />
    <title>Croram Admin · Moderación</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/daterangepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />

    <style>
    :root {
        --mod-primary: #2563eb;
        --mod-primary-soft: rgba(37,99,235,.07);
        --mod-success: #059669;
        --mod-success-soft: rgba(5,150,105,.08);
        --mod-danger: #dc2626;
        --mod-danger-soft: rgba(220,38,38,.07);
        --mod-warning: #d97706;
        --mod-warning-soft: rgba(217,119,6,.08);
        --mod-text: #1e293b;
        --mod-text-secondary: #64748b;
        --mod-text-muted: #94a3b8;
        --mod-surface: #ffffff;
        --mod-surface-alt: #f8fafc;
        --mod-border: #e2e8f0;
        --mod-radius: 14px;
        --mod-radius-sm: 10px;
        --mod-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --mod-shadow-lg: 0 8px 32px rgba(0,0,0,.1);
        --mod-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--mod-font); }

    .mod-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--mod-text-secondary);
    }
    .mod-breadcrumb a { color: var(--mod-primary); text-decoration: none; }
    .mod-breadcrumb .sep { opacity: .4; }

    .mod-card {
        background: var(--mod-surface);
        border: 1px solid var(--mod-border);
        border-radius: var(--mod-radius);
        box-shadow: var(--mod-shadow);
        margin-bottom: 1.25rem;
        overflow: hidden;
    }
    .mod-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--mod-border);
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--mod-text);
        background: var(--mod-surface-alt);
    }
    .mod-card-header .material-icons-outlined { font-size: 1.2rem; color: var(--mod-primary); }
    .mod-card-body { padding: 1.25rem 1.5rem; }

    .mod-status {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .35rem .85rem; border-radius: 999px;
        font-size: .75rem; font-weight: 600;
    }
    .mod-status.pending  { background: var(--mod-warning-soft); color: var(--mod-warning); }
    .mod-status.approved { background: var(--mod-success-soft); color: var(--mod-success); }
    .mod-status.rejected { background: var(--mod-danger-soft);  color: var(--mod-danger); }

    .mod-kpi-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .mod-kpi {
        background: var(--mod-surface);
        border: 1px solid var(--mod-border);
        border-radius: var(--mod-radius-sm);
        padding: 1rem 1.15rem;
        display: flex; flex-direction: column; gap: .15rem;
        transition: border-color .2s;
    }
    .mod-kpi-label {
        font-size: .7rem; text-transform: uppercase;
        letter-spacing: .06em; color: var(--mod-text-muted); font-weight: 600;
    }
    .mod-kpi-value {
        font-size: 1.15rem; font-weight: 700; color: var(--mod-text); line-height: 1.2;
    }

    /* ── Product table ── */
    .mod-table {
        width: 100%; border-collapse: separate; border-spacing: 0; font-size: .85rem;
    }
    .mod-table thead th {
        background: var(--mod-surface-alt); padding: .65rem 1rem;
        font-weight: 600; color: var(--mod-text-secondary);
        font-size: .73rem; text-transform: uppercase;
        letter-spacing: .04em; border-bottom: 1px solid var(--mod-border);
    }
    .mod-table thead th:first-child { border-radius: 8px 0 0 0; }
    .mod-table thead th:last-child  { border-radius: 0 8px 0 0; }
    .mod-table tbody td {
        padding: .55rem 1rem; border-bottom: 1px solid var(--mod-border);
        color: var(--mod-text); vertical-align: middle;
    }
    .mod-table tbody tr:last-child td { border-bottom: none; }
    .mod-table .row-total td {
        font-weight: 700; font-size: .95rem;
        background: var(--mod-primary-soft); color: var(--mod-primary);
    }

    /* ── Quantity controls ── */
    .mod-qty-group {
        display: inline-flex; align-items: center; gap: 0;
    }
    .mod-qty-btn {
        width: 28px; height: 28px;
        border: 1px solid var(--mod-border);
        background: var(--mod-surface-alt);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--mod-text-secondary);
        font-size: 1rem; transition: all .15s;
        user-select: none; flex-shrink: 0;
    }
    .mod-qty-btn:hover { background: var(--mod-primary-soft); color: var(--mod-primary); }
    .mod-qty-btn.minus { border-radius: 7px 0 0 7px; }
    .mod-qty-btn.plus  { border-radius: 0 7px 7px 0; }
    .mod-qty-input {
        width: 44px; height: 28px; text-align: center;
        border: 1px solid var(--mod-border);
        border-left: 0; border-right: 0;
        font-size: .82rem; font-weight: 600;
        font-family: var(--mod-font); color: var(--mod-text);
        background: var(--mod-surface);
    }
    .mod-qty-input:focus { outline: none; background: var(--mod-primary-soft); }
    .mod-qty-input::-webkit-inner-spin-button,
    .mod-qty-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    .mod-qty-input { -moz-appearance: textfield; }

    /* ── Delete button ── */
    .mod-delete-btn {
        width: 30px; height: 30px;
        border: 1px solid var(--mod-border);
        border-radius: 8px; background: var(--mod-surface);
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--mod-text-muted);
        transition: all .15s; flex-shrink: 0;
    }
    .mod-delete-btn:hover {
        background: var(--mod-danger-soft);
        border-color: var(--mod-danger);
        color: var(--mod-danger);
    }
    .mod-delete-btn .material-icons-outlined { font-size: .95rem; pointer-events: none; }

    /* Row removing animation */
    @keyframes rowRemove {
        to { opacity: 0; transform: translateX(14px); max-height: 0; padding: 0; }
    }
    .row-removing {
        animation: rowRemove .25s ease forwards;
        overflow: hidden;
    }

    /* ── Vehicle info ── */
    .mod-vehicle-row {
        display: flex; align-items: center; gap: 1rem;
        padding: .75rem 1rem; background: var(--mod-surface-alt);
        border-radius: var(--mod-radius-sm); flex-wrap: wrap;
    }
    .mod-vehicle-tag {
        display: inline-flex; align-items: center; gap: .3rem;
        font-size: .82rem; color: var(--mod-text-secondary);
    }
    .mod-vehicle-tag strong { color: var(--mod-text); font-weight: 600; }

    /* ── Timeline ── */
    .mod-timeline-wrap { padding: .5rem 0; }
    .mod-timeline {
        position: relative; width: 100%; height: 56px;
        background: var(--mod-surface-alt);
        border: 1px solid var(--mod-border);
        border-radius: var(--mod-radius-sm);
        overflow: hidden; cursor: default;
    }
    .mod-timeline-hours {
        position: absolute; top: -22px; left: 0; width: 100%;
        display: flex; justify-content: space-between;
        font-size: .68rem; color: var(--mod-text-muted); font-weight: 500;
        padding: 0 2px;
    }
    .mod-time-block {
        position: absolute; top: 3px; height: calc(100% - 6px);
        background: linear-gradient(135deg, var(--mod-primary) 0%, #3b82f6 100%);
        border-radius: 8px; cursor: grab;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: .72rem; font-weight: 600;
        box-shadow: 0 2px 8px rgba(37,99,235,.3);
        transition: box-shadow .15s;
        user-select: none; z-index: 5;
    }
    .mod-time-block:active { cursor: grabbing; box-shadow: 0 4px 16px rgba(37,99,235,.4); }
    .mod-occupied {
        position: absolute; top: 3px; height: calc(100% - 6px);
        background: repeating-linear-gradient(
            45deg, transparent, transparent 4px,
            rgba(148,163,184,.15) 4px, rgba(148,163,184,.15) 8px
        );
        border: 1px dashed var(--mod-border);
        border-radius: 6px; pointer-events: none; z-index: 2;
    }

    /* ── Buttons ── */
    .mod-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .65rem 1.35rem; border-radius: var(--mod-radius-sm);
        font-size: .85rem; font-weight: 600; font-family: var(--mod-font);
        cursor: pointer; border: none; transition: all .2s;
        text-decoration: none;
    }
    .mod-btn .material-icons-outlined { font-size: 1.1rem; }
    .mod-btn-success { background: var(--mod-success); color: #fff; }
    .mod-btn-success:hover { background: #047857; color: #fff; }
    .mod-btn-danger  { background: var(--mod-danger); color: #fff; }
    .mod-btn-danger:hover  { background: #b91c1c; color: #fff; }
    .mod-btn-outline {
        background: transparent; color: var(--mod-text-secondary);
        border: 1px solid var(--mod-border);
    }
    .mod-btn-outline:hover { border-color: var(--mod-primary); color: var(--mod-primary); }
    .mod-btn-primary { background: var(--mod-primary); color: #fff; }
    .mod-btn-primary:hover { background: #1d4ed8; color: #fff; }

    /* ── Form fields ── */
    .mod-field label {
        font-size: .78rem; font-weight: 600; color: var(--mod-text-secondary);
        text-transform: uppercase; letter-spacing: .03em;
        margin-bottom: .35rem; display: flex; align-items: center; gap: .3rem;
    }
    .mod-field label .material-icons-outlined { font-size: .9rem; }
    .mod-field select,
    .mod-field input {
        border-radius: var(--mod-radius-sm); border: 1px solid var(--mod-border);
        font-family: var(--mod-font); font-size: .875rem; padding: .55rem .85rem;
        width: 100%;
    }
    .mod-field select:focus,
    .mod-field input:focus {
        border-color: var(--mod-primary); outline: none;
        box-shadow: 0 0 0 3px var(--mod-primary-soft);
    }

    /* ── Layout ── */
    .mod-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1.25rem; align-items: start;
    }
    @media (max-width: 1024px) {
        .mod-grid { grid-template-columns: 1fr; }
    }

    .mod-proof-img {
        max-width: 100%; border-radius: var(--mod-radius-sm);
        border: 1px solid var(--mod-border);
    }
    .mod-no-bascula {
        display: flex; align-items: center; gap: .5rem;
        padding: .75rem 1rem; background: var(--mod-surface-alt);
        border-radius: var(--mod-radius-sm); font-size: .85rem;
        color: var(--mod-text-secondary);
    }
    .mod-no-bascula .material-icons-outlined { font-size: 1.1rem; color: var(--mod-warning); }

    .mod-modal .modal-content {
        border: none; border-radius: var(--mod-radius); box-shadow: var(--mod-shadow-lg);
    }
    .mod-modal .modal-header { border-bottom: 1px solid var(--mod-border); padding: 1rem 1.5rem; }
    .mod-modal .modal-body   { padding: 1.5rem; }

    /* ── Saving spinner ── */
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .mod-saving-icon { animation: spin .7s linear infinite; font-size: .95rem; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .mod-card { animation: fadeIn .35s ease both; }

    /* ── Empty-list state ── */
    .mod-empty-items {
        text-align: center; padding: 2rem 1rem;
        color: var(--mod-text-muted); font-size: .88rem;
    }
    .mod-empty-items .material-icons-outlined {
        font-size: 2.5rem; display: block; margin-bottom: .5rem; opacity: .35;
    }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminOrdenes.php";
    include_once "api/adminUsuarios.php";
    include_once "api/adminAutos.php";

    $adminOrdenes  = new AdministradorOrdenes();
    $adminUsuarios = new AdministradorUsuarios();
    $adminAutos    = new AdministradorAutos();

    if (isset($_GET['id'])) {
        $ordenes = $adminOrdenes->obtenerOrden($_GET['id']);
    } else {
        $ordenes = $adminOrdenes->damePrimeraOrdenSinAprovar();
    }

    $sinOrdenes = !is_object($ordenes) || empty($ordenes->id);

    if (!$sinOrdenes) {
        $fechaSelect = isset($_GET['fecha']) ? $_GET['fecha'] : date("Y-m-d");
        $directo     = isset($_GET['directo']) ? 1 : 0;

        $ordenesP = $adminOrdenes->dameOrdenesPorDia($fechaSelect);
        $periodos = array();
        if (is_array($ordenesP)) {
            foreach ($ordenesP as $ordenp) {
                if (is_object($ordenp) && isset($ordenp->fecha_entrega, $ordenp->tiempo_entrega)) {
                    $periodos[] = array(
                        "start" => date("H:i", strtotime($ordenp->fecha_entrega)),
                        "end"   => date("H:i", strtotime($ordenp->fecha_entrega) + intval($ordenp->tiempo_entrega))
                    );
                }
            }
        }
        $periodos[] = array("start" => "09:00", "end" => "09:30");

        $usuario = $adminUsuarios->dameUsuario($ordenes->id_cliente);

        $auto = null;
        if (!empty($ordenes->id_veiculo)) {
            $auto = $adminAutos->obtenerAuto($ordenes->id_veiculo);
        }

        $productos = $adminOrdenes->dameProductosOrdenCompuestos($ordenes->id);
        if (!is_array($productos)) $productos = [];

        $tiempoEntregaMinutos = intval(intval($ordenes->tiempo_entrega ?? 0) / 60) + 1;

        $comprobanteLimpio = '';
        if (!empty($ordenes->comprobante)) {
            $comprobanteLimpio = str_replace(
                "/home3/grupo465/public_html/clientes/dist",
                "https://clientes.grupocroram.com",
                $ordenes->comprobante
            );
        }

        $totalOrden = 0;
        $pesoTotal  = 0;
        foreach ($productos as $p) {
            if (is_object($p)) {
                $totalOrden += floatval($p->cantidad ?? 0) * floatval($p->precio_unitario ?? 0);
                $pesoTotal  += floatval($p->cantidad ?? 0) * floatval($p->weight ?? 0);
            }
        }
    }
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="mod-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span>Moderación de Órdenes</span>
                    <?php if (!$sinOrdenes): ?>
                    <span class="sep">/</span>
                    <span style="color:var(--mod-text);font-weight:600;">Orden #<?php echo intval($ordenes->id); ?></span>
                    <?php endif; ?>
                </div>

                <?php if ($sinOrdenes): ?>
                <div class="mod-card" style="text-align:center;padding:3rem;">
                    <div class="mod-card-body">
                        <span class="material-icons-outlined" style="font-size:3.5rem;color:var(--mod-success);display:block;margin-bottom:1rem;">check_circle</span>
                        <h5 style="font-weight:700;color:var(--mod-text);margin-bottom:.5rem;">No hay órdenes pendientes</h5>
                        <p style="color:var(--mod-text-secondary);margin-bottom:1.5rem;">Todas las órdenes han sido procesadas.</p>
                        <a href="orden-form.php" class="mod-btn mod-btn-primary">
                            <span class="material-icons-outlined">add_circle</span>
                            Crear nueva orden
                        </a>
                    </div>
                </div>

                <?php else: ?>

                <!-- KPIs -->
                <div class="mod-kpi-row">
                    <div class="mod-kpi">
                        <span class="mod-kpi-label">Orden</span>
                        <span class="mod-kpi-value">#<?php echo intval($ordenes->id); ?></span>
                    </div>
                    <div class="mod-kpi">
                        <span class="mod-kpi-label">Cliente</span>
                        <span class="mod-kpi-value" style="font-size:1rem;"><?php echo htmlspecialchars($usuario->nombre ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                    <div class="mod-kpi">
                        <span class="mod-kpi-label">Total</span>
                        <span class="mod-kpi-value" style="color:var(--mod-primary);" id="kpiTotal">$<?php echo number_format($totalOrden, 2); ?></span>
                    </div>
                    <div class="mod-kpi">
                        <span class="mod-kpi-label">Peso total</span>
                        <span class="mod-kpi-value" id="kpiPeso"><?php echo number_format($pesoTotal, 1); ?> kg</span>
                    </div>
                    <div class="mod-kpi">
                        <span class="mod-kpi-label">Tiempo carga</span>
                        <span class="mod-kpi-value"><?php echo $tiempoEntregaMinutos; ?> min</span>
                    </div>
                    <div class="mod-kpi">
                        <span class="mod-kpi-label">Pago</span>
                        <span class="mod-kpi-value" style="font-size:.9rem;">
                            <?php echo (intval($ordenes->tipo_pago ?? 0) == 1) ? 'Efectivo / Depósito' : 'Crédito'; ?>
                        </span>
                    </div>
                </div>

                <!-- Main grid -->
                <div class="mod-grid">

                    <!-- ── Left column ── -->
                    <div>

                        <!-- Vehicle -->
                        <?php if (is_object($auto) && !empty($auto->marca)): ?>
                        <div class="mod-card" style="animation-delay:.05s;">
                            <div class="mod-card-header">
                                <span class="material-icons-outlined">local_shipping</span>
                                Vehículo de recolección
                            </div>
                            <div class="mod-card-body">
                                <div class="mod-vehicle-row">
                                    <span class="mod-vehicle-tag">
                                        <span class="material-icons-outlined" style="font-size:.9rem;">directions_car</span>
                                        <strong><?php echo htmlspecialchars(($auto->marca ?? '') . ' ' . ($auto->modelo ?? '')); ?></strong>
                                    </span>
                                    <span class="mod-vehicle-tag">
                                        <span class="material-icons-outlined" style="font-size:.9rem;">palette</span>
                                        <?php echo htmlspecialchars($auto->color ?? 'N/A'); ?>
                                    </span>
                                    <span class="mod-vehicle-tag">
                                        <span class="material-icons-outlined" style="font-size:.9rem;">badge</span>
                                        <strong><?php echo htmlspecialchars($auto->placas ?? 'N/A'); ?></strong>
                                    </span>
                                    <?php if (!empty($ordenes->recolector)): ?>
                                    <span class="mod-vehicle-tag">
                                        <span class="material-icons-outlined" style="font-size:.9rem;">person</span>
                                        <?php echo htmlspecialchars($ordenes->recolector); ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Products table -->
                        <div class="mod-card" style="animation-delay:.1s;">
                            <div class="mod-card-header">
                                <span class="material-icons-outlined">inventory_2</span>
                                Productos de la orden
                                <span style="margin-left:auto;font-size:.78rem;color:var(--mod-text-muted);font-weight:400;" id="itemCountLabel">
                                    <?php echo count($productos); ?> artículo<?php echo count($productos) !== 1 ? 's' : ''; ?>
                                </span>
                            </div>
                            <div class="mod-card-body" style="padding:0;">
                                <table class="mod-table" id="productsTable">
                                    <thead>
                                        <tr>
                                            <th style="width:35%;">Producto</th>
                                            <th style="width:22%;text-align:center;">Cantidad</th>
                                            <th style="width:18%;text-align:right;">Peso</th>
                                            <th style="width:18%;text-align:right;">Subtotal</th>
                                            <th style="width:7%;text-align:center;">—</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productsBody">
                                        <?php foreach ($productos as $producto):
                                            if (!is_object($producto)) continue;
                                            $cant    = floatval($producto->cantidad ?? 0);
                                            $precioU = floatval($producto->precio_unitario ?? 0);
                                            $peso    = $cant * floatval($producto->weight ?? 0);
                                            $sub     = $cant * $precioU;
                                        ?>
                                        <tr id="row-<?php echo intval($producto->id); ?>"
                                            data-id="<?php echo intval($producto->id); ?>"
                                            data-precio="<?php echo $precioU; ?>"
                                            data-peso-unit="<?php echo floatval($producto->weight ?? 0); ?>">
                                            <td><?php echo htmlspecialchars($producto->name ?? ''); ?></td>
                                            <td style="text-align:center;">
                                                <div class="mod-qty-group">
                                                    <div class="mod-qty-btn minus" onclick="changeItemQty(<?php echo intval($producto->id); ?>, -1)">−</div>
                                                    <input  type="number"
                                                            class="mod-qty-input"
                                                            id="qty-<?php echo intval($producto->id); ?>"
                                                            value="<?php echo intval($cant); ?>"
                                                            min="1"
                                                            onchange="onQtyInput(<?php echo intval($producto->id); ?>)" />
                                                    <div class="mod-qty-btn plus" onclick="changeItemQty(<?php echo intval($producto->id); ?>, 1)">+</div>
                                                </div>
                                            </td>
                                            <td style="text-align:right;" id="peso-<?php echo intval($producto->id); ?>">
                                                <?php echo number_format($peso, 1); ?> <?php echo htmlspecialchars($producto->uom ?? 'kg'); ?>
                                            </td>
                                            <td style="text-align:right;font-weight:600;" id="sub-<?php echo intval($producto->id); ?>">
                                                $<?php echo number_format($sub, 2); ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <button class="mod-delete-btn"
                                                        onclick="deleteItem(<?php echo intval($producto->id); ?>)"
                                                        title="Eliminar producto">
                                                    <span class="material-icons-outlined">delete_outline</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="row-total" id="rowTotal">
                                            <td>Total</td>
                                            <td></td>
                                            <td style="text-align:right;" id="totalPeso"><?php echo number_format($pesoTotal, 1); ?> kg</td>
                                            <td style="text-align:right;" id="totalPrice">$<?php echo number_format($totalOrden, 2); ?></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <!-- Empty state (hidden by default) -->
                                <div class="mod-empty-items" id="emptyItems" style="display:none;">
                                    <span class="material-icons-outlined">remove_shopping_cart</span>
                                    No quedan productos en esta orden.
                                </div>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="mod-card" style="animation-delay:.15s;">
                            <div class="mod-card-header">
                                <span class="material-icons-outlined">schedule</span>
                                Programación de entrega
                            </div>
                            <div class="mod-card-body">
                                <?php if (intval($ordenes->uso_bascula ?? 0) == 1): ?>
                                <div class="mod-timeline-wrap">
                                    <div style="position:relative;padding-top:24px;">
                                        <div class="mod-timeline-hours" id="timelineHours"></div>
                                        <div class="mod-timeline" id="timeline">
                                            <div class="mod-time-block" id="timeBlock">
                                                <span id="blockLabel">--:--</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="mod-no-bascula">
                                    <span class="material-icons-outlined">info</span>
                                    El cliente no requiere uso de báscula — no necesita programación de horario.
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- ── Right column ── -->
                    <div>

                        <!-- Action buttons -->
                        <div class="mod-card" style="animation-delay:.05s;">
                            <div class="mod-card-body" style="display:flex;gap:.75rem;">
                                <button type="button" onclick="rechazarOrden()" class="mod-btn mod-btn-danger" style="flex:1;">
                                    <span class="material-icons-outlined">cancel</span>
                                    Rechazar
                                </button>
                                <button type="button" onclick="aprobarOrden()" class="mod-btn mod-btn-success" style="flex:1;">
                                    <span class="material-icons-outlined">check_circle</span>
                                    Aprobar
                                </button>
                            </div>
                        </div>

                        <!-- Delivery form -->
                        <div class="mod-card" style="animation-delay:.1s;">
                            <div class="mod-card-header">
                                <span class="material-icons-outlined">edit_calendar</span>
                                Datos de entrega
                            </div>
                            <div class="mod-card-body">
                                <div style="display:flex;flex-direction:column;gap:1rem;">
                                    <div class="mod-field">
                                        <label>
                                            <span class="material-icons-outlined">event</span>
                                            Fecha sugerida
                                        </label>
                                        <input type="date" id="fecha_cliente" value="<?php echo htmlspecialchars($fechaSelect); ?>"
                                               onchange="actualizaFecha(this.value)" />
                                    </div>
                                    <div class="mod-field">
                                        <label>
                                            <span class="material-icons-outlined">access_time</span>
                                            Periodo seleccionado
                                        </label>
                                        <input type="text" id="periodo" value="10:00 - 11:00" readonly
                                               style="background:var(--mod-surface-alt);" />
                                    </div>
                                    <div class="mod-field">
                                        <label>
                                            <span class="material-icons-outlined">notes</span>
                                            Notas
                                        </label>
                                        <input type="text" id="notas" placeholder="Escribe una nota sobre esta orden..." />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Comprobante -->
                        <div class="mod-card" style="animation-delay:.15s;">
                            <div class="mod-card-header">
                                <span class="material-icons-outlined">receipt</span>
                                Comprobante de pago
                            </div>
                            <div class="mod-card-body">
                                <?php if (intval($ordenes->tipo_pago ?? 0) == 1 && !empty($comprobanteLimpio)): ?>
                                <button type="button" class="mod-btn mod-btn-outline" style="width:100%;justify-content:center;margin-bottom:.75rem;"
                                        data-bs-toggle="modal" data-bs-target="#proofModal">
                                    <span class="material-icons-outlined">visibility</span>
                                    Ver comprobante
                                </button>
                                <?php elseif (intval($ordenes->tipo_pago ?? 0) == 2): ?>
                                <div class="mod-no-bascula">
                                    <span class="material-icons-outlined">credit_card</span>
                                    Pago a crédito — sin comprobante requerido.
                                </div>
                                <?php else: ?>
                                <div class="mod-no-bascula">
                                    <span class="material-icons-outlined">help_outline</span>
                                    No se ha adjuntado comprobante.
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Cotización -->
                        <div class="mod-card" style="animation-delay:.2s;">
                            <div class="mod-card-body" style="text-align:center;">
                                <a href="api/genera_cot.php?id=<?php echo intval($ordenes->id); ?>" target="_blank"
                                   class="mod-btn mod-btn-primary" style="width:100%;justify-content:center;">
                                    <span class="material-icons-outlined">description</span>
                                    Ver cotización
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- /.mod-grid -->

                <?php endif; ?>
            </div>
        </div>
        <?php include 'partials/footer.php'; ?>
    </main>

    <?php include "partials/theme.php"; ?>

    <?php if (!$sinOrdenes && !empty($comprobanteLimpio)): ?>
    <div class="modal fade mod-modal" id="proofModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-weight:700;display:flex;align-items:center;gap:.5rem;">
                        <span class="material-icons-outlined" style="color:var(--mod-primary);">receipt</span>
                        Comprobante de pago
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="text-align:center;">
                    <img src="<?php echo htmlspecialchars($comprobanteLimpio, ENT_QUOTES, 'UTF-8'); ?>"
                         alt="Comprobante de pago" class="mod-proof-img" />
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/vendors/js/daterangepicker.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (!$sinOrdenes): ?>
    <script>
    /* ══════════════════════════════════════════
       PHP data
    ══════════════════════════════════════════ */
    var ORDER_ID        = <?php echo json_encode(intval($ordenes->id)); ?>;
    var ES_DIRECTO      = <?php echo json_encode($directo); ?>;
    var CORREO_CLIENTE  = <?php echo json_encode($usuario->correo ?? ''); ?>;
    var USA_BASCULA     = <?php echo json_encode(intval($ordenes->uso_bascula ?? 0)); ?>;
    var TIEMPO_MINUTOS  = <?php echo json_encode($tiempoEntregaMinutos); ?>;
    var PERIODOS_OCUPADOS = <?php echo json_encode($periodos); ?>;

    var fmtMXN = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });

    /* ── Si no usa báscula: bloquear campos de fecha/hora ── */
    if (!USA_BASCULA) {
        var fc = document.getElementById('fecha_cliente');
        var pr = document.getElementById('periodo');
        if (fc) { fc.value = <?php echo json_encode(date("Y-m-d")); ?>; fc.readOnly = true; }
        if (pr) { pr.value = '00:00 - 00:00'; }
    }

    /* ══════════════════════════════════════════
       RECALCULATION
       Recorre todas las filas visibles y actualiza
       subtotales, totales, KPIs y contador.
    ══════════════════════════════════════════ */
    function recalcAll() {
        var rows = document.querySelectorAll('#productsBody tr[data-id]');
        var totalPrice = 0;
        var totalPeso  = 0;
        var count      = 0;

        rows.forEach(function(row) {
            var id       = row.dataset.id;
            var precio   = parseFloat(row.dataset.precio)   || 0;
            var pesoUnit = parseFloat(row.dataset.pesoUnit) || 0;
            var qtyEl    = document.getElementById('qty-' + id);
            var qty      = qtyEl ? (parseInt(qtyEl.value) || 0) : 0;

            var sub  = qty * precio;
            var peso = qty * pesoUnit;

            // Actualizar celdas de la fila
            var subEl  = document.getElementById('sub-'  + id);
            var pesoEl = document.getElementById('peso-' + id);
            if (subEl)  subEl.textContent  = fmtMXN.format(sub);
            if (pesoEl) pesoEl.textContent = peso.toFixed(1) + ' kg';

            totalPrice += sub;
            totalPeso  += peso;
            count++;
        });

        // Fila total de la tabla
        var tp = document.getElementById('totalPrice');
        var tw = document.getElementById('totalPeso');
        if (tp) tp.textContent = fmtMXN.format(totalPrice);
        if (tw) tw.textContent = totalPeso.toFixed(1) + ' kg';

        // KPIs superiores
        var kt = document.getElementById('kpiTotal');
        var kp = document.getElementById('kpiPeso');
        if (kt) kt.textContent = fmtMXN.format(totalPrice);
        if (kp) kp.textContent = totalPeso.toFixed(1) + ' kg';

        // Contador de artículos
        var cl = document.getElementById('itemCountLabel');
        if (cl) cl.textContent = count + ' artículo' + (count !== 1 ? 's' : '');

        // Estado vacío
        var empty = document.getElementById('emptyItems');
        var tfoot = document.getElementById('rowTotal');
        if (empty) empty.style.display = count === 0 ? 'block' : 'none';
        if (tfoot) tfoot.style.display = count === 0 ? 'none'  : '';
    }

    /* ══════════════════════════════════════════
       QUANTITY CONTROLS
    ══════════════════════════════════════════ */
    function changeItemQty(id, delta) {
        var input = document.getElementById('qty-' + id);
        if (!input) return;
        var val = Math.max(1, (parseInt(input.value) || 1) + delta);
        input.value = val;
        saveQty(id, val);
    }

    function onQtyInput(id) {
        var input = document.getElementById('qty-' + id);
        if (!input) return;
        var val = Math.max(1, parseInt(input.value) || 1);
        input.value = val;
        saveQty(id, val);
    }

    /* Guarda cantidad en el servidor y recalcula UI */
    function saveQty(id, qty) {
        recalcAll(); // Optimistic update inmediato

        var fd = new FormData();
        fd.append('accion',    'actualizarCantidad');
        fd.append('id_item',   id);
        fd.append('id_orden',  ORDER_ID);
        fd.append('cantidad',  qty);

        fetch('api/apiOrdenes.php', { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .catch(function(err) {
                console.warn('[mod] No se pudo guardar cantidad:', err);
            });
    }

    /* ══════════════════════════════════════════
       DELETE ITEM
    ══════════════════════════════════════════ */
    function deleteItem(id) {
        Swal.fire({
            title: '¿Eliminar producto?',
            text: 'Se quitará este ítem de la orden.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            var row = document.getElementById('row-' + id);
            if (!row) return;

            // Animación de salida
            row.classList.add('row-removing');

            var fd = new FormData();
            fd.append('accion',   'quitarItem');
            fd.append('id_item',  id);
            fd.append('id_orden', ORDER_ID);

            fetch('api/apiOrdenes.php', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    setTimeout(function() {
                        row.remove();
                        recalcAll();
                    }, 260); // esperar animación
                })
                .catch(function(err) {
                    console.error(err);
                    row.classList.remove('row-removing');
                    Swal.fire({
                        icon: 'error', title: 'Error',
                        text: 'No se pudo eliminar el producto.',
                        confirmButtonColor: '#dc2626'
                    });
                });
        });
    }

    /* ══════════════════════════════════════════
       APROBAR / RECHAZAR
    ══════════════════════════════════════════ */
    function aprobarOrden() {
        Swal.fire({
            title: '¿Aprobar esta orden?',
            text: 'Se notificará al cliente con la fecha y hora asignadas.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, aprobar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (!result.isConfirmed) return;
            var fd = new FormData();
            fd.append('id',            ORDER_ID);
            fd.append('fecha_cliente', document.getElementById('fecha_cliente').value);
            fd.append('periodo',       document.getElementById('periodo').value);
            fd.append('notas',         document.getElementById('notas').value);
            fd.append('correo',        CORREO_CLIENTE);
            fd.append('accion',        'aprobar');
            if (ES_DIRECTO) fd.append('directo', 'si');

            fetch('api/apiOrdenes.php', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    Swal.fire({
                        title: 'Orden aprobada', icon: 'success',
                        confirmButtonColor: '#059669', confirmButtonText: 'Continuar'
                    }).then(function() { location.reload(); });
                })
                .catch(function(err) {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo aprobar la orden.', confirmButtonColor: '#dc2626' });
                });
        });
    }

    function rechazarOrden() {
        Swal.fire({
            title: '¿Rechazar esta orden?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, rechazar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (!result.isConfirmed) return;
            var fd = new FormData();
            fd.append('id',            ORDER_ID);
            fd.append('fecha_cliente', '0000-00-00');
            fd.append('periodo',       '00:00 - 00:00');
            fd.append('notas',         'Orden rechazada');
            fd.append('correo',        CORREO_CLIENTE);
            fd.append('accion',        'rechazar');

            fetch('api/apiOrdenes.php', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    Swal.fire({
                        title: 'Orden rechazada', icon: 'info',
                        confirmButtonColor: '#2563eb', confirmButtonText: 'Continuar'
                    }).then(function() { location.reload(); });
                })
                .catch(function(err) {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo rechazar la orden.', confirmButtonColor: '#dc2626' });
                });
        });
    }

    /* ══════════════════════════════════════════
       DATE CHANGE
    ══════════════════════════════════════════ */
    function actualizaFecha(fecha) {
        window.location.href = 'moderacion.php?id=' + ORDER_ID + '&fecha=' + fecha;
    }

    /* ══════════════════════════════════════════
       TIMELINE (drag scheduler)
    ══════════════════════════════════════════ */
    if (USA_BASCULA) {
        (function() {
            var timeline  = document.getElementById('timeline');
            var hoursEl   = document.getElementById('timelineHours');
            var block     = document.getElementById('timeBlock');
            var label     = document.getElementById('blockLabel');
            var periodoInput = document.getElementById('periodo');

            if (!timeline || !block) return;

            var HORA_INICIO   = 8;
            var HORA_FIN      = 16;
            var timelineWidth = timeline.offsetWidth;
            var totalMinutes  = (HORA_FIN - HORA_INICIO) * 60;
            var pxPerMin      = timelineWidth / totalMinutes;
            var blockWidth    = TIEMPO_MINUTOS * pxPerMin;

            block.style.width = blockWidth + 'px';

            // Hora labels
            hoursEl.innerHTML = '';
            for (var h = HORA_INICIO; h <= HORA_FIN; h++) {
                var span = document.createElement('span');
                span.textContent = h + ':00';
                hoursEl.appendChild(span);
            }

            // Ocupados
            PERIODOS_OCUPADOS.forEach(function(p) {
                var p1 = p.start.split(':').map(Number);
                var p2 = p.end.split(':').map(Number);
                var sx = ((p1[0] - HORA_INICIO) * 60 + p1[1]) * pxPerMin;
                var ex = ((p2[0] - HORA_INICIO) * 60 + p2[1]) * pxPerMin;
                var occ = document.createElement('div');
                occ.className = 'mod-occupied';
                occ.style.left  = sx + 'px';
                occ.style.width = (ex - sx) + 'px';
                timeline.appendChild(occ);
            });

            function formatMin(mins) {
                var hr = Math.floor(mins / 60) + HORA_INICIO;
                var mn = mins % 60;
                return hr + ':' + (mn < 10 ? '0' + mn : mn);
            }

            function updatePosition(posPx) {
                var startMin = Math.round(posPx / pxPerMin);
                var endMin   = startMin + TIEMPO_MINUTOS;
                var s = formatMin(startMin);
                var e = formatMin(endMin);
                label.textContent = s + ' - ' + e;
                if (periodoInput) periodoInput.value = s + ' - ' + e;
            }

            function isOverlap(posPx) {
                var overlap = false;
                PERIODOS_OCUPADOS.forEach(function(p) {
                    var p1 = p.start.split(':').map(Number);
                    var p2 = p.end.split(':').map(Number);
                    var os = ((p1[0] - HORA_INICIO) * 60 + p1[1]) * pxPerMin;
                    var oe = ((p2[0] - HORA_INICIO) * 60 + p2[1]) * pxPerMin;
                    if (posPx + blockWidth > os && posPx < oe) overlap = true;
                });
                return overlap;
            }

            var dragging = false;

            block.addEventListener('mousedown',  function(e) { dragging = true; e.preventDefault(); });
            document.addEventListener('mouseup',   function()  { dragging = false; });
            document.addEventListener('mousemove', function(e) {
                if (!dragging) return;
                var rect = timeline.getBoundingClientRect();
                var pos  = Math.max(0, Math.min(e.clientX - rect.left, timelineWidth - blockWidth));
                if (!isOverlap(pos)) { block.style.left = pos + 'px'; updatePosition(pos); }
            });

            block.addEventListener('touchstart',  function(e) { dragging = true; e.preventDefault(); });
            document.addEventListener('touchend',   function()  { dragging = false; });
            document.addEventListener('touchmove',  function(e) {
                if (!dragging) return;
                var touch = e.touches[0];
                var rect  = timeline.getBoundingClientRect();
                var pos   = Math.max(0, Math.min(touch.clientX - rect.left, timelineWidth - blockWidth));
                if (!isOverlap(pos)) { block.style.left = pos + 'px'; updatePosition(pos); }
            });

            updatePosition(0);

            window.addEventListener('resize', function() {
                timelineWidth = timeline.offsetWidth;
                pxPerMin      = timelineWidth / totalMinutes;
                blockWidth    = TIEMPO_MINUTOS * pxPerMin;
                block.style.width = blockWidth + 'px';
            });
        })();
    }
    </script>
    <?php endif; ?>

</body>
</html>