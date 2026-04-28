<?php session_start() ?>

<?php

include_once "adminUsuarios.php";

$accion = $_POST['accion'];

$casoAlta = "alta";
$casoBaja = "baja";
$casoModificacion = "modificacion";
$casoLogin = "login";



function altaUsuario()
{
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];
    $pass = $_POST['pass'];
    $id_cliente = $_POST['id_cliente'];
    $estatus = $_POST['estatus'];
    $tipo = $_POST['tipo'];
    $id_crea = 1;
    $id_set = $_POST['id_set'];
    $auto_orden = $_POST['auto_orden'];
    $dias_pago = $_POST['dias_pago'];

    $adminUsuarios = new AdministradorUsuarios();
    $adminUsuarios->altaUsuario($nombre, $correo, $pass, $id_cliente, $estatus, $id_crea, $tipo, $auto_orden, $id_set, $dias_pago);
    $mensaje = array("mensaje" => "Usuario dado de alta", "tipo" => "success");
    echo json_encode($mensaje);
}

function modificarUsuario()
{
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];
    $pass = $_POST['pass'];
    $id_cliente = $_POST['id_cliente'];
    $estatus = $_POST['estatus'];
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $id_crea = 1;
    $auto_orden = $_POST['auto_orden'];
    $id_set = $_POST['id_set'];
    $dias_pago = $_POST['dias_pago'];

    $adminUsuarios = new AdministradorUsuarios();
    $adminUsuarios->modificarUsuario($id, $nombre, $correo, $pass, $id_cliente, $estatus, $id_crea, $tipo, $auto_orden, $id_set, $dias_pago);
    $mensaje = array("mensaje" => "Usuario modificado", "tipo" => "success");
    echo json_encode($mensaje);
}

function loginUsuario()
{
    $correo = $_POST['email'];
    $pass = $_POST['pass'];
    $adminUsuarios = new AdministradorUsuarios();
    $usuario = $adminUsuarios->loginCliente($correo, $pass);
    if ($usuario) {
        $_SESSION['usuario'] = $usuario->nombre;
        $_SESSION['id_usuario'] = $usuario->id;
        $_SESSION['correo'] = $usuario->correo;
        $_SESSION['id_cliente'] = $usuario->id_cliente;
        //setcookie('usuario', $usuario->nombre, time() + 3600, '/'); // Duración de 1 hora
        //setcookie('id_usuario', $usuario->id, time() + 3600, '/'); // Duración de 1 hora

        $mensaje = array("mensaje" => "Bienvenido " . $_SESSION['usuario'], "tipo" => "success");
        echo json_encode($mensaje);
    } else {
        $mensaje = array("mensaje" => "Usuario no encontrado o contraseña incorrecta", "tipo" => "error");
        echo json_encode($mensaje);
    }
}

switch ($accion) {
    case $casoAlta:
        altaUsuario();
        break;
    case $casoBaja:
        break;
    case $casoModificacion:
        modificarUsuario();
        break;
    case $casoLogin:
        loginUsuario();
        break;
}
