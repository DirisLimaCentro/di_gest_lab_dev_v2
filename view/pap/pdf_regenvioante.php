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

include '../../assets/lib/fpdf/fpdf.php';

require_once '../../model/Pap.php';
$pap = new Pap();

class PDF extends FPDF
{
  //Cabecera de página
  function Header()
  {
    //Logo
    $this->Image('../../assets/images/logo_diris.png',8,8,48);

    $this->SetFont('Arial','B',11);
    $this->Cell(0,7,utf8_decode("Solicitud y Resultado de Citología: Registro General (PAP)"),0,1,'C');

    $this->Ln(2);
    $this->SetFont('Arial','B',8);
    $this->Cell(44,5,utf8_decode("ESTABLECIMIENTO DE SALUD:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(80,5,utf8_decode($_SESSION['labNomDepUser']),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(12,5,utf8_decode("Distrito:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(86,5,utf8_decode("SAN JUAN DE LURIGANCHO"),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(11,5,utf8_decode("Fecha:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(17,5,date("d/m/Y"),0,1,'L');

    $this->SetFont('Arial','B',8);
    $this->Cell(47,5,utf8_decode("Responsable de toma de muestra:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(77,5,utf8_decode($_SESSION['labNomPer'] . " " . $_SESSION['labApePatPer'] . " " . $_SESSION['labApeMatPer']),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(13,5,utf8_decode("Servicio:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(85,5,utf8_decode($_SESSION['labNomServicio']),0,1,'L');
/*
    $this->SetFont('Arial','B',8);
    $this->Cell(38,5,utf8_decode("Hoja de envio de solicitud:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(10,5,'1',0,1,'L');
*/
    $this->SetFont('Arial','B',7);
    $this->Cell(12, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(14, 4, utf8_decode('H.C.'), 'LTR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode('SIS'), 'LTR', 0, 'C', false);
    $this->Cell(72, 4, utf8_decode('Apellidos y Nombres'), 'LTR', 0, 'C', false);
    $this->Cell(72, 4, utf8_decode('Dirección'), 'LTR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode('Edad'), 'LTR', 0, 'C', false);
    $this->Cell(14, 4, utf8_decode('FUR'), 'LTR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode('Gest'), 'LTR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode('1er'), 'LTR', 0, 'C', false);
    $this->Cell(9, 4, utf8_decode('MAC'), 'LTR', 0, 'C', false);
    $this->Cell(40, 4, utf8_decode('RESULTADO INFORME'), 1, 1, 'C', false);

    $this->Cell(12, 4, utf8_decode('Lámina'), 'LBR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('Documento'), 'LBR', 0, 'C', false);
    $this->Cell(14, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(72, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(72, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(14, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode('PAP'), 'LBR', 0, 'C', false);
    $this->Cell(9, 4, utf8_decode('(1)'), 'LBR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('N° Lamina'), 'LBR', 0, 'C', false);
    $this->Cell(24, 4, utf8_decode('Resultado (2)'), 'LBR', 1, 'C', false);

    //$this->Cell(0, 4, utf8_decode('Resultado'), 1, 1, 'C', false);
  }

  //Pie de página
  function Footer()
  {
    //Posición: a 1,5 cm del final (Siempre va en el footer)
    $this->SetY(-35);

    $this->SetFont('Arial','',7);
/*
    $this->Cell(0,4,utf8_decode("Laboratorio de Citología:"),0,1,'L');
*/

    //$this->Cell(208,4,utf8_decode("Tópico Patólogo"),0,0,'L');
    $this->Cell(208,4,utf8_decode(""),0,0,'L');
    $this->Cell(73,4,utf8_decode("Nota:"),0,1,'L');
/*
    $this->Cell(210,4,utf8_decode(""),0,0,'L');
    $this->Cell(71,4,utf8_decode("(1) Lesión de cuello uterino"),0,1,'L');
*/
    $this->Cell(210,4,utf8_decode(""),0,0,'L');
    $this->Cell(71,4,utf8_decode("1: DIU(1) ORAL(2) INYEC(3) IMPLANTE(4) NINGUNO(5)"),0,1,'L');

    $this->Cell(210,4,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'L');
    $this->Cell(71,4,utf8_decode("2: RESULTADO: INSATISFACTORIA: Se requiere toma"),0,1,'L');
        $this->Cell(210,4,utf8_decode(""),0,0,'L');
    $this->Cell(71,4,utf8_decode("RECHAZADA: Se requiere toma"),0,1,'L');
    $this->Cell(210,4,utf8_decode(""),0,0,'L');
    $this->Cell(71,4,utf8_decode("PARA MODIFICAR: Subsanar observación"),0,1,'L');
  }
}

$pdf=new PDF('L','mm','A4');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,20); //Siempre cuando se va a poner el pie de página
$pdf->SetMargins(8,8,8);
$pdf->AliasNbPages();
$pdf->AddPage();

$rsC = $pap->get_repDatosDetEnviado($_GET['idEnv']);
/*print_r($rsC);
exit();*/
foreach ($rsC as $row) {
  $pdf->SetFont('Arial','',7);
  $pdf->Cell(12, 4, $row['nro_ordensoli']."-".$row['anio_ordensoli'], 'LBR', 0, 'C', false);
  $pdf->Cell(16, 4, utf8_decode($row['nro_docpac']), 'LBR', 0, 'C', false);
  $pdf->Cell(14, 4, utf8_decode($row['nro_hc']), 'LBR', 0, 'C', false);
  $pdf->Cell(8, 4, utf8_decode($row['nom_sispac']), 'LBR', 0, 'C', false);
  $pdf->Cell(72, 4, utf8_decode($row['nombre_rspac']), 'LBR', 0, 'L', false);
  $pdf->Cell(72, 4, utf8_decode($row['distrito'] . " - " . $row['descrip_dir']), 'LBR', 0, 'L', false);
  $pdf->Cell(8, 4, utf8_decode($row['edad_pac']), 'LBR', 0, 'C', false);
  $pdf->Cell(14, 4, utf8_decode($row['fec_fur']), 'LBR', 0, 'C', false);
  $pdf->Cell(8, 4, utf8_decode($row['nom_tipgestante']), 'LBR', 0, 'C', false);
  $pdf->Cell(8, 4, utf8_decode($row['primer_pap']), 'LBR', 0, 'C', false);
  $pdf->Cell(9, 4, utf8_decode($row['id_mac']), 'LBR', 0, 'C', false);
  $pdf->SetFont('Arial','B',7);
  if($row['nro_reglab'] <> ''){
    $pdf->Cell(16, 4, utf8_decode($row['nro_reglab']."-".$row['anio_reglab']), 'LBR', 0, 'C', false);
    $pdf->Cell(24, 4, utf8_decode($row['nom_resul']), 'LBR', 1, 'L', false);
  } else {
    $pdf->Cell(16, 4, utf8_decode('-'), 'LBR', 0, 'C', false);
    $pdf->Cell(24, 4, utf8_decode($row['nomestado_envdet']), 'LBR', 1, 'L', false);
  }
}

$pdf->Output();
?>
