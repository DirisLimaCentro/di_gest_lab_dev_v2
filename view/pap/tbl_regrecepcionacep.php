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

require_once '../../model/Pap.php';
$pap = new Pap();

$aColumns = array('pap.id_papsoli', '', '', '', '', '', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'pap.id_papsoli';

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
    $sOrder = " Order By pap.id_papsoli";
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

$param[0]['idPapEnv'] = $input['idPapEnv'];
$param[0]['estEnv'] = $input['estEnv'];
//print_r($param);
//Aqui se manda los parametros de busqueda
$rResult = $pap->get_tblDatosSolicitudEnviada($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = $pap->get_tblCountSolicitudEnviada($sWhere, $param);
/* echo $rResultFilterTotal."Jose";
  exit(); */
list($iFilteredTotal) = $rResultFilterTotal;
$rResultTotal = $pap->get_tblCountSolicitudEnviada($sWhere, $param);
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
    if(($aRow['idestado_envdet'] == "3")  OR ($aRow['idestado_envdet'] == "5")){
      $nomEstado = "<span class=\"badge bg-yellow\">" . $aRow['nomestado_envdet'] . "</span>";
    } else if ($aRow['idestado_envdet'] == "4"){
      $nomEstado = "<span class=\"badge bg-red\">" . $aRow['nomestado_envdet'] . "</span>";
    } else {
      $nomEstado = "<span class=\"badge bg-green\">" . $aRow['nomestado_envdet'] . "</span>";
    }
	
	$btnDetRec = '';
	if ($aRow['id_papresul'] == ""){
      $nomEstadoResul = "<span class=\"badge bg-primary\">SIN RESULTADO</span>";
	  $btnDetRec = ' <a href="#" data-target="#showRecModal" class="delete" data-toggle="tooltip" data-placement="top" title="Rechazar muestra" onclick="event.preventDefault(); open_rechazar(\'' . $aRow['id_papenviodet'] . '\', \'' . $aRow['nro_ordensoli']."-".$aRow['anio_ordensoli'] . '\');"><i class="glyphicon glyphicon-remove"></i></a>';
    } else {
      $nomEstadoResul = "<span class=\"badge bg-green\">CON RESULTADO</span>";
    }
	
    $btnDet = '<a href="#" data-target="#editProductModal" class="detail" data-toggle="tooltip" data-placement="top" title="Ver detalle" onclick="event.preventDefault(); open_pdfsinvalor(\'' . $aRow['id_papsoli'] . '\');"><i class="glyphicon glyphicon-eye-open"></i></a>';
	
    $arrNomFalle = explode(" ", $aRow['nombre_pac']);
    $cntNomFalle = count($arrNomFalle);
    $priNomFalle = mb_substr($arrNomFalle[0], 0, 1); // porción1
    $otroNomFalle = "";
    for($i = 1; $i < $cntNomFalle; $i++){
      $otroNomFalle.= "".mb_substr($arrNomFalle[$i], 0, 1);
    }
	
    $row = array($aRow['nro_ordensoli']."-".$aRow['anio_ordensoli'], $aRow['abrev_rspac'].$priNomFalle.$otroNomFalle, $aRow['nombre_rspac'], $aRow['abrev_tipodocpac'] . ": " . $aRow['nro_docpac'], $aRow['nro_hc'], $aRow['nom_sispac'], $aRow['edad_pac'],  $aRow['primer_pap'], $nomEstado . "<br/>" . $nomEstadoResul, $aRow['nro_reglab']."-".$aRow['anio_reglab'], $btnDet.$btnDetRec);
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
