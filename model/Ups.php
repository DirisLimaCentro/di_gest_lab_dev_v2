<?php

include_once 'ConectaDb.php';

class Ups {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

    public function get_listaUps() {
        $conet = $this->db->getConnection();
        $this->sql = "Select id_ups, descripcion From tbl_ups Where estado=1";
        $this->sql .= " Order By descripcion";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_tblDatosUps($sWhere, $sOrder, $sLimit, $param) {
      $this->db->getConnection();
      $this->sql = "Select ups.id_ups, ups.abreviatura, ups.descripcion, ups.estado,
      Case When ups.estado=1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_ups ups";
      if (!empty($param[0]['idEstado'])) {
        $this->sql .= " Where ups.estado = '" . $param[0]['idEstado'] . "'";
      }
      $this->sql .= $sOrder . $sLimit;
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }

    public function get_tblCountUps($sWhere, $param) {
      $this->db->getConnection();
      $this->sql = "Select count(*) cnt From tbl_ups ups";
      if (!empty($param[0]['idEstado'])) {
        $this->sql .= " Where ups.estado = '" . $param[0]['idEstado'] . "'";
      }
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs[0]['cnt'];
    }
}
