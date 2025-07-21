<?php
session_start();
$reg = 0;
$datos = array();
$filtro=$_SESSION['filtro'];
$valor=$_SESSION['valorFiltro'];
$cliente = new SoapClient(null, array('uri' => 'http://localhost/', 'location' => 'https://virtualizacione01.000webhostapp.com/bitacora/serviciosweb/servicioweb.php'));
$datos = $cliente->mostrarbitacora($filtro,$valor);

date_default_timezone_set('America/Mexico_City');
$hoy = new DateTime();
require('pdf/pdf/fpdf.php');

class PDF extends FPDF {
    // Encabezado de la página
    function Header() {
        global $hoy;
        if ($this->PageNo() == 1) {
            $this->SetFont('Arial', 'B', 14);
            $this->Image('../img/dd.png', 15, 4, 40, 30, 'PNG', '');
            $this->Cell(60, 10);
            if($_SESSION['filtro']=='personal'){
                $this->Write(15, 'Reporte De Bitacora Filtrado Por Personal');
            } else if($_SESSION['filtro']=='rol'){
                $this->Write(15, 'Reporte De Bitacora Filtrado Por Rol');
            } else if($_SESSION['filtro']=='actividad'){
                $this->Write(15, 'Reporte De Bitacora Filtrado Por Proceso');
            } else if($_SESSION['filtro']=='fecha'){
                $this->Write(15, 'Reporte De Bitacora Filtrado Por Fecha');
            } else if($_SESSION['filtro']=='tarea'){
                $this->Write(15, 'Reporte De Bitacora Filtrado Por Tarea');
            } else if($_SESSION['filtro']=='proyecto'){
                $this->Write(15, 'Reporte De Bitacora Filtrado Por Proyecto');
            } else if($_SESSION['filtro']=='todos'){
                $this->Write(15, 'Reporte De Bitacora Filtrado Por Todos Los Datos');
            }
            $this->SetDrawColor(52, 73, 94);
            $this->Line(10, 35, 199, 35);
        }
        $this->SetFont('Arial', '', 7);
        $this->SetDrawColor(52, 73, 94);
        $this->Line(10, 35, 199, 35);
        $this->Ln();
        $this->Cell(170, 13, utf8_decode('Fecha de impresión: ') . $hoy->format('d/m/Y H:i:s'), 0, 0, 'R');
        
        $this->Ln();
        
        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(255, 255, 255);
        $this->SetFillColor(52, 73, 94);
        $this->SetDrawColor(255, 255, 255);
        $this->Cell(10, 8, utf8_decode('Clave'), 1, 0, 'C', true);
        $this->Cell(29, 8, utf8_decode('Nombre Personal'), 1, 0, 'C', true);
        $this->Cell(19, 8, utf8_decode('Rol'), 1, 0, 'C', true);
        $this->Cell(25, 8, utf8_decode('Fecha'), 1, 0, 'C', true);
        $this->Cell(30, 8, utf8_decode('Tarea Asignada'), 1, 0, 'C', true);
        $this->Cell(30, 8, utf8_decode('Proyecto Asignado'), 1, 0, 'C', true);
        $this->Cell(45, 8, utf8_decode('Actividad'), 1, 0, 'C', true);
        $this->Ln();
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Celda con texto multilínea
    function MultiCellRow($data, $height = 8) {
        $yStart = $this->GetY();
        $maxHeight = $height;

        // Calcular la altura de la fila
        foreach ($data as $col) {
            $nb = $this->NbLines($col[1], $col[0]);
            $h = $height * $nb;
            if ($h > $maxHeight) {
                $maxHeight = $h;
            }
        }

        // Hacer que la altura de la fila sea consistente
        foreach ($data as $col) {
            $x = $this->GetX();
            $this->MultiCell($col[1], $height, utf8_decode($col[0]), 0, 'L');
            $this->SetXY($x + $col[1], $yStart);
        }
        $this->Ln($maxHeight);
    }

    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(0, 0, 0);

foreach ($datos as $dato) {
    $pdf->MultiCellRow([
        [$dato["bID"], 10],
        [$dato["personal"], 29],
        [$dato["rol"], 20],
        [$dato["fecha"], 25],
        [$dato["tarea"], 30],
        [$dato["proyecto"], 30],
        [$dato["actividad"], 45]
    ]);

    // Verificar si se necesita otra página
    if ($pdf->GetY() > 260) {
        $pdf->AddPage();
    }
}

$pdf->Output();
?>
