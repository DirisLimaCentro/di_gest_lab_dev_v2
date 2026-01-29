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
$labIdRolUser = $_SESSION['labIdRolUser'];

require_once '../../model/Pap.php';
$pap = new Pap();

$aColumns = array('d.nom_depen', 'd.nom_depen', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'd.nom_depen';

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
  $sOrder = " Orde By pap.fec_atencion";
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

$param[0]['id_estadoenvminsa'] = $input['id_estadoenvminsa'];
$param[0]['fec_ini'] = $input['fec_ini'];
$param[0]['fec_fin'] = $input['fec_fin'];
//print_r($param);
//Aqui se manda los parametros de busqueda
$rResult = $pap->get_tblDatosSolicitudEnviadaHISMINSA($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = $pap->get_tblCountSolicitudEnviadaHISMINSA($sWhere, $param);
/* echo $rResultFilterTotal."Jose";
exit(); */
list($iFilteredTotal) = $rResultFilterTotal;
$rResultTotal = $pap->get_tblCountSolicitudEnviadaHISMINSA($sWhere, $param);
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
$ebien = '';
foreach ($rResult as $aRow) {
  $row = array();

  for ($i = 0; $i < $iColumnCount; $i++) {
    if (isset($aRow[$aColumns[$i]]))
    $row[] = $aRow[$aColumns[$i]];
  }
  $btnDet = ' <a href="#" data-target="#editProductModal" class="detail" data-toggle="tooltip" data-placement="top" title="Ver ficha de atención" onclick="event.preventDefault();open_pdfsinvalor(\'' . $aRow['id_papsoli'] . '\');">'.$aRow['nro_ordensoli'].'</a>';

  $row = array($aRow['nom_depen'], $btnDet, $aRow['fec_atencion'], $aRow['nom_sispac'], $aRow['nombre_rspac'], $aRow['abrev_tipodocpac'].": ".$aRow['nro_docpac'], $aRow['nro_hc'], $aRow['estadoenvminsa'], $aRow['fec_envminsa'], $aRow['descrip_obsenvminsa'], $aRow['id_citaminsa']);
  $output['aaData'][] = $row;
}
echo json_encode($output);
?>
