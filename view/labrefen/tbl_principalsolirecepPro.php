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

$aColumns = array('env.create_received_at', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'env.create_received_at';

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
    $sOrder = " Order By env.create_received_at desc";
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

if($input['opt'] == "LAB"){
	$param[0]['id_dependencia'] = $input['idDepRef'];
	$param[0]['id_producto'] = '60';//PSA
} else {
	$param[0]['id_dependencia'] = $labIdDepUser;
	$param[0]['id_producto'] = '';
}
$param[0]['id_estado_reg'] = $input['id_estado'];
//print_r($param);
//Aqui se manda los parametros de busqueda
$rResult = $lab->get_tblDatosEnvio($sWhere, $sOrder, $sLimit, $param);
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
$ebien = '';
foreach ($rResult as $aRow) {
    $row = array();

    for ($i = 0; $i < $iColumnCount; $i++) {
        if (isset($aRow[$aColumns[$i]]))
            $row[] = $aRow[$aColumns[$i]];
    }
    //Aqui agrego primer boton
	$btnRec = '';
	$btnObs = '';
	$btnPrintValid = '';
	$btnobs = '';
	$btnDet = ' <button type="button" class="btn btn-success btn-xs" title="Ver lista de muestras" onclick="open_detalle(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-eye-open"></i></button>';
	if($input['opt'] == "LAB"){
		if($input['id_estado'] == "2"){
			$btnRec = ' <a href="#" data-target="#editProductModal" class="acept" data-toggle="tooltip" data-placement="top" title="Recepcionar envio" onclick="reg_proceso(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-ok"></i></a>';
			if($aRow['cnt_solirechazada'] <> "0"){
				$btnobs = ' <button type="button" class="btn btn-danger btn-xs" title="Ver observados" onclick="open_detobs(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-list"></i></button>';
			}
			if($aRow['cnt_soliprocesada'] <> 0){
				$btnPrintValid = ' <button type="button" class="btn btn-warning btn-xs" title="Imprimir validados" onclick="print_validados(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-print"></i></button>';
			}
			$row = array($aRow['fec_recepcion'], $aRow['dependencia_origen'], $aRow['nro_envio']."-".$aRow['anio_envio'], $aRow['estado_env'], "<span class=\"badge bg-blue\">".$aRow['cnt_enviado']."</span>", "<span class=\"badge bg-green\">".$aRow['cnt_soliaceptada']."</span>", "<span class=\"badge bg-red\">".$aRow['cnt_solirechazada']."</span>", "<span class=\"badge bg-blue\">".$aRow['cnt_soliprocesada']."</span>", $btnobs.$btnDet.$btnRec.$btnPrintValid);
		} else {
			if($aRow['cnt_solirechazada'] <> "0"){
				$btnRec = ' <button type="button" class="btn btn-danger btn-xs" title="Ver observados" onclick="open_detobs(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-list"></i></button>';
			}
			$btnPrintValid = ' <button type="button" class="btn btn-warning btn-xs" title="Imprimir validados" onclick="print_validados(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-print"></i></button>';
			$row = array($aRow['fec_recepcion'], $aRow['fec_finaliza'], $aRow['dependencia_origen'], $aRow['nro_envio']."-".$aRow['anio_envio'], "<span class=\"badge bg-blue\">".$aRow['cnt_enviado']."</span>", "<span class=\"badge bg-green\">".$aRow['cnt_soliaceptada']."</span>", "<span class=\"badge bg-red\">".$aRow['cnt_solirechazada']."</span>", "<span class=\"badge bg-blue\">".$aRow['cnt_soliprocesada']."</span>", $btnDet.$btnRec.$btnPrintValid);
		}
	} else {
		if($input['id_estado'] == "2"){
			$btnRec = ' <button type="button" class="btn btn-primary btn-xs" title="Ver observados" onclick="reg_proceso(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-list"></i></button>';
			$row = array($aRow['fec_recepcion'], $aRow['nom_producto'], $aRow['nro_envio']."-".$aRow['anio_envio'], $aRow['estado_env'], "<span class=\"badge bg-blue\">".$aRow['cnt_enviado']."</span>", "<span class=\"badge bg-green\">".$aRow['cnt_soliaceptada']."</span>", "<span class=\"badge bg-red\">".$aRow['cnt_solirechazada']."</span>", "<span class=\"badge bg-blue\">".$aRow['cnt_soliprocesada']."</span>", $btnDet.$btnRec.$btnPrintValid);		
		} else {
			$btnPrintValid = ' <button type="button" class="btn btn-warning btn-xs" title="Imprimir validados" onclick="print_validados(\'' . $aRow['id'] . '\');"><i class="glyphicon glyphicon-print"></i></button>';
			$row = array($aRow['fec_recepcion'], $aRow['fec_finaliza'], $aRow['nom_producto'], $aRow['nro_envio']."-".$aRow['anio_envio'], "<span class=\"badge bg-blue\">".$aRow['cnt_enviado']."</span>", "<span class=\"badge bg-green\">".$aRow['cnt_soliaceptada']."</span>", "<span class=\"badge bg-red\">".$aRow['cnt_solirechazada']."</span>", "<span class=\"badge bg-blue\">".$aRow['cnt_soliprocesada']."</span>", $btnDet.$btnPrintValid);
		}
	}
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
