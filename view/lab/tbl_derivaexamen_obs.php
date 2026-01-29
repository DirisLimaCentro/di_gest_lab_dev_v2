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

require_once '../../model/Lab.php';
$lab = new Lab();

$aColumns = array('env.create_env', 'env.create_env', '', '', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'env.create_env';

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

$param[0]['id_dependencia'] = $labIdDepUser;
$param[0]['id_producto'] = $input['id_producto'];
$param[0]['id_dependencia_destino'] = $input['id_dependencia_destino'];
$param[0]['datos_pac'] = $input['datos_pac'];

//Aqui se manda los parametros de busqueda
$rResult = $lab->get_tblDatosProductoObservadas($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = 0;
$recordsFiltered  = 0;
if (isset($rResult[0]['cant_rows'])) {
    $recordsFiltered = intval($rResult[0]['cant_rows']);
}
// total sin filtrar (si usas el mismo para ambos, igual funciona)
$recordsTotal = $recordsFiltered;
// preparar la salida
$output = array(
    "iTotalRecords" => $recordsTotal,
    "iTotalDisplayRecords" => $recordsFiltered,
    "aaData" => array()
);

foreach ($rResult as $aRow) {
    $output['aaData'][] = array(
        "fecha_envio"  => $aRow['fecha_envio'],
        "paciente"   => "<b>" . $aRow['nombre_paciente'] . "</b><br/>" . $aRow['abrev_tipodoc'] . ": " . $aRow['nrodoc'] . " - ATENCIÓN: " . $aRow['nro_atencion'] . "",
        "producto"      =>  $aRow['producto'],
        "dependencia_destino"=> $aRow['dependencia_destino'],
        "fecha_recibe_destino"=> $aRow['fecha_recibe_destino'],
        "motivo_rechazo"=> $aRow['motivo_rechazo'],
        "detalle_motivo_rechazo"=> $aRow['detalle_motivo_rechazo']
    );
}
echo json_encode($output);
?>
