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

require_once '../../model/Atencion.php';
$at = new Atencion();

$aColumns = array('', '', '', '', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = ' la.fec_atencion desc';

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
    $sOrder = " Order By la.fec_atencion desc";
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

if ($_SESSION['labIdRolUser'] == "2"){
	$param[0]['idDepAten'] = 67;
} else {
	$param[0]['idDepAten'] = $labIdDepUser;
}

$param[0]['idServicio'] = $labIdServicio;
$param[0]['nroAte'] = $input['nroAte'];

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

 $param[0]['nroGene'] = '';
 $param[0]['desde_lab_refe'] = '';

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
	$btnEli = '<button type="button" class="btn btn-danger btn-xs" onclick="acc_registro(\'' . $aRow['id'] . '\',\'' . $aRow['nro_atencion_manual'] . '\',\'A\');"><i class="glyphicon glyphicon-trash"></i></button>';
	$btnResul = "";
	$btnRef = "";
	$btnEnvOrion = "";
	$nroAteOrion = "";
	$btnRechazar = '<button type="button" class="btn btn-warning btn-xs" onclick="acc_registro(\'' . $aRow['id'] . '\',\'' . $aRow['nro_atencion_manual'] . '\',\'R\');"><i class="fa fa-thumbs-o-down"></i></button>';

    $nomPac = str_replace("'", "\'", $aRow['nombre_rs']);

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
			$btnEli = '';
			$btnRechazar = '';
		break;
		case "1":
			$btnEdit = '<button type="button" class="btn btn-success btn-xs" onclick="open_edit(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
			$btnCorre = '<button type="button" class="btn btn-primary btn-xs" onclick="reg_recepcionmuestra(\'' . $aRow['id'] . '\',\'' . $nomPac . '\',0,0);"><i class="glyphicon glyphicon-ok"></i></button>';
		break;
		case "2":
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
			$btnEdit = '<button type="button" class="btn btn-success btn-xs" onclick="open_edit(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
			if($aRow['id_estado_resul'] == "2"){
				$btnEdit = '';
			}
			if(($aRow['id_estado_resul'] == "3" OR $aRow['id_estado_resul'] == "4")){
				$btnLab = '<button type="button" class="btn btn-warning btn-xs" onclick="print_resul(\'' . md5($aRow['id']) . '\',\'' . md5($aRow['id_dependencia']) . '\',\'0\',\'' . $nomPac . '\');"><i class="fa fa-file-text-o"></i></button>';
				$btnEdit = '';
				$btnRechazar = '';
			}
			if($aRow['id_estado_resul'] == "4"){
				$btnEntre = '<button type="button" class="btn btn-primary btn-xs" onclick="acc_registro(\'' . $aRow['id'] . '\',\'' . $aRow['nro_atencion'].'-'.$aRow['anio_atencion'] . '\',\'EP\');"><i class="glyphicon glyphicon-user"></i></button>';
				$btnEdit = '';
					$es_referencia = "";
					if($aRow['id_depenori'] <> ""){
						$es_referencia = $aRow['id_depenori'];
					}
				$btnRef = '<button type="button" class="btn btn-success btn-xs" onclick="open_deriva(\'' . $aRow['id'] . '\',\'' . $es_referencia . '\',\'' . $nomPac . '\');"><i class="glyphicon glyphicon-home"></i></button>';
			}
		break;
		case "4":
		break;
		case "5":
			if(($aRow['id_estado_resul'] == "3" OR $aRow['id_estado_resul'] == "4")){
				$btnLab = '<button type="button" class="btn btn-warning btn-xs" onclick="print_resul(\'' . md5($aRow['id']) . '\',\'' . md5($aRow['id_dependencia']) . '\',\'0\',\'' . $nomPac . '\');"><i class="fa fa-file-text-o"></i></button>';
				$btnRechazar = '';
			}
		break;
		case "6":
			$btnRechazar = '';
		break;
	}
	if ($_SESSION['labIdRolUser'] <> "4"){
		if($aRow['id_estado_reg'] <> "0"){
			$btnEdit = '<button type="button" class="btn btn-success btn-xs" onclick="open_edit(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
		}
	}
	if (($_SESSION['labIdRolUser'] == "1") Or ($_SESSION['labIdRolUser'] == "5") Or ($_SESSION['labIdRolUser'] == "14") Or ($_SESSION['labIdRolUser'] == "15") Or ($_SESSION['labIdRolUser'] == "16") Or ($_SESSION['labIdRolUser'] == "10")){
		if(($aRow['id_estado_reg'] <> "0") And ($aRow['id_estado_reg'] <> "6")){
			$btnResul = '<button type="button" class="btn btn-info btn-xs" onclick="reg_resultado(\'' . $aRow['id'] . '\');"><i class="fa fa-share"></i></button>';
			
		}
	}
	if (($_SESSION['labIdRolUser'] == "1")){
		
		if ($aRow['id_atencion_orionlab'] <> '') {
			$nroAteOrion = "<br/>".$aRow['nro_atencion_orionlab']; 
		} else {
			$btnEnvOrion = '<button type="button" class="btn btn-warning btn-xs" onclick="envia_datos_reg_orion(\'' . $aRow['id'] . '\');"><i class="fa fa-paper-plane"></i></button>';
		}
	}
	
	/*
    if ($aRow['id_estado_reg'] == "1"){
      if($aRow['nro_atencion'] == ""){
        $btnCorre = '<button class="btn btn-primary btn-xs" onclick="reg_nroatencion(\'' . $aRow['id'] . '\',\'' . $nomPac . '\');"><i class="glyphicon glyphicon-ok"></i></button>';
        if($aRow['id_estado_resul'] == "1"){

        }
      } else {
		if($_SESSION['labIdRolUser'] == "1" OR $_SESSION['labIdRolUser'] == "2" OR $_SESSION['labIdRolUser'] == "5"){
			if($aRow['id_estado_resul'] == "1"){
			  $btnEdit = '<button class="btn btn-success btn-xs" onclick="open_edit(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
			}
		}
      }
    }
    if($aRow['id_estado_resul'] == "3"){
		$btnDeri = "";
      $btnEntre = '<button class="btn btn-primary btn-xs" onclick="reg_entrega(\'' . $aRow['id'] . '\',\'' . $nomPac . '\');"><i class="glyphicon glyphicon-user"></i></button>';
    }
    if($aRow['id_estado_resul'] == "3" OR $aRow['id_estado_resul'] == "4"){
		$btnDeri = "";
	  $btnLab = '<button class="btn btn-warning btn-xs" onclick="print_resul(\'' . md5($aRow['id']) . '\',\'' . md5($aRow['id_dependencia']) . '\',\'0\',\'' . $nomPac . '\');"><i class="fa fa-file-text-o"></i></button>';
    }*/
	
	if ($_SESSION['labIdRolUser'] == "2"){
		$btnEli = '';
		$btnResul = "";
		$btnRechazar = '';
	}
	
    $row = array($aRow['id'], $aRow['nro_atencion_manual'], $aRow['nombre_rs'], $aRow['abrev_tipodoc'].": ".$aRow['nrodoc'],  $aRow['nom_depenori'], $aRow['sigla_plan'], $aRow['fec_atencion'], $aRow['fec_toma_muestra'], $aRow['nom_estadoreg'], $aRow['nom_estadoresul'], $btnRechazar . $btnResul . $btnEli);
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
