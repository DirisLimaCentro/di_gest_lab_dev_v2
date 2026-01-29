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

require_once '../../model/Pap.php';
$pap = new Pap();

class PDF extends FPDF{

  //Pie de página
  function Footer()
  {
    //Posición: a 1,5 cm del final (Siempre va en el footer)
    $this->SetY(-25);

    $this->SetFont('Arial','',7);
    $this->Cell(90,4,utf8_decode("Firma y sello"),0,0,'C');
    $this->Cell(90,4,utf8_decode("Firma y sello"),0,1,'C');

    $this->Cell(90,4,utf8_decode("Resposable de recepción de muestra"),0,0,'C');
    $this->Cell(90,4,utf8_decode("Resposable de LRC RSLC"),0,1,'C');
  }
}

$pdf=new PDF('P','mm','A4');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,4);
$pdf->SetMargins(10,4,10);
$pdf->AliasNbPages();
$pdf->AddPage();

$rsE = $pap->get_repDatosEnviadoNoConfor($_GET['idEnv']);
/*print_r($rsE);
exit();*/

$pdf->Image('../../assets/images/logo_diris.png',8,4,100);
//$pdf->Image('../../assets/images/progreso_todos.jpg',172,4,28);
//$pdf->Image('../../assets/images/reforma_massalud.jpg',171,17,28);
$pdf->setY(22);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0, 6, utf8_decode('LABORATORIO REFERENCIAL DE CITOLOGÍA'),0,1,'C', false);
$pdf->Ln(3);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0, 6, utf8_decode('FICHA DE REPORTE DE NO CONFORMIDADES'),0,1,'C', false);
$pdf->Ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10, 6, '',0,0,'L', false);
$pdf->Cell(180, 6, utf8_decode('Ficha N° '.str_pad($rsE[0]['nro_fichaobsfinal'], 4, "0", STR_PAD_LEFT).'-LRC-RSL-'.$rsE[0]['anio_fichaobsfinal'].''),0,1,'L', false);
$pdf->Ln(1);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10, 6, '',0,0,'L', false);
$pdf->Cell(180, 6, utf8_decode('Fecha: '.$rsE[0]['fec_papfinal'].''),0,1,'L', false);

$pdf->Ln(1);
$pdf->Cell(0, 6, utf8_decode('I. ESTABLECIMIENTO DE SALUD O INSTITUCIÓN: '.$rsE[0]['nom_depen']),1,1,'L', false);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(95, 6, utf8_decode('1. NOMBRE DEL RESPONSABLE (quien firma el documento):'),1,0,'L', false);
$pdf->Cell(95, 6, utf8_decode('4. INICALES DE LA(S) PACIENTE(S):'),1,1,'L', false);
$pdf->SetFont('Arial','',9);
//$pdf->Cell(95, 6, utf8_decode('Lic. Bertha Llempen Núñez'),1,0,'L', false);
$pdf->Cell(95, 6, utf8_decode(''),1,0,'L', false);
$pdf->Cell(95, 6, utf8_decode(''),1,1,'L', false);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(95, 6, utf8_decode('2. DOCUMENTO DE REFERENCIA:'),1,0,'L', false);
$pdf->Cell(95, 6, utf8_decode(''),1,1,'L', false);
$pdf->SetFont('Arial','',9);
$pdf->Cell(95, 6, utf8_decode('Planilla PAP N° '.$rsE[0]['nro_papenv'].'-'.$rsE[0]['anio_papenv']),1,0,'L', false);
$pdf->Cell(95, 6, utf8_decode(''),1,1,'L', false);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(95, 6, utf8_decode('3. EXÁMEN SOLICITADO: PAP'),1,0,'L', false);
$pdf->Cell(95, 6, utf8_decode(''),1,1,'L', false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(0, 4, utf8_decode(''),1,1,'C', false);
$pdf->Cell(0, 6, utf8_decode('II. NÚMERO Y TIPO DE MUESTRAS Y/O MATERIAL BIOLÓGICO RECIBIDAS'),'LR',1,'L', false);
$pdf->SetFont('Arial','',9);
$pdf->Cell(4, 5, '','L',0,'L', false);
$pdf->Cell(40, 5, utf8_decode('LAMINAS (X)'),0,0,'L', false);
$pdf->Cell(146, 5, utf8_decode('NÚMERO ('.$rsE[0]['cnt_papenv'].')'),'R',1,'L', false);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0, 2, utf8_decode(''),'RL',1,'C', false);
$pdf->Cell(105, 5, utf8_decode('III. RECEPCIÓN DE LA MUESTRA Y/O MATERIAL BIOLÓGICO'),'L',0,'L', false);
$pdf->Cell(16, 5, utf8_decode('FECHA:'),0,0,'R', false);
$pdf->Cell(25, 5, $rsE[0]['fec_papfinal'],1,0,'C', false);
$pdf->Cell(16, 5, utf8_decode('HORA:'),'L',0,'R', false);
$pdf->Cell(18, 5, $rsE[0]['fec_horafinal'],1,0,'L', false);
$pdf->Cell(10, 5, '','R',1,'L', false);
$pdf->Cell(0, 2, utf8_decode(''),'RL',1,'C', false);
$pdf->Cell(0, 2, utf8_decode(''),'RBL',1,'C', false);

$pdf->Cell(0, 6, utf8_decode('IV. DESCRIPCIÓN DE LA NO CONFORMIDAD:'),'LR',1,'L', false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(4, 5, '','L',0,'L', false);
$pdf->Cell(186, 5, utf8_decode('A) CON LOS DOCUMENTOS (ficha u oficio)'),'R',1,'L', false);
$pdf->SetFont('Arial','',9);
$rsMD = $pap->get_repDatosNoConforDocOEmpPorIdEnv($_GET['idEnv'], '1');
/*print_r($rsMD);
exit();*/
foreach ($rsMD as $row) {
  $cnt_nocofor = ($row['cnt_motnoconfor'] == 0) ? '' : 'X';
  $pdf->Cell(4, 5, '','L',0,'L', false);
  $pdf->Cell(10, 5, $cnt_nocofor,1,0,'C', false);
  $pdf->Cell(160, 5, utf8_decode($row['nom_motivo']),1,0,'L', false);
  $pdf->Cell(16, 5, '','R',1,'L', false);
}

$pdf->Cell(0, 3, utf8_decode(''),'RL',1,'C', false);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(4, 5, '','L',0,'L', false);
$pdf->Cell(186, 5, utf8_decode('B) CON LA MUESTRA Y/O MATERIAL BIOLÓGICO'),'R',1,'L', false);
$pdf->SetFont('Arial','',9);
$rsMD = $pap->get_repDatosRechazadoOPorSubsanarPorIdEnv($_GET['idEnv'], '4');
/*print_r($rsMD);
exit();*/
foreach ($rsMD as $row) {
  $cnt_rechazo = ($row['cnt_envrechazado'] == 0) ? '' : 'X';
  $pdf->Cell(4, 5, '','L',0,'L', false);
  $pdf->Cell(10, 5, $cnt_rechazo,1,0,'C', false);
  $pdf->Cell(160, 5, utf8_decode($row['nom_estado']),1,0,'L', false);
  $pdf->Cell(16, 5, '','R',1,'L', false);
}

$pdf->Cell(0, 3, utf8_decode(''),'RL',1,'C', false);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(4, 5, '','L',0,'L', false);
$pdf->Cell(186, 5, utf8_decode('C) CON EL EMPAQUE'),'R',1,'L', false);
$pdf->SetFont('Arial','',9);
$rsMD = $pap->get_repDatosNoConforDocOEmpPorIdEnv($_GET['idEnv'], '2');
/*print_r($rsMD);
exit();*/
foreach ($rsMD as $row) {
  $cnt_nocofor = ($row['cnt_motnoconfor'] == 0) ? '' : 'X';
  $pdf->Cell(4, 5, '','L',0,'L', false);
  $pdf->Cell(10, 5, $cnt_nocofor,1,0,'C', false);
  $pdf->Cell(160, 5, utf8_decode($row['nom_motivo']),1,0,'L', false);
  $pdf->Cell(16, 5, '','R',1,'L', false);
};

$pdf->Cell(0, 3, utf8_decode(''),'RL',1,'C', false);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0, 5, utf8_decode('OBSERVACIONES:'),'RL',1,'L', false);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0, 4, utf8_decode($rsE[0]['det_obsfinal']),'RL','L', false);

$pdf->Cell(0, 3, '','RLB',1,'L', false);

$y = 64;
$x = 106;
$pdf->setY($y);
$pdf->setX($x);
if($rsE[0]['cnt_solirechazada'] <= 4){
    $rsMD = $pap->get_repDatosEnviadoNoConforPacientesPorIdEnv($_GET['idEnv']);
    foreach ($rsMD as $row) {
		
    $arrNomFalle = explode(" ", $row['nombre_pac']);
    $cntNomFalle = count($arrNomFalle);
    $priNomFalle = substr($arrNomFalle[0], 0, 1); // porción1
    $otroNomFalle = "";
    for($i = 1; $i < $cntNomFalle; $i++){
      $otroNomFalle.= "".substr($arrNomFalle[$i], 0, 1);
    }
	
      $pdf->Cell(92, 6, utf8_decode($row['abrev_rspac'].$priNomFalle.$otroNomFalle." (".$row['nro_ordensoli']."-".$row['anio_ordensoli'].")"), 0, 1, 'L', false);
      $pdf->setX($x);
    }
} else {
  $rsMD = $pap->get_repDatosEnviadoNoConforPacientesPorIdEnv($_GET['idEnv']);
  $rs = "";
  foreach ($rsMD as $row) {
    $arrNomFalle = explode(" ", $row['nombre_pac']);
    $cntNomFalle = count($arrNomFalle);
    $priNomFalle = substr($arrNomFalle[0], 0, 1); // porción1
    $otroNomFalle = "";
    for($i = 1; $i < $cntNomFalle; $i++){
      $otroNomFalle.= "".substr($arrNomFalle[$i], 0, 1);
    }
	  
    $rs .= $row['abrev_rspac'].$priNomFalle.$otroNomFalle." (".$row['nro_ordensoli']."-".$row['anio_ordensoli']."), ";
  }
  $pdf->MultiCell(92, 6, utf8_decode($rs), 0, 'L', false);
}

$pdf->Output();
?>
