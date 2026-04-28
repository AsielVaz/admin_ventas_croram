<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Log Naperz" />
    <title>Croram Admin &middot; Log Naperz</title>
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
        --ln-primary: #2563eb;
        --ln-success: #059669;
        --ln-danger: #dc2626;
        --ln-warning: #d97706;
        --ln-text: #172033;
        --ln-muted: #64748b;
        --ln-border: #e2e8f0;
        --ln-soft: #f8fafc;
        --ln-card: #ffffff;
        --ln-radius: 10px;
        --ln-shadow: 0 1px 3px rgba(15,23,42,.05), 0 12px 28px rgba(15,23,42,.06);
        --ln-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--ln-font); }
    .ln-breadcrumb { display:flex; align-items:center; gap:.65rem; margin-bottom:1rem; font-size:.84rem; color:var(--ln-muted); }
    .ln-breadcrumb a { color:var(--ln-primary); text-decoration:none; }
    .ln-title { display:flex; justify-content:space-between; align-items:flex-end; gap:1rem; flex-wrap:wrap; margin-bottom:1rem; }
    .ln-title h4 { margin:0; color:var(--ln-text); font-weight:900; }
    .ln-title span { color:var(--ln-muted); font-size:.86rem; }
    .ln-toolbar { background:var(--ln-card); border:1px solid var(--ln-border); border-radius:var(--ln-radius); box-shadow:var(--ln-shadow); padding:1rem; display:flex; align-items:end; gap:.8rem; flex-wrap:wrap; margin-bottom:1rem; }
    .ln-field { display:flex; flex-direction:column; gap:.3rem; min-width:170px; }
    .ln-field.grow { flex:1; min-width:260px; }
    .ln-field label { color:var(--ln-muted); font-size:.72rem; text-transform:uppercase; font-weight:900; letter-spacing:.04em; }
    .ln-field input, .ln-field select { height:40px; border:1px solid var(--ln-border); border-radius:8px; padding:0 .8rem; color:var(--ln-text); background:#fff; }
    .ln-btn { height:40px; display:inline-flex; align-items:center; justify-content:center; gap:.4rem; border:0; border-radius:8px; padding:0 1rem; background:var(--ln-primary); color:#fff; font-weight:900; text-decoration:none; white-space:nowrap; }
    .ln-btn:hover { color:#fff; background:#1d4ed8; }
    .ln-btn.secondary { background:#475569; }
    .ln-kpis { display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:.85rem; margin-bottom:1rem; }
    .ln-kpi { background:var(--ln-card); border:1px solid var(--ln-border); border-radius:var(--ln-radius); box-shadow:var(--ln-shadow); padding:1rem; min-height:116px; }
    .ln-kpi .icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; margin-bottom:.65rem; }
    .ln-kpi .icon span { font-size:1.15rem; }
    .ln-kpi .label { color:var(--ln-muted); font-size:.72rem; text-transform:uppercase; font-weight:900; letter-spacing:.04em; }
    .ln-kpi .value { color:var(--ln-text); font-weight:900; font-size:1.35rem; line-height:1.2; overflow-wrap:anywhere; }
    .ln-card { background:var(--ln-card); border:1px solid var(--ln-border); border-radius:var(--ln-radius); box-shadow:var(--ln-shadow); overflow:hidden; }
    .ln-card-header { display:flex; justify-content:space-between; gap:1rem; align-items:center; padding:1rem 1.1rem; background:var(--ln-soft); border-bottom:1px solid var(--ln-border); flex-wrap:wrap; }
    .ln-card-title { display:flex; align-items:center; gap:.45rem; color:var(--ln-text); font-weight:900; }
    .ln-card-title .material-icons-outlined { font-size:1.15rem; color:var(--ln-primary); }
    .ln-card-body { padding:1rem; }
    .ln-badge { display:inline-flex; align-items:center; gap:.3rem; border-radius:999px; padding:.24rem .62rem; font-size:.72rem; font-weight:900; white-space:nowrap; }
    .ln-badge.ok { color:var(--ln-success); background:#ecfdf5; }
    .ln-badge.error { color:var(--ln-danger); background:#fef2f2; }
    .ln-message { max-width:720px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:var(--ln-text); }
    .ln-code { background:#0f172a; color:#e2e8f0; border-radius:8px; padding:1rem; white-space:pre-wrap; word-break:break-word; font-family:Consolas, Monaco, monospace; font-size:.85rem; }
    table.dataTable thead th { background:var(--ln-soft) !important; color:var(--ln-muted) !important; font-size:.72rem !important; text-transform:uppercase !important; letter-spacing:.04em !important; border-bottom:1px solid var(--ln-border) !important; }
    table.dataTable tbody td { font-size:.83rem !important; color:var(--ln-text) !important; vertical-align:middle !important; }
    div.dt-buttons .btn { border-radius:8px !important; font-size:.78rem !important; font-weight:800 !important; }
    @media (max-width:767px) { .ln-field, .ln-field.grow { min-width:100%; } .ln-btn { width:100%; } .ln-message { max-width:260px; } }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <?php
    include_once "api/adminLogNapers.php";

    function ln_e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
    function ln_fecha($value) { return $value ? date('d/m/Y H:i:s', strtotime($value)) : 'Sin fecha'; }
    function ln_estado($mensaje) { return stripos((string)$mensaje, 'ERROR') === 0 ? 'error' : 'ok'; }
    function ln_endpoint($mensaje) {
        if (preg_match('/Naperz\s+(GET|POST|PATCH|PUT|DELETE)\s+([^:\. ]+)/i', (string)$mensaje, $m)) {
            return strtoupper($m[1]) . ' ' . $m[2];
        }
        return 'Transaccion';
    }

    $hoy = date('Y-m-d');
    $haceSemana = date('Y-m-d', strtotime('-7 days'));
    $fechaInicio = $_GET['fecha_inicio'] ?? $haceSemana;
    $fechaFin = $_GET['fecha_fin'] ?? $hoy;
    $estatus = $_GET['estatus'] ?? 'todos';
    $buscar = $_GET['buscar'] ?? '';
    $limite = $_GET['limite'] ?? 1000;

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaInicio)) $fechaInicio = $haceSemana;
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaFin)) $fechaFin = $hoy;
    if (!in_array($estatus, ['todos', 'ok', 'error'], true)) $estatus = 'todos';
    if (!in_array((string)$limite, ['100', '500', '1000', '2500', '5000'], true)) $limite = 1000;
    if ($fechaInicio > $fechaFin) {
        $tmp = $fechaInicio;
        $fechaInicio = $fechaFin;
        $fechaFin = $tmp;
    }

    $adminLog = new AdministradorLogNapers();
    $filtroEstatus = $estatus === 'todos' ? '' : $estatus;
    $logs = $adminLog->listar($fechaInicio, $fechaFin, $filtroEstatus, $buscar, $limite);
    $resumen = $adminLog->resumen($fechaInicio, $fechaFin, $filtroEstatus, $buscar);

    $logsJson = [];
    foreach ($logs as $log) {
        $logsJson[] = [
            'id' => intval($log->id ?? 0),
            'fecha' => ln_fecha($log->fecha ?? ''),
            'estado' => ln_estado($log->mensaje ?? '') === 'error' ? 'Error' : 'OK',
            'endpoint' => ln_endpoint($log->mensaje ?? ''),
            'mensaje' => (string)($log->mensaje ?? '')
        ];
    }
    ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">
                <div class="ln-breadcrumb">
                    <a href="index.php">Inicio</a><span>/</span><span style="color:var(--ln-text);font-weight:900;">Log Naperz</span>
                </div>

                <div class="ln-title">
                    <div>
                        <h4>Log Naperz</h4>
                        <span>Detalle de transacciones enviadas al sistema original</span>
                    </div>
                    <span><?php echo ln_e($fechaInicio); ?> al <?php echo ln_e($fechaFin); ?></span>
                </div>

                <form class="ln-toolbar" method="get">
                    <div class="ln-field">
                        <label for="fecha_inicio">Fecha inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo ln_e($fechaInicio); ?>">
                    </div>
                    <div class="ln-field">
                        <label for="fecha_fin">Fecha fin</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo ln_e($fechaFin); ?>">
                    </div>
                    <div class="ln-field">
                        <label for="estatus">Estatus</label>
                        <select id="estatus" name="estatus">
                            <option value="todos" <?php echo $estatus === 'todos' ? 'selected' : ''; ?>>Todos</option>
                            <option value="ok" <?php echo $estatus === 'ok' ? 'selected' : ''; ?>>Correctos</option>
                            <option value="error" <?php echo $estatus === 'error' ? 'selected' : ''; ?>>Errores</option>
                        </select>
                    </div>
                    <div class="ln-field">
                        <label for="limite">Limite</label>
                        <select id="limite" name="limite">
                            <?php foreach ([100, 500, 1000, 2500, 5000] as $opcion): ?>
                                <option value="<?php echo $opcion; ?>" <?php echo intval($limite) === $opcion ? 'selected' : ''; ?>><?php echo number_format($opcion); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="ln-field grow">
                        <label for="buscar">Buscar</label>
                        <input type="search" id="buscar" name="buscar" value="<?php echo ln_e($buscar); ?>" placeholder="ID, endpoint, error, pago, venta...">
                    </div>
                    <button class="ln-btn" type="submit"><span class="material-icons-outlined" style="font-size:1rem;">filter_alt</span>Filtrar</button>
                    <a class="ln-btn secondary" href="log-napers.php"><span class="material-icons-outlined" style="font-size:1rem;">restart_alt</span>Limpiar</a>
                </form>

                <section class="ln-kpis">
                    <div class="ln-kpi">
                        <div class="icon" style="background:#eff6ff;color:var(--ln-primary);"><span class="material-icons-outlined">sync_alt</span></div>
                        <div class="label">Transacciones</div>
                        <div class="value"><?php echo number_format(floatval($resumen->total ?? 0)); ?></div>
                    </div>
                    <div class="ln-kpi">
                        <div class="icon" style="background:#ecfdf5;color:var(--ln-success);"><span class="material-icons-outlined">check_circle</span></div>
                        <div class="label">Correctas</div>
                        <div class="value"><?php echo number_format(floatval($resumen->exitos ?? 0)); ?></div>
                    </div>
                    <div class="ln-kpi">
                        <div class="icon" style="background:#fef2f2;color:var(--ln-danger);"><span class="material-icons-outlined">error</span></div>
                        <div class="label">Errores</div>
                        <div class="value"><?php echo number_format(floatval($resumen->errores ?? 0)); ?></div>
                    </div>
                    <div class="ln-kpi">
                        <div class="icon" style="background:#fffbeb;color:var(--ln-warning);"><span class="material-icons-outlined">schedule</span></div>
                        <div class="label">Ultimo movimiento</div>
                        <div class="value" style="font-size:1rem;"><?php echo ln_e(ln_fecha($resumen->ultima_fecha ?? '')); ?></div>
                    </div>
                </section>

                <section class="ln-card">
                    <div class="ln-card-header">
                        <div class="ln-card-title"><span class="material-icons-outlined">receipt_long</span> Movimientos registrados</div>
                        <span style="color:var(--ln-muted);font-size:.82rem;">Mostrando hasta <?php echo number_format(intval($limite)); ?> registros</span>
                    </div>
                    <div class="ln-card-body">
                        <div class="table-responsive">
                            <table id="tablaLogNapers" class="table table-hover align-middle w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Estatus</th>
                                        <th>Operacion</th>
                                        <th>Mensaje</th>
                                        <th>Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logs as $log): ?>
                                        <?php
                                            $mensaje = (string)($log->mensaje ?? '');
                                            $estado = ln_estado($mensaje);
                                            $idLog = intval($log->id ?? 0);
                                        ?>
                                        <tr>
                                            <td><strong>#<?php echo $idLog; ?></strong></td>
                                            <td><?php echo ln_e(ln_fecha($log->fecha ?? '')); ?></td>
                                            <td>
                                                <span class="ln-badge <?php echo $estado; ?>">
                                                    <span class="material-icons-outlined" style="font-size:.95rem;"><?php echo $estado === 'error' ? 'error' : 'check_circle'; ?></span>
                                                    <?php echo $estado === 'error' ? 'Error' : 'OK'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo ln_e(ln_endpoint($mensaje)); ?></td>
                                            <td><div class="ln-message"><?php echo ln_e($mensaje); ?></div></td>
                                            <td>
                                                <button type="button" class="ln-btn" style="height:34px;padding:0 .75rem;" onclick="abrirLogNapers(<?php echo $idLog; ?>)">
                                                    <span class="material-icons-outlined" style="font-size:1rem;">visibility</span> Ver
                                                </button>
                                            </td>
                                        </tr>
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

    <div class="modal fade" id="logNapersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="logNapersTitulo">Detalle del log</h5>
                        <div class="text-muted fs-12" id="logNapersMeta"></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <span id="logNapersEstado" class="ln-badge ok">OK</span>
                        <span id="logNapersEndpoint" class="ms-2 text-muted fw-bold"></span>
                    </div>
                    <div class="ln-code" id="logNapersMensaje"></div>
                </div>
            </div>
        </div>
    </div>

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
    var logsNapers = <?php echo json_encode($logsJson, JSON_UNESCAPED_UNICODE); ?>;
    var logsNapersMap = {};
    logsNapers.forEach(function(log) { logsNapersMap[log.id] = log; });

    function abrirLogNapers(id) {
        var log = logsNapersMap[id];
        if (!log) return;
        document.getElementById('logNapersTitulo').textContent = 'Log #' + log.id;
        document.getElementById('logNapersMeta').textContent = log.fecha;
        document.getElementById('logNapersEndpoint').textContent = log.endpoint;
        document.getElementById('logNapersMensaje').textContent = log.mensaje;

        var estado = document.getElementById('logNapersEstado');
        estado.className = 'ln-badge ' + (log.estado === 'Error' ? 'error' : 'ok');
        estado.textContent = log.estado;

        new bootstrap.Modal(document.getElementById('logNapersModal')).show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        var lang = {
            search: 'Buscar:', lengthMenu: 'Mostrar _MENU_ registros', info: 'Mostrando _START_ a _END_ de _TOTAL_',
            infoEmpty: 'Sin registros', infoFiltered: '(filtrado de _MAX_)', zeroRecords: 'Sin resultados',
            paginate: { first:'Primero', last:'Ultimo', next:'Sig.', previous:'Ant.' }
        };
        var table = $('#tablaLogNapers').DataTable({
            order: [[0, 'desc']],
            pageLength: 25,
            lengthChange: true,
            buttons: [
                { extend: 'copy', text: 'Copiar' },
                { extend: 'excel', text: 'Excel', title: 'Log Naperz' },
                { extend: 'pdf', text: 'PDF', title: 'Log Naperz', orientation: 'landscape', pageSize: 'A4' },
                { extend: 'print', text: 'Imprimir' }
            ],
            language: lang
        });
        table.buttons().container().appendTo('#tablaLogNapers_wrapper .col-md-6:eq(0)');
    });
    </script>
</body>
</html>
