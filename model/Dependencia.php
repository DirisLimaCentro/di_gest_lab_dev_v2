<?php

include_once 'ConectaDb.php';

class Dependencia {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

    public function post_reg_dependencia($param) {
        $this->db->getConnection();
        $aparam = array($param[0]['accion'], $param[0]['dependencia'], $param[0]['userIngreso']);
        $this->sql = "select sp_reg_dependencia($1,$2,$3);";
        $this->rs = $this->db->query_params($this->sql, $aparam);
        $this->db->closeConnection();
        return $this->rs[0][0];
      }

    public function get_datosDepenendenciaPorId($idDep) {
        $this->db->getConnection();
        $aparam = array($idDep);
        $this->sql = "Select d.id_dependencia, d.id_tipdepen, Case When d.id_tipdepen=1 Then 'SEDE CENTRAL'::Varchar When d.id_tipdepen=2 Then 'CENTRO DE SALUD'::Varchar When d.id_tipdepen=3 Then 'HOSPITAL'::Varchar When d.id_tipdepen=4 Then 'EXTERNOS'::Varchar When d.id_tipdepen=5 Then 'OFICINA ADMINISTRATIVA'::Varchar When d.id_tipdepen=6 Then 'ESPECIALIDADES'::Varchar End nom_tipdepen,
        d.codref_depen, d.abrev_depen, d.nom_depen, d.cat_depen, d.id_ubigeo, departamento, provincia, distrito, direc_depen,
        d.check_tipocorre, d.check_impriticket, d.tip_impresora, d.check_envlamisede,
        d.estado id_estado, Case When d.estado=1 Then 'ACTIVO'::Varchar Else 'DESACTIVADO'::Varchar End nom_estado
        From tbl_dependencia d Left Join tbl_ubigeo2019 ub On d.id_ubigeo = ub.id_ubigeo
        Where d.id_dependencia=$1";
        $this->rs = $this->db->query_params($this->sql, $aparam);
        $this->db->closeConnection();
        return $this->rs;
    }
	
    public function get_datosDepenendenciaPorNombre($nomDep) {
        $this->db->getConnection();
        $aparam = array($nomDep);
        $this->sql = "Select d.id_dependencia, d.id_tipdepen, Case When d.id_tipdepen=1 Then 'SEDE CENTRAL'::Varchar When d.id_tipdepen=2 Then 'CENTRO DE SALUD'::Varchar When d.id_tipdepen=3 Then 'HOSPITAL'::Varchar When d.id_tipdepen=4 Then 'EXTERNOS'::Varchar When d.id_tipdepen=5 Then 'OFICINA ADMINISTRATIVA'::Varchar When d.id_tipdepen=6 Then 'ESPECIALIDADES'::Varchar End nom_tipdepen,
        d.codref_depen, d.abrev_depen, d.nom_depen, d.cat_depen, d.id_ubigeo, departamento, provincia, distrito, direc_depen,
        d.check_tipocorre, d.check_impriticket, d.tip_impresora, d.check_envlamisede,
        d.estado id_estado, Case When d.estado=1 Then 'ACTIVO'::Varchar Else 'DESACTIVADO'::Varchar End nom_estado
        From tbl_dependencia d Left Join tbl_ubigeo2019 ub On d.id_ubigeo = ub.id_ubigeo
        Where d.nom_depen=$1 Limit 1";
        $this->rs = $this->db->query_params($this->sql, $aparam);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_listaDepenInstitucion() {
        $conet = $this->db->getConnection();
        $this->sql = "Select id_dependencia, codref_depen, nom_depen From tbl_dependencia Where estado=1 And id_tipdepen IN (0,1,2,3,4)";
        $this->sql .= " Order By nom_depen";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }
	
    public function get_listaDepenInstitucionCompleto() {
        $conet = $this->db->getConnection();
        $this->sql = "Select id_dependencia, codref_depen, nom_depen From tbl_dependencia Where estado=1";
        $this->sql .= " Order By nom_depen";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_tblDatosDependencia($sWhere, $sOrder, $sLimit, $param) {
      $this->db->getConnection();
      $this->sql = "Select d.id_dependencia, d.id_tipdepen, Case When d.id_tipdepen=1 Then 'SEDE CENTRAL'::Varchar When d.id_tipdepen=2 Then 'CENTRO DE SALUD'::Varchar When d.id_tipdepen=3 Then 'HOSPITAL'::Varchar When d.id_tipdepen=4 Then 'EXTERNOS'::Varchar When d.id_tipdepen=5 Then 'OFICINA ADMINISTRATIVA'::Varchar When d.id_tipdepen=6 Then 'ESPECIALIDADES'::Varchar End nom_tipdepen,
      d.codref_depen, d.abrev_depen, d.nom_depen, d.cat_depen, departamento||'-' ||provincia|| '-' ||distrito ||'-'|| direc_depen direc_depen,
      (Select count(*) From tbl_serviciodependencia Where id_dependencia=d.id_dependencia And estado=1) cnt_servicio,
      d.estado id_estado, Case When d.estado=1 Then 'ACTIVO'::Varchar Else 'DESACTIVADO'::Varchar End nom_estado
      From tbl_dependencia d Left Join tbl_ubigeo2019 ub On d.id_ubigeo = ub.id_ubigeo";
      $this->sql .= $sWhere. $sOrder . $sLimit;
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }

    public function get_tblCountDependencia($sWhere, $param) {
      $this->db->getConnection();
      $this->sql = "Select count(*) cnt From tbl_dependencia d Left Join tbl_ubigeo2019 ub On d.id_ubigeo = ub.id_ubigeo";
      $this->sql .= $sWhere;
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs[0]['cnt'];
    }
	
	/*********************************************************************************************/
	//////////////////////////////////////////// LABORATORIO //////////////////////////////////////
	/*********************************************************************************************/
	
    public function get_datosDepenendenciaPorIdRIS($idRIS = 0) {
        $conet = $this->db->getConnection();
        $this->sql = "Select d.id_dependencia, d.id_tipdepen, Case When d.id_tipdepen=1 Then 'SEDE CENTRAL'::Varchar When d.id_tipdepen=2 Then 'CENTRO DE SALUD'::Varchar When d.id_tipdepen=3 Then 'HOSPITAL'::Varchar When d.id_tipdepen=4 Then 'EXTERNOS'::Varchar When d.id_tipdepen=5 Then 'OFICINA ADMINISTRATIVA'::Varchar When d.id_tipdepen=6 Then 'ESPECIALIDADES'::Varchar End nom_tipdepen,
        d.codref_depen, d.abrev_depen, d.nom_depen, d.cat_depen, d.id_ubigeo, departamento, provincia, distrito, direc_depen,
        d.check_tipocorre, d.check_impriticket, d.tip_impresora, d.check_envlamisede, d.nro_ris_pertenece, 
        d.estado id_estado, Case When d.estado=1 Then 'ACTIVO'::Varchar Else 'DESACTIVADO'::Varchar End nom_estado
        From tbl_dependencia d Left Join tbl_ubigeo2019 ub On d.id_ubigeo = ub.id_ubigeo
        Where d.check_lab_diris=TRUE";
		if($idRIS <> 0){
				$this->sql .= " And d.nro_ris_pertenece=" . $idRIS;
		}
		$this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
		return $this->rs;
    }
}
