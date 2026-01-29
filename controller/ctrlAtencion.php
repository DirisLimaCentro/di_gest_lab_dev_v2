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
$labIdTipoCorrelativo = (isset($_SESSION['labIdTipoCorrelativo']))? $_SESSION['labIdTipoCorrelativo'] : '1';

require_once '../model/Area.php';
$a = new Area();
require_once '../model/Componente.php';
$c = new Componente();
require_once '../model/Producto.php';
$p = new Producto();
require_once '../model/Atencion.php';
$at = new Atencion();
require_once '../model/Tarifa.php';
$t = new Tarifa();

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

switch ($_POST['accion']) {
  case 'POST_ADD_REGSOLICITUD':
		$arr_paciente[0] = array($_POST['txtIdPer'], $_POST['txtIdTipDoc'], $_POST['txtNroDoc'], trim($_POST['txtNomPac']), trim($_POST['txtPriApePac']), trim($_POST['txtSegApePac']), $_POST['txtIdSexoPac'], trim($_POST['txtFecNacPac']), trim($_POST['txtNroTelFijoPac']), trim($_POST['txtNroTelMovilPac']), trim($_POST['txtEmailPac']), trim($_POST['txtNroHC']), trim($_POST['txtUBIGEOPac']), $_POST['txtIdAvDirPac'], trim($_POST['txtNomAvDirPac']), trim($_POST['txtNroDirPac']), trim($_POST['txtIntDirPac']), trim($_POST['txtDptoDirPac']), trim($_POST['txtMzDirPac']), trim($_POST['txtLtDirPac']), $_POST['txtIdPoblaDirPac'], trim($_POST['txtNomPoblaDirPac']), trim($_POST['txtDirPac']), trim($_POST['txtDirRefPac']), $_POST['txtIdPaisNacPac'], $_POST['txtIdEtniaPac']);
		$arr_solicitante[0] = array($_POST['txtIdSoli'], $_POST['txtIdTipDocSoli'], $_POST['txtNroDocSoli'], trim($_POST['txtNomSoli']), trim($_POST['txtPriApeSoli']), trim($_POST['txtSegApeSoli']), $_POST['txtIdSexoSoli'], trim($_POST['txtFecNacSoli']), trim($_POST['txtNroTelFijoSoli']), trim($_POST['txtNroTelMovilSoli']), trim($_POST['txtEmailSoli']), $_POST['txtIdPaisNacSoli']);
		$arr_atencion[0] = array($_POST['txtIdPlanTari'], $_POST['txtFechaAten'], $_POST['txtIdTipAtencion'], $_POST['txtIdServicio'], $_POST['txtIdDepRef'], trim($_POST['txtNroRefDep']), trim($_POST['txtAnioRefDep']), $_POST['txtFechaPedido'], $_POST['txtNombreMedico'], $_POST['txtIdParenSoli'], $_POST['txtAtenUrgente'], $_POST['txtPersonalSalud'], $_POST['txtSubTotal'], $_POST['txtPorDescuentoMonto'], $_POST['txtDescuentoMonto'], $_POST['txtTotalMonto'], $_POST['txtIdGestante'], $_POST['txtEdadGest'], $_POST['txtFechaParto'], $_POST['txtPesoPac'], $_POST['txtTallaPac'],'','');
		$arr_fua[0] = array('');
		$nroArrayCpt = (int) 0;
		if($_POST['txtIdProducto'] <> ""){
			$idCpt = explode(",", $_POST['txtIdProducto']);
			foreach ($idCpt as $clave=>$valor){
			  //echo "El valor de $clave es: $valor";
			  $detCpt = explode("_", $valor);
			  $arr_producto[$nroArrayCpt] = array($detCpt[0], $detCpt[1], $_POST['txtPorDescuentoMonto']);
			  $nroArrayCpt ++;
			}
		} else {
			$arr_producto[0] = array('');
		}
		$arr_detatencion[0] = array('');
		if($_POST['txtIdAtencion'] == "0"){
			$action = "S";
		} else {
			$action = "E";
		}
		$paramReg[0]['accion'] = $action;
		$paramReg[0]['id'] = $_POST['txtIdAtencion'];
		$paramReg[0]['paciente'] = to_pg_array($arr_paciente);
		$paramReg[0]['solicitante'] = to_pg_array($arr_solicitante);
		$paramReg[0]['atencion'] = to_pg_array($arr_atencion);
		$paramReg[0]['fua'] = to_pg_array($arr_fua);
		$paramReg[0]['producto'] = to_pg_array($arr_producto);		
		$paramReg[0]['detAtencion'] = to_pg_array($arr_detatencion);
		$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser . "|" . $labIdServicioUser."|". $labIdServicioDepUser."|".$labIdTipoCorrelativo;
		/*print_r($paramReg);
		exit();*/
		$rs = $at->post_reg_laboratorio($paramReg);
		/*if ($rs == "E") {
			echo "ER|Error al ingresar la atención";
			exit();
		}
		echo "OK|".$rs;*/
		echo $rs;
		exit();
  break;
  case 'POST_ADD_REGSOLICITUDREFERENCIADO':
		$arr_paciente[0] = array($_POST['txtIdPer'], $_POST['txtIdTipDoc'], $_POST['txtNroDoc'], trim($_POST['txtNomPac']), trim($_POST['txtPriApePac']), trim($_POST['txtSegApePac']), $_POST['txtIdSexoPac'], trim($_POST['txtFecNacPac']), trim($_POST['txtNroTelFijoPac']), trim($_POST['txtNroTelMovilPac']), trim($_POST['txtEmailPac']), trim($_POST['txtNroHC']), trim($_POST['txtUBIGEOPac']), $_POST['txtIdAvDirPac'], trim($_POST['txtNomAvDirPac']), trim($_POST['txtNroDirPac']), trim($_POST['txtIntDirPac']), trim($_POST['txtDptoDirPac']), trim($_POST['txtMzDirPac']), trim($_POST['txtLtDirPac']), $_POST['txtIdPoblaDirPac'], trim($_POST['txtNomPoblaDirPac']), trim($_POST['txtDirPac']), trim($_POST['txtDirRefPac']), $_POST['txtIdPaisNacPac'], $_POST['txtIdEtniaPac']);
		$arr_solicitante[0] = array($_POST['txtIdSoli'], $_POST['txtIdTipDocSoli'], $_POST['txtNroDocSoli'], trim($_POST['txtNomSoli']), trim($_POST['txtPriApeSoli']), trim($_POST['txtSegApeSoli']), $_POST['txtIdSexoSoli'], trim($_POST['txtFecNacSoli']), trim($_POST['txtNroTelFijoSoli']), trim($_POST['txtNroTelMovilSoli']), trim($_POST['txtEmailSoli']), $_POST['txtIdPaisNacSoli']);
		$arr_atencion[0] = array($_POST['txtIdPlanTari'], $_POST['txtFechaAten'], $_POST['txtIdTipAtencion'], $_POST['txtIdServicio'], $_POST['txtIdDepRef'], trim($_POST['txtNroRefDep']), trim($_POST['txtAnioRefDep']), $_POST['txtFechaPedido'], $_POST['txtNombreMedico'], $_POST['txtIdParenSoli'], $_POST['txtAtenUrgente'], $_POST['txtPersonalSalud'], $_POST['txtSubTotal'], $_POST['txtPorDescuentoMonto'], $_POST['txtDescuentoMonto'], $_POST['txtTotalMonto'], $_POST['txtIdGestante'], $_POST['txtEdadGest'], $_POST['txtFechaParto'], $_POST['txtPesoPac'], $_POST['txtTallaPac'],$_POST['txtNroAteManual'],$_POST['txtFechaTomaMuestra']);
		$arr_fua[0] = array('');
		$nroArrayCpt = (int) 0;
		if($_POST['txtIdProducto'] <> ""){
			$idCpt = explode(",", $_POST['txtIdProducto']);
			foreach ($idCpt as $clave=>$valor){
			  //echo "El valor de $clave es: $valor";
			  $detCpt = explode("_", $valor);
			  $arr_producto[$nroArrayCpt] = array($detCpt[0], $detCpt[1], $_POST['txtPorDescuentoMonto']);
			  $nroArrayCpt ++;
			}
		} else {
			$arr_producto[0] = array('');
		}
		$arr_detatencion[0] = array('');

		$paramReg[0]['accion'] = "SREF";
		$paramReg[0]['id'] = $_POST['txtIdAtencion'];
		$paramReg[0]['paciente'] = to_pg_array($arr_paciente);
		$paramReg[0]['solicitante'] = to_pg_array($arr_solicitante);
		$paramReg[0]['atencion'] = to_pg_array($arr_atencion);
		$paramReg[0]['fua'] = to_pg_array($arr_fua);
		$paramReg[0]['producto'] = to_pg_array($arr_producto);		
		$paramReg[0]['detAtencion'] = to_pg_array($arr_detatencion);
		$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser . "|" . $labIdServicioUser."|". $labIdServicioDepUser."|".$labIdTipoCorrelativo;
		/*print_r($paramReg);
		exit();*/
		$rs = $at->post_reg_laboratorio($paramReg);
		echo $rs;
		exit();
  break;
  case 'POST_ADD_REGSOLICITUDLABREF':
		$arr_paciente[0] = array($_POST['txtIdPer'], $_POST['txtIdTipDoc'], $_POST['txtNroDoc'], trim($_POST['txtNomPac']), trim($_POST['txtPriApePac']), trim($_POST['txtSegApePac']), $_POST['txtIdSexoPac'], trim($_POST['txtFecNacPac']), trim($_POST['txtNroTelFijoPac']), trim($_POST['txtNroTelMovilPac']), trim($_POST['txtEmailPac']), trim($_POST['txtNroHC']), trim($_POST['txtUBIGEOPac']), $_POST['txtIdAvDirPac'], trim($_POST['txtNomAvDirPac']), trim($_POST['txtNroDirPac']), trim($_POST['txtIntDirPac']), trim($_POST['txtDptoDirPac']), trim($_POST['txtMzDirPac']), trim($_POST['txtLtDirPac']), $_POST['txtIdPoblaDirPac'], trim($_POST['txtNomPoblaDirPac']), trim($_POST['txtDirPac']), trim($_POST['txtDirRefPac']), $_POST['txtIdPaisNacPac'], $_POST['txtIdEtniaPac']);
		$arr_solicitante[0] = array($_POST['txtIdSoli'], $_POST['txtIdTipDocSoli'], $_POST['txtNroDocSoli'], trim($_POST['txtNomSoli']), trim($_POST['txtPriApeSoli']), trim($_POST['txtSegApeSoli']), $_POST['txtIdSexoSoli'], trim($_POST['txtFecNacSoli']), trim($_POST['txtNroTelFijoSoli']), trim($_POST['txtNroTelMovilSoli']), trim($_POST['txtEmailSoli']), $_POST['txtIdPaisNacSoli']);
		$arr_atencion[0] = array($_POST['txtIdPlanTari'], $_POST['txtFechaAten'], $_POST['txtIdTipAtencion'], $_POST['txtIdServicio'], $_POST['txtIdDepRef'], trim($_POST['txtNroRefDep']), trim($_POST['txtAnioRefDep']), $_POST['txtFechaPedido'], $_POST['txtNombreMedico'], $_POST['txtIdParenSoli'], $_POST['txtAtenUrgente'], $_POST['txtPersonalSalud'], $_POST['txtSubTotal'], $_POST['txtPorDescuentoMonto'], $_POST['txtDescuentoMonto'], $_POST['txtTotalMonto'], $_POST['txtIdGestante'], $_POST['txtEdadGest'], $_POST['txtFechaParto'], $_POST['txtPesoPac'], $_POST['txtTallaPac'],$_POST['txtNroAteManual'],$_POST['txtFechaTomaMuestra']);
		$arr_fua[0] = array('');
		$nroArrayCpt = (int) 0;
		if($_POST['txtIdProducto'] <> ""){
			$idCpt = explode(",", $_POST['txtIdProducto']);
			foreach ($idCpt as $clave=>$valor){
			  //echo "El valor de $clave es: $valor";
			  $detCpt = explode("_", $valor);
			  $arr_producto[$nroArrayCpt] = array($detCpt[0], $detCpt[1], $_POST['txtPorDescuentoMonto']);
			  $nroArrayCpt ++;
			}
		} else {
			$arr_producto[0] = array('');
		}
		$arr_detatencion[0] = array('');
		if($_POST['txtIdAtencion'] == "0"){
			$action = "SLR";
		} else {
			$action = "ELR";
		}
		$paramReg[0]['accion'] = $action;
		$paramReg[0]['id'] = $_POST['txtIdAtencion'];
		$paramReg[0]['paciente'] = to_pg_array($arr_paciente);
		$paramReg[0]['solicitante'] = to_pg_array($arr_solicitante);
		$paramReg[0]['atencion'] = to_pg_array($arr_atencion);
		$paramReg[0]['fua'] = to_pg_array($arr_fua);
		$paramReg[0]['producto'] = to_pg_array($arr_producto);		
		$paramReg[0]['detAtencion'] = to_pg_array($arr_detatencion);
		$paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser . "|" . $labIdServicioUser."|". $labIdServicioDepUser."|".$labIdTipoCorrelativo;
		/*print_r($paramReg);
		exit();*/
		$rs = $at->post_reg_laboratorio($paramReg);
		echo $rs;
		exit();
  break;
  case 'POST_ADD_REGRESULTADOLAB':
  $nroArrayC = (int) 0;
  $arr_paciente[0] = array('');
  $arr_solicitante[0] = array('');
  $arr_atencion[0] = array($_POST['txtIdAtencion'], 0, $_POST['opt_save']);//trim($_POST['txtNroRefAtencion'])
  $arr_cpt[0] = array('');
  $rsA = $a->get_listaAreaPorIdAtencion($_POST['txtIdAtencion'], 0);
  foreach ($rsA as $rowA) {
    $rsP = $p->get_listaProductoPorIdAreaAndIdAtencion($_POST['txtIdAtencion'], $rowA['id_area']);
    foreach ($rsP as $rowP) {
      $rsC = $c->get_listaComponentePorIdAreaAndIdAtencionAndIdProducto($_POST['txtIdAtencion'], $rowA['id_area'], $rowP['id_producto']);
      foreach ($rsC as $rowC) {
        if ($_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id_componentedet'] . ''] <> "") {
          $ingValor = 1;
        }else {
          $ingValor = 0;
        }
        $arr_detatencion[$nroArrayC] = array($rowP['id_producto'], $rowC['id_componentedet'], $_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id_componentedet'] . ''], $ingValor, $rowC['orden_componentedet'], $_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id_componentedet'] . '_idval'],  $rowC['tipo_ingresosol'], $_POST['txt_' . $rowP['id_producto'] . '_' . $rowC['id_componentedet'] . '_proori']);
        $nroArrayC ++;
      }
    }
  }
  if(isset($_POST['txtOpt'])) {
    $accion = $_POST['txtOpt'];
  } else {
    $accion = "R";
  }

  $paramReg[0]['accion'] = $accion;
  $paramReg[0]['paciente'] = to_pg_array($arr_paciente);
  $paramReg[0]['solicitante'] = to_pg_array($arr_solicitante);
  $paramReg[0]['atencion'] = to_pg_array($arr_atencion);
  $paramReg[0]['producto'] = to_pg_array($arr_cpt);
  $paramReg[0]['detAtencion'] = to_pg_array($arr_detatencion);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser . "|" . $labIdServicioUser."|". $labIdServicioDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $at->post_reg_laboratorio($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar la atención";
    exit();
  }

  echo "OK|".$rs;
  break;
  case 'POST_REG_DESVALIDAR_XAMEN':
	$arr_examen[0] = array($_POST['id_producto'], $_POST['obs_desva_resultado']);
	$paramReg[0]['id'] = $_POST['id_atencion'];
	$paramReg[0]['datos_examen'] = to_pg_array($arr_examen);
	$paramReg[0]['userIngreso'] = $labIdUser;
	/*print_r($paramReg);
	exit();*/
	$rs = $at->post_reg_lab_resultado_desvalida($paramReg);
	if ($rs == "E") {
		echo "ER|Error al ingresar la atención";
		exit();
	}
  break;
  case 'POST_ADD_SOLIATENCION':
  $nroArrayC = (int) 0;
  $arr_paciente[0] = array($_POST['txtIdPer'], $_POST['txtIdTipDoc'], $_POST['txtNroDoc'], trim($_POST['txtNomPac']), trim($_POST['txtPriApePac']), trim($_POST['txtSegApePac']), $_POST['txtIdSexoPac'], trim($_POST['txtFecNacPac']), trim($_POST['txtNroTelFijoPac']), trim($_POST['txtNroTelMovilPac']), trim($_POST['txtEmailPac']), trim($_POST['txtNroHC']));
  $arr_solicitante[0] = array($_POST['txtIdSoli'], $_POST['txtIdTipDocSoli'], $_POST['txtNroDocSoli'], trim($_POST['txtNomSoli']), trim($_POST['txtPriApeSoli']), trim($_POST['txtSegApeSoli']), $_POST['txtIdSexoSoli'], trim($_POST['txtFecNacSoli']), trim($_POST['txtNroTelFijoSoli']), trim($_POST['txtNroTelMovilSoli']), trim($_POST['txtEmailSoli']));
  $arr_atencion[0] = array(trim($_POST['txtNroRefAtencion']),$_POST['txtIdTipAtencion'], $_POST['txtIdDepRef'], $_POST['txtNroRefDep'], $_POST['txtCodSIS'], trim($_POST['txtNroSIS']), $_POST['txtIdGestante'], trim($_POST['txtFechaParto']), trim($_POST['txtEdadGest']), trim($_POST['txtFechaAten']), $_POST['txtHoraAten'], trim($_POST['txtPesoPac']), trim($_POST['txtTallaPac']), trim($_POST['txtPAPac']));
  $nroArrayCpt = (int) 0;
  if($_POST['txtIdCpt'] <> ""){
    $idCpt = explode(",", $_POST['txtIdCpt']);
    foreach ($idCpt as $clave=>$valor){
      //echo "El valor de $clave es: $valor";
      $arr_cpt[$nroArrayCpt] = array($valor);
      $nroArrayCpt ++;
    }
  } else {
    $arr_cpt[0] = array('');
  }
  $arr_detatencion[0] = array('');
  $paramReg[0]['accion'] = 'S';
  $paramReg[0]['paciente'] = to_pg_array($arr_paciente);
  $paramReg[0]['solicitante'] = to_pg_array($arr_solicitante);
  $paramReg[0]['atencion'] = to_pg_array($arr_atencion);
  $paramReg[0]['cpt'] = to_pg_array($arr_cpt);
  $paramReg[0]['detAtencion'] = to_pg_array($arr_detatencion);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser ."|". $labIdServicioDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $at->post_reg_atenciondet($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar la atención";
    exit();
  }

  echo "OK|".$rs;
  exit();
  break;
  case 'POST_ADD_ATENCION':
  $nroArrayC = (int) 0;
  $arr_paciente[0] = array($_POST['txtIdPer'], $_POST['txtIdTipDoc'], $_POST['txtNroDoc'], trim($_POST['txtNomPac']), trim($_POST['txtPriApePac']), trim($_POST['txtSegApePac']), $_POST['txtIdSexoPac'], trim($_POST['txtFecNacPac']), trim($_POST['txtNroTelFijoPac']), trim($_POST['txtNroTelMovilPac']), trim($_POST['txtEmailPac']), trim($_POST['txtNroHC']));
  $arr_solicitante[0] = array($_POST['txtIdSoli'], $_POST['txtIdTipDocSoli'], $_POST['txtNroDocSoli'], trim($_POST['txtNomSoli']), trim($_POST['txtPriApeSoli']), trim($_POST['txtPriApeSoli']), $_POST['txtIdSexoSoli'], trim($_POST['txtFecNacSoli']), trim($_POST['txtNroTelFijoSoli']), trim($_POST['txtNroTelMovilSoli']), trim($_POST['txtEmailSoli']));
  $arr_atencion[0] = array(trim($_POST['txtNroRefAtencion']),$_POST['txtIdTipAtencion'], $_POST['txtIdDepRef'], $_POST['txtNroRefDep'], $_POST['txtCodSIS'], trim($_POST['txtNroSIS']), $_POST['txtIdGestante'], trim($_POST['txtFechaParto']), trim($_POST['txtEdadGest']), trim($_POST['txtFechaAten']), $_POST['txtHoraAten'], trim($_POST['txtPesoPac']), trim($_POST['txtTallaPac']), trim($_POST['txtPAPac']), trim($_POST['txtNroFUA']));
  $rsA = $a->get_listaArea();
  foreach ($rsA as $rowA) {
    $rsC = $c->get_listaComponentePorIdArea($rowA['id_area']);
    foreach ($rsC as $rowC) {
      if ($_POST['txt_' . $rowC['id_componentedet'] . ''] <> "") {
        $ingValor = 1;
      }else {
        $ingValor = 0;
      }
      $arr_detatencion[$nroArrayC] = array($rowC['id_componentedet'], $_POST['txt_' . $rowC['id_componentedet'] . ''], $ingValor, $rowC['orden_componentedet']);
      $nroArrayC ++;
    }
  }

  $nroArrayCpt = (int) 0;
  if($_POST['txtIdCpt'] <> ""){
    $idCpt = explode(",", $_POST['txtIdCpt']);
    foreach ($idCpt as $clave=>$valor){
      //echo "El valor de $clave es: $valor";
      $arr_cpt[$nroArrayCpt] = array($valor);
      $nroArrayCpt ++;
    }
  } else {
    $arr_cpt[0] = array('');
  }

  $paramReg[0]['accion'] = 'C';
  $paramReg[0]['paciente'] = to_pg_array($arr_paciente);
  $paramReg[0]['solicitante'] = to_pg_array($arr_solicitante);
  $paramReg[0]['atencion'] = to_pg_array($arr_atencion);
  $paramReg[0]['cpt'] = to_pg_array($arr_cpt);
  $paramReg[0]['detAtencion'] = to_pg_array($arr_detatencion);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser ."|". $labIdServicioDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $at->post_reg_atenciondet($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar la atención";
    exit();
  }

  echo "OK|".$rs;
  exit();
  break;
  case 'POST_ADD_REGRESULTADO':
  $nroArrayC = (int) 0;
  $arr_paciente[0] = array('');
  $arr_solicitante[0] = array('');
  $arr_atencion[0] = array($_POST['txtIdAtencion'], 0);//trim($_POST['txtNroRefAtencion'])
  $arr_cpt[0] = array('');
  $rsA = $a->get_listaAreaPorIdAtencion($_POST['txtIdAtencion'], 0);
  foreach ($rsA as $rowA) {
    $rsC = $c->get_listaComponentePorIdAreaAndIdAtencion($_POST['txtIdAtencion'], $rowA['id_area']);
    foreach ($rsC as $rowC) {
      if ($_POST['txt_' . $rowC['id_componentedet'] . ''] <> "") {
        $ingValor = 1;
      }else {
        $ingValor = 0;
      }
      $arr_detatencion[$nroArrayC] = array($rowC['id_componentedet'], $_POST['txt_' . $rowC['id_componentedet'] . ''], $ingValor, $rowC['orden_componentedet']);
      $nroArrayC ++;
    }
  }

  $paramReg[0]['accion'] = 'R';
  $paramReg[0]['paciente'] = to_pg_array($arr_paciente);
  $paramReg[0]['solicitante'] = to_pg_array($arr_solicitante);
  $paramReg[0]['atencion'] = to_pg_array($arr_atencion);
  $paramReg[0]['cpt'] = to_pg_array($arr_cpt);
  $paramReg[0]['detAtencion'] = to_pg_array($arr_detatencion);
  $paramReg[0]['userIngreso'] = $labIdUser . "|" . $labIdDepUser ."|". $labIdServicioDepUser;
  /*print_r($paramReg);
  exit();*/
  $rs = $at->post_reg_atenciondet($paramReg);
  if ($rs == "E") {
    echo "ER|Error al ingresar la atención";
    exit();
  }

  echo "OK|".$rs;
  exit();
  break;
  case "GET_CNTATENCIONESPORFECHA":
  $cnt_total=0;
  $tot_sis = 0;
  $tot_demanda = 0;
  $tot_estrategia = 0;
  $tot_exonerado = 0;
  $porc_sis = 0;
  $porc_demanda = 0;
  $porc_estrategia = 0;
  $porc_exonerado = 0;
  $param[0]['fecIniAte'] = $_POST['fecIni'];
  $param[0]['fecFinAte'] = $_POST['fecFin'];
  $param[0]['idDepAten'] = $labIdDepUser;
  $rs = $at->get_repCntAtencionPorFechaAndIdDependencia($param);
  foreach ($rs as $row) {
	  $cnt_total=$row['cnt_atencion'] + $cnt_total;
	  if($row['id_plan'] == "1"){
		  $tot_sis = $row['cnt_atencion'] ;
	  }
	  if($row['id_plan'] == "2"){
		  $tot_demanda = $row['cnt_atencion'] ;
	  }
	  if($row['id_plan'] == "3"){
		  $tot_estrategia = $row['cnt_atencion'] ;
	  }
	  if($row['id_plan'] == "4"){
		  $tot_exonerado = $row['cnt_atencion'] ;
	  }
  }
  //print_r($rs);
   if($cnt_total <> 0){
		$porc_sis = ($tot_sis * 100) / $cnt_total;
		$porc_demanda = ($tot_demanda * 100) / $cnt_total;
		$porc_estrategia = ($tot_estrategia * 100) / $cnt_total;
		$porc_exonerado = ($tot_exonerado * 100) / $cnt_total;
  }
  ?>
	<div class="progress-group">
		<span class="progress-text">SIS</span>
		<span class="progress-number"><b><?php echo $tot_sis?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
		<div class="progress-bar" style="width: <?php echo $porc_sis?>%"></div>
		</div>
	</div>
	<div class="progress-group">
		<span class="progress-text">PAGANTES</span>
		<span class="progress-number"><b><?php echo $tot_demanda?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
			<div class="progress-bar progress-bar-green" style="width: <?php echo $porc_demanda?>%"></div>
		</div>
	</div>
	<div class="progress-group">
		<span class="progress-text">ESTRATEGIAS SANITARIAS</span>
		<span class="progress-number"><b><?php echo $tot_estrategia?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
			<div class="progress-bar progress-bar-aqua" style="width: <?php echo $porc_estrategia?>%"></div>
		</div>
	</div>
	<div class="progress-group">
		<span class="progress-text">EXONERADOS</span>
		<span class="progress-number"><b><?php echo $tot_exonerado?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
			<div class="progress-bar progress-bar-yellow" style="width: <?php echo $porc_exonerado?>%"></div>
		</div>
	</div>
	<hr/>
	<h3 class="profile-username text-center">Examenes solitados</h3>
	<?php
		$tot_hema=0;
		$tot_bio=0;
		$tot_inmu=0;
		$tot_micro=0;
		$tot_reac=0;
		$tot_perfil=0;
	
		$rs = $at->get_repCntPorTipoProductoPorFechaAndIdDependencia($param);
		foreach ($rs as $row) {
			if($row['id'] == "1") $tot_hema = $row['ctn_producto'];
			if($row['id'] == "2") $tot_bio = $row['ctn_producto'];
			if($row['id'] == "3") $tot_inmu = $row['ctn_producto'];
			if($row['id'] == "4") $tot_micro = $row['ctn_producto'];
			if($row['id'] == "5") $tot_reac = $row['ctn_producto'];
			if($row['id'] == "6") $tot_perfil = $row['ctn_producto'];
		}
	?>
	<ul class="list-group list-group-unbordered">
		<li class="list-group-item">
			<b>EXAMENES HEMATOLOGICOS</b> <a class="pull-right" href="#"><span class="badge bg-green"><?php echo $tot_hema?></span></a>
		</li>
		<li class="list-group-item">
			<b>EXAMENES BIOQUIMICOS</b> <a class="pull-right" href="#"><span class="badge bg-yellow"><?php echo $tot_bio?></span></a>
		</li>
		<li class="list-group-item">
			<b>EXAMENES INMUNOLOGICOS</b> <a class="pull-right" href="#"><span class="badge bg-aqua"><?php echo $tot_inmu?></span></a>
		</li>
		<li class="list-group-item">
			<b>EXAMENES MICROBIOLOGICOS</b> <a class="pull-right" href="#"><span class="badge bg-red"><?php echo $tot_micro?></span></a>
		</li>
		<li class="list-group-item">
			<b>PERFIL / PAQUETE</b> <a class="pull-right" href="#"><span class="badge"><?php echo $tot_perfil?></span></a>
		</li>
	</ul>
  <?php
  break;
  case "GET_CNTRESULTADOSPORANIOMESANDPLANTARIFARIO":
  $cnt_total=0;
  $tot_sis = 0;
  $tot_demanda = 0;
  $tot_estrategia = 0;
  $tot_exonerado = 0;
  $porc_sis = 0;
  $porc_demanda = 0;
  $porc_estrategia = 0;
  $porc_exonerado = 0;
  $param[0]['anio'] = $_POST['anio'];
  $param[0]['mes'] = $_POST['mes'];
  $param[0]['idDepAten'] = $labIdDepUser;
  $rs = $at->get_repCntAtencionPorAnioMesAndIdDependencia($param);
  foreach ($rs as $row) {
	  $cnt_total=$row['cnt_atencion'] + $cnt_total;
	  if($row['id_plan'] == "1"){
		  $tot_sis = $row['cnt_atencion'] ;
	  }
	  if($row['id_plan'] == "2"){
		  $tot_demanda = $row['cnt_atencion'] ;
	  }
	  if($row['id_plan'] == "3"){
		  $tot_estrategia = $row['cnt_atencion'] ;
	  }
	  if($row['id_plan'] == "4"){
		  $tot_exonerado = $row['cnt_atencion'] ;
	  }
  }
  //print_r($rs);
   if($cnt_total <> 0){
		$porc_sis = ($tot_sis * 100) / $cnt_total;
		$porc_demanda = ($tot_demanda * 100) / $cnt_total;
		$porc_estrategia = ($tot_estrategia * 100) / $cnt_total;
		$porc_exonerado = ($tot_exonerado * 100) / $cnt_total;
  }
  ?>
	<div class="progress-group">
		<span class="progress-text">SIS</span>
		<span class="progress-number"><b><?php echo $tot_sis?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
		<div class="progress-bar" style="width: <?php echo $porc_sis?>%"></div>
		</div>
	</div>
	<div class="progress-group">
		<span class="progress-text">PAGANTES</span>
		<span class="progress-number"><b><?php echo $tot_demanda?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
			<div class="progress-bar progress-bar-green" style="width: <?php echo $porc_demanda?>%"></div>
		</div>
	</div>
	<div class="progress-group">
		<span class="progress-text">ESTRATEGIAS SANITARIAS</span>
		<span class="progress-number"><b><?php echo $tot_estrategia?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
			<div class="progress-bar progress-bar-aqua" style="width: <?php echo $porc_estrategia?>%"></div>
		</div>
	</div>
	<div class="progress-group">
		<span class="progress-text">EXONERADOS</span>
		<span class="progress-number"><b><?php echo $tot_exonerado?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
			<div class="progress-bar progress-bar-yellow" style="width: <?php echo $porc_exonerado?>%"></div>
		</div>
	</div>
	<hr/>
	<h3 class="profile-username text-center">Examenes validados</h3>
	<?php
		$tot_hema=0;
		$tot_bio=0;
		$tot_inmu=0;
		$tot_micro=0;
		$tot_reac=0;
		$tot_perfil=0;
	
		$rs = $at->get_repCntResultadosPorTipoProductoPorAnioMesAndIdDependencia($param);
		foreach ($rs as $row) {
			if($row['id'] == "1") $tot_hema = $row['ctn_producto'];
			if($row['id'] == "2") $tot_bio = $row['ctn_producto'];
			if($row['id'] == "3") $tot_inmu = $row['ctn_producto'];
			if($row['id'] == "4") $tot_micro = $row['ctn_producto'];
			if($row['id'] == "5") $tot_reac = $row['ctn_producto'];
			if($row['id'] == "6") $tot_perfil = $row['ctn_producto'];
		}
	?>
	<ul class="list-group list-group-unbordered">
		<li class="list-group-item">
			<b>EXAMENES HEMATOLOGICOS</b> <a class="pull-right" href="#"><span class="badge bg-green"><?php echo $tot_hema?></span></a>
		</li>
		<li class="list-group-item">
			<b>EXAMENES BIOQUIMICOS</b> <a class="pull-right" href="#"><span class="badge bg-yellow"><?php echo $tot_bio?></span></a>
		</li>
		<li class="list-group-item">
			<b>EXAMENES INMUNOLOGICOS</b> <a class="pull-right" href="#"><span class="badge bg-aqua"><?php echo $tot_inmu?></span></a>
		</li>
		<li class="list-group-item">
			<b>EXAMENES MICROBIOLOGICOS</b> <a class="pull-right" href="#"><span class="badge bg-red"><?php echo $tot_micro?></span></a>
		</li>
		<li class="list-group-item">
			<b>PERFIL / PAQUETE</b> <a class="pull-right" href="#"><span class="badge"><?php echo $tot_perfil?></span></a>
		</li>
	</ul>
	<?php
		$rsCnt = $at->get_repCntProductoPorAnioMesAndIdDependenciaManual($param);
		//print_r($rsCnt);
		if(count($rsCnt) <> "0"){
			?>
			<table class="table table-bordered">
			<thead>
				<tr>
				  <th colspan="3">CNT. EXAMENES AGREGADO MANUALMENTE</th>
				</tr>
			 </thead>
			 <tbody>
				<?php
				foreach ($rsCnt as $row) {
					?>
				<tr>
					<td><?php echo $row['nom_producto']?></td>
					<td class="text-right"><?php echo $row['cnt_total']?></td>
					<td class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="save_delet_cantidad('<?php echo $row['id'];?>','<?php echo $row['cnt_total'];?>');"><i class="glyphicon glyphicon-trash"></i></button></td>
				</tr>
				<?php
				}
				?>
			</tbody>
			</table>
			<?php
		}
	?>
  <?php
  break;
  case "GET_CNTRESULTADOSPORFECHAANDPLANTARIFARIO":
  $cnt_total=0;
  $tot_sis = 0;
  $tot_demanda = 0;
  $tot_estrategia = 0;
  $tot_exonerado = 0;
  $porc_sis = 0;
  $porc_demanda = 0;
  $porc_estrategia = 0;
  $porc_exonerado = 0;
  $param[0]['fecIniAte'] = $_POST['fecIni'];
  $param[0]['fecFinAte'] = $_POST['fecFin'];
  $param[0]['idDepAten'] = $labIdDepUser;
  $rs = $at->get_repCntAtencionPorFechaAndIdDependencia($param);
  foreach ($rs as $row) {
	  $cnt_total=$row['cnt_atencion'] + $cnt_total;
	  if($row['id_plan'] == "1"){
		  $tot_sis = $row['cnt_atencion'] ;
	  }
	  if($row['id_plan'] == "2"){
		  $tot_demanda = $row['cnt_atencion'] ;
	  }
	  if($row['id_plan'] == "3"){
		  $tot_estrategia = $row['cnt_atencion'] ;
	  }
	  if($row['id_plan'] == "4"){
		  $tot_exonerado = $row['cnt_atencion'] ;
	  }
  }
  //print_r($rs);
   if($cnt_total <> 0){
		$porc_sis = ($tot_sis * 100) / $cnt_total;
		$porc_demanda = ($tot_demanda * 100) / $cnt_total;
		$porc_estrategia = ($tot_estrategia * 100) / $cnt_total;
		$porc_exonerado = ($tot_exonerado * 100) / $cnt_total;
  }
  ?>
	<div class="progress-group">
		<span class="progress-text">SIS</span>
		<span class="progress-number"><b><?php echo $tot_sis?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
		<div class="progress-bar" style="width: <?php echo $porc_sis?>%"></div>
		</div>
	</div>
	<div class="progress-group">
		<span class="progress-text">PAGANTES</span>
		<span class="progress-number"><b><?php echo $tot_demanda?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
			<div class="progress-bar progress-bar-green" style="width: <?php echo $porc_demanda?>%"></div>
		</div>
	</div>
	<div class="progress-group">
		<span class="progress-text">ESTRATEGIAS SANITARIAS</span>
		<span class="progress-number"><b><?php echo $tot_estrategia?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
			<div class="progress-bar progress-bar-aqua" style="width: <?php echo $porc_estrategia?>%"></div>
		</div>
	</div>
	<div class="progress-group">
		<span class="progress-text">EXONERADOS</span>
		<span class="progress-number"><b><?php echo $tot_exonerado?></b>/<?php echo $cnt_total?></span>
		<div class="progress sm">
			<div class="progress-bar progress-bar-yellow" style="width: <?php echo $porc_exonerado?>%"></div>
		</div>
	</div>
	<hr/>
	<h3 class="profile-username text-center">Productos validados</h3>
	<?php
		$tot_hema=0;
		$tot_bio=0;
		$tot_inmu=0;
		$tot_micro=0;
		$tot_reac=0;
		$tot_perfil=0;
	
		$rs = $at->get_repCntResultadosPorTipoProductoPorFechaAndIdDependencia($param);
		foreach ($rs as $row) {
			if($row['id'] == "1") $tot_hema = $row['ctn_producto'];
			if($row['id'] == "2") $tot_bio = $row['ctn_producto'];
			if($row['id'] == "3") $tot_inmu = $row['ctn_producto'];
			if($row['id'] == "4") $tot_micro = $row['ctn_producto'];
			if($row['id'] == "5") $tot_reac = $row['ctn_producto'];
			if($row['id'] == "6") $tot_perfil = $row['ctn_producto'];
		}
	?>
	<ul class="list-group list-group-unbordered">
		<li class="list-group-item">
			<b>EXAMENES HEMATOLOGICOS</b> <a class="pull-right" href="#"><span class="badge bg-green"><?php echo $tot_hema?></span></a>
		</li>
		<li class="list-group-item">
			<b>EXAMENES BIOQUIMICOS</b> <a class="pull-right" href="#"><span class="badge bg-yellow"><?php echo $tot_bio?></span></a>
		</li>
		<li class="list-group-item">
			<b>EXAMENES INMUNOLOGICOS</b> <a class="pull-right" href="#"><span class="badge bg-aqua"><?php echo $tot_inmu?></span></a>
		</li>
		<li class="list-group-item">
			<b>EXAMENES MICROBIOLOGICOS</b> <a class="pull-right" href="#"><span class="badge bg-red"><?php echo $tot_micro?></span></a>
		</li>
		<li class="list-group-item">
			<b>PERFIL / PAQUETE</b> <a class="pull-right" href="#"><span class="badge"><?php echo $tot_perfil?></span></a>
		</li>
	</ul>
  <?php
  break;
  case "GET_SHOW_NEWNROATENCIONPORFECHAYIDDEP":
  $rs = $at->get_repNroAtencionPorFechaAndIdDep($_POST['txtFechaAten'], $labIdDepUser);
  echo $rs;
  break;
  case "SHOW_DETPRODUCTOATENCION":
  ?>
  <table class="table table-bordered" style="margin-bottom: 0px;">
    <thead class="bg-green">
      <tr>
        <th>&nbsp;</th>
        <th>CODIGO CPMS</th>
        <th>EXAMEN</th>
        <th>PRECIO</th>
		<th>FECHA RECEPCION MUESTRA</th>
		<th>&nbsp;</th>
		<th class='text-center'><button type="button" class="btn btn-warning btn-xs" onclick="imprime_resultado_unido_check('<?php echo $_POST['idAten']?>');"><i class="fa fa-file-text-o"></i></button></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $rs = $at->get_datosProductoPorIdAtencion($_POST['idAten']);
	  //print_r($rs);
	  $cnt_producto = count($rs);
      $a = 1;
      foreach ($rs as $row) {
		 $colorstyle = "";
		if($row['id_estado_envio'] == "1"){
			if($row['fec_recepciontoma'] == ""){
				$colorstyle = "active";
			} else {
				if($row['id_estado_resul'] == "1"){
					$colorstyle = "info";
				} else if($row['id_estado_resul'] == "2"){
					$colorstyle = "info";
				} else {
					$colorstyle = "success";
				}
			}
		} else {
			$colorstyle = "warning";
			if($row['id_estado_resul'] == "4"){
				$colorstyle = "success";
			}
		}
		if($row['id_dependencia'] == "67"){
			$examen = str_replace("TOMA DE MUESTRA ", "", $row['nom_producto']);
			$examen = str_replace("PARA ", "", $examen);
		} else {
			$examen = $row['nom_producto'];
		}
        echo "<tr>";
        echo "<td class='". $colorstyle . " text-center'><small><b>" . $a++ . "</b></small></td>";
        echo "<td class='". $colorstyle . " text-center'><small><b>" . $row['codref_producto'] . "</b></small></td>";
        echo "<td class='". $colorstyle . "'><small>" . $examen . "</small></td>";
        echo "<td class='". $colorstyle . " text-right'><small>" . $row['total'] . "</small></td>";
		echo "<td class='". $colorstyle . "'><small>" . $row['fec_recepciontoma'] ."</small></td>";
		echo "<td class='text-center'><small>";
		if (!isset($_POST['origen'])){
			if ($row['id_estado_envio'] == '1'){//1 No enviado
				if($row['fec_recepciontoma'] == ""){
					$nom_producto = str_replace("\"","",$row['nom_producto']);
					if($_SESSION['labIdRolUser'] == "1" OR $_SESSION['labIdRolUser'] == "2" OR $_SESSION['labIdRolUser'] == "3" OR $_SESSION['labIdRolUser'] == "4" OR $_SESSION['labIdRolUser'] == "5" OR $_SESSION['labIdRolUser'] == "14" OR $_SESSION['labIdRolUser'] == "15"){
					?>
						<button type="button" class="btn btn-info btn-xs" onclick="reg_recepcionmuestra('<?php echo $row['id_atencion']?>', '<?php echo $row['nom_producto']?>', <?php echo $row['id']?>, <?php echo $cnt_producto?>);"><i class="glyphicon glyphicon-ok"></i></button>
					<?php
					}
				}
			}
		}
		if ($row['id_estado_resul'] == '3' OR $row['id_estado_resul'] == '4'){//3 validado //4entregado pac
			if ($row['id_estado_envio']=="1"){
				$id_atencion_md5 = md5($row['id_atencion']);
				$id_dependencia_md5 = md5($row['id_dependencia']);
			} else {
				$idAtenOri = $at->get_id_atencion_procesa_resultado($row['id_dependencia'], $row['cod_ref_nro_atencion']);
				if($idAtenOri <> ""){
					$id_atencion_md5 = md5($idAtenOri);
					$id_dependencia_md5 = md5($row['id_dependencia']);
				} else {
					$id_atencion_md5 = md5($row['id_atencion']);
					$id_dependencia_md5 = md5($row['id_dependencia']);
				}
			}
		?>
			<button type="button" class="btn btn-warning btn-xs" onclick="imprime_resultado('<?php echo $id_atencion_md5?>', '<?php echo $id_dependencia_md5?>', '<?php echo $row['id_producto']?>');"><i class="fa fa-file-text-o"></i></button>
		<?php
		}
		echo "</small></td><td class='text-center'>";
		if ($row['id_estado_resul'] == '3' OR $row['id_estado_resul'] == '4'){//3 validado //4entregado pac
		if ($row['id_estado_envio']=="1"){
		?>
			<input type="checkbox" class="check_atencion_<?php echo $row['id_atencion']?>" name="txt_<?php echo $row['id_atencion']?>_<?php echo $row['id_producto']?>" id="txt_<?php echo $row['id_atencion']?>_<?php echo $row['id_producto']?>" value="<?php echo $row['id_producto']?>" checked/></label>
		<?php
		} }
        echo "</td></tr>";
      }
      ?>
    </tbody>
  </table>
  <?php
  break;
  case "POST_REG_RECEPCIONMUESTRA":
  //echo "124-SIS";
  $paramReg = $labIdUser . "|" . $labIdDepUser ."|". $_POST['id_atencion'] ."|". $_POST['id_productoaten'] ."|". $_POST['cnt_producto'];
  /*echo $paramReg;
  exit();*/
  $rs = $at->post_reg_recepcionmuestra($paramReg);
  echo $rs;
  break;
  case "POST_ADD_REG_ACCION_COMPLEMENTARIA":
	$rs = $at->post_reg_accion_complementaria($_POST['id_atencion'], $_POST['accion_sp'], $_POST['detalle'], $labIdUser);
	echo $rs;
  break;
  case "POST_ADD_REGVALIDAATENCION":
  //echo "124-SIS";
  $paramReg = $labIdUser . "|" . $labIdDepUser ."|". $_POST['idAten'];
  $rs = $at->post_reg_atencionvalidaresul($paramReg);
  echo $rs;
  break;
  case "GET_SHOW_PDFATENCION":
  $idAreaProd = 0;
  if(isset($_POST['id_areaprod'])) $idAreaProd = $_POST['id_areaprod'];
  ?>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title"><?php echo $_POST['nomPac']?></h2>
      </div>
      <div class="modal-body">
        <h4 class="text-center" style="margin: 0 0 10px 0 !important;">Tipo impresión:</h4>
        <div class="row">
          <div class="col-sm-6">
            <button type="button" class="btn btn-success btn-block" onclick="imprime_resultado_unido('<?php echo $_POST['idAten']?>', '<?php echo $_POST['idDep']?>',0);">Examenes agrupados</button>
          </div>
          <div class="col-sm-6">
            <button type="button" class="btn btn-primary btn-block" onclick="imprime_resultado('<?php echo $_POST['idAten']?>', '<?php echo $_POST['idDep']?>', '<?php echo $_POST['idProd']?>');">Examenes separados</button>
          </div>
		  <hr/>
		  <div class="col-sm-12">
            <button type="button" class="btn btn-info btn-block" onclick="imprime_resultado_area('<?php echo $_POST['idAten']?>', '<?php echo $_POST['idDep']?>',0);">Examenes por área</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default btn-block" type="button" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar Ventana</button>
      </div>
    </div>
  </div>
  <?php
  break;
  case "GET_SHOW_LISTATARIFADEPPORIDTIPPLAN":
  //$rs = $t->get_listaTarifaDepPorIdTipPlan($labIdDepUser, $_POST['txtIdTipPlan']);
  $rs = $t->get_listaTarifaPorIdDep($_POST['labIdDep']);
  echo json_encode($rs);
  break;
  case "POST_REG_CAMBIAMUESTRA_RESULTADO":
	$rs = $at->post_reg_cambia_muestra_resultado($_POST['id_atencion'], $_POST['id_est_nuevo'], $labIdUser);
	echo $rs;
  break;
  case "POST_REG_DEP_ORIGEN":
	$rs = $at->post_reg_dep_origen($_POST['id_atencion'], $_POST['id_dep_ori'], $labIdUser);
	echo $rs;
  break;
  case "GET_SHOW_ULTIMONROATENCION_REGISTRADO":
	$nro_atencion = "NINGUNA";
	$rs = $at->get_ultimo_nro_atencion($labIdDepUser);
	if(isset($rs['nro_atencion'])){
		$nro_atencion = $rs['nro_atencion']."-".$rs['anio_atencion'];	
	}
	echo $nro_atencion;
  break;
  case "GET_SHOW_LISTAEXAMENES_PARA_ORDEN":
	$idAtencion = $_POST['idAten'];
	$id_dependencia = $_POST['id_dependencia'];
	$rsA = $at->get_datosAtencion($idAtencion);
	$ip = (int)1;
	  $rsCtp = $at->get_datosProductoPorIdAtencion($idAtencion);
	  $cnt_productos = count($rsCtp);
	  $cnt_validado = (int)0;
	  $id_produc_sin_val = "";
	  foreach ($rsCtp as $rowCpt) {
		$btnIng = '';
		$btnImpr = '';
		if($rowCpt['id_estado_envio'] == "1"){
			if($rowCpt['fec_recepciontoma'] == ""){
				$id_produc_sin_val .= $rowCpt['id_producto'];
				$colorstyle = "active";
				$btnIng = '<button type="button" class="btn btn-primary btn-xs tbn-ing-producto" onclick="reg_resultado(\'' . $idAtencion . '\',\'' . $rowCpt['id_producto'] . '\');"><i class="glyphicon glyphicon-eject"></i></button>';
			} else {
				if($rowCpt['id_estado_resul'] == "1"){
					$id_produc_sin_val .= $rowCpt['id_producto'];
					$colorstyle = "info";
					if($cnt_productos <> 1){
						$btnIng = '<button type="button" class="btn btn-primary btn-xs tbn-ing-producto" onclick="reg_resultado(\'' . $idAtencion . '\',\'' . $rowCpt['id_producto'] . '\');"><i class="glyphicon glyphicon-eject"></i></button>';
					}
				} else if($rowCpt['id_estado_resul'] == "2"){
					$id_produc_sin_val .= $rowCpt['id_producto'];
					if($cnt_productos <> 1){
						$btnIng = '<button type="button" class="btn btn-success btn-xs tbn-ing-producto" onclick="reg_resultado(\'' . $idAtencion . '\',\'' . $rowCpt['id_producto'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
					}
					$colorstyle = "primary";
				} else {
					$colorstyle = "success";
					$btnImpr = '<button type="button" class="btn btn-warning btn-xs" onclick="imprime_resultado(\'' . md5($idAtencion) . '\',\'' . md5($id_dependencia) . '\',\'' . $rowCpt['id_producto'] . '\');"><i class="fa fa-file-text-o"></i></button>';
					$btnIng = '<button type="button" class="btn btn-success btn-xs tbn-ing-producto" onclick="reg_resultado(\'' . $idAtencion . '\',\'' . $rowCpt['id_producto'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
					$cnt_validado ++;
				}
			}
		} else {
			$colorstyle = "warning";
			if($rowCpt['id_estado_resul'] == "4"){
				$colorstyle = "success";
				$cnt_validado ++;
			}
		}
		
		echo "<tr>";
		echo "<td class=\"text-center\">".$ip ++."</td>";
		?>
		<td class="text-center">
			<?php if ($ip > 2){?>
				<button type="button" class="btn btn-primary btn-xs" onclick="cambiar_orden_producto('BP',<?php echo $idAtencion;?>, <?php echo $rowCpt['id_producto'];?>);"><i class="glyphicon glyphicon-circle-arrow-up"></i></button>
			<?php } ?>
			<?php if ($ip < $cnt_productos + 1){?>
				<button type="button" class="btn btn-primary btn-xs" onclick="cambiar_orden_producto('SP',<?php echo $idAtencion;?>, <?php echo $rowCpt['id_producto'];?>);"><i class="glyphicon glyphicon-circle-arrow-down"></i></button>
			<?php } ?>
			
		</td>
		<?php 
		echo "<td class='" . $colorstyle . "'><b>" . $rowCpt['nom_producto'] . "</b>";
		?>
		(<span style="font-weight: bold; cursor: pointer;" id="show-datos-adicionales-<?php echo $rowCpt['id_producto']?>" onclick="show_datos_adicionales(<?php echo $rowCpt['id_producto']?>)">+</span>)
		<div id="datos-adicionales-<?php echo $rowCpt['id_producto']?>" style="display: none;">
			<?php
				if($rowCpt['fec_recepciontoma'] <> ""){
				echo "<small>Recibido: " . $rowCpt['fec_recepciontoma']. "</small>"; 
				if($rowCpt['id_estado_resul'] == "2" OR $rowCpt['id_estado_resul'] == "4"){
					echo "<br/><small>Ing. Resul.: (" . $rowCpt['user_ing_resul'] . ") " . $rowCpt['fec_ing_resul'] . "</small>";
						if($rowCpt['user_modif_resul'] <> ""){echo "<br/><small>Mod. Resul.: (" . $rowCpt['user_modif_resul'] . ") " . $rowCpt['fec_modif_resul'] . "</small>";}
						if($rowCpt['user_valid_resul'] <> ""){echo "<br/><small>Val. Resul.: (" . $rowCpt['user_valid_resul'] . ") " . $rowCpt['fec_valid_resul'] . "</small>";}
					}
				} 
			?>
		</div>
		<?php
		echo "</td>";
		echo "<td class=\"text-center\">" . $btnIng . $btnImpr ."</td><td class='text-center'>";
		if ($rowCpt['id_estado_resul'] == '3' OR $rowCpt['id_estado_resul'] == '4'){//3 validado //4entregado pac
		if ($rowCpt['id_estado_envio']=="1"){
		?>
			<input type="checkbox" class="check_atencion_<?php echo $rowCpt['id_atencion']?>" name="txt_<?php echo $rowCpt['id_atencion']?>_<?php echo $rowCpt['id_producto']?>" id="txt_<?php echo $rowCpt['id_atencion']?>_<?php echo $rowCpt['id_producto']?>" value="<?php echo $rowCpt['id_producto']?>" checked/></label>
		<?php
		}}
		echo "</td></tr>";
	  }
		if($cnt_productos <> 1){
			if ($rowCpt['id_estado_resul'] == '1' OR $rowCpt['id_estado_resul'] == '2'){//3 validado //4entregado pac
				echo "<tr><td colspan='3'><b>Mostrar todos los examenes que no fueron validados</b></td>";
				$btnIng = '<button type="button" class="btn btn-primary btn-xs tbn-ing-producto" onclick="reg_resultado(\'' . $idAtencion . '\',\'\');"><i class="glyphicon glyphicon-eject"></i></button>';
				echo "<td class=\"text-center\">" . $btnIng . "</td><td>&nbsp;</td></tr>";
			}
		}
		if($cnt_productos <> 1){
			echo "<tr><td colspan='3'><b>Imprimir todos los resultados</b></td>";
			echo "<td class=\"text-center\">";?>
			<button type="button" class="btn btn-warning btn-xs" onclick="print_resul('<?php echo md5($rsA[0]['id']);?>','<?php echo md5($rsA[0]['id_dependencia']);?>','0','<?php echo $rsA[0]['nombre_rspac']?>')"><i class="fa fa-file-pdf-o"></i></button>
			<?php 
			echo "</td><td></td></tr>";
		}?>
		<tr><td colspan='3'><b>Mostrar resultado(s) a consultorio(s)</b></td></td><td class="text-center">
		<button id="btn_mostrar_resul" type="button" class="btn btn-default btn-xs" onclick="cambio_mostrar_resul('<?php echo $rsA[0]['id'];?>','<?php echo $rsA[0]['nombre_rspac']?>')"><?php echo $rsA[0]['nom_muestra_resul_servicios']?></button>
		</td><td></td></tr>
  <?php
  break;
  case 'POST_REG_CAMBIAR_ORDENEXAMEN':
	$paramReg[0]['accion'] = $_POST['opt'];
	$paramReg[0]['id_atencion'] = $_POST['id_atencion'];
	$paramReg[0]['id_producto'] = $_POST['id_producto'];
	$paramReg[0]['userIngreso'] = $labIdUser;
	/*print_r($paramReg);
	exit();*/
	$rs = $at->post_reg_orden_producto_atencion($paramReg);
	if ($rs == "E") {
		echo "ER|Error al ordenar";
		exit();
	}

	echo "OK|".$rs;
	exit();
  break;
  case 'GET_SHOW_LISTAULTI20EXAMENES':
  $rs = $at->get_datosUtimas20AtencionPorIdDep($_POST['id_dependencia']);
  $nr = count($rs);
  ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
		  <th><small>NRO. ATENCION</small></th>
		  <th><small>NOMBRE DE PACIENTE</small></th>
		  <th><small>NRO. DOCUMENTO</small></th>
		  <th><small>ESTADO RESULTADO</small></th>
		  <th><small>&nbsp;</small></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($nr > 0) {
          foreach ($rs as $row) {
			  $btnEst = '<button type="button" class="btn btn-info btn-xs" onclick="reg_resultado_new(\'' . $row['id'] . '\');"><i class="fa fa-share"></i></button>';
			  $nom_estilo = '';
            //$btnEst = '<button class="btn btn-danger btn-xs" onclick="cambio_estado_dep_comp(\'' . $row['id'] . '\');"><i class="glyphicon glyphicon-remove"></i></button>';
			if($row['id_estado_resul'] == "3"){
				$nom_estilo = 'primary';
			} else if ($row['id_estado_resul'] == "4") {
				$nom_estilo = 'success';
			}
            echo "<tr>";
			if ($_POST['ori'] == "LR"){
				$nro_atencion = $row['nro_atencion_manual'];
			} else {
				$nro_atencion = $row['nro_atencion'] . "-" . $row['anio_atencion'];
			}
            echo "<td class='text-center'><small><b>" . $nro_atencion . "</b></small></td>";
			echo "<td><small>" . $row['nombre_rs'] . "</small></td>";
			echo "<td><small>" . $row['abrev_tipodoc'] . ". " . $row['nrodoc'] . "</small></td>";
			echo "<td class='" . $nom_estilo . "'><small>" . $row['nom_estadoresul'] . "</small></td>";
            echo "<td class='text-center'><small>" . $btnEst . "</small></td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  break;
}
?>
