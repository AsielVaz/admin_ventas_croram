<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Croram Admin · Detalle de Cliente</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />

    <style>
    :root {
        --uv-primary: #2563eb; --uv-primary-soft: rgba(37,99,235,.07);
        --uv-success: #059669; --uv-success-soft: rgba(5,150,105,.08);
        --uv-danger: #dc2626; --uv-danger-soft: rgba(220,38,38,.07);
        --uv-warning: #d97706; --uv-warning-soft: rgba(217,119,6,.08);
        --uv-info: #0284c7; --uv-info-soft: rgba(2,132,199,.08);
        --uv-text: #1e293b; --uv-text-secondary: #64748b; --uv-text-muted: #94a3b8;
        --uv-surface: #ffffff; --uv-surface-alt: #f8fafc;
        --uv-border: #e2e8f0; --uv-radius: 14px; --uv-radius-sm: 10px;
        --uv-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --uv-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--uv-font); }

    .uv-breadcrumb { display: flex; align-items: center; gap: .75rem; margin-bottom: 1.5rem; font-size: .85rem; color: var(--uv-text-secondary); }
    .uv-breadcrumb a { color: var(--uv-primary); text-decoration: none; }
    .uv-breadcrumb .sep { opacity: .4; }

    .uv-card { background: var(--uv-surface); border: 1px solid var(--uv-border); border-radius: var(--uv-radius); box-shadow: var(--uv-shadow); overflow: hidden; margin-bottom: 1.25rem; }
    .uv-card-header { padding: 1rem 1.5rem; border-bottom: 1px solid var(--uv-border); display: flex; align-items: center; gap: .5rem; font-weight: 600; font-size: .95rem; color: var(--uv-text); background: var(--uv-surface-alt); }
    .uv-card-header .material-icons-outlined { font-size: 1.2rem; color: var(--uv-primary); }
    .uv-card-body { padding: 1.25rem 1.5rem; }

    .uv-kpi-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 1.25rem; }
    .uv-kpi { background: var(--uv-surface); border: 1px solid var(--uv-border); border-radius: var(--uv-radius-sm); padding: 1rem 1.15rem; display: flex; flex-direction: column; gap: .15rem; }
    .uv-kpi-label { font-size: .7rem; text-transform: uppercase; letter-spacing: .06em; color: var(--uv-text-muted); font-weight: 600; }
    .uv-kpi-value { font-size: 1.2rem; font-weight: 700; color: var(--uv-text); line-height: 1.2; }

    /* Tabs */
    .uv-tabs { display: flex; gap: .25rem; border-bottom: 2px solid var(--uv-border); margin-bottom: 1.25rem; flex-wrap: wrap; }
    .uv-tab { padding: .65rem 1.15rem; font-size: .85rem; font-weight: 600; color: var(--uv-text-secondary); cursor: pointer; border: none; background: none; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all .2s; display: flex; align-items: center; gap: .4rem; font-family: var(--uv-font); }
    .uv-tab:hover { color: var(--uv-primary); }
    .uv-tab.active { color: var(--uv-primary); border-bottom-color: var(--uv-primary); }
    .uv-tab .material-icons-outlined { font-size: 1rem; }

    /* Tables */
    .uv-table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: .84rem; }
    .uv-table thead th { background: var(--uv-surface-alt); padding: .6rem .85rem; font-weight: 600; color: var(--uv-text-secondary); font-size: .72rem; text-transform: uppercase; letter-spacing: .04em; border-bottom: 1px solid var(--uv-border); }
    .uv-table tbody td { padding: .55rem .85rem; border-bottom: 1px solid var(--uv-border); color: var(--uv-text); vertical-align: middle; }
    .uv-table tbody tr:hover { background: var(--uv-primary-soft); }
    .uv-table tfoot th { padding: .6rem .85rem; border-top: 2px solid var(--uv-border); }

    .insoluto-cell { position: relative; }
    .paid-stamp { margin-left: .5rem; padding: .1rem .4rem; font-size: .7rem; border: 1px solid var(--uv-success); color: var(--uv-success); border-radius: 4px; font-weight: 700; letter-spacing: .05em; }

    .detalle-wrapper { padding: .5rem 1rem 1rem; background: var(--uv-surface-alt); border-radius: 8px; margin: .25rem .5rem; }
    .subtable { font-size: .82rem; }
    .subtable th, .subtable td { white-space: nowrap; }

    /* Buttons */
    .uv-btn { display: inline-flex; align-items: center; gap: .35rem; padding: .4rem .75rem; border-radius: var(--uv-radius-sm); font-size: .78rem; font-weight: 600; font-family: var(--uv-font); cursor: pointer; border: none; transition: all .2s; text-decoration: none; white-space: nowrap; }
    .uv-btn .material-icons-outlined { font-size: .95rem; }
    .uv-btn-primary { background: var(--uv-primary); color: #fff; }
    .uv-btn-primary:hover { background: #1d4ed8; color: #fff; }
    .uv-btn-danger { background: var(--uv-danger); color: #fff; }
    .uv-btn-danger:hover { background: #b91c1c; color: #fff; }
    .uv-btn-outline { background: transparent; color: var(--uv-text-secondary); border: 1px solid var(--uv-border); }
    .uv-btn-outline:hover { border-color: var(--uv-primary); color: var(--uv-primary); }
    .uv-btn-sm { padding: .3rem .6rem; font-size: .75rem; }

    .uv-status { display: inline-flex; align-items: center; gap: .25rem; padding: .2rem .55rem; border-radius: 999px; font-size: .7rem; font-weight: 600; }
    .uv-status.cancelada { background: var(--uv-danger-soft); color: var(--uv-danger); }
    .uv-status.entregada { background: var(--uv-success-soft); color: var(--uv-success); }
    .uv-status.proceso { background: var(--uv-info-soft); color: var(--uv-info); }
    .uv-status.aprobada { background: var(--uv-warning-soft); color: var(--uv-warning); }
    .uv-status.pendiente { background: var(--uv-primary-soft); color: var(--uv-primary); }

    /* Modal tweaks */
    .modal-content { border: none; border-radius: var(--uv-radius); }
    .modal-header { border-bottom: 1px solid var(--uv-border); }
    .modal-footer { border-top: 1px solid var(--uv-border); }

    @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
    .uv-card { animation: fadeIn .35s ease both; }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    // ═══ Original PHP data loading — ALL methods preserved ═══
    include_once "api/adminOrdenes.php";
    include_once "api/adminAutos.php";
    include_once "api/adminUsuarios.php";
    include_once "api/adminPagos.php";

    $adminOrdenes  = new AdministradorOrdenes();
    $adminUsuarios = new AdministradorUsuarios();
    $adminAutos    = new AdministradorAutos();
    $adminPagos    = new AdministradorPagos();

    $userId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $ordenes              = $adminOrdenes->dameOrdenesDeUsuarioCompuestos($userId);
    $ordenesComplex       = $adminOrdenes->dameOrdenesDeUsuarioCompuestosComplex($userId);
    $reporteVentasUsuario = $adminOrdenes->dameReporteVentasUsuario($userId);
    $pagos                = $adminPagos->obtenerPagosDeUsuario($userId);
    $autos                = $adminAutos->obtenerAutosCliente($userId);
    $cliente              = $adminUsuarios->dameUsuario($userId);

    if (!is_array($ordenes))        $ordenes = [];
    if (!is_array($ordenesComplex)) $ordenesComplex = [];
    if (!is_array($pagos))          $pagos = [];
    if (!is_array($autos))          $autos = [];
    $pagosActivos = array_filter($pagos, function($p) { return intval($p->activo ?? 1) === 1; });

    // Original helper function
    function diasDiferencia(string $fecha): int {
        $hoy = new DateTime('today');
        $fechaComparar = new DateTime($fecha);
        $diff = $hoy->diff($fechaComparar);
        $dias = (int)$diff->format('%r%a');
        return $dias;
    }

    $fmtMoney = function ($v) { return '$' . number_format((float)$v, 2, '.', ','); };
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="uv-breadcrumb">
                    <a href="index.php">Inicio</a><span class="sep">/</span>
                    <a href="usuarios.php">Usuarios</a><span class="sep">/</span>
                    <span style="color:var(--uv-text);font-weight:600;"><?php echo htmlspecialchars($cliente->nombre ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>

                <!-- KPIs -->
                <div class="uv-kpi-row">
                    <div class="uv-kpi">
                        <span class="uv-kpi-label">Cliente</span>
                        <span class="uv-kpi-value" style="font-size:1rem;"><?php echo htmlspecialchars($cliente->nombre ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                    <div class="uv-kpi">
                        <span class="uv-kpi-label">Órdenes</span>
                        <span class="uv-kpi-value"><?php echo count($ordenesComplex); ?></span>
                    </div>
                    <div class="uv-kpi">
                        <span class="uv-kpi-label">Pagos registrados</span>
                        <span class="uv-kpi-value"><?php echo count($pagosActivos); ?></span>
                    </div>
                    <div class="uv-kpi">
                        <span class="uv-kpi-label">Vehículos</span>
                        <span class="uv-kpi-value"><?php echo count($autos); ?></span>
                    </div>
                </div>

                <!-- Tabs Card -->
                <div class="uv-card">
                    <div class="uv-card-body" style="padding-bottom:0;">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#tab-ordenes" style="font-family:var(--uv-font);font-weight:600;font-size:.85rem;display:flex;align-items:center;gap:.35rem;"><span class="material-icons-outlined" style="font-size:1rem;">receipt_long</span> Órdenes</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#tab-pagos" style="font-family:var(--uv-font);font-weight:600;font-size:.85rem;display:flex;align-items:center;gap:.35rem;"><span class="material-icons-outlined" style="font-size:1rem;">payments</span> Pagos</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#tab-autos" style="font-family:var(--uv-font);font-weight:600;font-size:.85rem;display:flex;align-items:center;gap:.35rem;"><span class="material-icons-outlined" style="font-size:1rem;">local_shipping</span> Vehículos</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#tab-data" style="font-family:var(--uv-font);font-weight:600;font-size:.85rem;display:flex;align-items:center;gap:.35rem;"><span class="material-icons-outlined" style="font-size:1rem;">bar_chart</span> Estadísticas</a></li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <!-- ═══════ TAB: ÓRDENES ═══════ -->
                        <div class="tab-pane fade show active" id="tab-ordenes">
                            <div style="padding:0 1.5rem 1.5rem;">
                                <div class="table-responsive">
                                    <table class="uv-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th><th>Vehículo</th><th>Fecha entrega</th><th>Tiempo</th>
                                                <th>Vendedor</th><th>Pagado</th><th>Insoluto</th><th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cuentaAtraso = 0;
                                            $cuentaCorriente = 0;

                                            foreach ($ordenesComplex as $orden) {
                                                $diferenciaDias = diasDiferencia($orden->fecha_inserta);

                                                if ((int)$orden->estatus != 9) {
                                                    if ($diferenciaDias < 0) {
                                                        $diasPos = $diferenciaDias * -1;
                                                        if ($diasPos >= $cliente->dias_pago) {
                                                            $cuentaAtraso += $orden->insoluto;
                                                        } else {
                                                            $cuentaCorriente += $orden->insoluto;
                                                        }
                                                    } else {
                                                        $cuentaCorriente += $orden->insoluto;
                                                    }
                                                }

                                                $auto     = $adminAutos->obtenerAuto($orden->id_veiculo);
                                                $vendedor = $adminUsuarios->dameUsuario($orden->id_crea);

                                                $insolutoVal = (float)$orden->insoluto;
                                                $estaPagado  = $insolutoVal <= 0.01;
                                                $rowId = 'det-' . (int)$orden->id;
                                                $oid = (int)$orden->id;
                                                $estatus = (int)$orden->estatus;

                                                $marca  = htmlspecialchars($auto->marca ?? '', ENT_QUOTES, 'UTF-8');
                                                $modelo = htmlspecialchars($auto->modelo ?? '', ENT_QUOTES, 'UTF-8');
                                                $placas = htmlspecialchars($auto->placas ?? '', ENT_QUOTES, 'UTF-8');
                                                $vendNom = htmlspecialchars(trim(($vendedor->nombre ?? '') . ' ' . ($vendedor->apellido ?? '')), ENT_QUOTES, 'UTF-8');
                                                $minutos = number_format(((float)$orden->tiempo_entrega / 60), 2);
                                            ?>
                                            <tr>
                                                <td><strong>#<?php echo $oid; ?></strong></td>
                                                <td><?php echo "$marca $modelo ($placas)"; ?></td>
                                                <td><?php echo htmlspecialchars($orden->fecha_entrega ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo $minutos; ?> min</td>
                                                <td><?php echo $vendNom; ?></td>
                                                <td><?php echo $fmtMoney($orden->total_pagado); ?></td>
                                                <td class="insoluto-cell">
                                                    <?php echo $fmtMoney($orden->insoluto); ?>
                                                    <?php if ($estaPagado): ?><span class="paid-stamp">PAGADO</span><?php endif; ?>
                                                </td>
                                                <td>
                                                    <div style="display:flex;gap:.3rem;align-items:center;flex-wrap:wrap;">
                                                        <?php if ($estatus == 9): ?>
                                                            <span class="uv-status cancelada">Cancelada</span>
                                                        <?php elseif ($estatus == 2): ?>
                                                            <span class="uv-status entregada">Entregada</span>
                                                        <?php elseif ($estatus == 1): ?>
                                                            <span class="uv-status proceso">En proceso</span>
                                                        <?php elseif ($estatus == 99): ?>
                                                            <button onclick="cancelarOrden(<?php echo $oid; ?>)" class="uv-btn uv-btn-danger uv-btn-sm">Cancelar</button>
                                                        <?php else: ?>
                                                            <a href="moderacion.php?id=<?php echo $oid; ?>" class="uv-btn uv-btn-primary uv-btn-sm">Editar</a>
                                                            <button onclick="cancelarOrden(<?php echo $oid; ?>)" class="uv-btn uv-btn-danger uv-btn-sm">Cancelar</button>
                                                        <?php endif; ?>
                                                        <button class="uv-btn uv-btn-outline uv-btn-sm" onclick="toggleDetalle('<?php echo $rowId; ?>')">Pagos</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Sub-row: pagos de esta orden -->
                                            <?php $pagosOrden = $adminPagos->dameRelPagoPorOrden($orden->id); ?>
                                            <tr id="<?php echo $rowId; ?>" style="display:none;">
                                                <td colspan="8" style="padding:0;">
                                                    <div class="detalle-wrapper">
                                                        <table class="table table-sm table-striped subtable mb-0">
                                                            <thead><tr><th>ID pago</th><th>Monto original</th><th>Saldo acreditable</th></tr></thead>
                                                            <tbody>
                                                                <?php if (count($pagosOrden) === 0): ?>
                                                                <tr><td colspan="3" class="text-center text-muted">Sin pagos registrados</td></tr>
                                                                <?php else: ?>
                                                                <?php foreach ($pagosOrden as $pago): ?>
                                                                <tr>
                                                                    <td>#<?php echo intval($pago->id_pago ?? 0); ?></td>
                                                                    <td><?php echo $fmtMoney($pago->monto_pago ?? 0); ?></td>
                                                                    <td><?php echo $fmtMoney($pago->monto_acreditado ?? 0); ?></td>
                                                                </tr>
                                                                <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr><th colspan="5" style="text-align:right;">Saldo corriente</th><th colspan="3" style="color:var(--uv-warning);">$<?php echo number_format($cuentaCorriente, 2); ?></th></tr>
                                            <tr><th colspan="5" style="text-align:right;">Saldo atrasado</th><th colspan="3" style="color:var(--uv-danger);">$<?php echo number_format($cuentaAtraso, 2); ?></th></tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ═══════ TAB: PAGOS ═══════ -->
                        <div class="tab-pane fade" id="tab-pagos">
                            <div style="padding:0 1.5rem 1.5rem;">
                                <div class="d-flex justify-content-end mb-3">
                                    <button class="uv-btn uv-btn-primary" data-bs-toggle="modal" data-bs-target="#agregarPagoModal">
                                        <span class="material-icons-outlined">add_circle</span> Agregar pago
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="uv-table">
                                        <thead><tr><th>ID</th><th>Monto</th><th>Orden</th><th>Evidencia</th><th>Fecha</th><th>ID Napers</th><th>Estatus</th><th>Acciones</th></tr></thead>
                                        <tbody>
                                            <?php foreach ($pagos as $pago):
                                                $pagoActivo = intval($pago->activo ?? 1) === 1;
                                                $pagoId = intval($pago->id ?? 0);
                                            ?>
                                            <tr id="pago-row-<?php echo $pagoId; ?>" class="<?php echo $pagoActivo ? '' : 'table-light text-muted'; ?>">
                                                <td><strong>#<?php echo $pagoId; ?></strong></td>
                                                <td style="font-weight:700;color:var(--uv-success);">$<?php echo number_format(floatval($pago->monto ?? 0), 2); ?></td>
                                                <td>#<?php echo intval($pago->id_orden ?? 0); ?></td>
                                                <td><?php if (!empty($pago->url_ev)): ?><a href="<?php echo htmlspecialchars($pago->url_ev, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="uv-btn uv-btn-outline uv-btn-sm"><span class="material-icons-outlined">visibility</span> Ver</a><?php else: ?>—<?php endif; ?></td>
                                                <td><?php echo htmlspecialchars($pago->fecha_inserta ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($pago->id_napers ?? '—', ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ═══════ TAB: VEHÍCULOS ═══════ -->
                        <div class="tab-pane fade" id="tab-autos">
                            <div style="padding:0 1.5rem 1.5rem;">
                                <div class="table-responsive">
                                    <table class="uv-table">
                                        <thead><tr><th>ID</th><th>Marca</th><th>Modelo</th><th>Color</th><th>Capacidad</th><th>Placas</th><th>Tipo</th></tr></thead>
                                        <tbody>
                                            <?php foreach ($autos as $auto): ?>
                                            <tr>
                                                <td>#<?php echo intval($auto->id ?? 0); ?></td>
                                                <td><strong><?php echo htmlspecialchars($auto->marca ?? '', ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                                <td><?php echo htmlspecialchars($auto->modelo ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($auto->color ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo number_format(floatval($auto->capacidad_kg ?? 0), 0); ?> kg</td>
                                                <td style="font-weight:700;letter-spacing:.03em;"><?php echo htmlspecialchars($auto->placas ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($auto->tipo ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ═══════ TAB: ESTADÍSTICAS ═══════ -->
                        <div class="tab-pane fade" id="tab-data">
                            <div style="padding:0 1.5rem 1.5rem;">
                                <div id="estUsuario" style="min-height:400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include 'partials/footer.php'; ?>
    </main>

    <?php include "partials/theme.php"; ?>

    <!-- ═══ Modal: Agregar Pago (original logic preserved) ═══ -->
    <div class="modal fade" id="agregarPagoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-weight:700;display:flex;align-items:center;gap:.5rem;">
                        <span class="material-icons-outlined" style="color:var(--uv-primary);">payments</span> Agregar pago
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formAgregarPago" novalidate>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="monto" class="form-label" style="font-weight:600;font-size:.82rem;">Monto total a pagar</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="monto" name="monto" placeholder="0.00" step="0.01" min="0" required>
                            </div>
                            <div class="form-text" id="ayudaSobrante">Sobrante por asignar: $0.00</div>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_pago" class="form-label" style="font-weight:600;font-size:.82rem;">Fecha del pago</label>
                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                        </div>
                        <div class="mb-3">
                            <label for="metodo_pago" class="form-label" style="font-weight:600;font-size:.82rem;">Método de pago</label>
                            <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                <option value="" selected disabled>Selecciona un método</option>
                                <option value="1">Cheque</option>
                                <option value="2">Efectivo</option>
                                <option value="3">Transferencia</option>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle" style="font-size:.84rem;">
                                <thead class="table-light">
                                    <tr><th style="width:60px;">Sel</th><th>ID</th><th>Total</th><th>Pagado</th><th class="text-end">Insoluto</th><th style="width:220px;">Monto a aplicar</th></tr>
                                </thead>
                                <tbody id="tbodyOrdenes">
                                    <?php foreach ($ordenes as $orden):
                                        $ordenId = (int)$orden->id;
                                        $totalFmt = number_format((float)$orden->insoluto, 2, '.', '');
                                    ?>
                                    <tr data-orden-id="<?php echo $ordenId; ?>" data-total="<?php echo $totalFmt; ?>">
                                        <td><input class="form-check-input chk-orden" type="checkbox"></td>
                                        <td>#<?php echo $ordenId; ?></td>
                                        <td>$<?php echo htmlspecialchars($orden->total_orden ?? '0', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>$<?php echo htmlspecialchars($orden->total_pagado ?? '0', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-end">$<span class="total-orden"><?php echo $totalFmt; ?></span></td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control input-monto-orden" placeholder="0.00" step="0.01" min="0">
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr><th colspan="4" class="text-end">Suma aplicada:</th><th colspan="2">$<span id="sumaMontos">0.00</span></th></tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="alert alert-danger d-none" id="alertaExceso">La suma aplicada no puede exceder el monto total.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:var(--uv-radius-sm);">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnGuardar" style="border-radius:var(--uv-radius-sm);">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ═══ Scripts ═══ -->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/theme-customizer-init.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    /* ══ Toggle detail rows (original) ══ */
    function toggleDetalle(rowId) {
        var tr = document.getElementById(rowId);
        if (!tr) return;
        tr.style.display = (tr.style.display === 'none' || tr.style.display === '') ? 'table-row' : 'none';
    }

    /* ══ Cancel order (original) ══ */
    function cancelarOrden(id) {
        Swal.fire({
            title: '¿Cancelar esta orden?', text: 'No se puede revertir.', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, cancelar', cancelButtonText: 'No'
        }).then(function(result) {
            if (!result.isConfirmed) return;
            var fd = new FormData();
            fd.append('id', id); fd.append('accion', 'rechazar');
            fetch('api/apiOrdenes.php', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.tipo == 'success') { Swal.fire({ title: 'Cancelada', icon: 'success', timer: 1500, showConfirmButton: false }).then(function() { location.reload(); }); }
                    else { Swal.fire({ icon: 'error', title: 'Error', confirmButtonColor: '#dc2626' }); }
                });
        });
    }

    /* ══ Payment modal logic (original — complete) ══ */
    function eliminarPago(id, monto) {
        Swal.fire({
            title: 'Eliminar pago #' + id,
            text: 'Se desactivara el pago por $' + monto + ' y se cancelara en Naperz si tiene ID remoto.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No'
        }).then(function(result) {
            if (!result.isConfirmed) return;
            var fd = new FormData();
            fd.append('id', id);
            fd.append('accion', 'baja');
            fetch('api/apiPagos.php', { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.tipo === 'success') {
                        Swal.fire({ title: 'Pago desactivado', icon: 'success', timer: 1500, showConfirmButton: false }).then(function() { location.reload(); });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: data.mensaje || 'No se pudo desactivar el pago.', confirmButtonColor: '#dc2626' });
                    }
                })
                .catch(function(err) {
                    console.error(err);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo desactivar el pago.', confirmButtonColor: '#dc2626' });
                });
        });
    }

    (function() {
        document.querySelectorAll('#tab-pagos tbody tr[id^="pago-row-"]').forEach(function(row) {
            var id = parseInt(row.id.replace('pago-row-', ''), 10);
            var inactive = row.classList.contains('text-muted');
            var amountCell = row.children[1];
            var monto = amountCell ? amountCell.textContent.replace('$', '').trim() : '0.00';
            var status = document.createElement('td');
            status.innerHTML = '<span class="uv-status ' + (inactive ? 'cancelada' : 'entregada') + '">' + (inactive ? 'Desactivado' : 'Activo') + '</span>';
            var actions = document.createElement('td');
            var button = document.createElement('button');
            button.type = 'button';
            button.className = inactive ? 'uv-btn uv-btn-outline uv-btn-sm' : 'uv-btn uv-btn-danger uv-btn-sm';
            button.disabled = inactive;
            button.innerHTML = inactive
                ? 'No seleccionable'
                : '<span class="material-icons-outlined">delete</span> Eliminar';
            if (!inactive) {
                button.addEventListener('click', function() {
                    eliminarPago(id, monto);
                });
            }
            actions.appendChild(button);
            row.appendChild(status);
            row.appendChild(actions);
        });
    })();

    (function() {
        var $form = document.getElementById('formAgregarPago');
        var $monto = document.getElementById('monto');
        var $tbody = document.getElementById('tbodyOrdenes');
        var $sumaMontos = document.getElementById('sumaMontos');
        var $alertaExceso = document.getElementById('alertaExceso');
        var $ayudaSobrante = document.getElementById('ayudaSobrante');
        var $btnGuardar = document.getElementById('btnGuardar');
        var $metodo = document.getElementById('metodo_pago');
        var $fechaPago = document.getElementById('fecha_pago');

        var money = function(n) { return (isFinite(n) ? parseFloat(n).toFixed(2) : '0.00'); };

        function getTotalPago() { return parseFloat($monto.value || 0); }

        function getSumaMontos() {
            var suma = 0;
            $tbody.querySelectorAll('.input-monto-orden').forEach(function(inp) {
                var v = parseFloat(inp.value || 0);
                if (isFinite(v)) suma += v;
            });
            return suma;
        }

        function updateResumen() {
            var total = getTotalPago();
            var suma = getSumaMontos();
            var sobrante = Math.max(0, total - suma);
            $sumaMontos.textContent = money(suma);
            $ayudaSobrante.textContent = 'Sobrante por asignar: $' + money(sobrante);
            var excede = suma - total > 1e-9;
            $alertaExceso.classList.toggle('d-none', !excede);
            $btnGuardar.disabled = excede || total <= 0 || !$metodo.value;
        }

        function autoFillRow(row) {
            var totalOrden = parseFloat(row.dataset.total || 0);
            var inputMonto = row.querySelector('.input-monto-orden');
            var total = getTotalPago();
            var sumaActual = getSumaMontos();
            var previo = parseFloat(inputMonto.value || 0);
            var sobranteConAjuste = Math.max(0, total - (sumaActual - previo));
            var montoAuto = Math.min(totalOrden, sobranteConAjuste);
            inputMonto.value = montoAuto > 0 ? money(montoAuto) : '';
        }

        $tbody.addEventListener('change', function(e) {
            var chk = e.target.closest('.chk-orden');
            if (chk) {
                var row = chk.closest('tr');
                var inputMonto = row.querySelector('.input-monto-orden');
                if (chk.checked) { autoFillRow(row); } else { inputMonto.value = ''; }
                updateResumen();
            }
        });

        $tbody.addEventListener('input', function(e) {
            var inp = e.target.closest('.input-monto-orden');
            if (inp) {
                var row = inp.closest('tr');
                var totalOrden = parseFloat(row.dataset.total || 0);
                var v = parseFloat(inp.value || 0);
                if (!isFinite(v) || v < 0) v = 0;
                if (v > totalOrden) v = totalOrden;
                inp.value = v ? money(v) : '';
                var chk = row.querySelector('.chk-orden');
                chk.checked = v > 0;
                updateResumen();
            }
        });

        $monto.addEventListener('input', updateResumen);
        $metodo.addEventListener('change', updateResumen);

        $form.addEventListener('submit', async function(e) {
            e.preventDefault(); e.stopPropagation();
            $form.classList.add('was-validated');
            var totalPago = getTotalPago();
            var suma = getSumaMontos();
            if (totalPago <= 0) return;
            if (suma - totalPago > 1e-9) { updateResumen(); return; }
            if (!$metodo.value) { updateResumen(); return; }

            var detalles = [];
            $tbody.querySelectorAll('tr').forEach(function(row) {
                var id = parseInt(row.dataset.ordenId, 10);
                var inp = row.querySelector('.input-monto-orden');
                var v = parseFloat(inp.value || 0);
                if (isFinite(v) && v > 0) { detalles.push({ id_orden: id, monto: parseFloat(v.toFixed(2)) }); }
            });

            var fd = new FormData();
            fd.append('monto', totalPago.toFixed(2));
            fd.append('metodo_pago', $metodo.value);
            fd.append('pagos', JSON.stringify(detalles));
            fd.append('fecha_pago', $fechaPago.value);
            fd.append('id_usuario', '<?php echo $userId; ?>');
            fd.append('accion', 'alta');

            try {
                var resp = await fetch('api/apiPagos.php', { method: 'POST', body: fd });
                var data = await resp.json().catch(function() { return {}; });
                if (resp.ok && (data.estatus === 'exito' || data.tipo === 'success')) {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('agregarPagoModal'));
                    if (modal) modal.hide();
                    $form.reset(); $form.classList.remove('was-validated');
                    $tbody.querySelectorAll('.input-monto-orden').forEach(function(i) { i.value = ''; });
                    $tbody.querySelectorAll('.chk-orden').forEach(function(c) { c.checked = false; });
                    updateResumen();
                    Swal.fire({ icon: 'success', title: 'Pago registrado', timer: 1500, showConfirmButton: false }).then(function() { location.reload(); });
                } else {
                    alert(data.message || data.error || 'No se pudo guardar el pago.');
                }
            } catch (err) { console.error(err); alert('Error de red al guardar el pago.'); }
        });

        updateResumen();
    })();

    /* ══ Chart: Reporte ventas por producto (original) ══ */
    var dataJson = <?php echo json_encode($reporteVentasUsuario ?? [], JSON_UNESCAPED_UNICODE); ?>;

    function renderColumnChart(targetId, rawData) {
        var target = document.querySelector('#' + targetId);
        if (!target) return;
        if (!Array.isArray(rawData) || rawData.length === 0) {
            target.innerHTML = '<div style="text-align:center;padding:3rem;color:var(--uv-text-muted);">Sin datos para mostrar.</div>';
            return;
        }
        var labels = rawData.map(function(r) { return r.producto; });
        var montos = rawData.map(function(r) { return parseFloat(r.total_gastado) || 0; });
        var fmtMXN = function(val) { return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN', maximumFractionDigits: 0 }).format(val); };

        new ApexCharts(target, {
            chart: { type: 'bar', height: 460, fontFamily: 'inherit', toolbar: { show: false } },
            series: [{ name: 'Monto (MXN)', data: montos }],
            xaxis: { categories: labels, labels: { rotate: -45, style: { fontSize: '11px' } } },
            yaxis: { labels: { formatter: fmtMXN }, title: { text: 'Monto gastado (MXN)' } },
            dataLabels: { enabled: true, formatter: fmtMXN, style: { fontSize: '11px', colors: ['#475569'] } },
            tooltip: { y: { formatter: function(val) { return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(val); } } },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '60%', distributed: true, dataLabels: { position: 'top' } } },
            colors: ['#2563eb','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#06b6d4','#84cc16','#f97316','#6366f1'],
            legend: { show: false }
        }).render();
    }

    renderColumnChart('estUsuario', dataJson);
    </script>

</body>
</html>
