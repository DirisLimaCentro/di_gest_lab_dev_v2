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

require_once '../../model/Atencion.php';
$at = new Atencion();

$aColumns = array('la.fec_atencion', 'la.fec_atencion', '', '', '', '', '', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'la.fec_atencion';

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
  $sOrder = " Order By la.fec_atencion";
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
$param[0]['fecIniAte'] = "";//Solo para el caso de la ventana de admisión
$param[0]['fecFinAte'] = "";//Solo para el caso de la ventana de admisión
$param[0]['chk_ing_resul'] = '1'; //Con esto digo que sera para resultado. Campo=>chk_ingresa_resultado
 
$param[0]['idDepAten'] = $labIdDepUser;
$param[0]['idServicio'] = "";
$param[0]['chk_referencia'] = '1';
$param[0]['nroAte'] = $input['nroAte'];

if(($input['nroAte'] <> "") OR ($input['nroDoc'] <> "") OR ($input['nomRS'] <> "")){
  $param[0]['chk_referencia'] = "";
} else {
	
}


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

// Voy a mostrar la informaci�n que tiene que ser igual a las cabecera de la tabla (th)
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
  $btnResul = "";
  $btnEntre = "";
  $btnFUA = "";
  $btnREF = "";

  $nomPac = str_replace("'", "\'", $aRow['nombre_rs']);
/*
  if($aRow['nro_fua'] <> ""){
    $btnRUA = '<button class="btn btn-primary btn-xs" onclick="open_fua(\'' . $aRow['id_atencion'] . '\');"><i class="fa fa-h-square"></i></button>';
  }
  */
  if($aRow['id_estado_resul'] == "3" OR $aRow['id_estado_resul'] == "4"){
	$btnLab = '<button class="btn btn-warning btn-xs" onclick="print_resul(\'' . md5($aRow['id']) . '\',\'' . md5($aRow['id_dependencia']) . '\',\'0\',\'' . $nomPac . '\');"><i class="fa fa-file-text-o"></i></button>';
	
	$btnFUA = '<button class="btn btn-primary btn-xs" onclick="open_fua(\'' . $aRow['id'] . '\');"><i class="fa fa-h-square"></i></button>';
	$btnREF = '<button class="btn btn-info btn-xs" onclick="open_ref(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-share"></i></button>';
  }

  $row = array($aRow['id'], $aRow['nro_atencion']."-".$aRow['anio_atencion'], $aRow['abrev_plan'], $aRow['nombre_rs'], $aRow['abrev_tipodoc'].": ".$aRow['nrodoc'],  $aRow['nro_hc'], $aRow['fec_atencion'], $aRow['nom_estadoreg'], $aRow['nom_estadoresul'], $btnLab.$btnFUA.$btnREF);
  $output['aaData'][] = $row;
}
echo json_encode($output);
?>
