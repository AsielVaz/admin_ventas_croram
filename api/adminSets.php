<?php 
include_once "conector.php";

class AdministradorSets extends Con{
    //SELECT `id`, `nombre`, `usuario_agrega`, `fecha_agrega` FROM `set_vendedor` WHERE 1
    //SELECT `id`, `id_set`, `id_producto`, `precio_set`, `id_usuario`, `fecha_agrega` FROM `set_item` WHERE 1
    public function dameSetVendedor(){
        $query = "SELECT `id`, `nombre`, `usuario_agrega`, `fecha_agrega` FROM `set_vendedor` WHERE 1";
        return json_decode($this->ejecutar($query));
    }
    public function dameSetVendedorPorId($id){
        $query = "SELECT `id`, `nombre`, `usuario_agrega`, `fecha_agrega` FROM `set_vendedor` WHERE id = $id";
        return json_decode($this->ejecutar($query) )[0];
    }
    public function agregarSetVendedor($nombre, $usuario_agrega){
        $fecha_agrega = date('Y-m-d H:i:s');
        $query = "INSERT INTO `set_vendedor` (`nombre`, `usuario_agrega`, `fecha_agrega`) VALUES ('$nombre', '$usuario_agrega', '$fecha_agrega')";
        return json_decode($this->ejecutar($query));
    }

    public function dameUltimoIdSetVendedor(){
        $query = "SELECT MAX(id) as ultimo_id FROM `set_vendedor`";
        return json_decode($this->ejecutar($query))[0]->ultimo_id;
    }

    public function eliminarSetVendedor($id){
        $query = "DELETE FROM `set_vendedor` WHERE id = $id";
        return json_decode($this->ejecutar($query));
    }
    public function dameSetItem(){
        $query = "SELECT `id`, `id_set`, `id_producto`, `precio_set`, `id_usuario`, `fecha_agrega` FROM `set_item` WHERE 1";
        return json_decode($this->ejecutar($query));
    }

    public function dameSetItemPorSet($id_set){
        $query = "SELECT `set_item`.*, `name` 
        FROM `set_item` 
        inner join products on products.id = set_item.id_producto
        WHERE id_set = $id_set";
        return json_decode($this->ejecutar($query));
    }

    public function dameSetItemComplex($id_set, $producto){
        $query = "SELECT `set_item`.*, `name` 
        FROM `set_item` 
        inner join products on products.id = set_item.id_producto
        WHERE id_set = $id_set AND id_producto = $producto limit 1";
        return json_decode($this->ejecutar($query) )[0];
    }

    public function eliminaSetItem($id){
        $query = "DELETE FROM `set_item` WHERE id = $id";
        return json_decode($this->ejecutar($query));
    }

    public function eliminarItemsPorSet($id_set){
        $query = "DELETE FROM `set_item` WHERE id_set = $id_set";
        return json_decode($this->ejecutar($query));
    }

    public function agregarItemSet($id_set, $id_producto, $precio_set, $id_usuario){
        $fecha_agrega = date('Y-m-d H:i:s');
        $query = "INSERT INTO `set_item` (`id_set`, `id_producto`, `precio_set`, `id_usuario`, `fecha_agrega`) VALUES ('$id_set', '$id_producto', '$precio_set', '$id_usuario', '$fecha_agrega')";
        return json_decode($this->ejecutar($query));
    }

}


?>