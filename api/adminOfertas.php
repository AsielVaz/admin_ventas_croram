<?php 
include_once "conector.php";


class AdministradorOfertas extends Con{
    //SELECT `id`, `id_producto_det`, `id_producto_of`, `cantidad_det`, `porc_oferta`, `tipo_oferta`, `cantidad_oferta`, `fecha_inicia`, `fecha_fin` FROM `promo` WHERE 1    
    public function agregarOferta($id_producto_det, $id_producto_of, $cantidad_det, $porc_oferta, $tipo_oferta, $cantidad_oferta, $fecha_inicia, $fecha_fin){
        $query = "INSERT INTO `promo`(`id_producto_det`, `id_producto_of`, `cantidad_det`, `porc_oferta`, `tipo_oferta`, `cantidad_oferta`, `fecha_inicia`, `fecha_fin`) VALUES ($id_producto_det, $id_producto_of, $cantidad_det, $porc_oferta, $tipo_oferta, $cantidad_oferta, '$fecha_inicia', '$fecha_fin')";
        return json_decode($this->ejecutar($query));
    }
    public function obtenerOfertas(){
        $query = "SELECT `promo`.*, `products`.`name` as `product_name` FROM `promo` 
        inner join products on products.id = promo.id_producto_det
        WHERE 1";
        return json_decode($this->ejecutar($query));
    }
    public function obtenerOferta($id){
        $query = "SELECT `id`, `id_producto_det`, `id_producto_of`, `cantidad_det`, `porc_oferta`, `tipo_oferta`, `cantidad_oferta`, `fecha_inicia`, `fecha_fin` FROM `promo` WHERE `id` = $id";
        return json_decode($this->ejecutar($query))[0];
    }
    public function modificarOferta($id, $id_producto_det, $id_producto_of, $cantidad_det, $porc_oferta, $tipo_oferta, $cantidad_oferta, $fecha_inicia, $fecha_fin){
        $query = "UPDATE `promo` SET `id_producto_det`=$id_producto_det,`id_producto_of`=$id_producto_of,`cantidad_det`=$cantidad_det,`porc_oferta`=$porc_oferta,`tipo_oferta`=$tipo_oferta,`cantidad_oferta`=$cantidad_oferta,`fecha_inicia`='$fecha_inicia',`fecha_fin`='$fecha_fin' WHERE `id` = $id";
        return json_decode($this->ejecutar($query));
    }
    public function bajaOferta($id){
        $query = "DELETE FROM `promo` WHERE `id` = $id";
        return json_decode($this->ejecutar($query));
    }
    public function dameOfertaProducto($producto_det){
        $query = "SELECT `id`, `id_producto_det`, `id_producto_of`, `cantidad_det`, `porc_oferta`, `tipo_oferta`, `cantidad_oferta`, `fecha_inicia`, `fecha_fin` FROM `promo` WHERE `id_producto_det` = $producto_det order by id desc limit 1";
        return json_decode($this->ejecutar($query))[0];
    }

     public function dameOfertaProductoFecha($producto_det, $fecha_actual){
        $query = "SELECT `id`, `id_producto_det`, `id_producto_of`, `cantidad_det`, `porc_oferta`, `tipo_oferta`, `cantidad_oferta`, `fecha_inicia`, `fecha_fin` FROM `promo` WHERE `id_producto_det` = $producto_det and `fecha_inicia` <= '$fecha_actual' and `fecha_fin` >= '$fecha_actual' order by id desc limit 1";
        return json_decode($this->ejecutar($query))[0];
    }
    public function dameOfertaProductoInvertida($producto_of){
        $query = "SELECT `id`, `id_producto_det`, `id_producto_of`, `cantidad_det`, `porc_oferta`, `tipo_oferta`, `cantidad_oferta`, `fecha_inicia`, `fecha_fin` FROM `promo` WHERE `id_producto_of` = $producto_of order by id desc limit 1";
        return json_decode($this->ejecutar($query))[0];
    }
      public function dameOfertaProductoInvertidaFecha($producto_of, $fecha_actual){
        $query = "SELECT `id`, `id_producto_det`, `id_producto_of`, `cantidad_det`, `porc_oferta`, `tipo_oferta`, `cantidad_oferta`, `fecha_inicia`, `fecha_fin` FROM `promo` WHERE `id_producto_of` = $producto_of and `fecha_inicia` <= '$fecha_actual' and `fecha_fin` >= '$fecha_actual' order by id desc limit 1";
        return json_decode($this->ejecutar($query))[0];
    }
    public function obtenerOfertasActivas(){
        $query = "SELECT `id`, `id_producto_det`, `id_producto_of`, `cantidad_det`, `porc_oferta`, `tipo_oferta`, `cantidad_oferta`, `fecha_inicia`, `fecha_fin` FROM `promo` WHERE `fecha_inicia` <= CURDATE() AND `fecha_fin` >= CURDATE()";
        return json_decode($this->ejecutar($query));
    }
    
}

?>