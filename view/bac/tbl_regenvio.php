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

require_once '../../model/Bacteriologia.php';
$bac = new Bacteriologia();

$aColumns = array('', 'bac.nro_atencion', 'bac.fec_atencion', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'bac.nro_atencion';

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
    $sOrder = " Order By " . implode(", ", $aOrderingRules);
} else {
    $sOrder = "";
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

$param[0]['idDepAten'] = $labIdDepUser;
//print_r($param);
//Aqui se manda los parametros de busqueda
$rResult = $bac->get_tblDatosSolicitudNoEnviada($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = $bac->get_tblCountSolicitudNoEnviada($sWhere, $param);
/* echo $rResultFilterTotal."Jose";
  exit(); */
list($iFilteredTotal) = $rResultFilterTotal;
$rResultTotal = $bac->get_tblCountSolicitudNoEnviada($sWhere, $param);
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
foreach ($rResult as $aRow) {
    $row = array();

    for ($i = 0; $i < $iColumnCount; $i++) {
        if (isset($aRow[$aColumns[$i]]))
            $row[] = $aRow[$aColumns[$i]];
    }
    $btnDet = '<a href="#" data-target="#editProductModal" class="detail" data-toggle="tooltip" data-placement="top" title="Ver detalle" onclick="open_pdfsinvalor(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-eye-open"></i></a>';
    $idcod = $aRow['id'];
	
    $row = array($idcod, $aRow['nro_atencion'] ."-".$aRow['anio_atencion'], $aRow['fec_atencion'], $aRow['nombre_rspac'], $aRow['abrev_tipodocpac'] . ": " . $aRow['nro_docpac'], $aRow['nro_hc'], $aRow['nombre_profe'],$btnDet);
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
