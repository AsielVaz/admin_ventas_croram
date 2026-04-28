<?php

include_once "conector.php";
include_once "naperzClient.php";

class AdministradorProductos extends Con
{
    public function obtenerProductos()
    {
        return json_decode($this->ejecutar("SELECT * FROM products"));
    }
    public function obtenerProducto($id)
    {
        return json_decode($this->ejecutar("SELECT * FROM products WHERE id = $id"))[0];
    }
    public function agregarProducto($nombre, $codigo, $cantidad, $precio, $napers, $imagen, $descripcion, $uom, $peso)
    {
        $query = "INSERT INTO products (name, code, description, available_quantity, standard_price, uom, weight, id_napers, image) VALUES ('$nombre', '$codigo', '$descripcion', $cantidad, $precio, '$uom', $peso, $napers, '$imagen')";
        $this->ejecutar($query);
    }
    public function modificarProducto($id, $nombre, $codigo, $cantidad, $precio, $napers, $imagen, $descripcion, $uom, $peso)
    {
        $query = "UPDATE products SET name = '$nombre', code = '$codigo', description = '$descripcion', available_quantity = $cantidad, standard_price = $precio, uom = '$uom', weight = $peso, id_napers = $napers, image = '$imagen' WHERE id = $id";
        $this->ejecutar($query);
    }
    public function modificarProductoSinImagen($id, $nombre, $codigo, $cantidad, $precio, $napers, $descripcion, $uom, $peso)
    {
        $query = "UPDATE products SET name = '$nombre', code = '$codigo', description = '$descripcion', available_quantity = $cantidad, standard_price = $precio, uom = '$uom', weight = $peso, id_napers = $napers WHERE id = $id";
        $this->ejecutar($query);
    }
    public function cambiarEstatus($id, $estatus)
    {
        $query = "UPDATE products SET estatus = $estatus WHERE id = $id";
        $this->ejecutar($query);
    }
    public function dameProductosApi()
    {
        $naperz = new NaperzClient();
        $response = $naperz->listProducts();
        return $response->items ?? [];
    }
}
