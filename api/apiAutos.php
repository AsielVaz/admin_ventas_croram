<?php

include_once "adminAutos.php";

$accion = $_POST['accion'];

$casoAlta = "alta";
$casoBaja = "baja";
$casoModificacion = "modificacion";

function altaAuto(){
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $color = $_POST['color'];
    $capacidad_kg = $_POST['capacidad'];
    $placas = $_POST['placas'];
    $tipo = $_POST['tipo'];
    $id_cliente = $_POST['id_cliente'];
    $adminAutos = new AdministradorAutos();
    $adminAutos->agregarAuto($marca, $modelo, $color, floatval($capacidad_kg), $placas, $tipo, intval($id_cliente));
    $mensaje = array("mensaje" => "Auto dado de alta", "tipo" => "success");
    echo json_encode($mensaje);
}

function modificarAuto(){
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $color = $_POST['color'];
    $capacidad_kg = $_POST['capacidad'];
    $placas = $_POST['placas'];
    $tipo = $_POST['tipo'];
    $id_cliente = $_POST['id_cliente'];
    $adminAutos = new AdministradorAutos();
    $adminAutos->modificarAuto($id, $marca, $modelo, $color, floatval($capacidad_kg), $placas, $tipo, intval($id_cliente));
    $mensaje = array("mensaje" => "Auto modificado", "tipo" => "success");
    echo json_encode($mensaje);
}

function bajaAuto(){
    $id = $_POST['id'];
    $adminAutos = new AdministradorAutos();
    $adminAutos->bajaAuto($id);
    $mensaje = array("mensaje" => "Auto dado de baja", "tipo" => "success");
    echo json_encode($mensaje);
}

switch($accion){
    case $casoAlta:
        altaAuto();
        break;
    case $casoModificacion:
        modificarAuto();
        break;
    case $casoBaja:
        bajaAuto();
        break;
}

?>