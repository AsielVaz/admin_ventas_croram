<?php 
include_once "conector.php";

class AdministradorAutos extends Con{
    //SELECT `id`, `marca`, `modelo`, `color`, `capacidad_kg`, `placas`, `tipo`, `id_cliente` FROM `autos` WHERE 1
    public function obtenerAutos(){
        $query = "SELECT `id`, `marca`, `modelo`, `color`, `capacidad_kg`, `placas`, `tipo`, `id_cliente` FROM `autos` WHERE 1";
        return json_decode($this->ejecutar($query));
    }
    public function obtenerAuto($id){
        $query = "SELECT `id`, `marca`, `modelo`, `color`, `capacidad_kg`, `placas`, `tipo`, `id_cliente` FROM `autos` WHERE `id` = $id";
        return json_decode($this->ejecutar($query))[0];
    }
    public function obtenerAutosCliente($id_cliente){
        $query = "SELECT `id`, `marca`, `modelo`, `color`, `capacidad_kg`, `placas`, `tipo`, `id_cliente` FROM `autos` WHERE `id_cliente` = $id_cliente";
        return json_decode($this->ejecutar($query));
    }
    public function agregarAuto($marca, $modelo, $color, $capacidad_kg, $placas, $tipo, $id_cliente){
        $query = "INSERT INTO `autos`(`marca`, `modelo`, `color`, `capacidad_kg`, `placas`, `tipo`, `id_cliente`) VALUES ('$marca', '$modelo', '$color', $capacidad_kg, '$placas', '$tipo', $id_cliente)";
        return json_decode($this->ejecutar($query));
    }
    public function modificarAuto($id, $marca, $modelo, $color, $capacidad_kg, $placas, $tipo, $id_cliente){
        $query = "UPDATE `autos` SET `marca`='$marca',`modelo`='$modelo',`color`='$color',`capacidad_kg`=$capacidad_kg,`placas`='$placas',`tipo`='$tipo',`id_cliente`=$id_cliente WHERE `id` = $id";
        return json_decode($this->ejecutar($query));
    }
    public function dameAutosConUsuario(){
        $query = "SELECT autos.id, autos.marca, autos.modelo, autos.color, autos.capacidad_kg, autos.placas, autos.tipo, autos.id_cliente, user.nombre FROM autos INNER JOIN user ON autos.id_cliente = user.id";
        return json_decode($this->ejecutar($query));
    }
    public function bajaAuto($id){
        $query = "DELETE FROM `autos` WHERE `id` = $id";
        return json_decode($this->ejecutar($query));
    }
}


?>