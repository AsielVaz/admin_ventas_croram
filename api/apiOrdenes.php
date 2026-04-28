<?php
session_start();
include_once "adminOrdenes.php";
include_once "notificador.php";
include_once "adminUsuarios.php";
include_once "adminAutos.php";

$accion = $_POST['accion'];

$casoAlta = "alta";
$casoBaja = "baja";
$casoModificacion = "modificacion";
$casoAprobar = "aprobar";
$casoRechazar = "rechazar";
$verOrdenes = "dameOrdenesDeUsuario";
$verProductosOrden = "dameProductosOrden";


function agregarOrden()
{
  $id_cliente = $_POST['id_cliente'];
  $id_veiculo = $_POST['id_veiculo'];
  $id_price_list = $_POST['id_price_list'];
  $fecha_entrega = $_POST['fecha_entrega'];
  $tiempo_entrega = $_POST['tiempo_entrega'];
  $detalles = $_POST['detalles'];
  $productos = $_POST['productos'];
  $recolector = $_POST['recolector'];
  $tipo_pago = $_POST['tipo_pago'];
  $productos = json_decode($productos);
  $id_crea = $_SESSION['id_usuario'];
  $uso_bascula = $_POST['uso_bascula'];
  $adminOrdenes = new AdministradorOrdenes();
  $adminOrdenes->agregarOrden(intval($id_cliente), intval($id_veiculo), intval($id_price_list), $fecha_entrega, $tiempo_entrega, $detalles, $recolector, $tipo_pago, $id_crea, $uso_bascula);
  $id_utimo = $adminOrdenes->dameUltimoId();
  $tiempoEntrega = 0;
  $segundosPorUnidad = 10;
  $cantidadProductos = 0;
  foreach ($productos as $producto) {
    if ($producto->quantity > 0) {
      //quitar 121209 del id como cadena 
      $producto->id =  str_replace("121209", "", $producto->id);
      $producto->id =  str_replace("121266", "", $producto->id);
      $adminOrdenes->agregaProductoOrden($producto->id, $id_utimo, $producto->price, $producto->quantity);
      $cantidadProductos += $producto->quantity;
    }
  }
  $tiempoEntrega = $cantidadProductos * $segundosPorUnidad;
  $tiempoEntrega = $tiempoEntrega + $tiempoEntrega + 900;
  $adminOrdenes->modificarTiempoEntrega($id_utimo, $tiempoEntrega);
  //mailerNot($_POST['correo'], 'Croram', 'Nueva orden', generaCorreo($id_utimo), null, null, null);
  //mailerNot("ventascroram@gmail.com", 'Croram', 'Nueva orden por moderar', generaCorreoAdmin($id_utimo), null, null, null);
  $mensaje = array("mensaje" => "Orden dada de alta", "tipo" => "success", "id" => $id_utimo);
  echo json_encode($mensaje);
}


function enviarOrdenNapers($id)
{
  $adminOrdenes = new AdministradorOrdenes();
  $adminUsuarios = new AdministradorUsuarios();
  $adminAutos = new AdministradorAutos();
  $orden = $adminOrdenes->obtenerOrden($id);
  $usuario = $adminUsuarios->dameUsuario($orden->id_cliente);
  $auto = $adminAutos->obtenerAuto($orden->id_veiculo);
  //echo json_encode($usuario);
  $productos = $adminOrdenes->dameProductosOrdenCompuestos($id);
  $fechaEntrega = date('Y-m-d H:i:s', strtotime($orden->fecha_entrega));
  $fechaEntrega = str_replace(" ", "T", $fechaEntrega);
  //fecha de creacion hoy 
  $fechaCrea = date('Y-m-d H:i:s');
  $fechaCrea = str_replace(" ", "T", $fechaCrea);
  $orden->id_cliente = $usuario->id_cliente;
  $lines = array();
  foreach ($productos as $producto) {
    $line = array(
      "productId" => (int) $producto->id_napers,
      "quantity" => (int) $producto->cantidad,
      "unitPrice" => (int) $producto->precio_unitario
    );
    array_push($lines, $line);
  }
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://croram.naperz.mx/api/croram/sale?key=cDkGWH6-VFpg8myZAI.0F3ozzx0B_GLZ2qiUB1hq&page=1&pageSize=100',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
          "clientId": '.$orden->id_cliente.',
          "priceListId": '.$orden->id_price_list.',
          "userId": 19,
          "createdDate": "'.$fechaCrea.'.123456-06:00",
          "deliveryDate": "'.$fechaEntrega.'.123456-06:00",
          "deliveryNote": "Prueba por favor ignorar",
          "deliveryDriverName": "'.$orden->recolector.'",
          "deliveryVehiclePlate": "'. $auto->placas . '",
          "deliveryContainerTypeId": 1,
          "lines": '.json_encode($lines, JSON_UNESCAPED_UNICODE).'
          }',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
    ),
  ));

  //imprimir el json 
  // echo '{
  //   "clientId": '.$orden->id_cliente.',
  //   "priceListId": '.$orden->id_price_list.',
  //   "userId": 19,
  //   "createdDate": "'.$fechaCrea.'.123456-06:00",
  //   "deliveryDate": "'.$fechaEntrega.'.123456-06:00",
  //   "deliveryNote": "Prueba por favor ignorar",
  //   "lines": '.json_encode($lines, JSON_UNESCAPED_UNICODE).'
  //   }';
    

  $response = curl_exec($curl);
   curl_close($curl);
   $response = json_decode($response);
   $adminOrdenes->actualizaIdNapers($id, $response->item->id);
  //echo $response;
}



function aprobarOrden()
{
  $id = $_POST['id'];
  $adminOrdenes = new AdministradorOrdenes();
  $fecha_cliente = $_POST['fecha_cliente'];
  $periodo = $_POST['periodo'];
  $notas = $_POST['notas'];
  //8:00 - 9:00
  $periodo = explode(" - ", $periodo)[0];
  $fechaCompuesta = $fecha_cliente . " " . $periodo;
  $adminOrdenes->aprobarOrden($id, $fechaCompuesta, $notas);
  if ($_POST['directo'] == "si") {
    $adminOrdenes->modificarEstatus($id, 99);
  }
  enviarOrdenNapers($id);
  $mensajeCorreo = "Su orden con el id " . $id . " ha sido aprobada";
  mailerNot($_POST['correo'], 'Croram', 'Orden Aproada', generaCorreo($mensajeCorreo), null, null, null);
  $mensaje = array("mensaje" => "Orden aprobada", "tipo" => "success");
  echo json_encode($mensaje);
}

function rechazarOrden()
{
  $id = $_POST['id'];
  $adminOrdenes = new AdministradorOrdenes();
  $fecha_cliente = $_POST['fecha_cliente'];
  $periodo = $_POST['periodo'];
  $notas = $_POST['notas'];
  //8:00 - 9:00
  $periodo = explode(" - ", $periodo)[0];
  $fechaCompuesta = $fecha_cliente . " " . $periodo;
  $adminOrdenes->rechazarOrden($id, $fechaCompuesta, $notas);
  $mensajeCorreo = "Su orden con el id " . $id . " ha sido cancelada";
  mailerNot($_POST['correo'], 'Croram', 'Orden Cancelada', generaCorreo($mensajeCorreo), null, null, null);
  $mensaje = array("mensaje" => "Orden Cancelada", "tipo" => "success");
  echo json_encode($mensaje);
}


function generaCorreo($id)
{
  $texto = <<<EOT
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>Email Template</title>
    <style type="text/css">
      @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap');
      html{width:100%}
      p{margin:0!important}
      body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;font-family:sans-serif!important;background-color:#F6F8FA}
      table{border-spacing:0;table-layout:auto;margin:0 auto}
      img{display:block!important;overflow:hidden!important}
      a{text-decoration:none;color:unset}
      .ReadMsgBody{width:100%;background-color:#F6F8FA}
      .ExternalClass{width:100%;background-color:#F6F8FA}
      .ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}
      .yshortcuts a{border-bottom:none!important}
      .pad{width:92%}
      @media only screen and (max-width: 673px) {
      .res-pad{width:92%;max-width:92%}
      .res-full{width:100%;max-width:100%}
      .res-text-left{text-align:left!important}
      .res-text-right{text-align:right!important}
      .res-text-center{text-align:center!important}
      .res-float-left{float:left!important}
      .res-float-right{float:right!important}
      .res-float-unset{float:unset!important}
      .mc-fluid-img{max-width:100%!important}
      }@media only screen and (max-width: 770px) {
      .res-rem-radius{border-radius:0!important}
      .margin-full{width:100%;max-width:100%}
      .margin-pad{width:92%;max-width:92%;max-width:600px}
      }
    </style>
  </head>
  <body>
    <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#F6F8FA" width="100%">
      <tbody>
        <tr>
          <td>
            <table border="0" cellpadding="0" cellspacing="0" align="center" class="margin-full" width="750" style="margin-top:-1px;">
              <tbody>
                <tr>
                  <td>
                    <table border="0" cellpadding="0" cellspacing="0" align="center" class="margin-pad" width="600">
                      <tbody>
                        <tr><td height="30" style="font-size:0;line-height:0;">&nbsp;</td></tr>
                        <tr>
                          <td style="padding-top:0;padding-bottom:0;">
                            <table border="0" cellpadding="0" cellspacing="0" align="center" class="res-full">
                              <tbody>
                                <tr>
                                  <td>
                                    <table border="0" cellpadding="0" cellspacing="0" align="center">
                                      <tbody>
                                        <tr>
                                          <td align="center" style="padding-left:0;padding-right:8px;"><img alt="Icon" width="22" src="https://clientes.grupocroram.com/media/logo-grande.png" style="border:0;font-size:0;line-height:0;max-width:220px;display:block;" /></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr><td height="30" style="font-size:0;line-height:0;">&nbsp;</td></tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>

   
    <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#F6F8FA" width="100%">
      <tbody>
        <tr>
          <td>
            <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#F0F3F6" class="margin-full res-rem-radius" width="750" style="border-radius:0px 0px 0px 0px;margin-top:-1px;">
              <tbody>
                <tr>
                  <td>
                    <table border="0" cellpadding="0" cellspacing="0" align="center" class="margin-pad" width="600">
                      <tbody>
                        <tr><td height="60" style="font-size:0;line-height:0;">&nbsp;</td></tr>
                        <tr><td class="res-text-center" style="font-family:'Roboto', Arial;font-size:22px;line-height:30px;letter-spacing:0px;text-align:center;color:#252B3A;word-break:break-word;padding-top:0;padding-bottom:0;">Su orden fue modificada recientemente</td></tr>
                        <tr>
                          <td style="padding-top:14px;padding-bottom:14px;">
                            <table border="0" cellpadding="0" cellspacing="0" align="center" class="res-full">
                              <tbody>
                                <tr>
                                  <td>
                                    <table border="0" cellpadding="0" cellspacing="0" align="center">
                                      <tbody>
                                        <tr>
                                          <td align="center" style=""><img alt="Icon" width="78" src="https://clientes.grupocroram.com/media/logo-grande.png" style="border:0;font-size:0;line-height:0;max-width:78px;display:block;" /></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr><td class="res-text-center" style="font-family:'Roboto', Arial;font-size:16px;line-height:22px;letter-spacing:0px;text-align:center;color:#607080;word-break:break-word;padding-top:0;padding-bottom:0;">Verifique los cambios en su cuenta de Croram para continuar con el proceso de compra.</td></tr>
                      
                        <tr><td height="64" style="font-size:0;line-height:0;">&nbsp;</td></tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>

 
    <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#F6F8FA" width="100%">
      <tbody>
        <tr>
          <td>
            <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#F0F3F6" class="margin-full res-rem-radius" width="750" background="img/c466356e40e937bf2c0e38c4541f7206.png" style="background-size:cover;background-position:center center;border-radius:0px 0px 0px 0px;margin-top:-1px;">
              <tbody>
                <tr>
                  <td>
                    <table border="0" cellpadding="0" cellspacing="0" align="center" class="margin-pad" width="600">
                      <tbody>
                        <tr><td height="100" style="font-size:0;line-height:0;">&nbsp;</td></tr>
                        <tr><td class="res-text-center" style="font-family:'Roboto', Arial;font-size:28px;line-height:36px;letter-spacing:2.5px;text-align:center;color:#FFFFFF;word-break:break-word;padding-top:3px;padding-bottom:0;">$id</td></tr>
                        
                      
                        <tr><td height="100" style="font-size:0;line-height:0;">&nbsp;</td></tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
   
 
  
  
  
  
    <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#F6F8FA" width="100%">
      <tbody>
        <tr>
          <td>
            <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#EAEDF2" class="margin-full res-rem-radius" width="750" style="border-radius:0px 0px 6px 6px;margin-top:-1px;">
              <tbody>
                <tr>
                  <td>
                    <table border="0" cellpadding="0" cellspacing="0" align="center" class="margin-pad" width="600">
                      <tbody>
                        <tr><td height="68" style="font-size:0;line-height:0;">&nbsp;</td></tr>
                        <tr>
                          <td style="padding-top:0;padding-bottom:0;">
                            <table border="0" cellpadding="0" cellspacing="0" align="center" class="res-full">
                              <tbody>
                                <tr>
                                  <td>
                                    <table border="0" cellpadding="0" cellspacing="0" align="center">
                                      <tbody>
                                        <tr>
                                          <td>
                                            <table border="0" cellpadding="0" cellspacing="0" style="padding:4px 5px 4px 5px;border:2px solid #607080;border-radius:5px;">
                                              <tbody>
                                                <tr>
                                                  <td align="center" style=""><img alt="Icon" width="25" src="img/79fa2a9627982555606b24a348e53e7f.png" style="border:0;font-size:0;line-height:0;max-width:25px;display:block;" /></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                          <td style="width:0;font-size:0;line-height:0;padding-left:7px;">&nbsp;</td>
                                          <td>
                                            <table border="0" cellpadding="0" cellspacing="0" style="padding:4px 5px 4px 5px;border:2px solid #607080;border-radius:5px;">
                                              <tbody>
                                                <tr>
                                                  <td align="center" style=""><img alt="Icon" width="25" src="img/542fa91100b09baa1b612eb80dd89295.png" style="border:0;font-size:0;line-height:0;max-width:25px;display:block;" /></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                          <td style="width:0;font-size:0;line-height:0;padding-left:7px;">&nbsp;</td>
                                          <td>
                                            <table border="0" cellpadding="0" cellspacing="0" style="padding:4px 5px 4px 5px;border:2px solid #607080;border-radius:5px;">
                                              <tbody>
                                                <tr>
                                                  <td align="center" style=""><img alt="Icon" width="25" src="img/112b22c0d561c5fdcea77cb1e2be7c9d.png" style="border:0;font-size:0;line-height:0;max-width:25px;display:block;" /></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                          <td style="width:0;font-size:0;line-height:0;padding-left:7px;">&nbsp;</td>
                                          <td>
                                            <table border="0" cellpadding="0" cellspacing="0" style="padding:4px 5px 4px 5px;border:2px solid #607080;border-radius:5px;">
                                              <tbody>
                                                <tr>
                                                  <td align="center" style=""><img alt="Icon" width="25" src="img/bfb34298941a774e8f9c2419bff004d7.png" style="border:0;font-size:0;line-height:0;max-width:25px;display:block;" /></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-top:35px;padding-bottom:13px;">
                            <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
                              <tbody>
                                <tr><td height="0" style="border-bottom:2px solid rgba(37, 43, 58, 0.25);border-radius:2px;"></td></tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr><td class="res-text-center" style="font-family:'Roboto', Arial;font-size:16px;line-height:22px;letter-spacing:0px;text-align:center;color:#607080;word-break:break-word;padding-top:0;padding-bottom:0;">Este es un mensaje automatizado y no representa garantía de una compra ni un documento de facturación, gracias por usar el servicio de Croram</td></tr>
                        <tr>
                          <td style="padding-top:14px;padding-bottom:30px;">
                            <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
                              <tbody>
                                <tr><td height="0" style="border-bottom:2px solid rgba(37, 43, 58, 0.25);border-radius:2px;"></td></tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-top:0;padding-bottom:0;">
                            <table border="0" cellpadding="0" cellspacing="0" align="center" class="res-full">
                              <tbody>
                                <tr>
                                  <td>
                                    <table border="0" cellpadding="0" cellspacing="0" align="center" class="undefined" style="overflow:hidden;border-radius:4px;border:2px solid #607080;">
                                      <tbody>
                                        <tr>
                                          <td align="center" style="padding-left:15px;"><img alt="Icon" width="20" src="img/9f56d17325f0c9adb6239ce66ccd8d77.png" style="border:0;font-size:0;line-height:0;max-width:20px;display:block;" /></td>
                                          <td style="text-align:center;padding:8px 16px 8px 10px;line-height:22px;">
                                            <a href="" style="font-family:'Roboto', Arial;font-size:16px;line-height:22px;letter-spacing:0px;color:#252B3A;word-break:break-all;text-decoration:none;padding:8px 0;"><span style="color:#607080;">012-345-6789</span></a>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr><td height="65" style="font-size:0;line-height:0;">&nbsp;</td></tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#F6F8FA" width="100%">
      <tbody>
        <tr>
          <td>
            <table border="0" cellpadding="0" cellspacing="0" align="center" class="margin-full" width="750" style="margin-top:-1px;">
              <tbody>
                <tr>
                  <td>
                    <table border="0" cellpadding="0" cellspacing="0" align="center" class="margin-pad" width="600">
                      <tbody>
                        <tr><td height="40" style="font-size:0;line-height:0;">&nbsp;</td></tr>
                        <tr>
                          <td style="padding-top:0;padding-bottom:0;">
                            <table border="0" cellpadding="0" cellspacing="0" align="center" class="res-full">
                              <tbody>
                                <tr>
                                  <td>
                                    <table border="0" cellpadding="0" cellspacing="0" align="center">
                                      <tbody>
                                        <tr>
                                          <td class="res-text-center" style="text-align:center;"><a style="font-family:'Roboto', Arial;font-size:16px;line-height:22px;letter-spacing:0px;color:#607080;word-break:break-word;text-decoration:none;" href="#">Message Settings</a></td>
                                          <td align="center" style="padding-right:11px;padding-left:11px;"><img alt="Icon" width="6" src="img/bd1954a44d49f0c8f7a6e74e618d03bf.png" style="border:0;font-size:0;line-height:0;max-width:6px;display:block;" /></td>
                                          <td class="res-text-center" style="text-align:center;"><a style="font-family:'Roboto', Arial;font-size:16px;line-height:22px;letter-spacing:0px;color:#607080;word-break:break-word;text-decoration:none;" href="#">Message Frequency</a></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr><td class="res-text-center" style="font-family:'Roboto', Arial;font-size:15px;line-height:21px;letter-spacing:0px;text-align:center;color:#607080;word-break:break-word;padding-top:14px;padding-bottom:14px;">Or Simply</td></tr>
                        <tr>
                          <td class="res-text-center" style="text-align:center;padding-top:0;padding-bottom:0;"><a style="font-family:'Roboto', Arial;font-size:16px;line-height:22px;letter-spacing:0px;color:#607080;word-break:break-word;text-decoration:none;" href="">Unsubscribe From Mail</a></td>
                        </tr>
                        <tr><td height="40" style="font-size:0;line-height:0;">&nbsp;</td></tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
EOT;

  return $texto;
}

function verOrdenes()
{
  $adminOrdenes = new AdministradorOrdenes();
  $id_usuario = $_POST['id_usuario'];
  $ordenes = $adminOrdenes->dameOrdenesDeUsuario($id_usuario);
  echo json_encode($ordenes);
}

function verProductosOrden()
{
  $adminOrdenes = new AdministradorOrdenes();
  $id_orden = $_POST['id_orden'];
  $productos = $adminOrdenes->dameProductosOrdenCompuestos($id_orden);
  echo json_encode($productos);
}

switch ($accion) {
  case $casoAlta:
    agregarOrden();
    break;
  case $casoBaja:
    break;
  case $casoModificacion:
    break;

  case $casoAprobar:
    aprobarOrden();
    break;
  case $casoRechazar:
    rechazarOrden();
    break;
  case $verOrdenes:
    verOrdenes();
    break;
  case $verProductosOrden:
    verProductosOrden();
    break;  
  default:
    $mensaje = array("mensaje" => "Accion no reconocida", "tipo" => "error");
    echo json_encode($mensaje);
    break;
}
