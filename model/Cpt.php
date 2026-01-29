<?php

include_once 'ConectaDb.php';

class Cpt {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function post_reg_cpt($param) {
    $this->db->getConnection();
    $aparam = array($param[0]['accion'], $param[0]['cpt'], $param[0]['userIngreso']);
    $this->sql = "select sp_reg_cpt($1,$2,$3);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_datosCptPorId($idUsu) {
    $this->db->getConnection();
    $aparam = array($idUsu);
    $this->sql = "Select id_cpt, denominacion_cpt, 
estado, Case When estado=1 Then 'ACTIVO'::Varchar Else 'DESACTIVADO'::Varchar End nom_estado From tbl_cpt
Where id_cpt=$1";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
}

  public function get_listaCptLaboratorio() {
    $this->db->getConnection();
    $this->sql = "Select id_cpt, denominacion_cpt From tbl_cpt Where estado=1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblDatosCpt($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select cpt.id_cpt, cpt.denominacion_cpt, cpt.estado,
    Case When cpt.estado=1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_cpt cpt";
    if (!empty($param[0]['idEstado'])) {
      $this->sql .= " Where cpt.estado = '" . $param[0]['idEstado'] . "'";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountCpt($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_cpt cpt";
    if (!empty($param[0]['idEstado'])) {
      $this->sql .= " Where cpt.estado = '" . $param[0]['idEstado'] . "'";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

}
