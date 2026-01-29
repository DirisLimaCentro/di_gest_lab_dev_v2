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

require_once '../../model/Atencion.php';
$at = new Atencion();

$aColumns = array('pro.nom_producto', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'pro.nom_producto';

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
		$sOrder = " Order By la.create_at desc";
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

$param[0]['fecIniAte'] = $input['fecIni'];
$param[0]['fecFinAte'] = $input['fecFin'];
$param[0]['tipo_resultado'] = $input['tipo_resultado'];
$param[0]['id_usuprofesional'] = $input['id_usuprofesional'];
$param[0]['idDepAten'] = $labIdDepUser;
$param[0]['chk_gestante'] = $input['chk_gestante'];
$param[0]['condicion_eg'] = $input['condicion_eg'];
$param[0]['nro_eg'] = $input['nro_eg'];
$param[0]['id_producto'] = $input['id_producto'];
$param[0]['condicion_edad'] = $input['condicion_edad'];
$param[0]['edad_desde'] = $input['edad_desde'];
$param[0]['edad_hasta'] = $input['edad_hasta'];

//print_r($param);
//Aqui se manda los parametros de busqueda
$rResult = $at->get_tblRepDatosProduccionPorFecha($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = $at->get_tblRepCountProduccionPorFecha($sWhere, $param);
/* echo $rResultFilterTotal."Jose";
  exit(); */
list($iFilteredTotal) = $rResultFilterTotal;
$rResultTotal = $at->get_tblRepCountProduccionPorFecha($sWhere, $param);
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

// Voy a mostrar la informaci�n que tiene que ser igual a las cabecera de la tabla (th)
$ebien = '';
foreach ($rResult as $aRow) {
    $row = array();

    for ($i = 0; $i < $iColumnCount; $i++) {
        if (isset($aRow[$aColumns[$i]]))
            $row[] = $aRow[$aColumns[$i]];
    }

	$btnRUA="";
	$btnLab="";
	if($aRow['id_tipo_genera_correlativo'] == "1"){
		$nro_atencion = "<b>".$aRow['nro_atencion']."-".$aRow['anio_atencion']."</b>";
	} else {
		$nro_atencion = substr($aRow['nro_atencion'], 0, 6)."<b>".substr($aRow['nro_atencion'],6)."</b>";
	}
    //$btnRUA = '<button class="btn btn-primary btn-xs" onclick="open_fua(\'' . $aRow['id_atencion'] . '\');"><i class="fa fa-h-square"></i></button>';
    //$btnLab = '<button class="btn btn-success btn-xs" onclick="open_pdf(\'' . $aRow['id_atencion'] . '\');"><i class="fa fa-file-text-o"></i></button>';
    //$btnResul = '<button class="btn btn-primary btn-xs" disabled><i class="glyphicon glyphicon-ok"></i></button>';

    $row = array($aRow['nom_producto'], $nro_atencion,  $aRow['sigla_plan'], $aRow['fec_atencion'], $aRow['fec_ing_resul'], $aRow['usu_ing_resul'], $aRow['fec_valid_resul'], $aRow['usu_valid_resul']);
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
