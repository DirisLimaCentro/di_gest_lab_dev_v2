<?php

include_once 'ConectaDb.php';

class LabRef {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

    public function get_listaPoblacionTPHA() {
        $conet = $this->db->getConnection();
        $this->sql = "Select id, abreviatura_poblacion, nombre_poblacion From lab_ref.tbl_tipo_poblacion_tpha Where id_estado=1 order by orden_poblacion";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
    public function get_listaResultadoDetallePorExamen($id_seleccion) {
        $conet = $this->db->getConnection();
        $this->sql = "Select id, abreviatura, nombre From public.tbl_componente_seleccionresuldet Where id_componente_seleccionresul=" . $id_seleccion . " Order By orden_muestra_resul";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
  
	public function post_reg_psa($param) {
		$this->db->getConnection();
		$aparam = array($param[0]['accion'], $param[0]['id'], $param[0]['datos'], $param[0]['userIngreso']);
		$this->sql = "select lab_ref.sp_crud_psa($1,$2,$3,$4);";
		$this->rs = $this->db->query_params($this->sql, $aparam);
		$this->db->closeConnection();
		return $this->rs[0][0];
	}
}
