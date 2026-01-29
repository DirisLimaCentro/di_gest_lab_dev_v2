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

require_once '../../model/Pap.php';
$pap = new Pap();

$idTipDoc = $_GET['idTipDoc'];
$nroDoc = $_GET['nroDoc'];
$nomRS = $_GET['nomRS'];
$fecIni = $_GET['fecIni'];
$fecFin = $_GET['fecFin'];

class PDF extends FPDF
{
  //Cabecera de página
  function Header()
  {
    require_once '../../model/Dependencia.php';
    $d = new Dependencia();
    require_once '../../model/Pap.php';
    $pap = new Pap();
    //Logo
    $this->Image('../../assets/images/logo_diris.png',8,8,48);

    $this->SetFont('Arial','B',11);
    $this->Cell(0,7,utf8_decode("REPORTE DE ATENCIONES DE TAMIZAJE DE PAPANICOLAOU"),0,1,'C');

    $this->Ln(2);
    $this->SetFont('Arial','B',8);
    $this->Cell(37,5,utf8_decode("Establecimiento de salud:"),0,0,'L');
    $rsD = $d->get_datosDepenendenciaPorId($_SESSION['labIdDepUser']);
    $this->SetFont('Arial','',8);
    $this->Cell(115,5,utf8_decode($rsD[0]["nom_depen"]),0,0,'L');
    $this->SetFont('Arial','B',8);
    $this->Cell(12,5,utf8_decode("Distrito:"),0,0,'L');
    $this->SetFont('Arial','',8);
    $this->Cell(76,5,utf8_decode($rsD[0]["distrito"]),0,0,'L');
	$this->Cell(39,5,utf8_decode("Del: " . $_GET['fecIni'] . "  al  " . $_GET['fecFin']),0,1,'R');

    $this->SetFont('Arial','B',7);
    $this->Cell(7, 4, 'Item', 'LTR', 0, 'C', false);
    $this->Cell(11, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(11, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', false);
    $this->Cell(5, 4, utf8_decode('SIS'), 'LTR', 0, 'C', false);
    $this->Cell(22, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(15, 4, utf8_decode('H.C.'), 'LTR', 0, 'C', false);
    $this->Cell(72, 4, utf8_decode('Paciente'), 'LTR', 0, 'C', false);
    $this->Cell(6, 4, utf8_decode('Edad'), 'LTR', 0, 'C', false);
    $this->Cell(99, 4, utf8_decode('Dirección'), 'LTR', 0, 'C', false);
	$this->Cell(23, 4, utf8_decode('Teléfono(s)'), 'LTR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode('Resul'), 'LTR', 1, 'C', false);


    $this->Cell(7, 4, '', 'LBR', 0, 'C', false);
    $this->Cell(11, 4, utf8_decode('Lámina'), 'LBR', 0, 'C', false);
    $this->Cell(11, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(5, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(22, 4, utf8_decode('Documento'), 'LBR', 0, 'C', false);
    $this->Cell(15, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(72, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(6, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(99, 4, utf8_decode(''), 'LBR', 0, 'C', false);
	$this->Cell(23, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(8, 4, utf8_decode(''), 'LBR', 1, 'C', false);

    //$this->Cell(0, 4, utf8_decode('Resultado'), 1, 1, 'C', false);
  }

  //Pie de página
  function Footer()
  {
    //Posición: a 1,5 cm del final (Siempre va en el footer)
    $this->SetY(-20);

    require_once '../../model/Pap.php';
    $pap = new Pap();

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

if(empty($_GET['nroDoc']) And empty($_GET['nomRS'])){
  $fecIni = $_GET['fecIni'];
  $fecFin = $_GET['fecFin'];
	if($labIdRolUser <> "6"){
		$param[0]['idDepAten'] = $labIdDepUser;
	} else {
		$param[0]['idDepAten'] = "";
	}
} else {
  $fecIni = "";
  $fecFin = "";
	if($labIdRolUser <> "6"){
		$param[0]['idDepAten'] = $labIdDepUser;
	} else {
		$param[0]['idDepAten'] = "";
	}
}

if($_GET['tipo_repor'] == "2"){
  $fecIni = "";
  $fecFin = "";
	if($labIdRolUser <> "6"){
		$param[0]['idDepAten'] = $labIdDepUser;
	} else {
		if($_GET['id_dependencia'] <> ""){
			$param[0]['idDepAten'] = $_GET['id_dependencia'];
		} else {
			$param[0]['idDepAten'] = "";
		}
	}
}

$param[0]['idTipDoc'] = $_GET['idTipDoc'];
$param[0]['nroDoc'] = $_GET['nroDoc'];
$param[0]['nomRS'] = $_GET['nomRS'];
$param[0]['fecIniAte'] = $fecIni;
$param[0]['fecFinAte'] = $fecFin;
$param[0]['chk_positivo'] = $_GET['chk_positivo'];
$param[0]['tipo_repor'] = $_GET['tipo_repor'];

$rsC = $pap->get_repDatosSolicitud($param);
/*print_r($rsC);
exit();*/
$item = 0;
foreach ($rsC as $row) {
  $item ++;
  $pdf->SetFont('Arial','',7);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->Cell(7, 4, $item, 'LBR', 0, 'C', false);
  $pdf->Cell(11, 4, $row['nro_ordensoli']."-".$row['anio_ordensoli'], 'BR', 0, 'C', false);
  $pdf->Cell(11, 4, $row['fec_atencion'], 'LBR', 0, 'C', false);
  $pdf->Cell(5, 4, utf8_decode($row['nom_sispac']), 'LBR', 0, 'C', false);
  $tipo_doc = $row['abrev_tipodocpac']. ": ";
  $nro_doc = $row['nro_docpac'];
  if($row['abrev_tipodocpac'] == "SDI"){$nro_doc = substr($row['nro_docpac'], -8);}
  $pdf->Cell(22, 4, $tipo_doc . $nro_doc, 'LBR', 0, 'L', false);
  $pdf->Cell(15, 4, utf8_decode($row['nro_hc']), 'LBR', 0, 'C', false);
  $pdf->Cell(72, 4, utf8_decode($row['nombre_rspac']), 'LBR', 0, 'L', false);
  $pdf->Cell(6, 4, utf8_decode($row['edad_pac']), 'LBR', 0, 'C', false);
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(99, 4, utf8_decode(str_replace("SAN JUAN DE LURIGANCHO", "SJL", $row['distrito']) . " - " . $row['descrip_dir']), 'LBR', 0, 'L', false);
  $pdf->Cell(23, 4, trim($row['telf_movil'] . " " . $row['telf_fijo']), 'LBR', 0, 'C', true);
  $pdf->SetFont('Arial','B',6);
  $nom_resultado = "";
  switch($row['nom_resul']){
	  case "INSATISFAC.":
		$nom_resultado = "INS";
	  break;
	  case "NEGATIVO":
		$nom_resultado = "NEG";
	  break;
	  case "POSITIVO":
		$nom_resultado = "POS";
	  break;
	  default:
		$nom_resultado = $row['nom_resul'];
	  break;
  }
  $pdf->Cell(8, 4, $nom_resultado, 'LBR', 1, 'C', false);
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
