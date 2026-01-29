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
$labIdDepUser_md5 = md5($labIdDepUser);

include '../../assets/lib/fpdf/fpdf.php';
include '../../assets/lib/qr/phpqrcode/qrlib.php';

require_once '../../model/Atencion.php';
$at = new Atencion();
require_once '../../model/Producton.php';
$pn = new Producton();
require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/Lab.php';
$la = new Lab();

$idAtencion = $_GET['valid'];
$idDependencia = $_GET['p'];

$rsA = $at->get_datosAtencion_md5($idAtencion, $idDependencia);
/*print_r($rsA);
exit();*/
$_GET['id_atencion'] = $rsA[0]['id'];
$idAtencion = $rsA[0]['id']; 

class PDF extends FPDF{
	//Cabecera de página
	function Header(){
		require_once '../../model/Atencion.php';
		$at = new Atencion();
		$idAtencion = $_GET['id_atencion'];
		$rsA = $at->get_datosAtencion($idAtencion);

		$this->SetTextColor(0, 0, 0);
		$this->Image('../../assets/images/logo_diris.png',13,7,83);
		$this->Image('../labrefen/logo_laboratorio_ref.jpeg',108,4,23);
		$this->Ln(19);
		$this->SetFont('Arial','B',12);
		$this->Cell(0,5,utf8_decode('LABORATORIO DE REFERENCIA'),0,1,'C');
		$this->Cell(0,5,utf8_decode('DE SALUD PÚBLICA'),0,1,'C');

		$this->SetFont('Arial','B',7);
		$this->Cell(40,2,'',0,1,'');

		$this->SetFont('Arial','B',7);
		$this->Cell(22,4,utf8_decode('Código'),0,0,'');
		$this->SetFont('Arial','',7);
		$this->Cell(45,4, utf8_decode(': ' . $rsA[0]['nro_atencion_manual']),0,0,'');//$rsA[0]['cod_ref_nro_atencion']
		$this->SetFont('Arial','B',7);
		$this->Cell(10,4,'Paciente',0,0,'');
		$this->SetFont('Arial','',7);
		$this->Cell(94,4, utf8_decode(': ' . $rsA[0]['nombre_rspac']),0,1,'');

		$this->SetFont('Arial','B',7);
		$this->Cell(22,4,utf8_decode('Fecha resultado'),0,0,'');
		$this->SetFont('Arial','',7);
		$this->Cell(45,4, '',0,0,'');
		//$this->Cell(45,4, ': ' . substr($rsA[0]['fec_cita'], 0, 10),0,0,'');
		$this->SetFont('Arial','B',7);
		$this->Cell(10,4,utf8_decode($rsA[0]['abrev_tipodocpac']),0,0,'');
		$this->SetFont('Arial','',7);
		$this->Cell(25,4, ': ' . $rsA[0]['nro_docpac'] ,0,0,'');
		$this->SetFont('Arial','B',7);
		$this->Cell(7,4,'Edad',0,0,'');
		$this->SetFont('Arial','',7);
		$this->Cell(15,4,utf8_decode(': ' . $rsA[0]['edad_anio']),0,1,'');

		$this->SetFont('Arial','B',7);
		$this->Cell(22,4,utf8_decode(''),0,0,'');
		$this->SetFont('Arial','',7);
		$this->Cell(45,4, '',0,0,'');
		$this->SetFont('Arial','B',7);
		$this->Cell(10,4,'Sexo',0,0,'');
		$this->SetFont('Arial','',7);
		$this->Cell(12,4, utf8_decode(': ' . $rsA[0]['nom_sexopac']),0,1,'');
		/*$this->SetFont('Arial','B',7);
		$this->Cell(20,4,utf8_decode('H.C.'),0,0,'R');
		$this->SetFont('Arial','',7);
		$this->Cell(10,4, utf8_decode(': ' . utf8_decode($rsA[0]['nro_hcpac'])),0,1,'');*/


		$this->SetFont('Arial','B',7);
		$this->Cell(22,4,utf8_decode('Procedencia'),0,0,'');
		$this->SetFont('Arial','',7);
		$this->Cell(97,4, utf8_decode(': ' . utf8_decode($rsA[0]['nom_depenori'])),0,0,'');
		//$pdf->Cell(19,4,utf8_decode('Nro. Atencion'),0,0,'');
		//$pdf->SetFont('Arial','',7);
		//$pdf->Cell(25,4, utf8_decode(': ' . $rsA[0]['nro_atencion'] . "-" . $rsA[0]['anio_atencion']),0,1,'');
		$this->Ln(5);

		$this->SetFont('Arial','B',10);
		$this->Cell(0,3,'',0,1,'');
		$this->Cell(0,5,utf8_decode('INMUNOLOGÍA'),1,1,'C');

		$this->Ln(2);
		$this->SetFont('Arial','IB',7);
		$this->Cell(65,4,utf8_decode('ANÁLISIS CLINICO'),0,0,'C');
		$this->Cell(27,4,utf8_decode('RESULTADO'),0,0,'C');
		$this->Cell(18,4,utf8_decode('U.M.'),0,0,'C');
		$this->Cell(30,4,utf8_decode('VALOR DE REFERENCIA'),0,1,'C');
	}

	//Pie de página
	function Footer(){
		$labNomUser = $_SESSION['labNomUser'];
		require_once '../../model/Atencion.php';
		$at = new Atencion();
		
		$this->SetY(-35);
		$this->Image("../labrefen/psa_visto_bueno_lab_ref.png",100,$this->GetY(),25);
		$rsHI = $at->get_datosfecHoraActual();
		$this->Ln(10);
		$this->SetFont('Arial','',5);
		$this->Cell(26,3,utf8_decode("FECHA Y HORA DE IMPRESIÓN"),0,0,'');
		$this->Cell(59,3," : ".$rsHI[0]['fechora_actual'] . " (".$labNomUser.")",0,0,'');
		
	}
}


//$pdf=new FPDF('L','mm','A4');
$pdf=new PDF('P','mm','A5');
//$pdf->SetLeftMargin(6);
$pdf->SetAutoPageBreak(true,35);
$pdf->SetMargins(5,4,5);
$pdf->AliasNbPages();

$esDengue = "NO";
$id_examen_resul = (int) 0;

$nomSexo = $rsA[0]['nom_sexopac'];
$edadAnio = $rsA[0]['edad_anio'];
$edadMes =  $rsA[0]['edad_mes'];
$edadDia =  $rsA[0]['edad_dia'];
$rsP = $at->get_datosProductoPorIdAtencion($idAtencion,0,'RV');
$pdf->AddPage();
foreach ($rsP as $rowP) {
	if(($rowP['id_producto'] == "50") Or ($rowP['id_producto'] == "92") Or ($rowP['id_producto'] == "83") Or ($rowP['id_producto'] == "80")){
		$esDengue = "SI";
		$id_examen_resul = $rowP['id_producto'];
	}
	
	$cnt_componente = (int)($pn->get_cntComponentePorIdProductoAndIdAtencion($idAtencion, $rowP['id_producto']));
	$pdf->Ln(1);

	$nom_producto = str_replace("TOMA DE MUESTRA ", "", $rowP['nom_producto']);
	$nom_producto = str_replace("PARA ", "", $nom_producto);
	if(strlen($nom_producto)<34){
		$pdf->SetFont('Arial','IB',9);
		$pdf->Cell(0,4,utf8_decode($nom_producto),0,0,'L');
	} else {
		$pdf->SetFont('Arial','IB',7);
		$pdf->Cell(0,4,utf8_decode($nom_producto),0,0,'L');
	}
	$pdf->Ln(3);
	$rsG = $pn->get_datosGrupoPorIdProductoAndidAtencion($idAtencion, $rowP['id_producto']);
	$muestra_entrelineas = "NO";
	$cnt_grupo = 0;
	$cantG = Count($rsG);
	foreach ($rsG as $rowG) {
	/*$rsCObs = $pn->get_datosSiTieneObsComponentePorIdGrupoProdAndIdAtencion($idAtencion, $rowP['id_producto'], $rowG['id']);
	if(isset($rsCObs[0]['det_result_obs'])) {
		if($rsCObs[0]['det_result_obs']<>"") {
			$muestra_entrelineas = "SI";
		}
	}*/
	  
	$cnt_grupo ++;
	if($rowG['nom_visible'] == "SI"){
		$pdf->Ln(2);
		$pdf->SetFont('Arial','IB',7);
		$pdf->Cell(0,4,utf8_decode($rowG['descripcion_grupo']),0,1,'L');
	}
	$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdAtencion($idAtencion, $rowP['id_producto'], $rowG['id']);
	$cnt_comp = 0;
	$cantC = Count($rsC);
			foreach ($rsC as $rowC) {
			if ($rowC['muestra_comp_vacio'] == "NO" && $rowC['det_result'] == ""){
			} else {
			$cnt_comp++;
			switch($rowC['id_tipo_val_ref']){
				case "2":
					if ($rowC['det_result'] == ""){
						$resulVRef = 0;
					}else {
						$resulVRef = $rowC['det_result'];
					}
				break;
				default:
					$resulVRef = 0;
				break;
			}
			$rsVC = $c->get_datosValidaValReferencialComp($rowC['id'], $rowC['id_tipo_val_ref'], $resulVRef, $edadAnio, $edadMes, $edadDia, $nomSexo);
			if($rowC['idtipo_ingresol'] == "1"){
			  $valMin = "";
			  $valMax = "";
			  $totVal = "";
			  $valRes = $rowC['det_result'];
			  $valResDescrip = $rowC['descrip_valref_metodo'];//Para la descripcion que se registro en los valores referenciales.
			  $valColor = "0";
			  switch($rowC['idtipocaracter_ingresul']){
				case "1":
				$totVal = $rowC['valor_ref'];
				break;
				case "2":
				$totVal = $rowC['valor_ref'];
				break;
				case "3":
				if(isset($rsVC[0]['liminf'])) {
					if($rsVC[0]['liminf'] <> "") {
					  $valMin = $rsVC[0]['liminf'];
					  $valMax = $rsVC[0]['limsup'];
					  if ($rsVC[0]['limsup'] == 99999){
							$totVal = "> " . number_format($rsVC[0]['liminf']);
					  } else {
							if ($rsVC[0]['liminf'] == -1){
							$totVal = "< " . number_format($rsVC[0]['limsup']);
							} else {
								$totVal = number_format($rsVC[0]['liminf']) . " - " . number_format($rsVC[0]['limsup']);
							}
					  }
					  if($rowC['chk_muestra_valref_especifico'] == 't'){
						$valResDescrip = $rsVC[0]['descripvalref'];
					  }
					  if($rowC['det_result'] <> ""){
						  $valRes = number_format($rowC['det_result']);
						  if($rowC['det_result'] < $valMin){
							$valColor = "1";
						  }
						  if($rowC['det_result'] > $valMax) {
							$valColor = "2";
						  }
					  }
					} else {
					  $totVal = $rowC['valor_ref'];
					}
				} else {
					$totVal = $rowC['valor_ref'];
				}
				break;
				case "4":
				if(isset($rsVC[0]['liminf'])){
				if($rsVC[0]['liminf'] <> "") {
				  $valMin = $rsVC[0]['liminf'];
				  $valMax = $rsVC[0]['limsup'];
				  if ($rsVC[0]['limsup'] == 99999){
					$totVal = "> " . number_format($rsVC[0]['liminf'], $rowC['detcaracter_ingresul'], '.', '');
				  } else {
					if ($rsVC[0]['liminf'] == -1){
						$totVal = "< " . number_format($rsVC[0]['limsup'], $rowC['detcaracter_ingresul'], '.', '');
					} else {
						$totVal = number_format($rsVC[0]['liminf'], $rowC['detcaracter_ingresul'], '.', '') . " - " . number_format($rsVC[0]['limsup'], $rowC['detcaracter_ingresul'], '.', '');	
					}
				  }
				  if($rowC['chk_muestra_valref_especifico'] == 't'){
					$valResDescrip = $rsVC[0]['descripvalref'];
				  }
				  if($rowC['det_result'] <> ""){
					  $valRes = number_format($rowC['det_result'], $rowC['detcaracter_ingresul'], '.', '');
					  if($rowC['det_result'] < $valMin){
						$valColor = "1";
					  }
					  if($rowC['det_result'] > $valMax) {
						$valColor = "2";
					  }
				  }
				} else {
				  $totVal = $rowC['valor_ref'];
				}
				} else {
					  $totVal = $rowC['valor_ref'];
					}
				break;
				default:
				$totVal = $rowC['valor_ref'];
				break;
			  }
	  
			  if($cnt_componente == 1){
				   if($nom_producto == $rowC['componente']){
					  $oldY = $pdf->getY();
					  $pdf->setY($oldY-3);
					  $pdf->SetFont('Arial','',7);
					  $pdf->Cell(65,3,'','',0,'L');
				  } else {
					$pdf->Cell(65,3,utf8_decode($rowC['componente']),'',0,'L');  
				  }
			  } else {
				   if($nom_producto == $rowC['componente']){
					  $oldY = $pdf->getY();
					  $pdf->setY($oldY-3);
					  $pdf->SetFont('Arial','',7);
					  $pdf->Cell(65,3,'','',0,'L');
				  } else {
						if($cnt_comp == 1){
							$pdf->Ln(1.5);
						}
						$pdf->SetFont('Arial','',7);
						if($rowC['id_componente'] == "98"){
							$pdf->SetFont('Arial','B',7);
							$pdf->Cell(10,3,utf8_decode($rowC['componente'] . ": "),'',0,'L');
							$pdf->SetFont('Arial','',7);
						} else {
							$pdf->Cell(65,3,utf8_decode($rowC['componente']),'',0,'L');
						}
				  }
			  }
			  switch($valColor){
				case "1":
				$pdf->SetFont('Arial','B',8);
				//$pdf->SetTextColor(255, 0, 0);
				$pdf->Cell(27,3,utf8_decode($valRes." *"),0,0,'C');
				break;
				case "2":
				$pdf->SetFont('Arial','BI',8);
				//$pdf->SetTextColor(128, 0, 0);
				$pdf->Cell(27,3,utf8_decode($valRes." *"),0,0,'C');
				break;
				default:
					if(($rowC['idtipocaracter_ingresul']==3) OR ($rowC['idtipocaracter_ingresul']==4)){
						$pdf->SetFont('Arial','I',8);
						$pdf->Cell(27,3,utf8_decode($valRes),0,0,'C');
					} else {
						$pdf->SetFont('Arial','I',7);
						$pdf->Cell(27,3,utf8_decode($valRes),0,0,'C');								
					}
				break;
			  }
			  $pdf->SetFont('Arial','',6);
			  $pdf->SetTextColor(0, 0, 0);
			  $pdf->Cell(18,3,utf8_decode($rowC['uni_medida']),0,0,'C');
			  
			  if($rowC['chk_muestra_valref_especifico'] == 't'){
				$valResDescrip = $totVal . " " . $valResDescrip;
			  }
			  
			  $pdf->SetFont('Arial','',6);
			  $pdf->MultiCell(30,3,utf8_decode(trim($valResDescrip)),0,'C','');//Este es el valor referencial
			} elseif ($rowC['idtipo_ingresol'] == "2") {  //Cuando es MultiCell
				if($rowC['id_componente'] == '159'){
					if (trim($rowC['det_result']) <> ""){
						$pdf->SetFont('Arial','',7);
						$pdf->Cell(65,4,utf8_decode($rowC['componente']),'',1,'L');
						$pdf->Cell(5,4,'','',0,'L');
						$pdf->MultiCell(130,4,utf8_decode($rowC['det_result']),0,'J','');
					}
				} else {
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(65,4,utf8_decode($rowC['componente']),'',1,'L');
					$pdf->Cell(5,4,'','',0,'L');
					$pdf->MultiCell(130,4,utf8_decode($rowC['det_result']),0,'J','');
				}
			} else { //Cuando es select
			  if($cnt_componente == 1){
				  if($nom_producto == $rowC['componente']){
					  $oldY = $pdf->getY();
					  $pdf->setY($oldY-3);
					  $pdf->SetFont('Arial','',7);
					  $pdf->Cell(65,3,'','',0,'L');
				  } else {
					$pdf->Cell(65,3,utf8_decode($rowC['componente']),'',0,'L');  
				  }
			  } else {
				   if($nom_producto == $rowC['componente']){
					  $oldY = $pdf->getY();
					  $pdf->setY($oldY-3);
					  $pdf->SetFont('Arial','',7);
					  $pdf->Cell(65,3,'','',0,'L');
				  } else {
						if($cnt_comp == 1){
							$pdf->Ln(1.5);
						}
						$pdf->SetFont('Arial','',7);
						$pdf->Cell(65,3,utf8_decode($rowC['componente']),'',0,'L');
				  }
			  }
				if($rowC['seleccion_resul_negrita'] == "SI"){
				  $pdf->SetFont('Arial','BU',7);
				} else {
				  $pdf->SetFont('Arial','',7);
				}
				$minuscula = $rowC['componente'];
				if((preg_match("/[g,q,p,y,j]/", $minuscula)) == "1"){
					$pdf->Cell(27,4,utf8_decode($rowC['nombreseleccion_resul']),0,1,'L');
				} else {
					$pdf->Cell(27,3,utf8_decode($rowC['nombreseleccion_resul']),0,1,'L');
				}

				$pdf->SetFont('Arial','',7);

			}
			$pdf->SetTextColor(130, 130, 130);
			$pdf->SetFont('Arial','',4);
			//$pdf->Cell(0,1,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -','',1,'');
			$pdf->ln(1);
			$pdf->SetTextColor(0, 0, 0);

		}
	}
	}
	$oldY = $pdf->getY();
	$pdf->setY($oldY-1);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(10,1,'','',0,'',True);
	$pdf->Cell(50,1,'','B',0,'',True);
	$pdf->Cell(12,1,'---','',0,'C',True);
	$pdf->Cell(50,1,'','B',0,'',True);
	$pdf->Cell(13,1,'','',1,'',True);

	if($esDengue == "SI"){
		$rsPROF = $la->get_datosProfesionalProcesaAndValida_dengue_labref($idAtencion, $id_examen_resul);
		/*print_r($rsPROF);
		exit();*/
		$pdf->ln(20);
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(40,4,utf8_decode("Verificado por: "),0,0,'R');
		$pdf->SetFont('Arial','',7);
		$rneResul = "";
		$rneValid = "";
		$nro_coleResul = "";
		$nro_coleValid = "";
		if($rsPROF[0]['nro_rneresul'] <> ""){
			$rneResul = " - RNE. " . $rsPROF[0]['nro_rneresul'];
		}
		if($rsPROF[0]['nro_rnevalid'] <> ""){
			$rneValid = " - RNE. " . $rsPROF[0]['nro_rnevalid'];
		}
		if($rsPROF[0]['nro_coleresul'] <> "0"){
			$nro_coleResul = " - " . $rsPROF[0]['abrev_coleprofesionresul'] . " " . $rsPROF[0]['nro_coleresul'];
		}
		if($rsPROF[0]['nro_colevalid'] <> "0"){
			$nro_coleValid = " - " . $rsPROF[0]['abrev_coleprofesionvalid'] . " " . $rsPROF[0]['nro_colevalid'];
		}
		$pdf->Cell(90,4,utf8_decode($rsPROF[0]['abrev_profesionvalid']. " " . $rsPROF[0]['nombre_profvalid'] . $nro_coleValid . $rneValid),0,1,'L');
		$pdf->ln(1);
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(40,4,utf8_decode("Análisis Realizado por: "),0,0,'R');
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(90,4,utf8_decode($rsPROF[0]['abrev_profesionresul']. " " . $rsPROF[0]['nombre_profresul'] . $nro_coleResul . $rneResul),0,1,'L');
		
		$pdf->SetY(39);
		$pdf->Cell(22,4,'',0,0,'');
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(45,4, ': ' . $rsPROF[0]['fec_validacion'],0,1,'');
	}
}

$pdf->Output();
?>
