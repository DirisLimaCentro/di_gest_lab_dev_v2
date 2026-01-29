<?php

include_once 'ConectaDb.php';

class Menu {

    private $db;
    private $sql;

    public function __construct() {
        $this->db = new ConectaDb();
        $this->rs = array();
    }

    public function listaMenuActivoPorRol($idRol) {
        $this->db->getConnection();
        $this->sql = "Select m.id_menu From tbl_menu m Where id_group_rol like '%" . $idRol . "%';";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_DetAccesoUser($idUsuDep) {
        $this->db->getConnection();
        $this->sql = "Select id_menu, nom_detmenu, link_detmenu From tbl_usuarioacceso a
Inner Join tbl_menudetalle m On a.id_detmenu = m.id_detmenu
Where a.id_profesionalservicio=" . $idUsuDep . " And a.estado=1 And m.estado=1 And id_modulo isNull Order By id_menu, order_detmenu";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function listaMenuPrincipal() {
        $this->db->getConnection();
        $this->sql = "Select Distinct pad_name From tbl_menu Order By pad_name";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_repDatosAccesoPorUsuario($param) {
        $this->db->getConnection();
        $this->sql = "Select a.id_usuario, a.id_menu, m.pad_name, m.bar_name, bar_link from tbl_acceso a inner join tbl_menu m on a.id_menu=m.id_menu
Where id_usuario=" . $param[0]['idUsu'] . "";
        if (!empty($param[0]['idMenuUsu'])) {
            $this->sql .= " And m.pad_name='" . $param[0]['idMenuUsu'] . "'";
        }
        $this->sql .= " Order By id_menu,bar_name";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

    public function get_repDatosAccesoNoIncluUsuario($param) {
        $this->db->getConnection();
        $this->sql = "Select m.id_menu, m.pad_name, m.bar_name, m.bar_link  From tbl_menu m
Where id_menu Not In (Select id_menu From tbl_acceso Where id_usuario=" . $param[0]['idUsu'] . ")";
        if (!empty($param[0]['idMenuUsu'])) {
            $this->sql .= " And m.pad_name='" . $param[0]['idMenuUsu'] . "'";
        }
        $this->sql .= " Order By id_menu,bar_name";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

}
