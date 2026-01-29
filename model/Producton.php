<?php

include_once 'ConectaDb.php';

class Producton {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }
  
  public function get_datosGrupoPorIdProducto($idProd, $activo = 0) {
    $this->db->getConnection();
    $aparam = array($idProd);
    $this->sql = "Select pgr.id, pgr.id_producto, pgr.id_grupo, pgr.orden_grupo, gr.descripcion_grupo,
(Select count(1) FROM lab.tbl_producto_grupo_componente Where id_productogrupo=pgr.id And estado=1) cnt_comp,
pgr.chk_muestra, Case When pgr.chk_muestra=TRUE Then 'SI'::Varchar Else 'NO'::Varchar End nom_visible,
pgr.estado, Case When pgr.estado=1 Then 'ACT'::Varchar Else 'INAC'::Varchar End nom_estado
From lab.tbl_producto_grupo pgr Inner Join lab.tbl_grupo gr On pgr.id_grupo=gr.id
Where pgr.id_producto=$1";
	if($activo <> 0){
		$this->sql .= " And pgr.estado=".$activo;
	}
    $this->sql .= " Order By pgr.orden_grupo";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_datosComponenteGrupoProdPorId($id) {
    $this->db->getConnection();
    $aparam = array($id);
    $this->sql = "SELECT pgrcomp.id, comp.id_componente, comp.descrip_comp componente, comp.id_unimedida, um.descrip_unimedida uni_medida,
comp.idtipo_ingresol, Case comp.idtipo_ingresol When 1 Then 'LINEA'::Varchar When 2 Then 'MULTILINEA'::Varchar Else 'SELECCION' End ing_solu,
pgrcomp.id_metodocomponente, case when pgrcomp.id_metodocomponente is Null Then 'SIN METODO' ELSE met.nombre_metodo END metodocomponente, pgrcomp.orden_componente, 
pgrcomp.chk_muestra_metodo, Case When pgrcomp.chk_muestra_metodo=TRUE Then 'SI'::Varchar Else 'NO'::Varchar End nom_visible, pgrcomp.chk_muestra_comp_vacio, Case When pgrcomp.chk_muestra_comp_vacio=TRUE Then 'SI'::Varchar Else 'NO'::Varchar End muestra_comp_vacio, 
pgrcomp.estado, Case When pgrcomp.estado=1 Then 'ACT'::Varchar Else 'INAC'::Varchar End nom_estado
FROM lab.tbl_producto_grupo_componente pgrcomp Inner Join tbl_componente comp On pgrcomp.id_componente=comp.id_componente
Left Join tbl_unimedida um On comp.id_unimedida = um.id_unimedida
Left Join lab.tbl_componente_metodo compmet On pgrcomp.id_metodocomponente=compmet.id
Left Join lab.tbl_metodo met On compmet.id_metodo=met.id
Where pgrcomp.id=$1";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_datosComponentePorIdGrupoProd($idProdGrupo, $activo = 0, $id_metodo = '') {
    $this->db->getConnection();
    $aparam = array($idProdGrupo);
    $this->sql = "SELECT pgrcomp.id, comp.id_componente, comp.descrip_comp componente, um.descrip_unimedida uni_medida,
pgrcomp.id_metodocomponente, case when pgrcomp.id_metodocomponente is Null Then 'SIN METODO' ELSE met.nombre_metodo END metodocomponente, pgrcomp.orden_componente, pgrcomp.chk_muestra_metodo,
Case When pgrcomp.chk_muestra_metodo=TRUE Then 'SI'::Varchar Else 'NO'::Varchar End nom_visible, pgrcomp.chk_muestra_comp_vacio, Case When pgrcomp.chk_muestra_comp_vacio=TRUE Then 'SI'::Varchar Else 'NO'::Varchar End muestra_comp_vacio, 
pgrcomp.estado, Case When pgrcomp.estado=1 Then 'ACT'::Varchar Else 'INAC'::Varchar End nom_estado,
(Select count(1) From lab.tbl_producto_grupo_componente_dep Where id_productogrupocomp=pgrcomp.id And estado=1) cnt_dependencia
FROM lab.tbl_producto_grupo_componente pgrcomp Inner Join tbl_componente comp On pgrcomp.id_componente=comp.id_componente
Left Join tbl_unimedida um On comp.id_unimedida = um.id_unimedida
Left Join lab.tbl_componente_metodo compmet On pgrcomp.id_metodocomponente=compmet.id
Left Join lab.tbl_metodo met On compmet.id_metodo=met.id
Where id_productogrupo=$1";
	if($activo <> 0){
		$this->sql .= " And pgrcomp.estado=" . $activo;
	}
	if($id_metodo <> ''){
		$this->sql .= " And met.id = " . $id_metodo;
	}
    $this->sql .= " Order By pgrcomp.orden_componente";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_datosComponentePorIdGrupoProdAndIdDependenciaActivo($idProdGrupo, $idDep) {
    $this->db->getConnection();
    $aparam = array($idProdGrupo, $idDep);
    $this->sql = "SELECT pgrcomp.id, comp.id_componente, comp.descrip_comp componente, um.descrip_unimedida uni_medida,
pgrcomp.id_metodocomponente, case when pgrcomp.id_metodocomponente is Null Then 'SIN METODO' ELSE met.nombre_metodo END metodocomponente, compmet.id_tipo_val_ref, 
pgrcomp.orden_componente, pgrcomp.chk_muestra_metodo,
comp.idtipo_ingresol, comp.idtipocaracter_ingresul, comp.detcaracter_ingresul, comp.idseleccion_ingresul, descrip_valor valor_ref, 
Case When pgrcomp.chk_muestra_metodo=TRUE Then 'SI'::Varchar Else 'NO'::Varchar End nom_visible,
'' det_result --Se utiliza en la ventana editar resultado
FROM lab.tbl_producto_grupo_componente pgrcomp Inner Join tbl_componente comp On pgrcomp.id_componente=comp.id_componente
Inner join lab.tbl_producto_grupo_componente_dep pgrcompdep On pgrcomp.id=pgrcompdep.id_productogrupocomp
Left Join tbl_unimedida um On comp.id_unimedida = um.id_unimedida
Left Join lab.tbl_componente_metodo compmet On pgrcomp.id_metodocomponente=compmet.id
Left Join lab.tbl_metodo met On compmet.id_metodo=met.id
Where id_productogrupo=$1 And id_dependencia=$2 And pgrcomp.estado=1 And pgrcompdep.estado=1";
    $this->sql .= " Order By pgrcomp.orden_componente";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_datosDependenciaPorIdProductoGrupoComp($idProdGrupoComp) {
    $this->db->getConnection();
    $aparam = array($idProdGrupoComp);
    $this->sql = "SELECT id, d.id_dependencia, d.nom_depen dependencia
FROM lab.tbl_producto_grupo_componente_dep pgrcompdep
Inner join tbl_dependencia d On pgrcompdep.id_dependencia=d.id_dependencia
Where id_productogrupocomp=$1 And pgrcompdep.estado=1";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function reg_grupo_componente($param) {
    $this->db->getConnection();
    $aparam = array($param[0]['accion'], $param[0]['id'], $param[0]['datos'], $param[0]['userIngreso']);
    $this->sql = "select lab.sp_crud_grupo_componente($1,$2,$3,$4);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_listaGrupoActivo() {
    $this->db->getConnection();
    $this->sql = "Select id, descripcion_grupo From lab.tbl_grupo Where estado=1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaGrupoCambioOtroActivo($idProd, $idProdGrupo) {
    $this->db->getConnection();
    $this->sql = "Select pgr.id, gr.descripcion_grupo From lab.tbl_grupo gr
Inner Join lab.tbl_producto_grupo pgr On gr.id=pgr.id_grupo
Where pgr.id_producto=" . $idProd . " And pgr.id<>" . $idProdGrupo . " And gr.estado=1 And pgr.estado=1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_datosNombreProductoPorIdProductoMultiselect($idProd) {
    $this->db->getConnection();
    $this->sql = "Select id_producto, nom_producto From tbl_producto Where id_producto in (" . $idProd . ")";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  /*******************************************************************************************/
  //////////////////////////////////// Datos con atención ////////////////////////////////////
  /*******************************************************************************************/

  public function get_datosAreaPoridAtencion($idAten) {
    $this->db->getConnection();
    $aparam = array($idAten);
    $this->sql = "Select Distinct tpro.id, tpro.abrev_tipo_producto From lab.tbl_labproductoatencion dpro
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto=tpro.id
Where dpro.id_atencion=$1 And dpro.id_estado_reg=1 And id_estado_resul=4
Order By tpro.id";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  } 

  public function get_datosProductoPorIdAtencionAndIdArea($idAten,$idArea) {
    $this->db->getConnection();
    $aparam = array($idAten,$idArea);
    $this->sql = "Select dpro.id_atencion, dpro.id_producto, codref_producto, pro.nom_producto, dpro.precio, dpro.porcentaje_descuento, dpro.descuento, dpro.total, dpro.id_dependencia, dpro.id_estado_resul,
Case When pro.idtipo_producto='6' Then 'PERFIL' Else 'EXAMEN' End nomtipo_producto From lab.tbl_labproductoatencion dpro
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Where dpro.id_atencion=$1 And pro.idtipo_producto=$2 And dpro.id_estado_reg=1 And id_estado_resul=4 Order By dpro.id;";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }   
  
  public function get_datosGrupoPorIdProductoAndidAtencion($idAten, $idProd) {
    $this->db->getConnection();
    $aparam = array($idAten, $idProd);
    $this->sql = "Select DISTINCT pgr.id, pgr.id_producto, pgr.id_grupo, gr.descripcion_grupo, dresul.orden_grupo, 
dresul.chk_muestra_grupo chk_muestra, Case When dresul.chk_muestra_grupo=TRUE Then 'SI'::Varchar Else 'NO'::Varchar End nom_visible
From lab.tbl_labresultadodet dresul 
Inner Join lab.tbl_producto_grupo pgr On dresul.id_productogrupo=pgr.id
Inner Join lab.tbl_grupo gr On pgr.id_grupo=gr.id
Where dresul.id_atencion=$1 And dresul.id_producto=$2 And dresul.estado=1 Order By dresul.orden_grupo";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_datosSiTieneObsComponentePorIdGrupoProdAndIdAtencion($idAten, $idProd, $idProdGrupo) {
    $this->db->getConnection();
    $aparam = array($idAten, $idProd, $idProdGrupo);
    $this->sql = "SELECT dresul.det_resul det_result_obs FROM lab.tbl_labresultadodet dresul 
Inner join lab.tbl_producto_grupo_componente pgrcomp On dresul.id_productogrupocomp=pgrcomp.id
Inner Join tbl_componente comp On pgrcomp.id_componente=comp.id_componente
Left Join tbl_unimedida um On comp.id_unimedida = um.id_unimedida
Left Join tbl_componentevalref cvr On dresul.id_compvalref = cvr.id_compvalref
Left Join tbl_componente_seleccionresuldet rsele On dresul.det_resul=rsele.id::Varchar
Left Join lab.tbl_componente_metodo compmet On dresul.id_metodocomponente=compmet.id
Left Join lab.tbl_metodo met On compmet.id_metodo=met.id
Where dresul.id_atencion=$1 And dresul.id_producto=$2 And dresul.id_productogrupo=$3 And comp.id_componente=159 And dresul.estado=1";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_datosComponentePorIdGrupoProdAndIdAtencion($idAten, $idProd, $idProdGrupo) {
    $this->db->getConnection();
    $aparam = array($idAten, $idProd, $idProdGrupo);
    $this->sql = "SELECT pgrcomp.id, comp.id_componente, comp.descrip_comp componente, um.descrip_unimedida uni_medida, dresul.opt_origen_sistema, dresul.det_resul det_result, 
dresul.id_metodocomponente, case when dresul.id_metodocomponente is Null Then 'SIN METODO' ELSE met.nombre_metodo END metodocomponente, compmet.id_tipo_val_ref, 
dresul.ord_componente orden_componente, dresul.chk_muestra_metodo,
dresul.idtipo_ingresol, comp.idtipocaracter_ingresul, comp.detcaracter_ingresul, dresul.idseleccion_resul idseleccion_ingresul, comp.descrip_valor valor_ref, 
Case When pgrcomp.chk_muestra_metodo=TRUE Then 'SI'::Varchar Else 'NO'::Varchar End nom_visible, 
Case When pgrcomp.chk_muestra_comp_vacio=TRUE Then 'SI'::Varchar Else 'NO'::Varchar End muestra_comp_vacio, 
compmet.descrip_valref_metodo, compmet.chk_muestra_valref_especifico,
lim_inf liminf, lim_sup limsup, dresul.valor_ref_minimo, dresul.valor_ref_maximo, descip_valref descripvalref, 
rsele.nombre nombreseleccion_resul, rsele.chk_negrita, Case When rsele.chk_negrita=TRUE Then 'SI'::Varchar Else 'NO'::Varchar End seleccion_resul_negrita
FROM lab.tbl_labresultadodet dresul 
Inner join lab.tbl_producto_grupo_componente pgrcomp On dresul.id_productogrupocomp=pgrcomp.id
Inner Join tbl_componente comp On pgrcomp.id_componente=comp.id_componente
Left Join tbl_unimedida um On comp.id_unimedida = um.id_unimedida
Left Join tbl_componentevalref cvr On dresul.id_compvalref = cvr.id_compvalref
Left Join tbl_componente_seleccionresuldet rsele On dresul.det_resul=rsele.id::Varchar
Left Join lab.tbl_componente_metodo compmet On dresul.id_metodocomponente=compmet.id
Left Join lab.tbl_metodo met On compmet.id_metodo=met.id
Where dresul.id_atencion=$1 And dresul.id_producto=$2 And dresul.id_productogrupo=$3 And dresul.estado=1
Order By dresul.ord_componente";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  
  public function get_cntComponentePorIdProductoAndIdAtencion($idAten, $idProd) {
    $this->db->getConnection();
    $aparam = array($idAten, $idProd);
    $this->sql = "Select count(1) cnt_componente From lab.tbl_labresultadodet 
Where id_atencion=$1 And id_producto=$2 And estado=1";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }
  
  /*******************************************************************************************/
  //////////////////////////////////// Reporte Productos ////////////////////////////////////
  /*******************************************************************************************/

  public function get_datosComponentePoridProductoAndIdDependenciaActivo($idProd, $idDep) {
    $this->db->getConnection();
	if ($idDep == Null) {
    $this->sql = "Select comp.id_componente, pgrcomp.id id_componente_grupo, comp.descrip_comp componente, um.descrip_unimedida uni_medida,
case when pgrcomp.id_metodocomponente is Null Then 'SIN METODO' ELSE 'CON METODO' END metodocomponente, gp.descripcion_grupo
From lab.tbl_producto_grupo_componente pgrcomp
Inner Join tbl_componente comp On pgrcomp.id_componente=comp.id_componente
Inner join lab.tbl_producto_grupo gpr On pgrcomp.id_productogrupo=gpr.id
Inner Join lab.tbl_grupo gp On gpr.id_grupo=gp.id
Left Join tbl_unimedida um On comp.id_unimedida = um.id_unimedida
Where gpr.id_producto=" . $idProd . " And pgrcomp.estado=1 And gpr.estado=1 
Order By gpr.orden_grupo, pgrcomp.orden_componente";
	} else {
    $this->sql = "Select comp.id_componente, pgrcomp.id id_componente_grupo, comp.descrip_comp componente, um.descrip_unimedida uni_medida,
case when pgrcomp.id_metodocomponente is Null Then 'SIN METODO' ELSE met.nombre_metodo END metodocomponente, gp.descripcion_grupo
From lab.tbl_producto_grupo_componente pgrcomp
Inner Join tbl_componente comp On pgrcomp.id_componente=comp.id_componente
Inner join lab.tbl_producto_grupo gpr On pgrcomp.id_productogrupo=gpr.id
Inner Join lab.tbl_grupo gp On gpr.id_grupo=gp.id
Inner Join lab.tbl_producto_grupo_componente_dep pgrcompdep On pgrcomp.id = pgrcompdep.id_productogrupocomp
Left Join tbl_unimedida um On comp.id_unimedida = um.id_unimedida
Left Join lab.tbl_componente_metodo compmet On pgrcomp.id_metodocomponente=compmet.id
Left Join lab.tbl_metodo met On compmet.id_metodo=met.id
Where gpr.id_producto=" . $idProd . " And id_dependencia=" . $idDep . " And pgrcomp.estado=1 And gpr.estado=1 And pgrcompdep.estado=1
Order By gpr.orden_grupo, pgrcomp.orden_componente";
	}
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

  public function post_reg_grupo($param) {
    $this->db->getConnection();
    $aparam = array($param[0]['accion'], $param[0]['grupo'], $param[0]['userIngreso']);
    $this->sql = "select sp_reg_grupo($1,$2,$3);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_listaGrupoPorIdArea($idArea) {
    $this->db->getConnection();
    $aparam = array($idArea);
    $this->sql = "Select * From sp_show_grupoporidarea($1);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }


  public function get_listaGrupoPorIdAreaAndIdAtencion($idAtencion, $idArea, $idGrupo) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_grupoporidareaandidatencion(" . $idAtencion . ", " . $idArea . ", " . $idGrupo . ", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaGrupoPorIdAreaAndIdAtencionAndIdProducto($idAtencion, $idArea, $idProd) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_grupoporidareaandidatencionandidproducto(" . $idAtencion . ", " . $idArea . ", " . $idProd . ", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function post_reg_grupoarea($param) {
    $this->db->getConnection();
    $aparam = array($param[0]['accion'], $param[0]['grupoarea'], $param[0]['userIngreso']);
    $this->sql = "select sp_reg_grupoarea($1,$2,$3);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_tblDatosGrupo($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select g.id_grupo, g.descrip_grupo, g.estado,
    Case When g.estado=1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_grupo g";
    if (!empty($param[0]['idEstado'])) {
      $this->sql .= " Where g.estado = '" . $param[0]['idEstado'] . "'";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountGrupo($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_grupo g";
    if (!empty($param[0]['idEstado'])) {
      $this->sql .= " Where g.estado = '" . $param[0]['idEstado'] . "'";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_listaGrupoAreaPorIdArea($idArea){
    $this->db->getConnection();
    $aparam = array($idArea);
    $this->sql = "Select ga.id_grupoarea, g.descrip_grupo grupo From tbl_grupo g
    Inner Join tbl_grupoxarea ga On ga.id_grupo = g.id_grupo
    Where ga.estado=1 And ga.id_area=$1";
    $this->sql .= " Order By ga.ord_grupoarea";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }


  public function get_tblDatosArea($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select a.id_area, a.ord_area, a.abrev_area, a.descrip_area, a.visible, (Select count(id_area) From tbl_grupoxarea Where id_area=a.id_area And estado=1) cnt_grupo,
    Case When a.visible='1' Then 'VISIBLE'::Varchar Else 'NO VISIBLE'::Varchar End nom_visible From tbl_area a
    Where a.estado = 1";
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountArea($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_area a
    Where a.estado = 1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  /*public function get_tblDatosGrupoPorArea($sWhere, $sOrder, $sLimit, $param) {
  $this->db->getConnection();
  $this->sql = "Select ga.id_grupoarea, a.ord_area nro_area, descrip_area area, id_grupoarea, descrip_grupo grupo, ga.ord_grupoarea nro_grupoarea, ga.visible, ga.estado,
  Case When ga.visible='1' Then 'VISIBLE'::Varchar Else 'NO VISIBLE'::Varchar End nom_visible,
  Case When ga.estado=1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_grupo g
  Inner Join tbl_grupoxarea ga On ga.id_grupo = g.id_grupo
  Inner Join tbl_area a On ga.id_area = a.id_area
  Where g.estado=1 And a.estado=1";
  if (!empty($param[0]['idEstado'])) {
  $this->sql .= " And ga.estado = '" . $param[0]['idEstado'] . "'";
}
$this->sql .= $sOrder . $sLimit;
$this->rs = $this->db->query($this->sql);
$this->db->closeConnection();
return $this->rs;
}

public function get_tblCountGrupoPorArea($sWhere, $param) {
$this->db->getConnection();
$this->sql = "Select count(*) cnt From tbl_grupo g
Inner Join tbl_grupoxarea ga On ga.id_grupo = g.id_grupo
Inner Join tbl_area a On ga.id_area = a.id_area
Where g.estado=1 And a.estado=1";
if (!empty($param[0]['idEstado'])) {
$this->sql .= " And ga.estado = '" . $param[0]['idEstado'] . "'";
}
$this->rs = $this->db->query($this->sql);
$this->db->closeConnection();
return $this->rs[0]['cnt'];
}*/

}
