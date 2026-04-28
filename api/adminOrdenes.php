<?php

include_once "conector.php";

class AdministradorOrdenes extends Con
{
    //SELECT `id`, `id_cliente`, `id_veiculo`, `id_price_list`, `fecha_entrega`, `tiempo_entrega`, `detalles` FROM `order` WHERE 1
    public function obtenerOrdenes()
    {
        return json_decode($this->ejecutar("SELECT * FROM `order`"));
    }
    public function sumaCuentaUsuarios($usuario)
    {
        return json_decode($this->ejecutar("SELECT * FROM `order`"));
    }

    public function sumaOrdenesClientes()
    {
        $sql = "SELECT SUM(product_order.precio_unitario * product_order.cantidad), id_cliente
                FROM `order` 
                inner join product_order on product_order.id_orden = `order`.id
                GROUP by id_cliente;";
        return json_decode($this->ejecutar($sql));
    }
    public function obtenerOrdenesUltimoMes()
    {
        return json_decode($this->ejecutar("SELECT * FROM `order` WHERE `fecha_entrega` > DATE_SUB(NOW(), INTERVAL 1 MONTH)"));
    }
    public function obtenerOrdenesPaginacion($rows, $pagina)
    {
        $inicio = ($pagina - 1) * $rows;
        return json_decode($this->ejecutar("SELECT * FROM `order` order by `id` DESC LIMIT $inicio, $rows"));
    }
    public function contarOrdenes()
    {
        return json_decode($this->ejecutar("SELECT COUNT(*) as conteo FROM `order`"))[0]->conteo;
    }
    public function obtenerOrdenesCliente($id_cliente)
    {
        return json_decode($this->ejecutar("SELECT * FROM `order` WHERE `id_cliente` = $id_cliente"));
    }
    public function obtenerOrden($id)
    {
        return json_decode($this->ejecutar("SELECT * FROM `order` WHERE `id` = $id"))[0];
    }
    public function eliminarOrden($id)
    {
        return json_decode($this->ejecutar("DELETE FROM `order` WHERE `id` = $id"));
    }
    public function agregarOrden($id_cliente, $id_veiculo, $id_price_list, $fecha_entrega, $tiempo_entrega, $detalles, $recolector, $tipo_pago, $id_crea, $uso_bascula)
    {
        $id_crea = $id_crea ?? 0;
        $query = "INSERT INTO `order`(`id_cliente`, `id_veiculo`, `id_price_list`, `fecha_entrega`, `tiempo_entrega`, `detalles`, `recolector`, `tipo_pago`, `id_crea`, `uso_bascula`) VALUES ($id_cliente, $id_veiculo, $id_price_list, '$fecha_entrega', '$tiempo_entrega', '$detalles', '$recolector','$tipo_pago', $id_crea, $uso_bascula)";
       // echo $query;
        return json_decode($this->ejecutar($query));
    }
    public function modificarOrden($id, $id_cliente, $id_veiculo, $id_price_list, $fecha_entrega, $tiempo_entrega, $detalles)
    {
        return json_decode($this->ejecutar("UPDATE `order` SET `id_cliente`=$id_cliente,`id_veiculo`=$id_veiculo,`id_price_list`=$id_price_list,`fecha_entrega`='$fecha_entrega',`tiempo_entrega`='$tiempo_entrega',`detalles`='$detalles' WHERE `id` = $id"));
    }
    public function modificarHoraEntrega($id, $tiempo_entrega)
    {
        return json_decode($this->ejecutar("UPDATE `order` SET `tiempo_entrega`='$tiempo_entrega' WHERE `id` = $id"));
    }
    public function modificarFechaEntrega($id, $fecha_entrega)
    {
        return json_decode($this->ejecutar("UPDATE `order` SET `fecha_entrega`='$fecha_entrega' WHERE `id` = $id"));
    }
    public function dameUltimoId()
    {
        return json_decode($this->ejecutar("SELECT MAX(`id`) as id FROM `order`"))[0]->id;
    }
    //SELECT `id`, `id_producto`, `id_orden`, `precio_unitario`, `cantidad` FROM `product_order` WHERE 1
    function agregaProductoOrden($id_producto, $id_orden, $precio_unitario, $cantidad)
    {
        return json_decode($this->ejecutar("INSERT INTO `product_order`(`id_producto`, `id_orden`, `precio_unitario`, `cantidad`) VALUES ($id_producto, $id_orden, $precio_unitario, $cantidad)"));
    }
    function dameProductosOrden($id_orden)
    {
        return json_decode($this->ejecutar("SELECT * FROM `product_order` WHERE `id_orden` = $id_orden"));
    }
    function dameTotalOrden($id_orden)
    {
        return json_decode($this->ejecutar("SELECT sum(precio_unitario * cantidad) as suma FROM `product_order` WHERE `id_orden`  = $id_orden;"));
    }

    //SELECT `id`, `name`, `code`, `description`, `available_quantity`, `standard_price`, `uom`, `weight`, `created_date`, `updated_date`, `id_napers`, `image` FROM `products` WHERE 1
    function dameProductosOrdenCompuestos($id_orden)
    {
        //traer productos de la orden con cantidad y precio 
        $query = "SELECT `product_order`.`id`, `product_order`.`id_producto`, `product_order`.`id_orden`, `product_order`.`precio_unitario`, `product_order`.`cantidad`, `products`.`name`, `products`.`code`, `products`.`description`, `products`.`available_quantity`, `products`.`standard_price`, `products`.`uom`, `products`.`weight`, `products`.`created_date`, `products`.`updated_date`, `products`.`id_napers`, `products`.`image` FROM `product_order` INNER JOIN `products` ON `product_order`.`id_producto` = `products`.`id` WHERE `product_order`.`id_orden` = $id_orden";
        return json_decode($this->ejecutar($query));
    }
    function damePrimeraOrdenSinAprovar()
    {
        return json_decode($this->ejecutar("SELECT * FROM `order` WHERE `estatus` = 0 LIMIT 1"))[0];
    }
    function aprobarOrden($id, $fecha, $notas)
    {
        return json_decode($this->ejecutar("UPDATE `order` SET `estatus`=1, `fecha_entrega`='$fecha', `detalles`='$notas' WHERE `id` = $id"));
    }
    function modificarTiempoEntrega($id, $tiempo_entrega)
    {
        return json_decode($this->ejecutar("UPDATE `order` SET `tiempo_entrega`='$tiempo_entrega' WHERE `id` = $id"));
    }
    function modificarEstatus($id, $estatus)
    {
        return json_decode($this->ejecutar("UPDATE `order` SET `estatus`=$estatus WHERE `id` = $id"));
    }
    function rechazarOrden($id, $fecha, $notas)
    {
        return json_decode($this->ejecutar("UPDATE `order` SET `estatus`=9, `fecha_entrega`='$fecha', `detalles`='$notas' WHERE `id` = $id"));
    }
    function dameOrdenesPorDia($fecha)
    {
        return json_decode($this->ejecutar("SELECT * FROM `order` WHERE `fecha_entrega` like '$fecha%'"));
    }
    function dameOrdenesPorMes($mes)
    {
        return json_decode($this->ejecutar("SELECT * FROM `order` WHERE `fecha_entrega` like '$mes%'"));
    }
    function dameOrdenesPorAnio($anio)
    {
        return json_decode($this->ejecutar("SELECT * FROM `order` WHERE `fecha_entrega` like '$anio%'"));
    }
    function dameOrdenesDeUsuario($id_usuario)
    {
        return json_decode($this->ejecutar("SELECT * FROM `order` WHERE `id_cliente` = $id_usuario"));
    }


    function dameReporteVentas($fecha_inicio, $fecha_fin)
    {
        $sql = "
          SELECT
    o.id AS id_orden,
    o.id_cliente,
    COALESCE(u.nombre, CONCAT('Cliente #', o.id_cliente)) AS cliente,
    po.id_producto,
    p.name AS producto,
    po.cantidad,
    po.precio_unitario,
    (po.cantidad * po.precio_unitario) AS total_linea,
    o.fecha_entrega
        FROM `order` o
        INNER JOIN product_order po ON o.id = po.id_orden
        LEFT JOIN `products` p ON po.id_producto = p.id
        LEFT JOIN `user` u ON o.id_cliente = u.id
        WHERE o.fecha_entrega BETWEEN '$fecha_inicio' AND '$fecha_fin'
        -- si deseas filtrar por cliente en específico:
        -- AND o.id_cliente = :id_usuario
        ORDER BY o.fecha_entrega, o.id, po.id_producto;";
        return json_decode($this->ejecutar($sql));
    }

    function dameReporteVentasDetallado($fecha_inicio, $fecha_fin)
    {
        $sql = "
            SELECT
                o.id AS id_orden,
                o.id_cliente,
                COALESCE(u.nombre, CONCAT('Cliente #', o.id_cliente)) AS cliente,
                o.fecha_entrega,
                o.fecha_inserta,
                o.estatus,
                o.tipo_pago,
                po.id_producto,
                COALESCE(p.name, CONCAT('Producto #', po.id_producto)) AS producto,
                po.cantidad,
                po.precio_unitario,
                (po.cantidad * po.precio_unitario) AS total_linea,
                COALESCE(pagos.total_pagado, 0) AS total_pagado_orden
            FROM `order` o
            INNER JOIN product_order po ON o.id = po.id_orden
            LEFT JOIN `products` p ON po.id_producto = p.id
            LEFT JOIN `user` u ON o.id_cliente = u.id
            LEFT JOIN (
                SELECT r.id_orden, SUM(r.monto) AS total_pagado
                FROM rel_pago_orden r
                INNER JOIN pagos p ON p.id = r.id_pago
                WHERE (p.activo IS NULL OR p.activo = 1)
                GROUP BY id_orden
            ) pagos ON pagos.id_orden = o.id
            WHERE o.fecha_entrega BETWEEN '$fecha_inicio' AND '$fecha_fin'
            AND (o.estatus IS NULL OR o.estatus <> 9)
            ORDER BY o.fecha_entrega DESC, o.id DESC, po.id_producto ASC;
        ";
        return json_decode($this->ejecutar($sql));
    }


    function dameOrdenesDeUsuarioCompuestos($id_usuario)
    {
        //SELECT `id`, `marca`, `modelo`, `color`, `capacidad_kg`, `placas`, `tipo`, `id_cliente` FROM `autos` WHERE 1 
        $query = "SELECT 
                    o.id,
                    o.id_cliente,
                    o.id_veiculo,
                    o.id_price_list,
                    o.fecha_entrega,
                    o.tiempo_entrega,
                    o.detalles,
                    o.recolector,
                    o.fecha_inserta,
                    o.estatus,
                    o.comprobante,
                    o.id_napers,
                    o.tipo_pago,
                    o.id_cliente_vendedor,
                    o.id_crea,
                    COALESCE(po.total_orden, 0)   AS total_orden,
                    COALESCE(rp.total_pagado, 0)  AS total_pagado,
                    (COALESCE(po.total_orden, 0) - COALESCE(rp.total_pagado, 0)) AS insoluto
                FROM `order` o
                LEFT JOIN (
                    SELECT id_orden, SUM(precio_unitario * cantidad) AS total_orden
                    FROM product_order
                    GROUP BY id_orden
                ) po ON o.id = po.id_orden
                LEFT JOIN (
                    SELECT r.id_orden, SUM(r.monto) AS total_pagado
                    FROM rel_pago_orden r
                    INNER JOIN pagos p ON p.id = r.id_pago
                    WHERE (p.activo IS NULL OR p.activo = 1)
                    GROUP BY id_orden
                ) rp ON o.id = rp.id_orden
                WHERE o.id_cliente = $id_usuario
                HAVING insoluto >= 1;
            ";
        ///echo $query;
        return json_decode($this->ejecutar($query));
    }

    function dameOrdenesDeUsuarioCompuestosComplex($id_usuario)
    {
        //SELECT `id`, `marca`, `modelo`, `color`, `capacidad_kg`, `placas`, `tipo`, `id_cliente` FROM `autos` WHERE 1 
        $query = "SELECT 
                    o.id,
                    o.id_cliente,
                    o.id_veiculo,
                    o.id_price_list,
                    o.fecha_entrega,
                    o.tiempo_entrega,
                    o.detalles,
                    o.recolector,
                    o.fecha_inserta,
                    o.estatus,
                    o.comprobante,
                    o.id_napers,
                    o.tipo_pago,
                    o.id_cliente_vendedor,
                    o.id_crea,
                    COALESCE(po.total_orden, 0)   AS total_orden,
                    COALESCE(rp.total_pagado, 0)  AS total_pagado,
                    (COALESCE(po.total_orden, 0) - COALESCE(rp.total_pagado, 0)) AS insoluto
                FROM `order` o
                LEFT JOIN (
                    SELECT id_orden, SUM(precio_unitario * cantidad) AS total_orden
                    FROM product_order
                    GROUP BY id_orden
                ) po ON o.id = po.id_orden
                LEFT JOIN (
                    SELECT r.id_orden, SUM(r.monto) AS total_pagado
                    FROM rel_pago_orden r
                    INNER JOIN pagos p ON p.id = r.id_pago
                    WHERE (p.activo IS NULL OR p.activo = 1)
                    GROUP BY id_orden
                ) rp ON o.id = rp.id_orden
                WHERE o.id_cliente = $id_usuario
            ";
        //echo $query;
        return json_decode($this->ejecutar($query));
    }
    function actualizaIdNapers($id, $id_napers)
    {
        return json_decode($this->ejecutar("UPDATE `order` SET `id_napers`='$id_napers' WHERE `id` = $id"));
    }

    function dameEstadisticasOrdenes($fecha_inicio, $fecha_fin)
    {
        return json_decode($this->ejecutar("
                                       SELECT 
                            p.id AS id_producto,
                            p.image as imagen,
                            p.name AS nombre_producto,
                            SUM(po.cantidad) AS cantidad_total,
                            ROUND(100 * SUM(po.cantidad) / total.total_cantidad, 2) AS porcentaje
                        FROM product_order po
                        INNER JOIN products p ON p.id = po.id_producto
                        INNER JOIN `order` o ON o.id = po.id_orden
                        INNER JOIN (
                            SELECT SUM(po2.cantidad) AS total_cantidad
                            FROM product_order po2
                            INNER JOIN `order` o2 ON o2.id = po2.id_orden
                            WHERE o2.fecha_inserta BETWEEN '$fecha_inicio' AND '$fecha_fin'
                        ) AS total
                        WHERE o.fecha_inserta BETWEEN '$fecha_inicio' AND '$fecha_fin'
                        GROUP BY p.id, p.name
                        ORDER BY cantidad_total DESC;
"));
    }


    function dameEstadisticasAnio()
    {
        $query = "
                    SELECT 
                        YEAR(o.fecha_inserta) AS anio,
                        MONTH(o.fecha_inserta) AS mes,
                        DATE_FORMAT(o.fecha_inserta, '%M %Y') AS periodo,
                        ROUND(SUM(po.cantidad * po.precio_unitario), 2) AS total_ganado
                    FROM product_order po
                    INNER JOIN `order` o ON o.id = po.id_orden
                    WHERE o.fecha_inserta IS NOT NULL
                    AND (o.estatus IS NULL OR o.estatus <> 9)
                    GROUP BY anio, mes
                    ORDER BY anio DESC, mes DESC;
                    ";
        return json_decode($this->ejecutar($query));
    }


    function dameEstadisticasVentasUsuarios($fechaInicio, $fechaFin)
    {
        $sql = "SELECT
    o.id_cliente,
    COALESCE(u.nombre, CONCAT('Cliente #', o.id_cliente)) AS cliente,
    COUNT(DISTINCT o.id) AS pedidos,
    SUM(po.cantidad) AS total_unidades,
    SUM(po.cantidad * po.precio_unitario) AS monto_acumulado
        FROM `order` o
        INNER JOIN product_order po ON o.id = po.id_orden
        LEFT JOIN `user` u ON o.id_cliente = u.id
        WHERE o.fecha_entrega BETWEEN '$fechaInicio' AND '$fechaFin'
        GROUP BY o.id_cliente
        HAVING SUM(po.cantidad * po.precio_unitario) > 0
        ORDER BY monto_acumulado DESC;";
        return json_decode($this->ejecutar($sql));
    }

    function dameReporteVentasUsuario($usuario)
    {
        $sql = "SELECT
    p.id AS id_producto,
    p.name AS producto,
    SUM(po.cantidad) AS total_unidades,
    SUM(po.cantidad * po.precio_unitario) AS total_gastado
    FROM `order` o
    INNER JOIN product_order po ON o.id = po.id_orden
    INNER JOIN products p ON po.id_producto = p.id
    WHERE o.id_cliente = $usuario
    GROUP BY p.id, p.name
    HAVING SUM(po.cantidad) > 0
    ORDER BY total_gastado DESC;";
        return json_decode($this->ejecutar($sql));
    }

    function dameEstadisticasAvanzadasClientes($fechaInicio, $fechaFin)
    {
        $sql = "SELECT
    o.id_cliente,
    COALESCE(u.nombre, CONCAT('Cliente #', o.id_cliente)) AS cliente,
    COUNT(DISTINCT o.id) AS pedidos,
    SUM(COALESCE(po.total_unidades, 0)) AS total_unidades,
    SUM(COALESCE(po.total_orden, 0)) AS monto_acumulado,
    COALESCE(pag.total_pagado, 0) AS total_pagado,
    (SUM(COALESCE(po.total_orden, 0)) - COALESCE(pag.total_pagado, 0)) AS saldo,
    CASE
        WHEN (SUM(COALESCE(po.total_orden, 0)) - COALESCE(pag.total_pagado, 0)) <= 0 THEN 'pagado'
        ELSE 'pendiente'
    END AS estado
FROM `order` o
LEFT JOIN (
    -- totales por orden
    SELECT id_orden, SUM(precio_unitario * cantidad) AS total_orden, SUM(cantidad) AS total_unidades
    FROM product_order
    GROUP BY id_orden
) po ON o.id = po.id_orden
LEFT JOIN `user` u ON o.id_cliente = u.id
LEFT JOIN (
    -- pagos totales por usuario
    SELECT id_usuario, SUM(monto) AS total_pagado
    FROM pagos
    WHERE (`activo` IS NULL OR `activo` = 1)
    GROUP BY id_usuario
) pag ON o.id_cliente = pag.id_usuario
WHERE o.fecha_entrega BETWEEN '$fechaInicio' AND '$fechaFin'
GROUP BY o.id_cliente
ORDER BY saldo DESC, monto_acumulado DESC;
";
        return json_decode($this->ejecutar($sql));
    }
}
