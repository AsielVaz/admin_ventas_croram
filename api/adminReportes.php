<?php

include_once "conector.php";

class AdministradorReportes extends Con
{
    private function rango(string $fechaInicio, string $fechaFin): array
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaInicio)) {
            $fechaInicio = date('Y-m-01');
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaFin)) {
            $fechaFin = date('Y-m-d');
        }
        if ($fechaInicio > $fechaFin) {
            $tmp = $fechaInicio;
            $fechaInicio = $fechaFin;
            $fechaFin = $tmp;
        }

        return [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'];
    }

    public function dameResumen(string $fechaInicio, string $fechaFin)
    {
        [$inicio, $fin] = $this->rango($fechaInicio, $fechaFin);
        $sql = "
            SELECT
                COUNT(DISTINCT o.id) AS ordenes,
                COUNT(DISTINCT o.id_cliente) AS clientes,
                COALESCE(SUM(po.total_orden), 0) AS ventas,
                COALESCE(SUM(po.total_unidades), 0) AS unidades,
                COALESCE(SUM(pg.total_pagado), 0) AS pagado,
                COALESCE(SUM(po.total_orden), 0) - COALESCE(SUM(pg.total_pagado), 0) AS saldo
            FROM `order` o
            LEFT JOIN (
                SELECT id_orden, SUM(precio_unitario * cantidad) AS total_orden, SUM(cantidad) AS total_unidades
                FROM product_order
                GROUP BY id_orden
            ) po ON po.id_orden = o.id
            LEFT JOIN (
                SELECT id_orden, SUM(monto) AS total_pagado
                FROM rel_pago_orden
                GROUP BY id_orden
            ) pg ON pg.id_orden = o.id
            WHERE o.fecha_entrega BETWEEN '$inicio' AND '$fin'
              AND (o.estatus IS NULL OR o.estatus <> 9);
        ";
        $rows = json_decode($this->ejecutar($sql));
        return is_array($rows) && isset($rows[0]) ? $rows[0] : null;
    }

    public function dameVentasPorDia(string $fechaInicio, string $fechaFin)
    {
        [$inicio, $fin] = $this->rango($fechaInicio, $fechaFin);
        return json_decode($this->ejecutar("
            SELECT
                DATE(o.fecha_entrega) AS fecha,
                COUNT(DISTINCT o.id) AS ordenes,
                COALESCE(SUM(po.precio_unitario * po.cantidad), 0) AS total
            FROM `order` o
            INNER JOIN product_order po ON po.id_orden = o.id
            WHERE o.fecha_entrega BETWEEN '$inicio' AND '$fin'
              AND (o.estatus IS NULL OR o.estatus <> 9)
            GROUP BY DATE(o.fecha_entrega)
            ORDER BY fecha ASC;
        "));
    }

    public function dameProductosVendidos(string $fechaInicio, string $fechaFin)
    {
        [$inicio, $fin] = $this->rango($fechaInicio, $fechaFin);
        return json_decode($this->ejecutar("
            SELECT
                po.id_producto,
                COALESCE(p.name, CONCAT('Producto #', po.id_producto)) AS producto,
                COALESCE(p.code, '') AS codigo,
                SUM(po.cantidad) AS unidades,
                SUM(po.precio_unitario * po.cantidad) AS total,
                AVG(po.precio_unitario) AS precio_promedio
            FROM `order` o
            INNER JOIN product_order po ON po.id_orden = o.id
            LEFT JOIN products p ON p.id = po.id_producto
            WHERE o.fecha_entrega BETWEEN '$inicio' AND '$fin'
              AND (o.estatus IS NULL OR o.estatus <> 9)
            GROUP BY po.id_producto, p.name, p.code
            ORDER BY total DESC, unidades DESC;
        "));
    }

    public function dameClientesVentas(string $fechaInicio, string $fechaFin)
    {
        [$inicio, $fin] = $this->rango($fechaInicio, $fechaFin);
        return json_decode($this->ejecutar("
            SELECT
                o.id_cliente,
                COALESCE(u.nombre, CONCAT('Cliente #', o.id_cliente)) AS cliente,
                COUNT(DISTINCT o.id) AS ordenes,
                SUM(po.total_unidades) AS unidades,
                SUM(po.total_orden) AS total,
                COALESCE(SUM(pg.total_pagado), 0) AS pagado,
                SUM(po.total_orden) - COALESCE(SUM(pg.total_pagado), 0) AS saldo
            FROM `order` o
            INNER JOIN (
                SELECT id_orden, SUM(precio_unitario * cantidad) AS total_orden, SUM(cantidad) AS total_unidades
                FROM product_order
                GROUP BY id_orden
            ) po ON po.id_orden = o.id
            LEFT JOIN (
                SELECT id_orden, SUM(monto) AS total_pagado
                FROM rel_pago_orden
                GROUP BY id_orden
            ) pg ON pg.id_orden = o.id
            LEFT JOIN `user` u ON u.id = o.id_cliente
            WHERE o.fecha_entrega BETWEEN '$inicio' AND '$fin'
              AND (o.estatus IS NULL OR o.estatus <> 9)
            GROUP BY o.id_cliente, u.nombre
            ORDER BY total DESC;
        "));
    }

    public function dameCobranza(string $fechaInicio, string $fechaFin)
    {
        [$inicio, $fin] = $this->rango($fechaInicio, $fechaFin);
        return json_decode($this->ejecutar("
            SELECT
                o.id AS id_orden,
                o.fecha_entrega,
                o.tipo_pago,
                o.estatus,
                COALESCE(u.nombre, CONCAT('Cliente #', o.id_cliente)) AS cliente,
                COALESCE(po.total_orden, 0) AS total,
                COALESCE(pg.total_pagado, 0) AS pagado,
                COALESCE(po.total_orden, 0) - COALESCE(pg.total_pagado, 0) AS saldo
            FROM `order` o
            LEFT JOIN (
                SELECT id_orden, SUM(precio_unitario * cantidad) AS total_orden
                FROM product_order
                GROUP BY id_orden
            ) po ON po.id_orden = o.id
            LEFT JOIN (
                SELECT id_orden, SUM(monto) AS total_pagado
                FROM rel_pago_orden
                GROUP BY id_orden
            ) pg ON pg.id_orden = o.id
            LEFT JOIN `user` u ON u.id = o.id_cliente
            WHERE o.fecha_entrega BETWEEN '$inicio' AND '$fin'
              AND (o.estatus IS NULL OR o.estatus <> 9)
            HAVING saldo > 0.01
            ORDER BY saldo DESC, o.fecha_entrega ASC;
        "));
    }

    public function dameDevoluciones(string $fechaInicio, string $fechaFin)
    {
        [$inicio, $fin] = $this->rango($fechaInicio, $fechaFin);
        return json_decode($this->ejecutar("
            SELECT
                d.id,
                d.id_orden,
                d.id_producto,
                d.cantidad,
                d.motivo,
                d.fecha_ingresa,
                COALESCE(p.name, CONCAT('Producto #', d.id_producto)) AS producto,
                COALESCE(u.nombre, CONCAT('Cliente #', o.id_cliente)) AS cliente,
                COALESCE(po.precio_unitario, p.standard_price, 0) AS precio_referencia,
                d.cantidad * COALESCE(po.precio_unitario, p.standard_price, 0) AS monto_estimado
            FROM devoluciones d
            INNER JOIN `order` o ON o.id = d.id_orden
            LEFT JOIN products p ON p.id = d.id_producto
            LEFT JOIN product_order po ON po.id_orden = d.id_orden AND po.id_producto = d.id_producto
            LEFT JOIN `user` u ON u.id = o.id_cliente
            WHERE d.fecha_ingresa BETWEEN '$inicio' AND '$fin'
            ORDER BY d.fecha_ingresa DESC, d.id DESC;
        "));
    }

    public function dameOrdenesPorEstatus(string $fechaInicio, string $fechaFin)
    {
        [$inicio, $fin] = $this->rango($fechaInicio, $fechaFin);
        return json_decode($this->ejecutar("
            SELECT
                CASE
                    WHEN o.estatus = 9 THEN 'Cancelada'
                    WHEN o.estatus = 2 THEN 'Entregada'
                    WHEN o.estatus = 1 THEN 'En proceso'
                    WHEN o.estatus = 99 THEN 'Aprobada'
                    ELSE 'Pendiente'
                END AS estatus,
                COUNT(*) AS ordenes
            FROM `order` o
            WHERE o.fecha_entrega BETWEEN '$inicio' AND '$fin'
            GROUP BY estatus
            ORDER BY ordenes DESC;
        "));
    }

    public function dameVentasPorTipoPago(string $fechaInicio, string $fechaFin)
    {
        [$inicio, $fin] = $this->rango($fechaInicio, $fechaFin);
        return json_decode($this->ejecutar("
            SELECT
                CASE
                    WHEN o.tipo_pago = 2 THEN 'Credito'
                    WHEN o.tipo_pago = 1 THEN 'Contado'
                    ELSE CONCAT('Tipo ', COALESCE(o.tipo_pago, 0))
                END AS tipo_pago,
                COUNT(DISTINCT o.id) AS ordenes,
                COALESCE(SUM(po.precio_unitario * po.cantidad), 0) AS total
            FROM `order` o
            INNER JOIN product_order po ON po.id_orden = o.id
            WHERE o.fecha_entrega BETWEEN '$inicio' AND '$fin'
              AND (o.estatus IS NULL OR o.estatus <> 9)
            GROUP BY tipo_pago
            ORDER BY total DESC;
        "));
    }

    public function dameCapturistas(string $fechaInicio, string $fechaFin)
    {
        [$inicio, $fin] = $this->rango($fechaInicio, $fechaFin);
        return json_decode($this->ejecutar("
            SELECT
                o.id_crea,
                COALESCE(u.nombre, CONCAT('Usuario #', o.id_crea)) AS capturista,
                COUNT(DISTINCT o.id) AS ordenes,
                COALESCE(SUM(po.precio_unitario * po.cantidad), 0) AS total
            FROM `order` o
            INNER JOIN product_order po ON po.id_orden = o.id
            LEFT JOIN `user` u ON u.id = o.id_crea
            WHERE o.fecha_entrega BETWEEN '$inicio' AND '$fin'
              AND (o.estatus IS NULL OR o.estatus <> 9)
            GROUP BY o.id_crea, u.nombre
            ORDER BY total DESC;
        "));
    }

    public function dameDetalleVentas(string $fechaInicio, string $fechaFin)
    {
        [$inicio, $fin] = $this->rango($fechaInicio, $fechaFin);
        return json_decode($this->ejecutar("
            SELECT
                o.id AS id_orden,
                o.fecha_entrega,
                o.estatus,
                o.tipo_pago,
                COALESCE(u.nombre, CONCAT('Cliente #', o.id_cliente)) AS cliente,
                po.id_producto,
                COALESCE(p.name, CONCAT('Producto #', po.id_producto)) AS producto,
                po.cantidad,
                po.precio_unitario,
                po.cantidad * po.precio_unitario AS total_linea
            FROM `order` o
            INNER JOIN product_order po ON po.id_orden = o.id
            LEFT JOIN products p ON p.id = po.id_producto
            LEFT JOIN `user` u ON u.id = o.id_cliente
            WHERE o.fecha_entrega BETWEEN '$inicio' AND '$fin'
              AND (o.estatus IS NULL OR o.estatus <> 9)
            ORDER BY o.fecha_entrega DESC, o.id DESC;
        "));
    }

    public function dameInventarioProductos()
    {
        return json_decode($this->ejecutar("
            SELECT
                id,
                name AS producto,
                code AS codigo,
                available_quantity AS existencia,
                standard_price AS precio,
                estatus
            FROM products
            ORDER BY available_quantity ASC, name ASC;
        "));
    }
}
