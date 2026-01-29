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

require_once '../../model/Dependencia.php';
$d = new Dependencia();

$aColumns = array('d.codref_depen', 'd.abrev_depen', 'd.nom_depen', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'd.codref_depen';

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
            $aFilteringRules[] = "UPPER(" . $aColumns[$i] . ") LIKE UPPER('%" . $input['sSearch'] . "%')";
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
		Where  " . implode(" AND ", $aFilteringRules);
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

$param[0]['idEstado'] = '';

//Aqui se manda los parametros de busqueda
$rResult = $d->get_tblDatosDependencia($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = $d->get_tblCountDependencia($sWhere, $param);
/* echo $rResultFilterTotal."Jose";
  exit(); */
list($iFilteredTotal) = $rResultFilterTotal;
$rResultTotal = $d->get_tblCountDependencia($sWhere, $param);
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

    $btnEdit = '<button type="button" class="btn btn-success btn-xs" onclick="edit_registro(\'' . $aRow['id_dependencia'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
    $btnAcce = '<button type="button" class="btn btn-primary btn-xs" onclick="open_servicio(\'' . $aRow['id_dependencia'] . '\',\'' . $aRow['nom_depen'] . '\');"><i class="glyphicon glyphicon-list-alt"></i></button>';

    if ($aRow['id_estado'] == "1") {
        $styleEst = "bg-green";
    } else {
        $styleEst = "bg-red";
    }

    $nomEstado = '<span class="badge ' . $styleEst . '"><small>' . $aRow['nom_estado'] . '</small></span>';
    $row = array($aRow['codref_depen'], $aRow['abrev_depen'],  $aRow['nom_depen'], $aRow['cat_depen'], $aRow['nom_tipdepen'], $aRow['direc_depen'], $aRow['cnt_servicio'],$nomEstado, $btnEdit.$btnAcce);
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
