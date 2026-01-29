<?php

include_once 'ConectaDb.php';

class Cargo {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function get_tblDatosCargo($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select ca.id_cargo, ca.nom_cargo,
    ca.estado, Case When ca.estado=1 Then 'ACTIVO'::Varchar Else 'DESACTIVADO'::Varchar End nom_estado From tbl_cargo ca";
    if (!empty($param[0]['idEstado'])) {
      $this->sql .= " Where ca.estado = '" . $param[0]['idEstado'] . "'";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountCargo($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_cargo ca";
    if (!empty($param[0]['idEstado'])) {
      $this->sql .= " Where ca.estado = '" . $param[0]['idEstado'] . "'";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

}
