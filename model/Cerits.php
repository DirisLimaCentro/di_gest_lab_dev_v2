<?php

include_once 'ConectaDb.php';

class Cerits {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function post_reg_constanciaits($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['paciente'], $paramReg[0]['solicitud'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From sp_reg_cerisoliits($1, $2, $3, $4);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_datosSoliConstanciaITS($idSolicitud) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_cerisoliits(" . $idSolicitud .", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblDatosSoliConstanciaITS($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select ce.id id_cerisoliits, p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc,
    Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac,
    to_char(ce.fec_atencion, 'DD/MM/YYYY') fec_atencion, nro_atencion nro_ordensoli, substring(extract(year from ce.fec_atencion)::Varchar, 3) anio_ordensoli, d.nom_depen, ce.estado id_estadosoli,
    pu.nombre_rs||' '||Case When pu.primer_ape isNull Then '' Else pu.primer_ape End nombre_profe
    From tbl_cerisoliits ce
    Inner Join tbl_serviciodependencia sed On ce.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_persona p On ce.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_usuario u On ce.user_create_at = u.id_usuario
    Inner Join tbl_persona pu On u.id_persona = pu.id_persona";
    if (!empty($param[0]['idDepAten'])) {
      $this->sql .= " And d.id_dependencia='" . $param[0]['idDepAten'] . "'";
    }
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And ce.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
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

  public function get_tblCountSoliConstanciaITS($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_cerisoliits ce
    Inner Join tbl_serviciodependencia sed On ce.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_persona p On ce.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_usuario u On ce.user_create_at = u.id_usuario
    Inner Join tbl_persona pu On u.id_persona = pu.id_persona";
    if (!empty($param[0]['idDepAten'])) {
      $this->sql .= " And d.id_dependencia='" . $param[0]['idDepAten'] . "'";
    }
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And ce.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
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

}
