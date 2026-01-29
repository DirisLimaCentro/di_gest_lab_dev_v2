<?php

include_once 'ConectaDb.php';

class Servicio {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function post_reg_serviciodep($param) {
      $this->db->getConnection();
      $aparam = array($param[0]['accion'], $param[0]['serviciodep'], $param[0]['userIngreso']);
      $this->sql = "select sp_reg_serviciodep($1,$2,$3);";
      $this->rs = $this->db->query_params($this->sql, $aparam);
      $this->db->closeConnection();
      return $this->rs[0][0];
    }

  public function get_listaServicio() {
    $this->db->getConnection();
    $this->sql = "Select se.id_servicio, se.nom_servicio From tbl_servicio se
    Where se.estado = 1 Order By nom_servicio;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaServicioDependenciaPorIdDep($idDep) {
    $this->db->getConnection();
    $aparam = array($idDep);
    $this->sql = "Select sed.id_serviciodep, abrev_servicio, nom_servicio From tbl_servicio se
    Inner Join tbl_serviciodependencia sed On se.id_servicio = sed.id_servicio Where sed.id_dependencia=$1
    Order By nom_servicio;";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaServicioPorIdDep($idDep) {
    $this->db->getConnection();
    $aparam = array($idDep);
    $this->sql = "Select se.id_servicio, abrev_servicio, nom_servicio From tbl_servicio se
    Inner Join tbl_serviciodependencia sed On se.id_servicio = sed.id_servicio
    Where sed.id_dependencia=$1 And sed.estado=1 And se.estado=1 Order By nom_servicio;";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosServicioPorIdDep($idDep, $idEst = 0) {
    $this->db->getConnection();
    $aparam = array($idDep);
    $this->sql = "Select sed.id_serviciodep, se.nom_servicio, sed.estado,
    Case When sed.estado=1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_serviciodependencia sed
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Where sed.id_dependencia=$1";
    if ($idEst <> 0) {
      $this->sql .= " And sed.estado = " . $idEst . "";
    }
    $this->sql .= " Order By se.nom_servicio";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }
}
