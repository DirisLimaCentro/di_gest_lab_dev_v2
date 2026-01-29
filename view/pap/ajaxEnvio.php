<?php
	session_start();
	require_once '../model/Expediente.php';
	$exp = new Expediente();
	mb_internal_encoding('UTF-8');


	$aColumns = array( 'nro_ht','tproc.descripcion', 'anio_ht','tdadm.descripcion','fec_deriva', 'asunto_ht', 'solicitante', 'dd.nom_dep', 'remitente',   'nro_folio','idproc_ht','idestado_mov'); //Kolom Pada Tabel

	// Indexed column (used for fast and accurate table cardinality)
	$sIndexColumn = 'nro_ht';

	// DB table to use
	//$sTable = 'tbl_equipos'; // Nama Tabel

	// Database connection information

	//$gaSql['port']     = 5433; // 3306 is the default MySQL port

	// Input method (use $_GET, $_POST or $_REQUEST)
	$input =& $_POST;

	$gaSql['charset']  = 'utf8';

	/**
		* MySQL connection
	*/
	//$db = pg_connect($gaSql['server'], $gaSql['port'],$gaSql['db'] ,$gaSql['user'], $gaSql['password']);

	/*if (!$db->set_charset($gaSql['charset'])) {
		die( 'Error loading character set "'.$gaSql['charset'].'": '.$db->error );
	}
	*/

	/**
		* Paging
	*/
	$sLimit = "";
	if ( isset( $input['iDisplayStart'] ) && $input['iDisplayLength'] != '-1' ) {
		$sLimit = " LIMIT ".intval( $input['iDisplayLength'] )." OFFSET ".intval( $input['iDisplayStart'] );
	}


	/**
		* Ordering
	*/
	$aOrderingRules = array();
	if ( isset( $input['iSortCol_0'] ) ) {
		$iSortingCols = intval( $input['iSortingCols'] );
		for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
			if ( $input[ 'bSortable_'.intval($input['iSortCol_'.$i]) ] == 'true' ) {
				$aOrderingRules[] =
                "".$aColumns[ intval( $input['iSortCol_'.$i] ) ]." "
                .($input['sSortDir_'.$i]==='asc' ? 'asc' : 'desc');
			}
		}
	}

	if (!empty($aOrderingRules)) {
		$sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
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

	if ( isset($input['sSearch']) && $input['sSearch'] != "" ) {
		$aFilteringRules = array();
		for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
			if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' ) {
				$aFilteringRules[] = "".$aColumns[$i]." LIKE '%".  $input['sSearch']."%'";
			}
		}
		if (!empty($aFilteringRules)) {
			$aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
		}
	}

	// Individual column filtering
	for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
		if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
			$aFilteringRules[] = "".$aColumns[$i]." LIKE '%".mb_strtoupper(pg_escape_string($input['sSearch_'.$i]),'UTF-8')."%'";
		}
	}

/*	if (!empty($aFilteringRules)) {
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
	}*/

if($_SESSION['id_rol']!='6'){ $validrol=" and tm.usu_recibe='".$_SESSION['id_usuario']."' "; }else{ $validrol= "";}
	if (!empty($aFilteringRules)) {
		$sWhere = " WHERE   t.idestado_ht='1' and idestado_mov = '2' ".$validrol." and tm.dep_recibe

		In
    (
    Select   d.id_dep From tbl_dependencia d Inner Join tbl_cargoxusuario cu On d.id_dep=cu.id_dep And cu.id_rol='2' Where d.id_dep='".$_SESSION['id_dep']."'
    Union
    Select d.hist_dep From tbl_dependencia d Inner Join tbl_cargoxusuario cu On d.id_dep=cu.id_dep And cu.id_rol='2' Where d.id_dep='".$_SESSION['id_dep']."'
    )

		and  ".implode(" AND ", $aFilteringRules);
		} else {
		$sWhere = " WHERE   t.idestado_ht='1' and idestado_mov = '2' ".$validrol." and tm.dep_recibe

		In
    (
    Select   d.id_dep From tbl_dependencia d Inner Join tbl_cargoxusuario cu On d.id_dep=cu.id_dep And cu.id_rol='2' Where d.id_dep='".$_SESSION['id_dep']."'
    Union
    Select d.hist_dep From tbl_dependencia d Inner Join tbl_cargoxusuario cu On d.id_dep=cu.id_dep And cu.id_rol='2' Where d.id_dep='".$_SESSION['id_dep']."'
    )

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

	$rResult=$exp->QryEnvio($sWhere,$sOrder,$sLimit);

	$rResultFilterTotal=$exp->countEnvio($sWhere);

	list($iFilteredTotal) = $rResultFilterTotal;

	$rResultTotal=$exp->countEnvio($sWhere);
	//$rResultTotal = $rResultFilterTotal;
	list($iTotal) =  $rResultTotal;



	/**
		* Output
	*/
	$output = array(
    //"sEcho"                => intval($input['sEcho']),
    "iTotalRecords"        => $rResultFilterTotal,
    "iTotalDisplayRecords" => $rResultFilterTotal,
    "aaData"               => array(),
	);

	// Looping Data
		$ebien='';
		foreach ($rResult as $aRow) {
 		$row = array();
		$idcod=$aRow['idproc_ht']."|".$aRow['anio_ht']."|".$aRow['nro_ht']."|".$aRow['nro_mov'];
		$idcodfinish=$aRow['idproc_ht']."|".$aRow['anio_ht']."|".$aRow['nro_ht']."|".$aRow['nro_mov'];
		if ($aRow["idestado_mov"]=='1'){ $ebien= "<i class='fa fa-clock-o text-warning text-center'></i>";}else {$ebien= "<i class='fa fa-check text-success text-center'></i>";}
		$btn = '<a href="#" onClick="finishHt(\''.$aRow['nro_ht'].'\',\''.$idcodfinish.'\')"><i class="fa fa-flag"></i></a> | <a href="#" onClick="ShowRuta(\''.$idcod.'\')"><i class="fa fa-eye"></i></a> | <a href="#" onClick="RegObs(\''.$idcod.'\')"><i class="fa fa-cog"></i></a>';
		for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
			$row[] = $aRow[ $aColumns[$i] ];

		}

		$row = array($idcod,"<b>".$aRow['nro_ht']."</b>",$aRow['tproc.descripcion'], $aRow['tdadm.descripcion'], $aRow['nro_doc_ht'], $aRow['fec_deriva'], $aRow['asunto_ht'], $aRow['solicitante'], $aRow['remitente'], $aRow['dd.nom_dep'] , $aRow['nro_folio'],$btn,$ebien);
		$output['aaData'][] = $row;
	}
	echo json_encode( $output );

?>
