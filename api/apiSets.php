<?php session_start() ?>

<?php

include_once "adminSets.php";

$accion = $_POST['accion'];

$casoAlta = "alta";
$casoBaja = "baja";
$casoModificacion = "modificacion";


 function agregarSetVendedor()
{
    $nombre = $_POST['nombre'];
    $usuario_agrega = $_SESSION['usuario_id'];
    $adminSets = new AdministradorSets();
    $adminSets->agregarSetVendedor($nombre, $usuario_agrega);
    $idSet = $adminSets->dameUltimoIdSetVendedor();
    $items = json_decode($_POST['items'], true);
    foreach ($items as $item) {
        $adminSets->agregarItemSet($idSet, $item['id'], $item['precio'], $usuario_agrega);
    }
    $mensaje = array("mensaje" => "Set de vendedor agregado", "tipo" => "success", "id" => $idSet);
    echo json_encode($mensaje);
}


switch ($accion) {
    case $casoAlta:
        agregarSetVendedor();
        break;
    case $casoBaja:
        //eliminarSetVendedor();
        break;
    case $casoModificacion:
        //modificarSetVendedor();
        break;
    default:
        echo json_encode(array("mensaje" => "Acción no válida", "tipo" => "error"));
        break;
}


