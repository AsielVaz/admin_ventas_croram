<?php
session_start();

require_once "fpdf/fpdf.php";
include_once "adminReportes.php";

function limpiarFecha($fecha, $fallback)
{
    return preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$fecha) ? $fecha : $fallback;
}

function txt($value)
{
    $value = trim((string)$value);
    $value = str_replace(["\r", "\n", "\t"], ' ', $value);
    $value = preg_replace('/\s+/', ' ', $value);
    if (function_exists('iconv')) {
        $converted = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $value);
        if ($converted !== false) return $converted;
    }
    return utf8_decode($value);
}

function money($value)
{
    return '$' . number_format(floatval($value), 2);
}

function num($value)
{
    return number_format(floatval($value), 2);
}

class ReporteCroramPDF extends FPDF
{
    private string $fechaInicio = '';
    private string $fechaFin = '';

    public function setPeriodo(string $fechaInicio, string $fechaFin): void
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    public function Header()
    {
        $this->SetFillColor(29, 78, 216);
        $this->Rect(0, 0, 210, 12, 'F');
        $this->SetFillColor(8, 145, 178);
        $this->Rect(0, 11, 210, 2, 'F');

        $logo = __DIR__ . '/../assets/images/logo/croram_dark_m.png';
        if (file_exists($logo)) {
            @$this->Image($logo, 12, 17, 42);
        }

        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(30, 41, 59);
        $this->SetXY(78, 17);
        $this->Cell(120, 8, txt('Reporte ejecutivo'), 0, 1, 'R');

        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(100, 116, 139);
        $this->SetX(78);
        $this->Cell(120, 5, txt('Periodo: ' . $this->fechaInicio . ' al ' . $this->fechaFin), 0, 1, 'R');
        $this->SetX(78);
        $this->Cell(120, 5, txt('Generado: ' . date('d/m/Y H:i')), 0, 1, 'R');

        $this->SetDrawColor(226, 232, 240);
        $this->Line(12, 42, 198, 42);
        $this->Ln(20);
    }

    public function Footer()
    {
        $this->SetY(-16);
        $this->SetDrawColor(226, 232, 240);
        $this->Line(12, $this->GetY(), 198, $this->GetY());
        $this->Ln(3);
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(100, 116, 139);
        $this->Cell(0, 5, txt('Grupo Croram | Pagina ' . $this->PageNo()), 0, 0, 'C');
    }

    public function sectionTitle(string $title): void
    {
        $this->ensureSpace(22);
        $this->SetFillColor(248, 250, 252);
        $this->SetDrawColor(226, 232, 240);
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(30, 41, 59);
        $this->Cell(0, 8, txt($title), 1, 1, 'L', true);
        $this->Ln(2);
    }

    public function kpiRow(array $items): void
    {
        $this->ensureSpace(26);
        $w = 46.5;
        foreach ($items as $index => $item) {
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetFillColor(255, 255, 255);
            $this->SetDrawColor(226, 232, 240);
            $this->Rect($x, $y, $w, 22, 'DF');
            $this->SetXY($x + 3, $y + 3);
            $this->SetFont('Arial', '', 7.5);
            $this->SetTextColor(100, 116, 139);
            $this->Cell($w - 6, 4, txt($item[0]), 0, 2);
            $this->SetFont('Arial', 'B', 11);
            $this->SetTextColor(30, 41, 59);
            $this->Cell($w - 6, 7, txt($item[1]), 0, 0);
            $this->SetXY($x + $w + 2, $y);
            if (($index + 1) % 4 === 0) {
                $this->Ln(25);
            }
        }
        if (count($items) % 4 !== 0) $this->Ln(25);
    }

    public function table(array $headers, array $widths, array $rows, int $limit = 12): void
    {
        $this->ensureSpace(18);
        $this->SetFillColor(29, 78, 216);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 7.5);
        foreach ($headers as $i => $header) {
            $this->Cell($widths[$i], 7, txt($header), 1, 0, 'L', true);
        }
        $this->Ln();

        $this->SetFont('Arial', '', 7.2);
        $this->SetTextColor(30, 41, 59);
        $printed = 0;
        foreach ($rows as $row) {
            if ($printed >= $limit) break;
            $this->ensureSpace(8);
            $fill = $printed % 2 === 0;
            $this->SetFillColor($fill ? 248 : 255, $fill ? 250 : 255, $fill ? 252 : 255);
            foreach ($row as $i => $cell) {
                $text = txt($cell);
                if (strlen($text) > 46) $text = substr($text, 0, 43) . '...';
                $align = preg_match('/^\$|^[\d,.]+$/', $text) ? 'R' : 'L';
                $this->Cell($widths[$i], 6.5, $text, 1, 0, $align, true);
            }
            $this->Ln();
            $printed++;
        }

        if (count($rows) > $limit) {
            $this->SetFont('Arial', 'I', 7);
            $this->SetTextColor(100, 116, 139);
            $this->Cell(0, 6, txt('Se muestran ' . $limit . ' de ' . count($rows) . ' registros. El detalle completo esta disponible en el panel exportable.'), 0, 1);
        }
        if (count($rows) === 0) {
            $this->SetFont('Arial', 'I', 8);
            $this->SetTextColor(100, 116, 139);
            $this->Cell(array_sum($widths), 7, txt('Sin datos en el periodo seleccionado.'), 1, 1, 'C');
        }
        $this->Ln(4);
    }

    public function paragraph(string $text): void
    {
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(71, 85, 105);
        $this->MultiCell(0, 5, txt($text));
        $this->Ln(2);
    }

    private function ensureSpace(float $height): void
    {
        if ($this->GetY() + $height > 274) {
            $this->AddPage();
        }
    }
}

$hoy = date('Y-m-d');
$inicioMes = date('Y-m-01');
$fechaInicio = limpiarFecha($_GET['fecha_inicio'] ?? $inicioMes, $inicioMes);
$fechaFin = limpiarFecha($_GET['fecha_fin'] ?? $hoy, $hoy);
if ($fechaInicio > $fechaFin) {
    $tmp = $fechaInicio;
    $fechaInicio = $fechaFin;
    $fechaFin = $tmp;
}

$adminReportes = new AdministradorReportes();
$resumen = $adminReportes->dameResumen($fechaInicio, $fechaFin);
$productos = $adminReportes->dameProductosVendidos($fechaInicio, $fechaFin);
$clientes = $adminReportes->dameClientesVentas($fechaInicio, $fechaFin);
$cobranza = $adminReportes->dameCobranza($fechaInicio, $fechaFin);
$devoluciones = $adminReportes->dameDevoluciones($fechaInicio, $fechaFin);
$estatus = $adminReportes->dameOrdenesPorEstatus($fechaInicio, $fechaFin);
$tipoPago = $adminReportes->dameVentasPorTipoPago($fechaInicio, $fechaFin);
$capturistas = $adminReportes->dameCapturistas($fechaInicio, $fechaFin);

if (!is_object($resumen)) $resumen = (object)['ordenes'=>0,'clientes'=>0,'ventas'=>0,'unidades'=>0,'pagado'=>0,'saldo'=>0];
foreach (['productos','clientes','cobranza','devoluciones','estatus','tipoPago','capturistas'] as $lista) {
    if (!is_array($$lista)) $$lista = [];
}

$totalDevoluciones = 0;
$montoDevoluciones = 0;
foreach ($devoluciones as $dev) {
    $totalDevoluciones += floatval($dev->cantidad ?? 0);
    $montoDevoluciones += floatval($dev->monto_estimado ?? 0);
}

$ventas = floatval($resumen->ventas ?? 0);
$pagado = floatval($resumen->pagado ?? 0);
$saldo = floatval($resumen->saldo ?? 0);
$ordenes = intval($resumen->ordenes ?? 0);
$ticket = $ordenes > 0 ? $ventas / $ordenes : 0;
$cobranzaPct = $ventas > 0 ? ($pagado / $ventas) * 100 : 0;

$pdf = new ReporteCroramPDF('P', 'mm', 'Letter');
$pdf->SetMargins(12, 48, 12);
$pdf->SetAutoPageBreak(true, 18);
$pdf->setPeriodo($fechaInicio, $fechaFin);
$pdf->AddPage();

$pdf->sectionTitle('Resumen ejecutivo');
$pdf->kpiRow([
    ['Ventas', money($ventas)],
    ['Pagado', money($pagado)],
    ['Saldo', money($saldo)],
    ['Ordenes', number_format($ordenes)],
    ['Clientes', number_format(intval($resumen->clientes ?? 0))],
    ['Unidades', num($resumen->unidades ?? 0)],
    ['Ticket promedio', money($ticket)],
    ['Cobranza', number_format($cobranzaPct, 1) . '%'],
]);
$pdf->paragraph('Este documento resume la informacion relevante del periodo seleccionado: ventas netas sin ordenes canceladas, cobranza aplicada, saldos pendientes, productos con mayor movimiento, clientes principales, devoluciones y operacion.');

$pdf->sectionTitle('Ventas por tipo de pago');
$rows = [];
foreach ($tipoPago as $row) {
    $rows[] = [$row->tipo_pago ?? '', number_format(intval($row->ordenes ?? 0)), money($row->total ?? 0)];
}
$pdf->table(['Tipo', 'Ordenes', 'Total'], [80, 35, 55], $rows, 8);

$pdf->sectionTitle('Top clientes');
$rows = [];
foreach ($clientes as $row) {
    $rows[] = [$row->cliente ?? '', number_format(intval($row->ordenes ?? 0)), num($row->unidades ?? 0), money($row->total ?? 0), money($row->saldo ?? 0)];
}
$pdf->table(['Cliente', 'Ordenes', 'Unidades', 'Total', 'Saldo'], [68, 25, 28, 38, 38], $rows, 12);

$pdf->sectionTitle('Productos mas vendidos');
$rows = [];
foreach ($productos as $row) {
    $rows[] = [$row->producto ?? '', $row->codigo ?? '', num($row->unidades ?? 0), money($row->precio_promedio ?? 0), money($row->total ?? 0)];
}
$pdf->table(['Producto', 'Codigo', 'Unidades', 'Precio prom.', 'Total'], [72, 28, 28, 35, 34], $rows, 14);

$pdf->sectionTitle('Cobranza pendiente');
$rows = [];
foreach ($cobranza as $row) {
    $tipo = intval($row->tipo_pago ?? 0) === 2 ? 'Credito' : 'Contado';
    $rows[] = ['#' . intval($row->id_orden ?? 0), substr($row->fecha_entrega ?? '', 0, 10), $row->cliente ?? '', money($row->total ?? 0), money($row->saldo ?? 0), $tipo];
}
$pdf->table(['Orden', 'Fecha', 'Cliente', 'Total', 'Saldo', 'Tipo'], [22, 25, 62, 30, 30, 28], $rows, 14);

$pdf->sectionTitle('Devoluciones');
$rows = [];
foreach ($devoluciones as $row) {
    $rows[] = [substr($row->fecha_ingresa ?? '', 0, 10), '#' . intval($row->id_orden ?? 0), $row->cliente ?? '', $row->producto ?? '', num($row->cantidad ?? 0), money($row->monto_estimado ?? 0)];
}
$pdf->paragraph('Total devuelto estimado: ' . money($montoDevoluciones) . ' | Unidades devueltas: ' . num($totalDevoluciones));
$pdf->table(['Fecha', 'Orden', 'Cliente', 'Producto', 'Cant.', 'Monto est.'], [24, 20, 48, 55, 20, 30], $rows, 12);

$pdf->sectionTitle('Operacion');
$rows = [];
foreach ($estatus as $row) {
    $rows[] = [$row->estatus ?? '', number_format(intval($row->ordenes ?? 0))];
}
$pdf->table(['Estatus', 'Ordenes'], [110, 35], $rows, 8);

$rows = [];
foreach ($capturistas as $row) {
    $rows[] = [$row->capturista ?? '', number_format(intval($row->ordenes ?? 0)), money($row->total ?? 0)];
}
$pdf->table(['Capturista', 'Ordenes', 'Total generado'], [95, 35, 55], $rows, 10);

$filename = 'Reporte_Croram_' . $fechaInicio . '_a_' . $fechaFin . '.pdf';
$pdf->Output('D', $filename);
