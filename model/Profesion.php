<?php

include_once 'ConectaDb.php';

class Profesion {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

    public function get_tblDatosProfesion($sWhere, $sOrder, $sLimit, $param) {
      $this->db->getConnection();
      $this->sql = "Select pr.id_profesion, pr.cod_refprofesion, pr.nom_profesion, pr.estado,
      Case When pr.estado=1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_profesion pr";
      if (!empty($param[0]['idEstado'])) {
        $this->sql .= " Where pr.estado = '" . $param[0]['idEstado'] . "'";
      }
      $this->sql .= $sOrder . $sLimit;
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }

    public function get_tblCountProfesion($sWhere, $param) {
      $this->db->getConnection();
      $this->sql = "Select count(*) cnt From tbl_profesion pr";
      if (!empty($param[0]['idEstado'])) {
        $this->sql .= " Where pr.estado = '" . $param[0]['idEstado'] . "'";
      }
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs[0]['cnt'];
    }
}
