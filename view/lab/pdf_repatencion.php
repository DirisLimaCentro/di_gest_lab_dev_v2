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

include '../../assets/lib/fpdf/PDF_MC_Table.php';

class ReporteAtenciones extends PDF_MC_Table{
	
  private $rs = [];
  private $d = [];
  
  public function __construct() {
    parent::__construct();
	
    $this->SetTitle(utf8_decode('Reporte atenciones - DIRISLAB'));
    $this->SetAuthor('Dirislab');
    $this->SetAutoPageBreak(true, 20);
    $this->SetMargins(8,8,8);
  }
  
  public function Header() {
    require_once '../../model/Dependencia.php';
    $d = new Dependencia();
    require_once '../../model/Atencion.php';
    $at = new Atencion();
	require_once '../../model/Producton.php';
    $prn = new Producton();
	 
	//Logo y nombre del establecimiento
    $this->Image('../../assets/images/logo_diris.png',8,8,48);
	$rsD = $d->get_datosDepenendenciaPorId($_SESSION['labIdDepUser']);
	$this->SetY(8);
    $this->SetFont('Arial','B',11);
    $this->Cell(0,7,utf8_decode($rsD[0]["nom_depen"]),0,1,'C');
	
	if($_GET['opt'] == "H"){
		//Datos de cabecera
		$this->Ln(2);
		$this->SetFont('Arial','B',8);
		$this->Cell(110,5,utf8_decode("REPORTE DE ATENCIONES EN LABORATORIO CLINICO"),0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(95,5,"Del :   " . $_GET['fecIni'] . "  al  " . $_GET['fecFin'],0,0,'L');
		$this->Cell(28,5,utf8_decode("Fecha y hora reporte:"),0,0,'L');
		$rsHI = $at->get_datosfecHoraActual();
		$this->Cell(50,5,$rsHI[0]['fechora_actual']." (".$_SESSION['labNomUser'].")",0,1,'L');
	} else {
		//Datos de cabecera
		$this->Ln(2);
		$this->SetFont('Arial','B',8);
		$this->Cell(82,5,utf8_decode("REPORTE DE ATENCIONES EN LABORATORIO CLINICO"),0,0,'L');
		$this->SetFont('Arial','',7);
		$this->Cell(45,5,"Del :   " . $_GET['fecIni'] . "  al  " . $_GET['fecFin'],0,0,'L');
		$this->Cell(25,5,utf8_decode("Fecha y hora reporte:"),0,0,'L');
		$rsHI = $at->get_datosfecHoraActual();
		$this->Cell(40,5,$rsHI[0]['fechora_actual']." (".$_SESSION['labNomUser'].")",0,1,'L');

	}
	
	$chk_gestante = (empty($_GET['chk_gestante'])) ? "NO GESTANTE" : ($_GET['chk_gestante'] == "1" ? "GESTANTE": "");
	$condicion_eg = "";
	if ($_GET['condicion_eg'] <> "") {
		if($_GET['condicion_eg'] == "<"){$condicion_eg = " CON EG MENOR A: " . $_GET['nro_eg'];}
		else if($_GET['condicion_eg'] == ">"){$condicion_eg = " CON EG MAYOR A: " . $_GET['nro_eg'];}
		else {$condicion_eg = " CON EG IGUAL A: " . $_GET['nro_eg'];}
		$chk_gestante = $chk_gestante . $condicion_eg;
	}
	$rango_edad = (!empty($_GET['edad_hasta'])) ? "Rango edad: ". $_GET['edad_desde'] . " hasta " . $_GET['edad_hasta'] . " años" : "";
	$condicion_eess_procedencia = (empty($_GET['condicion_dep_procedencia'])) ? "" : "ESTABLECIMIENTO DE PROCEDENCIA: ";
	$eess_procedencia = (empty($_GET['id_dep_procedencia'])) ? "TODOS" : "";
	if(!empty($condicion_eess_procedencia)){
		if($eess_procedencia == "TODOS"){
			$condicion_eess_procedencia = $condicion_eess_procedencia . $eess_procedencia;
		} else {
			$rsDO = $d->get_datosDepenendenciaPorId($_GET['id_dep_procedencia']);
			$condicion_eess_procedencia = $condicion_eess_procedencia . $rsDO[0]["nom_depen"];
		}
	}
	$id_producto = (!empty($_GET['id_producto'])) ? $_GET['id_producto'] : "";
	if (!empty($id_producto)){
		$productos = '';
		$rsP = $prn->get_datosNombreProductoPorIdProductoMultiselect($_GET['id_producto']);
		foreach ($rsP as $row) {
			$productos.= $row['nom_producto'].",";
		}

	}
	
	if ($condicion_eess_procedencia <> ""){
		$this->MultiCell(0,4,utf8_decode($condicion_eess_procedencia), 0, 1);
	}
	if($chk_gestante == "" && $rango_edad == "" ){
		if ($id_producto <> ""){
			$this->MultiCell(0,4,utf8_decode("Examen solicitado: " . $productos), 0, 1);
		}
	} else {
		if ($id_producto <> ""){
			if($_GET['opt'] == "H"){
				$this->Cell(140,4,utf8_decode($chk_gestante . $rango_edad),0,0,'L');
				$this->MultiCell(140,4,utf8_decode("Examen solicitado: " . $productos), 0, 1);
			} else {
				$this->Cell(0,4,utf8_decode($chk_gestante . $rango_edad),0,1,'L');
				$this->MultiCell(0,4,utf8_decode("Examen solicitado: " . $productos), 0, 1);	
			}
		} else {
			$this->Cell(0,4,utf8_decode($chk_gestante . $rango_edad),0,1,'L');
		}
	}
	
	if($_GET['opt'] == "H"){
		$this->SetFont('Arial','B',7);
		$this->SetFillColor(180, 179, 179);
		$this->Cell(7, 4, utf8_decode('Item'), 'LTR', 0, 'C', true);
		$this->Cell(17, 4, utf8_decode('N°'), 'LTR', 0, 'C', true);
		$this->Cell(16, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', true);
		$this->Cell(16, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', true);
		$this->Cell(70, 4, utf8_decode('Paciente'), 'LTR', 0, 'C', true);
		$this->Cell(8, 4, utf8_decode('Plan'), 'LTR', 0, 'C', true);
		$this->Cell(20, 4, utf8_decode('Resultado'), 'LTR', 0, 'C', true);
		$this->Cell(126, 4, utf8_decode('Examenes'), 'LTR', 1, 'C', true);
		
		$this->Cell(7, 4, utf8_decode(''), 'LBR', 0, 'C', true);
		$this->Cell(17, 4, utf8_decode('Atención'), 'LBR', 0, 'C', true);
		$this->Cell(16, 4, utf8_decode('Registro/Aten'), 'LBR', 0, 'C', true);
		$this->Cell(16, 4, utf8_decode('Cita'), 'LBR', 0, 'C', true);
		$this->Cell(70, 4, utf8_decode(''), 'LBR', 0, 'C', true);
		$this->Cell(8, 4, utf8_decode('Tarif.'), 'LBR', 0, 'C', true);
		$this->Cell(20, 4, utf8_decode(''), 'LBR', 0, 'C', true);
		$this->Cell(126, 4, utf8_decode(''), 'LBR', 1, 'C', true);
		$this->SetFont('Arial','',7);
	} else {
		$this->SetFont('Arial','B',7);
		$this->SetFillColor(180, 179, 179);
		$this->Cell(7, 4, utf8_decode('Item'), 'LTR', 0, 'C', true);
		$this->Cell(17, 4, utf8_decode('N°'), 'LTR', 0, 'C', true);
		$this->Cell(16, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', true);
		$this->Cell(16, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', true);
		$this->Cell(50, 4, utf8_decode('Paciente'), 'LTR', 0, 'C', true);
		$this->Cell(8, 4, utf8_decode('Plan'), 'LTR', 0, 'C', true);
		$this->Cell(80, 4, utf8_decode('Examenes'), 'LTR', 1, 'C', true);
		
		$this->Cell(7, 4, utf8_decode(''), 'LBR', 0, 'C', true);
		$this->Cell(17, 4, utf8_decode('Atención'), 'LBR', 0, 'C', true);
		$this->Cell(16, 4, utf8_decode('Registro/Aten'), 'LBR', 0, 'C', true);
		$this->Cell(16, 4, utf8_decode('Cita'), 'LBR', 0, 'C', true);
		$this->Cell(50, 4, utf8_decode(''), 'LBR', 0, 'C', true);
		$this->Cell(8, 4, utf8_decode('Tarif.'), 'LBR', 0, 'C', true);
		$this->Cell(80, 4, utf8_decode(''), 'LBR', 1, 'C', true);
		$this->SetFont('Arial','',7);
	}
  }
  
  public function Footer(){
    //Posición: a 1,5 cm del final (Siempre va en el footer)
    $this->SetY(-20);
    $this->SetFont('Arial','',7);
	if($_GET['opt'] == "H"){
		$this->Cell(140,4,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'L');
		$this->Cell(140,4,utf8_decode('* No se está considerando las atenciones ANULADAS'),0,1,'R');
	} else {
		$this->Cell(100,4,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'L');
		$this->Cell(93,4,utf8_decode('* No se está considerando las atenciones ANULADAS'),0,1,'R');
	}
  }
  
  public function Body() {

	$fecIni = $_GET['fecIni'];
	$fecFin = $_GET['fecFin'];
	$labIdDepUser = $_SESSION['labIdDepUser'];
	
	$param[0]['fecIniAte'] = $fecIni;
	$param[0]['fecFinAte'] = $fecFin;
	$param[0]['idDepAten'] = $labIdDepUser;
	
	$param[0]['chk_dep_procedencia'] = (empty($_GET['condicion_dep_procedencia'])) ? "" : "1";
	$param[0]['id_dep_procedencia'] = '';
	
	if(isset($_GET['chk_gestante'])){
		$param[0]['chk_gestante'] = $_GET['chk_gestante'];
		$param[0]['condicion_eg'] = $_GET['condicion_eg'];
		$param[0]['nro_eg'] = $_GET['nro_eg'];
		$param[0]['id_producto'] = $_GET['id_producto'];
		$param[0]['condicion_edad'] = $_GET['condicion_edad'];
		$param[0]['edad_desde'] = $_GET['edad_desde'];
		$param[0]['edad_hasta'] = $_GET['edad_hasta'];
		$param[0]['condicion_urgente'] = $_GET['condicion_urgente'];
		if(!empty($param[0]['chk_dep_procedencia'])){
			$param[0]['id_dep_procedencia'] = $_GET['id_dep_procedencia'];
		}
	} else {
		$param[0]['chk_gestante'] = "";
		$param[0]['condicion_eg'] = "";
		$param[0]['nro_eg'] = "";
		$param[0]['id_producto'] = "";
		$param[0]['condicion_edad'] = "";
		$param[0]['edad_desde'] = "";
		$param[0]['edad_hasta'] = "";
		$param[0]['condicion_urgente'] = "";
		$param[0]['origen_atencion'] = "";
		if(!empty($param[0]['chk_dep_procedencia'])){
			$param[0]['id_dep_procedencia'] = $_GET['id_dep_procedencia'];
		}
	}
	
	require_once '../../model/Atencion.php';
	$a = new Atencion();
	$rsC = $a->get_repDatosAtencion($param);
	$item = 0;
	$tot_sis = 0;
	$tot_pag = 0;
	$tot_est = 0;
	$tot_exo = 0;
	$tot_exa = 0;
	foreach ($rsC as $r) {
		$item ++;
		
		$producto = '';
		$rsP = $a->get_datosProductoPorIdAtencion($r['id']);
		foreach ($rsP as $rowP) {
			$tot_exa ++;
			$producto .= $rowP['nom_producto']. ', ';
		}
		$producto = substr(trim($producto), 0, -1);
		
		switch ($r['sigla_plan']) {
			case 'SIS':
				$tot_sis ++;
			break;
			case 'PAG':
				$tot_pag ++;
			break;
			case 'EST':
				$tot_est ++;
			break;
			case 'EX-T':
				$tot_exo ++;
			break;
		}
		
		if($_GET['opt'] == "H"){
			if($r['id_tipo_genera_correlativo'] == "1"){
				$nroAtencion = $r['nro_atencion']."-".$r['anio_atencion'];
			} else {
				$nroAtencion = substr($r['nro_atencion'], 0, 6).substr($r['nro_atencion'],6);
			}
			$this->Row(array(
				utf8_decode($item),
				utf8_decode($nroAtencion),
				utf8_decode($r['fec_atencion']),
				utf8_decode($r['fec_cita']),
				utf8_decode($r['nombre_rs']),
				utf8_decode($r['sigla_plan']),
				utf8_decode($r['nom_estadoresul']),
				utf8_decode($producto)
			));
		} else {
			if($r['id_tipo_genera_correlativo'] == "1"){
				$nroAtencion = $r['nro_atencion']."-".$r['anio_atencion'];
			} else {
				$nroAtencion = substr($r['nro_atencion'], 0, 6).substr($r['nro_atencion'],6);
			}
			$this->Row(array(
				utf8_decode($item),
				utf8_decode($nroAtencion),
				utf8_decode($r['fec_atencion']),
				utf8_decode($r['fec_cita']),
				utf8_decode($r['nombre_rs']),
				utf8_decode($r['sigla_plan']),
				utf8_decode($producto)
			));
		}
	}
	$this->Ln(2);
	$this->SetFont('Arial','B',7);
	$this->SetFillColor(180, 179, 179);
	if($_GET['opt'] == "H"){
		$this->Cell(24, 4, '', 0, 0, 'C', false);
		$this->Cell(24, 4, utf8_decode("Total atenciones"), 1, 0, 'C', true);
		$this->Cell(15, 4, $item, 1, 0, 'C', false);
		$this->Cell(24, 4, utf8_decode("Total SIS"), 1, 0, 'C', true);
		$this->Cell(15, 4, $tot_sis, 1, 0, 'C', false);
		$this->Cell(24, 4, utf8_decode("Total PAG"), 1, 0, 'C', true);
		$this->Cell(15, 4, $tot_pag, 1, 0, 'C', false);
		$this->Cell(24, 4, utf8_decode("Total EST-T"), 1, 0, 'C', true);
		$this->Cell(15, 4, $tot_est, 1, 0, 'C', false);
		$this->Cell(24, 4, utf8_decode("Total EXO"), 1, 0, 'C', true);
		$this->Cell(15, 4, $tot_exo, 1, 0, 'C', false);
		$this->Cell(24, 4, utf8_decode("Total Examenes"), 1, 0, 'C', true);
		$this->Cell(15, 4, $tot_exa, 1, 0, 'C', false);
	} else {
		$this->Cell(3, 4, '', 0, 0, 'C', false);
		$this->Cell(24, 4, utf8_decode("Total atenciones"), 1, 0, 'C', true);
		$this->Cell(10, 4, $item, 1, 0, 'C', false);
		$this->Cell(20, 4, utf8_decode("Total SIS"), 1, 0, 'C', true);
		$this->Cell(10, 4, $tot_sis, 1, 0, 'C', false);
		$this->Cell(20, 4, utf8_decode("Total PAG"), 1, 0, 'C', true);
		$this->Cell(10, 4, $tot_pag, 1, 0, 'C', false);
		$this->Cell(20, 4, utf8_decode("Total EST-T"), 1, 0, 'C', true);
		$this->Cell(10, 4, $tot_est, 1, 0, 'C', false);
		$this->Cell(20, 4, utf8_decode("Total EXO"), 1, 0, 'C', true);
		$this->Cell(10, 4, $tot_exo, 1, 0, 'C', false);
		$this->Cell(24, 4, utf8_decode("Total Examenes"), 1, 0, 'C', true);
		$this->Cell(10, 4, $tot_exa, 1, 0, 'C', false);
	}
  }
}
$pdf = new ReporteAtenciones();
if($_GET['opt'] == "H"){
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'C', 'C', 'L'));
	$pdf->SetWidths(array(7, 17, 16, 16, 70, 8, 20, 126));
} else {
	$pdf->SetAligns(array('C', 'C', 'C', 'C', 'L', 'C', 'L'));
	$pdf->SetWidths(array(7, 17, 16, 16, 50, 8, 80));
}



$pdf->SetAutoPageBreak(true, 20);
$pdf->SetMargins(8, 8, 8);
$pdf->AliasNbPages();
if($_GET['opt'] == "H"){
	$pdf->AddPage('L', 'A4');
} else {
	$pdf->AddPage('P', 'A4');
}
$pdf->Body();
$pdf->output();
?>
