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

include '../../assets/lib/fpdf/rotation.php';

require_once '../../model/Lab.php';
$la = new Lab();

class PDF extends PDF_Rotate{
	function RotatedText($x,$y,$txt,$angle){
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}

	function RotatedImage($file,$x,$y,$w,$h,$angle){
		//Image rotated around its upper-left corner
		$this->Rotate($angle,$x,$y);
		$this->Image($file,$x,$y,$w,$h);
		$this->Rotate(0);
	}
	
  //Cabecera de página
  function Header(){
    require_once '../../model/Dependencia.php';
    $d = new Dependencia();
	require_once '../../model/Tipo.php';
	$t = new Tipo();

    //Logo
    $this->Image('../../assets/images/logo_diris.png',8,8,48);
	$rsD = $d->get_datosDepenendenciaPorId($_SESSION['labIdDepUser']);
    $this->SetFont('Arial','B',12);
    $this->Cell(0,8,utf8_decode("REPORTE ATENCIONES DE BACILOSCOPIAS MES " . $t->nombrar_mes($_GET['mes']) . " DEL " . $_GET['anio']),0,1,'C');

    $this->Ln(2);
    $this->SetFont('Arial','B',8);
    $this->Cell(180,5,utf8_decode("EESS: " . $rsD[0]["nom_depen"]),0,0,'L');
	$rsHI = $t->get_datosfecHoraActual();
	$this->SetFont('Arial','',8);
	$this->Cell(100,5,"Fecha y hora reporte: " . $rsHI[0]['fechora_actual'],0,1,'R');

    $this->SetFont('Arial','B',7);
    $this->Cell(10, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(14, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(11, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', false);
	$this->Cell(74, 4, utf8_decode('Apellidos y nombres'), 'LTR', 0, 'C', false);
    $this->Cell(17, 4, utf8_decode('H.C.'), 'LTR', 0, 'C', false);
	$this->Cell(24, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
	$this->RotatedText(162,30,'Edad',90);
    $this->Cell(6, 4, utf8_decode(''), 'LTR', 0, 'C', false);
	$this->RotatedText(167,30,'Sexo',90);
	$this->Cell(4, 4, utf8_decode(''), 'LTR', 0, 'C', false);
	$this->Cell(24, 4, utf8_decode('Tipo'), 'LTR', 0, 'C', false);
	$this->Cell(10, 4, utf8_decode('Calidad'), 'LTR', 0, 'C', false);
    $this->Cell(87, 4, utf8_decode('BACILOSCOPIA'), 1, 1, 'C', false);


    $this->Cell(10, 4, utf8_decode('Registro'), 'LBR', 0, 'C', false);
    $this->Cell(14, 4, utf8_decode('Atención'), 'LBR', 0, 'C', false);
    $this->Cell(11, 4, utf8_decode(''), 'LBR', 0, 'C', false);
	$this->Cell(74, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(17, 4, utf8_decode(''), 'LBR', 0, 'C', false);
	$this->Cell(24, 4, utf8_decode('Documento'), 'LBR', 0, 'C', false);
    $this->Cell(6, 4, utf8_decode(''), 'LBR', 0, 'C', false);
	$this->Cell(4, 4, utf8_decode(''), 'LBR', 0, 'C', false);
	$this->Cell(24, 4, utf8_decode('Muestra'), 'LBR', 0, 'C', false);
	$this->Cell(10, 4, utf8_decode('Muestra'), 'LBR', 0, 'C', false);
    $this->Cell(44, 4, utf8_decode('Diagnóstico'), 'LBR', 0, 'C', false);
	$this->Cell(5, 4, utf8_decode('Mes'), 'LBR', 0, 'C', false);
	$this->Cell(10, 4, utf8_decode('Muestra'), 'LBR', 0, 'C', false);
	$this->Cell(28, 4, utf8_decode('Resultado'), 'LBR', 1, 'C', false);

    //$this->Cell(0, 4, utf8_decode('Resultado'), 1, 1, 'C', false);
  }

  //Pie de página
  function Footer(){
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

$rsC = $la->get_detalleBKValidPorAnioMesAndIddependencia($labIdDepUser, $_GET['anio'], $_GET['mes']);
/*print_r($rsC);
exit();*/
$item = 0;
foreach ($rsC as $row) {
  $nom_tip_muestra = '';
  $nom_cali_muestra = '';
  $nom_diagostico = '';
  $nom_nro_muestra = '';
  $nom_resultado = '';
  
  if($row['id_tipo_genera_correlativo'] == "1"){
	$nroAtencion = $row['nro_atencion']."-".$row['anio_atencion'];
  } else {
	$nroAtencion = substr($row['nro_atencion'], 0, 6).substr($row['nro_atencion'],6);
  }
  
  $item ++;
  $pdf->SetFont('Arial','',7);
  $pdf->Cell(10, 4, $row['nro_reg_bk'], 'LBR', 0, 'C', false);
  $pdf->Cell(14, 4, $nroAtencion, 'BR', 0, 'C', false);
  $pdf->Cell(11, 4, $row['fec_atencion'], 'LBR', 0, 'C', false);
  $pdf->Cell(74, 4, utf8_decode($row['nombre_rspac']), 'LBR', 0, 'L', false);
  $pdf->Cell(17, 4, $row['nro_hcpac'], 'LBR', 0, 'C', false);
  $pdf->Cell(24, 4, $row['abrev_tipodocpac']. ": ".$row['nro_docpac'], 'LBR', 0, 'L', false);
  $pdf->Cell(6, 4, $row['edad_anio'], 'LBR', 0, 'C', false);
  $abrev_sexo="M";
  if($row['id_sexo']=="2"){
	$abrev_sexo="F";
  }
  $pdf->Cell(4, 4, $abrev_sexo, 'LBR', 0, 'C', false);
  if($row['id_tip_muestra'] <> "") { $rs = $la->get_datosSeleccionresuldetPorId($row['id_tip_muestra']); if(isset($rs)){ $nom_tip_muestra = $rs[0]['nombre'];}}
  if($row['id_cali_muestra'] <> "") { $rs = $la->get_datosSeleccionresuldetPorId($row['id_cali_muestra']); if(isset($rs)){ $nom_cali_muestra = $rs[0]['abreviatura'];}}
  if($row['id_diagostico'] <> "") { $rs = $la->get_datosSeleccionresuldetPorId($row['id_diagostico']); if(isset($rs)){ $nom_diagostico = $rs[0]['nombre'];}}
  if($row['id_nro_muestra'] <> "") { $rs = $la->get_datosSeleccionresuldetPorId($row['id_nro_muestra']); if(isset($rs)){ $nom_nro_muestra = $rs[0]['abreviatura'];}}
  if($row['id_resultado'] <> "") { $rs = $la->get_datosSeleccionresuldetPorId($row['id_resultado']); if(isset($rs)){ $nom_resultado = $rs[0]['nombre'];}}
  
  $pdf->Cell(24, 4, $nom_tip_muestra, 'LBR', 0, 'L', false);
  $pdf->Cell(10, 4, $nom_cali_muestra, 'LBR', 0, 'C', false);
  $pdf->Cell(44, 4, $nom_diagostico, 'LBR', 0, 'L', false);
  $pdf->Cell(5, 4, $row['mes_control'], 'LBR', 0, 'C', false);
  $pdf->Cell(10, 4, utf8_decode($nom_nro_muestra), 'LBR', 0, 'C', false);
  $pdf->Cell(28, 4, $nom_resultado, 'LBR', 1, 'C', false);
}

$pdf->Output();
?>
