<?php

include_once 'ConectaDb.php';

class Tarifa {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function get_listaTarifaPorIdDep($idDep) {
      $conet = $this->db->getConnection();
      $this->sql = "Select ta.id_plan, ta.abrev_plan, ta.nom_plan, ta.sigla_plan, ta.id_tipoplan, ta.check_precio
From tbl_plantarifa ta
Inner Join tbl_plantarifadep tad On ta.id_plan = tad.id_plan
Where tad.id_dependencia = ".$idDep." And ta.estado=1 And tad.estado=1";
      $this->sql .= " Order By ta.id_plan";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
  }

    public function get_listaTarifaDepPorIdTipPlan($idDep, $idTipPlan) {
        $conet = $this->db->getConnection();
        $this->sql = "Select ta.id_plan, ta.abrev_plan, ta.nom_plan, ta.sigla_plan, ta.id_tipoplan, ta.check_precio
From tbl_plantarifa ta
Inner Join tbl_plantarifadep tad On ta.id_plan = tad.id_plan
Where tad.id_dependencia = ".$idDep." And (id_tipoplan=".$idTipPlan." Or id_tipoplan=3) And ta.estado=1 And tad.estado=1";
        $this->sql .= " Order By ta.id_plan";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

}
