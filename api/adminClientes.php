<?php
include_once "conector.php";

//SELECT `id`, `nombre`, `correo`, `telefono`, `id_vendedor`, `fecha_captura` FROM `vendedor_clientes` WHERE 1
class AdministradorClientes extends Con
{
    public function dameClientes()
    {
        $query = "SELECT vendedor_clientes.*, user.nombre as nombre_vendedor
        FROM vendedor_clientes
        inner join user on user.id = vendedor_clientes.id_vendedor";
        $clientes = $this->ejecutar($query);
        return json_decode($clientes);
    }

    public function dameCliente($id)
    {
        $query = "SELECT * FROM vendedor_clientes WHERE id = $id";
        $cliente = $this->ejecutar($query);
        return json_decode($cliente)[0];
    }

    public function altaCliente($nombre, $correo, $telefono, $id_vendedor)
    {
        $query = "INSERT INTO vendedor_clientes (nombre, correo, telefono, id_vendedor) VALUES ('$nombre', '$correo', '$telefono', $id_vendedor)";
        return $this->ejecutar($query);
    }
    public function actualizarCliente($id, $nombre, $correo, $telefono, $estatus)
    {
        $query = "UPDATE vendedor_clientes SET nombre = '$nombre', correo = '$correo', telefono = '$telefono', estatus = '$estatus' WHERE id = $id";
        return $this->ejecutar($query);
    }
    public function eliminarCliente($id)
    {
        $query = "DELETE FROM vendedor_clientes WHERE id = $id";
        return $this->ejecutar($query);
    }

    public function dameClienteVendedor($id_vendedor)
    {
        $query = "SELECT * FROM vendedor_clientes WHERE id_vendedor = $id_vendedor";
        $clientes = $this->ejecutar($query);
        return json_decode($clientes);
    }
}
