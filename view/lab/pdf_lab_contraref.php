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
$pdf->SetMargins(8,15,9);
$pdf->AliasNbPages();
$pdf->AddPage();

$rs = $la->get_datosDetalleReferenciaAndFUA($_GET['id_atencion']);
/*print_r($rs);
exit();*/

/*****************************/
$pdf->SetFont('Arial','B',13);
$pdf->Cell(150,9,'',0,0,'L');
$pdf->Cell(43,9,$rs[0]['nro_contraref'],0,1,'C');

/*****************************/
$pdf->Ln(13);
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
$pdf->SetFont('Arial','',9);
$pdf->Cell(10,7,'',0,0,'L');
$pdf->Cell(10,7,$fecAtencionD1.$fecAtencionD2,0,0,'L');
$pdf->Cell(10,7,$fecAtencionM1.$fecAtencionM2,0,0,'L');
$pdf->Cell(10,7,$fecAtencionA3.$fecAtencionA4,0,0,'L');
$pdf->Cell(20,7,'',0,0,'L');
$pdf->Cell(7,7,'08',0,0,'L');
$pdf->Cell(7,7,'00',0,0,'L');
$pdf->Cell(109,7,'',0,0,'L');
$pdf->Cell(10,7,'X',0,1,'C');

/*****************************/
$pdf->Ln(5);
$pdf->SetFont('Arial','',12);
$pdf->Cell(90,7,'',0,0,'L');
$pdf->Cell(150,8,utf8_decode($rs[0]['nom_depen']),0,1,'L');
$pdf->Ln(2);
$pdf->Cell(90,7,'',0,0,'L');
$pdf->Cell(150,8,$rs[0]['nom_depenori'],0,1,'L');

/*****************************/
$pdf->SetFont('Arial','',10);
$pdf->Cell(10,7,'',0,0,'L');
$pdf->Cell(10,7,'x',0,0,'L');
$pdf->Cell(40,7,'',0,0,'L');
$pdf->Cell(30,7,$rs[0]['nro_docpac'],0,0,'L');

$pdf->Cell(5,7,$rs[0]['id_tiposis'],0,0,'C');
$pdf->Cell(23,7,' - ' . $rs[0]['nro_sis'],0,0,'C');
$pdf->Cell(40,7,'',0,0,'L');
$pdf->Cell(35,7,$rs[0]['nro_hcpac'],0,1,'L');

/*****************************/
$pdf->Ln(3);
$pdf->SetFont('Arial','',11);
$pdf->Cell(45,6,$rs[0]['primer_apepac'],0,0,'L');
$pdf->Cell(45,6,$rs[0]['segundo_apepac'],0,0,'L');
$pdf->Cell(52,6,$rs[0]['primer_nombrepac_fua'],0,0,'L');
$pdf->Cell(51,6,$rs[0]['otro_nombre_fua'],0,1,'L');

/*****************************/
$pdf->Ln(2);
$pdf->SetFont('Arial','',10);
$idsexoF="";
$idsexoM="";
if($rs[0]['id_sexopac'] == "2"){//Si el sexo es FEMENINO
	$idsexoF = "X";
} else {
	$idsexoM = "X";
}
$pdf->Cell(10,5,'',0,0,'L');
$pdf->Cell(5,5,$idsexoF,0,0,'L');
$pdf->Cell(5,5,'',0,0,'L');
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
$pdf->Cell(3,7,$fecNacD1,0,0,'C');
$pdf->Cell(3,7,$fecNacD2,0,0,'C');
$pdf->Cell(3,7,$fecNacM1,0,0,'C');
$pdf->Cell(3,7,$fecNacM2,0,0,'C');
$pdf->Cell(3,7,$fecNacA3,0,0,'C');
$pdf->Cell(3,7,$fecNacA4,0,0,'C');
$pdf->Cell(25,7,'',0,1,'C');


/*****************************/
$pdf->Ln(2);
$pdf->Cell(25,7,'',0,0,'C');
$pdf->Cell(90,7,'-',0,0,'C');
$pdf->Cell(25,7,'',0,0,'C');
$pdf->Cell(25,7,'LIMA',0,0,'C');
$pdf->Cell(25,7,'LIMA',0,0,'C');

/*****************************/
$pdf->Ln(12);
$pdf->Cell(25,7,'',0,0,'C');
$pdf->Cell(90,7,'EXAMEN DE LABORATORIO',0,0,'L');
$pdf->Cell(40,7,'',0,0,'C');
$pdf->Cell(4,7,'Z',0,0,'C');
$pdf->Cell(4,7,'0',0,0,'C');
$pdf->Cell(4,7,'1',0,0,'C');
$pdf->Cell(4,7,'7',0,1,'C');

/*****************************/
$pdf->Ln(12);
$pdf->SetFont('Arial','',13);
$pdf->Cell(25,7,'',0,0,'C');
$pdf->Cell(90,7,'SE ENVIA INFORMES Y/O RESULTADOS',0,1,'L');

/*****************************/
$pdf->Ln(12);
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,7,'',0,0,'C');
$pdf->Cell(5,7,'X',0,1,'C');
$pdf->Ln(3);
$pdf->Cell(60,7,'',0,0,'C');
$pdf->Cell(5,7,'X',0,1,'C');
$pdf->Ln(3);
$pdf->Cell(115,7,'',0,0,'C');
$pdf->Cell(5,7,'X',0,1,'C');
$pdf->Ln(3);
$pdf->Cell(135,7,'',0,0,'C');
$pdf->Cell(5,7,'X',0,1,'C');

/*****************************/
$pdf->Ln(13);
$pdf->SetFont('Arial','',13);
$pdf->Cell(0,7,'VOLVER AL ESTABLECIMIENTO DE SALUD QUE LE CORRESPONDA PARA',0,1,'C');
$pdf->Cell(0,7,'LECTURA DE RESULTADOS',0,1,'C');

/*****************************/
$pdf->Ln(15);
$pdf->SetFont('Arial','',9);
$pdf->Cell(115,7,'',0,0,'C');
$pdf->Cell(78,7,$rs[0]['nombre_docresponsable_aten'],0,1,'L');
$pdf->Cell(115,7,'',0,0,'C');
$pdf->Cell(37,7,$rs[0]['nro_coleresponsable_aten'],0,1,'L');

/*****************************/
$pdf->Ln(3);
$pdf->SetFont('Arial','',10);
$pdf->Cell(30,7,'',0,0,'C');
$pdf->Cell(5,7,'X',0,1,'L');


$pdf->Output();
?>
