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
$labNomUser = $_SESSION['labNomUser'];

require('../../assets/lib/fpdf/rotation.php');

require_once '../../model/Cerits.php';
$ce = new Cerits();
require_once '../../model/Tipo.php';
$t = new Tipo();

$rsHI = $t->get_datosfecHoraActual();

class PDF extends PDF_Rotate{
function Header(){
	//Put the watermark
	$this->SetFont('Arial','B',70);
	$this->SetTextColor(255,192,203);
	$this->RotatedText(65,110,'GRATUITO',40);
}

function RotatedText($x, $y, $txt, $angle){
	//Text rotated around its origin
	$this->Rotate($angle,$x,$y);
	$this->Text($x,$y,$txt);
	$this->Rotate(0);
}
}

$pdf=new PDF('L','mm','A5');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,4);
$pdf->SetMargins(8,4,8);
$pdf->AliasNbPages();
$pdf->AddPage();

$idSolicitud = $_GET['id_solicitud'];
$rsSCE = $ce->get_datosSoliConstanciaITS($idSolicitud);

$pdf->Ln(1);
$pdf->Image('../../assets/images/logo_diris.png',8,4,68);

$pdf->SetY(15);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6, utf8_decode('CENTRO DE REFERENCIAS DE LAS INFECCIONES DE TRANSMISIÓN SEXUAL, VIH Y SIDA'),0,1,'C', false);
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
$pdf->SetX(145);
$pdf->Cell(33, 4, utf8_decode('N° de constancia:'), 0, 0, 'L', false);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(23, 4, $rsSCE[0]['nro_ordenatencion']."-".$rsSCE[0]['anio_ordensoli'],0,1,'C', false);

$pdf->Ln(3);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(0, 6, utf8_decode('CONSTANCIA DE ATENCIÓN'),0,1,'C', false);

if($rsSCE[0]['id_sexo'] == "1"){
$sr = "el Sr.";
$iden = "Identificado";
$ate = "atendido";
$usu = "el usuario";
} else {
$sr = "la Sra. (Srta.)";
$iden = "Identificada";
$ate = "atendida";
$usu = "la usuaria";
}

$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0, 5, utf8_decode('Conste por el presente que ' . $sr . ':'), 0, 1, 'L', false);

$pdf->Ln(3);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0, 5, utf8_decode($rsSCE[0]['nombre_rs']), 0, 1, 'C', false);

$pdf->Ln(3);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,6,utf8_decode($iden . " con " . $rsSCE[0]['abrev_tipodoc'] . " N° " . $rsSCE[0]['nrodoc'] . " y con Historia Clínica N° " . $rsSCE[0]['nro_hc'] . ", ha sido " . $ate . " y hasta la fecha no presenta ninguna ITS. Se expide esta Constancia para los fines que " . $usu . " considere pertinente."), 0, 'J', 0);

$pdf->Ln(4);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0, 5, utf8_decode('VIGENCIA: De: ' . $rsSCE[0]['fec_inicio'] . ' al ' . $rsSCE[0]['fec_termino']), 0, 1, 'L', false);

$pdf->Ln(4);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0, 5, utf8_decode($rsSCE[0]['distrito_depen'] . ','.$t->nombrar_fecha($rsSCE[0]["fec_atencioni"])), 0, 1, 'R', false);

$pdf->Ln(30);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(15,4,'',0,0,'');
$pdf->Cell(70, 4, utf8_decode('Profesional Responsable de la Atención'), 'T', 0, 'C');
$pdf->Cell(25,4,'',0,0,'');
$pdf->Cell(70, 4, utf8_decode('V. B. Responsable del CERTIS'), 'T', 1, 'C');

$pdf->Ln(2);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0, 5, utf8_decode('NOTA: Carece de valor si no cuenta con rubrica original del responsable del CERITS.'), 0, 1, 'L', false);

$pdf->Output();
?>
