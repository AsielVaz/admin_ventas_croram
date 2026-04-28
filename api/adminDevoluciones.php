<?php 
include_once "conector.php";

//SELECT `id`, `id_orden`, `id_producto`, `cantidad`, `motivo`, `fecha_ingresa`, `usuario_ingresa` FROM `devoluciones` WHERE 1
//SELECT `id`, `id_cliente`, `id_veiculo`, `id_price_list`, `fecha_entrega`, `tiempo_entrega`, `detalles`, `recolector`, `fecha_inserta`, `estatus`, `comprobante`, `id_napers`, `tipo_pago` FROM `order` WHERE 1
//SELECT `id`, `name`, `code`, `description`, `available_quantity`, `standard_price`, `uom`, `weight`, `created_date`, `updated_date`, `id_napers`, `image`, `estatus` FROM `products` WHERE 1
class AdministradorDevoluciones extends Con{
    public function obtenerDevoluciones(){
        $query = "SELECT `id`, `id_orden`, `id_producto`, `cantidad`, `motivo`, `fecha_ingresa`, `usuario_ingresa` FROM `devoluciones` WHERE 1";
        return json_decode($this->ejecutar($query));
    }
    public function obtenerDevolucion($id){
        $query = "SELECT `id`, `id_orden`, `id_producto`, `cantidad`, `motivo`, `fecha_ingresa`, `usuario_ingresa` FROM `devoluciones` WHERE id = $id";
        return json_decode($this->ejecutar($query))[0];
    }
    public function agregarDevolucion($id_orden, $id_producto, $cantidad, $motivo, $fecha_ingresa, $usuario_ingresa){
        $query = "INSERT INTO devoluciones (id_orden, id_producto, cantidad, motivo, fecha_ingresa, usuario_ingresa) VALUES ($id_orden, $id_producto, $cantidad, '$motivo', '$fecha_ingresa', '$usuario_ingresa')";
        echo $query;
        return json_decode($this->ejecutar($query));
    }
    public function modificarDevolucion($id, $id_orden, $id_producto, $cantidad, $motivo, $fecha_ingresa, $usuario_ingresa){
        $query = "UPDATE devoluciones SET id_orden = $id_orden, id_producto = $id_producto, cantidad = $cantidad, motivo = '$motivo', fecha_ingresa = '$fecha_ingresa', usuario_ingresa = '$usuario_ingresa' WHERE id = $id";
        return json_decode($this->ejecutar($query));
    }
    public function bajaDevolucion($id){
        $query = "DELETE FROM devoluciones WHERE id = $id";
        return json_decode($this->ejecutar($query));
    }
    public function dameDevolucionesConOrdenes(){
        $query = "SELECT `devoluciones`.`id`, `devoluciones`.`id_orden`, `devoluciones`.`id_producto`, `devoluciones`.`cantidad`, `devoluciones`.`motivo`, `devoluciones`.`fecha_ingresa`, `devoluciones`.`usuario_ingresa`, `order`.`id_cliente`, `order`.`recolector`, `order`.`tipo_pago` FROM devoluciones INNER JOIN order ON devoluciones.id_orden = order.id";
        return json_decode($this->ejecutar($query));
    }
    public function dameDevolucionConOrden($id){
        $query = "SELECT `devoluciones`.`id`, `devoluciones`.`id_orden`, `devoluciones`.`id_producto`, `devoluciones`.`cantidad`, `devoluciones`.`motivo`, `devoluciones`.`fecha_ingresa`, `devoluciones`.`usuario_ingresa`, `order`.`id_cliente`, `order`.`recolector`, `order`.`tipo_pago` FROM devoluciones INNER JOIN order ON devoluciones.id_orden = order.id WHERE devoluciones.id = $id";
        return json_decode($this->ejecutar($query))[0];
    }
    public function dameDevolucionConOrdenes($id_orden){
        $query = "SELECT `devoluciones`.`id`, `devoluciones`.`id_orden`, `devoluciones`.`id_producto`, `devoluciones`.`cantidad`, `devoluciones`.`motivo`, `devoluciones`.`fecha_ingresa`, `devoluciones`.`usuario_ingresa`, `order`.`id_cliente`, `order`.`recolector`, `order`.`tipo_pago` FROM devoluciones INNER JOIN order ON devoluciones.id_orden = order.id WHERE devoluciones.id_orden = $id_orden";
        return json_decode($this->ejecutar($query));
    }
    public function dameDevolucionConOrdenesUltimoMes($id_orden){
        $query = "SELECT `devoluciones`.`id`, `devoluciones`.`id_orden`, `devoluciones`.`id_producto`, `devoluciones`.`cantidad`, `devoluciones`.`motivo`, `devoluciones`.`fecha_ingresa`, `devoluciones`.`usuario_ingresa`, `order`.`id_cliente`, `order`.`recolector`, `order`.`tipo_pago` FROM devoluciones INNER JOIN order ON devoluciones.id_orden = order.id WHERE devoluciones.id_orden = $id_orden AND devoluciones.fecha_ingresa > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        return json_decode($this->ejecutar($query));
    }
    function dameDevolucionesConTodo (){
        $query = "SELECT `devoluciones`.`id`, `devoluciones`.`id_orden`, `devoluciones`.`id_producto`, `devoluciones`.`cantidad`, `devoluciones`.`motivo`, `devoluciones`.`fecha_ingresa`, `devoluciones`.`usuario_ingresa`, `order`.`id_cliente`, `order`.`recolector`, `order`.`tipo_pago`, `products`.`name` FROM devoluciones INNER JOIN `order` ON devoluciones.id_orden = `order`.id INNER JOIN products ON devoluciones.id_producto = products.id";
        //echo $query;
        return json_decode($this->ejecutar($query));
    }
}