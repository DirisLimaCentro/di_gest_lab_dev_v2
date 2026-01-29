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
include '../../assets/lib/qr/phpqrcode/qrlib.php';

require_once '../../model/Atencion.php';
$at = new Atencion();
require_once '../../model/Producton.php';
$pn = new Producton();
require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/Lab.php';
$la = new Lab();

		class PDF extends FPDF{
			//Cabecera de página
			function Header(){
			}

			//Pie de página
			function Footer(){
				$labNomUser = $_SESSION['labNomUser'];
				require_once '../../model/Atencion.php';
				$at = new Atencion();
				
				$this->SetY(-35);
				$this->Image("./psa_visto_bueno_lab_ref.png",100,$this->GetY(),25);
				$rsHI = $at->get_datosfecHoraActual();
				$this->Ln(10);
				$this->SetFont('Arial','',5);
				$this->Cell(19,3,"FECHA DE IMPRESION",0,0,'');
				$this->Cell(59,3," : ".$rsHI[0]['fechora_actual'] . " (".$labNomUser.")",0,0,'');
				
			}
		}


		//$pdf=new FPDF('L','mm','A4');
		$pdf=new PDF('P','mm','A5');
		//$pdf->SetLeftMargin(6);
		$pdf->SetAutoPageBreak(true,35);
		$pdf->SetMargins(5,4,5);
		$pdf->AliasNbPages();

		$param[0]['id_envio'] = $_GET['id_envio'];
		$param[0]['id_estado'] = '4';
		$sWhere=""; $sOrder=""; $sLimit="";
		$rsL = $la->get_tblDatosIngResultadoPSA($sWhere, $sOrder, $sLimit, $param);
		//print_r($rsL);
		if(count($rsL) > 0){
			foreach ($rsL as $row) {
				$pdf->AddPage();
				$idAtencion = $row['id_atencion'];
				$idDependencia = $row['id_dependencia'];
				$idProducto = 60;//PSA
				
				

				$rsA = $at->get_datosAtencion($idAtencion, $idDependencia);
				/*print_r($rsA);
				exit();*/
				$_GET['id_atencion'] = $rsA[0]['id'];
				$idAtencion = $rsA[0]['id']; 

				$nomSexo = $rsA[0]['nom_sexopac'];
				$edadAnio = $rsA[0]['edad_anio'];
				$edadMes =  $rsA[0]['edad_mes'];
				$edadDia =  $rsA[0]['edad_dia'];
				$rsP = $at->get_datosProductoPorIdAtencion($idAtencion, $idProducto,'RV');
				/*print_r($rsP);
				exit();*/
				foreach ($rsP as $rowP) {
					$pdf->Image('../../assets/images/logo_diris.png',13,7,83);
					$pdf->Image('./logo_laboratorio_ref.jpeg',108,4,23);
					$pdf->Ln(19);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0,5,utf8_decode('LABORATORIO DE REFERENCIA'),0,1,'C');
					$pdf->Cell(0,5,utf8_decode('DE SALUD PÚBLICA'),0,1,'C');

					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(40,2,'',0,1,'');
					
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(22,4,utf8_decode('Código'),0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(45,4, utf8_decode(': ' . utf8_decode($row['cod_ref_nro_atencion'])),0,0,'');
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(10,4,'Paciente',0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(94,4, utf8_decode(': ' . $rsA[0]['nombre_rspac']),0,1,'');
					
					
					
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(22,4,utf8_decode('Fecha resultado'),0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(45,4, ': ' . substr($row['fecha_resultado'], 0, 10),0,0,'');
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(10,4,utf8_decode($rsA[0]['abrev_tipodocpac']),0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(25,4, ': ' . $rsA[0]['nro_docpac'] ,0,0,'');
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(7,4,'Edad',0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(15,4,utf8_decode(': ' . $rsA[0]['edad_anio']),0,1,'');
					
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(22,4,utf8_decode(''),0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(45,4, '',0,0,'');
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(10,4,'Sexo',0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(12,4, utf8_decode(': ' . $rsA[0]['nom_sexopac']),0,0,'');
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(20,4,utf8_decode('H.C.'),0,0,'R');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(10,4, utf8_decode(': ' . utf8_decode($rsA[0]['nro_hcpac'])),0,1,'');

					
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(22,4,utf8_decode('Procedencia'),0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(97,4, utf8_decode(': ' . utf8_decode($rsA[0]['nom_depen'])),0,0,'');
					//$pdf->Cell(19,4,utf8_decode('Nro. Atencion'),0,0,'');
					//$pdf->SetFont('Arial','',7);
					//$pdf->Cell(25,4, utf8_decode(': ' . $rsA[0]['nro_atencion'] . "-" . $rsA[0]['anio_atencion']),0,1,'');
					$pdf->Ln(5);

					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(0,3,'',0,1,'');
					$pdf->Cell(0,5,utf8_decode('INMUNOLOGÍA'),1,1,'C');
					
				  $pdf->Ln(2);
				  $pdf->SetFont('Arial','IB',7);
				  $pdf->Cell(65,4,utf8_decode('ANALISIS CLINICO'),0,0,'C');
				  $pdf->Cell(27,4,utf8_decode('RESULTADO'),0,0,'C');
				  $pdf->Cell(18,4,utf8_decode('U.M.'),0,0,'C');
				  $pdf->Cell(30,4,utf8_decode('VALOR DE REFERENCIA'),0,1,'C');

				  $cnt_componente = (int)($pn->get_cntComponentePorIdProductoAndIdAtencion($idAtencion, $rowP['id_producto']));
				  $cnt_componente = 2;
				
					  $pdf->Ln(1);
					  $rsG = $pn->get_datosGrupoPorIdProductoAndidAtencion($idAtencion, $rowP['id_producto']);
					  $cnt_grupo = 0;
					  $cantG = Count($rsG);
					  foreach ($rsG as $rowG) {
						$cnt_grupo ++;
						$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdAtencion($idAtencion, $rowP['id_producto'], $rowG['id']);
						if($rowG['nom_visible'] == "SI"){
							$pdf->Ln(2);
							$pdf->SetFont('Arial','IB',7);
							$pdf->Cell(0,4,utf8_decode($rowG['descripcion_grupo']),0,1,'L');
						}
						$cnt_comp = 0;
						$cantC = Count($rsC);
						foreach ($rsC as $rowC) {
							if($rowC['id_componente'] <> '159'){
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
								  $valResDescrip = "";//Para la descripcion que se registro en los valores referenciales.
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
										  $valResDescrip = $rsVC[0]['descripvalref'];
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
									  
									  $valResDescrip = $rsVC[0]['descripvalref'];
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
									   if($rowP['nom_producto'] == $rowC['componente']){
										  $oldY = $pdf->getY();
										  $pdf->setY($oldY-3);
										  $pdf->SetFont('Arial','',7);
										  $pdf->Cell(65,3,'','',0,'L');
									  } else {
										$pdf->SetFont('Arial','',7);
										$pdf->Cell(65,3,utf8_decode($rowC['componente']),'',0,'L');  
									  }
								  } else {
									  $pdf->SetFont('Arial','',7);
									  $pdf->Cell(65,3,utf8_decode($rowC['componente']),'',0,'L');
								  }
								  $pinta_obs_asterisco = 0;
								  switch($valColor){
									case "1":
									$pdf->SetFont('Arial','BI',7);
									//$pdf->SetTextColor(255, 0, 0);
									$pdf->Cell(27,3,utf8_decode(str_replace(".",",",$valRes)." *"),0,0,'C');
									$pinta_obs_asterisco = 1;
									break;
									case "2":
									$pdf->SetFont('Arial','BI',7);
									//$pdf->SetTextColor(128, 0, 0);
									$pdf->Cell(27,3,utf8_decode(str_replace(".",",",$valRes)." *"),0,0,'C');
									$pinta_obs_asterisco = 1;
									break;
									default:
									$pdf->SetFont('Arial','I',7);
									$pdf->Cell(27,3,utf8_decode(str_replace(".",",",$valRes)),0,0,'C');
									break;
								  }
								  $pdf->SetFont('Arial','',6);
								  $pdf->SetTextColor(0, 0, 0);
								  $pdf->Cell(18,3,utf8_decode($rowC['uni_medida']),0,0,'C');
								  $pdf->SetFont('Arial','',6);
								  $pdf->MultiCell(30,3,utf8_decode(trim(str_replace(".",",",$totVal) . "\n" . $valResDescrip)),0,'C','');//Este es el valor referencial
								} elseif ($rowC['idtipo_ingresol'] == "2") { //Cuando es textarea observación
								  $pdf->SetFont('Arial','',7);
								  $pdf->Cell(65,4,utf8_decode($rowC['componente']),'',1,'L');
								  $pdf->Cell(5,4,'','',0,'L');
								  $pdf->MultiCell(130,4,utf8_decode($rowC['det_result']),0,'J','');		
								} else {//Cuando es combo seleccion
								  if($cnt_componente == 1){
									   if($rowP['nom_producto'] == $rowC['componente']){
										  $oldY = $pdf->getY();
										  $pdf->setY($oldY-3);
										  $pdf->SetFont('Arial','',7);
										  $pdf->Cell(65,3,'','',0,'L');
									  } else {
										$pdf->SetFont('Arial','',7);
										$pdf->Cell(65,3,utf8_decode($rowC['componente']),'',0,'L');  
									  }
								  } else {
									  $pdf->SetFont('Arial','',7);
									  $pdf->Cell(65,3,utf8_decode($rowC['componente']),'',0,'L');
								  }
								  $pdf->SetFont('Arial','',6);
								  $pdf->Cell(27,3,utf8_decode($rowC['nombreseleccion_resul']),0,1,'L');
								}
								if(!empty($row['obs_doble_valid'])){
									$pdf->SetFont('Arial','',7);
									$pdf->Cell(65,4,utf8_decode('Observación:'),'',1,'L');
									$pdf->Cell(5,4,'','',0,'L');
									$pdf->MultiCell(130,4,utf8_decode($row['obs_doble_valid']),0,'J','');		
								}
								  
							}
						}
					  }
					  
				  $pdf->Ln(1);
				  $pdf->Cell(10,1,'','',0,'');
				  $pdf->Cell(50,1,'','B',0,'');
				  $pdf->Cell(12,1,'---','',0,'C');
				  $pdf->Cell(50,1,'','B',1,'');
				  
				  if($pinta_obs_asterisco == 1){
					  $pdf->Ln(2);
					  $pdf->SetFont('Arial','',6);
					  //$pdf->SetTextColor(255, 0, 0);
					  $pdf->Cell(0,3,'(*) Resultado fuera del valor de referencia',0,1,'R');
					  $pdf->SetTextColor(0, 0, 0);
				  }
				  
				  $pdf->Ln(25);
				  $pdf->SetFont('Arial','B',6);
				  $pdf->Cell(53,4,'Validado por:',0,0,'R');
				  $var = $row['fecha_resultado'];
				  $date = str_replace('/', '-', $var);
				  $date_re = date('Y-m-d', strtotime($date));
				  $date_termino = date('Y-m-d', strtotime('15-04-2023'));
				  
				  if($date_re < $date_termino){
					  $pdf->SetFont('Arial','',6);
					  $pdf->Cell(86,4,'    LIC. T.M. MIGUEL ANGEL PEREZ MALLQUI',0,1,'L');
					  $pdf->Ln(5);
					  $pdf->Image("./psa_firma_miguel_lab_ref.png",60,$pdf->GetY(),37);
				  } else {
					  $pdf->SetFont('Arial','',6);
					  $pdf->Cell(86,4,utf8_decode('    LIC. T.M. JANET DEL PILAR VICUÑA UBILLUS'),0,1,'L');
					  $pdf->Ln(5);
					  $pdf->Image("./psa_firma_janet_lab_ref.jpeg",60,$pdf->GetY(),43);					  
				  }
				}
				
				
				
			}
		}
$pdf->Output();
?>
