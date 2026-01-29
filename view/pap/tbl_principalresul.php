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

$aColumns = array('pap.nro_reglab', '', '', '', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'pap.nro_reglab';

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
    $sOrder = " Order By pap.fec_atencion";
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
$param[0]['nroOrden'] = $input['nroOrden'];
$param[0]['bus_anio'] = $input['bus_anio'];
//print_r($param);
//Aqui se manda los parametros de busqueda
$rResult = $pap->get_tblDatosAceptable($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = $pap->get_tblCountAceptable($sWhere, $param);
/*echo $rResultFilterTotal."Jose";
exit(); */
list($iFilteredTotal) = $rResultFilterTotal;
$rResultTotal = $pap->get_tblCountAceptable($sWhere, $param);
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

    $btnResul = '';
    $btnEdit = '';


    if($aRow['id_estadoresulpap'] == "1"){
      $btnResul = ' <a href="#" data-target="#editProductModal" data-toggle="tooltip" data-placement="top" title="Ingresar resultado" onclick="reg_resultado(\'' . $aRow['id_papsoli'] . '\');"><i class="glyphicon glyphicon-eject"></i></a>';
      $btnDet = '<a href="#" data-target="#editProductModal" class="detail" data-toggle="tooltip" data-placement="top" title="Ver detalle" onclick="open_pdfsinvalor(\'' . $aRow['id_papsoli'] . '\');"><i class="glyphicon glyphicon-eye-open"></i></a>';
    } else {
      $btnDet = '<a href="#" data-target="#editProductModal" class="detail" data-toggle="tooltip" data-placement="top" title="Ver detalle" onclick="open_pdfresulsinvalor(\'' . $aRow['id_papsoli'] . '\');"><i class="glyphicon glyphicon-eye-open"></i></a>';
      $btnEdit = ' <a href="#" class="acept" data-target="#editProductModal" data-toggle="tooltip" data-placement="top" title="Editar resultado" onclick="edit_resultado(\'' . $aRow['id_papsoli'] . '\');"><i class="glyphicon glyphicon-pencil"></i></a>';
	  if($labIdRolUser == "1" Or $labIdRolUser == "10"){
      $btnResul = ' <a href="#" data-target="#editProductModal" data-toggle="tooltip" data-placement="top" title="Validar resultado" onclick="valid_resultado(\'' . $aRow['id_papsoli'] . '\',\'' . $aRow['nro_reglab']."-".$aRow['anio_reglab'] . '\');"><i class="glyphicon glyphicon-check"></i></a>';
	  }
    }
    if($aRow['nom_bethesa'] <> ""){
      $resultado = $aRow['nom_bethesa'];
    } else {
      $resultado = $aRow['nom_resul'];
    }
	

$arrNomFalle = explode(" ", $aRow['nombre_pac']);
$cntNomFalle = count($arrNomFalle);
$priNomFalle = mb_substr($arrNomFalle[0], 0, 1); // porción1
$otroNomFalle = "";
for($i = 1; $i < $cntNomFalle; $i++){
  $otroNomFalle.= "".mb_substr($arrNomFalle[$i], 0, 1);
}	

    $row = array($aRow['nro_reglab']."-".$aRow['anio_reglab'], $aRow['nro_ordensoli']."-".$aRow['anio_ordensoli'], $aRow['abrev_rspac'].$priNomFalle.$otroNomFalle, $aRow['nombre_rspac'], $aRow['abrev_tipodocpac'].": ".$aRow['nro_docpac'], $aRow['nro_hc'], $aRow['nom_depen'], $aRow['nom_estadosoliresulpap'], $resultado, $btnDet . $btnEdit . $btnResul);
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
