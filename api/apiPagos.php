<?php 
session_start();

include_once "adminPagos.php";
$accion = $_POST['accion'];
$casoAlta = "alta";
$casoBaja = "baja";
$casoModificacion = "modificacion";
$casoLogin = "login";



function altaPago()
{
    $monto = $_POST['monto'];
    $id_orden = $_POST['orden'];
    $url_ev = $_POST['url_ev'];
    $id_usuario = $_POST['id_usuario'];
    $id_inserta = $_SESSION['id_usuario'];
    $id_napers = $_POST['id_napers'];
    $tipo_pago = $_POST['metodo_pago'];
    $adminPagos = new AdministradorPagos();
    $pagos = $_POST['pagos'];
    $pagosDes = json_decode($pagos);
    $adminPagos->agregarPago($monto, 0, '', intval($id_usuario), intval($id_inserta), intval($id_napers), $tipo_pago);
    $ultimo_id = $adminPagos->dameUltimoId();
    foreach($pagosDes as $pago){
        $adminPagos->insertaRelacionPago($ultimo_id, $pago->id_orden, $pago->monto);
    }
    $mensaje = array("mensaje" => "Pago dado de alta", "tipo" => "success");
    echo json_encode($mensaje);
}

function altaRelaciones(){

}

function modificarPago()
{
    $id = $_POST['id'];
    $monto = $_POST['monto'];
    $id_orden = $_POST['id_orden'];
    $url_ev = $_POST['url_ev'];
    $id_usuario = $_POST['id_usuario'];
    $id_napers = $_POST['id_napers'];
    $adminPagos = new AdministradorPagos();
    $adminPagos->modificarPago($id, $monto, $id_orden, $url_ev, $id_usuario, $id_napers);
    $mensaje = array("mensaje" => "Pago modificado", "tipo" => "success");
    echo json_encode($mensaje);
}

function bajaPago()
{
    $id = $_POST['id'];
    $adminPagos = new AdministradorPagos();
    $adminPagos->bajaPago($id);
    $mensaje = array("mensaje" => "Pago eliminado", "tipo" => "success");
    echo json_encode($mensaje);
}

switch ($accion) {
    case $casoAlta:
        altaPago();
        break;
    case $casoModificacion:
        modificarPago();
        break;
    case $casoBaja:
        bajaPago();
        break;
    default:
        $mensaje = array("mensaje" => "Acción no reconocida", "tipo" => "error");
        echo json_encode($mensaje);
        break;
}



?>