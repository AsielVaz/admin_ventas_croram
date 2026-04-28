<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Nueva Orden" />
    <title>Croram Admin · Nueva Orden</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <!-- CSS Base -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/daterangepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <!-- Select2 para buscador de clientes -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />

    <style>
    /* ══════════════════════════════════════════
       Orden Form — Clean Industrial UI
    ══════════════════════════════════════════ */
    :root {
        --of-primary: #2563eb;
        --of-primary-hover: #1d4ed8;
        --of-primary-soft: rgba(37,99,235,.07);
        --of-success: #059669;
        --of-success-soft: rgba(5,150,105,.08);
        --of-warning: #d97706;
        --of-warning-soft: rgba(217,119,6,.08);
        --of-danger: #dc2626;
        --of-danger-soft: rgba(220,38,38,.07);
        --of-text: #1e293b;
        --of-text-secondary: #64748b;
        --of-text-muted: #94a3b8;
        --of-surface: #ffffff;
        --of-surface-alt: #f8fafc;
        --of-border: #e2e8f0;
        --of-border-strong: #cbd5e1;
        --of-radius: 14px;
        --of-radius-sm: 10px;
        --of-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --of-shadow-lg: 0 8px 32px rgba(0,0,0,.1);
        --of-font: 'DM Sans', sans-serif;
    }

    body { font-family: var(--of-font); }

    /* ── Breadcrumb ── */
    .of-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--of-text-secondary);
    }
    .of-breadcrumb a { color: var(--of-primary); text-decoration: none; }
    .of-breadcrumb .sep { opacity: .4; }

    /* ── Section Card ── */
    .of-card {
        background: var(--of-surface);
        border: 1px solid var(--of-border);
        border-radius: var(--of-radius);
        box-shadow: var(--of-shadow);
        margin-bottom: 1.25rem;
        overflow: hidden;
        transition: box-shadow .2s ease;
    }
    .of-card:hover { box-shadow: var(--of-shadow-lg); }
    .of-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--of-border);
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--of-text);
        background: var(--of-surface-alt);
    }
    .of-card-header .material-icons-outlined { font-size: 1.2rem; color: var(--of-primary); }
    .of-card-body { padding: 1.25rem 1.5rem; }

    /* ── KPI mini cards ── */
    .of-kpi-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .of-kpi {
        background: var(--of-surface);
        border: 1px solid var(--of-border);
        border-radius: var(--of-radius-sm);
        padding: 1rem 1.25rem;
        display: flex; flex-direction: column; gap: .15rem;
    }
    .of-kpi-label {
        font-size: .7rem; text-transform: uppercase;
        letter-spacing: .06em; color: var(--of-text-muted); font-weight: 600;
    }
    .of-kpi-value {
        font-size: 1.35rem; font-weight: 700; color: var(--of-text); line-height: 1.2;
    }
    .of-kpi-value.success { color: var(--of-success); }
    .of-kpi-value.warning { color: var(--of-warning); }
    .of-kpi-value.danger { color: var(--of-danger); }

    /* ── Search & Filters ── */
    .of-toolbar {
        display: flex; align-items: center; gap: .75rem;
        flex-wrap: wrap; margin-bottom: 1.25rem;
    }
    .of-search-box {
        flex: 1; min-width: 220px; position: relative;
    }
    .of-search-box input {
        width: 100%; padding: .6rem 1rem .6rem 2.6rem;
        border: 1px solid var(--of-border); border-radius: var(--of-radius-sm);
        font-size: .875rem; background: var(--of-surface);
        transition: border-color .2s, box-shadow .2s;
        font-family: var(--of-font);
    }
    .of-search-box input:focus {
        outline: none; border-color: var(--of-primary);
        box-shadow: 0 0 0 3px var(--of-primary-soft);
    }
    .of-search-box .search-icon {
        position: absolute; left: .85rem; top: 50%;
        transform: translateY(-50%); font-size: 1.1rem;
        color: var(--of-text-muted); pointer-events: none;
    }
    .of-filter-btn {
        padding: .5rem 1rem; border-radius: var(--of-radius-sm);
        border: 1px solid var(--of-border); background: var(--of-surface);
        font-size: .8rem; font-weight: 500; cursor: pointer;
        color: var(--of-text-secondary); transition: all .2s;
        font-family: var(--of-font);
    }
    .of-filter-btn:hover,
    .of-filter-btn.active {
        border-color: var(--of-primary); color: var(--of-primary);
        background: var(--of-primary-soft);
    }
    .of-view-toggle { display: flex; gap: 0; }
    .of-view-toggle button {
        padding: .5rem .7rem; border: 1px solid var(--of-border);
        background: var(--of-surface); cursor: pointer; color: var(--of-text-muted);
        transition: all .15s;
    }
    .of-view-toggle button:first-child { border-radius: var(--of-radius-sm) 0 0 var(--of-radius-sm); }
    .of-view-toggle button:last-child { border-radius: 0 var(--of-radius-sm) var(--of-radius-sm) 0; border-left: 0; }
    .of-view-toggle button.active { background: var(--of-primary); color: #fff; border-color: var(--of-primary); }

    /* ── Product Grid ── */
    .of-products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1rem;
    }
    .of-products-grid.list-view {
        grid-template-columns: 1fr;
    }

    /* ── Product Card ── */
    .of-product {
        background: var(--of-surface);
        border: 1px solid var(--of-border);
        border-radius: var(--of-radius);
        overflow: hidden;
        display: flex;
        transition: all .2s ease;
        position: relative;
    }
    .of-product:hover {
        border-color: var(--of-border-strong);
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
    }
    .of-product.has-quantity {
        border-color: var(--of-primary);
        box-shadow: 0 0 0 1px var(--of-primary), 0 4px 16px rgba(37,99,235,.12);
    }
    .of-product.disabled-card {
        opacity: .45; pointer-events: none;
    }
    .of-product-img {
        width: 130px; min-height: 130px;
        background: var(--of-surface-alt);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; overflow: hidden;
    }
    .of-product-img img {
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .of-product-body {
        padding: 1rem 1.15rem;
        flex: 1; display: flex; flex-direction: column; gap: .5rem;
    }
    .of-product-name {
        font-size: .9rem; font-weight: 700; color: var(--of-text);
        line-height: 1.25; margin: 0;
    }
    .of-product-desc {
        font-size: .78rem; color: var(--of-text-muted);
        line-height: 1.4; margin: 0;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .of-product-price {
        font-size: 1.05rem; font-weight: 700; color: var(--of-primary);
    }
    .of-product-price small {
        font-size: .72rem; font-weight: 400; color: var(--of-text-muted);
    }

    /* Badge de oferta */
    .of-badge-offer {
        position: absolute; top: .6rem; left: .6rem;
        padding: .2rem .6rem; border-radius: 6px;
        font-size: .68rem; font-weight: 600;
        background: var(--of-danger); color: #fff;
        z-index: 2; display: flex; align-items: center; gap: .25rem;
    }
    .of-badge-offer .material-icons-outlined { font-size: .8rem; }

    /* Badge de stock */
    .of-badge-stock {
        font-size: .7rem; font-weight: 500;
        padding: .2rem .55rem; border-radius: 6px;
        display: inline-flex; align-items: center; gap: .25rem;
        background: var(--of-surface-alt); color: var(--of-text-muted);
        border: 1px solid var(--of-border);
    }
    .of-badge-stock.low { background: var(--of-warning-soft); color: var(--of-warning); border-color: transparent; }
    .of-badge-stock.out { background: var(--of-danger-soft); color: var(--of-danger); border-color: transparent; }

    /* Offer detail text */
    .of-offer-text {
        font-size: .73rem; font-weight: 600;
        color: var(--of-success); display: flex;
        align-items: center; gap: .25rem;
    }
    .of-offer-text .material-icons-outlined { font-size: .85rem; }

    /* Quantity input inline */
    .of-qty-group {
        display: flex; align-items: center; gap: 0;
        margin-top: auto;
    }
    .of-qty-btn {
        width: 34px; height: 34px; border: 1px solid var(--of-border);
        background: var(--of-surface-alt); display: flex;
        align-items: center; justify-content: center;
        cursor: pointer; color: var(--of-text-secondary);
        font-size: 1.1rem; transition: all .15s;
        -webkit-user-select: none; user-select: none;
    }
    .of-qty-btn:hover { background: var(--of-primary-soft); color: var(--of-primary); }
    .of-qty-btn:first-child { border-radius: 8px 0 0 8px; }
    .of-qty-btn:last-child { border-radius: 0 8px 8px 0; }
    .of-qty-input {
        width: 52px; height: 34px; text-align: center;
        border: 1px solid var(--of-border); border-left: 0; border-right: 0;
        font-size: .85rem; font-weight: 600; font-family: var(--of-font);
        color: var(--of-text); background: var(--of-surface);
    }
    .of-qty-input:focus { outline: none; background: var(--of-primary-soft); }
    .of-qty-input::-webkit-inner-spin-button,
    .of-qty-input::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    .of-qty-input { -moz-appearance: textfield; }

    /* ── IVA Row ── */
    .of-iva-row {
        display: none; align-items: center; gap: .5rem;
        margin-top: .55rem; padding: .45rem .65rem;
        background: var(--of-warning-soft);
        border: 1px dashed #f59e0b44;
        border-radius: 8px;
    }
    .of-iva-row input[type="checkbox"] {
        width: 15px; height: 15px; cursor: pointer;
        accent-color: var(--of-warning);
    }
    .of-iva-row label {
        font-size: .75rem; font-weight: 600;
        color: var(--of-warning); cursor: pointer; margin: 0;
        display: flex; align-items: center; gap: .3rem;
    }
    .of-iva-row label .material-icons-outlined { font-size: .9rem; }
    .of-iva-legend {
        display: none; align-items: center; gap: .3rem;
        font-size: .7rem; font-weight: 600; color: var(--of-success);
        margin-top: .2rem;
    }
    .of-iva-legend .material-icons-outlined { font-size: .8rem; }

    /* ── Sticky Cart Summary ── */
    .of-cart-bar {
        position: fixed; bottom: 0; left: 0; right: 0;
        z-index: 1050;
        background: var(--of-surface);
        border-top: 1px solid var(--of-border);
        box-shadow: 0 -4px 24px rgba(0,0,0,.1);
        padding: .85rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        gap: 1rem; flex-wrap: wrap;
        transform: translateY(100%);
        transition: transform .3s cubic-bezier(.4,0,.2,1);
    }
    .of-cart-bar.visible { transform: translateY(0); }
    .of-cart-bar .cart-info {
        display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
    }
    .of-cart-bar .cart-stat {
        display: flex; flex-direction: column;
    }
    .of-cart-bar .cart-stat-label {
        font-size: .68rem; text-transform: uppercase; letter-spacing: .04em;
        color: var(--of-text-muted); font-weight: 600;
    }
    .of-cart-bar .cart-stat-value {
        font-size: 1rem; font-weight: 700; color: var(--of-text);
    }
    .of-cart-bar .cart-actions { display: flex; gap: .5rem; }
    .of-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .6rem 1.25rem; border-radius: var(--of-radius-sm);
        font-size: .85rem; font-weight: 600; font-family: var(--of-font);
        cursor: pointer; border: none; transition: all .2s;
        text-decoration: none;
    }
    .of-btn .material-icons-outlined { font-size: 1.1rem; }
    .of-btn-primary {
        background: var(--of-primary); color: #fff;
    }
    .of-btn-primary:hover { background: var(--of-primary-hover); color: #fff; }
    .of-btn-success {
        background: var(--of-success); color: #fff;
    }
    .of-btn-success:hover { background: #047857; color: #fff; }
    .of-btn-outline {
        background: transparent; color: var(--of-text-secondary);
        border: 1px solid var(--of-border);
    }
    .of-btn-outline:hover { border-color: var(--of-primary); color: var(--of-primary); }
    .of-btn-danger {
        background: var(--of-danger); color: #fff;
    }

    /* ── Modal overrides ── */
    .of-modal .modal-content {
        border: none; border-radius: var(--of-radius);
        box-shadow: var(--of-shadow-lg);
    }
    .of-modal .modal-header {
        border-bottom: 1px solid var(--of-border);
        padding: 1.15rem 1.5rem;
    }
    .of-modal .modal-title {
        font-size: 1rem; font-weight: 700; color: var(--of-text);
        display: flex; align-items: center; gap: .5rem;
    }
    .of-modal .modal-title .material-icons-outlined { font-size: 1.2rem; color: var(--of-primary); }
    .of-modal .modal-body { padding: 1.5rem; }
    .of-modal .modal-footer { border-top: 1px solid var(--of-border); padding: 1rem 1.5rem; }

    /* Order summary table */
    .of-summary-table {
        width: 100%; border-collapse: separate;
        border-spacing: 0; font-size: .85rem;
    }
    .of-summary-table thead th {
        background: var(--of-surface-alt); padding: .65rem 1rem;
        font-weight: 600; color: var(--of-text-secondary);
        font-size: .75rem; text-transform: uppercase;
        letter-spacing: .04em; border-bottom: 1px solid var(--of-border);
    }
    .of-summary-table thead th:first-child { border-radius: 8px 0 0 0; }
    .of-summary-table thead th:last-child { border-radius: 0 8px 0 0; }
    .of-summary-table tbody td {
        padding: .6rem 1rem; border-bottom: 1px solid var(--of-border);
        color: var(--of-text); vertical-align: middle;
    }
    .of-summary-table tbody tr:last-child td { border-bottom: none; }
    .of-summary-table .row-total td {
        font-weight: 700; font-size: .95rem;
        background: var(--of-primary-soft); color: var(--of-primary);
    }
    .of-summary-table .offer-tag {
        display: inline-block; padding: .1rem .45rem;
        border-radius: 4px; font-size: .68rem; font-weight: 600;
        background: var(--of-success-soft); color: var(--of-success);
        margin-left: .35rem;
    }

    /* ── Select2 tweaks ── */
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: var(--of-radius-sm) !important;
        min-height: 42px !important;
        border-color: var(--of-border) !important;
        font-family: var(--of-font) !important;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        padding-top: 2px;
    }

    /* ── Form fields inside modal ── */
    .of-field label {
        font-size: .78rem; font-weight: 600; color: var(--of-text-secondary);
        text-transform: uppercase; letter-spacing: .03em;
        margin-bottom: .35rem; display: flex; align-items: center; gap: .3rem;
    }
    .of-field label .material-icons-outlined { font-size: .9rem; }
    .of-field select,
    .of-field input {
        border-radius: var(--of-radius-sm); border: 1px solid var(--of-border);
        font-family: var(--of-font); font-size: .875rem;
        padding: .55rem .85rem;
    }
    .of-field select:focus,
    .of-field input:focus {
        border-color: var(--of-primary);
        box-shadow: 0 0 0 3px var(--of-primary-soft);
    }

    /* ── Extras table ── */
    .of-extras-table {
        width: 100%; font-size: .85rem;
        border-collapse: collapse;
    }
    .of-extras-table th {
        padding: .55rem .75rem; font-weight: 600;
        color: var(--of-text-secondary); font-size: .73rem;
        text-transform: uppercase; letter-spacing: .03em;
        border-bottom: 2px solid var(--of-border);
    }
    .of-extras-table td {
        padding: .5rem .75rem; border-bottom: 1px solid var(--of-border);
    }
    .of-extras-table input {
        width: 80px; text-align: center;
        border: 1px solid var(--of-border);
        border-radius: 8px; padding: .35rem .5rem;
        font-family: var(--of-font); font-size: .85rem;
    }
    .of-extras-table input:focus {
        outline: none; border-color: var(--of-primary);
        box-shadow: 0 0 0 3px var(--of-primary-soft);
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .of-products-grid { grid-template-columns: 1fr; }
        .of-product-img { width: 100px; min-height: 100px; }
        .of-cart-bar { padding: .65rem 1rem; }
        .of-cart-bar .cart-info { gap: 1rem; }
    }

    /* ── Animation ── */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .of-product {
        animation: fadeInUp .35s ease both;
    }

    /* Space for fixed bottom bar */
    .of-bottom-spacer { height: 90px; }

    /* ── Empty state ── */
    .of-empty {
        text-align: center; padding: 3rem 1rem;
        color: var(--of-text-muted);
    }
    .of-empty .material-icons-outlined {
        font-size: 3rem; display: block; margin-bottom: .75rem; opacity: .4;
    }

    /* No results for search */
    .of-no-results {
        display: none; text-align: center; padding: 2.5rem 1rem;
        color: var(--of-text-muted); font-size: .9rem;
    }
    .of-no-results.show { display: block; }
    </style>
</head>

<body>
    <!-- ═══ Navigation ═══ -->
    <?php include "partials/barra.php"; ?>
    <!-- ═══ Header ═══ -->
    <?php include "partials/header.php"; ?>

    <?php
    /* ─────────────────────────────────────
       PHP: Data loading
    ───────────────────────────────────── */
    include_once "api/adminProductos.php";
    include_once "api/adminAutos.php";
    include_once "api/adminUsuarios.php";
    include_once "api/adminOfertas.php";
    include_once "api/adminSets.php";

    $adminProductos = new AdministradorProductos();
    $adminUsuarios  = new AdministradorUsuarios();
    $adminSets      = new AdministradorSets();
    $usuarios       = $adminUsuarios->dameUsuarios();

    $clienteSeleccionado = false;
    $id = null;
    $nombreCliente = '';
    $credito = 0;
    $id_price_list = '';
    $autos = [];
    $productos = [];
    $precios = [];
    $setNombre = '';

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);
        $clienteSeleccionado = true;

        $adminAutos   = new AdministradorAutos();
        $adminOfertas = new AdministradorOfertas();

        $productos = $adminProductos->obtenerProductos();
        $autos     = $adminAutos->obtenerAutosCliente($id);
        $usuario   = $adminUsuarios->dameUsuario($id);
        $usuarioApi = $adminUsuarios->dameUsuarioApi($usuario->id_cliente);

        $precios        = $usuarioApi->item->salePriceList->lines;
        $nombreCliente  = $usuarioApi->item->firstName;
        $id_price_list  = $usuarioApi->item->salePriceList->id;

        $sumaCreditoProbable = floatval($adminUsuarios->dameSumaOrdenesCredito($id));
        $creditoTotal = floatval($usuarioApi->item->saleCreditAmountLimit);
        $deudaActual  = floatval($usuarioApi->item->amountDue);
        $credito      = $creditoTotal - $deudaActual - $sumaCreditoProbable;

        if ($usuario->id_set != 0) {
            if (method_exists($adminSets, 'dameSetVendedorPorId')) {
                try {
                    $set = @$adminSets->dameSetVendedorPorId($usuario->id_set);
                    $setNombre = is_object($set) && isset($set->nombre) ? $set->nombre : '';
                } catch (Exception $e) { $setNombre = ''; }
            }
        }
    }

    // Helper para URLs de imágenes
    function reemplazarUrl($url) {
        return str_replace("/home3/grupo465/public_html/admin", "https://admin.grupocroram.com/", $url);
    }
    ?>

    <!-- ═══ Main Content ═══ -->
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <!-- Breadcrumb -->
                <div class="of-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span>Nueva Orden</span>
                    <?php if ($clienteSeleccionado): ?>
                        <span class="sep">/</span>
                        <span style="color:var(--of-text);font-weight:600;"><?php echo htmlspecialchars($nombreCliente); ?></span>
                    <?php endif; ?>
                </div>

                <!-- ═══ Selector de Cliente ═══ -->
                <div class="of-card">
                    <div class="of-card-header">
                        <span class="material-icons-outlined">person_search</span>
                        Seleccionar Cliente
                    </div>
                    <div class="of-card-body">
                        <select id="selectorCliente" class="form-select" style="width:100%;">
                            <option value="">Buscar cliente por nombre...</option>
                            <?php foreach ($usuarios as $u): ?>
                                <option value="<?php echo $u->id; ?>"
                                    <?php echo ($u->id == $id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($u->nombre); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php if ($clienteSeleccionado): ?>

                <!-- ═══ KPIs del cliente ═══ -->
                <div class="of-kpi-row">
                    <div class="of-kpi">
                        <span class="of-kpi-label">Cliente</span>
                        <span class="of-kpi-value"><?php echo htmlspecialchars($nombreCliente); ?></span>
                    </div>
                    <?php if (!empty($setNombre)): ?>
                    <div class="of-kpi">
                        <span class="of-kpi-label">Lista de precios</span>
                        <span class="of-kpi-value" style="font-size:1rem;"><?php echo htmlspecialchars($setNombre); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="of-kpi">
                        <span class="of-kpi-label">Crédito disponible</span>
                        <span class="of-kpi-value <?php echo $credito > 0 ? 'success' : 'danger'; ?>">
                            $<?php echo number_format($credito, 2); ?>
                        </span>
                    </div>
                    <div class="of-kpi">
                        <span class="of-kpi-label">Productos en orden</span>
                        <span class="of-kpi-value" id="kpiProductCount">0</span>
                    </div>
                </div>

                <!-- ═══ Toolbar: Búsqueda + Filtros ═══ -->
                <div class="of-toolbar">
                    <div class="of-search-box">
                        <span class="material-icons-outlined search-icon">search</span>
                        <input type="text" id="searchProducts" placeholder="Buscar producto por nombre..." autocomplete="off" />
                    </div>
                    <button class="of-filter-btn active" data-filter="all" onclick="filterProducts('all', this)">
                        Todos
                    </button>
                    <button class="of-filter-btn" data-filter="offer" onclick="filterProducts('offer', this)">
                        🏷️ Con oferta
                    </button>
                    <button class="of-filter-btn" data-filter="inCart" onclick="filterProducts('inCart', this)">
                        🛒 En carrito
                    </button>
                    <div class="of-view-toggle">
                        <button class="active" onclick="setView('grid', this)" title="Vista cuadrícula">
                            <span class="material-icons-outlined" style="font-size:1.1rem;">grid_view</span>
                        </button>
                        <button onclick="setView('list', this)" title="Vista lista">
                            <span class="material-icons-outlined" style="font-size:1.1rem;">view_list</span>
                        </button>
                    </div>
                </div>

                <!-- No results message -->
                <div class="of-no-results" id="noResults">
                    <span class="material-icons-outlined" style="font-size:2.5rem;display:block;margin-bottom:.5rem;opacity:.4;">search_off</span>
                    No se encontraron productos con ese nombre.
                </div>

                <!-- ═══ Product Grid ═══ -->
                <div class="of-products-grid" id="productsGrid">
                    <?php
                    $productIndex = 0;
                    foreach ($productos as $producto):
                        if (!is_object($producto)) continue;
                        if (intval($producto->id ?? 0) == 24) continue;
                        if (intval($producto->estatus ?? 0) == 0) continue;

                        // ── Precio ──
                        $precio = 0;
                        $precioSet = null;

                        if (isset($adminSets) && method_exists($adminSets, 'dameSetItemComplex')) {
                            try {
                                $precioSet = @$adminSets->dameSetItemComplex($usuario->id_set, $producto->id);
                            } catch (Exception $e) { $precioSet = null; }
                        }

                        foreach ($precios as $p) {
                            if (isset($p->productId) && $p->productId == ($producto->id_napers ?? null)) {
                                $precio = floatval($p->fixedPrice ?? 0);
                            }
                            if (is_object($precioSet)
                                && isset($precioSet->id_producto)
                                && $precioSet->id_producto == $producto->id) {
                                $precio = floatval($precioSet->precio_set ?? 0);
                            }
                        }
                        if ($precio == 0) continue;

                        // ── Ofertas ──
                        $ofertaProd = null;
                        $ofertaSobreProd = null;

                        if (isset($adminOfertas)) {
                            if (method_exists($adminOfertas, 'dameOfertaProductoInvertidaFecha')) {
                                try {
                                    $ofertaProd = @$adminOfertas->dameOfertaProductoInvertidaFecha($producto->id, date("Y-m-d"));
                                } catch (Exception $e) { $ofertaProd = null; }
                            }
                            if (method_exists($adminOfertas, 'dameOfertaProductoFecha')) {
                                try {
                                    $ofertaSobreProd = @$adminOfertas->dameOfertaProductoFecha($producto->id, date("Y-m-d"));
                                } catch (Exception $e) { $ofertaSobreProd = null; }
                            }
                        }

                        $tipoOfertaProd  = (is_object($ofertaProd) && isset($ofertaProd->tipo_oferta))
                                            ? intval($ofertaProd->tipo_oferta) : 0;
                        $tipoOfertaSobre = (is_object($ofertaSobreProd) && isset($ofertaSobreProd->tipo_oferta))
                                            ? intval($ofertaSobreProd->tipo_oferta) : 0;

                        $tieneOfertaProd  = ($tipoOfertaProd === 1);
                        $tieneOfertaSobre = ($tipoOfertaSobre > 0);
                        $hasOffer = $tieneOfertaProd || $tieneOfertaSobre;

                        $offerText = '';
                        if ($tieneOfertaSobre && is_object($ofertaSobreProd)) {
                            $cantDet = intval($ofertaSobreProd->cantidad_det ?? 0);
                            $cantOf  = intval($ofertaSobreProd->cantidad_oferta ?? 0);
                            $porcOf  = floatval($ofertaSobreProd->porc_oferta ?? 0);

                            if ($tipoOfertaSobre === 1 && $cantDet > 0) {
                                $offerText = "Lleva {$cantDet} → recibe {$cantOf} gratis";
                            } elseif ($tipoOfertaSobre === 2 && $cantDet > 0) {
                                $offerText = "-{$porcOf}% al llevar {$cantDet}+";
                            }
                        }

                        $safeId      = intval($producto->id);
                        $safeNapers  = intval($producto->id_napers ?? 0);
                        $safeName    = htmlspecialchars($producto->name ?? '', ENT_QUOTES, 'UTF-8');
                        $safeNameLow = htmlspecialchars(mb_strtolower($producto->name ?? '', 'UTF-8'), ENT_QUOTES, 'UTF-8');
                        $safeDesc    = htmlspecialchars($producto->description ?? '', ENT_QUOTES, 'UTF-8');
                        $safeImage   = htmlspecialchars(reemplazarUrl($producto->image ?? ''), ENT_QUOTES, 'UTF-8');

                        $delay = min($productIndex * 0.04, 0.8);
                        $productIndex++;
                    ?>
                    <div class="of-product"
                         id="card-<?php echo $safeId; ?>"
                         data-product-id="<?php echo $safeId; ?>"
                         data-napers-id="<?php echo $safeNapers; ?>"
                         data-name="<?php echo $safeNameLow; ?>"
                         data-has-offer="<?php echo $hasOffer ? '1' : '0'; ?>"
                         style="animation-delay:<?php echo $delay; ?>s">

                        <?php if ($hasOffer): ?>
                        <span class="of-badge-offer">
                            <span class="material-icons-outlined">local_offer</span> Oferta
                        </span>
                        <?php endif; ?>

                        <div class="of-product-img">
                            <?php if (!empty($safeImage)): ?>
                            <img src="<?php echo $safeImage; ?>"
                                 alt="<?php echo $safeName; ?>"
                                 loading="lazy"
                                 onerror="this.style.display='none'" />
                            <?php else: ?>
                            <span class="material-icons-outlined" style="font-size:2.5rem;color:var(--of-text-muted);opacity:.3;">image</span>
                            <?php endif; ?>
                        </div>

                        <div class="of-product-body">
                            <h6 class="of-product-name"><?php echo $safeName; ?></h6>
                            <?php if (!empty($safeDesc)): ?>
                            <p class="of-product-desc"><?php echo $safeDesc; ?></p>
                            <?php endif; ?>

                            <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
                                <span class="of-product-price" id="price-display-<?php echo $safeId; ?>">
                                    $<?php echo number_format($precio, 2); ?>
                                    <small>/ Bolsa</small>
                                </span>
                                <span class="of-badge-stock" id="stock-<?php echo $safeNapers; ?>">
                                    <span class="material-icons-outlined" style="font-size:.8rem;">inventory_2</span>
                                    ...
                                </span>
                            </div>

                            <?php if (!empty($offerText)): ?>
                            <div class="of-offer-text">
                                <span class="material-icons-outlined">redeem</span>
                                <?php echo htmlspecialchars($offerText, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <?php endif; ?>

                            <div class="of-qty-group">
                                <div class="of-qty-btn" onclick="changeQty(<?php echo $safeId; ?>, -1)">−</div>
                                <input type="number" class="of-qty-input"
                                       id="p<?php echo $safeId; ?>"
                                       value="0" min="0"
                                       onchange="setQty(<?php echo $safeId; ?>)" />
                                <div class="of-qty-btn" onclick="changeQty(<?php echo $safeId; ?>, 1)">+</div>
                            </div>

                            <!-- IVA toggle — visible solo cuando hay qty -->
                            <div class="of-iva-row" id="iva-row-<?php echo $safeId; ?>">
                                <input type="checkbox"
                                       id="iva-<?php echo $safeId; ?>"
                                       onchange="toggleIva(<?php echo $safeId; ?>)" />
                                <label for="iva-<?php echo $safeId; ?>">
                                    <span class="material-icons-outlined">receipt</span>
                                    Aplica IVA <span style="opacity:.75;">(+16%)</span>
                                </label>
                            </div>
                            <div class="of-iva-legend" id="iva-legend-<?php echo $safeId; ?>">
                                <span class="material-icons-outlined">check_circle</span>
                                Precio mostrado ya incluye IVA del 16%
                            </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="of-bottom-spacer"></div>

                <!-- ═══ Sticky Cart Bar ═══ -->
                <div class="of-cart-bar" id="cartBar">
                    <div class="cart-info">
                        <div class="cart-stat">
                            <span class="cart-stat-label">Productos</span>
                            <span class="cart-stat-value" id="barItems">0</span>
                        </div>
                        <div class="cart-stat">
                            <span class="cart-stat-label">Peso aprox.</span>
                            <span class="cart-stat-value" id="barWeight">0 kg</span>
                        </div>
                        <div class="cart-stat">
                            <span class="cart-stat-label">Total</span>
                            <span class="cart-stat-value" id="barTotal" style="color:var(--of-primary);">$0</span>
                        </div>
                    </div>
                    <div class="cart-actions">
                        <button class="of-btn of-btn-outline" data-bs-toggle="modal" data-bs-target="#extrasModal">
                            <span class="material-icons-outlined">add_circle_outline</span>
                            Extras
                        </button>
                        <button class="of-btn of-btn-success" data-bs-toggle="modal" data-bs-target="#orderModal" onclick="prepareOrderModal()">
                            <span class="material-icons-outlined">check_circle</span>
                            Finalizar Orden
                        </button>
                    </div>
                </div>

                <?php else: ?>
                <!-- Empty State: no client selected -->
                <div class="of-empty">
                    <span class="material-icons-outlined">person_search</span>
                    <p style="font-weight:600;color:var(--of-text);margin-bottom:.25rem;">Selecciona un cliente</p>
                    <p>Elige un cliente del buscador para comenzar a crear la orden.</p>
                </div>
                <?php endif; ?>

            </div>
        </div>
        <?php include 'partials/footer.php'; ?>
    </main>

    <?php include "partials/theme.php"; ?>

    <?php if ($clienteSeleccionado): ?>
    <!-- ═══════════════════════════════════════════
         Modal: Finalizar Orden
    ═══════════════════════════════════════════ -->
    <div class="modal fade of-modal" id="orderModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="material-icons-outlined">receipt_long</span>
                        Resumen de Orden
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Tabla resumen -->
                    <table class="of-summary-table" id="orderSummaryTable">
                        <thead>
                            <tr>
                                <th style="width:40%;">Producto</th>
                                <th style="width:15%;text-align:center;">Cant.</th>
                                <th style="width:20%;text-align:right;">Precio</th>
                                <th style="width:25%;text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="orderSummaryBody"></tbody>
                    </table>

                    <hr style="margin:1.25rem 0;border-color:var(--of-border);">

                    <!-- Campos de la orden -->
                    <div class="row g-3">
                        <div class="col-md-6 of-field">
                            <label>
                                <span class="material-icons-outlined">local_shipping</span>
                                Vehículo de recolección
                            </label>
                            <select class="form-select" id="auto">
                                <option value="0">Sin vehículo</option>
                                <?php foreach ($autos as $auto): ?>
                                <option value="<?php echo $auto->id; ?>">
                                    <?php echo htmlspecialchars($auto->marca . ' ' . $auto->modelo . ' — ' . $auto->placas); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 of-field">
                            <label>
                                <span class="material-icons-outlined">badge</span>
                                Nombre del recolector
                            </label>
                            <input type="text" class="form-control" id="recolector" placeholder="Nombre completo" />
                        </div>
                        <div class="col-md-6 of-field">
                            <label>
                                <span class="material-icons-outlined">payment</span>
                                Tipo de pago
                            </label>
                            <select class="form-select" id="tipoPago">
                                <option value="1">Efectivo / Depósito</option>
                                <option value="2" <?php echo ($credito <= 0) ? 'disabled' : ''; ?>>
                                    Crédito <?php echo ($credito <= 0) ? '— Insuficiente' : ''; ?>
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 of-field">
                            <label>
                                <span class="material-icons-outlined">scale</span>
                                Uso de báscula
                            </label>
                            <select class="form-select" id="usoBascula">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="of-btn of-btn-outline" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="of-btn of-btn-success" onclick="submitOrder()" id="btnSubmitOrder">
                        <span class="material-icons-outlined">check_circle</span>
                        Confirmar Orden
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         Modal: Productos Extra
    ═══════════════════════════════════════════ -->
    <div class="modal fade of-modal" id="extrasModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="material-icons-outlined">add_shopping_cart</span>
                        Productos Extra (sin costo)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="of-search-box" style="margin-bottom:1rem;">
                        <span class="material-icons-outlined search-icon">search</span>
                        <input type="text" id="searchExtras" placeholder="Buscar en extras..." autocomplete="off" />
                    </div>
                    <table class="of-extras-table" id="extrasTable">
                        <thead>
                            <tr>
                                <th style="width:55%;">Producto</th>
                                <th style="width:25%;text-align:center;">Precio ref.</th>
                                <th style="width:20%;text-align:center;">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto):
                                if ($producto->id == 24) continue;
                                if ($producto->estatus == 0) continue;
                                $precio = 0;
                                foreach ($precios as $p) {
                                    if ($p->productId == $producto->id_napers) $precio = $p->fixedPrice;
                                }
                                if ($precio == 0) continue;
                            ?>
                            <tr data-extra-name="<?php echo htmlspecialchars(mb_strtolower($producto->name)); ?>">
                                <td><?php echo $producto->name; ?></td>
                                <td style="text-align:center;color:var(--of-text-muted);">
                                    $<?php echo number_format($precio, 2); ?>
                                </td>
                                <td style="text-align:center;">
                                    <input type="number" min="0" value="0"
                                           id="extra<?php echo $producto->id; ?>"
                                           onchange="setExtraQty(<?php echo $producto->id; ?>)" />
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="of-btn of-btn-success" data-bs-dismiss="modal">
                        <span class="material-icons-outlined">check</span>
                        Listo
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════
         Scripts
    ═══════════════════════════════════════════ -->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/vendors/js/daterangepicker.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>
    <!-- jQuery (from vendors) + Select2 + SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    /* ══════════════════════════════════════════
       Client Selector (Select2)
    ══════════════════════════════════════════ */
    $(document).ready(function() {
        $('#selectorCliente').select2({
            theme: 'bootstrap-5',
            placeholder: 'Buscar cliente por nombre...',
            allowClear: true,
            language: {
                noResults: () => 'No se encontraron clientes',
                searching: () => 'Buscando...'
            }
        }).on('select2:select', function(e) {
            const val = e.params.data.id;
            if (val) window.location.href = 'ordenes-crear.php?id=' + val;
        }).on('select2:clear', function() {
            window.location.href = 'ordenes-crear.php';
        });
    });
    </script>

    <!-- ═══════════════════════════════════════════
         BLOCK 1: Pure JS functions — NO PHP here.
         This block can NEVER break from bad data.
    ═══════════════════════════════════════════ -->
    <script>
    /* ── Globals that the data block will populate ── */
    var CLIENT_ID = 0;
    var PRICE_LIST_ID = '';
    var CREDIT_LIMIT = 0;
    var autosData = [];
    var products = {};
    var offers = [];

    /* ── Formatters ── */
    var fmtMXN = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });

    /* Spin keyframes */
    (function(){
        var s = document.createElement('style');
        s.textContent = '@keyframes spin{from{transform:rotate(0)}to{transform:rotate(360deg)}}';
        document.head.appendChild(s);
    })();

    /* ══ Quantity controls ══ */
    function changeQty(id, delta) {
        var input = document.getElementById('p' + id);
        if (!input) return;
        var val = Math.max(0, (parseInt(input.value) || 0) + delta);
        input.value = val;
        setQty(id);
    }

    function setQty(id) {
        var input = document.getElementById('p' + id);
        if (!input) return;
        var val = Math.max(0, parseInt(input.value) || 0);
        input.value = val;
        if (products[id]) products[id].qty = val;
        var card = document.getElementById('card-' + id);
        if (card) card.classList.toggle('has-quantity', val > 0);

        // Mostrar/ocultar fila IVA
        var ivaRow = document.getElementById('iva-row-' + id);
        if (ivaRow) ivaRow.style.display = val > 0 ? 'flex' : 'none';

        // Si qty vuelve a 0, desmarcar y limpiar IVA
        if (val === 0) {
            var cb = document.getElementById('iva-' + id);
            if (cb) cb.checked = false;
            if (products[id]) products[id].ivaApplied = false;
            var legend = document.getElementById('iva-legend-' + id);
            if (legend) legend.style.display = 'none';
        }

        recalculate();
    }

    function setExtraQty(id) {
        var input = document.getElementById('extra' + id);
        if (!input) return;
        var val = Math.max(0, parseInt(input.value) || 0);
        input.value = val;
        var key = 'extra_' + id;
        if (products[key]) products[key].qty = val;
        recalculate();
    }

    /* ══ IVA toggle ══ */
    function toggleIva(id) {
        var cb = document.getElementById('iva-' + id);
        if (!cb || !products[id]) return;
        products[id].ivaApplied = cb.checked;
        var legend = document.getElementById('iva-legend-' + id);
        if (legend) {
            legend.style.display = cb.checked ? 'flex' : 'none';
        }
        recalculate();
    }

    /* ══ Offers: reset & recalculate ══ */
    function recalculate() {
        Object.keys(products).forEach(function(k) {
            var p = products[k];
            if (p.isOffer) p.qty = 0;
            if (!p.isOffer && !p.isExtra) {
                p.price = p.priceOriginal;
                p.name = p.nameOriginal;
            }
        });
        offers.forEach(function(o) {
            var trigger = products[o.triggerProductId];
            if (!trigger || trigger.qty <= 0) return;
            if (o.offerType === 1) {
                var times = Math.floor(trigger.qty / o.triggerQty);
                var slot = products[o.offerProductId];
                if (slot && times > 0) slot.qty = times * o.offerQty;
            } else if (o.offerType === 2) {
                if (trigger.qty >= o.triggerQty) {
                    trigger.price = trigger.priceOriginal * (1 - o.discountPct / 100);
                    trigger.name = trigger.nameOriginal + ' \u2014 ' + o.discountPct + '% OFF';
                }
            }
        });

        // Aplicar IVA (16%) después de precios base + ofertas
        Object.keys(products).forEach(function(k) {
            var p = products[k];
            if (!p.isOffer && !p.isExtra && p.ivaApplied) {
                p.price = p.price * 1.16;
                // Refrescar display del precio en la tarjeta
                var dispEl = document.getElementById('price-display-' + p.id);
                if (dispEl) {
                    dispEl.innerHTML = fmtMXN.format(p.price) + ' <small>/ Bolsa <span style="color:var(--of-warning);font-weight:700;">+IVA</span></small>';
                }
            } else if (!p.isOffer && !p.isExtra && !p.ivaApplied) {
                // Restaurar display sin IVA
                var dispElClean = document.getElementById('price-display-' + p.id);
                if (dispElClean) {
                    dispElClean.innerHTML = fmtMXN.format(p.price) + ' <small>/ Bolsa</small>';
                }
            }
        });

        updateCartBar();
    }

    /* ══ Cart bar ══ */
    function updateCartBar() {
        var totalItems = 0, totalWeight = 0, totalPrice = 0;
        Object.values(products).forEach(function(p) {
            if (p.qty > 0) {
                totalItems += p.qty;
                totalWeight += p.weight * p.qty;
                totalPrice += p.price * p.qty;
            }
        });
        var el;
        el = document.getElementById('barItems');        if (el) el.textContent = totalItems;
        el = document.getElementById('barWeight');       if (el) el.textContent = totalWeight.toFixed(1) + ' kg';
        el = document.getElementById('barTotal');        if (el) el.textContent = fmtMXN.format(totalPrice);
        el = document.getElementById('kpiProductCount'); if (el) el.textContent = totalItems;
        var bar = document.getElementById('cartBar');
        if (bar) bar.classList.toggle('visible', totalItems > 0);
    }

    /* ══ Order modal ══ */
    function prepareOrderModal() {
        var tbody = document.getElementById('orderSummaryBody');
        if (!tbody) return;
        tbody.innerHTML = '';
        var total = 0, totalWeight = 0;
        Object.values(products).forEach(function(p) {
            if (p.qty <= 0) return;
            var sub = p.price * p.qty;
            total += sub;
            totalWeight += p.weight * p.qty;
            var tr = document.createElement('tr');
            var offerTag = (p.isOffer || p.isExtra)
                ? '<span class="offer-tag">' + (p.isOffer ? 'OFERTA' : 'EXTRA') + '</span>' : '';
            var ivaTag = (!p.isOffer && !p.isExtra && p.ivaApplied)
                ? '<span class="offer-tag" style="background:#d9770622;color:#d97706;">IVA 16%</span>' : '';
            var nameHtml = p.name.indexOf('OFF') !== -1
                ? p.name.replace(/\u2014\s*(\d+%\s*OFF)/, '\u2014 <span class="offer-tag">$1</span>') : p.name;
            tr.innerHTML =
                '<td>' + nameHtml + ' ' + offerTag + ' ' + ivaTag + '</td>' +
                '<td style="text-align:center;">' + p.qty + '</td>' +
                '<td style="text-align:right;">' + fmtMXN.format(p.price) + '</td>' +
                '<td style="text-align:right;">' + fmtMXN.format(sub) + '</td>';
            tbody.appendChild(tr);
        });
        var trTotal = document.createElement('tr');
        trTotal.className = 'row-total';
        trTotal.innerHTML = '<td>TOTAL</td><td></td><td></td><td style="text-align:right;">' + fmtMXN.format(total) + '</td>';
        tbody.appendChild(trTotal);
        validateAutos(totalWeight);
        validateCredit(total);
    }

    function validateAutos(weight) {
        var sel = document.getElementById('auto');
        if (!sel) return;
        var disabledCount = 0;
        for (var i = 1; i < sel.options.length; i++) {
            var opt = sel.options[i];
            var a = autosData.find(function(x) { return x.id == opt.value; });
            if (a && a.capacidad < weight) {
                opt.disabled = true;
                if (opt.text.indexOf('\u26A0') === -1) opt.text += ' \u26A0 Excede peso';
                disabledCount++;
            } else {
                opt.disabled = false;
                opt.text = opt.text.replace(' \u26A0 Excede peso', '');
            }
        }
        if (disabledCount > 0 && disabledCount >= sel.options.length - 1) {
            Swal.fire({ icon: 'warning', title: 'Peso excedido', text: 'Ningún vehículo tiene capacidad suficiente.', confirmButtonColor: '#2563eb' });
        }
    }

    function validateCredit(total) {
        var sel = document.getElementById('tipoPago');
        if (!sel || sel.options.length < 2) return;
        var opt = sel.options[1];
        if (total > CREDIT_LIMIT) {
            opt.disabled = true;
            opt.textContent = 'Crédito \u2014 Insuficiente ($' + CREDIT_LIMIT.toFixed(2) + ')';
        } else {
            opt.disabled = false;
            opt.textContent = 'Crédito';
        }
    }

    /* ══ Submit order ══ */
    async function submitOrder() {
        var btn = document.getElementById('btnSubmitOrder');
        if (btn) { btn.disabled = true; btn.innerHTML = '<span class="material-icons-outlined" style="animation:spin 1s linear infinite;">sync</span> Procesando...'; }
        try {
            var inputsPayload = [];
            Object.values(products).forEach(function(p) {
                if (p.qty > 0 || !p.isOffer) {
                    var legacyId = p.id;
                    if (typeof p.id === 'string') {
                        if (p.id.indexOf('extra_') === 0) legacyId = parseInt('121266' + p.id.replace('extra_', ''));
                        else if (p.id.indexOf('offer_') === 0) legacyId = parseInt('121209' + p.id.replace('offer_', ''));
                    }
                    inputsPayload.push({
                        id: legacyId,
                        name: p.name,
                        price: p.price,
                        peso: p.weight,
                        quantity: p.qty,
                        aplica_iva: (!p.isOffer && !p.isExtra && p.ivaApplied) ? 1 : 0
                    });
                }
            });
            var fd = new FormData();
            fd.append('productos', JSON.stringify(inputsPayload));
            fd.append('accion', 'alta');
            fd.append('id_cliente', CLIENT_ID);
            fd.append('id_veiculo', document.getElementById('auto').value);
            fd.append('id_price_list', PRICE_LIST_ID);
            fd.append('fecha_entrega', new Date().toISOString().split('T')[0]);
            fd.append('tiempo_entrega', '10');
            fd.append('detalles', 'Orden generada desde panel');
            fd.append('tipo_pago', document.getElementById('tipoPago').value);
            fd.append('correo', 'NA');
            fd.append('recolector', document.getElementById('recolector').value);
            fd.append('uso_bascula', document.getElementById('usoBascula').value);
            var res = await fetch('api/apiOrdenes.php', { method: 'POST', body: fd });
            if (!res.ok) throw new Error('Error HTTP ' + res.status);
            var data = await res.json();
            Swal.fire({ title: data.mensaje || 'Operación realizada', icon: data.tipo || 'info', confirmButtonColor: '#059669', confirmButtonText: 'Aceptar' })
                .then(function(result) { if (result.isConfirmed && data.tipo === 'success') window.location.href = 'moderacion.php?id=' + data.id + '&directo=si'; });
        } catch (err) {
            console.error(err);
            Swal.fire({ icon: 'error', title: 'Error', text: err.message || 'No se pudo procesar la orden.', confirmButtonColor: '#dc2626' });
        } finally {
            if (btn) { btn.disabled = false; btn.innerHTML = '<span class="material-icons-outlined">check_circle</span> Confirmar Orden'; }
        }
    }

    /* ══ Search & Filters ══ */
    var currentFilter = 'all';

    function filterProducts(filter, el) {
        currentFilter = filter;
        document.querySelectorAll('.of-filter-btn').forEach(function(b) { b.classList.remove('active'); });
        el.classList.add('active');
        applyFilters();
    }

    function applyFilters() {
        var searchEl = document.getElementById('searchProducts');
        var query = searchEl ? searchEl.value.toLowerCase().trim() : '';
        var cards = document.querySelectorAll('.of-product');
        var visible = 0;
        cards.forEach(function(card) {
            var name = card.dataset.name || '';
            var hasOffer = card.dataset.hasOffer === '1';
            var id = parseInt(card.dataset.productId);
            var inCart = products[id] && products[id].qty > 0;
            var show = true;
            if (query && name.indexOf(query) === -1) show = false;
            if (currentFilter === 'offer' && !hasOffer) show = false;
            if (currentFilter === 'inCart' && !inCart) show = false;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        var noRes = document.getElementById('noResults');
        if (noRes) noRes.classList.toggle('show', visible === 0);
    }

    function setView(mode, el) {
        document.querySelectorAll('.of-view-toggle button').forEach(function(b) { b.classList.remove('active'); });
        el.classList.add('active');
        var grid = document.getElementById('productsGrid');
        if (grid) grid.classList.toggle('list-view', mode === 'list');
    }

    /* ══ Stock loading ══ */
    async function loadStock(napersId) {
        var badge = document.getElementById('stock-' + napersId);
        if (!badge) return;
        try {
            var res = await fetch('https://croram.naperz.mx/api/croram/products/' + napersId + '?key=cDkGWH6-VFpg8myZAI.0F3ozzx0B_GLZ2qiUB1hq&page=1&pageSize=100');
            var data = await res.json();
            if (data.status === 200 && data.item) {
                var qty = data.item.availableQuantity;
                badge.innerHTML = '<span class="material-icons-outlined" style="font-size:.8rem;">inventory_2</span> ' + qty;
                if (qty < 200) badge.classList.add('low');
                if (qty < 1) {
                    badge.classList.add('out');
                    badge.innerHTML = '<span class="material-icons-outlined" style="font-size:.8rem;">block</span> Agotado';
                    var card = badge.closest('.of-product');
                    if (card) card.classList.add('disabled-card');
                }
            } else { badge.textContent = 'N/D'; }
        } catch (e) { badge.textContent = 'Error'; }
    }
    </script>

    <!-- ═══════════════════════════════════════════
         BLOCK 2: Data from PHP (json_encode only).
         Isolated — if this breaks, functions above survive.
    ═══════════════════════════════════════════ -->
    <?php if ($clienteSeleccionado): ?>
    <script>
    try {
        CLIENT_ID = <?php echo json_encode($id); ?>;
        PRICE_LIST_ID = <?php echo json_encode($id_price_list); ?>;
        CREDIT_LIMIT = <?php echo json_encode($credito); ?>;

        autosData = <?php
            $autosArr = [];
            foreach ($autos as $a) {
                $autosArr[] = [
                    'id' => intval($a->id),
                    'marca' => $a->marca,
                    'modelo' => $a->modelo,
                    'placas' => $a->placas,
                    'capacidad' => floatval($a->capacidad_kg)
                ];
            }
            echo json_encode($autosArr, JSON_UNESCAPED_UNICODE);
        ?>;

        /* Build products map via single json_encode — safe for any characters */
        var _rawProducts = <?php
            $prodMap = [];
            foreach ($productos as $producto) {
                if (!is_object($producto)) continue;
                if (intval($producto->id ?? 0) == 24) continue;
                if (intval($producto->estatus ?? 0) == 0) continue;

                $precio = 0;
                $precioSet = null;
                if (isset($adminSets) && method_exists($adminSets, 'dameSetItemComplex')) {
                    try { $precioSet = @$adminSets->dameSetItemComplex($usuario->id_set, $producto->id); }
                    catch (Exception $e) { $precioSet = null; }
                }

                foreach ($precios as $p) {
                    if (isset($p->productId) && $p->productId == ($producto->id_napers ?? null)) {
                        $precio = floatval($p->fixedPrice ?? 0);
                    }
                    if (is_object($precioSet) && isset($precioSet->id_producto)
                        && $precioSet->id_producto == $producto->id) {
                        $precio = floatval($precioSet->precio_set ?? 0);
                    }
                }
                if ($precio == 0) continue;

                // Oferta invertida
                $ofertaProd = null;
                if (isset($adminOfertas) && method_exists($adminOfertas, 'dameOfertaProductoInvertidaFecha')) {
                    try { $ofertaProd = @$adminOfertas->dameOfertaProductoInvertidaFecha($producto->id, date("Y-m-d")); }
                    catch (Exception $e) { $ofertaProd = null; }
                }

                // Main product
                $prodMap[strval($producto->id)] = [
                    'id' => intval($producto->id),
                    'name' => $producto->name ?? '',
                    'nameOriginal' => $producto->name ?? '',
                    'price' => floatval($precio),
                    'priceOriginal' => floatval($precio),
                    'weight' => floatval($producto->weight ?? 0),
                    'qty' => 0, 'isOffer' => false, 'isExtra' => false, 'ivaApplied' => false
                ];

                // Extra slot (price = 0)
                $prodMap['extra_' . $producto->id] = [
                    'id' => 'extra_' . $producto->id,
                    'name' => ($producto->name ?? '') . ' — Extra',
                    'nameOriginal' => ($producto->name ?? '') . ' — Extra',
                    'price' => 0, 'priceOriginal' => 0,
                    'weight' => floatval($producto->weight ?? 0),
                    'qty' => 0, 'isOffer' => false, 'isExtra' => true, 'ivaApplied' => false
                ];

                // Offer-receiving slot
                $tipoOP = (is_object($ofertaProd) && isset($ofertaProd->tipo_oferta))
                          ? intval($ofertaProd->tipo_oferta) : 0;
                if ($tipoOP === 1) {
                    $prodMap['offer_' . $producto->id] = [
                        'id' => 'offer_' . $producto->id,
                        'name' => ($producto->name ?? '') . ' — Oferta',
                        'nameOriginal' => ($producto->name ?? '') . ' — Oferta',
                        'price' => 0, 'priceOriginal' => 0,
                        'weight' => floatval($producto->weight ?? 0),
                        'qty' => 0, 'isOffer' => true, 'isExtra' => false, 'ivaApplied' => false
                    ];
                }
            }
            echo json_encode($prodMap, JSON_UNESCAPED_UNICODE);
        ?>;

        Object.keys(_rawProducts).forEach(function(k) { products[k] = _rawProducts[k]; });

        offers = <?php
            $offersArr = [];
            if (isset($adminOfertas) && method_exists($adminOfertas, 'dameOfertaProductoFecha')) {
                foreach ($productos as $producto) {
                    if (!is_object($producto)) continue;
                    if (intval($producto->id ?? 0) == 24 || intval($producto->estatus ?? 0) == 0) continue;

                    $precio = 0;
                    foreach ($precios as $p) {
                        if (isset($p->productId) && $p->productId == ($producto->id_napers ?? null)) {
                            $precio = floatval($p->fixedPrice ?? 0);
                        }
                    }
                    if ($precio == 0) continue;

                    $ofertaSobreProd = null;
                    try { $ofertaSobreProd = @$adminOfertas->dameOfertaProductoFecha($producto->id, date("Y-m-d")); }
                    catch (Exception $e) { $ofertaSobreProd = null; }

                    $tipoOS = (is_object($ofertaSobreProd) && isset($ofertaSobreProd->tipo_oferta))
                              ? intval($ofertaSobreProd->tipo_oferta) : 0;

                    if ($tipoOS > 0) {
                        $offersArr[] = [
                            'id' => intval($ofertaSobreProd->id ?? 0),
                            'triggerProductId' => intval($producto->id),
                            'offerProductId' => ($tipoOS === 1)
                                ? 'offer_' . intval($ofertaSobreProd->id_producto_of ?? 0) : 0,
                            'triggerQty' => intval($ofertaSobreProd->cantidad_det ?? 0),
                            'discountPct' => floatval($ofertaSobreProd->porc_oferta ?? 0),
                            'offerType' => $tipoOS,
                            'offerQty' => intval($ofertaSobreProd->cantidad_oferta ?? 0)
                        ];
                    }
                }
            }
            echo json_encode($offersArr, JSON_UNESCAPED_UNICODE);
        ?>;

        console.log('[Croram] Data loaded:', Object.keys(products).length, 'products,', offers.length, 'offers');
    } catch (dataErr) {
        console.error('[Croram] Error parsing PHP data:', dataErr);
    }

    /* Attach event listeners */
    (function() {
        var searchEl = document.getElementById('searchProducts');
        if (searchEl) searchEl.addEventListener('input', applyFilters);

        var extrasSearchEl = document.getElementById('searchExtras');
        if (extrasSearchEl) {
            extrasSearchEl.addEventListener('input', function() {
                var q = this.value.toLowerCase().trim();
                document.querySelectorAll('#extrasTable tbody tr').forEach(function(row) {
                    var name = row.dataset.extraName || '';
                    row.style.display = (!q || name.indexOf(q) !== -1) ? '' : 'none';
                });
            });
        }

        /* Load stock with stagger */
        var stockCards = document.querySelectorAll('.of-product[data-napers-id]');
        stockCards.forEach(function(card, i) {
            setTimeout(function() { loadStock(card.dataset.napersId); }, i * 120);
        });
    })();
    </script>
    <?php endif; ?>

</body>
</html>