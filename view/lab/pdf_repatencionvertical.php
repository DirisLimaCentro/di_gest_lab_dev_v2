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

$fecIni = $_GET['fecIni'];
$fecFin = $_GET['fecFin'];

class PDF extends FPDF
{
  //Cabecera de página
  function Header()
  {
    require_once '../../model/Dependencia.php';
    $d = new Dependencia();
	require_once '../../model/Producton.php';
    $prn = new Producton();

    //Logo
    $this->Image('../../assets/images/logo_diris.png',8,8,48);
	$rsD = $d->get_datosDepenendenciaPorId($_SESSION['labIdDepUser']);
    $this->SetFont('Arial','B',11);
    $this->Cell(0,7,utf8_decode($rsD[0]["nom_depen"]),0,1,'C');

    $this->Ln(2);
    $this->SetFont('Arial','B',8);
    $this->Cell(150,5,utf8_decode("REPORTE DE ATENCIONES EN LABORATORIO CLINICO"),0,0,'L');
	$this->SetFont('Arial','',8);
    $this->Cell(40,5,"Del: " . $_GET['fecIni'] . " al " . $_GET['fecFin'],0,1,'L');
	
	$condicion_eg = "";
	$eg = "ATENCIONES A GESTANTES";
	if ($_GET['chk_gestante'] <> "99") {
		if ($_GET['chk_gestante'] == 1) {
			if ($_GET['condicion_eg'] <> "") {
				if($_GET['condicion_eg'] == "<"){$condicion_eg = "CON EG MENOR A: " . $_GET['nro_eg'];}
				else if($_GET['condicion_eg'] == ">"){$condicion_eg = "CON EG MAYOR A: " . $_GET['nro_eg'];}
				else {$condicion_eg = "CON EG IGUAL A: " . $_GET['nro_eg'];}
				$eg = "ATENCIONES A GESTANTES, " . $condicion_eg;
			}
			$this->Cell(75,5,utf8_decode($eg),0,0,'L');
			if (!empty($_GET['edad_hasta'])) {
				$this->Cell(50,5,utf8_decode("Edad inicio: ". $_GET['edad_desde'] . " hasta " . $_GET['edad_hasta'] . " Años"),0,0,'L');
				$productos = "";
				if (!empty($_GET['id_producto'])) {
					$rsP = $prn->get_datosNombreProductoPorIdProductoMultiselect($_GET['id_producto']);
					foreach ($rsP as $row) {
						$productos.= $row['nom_producto'].",";
					}
					if($productos <> ""){
						$this->Cell(80,5,utf8_decode("Examen solicitado: " . $productos),0,1,'L');
					} else {
						$this->Cell(80,5,"",0,1,'L');
					}
				} else {
					$this->Cell(80,5,"",0,1,'L');
				}
			} else {
				$productos = "";
				if (!empty($_GET['id_producto'])) {
					$rsP = $prn->get_datosNombreProductoPorIdProductoMultiselect($_GET['id_producto']);
					foreach ($rsP as $row) {
						$productos.= $row['nom_producto'].",";
					}
					if($productos <> ""){
						$this->Cell(80,5,utf8_decode("Examen solicitado: " . $productos),0,1,'L');
					} else {
						$this->Cell(80,5,"",0,1,'L');
					}
				} else {
					$this->Cell(80,5,"",0,1,'L');
				}
			}
		} else {
			$eg = "ATENCIONES A NO GESTANTES";
			$this->Cell(55,5,utf8_decode($eg),0,0,'L');
			if (!empty($_GET['edad_hasta'])) {
				$this->Cell(50,5,utf8_decode("Edad inicio: ". $_GET['edad_desde'] . " hasta " . $_GET['edad_hasta'] . " Años"),0,0,'L');
				$productos = "";
				if (!empty($_GET['id_producto'])) {
					$rsP = $prn->get_datosNombreProductoPorIdProductoMultiselect($_GET['id_producto']);
					foreach ($rsP as $row) {
						$productos.= $row['nom_producto'].",";
					}
					if($productos <> ""){
						$this->Cell(80,5,utf8_decode("Examen solicitado: " . $productos),0,1,'L');
					} else {
						$this->Cell(80,5,"",0,1,'L');
					}
				} else {
					$this->Cell(80,5,"",0,1,'L');
				}
			} else {
				$productos = "";
				if (!empty($_GET['id_producto'])) {
					$rsP = $prn->get_datosNombreProductoPorIdProductoMultiselect($_GET['id_producto']);
					foreach ($rsP as $row) {
						$productos.= $row['nom_producto'].",";
					}
					if($productos <> ""){
						$this->Cell(80,5,utf8_decode("Examen solicitado: " . $productos),0,1,'L');
					} else {
						$this->Cell(80,5,"",0,1,'L');
					}
				} else {
					$this->Cell(80,5,"",0,1,'L');
				}
			}
		}
	} else {
		if (!empty($_GET['edad_hasta'])) {
			$this->Cell(50,5,utf8_decode("Edad inicio: ". $_GET['edad_desde'] . " hasta " . $_GET['edad_hasta'] . " Años"),0,0,'L');
			$productos = "";
			if (!empty($_GET['id_producto'])) {
				$rsP = $prn->get_datosNombreProductoPorIdProductoMultiselect($_GET['id_producto']);
				foreach ($rsP as $row) {
					$productos.= $row['nom_producto'].",";
				}
				if($productos <> ""){
					$this->Cell(80,5,utf8_decode("Examen solicitado: " . $productos),0,1,'L');
				} else {
					$this->Cell(80,5,"",0,1,'L');
				}
			} else {
				$this->Cell(80,5,"",0,1,'L');
			}
		} else {
			$productos = "";
			if (!empty($_GET['id_producto'])) {
				$rsP = $prn->get_datosNombreProductoPorIdProductoMultiselect($_GET['id_producto']);
				foreach ($rsP as $row) {
					$productos.= $row['nom_producto'].",";
				}
				if($productos <> ""){
					$this->Cell(80,5,utf8_decode("Examen solicitado: " . $productos),0,1,'L');
				} else {
					$this->Cell(80,5,"",0,1,'L');
				}
			} else {
				$this->Cell(80,5,"",0,1,'L');
			}
		}
	}
	
	
	

    $this->SetFont('Arial','B',7);
    $this->Cell(10, 4, utf8_decode('Item'), 'LTR', 0, 'C', false);
    $this->Cell(14, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('Fecha'), 'LTR', 0, 'C', false);
    $this->Cell(7, 4, utf8_decode('Plan'), 'LTR', 0, 'C', false);
    $this->Cell(22, 4, utf8_decode('N°'), 'LTR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode('H.C.'), 'LTR', 0, 'C', false);
    $this->Cell(80, 4, utf8_decode('Paciente'), 'LTR', 0, 'C', false);
    $this->Cell(7, 4, utf8_decode('Edad'), 'LTR', 0, 'C', false);
    $this->Cell(20, 4, utf8_decode('Resultado'), 'LTR', 1, 'C', false);


    $this->Cell(10, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(14, 4, utf8_decode('Atención'), 'LBR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(7, 4, utf8_decode('Tarif.'), 'LBR', 0, 'C', false);
    $this->Cell(22, 4, utf8_decode('Documento'), 'LBR', 0, 'C', false);
    $this->Cell(16, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(80, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(7, 4, utf8_decode(''), 'LBR', 0, 'C', false);
    $this->Cell(20, 4, utf8_decode(''), 'LBR', 1, 'C', false);

    //$this->Cell(0, 4, utf8_decode('Resultado'), 1, 1, 'C', false);
  }

  //Pie de página
  function Footer()
  {
    require_once '../../model/Atencion.php';
    $at = new Atencion();
	
    //Posición: a 1,5 cm del final (Siempre va en el footer)
    $this->SetY(-20);
    $this->SetFont('Arial','',7);
    $this->Cell(135,4,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'L');
	
    $this->Cell(24,5,utf8_decode("Fecha y hora reporte:"),0,0,'L');
	$rsHI = $at->get_datosfecHoraActual();
	$this->Cell(50,5,$rsHI[0]['fechora_actual'],0,1,'L');

  }
}

$pdf=new PDF('P','mm','A4');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,20); //Siempre cuando se va a poner el pie de página
$pdf->SetMargins(8,8,8);
$pdf->AliasNbPages();
$pdf->AddPage();

$param[0]['fecIniAte'] = $fecIni;
$param[0]['fecFinAte'] = $fecFin;
$param[0]['idDepAten'] = $labIdDepUser;
$param[0]['chk_gestante'] = $_GET['chk_gestante'];
$param[0]['condicion_eg'] = $_GET['condicion_eg'];
$param[0]['nro_eg'] = $_GET['nro_eg'];
$param[0]['id_producto'] = $_GET['id_producto'];
$param[0]['condicion_edad'] = $_GET['condicion_edad'];
$param[0]['edad_desde'] = $_GET['edad_desde'];
$param[0]['edad_hasta'] = $_GET['edad_hasta'];
$param[0]['condicion_urgente'] = $_GET['condicion_urgente'];

$rsC = $a->get_repDatosAtencion($param);
/*print_r($rsC);
exit();*/
$item = 0;
foreach ($rsC as $row) {
  $item ++;
  $pdf->SetFont('Arial','',7);
  $pdf->Cell(10, 4, $item, 'LBR', 0, 'C', false);
  $pdf->Cell(14, 4, $row['nro_atencion']."-".$row['anio_atencion'], 'BR', 0, 'C', false);
  $pdf->Cell(16, 4, utf8_decode($row['fec_atencion']), 'LBR', 0, 'C', false);
  $pdf->Cell(7, 4, utf8_decode($row['sigla_plan']), 'LBR', 0, 'C', false);
  $pdf->Cell(22, 4, utf8_decode($row['abrev_tipodoc']. ": ".$row['nrodoc']), 'LBR', 0, 'L', false);
  $pdf->Cell(16, 4, utf8_decode($row['nro_hc']), 'LBR', 0, 'C', false);
  $pdf->Cell(80, 4, utf8_decode($row['nombre_rs']), 'LBR', 0, 'L', false);
  $pdf->Cell(7, 4, utf8_decode($row['edad_pac']), 'LBR', 0, 'C', false);
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(20, 4, utf8_decode($row['nom_estadoresul']), 'LBR', 1, 'C', false);
}

if($item <= 25){
  $pdf->Ln(2);
  $pdf->Cell(30,1,'','',0,'');
  $pdf->Cell(60,1,'','B',0,'');
  $pdf->Cell(18,1,'******','',0,'C');
  $pdf->Cell(60,1,'','B',1,'');
}

$pdf->Output();
?>
