<?php
include_once 'conector.php';
function dameUsuariosApi()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://croram.naperz.mx/api/croram/clients?key=cDkGWH6-VFpg8myZAI.0F3ozzx0B_GLZ2qiUB1hq&page=1&pageSize=100',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return ($response);
}

function leerOrdenesCSV($rutaArchivo = 'ordenes.csv')
{
    if (!file_exists($rutaArchivo)) {
        die("El archivo $rutaArchivo no existe.");
    }

    $ordenes_raw = [];

    if (($handle = fopen($rutaArchivo, "r")) !== false) {
        $encabezados = fgetcsv($handle, 0, ',');
        $encabezados = array_map(function ($h) {
            $h = trim(preg_replace('/[[:^print:]]/', '', $h));
            return strtolower(str_replace(' ', '_', $h));
        }, $encabezados);

        while (($data = fgetcsv($handle, 0, ',')) !== false) {
            if (count($data) < count($encabezados)) continue;
            $obj = new stdClass();
            foreach ($encabezados as $i => $campo) {
                $valor = isset($data[$i]) ? trim($data[$i]) : null;

                if (in_array($campo, ['subtotal', 'impuestos', 'total'])) {
                    $valor = str_replace([',', '"', ' '], '', $valor);
                    $valor = ($valor === '-' || $valor === '') ? 0 : (float)$valor;
                }

                if ($valor === '-' || $valor === '—') {
                    $valor = '';
                }

                $obj->$campo = $valor;
            }
            $ordenes_raw[] = $obj;
        }

        fclose($handle);
    }

    return $ordenes_raw;
}


function agruparOrdenes($ordenes_raw, $respuesta_json)
{
    $respuesta = json_decode($respuesta_json, true);
    $clientes = [];
    foreach ($respuesta['items'] as $item) {
        $clientes[trim(strtoupper($item['displayName']))] = $item['id'];
    }

    $agrupadas = [];
    $id_auto = 400;

    foreach ($ordenes_raw as $o) {
        $pedido = $o->pedido;

        // Buscar id_cliente según el nombre en el JSON
        $nombre_cliente = trim(strtoupper($o->cliente));
        $id_cliente = isset($clientes[$nombre_cliente]) ? $clientes[$nombre_cliente] : 0;

        // Si no existe la orden, crearla
        if (!isset($agrupadas[$pedido])) {
            $orden = new stdClass();
            $orden->id = $id_auto++;
            $orden->id_cliente = $id_cliente;
            $orden->id_veiculo = 0;
            $orden->id_price_list = 0;
            $orden->fecha_entrega = $o->fecha_de_entrega ?: '0000-00-00';
            $orden->tiempo_entrega = 0;
            $orden->detalles = '';
            $orden->recolector = 0;
            $orden->fecha_inserta = $o->fecha_alta ?: date('Y-m-d');
            $orden->estatus = $o->estado_alta ?: '';
            $orden->comprobante = '';
            $orden->id_napers = 0;
            $orden->tipo_pago = $o->estado_de_pago ?: '';
            $orden->id_cliente_vendedor = 0;
            $orden->id_crea = 0;
            $orden->uso_bascula = 0;
            $orden->productos = [];
            $agrupadas[$pedido] = $orden;
        }

        // Agregar producto
        $producto = new stdClass();
        $producto->nombre = $o->producto;
        $producto->cantidad = (int)$o->cantidad;
        $producto->subtotal = (float)$o->subtotal;
        $producto->impuestos = (float)$o->impuestos;
        $producto->total = (float)$o->total; 
        $producto->entrega = $o->entrega;
        $producto->id = 0; // Aquí podrías mapear el nombre del producto a un ID si tienes esa información

        $agrupadas[$pedido]->productos[] = $producto;
    }

    // Devolver arreglo de objetos (no asociativo)
    return array_values($agrupadas);
}

function formatearFecha($fecha)
{
    $partes = explode('/', $fecha);
    if (count($partes) === 3) {
        $dia = str_pad($partes[0], 2, '0', STR_PAD_LEFT);
        $mes = str_pad($partes[1], 2, '0', STR_PAD_LEFT);
        $anio = $partes[2];
        return "$anio-$mes-$dia";
    }
    return '0000-00-00';
}


// 🧪 --- Ejemplo de uso ---
$respuesta_json = '{"status":200,"items":[{"id":14,"displayName":"ANDRES GONZALEZ BERROSPE"},{"id":18,"displayName":"DANIEL ALONSO RUVALCABA GUTIERREZ"},{"id":20,"displayName":"CARLOS SAUL REYES RAMIREZ"},{"id":44,"displayName":"OMAR ARISTEO FLORES BERMEJO"},{"id":47,"displayName":"FRANCISCO JAVIER FRAUSTO"},{"id":49,"displayName":"CLIENTE CRORAM"},{"id":54,"displayName":"VIDAL BENITEZ ROSAS"},{"id":55,"displayName":"WALMART"},{"id":56,"displayName":"FREYR RICARDO FLORES FLORES"},{"id":57,"displayName":"MARIA DE LA LUZ ROBLES VICENCIO"},{"id":58,"displayName":"BRIAN MARTIN PEREZ RIVERA"},{"id":60,"displayName":"ALDO ROGELIO ARVIZU ROBLES"},{"id":61,"displayName":"DAVID ACEVES MICHEL"},{"id":62,"displayName":"ENRIQUE FARID BETANZOS LOMELI"},{"id":63,"displayName":"FABIOLA ARACELI VELASCO VERGARA"},{"id":65,"displayName":"HECTOR ERNESTO LOPEZ HERRERA"},{"id":66,"displayName":"JORGE GARCIA ZUÑIGA"},{"id":67,"displayName":"JUAN PABLO GONZALEZ BERROSPE"},{"id":68,"displayName":"MARIA FERNANDA PATRICIO MONTOYA"},{"id":69,"displayName":"MARTHA MARGARITA GIL ALVAREZ"},{"id":70,"displayName":"MARTHA OFELIA RAMIREZ GIL"},{"id":71,"displayName":"MARTIN GARCÍA LEOCADIO"},{"id":72,"displayName":"RAMIRO RODRIGO SOLORZANO MACIEL"},{"id":79,"displayName":"DAVID MACIAS"},{"id":81,"displayName":"JORGE CARRILLO"},{"id":89,"displayName":"ADRIANA PATRICIA OVALLE CAMPOS"},{"id":93,"displayName":"EMPLEADOS"},{"id":96,"displayName":"MIRIAM LUCERO ROCHA FLORES"},{"id":98,"displayName":"Miguel Angel  Navarro Pérez "},{"id":100,"displayName":"CIAN PRODUCTOS"},{"id":106,"displayName":"REFUGIO MANADAS"},{"id":117,"displayName":"Prueba jun25 Prueba"},{"id":119,"displayName":"CARLOS EDUARDO SALAZAR NAPOLES"},{"id":146,"displayName":"SALVADOR GOMEZ CARRILLO"},{"id":148,"displayName":"POLICIAS "},{"id":152,"displayName":"VENTAS ONLINE"},{"id":153,"displayName":"MERCADO LIBRE"},{"id":156,"displayName":"SERGIO GOMEZ GONZALEZ"},{"id":158,"displayName":"JAVIER CEJA GOMEZ"},{"id":159,"displayName":"GRUPO DE PLASTICOS ARESA 0723"},{"id":160,"displayName":"MUESTRAS "},{"id":165,"displayName":"JOSE MANUEL LOZANO VARGAS"},{"id":171,"displayName":"PREMIOS"},{"id":181,"displayName":"CAMBIO DE PRESENTACIÓN "},{"id":182,"displayName":"JAQUELINE FERNANDEZ MANZO "},{"id":183,"displayName":"ISRAEL ESCOBAR GARCIA"},{"id":184,"displayName":"JORGE NAVARRETE"},{"id":185,"displayName":"OSCAR CANALES FLORES"},{"id":186,"displayName":"CARRERA UDG "},{"id":187,"displayName":"LUIS HUMBERTO SALCIDO SAENZ"},{"id":189,"displayName":"CLAUDIA MAGALY QUINTERO CARBAJAL"},{"id":190,"displayName":"GRANERO SOSA SA DE CV "},{"id":191,"displayName":"BARRIDO PARA PRODUCCION"},{"id":192,"displayName":"DEVOLUCIÓN "},{"id":193,"displayName":"SWEET MARKET"},{"id":194,"displayName":"JOSE PEREZ"},{"id":195,"displayName":"QUESOS SAN MIGUEL"},{"id":196,"displayName":"JAVIER MARIN"},{"id":197,"displayName":"IVÁN GONZÁLEZ "},{"id":198,"displayName":"FRANCISCO PÉREZ MIRANDA "}],"count":"60"}';

$ordenes_raw = leerOrdenesCSV('ordenes.csv');
$ordenes = agruparOrdenes($ordenes_raw, $respuesta_json);
$productos = [
    'CAGNO ADULTO 25 KG' => 1,
    'CAGNO CACHORRO 20 KG' => 2, 
    'CAGNOLINO ADULTO 20 KG' => 3,
    'CROQUETA ECONOMICA 20 KG' => 4,
    'ALMA PERRONA 20KG M' => 5,
    'CROQUETA ECONOMICA 25KG' => 6,
    'KETOS CACHORRO 20KG' => 7,
    'GATISIMO 15 KG' => 8,
    'KETTOS ADULTO 25 KILOS' => 9,
    'CUADRO AMARILLO 20 KILOS' => 10,
    'CAGNOLINO ADULTO 25KG' => 11,
    'CAGNOLINO CACHORRO 21KG' => 12, 
    'GATISIMO 16KG' => 13,
    'MAQUILA AGUASCALIENTES 20 KILOS' => 14,
    'GALLO AZTECA 25KG' => 15,
    'MAÍZ QUEBRADO' => 16,
    'CAGNO ADULTO 5 KG' => 21,
    'CAGNO CACHORRO 5 KG' => 22,
    'GATISIMO 5 KG' => 23,
    'PRODUCTO DESCONTINUADO' => 24,
];

$conector = new Con();
// 🔍 Mostrar resultado
foreach ($ordenes as $orden) {
    if($orden->id_cliente != 0){
    echo "Cliente no encontrado para la orden ID: {$orden->id}<br>";
    $queryIdSistema = "SELECT id FROM user WHERE id_cliente = {$orden->id_cliente};";
    $resultadoIdSistema = $conector->ejecutar($queryIdSistema);
    $resultadoIdSistemaArr = json_decode($resultadoIdSistema, true);
    echo 'El id de sistema es: ' . ($resultadoIdSistemaArr[0]['id']) . "<br>";
    $idFinalSistema = $resultadoIdSistemaArr[0]['id'];
   $orden->id_cliente = intval($idFinalSistema);
   if($orden->id_cliente == 0){
    echo "Cliente no encontrado para la orden ID: {$orden->id}<br>";
    continue;
   }
    //echo "Pedido: {$orden->id} | Cliente: {$orden->id_cliente} | Estatus: {$orden->estatus}<br>";
    $orden->fecha_entrega = formatearFecha($orden->fecha_entrega);
    $orden->fecha_inserta = formatearFecha($orden->fecha_inserta);
  //SELECT `id`, `id_cliente`, `id_veiculo`, `id_price_list`, `fecha_entrega`, `tiempo_entrega`, `detalles`, `recolector`, `fecha_inserta`, `estatus`, `comprobante`, `id_napers`, `tipo_pago`, `id_cliente_vendedor`, `id_crea`, `uso_bascula` FROM `order` WHERE 1
    $queryOrden = "INSERT INTO `order` (`id`, `id_cliente`, `id_veiculo`, `id_price_list`, `fecha_entrega`, `tiempo_entrega`, `detalles`, `recolector`, `fecha_inserta`, `estatus`, `comprobante`, `id_napers`, `tipo_pago`, `id_cliente_vendedor`, `id_crea`, `uso_bascula`) VALUES ({$orden->id}, {$orden->id_cliente}, {$orden->id_veiculo}, {$orden->id_price_list}, '{$orden->fecha_entrega}', {$orden->tiempo_entrega}, '{$orden->detalles}', {$orden->recolector}, '{$orden->fecha_inserta}', '{$orden->estatus}', '{$orden->comprobante}', {$orden->id_napers}, '{$orden->tipo_pago}', {$orden->id_cliente_vendedor}, {$orden->id_crea}, {$orden->uso_bascula});";
    echo $queryOrden . "<br>";
    $conector->ejecutar($queryOrden);
    foreach ($orden->productos as $p) {
        $p->id = $productos[$p->nombre] ?? 24;
        //SELECT `id`, `id_producto`, `id_orden`, `precio_unitario`, `cantidad` FROM `product_order` WHERE 1
        $precioUnitario = $p->total / ($p->cantidad > 0 ? $p->cantidad : 1);
        $queryProducto = "INSERT INTO `product_order` (`id_producto`, `id_orden`, `precio_unitario`, `cantidad`) VALUES ({$p->id}, {$orden->id}, {$precioUnitario}, {$p->cantidad});";
        echo $queryProducto . "<br>";
        $conector->ejecutar($queryProducto);
        
    }
    echo "-----------------------------<br>";
    } else {
        echo "Cliente no encontrado para la orden ID: {$orden->id}<br>";
    }
}
