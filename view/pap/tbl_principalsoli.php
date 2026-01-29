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

$aColumns = array('nro_atencion', 'nro_atencion', '', '', '', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'nro_atencion';

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
  $sOrder = " Orde By pap.nro_orden";
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

if(empty($input['nroDoc']) And empty($input['nomRS'])){
  $fecIni = $input['fecIni'];
  $fecFin = $input['fecFin'];
	if(($labIdRolUser <> "6") And ($labIdRolUser <> "1") ){
		$param[0]['idDepAten'] = $labIdDepUser;
	} else {
		if($input['id_dependencia'] <> ""){
			$param[0]['idDepAten'] = $input['id_dependencia'];
		} else {
			$param[0]['idDepAten'] = "";
		}
	}
} else {
  $fecIni = "";
  $fecFin = "";
	if(($labIdRolUser <> "6") And ($labIdRolUser <> "1") ){
		$param[0]['idDepAten'] = $labIdDepUser;
	} else {
		if($input['id_dependencia'] <> ""){
			$param[0]['idDepAten'] = $input['id_dependencia'];
		} else {
			$param[0]['idDepAten'] = "";
		}
	}
}

if($input['tipo_repor'] == "2"){
  $fecIni = "";
  $fecFin = "";
	if(($labIdRolUser <> "6") And ($labIdRolUser <> "1") ){
		$param[0]['idDepAten'] = $labIdDepUser;
	} else {
		if($input['id_dependencia'] <> ""){
			$param[0]['idDepAten'] = $input['id_dependencia'];
		} else {
			$param[0]['idDepAten'] = "";
		}
	}
}

$param[0]['tipo_repor'] = $input['tipo_repor'];
$param[0]['tipo_resul'] = $input['tipo_resul'];
$param[0]['idTipDoc'] = $input['idTipDoc'];
$param[0]['nroDoc'] = $input['nroDoc'];
$param[0]['nomRS'] = $input['nomRS'];
$param[0]['fecIniAte'] = $fecIni;
$param[0]['fecFinAte'] = $fecFin;
//print_r($param);
//Aqui se manda los parametros de busqueda
$rResult = $pap->get_tblDatosSolicitud($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = $pap->get_tblCountSolicitud($sWhere, $param);
/* echo $rResultFilterTotal."Jose";
exit(); */
list($iFilteredTotal) = $rResultFilterTotal;
$rResultTotal = $pap->get_tblCountSolicitud($sWhere, $param);
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
  $nroRegLab = "";
  $btnNotif = '';
  $btnEdit = '';
  $btnEli = '';
  $btnDet = ' <a href="#" data-target="#editProductModal" class="detail" data-toggle="tooltip" data-placement="top" title="Ver ficha de atención" onclick="event.preventDefault();open_pdfsinvalor(\'' . $aRow['id_papsoli'] . '\');"><i class="glyphicon glyphicon-eye-open"></i></a>';
  $btnLam = ' <a href="#" data-target="#editProductModal" class="acept" data-toggle="tooltip" data-placement="top" title="Datos Lámina" onclick="event.preventDefault();open_datoslamina(\'' . $aRow['id_papsoli'] . '\');"><i class="glyphicon glyphicon-th-list"></i></a>';

  	if($labIdRolUser <> "6"){
  
		if ( $aRow['id_estadosolipap'] == "1"){ //REGISTRADO
			$btnEdit = ' <a href="#" data-target="#editProductModal" class="acept" data-toggle="tooltip" data-placement="top" title="Editar toma PAP" onclick="event.preventDefault();edit_solicitud(\'' . $aRow['id_papsoli'] . '\');"><i class="glyphicon glyphicon-pencil"></i></a>';
			$btnEli = ' <a href="#" data-target="#editProductModal" class="delete" data-toggle="tooltip" data-placement="top" title="Anular toma PAP" onclick="event.preventDefault();acc_registro(\'' . $aRow['id_papsoli'] . '\',\'' . $aRow['nro_ordensoli']."-".$aRow['anio_ordensoli'] . '\',\'A\');"><i class="glyphicon glyphicon-trash"></i></a>';
		}
		if ( $aRow['id_estadosolipap'] == "0"){ //Anulado
			$btnLam = '';
		}
		if ($aRow['id_estadosolipap'] == "3" Or $aRow['id_estadosolipap'] == "4"){ //Finalizado o Entregado a paciente

			if($aRow['id_estadosolipap'] == "3" And $aRow['nom_resul'] <> "RECHAZADA"){
			  $btnNotif = ' <a href="#" data-target="#editProductModal" class="acept" data-toggle="tooltip" data-placement="top" title="Entregar resultado a Paciente" onclick="event.preventDefault();acc_registro(\'' . $aRow['id_papsoli'] . '\',\'' . $aRow['nro_ordensoli']."-".$aRow['anio_ordensoli'] . '\',\'E\');"><i class="glyphicon glyphicon-user"></i></a>';
			}
			if(($aRow['id_estadosolipap'] == "3" Or $aRow['id_estadosolipap'] == "4") And $aRow['nom_resul'] <> "RECHAZADA"){
			  $btnDet = ' <a href="#" data-target="#editProductModal" class="detail" data-toggle="tooltip" data-placement="top" title="Ver ficha de atención" onclick="event.preventDefault();open_opcionimpresionresul(\'' . $aRow['id_papsoli'] . '\');"><i class="glyphicon glyphicon-eye-open"></i></a>';
			}
			$btnLam = '';
			if($aRow['nro_reglab'] <> "") $nroRegLab= $aRow['nro_reglab'] . "-" . $aRow['anio_reglab'];
		}

	} else {
		if($aRow['nro_reglab'] <> "") $nroRegLab= $aRow['nro_reglab'] . "-" . $aRow['anio_reglab'];
	}
  $arrNomFalle = explode(" ", $aRow['nombre_pac']);
  $cntNomFalle = count($arrNomFalle);
  $priNomFalle = mb_substr($arrNomFalle[0], 0, 1); // porción1
  $otroNomFalle = "";

  for($i = 1; $i < $cntNomFalle; $i++){
	if(!isset($arrNomFalle[$i])){
		$otroNomFalle.= "".mb_substr($arrNomFalle[$i], 0, 1);
	}
  }
  
  $nro_docini = $aRow['nro_docpac'];
  $nro_docfin = mb_substr($aRow['nro_docpac'], -1);
  //$nro_docini.".......".$nro_docfin
  
  $row = array($aRow['nro_ordensoli']."-".$aRow['anio_ordensoli'], $aRow['abrev_rspac'].$priNomFalle.$otroNomFalle, $aRow['nombre_rspac'], $aRow['abrev_tipodocpac'].": ".$aRow['nro_docpac'], $aRow['nro_hc'], $aRow['nombre_profe'], $aRow['fec_atencion'], $aRow['nom_estadosolipap'], $aRow['nom_resul'], $aRow['fec_resultado'], $nroRegLab, $btnEdit.$btnDet.$btnLam.$btnEli.$btnNotif);
  $output['aaData'][] = $row;
}
echo json_encode($output);
?>
