<?php

include_once 'ConectaDb.php';

class Profesional {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

    public function post_valid_exis_profesional($tipdoc, $nrodoc) {
      $this->db->getConnection();
      $this->sql = "Select count(id_profesional) cnt From tbl_profesional pro
      Inner Join tbl_persona p On pro.id_persona=p.id_persona Where p.id_tipodoc=" . $tipdoc . " And p.nrodoc='" . $nrodoc . "'";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs[0]['cnt'];
    }

  public function post_reg_profesional($param) {
    $this->db->getConnection();
    $aparam = array($param[0]['accion'], $param[0]['persona'], $param[0]['profesion'], $param[0]['userIngreso']);
    $this->sql = "select sp_reg_profesional($1,$2,$3,$4);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_datosProfesionalPorIdPerAndIdDep($idPer, $idDep, $idEst = 0) {
    $this->db->getConnection();
    $this->sql = "Select pro.id_profesional, pro.id_serviciodep, p.id_persona id_persona, p.id_tipodoc id_tipodocpro, tdp.abreviatura abrev_tipodocpro, p.nrodoc nro_docpro, Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspro,
    d.id_dependencia, d.nom_depen, se.id_servicio, se.nom_servicio, pr.cod_refprofesion, pr.nom_profesion profesion, pro.nro_colegiatura, pro.nro_rne, pro.id_cargo, ca.nom_cargo,
    pro.estado, Case When pro.estado=1 Then 'ACTIVO'::Varchar Else 'DESACTIVADO'::Varchar End nom_estado From tbl_profesional pro
    Inner Join tbl_serviciodependencia sed On pro.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_profesion pr On pro.id_profesion = pr.id_profesion
    Inner Join tbl_cargo ca On pro.id_cargo = ca.id_cargo
    Inner Join tbl_persona p On pro.id_persona = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Where pro.id_persona = " . $idPer . " And sed.id_dependencia = " . $idDep . "";
    if($idEst <> 0){
      $this->sql .= " And pro.estado=" . $idEst . "";
    }
    $this->sql .= " Order By 1 Limit 1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblDatosProfesional($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
	if (empty($param[0]['idRol'])) {
		$this->sql = "Select pro.id_profesional, p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspro,
		pro.id_profesion, pr.nom_profesion, pro.nro_colegiatura, pro.nro_rne, pro.id_condicion_laboral, condilab.abreviatura condicion_laboral,
		pro.estado, Case When pro.estado=1 Then 'ACTIVO'::Varchar Else 'DESACTIVADO'::Varchar End nom_estado 
		From tbl_profesional pro 
		Inner Join tbl_profesion pr On pro.id_profesion = pr.id_profesion
		Left Join tbl_condicion_laboral condilab On pro.id_condicion_laboral=condilab.id
		Inner Join tbl_persona p On pro.id_persona = p.id_persona
		Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc";
	} else {
		$this->sql = "select p.id_profesional, p.id_persona id_paciente, p.id_tipodoc, p.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspro,
p.id_profesion, p.nom_profesion, p.nro_colegiatura, p.nro_rne, p.estado, Case When p.estado=1 Then 'ACTIVO'::Varchar Else 'DESACTIVADO'::Varchar End nom_estado	
From (Select pro.id_profesional, p.id_persona, p.id_tipodoc, tdp.abreviatura, p.nrodoc, p.primer_ape, p.segundo_ape, p.nombre_rs,
pro.id_profesion, pr.nom_profesion, pro.nro_colegiatura, pro.nro_rne, pro.id_condicion_laboral, condilab.abreviatura condicion_laboral, pro.estado 
From tbl_profesional pro 
Inner Join tbl_profesion pr On pro.id_profesion = pr.id_profesion
Left Join tbl_condicion_laboral condilab On pro.id_condicion_laboral=condilab.id
Inner Join tbl_persona p On pro.id_persona = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join (Select Distinct id_profesional From tbl_profesionalservicio Where id_rol in (6,7,8,9,10) And estado=1) una On pro.id_profesional=una.id_profesional
Union All
Select pro.id_profesional, p.id_persona, p.id_tipodoc, tdp.abreviatura, p.nrodoc, p.primer_ape, p.segundo_ape, p.nombre_rs,
pro.id_profesion, pr.nom_profesion, pro.nro_colegiatura, pro.nro_rne, pro.estado From tbl_profesional pro
Inner Join tbl_profesion pr On pro.id_profesion = pr.id_profesion
Inner Join tbl_persona p On pro.id_persona = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Where pro.id_profesional Not in (Select Distinct id_profesional From tbl_profesionalservicio Where estado=1)) p Where estado<>0";
	}
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And p.nrodoc ||' '|| Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
    if (!empty($param[0]['id_dependencia'])) {
      $this->sql .= " And pro.id_profesional In (Select id_profesional From tbl_profesionalservicio Where id_dependencia=".$param[0]['id_dependencia'].")";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountProfesional($sWhere, $param) {
    $this->db->getConnection();
	if (empty($param[0]['idRol'])) {
		$this->sql = "Select count(*) cnt From tbl_profesional pro
		Inner Join tbl_profesion pr On pro.id_profesion = pr.id_profesion
		Inner Join tbl_persona p On pro.id_persona = p.id_persona
		Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc";
	} else {
		$this->sql = "select count(*) cnt From (Select pro.id_profesional, p.id_persona, p.id_tipodoc, tdp.abreviatura, p.nrodoc, p.primer_ape, p.segundo_ape, p.nombre_rs,
pro.id_profesion, pr.nom_profesion, pro.nro_colegiatura, pro.nro_rne, pro.estado From tbl_profesional pro
		Inner Join tbl_profesion pr On pro.id_profesion = pr.id_profesion
		Inner Join tbl_persona p On pro.id_persona = p.id_persona
		Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
		Inner Join (Select Distinct id_profesional From tbl_profesionalservicio Where id_rol in (6,7,8,9,10) And estado=1) una On pro.id_profesional=una.id_profesional
		Union All
		Select pro.id_profesional, p.id_persona, p.id_tipodoc, tdp.abreviatura, p.nrodoc, p.primer_ape, p.segundo_ape, p.nombre_rs,
pro.id_profesion, pr.nom_profesion, pro.nro_colegiatura, pro.nro_rne, pro.estado From tbl_profesional pro
		Inner Join tbl_profesion pr On pro.id_profesion = pr.id_profesion
		Inner Join tbl_persona p On pro.id_persona = p.id_persona
		Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
		Where pro.id_profesional Not in (Select Distinct id_profesional From tbl_profesionalservicio Where estado=1)) p Where estado<>0";
	}
		if (!empty($param[0]['nomRS'])) {
		  $this->sql .= " And p.nrodoc ||' '|| Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
		}
		if (!empty($param[0]['id_dependencia'])) {
		  $this->sql .= " And pro.id_profesional In (Select id_profesional From tbl_profesionalservicio Where id_dependencia=".$param[0]['id_dependencia'].")";
		}
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_ListaProfesionalResulPAP() {
    $this->db->getConnection();
		$this->sql = "Select distinct u.id_usuario, primer_ape, segundo_ape, nombre_rs From tbl_papresul papr
		Inner Join tbl_usuario u On papr.user_create_at = u.id_usuario
		Inner Join tbl_persona p On u.id_persona = p.id_persona
		Order By primer_ape";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_ListaProfesionalPoridServicioAndIdDependencia($id_dep, $id_servicio, $id_estado=0) {
    $this->db->getConnection();
		$this->sql = "Select distinct u.id_usuario, primer_ape, segundo_ape, nombre_rs, prs.id_cargo, case prs.estado when 1 Then 'ACTIVO' Else 'INACTIVO' End estado_usuario From tbl_profesional pr
Inner Join tbl_profesionalservicio prs On pr.id_profesional=prs.id_profesional
Inner Join tbl_serviciodependencia sdep On prs.id_serviciodep=sdep.id_serviciodep
Inner Join tbl_usuario u On prs.id_usuario = u.id_usuario
Inner Join tbl_persona p On u.id_persona = p.id_persona
Where sdep.id_dependencia=" . $id_dep . " And sdep.id_servicio=" . $id_servicio;
	if ($id_estado == 1) {
		$this-> sql .= " And prs.estado=1";
	}
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

    public function get_datosServicioPorIdProfesional($id) {
      $conet = $this->db->getConnection();
      $this->sql = "Select * From sp_show_profesionalservicio(" . $id .", 'ref_cursor'); Fetch All In ref_cursor;";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }

    public function get_datosUsuarioPorIdProfesional($id) {
      $this->db->getConnection();
      $this->sql = "Select id_usuario, nom_usuario From tbl_profesional pr
  Inner Join tbl_persona p On pr.id_persona = p.id_persona
  Left Join tbl_usuario u On p.id_persona = u.id_persona Where id_profesional=".$id."";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }

  public function get_repDatosProfesional($param) {
    $this->db->getConnection();
	$this->sql = "Select d.nom_depen dependencia, s.nom_servicio servicio, tdp.abreviatura abrev_tipodoc, p.nrodoc nro_doc, Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs profesional,
pr.nom_profesion profesion, pro.nro_colegiatura, pro.nro_rne, tf.nro_telefono telefono_fijo, tm.nro_telefono telefono_movil, te.email,
cap.nom_cargo cargo, u.nom_usuario usuario, rol.nom_rol rol
From tbl_profesional pro
Inner Join tbl_profesionalservicio pros On pro.id_profesional = pros.id_profesional
Inner Join tbl_dependencia d On pros.id_dependencia = d.id_dependencia
Inner Join tbl_serviciodependencia sdep On pros.id_serviciodep = sdep.id_serviciodep 
Inner Join tbl_servicio s On sdep.id_servicio = s.id_servicio
Inner Join tbl_persona p On pro.id_persona = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_profesion pr On pro.id_profesion = pr.id_profesion
Left Join (Select max(id_histotelefono) id_histotelefono, id_persona From tbl_historialtelefono Where id_tipotelefono=1 And estado=1 Group By id_persona) mtf On p.id_persona = mtf.id_persona
Left Join tbl_historialtelefono tf On mtf.id_histotelefono = tf.id_histotelefono
Left Join (Select max(id_histotelefono) id_histotelefono, id_persona From tbl_historialtelefono Where id_tipotelefono=2 And estado=1 Group By id_persona) mtm On p.id_persona = mtm.id_persona
Left Join tbl_historialtelefono tm On mtm.id_histotelefono = tm.id_histotelefono
Left Join (Select max(id_histoemail) id_histoemail, id_persona From tbl_historialemail Where estado=1 Group By id_persona) mte On p.id_persona = mte.id_persona
Left Join tbl_historialemail te On mte.id_histoemail = te.id_histoemail
Inner Join tbl_cargo cap On pros.id_cargo = cap.id_cargo
Inner Join tbl_usuario u On pros.id_usuario = u.id_usuario
Inner Join tbl_rol rol On pros.id_rol = rol.id_rol
Where pro.estado=1 And pros.estado=1";
	if (empty($param[0]['idRol'])) {
		$this-> sql .= " Order By d.id_dependencia";
	} else {
		$this-> sql .= " And rol.id_rol in (6,7,8,9,10) Order By d.id_dependencia";
	}
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  

  public function get_repDatosProfesionalPorServicio($id_modulo, $id_dependencia) {
    $this->db->getConnection();
	$this->sql = "Select dep.nom_depen, tdp.abreviatura abrev_tipodoc, profp.nrodoc nro_doc, Case When profp.primer_ape isNull Then '' Else profp.primer_ape End||' '||Case When profp.segundo_ape isNull Then '' Else profp.segundo_ape End ||' '||profp.nombre_rs nombre_profesional,
pr.nom_profesion, prof.nro_colegiatura, condilab.nombre nom_condi_laboral, serv.nom_servicio, car.nom_cargo, us.nom_usuario, rol.nom_rol, to_char(profserv.create_at::date, 'DD/MM/YYYY') fec_registro
From tbl_profesionalservicio profserv
Inner Join tbl_dependencia dep On profserv.id_dependencia=dep.id_dependencia
Inner Join tbl_serviciodependencia depserv On profserv.id_serviciodep=depserv.id_serviciodep
Inner Join tbl_servicio serv On depserv.id_servicio=serv.id_servicio
Inner Join tbl_profesional prof On profserv.id_profesional=prof.id_profesional
Inner Join tbl_persona profp On prof.id_persona=profp.id_persona
Inner Join tbl_tipodoc tdp On profp.id_tipodoc=tdp.id_tipodoc
Inner Join tbl_profesion pr On prof.id_profesion=pr.id_profesion
Inner Join tbl_cargo car On profserv.id_cargo=car.id_cargo
Inner Join tbl_usuario us On profserv.id_usuario=us.id_usuario
Inner Join tbl_rol rol On profserv.id_rol=rol.id_rol
Left Join tbl_condicion_laboral condilab On prof.id_condicion_laboral=condilab.id
Where profserv.estado=1";
		if (!empty($id_modulo)) {
			if($id_modulo == 1){
				$this->sql .= " And rol.id_modulo_lab=" . $id_modulo . "";
			}
		}
		if (!empty($id_dependencia)) {
		  $this->sql .= " And dep.id_dependencia=".$id_dependencia."";
		}
	$this->sql .= " Order By dep.nom_depen, profserv.create_at";		
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  
}
