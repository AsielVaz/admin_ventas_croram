<?php 

include_once "adminOfertas.php";

$accion = $_POST['accion'];

$casoAlta = "alta";
$casoBaja = "baja";
$casoModificacion = "modificacion";


function altaOferta(){
    $id_producto_det = $_POST['producto_det'];
    $id_producto_of = $_POST['producto_of'];
    $cantidad_det = $_POST['cantidad_det'];
    $porc_oferta = $_POST['porc_oferta'];
    $tipo_oferta = $_POST['tipo_oferta'];
    $cantidad_oferta = $_POST['cantidad_oferta'];
    $fecha_inicia = $_POST['fecha_inicia'];
    $fecha_fin = $_POST['fecha_fin'];
    $adminOfertas = new AdministradorOfertas();
    $adminOfertas->agregarOferta($id_producto_det, intval($id_producto_of), intval($cantidad_det), intval($porc_oferta), $tipo_oferta, intval($cantidad_oferta), $fecha_inicia, $fecha_fin);
    $mensaje = array("mensaje" => "Oferta dada de alta", "tipo" => "success");
    echo json_encode($mensaje);
}

function bajaOferta(){
    $id = $_POST['id'];
    $adminOfertas = new AdministradorOfertas();
    $adminOfertas->bajaOferta($id);
    $mensaje = array("mensaje" => "Oferta dada de baja", "tipo" => "success");
    echo json_encode($mensaje);
}

function modificarOferta(){
    $id = $_POST['id'];
    $id_producto_det = $_POST['producto_det'];
    $id_producto_of = $_POST['producto_of'];
    $cantidad_det = $_POST['cantidad_det'];
    $porc_oferta = $_POST['porc_oferta'];
    $tipo_oferta = $_POST['tipo_oferta'];
    $cantidad_oferta = $_POST['cantidad_oferta'];
    $fecha_inicia = $_POST['fecha_inicia'];
    $fecha_fin = $_POST['fecha_fin'];
    $adminOfertas = new AdministradorOfertas();
    $adminOfertas->modificarOferta($id, $id_producto_det, intval($id_producto_of), intval($cantidad_det), intval($porc_oferta), $tipo_oferta, intval($cantidad_oferta), $fecha_inicia, $fecha_fin);
    $mensaje = array("mensaje" => "Oferta modificada", "tipo" => "success");
    echo json_encode($mensaje);
}

switch($accion){
    case $casoAlta:
        altaOferta();
        break;
    case $casoModificacion:
        modificarOferta();
        break;
    case $casoBaja:
        bajaOferta();
        break;
    default:
        echo "No se encontro la accion";

}


?>