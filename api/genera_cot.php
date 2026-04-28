<?php
require_once "fpdf/fpdf.php";
include_once "adminOrdenes.php";
include_once "adminUsuarios.php";

// ─── Datos ────────────────────────────────────────────────────────────────────
$adminUsuarios = new AdministradorUsuarios();
$adminOrdenes  = new AdministradorOrdenes();
$ordenes       = $adminOrdenes->obtenerOrden($_GET['id']);
$cliente       = $adminUsuarios->dameUsuario($ordenes->id_cliente);
$vendedor      = $adminUsuarios->dameUsuario($ordenes->id_crea);
$productos     = $adminOrdenes->dameProductosOrdenCompuestos($ordenes->id);

// ─── Fechas de vigencia ───────────────────────────────────────────────────────
$fechaEmision  = date("d/m/Y");
$fechaVigencia = date("d/m/Y", strtotime("+7 days"));

// ─── Paleta de colores ────────────────────────────────────────────────────────
// Azul corporativo oscuro
define('C_PRIM_R',  30);  define('C_PRIM_G',  64);  define('C_PRIM_B',  115);
// Azul acento
define('C_ACEL_R',   0);  define('C_ACEL_G', 163);  define('C_ACEL_B',  224);
// Fondo alterno filas
define('C_FOND_R', 245);  define('C_FOND_G', 247);  define('C_FOND_B',  250);
// Verde vigencia
define('C_VIGE_R',  22);  define('C_VIGE_G', 163);  define('C_VIGE_B',   74);
// Ámbar nota
define('C_NOTA_R', 180);  define('C_NOTA_G', 120);  define('C_NOTA_B',   0);

// ─── Clase personalizada ──────────────────────────────────────────────────────
class CotizacionPDF extends FPDF
{
    private $numeroOrden;
    private $fechaOrden;
    private $fechaVigencia;

    public function setDatosEncabezado($numero, $fecha, $vigencia)
    {
        $this->numeroOrden   = $numero;
        $this->fechaOrden    = $fecha;
        $this->fechaVigencia = $vigencia;
    }

    // ── Encabezado de página ──────────────────────────────────────────────────
    public function Header()
    {
        // Barra superior degradada (simulada con dos rectángulos)
        $this->SetFillColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->Rect(0, 0, 210, 10, 'F');
        $this->SetFillColor(C_ACEL_R, C_ACEL_G, C_ACEL_B);
        $this->Rect(0, 8, 210, 2, 'F');

        // Logo
        $logo = 'https://clientes.grupocroram.com/media/logo-grande.png';
        @$this->Image($logo, 10, 13, 48);

        // Bloque derecho: título + datos orden
        $this->SetFont('Arial', 'B', 24);
        $this->SetTextColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->SetXY(120, 13);
        $this->Cell(80, 11, 'COTIZACION', 0, 1, 'R');

        $this->SetFont('Arial', '', 8.5);
        $this->SetTextColor(90, 90, 90);
        $this->SetX(120);
        $this->Cell(80, 5, 'No. de orden: #' . $this->numeroOrden, 0, 1, 'R');
        $this->SetX(120);
        $this->Cell(80, 5, 'Fecha de emision: ' . $this->fechaOrden, 0, 1, 'R');

        // Píldora de vigencia en el header
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(C_VIGE_R, C_VIGE_G, C_VIGE_B);
        $this->SetTextColor(255, 255, 255);
        $this->SetX(120);
        $vig_text = 'Vigencia: ' . $this->fechaOrden . '  ->  ' . $this->fechaVigencia;
        $this->Cell(80, 6, $vig_text, 0, 1, 'R', true);

        // Línea separadora doble
        $this->SetY(45);
        $this->SetDrawColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->SetLineWidth(0.8);
        $this->Line(10, 45, 200, 45);
        $this->SetDrawColor(C_ACEL_R, C_ACEL_G, C_ACEL_B);
        $this->SetLineWidth(0.3);
        $this->Line(10, 46.5, 200, 46.5);
        $this->SetLineWidth(0.2);
        $this->Ln(6);
    }

    // ── Pie de página ─────────────────────────────────────────────────────────
    public function Footer()
    {
        $this->SetY(-20);
        // Línea acento antes del pie
        $this->SetDrawColor(C_ACEL_R, C_ACEL_G, C_ACEL_B);
        $this->SetLineWidth(0.5);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(1);

        // Barra de pie
        $this->SetFillColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->Rect(0, $this->GetY(), 210, 18, 'F');

        $this->SetFont('Arial', '', 7.5);
        $this->SetTextColor(200, 215, 240);
        $this->Ln(2);
        $this->Cell(0, 5,
            'Pagina ' . $this->PageNo() .
            '  |  Grupo Croram  |  Los precios pueden cambiar sin previo aviso.',
            0, 1, 'C'
        );
        $this->SetFont('Arial', 'B', 7.5);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 5,
            'Cotizacion valida del ' . $this->fechaOrden . ' al ' . $this->fechaVigencia . '  |  Vencida despues de 7 dias.',
            0, 0, 'C'
        );
    }

    // ── Sección: cliente y vendedor ───────────────────────────────────────────
    public function seccionPartes($cliente, $vendedor)
    {
        $startY = $this->GetY();

        // ── Caja Cliente ──
        $this->SetFillColor(C_FOND_R, C_FOND_G, C_FOND_B);
        $this->SetDrawColor(C_ACEL_R, C_ACEL_G, C_ACEL_B);
        $this->SetLineWidth(0.4);
        $this->RoundedRect(10, $startY, 88, 36, 3, 'DF');

        // Etiqueta
        $this->SetXY(14, $startY + 3);
        $this->SetFont('Arial', 'B', 7.5);
        $this->SetTextColor(C_ACEL_R, C_ACEL_G, C_ACEL_B);
        $this->Cell(80, 5, strtoupper('Cotizacion para:'), 0, 1);

        // Nombre
        $this->SetX(14);
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->Cell(80, 7, $this->u($cliente->nombre), 0, 1);

        // Correo
        $this->SetX(14);
        $this->SetFont('Arial', '', 8.5);
        $this->SetTextColor(80, 80, 80);
        $this->Cell(6, 5, '', 0, 0); // pequeño indent
        $this->Cell(74, 5, $this->u($cliente->correo), 0, 1);

        // Teléfono (si existe)
        if (!empty($cliente->telefono)) {
            $this->SetX(14);
            $this->Cell(6, 5, '', 0, 0);
            $this->Cell(74, 5, $this->u($cliente->telefono), 0, 1);
        }

        // ── Caja Vendedor ──
        $this->SetFillColor(C_FOND_R, C_FOND_G, C_FOND_B);
        $this->SetDrawColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->RoundedRect(112, $startY, 88, 36, 3, 'DF');

        $this->SetXY(116, $startY + 3);
        $this->SetFont('Arial', 'B', 7.5);
        $this->SetTextColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->Cell(80, 5, strtoupper('Asesor comercial:'), 0, 1);

        $this->SetX(116);
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->Cell(80, 7, $this->u($vendedor->nombre), 0, 1);

        $this->SetX(116);
        $this->SetFont('Arial', '', 8.5);
        $this->SetTextColor(80, 80, 80);
        $this->Cell(6, 5, '', 0, 0);
        $this->Cell(74, 5, $this->u($vendedor->correo), 0, 1);

        if (!empty($vendedor->telefono)) {
            $this->SetX(116);
            $this->Cell(6, 5, '', 0, 0);
            $this->Cell(74, 5, $this->u($vendedor->telefono), 0, 1);
        }

        $this->Ln(12);
    }

    // ── Banner de vigencia ────────────────────────────────────────────────────
    public function bannerVigencia($desde, $hasta)
    {
        $y = $this->GetY();

        // Fondo verde suave
        $this->SetFillColor(236, 253, 245);
        $this->SetDrawColor(C_VIGE_R, C_VIGE_G, C_VIGE_B);
        $this->SetLineWidth(0.5);
        $this->RoundedRect(10, $y, 190, 13, 3, 'DF');

        // Icono + texto
        $this->SetXY(14, $y + 2);
        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(C_VIGE_R, C_VIGE_G, C_VIGE_B);
        $this->Cell(30, 5, 'VIGENCIA:', 0, 0, 'L');

        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(30, 30, 30);
        $this->Cell(80, 5, 'Esta cotizacion es valida del  ' . $desde . '  al  ' . $hasta, 0, 0, 'L');

        $this->SetFont('Arial', 'I', 8.5);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 5, '(7 dias naturales a partir de la fecha de emision)', 0, 1, 'R');

        $this->Ln(7);
    }

    // ── Encabezado de la tabla ────────────────────────────────────────────────
    public function tablaEncabezado()
    {
        $this->SetFillColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 8.5);
        $this->SetDrawColor(255, 255, 255);
        $this->SetLineWidth(0.1);

        $this->Cell(10,  9, '#',            1, 0, 'C', true);
        $this->Cell(52,  9, 'PRODUCTO',     1, 0, 'L', true);
        $this->Cell(62,  9, 'DESCRIPCION',  1, 0, 'L', true);
        $this->Cell(18,  9, 'CANT.',        1, 0, 'C', true);
        $this->Cell(28,  9, 'PRECIO UNIT.', 1, 0, 'R', true);
        $this->Cell(20,  9, 'TOTAL',        1, 1, 'R', true);
    }

    // ── Fila de producto ──────────────────────────────────────────────────────
    public function tablaFila($producto, $fila)
    {
        if ($fila % 2 === 0) {
            $this->SetFillColor(C_FOND_R, C_FOND_G, C_FOND_B);
        } else {
            $this->SetFillColor(255, 255, 255);
        }

        $this->SetTextColor(45, 45, 45);
        $this->SetFont('Arial', '', 8.5);
        $this->SetDrawColor(215, 220, 230);
        $this->SetLineWidth(0.2);

        $subtotalFila = $producto->precio_unitario * $producto->cantidad;

        $nombre = $this->u($producto->name);
        $desc   = $this->u($producto->description ?? '');

        // Calcular altura necesaria para el contenido
        $lineasNombre = max(1, ceil($this->GetStringWidth($nombre) / 50));
        $lineasDesc   = max(1, ceil($this->GetStringWidth($desc)   / 60));
        $lineas       = max($lineasNombre, $lineasDesc, 1);
        $h            = max($lineas * 5.5, 9);

        $x = $this->GetX();
        $y = $this->GetY();

        // Nro de fila
        $this->SetFont('Arial', '', 7.5);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(10, $h, $fila + 1, 1, 0, 'C', true);

        // Nombre y descripción con MultiCell
        $this->SetFont('Arial', 'B', 8.5);
        $this->SetTextColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->MultiCell(52, $h, $nombre, 1, 'L', true);

        $this->SetXY($x + 62, $y);
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(70, 70, 70);
        $this->MultiCell(62, $h, $desc, 1, 'L', true);

        $this->SetXY($x + 124, $y);
        $this->SetFont('Arial', 'B', 8.5);
        $this->SetTextColor(45, 45, 45);
        $this->Cell(18, $h, $producto->cantidad,                                  1, 0, 'C', true);

        $this->SetFont('Arial', '', 8.5);
        $this->Cell(28, $h, '$' . number_format($producto->precio_unitario, 2),   1, 0, 'R', true);

        $this->SetFont('Arial', 'B', 8.5);
        $this->SetTextColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->Cell(20, $h, '$' . number_format($subtotalFila, 2),                1, 1, 'R', true);

        return $subtotalFila;
    }

    // ── Totales ───────────────────────────────────────────────────────────────
    // $subtotal = suma de líneas (precios base, sin IVA)
    public function tablaTotales($subtotal)
    {
        $iva        = $subtotal * 0.16;
        $totalFinal = $subtotal + $iva;

        $this->Ln(5);

        $colLabel = 56;
        $colVal   = 24;
        $xStart   = 210 - 10 - $colLabel - $colVal; // alineado al margen derecho

        // ── Subtotal ──
        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(C_FOND_R, C_FOND_G, C_FOND_B);
        $this->SetTextColor(60, 60, 60);
        $this->SetX($xStart);
        $this->Cell($colLabel, 8, 'Subtotal (sin IVA):', 0, 0, 'R', true);
        $this->Cell($colVal,   8, '$' . number_format($subtotal, 2), 0, 1, 'R', true);

        // ── IVA ──
        $this->SetX($xStart);
        $this->SetFillColor(255, 255, 255);
        $this->Cell($colLabel, 8, 'IVA (16%):', 0, 0, 'R', true);
        $this->Cell($colVal,   8, '$' . number_format($iva, 2), 0, 1, 'R', true);

        // Línea separadora
        $this->SetDrawColor(C_ACEL_R, C_ACEL_G, C_ACEL_B);
        $this->SetLineWidth(0.7);
        $lineX = $xStart;
        $this->Line($lineX, $this->GetY(), 200, $this->GetY());
        $this->SetLineWidth(0.2);
        $this->Ln(3);

        // ── Total final ──
        $this->SetFillColor(C_PRIM_R, C_PRIM_G, C_PRIM_B);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 11);
        $this->SetX($xStart);
        $this->Cell($colLabel, 11, 'TOTAL (con IVA):', 0, 0, 'R', true);
        $this->Cell($colVal,   11, '$' . number_format($totalFinal, 2), 0, 1, 'R', true);
    }

    // ── Sección de vigencia detallada ─────────────────────────────────────────
    public function seccionVigenciaDetalle($desde, $hasta)
    {
        $this->Ln(10);
        $y = $this->GetY();

        // Fondo
        $this->SetFillColor(236, 253, 245);
        $this->SetDrawColor(C_VIGE_R, C_VIGE_G, C_VIGE_B);
        $this->SetLineWidth(0.5);
        $this->RoundedRect(10, $y, 190, 26, 3, 'DF');

        // Barra izquierda de acento
        $this->SetFillColor(C_VIGE_R, C_VIGE_G, C_VIGE_B);
        $this->Rect(10, $y, 4, 26, 'F');

        // Título
        $this->SetXY(19, $y + 3);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(C_VIGE_R, C_VIGE_G, C_VIGE_B);
        $this->Cell(0, 6, 'Vigencia de esta cotizacion', 0, 1);

        // Texto principal
        $this->SetX(19);
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(30, 60, 30);
        $this->Cell(60, 5.5, 'Fecha de emision:  ' . $desde, 0, 0);
        $this->Cell(70, 5.5, 'Valida hasta:  ' . $hasta, 0, 0);

        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(C_VIGE_R, C_VIGE_G, C_VIGE_B);
        $this->Cell(0, 5.5, '7 dias naturales', 0, 1, 'R');

        // Aviso
        $this->SetX(19);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(80, 110, 80);
        $this->MultiCell(175, 5,
            'Transcurrido este plazo, los precios y condiciones quedan sujetos a revision. ' .
            'Para confirmar disponibilidad y precio vigente, contacte a su asesor comercial.',
            0, 'L'
        );
    }

    // ── Nota informativa ─────────────────────────────────────────────────────
    public function notaFinal()
    {
        $this->Ln(6);
        $y = $this->GetY();

        $this->SetFillColor(255, 252, 235);
        $this->SetDrawColor(200, 160, 40);
        $this->SetLineWidth(0.4);
        $this->RoundedRect(10, $y, 190, 20, 3, 'DF');

        // Barra izquierda ámbar
        $this->SetFillColor(C_NOTA_R, C_NOTA_G, C_NOTA_B);
        $this->Rect(10, $y, 4, 20, 'F');

        $this->SetXY(19, $y + 3);
        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(C_NOTA_R, C_NOTA_G, C_NOTA_B);
        $this->Cell(0, 5, 'Aviso importante:', 0, 1);

        $this->SetX(19);
        $this->SetFont('Arial', '', 8.5);
        $this->SetTextColor(70, 55, 10);
        $this->MultiCell(175, 5,
            'Los precios mostrados en esta cotizacion son referenciales y estan sujetos a disponibilidad de inventario. ' .
            'El precio unitario es precio base; el total incluye IVA del 16%. ' .
            'Para solicitar factura o condiciones especiales, contacte a su asesor.',
            0, 'L'
        );
    }

    // ── Rectángulo con esquinas redondeadas ───────────────────────────────────
    public function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k  = $this->k;
        $hp = $this->h;
        if ($style === 'F')                     $op = 'f';
        elseif ($style === 'FD' || $style === 'DF') $op = 'B';
        else                                    $op = 'S';

        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
        $this->_Arc($x + $w - $r, $y,          $x + $w, $y,          $x + $w, $y + $r);
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - ($y + $h - $r)) * $k));
        $this->_Arc($x + $w, $y + $h - $r,     $x + $w, $y + $h,     $x + $w - $r, $y + $h);
        $this->_out(sprintf('%.2F %.2F l', ($x + $r) * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($x + $r, $y + $h,           $x, $y + $h,          $x, $y + $h - $r);
        $this->_out(sprintf('%.2F %.2F l', $x * $k, ($hp - ($y + $r)) * $k));
        $this->_Arc($x, $y + $r,                $x, $y,               $x + $r, $y);
        $this->_out($op);
    }

    private function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            $x1 * $this->k, ($h - $y1) * $this->k,
            $x2 * $this->k, ($h - $y2) * $this->k,
            $x3 * $this->k, ($h - $y3) * $this->k
        ));
    }

    // ── Helper: UTF-8 → Latin-1 ───────────────────────────────────────────────
    public function u($str)
    {
        if (empty($str)) return '';
        return iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', (string)$str);
    }
}

// ─── Generación del PDF ───────────────────────────────────────────────────────
$pdf = new CotizacionPDF('P', 'mm', 'A4');
$pdf->SetAutoPageBreak(true, 28);
$pdf->SetMargins(10, 52, 10);
$pdf->SetTitle('Cotizacion #' . $ordenes->id . ' - ' . $cliente->nombre);
$pdf->SetAuthor('Grupo Croram');
$pdf->setDatosEncabezado(
    $ordenes->id,
    $fechaEmision,
    $fechaVigencia
);

$pdf->AddPage();

// ── Sección partes (cliente + vendedor) ──
$pdf->seccionPartes($cliente, $vendedor);

// ── Banner de vigencia compacto ──
$pdf->bannerVigencia($fechaEmision, $fechaVigencia);

// ── Tabla de productos ──
$pdf->tablaEncabezado();

$subtotal = 0;
$fila     = 0;
foreach ($productos as $producto) {
    // Salto de página si no queda espacio suficiente
    if ($pdf->GetY() > 235) {
        $pdf->AddPage();
        $pdf->tablaEncabezado();
    }
    $subtotal += $pdf->tablaFila($producto, $fila);
    $fila++;
}

// ── Totales (subtotal + IVA + total final) ──
$pdf->tablaTotales($subtotal);

// ── Sección de vigencia detallada ──
$pdf->seccionVigenciaDetalle($fechaEmision, $fechaVigencia);

// ── Nota informativa ──
$pdf->notaFinal();

// ─── Output ───────────────────────────────────────────────────────────────────
$pdf->Output('I', 'Cotizacion_' . $ordenes->id . '.pdf');