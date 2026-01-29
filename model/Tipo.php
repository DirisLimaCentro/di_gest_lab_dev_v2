<?php

include_once 'ConectaDb.php';

class Tipo {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function get_listaTipoDocPerNatu() {
    $this->db->getConnection();
    $this->sql = "Select id_tipodoc, abreviatura, descripcion From tbl_tipodoc Where estado=1 And (id_cattipodoc=1 Or id_cattipodoc=3) Order By id_tipodoc";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  public function get_listaTipoDocPerNatuConDoc() {
    $this->db->getConnection();
    $this->sql = "Select id_tipodoc, abreviatura, descripcion From tbl_tipodoc Where estado=1 And id_cattipodoc=1 Order By id_tipodoc";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaTipoDocPerNatuConDocAdulto() {
    $this->db->getConnection();
    $this->sql = "Select id_tipodoc, abreviatura, descripcion From tbl_tipodoc Where estado=1 And id_cattipodoc=1 And id_tipodoc<>5 Order By id_tipodoc";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaTipoDocPerNatuSinDocAndConDocAdulto() {
    $this->db->getConnection();
    $this->sql = "Select id_tipodoc, abreviatura, descripcion From tbl_tipodoc Where estado=1 And (id_cattipodoc=1 Or id_cattipodoc=3) And id_tipodoc<>5 Order By id_tipodoc";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }


    public function get_listaTipoDocPerNatuSinDocAndConDocMenor() {
      $this->db->getConnection();
      $this->sql = "Select id_tipodoc, abreviatura, descripcion From tbl_tipodoc Where estado=1 And (id_tipodoc=1 Or id_tipodoc=7) Order By id_tipodoc";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }

  public function selecina_tablatipo($id_tbl, $est, $ord) {
    $this->db->getConnection();
    $this->sql = "SELECT id_tabla, id_tipo, descripcion, val_abr, id_categoria FROM tablatipo WHERE id_tabla='" . $id_tbl . "'";
    if (!empty($ord)) {
      $this->sql.=" And idest_tablatipo='" . $est . "'";
    }
    if (!empty($ord)) {
      $this->sql.=" ORDER BY " . $ord . "";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
    //return $this->sql;
  }

  public function selecina_tablatipo_id($id_tabla, $est, $id) {
    $this->db->getConnection();
    $this->sql = "SELECT id_tabla, id_tipo, descripcion, val_abr, id_categoria FROM tablatipo WHERE id_tabla='" . $id_tabla . "' And id_tipo='" . $id . "'";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
    //return $this->sql;
  }

  public function selecina_tablatipo_valabr($id_tabla, $est, $valabr) {
    $this->db->getConnection();
    $this->sql = "SELECT id_tabla, id_tipo, descripcion, val_abr, id_categoria FROM tablatipo WHERE id_tabla='" . $id_tabla . "' And val_abr='" . $valabr . "'";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    //return $this->rs;
    return $this->sql;
  }

  public function selecina_tablatipo_categoria($id_tbl, $id_cat, $est, $ord) {
    $this->db->getConnection();
    $this->sql = "SELECT id_tabla, id_tipo, descripcion, val_abr, id_categoria FROM tablatipo WHERE id_tabla='" . $id_tbl . "' and id_categoria in (" . $id_cat . ")";
    if (!empty($ord)) {
      $this->sql.=" ORDER BY " . $ord . "";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
    //return $this->sql;
  }

  public function selecina_tipo_dh() {
    $this->db->getConnection();
    $this->sql = "SELECT id_tabla, id_tipo, descripcion, val_abr, id_categoria FROM tablatipo WHERE id_tabla='86' and id_tipo<>'1'";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function selecina_parentesco() {
    $this->db->getConnection();
    $this->sql = "select id_tipo,descripcion, id_categoria from tablatipo where id_tabla='86' and id_tipo in('3','2','5','6','7','1')  order by 1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaParentesco() {
    $this->db->getConnection();
    $this->sql = "Select id_parentesco, nom_parentesco From tbl_parentesco Where estado=1 Order By nom_parentesco";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaFinanciador() {
    $this->db->getConnection();
    $this->sql = "Select id, nom_financiador From tbl_financiador Where id_estadoreg=1 Order By nom_financiador";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_listaFinanciadorSinSIS() {
    $this->db->getConnection();
    $this->sql = "Select id, nom_financiador From tbl_financiador Where id_estadoreg=1 And id<>2 Order By nom_financiador";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  
  public function get_listaCie10PAP() {
    $this->db->getConnection();
    $this->sql = "Select id_cie, nom_cie From tbl_cie10 Where id_estadoreg=1 Order By nom_cie";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_listaTipoSeguroSis() {
    $this->db->getConnection();
    $this->sql = "Select id_codigoasegurado, nom_codasegurado From tbl_codigoasegurado Where estado=1 Order By nom_codasegurado";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaTipoVia() {
    $this->db->getConnection();
    $this->sql = "Select id_tipovia, abrev_tipovia, nom_tipovia From tbl_direciontipovia Where estado=1 Order By 1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaTipoPoblacion() {
    $this->db->getConnection();
    $this->sql = "Select id_tipopoblacion, abrev_tipopoblacion, nom_tipopoblacion From tbl_direciontipopoblacion Where estado=1 Order By 1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaEtnia() {
    $this->db->getConnection();
    $this->sql = "Select id_etnia, nom_etnia From tbl_etnia Where id_estadoreg=1 Order By 1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_listaBACTipoMuestra() {
    $this->db->getConnection();
    $this->sql = "Select id_tipo id, cod_referencial, abrev_tipo abreviatura, descr_tipo tipo From tbl_bacteriologia_tablatipo Where id_estadoreg=1 And id_tabla=1 Order By 1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_listaBACTipoExamen() {
    $this->db->getConnection();
    $this->sql = "Select id_tipo id, cod_referencial, abrev_tipo abreviatura, descr_tipo tipo From tbl_bacteriologia_tablatipo Where id_estadoreg=1 And id_tabla=6 Order By 1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_listaBACPruebaRapida() {
    $this->db->getConnection();
    $this->sql = "Select id_tipo id, cod_referencial, abrev_tipo abreviatura, descr_tipo tipo From tbl_bacteriologia_tablatipo Where id_estadoreg=1 And id_tabla=7 Order By 1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_listaBACPruebaConvencional() {
    $this->db->getConnection();
    $this->sql = "Select id_tipo id, cod_referencial, abrev_tipo abreviatura, descr_tipo tipo From tbl_bacteriologia_tablatipo Where id_estadoreg=1 And id_tabla=8 Order By 1";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

    public function get_listaTipoNotificacion() {
      $this->db->getConnection();
      $this->sql = "Select id_tiponotif, nom_tiponotif From tbl_tiponotificicacion Where estado=1 Order By nom_tiponotif";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }

    public function get_listaRx() {
        $conet = $this->db->getConnection();
        $this->sql = "Select id, nom_tiporx From tbl_rxtipoexamen Where estado=1";
        $this->sql .= " Order By nom_tiporx";
        $this->rs = $this->db->query($this->sql);
        $this->db->closeConnection();
        return $this->rs;
    }

  function function_calculaEdad($fecha_ini, $fecha_fin){
    date_default_timezone_set('America/Lima');
    //rearmar la fecha
    $f1=explode("/", $fecha_ini);
    $fecha_ini=$f1[2]."-".$f1[1]."-".$f1[0];

    //separamos en partes las fechas
    $array_fecini = explode("-", $fecha_ini);
    $array_fecfin = explode("/", $fecha_fin);


    $anos =  $array_fecfin[2] - $array_fecini[0]; // calculamos años
    $meses = $array_fecfin[1] - $array_fecini[1]; // calculamos meses
    $dias =  $array_fecfin[0] - $array_fecini[2]; // calculamos días

    //ajuste de posible negativo en $días
    if ($dias < 0){
      --$meses;

      //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
      switch ($array_fecfin[1]) {
        case 1:   $dias_mes_anterior=31; break;
        case 2:   $dias_mes_anterior=31; break;
        case 3:
        //if (bisiesto($array_fecfin[0])){
        if (($array_fecfin[0]%4 == 0 && $array_fecfin[0]%100 != 0) || $array_fecfin[0]%400 == 0){
          $dias_mes_anterior=29; break;
        }else{
          $dias_mes_anterior=28; break;
        }
        case 4:   $dias_mes_anterior=31; break;
        case 5:   $dias_mes_anterior=30; break;
        case 6:   $dias_mes_anterior=31; break;
        case 7:   $dias_mes_anterior=30; break;
        case 8:   $dias_mes_anterior=31; break;
        case 9:   $dias_mes_anterior=31; break;
        case 10:   $dias_mes_anterior=30; break;
        case 11:   $dias_mes_anterior=31; break;
        case 12:   $dias_mes_anterior=30; break;
      }
      $dias=$dias + $dias_mes_anterior;
    }

    //ajuste de posible negativo en $meses
    if ($meses < 0){
      --$anos;
      $meses=$meses + 12;
    }

    $arrayName = array(0 => $anos, 1 => $meses, 2 => $dias);
    return $arrayName;
  }

  public function get_datosfecHoraActual() {
    $conet = $this->db->getConnection();
    $this->sql = "Select to_char(now(), 'dd/mm/yyyy hh12:mi:ss AM') fechora_actual;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  function nombrar_fecha($fecha){
    $mes=array('', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SETIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
    $dianom=date("d", strtotime($fecha));
    $mesnom=date("m", strtotime($fecha))*1;
    $anionom=date("Y", strtotime($fecha));
    $cadena=$dianom." de ".$mes[$mesnom]." del ".$anionom;
    return $cadena;
  }

}
