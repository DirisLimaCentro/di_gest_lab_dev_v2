<?php

include_once 'ConectaDb.php';

class Ubigeo {
  
  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function get_listaUbigeoDepartamentosPeru() {
    $this->db->getConnection();
    $this->sql = "Select substring(id_ubigeo, 1, 2) id_ubigeo, departamento From tbl_ubigeo2019 Where id_pais='PER' And id_estadoreg=1 Group By substring(id_ubigeo, 1, 2), departamento Order By departamento";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaUbigeoPeru() {
    $this->db->getConnection();
    $this->sql = "Select id_ubigeo, distrito, provincia, departamento From tbl_ubigeo2019 Where id_pais='PER' And id_estadoreg=1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaUbigeoLimaCallaoPeru() {
    $this->db->getConnection();
    $this->sql = "Select id_ubigeo, distrito, provincia, departamento From tbl_ubigeo2019 Where id_pais='PER' And (substring(id_ubigeo from 1 for 2)='14' Or substring(id_ubigeo from 1 for 2)='24') And id_estadoreg=1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaUbigeoLimaPeru() {
    $this->db->getConnection();
    $this->sql = "Select id_ubigeo, distrito, provincia, departamento From tbl_ubigeo2019 Where id_pais='PER' And substring(id_ubigeo, 1, 2)='14' And id_estadoreg=1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaProvinciaAndDistritoPorIdDepartamento($idDepartamento) {
    $this->db->getConnection();
    $this->sql = "Select id_ubigeo, distrito, provincia, departamento From tbl_ubigeo2019 Where id_pais='PER' And substring(id_ubigeo, 1, 2)='".$idDepartamento."' And id_estadoreg=1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaPais() {
    $this->db->getConnection();
    $this->sql = "Select distinct id_pais, provincia nom_pais From tbl_ubigeo2019 Where id_pais<>'PER' And id_estadoreg=1
    Union all Select 'PER', 'PERÚ' Order By nom_pais";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

}
