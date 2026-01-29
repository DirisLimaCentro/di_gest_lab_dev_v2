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

require_once '../../model/Atencion.php';
$a = new Atencion();

$fecIni = $_GET['fecIni'];
$fecFin = $_GET['fecFin'];
$id_examen = $_GET['id_examen'];

class PDF extends FPDF
{
  //Cabecera de página
  function Header()
  {
    require_once '../../model/Dependencia.php';
    $d = new Dependencia();

    //Logo
    $this->Image('../../assets/images/logo_diris.png',8,8,48);

    $this->SetFont('Arial','B',11);
    $this->Cell(0,7,utf8_decode("REGISTRO RESULTADOS POR EXAMEN REALIZADO EN LABORATORIO CLINICO"),0,1,'C');

    $this->Ln(2);
    $this->SetFont('Arial','B',8);
    $this->Cell(37,5,utf8_decode("Establecimiento de salud:"),0,0,'L');
    $rsD = $d->get_datosDepenendenciaPorId($_SESSION['labIdDepUser']);
    $this->SetFont('Arial','',8);
    $this->Cell(115,5,utf8_decode($rsD[0]["nom_depen"]),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(12,5,utf8_decode("Distrito:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(76,5,utf8_decode($rsD[0]["distrito"]),0,1,'L');

    $this->SetFont('Arial','B',7);
    $this->Cell(10, 4, utf8_decode('Item'), 'LTR', 0, 'C', false);
    $this->Cell(14, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', false);
    $this->Cell(7, 4, utf8_decode('Plan'), 'LTR', 0, 'C', false);
    $this->Cell(22, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('H.C.'), 'LTR', 0, 'C', false);
    $this->Cell(70, 4, utf8_decode('Paciente'), 'LTR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', false);
    $this->Cell(67, 4, utf8_decode('Examen'), 'LTR', 0, 'C', false);
	$this->Cell(30, 4, utf8_decode('Resultado'), 'LTR', 0, 'C', false);
    $this->Cell(15, 4, utf8_decode('U.M.'), 'LTR', 1, 'C', false);


    $this->Cell(10, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(14, 4, utf8_decode('Atención'), 'LBR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('Atención'), 'LBR', 0, 'C', false);
    $this->Cell(7, 4, utf8_decode('Tarif.'), 'LBR', 0, 'C', false);
    $this->Cell(22, 4, utf8_decode('Documento'), 'LBR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(70, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('Resultado'), 'LBR', 0, 'C', false);
    $this->Cell(67, 4, utf8_decode(''), 'LBR', 0, 'C', false);
	$this->Cell(30, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(15, 4, utf8_decode(''), 'LBR', 1, 'C', false);

    //$this->Cell(0, 4, utf8_decode('Resultado'), 1, 1, 'C', false);
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

$pdf=new PDF('L','mm','A4');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,20); //Siempre cuando se va a poner el pie de página
$pdf->SetMargins(8,8,8);
$pdf->AliasNbPages();
$pdf->AddPage();

$param[0]['fecIniAte'] = $fecIni;
$param[0]['fecFinAte'] = $fecFin;
$param[0]['id_examen'] = $id_examen;
$param[0]['idDepAten'] = $labIdDepUser;

$rsC = $a->get_repDatosResultadoExamenPorFecha($param);
/*print_r($rsC);
exit();*/
$item = 0;
foreach ($rsC as $row) {
  $item ++;
  $pdf->SetFont('Arial','',7);
  $pdf->Cell(10, 4, $item, 'LBR', 0, 'C', false);
  $pdf->Cell(14, 4, $row['nro_atenciondia'], 'BR', 0, 'C', false);
  $pdf->Cell(16, 4, utf8_decode($row['fec_atencion']), 'LBR', 0, 'C', false);
  $pdf->Cell(7, 4, utf8_decode($row['abrev_plan']), 'LBR', 0, 'C', false);
  $pdf->Cell(22, 4, utf8_decode($row['abrev_tipodoc']. ": ".$row['nrodoc']), 'LBR', 0, 'L', false);
  $pdf->Cell(16, 4, utf8_decode($row['nro_hc']), 'LBR', 0, 'C', false);
  $pdf->Cell(70, 4, utf8_decode($row['nombre_rs']), 'LBR', 0, 'L', false);
  $pdf->Cell(16, 4, utf8_decode($row['fec_resultado']), 'LBR', 0, 'C', false);
  $pdf->Cell(67, 4, utf8_decode($row['componente']), 'LBR', 0, 'L', false);
  $pdf->Cell(30, 4, utf8_decode($row['det_resul']), 'LBR', 0, 'C', false);
  $pdf->Cell(15, 4, utf8_decode($row['uni_medida']), 'LBR', 1, 'C', false);
}

if($item <= 25){
  $pdf->Ln(2);
  $pdf->Cell(75,1,'','',0,'');
  $pdf->Cell(60,1,'','B',0,'');
  $pdf->Cell(18,1,'******','',0,'C');
  $pdf->Cell(60,1,'','B',1,'');
}

$pdf->Output();
?>
