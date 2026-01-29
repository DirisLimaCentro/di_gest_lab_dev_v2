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

$aColumns = array('', 'la.nro_atencion', '', '', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'la.nro_atencion';

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

$param[0]['id_producto'] = $input['id_producto'];
$param[0]['id_dependencia'] = $labIdDepUser;
$param[0]['id_dependencia_origen'] = $input['id_dependencia_origen'];

//Aqui se manda los parametros de busqueda
$rResult = $lab->get_tblDatosProductoEnviadosPorClasificar($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = 0;
if(isset($rResult[0]["cant_rows"])){$rResultFilterTotal = $rResult[0]["cant_rows"];}

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
/*print_r($rResult);
exit();*/
foreach ($rResult as $aRow) {
    $row = array();

    for ($i = 0; $i < $iColumnCount; $i++) {
        if (isset($aRow[$aColumns[$i]]))
            $row[] = $aRow[$aColumns[$i]];
    }
    $btnAcet = '<a href="#" data-target="#editProductModal" class="acept" data-toggle="tooltip" data-placement="top" title="Ver detalle" onclick="event.preventDefault(); event.stopPropagation(); aceptar_muestra(\'' . $aRow['id'] . '\'); "><i class="fa fa-check"></i></a>';
    $btnRecha = '<a href="#" data-target="#editProductModal" class="delete" data-toggle="tooltip" data-placement="top" title="Ver detalle" onclick="event.preventDefault(); event.stopPropagation(); abrirModalRechazo(\'' . $aRow['id'] . '\');"><i class="fa fa-ban"></i></a>';
	
    $idcod = $aRow['id'];
	
    $row = array($idcod, $btnAcet . ' ' . $btnRecha,  $aRow['nro_atencion'], $aRow['nombre_paciente'] . "<br/>" . $aRow['abrev_tipodoc'] . ": " . $aRow['nrodoc'], $aRow['dependencia_origen'], $aRow['fecha_toma_muestra'], $aRow['fecha_envio_destino'], $aRow['cnt_dia']);
	//$row = array($idcod, "", "", "", "", "", "", "", "","");
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
