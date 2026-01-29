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

$id_tipodoc = $_GET['idTipDoc'];
$nro_doc = $_GET['nroDoc'];
$nombre_pac = $_GET['nomRS'];
$fecIni = $_GET['fecIni'];
$fecFin = $_GET['fecFin'];
$nro_atencion = $_GET['nroAte'];
$es_urgente = (isset($_GET['optUrgente'])) ? $_GET['optUrgente'] : '';
$id_producto = (isset($_GET['idProducto'])) ? $_GET['idProducto'] : '';
$nro_atencion_otroapp = (isset($_GET['nroAteOtro'])) ? $_GET['nroAteOtro'] : '';

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
	if($_SESSION['labIdDepUser'] == "67"){
		$this->Cell(0,7,utf8_decode("REPORTE ATENCIONES EN EL SERVICIO LABORATORIO"),0,1,'C');
	} else {
		$this->Cell(0,7,utf8_decode("REPORTE GENERAL DE CITAS EN EL SERVICIO LABORATORIO"),0,1,'C');
	}

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
	if(($_GET['nroAte'] == "") And ($_GET['nomRS'] == "") And ($_GET['nroDoc'] == "")){
		$this->SetFont('Arial','B',8);
		$this->Cell(12,5,utf8_decode("Fechas:"),0,0,'L');
		$this->SetFont('Arial','',7);
		$this->Cell(31,5,$_GET['fecIni'] . " AL " . $_GET['fecFin'],0,1,'L');	
	} else {
		$this->Cell(43,5,'',0,1,'L');
	}



    $this->SetFont('Arial','B',7);
    $this->Cell(7, 4, utf8_decode('Item'), 'LTR', 0, 'C', false);
    $this->Cell(18, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(15, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', false);
	$this->Cell(16, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', false);
    $this->Cell(7, 4, utf8_decode('Plan'), 'LTR', 0, 'C', false);
    $this->Cell(22, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('H.C.'), 'LTR', 0, 'C', false);
    $this->Cell(80, 4, utf8_decode('Paciente'), 'LTR', 0, 'C', false);
    $this->Cell(7, 4, utf8_decode('Edad'), 'LTR', 0, 'C', false);
	if($_SESSION['labIdDepUser'] == "67"){
		$this->Cell(73, 4, utf8_decode('Establecimiento procedencia'), 'LTR', 0, 'C', false);
	} else {
		$this->Cell(43, 4, utf8_decode('Teléfono'), 'LTR', 0, 'C', false);
		$this->Cell(30, 4, utf8_decode('Teléfono'), 'LTR', 0, 'C', false);
	}
    $this->Cell(22, 4, utf8_decode('Resultado'), 'LTR', 1, 'C', false);


    $this->Cell(7, 4, utf8_decode(''), 'LBR', 0, 'C', false);
	$this->Cell(18, 4, utf8_decode('Atención'), 'LBR', 0, 'C', false);
	if($_SESSION['labIdDepUser'] == "67"){
		$this->Cell(15, 4, utf8_decode('Recepción'), 'LBR', 0, 'C', false);
	} else {
		$this->Cell(15, 4, utf8_decode('Registro'), 'LBR', 0, 'C', false);
	}
	if($_SESSION['labIdDepUser'] == "67"){
		$this->Cell(16, 4, utf8_decode('Toma muestra'), 'LBR', 0, 'C', false);
	} else {
		$this->Cell(16, 4, utf8_decode('Atención'), 'LBR', 0, 'C', false);
	}
    $this->Cell(7, 4, utf8_decode('Tarif.'), 'LBR', 0, 'C', false);
    $this->Cell(22, 4, utf8_decode('Documento'), 'LBR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(80, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(7, 4, utf8_decode(''), 'LBR', 0, 'C', false);
	if($_SESSION['labIdDepUser'] == "67"){
		$this->Cell(73, 4, utf8_decode(''), 'LR', 0, 'C', false);
	} else {
		$this->Cell(43, 4, utf8_decode('Móvil'), 'LBR', 0, 'C', false);
		$this->Cell(30, 4, utf8_decode('Fijo'), 'LBR', 0, 'C', false);
	}
    $this->Cell(22, 4, utf8_decode(''), 'LBR', 1, 'C', false);

    //$this->Cell(0, 4, utf8_decode('Resultado'), 1, 1, 'C', false);
  }

  //Pie de página
  function Footer()  {
    //Posición: a 1,5 cm del final (Siempre va en el footer)
	require_once '../../model/Atencion.php';
	$at = new Atencion();
	$rsHI = $at->get_datosfecHoraActual();
	
    $this->SetY(-20);
    $this->SetFont('Arial','',6);
    $this->Cell(94,4,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'L');
	$this->Cell(94,4,utf8_decode("Fecha y hora de impresión: " . $rsHI[0]['fechora_actual'] . " (" . $_SESSION['labNomUser'] . ")"),0,0,'C');
	$this->Cell(95,4,utf8_decode("* No se está considerando las atenciones ANULADAS."),0,1,'R');
  }
}

$pdf=new PDF('L','mm','A4');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,20); //Siempre cuando se va a poner el pie de página
$pdf->SetMargins(8,8,8);
$pdf->AliasNbPages();
$pdf->AddPage();

$param[0]['id_tipodoc'] = $id_tipodoc;
$param[0]['nro_doc'] = $nro_doc;
$param[0]['nombre_pac'] = $nombre_pac;
$param[0]['fec_cita_ini'] = $fecIni;
$param[0]['fec_cita_fin'] = $fecFin;
$param[0]['idDepAten'] = $labIdDepUser;
$param[0]['nro_atencion'] = $nro_atencion;
$param[0]['es_urgente'] = $es_urgente;
$param[0]['id_producto'] = $id_producto;
$param[0]['nro_atencionotro'] = $nro_atencion_otroapp;
$param[0]['id_tipo_correlativo'] = $_SESSION['labIdTipoCorrelativo'];
if($nro_atencion <> ""){
	$param[0]['fec_cita_ini'] = "";
	$param[0]['fec_cita_fin'] = "";
}

if($nro_atencion_otroapp <> ""){
	$param[0]['fec_cita_ini'] = "";
	$param[0]['fec_cita_fin'] = "";	
}

if($nombre_pac <> ""){
	$param[0]['fec_cita_ini'] = "";
	$param[0]['fec_cita_fin'] = "";	
}

if($nro_doc <> ""){
	$param[0]['fec_cita_ini'] = "";
	$param[0]['fec_cita_fin'] = "";	
}

$param[0]['origen_dep'] = "";
if($_SESSION['labIdDepUser'] == "67"){
	$param[0]['origen_dep'] = "LR";
}
/*print_r($param);
exit();*/
$rsC = $a->get_repDatosAtencionCita($param);
/*print_r($rsC);
exit();*/
$item = 0;
$subitem = 0;
foreach ($rsC as $row) {
  $item ++;
  $pdf->SetFont('Arial','',7);
  $pdf->Cell(7, 4, $item, 1, 0, 'C', false);
  if($_SESSION['labIdDepUser'] == "67"){
	$pdf->Cell(18, 4, $row['nro_atencion_manual'], 'BR', 0, 'L', false);
  } else {
	if($row['id_tipo_genera_correlativo'] == "1"){
		$nroAtencion = $row['nro_atencion'] . "-". $row['anio_atencion'];
	} else {
		$nroAtencion = substr($row['nro_atencion'], 0, 6).substr($row['nro_atencion'],6);
	}
	$pdf->Cell(18, 4, $nroAtencion, 'BR', 0, 'C', false);
	
  }
  $pdf->Cell(15, 4, utf8_decode($row['fec_atencion']), 'LBR', 0, 'C', false);
  $pdf->Cell(16, 4, utf8_decode($row['fec_cita']), 'LBR', 0, 'C', false);
  $pdf->Cell(7, 4, utf8_decode($row['sigla_plan']), 'LBR', 0, 'C', false);
  $pdf->Cell(22, 4, utf8_decode($row['abrev_tipodoc']. ": ".$row['nrodoc']), 'LBR', 0, 'L', false);
  $pdf->Cell(16, 4, utf8_decode($row['nro_hc']), 'LBR', 0, 'C', false);
  $pdf->Cell(80, 4, utf8_decode($row['nombre_rs']), 1, 0, 'L', false);
  $pdf->Cell(7, 4, utf8_decode($row['edad_pac']), 1, 0, 'C', false);

	if($_SESSION['labIdDepUser'] == "67"){
		$pdf->Cell(73, 4, utf8_decode($row['nom_depenori']), 1, 0, 'L', false); 
	} else {
		$pdf->Cell(43, 4, utf8_decode(str_replace("000000000", "", $row['nro_telefonomovil'])), 1, 0, 'C', false);
		$pdf->Cell(30, 4, utf8_decode($row['nro_telefonofijo']), 1, 0, 'C', false);
	}
  $pdf->SetFillColor(255, 255, 255);
  $pdf->SetFont('Arial','B',6);
  if($row['id_estadoreg'] <> "6"){
	if($row['nom_estadoresul'] == "VALID./COMPL"){
		$pdf->SetTextColor(0, 128, 0);
	} else {
		$pdf->SetTextColor(0,0,0);
	}
	$pdf->Cell(22, 4, utf8_decode($row['nom_estadoresul']), 1, 1, 'C', true);
  } else {
	  $pdf->SetTextColor(255, 0, 0);
	$pdf->Cell(22, 4, "RECHAZADO", 1, 1, 'C', true);
  }
  
  $pdf->SetTextColor(0,0,0);
  if($_GET['opt'] == "T"){
	  $rsP = $a->get_datosProductoPorIdAtencion($row['id']);
	  $subitem = 0;
	  foreach ($rsP as $rowP) {
		  $subitem ++;
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(3, 4, '', 0, 0, 'C', false);
		$pdf->Cell(4, 4, $subitem, 'LBR', 0, 'C', false);
		if($_SESSION['labIdDepUser'] == "67"){
			$examen = str_replace("TOMA DE MUESTRA ", "", $rowP['nom_producto']);
			$examen = str_replace("PARA ", "", $examen);
		} else {
			$examen = $rowP['nom_producto'];
		}
		$pdf->Cell(94, 4, utf8_decode($examen), 'LBR', 1, 'L', false);
	  }
  }
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
