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

class PDF extends FPDF{

  function Header()
  {
	
	if($_GET['idDep'] <> "0"){
		$labIdDepUser = $_GET['idDep'];
	} else {
		$labIdDepUser = $_SESSION['labIdDepUser'];
	}
	
    require_once '../../model/Dependencia.php';
    $d = new Dependencia();
    //Logo
    $this->Image('../../assets/images/logo_diris.png',13,4,100);

    $this->setY(20);
    $this->SetFont('Arial','B',11);
    $this->Cell(0,7,utf8_decode("CARGO DE SOLICITUD DE CITOLOGÍA DE PAP"),0,1,'C');

    $this->Ln(2);
    $this->SetFont('Arial','B',9);
    $this->Cell(40,5,utf8_decode("Establecimiento de salud:"),0,0,'L');
    $rsD = $d->get_datosDepenendenciaPorId($labIdDepUser);
    $this->SetFont('Arial','',10);
    $this->Cell(205,5,utf8_decode($rsD[0]["nom_depen"]),0,1,'L');
  }

}

$pdf=new PDF('P','mm','A4');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,4);
$pdf->SetMargins(13,8,8);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Ln(5);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode('ENVÍO'),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode('DESTINO'),1,0,'C', false);
$pdf->Cell(32, 7, utf8_decode('FEC. ENVÍO'),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode('ENVÍO'),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode('DESTINO'),1,0,'C', false);
$pdf->Cell(30, 7, utf8_decode('FEC. ENVÍO'),1,1,'C', false);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(12, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,1,'C', false);


$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 4, utf8_decode('N° DE'),'TLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode('CÓDIGOS DE LÁMINAS'),'T',0,'C', false);
$pdf->Cell(32, 4, utf8_decode('CANTIDAD DE'),'TLR',0,'C', false);

$pdf->Cell(5, 4, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 4, utf8_decode('N° DE'),'TLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode('CÓDIGOS DE LÁMINAS'),'T',0,'C', false);
$pdf->Cell(30, 4, utf8_decode('CANTIDAD DE'),'TLR',1,'C', false);


$pdf->Cell(16, 4, utf8_decode('PLANILLA'),'BLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),'B',0,'C', false);
$pdf->Cell(32, 4, utf8_decode('PAP'),'BLR',0,'C', false);

$pdf->Cell(5, 4, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 4, utf8_decode('PLANILLA'),'BLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),'B',0,'C', false);
$pdf->Cell(30, 4, utf8_decode('PAP'),'BLR',1,'C', false);
/////
$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(32, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(30, 7, utf8_decode(''),1,1,'C', false);

/////////
$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(32, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(30, 7, utf8_decode(''),1,1,'C', false);

/////////
$pdf->Cell(61, 7, utf8_decode('TOTAL'),0,0,'R', false);
$pdf->Cell(32, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(61, 7, utf8_decode('TOTAL'),0,0,'R', false);
$pdf->Cell(30, 7, utf8_decode(''),1,1,'C', false);

$pdf->Ln(3);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 4, utf8_decode('Recibido por:'),0,0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),0,0,'C', false);
$pdf->Cell(32, 4, utf8_decode('Fec. Recepción'),0,0,'C', false);

$pdf->Cell(5, 4, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 4, utf8_decode('Recibido por:'),0,0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),0,0,'C', false);
$pdf->Cell(30, 4, utf8_decode('Fec. Recepción'),0,1,'C', false);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(12, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,1,'C', false);


/***************************************************************/
$pdf->Ln(15);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode('ENVÍO'),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode('DESTINO'),1,0,'C', false);
$pdf->Cell(32, 7, utf8_decode('FEC. ENVÍO'),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode('ENVÍO'),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode('DESTINO'),1,0,'C', false);
$pdf->Cell(30, 7, utf8_decode('FEC. ENVÍO'),1,1,'C', false);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(12, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,1,'C', false);


$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 4, utf8_decode('N° DE'),'TLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode('CÓDIGOS DE LÁMINAS'),'T',0,'C', false);
$pdf->Cell(32, 4, utf8_decode('CANTIDAD DE'),'TLR',0,'C', false);

$pdf->Cell(5, 4, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 4, utf8_decode('N° DE'),'TLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode('CÓDIGOS DE LÁMINAS'),'T',0,'C', false);
$pdf->Cell(30, 4, utf8_decode('CANTIDAD DE'),'TLR',1,'C', false);


$pdf->Cell(16, 4, utf8_decode('PLANILLA'),'BLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),'B',0,'C', false);
$pdf->Cell(32, 4, utf8_decode('PAP'),'BLR',0,'C', false);

$pdf->Cell(5, 4, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 4, utf8_decode('PLANILLA'),'BLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),'B',0,'C', false);
$pdf->Cell(30, 4, utf8_decode('PAP'),'BLR',1,'C', false);
/////
$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(32, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(30, 7, utf8_decode(''),1,1,'C', false);

/////////
$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(32, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(30, 7, utf8_decode(''),1,1,'C', false);

/////////
$pdf->Cell(61, 7, utf8_decode('TOTAL'),0,0,'R', false);
$pdf->Cell(32, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(61, 7, utf8_decode('TOTAL'),0,0,'R', false);
$pdf->Cell(30, 7, utf8_decode(''),1,1,'C', false);

$pdf->Ln(3);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 4, utf8_decode('Recibido por:'),0,0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),0,0,'C', false);
$pdf->Cell(32, 4, utf8_decode('Fec. Recepción'),0,0,'C', false);

$pdf->Cell(5, 4, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 4, utf8_decode('Recibido por:'),0,0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),0,0,'C', false);
$pdf->Cell(30, 4, utf8_decode('Fec. Recepción'),0,1,'C', false);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(12, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,1,'C', false);




/***************************************************************/
$pdf->Ln(15);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode('ENVÍO'),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode('DESTINO'),1,0,'C', false);
$pdf->Cell(32, 7, utf8_decode('FEC. ENVÍO'),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode('ENVÍO'),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode('DESTINO'),1,0,'C', false);
$pdf->Cell(30, 7, utf8_decode('FEC. ENVÍO'),1,1,'C', false);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(12, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,1,'C', false);


$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 4, utf8_decode('N° DE'),'TLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode('CÓDIGOS DE LÁMINAS'),'T',0,'C', false);
$pdf->Cell(32, 4, utf8_decode('CANTIDAD DE'),'TLR',0,'C', false);

$pdf->Cell(5, 4, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 4, utf8_decode('N° DE'),'TLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode('CÓDIGOS DE LÁMINAS'),'T',0,'C', false);
$pdf->Cell(30, 4, utf8_decode('CANTIDAD DE'),'TLR',1,'C', false);


$pdf->Cell(16, 4, utf8_decode('PLANILLA'),'BLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),'B',0,'C', false);
$pdf->Cell(32, 4, utf8_decode('PAP'),'BLR',0,'C', false);

$pdf->Cell(5, 4, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 4, utf8_decode('PLANILLA'),'BLR',0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),'B',0,'C', false);
$pdf->Cell(30, 4, utf8_decode('PAP'),'BLR',1,'C', false);
/////
$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(32, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(30, 7, utf8_decode(''),1,1,'C', false);

/////////
$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(32, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(30, 7, utf8_decode(''),1,1,'C', false);

/////////
$pdf->Cell(61, 7, utf8_decode('TOTAL'),0,0,'R', false);
$pdf->Cell(32, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(61, 7, utf8_decode('TOTAL'),0,0,'R', false);
$pdf->Cell(30, 7, utf8_decode(''),1,1,'C', false);

$pdf->Ln(3);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 4, utf8_decode('Recibido por:'),0,0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),0,0,'C', false);
$pdf->Cell(32, 4, utf8_decode('Fec. Recepción'),0,0,'C', false);

$pdf->Cell(5, 4, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 4, utf8_decode('Recibido por:'),0,0,'C', false);
$pdf->Cell(45, 4, utf8_decode(''),0,0,'C', false);
$pdf->Cell(30, 4, utf8_decode('Fec. Recepción'),0,1,'C', false);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(12, 7, utf8_decode(''),1,0,'C', false);

$pdf->Cell(5, 7, utf8_decode(''),0,0,'L', false);

$pdf->Cell(16, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(45, 7, utf8_decode(''),0,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,0,'C', false);
$pdf->Cell(10, 7, utf8_decode(''),1,1,'C', false);


$pdf->Output();
?>
