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

include '../../assets/lib/fpdf/fpdf.php';

require_once '../../model/Area.php';
$a = new Area();
require_once '../../model/Grupo.php';
$g = new Grupo();
require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/Atencion.php';
$at = new Atencion();
/*
$idAtencion = $_GET['id_atencion'];
$idArea =  $_GET['id_area'];
*/
class PDF extends FPDF{
}

$pdf=new PDF('P','mm','A4');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,4);
$pdf->SetMargins(9,0,1);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetY(30);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(54, 5, utf8_decode('6178'),'LTB',0,'C', false);
$pdf->Cell(145, 5, utf8_decode('C.S. SURQUILLO'),'1',1,'C', false);
$pdf->Cell(0, 5, '','0',1,'C', false);

$pdf->SetX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(5, 4, 'X','1',0,'C', false);
$pdf->SetX(82);
$pdf->Cell(5, 4, 'X','1',0,'C', false);
$pdf->SetX(105);
$pdf->Cell(5, 4, 'X','1',1,'C', false);

$pdf->Sety(44);
$pdf->SetX(110);
$pdf->Cell(15, 8, '45789','1',0,'C', false);
$pdf->Cell(65, 8, '45789','1',0,'C', false);
$pdf->Cell(18, 8, '45789','1',1,'C', false);

$pdf->Sety(44);
$pdf->SetX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(5, 4, 'X','1',0,'C', false);
$pdf->SetX(82);
$pdf->Cell(5, 4, 'X','1',0,'C', false);
$pdf->SetX(105);
$pdf->Cell(5, 4, 'X','1',1,'C', false);

$pdf->SetX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(5, 4, 'X','1',0,'C', false);
$pdf->SetX(105);
$pdf->Cell(5, 4, 'X','1',1,'C', false);

$pdf->Output();

?>
