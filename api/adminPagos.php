<?php

include_once "conector.php";

class AdministradorPagos extends Con
{
    //SELECT `id`, `monto`, `id_orden`, `url_ev`, `id_usuario`, `id_inserta`, `fecha_inserta`, `id_napers` FROM `pagos` WHERE 1
    public function agregarPago($monto, $id_orden, $url_ev, $id_usuario, $id_inserta, $id_napers, $tipo_pago)
    {
        $query = "INSERT INTO `pagos`(`monto`, `id_orden`, `url_ev`, `id_usuario`, `id_inserta`, `fecha_inserta`, `id_napers`, `tipo_pago`) VALUES ($monto, $id_orden, '$url_ev', $id_usuario, $id_inserta, NOW(), '$id_napers', '$tipo_pago')";
        return json_decode($this->ejecutar($query));
    }
    public function obtenerPagos()
    {
        $query = "SELECT * FROM `pagos`";
        return json_decode($this->ejecutar($query));
    }
    public function obtenerPago($id)
    {
        $query = "SELECT * FROM `pagos` WHERE `id` = $id";
        return json_decode($this->ejecutar($query))[0];
    }
    public function modificarPago($id, $monto, $id_orden, $url_ev, $id_usuario, $id_napers)
    {
        $query = "UPDATE `pagos` SET `monto`=$monto,`id_orden`=$id_orden,`url_ev`='$url_ev',`id_usuario`=$id_usuario,`id_napers`='$id_napers' WHERE `id` = $id";
        return json_decode($this->ejecutar($query));
    }
    public function bajaPago($id)
    {
        $query = "DELETE FROM `pagos` WHERE `id` = $id";
        return json_decode($this->ejecutar($query));
    }
    public function obtenerPagosDeUsuario($id_usuario)
    {
        $query = "SELECT * FROM `pagos` WHERE `id_usuario` = $id_usuario";
        return json_decode($this->ejecutar($query));
    }

    public function dameUltimoId()
    {
        return json_decode($this->ejecutar("SELECT MAX(`id`) as id FROM `pagos`"))[0]->id;
    }

    public function insertaRelacionPago($id_pago, $id_orden, $monto)
    {
        $query = "INSERT INTO `rel_pago_orden`(`id_orden`, `id_pago`, `monto`, `usuario_asigna`) VALUES ('$id_orden', '$id_pago', '$monto',0)";
        return json_decode($this->ejecutar($query));
    }

    public function dameRelPagoPorOrden($id_orden)
    {
        $sql = "SELECT
                r.id_orden,
                p.id            AS id_pago,          -- Ajusta si tu PK de pagos se llama distinto
                p.monto         AS monto_pago,       -- Monto total del pago
                r.monto         AS monto_acreditado, -- Monto acreditado a ESTA orden
                p.fecha_inserta,
                p.tipo_pago,
                p.url_ev,
                p.id_usuario,
                r.usuario_asigna
                FROM rel_pago_orden AS r
                JOIN pagos AS p
                ON p.id = r.id_pago
                WHERE r.id_orden = $id_orden;";
        return json_decode($this->ejecutar($sql));
    }
}
