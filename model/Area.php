<?php

include_once 'ConectaDb.php';

class Area {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

    public function post_reg_area($param) {
        $this->db->getConnection();
        $aparam = array($param[0]['accion'], $param[0]['area'], $param[0]['userIngreso']);
        $this->sql = "select sp_reg_area($1,$2,$3);";
        $this->rs = $this->db->query_params($this->sql, $aparam);
        $this->db->closeConnection();
        return $this->rs[0][0];
      }

    public function get_datosAreaPorId($idUsu) {
        $this->db->getConnection();
        $aparam = array($idUsu);
        $this->sql = "Select a.id_area, a.ord_area nro_area, a.abrev_area, a.descrip_area area,
a.visible, Case When a.visible='1' Then 'VISIBLE'::Varchar Else 'NO VISIBLE'::Varchar End nom_visible,
a.estado, Case When a.estado=1 Then 'ACTIVO'::Varchar Else 'DESACTIVADO'::Varchar End nom_estado From tbl_area a
Where a.id_area=$1";
        $this->rs = $this->db->query_params($this->sql, $aparam);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_datosNueOrdArea() {
      $this->db->getConnection();
      $this->sql = "Select coalesce(max(ord_area), 0) + 1 cnt From tbl_area a Where estado=1";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs[0]['cnt'];
    }

    public function get_listaArea() {
        $conet = $this->db->getConnection();
        $this->sql = "Select * From sp_show_areas();";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_listaAreaPorIdAtencion($idAtencion, $idArea) {
        $conet = $this->db->getConnection();
        $this->sql = "Select * From sp_show_areaporidatencion(" . $idAtencion .", " . $idArea . ", 'ref_cursor'); Fetch All In ref_cursor;";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_listaAreaPorIdAtencionAndIdProducto($idAtencion, $idProd) {
        $conet = $this->db->getConnection();
        $this->sql = "Select * From sp_show_areaporidatencionandidproducto(" . $idAtencion .", " . $idProd . ", 'ref_cursor'); Fetch All In ref_cursor;";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_listaAreaPorIdAtencionAndIdProductoAndIdProdAnterior($idAtencion, $idProd, $idProdAnte) {
        $conet = $this->db->getConnection();
        $this->sql = "Select * From sp_show_areaporidatencionandidproductoandidprodante(" . $idAtencion .", " . $idProd . ", '" . $idProdAnte . "', 'ref_cursor'); Fetch All In ref_cursor;";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_tblDatosArea($sWhere, $sOrder, $sLimit, $param) {
      $this->db->getConnection();
      $this->sql = "Select a.id_area, a.ord_area, a.abrev_area, a.descrip_area, a.visible, a.estado,
      Case When a.visible='1' Then 'VISIBLE'::Varchar Else 'NO VISIBLE'::Varchar End nom_visible,
      Case When a.estado=1 Then 'ACTIVO'::Varchar Else 'INACTIVO'::Varchar End nom_estado From tbl_area a";
      if (!empty($param[0]['idEstado'])) {
        $this->sql .= " Where a.estado = '" . $param[0]['idEstado'] . "'";
      }
      $this->sql .= $sOrder . $sLimit;
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }

    public function get_tblCountArea($sWhere, $param) {
      $this->db->getConnection();
      $this->sql = "Select count(*) cnt From tbl_area a";
      if (!empty($param[0]['idEstado'])) {
        $this->sql .= " Where a.estado = '" . $param[0]['idEstado'] . "'";
      }
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs[0]['cnt'];
    }

}
