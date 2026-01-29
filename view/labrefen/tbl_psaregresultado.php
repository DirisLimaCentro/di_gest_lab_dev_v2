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

if($_POST['id_estado'] == "1"){
	$aColumns = array('env.create_received_at', 'd.nom_depen', '', '', '', '', '', '', '', '', '', ''); 
} else {
	$aColumns = array('envd.id', 'env.create_received_at', '', '', '', '', '', '', 'labresul.det_resul', ''); 	
}
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'envd.id';

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
    $sOrder = " Order By envd.id";
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

$param[0]['id_estado'] = $input['id_estado'];
//print_r($param);
//Aqui se manda los parametros de busqueda
$rResult = $lab->get_tblDatosIngResultadoPSA($sWhere, $sOrder, $sLimit, $param);
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
foreach ($rResult as $aRow) {
    $row = array();

    for ($i = 0; $i < $iColumnCount; $i++) {
        if (isset($aRow[$aColumns[$i]]))
            $row[] = $aRow[$aColumns[$i]];
    }
	
	$btnDet = '';	
	$btnIngResul = '';
	if($input['id_estado'] == "1"){
		$btnIngResul = ' <a href="#" data-target="#editProductModal" class="acept" data-toggle="tooltip" data-placement="top" title="Registrar resultado" onclick="openFormIngResul(\'' . $aRow['id_atencion'] . '\',\'' . $aRow['abrev_tipodocpac'] . ": " . $aRow['nro_docpac'] . '\');"><i class="glyphicon glyphicon-ok"></i></a>';
		$row = array($aRow['fecha_recepcion'], $aRow['nom_dependencia_origen'], $aRow['abrev_tipodocpac'] . ": " . $aRow['nro_docpac'], $aRow['nombre_rspac'], $aRow['nro_envio']."-".$aRow['anio_envio'], $aRow['fec_envio'], $aRow['nro_atencion']."-".$aRow['anio_atencion'], $aRow['cod_ref_nro_atencion'], $btnDet.$btnIngResul);
	} else {
		$idcod = $aRow['id_resuldet'];
		$btnIngResul = ' <a href="#" data-target="#editProductModal" class="acept" data-toggle="tooltip" data-placement="top" title="Validar y agregar comentario" onclick="openFormIngResulValid(\'' . $aRow['id_resuldet'] . '\',\'' . $aRow['abrev_tipodocpac'] . ": " . $aRow['nro_docpac'] . '\',\'' . $aRow['cod_ref_nro_atencion'] . '\',\'' . $aRow['det_resul'] . '\',\'' . $aRow['fecha_resultado'] . '\');"><i class="glyphicon glyphicon-ok"></i><i class="glyphicon glyphicon-ok"></i></a>';
		$row = array($idcod, $aRow['fecha_recepcion'], $aRow['nom_dependencia_origen'], $aRow['abrev_tipodocpac'] . ": " . $aRow['nro_docpac'], $aRow['nombre_rspac'], $aRow['nro_envio']."-".$aRow['anio_envio'], $aRow['fec_envio'],$aRow['nro_atencion']."-".$aRow['anio_atencion'], $aRow['cod_ref_nro_atencion'], $aRow['det_resul'], $btnIngResul);		
	}
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
