<?php
session_start();
include_once "adminDevoluciones.php";

$accion = $_POST['accion'];

$casoAgrega   = "agregarDevolucion";
$casoModificar = "modificarDevolucion";
$casoBaja     = "bajaDevolucion";
$casoObtener  = "obtenerDevolucion";
$casoObtenerTodo = "obtenerDevoluciones";
$casoObtenerConOrdenes = "dameDevolucionesConOrdenes";

function agregarDevolucion(){
    //$id_orden, $id_producto, $cantidad, $motivo, $fecha_ingresa, $usuario_ingresa
    $id_orden = $_POST['id_orden'];
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $motivo = $_POST['motivo'];
    $fecha_ingresa = date("Y-m-d H:i:s");
    $usuario_ingresa =$_SESSION['id_usuario'];
    $adminDevoluciones = new AdministradorDevoluciones();
    $adminDevoluciones->agregarDevolucion($id_orden, $id_producto, $cantidad, $motivo, $fecha_ingresa, $usuario_ingresa);
    $mensaje = array("mensaje" => "Devolucion dada de alta", "tipo" => "success");
    echo json_encode($mensaje);
}

function modificarDevolucion(){
    $id = $_POST['id'];
    $id_orden = $_POST['id_orden'];
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $motivo = $_POST['motivo'];
    $fecha_ingresa = date("Y-m-d H:i:s");
    $usuario_ingresa =$_SESSION['id_usuario'];
    $adminDevoluciones = new AdministradorDevoluciones();
    $adminDevoluciones->modificarDevolucion($id, $id_orden, $id_producto, $cantidad, $motivo, $fecha_ingresa, $usuario_ingresa);
    $mensaje = array("mensaje" => "Devolucion modificada", "tipo" => "success");
    echo json_encode($mensaje);
}

function bajaDevolucion(){
    $id = $_POST['id'];
    $adminDevoluciones = new AdministradorDevoluciones();
    $adminDevoluciones->bajaDevolucion($id);
    $mensaje = array("mensaje" => "Devolucion dada de baja", "tipo" => "success");
    echo json_encode($mensaje);
}

function obtenerDevolucion(){
    $id = $_POST['id'];
    $adminDevoluciones = new AdministradorDevoluciones();
    $devolucion = $adminDevoluciones->obtenerDevolucion($id);
    echo json_encode($devolucion);
}

function obtenerDevoluciones(){
    $adminDevoluciones = new AdministradorDevoluciones();
    $devoluciones = $adminDevoluciones->obtenerDevoluciones();
    echo json_encode($devoluciones);
}

function obtenerDevolucionesConOrdenes(){
    $adminDevoluciones = new AdministradorDevoluciones();
    $devoluciones = $adminDevoluciones->dameDevolucionesConOrdenes();
    echo json_encode($devoluciones);
}



switch ($accion) {
    case $casoAgrega:
        agregarDevolucion();
        break;
    case $casoModificar:
        modificarDevolucion();
        break;
    case $casoBaja:
        bajaDevolucion();
        break;
    case $casoObtener:
        obtenerDevolucion();
        break;
    case $casoObtenerTodo:
        obtenerDevoluciones();
        break;
    case $casoObtenerConOrdenes:
        obtenerDevolucionesConOrdenes();
        break;
    default:
        echo json_encode(array("mensaje" => "Accion no valida", "tipo" => "error"));
        break;
}

?>