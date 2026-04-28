<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Sets de Precios" />
    <title>Croram Admin · Sets de Precios</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />

    <style>
    :root {
        --st-primary: #2563eb;
        --st-primary-soft: rgba(37,99,235,.07);
        --st-success: #059669;
        --st-success-soft: rgba(5,150,105,.08);
        --st-text: #1e293b;
        --st-text-secondary: #64748b;
        --st-text-muted: #94a3b8;
        --st-surface: #ffffff;
        --st-surface-alt: #f8fafc;
        --st-border: #e2e8f0;
        --st-radius: 14px;
        --st-radius-sm: 10px;
        --st-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --st-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--st-font); }

    .st-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--st-text-secondary);
    }
    .st-breadcrumb a { color: var(--st-primary); text-decoration: none; }
    .st-breadcrumb .sep { opacity: .4; }

    /* KPIs */
    .st-kpi-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .st-kpi {
        background: var(--st-surface);
        border: 1px solid var(--st-border);
        border-radius: var(--st-radius-sm);
        padding: 1rem 1.15rem;
        display: flex; flex-direction: column; gap: .15rem;
        animation: fadeIn .3s ease both;
    }
    .st-kpi-label {
        font-size: .7rem; text-transform: uppercase;
        letter-spacing: .06em; color: var(--st-text-muted); font-weight: 600;
    }
    .st-kpi-value {
        font-size: 1.35rem; font-weight: 700; color: var(--st-text); line-height: 1.2;
    }

    /* Set card */
    .st-set-card {
        background: var(--st-surface);
        border: 1px solid var(--st-border);
        border-radius: var(--st-radius);
        box-shadow: var(--st-shadow);
        margin-bottom: 1.25rem;
        overflow: hidden;
        animation: fadeIn .35s ease both;
    }
    .st-set-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--st-border);
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; flex-wrap: wrap;
        background: var(--st-surface-alt);
    }
    .st-set-header-left {
        display: flex; align-items: center; gap: .5rem;
    }
    .st-set-header-left .material-icons-outlined { font-size: 1.2rem; color: var(--st-primary); }
    .st-set-header-left h6 {
        margin: 0; font-weight: 700; font-size: .95rem; color: var(--st-text);
    }
    .st-set-count {
        font-size: .75rem; font-weight: 600;
        padding: .2rem .6rem; border-radius: 999px;
        background: var(--st-primary-soft); color: var(--st-primary);
    }
    .st-set-body { padding: 0; }

    /* Table */
    .st-table {
        width: 100%; border-collapse: separate; border-spacing: 0; font-size: .85rem;
    }
    .st-table thead th {
        background: var(--st-surface-alt); padding: .6rem 1.25rem;
        font-weight: 600; color: var(--st-text-secondary);
        font-size: .73rem; text-transform: uppercase;
        letter-spacing: .04em; border-bottom: 1px solid var(--st-border);
    }
    .st-table tbody td {
        padding: .55rem 1.25rem; border-bottom: 1px solid var(--st-border);
        color: var(--st-text); vertical-align: middle;
    }
    .st-table tbody tr:last-child td { border-bottom: none; }
    .st-table tbody tr:hover { background: var(--st-primary-soft); }

    /* Price display */
    .st-price {
        font-weight: 700; color: var(--st-success);
        font-variant-numeric: tabular-nums;
    }

    /* Button */
    .st-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1.1rem; border-radius: var(--st-radius-sm);
        font-size: .82rem; font-weight: 600; font-family: var(--st-font);
        cursor: pointer; border: none; transition: all .2s;
        text-decoration: none; white-space: nowrap;
    }
    .st-btn .material-icons-outlined { font-size: 1rem; }
    .st-btn-primary { background: var(--st-primary); color: #fff; }
    .st-btn-primary:hover { background: #1d4ed8; color: #fff; }

    /* Empty state */
    .st-empty {
        text-align: center; padding: 2rem 1rem; color: var(--st-text-muted); font-size: .85rem;
    }
    .st-empty .material-icons-outlined {
        font-size: 2.5rem; display: block; margin-bottom: .5rem; opacity: .35;
    }

    /* Search */
    .st-search-box {
        position: relative; max-width: 320px;
    }
    .st-search-box input {
        width: 100%; padding: .55rem 1rem .55rem 2.5rem;
        border: 1px solid var(--st-border); border-radius: var(--st-radius-sm);
        font-size: .85rem; font-family: var(--st-font);
        transition: border-color .2s, box-shadow .2s;
    }
    .st-search-box input:focus {
        outline: none; border-color: var(--st-primary);
        box-shadow: 0 0 0 3px var(--st-primary-soft);
    }
    .st-search-box .search-icon {
        position: absolute; left: .8rem; top: 50%;
        transform: translateY(-50%); font-size: 1.1rem;
        color: var(--st-text-muted); pointer-events: none;
    }

    /* Toolbar */
    .st-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; flex-wrap: wrap; margin-bottom: 1.25rem;
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
    include_once "api/adminSets.php";
    $adminSets = new AdministradorSets();
    $sets = $adminSets->dameSetVendedor();
    if (!is_array($sets)) $sets = [];

    // KPIs
    $totalSets = count($sets);
    $totalItems = 0;

    // Pre-load items for each set
    $setsData = [];
    foreach ($sets as $set) {
        if (!is_object($set)) continue;
        $items = $adminSets->dameSetItemPorSet($set->id);
        if (!is_array($items)) $items = [];
        $totalItems += count($items);
        $setsData[] = ['set' => $set, 'items' => $items];
    }
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="st-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span>Catálogos</span>
                    <span class="sep">/</span>
                    <span style="color:var(--st-text);font-weight:600;">Sets de Precios</span>
                </div>

                <!-- KPIs -->
                <div class="st-kpi-row">
                    <div class="st-kpi" style="animation-delay:.05s;">
                        <span class="st-kpi-label">Total sets</span>
                        <span class="st-kpi-value"><?php echo $totalSets; ?></span>
                    </div>
                    <div class="st-kpi" style="animation-delay:.1s;">
                        <span class="st-kpi-label">Total productos en sets</span>
                        <span class="st-kpi-value"><?php echo $totalItems; ?></span>
                    </div>
                </div>

                <!-- Toolbar -->
                <div class="st-toolbar">
                    <div class="st-search-box">
                        <span class="material-icons-outlined search-icon">search</span>
                        <input type="text" id="searchSets" placeholder="Buscar set por nombre..." autocomplete="off" />
                    </div>
                    <a href="sets-form.php" class="st-btn st-btn-primary">
                        <span class="material-icons-outlined">add_circle</span>
                        Agregar set de precios
                    </a>
                </div>

                <?php if (empty($setsData)): ?>
                <div class="st-set-card">
                    <div class="st-empty">
                        <span class="material-icons-outlined">price_change</span>
                        <p>No hay sets de precios registrados.</p>
                        <a href="sets-form.php" class="st-btn st-btn-primary" style="margin-top:.5rem;">
                            <span class="material-icons-outlined">add_circle</span>
                            Crear primer set
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Set Cards -->
                <?php
                $setIndex = 0;
                foreach ($setsData as $data):
                    $set   = $data['set'];
                    $items = $data['items'];
                    $delay = min($setIndex * 0.08, 0.6);
                    $setIndex++;
                    $safeName = htmlspecialchars($set->nombre ?? '', ENT_QUOTES, 'UTF-8');
                ?>
                <div class="st-set-card" data-set-name="<?php echo htmlspecialchars(mb_strtolower($set->nombre ?? '', 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>"
                     style="animation-delay:<?php echo $delay; ?>s;">
                    <div class="st-set-header">
                        <div class="st-set-header-left">
                            <span class="material-icons-outlined">price_change</span>
                            <h6><?php echo $safeName; ?></h6>
                        </div>
                        <span class="st-set-count">
                            <?php echo count($items); ?> producto<?php echo count($items) !== 1 ? 's' : ''; ?>
                        </span>
                    </div>
                    <div class="st-set-body">
                        <?php if (empty($items)): ?>
                        <div class="st-empty" style="padding:1.5rem;">
                            <span class="material-icons-outlined" style="font-size:1.8rem;">inbox</span>
                            <p>Este set no tiene productos asignados.</p>
                        </div>
                        <?php else: ?>
                        <table class="st-table">
                            <thead>
                                <tr>
                                    <th style="width:60%;">Producto</th>
                                    <th style="width:40%;text-align:right;">Precio del set</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item):
                                    if (!is_object($item)) continue;
                                    $itemName  = htmlspecialchars($item->name ?? '—', ENT_QUOTES, 'UTF-8');
                                    $itemPrice = floatval($item->precio_set ?? 0);
                                ?>
                                <tr>
                                    <td><strong><?php echo $itemName; ?></strong></td>
                                    <td style="text-align:right;">
                                        <span class="st-price">$<?php echo number_format($itemPrice, 2); ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
        <?php include 'partials/footer.php'; ?>
    </main>

    <?php include "partials/theme.php"; ?>

    <!-- Scripts -->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>

    <script>
    /* ══ Search sets ══ */
    document.getElementById('searchSets').addEventListener('input', function() {
        var query = this.value.toLowerCase().trim();
        var cards = document.querySelectorAll('.st-set-card[data-set-name]');
        var visible = 0;

        cards.forEach(function(card) {
            var name = card.dataset.setName || '';
            var show = !query || name.indexOf(query) !== -1;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
    });
    </script>

</body>
</html>