<?php

include_once 'ConectaDb.php';

class Bacteriologia {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function post_reg_solicitud($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['id'], $paramReg[0]['paciente'], $paramReg[0]['apoderado'], $paramReg[0]['solicitud'], $paramReg[0]['diagnostico'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From sp_reg_bateriologiasoli($1, $2, $3, $4, $5, $6, $7);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function post_reg_envio($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['id'], $paramReg[0]['detalle'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From sp_reg_bacteriologiaenvio($1, $2, $3, $4);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_datosSolicitud($idSolicitud) {
      $conet = $this->db->getConnection();
      $this->sql = "Select * From sp_show_bacsoli(" . $idSolicitud .", 'ref_cursor'); Fetch All In ref_cursor;";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
  }
  
  public function get_datosSolicitudDiagnostico($idSolicitud) {
      $conet = $this->db->getConnection();
      $this->sql = "Select id, id_diagnostico, obacd.descr_tipo diagnostico, bacd.desc_diagnostico From tbl_bacteriologiasoli_diag bacd Inner Join tbl_bacteriologia_tablatipo obacd On bacd.id_diagnostico = obacd.id_tipo And obacd.id_tabla=4  Where id_atencion=".$idSolicitud." And bacd.id_estadoreg=1;";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
  }

  public function get_datosResultado($idSolicitud, $idTipo) {
      $conet = $this->db->getConnection();
      $this->sql = "Select * From sp_show_bacresul(" . $idSolicitud .", " . $idTipo .", 'ref_cursor'); Fetch All In ref_cursor;";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
  }

  public function get_tblDatosSolicitud($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select sba.id, sba.nro_atencion, sba.anio_atencion, p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=sba.id_dependencia) nro_hc, Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac,
so.id_persona id_solicitante, so.id_tipodoc id_tipodocsoli, tdso.abreviatura abrev_tipodocsoli, so.nrodoc nro_docsoli, Case When so.primer_ape isNull Then '' Else so.primer_ape End||' '||so.nombre_rs nombre_rssoli,
to_char(sba.fec_atencion, 'DD/MM/YYYY') fec_atencion, to_char(sba.create_finalize, 'DD/MM/YYYY') fec_finalizado, sba.id_estadoreg id_estadosolibac, esba.nom_estado nom_estadosolibac From tbl_bacteriologiasoli sba
Inner Join tbl_bacteriologiaestado esba On sba.id_estadoreg = esba.id
Inner Join tbl_persona p On sba.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_usuario u On sba.user_create_at = u.id_usuario
Inner Join tbl_persona so On u.id_usuario = so.id_persona
Inner Join tbl_tipodoc tdso On p.id_tipodoc = tdso.id_tipodoc
Where sba.id_estadoreg<>0 And sba.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And sba.fec_atencion between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And p.nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountSolicitud($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_bacteriologiasoli sba
    Inner Join tbl_bacteriologiaestado esba On sba.id_estadoreg = esba.id
    Inner Join tbl_persona p On sba.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_usuario u On sba.user_create_at = u.id_usuario
	Inner Join tbl_persona so On u.id_usuario = so.id_persona
    Inner Join tbl_tipodoc tdso On p.id_tipodoc = tdso.id_tipodoc
    Where sba.id_estadoreg<>0 And sba.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And sba.fec_atencion between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And p.nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_tblDatosEnvSolicitud($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select env.id, nro_envio||'-'||anio_envio nro_envio, d.id_dependencia, d.nom_depen, to_char(env.fec_envio, 'DD/MM/YYYY') fec_envio,
env.id_estadoreg, eenv.nom_estado nom_estadoreg,
(Select count(*) From tbl_bacteriologiaenviodet Where id_envio= env.id) cnt_solienvtot,
0 cnt_finalizado
From tbl_bacteriologiaenvio env
Inner Join tbl_papenvioestado eenv On env.id_estadoreg = eenv.id_papenvestado
Inner Join tbl_dependencia d On env.id_dependencia_origen = d.id_dependencia
Where env.id_servicio_origen=1 And d.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And env.fec_envio between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountEnvSolicitud($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_bacteriologiaenvio env
Inner Join tbl_papenvioestado eenv On env.id_estadoreg = eenv.id_papenvestado
Inner Join tbl_dependencia d On env.id_dependencia_origen = d.id_dependencia
Where env.id_servicio_origen=1 And d.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And env.fec_envio between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }
  
  public function get_tblDatosResultadoLabEESS($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select sba.id, sba.nro_atencion, sba.anio_atencion, rbac.nro_reglab, rbac.anio_reglab, rbac.id_estado_resultado, 
p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=sba.id_dependencia) nro_hc, Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac,
d.id_dependencia, d.nom_depen dependencia_solitante,
to_char(sba.fec_atencion, 'DD/MM/YYYY') fec_atencion, to_char(sba.create_finalize, 'DD/MM/YYYY') fec_finalizado, 
rbac.id_estado_resultado, erbac.nom_estado estado_resultado, rbac.id_resultado, terbac.descr_tipo resultado
From tbl_bacteriologiaresul rbac
Inner Join tbl_bacteriologiasoli sba On rbac.id_atencion = sba.id
Inner Join tbl_dependencia d On sba.id_dependencia = d.id_dependencia
Inner Join tbl_bacteriologiaestado_resultado erbac On rbac.id_estado_resultado = erbac.id
Inner Join tbl_persona p On sba.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Left Join tbl_bacteriologia_tablatipo terbac On rbac.id_resultado = terbac.id_tipo And terbac.id_tabla=11
Where sba.id_estadoreg<>0 And rbac.id_estado_resultado In (1,2) And sba.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['id_tipprocedimiento'])) {
      $this->sql .= " And id_tipprocedimiento=" . $param[0]['id_tipprocedimiento'] . "";
    }
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And sba.fec_atencion between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And p.nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountResultadoLabEESS($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_bacteriologiaresul rbac
Inner Join tbl_bacteriologiasoli sba On rbac.id_atencion = sba.id
Inner Join tbl_dependencia d On sba.id_dependencia = d.id_dependencia
Inner Join tbl_bacteriologiaestado_resultado erbac On rbac.id_estado_resultado = erbac.id
Inner Join tbl_persona p On sba.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Left Join tbl_bacteriologia_tablatipo terbac On rbac.id_resultado = terbac.id_tipo And terbac.id_tabla=11
Where sba.id_estadoreg<>0 And rbac.id_estado_resultado In (1,2) And sba.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['id_tipprocedimiento'])) {
      $this->sql .= " And id_tipprocedimiento=" . $param[0]['id_tipprocedimiento'] . "";
    }
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And sba.fec_atencion between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And p.nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }
  
  public function get_tblDatosSolicitudNoEnviada($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select bac.id, bac.nro_atencion, bac.anio_atencion, to_char(bac.fec_atencion, 'DD/MM/YYYY') fec_atencion,
tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac,
Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, 
(Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc, Case When bac.check_tipopac=True Then 'SI' Else 'NO' End pac_sis,
pu.nombre_rs||' '||Case When pu.primer_ape isNull Then '' Else pu.primer_ape End nombre_profe
From tbl_bacteriologiasoli bac 
Inner Join tbl_dependencia d On bac.id_dependencia = d.id_dependencia
Inner Join tbl_persona p On bac.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_usuario u On bac.user_create_at = u.id_usuario
Inner Join tbl_persona pu On u.id_persona = pu.id_persona
Where bac.id_estadoreg=1 And d.id_dependencia=" . $param[0]['idDepAten'] . " ";
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountSolicitudNoEnviada($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_bacteriologiasoli bac 
Inner Join tbl_dependencia d On bac.id_dependencia = d.id_dependencia
Inner Join tbl_persona p On bac.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_usuario u On bac.user_create_at = u.id_usuario
Inner Join tbl_persona pu On u.id_persona = pu.id_persona
Where bac.id_estadoreg=1 And d.id_dependencia=" . $param[0]['idDepAten'] . "";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }
  
  public function get_tblDatosRecepcionarEnvio($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select env.id, env.nro_envio::Varchar||'-'||env.anio_envio nro_envio, d.id_dependencia, d.nom_depen, to_char(fec_envio, 'DD/MM/YYYY') fec_envio, 
env.id_estadoreg id_estadopapenv, eenv.nom_estado nom_estadopapenv,
(Select count(*) From tbl_bacteriologiaenviodet Where id_envio= env.id And id_estadoreg<>0) cnt_solienvtot
From tbl_bacteriologiaenvio env
Inner Join tbl_papenvioestado eenv On env.id_estadoreg = eenv.id_papenvestado
Inner Join tbl_dependencia d On env.id_dependencia_origen = d.id_dependencia";
    if (!empty($param[0]['estEnv'])) {
      if ($param[0]['estEnv'] == "Pro") {
        $this->sql .= " Where (env.id_estadoreg=2 Or env.id_estadoreg=3)";
      } else {
        $this->sql .= " Where (env.id_estadoreg=4)";
      }
    } else {
      $this->sql .= " Where (env.id_estadoreg=1)";
    }
    if (!empty($param[0]['idDepRef'])) {
      $this->sql .= " And d.id_dependencia=" . $param[0]['idDepRef'] . "";
    }
    if (!empty($param[0]['id_servicio_origen'])) {
      $this->sql .= " And env.id_servicio_origen=" . $param[0]['id_servicio_origen'] . "";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountRecepcionarEnvio($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_bacteriologiaenvio env
Inner Join tbl_papenvioestado eenv On env.id_estadoreg = eenv.id_papenvestado
Inner Join tbl_dependencia d On env.id_dependencia_origen = d.id_dependencia";
    if (!empty($param[0]['estEnv'])) {
      if ($param[0]['estEnv'] == "Pro") {
        $this->sql .= " Where (env.id_estadoreg=2 Or env.id_estadoreg=3)";
      } else {
        $this->sql .= " Where (env.id_estadoreg=4)";
      }
    } else {
      $this->sql .= " Where (env.id_estadoreg=1)";
    }
    if (!empty($param[0]['idDepRef'])) {
      $this->sql .= " And d.id_dependencia=" . $param[0]['idDepRef'] . "";
    }
    if (!empty($param[0]['id_servicio_origen'])) {
      $this->sql .= " And env.id_servicio_origen=" . $param[0]['id_servicio_origen'] . "";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_tblDatosEnvioALabReferencial($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select env.id, nro_envio||'-'||anio_envio nro_envio, d.id_dependencia, d.nom_depen, to_char(env.fec_envio, 'DD/MM/YYYY') fec_envio,
env.id_estadoreg, eenv.nom_estado nom_estadoreg,
(Select count(*) From tbl_bacteriologiaenviodet Where id_envio= env.id) cnt_solienvtot,
0 cnt_finalizado
From tbl_bacteriologiaenvio env
Inner Join tbl_papenvioestado eenv On env.id_estadoreg = eenv.id_papenvestado
Inner Join tbl_dependencia d On env.id_dependencia_origen = d.id_dependencia
Where env.id_servicio_origen=2 And d.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And env.fec_envio between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountEnvioALabReferencial($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_bacteriologiaenvio env
Inner Join tbl_papenvioestado eenv On env.id_estadoreg = eenv.id_papenvestado
Inner Join tbl_dependencia d On env.id_dependencia_origen = d.id_dependencia
Where env.id_servicio_origen=2 And d.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And env.fec_envio between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_tblDatosLabReferencialNoEnviada($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select bac.id, bac.nro_atencion, bac.anio_atencion, to_char(bac.fec_atencion, 'DD/MM/YYYY') fec_atencion, rbac.nro_reglab, rbac.anio_reglab,
tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac,
Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, 
(Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc, Case When bac.check_tipopac=True Then 'SI' Else 'NO' End pac_sis,
pu.nombre_rs||' '||Case When pu.primer_ape isNull Then '' Else pu.primer_ape End nombre_profe,
d.id_dependencia, d.nom_depen dependencia_solitante
From tbl_bacteriologiaresul rbac
Inner Join tbl_bacteriologiasoli bac On rbac.id_atencion=bac.id
Inner Join tbl_dependencia d On bac.id_dependencia = d.id_dependencia
Inner Join tbl_persona p On bac.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_usuario u On bac.user_create_at = u.id_usuario
Inner Join tbl_persona pu On u.id_persona = pu.id_persona
Where bac.id_estadoreg=2 And rbac.id_tipprocedimiento=1 And rbac.id_estado_resultado=3 
And bac.id Not In (Select id_atencion From tbl_bacteriologiaenviodet de Inner Join tbl_bacteriologiaenvio e On de.id_envio=e.id Where e.id_servicio_origen=2)
And rbac.id_dependencia=" . $param[0]['idDepAten'] . " ";
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountLabReferencialNoEnviada($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_bacteriologiaresul rbac
Inner Join tbl_bacteriologiasoli bac On rbac.id_atencion=bac.id
Inner Join tbl_dependencia d On bac.id_dependencia = d.id_dependencia
Inner Join tbl_persona p On bac.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_usuario u On bac.user_create_at = u.id_usuario
Inner Join tbl_persona pu On u.id_persona = pu.id_persona
Where bac.id_estadoreg=2 And rbac.id_tipprocedimiento=1 And rbac.id_estado_resultado=3 
And bac.id Not In (Select id_atencion From tbl_bacteriologiaenviodet de Inner Join tbl_bacteriologiaenvio e On de.id_envio=e.id Where e.id_servicio_origen=2)
And rbac.id_dependencia=" . $param[0]['idDepAten'] . "";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }  
  
}
