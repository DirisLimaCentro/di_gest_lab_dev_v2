<?php

include_once 'ConectaDb.php';

class Producto {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function post_reg_producto($param) {
    $this->db->getConnection();
    $aparam = array($param[0]['accion'], $param[0]['producto'], $param[0]['userIngreso']);
    $this->sql = "select sp_reg_producto($1,$2,$3);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_datosProductoPorId($idProd) {
    $this->db->getConnection();
    $aparam = array($idProd);
    $this->sql = "Select id_producto, codref_producto, nom_producto, descrip_prepapro, descrip_insupro, descrip_obspro,
    pr.idtipo_producto, tpr.nombre_tipo_producto nomtipo_producto,
    pr.estado id_estado, Case pr.estado When 1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_producto pr
	INNER JOIN public.tbl_labtipo_producto tpr On pr.idtipo_producto=tpr.id
    Where id_producto=$1";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaProductoLaboratorio() {
    $this->db->getConnection();
    $this->sql = "Select id_producto, codref_producto, nom_producto, tpr.nombre_tipo_producto nomtipo_producto From tbl_producto pr INNER JOIN public.tbl_labtipo_producto tpr On pr.idtipo_producto=tpr.id Where pr.estado=1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
 
  public function get_listaProductoLaboratorioPorIdDep($idDep) {
    $this->db->getConnection();
    $this->sql = "Select pr.id_producto, codref_producto, nom_producto, prec_sis, prec_parti,
tpr.nombre_tipo_producto nomtipo_producto From tbl_producto pr
INNER JOIN public.tbl_labtipo_producto tpr On pr.idtipo_producto=tpr.id
Inner Join tbl_labproductodepen pd On pr.id_producto = pd.id_producto
Where pd.estado=1 And pr.estado=1 And pd.id_dependencia=".$idDep."";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
 
  public function get_listaProductoLaboratorioPorIdDepAndIdTipoProducto($idDep, $idTipoProd) {
    $this->db->getConnection();
    $this->sql = "Select pr.id_producto, codref_producto, nom_producto, prec_sis, prec_parti,
tpr.nombre_tipo_producto nomtipo_producto From tbl_producto pr
INNER JOIN public.tbl_labtipo_producto tpr On pr.idtipo_producto=tpr.id
Inner Join tbl_labproductodepen pd On pr.id_producto = pd.id_producto
Where pd.estado=1 And pr.estado=1 And pd.id_dependencia=".$idDep." And tpr.id=". $idTipoProd . " Order By nom_producto";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_datosComponentePorIdPro($idProd) {
    $this->db->getConnection();
    $this->sql = "Select compd.id_componentedet, comp.id_componente, comp.descrip_comp componente From public.tbl_componentedetprod compdpro
Inner Join public.tbl_componentedet compd On compdpro.id_componentedet = compd.id_componentedet
Inner Join public.tbl_componente comp On compd.id_componente = comp.id_componente
Where compdpro.id_producto=".$idProd."";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaProductoLaboratorioPorIdDepAndIdPerfil($idDep,$idPerfil) {
    $this->db->getConnection();
    $this->sql = "Select p.id_producto, codref_producto, nom_producto, prec_sis, prec_parti,
tpr.nombre_tipo_producto nomtipo_producto, pd.id_dependencia From tbl_producto p
INNER JOIN public.tbl_labtipo_producto tpr On pr.idtipo_producto=tpr.id
Inner Join tbl_labproductodepen pd On p.id_producto = pd.id_producto
Inner Join public.tbl_labperfilxproducto perprod On p.id_producto = perprod.id_producto
Inner Join public.tbl_labperfil per On perprod.id_perfillab=per.id
Where pd.estado=1 And p.estado=1 And id_dependencia=".$idDep." And per.id=".$idPerfil."";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosProductoPorIdPro($idPro) {
    $this->db->getConnection();
    $aparam = array($idPro);
    $this->sql = "Select '' id_cpt,
    Case When p.descrip_prepapro isNull Then '' Else p.descrip_prepapro End descrip_prepapro,
    Case When p.descrip_insupro isNull Then '' Else p.descrip_insupro End descrip_insupro,
    Case When p.descrip_obspro isNull Then '' Else p.descrip_obspro End descrip_obspro
    From tbl_producto p
    Where id_producto=$1";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblDatosProducto($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select id_producto, codref_producto, nom_producto,
    descrip_prepapro, descrip_insupro, descrip_obspro, (Select count(id_producto) From tbl_labproductodepen Where id_producto=pr.id_producto And estado=1) cnt_dep,
    (Select count(id_producto) From tbl_componentedetprod Where id_producto=pr.id_producto And estado=1) cnt_comp,
    pr.es_toma_muestra, pr.idtipo_producto, tpr.abrev_tipo_producto nomtipo_producto,
    pr.estado, Case pr.estado When 1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_producto pr 
	INNER JOIN public.tbl_labtipo_producto tpr On pr.idtipo_producto=tpr.id Where pr.estado <> 3";
	if (!empty($param[0]['id_tipo_producto'])) {
		$this->sql .= "  And pr.idtipo_producto=" . $param[0]['id_tipo_producto'] . "";
	}
	if (!empty($param[0]['id_estado'])) {
		$this->sql .= "  And pr.estado=" . $param[0]['id_estado'] . "";
	}
	if (!empty($param[0]['nom_producto'])) {
		$this->sql .= "  And pr.nom_producto ilike '%" . $param[0]['nom_producto'] . "%'";
	}
    $this->sql .= $sWhere. $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountProducto($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_producto pr Where pr.estado <> 3";
	if (!empty($param[0]['id_tipo_producto'])) {
		$this->sql .= "  And pr.idtipo_producto=" . $param[0]['id_tipo_producto'] . "";
	}
	if (!empty($param[0]['id_estado'])) {
		$this->sql .= "  And pr.estado=" . $param[0]['id_estado'] . "";
	}
	if (!empty($param[0]['nom_producto'])) {
		$this->sql .= "  And pr.nom_producto ilike '%" . $param[0]['nom_producto'] . "%'";
	}
    $this->sql .= $sWhere;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }


  public function get_tblDatosProductoDependencia($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select pr.id_producto, dep.id_dependencia, dep.nom_depen, pr.codref_producto, pr.nom_producto,
pr.descrip_prepapro, pr.descrip_insupro, pr.descrip_obspro";
if (!empty($param[0]['id_establecimiento'])) {
	$this->sql .= ", (Select count(pri.id_producto) From lab.tbl_producto_grupo_componente gcomp
Inner join lab.tbl_producto_grupo_componente_dep gcompd On gcomp.id=gcompd.id_productogrupocomp
Inner join lab.tbl_producto_grupo gpr On gcomp.id_productogrupo=gpr.id
Inner Join tbl_producto pri On gpr.id_producto=pri.id_producto
Where pri.id_producto=pr.id_producto And gcompd.id_dependencia=" . $param[0]['id_establecimiento'] . " And gcomp.estado=1 And gpr.estado=1) cnt_comp,";
} else {
	$this->sql .= ", (Select count(pri.id_producto) From lab.tbl_producto_grupo_componente gcomp
Inner join lab.tbl_producto_grupo gpr On gcomp.id_productogrupo=gpr.id
Inner Join tbl_producto pri On gpr.id_producto=pri.id_producto
Where pri.id_producto=pr.id_producto And gcomp.estado=1 And gpr.estado=1) cnt_comp,";
}
$this->sql .= "pr.idtipo_producto, tpr.abrev_tipo_producto nomtipo_producto, prdep.prec_sis, prdep.prec_parti,
pr.estado, Case pr.estado When 1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_producto pr
INNER JOIN public.tbl_labtipo_producto tpr On pr.idtipo_producto=tpr.id
LEFT JOIN public.tbl_labproductodepen prdep On pr.id_producto=prdep.id_producto
LEFT JOIN public.tbl_dependencia dep On prdep.id_dependencia=dep.id_dependencia
WHERE pr.estado=1";
	if (!empty($param[0]['id_establecimiento'])) {
		$this->sql .= "  And prdep.estado=1 And dep.id_dependencia=" . $param[0]['id_establecimiento'] . "";
	}
	if (!empty($param[0]['nom_producto'])) {
		$this->sql .= " And pr.nom_producto ilike '%" . $param[0]['nom_producto'] . "%'";
	}
    $this->sql .= $sWhere. $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountProductoDependencia($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_producto pr
INNER JOIN public.tbl_labtipo_producto tpr On pr.idtipo_producto=tpr.id
LEFT JOIN public.tbl_labproductodepen prdep On pr.id_producto=prdep.id_producto
LEFT JOIN public.tbl_dependencia dep On prdep.id_dependencia=dep.id_dependencia
WHERE pr.estado=1";
	if (!empty($param[0]['id_establecimiento'])) {
		$this->sql .= " And prdep.estado=1 And dep.id_dependencia=" . $param[0]['id_establecimiento'] . "";
	}
	if (!empty($param[0]['nom_producto'])) {
		$this->sql .= " And pr.nom_producto ilike '%" . $param[0]['nom_producto'] . "%'";
	}
    $this->sql .= $sWhere;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }
  

	public function get_repDatosProductoDependencia($param) {
	  //print_r($param);exit();
		$this->db->getConnection();
		if (empty($param[0]['id_establecimiento'])) {
			$this->sql = "Select id_producto, '' nom_depen, cod_producto_orionlab, codref_producto, nom_producto,
		descrip_prepapro, descrip_insupro, descrip_obspro, (Select count(id_producto) From tbl_labproductodepen Where id_producto=pr.id_producto And estado=1) cnt_dep,
		(Select count(pri.id_producto) From lab.tbl_producto_grupo_componente gcomp
Inner join lab.tbl_producto_grupo gpr On gcomp.id_productogrupo=gpr.id
Inner Join tbl_producto pri On gpr.id_producto=pri.id_producto
Where pri.id_producto=pr.id_producto And gcomp.estado=1 And gpr.estado=1) cnt_comp,
		pr.idtipo_producto, tpr.abrev_tipo_producto nomtipo_producto, '' prec_sis, '' prec_parti, pr.orden_por_tipo_producto,
		pr.estado, Case pr.estado When 1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_producto pr 
		INNER JOIN public.tbl_labtipo_producto tpr On pr.idtipo_producto=tpr.id Where pr.estado=1";
		} else {
			$this->sql = "Select pr.id_producto, dep.nom_depen, pr.codref_producto, pr.cod_producto_orionlab, pr.nom_producto,
	pr.descrip_prepapro, pr.descrip_insupro, pr.descrip_obspro, (Select count(pri.id_producto) From lab.tbl_producto_grupo_componente gcomp
Inner join lab.tbl_producto_grupo_componente_dep gcompd On gcomp.id=gcompd.id_productogrupocomp
Inner join lab.tbl_producto_grupo gpr On gcomp.id_productogrupo=gpr.id
Inner Join tbl_producto pri On gpr.id_producto=pri.id_producto
Where pri.id_producto=pr.id_producto And gcompd.id_dependencia=" . $param[0]['id_establecimiento'] . " And gcomp.estado=1 And gpr.estado=1) cnt_comp,
	pr.idtipo_producto, tpr.abrev_tipo_producto nomtipo_producto, prdep.prec_sis, prdep.prec_parti, pr.orden_por_tipo_producto,
	pr.estado, Case pr.estado When 1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_producto pr
	INNER JOIN public.tbl_labtipo_producto tpr On pr.idtipo_producto=tpr.id
	INNER JOIN public.tbl_labproductodepen prdep On pr.id_producto=prdep.id_producto
	INNER JOIN public.tbl_dependencia dep On prdep.id_dependencia=dep.id_dependencia
	WHERE pr.estado=1 And prdep.estado=1 And dep.id_dependencia=" . $param[0]['id_establecimiento'] . "";
		}
		if ($param[0]['id_tipo'] <> 0) {
			$this->sql .= " And tpr.id=" . $param[0]['id_tipo'] . "";
		}
		$this->sql .= " Order By tpr.id, pr.orden_por_tipo_producto";
		$this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
		return $this->rs;
	}
  

  public function get_datosDependenciaProductoPorId($idProd) {
    $this->db->getConnection();
    $aparam = array($idProd);
    $this->sql = "Select prd.id_productodepen, pr.id_producto, d.id_dependencia, pr.codref_producto, pr.nom_producto,
    d.codref_depen, d.nom_depen, prd.prec_sis, prd.prec_parti,
    pr.estado id_estado, Case pr.estado When 1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado
    From tbl_labproductodepen prd
    Inner Join tbl_producto pr On prd.id_producto = pr.id_producto
    Inner Join tbl_dependencia d On prd.id_dependencia = d.id_dependencia
    Where prd.id_productodepen=$1";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosDependenciaPorIdProducto($idPro) {
    $this->db->getConnection();
    $aparam = array($idPro);
    $this->sql = "Select pd.id_productodepen, d.nom_depen, pd.prec_sis, pd.prec_parti,
	pd.chek_es_americana, case When pd.chek_es_americana = true Then 'SI' Else 'NO' End es_americana, 
	pd.chek_es_diagnostica, case When pd.chek_es_diagnostica = true Then 'SI' Else 'NO' End es_diagnostica, 
    pd.estado, Case When pd.estado=1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado
    From tbl_dependencia d
    Inner Join tbl_labproductodepen pd On d.id_dependencia = pd.id_dependencia
    Where pd.id_producto=$1 order by d.nom_depen";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function post_reg_productodepen($param) {
    $this->db->getConnection();
    $aparam = array($param[0]['accion'], $param[0]['detproddep'], $param[0]['userIngreso']);
    $this->sql = "select sp_reg_labproductodepen($1,$2,$3);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_listaProductoPorIdAreaAndIdAtencion($idAtencion, $idArea) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_productoporareaandidatencion(" . $idAtencion . ", " . $idArea . ", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaProductoPorIdAtencion($idAtencion) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_productoporidatencion(" . $idAtencion .", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaProductoAnteriorPorIdProducto($idProd) {
    $conet = $this->db->getConnection();
    $this->sql = "Select Distinct id_productoori From tbl_componentedetprod Where id_producto = " . $idProd ." And estado=1 Order By id_productoori Desc;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

    public function get_listaTipoProducto() {
        $conet = $this->db->getConnection();
        $this->sql = "Select id, nombre_tipo_producto, abrev_tipo_producto From tbl_labtipo_producto Where estado=1";
        $this->sql .= " Order By id";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
	/***********************************************************************************/
	////////////////////////////// RESULTADOS /////////////////////////////////////
	/***********************************************************************************/

    public function get_resul_AreaProductoPorIdAtencion($idAtencion) {
        $conet = $this->db->getConnection();
        $this->sql = "Select id, nombre_tipo_producto, abrev_tipo_producto From tbl_labtipo_producto Where estado=1";
        $this->sql .= " Order By id";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

}
