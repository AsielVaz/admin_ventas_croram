<?php 
session_start();

include_once "adminPagos.php";
include_once "adminUsuarios.php";
include_once "naperzClient.php";
$accion = $_POST['accion'];
$casoAlta = "alta";
$casoBaja = "baja";
$casoModificacion = "modificacion";
$casoLogin = "login";



function altaPago()
{
    $monto = $_POST['monto'];
    $id_usuario = $_POST['id_usuario'];
    $id_inserta = $_SESSION['id_usuario'];
    $id_napers = $_POST['id_napers'] ?? 0;
    $tipo_pago = $_POST['metodo_pago'];
    $fecha_pago = $_POST['fecha_pago'] ?? date('Y-m-d');
    $adminPagos = new AdministradorPagos();
    $adminUsuarios = new AdministradorUsuarios();
    $pagos = $_POST['pagos'];
    $pagosDes = json_decode($pagos);
    $adminPagos->agregarPago($monto, 0, '', intval($id_usuario), intval($id_inserta), intval($id_napers), $tipo_pago);
    $ultimo_id = $adminPagos->dameUltimoId();
    $ordenesNota = [];
    foreach($pagosDes as $pago){
        $adminPagos->insertaRelacionPago($ultimo_id, $pago->id_orden, $pago->monto);
        $ordenesNota[] = '#' . intval($pago->id_orden) . ' $' . number_format(floatval($pago->monto), 2);
    }

    $naperz = array("sincronizado" => false);
    try {
        $usuario = $adminUsuarios->dameUsuario(intval($id_usuario));
        $clientId = intval($usuario->id_cliente ?? 0);
        if ($clientId > 0) {
            $responseNapers = (new NaperzClient())->createPayment([
                "date" => date('Y-m-d\TH:i:s.000000P', strtotime($fecha_pago . ' 12:00:00')),
                "amount" => floatval($monto),
                "note" => "Pago registrado desde admin Croram. Pago local #$ultimo_id. Ordenes: " . implode(', ', $ordenesNota),
                "clientId" => $clientId,
                "paymentMethod" => metodoPagoNapers($tipo_pago),
            ]);
            $idNapersPago = intval($responseNapers->item->id ?? 0);
            if ($idNapersPago > 0) {
                $adminPagos->actualizaIdNapers($ultimo_id, $idNapersPago);
            }
            $naperz = array("sincronizado" => true, "id" => $idNapersPago);
        } else {
            $naperz = array("sincronizado" => false, "mensaje" => "El usuario no tiene cliente Napers vinculado");
        }
    } catch (Exception $e) {
        $naperz = array("sincronizado" => false, "mensaje" => $e->getMessage());
    }

    $mensaje = array("mensaje" => "Pago dado de alta", "tipo" => "success", "id" => $ultimo_id, "naperz" => $naperz);
    echo json_encode($mensaje);
}

function metodoPagoNapers($metodo)
{
    $map = [
        "1" => "cheque",
        "2" => "efectivo",
        "3" => "transferencia",
        "4" => "deposito",
        "cheque" => "cheque",
        "efectivo" => "efectivo",
        "transferencia" => "transferencia",
        "deposito" => "deposito",
    ];
    return $map[strtolower((string)$metodo)] ?? "transferencia";
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
    $pago = $adminPagos->obtenerPago($id);
    $idNapers = intval($pago->id_napers ?? 0);
    if ($idNapers > 0) {
        try {
            (new NaperzClient())->cancelPayment($idNapers);
        } catch (Exception $e) {
            $mensaje = array("mensaje" => "No se pudo cancelar el pago en Naperz: " . $e->getMessage(), "tipo" => "error");
            echo json_encode($mensaje);
            return;
        }
    }
    $adminPagos->bajaPago($id);
    $mensaje = array("mensaje" => "Pago eliminado", "tipo" => "success", "naperz" => array("cancelado" => $idNapers > 0));
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
