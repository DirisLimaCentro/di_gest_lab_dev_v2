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

require_once '../../model/Atencion.php';
$at = new Atencion();

$idAtencion = $_GET['valid'];
$idDependencia = $_GET['p'];

$rsA = $at->get_datosAtencion_md5($idAtencion, $idDependencia);
$_GET['id_atencion'] = $rsA[0]['id'];
$idAtencion = $rsA[0]['id'];

class PDF extends FPDF
{
  //Cabecera de página
  function Header(){
	$this->SetTextColor(0, 0, 0);
    //Logo
    $this->Image('../../assets/images/logo_diris.png',10,4,50);
    $this->SetFont('Arial','',6);

    require_once '../../model/Atencion.php';
    $at = new Atencion();
    $idAtencion = $_GET['id_atencion'];
    $rsA = $at->get_datosAtencion($idAtencion);
	
    //Aubtitles
    $this->SetFont('Arial','B',7);
    $this->Cell(0,4,utf8_decode($rsA[0]['nom_depen'])."          ",0,1,'R');
    $this->SetFont('Arial','B',10);
    $this->Cell(0,3,utf8_decode('HC: '.$rsA[0]['nro_hcpac'])."          ",0,1,'R');

    $this->SetFont('Arial','B',10);
    $this->Cell(40,2,'',0,1,'');
    $this->Cell(0,5,'SERVICIO DE LABORATORIO',0,1,'C');

    $this->SetFont('Arial','B',7);
    $this->Cell(40,2,'',0,1,'');

    $this->Cell(22,4,'Paciente',0,0,'');
    $this->SetFont('Arial','',8);
    $this->Cell(96,4, utf8_decode(': ' . $rsA[0]['nombre_rspac']),0,0,'');

    $this->SetFont('Arial','B',7);
    $this->Cell(8,4,'Sexo',0,0,'');
    $this->SetFont('Arial','',7);
    $this->Cell(5,4, utf8_decode(': ' . $rsA[0]['nom_sexopac']),0,1,'');

    if($rsA[0]['abrev_tipodocpac'] == "DNI"){
      $naci = "PER";
    } else {
      $naci = "EXT";
    }

    $this->SetFont('Arial','B',7);
    $this->Cell(22,4,utf8_decode('Doc. Identificación'),0,0,'');
    $this->SetFont('Arial','',7);
    $this->Cell(25,4, ': ' . $rsA[0]['abrev_tipodocpac'] .'-'. $rsA[0]['nro_docpac'] ,0,0,'');

    $this->SetFont('Arial','B',7);
    $this->Cell(8,4,'Edad',0,0,'');
    $this->SetFont('Arial','',7);
    $this->Cell(24,4,utf8_decode(': ' . $rsA[0]['edad_anio'] . ' AÑOS'),0,0,'');

    $this->SetFont('Arial','B',7);
    $this->Cell(23,4,utf8_decode('Fecha cita'),0,0,'');
    $this->SetFont('Arial','',7);
    $this->Cell(30,4,': '. $rsA[0]['fec_cita'],0,1,'');

    $this->SetFont('Arial','B',7);
    $this->Cell(22,4,utf8_decode('Nro. Atención'),0,0,'');
    $this->SetFont('Arial','',7);
	if($rsA[0]['id_tipo_genera_correlativo'] == "1"){
		$nroAtencion = $rsA[0]['nro_atencion'] . "-". $rsA[0]['anio_atencion'];
	} else {
		$nroAtencion = substr($rsA[0]['nro_atencion'], 0, 6).substr($rsA[0]['nro_atencion'],6);
	}
    $this->Cell(25,4, utf8_decode(': ' . $nroAtencion),0,0,'');


    $this->SetFont('Arial','B',7);
    $this->Cell(11,4,utf8_decode('Atención'),0,0,'');
    $this->SetFont('Arial','',7);
	if($rsA[0]['nombre_medico'] == ""){
		$this->Cell(21,4,utf8_decode(': ' . $rsA[0]['abrev_plan']),0,0,'');
	} else {
		$this->Cell(20,4,utf8_decode(': ' . $rsA[0]['abrev_plan']),0,0,'');
	}
	
	if($rsA[0]['nombre_medico'] == ""){
		$this->Cell(53,4,'',0,1,'');
	} else {
		$this->SetFont('Arial','B',7);
		$this->Cell(15,4,utf8_decode('Prfsnal. Soli.'),0,0,'');
		$this->SetFont('Arial','',7);
		$this->Cell(30,4,utf8_decode(': ' . $rsA[0]['nombre_medico']),0,1,'');		
	}
	//------------------------------------------------------------------------
	$this->Ln(1);
	$this->SetFont('Arial','B',8);
	$this->SetFillColor(222,219,219);
    $this->Cell(0,5,utf8_decode('ANALISIS CLINICO SOLICITADO'),'T',1,'',true);
	
  }

  //Pie de página
  function Footer(){
    $this->SetY(-10);
    $labNomUser = $_SESSION['labNomUser'];
    require_once '../../model/Atencion.php';
    $at = new Atencion();
	$rsHI = $at->get_datosfecHoraActual();
	$this->SetFont('Arial','',6);
	$this->Cell(20,3,utf8_decode('Fecha de impresión:'),'',0,'L');
	$this->SetFont('Arial','B',6);
	$this->Cell(85,3,$rsHI[0]['fechora_actual'] . " (".$labNomUser.")",0,0,'');
	
	$this->SetFont('Arial','',6);
	$this->Cell(30,3,utf8_decode('Página: '.$this->PageNo().'   de   {nb}'),0,1,'R');
  }
}

$pdf=new PDF('P','mm','A5');
$pdf->SetAutoPageBreak(true,35);
$pdf->SetMargins(5,4,5);
$pdf->AliasNbPages();
$pdf->AddPage();

$rsP = $at->get_datosProductoPorIdAtencion($idAtencion);
foreach ($rsP as $rowP) {
	$pdf->SetFont('Arial','',8);
	$pdf->SetDrawColor(203,198,198);
	$pdf->Cell(0,5,utf8_decode($rowP['nom_producto']),'B',1,'L');
}

$pdf->Output();
?>
