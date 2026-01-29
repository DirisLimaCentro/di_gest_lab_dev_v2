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
					$pdf->Image('../../assets/images/logo_diris.png',10,4,50);
					$pdf->SetFont('Arial','',6);
					//Aubtitles
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(0,4,utf8_decode($rsA[0]['nom_depen']),0,1,'R');
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(0,3,utf8_decode('HC: '.$rsA[0]['nro_hcpac']),0,1,'R');

					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(40,2,'',0,1,'');
					$pdf->Cell(0,5,'SERVICIO DE LABORATORIO',0,1,'C');

					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(40,2,'',0,1,'');

					$pdf->Cell(22,4,'Paciente',0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(96,4, utf8_decode(': ' . $rsA[0]['nombre_rspac']),0,0,'');

					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(8,4,'Sexo',0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(5,4, utf8_decode(': ' . $rsA[0]['nom_sexopac']),0,1,'');

					if($rsA[0]['abrev_tipodocpac'] == "DNI"){
					  $naci = "PER";
					} else {
					  $naci = "EXT";
					}

					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(22,4,utf8_decode('Doc. Identificación'),0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(25,4, ': ' . $rsA[0]['abrev_tipodocpac'] .'-'. $rsA[0]['nro_docpac'] ,0,0,'');

					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(8,4,'Edad',0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(24,4,utf8_decode(': ' . $rsA[0]['edad_anio'] . ' AÑOS'),0,0,'');

					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(23,4,utf8_decode('Fecha atención'),0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(30,4,': '. $rsA[0]['fec_atencion'],0,1,'');

					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(22,4,utf8_decode('Nro. Atencion'),0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(25,4, utf8_decode(': ' . $rsA[0]['nro_atencion'] . "-" . $rsA[0]['anio_atencion']),0,0,'');


					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(11,4,utf8_decode('Atención'),0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(21,4,utf8_decode(': ' . $rsA[0]['abrev_plan']),0,0,'');

					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(23,4,utf8_decode(''),0,0,'');
					$pdf->SetFont('Arial','',7);
					$pdf->Cell(30,4,'       ',0,1,'');

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
							if($rowC['id_componente'] <> '98'){
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
								  switch($valColor){
									case "1":
									$pdf->SetFont('Arial','BI',7);
									$pdf->SetTextColor(255, 0, 0);
									$pdf->Cell(27,3,utf8_decode($valRes." *"),0,0,'C');
									break;
									case "2":
									$pdf->SetFont('Arial','BI',7);
									$pdf->SetTextColor(128, 0, 0);
									$pdf->Cell(27,3,utf8_decode($valRes." *"),0,0,'C');
									break;
									default:
									$pdf->SetFont('Arial','I',7);
									$pdf->Cell(27,3,utf8_decode($valRes),0,0,'C');
									break;
								  }
								  $pdf->SetFont('Arial','',6);
								  $pdf->SetTextColor(0, 0, 0);
								  $pdf->Cell(18,3,utf8_decode($rowC['uni_medida']),0,0,'C');
								  $pdf->SetFont('Arial','',6);
								  $pdf->MultiCell(30,3,utf8_decode(trim($totVal . " " . $valResDescrip)),0,'C','');//Este es el valor referencial
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
								if($cantG == $cnt_grupo){
									if($cantC <> $cnt_comp){
									  $pdf->SetTextColor(130, 130, 130);
									  $pdf->SetFont('Arial','',4);
									  $pdf->Cell(0,1,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -','',1,'');
									  $pdf->SetTextColor(0, 0, 0);
									}
								} else {
									$pdf->SetTextColor(130, 130, 130);
									$pdf->SetFont('Arial','',4);
									$pdf->Cell(0,1,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -','',1,'');
									$pdf->SetTextColor(0, 0, 0);
								}
							} else {
								if(trim($rowC['det_result']) <> ''){
									$pdf->SetFont('Arial','I',6);
									$pdf->Cell(8,3,utf8_decode($rowC['componente']).": ",0,0,'L');
									$pdf->SetTextColor(130, 130, 130);
									$pdf->SetFont('Arial','IB',6);
									$pdf->MultiCell(60,3,utf8_decode($rowC['det_result']),0,'L','');
								}				
							}
						}
					  }
				  $pdf->Ln(1);
				  $pdf->Cell(10,1,'','',0,'');
				  $pdf->Cell(50,1,'','B',0,'');
				  $pdf->Cell(12,1,'---','',0,'C');
				  $pdf->Cell(50,1,'','B',1,'');
				}
				
				
				
			}
		}
$pdf->Output();
?>
