<?php
session_start();

if (!isset($_SESSION["labAccess"])) {
  header("location:../index.php");
  exit();
}
if ($_SESSION["labAccess"] <> "Yes") {
  header("location:../index.php");
  exit();
}
$labIdUser = $_SESSION['labIdUser'];
$labIdDepUser = $_SESSION['labIdDepUser'];
$labIdRolUser = $_SESSION['labIdRolUser'];

include '../../assets/lib/fpdf/fpdf.php';

require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/Lab.php';
$la = new Lab();

class PDF extends FPDF
{
  //Cabecera de página
  function Header()
  {
    require_once '../../model/Dependencia.php';
    $d = new Dependencia();
	require_once '../../model/Tipo.php';
	$t = new Tipo();

    //Logo
    $this->Image('../../assets/images/logo_diris.png',8,8,48);
	$rsD = $d->get_datosDepenendenciaPorId($_SESSION['labIdDepUser']);
    $this->SetFont('Arial','B',12);
	$this->Cell(50,8,"",0,0,'L');
    $this->Cell(144,8,utf8_decode("REPORTE DE BACILOSCOPIAS MES " . $t->nombrar_mes($_GET['mes']) . " DEL " . $_GET['anio']),0,1,'C');

    $this->Ln(2);
    $this->SetFont('Arial','B',8);
    $this->Cell(115,7,utf8_decode("EESS: " . $rsD[0]["nom_depen"]),0,0,'L');
	$rsHI = $t->get_datosfecHoraActual();
	$this->SetFont('Arial','',8);
	$this->Cell(79,7,"Fecha y hora reporte: " . $rsHI[0]['fechora_actual'],0,1,'R');
  }

  //Pie de página
  function Footer()
  {
    //Posición: a 1,5 cm del final (Siempre va en el footer)
    $this->SetY(-20);
    $this->SetFont('Arial','',7);
    $this->Cell(210,4,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'L');

  }
}

$pdf=new PDF('P','mm','A4');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,20); //Siempre cuando se va a poner el pie de página
$pdf->SetMargins(8,8,8);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->ln(3);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(58, 6, utf8_decode('DIAGNÓSTICO'), 1, 0, 'L', false);
$pdf->Cell(21, 6, 'N', 1, 0, 'C', false);
$pdf->Cell(21, 6, 'P', 1, 0, 'C', false);
$pdf->Cell(22, 6, 'POSITIVO (+)', 1, 0, 'C', false);
$pdf->Cell(23, 6, 'POSITIVO (++)', 1, 0, 'C', false);
$pdf->Cell(25, 6, 'POSITIVO (+++)', 1, 0, 'C', false);
$pdf->Cell(25, 6, 'PAUCIBACILAR', 1, 1, 'C', false);
$rsC = $c->get_listaSeleccionResultadoPorTipo(45);
/*print_r($rsC);
exit();*/

$totcntNega = (Int) 0;
$totcntPosi = (Int) 0;
$totcntPosi1 = (Int) 0;
$totcntPosi2 = (Int) 0;
$totcntPosi3 = (Int) 0;
$totcntPau = (Int) 0;

$cntNega = (Int) 0;
$cntPosi = (Int) 0;
$cntPosi1 = (Int) 0;
$cntPosi2 = (Int) 0;
$cntPosi3 = (Int) 0;
$cntPau = (Int) 0;

foreach ($rsC as $row) {
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(58, 6, utf8_decode($row['nombre']), 'LBR', 0, 'L', false);
	$cntNega = $la->get_CntBKValidPorAnioMesAndIddependencia($labIdDepUser, $_GET['anio'], $_GET['mes'], $row['id'],204);
	$cntPosi1 = $la->get_CntBKValidPorAnioMesAndIddependencia($labIdDepUser, $_GET['anio'], $_GET['mes'], $row['id'], 205);
	$cntPosi2 = $la->get_CntBKValidPorAnioMesAndIddependencia($labIdDepUser, $_GET['anio'], $_GET['mes'], $row['id'],206);
	$cntPosi3 = $la->get_CntBKValidPorAnioMesAndIddependencia($labIdDepUser, $_GET['anio'], $_GET['mes'], $row['id'],207);
	$cntPau = $la->get_CntBKValidPorAnioMesAndIddependencia($labIdDepUser, $_GET['anio'], $_GET['mes'], $row['id'],99);
	$pdf->Cell(21, 6, $cntNega, 'LBR', 0, 'C', false);
	$pdf->Cell(21, 6, ($cntPosi1 + $cntPosi2 + $cntPosi3), 'LBR', 0, 'C', false);
	$pdf->Cell(22, 6, $cntPosi1, 'LBR', 0, 'C', false);
	$pdf->Cell(23, 6, $cntPosi2, 'LBR', 0, 'C', false);
	$pdf->Cell(25, 6, $cntPosi3, 'LBR', 0, 'C', false);
	$pdf->Cell(25, 6, $cntPau, 'LBR', 1, 'C', false);
	
	$totcntNega = $totcntNega + $cntNega;
	$totcntPosi = $totcntPosi + $cntPosi1 + $cntPosi2 + $cntPosi3;
	$totcntPosi1 = $totcntPosi1 + $cntPosi1;
	$totcntPosi2 = $totcntPosi2 + $cntPosi2;
	$totcntPosi3 = $totcntPosi3 + $cntPosi3;
	$totcntPau = $totcntPau + $cntPau;
}

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(58, 6, "TOTAL: " . ($totcntNega + $totcntPosi + $totcntPau), 'LBR', 0, 'L', false);
	$pdf->Cell(21, 6, $totcntNega, 'LBR', 0, 'C', false);
	$pdf->Cell(21, 6, $totcntPosi, 'LBR', 0, 'C', false);
	$pdf->Cell(22, 6, $totcntPosi1, 'LBR', 0, 'C', false);
	$pdf->Cell(23, 6, $totcntPosi2, 'LBR', 0, 'C', false);
	$pdf->Cell(25, 6, $totcntPosi3, 'LBR', 0, 'C', false);
	$pdf->Cell(25, 6, $totcntPau, 'LBR', 1, 'C', false);

$pdf->Output();
?>
