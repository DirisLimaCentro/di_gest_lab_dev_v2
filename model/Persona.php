<?php

include_once 'ConectaDb.php';

class Persona {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function get_datosDetallePersona($optRep, $tipDocPer, $nroDoc) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_personadetalle('" . $optRep ."', '" . $tipDocPer . "', '" . $nroDoc . "', 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosDetallePersonaUltimaAtencionPorIdDed($optRep, $tipDocPer, $nroDoc, $idDep) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_personaultimaatencionpordependencia('" . $optRep ."', '" . $tipDocPer . "', '" . $nroDoc . "', '" . $idDep . "', 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosDetallePersonaPadron($nroDoc) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_consult_personapadron('" . $nroDoc . "', 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosDetalleDireccionConViaPorDatosPersona($optRep, $tipDocPer, $nroDoc) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_direccionconviaporpersona('" . $optRep ."', '" . $tipDocPer . "', '" . $nroDoc . "', 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
}
