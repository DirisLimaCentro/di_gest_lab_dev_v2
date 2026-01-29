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
$labIdServicioUser = $_SESSION['labIdServicio'];
$labIdServicioDepUser = $_SESSION['labIdServicioDep'];

require_once '../model/Atencion.php';
$at = new Atencion();

require_once '../model/Componente.php';
$c = new Componente();

require_once '../model/Producton.php';
$pn = new Producton();

require_once '../model/Lab.php';
$la = new Lab();

require_once '../model/LabRef.php';
$lar = new LabRef();

function to_pg_array($set) {
  settype($set, 'array'); // can be called with a scalar or array
  $result = array();
  foreach ($set as $t) {
    if (is_array($t)) {
      $result[] = to_pg_array($t);
    } else {
      $t = str_replace('"', '\\"', $t); // escape double quote
      if (!is_numeric($t)) // quote only non-numeric values
      $t = '"' . $t . '"';
      $result[] = $t;
    }
  }
  return '{' . implode(",", $result) . '}'; // format
}

function to_pg_array_unique($set) {
  settype($set, 'array'); // can be called with a scalar or array
  $result = array();
  foreach ($set as $t) {
    if (is_array($t)) {
      $result[] = to_pg_array($t);
    } else {
      $t = str_replace('"', '\\"', $t); // escape double quote
      if (!is_numeric($t)) // quote only non-numeric values
      $t = '"' . $t . '"';
      $result[] = $t;
    }
  }
  return implode(",", $result); // format
}


if(isset($_POST['accion'])){

	switch ($_POST['accion']) {
	  case 'POST_REG_RESULTADOLAB':
		$valid_ingreso = "0";
		$i = (int) 0;
		$rsP = $at->get_datosProductoPorIdAtencion($_POST['id_atencion'], $_POST['txt_id_producto_selec'], 'R');
		foreach ($rsP as $rowP) {
			$rsG = $pn->get_datosGrupoPorIdProducto($rowP['id_producto'], 1);
			foreach ($rsG as $rowG) {
				$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdDependenciaActivo($rowG['id'], $labIdDepUser);
				foreach ($rsC as $rowC) {
					if (trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']) <> "") {
						$ingValor = 1;
					} else {
						$ingValor = 0;
					}
					
					if(trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']) <> ""){
						$idtipocaracter_ingresul = $rowC['idtipocaracter_ingresul'];
						switch($rowC['idtipo_ingresol']){
							case '1':
								if ($idtipocaracter_ingresul == "3" || $idtipocaracter_ingresul == "4"){
									//echo $rowC['idtipo_ingresol'] . "-" . $rowC['idtipocaracter_ingresul'] . "-" .$_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . ''] . "; ";
									if(!is_numeric(trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']))) {
										$valid_ingreso = "1";
									}
								}
								
							break;
							default:
							break;
						}
					}
					//							 id_producto  , id_productogrupo,   muestra grupo ,        orden grupo  ,id_productogrupocomp,id_metodocomponente 	, 		chk_muestra_metodo	  ,                       el id del valor referencial                   , si ing valor, texto_texbox_seleccion  ,            valor_ingresado                                       ,  id de seleccion que eligió  ,     orden componente  
					$reg_datos[$i] = array($rowP['id_producto'], $rowG['id'], $rowG['chk_muestra'], $rowG['orden_grupo'], $rowC['id'],  $rowC['id_metodocomponente'],  $rowC['chk_muestra_metodo'], $_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '_idval'],  $ingValor,   $rowC['idtipo_ingresol'], trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']), $rowC['idseleccion_ingresul'], $rowC['orden_componente']);
					$i ++;
				}
			}
		}
		if($valid_ingreso == "1"){
			echo "ER|Error al registrar el resultado, está ingresando texto en un campo de ingreso numérico.";
			exit();
		}
		$datos_producto[0] = array('');
		$paramReg[0]['accion'] = $_POST['accion_sp'];
		$paramReg[0]['id'] = $_POST['id_atencion'];
		$paramReg[0]['id_producto_selec'] = $_POST['txt_id_producto_selec'];
		$paramReg[0]['datos_producto'] = to_pg_array($datos_producto);
		$paramReg[0]['datos'] = to_pg_array($reg_datos);
		$paramReg[0]['obs'] = '';
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_resultado_laboratorio($paramReg);
		echo $rs;
	  break;
	  case 'POST_EDIT_RESULTADOLAB':
		$valid_ingreso = "0";
		$i = (int) 0;
		$rsP = $at->get_datosProductoPorIdAtencion($_POST['id_atencion'], $_POST['txt_id_producto_selec'], 'R');
		foreach ($rsP as $rowP) {
			$rsG = $pn->get_datosGrupoPorIdProductoAndidAtencion($_POST['id_atencion'], $rowP['id_producto']);
			if(count($rsG) == 0){
				$rsG = $pn->get_datosGrupoPorIdProducto($rowP['id_producto'], 1); /////
			}
			foreach ($rsG as $rowG) {
				$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdAtencion($_POST['id_atencion'], $rowP['id_producto'], $rowG['id']);
				if(count($rsC) == 0){
					$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdDependenciaActivo($rowG['id'], $_POST['id_dependencia']); //Aquí valida en editar si existe o coge esta funcion
				}
				foreach ($rsC as $rowC) {
					if (trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']) <> "") {
						$ingValor = 1;
					} else {
						$ingValor = 0;
					}
					if(trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']) <> ""){
						$idtipocaracter_ingresul = $rowC['idtipocaracter_ingresul'];
						switch($rowC['idtipo_ingresol']){
							case '1':
								if ($ingValor == 1){
									if ($idtipocaracter_ingresul == "3" || $idtipocaracter_ingresul == "4"){
										if(!is_numeric(trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']))) {
											$valid_ingreso = "1";
										}
									}
								}
							break;
							default:
							break;
						}
					}
					//							 id_producto  , id_productogrupo,   muestra grupo ,        orden grupo  ,id_productogrupocomp,id_metodocomponente 	, 		chk_muestra_metodo	  ,                       el id del valor referencial                   , si ing valor, texto_texbox_seleccion  ,            valor_ingresado                                       ,  id de seleccion que eligió  ,     orden componente  
					$reg_datos[$i] = array($rowP['id_producto'], $rowG['id'], $rowG['chk_muestra'], $rowG['orden_grupo'], $rowC['id'],  $rowC['id_metodocomponente'],  $rowC['chk_muestra_metodo'], $_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '_idval'],  $ingValor,   $rowC['idtipo_ingresol'], trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']), $rowC['idseleccion_ingresul'], $rowC['orden_componente']);
					$i ++;
				}
			}
		}
		
		if($valid_ingreso == "1"){
			echo "ER|Error al registrar el resultado, está ingresando texto en un campo de ingreso numérico.";
			exit();
		}
		$datos_producto[0] = array('');
		$paramReg[0]['accion'] = $_POST['accion_sp'];
		$paramReg[0]['id'] = $_POST['id_atencion'];
		$paramReg[0]['id_producto_selec'] = $_POST['txt_id_producto_selec'];
		$paramReg[0]['datos_producto'] = to_pg_array($datos_producto);
		$paramReg[0]['datos'] = to_pg_array($reg_datos);
		$paramReg[0]['obs'] = '';
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_resultado_laboratorio($paramReg);
		echo $rs;
	  break;
	  case 'POST_EDIT_RESULTADOLABVALIDADO':
		$valid_ingreso = "0";
		$i = (int) 0;
		$rsP = $at->get_datosProductoPorIdAtencion($_POST['id_atencion'], $_POST['txt_id_producto_selec'], 'RV');
		foreach ($rsP as $rowP) {
			$rsG = $pn->get_datosGrupoPorIdProductoAndidAtencion($_POST['id_atencion'], $rowP['id_producto']);
			if(count($rsG) == 0){
				$rsG = $pn->get_datosGrupoPorIdProducto($rowP['id_producto'], 1); /////
			}
			foreach ($rsG as $rowG) {
				$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdAtencion($_POST['id_atencion'], $rowP['id_producto'], $rowG['id']);
				if(count($rsC) == 0){
					$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdDependenciaActivo($rowG['id'], $_POST['id_dependencia']); //Aquí valida en editar si existe o coge esta funcion
				}
				foreach ($rsC as $rowC) {
					if (trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']) <> "") {
						$ingValor = 1;
					} else {
						$ingValor = 0;
					}
					if(trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']) <> ""){
						$idtipocaracter_ingresul = $rowC['idtipocaracter_ingresul'];
						switch($rowC['idtipo_ingresol']){
							case '1':
								if ($ingValor == 1){
									if ($idtipocaracter_ingresul == "3" || $idtipocaracter_ingresul == "4"){
										if(!is_numeric(trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']))) {
											$valid_ingreso = "1";
										}
									}
								}
							break;
							default:
							break;
						}
					}
					
					//$rsVC = $c->get_datosValidaValReferencialComp($rowC['id'], $rowC['id_tipo_val_ref'], $resulVRef, $_POST['edadAnio'], $_POST['edadMes'], $_POST['edadDia'], $_POST['nomSexo']);
					//							 id_producto  , id_productogrupo,   muestra grupo ,        orden grupo  ,id_productogrupocomp,id_metodocomponente 	, 		chk_muestra_metodo	  ,                       el id del valor referencial                   , si ing valor, texto_texbox_seleccion  ,            valor_ingresado                                       ,  id de seleccion que eligió  ,     orden componente  
					$reg_datos[$i] = array($rowP['id_producto'], $rowG['id'], $rowG['chk_muestra'], $rowG['orden_grupo'], $rowC['id'],  $rowC['id_metodocomponente'],  $rowC['chk_muestra_metodo'], $_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '_idval'],  $ingValor,   $rowC['idtipo_ingresol'], trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']), $rowC['idseleccion_ingresul'], $rowC['orden_componente']);
					$i ++;
				}
			}
		}
		
		if($valid_ingreso == "1"){
			echo "ER|Error al registrar el resultado, está ingresando texto en un campo de ingreso numérico.";
			exit();
		}
		$paramReg[0]['accion'] = $_POST['accion_sp'];
		$paramReg[0]['id'] = $_POST['id_atencion'];
		$paramReg[0]['id_producto_selec'] = $_POST['txt_id_producto_selec'];
		$paramReg[0]['datos'] = to_pg_array($reg_datos);
		$paramReg[0]['obs'] = $_POST['descrip_edit_valid'];
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_resultado_laboratorio($paramReg);
		echo $rs;
	  break;
	  case 'POST_REG_RESULTADOLABSINMUESTRA':
		$valid_ingreso = "0";
		$a = (int) 0;
		$i = (int) 0;
		if ($_POST['origen_procesa'] == "deri") {//Cuando registro desde derivación
			$rsP = $at->get_datosProductoPorIdAtencion($_POST['id_atencion'], $_POST['txt_id_producto_selec'], 'MD', '2');
		} else {
			$rsP = $at->get_datosProductoPorIdAtencion($_POST['id_atencion'], $_POST['txt_id_producto_selec'], 'MNR', '1');
		}
		foreach ($rsP as $rowP) {
			//$rsG = $pn->get_datosGrupoPorIdProducto($rowP['id_producto'], 1);
			$rsG = $pn->get_datosGrupoPorIdProductoAndidAtencion($_POST['id_atencion'], $rowP['id_producto']);
			if(count($rsG) == 0){
				$rsG = $pn->get_datosGrupoPorIdProducto($rowP['id_producto'], 1); /////
			}
			foreach ($rsG as $rowG) {
				//$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdDependenciaActivo($rowG['id'], $labIdDepUser);
				$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdAtencion($_POST['id_atencion'], $rowP['id_producto'], $rowG['id']);
				if(count($rsC) == 0){
					$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdDependenciaActivo($rowG['id'], $_POST['id_dependencia']); //Aquí valida en editar si existe o coge esta funcion
				}
				foreach ($rsC as $rowC) {
					if (trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']) <> "") {
						$ingValor = 1;
					} else {
						$ingValor = 0;
					}
					
					if(trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']) <> ""){
						$idtipocaracter_ingresul = $rowC['idtipocaracter_ingresul'];
						switch($rowC['idtipo_ingresol']){
							case '1':
								if ($idtipocaracter_ingresul == "3" || $idtipocaracter_ingresul == "4"){
									//echo $rowC['idtipo_ingresol'] . "-" . $rowC['idtipocaracter_ingresul'] . "-" .$_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . ''] . "; ";
									if(!is_numeric(trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']))) {
										$valid_ingreso = "1";
									}
								}
								
							break;
							default:
							break;
						}
					}
					//							 id_producto  , id_productogrupo,   muestra grupo ,        orden grupo  ,id_productogrupocomp,id_metodocomponente 	, 		chk_muestra_metodo	  ,                       el id del valor referencial                   , si ing valor, texto_texbox_seleccion  ,            valor_ingresado                                       ,  id de seleccion que eligió  ,     orden componente  
					$reg_datos[$i] = array($rowP['id_producto'], $rowG['id'], $rowG['chk_muestra'], $rowG['orden_grupo'], $rowC['id'],  $rowC['id_metodocomponente'],  $rowC['chk_muestra_metodo'], $_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '_idval'],  $ingValor,   $rowC['idtipo_ingresol'], trim($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id'] . '']), $rowC['idseleccion_ingresul'], $rowC['orden_componente'], $_POST['txt_' . $rowP['id_producto'] . '_fecha_valid']);
					$i ++;
				}
			}
			$datos_producto[$i] = array($rowP['id_producto'], $_POST['txt_' . $rowP['id_producto'] . '_fecha'], $_POST['txt_' . $rowP['id_producto'] . '_fecha_valid']);
			$a ++;
		}
		if($valid_ingreso == "1"){
			echo "ER|Error al registrar el resultado, está ingresando texto en un campo de ingreso numérico.";
			exit();
		}
		$paramReg[0]['accion'] = $_POST['accion_sp'];
		$paramReg[0]['id'] = $_POST['id_atencion'];
		$paramReg[0]['id_producto_selec'] = $_POST['txt_id_producto_selec'];
		$paramReg[0]['datos_producto'] = to_pg_array($datos_producto);
		$paramReg[0]['datos'] = to_pg_array($reg_datos);
		$paramReg[0]['obs'] = $_POST['id_usuario_resul']."|".$_POST['id_usuario_valid']."|".$_POST['id_usuario_sello']."|".$_POST['origen_procesa'];
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		if ($_POST['accion_sp'] == "I"){
			$rs = $la->reg_resultado_laboratorio_procesado($paramReg);
		} else {
			$rs = $la->reg_resultado_laboratorio_validado($paramReg);
		}
		echo $rs;
	  break;
	  case 'POST_ADD_REGCNTEXAMENPORMESANIO':
		$datos[0] = array($labIdDepUser, $_POST['id_producto'], $_POST['anio'], $_POST['mes'], $_POST['cnt_sis_producto'], $_POST['cnt_pag_producto'], $_POST['cnt_est_producto'], $_POST['cnt_exo_producto'], $_POST['cnt_total']);
		if($_POST['id_cnt_prod_mes'] == "0"){
			$accion = "I";
		} else {
			$accion = "A";
		}
		$paramReg[0]['accion'] = $accion;
		$paramReg[0]['id'] = $_POST['id_cnt_prod_mes'];
		$paramReg[0]['datos'] = to_pg_array($datos);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_producto_cantidad_mensual($paramReg);
		echo $rs; 
	  break;
	  case 'POST_DELET_REGCNTEXAMENPORMESANIO':
		$datos[0] = array('');
		$paramReg[0]['accion'] = "D";
		$paramReg[0]['id'] = $_POST['id_cnt_prod_mes'];
		$paramReg[0]['datos'] = to_pg_array($datos);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_producto_cantidad_mensual($paramReg);
		echo $rs; 
	  break;
	  case 'POST_ADD_CAMBIAENCARGADOTURNO':
		$reg_datos[0] = array($_POST['id_usuario_sello']);
		$paramReg[0]['accion'] = 'AE';//Actualiza encargado
		$paramReg[0]['id'] = $_POST['id_atencion'];
		$paramReg[0]['datos'] = to_pg_array($reg_datos);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_cambia_profesional_encargado_turno($paramReg);
		echo $rs; 
	  break;
	  case 'POST_ADD_REGENVIO':
		$nroArrayS = (int) 0;
		$id_producto_atencion = explode(",", $_POST['id_producto_atencion']);
		
		foreach ($id_producto_atencion as $clave => $valor){
			$datos_productoaten[$nroArrayS] = array($valor, '');
			$nroArrayS ++;
		}
		$datos_cabecera[0] = array($labIdDepUser, $_POST['id_destino'], $_POST['id_producto']);
		$paramReg[0]['accion'] = 'IEN';
		$paramReg[0]['id'] = 0;
		$paramReg[0]['datos_cabecera'] = to_pg_array_unique($datos_cabecera);
		$paramReg[0]['datos'] = to_pg_array($datos_productoaten);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_envio($paramReg);
		echo $rs; 
	  break;

	case 'POST_DETALLE_EXAMEN_ENVIADO':
		$rs = $la -> datos_detalle_examen_derivado($_POST['id']);
		if ($rs) {
			$datos = array(
			  "lbl_dependencia" => $rs['dependencia_origen'],
			  "abrev_tipodoc_pac" => $rs['abrev_tipodoc_pac'],
			  "nrodoc_pac" => $rs['nrodoc_pac'],
			  "pais_nac_pac" => $rs['pais_nac_pac'],
			  "primer_ape_pac" => $rs['primer_ape_pac'],
			  "segundo_ape_pac" => $rs['segundo_ape_pac'],
			  "nombre_pac" => $rs['nombre_pac'],
			  "nombre_completo_pac" => $rs['nombre_completo_pac'],
			  "fec_nac_pac" => $rs['fec_nac_pac'],
			  "sexo_pac" => $rs['sexo_pac'],
			  "fec_cita" => $rs['fec_cita'],
			  "producto" => $rs['producto']
			);
		}
		echo json_encode($datos);
	/*	$opt = ($_POST['interfaz_origen'] == "LAB") ? '3' : '4';
	
		$rs = $p->get_datosDetallePersonaUltimaAtencionPorIdDed($opt, $_POST['id_atencion'], '','');//Opcion 2 es por documento  y 1 por idpersona, 3:paciente lab, 4paciente pap
		$nr = count($rs);
		if ($nr > 0) {
			if($rs[0]['fec_nac'] == ""){
			  $fecNacPac = "";
			} else {
			  $fecNacPac = date_create($rs[0]['fec_nac']);
			  $fecNacPac = date_format($fecNacPac, "d/m/Y");
			}
			if($labIdDepUser == "67"){
				if(trim($rs[0]['nro_hc']) == ""){
					$nro_hc = "00";
				} else {
					$nro_hc = trim($rs[0]['nro_hc']); 
				}
			} else {
				$nro_hc = trim($rs[0]['nro_hc']);
			}
			$datos = array(
			  0 => $rs[0]['id_persona'],
			  1 => $rs[0]['id_tipodoc'],
			  2 => $rs[0]['abrev_tipodoc'],
			  3 => $rs[0]['nrodoc'],
			  4 => $rs[0]['nombre_rs'],
			  5 => $rs[0]['primer_ape'],
			  6 => trim($rs[0]['segundo_ape']),
			  7 => $rs[0]['id_sexo'],
			  8 => $rs[0]['abrev_sexo'],
			  9 => $fecNacPac,
			  10 => $nro_hc,
			  11 => trim($rs[0]['nro_telfijo']),
			  12 => trim($rs[0]['nro_telmovil']),
			  13 => trim($rs[0]['email']),
			  14 => trim($rs[0]['id_ubigeo']),
			  15 => trim($rs[0]['departamento']),
			  16 => trim($rs[0]['provincia']),
			  17 => trim($rs[0]['distrito']),
			  18 => trim($rs[0]['direccion']),
			  19 => trim($rs[0]['referencia_dir']),
			  20 => trim($rs[0]['edad']),
			  21 => trim($rs[0]['id_paisnac']),
			  22 => trim($rs[0]['id_etnia']),
			  23 => 'SISTEMA'
			);
			echo json_encode($datos);
		}*/
	break;

 	case 'POST_CLASIFICA_EXAMEN_ENVIADO':
		if ($_POST['accion_sp'] == "ACEPTAR"){
			$accion_sp = "AM";
			$id = Null;
			$nroArrayS = (int) 0;
			$id_envio = explode(",", $_POST['id']);
			
			foreach ($id_envio as $clave => $valor){
				$datos_envio[$nroArrayS] = array($valor);
				$nroArrayS ++;
			}
			$paramReg[0]['datos_cabecera'] = Null;
			$paramReg[0]['datos'] = to_pg_array($datos_envio);

		} else if ($_POST['accion_sp'] == "RECHAZAR"){
			$accion_sp = "RM";
			$id = $_POST['id'];
			$datos_cabecera[0] = array($_POST['id_motivo_rechazo'], $_POST['motivo_rechazo']);
			$paramReg[0]['datos_cabecera'] = to_pg_array_unique($datos_cabecera);
			$paramReg[0]['datos'] = Null;

		}  else if ($_POST['accion_sp'] == "ENV_PROCESO"){
			$accion_sp = "EP";
			$id = $_POST['id'];
			$paramReg[0]['datos_cabecera'] = Null;
			$paramReg[0]['datos'] = Null;
		} 
		$paramReg[0]['accion'] = $accion_sp;
		$paramReg[0]['id'] = $id;
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_envio($paramReg);
		echo $rs; 
	  break;

	  case 'POST_RECEPCION_ENVIO_EXAMEN':
		$datos_cabecera[0] = array('');
		$datos_productoaten[0] = array('');
		$paramReg[0]['accion'] = 'RME';//Recepción muestra envío
		$paramReg[0]['id'] = $_POST['id_envio'];
		$paramReg[0]['datos_cabecera'] = to_pg_array($datos_cabecera);
		$paramReg[0]['datos'] = to_pg_array($datos_productoaten);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_envio($paramReg);
		echo $rs; 
	  break;
	  case 'POST_ADD_REGENVIOOBSOACEPTARDET':
		$nroArrayS = (int) 0;
		$idSolicitud = explode(",", $_POST['txtIdEnvDet']);
		foreach ($idSolicitud as $clave => $valor){
			$datos_productoaten[$nroArrayS] = array($valor, $_POST['txtIdEstEnvDet'], $_POST['txtDetObsEstEnvDet']);
			$nroArrayS ++;
		}
		$datos_cabecera[0] = array('');
		if($_POST['txtTipoOpe'] == "1"){
			$accion = "NOSE"; //Rechazar
		} else if ($_POST['txtTipoOpe'] == "2"){
			$accion = "RECHAZA"; //Rechazar
		} else if ($_POST['txtTipoOpe'] == "AO"){
			$accion = "SUBSANA"; //De observado a Rechazado
		} else if ($_POST['txtTipoOpe'] == "RO"){
			$accion = "RECHAZA"; //De adecuado a Rechazado
		} else {
			$accion = "ACEPTA"; //Aceptar
		}

		$paramReg[0]['accion'] = $accion;//Recepción muestra envío
		$paramReg[0]['id'] = $_POST['id_envio'];
		$paramReg[0]['datos_cabecera'] = to_pg_array($datos_cabecera);
		$paramReg[0]['datos'] = to_pg_array($datos_productoaten);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_envio($paramReg);
		echo $rs;
	  break;
	  case 'CARGA_ARCHIVO_RESUL_PSA':
        $result = ["error" => "", "row" => []];
		$url = __DIR__ . "/../view/labrefen/psa/";
		$newfilename = date("YmdHis").".xls";
		if (move_uploaded_file($_FILES['file']['tmp_name'], $url . $newfilename)) {
			$change_tipo="export HOME=/var/www/html/di_gest_lab_dev/view/labrefen/psa/ && libreoffice --headless --convert-to csv:'Text - txt - csv (StarCalc)':124,34,UTF8 --infilter=CSV:124,34,UTF8 /var/www/html/di_gest_lab_dev/view/labrefen/psa/". $newfilename ." --outdir /var/www/html/di_gest_lab_dev/view/labrefen/psa/";
			exec($change_tipo);
			//Espero un segundo para 
			sleep(1);
			
			$arrnom_file = explode(".", $newfilename);
			$file_name = $arrnom_file[0] . ".csv";
			
			$csv_file = fopen($url . $file_name, 'r');
			$id =  (int)0;
			$itemcabe =  (int)0;
			$itemdet = (int)0;
			$fila =  (int)1;
			while(($datos = fgetcsv($csv_file)) !== FALSE){ //Esto es el actual
				//print_r($datos[0]);
				$datos1 = explode("|", $datos[0]);
				if(!empty(trim($datos1[1]))){
					if($fila > 1){
					//print_r($datos1[1]);
					//				  1.nro_registro, 2.fec_tomamuestra,3.fec_recepcion, 4.tipo_doc_pac, 5.nro_doc_pac, 6.nombre_pac, 7.primer_ape_pac, 8.segundo_ape_pac,  9.fecha_nac_pac,  10.nro_celular_pac, 11.fecha_resultado, 12.resultado, 13.tipo_doc_prof, 14.nro_doc_prof,  15.nombre_prof, 16.codigo_establecimiento, 17.nombre_establecimiento, 18.archivo_carga,    19.archivo_ori
					$arr_datos[$id] = array($datos1[1],   $datos1[2],      $datos1[2],    $datos1[7],       $datos1[8],   $datos1[9],       ''        ,        ''       ,      $datos1[11]   ,    $datos1[10],         $datos1[4],     $datos1[12],      '',             $datos1[5],       $datos1[6],         $datos1[17],                $datos1[18],         $newfilename,   $_FILES['file']['name']);
					$id ++;
					}
				}
				$fila ++;
			}
			fclose($csv_file);
			$paramReg[0]['accion'] = 'IC';
			$paramReg[0]['id'] = null;
			$paramReg[0]['datos'] = to_pg_array($arr_datos);
			$paramReg[0]['userIngreso'] = $labIdUser;
			/*print_r($paramReg);
			exit();*/
			$rs = $lar->post_reg_psa($paramReg);
			echo $rs;
			/*while(($datos = fgetcsv($csv_file)) !== FALSE){ //Esto es de la empresa 2023
				//print_r($datos[0]);
				$datos1 = explode("|", $datos[0]);
				//print_r($datos1[16]);
				if(!empty(trim($datos1[16]))){
					if(trim($datos1[16])<>"Procedencia"){
						if(trim($datos1[14])<>""){
															  //EESS,   , Nº Registro,       DNI,  Fecha Infor , Resultado  , Rutina/Repido
							//$datos_cabecera[$id] = array($datos1[16], $datos1[7], $datos1[8], $datos1[14], $datos1[12],  $datos1[18]);
							$resultado = $datos1[12];
							//print_r($datos1[8]."|".$datos1[12]."<br/>");//DNI y resultado para validar
							$id_producto = 60;//PSA
							//$datos_cabecera[$id] = array($datos1[8], $id_producto, trim($datos1[16]));
							$rsA = $la->get_ObtenerDatosAtencionPSA($datos1[8], $id_producto, trim($datos1[16]));//$nrodoc, $id_producto, $nom_dep_excel
							if(count($rsA) > 0){
								$idAtencion = $rsA[0]['id_atencion'];
								$edadAnio = $rsA[0]['edad_anio'];
								$edadMes = $rsA[0]['edad_mes'];
								$edadDia = $rsA[0]['edad_dia'];
								$nomSexo = $rsA[0]['id_sexopac'];
								
								$datos_cabecera[$itemcabe] = array($idAtencion, $id_producto, $datos1[7], 0, '', trim($datos1[14]));
								
								$rsG = $pn->get_datosGrupoPorIdProductoAndidAtencion($idAtencion, $id_producto); //Aquí validará si existe o no existe en la tabla detresultado
								if(count($rsG) == 0){
									$rsG = $pn->get_datosGrupoPorIdProducto($id_producto, 1); /////
								}
								$psa_u_obs = 0;//Psa u observación
								foreach ($rsG as $rowG) {
									$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdAtencion($idAtencion, $id_producto, $rowG['id']);
									if(count($rsC) == 0){
										$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdDependenciaActivo($rowG['id'], 67); //Aquí valida en editar si existe o coge esta funcion //ID GRUPO , ID DEP ESTE CASO LAB REFERENCIAL
									}

									//print_r($rsC);
									foreach ($rsC as $rowC) {
										$id_valor_referencial = "";
										$rsVC = $c->get_datosValidaValReferencialComp($rowC['id'], 1, 0, $edadAnio, $edadMes, $edadDia, $nomSexo);
										//print_r($rowC['id']."|".$rowC['id_metodocomponente']."|0|".$edadAnio."|".$edadMes."|".$edadDia."|".$nomSexo);
										if($rsVC > 1){
											if(isset($rsVC[0]['idcompvalref'])){
												$id_valor_referencial = $rsVC[0]['idcompvalref'];
											}
										}
										$ingValor = 1;
										if($psa_u_obs == 0){
											//					   id_producto  , id_productogrupo,   muestra grupo ,   orden grupo  ,id_productogrupocomp,  id_metodocomponente 	, 	chk_muestra_metodo, el id del valor referencial, si ing valor, texto_texbox_seleccion  , valor_ingresado,id de seleccion que eligió,orden componente 
											$datos_productoaten[$itemdet] = array($id_producto, $rowG['id'], $rowG['chk_muestra'], $rowG['orden_grupo'], $rowC['id'],  $rowC['id_metodocomponente'],  $rowC['chk_muestra_metodo'], $id_valor_referencial,  $ingValor,   $rowC['idtipo_ingresol'], trim($resultado), $rowC['idseleccion_ingresul'], $rowC['orden_componente'], $idAtencion);
											$psa_u_obs++;
										} else {
											//					 				  id_producto  , id_productogrupo,   muestra grupo ,   orden grupo  ,id_productogrupocomp,  id_metodocomponente 	, 	chk_muestra_metodo,   el id del valor referencial,si ing valor,texto_texbox_seleccion, valor_ingresado,id de seleccion que eligió,  orden componente 
											$datos_productoaten[$itemdet] = array($id_producto, $rowG['id'], $rowG['chk_muestra'], $rowG['orden_grupo'], $rowC['id'],  $rowC['id_metodocomponente'],  $rowC['chk_muestra_metodo'], $id_valor_referencial,  0,   $rowC['idtipo_ingresol'],     trim(''),     $rowC['idseleccion_ingresul'], $rowC['orden_componente'], $idAtencion);
										}
										$itemdet ++;
										
									}
								}
								$itemcabe++;
							}
						$id++;
						}
					}
				}
			}*/
			//$datos_cabecera[0] = array('');
			//$datos_productoaten[0] = array('');
			/*$paramReg[0]['accion'] = 'IREXCELPSA';//Ingresa resultado EXCEL
			$paramReg[0]['id'] = 0;
			$paramReg[0]['datos_cabecera'] = to_pg_array($datos_cabecera);
			$paramReg[0]['datos'] = to_pg_array($datos_productoaten);
			$paramReg[0]['userIngreso'] = $labIdUser;
			/*print_r($paramReg);
			exit();*/
			/*$rs = $la->reg_envio($paramReg);
			echo $rs;*/
		} else {
			$result["error"] = $_FILES['file']['name'].", Error al intentar cargar el archivo.";
		}
        return $result;
	  break;
	  case 'POST_ADD_RESULPSA':
	    $result = ["error" => "", "row" => []];
		$id_producto = 60;//PSA
		$itemdet = 0;
		$rsA = $at->get_datosAtencion($_POST['id_atencion']);
		if(count($rsA) > 0){
			$idAtencion = $rsA[0]['id'];
			$edadAnio = $rsA[0]['edad_anio'];
			$edadMes = $rsA[0]['edad_mes'];
			$edadDia = $rsA[0]['edad_dia'];
			$nomSexo = $rsA[0]['id_sexopac'];
			
			$datos_cabecera[0] = array($idAtencion, $id_producto, $_POST['codigo_ref_lab'], 1, $_POST['obs_det_resultado'], $_POST['fecha_resultado']);
			$rsG = $pn->get_datosGrupoPorIdProductoAndidAtencion($idAtencion, $id_producto); //Aquí validará si existe o no existe en la tabla detresultado
			if(count($rsG) == 0){
				$rsG = $pn->get_datosGrupoPorIdProducto($id_producto, 1); /////
			}
			foreach ($rsG as $rowG) {
				$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdAtencion($idAtencion, $id_producto, $rowG['id']);
				if(count($rsC) == 0){
					$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdDependenciaActivo($rowG['id'], 67); //Aquí valida en editar si existe o coge esta funcion //ID GRUPO , ID DEP ESTE CASO LAB REFERENCIAL
				}
				foreach ($rsC as $rowC) {
					$id_valor_referencial = "";
					$rsVC = $c->get_datosValidaValReferencialComp($rowC['id'], 1, 0, $edadAnio, $edadMes, $edadDia, $nomSexo);
					//print_r($rowC['id']."|".$rowC['id_metodocomponente']."|0|".$edadAnio."|".$edadMes."|".$edadDia."|".$nomSexo);
					if($rsVC > 1){
						if(isset($rsVC[0]['idcompvalref'])){
							$id_valor_referencial = $rsVC[0]['idcompvalref'];
						}
					}
					$ingValor = 1;
					if($itemdet == 0){
						//					   id_producto  , id_productogrupo,   muestra grupo ,   orden grupo  ,id_productogrupocomp,  id_metodocomponente 	, 	chk_muestra_metodo, el id del valor referencial, si ing valor, texto_texbox_seleccion  , valor_ingresado,id de seleccion que eligió,orden componente 
						$datos_productoaten[$itemdet] = array($id_producto, $rowG['id'], $rowG['chk_muestra'], $rowG['orden_grupo'], $rowC['id'],  $rowC['id_metodocomponente'],  $rowC['chk_muestra_metodo'], $id_valor_referencial,  $ingValor,   $rowC['idtipo_ingresol'], trim($_POST['det_resultado']), $rowC['idseleccion_ingresul'], $rowC['orden_componente'], $_POST['id_atencion']);
					} else {
						//					   id_producto  , id_productogrupo,   muestra grupo ,   orden grupo  ,id_productogrupocomp,  id_metodocomponente 	, 	chk_muestra_metodo, el id del valor referencial, si ing valor, texto_texbox_seleccion  , valor_ingresado,id de seleccion que eligió,orden componente 
						$datos_productoaten[$itemdet] = array($id_producto, $rowG['id'], $rowG['chk_muestra'], $rowG['orden_grupo'], $rowC['id'],  $rowC['id_metodocomponente'],  $rowC['chk_muestra_metodo'], $id_valor_referencial,  0,   $rowC['idtipo_ingresol'], '', $rowC['idseleccion_ingresul'], $rowC['orden_componente'], $_POST['id_atencion']);						
					}
					$itemdet ++;
				}
			}
		}
		$paramReg[0]['accion'] = 'IREXCELPSA';//Ingresa resultado EXCEL
		$paramReg[0]['id'] = 0;
		$paramReg[0]['datos_cabecera'] = to_pg_array($datos_cabecera);
		$paramReg[0]['datos'] = to_pg_array($datos_productoaten);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_envio($paramReg);
		echo $rs;
	  break;
	  case 'POST_ADD_VALIDRESULPSA':
		$nroArrayS = (int) 0;
		$idSolicitud = explode(",", $_POST['txtIdEnvDet']);
		foreach ($idSolicitud as $clave => $valor){
			$datos_productoaten[$nroArrayS] = array($valor,0,'','');
			$nroArrayS ++;
		}
		$datos_cabecera[0] = array('');
		$paramReg[0]['accion'] = 'VALIDPSA';//Valida resultado PSA
		$paramReg[0]['id'] = 0;
		$paramReg[0]['datos_cabecera'] = to_pg_array($datos_cabecera);
		$paramReg[0]['datos'] = to_pg_array($datos_productoaten);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_envio($paramReg);
		echo $rs;
	  break;
	  case 'POST_ADD_VALIDRESULPSAUNICO':
		$datos_cabecera[0] = array('');
		$datos_productoaten[0] = array($_POST['id_atencion'], 1, trim($_POST['det_resultado']), $_POST['obs_det_resultado']);//id_atencion: En realidad es el codigo txtIdEnvDet
		$paramReg[0]['accion'] = 'VALIDPSA';//Valida resultado PSA
		$paramReg[0]['id'] = 0;
		$paramReg[0]['datos_cabecera'] = to_pg_array($datos_cabecera);
		$paramReg[0]['datos'] = to_pg_array($datos_productoaten);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_envio($paramReg);
		echo $rs;
	  break;
	  Case "GET_SHOW_DATOSATENCION":
		$rs = $at->get_datosAtencion($_POST['id']);
		?>
		<div class="modal-dialog modal-xs">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <h2 class="modal-title">DATOS ATENCIÓN</h2>
			</div>
			<div class="modal-body">
			  <div class="row">
				<div class="col-sm-12">
				  <?php
				  if($labIdDepUser == "67"){
					  $nroAtencion = $rs[0]['nro_atencion_manual'];
				  } else {
						if($rs[0]['id_tipo_genera_correlativo'] == "1"){
							$nroAtencion = "<b>".$rs[0]['nro_atencion'] . "-". $rs[0]['anio_atencion']."</b>";
						} else {
							$nroAtencion = substr($rs[0]['nro_atencion'], 0, 6)."<b>".substr($rs[0]['nro_atencion'],6)."</b>";
						}
				  }
				  echo '<dt>Número de atención:</dt>';
				  echo "<h2 class='text-center' style='margin-top: 2px;'>". $nroAtencion. "</h2>";
				  echo '<dt>Apellidos y nombres de la paciente:</dt>';
				  echo "<h4 style='margin-top: 2px;'>".$rs[0]['nombre_rspac'] . "</h4>";
				  if (($_SESSION['labIdRolUser'] == "1") Or ($_SESSION['labIdRolUser'] == "5") Or ($_SESSION['labIdRolUser'] == "14") Or ($_SESSION['labIdRolUser'] == "15") Or ($_SESSION['labIdRolUser'] == "2") Or ($_SESSION['labIdRolUser'] == "16")){
				  ?>
				  <div class="btn-group btn-group-justified">
					<a href="#" class="btn btn-info btn-lg" onclick="event.preventDefault(); reg_resultado(<?php echo $_POST['id'];?>)"><i class="fa fa-file-text-o"></i> Ingresar resultado</a>
					<a href="#" class="btn btn-primary btn-lg" onclick="event.preventDefault(); recargar_pag_reg()"><i class="glyphicon glyphicon-plus"></i> Registrar Nueva atención</a>
				  </div>
				  <hr/>
				  <div class="btn-group btn-group-justified">
					<a href="#" class="btn btn-success" onclick="event.preventDefault(); expor_atenciones_hoy('<?php echo date("d/m/Y")?>','<?php echo $labIdDepUser?>')"><i class="glyphicon glyphicon-open"></i> Ver atenciones ingresadas</a>
				  </div>
				  <?php } ?>
				  <?php 
					if (($_SESSION['labIdRolUser'] == "3") Or ($_SESSION['labIdRolUser'] == "17")){
				  ?>
				  <div class="btn-group btn-group-justified">
					<a href="#" class="btn btn-primary btn-lg" onclick="event.preventDefault(); recargar_pag_reg()"><i class="glyphicon glyphicon-plus"></i> Registrar Nueva atención</a>
					<a href="#" class="btn btn-success btn-lg" onclick="event.preventDefault(); expor_atenciones_hoy('<?php echo date("d/m/Y")?>','<?php echo $labIdDepUser?>')"><i class="glyphicon glyphicon-open"></i> Ver atenciones ingresadas</a>
				  </div>
				  <?php } ?>
				</div>
			  </div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-12 text-center">
						<a href="#" class="btn btn-default" onclick="event.preventDefault(); back()"><i class="glyphicon glyphicon-log-out"></i> Salir del formulario</a>
					</div>
				</div>
			</div>
		  </div>
		</div>
		<?php
	  break;
	  case 'POST_SHOW_REFERENCIAANDFUAPORIDATENCION':
		$rs = $la->get_datosDetalleReferenciaAndFUA($_POST['id_atencion']);
		$nr = count($rs);
		if ($nr > 0) {
			$nro_fua = 0;
			if(trim($rs[0]['id_fua']) <> ""){
					$nro_fua = $rs[0]['id_fua'];
			}
			$primer_nom = "";
			$segundo_nom = "";
			if($rs[0]['id_formato_generado'] == "1"){
				$nombre_array = explode(" ", trim($rs[0]['nombre_pac']));
				if(count($nombre_array) == 2){
					$primer_nom = $nombre_array[0]; // porción1
					$segundo_nom = $nombre_array[1]; // porción2
				} else {
					$primer_nom = $rs[0]['nombre_pac'];
				}
			} else {
				$primer_nom = trim($rs[0]['primer_nombrepac_fua']);
				$segundo_nom = trim($rs[0]['otro_nombre_fua']);
			}
			$datos = array(
				0 => trim($rs[0]['id_atencion']),
				1 => $nro_fua,
				2 => trim($rs[0]['id_formato_generado']),
				3 => trim($rs[0]['descrip_formato_generado']),
				4 => trim($rs[0]['codref_depen']),
				5 => trim($rs[0]['nom_depen']),
				6 => trim($rs[0]['nro_refdepenori']),
				7 => trim($rs[0]['anio_refdepenori']),
				8 => trim($rs[0]['id_depenori']),
				9 => trim($rs[0]['nom_depenori']),
				10 => trim($rs[0]['nro_contraref']),
				11 => trim($rs[0]['anio_contraref']),
				12 => trim($rs[0]['id_regimen_contraref']),
				13 => trim($rs[0]['nom_regimen_contraref']),
				//Aquí empieza FUA
				14 => trim($rs[0]['nro_fua']),
				15 => trim($rs[0]['anio_fua']),
				16 => trim($rs[0]['fua_id_tipodoc']),
				17 => trim($rs[0]['nro_docpac']),
				18 => trim($rs[0]['cod_diresa_fua']),
				19 => trim($rs[0]['id_tiposis']),
				20 => trim($rs[0]['nombre_tiposis']),
				21 => trim($rs[0]['nro_sis']),
				22 => trim($rs[0]['primer_apepac']),
				23 => trim($rs[0]['segundo_apepac']),
				24 => trim($rs[0]['nombre_pac']),
				25 => $primer_nom,
				26 => $segundo_nom,
				27 => trim($rs[0]['id_sexopac']),
				28 => trim($rs[0]['fec_nacpac']),
				29 => trim($rs[0]['check_gestante']),
				30 => trim($rs[0]['edad_gestacional']),
				31 => trim($rs[0]['fecha_prob_parte']),
				32 => trim($rs[0]['nro_hcpac']),
				33 => trim($rs[0]['nom_etniapac']),
				34 => trim($rs[0]['fechora_atencion']),
				35 => trim($rs[0]['id_codigo_prestacional']),
				36 => trim($rs[0]['cod_referencial']),
				37 => trim($rs[0]['nombre_cod_referencial']),
				38 => trim($rs[0]['id_cie_fua']),
				39 => trim($rs[0]['nom_cie_fua']),
				40 => trim($rs[0]['user_encargado_lab']),
				41 => trim($rs[0]['id_user_responsable_aten']),
				42 => trim($rs[0]['nro_docresponsable_aten']),
				43 => trim($rs[0]['nombre_docresponsable_aten']),
				44 => trim($rs[0]['codref_depenori'])
			);
		} else {
			$datos = array(
				0 => 'NE'
			);
		}
		echo json_encode($datos);
	  break;
	  case 'POST_ADD_REGREFERENCIAFUA':
		if($_POST['accion_sp'] == "F"){
			$datos_ref[0] = array('');
			$datos_fua[0] = array($_POST['fua_primer_nom'], $_POST['fua_otro_nom'], $_POST['fua_cod_diresa'], $_POST['fua_nro'], $_POST['fua_anio'], $_POST['id_tipo_sis'], $_POST['nro_sis'], $_POST['fua_id_cod_prestacional'], $_POST['fua_id_cie'], $_POST['fua_chk_gestante'], $_POST['fua_edad_gest'], $_POST['fua_fecha_parto'], $_POST['id_resp_atencion']);
		} else {
			$datos_ref[0] = array($_POST['nro_ref'], $_POST['anio_ref'], $_POST['id_dep_origen'], $_POST['nro_contraref'], $_POST['anio_contraref'], $_POST['id_regimen'], $_POST['chk_tiene_fua'], $_POST['id_resp_atencion']);
			$datos_fua[0] = array($_POST['fua_primer_nom'], $_POST['fua_otro_nom'], $_POST['fua_cod_diresa'], $_POST['fua_nro'], $_POST['fua_anio'], $_POST['id_tipo_sis'], $_POST['nro_sis'], $_POST['fua_id_cod_prestacional'], $_POST['fua_id_cie'], $_POST['fua_chk_gestante'], $_POST['fua_edad_gest'], $_POST['fua_fecha_parto']);
		}
		
		$paramReg[0]['accion'] = $_POST['accion_sp'];
		$paramReg[0]['id_atencion'] = $_POST['id_atencion'];
		$paramReg[0]['id'] = $_POST['id_fua'];
		$paramReg[0]['datos_ref'] = to_pg_array($datos_ref);
		$paramReg[0]['datos_fua'] = to_pg_array($datos_fua);
		$paramReg[0]['userIngreso'] = $labIdUser;
		/*print_r($paramReg);
		exit();*/
		$rs = $la->reg_referencia_fua($paramReg);
		echo $rs; 
	  break;
	  case 'SHOW_CALENDARIOPORMESYANIO':
		$anio = $_POST['anio'];
		$mes = $_POST['mes'];

		$nombresDias = array("Do","Lu","Ma","Mi","Ju","Vi","Sa");
		
		$cant_dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

		echo "<table class=\"table table-striped table-bordered table-hover\"><tr>";
		$contador_fecha = 0;
		$rsP = $la->get_CantidadFechaCitadosPorAnioMes($labIdDepUser,$anio,$mes);
		//print_r($rsP);
		for ($i = 1; $i <= $cant_dias_mes; $i++) {
			$fecha_for = $anio . "-" . str_pad($mes,2,"0", STR_PAD_LEFT) . "-" . str_pad($i,2,"0", STR_PAD_LEFT);
			$fecha_dmY =  str_pad($i,2,"0", STR_PAD_LEFT) . "/" . str_pad($mes,2,"0", STR_PAD_LEFT) . "/" . $anio;
			$contador_fecha	++;
			$nom_dia = $nombresDias[date('w', strtotime($fecha_for))];
			
			$key = array_search($fecha_for, array_column($rsP, 'fecha_cita'));
			
			echo "<td class=\"text-center\">";
				echo $nom_dia . " - " . str_pad($i,2,"0", STR_PAD_LEFT);
				if ($key !== FALSE){
					echo "<br/><span class='label bg-blue'>".$rsP[$key]['ctn_total']."</span> <span class='label bg-green'>".$rsP[$key]['atendidos']."</span> <span class='label bg-yellow'>".$rsP[$key]['pendientes']."</span>";
					if ($_POST['origen'] == "REG"){
						echo " <span style='cursor: pointer;' class='fa fa-arrow-circle-right' onclick=\"obtener_nroatencion('" . $fecha_dmY . "',2);\"></span>";
					}
				} else {
					echo "<br/><span class='label fc-event bg-aqua'>Libre</span>";
					if ($_POST['origen'] == "REG"){
						echo " <span style='cursor: pointer;' class='fa fa-arrow-circle-right' onclick=\"obtener_nroatencion('" . $fecha_dmY . "',2);\"></span>";
					}
				}
			echo "</td>";
			if(($nom_dia=='Do')){ echo "</tr>";}
			if(($nom_dia=='Do')){ echo "<tr>";}
			
		}
		echo "</tr></table>";
	  break;
	  case 'REG_IMPRIME_TICKET':
	  
		$impresora = $labIdDepUser."_diagnostica2";
		$rs = $la->get_datosTicket_id_atencion($_POST['id_atencion']);
$cod_zpl='^XA
^LH0,0
^FO10,15^ADN,10,10^FD' . $rs['apellidos_pac'] . ' ' . $rs['nombres_pac'] . '^FS
^FO10,35^ADN,10,10^FD' . $rs['tipo_documento_pac'] . '. ' . $rs['numero_documento_pac'] . '  Sexo: ' . $rs['sexo_pac'] . '  Edad: ' . $rs['edad_anio_pac'] . '^FS

^FO35,185^ACN,20,15^FA20^FD' . $rs['numero_orden'] . $rs['codigo_sufijo_muestra'] . '^FS
^BY2,3,200
^FO35,75^BCN,100,N,Y,N^FD' . $rs['numero_orden'] . $rs['codigo_sufijo_muestra'] . '^FS ^FO50,210^AC1,15,5^FA20^FD' . $rs['fecha_atencion'] . '      ' . $rs['sufijo_muestra'] . '^FS
^XZ';
	//print_r($cod_zpl); exit();
	  	$rsT = $la->reg_imprime_ticket('DIAG', $_POST['id_atencion'], $impresora, $rs['numero_orden'], $cod_zpl, $rs['codigo_sufijo_muestra']);
		echo $rsT;
	  break;
	}
	
} else {
	
	switch ($_GET['accion']) {
	  case "GET_MEDICO_POR_EESS":
		$rs = $la->get_datosMedicoPorIdDependencia($labIdDepUser, $_GET['term']);
		echo json_encode($rs);
	  break;
	  case 'GET_SHOW_LISTATIPORECHAZOENV':
		$rs = $la->get_listaTipoRechazadoEnvio($_GET['id_producto'], $_GET['id_tiporechazo']);
		echo json_encode($rs);
	  break;
	  case 'GET_SHOW_DETALLERECHAZOMUESTRA':
		if(!isset($_GET['id_enviodet'])){
			$rs = $la->get_datosRechazoMuestraPorIdEnvAndIdDetEnv($_GET['id_envio']);
			foreach ($rs as $row) {
				?>
				<div class="pad">
					<div class="callout callout-info" style="margin-bottom: 0 !important; padding: 10px 30px 15px 5px !important;">
						<h4 style="margin-bottom: 2px;"><?php echo "(" . $row['abrev_tipodocpac'] . ": " . $row['nro_docpac'] . ") " . $row['nombre_rspac']?></h4>
						<h4><small><?php echo $row['descrip_rechazo'];?></small></h4>
						<span><?php echo nl2br($row['det_rechazo']);?></span>
					</div>
				</div>
				<?php
			}
		} else {
			$rs = $la->get_datosRechazoMuestraPorIdEnvAndIdDetEnv($_GET['id_envio'], $_GET['id_enviodet']);
			$nr = count($rs);
			if ($nr > 0) {
				$datos = array(
				0 => $rs[0]['id_detenv'],
				1 => $rs[0]['tipo_rechazo'],
				2 => $rs[0]['descrip_rechazo'],
				3 => $rs[0]['det_rechazo']
				);
				echo json_encode($datos);
			} else {
				$datos = array(
				0 => '0'
				);
			}
		}
	  break;
	}
	
}
?>
