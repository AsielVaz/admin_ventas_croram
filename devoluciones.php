<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Devoluciones" />
    <title>Croram Admin &middot; Devoluciones</title>
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
        --dv-primary: #2563eb;
        --dv-primary-soft: rgba(37,99,235,.07);
        --dv-success: #059669;
        --dv-success-soft: rgba(5,150,105,.08);
        --dv-danger: #dc2626;
        --dv-warning: #d97706;
        --dv-warning-soft: rgba(217,119,6,.08);
        --dv-info: #0284c7;
        --dv-info-soft: rgba(2,132,199,.08);
        --dv-text: #1e293b;
        --dv-text-secondary: #64748b;
        --dv-text-muted: #94a3b8;
        --dv-surface: #ffffff;
        --dv-surface-alt: #f8fafc;
        --dv-border: #e2e8f0;
        --dv-radius: 14px;
        --dv-radius-sm: 10px;
        --dv-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 20px rgba(0,0,0,.06);
        --dv-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--dv-font); }

    .dv-breadcrumb {
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.5rem; font-size: .85rem; color: var(--dv-text-secondary);
    }
    .dv-breadcrumb a { color: var(--dv-primary); text-decoration: none; }
    .dv-breadcrumb .sep { opacity: .4; }

    .dv-kpi-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem; margin-bottom: 1.25rem;
    }
    .dv-kpi {
        background: var(--dv-surface);
        border: 1px solid var(--dv-border);
        border-radius: var(--dv-radius-sm);
        padding: 1rem 1.15rem;
        display: flex; flex-direction: column; gap: .15rem;
        animation: fadeIn .3s ease both;
    }
    .dv-kpi-label {
        font-size: .7rem; text-transform: uppercase;
        letter-spacing: .06em; color: var(--dv-text-muted); font-weight: 600;
    }
    .dv-kpi-value {
        font-size: 1.35rem; font-weight: 700; color: var(--dv-text); line-height: 1.2;
    }

    .dv-card {
        background: var(--dv-surface);
        border: 1px solid var(--dv-border);
        border-radius: var(--dv-radius);
        box-shadow: var(--dv-shadow);
        overflow: hidden;
        animation: fadeIn .35s ease both;
    }
    .dv-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--dv-border);
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; flex-wrap: wrap;
        background: var(--dv-surface-alt);
    }
    .dv-card-header-left {
        display: flex; align-items: center; gap: .5rem;
        font-weight: 600; font-size: .95rem; color: var(--dv-text);
    }
    .dv-card-header-left .material-icons-outlined { font-size: 1.2rem; color: var(--dv-primary); }
    .dv-card-body { padding: 1.25rem 1.5rem; }

    .dv-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .25rem .65rem; border-radius: 999px;
        font-size: .72rem; font-weight: 600; white-space: nowrap;
        background: var(--dv-info-soft); color: var(--dv-info);
    }
    .dv-badge.order { background: var(--dv-primary-soft); color: var(--dv-primary); }
    .dv-badge.qty { background: var(--dv-warning-soft); color: var(--dv-warning); }

    .dv-motive {
        max-width: 360px;
        white-space: normal;
        color: var(--dv-text-secondary);
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: var(--dv-radius-sm) !important;
        border: 1px solid var(--dv-border) !important;
        font-family: var(--dv-font) !important;
        font-size: .85rem !important;
        padding: .45rem .85rem !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--dv-primary) !important;
        box-shadow: 0 0 0 3px var(--dv-primary-soft) !important;
        outline: none !important;
    }
    .dataTables_wrapper .dataTables_length select {
        border-radius: var(--dv-radius-sm) !important;
        border: 1px solid var(--dv-border) !important;
        font-family: var(--dv-font) !important;
    }
    table.dataTable thead th {
        background: var(--dv-surface-alt) !important;
        font-weight: 600 !important; font-size: .75rem !important;
        text-transform: uppercase !important; letter-spacing: .04em !important;
        color: var(--dv-text-secondary) !important;
        border-bottom: 1px solid var(--dv-border) !important;
        padding: .7rem 1rem !important;
    }
    table.dataTable tbody td {
        font-size: .84rem !important;
        color: var(--dv-text) !important;
        padding: .65rem 1rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid var(--dv-border) !important;
    }
    table.dataTable tbody tr:hover { background: var(--dv-primary-soft) !important; }
    .dataTables_wrapper .dataTables_info {
        font-size: .8rem !important;
        color: var(--dv-text-muted) !important;
    }
    div.dt-buttons .btn {
        border-radius: var(--dv-radius-sm) !important;
        font-family: var(--dv-font) !important;
        font-size: .78rem !important;
        font-weight: 600 !important;
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
    include_once "api/adminDevoluciones.php";
    include_once "api/adminUsuarios.php";

    $adminDevoluciones = new AdministradorDevoluciones();
    $adminUsuarios = new AdministradorUsuarios();

    $devoluciones = $adminDevoluciones->dameDevolucionesConTodo();
    if (!is_array($devoluciones)) $devoluciones = [];

    $usuarios = $adminUsuarios->dameUsuarios();
    if (!is_array($usuarios)) $usuarios = [];

    $usuariosPorId = [];
    foreach ($usuarios as $usuario) {
        if (!is_object($usuario)) continue;
        $usuariosPorId[intval($usuario->id ?? 0)] = $usuario->nombre ?? ('Usuario #' . intval($usuario->id ?? 0));
    }

    $totalDevoluciones = count($devoluciones);
    $totalPiezas = 0;
    $ordenesUnicas = [];
    $productosUnicos = [];

    foreach ($devoluciones as $devolucion) {
        if (!is_object($devolucion)) continue;
        $totalPiezas += floatval($devolucion->cantidad ?? 0);
        if (!empty($devolucion->id_orden)) $ordenesUnicas[intval($devolucion->id_orden)] = true;
        if (!empty($devolucion->id_producto)) $productosUnicos[intval($devolucion->id_producto)] = true;
    }
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">

                <div class="dv-breadcrumb">
                    <a href="index.php">Inicio</a>
                    <span class="sep">/</span>
                    <span>Reportes</span>
                    <span class="sep">/</span>
                    <span style="color:var(--dv-text);font-weight:600;">Devoluciones</span>
                </div>

                <div class="dv-kpi-row">
                    <div class="dv-kpi" style="animation-delay:.05s;">
                        <span class="dv-kpi-label">Total devoluciones</span>
                        <span class="dv-kpi-value"><?php echo $totalDevoluciones; ?></span>
                    </div>
                    <div class="dv-kpi" style="animation-delay:.1s;">
                        <span class="dv-kpi-label">Piezas devueltas</span>
                        <span class="dv-kpi-value" style="color:var(--dv-warning);"><?php echo number_format($totalPiezas, 2); ?></span>
                    </div>
                    <div class="dv-kpi" style="animation-delay:.15s;">
                        <span class="dv-kpi-label">Ordenes afectadas</span>
                        <span class="dv-kpi-value"><?php echo count($ordenesUnicas); ?></span>
                    </div>
                    <div class="dv-kpi" style="animation-delay:.2s;">
                        <span class="dv-kpi-label">Productos distintos</span>
                        <span class="dv-kpi-value"><?php echo count($productosUnicos); ?></span>
                    </div>
                </div>

                <div class="dv-card">
                    <div class="dv-card-header">
                        <div class="dv-card-header-left">
                            <span class="material-icons-outlined">assignment_return</span>
                            Lista de devoluciones
                        </div>
                    </div>
                    <div class="dv-card-body" style="padding:.75rem 1.25rem 1.25rem;">
                        <div class="table-responsive">
                            <table id="tablaDevoluciones" class="table table-striped table-bordered" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Orden</th>
                                        <th>Cliente</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Motivo</th>
                                        <th>Fecha</th>
                                        <th>Usuario ingresa</th>
                                        <th>Recolector</th>
                                        <th>Tipo pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($devoluciones as $devolucion):
                                        if (!is_object($devolucion)) continue;
                                        $idCliente = intval($devolucion->id_cliente ?? 0);
                                        $idUsuarioIngresa = intval($devolucion->usuario_ingresa ?? 0);
                                        $cliente = $usuariosPorId[$idCliente] ?? ('Cliente #' . $idCliente);
                                        $usuarioIngresa = $usuariosPorId[$idUsuarioIngresa] ?? ('Usuario #' . $idUsuarioIngresa);
                                        $tipoPago = intval($devolucion->tipo_pago ?? 0);
                                        $tipoPagoTexto = $tipoPago === 2 ? 'Credito' : ($tipoPago === 1 ? 'Contado' : 'Tipo #' . $tipoPago);
                                    ?>
                                    <tr>
                                        <td><strong>#<?php echo intval($devolucion->id ?? 0); ?></strong></td>
                                        <td>
                                            <span class="dv-badge order">
                                                <span class="material-icons-outlined" style="font-size:.8rem;">receipt_long</span>
                                                #<?php echo intval($devolucion->id_orden ?? 0); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($cliente, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($devolucion->name ?? 'Producto sin nombre', ENT_QUOTES, 'UTF-8'); ?></strong>
                                            <div style="font-size:.75rem;color:var(--dv-text-muted);">
                                                ID producto: <?php echo intval($devolucion->id_producto ?? 0); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="dv-badge qty">
                                                <?php echo number_format(floatval($devolucion->cantidad ?? 0), 2); ?>
                                            </span>
                                        </td>
                                        <td><div class="dv-motive"><?php echo htmlspecialchars($devolucion->motivo ?? '', ENT_QUOTES, 'UTF-8'); ?></div></td>
                                        <td><?php echo htmlspecialchars($devolucion->fecha_ingresa ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($usuarioIngresa, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($devolucion->recolector ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($tipoPagoTexto, ENT_QUOTES, 'UTF-8'); ?></td>
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
    $(document).ready(function() {
        var table = $('#tablaDevoluciones').DataTable({
            lengthChange: true,
            pageLength: 25,
            buttons: ['copy', 'excel', 'pdf', 'print'],
            language: {
                search: 'Buscar:',
                lengthMenu: 'Mostrar _MENU_ registros',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ devoluciones',
                infoEmpty: 'Sin devoluciones',
                infoFiltered: '(filtrado de _MAX_ totales)',
                zeroRecords: 'No se encontraron devoluciones',
                paginate: { first: 'Primero', last: 'Ultimo', next: 'Sig.', previous: 'Ant.' }
            },
            order: [[6, 'desc']]
        });

        table.buttons().container()
            .appendTo('#tablaDevoluciones_wrapper .col-md-6:eq(0)');
    });
    </script>
</body>
</html>
