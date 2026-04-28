<?php

include_once "adminProductos.php";

$accion = $_POST['accion'];

$casoAlta = "alta";
$casoBaja = "baja";
$casoModificacion = "modificacion";
$casoCambioEstatus = "cambioEstatus";

function agregarProducto(){
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $napers = $_POST['napers'];
    $imagen = guardarImagen()['ruta'];
    $descripcion = $_POST['descripcion'];
    $uom = $_POST['uom'];
    $peso = $_POST['peso'];
    $adminProductos = new AdministradorProductos();
    $adminProductos->agregarProducto($nombre, $codigo, $cantidad, $precio, $napers, $imagen, $descripcion, $uom, $peso);
    $mensaje = array("mensaje" => "Producto dado de alta", "tipo" => "success");
    echo json_encode($mensaje);
}

function modificarProducto(){
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $napers = $_POST['napers'];
    $imagen = guardarImagen()['ruta'];
    $descripcion = $_POST['descripcion'];
    $uom = $_POST['uom'];
    $peso = $_POST['peso'];
    $id = $_POST['id'];
    $adminProductos = new AdministradorProductos();
    if ($imagen == null || $imagen == '' || $imagen == 'null') {
        $adminProductos->modificarProductoSinImagen($id, $nombre, $codigo, $cantidad, $precio, $napers, $descripcion, $uom, $peso);
        $mensaje = array("mensaje" => "Producto modificado sin cambio de imagen", "tipo" => "success", "imagen" => $imagen);
        echo json_encode($mensaje);
        return;
    }
    $adminProductos->modificarProducto($id, $nombre, $codigo, $cantidad, $precio, $napers, $imagen, $descripcion, $uom, $peso);
    $mensaje = array("mensaje" => "Producto modificado", "tipo" => "success");
    echo json_encode($mensaje);
}

function cambiarEstatus(){
    $id = $_POST['id'];
    $estatus = $_POST['estatus'];
    $adminProductos = new AdministradorProductos();
    $adminProductos->cambiarEstatus($id, $estatus);
    $mensaje = array("mensaje" => "Estatus cambiado", "tipo" => "success");
    echo json_encode($mensaje);
}

function guardarImagen() {
    // Verificar si el archivo fue enviado
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'No se envió una imagen válida.'];
    }

    // Generar un UUID para el nombre del archivo
    $uuid = uniqid();
    
    // Obtener información del archivo
    $archivo = $_FILES['imagen'];
    $tipoArchivo = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    
    // Asegurarse de que sea un formato de imagen válido
    $formatosPermitidos = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array(strtolower($tipoArchivo), $formatosPermitidos)) {
        return ['error' => 'Formato de imagen no permitido.'];
    }

    // Crear la carpeta si no existe
    $directorio = __DIR__ . '/media';
    if (!is_dir($directorio)) {
        mkdir($directorio, 0755, true);
    }

    // Definir la ruta completa del archivo
    $rutaArchivo = $directorio . '/' . $uuid . '.' . $tipoArchivo;

    // Mover el archivo a la carpeta
    if (!move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
        return ['error' => 'No se pudo guardar la imagen.'];
    }

    // Retornar la ruta donde se guardó
    return ['ruta' => $rutaArchivo];
}

switch($accion){
    case $casoAlta:
        agregarProducto();
        break;
    case $casoBaja:
        break;
    case $casoModificacion:
        modificarProducto();
        break;
    case $casoCambioEstatus:
        cambiarEstatus();
        break;
}

?>