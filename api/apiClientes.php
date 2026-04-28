<?php session_start() ?>

<?php

include_once "adminClientes.php";

$accion = $_POST['accion'];

$casoAlta = "alta";
$casoBaja = "baja";
$casoModificacion = "modificacion";
$casoLogin = "login";


function altaCliente()
{
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];
    $telefono = $_POST['telefono'];
    $id_cliente = $_POST['id_vendedor'];
    $adminClientes = new AdministradorClientes();
    //$nombre, $correo, $telefono, $id_vendedor
    $adminClientes->altaCliente($nombre, $correo, $telefono, $id_cliente);
    $mensaje = array("mensaje" => "Cliente dado de alta", "tipo" => "success");
    echo json_encode($mensaje);
}

function bajaCliente()
{
    $id_cliente = $_POST['id_cliente'];
    $adminClientes = new AdministradorClientes();
    $adminClientes->eliminarCliente($id_cliente);
    $mensaje = array("mensaje" => "Cliente dado de baja", "tipo" => "success");
    echo json_encode($mensaje);
}

function modificacionCliente()
{
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];
    $telefono = $_POST['telefono'];
    $estatus = $_POST['estatus'];
    $adminClientes = new AdministradorClientes();
    $adminClientes->actualizarCliente($id_cliente, $nombre, $correo, $telefono, $estatus);
    $mensaje = array("mensaje" => "Cliente modificado", "tipo" => "success");
    echo json_encode($mensaje);
}


switch ($accion) {
    case $casoAlta:
        altaCliente();
        break;
    case $casoBaja:
        bajaCliente();
        break;
    case $casoModificacion:
        modificacionCliente();
        break;

    default:
        echo json_encode(array("mensaje" => "Acción no válida", "tipo" => "error"));
        break;
}


