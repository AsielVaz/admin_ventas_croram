<?php
include_once "conector.php";
include_once "naperzClient.php";
class AdministradorUsuarios extends Con
{
    public function dameUsuarios()
    {
        $query = "SELECT * FROM user";
        $usuarios = $this->ejecutar($query);
        return json_decode($usuarios);
    }

    public function dameUsuario($id)
    {
        $query = "SELECT * FROM user WHERE id = $id";
        $usuario = $this->ejecutar($query);
        return json_decode($usuario)[0];
    }
    public function altaUsuario($nombre, $correo, $pass, $id_cliente, $estatus, $id_crea, $tipo, $auto_orden, $id_set, $dias_pago)
    {
        $pass = md5(sha1($pass));
        $query = "INSERT INTO user (nombre, correo, pass, id_cliente
        , estatus, id_crea, tipo, auto_orden, id_set, dias_pago) VALUES ('$nombre', '$correo', '$pass', $id_cliente, $estatus, $id_crea, '$tipo', $auto_orden, $id_set, $dias_pago)";
        $this->ejecutar($query);
    }
    public function modificarUsuario($id, $nombre, $correo, $pass, $id_cliente, $estatus, $id_crea, $tipo, $auto_orden, $id_set, $dias_pago)
    {
        $pass = md5(sha1($pass));
        $query = "UPDATE user SET nombre = '$nombre', correo = '$correo', pass = '$pass', id_cliente = $id_cliente, estatus = $estatus, tipo = '$tipo', id_crea = $id_crea, auto_orden = $auto_orden, id_set = $id_set, dias_pago = $dias_pago WHERE id = $id";
       // echo $query;
        $this->ejecutar($query);
    }
    public function dameSumaOrdenesCredito($usuario){
        $query = "select (sum(precio_unitario * cantidad)) as total from `order`
                    inner join `product_order`
                    on `order`.`id` = `product_order`.`id_orden`
                    where `order`.`id_cliente`= $usuario and `order`.`tipo_pago`= 2 and `order`.`estatus` != 9;";
        $total = $this->ejecutar($query);
        return json_decode($total)[0]->total;
    }

    public function loginCliente($correo, $pass){
        $pass = md5(sha1($pass));
        $query = "SELECT * FROM user WHERE correo = '$correo' AND pass = '$pass'";
        $usuario = $this->ejecutar($query);
        return json_decode($usuario)[0];
    }

    public function dameUsuariosApi()
    {
        return $this->dameClientesApi();
    }

    public function dameClientesApi()
    {
        $naperz = new NaperzClient();
        $response = $naperz->listClients();
        return $response->items ?? [];
    }

    public function dameUsuariosNapersApi()
    {
        $naperz = new NaperzClient();
        $response = $naperz->listUsers();
        return $response->items ?? [];
    }

    public function dameUsuarioApi($id){
        $naperz = new NaperzClient();
        return $naperz->getClient(intval($id));
    }

    public function dameUsuarioNapersApi($id)
    {
        $naperz = new NaperzClient();
        return $naperz->getUser(intval($id));
    }
}
