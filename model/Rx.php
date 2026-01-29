<?php

include_once 'ConectaDb.php';

class Rx {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function post_reg_atencion($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['paciente'], $paramReg[0]['apoderado'], $paramReg[0]['atencion'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From sp_reg_rxsoli($1, $2, $3, $4, $5);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_tblDatosAtencion($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select rx.id, p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc,
    Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac,
    to_char(rx.fec_atencion, 'DD/MM/YYYY') fec_atencion, nro_atencion, anio_atencion, d.nom_depen, nom_carpeta, rx.id_estado, rx.id_estado, e.nom_estado,  id_estadoresul, er.nom_estado nom_estadoresul,
    pu.nombre_rs||' '||Case When pu.primer_ape isNull Then '' Else pu.primer_ape End nombre_profe
    From tbl_rx rx
    Inner Join tbl_dependencia d On rx.id_dependencia = d.id_dependencia
    Inner Join tbl_persona p On rx.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_usuario u On rx.user_create_at = u.id_usuario
    Inner Join tbl_persona pu On u.id_persona = pu.id_persona
    Inner Join tbl_rxestado e On rx.id_estado = e.id
    Inner Join tbl_rxestadoresul er On rx.id_estado = er.id
    Where d.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
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

  public function get_tblCountAtencion($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_rx rx
    Inner Join tbl_dependencia d On rx.id_dependencia = d.id_dependencia
    Inner Join tbl_persona p On rx.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_usuario u On rx.user_create_at = u.id_usuario
    Inner Join tbl_persona pu On u.id_persona = pu.id_persona
    Inner Join tbl_rxestado e On rx.id_estado = e.id
    Inner Join tbl_rxestadoresul er On rx.id_estado = er.id
    Where d.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
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

    public function get_tblDatosLectura($sWhere, $sOrder, $sLimit, $param) {
      $this->db->getConnection();
      $this->sql = "Select rx.id, p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc,
      Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac,
      to_char(rx.fec_atencion, 'DD/MM/YYYY') fec_atencion, nro_atencion, anio_atencion, d.nom_depen, rx.id_tiporx, te.nom_tiporx,nom_carpeta, rx.id_estado, rx.id_estado, e.nom_estado,  id_estadoresul, er.nom_estado nom_estadoresul,
      pu.nombre_rs||' '||Case When pu.primer_ape isNull Then '' Else pu.primer_ape End nombre_profe
      From tbl_rx rx
      Inner Join tbl_dependencia d On rx.id_dependencia = d.id_dependencia
      Inner Join tbl_persona p On rx.id_paciente = p.id_persona
      Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
      Inner Join tbl_usuario u On rx.user_create_at = u.id_usuario
      Inner Join tbl_persona pu On u.id_persona = pu.id_persona
      Inner Join tbl_rxtipoexamen te On rx.id_tiporx = te.id
      Inner Join tbl_rxestado e On rx.id_estado = e.id
      Inner Join tbl_rxestadoresul er On rx.id_estado = er.id
      Where rx.id_estado=1";
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

    public function get_tblCountLectura($sWhere, $param) {
      $this->db->getConnection();
      $this->sql = "Select count(*) cnt From tbl_rx rx
      Inner Join tbl_dependencia d On rx.id_dependencia = d.id_dependencia
      Inner Join tbl_persona p On rx.id_paciente = p.id_persona
      Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
      Inner Join tbl_usuario u On rx.user_create_at = u.id_usuario
      Inner Join tbl_persona pu On u.id_persona = pu.id_persona
      Inner Join tbl_rxtipoexamen te On rx.id_tiporx = te.id
      Inner Join tbl_rxestado e On rx.id_estado = e.id
      Inner Join tbl_rxestadoresul er On rx.id_estado = er.id
      Where rx.id_estado=1";
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
