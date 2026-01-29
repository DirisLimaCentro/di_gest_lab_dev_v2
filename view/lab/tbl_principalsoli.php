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
$labIdServicio = $_SESSION['labIdServicio'];
$envia_americana = $_SESSION['labEnvAmericana'];
$envia_diagnostica = $_SESSION['labEnvDiagnostica'];

require_once '../../model/Atencion.php';
$at = new Atencion();

$aColumns = array('', 'la.anio_atencion desc, la.nro_atencion', '', '', '', '', '', 'la.fec_cita', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = ' la.anio_atencion desc, la.nro_atencion desc';

// DB table to use
//$sTable = 'tbl_equipos'; // Nama Tabel
// Database connection information
//$gaSql['port']     = 5433; // 3306 is the default MySQL port
// Input method (use $_GET, $_POST or $_REQUEST)
$input = & $_POST;

$gaSql['charset'] = 'utf8';

/**
 * MySQL connection
 */
//$db = pg_connect($gaSql['server'], $gaSql['port'],$gaSql['db'] ,$gaSql['user'], $gaSql['password']);

/* if (!$db->set_charset($gaSql['charset'])) {
  die( 'Error loading character set "'.$gaSql['charset'].'": '.$db->error );
  }
 */

/**
 * Paging
 */
$sLimit = "";
if (isset($input['iDisplayStart']) && $input['iDisplayLength'] != '-1') {
    $sLimit = " LIMIT " . intval($input['iDisplayLength']) . " OFFSET " . intval($input['iDisplayStart']);
}


/**
 * Ordering
 */
$aOrderingRules = array();
if (isset($input['iSortCol_0'])) {
    $iSortingCols = intval($input['iSortingCols']);
    for ($i = 0; $i < $iSortingCols; $i++) {
        if ($input['bSortable_' . intval($input['iSortCol_' . $i])] == 'true') {
            $aOrderingRules[] = "" . $aColumns[intval($input['iSortCol_' . $i])] . " "
                    . ($input['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc');
        }
    }
}

if (!empty($aOrderingRules)) {
    $sOrder = " ORDER BY " . implode(", ", $aOrderingRules);
} else {
	if ($_SESSION['labIdTipoCorrelativo'] == "1"){
		$sOrder = " Order By la.anio_atencion desc, la.nro_atencion desc";
	} else {
		$sOrder = " Order By la.fec_cita desc, la.nro_atencion desc";
	}
}


/**
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here, but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */
$iColumnCount = count($aColumns);
if (isset($input['sSearch']) && $input['sSearch'] != "") {
    $aFilteringRules = array();
    for ($i = 0; $i < $iColumnCount; $i++) {
        if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true') {
            $aFilteringRules[] = "" . $aColumns[$i] . " LIKE '%" . $input['sSearch'] . "%'";
        }
    }
    if (!empty($aFilteringRules)) {
        $aFilteringRules = array('(' . implode(" OR ", $aFilteringRules) . ')');
    }
}

// Individual column filtering
for ($i = 0; $i < $iColumnCount; $i++) {
    if (isset($input['bSearchable_' . $i]) && $input['bSearchable_' . $i] == 'true' && $input['sSearch_' . $i] != '') {
        $aFilteringRules[] = "" . $aColumns[$i] . " LIKE '%" . mb_strtoupper(pg_escape_string($input['sSearch_' . $i]), 'UTF-8') . "%'";
    }
}

/* 	if (!empty($aFilteringRules)) {
  $sWhere = " WHERE idestado_mov = '2' and tm.dep_recibe='".$_SESSION['id_dep']."'
  AND
  to_char(tm.fec_deriva,'dd/mm/yyyy hh:mi:ss') = (select to_char(max(tmm.fec_deriva),'dd/mm/yyyy hh:mi:ss') FROM tbl_ht_movimiento tmm)
  and tm.usu_recibe='".$_SESSION['id_usuario']."'
  and  ".implode(" AND ", $aFilteringRules);
  } else {
  $sWhere = " WHERE idestado_mov = '2' and tm.dep_recibe='".$_SESSION['id_dep']."'
  AND
  to_char(tm.fec_deriva,'dd/mm/yyyy hh:mi:ss') = (select to_char(max(tmm.fec_deriva),'dd/mm/yyyy hh:mi:ss') FROM tbl_ht_movimiento tmm)
  and tm.usu_recibe='".$_SESSION['id_usuario']."'
  ";
  } */


if (!empty($aFilteringRules)) {
    $sWhere = "
		and  " . implode(" AND ", $aFilteringRules);
} else {
    $sWhere = "
		";
}


/**
 * SQL queries
 * Get data to display
 */
$aQueryColumns = array();
foreach ($aColumns as $col) {
    if ($col != ' ') {
        $aQueryColumns[] = $col;
    }
}

$param[0]['idTipDoc'] = $input['idTipDoc'];
$param[0]['nroDoc'] = $input['nroDoc'];
$param[0]['nomRS'] = $input['nomRS'];
$param[0]['fecIniAte'] = $input['fecIni'];
$param[0]['fecFinAte'] = $input['fecFin'];

$param[0]['idDepAten'] = $labIdDepUser;
$param[0]['idServicio'] = $labIdServicio;
$param[0]['nroAte'] = $input['nroAte'];

$param[0]['nroAteOtro'] = $input['nroAteOtro'];
$param[0]['optUrgente'] = $input['optUrgente'];
$param[0]['idProducto'] = $input['idProducto'];

if($input['nroAte'] <> ""){
   $param[0]['idEstAte'] = "";
   $param[0]['fecIniAte'] = "";
   $param[0]['fecFinAte'] = "";
}

if($input['nomRS'] <> ""){
   $param[0]['idEstAte'] = "";
   $param[0]['fecIniAte'] = "";
   $param[0]['fecFinAte'] = "";
}

if($input['nroDoc'] <> ""){
   $param[0]['idEstAte'] = "";
   $param[0]['fecIniAte'] = "";
   $param[0]['fecFinAte'] = "";
}

if($input['nroAteOtro'] <> ""){
   $param[0]['idEstAte'] = "";
   $param[0]['fecIniAte'] = "";
   $param[0]['fecFinAte'] = "";
}

 $param[0]['nroGene'] = '';

//print_r($param);
//Aqui se manda los parametros de busqueda
$rResult = $at->get_tblDatosAtencion($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = $at->get_tblCountAtencion($sWhere, $param);
/* echo $rResultFilterTotal."Jose";
  exit(); */
list($iFilteredTotal) = $rResultFilterTotal;
$rResultTotal = $at->get_tblCountAtencion($sWhere, $param);
//$rResultTotal = $rResultFilterTotal;
list($iTotal) = $rResultTotal;


/**
 * Output
 */
$output = array(
    //"sEcho"                => intval($input['sEcho']),
    "iTotalRecords" => $rResultFilterTotal,
    "iTotalDisplayRecords" => $rResultFilterTotal,
    "aaData" => array(),
);

// Voy a mostrar la información que tiene que ser igual a las cabecera de la tabla (th)
$correTipoPlanDep = 1;
$nroTipoPlanDep = "";
foreach ($rResult as $aRow) {
    $row = array();

    for ($i = 0; $i < $iColumnCount; $i++) {
        if (isset($aRow[$aColumns[$i]]))
            $row[] = $aRow[$aColumns[$i]];
    }

    $btnFUA = "";
    $btnLab = "";
    $btnCorre = "";
    $btnEntre = "";
    $btnEdit = "";
	$btnDeri = "";
	$btnEli = "";
	$btnAte = "";
	$btnResul = "";
	$btnEnvOrion = "";
	$nroAteOrion = "";
	$btnNoAsistio = "";
	$btnTicket = "";
	$btnEnvDiagnostica = "";
	$btnRef = "";
	$btnEditPer = "";
	
    $nomPac = str_replace("'", "\'", $aRow['nombre_rs']);

	if($aRow['id_tipo_genera_correlativo'] == "1"){
		$nro_atencion = "<b>".$aRow['nro_atencion']."-".$aRow['anio_atencion']."</b>";
	} else {
		$nro_atencion = substr($aRow['nro_atencion'], 0, 6)."<b>".substr($aRow['nro_atencion'],6)."</b>";
	}
	
	$es_urgencia = "";
	$es_referencia = "";
	if($aRow['id_depenori'] <> ""){
		$es_referencia = $aRow['id_depenori'];
	}
	$btnRef = '<button type="button" class="btn btn-success btn-xs" onclick="open_deriva(\'' . $aRow['id'] . '\',\'' . $es_referencia . '\',\'' . $nomPac . '\');"><i class="glyphicon glyphicon-home"></i></button>';
	
	
	if($aRow['id_plantarifario'] == "1"){
		if($aRow['chk_genera_fua'] == "f"){
			//$btnFUA = '<button type="button" class="btn btn-success btn-xs" onclick="open_fua(\'' . $aRow['id'] . '\');"><i class="fa fa-h-square"></i></button>';
		} else {
			//$btnFUA = '<button type="button" class="btn btn-primary btn-xs" onclick="imprime_fua(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-print"></i></button>';
		}
	}
	
	switch ($aRow['id_estado_reg']) {
		case "0":
			$btnFUA = '';
		break;
		case "1":
			$btnEdit = '<button type="button" class="btn btn-success btn-xs" onclick="open_edit(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
			$btnCorre = '<button type="button" class="btn btn-primary btn-xs" onclick="reg_recepcionmuestra(\'' . $aRow['id'] . '\',\'' . $nomPac . '\',0,0);"><i class="glyphicon glyphicon-ok"></i></button>';
			$btnAte = '<button type="button" class="btn btn-info btn-xs" onclick="imprime_orden(\'' . md5($aRow['id']) . '\',\'' . md5($aRow['id_dependencia']) . '\');"><i class="fa fa-file-text-o"></i></button>';
			$btnNoAsistio = '<button type="button" class="btn btn-default btn-xs" onclick="acc_registro(\'' . $aRow['id'] . '\',\'' . $nro_atencion . '\',\'PNA\');"><i class="fa fa-user-times"></i></button>';
		break;
		case "2":
			$btnAte = '<button type="button" class="btn btn-info btn-xs" onclick="imprime_orden(\'' . md5($aRow['id']) . '\',\'' . md5($aRow['id_dependencia']) . '\');"><i class="fa fa-file-text-o"></i></button>';
			$btnEdit = '<button type="button" class="btn btn-success btn-xs" onclick="open_edit(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
			$btnCorre = '<button type="button" class="btn btn-primary btn-xs" onclick="reg_recepcionmuestra(\'' . $aRow['id'] . '\',\'' . $nomPac . '\',0,0);"><i class="glyphicon glyphicon-ok"></i></button>';
			if($aRow['id_estado_resul'] == "2"){
				$btnEdit = '';
			}
			if(($aRow['id_estado_resul'] == "3" OR $aRow['id_estado_resul'] == "4")){
				$btnLab = '<button type="button" class="btn btn-warning btn-xs" onclick="print_resul(\'' . md5($aRow['id']) . '\',\'' . md5($aRow['id_dependencia']) . '\',\'0\',\'' . $nomPac . '\');"><i class="fa fa-file-text-o"></i></button>';
				$btnEdit = '';
			}
		break;
		case "3":
			$btnAte = '<button type="button" class="btn btn-info btn-xs" onclick="imprime_orden(\'' . md5($aRow['id']) . '\',\'' . md5($aRow['id_dependencia']) . '\');"><i class="fa fa-file-text-o"></i></button>';
			$btnEdit = '<button type="button" class="btn btn-success btn-xs" onclick="open_edit(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
			if($aRow['id_estado_resul'] == "2"){
				$btnEdit = '';
			}
			if(($aRow['id_estado_resul'] == "3" OR $aRow['id_estado_resul'] == "4")){
				$btnLab = '<button type="button" class="btn btn-warning btn-xs" onclick="print_resul(\'' . md5($aRow['id']) . '\',\'' . md5($aRow['id_dependencia']) . '\',\'0\',\'' . $nomPac . '\');"><i class="fa fa-file-text-o"></i></button>';
				$btnEdit = '';
			}
			if($aRow['id_estado_resul'] == "4"){
				$btnEntre = '<button type="button" class="btn btn-primary btn-xs" onclick="acc_registro(\'' . $aRow['id'] . '\',\'' . $aRow['nro_atencion'].'-'.$aRow['anio_atencion'] . '\',\'EP\');"><i class="glyphicon glyphicon-user"></i></button>';
				$btnEdit = '';
			}
		break;
		case "4":
		break;
		case "5":
			if(($aRow['id_estado_resul'] == "3" OR $aRow['id_estado_resul'] == "4")){
				$btnLab = '<button type="button" class="btn btn-warning btn-xs" onclick="print_resul(\'' . md5($aRow['id']) . '\',\'' . md5($aRow['id_dependencia']) . '\',\'0\',\'' . $nomPac . '\');"><i class="fa fa-file-text-o"></i></button>';
			}
		break;
		case "7":
			$btnNoAsistio = '<button type="button" class="btn btn-default btn-xs" onclick="acc_registro(\'' . $aRow['id'] . '\',\'' . $nro_atencion . '\',\'PA\');"><i class="fa fa-user-plus"></i></button>';
		break;
	}
	if ($_SESSION['labIdRolUser'] <> "4"){
		if($aRow['id_estado_reg'] <> "0"){
			$btnEdit = '<button type="button" class="btn btn-success btn-xs" onclick="open_edit(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
		}
	}
	if (($_SESSION['labIdRolUser'] == "1") Or ($_SESSION['labIdRolUser'] == "5") Or ($_SESSION['labIdRolUser'] == "14") Or ($_SESSION['labIdRolUser'] == "15") Or ($_SESSION['labIdRolUser'] == "2")){
		if($aRow['id_estado_reg'] <> "0"){
			$btnResul = '<button type="button" class="btn btn-info btn-xs" onclick="reg_resultado(\'' . $aRow['id'] . '\');"><i class="fa fa-share"></i></button>';
		}
	}
	if (($_SESSION['labIdRolUser'] == "1") Or ($_SESSION['labIdRolUser'] == "2") Or ($_SESSION['labIdRolUser'] == "5") Or ($_SESSION['labIdRolUser'] == "15")){ //15 Sissy, 5 resp. eess 2 resp. diris
		$btnEditPer = '<a onclick="open_edit_persona(\'' . $aRow['id'] . '\');" class="text-success" style="cursor: pointer;"><i class="glyphicon glyphicon-pencil"></i></a>';
	}
	
	if ($aRow['id_atencion_orionlab'] <> '') {
		$nroAteOrion = "<br/>".$aRow['nro_atencion_orionlab']; 
		if($aRow['id_estado_resul'] <> "4"){
			$btnEnvOrion = '<button type="button" class="btn btn-primary btn-xs" onclick="envia_datos_edit_orion(\'' . $aRow['id'] . '\');"><i class="fa fa-paper-plane"></i></button>';
		}
		$btnEli = '<button type="button" class="btn btn-danger btn-xs" onclick="acc_registro(\'' . $aRow['id'] . '\',\'' . $aRow['nro_atencion'].'-'.$aRow['anio_atencion'] . '\',\'AoS\');"><i class="glyphicon glyphicon-trash"></i></button>';
	} else {
		if($aRow['id_estado_resul'] <> "4"){
			$btnEnvOrion = '<button type="button" class="btn btn-info btn-xs" onclick="envia_datos_reg_orion(\'' . $aRow['id'] . '\');"><i class="fa fa-paper-plane"></i></button>';
		}
		$btnEli = '<button type="button" class="btn btn-danger btn-xs" onclick="acc_registro(\'' . $aRow['id'] . '\',\'' . $aRow['nro_atencion'].'-'.$aRow['anio_atencion'] . '\',\'A\');"><i class="glyphicon glyphicon-trash"></i></button>';
	}
	if ($envia_diagnostica <> 0){
		if ($aRow['id_atencion_diagnostica'] <> '') {
			if($aRow['id_estado_resul'] <> "4"){
				$btnEnvDiagnostica = '<button type="button" class="btn btn-env-diagnostica_edit btn-xs" onclick="envia_datos_edit_diagnostica(\'' . $aRow['id'] . '\',\'' . $aRow['nro_atencion'].'-'.$aRow['anio_atencion'] . '\');"><i class="fa fa-paper-plane"></i></button>';
			}
		} else {
			if($aRow['id_estado_resul'] <> "4"){
				$btnEnvDiagnostica = '<button type="button" class="btn btn-env-diagnostica btn-xs" onclick="envia_datos_reg_diagnostica(\'' . $aRow['id'] . '\',\'' . $aRow['nro_atencion'].'-'.$aRow['anio_atencion'] . '\');"><i class="fa fa-paper-plane"></i></button>';			
			}
		}
		$btnTicket = '<button type="button" class="btn btn-env-diagnostica btn-xs" onclick="imprime_ticket(\'' . $aRow['id'] . '\',\'' . $aRow['nro_atencion'].'-'.$aRow['anio_atencion'] . '\');"><i class="fa fa-address-card"></i></button>';
	}
	
	if($aRow['id_depenori'] <> ""){
		$es_referencia = "-R";
	}
	if($aRow['check_urgente'] == "t"){
		$es_urgencia = "-U";
	}
	if(trim($aRow['id_atencion_procesa']) == ""){
		$estilo_origen = " text-primary";
	} else {
		$estilo_origen = " text-inmuno";
	}
	if(trim($aRow['nom_depenori']) == ""){
		$nom_procedencia = "";
	} else {
		$nom_procedencia = "<br/><small class='label bg-purple'>" . $aRow['nom_depenori'] . "</small>";
	}
	
    $row = array($aRow['id'], $nro_atencion.$es_urgencia.$es_referencia.$nroAteOrion, "<b><i class='fa fa-pause " . $estilo_origen . "'>&nbsp;</i>" . $aRow['abrev_tipodoc'].": ".$aRow['nrodoc'] . "</b> " . $btnEditPer . "<br/>" . $aRow['nombre_rs'] . $nom_procedencia ,  $aRow['nro_hc'], $aRow['abrev_plan'], $aRow['fec_atencion'], $aRow['fec_cita'], $aRow['nom_estadoreg'], $aRow['nom_estadoresul'], $btnNoAsistio.$btnLab.$btnAte.$btnEdit.$btnCorre.$btnFUA.$btnDeri.$btnEnvOrion.$btnResul.$btnEntre.$btnRef.$btnEli.$btnTicket.$btnEnvDiagnostica);
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
