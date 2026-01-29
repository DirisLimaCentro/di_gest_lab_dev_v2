<?php

include_once 'ConectaDb.php';

class ITS {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function post_reg_its_sifilis($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['id'], $paramReg[0]['paciente'], $paramReg[0]['atencion'], $paramReg[0]['detatencion'], $paramReg[0]['menor'], $paramReg[0]['referencia'], $paramReg[0]['seguimiento'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From its.sp_reg_itssifilis($1, $2, $3, $4, $5, $6, $7, $8, $9);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_datos_itssifilis($tipo, $id) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From its.sp_show_itssifilis(" . $tipo . ", " . $id .", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblDatosSoliConstanciaITS($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select si.id, p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc,
Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac,
d.nom_depen,
pu.nombre_rs||' '||Case When pu.primer_ape isNull Then '' Else pu.primer_ape End nombre_profe, 
si.chk_tiposeguimiento, Case When si.chk_tiposeguimiento = TRUE Then 'GESTANTE' Else 'PUÉRPERA' End tiposeguimiento, to_char(si.fec_proximavisita, 'DD/MM/YYYY') fec_proximavisita
From its.tbl_sifilis si
Inner Join tbl_dependencia d On si.id_dependencia = d.id_dependencia
Inner Join tbl_persona p On si.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_usuario u On si.user_create_at = u.id_usuario
Inner Join tbl_persona pu On u.id_persona = pu.id_persona";
    if (!empty($param[0]['idDepAten'])) {
      $this->sql .= " And d.id_dependencia='" . $param[0]['idDepAten'] . "'";
    }
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And si.create_at::date = '" . $param[0]['fecIniAte'] . "'";
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
    $this->sql = "Select count(*) cnt From its.tbl_sifilis si
Inner Join tbl_dependencia d On si.id_dependencia = d.id_dependencia
Inner Join tbl_persona p On si.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_usuario u On si.user_create_at = u.id_usuario
Inner Join tbl_persona pu On u.id_persona = pu.id_persona";
    if (!empty($param[0]['idDepAten'])) {
      $this->sql .= " And d.id_dependencia='" . $param[0]['idDepAten'] . "'";
    }
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And si.create_at::date = '" . $param[0]['fecIniAte'] . "'";
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
