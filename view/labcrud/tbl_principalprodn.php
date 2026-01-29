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

require_once '../../model/Producto.php';
$pr = new Producto();

$aColumns = array('codref_producto', '', 'nom_producto', '', '', ''); //Kolom Pada Tabel
// Indexed column (used for fast and accurate table cardinality)
$sIndexColumn = 'codref_producto';

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
    $sOrder = " Order By codref_producto";
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
            $aFilteringRules[] = "UPPER(" . $aColumns[$i] . ") LIKE UPPER('%" . $input['sSearch'] . "%')";
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
		Where  " . implode(" AND ", $aFilteringRules);
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

$param[0]['id_tipo_producto'] = $input['id_tipo_producto'];
$param[0]['id_estado'] = $input['id_estado'];
$param[0]['nom_producto'] = $input['nom_producto'];
//print_r($param);
//Aqui se manda los parametros de busqueda
$rResult = $pr->get_tblDatosProducto($sWhere, $sOrder, $sLimit, $param);
//print_r($rResult);
$rResultFilterTotal = $pr->get_tblCountProducto($sWhere, $param);
/* echo $rResultFilterTotal."Jose";
  exit(); */
list($iFilteredTotal) = $rResultFilterTotal;
$rResultTotal = $pr->get_tblCountProducto($sWhere, $param);
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

	$btnEdit = '';
	$btnDep = '';
	$btnComp = '';
	$nom_producto = str_replace("\"","",$aRow['nom_producto']);
	
    if ($aRow['estado'] == "1") {
        $styleEst = "bg-green";
		$btnEdit = '<button class="btn btn-success btn-xs" onclick="edit_registro(\'' . $aRow['id_producto'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
		$btnDep = '<button class="btn btn-primary btn-xs" onclick="open_dependencia(\'' . $aRow['id_producto'] . '\',\'' . $nom_producto . '\');"><i class="fa fa-hospital-o"></i></button>';
		$btnComp = '<button class="btn btn-info btn-xs" onclick="open_grupo(\'' . $aRow['id_producto'] . '\',\'' . $nom_producto . '\');"><i class="glyphicon glyphicon-list-alt"></i></button>';
		$btnEst = '<button class="btn btn-danger btn-xs" onclick="cambio_estado_registro(\'' . $aRow['id_producto'] . '\',\'1\',\'' . $aRow['idtipo_producto'] . '\',\'' . $nom_producto . '\');"><i class="glyphicon glyphicon-trash"></i></button>';
    } else {
        $styleEst = "bg-red";
		$btnEst = '<button class="btn btn-success btn-xs" onclick="cambio_estado_registro(\'' . $aRow['id_producto'] . '\',\'2\',\'' . $aRow['idtipo_producto'] . '\',\'' . $nom_producto . '\');"><i class="glyphicon glyphicon-ok"></i></button>';
    }

    $nomEstado = '<span class="badge ' . $styleEst . '"><small>' . $aRow['nom_estado'] . '</small></span>';
    $row = array($aRow['codref_producto'], $aRow['nomtipo_producto'], $aRow['nom_producto'], nl2br($aRow['descrip_prepapro']), "<b>".$aRow['cnt_dep']."</b>", "<b>".$aRow['cnt_comp']."</b>", $nomEstado, $btnEdit.$btnDep.$btnComp.$btnEst);
    $output['aaData'][] = $row;
}
echo json_encode($output);
?>
