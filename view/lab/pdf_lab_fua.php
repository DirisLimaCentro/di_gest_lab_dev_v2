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

require_once '../../model/Lab.php';
$la = new Lab();

class PDF extends FPDF{
  //Cabecera de página
  function Header(){  }

  //Pie de página
  function Footer() {  }
}

$pdf=new PDF('P','mm','A4');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,20); //Siempre cuando se va a poner el pie de página
$pdf->SetMargins(8,8,9);
$pdf->AliasNbPages();
$pdf->AddPage();

$rs = $la->get_datosDetalleReferenciaAndFUA($_GET['id_atencion']);
/*print_r($rs);
exit();*/
$pdf->SetFont('Arial','B',12);
$pdf->Ln(22);
$pdf->Cell(0,9,'',0,1,'L');
$pdf->Cell(40,8,$rs[0]['codref_depen'],0,0,'C');
$pdf->Cell(154,8,utf8_decode($rs[0]['nom_depen']),0,1,'C');

$pdf->Cell(0,4,'',0,1,'L');

$pdf->SetFont('Arial','',10);
$pdf->Cell(20,4,'',0,0,'L');
$pdf->Cell(4,4,'X',0,0,'C');//De la iprres
$pdf->Cell(47,4,'',0,0,'L');
$pdf->Cell(4,4,'X',0,0,'C');//Intramural
$pdf->Cell(20,4,'',0,0,'L');
$ate_ambulatoria="";
$ate_referencia="";
$cita="";
$contrareferido="";
$codref_depenori = "";
$depenori = "";
$nro_refdepenori = "";
$nro_contraref = "";
if($rs[0]['id_formato_generado'] == "2"){//Si solo es FUA (Ambulatoria)
	$ate_ambulatoria = "X";
	$cita = "X";
} else {
	$ate_referencia="X";
	$contrareferido = "X";
	
	$codref_depenori = $rs[0]['codref_depenori'];
	$depenori = $rs[0]['nom_depenori'];
	$nro_refdepenori = $rs[0]['nro_refdepenori'];
	$nro_contraref = $rs[0]['nro_contraref'];
}
$pdf->Cell(4,4,$ate_ambulatoria,0,0,'C');
$pdf->Cell(94,4,'',0,1,'C');
$pdf->Cell(96,4,'',0,0,'L');
$pdf->Cell(4,4,$ate_referencia,0,0,'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(16,8,$codref_depenori,0,0,'C');
$pdf->Cell(64,8,$depenori,0,0,'C');
$pdf->Cell(14,8,$nro_refdepenori,0,1,'C');

$pdf->Ln(8);
$pdf->SetFont('Arial','',10);
$pdf->Cell(11,7,$rs[0]['fua_id_tipodoc'],0,0,'C');
$pdf->Cell(46,7,$rs[0]['nro_docpac'],0,0,'C');
$pdf->Cell(2,7,'',0,0,'C');
$pdf->Cell(13,7,$rs[0]['cod_diresa_fua'],0,0,'C');
$pdf->Cell(8,7,$rs[0]['id_tiposis'],0,0,'C');
$pdf->Cell(23,7,$rs[0]['nro_sis'],0,1,'C');

$pdf->Ln(2);
$pdf->SetFont('Arial','',11);
$pdf->Cell(96,6,$rs[0]['primer_apepac'],0,0,'C');
$pdf->Cell(2,6,'',0,0,'C');
$pdf->Cell(96,6,$rs[0]['segundo_apepac'],0,1,'C');
$pdf->Ln(2);
$pdf->SetFont('Arial','',11);
$pdf->Cell(96,6,$rs[0]['primer_nombrepac_fua'],0,0,'C');
$pdf->Cell(2,6,'',0,0,'C');
$pdf->Cell(96,6,$rs[0]['otro_nombre_fua'],0,1,'C');

/******************************************************************************/
$pdf->Ln(3);
$pdf->SetFont('Arial','',10);
$idsexoF="";
$idsexoM="";
if($rs[0]['id_sexopac'] == "2"){//Si el sexo es FEMENINO
	$idsexoF = "X";
} else {
	$idsexoM = "X";
}
$pdf->Cell(18,5,'',0,0,'L');
$pdf->Cell(5,5,$idsexoM,0,0,'L');
$fecNacA1 = "";
$fecNacA2 = "";
$fecNacA3 = "";
$fecNacA4 = "";
$fecNacM1 = "";
$fecNacM2 = "";
$fecNacD1 = "";
$fecNacD2 = "";
if($rs[0]['fec_nacpac'] <> ""){
  $fecNac = str_replace("/","",$rs[0]['fec_nacpac']);
  $arrFec = str_split($fecNac);
  $fecNacD1 = $arrFec[0];
  $fecNacD2 = $arrFec[1];
  $fecNacM1 = $arrFec[2];
  $fecNacM2 = $arrFec[3];
  $fecNacA1 = $arrFec[4];
  $fecNacA2 = $arrFec[5];
  $fecNacA3 = $arrFec[6];
  $fecNacA4 = $arrFec[7];
}
$pdf->Cell(25,7,'',0,0,'C');
$pdf->Cell(8,7,$fecNacD1,0,0,'C');
$pdf->Cell(9,7,$fecNacD2,0,0,'C');
$pdf->Cell(8,7,$fecNacM1,0,0,'C');
$pdf->Cell(8,7,$fecNacM2,0,0,'C');
$pdf->Cell(8,7,$fecNacA1,0,0,'C');
$pdf->Cell(9,7,$fecNacA2,0,0,'C');
$pdf->Cell(10,7,$fecNacA3,0,0,'C');
$pdf->Cell(11,7,$fecNacA4,0,0,'C');
$pdf->Cell(1,7,'',0,0,'C');
$pdf->Cell(35,7,$rs[0]['nro_hcpac'],0,0,'C');
$pdf->Cell(3,7,'',0,0,'C');
$pdf->Cell(36,7,'MESTIZO',0,1,'C');

/*************************************************************************************/

$fecProbPartoA1 = "";
$fecProbPartoA2 = "";
$fecProbPartoA3 = "";
$fecProbPartoA4 = "";
$fecProbPartoM1 = "";
$fecProbPartoM2 = "";
$fecProbPartoD1 = "";
$fecProbPartoD2 = "";
if($rs[0]['fecha_prob_parte'] <> ""){
  $fecProb = str_replace("/","",$rs[0]['fecha_prob_parte']);
  $arrFecProb = str_split($fecProb);
  $fecProbPartoD1 = $arrFecProb[0];
  $fecProbPartoD2 = $arrFecProb[1];
  $fecProbPartoM1 = $arrFecProb[2];
  $fecProbPartoM2 = $arrFecProb[3];
  $fecProbPartoA1 = $arrFecProb[4];
  $fecProbPartoA2 = $arrFecProb[5];
  $fecProbPartoA3 = $arrFecProb[6];
  $fecProbPartoA4 = $arrFecProb[7];
}
$pdf->Cell(48,5,'',0,0,'L');
$pdf->Cell(8,7,$fecProbPartoD1,0,0,'C');
$pdf->Cell(9,7,$fecProbPartoD2,0,0,'C');
$pdf->Cell(8,7,$fecProbPartoM1,0,0,'C');
$pdf->Cell(8,7,$fecProbPartoM2,0,0,'C');
$pdf->Cell(8,7,$fecProbPartoA1,0,0,'C');
$pdf->Cell(9,7,$fecProbPartoA2,0,0,'C');
$pdf->Cell(10,7,$fecProbPartoA3,0,0,'C');
$pdf->Cell(11,7,$fecProbPartoA4,0,1,'C');

$pdf->SetY($pdf->GetY() - 11);
$pdf->Cell(18,5,'',0,0,'L');
$pdf->Cell(5,5,$idsexoF,0,1,'L');
$pdf->SetY($pdf->GetY() + 6);
/***************************************************************************************/

$pdf->Ln(16);
$pdf->SetFont('Arial','',10);
$fecAtencionA1 = "";
$fecAtencionA2 = "";
$fecAtencionA3 = "";
$fecAtencionA4 = "";
$fecAtencionM1 = "";
$fecAtencionM2 = "";
$fecAtencionD1 = "";
$fecAtencionD2 = "";
if($rs[0]['fechora_atencion'] <> ""){
  $fecAten = str_replace("/","",$rs[0]['fechora_atencion']);
  $arrFecAten = str_split($fecAten);
  $fecAtencionD1 = $arrFecAten[0];
  $fecAtencionD2 = $arrFecAten[1];
  $fecAtencionM1 = $arrFecAten[2];
  $fecAtencionM2 = $arrFecAten[3];
  $fecAtencionA1 = $arrFecAten[4];
  $fecAtencionA2 = $arrFecAten[5];
  $fecAtencionA3 = $arrFecAten[6];
  $fecAtencionA4 = $arrFecAten[7];
}
$pdf->Cell(6,7,$fecAtencionD1,0,0,'L');
$pdf->Cell(6,7,$fecAtencionD2,0,0,'L');
$pdf->Cell(5,7,$fecAtencionM1,0,0,'C');
$pdf->Cell(6,7,$fecAtencionM2,0,0,'C');
$pdf->Cell(5,7,$fecAtencionA1,0,0,'C');
$pdf->Cell(8,7,$fecAtencionA2,0,0,'C');
$pdf->Cell(6,7,$fecAtencionA3,0,0,'C');
$pdf->Cell(6,7,$fecAtencionA4,0,0,'C');
$pdf->Cell(2,7,'',0,0,'C');
$pdf->Cell(9,7,'08',0,0,'C');
$pdf->Cell(3,7,':',0,0,'C');
$pdf->Cell(7,7,'00',0,0,'C');
$pdf->Cell(15,7,'',0,0,'C');
$pdf->Cell(11,7,$rs[0]['cod_referencial'],0,1,'C');

/*****************************************************************************************/

$pdf->Ln(9);
$pdf->SetFont('Arial','',12);//Atención directa
$pdf->Cell(18,10,'',0,0,'L');
$pdf->Cell(5,10,'X',0,1,'L');

/*****************************************************************************************/

$pdf->Ln(6);
$pdf->SetFont('Arial','',10);
$pdf->Cell(22,6,'',0,0,'L');
$pdf->Cell(6,6,$cita,0,0,'C');
$pdf->Cell(117,6,'',0,0,'L');
$pdf->Cell(6,6,$contrareferido,0,1,'C');

/*****************************************************************************************/

$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(37,6,$codref_depenori,0,0,'C');
$pdf->Cell(19,6,$depenori,0,0,'L');
$pdf->Cell(48,6,$nro_contraref,0,1,'C');

/*****************************************************************************************/

$pdf->Ln(17);
$pdf->SetFont('Arial','',10);
$pdf->Cell(13,6,'',0,0,'C');
$pdf->Cell(6,6,$rs[0]['edad_gestacional'],0,1,'L');

/*****************************************************************************************/

$pdf->Ln(28);
$pdf->SetFont('Arial','',7);
$pdf->Cell(7,4,'',0,0,'C');
$pdf->Cell(100,4,$rs[0]['nom_cie_fua'],0,0,'L');
$pdf->Cell(30,4,'',0,0,'L');
$pdf->Cell(35,4,$rs[0]['id_cie_fua'],0,1,'L');


$pdf->Ln(19);
$pdf->SetFont('Arial','',7);
$pdf->Cell(35,4,$rs[0]['nro_docresponsable_aten'],0,0,'C');
$pdf->Cell(122,4,$rs[0]['nombre_docresponsable_aten'],0,0,'C');
$pdf->Cell(37,4,$rs[0]['nro_coleresponsable_aten'],0,1,'C');
//$pdf->Cell(0,4,'',0,1,'L'); 

$pdf->Output();
?>
