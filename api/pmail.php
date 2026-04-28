<?php 
include_once "notificador.php";
$asunto = "Prueba de envio de correo";
$mensaje = "Este es un mensaje de prueba";
$mail_destino = "asielsempai@gmail.com";
$nombre_destino = "Asiel";
//function mailerNot($mail_destino, $nombre_destino, $asunto, $mensaje, $attachment, $attachment_name, $mail_oculto)

mailerNot($mail_destino, $nombre_destino, $asunto, $mensaje, null, null, null);

?>