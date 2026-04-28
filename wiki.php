<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Croram - Wiki para empleados" />
    <title>Croram Admin &middot; Wiki</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet" />

    <style>
    :root {
        --wk-primary: #1d4ed8;
        --wk-info: #0891b2;
        --wk-success: #059669;
        --wk-warning: #d97706;
        --wk-danger: #dc2626;
        --wk-text: #1e293b;
        --wk-muted: #64748b;
        --wk-soft: #f8fafc;
        --wk-border: #e2e8f0;
        --wk-card: #ffffff;
        --wk-radius: 10px;
        --wk-shadow: 0 1px 3px rgba(15,23,42,.05), 0 12px 28px rgba(15,23,42,.06);
        --wk-font: 'DM Sans', sans-serif;
    }
    body { font-family: var(--wk-font); color: var(--wk-text); }
    .wk-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 58%, #0891b2 100%);
        border-radius: var(--wk-radius);
        padding: 1.5rem;
        color: #fff;
        margin-bottom: 1rem;
        box-shadow: var(--wk-shadow);
    }
    .wk-hero h4 { margin: 0 0 .35rem; color: #fff; font-weight: 800; }
    .wk-hero p { margin: 0; color: rgba(255,255,255,.82); max-width: 820px; }
    .wk-toolbar {
        display: flex;
        gap: .75rem;
        align-items: center;
        flex-wrap: wrap;
        background: var(--wk-card);
        border: 1px solid var(--wk-border);
        border-radius: var(--wk-radius);
        padding: .85rem;
        margin-bottom: 1rem;
        box-shadow: var(--wk-shadow);
    }
    .wk-search {
        flex: 1 1 280px;
        display: flex;
        align-items: center;
        gap: .5rem;
        border: 1px solid var(--wk-border);
        border-radius: 8px;
        padding: 0 .75rem;
        height: 42px;
        background: #fff;
    }
    .wk-search input { border: 0; outline: 0; flex: 1; font: inherit; min-width: 120px; }
    .wk-btn {
        height: 42px;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        border: 0;
        border-radius: 8px;
        padding: 0 .9rem;
        background: var(--wk-primary);
        color: #fff;
        font-weight: 800;
        text-decoration: none;
    }
    .wk-btn:hover { color: #fff; background: #1e40af; }
    .wk-layout { display: grid; grid-template-columns: 260px minmax(0, 1fr); gap: 1rem; align-items: start; }
    .wk-nav {
        position: sticky;
        top: 90px;
        background: var(--wk-card);
        border: 1px solid var(--wk-border);
        border-radius: var(--wk-radius);
        box-shadow: var(--wk-shadow);
        padding: .65rem;
    }
    .wk-nav a {
        display: flex;
        align-items: center;
        gap: .5rem;
        color: var(--wk-text);
        padding: .55rem .65rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: .86rem;
        font-weight: 700;
    }
    .wk-nav a:hover { background: #eff6ff; color: var(--wk-primary); }
    .wk-section {
        background: var(--wk-card);
        border: 1px solid var(--wk-border);
        border-radius: var(--wk-radius);
        box-shadow: var(--wk-shadow);
        margin-bottom: 1rem;
        overflow: hidden;
    }
    .wk-section-header {
        display: flex;
        align-items: center;
        gap: .55rem;
        padding: 1rem 1.15rem;
        background: var(--wk-soft);
        border-bottom: 1px solid var(--wk-border);
    }
    .wk-section-header .material-icons-outlined { color: var(--wk-primary); font-size: 1.2rem; }
    .wk-section-header h5 { margin: 0; font-weight: 800; color: var(--wk-text); }
    .wk-section-body { padding: 1rem 1.15rem; }
    .wk-section-body p { color: var(--wk-muted); line-height: 1.65; margin-bottom: .85rem; }
    .wk-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: .8rem; }
    .wk-card {
        border: 1px solid var(--wk-border);
        border-radius: 8px;
        padding: .9rem;
        background: #fff;
    }
    .wk-card h6 { margin: 0 0 .45rem; font-weight: 800; color: var(--wk-text); }
    .wk-card p { margin: 0; font-size: .88rem; }
    .wk-list { margin: 0; padding-left: 1.1rem; color: var(--wk-muted); line-height: 1.7; }
    .wk-list li { margin-bottom: .25rem; }
    .wk-flow { display: grid; gap: .6rem; }
    .wk-step {
        display: grid;
        grid-template-columns: 36px minmax(0, 1fr);
        gap: .75rem;
        align-items: start;
        border: 1px solid var(--wk-border);
        border-radius: 8px;
        padding: .75rem;
        background: #fff;
    }
    .wk-num {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: var(--wk-primary);
        font-weight: 900;
    }
    .wk-step strong { display: block; color: var(--wk-text); margin-bottom: .2rem; }
    .wk-step span { color: var(--wk-muted); font-size: .9rem; line-height: 1.55; }
    .wk-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: .2rem .55rem;
        font-size: .72rem;
        font-weight: 800;
        background: #eff6ff;
        color: var(--wk-primary);
        margin: .1rem .2rem .1rem 0;
    }
    .wk-badge.ok { background: #ecfdf5; color: var(--wk-success); }
    .wk-badge.warn { background: #fffbeb; color: var(--wk-warning); }
    .wk-badge.danger { background: #fef2f2; color: var(--wk-danger); }
    .wk-table { width: 100%; border-collapse: collapse; font-size: .88rem; }
    .wk-table th, .wk-table td { border: 1px solid var(--wk-border); padding: .65rem; vertical-align: top; }
    .wk-table th { background: var(--wk-soft); color: var(--wk-muted); text-transform: uppercase; font-size: .72rem; letter-spacing: .04em; }
    .wk-callout {
        border-left: 4px solid var(--wk-warning);
        background: #fffbeb;
        border-radius: 8px;
        padding: .85rem 1rem;
        color: #92400e;
        margin: .8rem 0;
    }
    .wk-hidden { display: none !important; }
    @media (max-width: 991px) {
        .wk-layout { grid-template-columns: 1fr; }
        .wk-nav { position: relative; top: 0; }
    }
    @media print {
        .nxl-navigation, .nxl-header, .wk-toolbar, .wk-nav, .customizer-sidebar { display: none !important; }
        .nxl-container { margin-left: 0 !important; }
        .wk-layout { display: block; }
        .wk-section { break-inside: avoid; box-shadow: none; }
        .wk-hero { background: #1d4ed8 !important; print-color-adjust: exact; }
    }
    </style>
</head>

<body>
    <?php include "partials/barra.php"; ?>
    <?php include "partials/header.php"; ?>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">
                <div class="wk-hero">
                    <h4>Wiki Croram para empleados</h4>
                    <p>Guia operativa del sistema administrativo: como se usan los modulos, que informacion cuidar y como funciona la integracion con Naperz.</p>
                </div>

                <div class="wk-toolbar">
                    <div class="wk-search">
                        <span class="material-icons-outlined">search</span>
                        <input type="search" id="wikiSearch" placeholder="Buscar en la wiki..." autocomplete="off">
                    </div>
                    <button type="button" class="wk-btn" onclick="window.print()">
                        <span class="material-icons-outlined" style="font-size:1rem;">print</span>
                        Imprimir
                    </button>
                </div>

                <div class="wk-layout">
                    <aside class="wk-nav">
                        <a href="#proposito"><span class="material-icons-outlined">flag</span>Proposito</a>
                        <a href="#mapa"><span class="material-icons-outlined">account_tree</span>Mapa del sistema</a>
                        <a href="#roles"><span class="material-icons-outlined">groups</span>Roles</a>
                        <a href="#ordenes"><span class="material-icons-outlined">shopping_cart</span>Ordenes</a>
                        <a href="#pagos"><span class="material-icons-outlined">payments</span>Pagos</a>
                        <a href="#catalogos"><span class="material-icons-outlined">inventory_2</span>Catalogos</a>
                        <a href="#reportes"><span class="material-icons-outlined">bar_chart</span>Reportes</a>
                        <a href="#napers"><span class="material-icons-outlined">cloud_sync</span>Naperz</a>
                        <a href="#incidencias"><span class="material-icons-outlined">support_agent</span>Incidencias</a>
                    </aside>

                    <div>
                        <section class="wk-section wiki-block" id="proposito">
                            <div class="wk-section-header"><span class="material-icons-outlined">flag</span><h5>Proposito de la wiki</h5></div>
                            <div class="wk-section-body">
                                <p>Esta wiki esta escrita para empleados de Croram. Su objetivo es explicar el uso diario del sistema administrativo, los cuidados basicos de captura y la forma en que los datos se comunican con el sistema original Naperz.</p>
                                <div class="wk-grid">
                                    <div class="wk-card"><h6>Que si cubre</h6><p>Flujo de ordenes, clientes, productos, pagos, reportes, devoluciones y sincronizacion con Naperz.</p></div>
                                    <div class="wk-card"><h6>Que no cubre</h6><p>No publica contrasenas, llaves de API ni datos sensibles. Si se requiere soporte tecnico, se escala con administracion.</p></div>
                                    <div class="wk-card"><h6>Regla de oro</h6><p>Si una operacion afecta dinero, inventario, cliente o entrega, debe capturarse completa y revisarse antes de guardar.</p></div>
                                </div>
                            </div>
                        </section>

                        <section class="wk-section wiki-block" id="mapa">
                            <div class="wk-section-header"><span class="material-icons-outlined">account_tree</span><h5>Mapa del sistema</h5></div>
                            <div class="wk-section-body">
                                <div class="wk-grid">
                                    <div class="wk-card"><h6>Dashboard</h6><p>Vista general de ventas, productos, clientes activos y saldos pendientes.</p></div>
                                    <div class="wk-card"><h6>Ordenes</h6><p>Alta, revision, aprobacion, moderacion, cancelacion y consulta de pedidos.</p></div>
                                    <div class="wk-card"><h6>Usuarios</h6><p>Clientes, vendedores y administradores internos. Aqui se vincula el cliente Naperz.</p></div>
                                    <div class="wk-card"><h6>Catalogos</h6><p>Productos, vehiculos, ofertas, clientes vendedores y sets de precios.</p></div>
                                    <div class="wk-card"><h6>Reportes</h6><p>Ventas, cobranza, productos, clientes, devoluciones, inventario y PDF ejecutivo.</p></div>
                                    <div class="wk-card"><h6>Wiki</h6><p>Documentacion operativa para empleados. No modifica datos del sistema.</p></div>
                                </div>
                            </div>
                        </section>

                        <section class="wk-section wiki-block" id="roles">
                            <div class="wk-section-header"><span class="material-icons-outlined">groups</span><h5>Roles y responsabilidades</h5></div>
                            <div class="wk-section-body">
                                <table class="wk-table">
                                    <thead><tr><th>Rol</th><th>Responsabilidad</th><th>Cuidados</th></tr></thead>
                                    <tbody>
                                        <tr><td>Ventas</td><td>Crear pedidos, revisar cliente, precios y productos.</td><td>Confirmar cliente Naperz, fecha de entrega y metodo de pago.</td></tr>
                                        <tr><td>Moderacion</td><td>Aprobar, ajustar o rechazar ordenes.</td><td>Al aprobar, la venta se envia o actualiza en Naperz.</td></tr>
                                        <tr><td>Cobranza</td><td>Registrar pagos y aplicar montos a ordenes.</td><td>El pago tambien se envia a Naperz; no registrar duplicados.</td></tr>
                                        <tr><td>Administracion</td><td>Gestionar usuarios, catalogos, reportes e incidencias.</td><td>No compartir credenciales ni llaves de integracion.</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <section class="wk-section wiki-block" id="ordenes">
                            <div class="wk-section-header"><span class="material-icons-outlined">shopping_cart</span><h5>Flujo de ordenes</h5></div>
                            <div class="wk-section-body">
                                <div class="wk-flow">
                                    <div class="wk-step"><div class="wk-num">1</div><div><strong>Crear orden</strong><span>Se elige cliente, vehiculo, productos, cantidades, tipo de pago, recolector y fecha solicitada.</span></div></div>
                                    <div class="wk-step"><div class="wk-num">2</div><div><strong>Revisar disponibilidad y precios</strong><span>El sistema usa productos locales vinculados a productos Naperz. Si un producto no tiene ID Naperz, la venta remota puede fallar.</span></div></div>
                                    <div class="wk-step"><div class="wk-num">3</div><div><strong>Moderacion</strong><span>Se ajusta fecha/hora, notas y productos si hace falta. La orden puede aprobarse o rechazarse.</span></div></div>
                                    <div class="wk-step"><div class="wk-num">4</div><div><strong>Aprobacion</strong><span>Al aprobar, el sistema crea la venta en Naperz. Si ya tenia ID Naperz, manda una actualizacion de fecha y nota.</span></div></div>
                                    <div class="wk-step"><div class="wk-num">5</div><div><strong>Cancelacion</strong><span>Si la orden ya existe en Naperz, se cancela primero en Naperz y despues se marca localmente como cancelada.</span></div></div>
                                </div>
                                <div class="wk-callout">Antes de aprobar una orden, validar cliente, lista de precios, productos, cantidades, placa y chofer. Esos datos viajan a Naperz.</div>
                            </div>
                        </section>

                        <section class="wk-section wiki-block" id="pagos">
                            <div class="wk-section-header"><span class="material-icons-outlined">payments</span><h5>Pagos y cobranza</h5></div>
                            <div class="wk-section-body">
                                <p>Los pagos se registran desde la vista del cliente. Se captura monto total, fecha, metodo de pago y distribucion del monto entre ordenes pendientes.</p>
                                <div class="wk-grid">
                                    <div class="wk-card"><h6>Metodos aceptados</h6><p><span class="wk-badge">Cheque</span><span class="wk-badge">Efectivo</span><span class="wk-badge">Transferencia</span><span class="wk-badge">Deposito</span></p></div>
                                    <div class="wk-card"><h6>Sincronizacion</h6><p>Al guardar, el sistema crea un pago confirmado en Naperz y guarda el identificador remoto en `id_napers`.</p></div>
                                    <div class="wk-card"><h6>Cancelacion</h6><p>Si un pago tiene ID Naperz, primero se cancela en Naperz. Si Naperz rechaza la cancelacion, no se elimina localmente.</p></div>
                                </div>
                            </div>
                        </section>

                        <section class="wk-section wiki-block" id="catalogos">
                            <div class="wk-section-header"><span class="material-icons-outlined">inventory_2</span><h5>Catalogos</h5></div>
                            <div class="wk-section-body">
                                <table class="wk-table">
                                    <thead><tr><th>Catalogo</th><th>Uso</th><th>Integracion</th></tr></thead>
                                    <tbody>
                                        <tr><td>Productos</td><td>Lista local de productos vendibles, precio base, unidad, peso e imagen.</td><td>Debe vincularse con Producto Naperz para enviar ventas.</td></tr>
                                        <tr><td>Usuarios / Clientes</td><td>Personas o empresas que compran, vendedores y administradores.</td><td>El campo Cliente Naperz relaciona el usuario local con el cliente original.</td></tr>
                                        <tr><td>Vehiculos</td><td>Datos de unidad usada para entrega.</td><td>La placa viaja a Naperz en la venta.</td></tr>
                                        <tr><td>Sets de precios</td><td>Precios especiales por cliente o grupo.</td><td>La lista de precio Naperz se usa al crear venta remota.</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <section class="wk-section wiki-block" id="reportes">
                            <div class="wk-section-header"><span class="material-icons-outlined">bar_chart</span><h5>Reportes</h5></div>
                            <div class="wk-section-body">
                                <p>El panel de reportes concentra informacion relevante para venta, cobranza y operacion. Puede filtrarse por fecha y exportarse a PDF ejecutivo.</p>
                                <div class="wk-grid">
                                    <div class="wk-card"><h6>Ventas</h6><p>Total vendido, pagado, saldo, ordenes, unidades y ticket promedio.</p></div>
                                    <div class="wk-card"><h6>Cobranza</h6><p>Ordenes con saldo pendiente y clientes con mayor deuda.</p></div>
                                    <div class="wk-card"><h6>Operacion</h6><p>Estatus de ordenes, capturistas, devoluciones e inventario actual.</p></div>
                                </div>
                            </div>
                        </section>

                        <section class="wk-section wiki-block" id="napers">
                            <div class="wk-section-header"><span class="material-icons-outlined">cloud_sync</span><h5>Integracion con Naperz</h5></div>
                            <div class="wk-section-body">
                                <p>Naperz es el sistema original. El admin Croram funciona como herramienta operativa y envia/consulta informacion mediante la API documentada. La llave de acceso esta en codigo del backend y no debe compartirse.</p>
                                <div class="wk-grid">
                                    <div class="wk-card"><h6>Lectura desde Naperz</h6><p><span class="wk-badge ok">Clientes</span><span class="wk-badge ok">Productos</span><span class="wk-badge ok">Usuarios</span><br>Se consultan para vincular registros locales y validar datos.</p></div>
                                    <div class="wk-card"><h6>Envio hacia Naperz</h6><p><span class="wk-badge ok">Ventas</span><span class="wk-badge ok">Pagos</span><br>Se crean desde acciones del sistema admin.</p></div>
                                    <div class="wk-card"><h6>Actualizacion / cancelacion</h6><p><span class="wk-badge warn">Ventas.update</span><span class="wk-badge danger">Ventas.cancel</span><span class="wk-badge danger">Pagos.cancel</span></p></div>
                                </div>

                                <table class="wk-table" style="margin-top:1rem;">
                                    <thead><tr><th>Accion en admin</th><th>Endpoint Naperz</th><th>Resultado esperado</th></tr></thead>
                                    <tbody>
                                        <tr><td>Buscar clientes</td><td>GET /clients y GET /clients/{id}</td><td>Lista clientes activos y detalle con termino/lista de precio.</td></tr>
                                        <tr><td>Buscar productos</td><td>GET /products y GET /products/{id}</td><td>Productos activos vendibles y precio estandar.</td></tr>
                                        <tr><td>Buscar usuarios Naperz</td><td>GET /users y GET /users/{id}</td><td>Usuarios activos del sistema original.</td></tr>
                                        <tr><td>Aprobar orden nueva</td><td>POST /sale</td><td>Venta confirmada en Naperz; se guarda ID remoto.</td></tr>
                                        <tr><td>Reaprobar orden ya enviada</td><td>PATCH /sale/{saleId}</td><td>Actualiza fecha de entrega y nota.</td></tr>
                                        <tr><td>Cancelar orden enviada</td><td>PATCH /sale/cancel/{saleId}</td><td>Cancela venta y entrega en Naperz.</td></tr>
                                        <tr><td>Registrar pago</td><td>POST /payments</td><td>Pago confirmado en Naperz; se guarda ID remoto.</td></tr>
                                        <tr><td>Cancelar pago</td><td>PATCH /payments/cancel/{paymentId}</td><td>Cancela pago remoto antes de eliminar localmente.</td></tr>
                                    </tbody>
                                </table>

                                <div class="wk-callout">Si una orden o pago no tiene `id_napers`, significa que no esta vinculado con Naperz o que la sincronizacion fallo. Revisar antes de duplicar movimientos.</div>
                            </div>
                        </section>

                        <section class="wk-section wiki-block" id="incidencias">
                            <div class="wk-section-header"><span class="material-icons-outlined">support_agent</span><h5>Incidencias comunes</h5></div>
                            <div class="wk-section-body">
                                <table class="wk-table">
                                    <thead><tr><th>Situacion</th><th>Que revisar</th><th>Accion recomendada</th></tr></thead>
                                    <tbody>
                                        <tr><td>No aparece cliente Naperz</td><td>Cliente activo en Naperz y conexion disponible.</td><td>No crear duplicado local sin confirmar con administracion.</td></tr>
                                        <tr><td>Falla al aprobar orden</td><td>ID cliente Naperz, producto Naperz, lista de precios, placa y fecha.</td><td>Corregir datos y reintentar aprobacion.</td></tr>
                                        <tr><td>Falla al registrar pago</td><td>Cliente vinculado, monto positivo, metodo de pago valido.</td><td>Si el pago quedo local pero no remoto, reportar ID local.</td></tr>
                                        <tr><td>Saldo incorrecto</td><td>Relaciones de pago por orden y pagos cancelados.</td><td>Revisar historial del cliente antes de capturar otro pago.</td></tr>
                                        <tr><td>Producto sin precio correcto</td><td>Set de precio local y lista de precio Naperz.</td><td>Confirmar con ventas antes de aprobar.</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
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
    <script>
    (function() {
        var input = document.getElementById('wikiSearch');
        var blocks = Array.prototype.slice.call(document.querySelectorAll('.wiki-block'));
        if (!input) return;

        input.addEventListener('input', function() {
            var term = input.value.trim().toLowerCase();
            blocks.forEach(function(block) {
                var text = block.innerText.toLowerCase();
                block.classList.toggle('wk-hidden', term && text.indexOf(term) === -1);
            });
        });
    })();
    </script>
</body>
</html>
