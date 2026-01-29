<?php

include_once 'ConectaDb.php';

class Atencion {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function post_reg_laboratorio($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['id'], $paramReg[0]['paciente'], $paramReg[0]['solicitante'], $paramReg[0]['atencion'], $paramReg[0]['fua'], $paramReg[0]['producto'], $paramReg[0]['detAtencion'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From lab.sp_reg_laboratorio($1, $2, $3, $4, $5, $6, $7, $8, $9);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function post_reg_atenciondet($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['paciente'], $paramReg[0]['solicitante'], $paramReg[0]['atencion'], $paramReg[0]['cpt'], $paramReg[0]['detAtencion'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From sp_reg_atenciondet($1, $2, $3, $4, $5, $6, $7);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }
  
	public function post_reg_lab_resultado_desvalida($paramReg) {
		$this->db->getConnection();
		$aparam = array($paramReg[0]['id'], $paramReg[0]['datos_examen'], $paramReg[0]['userIngreso']);
		$this->sql = "Select * From lab.sp_reg_lab_resultado_desvalida($1, $2, $3);";
		$this->rs = $this->db->query_params($this->sql, $aparam);
		$this->db->closeConnection();
		return $this->rs[0][0];
	}

  public function post_reg_recepcionmuestra($paramDReg) {
    $this->db->getConnection();
    $aparam = array($paramDReg);
    $this->sql = "Select * From lab.sp_reg_recepcionmuestra($1);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

    public function post_reg_accion_complementaria($id, $accion, $detalle, $id_usuario) {
      $this->db->getConnection();
      $aparam = array($id, $accion, $detalle, $id_usuario);
      $this->sql = "Select * From lab.sp_reg_lab_accion_complementaria($1, $2, $3, $4);";
      $this->rs = $this->db->query_params($this->sql, $aparam);
      $this->db->closeConnection();
      return $this->rs[0][0];
    }

    public function post_reg_atencionvalidaresul($paramDReg) {
      $this->db->getConnection();
      $aparam = array($paramDReg);
      $this->sql = "Select * From sp_reg_atencionvalidaresul($1);";
      $this->rs = $this->db->query_params($this->sql, $aparam);
      $this->db->closeConnection();
      return $this->rs[0][0];
    }

  public function get_datosAtencion($idAtencion) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From lab.sp_show_atencion(" . $idAtencion .", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosAtencion_md5($idAtencion, $idDependencia) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_atencion_md5('" . $idAtencion ."','" . $idDependencia ."', 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosCptPorIdAtencion($idAtencion) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_atenciondetctp(" . $idAtencion .", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosProductoPorIdAtencion($idAtencion, $idProducto = 0, $tipo_reporte = '', $opt_estado = '') {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_atenciondetproducto(" . $idAtencion .", " . $idProducto .", '" . $tipo_reporte ."', '" . $opt_estado ."', 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosProductoPorIdAtencionAndIdTipoProducto($id_atencion, $id_tipoprod) {
    $this->db->getConnection();
    $this->sql = "Select dpro.id, dpro.id_atencion, dpro.id_producto, pro.nom_producto
From lab.tbl_labproductoatencion dpro
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto = tpro.id
Where dpro.id_atencion=" . $id_atencion;
	if (!empty($id_tipoprod)) {
		$this->sql .= " And tpro.id=" . $id_tipoprod;
	}
	$this->sql .= " And dpro.id_estado_reg=1 Order By orden_muestra_producto;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_repNroAtencionPorFechaAndIdDep($fecAtencion, $idDep) {
    $this->db->getConnection();
    $aparam = array($fecAtencion, $idDep);
    $this->sql = "select coalesce(max(nro_citadia),0) + 1 nroatencion From lab.tbl_labatencion Where fec_cita=$1 And id_dependencia=$2;";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    //$fecha = str_replace("/", "", $fecAtencion);
    //$nroAtencion = $fecha."-".$this->rs[0][0];
    return $this->rs[0][0];
  }

  public function get_datosIngDetComponenteAtencionPorIdCpt($idAtencion, $idCpt) {
    $this->db->getConnection();
    $this->sql = "Select dcpt.id_cpt, cpt.denominacion_cpt, ccpt.id_componentedetcpt, c.descrip_comp,
(Select ing_result From tbl_atenciondet Where id_atencion=dcpt.id_atencion And id_componentedet=cd.id_componentedet And estado=1) ing_result,
(Select det_result From tbl_atenciondet Where id_atencion=dcpt.id_atencion And id_componentedet=cd.id_componentedet And estado=1) det_result  From tbl_atenciondetcpt dcpt
Inner Join tbl_cpt cpt On dcpt.id_cpt = cpt.id_cpt
Inner Join tbl_componentedetcpt ccpt On cpt.id_cpt = ccpt.id_cpt
Inner Join tbl_componentedet cd On ccpt.id_componentedet = cd.id_componentedet
Inner Join tbl_componente c On cd.id_componente = c.id_componente
Where dcpt.estado=1 And dcpt.id_atencion=" . $idAtencion . " And dcpt.id_cpt='" . $idCpt . "';";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblDatosAtencion($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select la.id, la.id_dependencia, la.nro_atencion, la.anio_atencion, la.nro_atencion_manual, to_char(la.fec_atencion, 'DD/MM/YYYY') fec_atencion, to_char(la.fec_cita, 'DD/MM/YYYY') fec_cita, to_char(la.create_primera_toma, 'DD/MM/YYYY') fec_toma_muestra, 
tdp.abreviatura abrev_tipodoc, nrodoc, Case When primer_ape isNull Then '' Else primer_ape End||' '||Case When segundo_ape isNull Then '' Else segundo_ape End ||' '||nombre_rs nombre_rs,
(Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=la.id_dependencia) nro_hc,
la.id_plantarifario, ta.abrev_plan, ta.sigla_plan, la.chk_genera_fua, la.chk_genera_contraref, la.check_urgente, la.id_depenori, depori.nom_depen nom_depenori, 
la.id_estado_reg, estlab.abreviatura_estado nom_estadoreg, la.id_estado_resul, estlabrs.abreviatura_estado nom_estadoresul, la.id_atencion_orionlab, la.nro_atencion_orionlab,
la.id_tipo_genera_correlativo, ateref.id_atencion_procesa, 
ateapi.id_atencion_diagnostica
From lab.tbl_labatencion la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join lab.tbl_estado_lab estlab On la.id_estado_reg = estlab.id
Inner join lab.tbl_estado_lab_resultado estlabrs On la.id_estado_resul = estlabrs.id";
if (!isset($param[0]['desde_lab_refe'])) {
	if (!empty($param[0]['idProducto'])) {
		  $this->sql .= " Inner Join lateral (Select id_atencion From lab.tbl_labproductoatencion  
Where id_atencion=la.id And id_estado_reg='1' And id_producto In (" . $param[0]['idProducto'] . ") limit 1) refdoc On true";
	}
}
$this->sql .= " Left Join tbl_dependencia depori On la.id_depenori = depori.id_dependencia
Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Left Join lab.tbl_labatencion_referenciada ateref On la.id = ateref.id_atencion_procesa
Left Join lab.tbl_labatencion_api_tercero ateapi On la.id = ateapi.id_atencion
Where la.id<>0";

	if (isset($param[0]['desde_referencia'])) {
			$this->sql .= " And la.id_depenori=" . $param[0]['idDepAten'] . " And la.id_estado_resul in (3,4) And chk_muestra_resul_servicios=TRUE";
	} else {
		if (!empty($param[0]['idDepAten'])) {
			$this->sql .= " And la.id_dependencia=" . $param[0]['idDepAten'] . "";
		}
	}
	
    if (isset($param[0]['chk_referencia'])) {//Listado de referencias y FUA
      if (!empty($param[0]['chk_referencia'])) {
        $this->sql .= " And la.id_estado_reg<>0 And (la.chk_genera_fua=TRUE OR la.chk_genera_contraref=TRUE)";
      }
    }
    if (isset($param[0]['idEstAte'])) {
      if (!empty($param[0]['idEstAte'])) {//Esto envia en listado de registra resultado
        $this->sql .= " And la.id_estado_reg<>0 And la.id_estado_resul<>4";
      }
    }
	if (isset($param[0]['desde_lab_refe'])) {
		if (!empty($param[0]['nroAte'])) {
			  $this->sql .= " And nro_atencion_manual='" . $param[0]['nroAte'] . "'";
		}
		if (!empty($param[0]['fecIniAte'])) {
		  $this->sql .= " And la.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
		}		
	} else {
		if (!empty($param[0]['nroAte'])) {
			  $this->sql .= " And ((la.id_tipo_genera_correlativo=1 And nro_atencion::Varchar||'-'||anio_atencion::Varchar='" . $param[0]['nroAte'] . "') Or (la.id_tipo_genera_correlativo=3 And nro_atencion::Varchar='" . $param[0]['nroAte'] . "'))";
			  //$this->sql .= " And nro_atencion::Varchar||'-'||anio_atencion::Varchar='" . $param[0]['nroAte'] . "'";
		}
		if (!empty($param[0]['nroAteOtro'])) {
			  $this->sql .= " And nro_atencion_orionlab='" . $param[0]['nroAteOtro'] . "'";
		}
		if (!empty($param[0]['optUrgente'])) {
			if($param[0]['optUrgente'] == "1"){
			  $this->sql .= " And check_urgente=TRUE";
			} else {
			  $this->sql .= " And check_urgente=FALSE";
			}
		}
		if (!empty($param[0]['fecIniAte'])) {
		  $this->sql .= " And la.fec_cita::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
		}
		
	}
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
	if (!empty($param[0]['chk_ing_resul'])) {
		//$this->sql .= " And la.chk_ingresa_resultado = TRUE";
	}
	
	if (isset($param[0]['desde_servicio'])) {
      if ($param[0]['desde_servicio'] == 1) {
		  if (!empty($param[0]['idServicio'])) {
			$this->sql .= " And la.id_servicioori=". $param[0]['idServicio'];
		  }
		  if (!empty($param[0]['nroHCL'])) {
			$this->sql .= " And la.id_paciente=(Select id_persona From tbl_historialhc Where nro_hc='" . $param[0]['nroHCL'] . "' And id_dependencia=" . $param[0]['idDepAten'] . ")";
		  }
		  //$this->sql .= " And la.id_estado_reg in (3,4,5) And la.id_estado_resul in (3,4)";//REcibido completo, entregado a paciente
		  $this->sql .= " And la.id_estado_resul in (3,4) And chk_muestra_resul_servicios=TRUE And id_depenori isNull";
      }
    }
	if (isset($param[0]['fecha_pri_toma'])) {
		if (!empty($param[0]['fecha_pri_toma'])) {
			$this->sql .= " And la.create_primera_toma::date='" . $param[0]['fecha_pri_toma'] . "'";
		}
	}
	//$sOrder = "";
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountAtencion($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From lab.tbl_labatencion la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join lab.tbl_estado_lab estlab On la.id_estado_reg = estlab.id
Inner join lab.tbl_estado_lab_resultado estlabrs On la.id_estado_resul = estlabrs.id";
if (!isset($param[0]['desde_lab_refe'])) {
	if (!empty($param[0]['idProducto'])) {
		  $this->sql .= " Inner Join lateral (Select id_atencion From lab.tbl_labproductoatencion  
Where id_atencion=la.id And id_estado_reg='1' And id_producto In (" . $param[0]['idProducto'] . ") limit 1) refdoc On true";
	}
}
$this->sql .= " Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Where la.id<>0";
	if (isset($param[0]['desde_referencia'])) {
			$this->sql .= " And la.id_depenori=" . $param[0]['idDepAten'] . " And la.id_estado_resul in (3,4) And chk_muestra_resul_servicios=TRUE";
	} else {
		if (!empty($param[0]['idDepAten'])) {
			$this->sql .= " And la.id_dependencia=" . $param[0]['idDepAten'] . "";
		}
	}
    if (isset($param[0]['chk_referencia'])) {//Listado de referencias y FUA
      if (!empty($param[0]['chk_referencia'])) {
        $this->sql .= " And la.id_estado_reg<>0 And (la.chk_genera_fua=TRUE OR la.chk_genera_contraref=TRUE)";
      }
    }
    if (isset($param[0]['idEstAte'])) {
      if (!empty($param[0]['idEstAte'])) {//Esto envia en listado de registra resultado
        $this->sql .= " And la.id_estado_reg<>0 And la.id_estado_resul<>4";
      }
    }
	if (isset($param[0]['desde_lab_refe'])) {
		if (!empty($param[0]['nroAte'])) {
			  $this->sql .= " And nro_atencion_manual='" . $param[0]['nroAte'] . "'";
		}
		if (!empty($param[0]['fecIniAte'])) {
		  $this->sql .= " And la.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
		}		
	} else {
		if (!empty($param[0]['nroAte'])) {
			  $this->sql .= " And nro_atencion::Varchar||'-'||anio_atencion::Varchar='" . $param[0]['nroAte'] . "'";
		}
		if (!empty($param[0]['nroAteOtro'])) {
			  $this->sql .= " And nro_atencion_orionlab='" . $param[0]['nroAteOtro'] . "'";
		}
		if (!empty($param[0]['optUrgente'])) {
			if($param[0]['optUrgente'] == "1"){
			  $this->sql .= " And check_urgente=TRUE";
			} else {
			  $this->sql .= " And check_urgente=FALSE";
			}
		}
		if (!empty($param[0]['fecIniAte'])) {
		  $this->sql .= " And la.fec_cita::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
		}
	}
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
	if (!empty($param[0]['chk_ing_resul'])) {
		//$this->sql .= " And la.chk_ingresa_resultado = TRUE";
	}
	
	if (isset($param[0]['desde_servicio'])) {
      if ($param[0]['desde_servicio'] == 1) {
		  if (!empty($param[0]['idServicio'])) {
			$this->sql .= " And la.id_servicioori=". $param[0]['idServicio'];
		  }
		  if (!empty($param[0]['nroHCL'])) {
			$this->sql .= " And la.id_paciente=(Select id_persona From tbl_historialhc Where nro_hc='" . $param[0]['nroHCL'] . "' And id_dependencia=" . $param[0]['idDepAten'] . ")";
		  }
		  //$this->sql .= " And la.id_estado_reg in (3,4,5) And la.id_estado_resul in (3,4)";//REcibido completo, entregado a paciente
		  $this->sql .= " And la.id_estado_resul in (3,4) And chk_muestra_resul_servicios=TRUE And id_depenori isNull";
      }
    }
	if (isset($param[0]['fecha_pri_toma'])) {
		if (!empty($param[0]['fecha_pri_toma'])) {
			$this->sql .= " And la.create_primera_toma::date='" . $param[0]['fecha_pri_toma'] . "'";
		}
	}
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_tblRepDatosAtencion($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select la.id, to_char(la.fec_atencion, 'dd/mm/yyyy hh12:mi:ss AM') fec_atencion, la.nro_atencion, la.anio_atencion,
p.id_persona, p.id_tipodoc, tdp.abreviatura abrev_tipodoc, nrodoc, Case When primer_ape isNull Then '' Else primer_ape End||' '||Case When segundo_ape isNull Then '' Else segundo_ape End ||' '||nombre_rs nombre_rs,
(Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=la.id_dependencia) nro_hc,
la.id_plantarifario, ta.sigla_plan, ta.abrev_plan, la.id_estado_resul, estlabrs.abreviatura_estado nom_estadoresul,
la.id_depenori, la.id_tipo_genera_correlativo
From lab.tbl_labatencion la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Inner join lab.tbl_estado_lab_resultado estlabrs On la.id_estado_resul = estlabrs.id
Where la.id_dependencia=" . $param[0]['idDepAten'] . "";
$this->sql .= " And la.id_estado_reg<>0";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And la.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
	if (isset($param[0]['chk_gestante'])) {
      if ($param[0]['chk_gestante'] <> 99) {
		  if ($param[0]['chk_gestante'] == 1) {
			$this->sql .= " And la.check_gestante=TRUE";
			if ($param[0]['condicion_eg'] <> "") {
				$this->sql .= " And la.edad_gestacional" . $param[0]['condicion_eg'] . $param[0]['nro_eg'];
			}
		  } else {
			  $this->sql .= " And la.check_gestante=FALSE";
		  }
      }
    }
	if (isset($param[0]['condicion_edad'])) {
		if (!empty($param[0]['edad_hasta'])) {
			$this->sql .= " And date_part('year',age(la.fec_atencion, p.fec_nac)) between " . $param[0]['edad_desde'] . " And " . $param[0]['edad_hasta'];
		}
	}
	if (isset($param[0]['condicion_urgente'])) {
		if ($param[0]['condicion_urgente'] == 1) {
			$this->sql .= " And check_urgente=TRUE";
		}
	}
    if (!empty($param[0]['id_producto'])) {
      $this->sql .= " And la.id in (select distinct lab.id From lab.tbl_labproductoatencion dpro Inner Join lab.tbl_labatencion lab On dpro.id_atencion=lab.id Where id_producto in (".$param[0]['id_producto'].") And lab.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "')";
    }
	if (!empty($param[0]['chk_dep_procedencia'])) {
		if (empty($param[0]['id_dep_procedencia'])) {
			$this->sql .= " And la.id_depenori is not null";
		} else {
			$this->sql .= " And la.id_depenori=" . $param[0]['id_dep_procedencia'];
		}
	}
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblRepCountAtencion($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From lab.tbl_labatencion la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Inner join lab.tbl_estado_lab_resultado estlabrs On la.id_estado_resul = estlabrs.id
Where la.id_dependencia=" . $param[0]['idDepAten'] . "";
$this->sql .= " And la.id_estado_reg<>0";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And la.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
	if (isset($param[0]['chk_gestante'])) {
      if ($param[0]['chk_gestante'] <> 99) {
		  if ($param[0]['chk_gestante'] == 1) {
			$this->sql .= " And la.check_gestante=TRUE";
			if ($param[0]['condicion_eg'] <> "") {
				$this->sql .= " And la.edad_gestacional" . $param[0]['condicion_eg'] . $param[0]['nro_eg'];
			}
		  } else {
			  $this->sql .= " And la.check_gestante=FALSE";
		  }
      }
    }
	if (isset($param[0]['condicion_edad'])) {
		if (!empty($param[0]['edad_hasta'])) {
			$this->sql .= " And date_part('year',age(la.fec_atencion, p.fec_nac)) between " . $param[0]['edad_desde'] . " And " . $param[0]['edad_hasta'];
		}
	}
	if (isset($param[0]['condicion_urgente'])) {
		if ($param[0]['condicion_urgente'] == 1) {
			$this->sql .= " And check_urgente=TRUE";
		}
	}
    if (!empty($param[0]['id_producto'])) {
      $this->sql .= " And la.id in (select distinct lab.id From lab.tbl_labproductoatencion dpro Inner Join lab.tbl_labatencion lab On dpro.id_atencion=lab.id Where id_producto in (".$param[0]['id_producto'].") And lab.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "')";
    }
	if (!empty($param[0]['chk_dep_procedencia'])) {
		if (empty($param[0]['id_dep_procedencia'])) {
			$this->sql .= " And la.id_depenori is not null";
		} else {
			$this->sql .= " And la.id_depenori=" . $param[0]['id_dep_procedencia'];
		}
	}
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_repDatosAtencion($param) {
    $this->db->getConnection();
    $this->sql = "Select la.id, to_char(la.fec_atencion, 'dd/mm/yyyy') fec_atencion, to_char(la.fec_cita, 'dd/mm/yyyy') fec_cita, la.nro_atencion, la.anio_atencion, la.nro_atencion_manual, 
p.id_persona, p.id_tipodoc, tdp.abreviatura abrev_tipodoc, nrodoc, Case When primer_ape isNull Then '' Else primer_ape End||' '||Case When segundo_ape isNull Then '' Else segundo_ape End ||' '||nombre_rs nombre_rs, p.id_sexo id_sexo_pac,
date_part('year',age(la.fec_atencion, p.fec_nac)) edad_pac, EXTRACT(YEAR FROM AGE(la.fec_atencion, p.fec_nac)) edad_anio_pac, EXTRACT(MONTH FROM AGE(la.fec_atencion, p.fec_nac)) edad_mes_pac, EXTRACT(DAY FROM AGE(la.fec_atencion, p.fec_nac)) edad_dia_pac,
(Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=la.id_dependencia) nro_hc, ubip.distrito, descrip_dir,
tefmov.nro_telefono nro_telefonomovil, teffij.nro_telefono nro_telefonofijo,
la.id_depenori, depori.nom_depen nom_depenori, serv.nom_servicio servicioori, nombre_medico,
la.id_plantarifario, ta.sigla_plan, ta.abrev_plan, la.id_estado_reg id_estadoreg, ela.abreviatura_estado nom_estadoreg, elapr.abreviatura_estado nom_estadoresul, la.id_tipo_genera_correlativo
From lab.tbl_labatencion la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Inner join lab.tbl_estado_lab ela On la.id_estado_reg = ela.id
Inner join lab.tbl_estado_lab_resultado elapr On la.id_estado_resul = elapr.id
Inner Join tbl_usuario u On la.user_create_at = u.id_usuario
Left Join tbl_dependencia depori On la.id_depenori = depori.id_dependencia
Left Join tbl_historialdireccionvia ladir On la.id_direccionpac=ladir.id_histodireccion
Left Join tbl_ubigeo2019 ubip On ladir.id_ubigeo=ubip.id_ubigeo
Left Join tbl_historialtelefono tefmov On la.id_telfmovilpac = tefmov.id_histotelefono
Left Join tbl_historialtelefono teffij On la.id_telffijopac = teffij.id_histotelefono
Left Join public.tbl_servicio serv On la.id_servicioori = serv.id_servicio
Where la.id_dependencia=" . $param[0]['idDepAten'] . "";
$this->sql .= " And la.id_estado_reg<>0";
	if(!isset($param[0]['origen_atencion'])){
		if (!empty($param[0]['fecIniAte'])) {
		  $this->sql .= " And la.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
		}
		if (isset($param[0]['chk_gestante'])) {
		  if ($param[0]['chk_gestante'] <> 99) {
			  if ($param[0]['chk_gestante'] == 1) {
				$this->sql .= " And la.check_gestante=TRUE";
				if ($param[0]['condicion_eg'] <> "") {
					$this->sql .= " And la.edad_gestacional" . $param[0]['condicion_eg'] . $param[0]['nro_eg'];
				}
			  } else {
				  $this->sql .= " And la.check_gestante=FALSE";
			  }
		  }
		}
		if (isset($param[0]['condicion_edad'])) {
			if (!empty($param[0]['edad_hasta'])) {
				$this->sql .= " And date_part('year',age(la.fec_atencion, p.fec_nac)) between " . $param[0]['edad_desde'] . " And " . $param[0]['edad_hasta'];
			}
		}
		if (isset($param[0]['condicion_urgente'])) {
			if ($param[0]['condicion_urgente'] == 1) {
				$this->sql .= " And check_urgente=TRUE";
			}
		}
		if (!empty($param[0]['id_producto'])) {
		  $this->sql .= " And la.id in (select distinct lab.id From lab.tbl_labproductoatencion dpro Inner Join lab.tbl_labatencion lab On dpro.id_atencion=lab.id Where id_producto in (".$param[0]['id_producto'].") And lab.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "')";
		}
		if (!empty($param[0]['chk_dep_procedencia'])) {
			if (empty($param[0]['id_dep_procedencia'])) {
				$this->sql .= " And la.id_depenori is not null";
			} else {
				$this->sql .= " And la.id_depenori=" . $param[0]['id_dep_procedencia'];
			}
		}
		$this->sql .= " Order By la.anio_atencion, la.nro_atencion";
	} else {
		$this->sql .= " And la.create_at::date='" . $param[0]['fecIniAte'] . "'";
		$this->sql .= " Order By la.create_at desc";
	}
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }	
  
  public function get_repDatosAtencionCita($param) {
    $this->db->getConnection();
    $this->sql = "Select la.id, to_char(la.fec_atencion, 'dd/mm/yyyy') fec_atencion, to_char(la.fec_cita, 'dd/mm/yyyy') fec_cita, la.nro_atencion, la.anio_atencion, la.nro_atencion_manual, la.nro_atencion_orionlab, 
p.id_persona, p.id_tipodoc, tdp.abreviatura abrev_tipodoc, nrodoc, Case When primer_ape isNull Then '' Else primer_ape End||' '||Case When segundo_ape isNull Then '' Else segundo_ape End ||' '||nombre_rs nombre_rs,
date_part('year',age(la.fec_atencion, p.fec_nac)) edad_pac, Case p.id_sexo When '1' Then 'M' Else 'F' End abrev_sexo, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=la.id_dependencia) nro_hc, ubip.distrito, descrip_dir,
tefmov.nro_telefono nro_telefonomovil, teffij.nro_telefono nro_telefonofijo, la.id_depenori, depori.nom_depen nom_depenori,
la.id_plantarifario, ta.sigla_plan, ta.abrev_plan, la.id_estado_reg id_estadoreg, ela.abreviatura_estado nom_estadoreg, elapr.abreviatura_estado nom_estadoresul, la.id_tipo_genera_correlativo
From lab.tbl_labatencion la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Inner join lab.tbl_estado_lab ela On la.id_estado_reg = ela.id
Inner join lab.tbl_estado_lab_resultado elapr On la.id_estado_resul = elapr.id
Inner Join tbl_usuario u On la.user_create_at = u.id_usuario";
if($param[0]['origen_dep'] <> "LR"){
	if (isset($param[0]['id_tipoprod'])) {
		if (!empty($param[0]['id_tipoprod'])) {
			  $this->sql .= " Inner Join lateral (Select id_atencion From lab.tbl_labproductoatencion ateprod
Inner Join tbl_producto pro On ateprod.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto = tpro.id
Where ateprod.id_atencion=la.id And tpro.id=" . $param[0]['id_tipoprod'] . " And ateprod.id_estado_reg='1' limit 1) refdoc On true";
		} else {
			if (!empty($param[0]['id_producto'])) {
				  $this->sql .= " Inner Join lateral (Select id_atencion From lab.tbl_labproductoatencion  
Where id_atencion=la.id And id_estado_reg='1' And id_producto In (" . $param[0]['id_producto'] . ") limit 1) refdoc On true";
			}
		}
	} else {
		if (!empty($param[0]['id_producto'])) {
			  $this->sql .= " Inner Join lateral (Select id_atencion From lab.tbl_labproductoatencion  
Where id_atencion=la.id And id_estado_reg='1' And id_producto In (" . $param[0]['id_producto'] . ") limit 1) refdoc On true";
		}		
	}
}
$this->sql .= " Left Join tbl_dependencia depori On la.id_depenori = depori.id_dependencia
Left Join tbl_historialdireccionvia ladir On la.id_direccionpac=ladir.id_histodireccion
Left Join tbl_ubigeo2019 ubip On ladir.id_ubigeo=ubip.id_ubigeo
Left Join tbl_historialtelefono tefmov On la.id_telfmovilpac = tefmov.id_histotelefono
Left Join tbl_historialtelefono teffij On la.id_telffijopac = teffij.id_histotelefono
Where la.id_dependencia=" . $param[0]['idDepAten'];
	if (!empty($param[0]['nro_doc'])) {
	  $this->sql .= " And p.id_tipodoc = " . $param[0]['id_tipodoc'] . " And nrodoc= '" . $param[0]['nro_doc'] . "'";
	}
	if (!empty($param[0]['nombre_pac'])) {
	  $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nombre_pac'] . "%')";
	}
	
	if($param[0]['origen_dep'] == "LR"){
		if (!empty($param[0]['nro_atencion'])) {
			  $this->sql .= " And la.nro_atencion_manual='" . $param[0]['nro_atencion'] . "'";
		}
		if (!empty($param[0]['fec_cita_ini'])) {
		  $this->sql .= " And la.fec_atencion::date between '" . $param[0]['fec_cita_ini'] . "' And '" . $param[0]['fec_cita_fin'] . "'";
		}
		$this->sql .= " And la.id_estado_reg<>0";
		$this->sql .= " Order By la.id";
	} else {
		if (!empty($param[0]['nro_atencion'])) {
			  $this->sql .= " And la.nro_atencion::Varchar||'-'||la.anio_atencion::Varchar='" . $param[0]['nro_atencion'] . "'";
		}
		if (!empty($param[0]['nro_atencionotro'])) {
			  $this->sql .= " And la.nro_atencion_orionlab='" . $param[0]['nro_atencionotro'] . "'";
		}
		if (!empty($param[0]['es_urgente'])) {
			if($param[0]['es_urgente'] == "1"){
			  $this->sql .= " And la.check_urgente=TRUE";
			} else {
			  $this->sql .= " And la.check_urgente=FALSE";
			}
		}
		if (!empty($param[0]['fec_cita_ini'])) {
		  $this->sql .= " And la.fec_cita::date between '" . $param[0]['fec_cita_ini'] . "' And '" . $param[0]['fec_cita_fin'] . "'";
		}
		if (isset($param[0]['id_estado_reg_no_asistio'])) {
			$this->sql .= " And la.id_estado_reg<>0 And la.id_estado_reg<>7";
		} else {
			$this->sql .= " And la.id_estado_reg<>0";
		}
		if (isset($param[0]['id_tipo_correlativo'])) {
			if($param[0]['id_tipo_correlativo'] == "1"){
				$this->sql .= " Order By la.fec_cita, la.nro_citadia";
			} else {
				$this->sql .= " Order By la.create_at";
			}
		} else {
			$this->sql .= " Order By la.fec_cita, la.nro_citadia";
		}
	}

    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }


  public function get_tblRepDatosProduccionPorFecha($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select pro.nom_producto, 
p.id_tipodoc, tdp.abreviatura abrev_tipodoc, nrodoc, Case When primer_ape isNull Then '' Else primer_ape End||' '||Case When segundo_ape isNull Then '' Else segundo_ape End ||' '||nombre_rs nombre_rs,
(Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=la.id_dependencia) nro_hc,
la.nro_atencion, la.anio_atencion, ta.sigla_plan, to_char(la.fec_atencion, 'dd/mm/yyyy hh12:mi:ss AM') fec_atencion, 
uingresul.nom_usuario usu_ing_resul, to_char(dpro.create_resultado, 'dd/mm/yyyy hh12:mi:ss AM') fec_ing_resul, uvalidresul.nom_usuario usu_valid_resul, to_char(dpro.create_valid, 'dd/mm/yyyy hh12:mi:ss AM') fec_valid_resul, 
la.id_tipo_genera_correlativo
From lab.tbl_labatencion la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Inner Join lab.tbl_labproductoatencion dpro On la.id=dpro.id_atencion
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto=tpro.id
Inner Join tbl_usuario uingresul On dpro.user_create_resultado = uingresul.id_usuario
Left Join tbl_usuario uvalidresul On dpro.user_create_valid = uvalidresul.id_usuario
Where dpro.id_estado_resul In (3,4) And dpro.id_estado_reg<>0 And dpro.id_dependencia=" . $param[0]['idDepAten'] . "";
	if ($param[0]['tipo_resultado'] == "1") {
		if (!empty($param[0]['fecIniAte'])) {
		  $this->sql .= " And dpro.create_valid::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
		}
		if (!empty($param[0]['id_usuprofesional'])) {
		  $this->sql .= " And dpro.user_create_valid=" . $param[0]['id_usuprofesional'] . "";
		}
	} else {
		if (!empty($param[0]['fecIniAte'])) {
		  $this->sql .= " And dpro.create_resultado::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
		}
		if (!empty($param[0]['id_usuprofesional'])) {
		  $this->sql .= " And dpro.user_create_resultado=" . $param[0]['id_usuprofesional'] . "";
		}		
	}
	
	if (isset($param[0]['chk_gestante'])) {
      if ($param[0]['chk_gestante'] <> 99) {
		  if ($param[0]['chk_gestante'] == 1) {
			$this->sql .= " And la.check_gestante=TRUE";
			if ($param[0]['condicion_eg'] <> "") {
				$this->sql .= " And la.edad_gestacional" . $param[0]['condicion_eg'] . $param[0]['nro_eg'];
			}
		  } else {
			  $this->sql .= " And la.check_gestante=FALSE";
		  }
      }
    }
	if (isset($param[0]['condicion_edad'])) {
		if (!empty($param[0]['edad_hasta'])) {
			$this->sql .= " And date_part('year',age(la.fec_atencion, p.fec_nac)) between " . $param[0]['edad_desde'] . " And " . $param[0]['edad_hasta'];
		}
	}
	
    if (!empty($param[0]['id_producto'])) {
      $this->sql .= " And pro.id_producto=".$param[0]['id_producto']."";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }


  public function get_tblRepCountProduccionPorFecha($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From lab.tbl_labatencion la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Inner Join lab.tbl_labproductoatencion dpro On la.id=dpro.id_atencion
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto=tpro.id
Inner Join tbl_usuario uingresul On dpro.user_create_resultado = uingresul.id_usuario
Inner Join tbl_usuario uvalidresul On dpro.user_create_valid = uvalidresul.id_usuario
Where dpro.id_estado_resul In (3,4) And dpro.id_estado_reg<>0 And dpro.id_dependencia=" . $param[0]['idDepAten'] . "";
	if ($param[0]['tipo_resultado'] == "1") {
		if (!empty($param[0]['fecIniAte'])) {
		  $this->sql .= " And dpro.create_valid::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
		}
		if (!empty($param[0]['id_usuprofesional'])) {
		  $this->sql .= " And dpro.user_create_valid=" . $param[0]['id_usuprofesional'] . "";
		}
	} else {
		if (!empty($param[0]['fecIniAte'])) {
		  $this->sql .= " And dpro.create_resultado::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
		}
		if (!empty($param[0]['id_usuprofesional'])) {
		  $this->sql .= " And dpro.user_create_resultado=" . $param[0]['id_usuprofesional'] . "";
		}		
	}
	
	if (isset($param[0]['chk_gestante'])) {
      if ($param[0]['chk_gestante'] <> 99) {
		  if ($param[0]['chk_gestante'] == 1) {
			$this->sql .= " And la.check_gestante=TRUE";
			if ($param[0]['condicion_eg'] <> "") {
				$this->sql .= " And la.edad_gestacional" . $param[0]['condicion_eg'] . $param[0]['nro_eg'];
			}
		  } else {
			  $this->sql .= " And la.check_gestante=FALSE";
		  }
      }
    }
	if (isset($param[0]['condicion_edad'])) {
		if (!empty($param[0]['edad_hasta'])) {
			$this->sql .= " And date_part('year',age(la.fec_atencion, p.fec_nac)) between " . $param[0]['edad_desde'] . " And " . $param[0]['edad_hasta'];
		}
	}
	
    if (!empty($param[0]['id_producto'])) {
      $this->sql .= " And pro.id_producto=".$param[0]['id_producto']."";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }
  
    
  public function get_repIndicadorProduccionPorAnioMesManual($anio, $mes, $id_dep, $id_plan, $id_tipprod=0, $id_prod=0) {
    $this->db->getConnection();
    $this->sql = "Select dpro.id_producto, pro.nom_producto, dpro.anio, dpro.mes, 
sum(dpro.cnt_sis) cnt_sis, sum(dpro.cnt_pagante) cnt_pagante, sum(dpro.cnt_estrategia) cnt_estrategia, sum(dpro.cnt_exonerado) cnt_exonerado, sum(dpro.cnt_total) cnt_total From lab.tbl_producto_cantidad_mensual dpro
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Where dpro.id_dependencia=" . $id_dep . "
And dpro.anio=" . $anio . " And dpro.mes=" . $mes . " And pro.id_producto=" . $id_prod . " And dpro.id_estado_reg=1 
Group By dpro.id_producto, pro.nom_producto, dpro.anio, dpro.mes";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
    
  public function get_repIndicadorProduccionPorAnioMes($anio, $mes, $id_dep, $id_plan, $id_tipprod=0, $id_prod=0, $prod_es_toma='f') {
    $this->db->getConnection();
    $this->sql = "Select count(1) ctn_producto From lab.tbl_labproductoatencion dpro
Inner Join lab.tbl_labatencion la On dpro.id_atencion=la.id
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto=tpro.id
Where dpro.id_dependencia=" . $id_dep . " And la.id_plantarifario=" . $id_plan . "";
	if ($prod_es_toma == 't') {
		$this->sql .= " And extract(year from la.fec_cita)=" . $anio . " And extract(month from la.fec_cita)=" . $mes . " And dpro.id_estado_reg=1";
	} else {
		$this->sql .= " And extract(year from dpro.create_valid)=" . $anio . " And extract(month from dpro.create_valid)=" . $mes . " And dpro.id_estado_reg=1";
	}
	if ($id_tipprod <> 0) {
		$this->sql .= " And pro.idtipo_producto=" . $id_tipprod;
	}
	if ($id_prod <> 0) {
		$this->sql .= " And pro.id_producto=" . $id_prod;
	}
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }
  
  public function get_repIndicadorProduccionPorFecha($fec_ini, $fec_fin, $id_dep, $id_plan, $id_tipprod=0, $id_prod=0) {
    $this->db->getConnection();
    $this->sql = "Select count(1) ctn_producto From lab.tbl_labproductoatencion dpro
Inner Join lab.tbl_labatencion la On dpro.id_atencion=la.id
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto=tpro.id
Where dpro.id_dependencia=" . $id_dep . " And la.id_plantarifario=" . $id_plan . " And dpro.create_valid::date between '" . $fec_ini . "' And '" . $fec_fin . "' And dpro.id_estado_reg=1";
	if ($id_tipprod <> 0) {
		$this->sql .= " And pro.idtipo_producto=" . $id_tipprod;
	}
	if ($id_prod <> 0) {
		$this->sql .= " And pro.id_producto=" . $id_prod;
	}
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_tblRepDatosResultadoExamenPorFecha($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select la.id_atencion, la.nro_atencion, TO_CHAR(fec_atencion, 'YYYYMMDD')||la.nro_atenciondia nro_atenciondia, to_char(la.fec_atencion, 'DD/MM/YYYY') fec_atencion, to_char(la.create_resul, 'DD/MM/YYYY') fec_resultado,
p.id_persona, p.id_tipodoc, tdp.abreviatura abrev_tipodoc, nrodoc, Case When primer_ape isNull Then '' Else primer_ape End||' '||Case When segundo_ape isNull Then '' Else segundo_ape End ||' '||nombre_rs nombre_rs,
(Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=la.id_dependencia) nro_hc,
ta.abrev_plan, c.descrip_comp componente, Case rex.idtipo_ingresosol when 3 Then cdsr.nombre Else rex.det_resul End det_resul, um.descrip_unimedida uni_medida
From tbl_laboratorio la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Inner Join tbl_laboratorioresuldet rex On la.id_atencion = rex.id_atencion
Inner Join tbl_componentedet cd On rex.id_componentedet = cd.id_componentedet
Inner Join tbl_componente c On cd.id_componente=c.id_componente
Left Join tbl_unimedida um On c.id_unimedida=um.id_unimedida
Left Join tbl_componente_seleccionresuldet cdsr On rex.idseleccion_resul=cdsr.id
Where p.estado=1 And la.estado_resul in (3,4) --3:Resultado Validado, 4: entregado a paciente
And la.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And la.create_resul::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
	$this->sql .= " And cd.id_componentedet in (".$param[0]['id_examen'].")";
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblRepCountResultadoExamenPorFecha($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_laboratorio la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Inner Join tbl_laboratorioresuldet rex On la.id_atencion = rex.id_atencion
Inner Join tbl_componentedet cd On rex.id_componentedet = cd.id_componentedet
Inner Join tbl_componente c On cd.id_componente=c.id_componente
Left Join tbl_unimedida um On c.id_unimedida=um.id_unimedida
Left Join tbl_componente_seleccionresuldet cdsr On rex.idseleccion_resul=cdsr.id
Where p.estado=1 And la.estado_resul in (3,4) --3:Resultado Validado, 4: entregado a paciente
And la.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And la.create_resul::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
	$this->sql .= " And cd.id_componentedet in (".$param[0]['id_examen'].")";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_repDatosResultadoExamenPorFecha($param) {
    $this->db->getConnection();
    $this->sql = "Select la.id_atencion, la.nro_atencion, TO_CHAR(fec_atencion, 'YYYYMMDD')||la.nro_atenciondia nro_atenciondia, to_char(la.fec_atencion, 'DD/MM/YYYY') fec_atencion, to_char(la.create_resul, 'DD/MM/YYYY') fec_resultado,
p.id_persona, p.id_tipodoc, tdp.abreviatura abrev_tipodoc, nrodoc, Case When primer_ape isNull Then '' Else primer_ape End||' '||Case When segundo_ape isNull Then '' Else segundo_ape End ||' '||nombre_rs nombre_rs,
(Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=la.id_dependencia) nro_hc,
ta.sigla_plan abrev_plan, c.descrip_comp componente, Case rex.idtipo_ingresosol when 3 Then cdsr.nombre Else rex.det_resul End det_resul, um.descrip_unimedida uni_medida
From tbl_laboratorio la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_plantarifa ta On la.id_plantarifario = ta.id_plan
Inner Join tbl_laboratorioresuldet rex On la.id_atencion = rex.id_atencion
Inner Join tbl_componentedet cd On rex.id_componentedet = cd.id_componentedet
Inner Join tbl_componente c On cd.id_componente=c.id_componente
Left Join tbl_unimedida um On c.id_unimedida=um.id_unimedida
Left Join tbl_componente_seleccionresuldet cdsr On rex.idseleccion_resul=cdsr.id
Where p.estado=1 And la.estado_resul in (3,4) --3:Resultado Validado, 4: entregado a paciente
And la.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And la.create_resul::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
	$this->sql .= " And cd.id_componentedet in (".$param[0]['id_examen'].")";
	$this->sql .= " Order By la.create_resul";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repCntAtencionPorAnioMesAndIdDependencia($param) {
    $this->db->getConnection();
    $this->sql = "Select tarilab.id_plan, tarilab.nom_plan, count(1) cnt_atencion
From lab.tbl_labatencion la Inner Join public.tbl_plantarifa tarilab On la.id_plantarifario=tarilab.id_plan
WHERE la.id_dependencia=" . $param[0]['idDepAten'] . " And extract(year From la.fec_atencion)=" . $param[0]['anio'] . " And extract(month From la.fec_atencion)=" . $param[0]['mes'] . "
Group By tarilab.id_plan, tarilab.nom_plan Order By tarilab.id_plan";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_repCntAtencionPorFechaAndIdDependencia($param) {
    $this->db->getConnection();
    $this->sql = "Select tarilab.id_plan, tarilab.nom_plan, count(1) cnt_atencion
From lab.tbl_labatencion la Inner Join public.tbl_plantarifa tarilab On la.id_plantarifario=tarilab.id_plan
WHERE fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "' And id_dependencia=" . $param[0]['idDepAten'] . "  And la.id_estado_reg<>0
Group By tarilab.id_plan, tarilab.nom_plan Order By tarilab.id_plan";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repCntPorTipoProductoPorFechaAndIdDependencia($param) {
    $this->db->getConnection();
    $this->sql = "Select tpro.id, tpro.nombre_tipo_producto, count(1) ctn_producto From lab.tbl_labproductoatencion dpro
Inner Join lab.tbl_labatencion la On dpro.id_atencion=la.id
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto=tpro.id
Where dpro.id_estado_reg=1 And fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "' And la.id_dependencia=" . $param[0]['idDepAten'] . " 
Group By tpro.id, tpro.nombre_tipo_producto";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_repIndicadorAtencionesPorFecha($fec_ini, $fec_fin, $id_dep, $id_plan, $id_tipprod=0, $id_prod=0) {
    $this->db->getConnection();
    $this->sql = "Select count(1) ctn_producto From lab.tbl_labproductoatencion dpro
Inner Join lab.tbl_labatencion la On dpro.id_atencion=la.id
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto=tpro.id
Where la.id_dependencia=" . $id_dep . " And la.id_plantarifario=" . $id_plan . " And la.fec_atencion::date between '" . $fec_ini . "' And '" . $fec_fin . "' And dpro.id_estado_reg=1";
	if ($id_tipprod <> 0) {
		$this->sql .= " And pro.idtipo_producto=" . $id_tipprod;
	}
	if ($id_prod <> 0) {
		$this->sql .= " And pro.id_producto=" . $id_prod;
	}
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_repCntResultadosPorTipoProductoPorAnioMesAndIdDependencia($param) {
    $this->db->getConnection();
    $this->sql = "Select tpro.id, tpro.nombre_tipo_producto, count(1) ctn_producto From lab.tbl_labproductoatencion dpro
Inner Join lab.tbl_labatencion la On dpro.id_atencion=la.id
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto=tpro.id
Where dpro.id_estado_reg=1 And dpro.id_estado_resul='4' And dpro.id_dependencia=" . $param[0]['idDepAten'] . "
And extract(year From dpro.create_valid)=" . $param[0]['anio'] . " And extract(month From dpro.create_valid)=" . $param[0]['mes'] . " 
Group By tpro.id, tpro.nombre_tipo_producto";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repCntProductoPorAnioMesAndIdDependenciaManual($param) {
    $this->db->getConnection();
    $this->sql = "Select dpro.id, dpro.id_producto, pro.nom_producto, dpro.anio, dpro.mes, 
dpro.cnt_sis, dpro.cnt_pagante, dpro.cnt_estrategia, dpro.cnt_exonerado, dpro.cnt_total From lab.tbl_producto_cantidad_mensual dpro
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Where dpro.id_estado_reg=1 And dpro.id_dependencia=" . $param[0]['idDepAten'] . "
And dpro.anio=" . $param[0]['anio'] . " And dpro.mes=" . $param[0]['mes'] . "";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_repCntResultadosPorTipoProductoPorFechaAndIdDependencia($param) {
    $this->db->getConnection();
    $this->sql = "Select tpro.id, tpro.nombre_tipo_producto, count(1) ctn_producto From lab.tbl_labproductoatencion dpro
Inner Join lab.tbl_labatencion la On dpro.id_atencion=la.id
Inner Join tbl_producto pro On dpro.id_producto = pro.id_producto
Inner Join tbl_labtipo_producto tpro On pro.idtipo_producto=tpro.id
Where dpro.id_estado_reg=1 And dpro.id_estado_resul='4' And dpro.create_valid::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "' And dpro.id_dependencia=" . $param[0]['idDepAten'] . " 
Group By tpro.id, tpro.nombre_tipo_producto";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
    public function get_datosAtencionProfesionalValidaResul($idAtencion) {
      $conet = $this->db->getConnection();
      $this->sql = "Select pr.id_profesional, '' nom_tipdoc, nrodoc nro_docprof, p.nombre_rs nom_prof, primer_ape primer_apeprof, segundo_ape segundo_aprprof, pr.nro_colegiatura, pr.nro_rne From tbl_laboratorioresuldet drla
Inner Join tbl_laboratorio la On drla.id_atencion = la.id_atencion
Inner Join tbl_usuario u On drla.user_create_valid = u.id_usuario
Inner Join tbl_persona p On u.id_persona = p.id_persona
Inner Join tbl_profesional pr On p.id_persona = pr.id_persona
Inner Join tbl_profesionalservicio prs On  pr.id_profesional = prs.id_profesional
Inner Join tbl_serviciodependencia sdep On prs.id_serviciodep = sdep.id_serviciodep
Inner Join tbl_dependencia d On sdep.id_dependencia = d.id_dependencia And la.id_dependencia = d.id_dependencia
Where la.id_atencion=".$idAtencion." And valid_resul=1::Boolean Order By drla.create_at Desc Limit 1;";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }
	
    public function get_datosAtencionProfesionalResponsableTurno($idAtencion) {
      $conet = $this->db->getConnection();
      $this->sql = "Select pr.id_profesional, '' nom_tipdoc, nrodoc nro_docprof, p.nombre_rs nom_prof, primer_ape primer_apeprof, segundo_ape segundo_aprprof, pr.nro_colegiatura, pr.nro_rne From lab.tbl_labatencion la 
Inner Join tbl_usuario u On la.user_encargado_lab = u.id_usuario
Inner Join tbl_persona p On u.id_persona = p.id_persona
Inner Join tbl_profesional pr On p.id_persona = pr.id_persona
Inner Join tbl_profesionalservicio prs On  pr.id_profesional = prs.id_profesional
Inner Join tbl_serviciodependencia sdep On prs.id_serviciodep = sdep.id_serviciodep
Inner Join tbl_dependencia d On sdep.id_dependencia = d.id_dependencia And la.id_dependencia = d.id_dependencia
Where la.id=".$idAtencion." And la.id_estado_resul>2 Limit 1;";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }

    public function get_datosfecHoraActual() {
      $conet = $this->db->getConnection();
      $this->sql = "Select to_char(now(), 'dd/mm/yyyy hh12:mi:ss AM') fechora_actual;";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }
	
    public function post_reg_cambia_muestra_resultado($id_atencion, $id_est_nuevo, $id_usuario) {
      $conet = $this->db->getConnection();
      $this->sql = "Update lab.tbl_labatencion Set chk_muestra_resul_servicios='" . $id_est_nuevo . "' Where id=". $id_atencion .";";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }
		
    public function post_reg_dep_origen($id_atencion, $id_dep_ori, $id_usuario) {
		$conet = $this->db->getConnection();
		if($_POST['id_dep_ori'] == 0){
			$this->sql = "Update lab.tbl_labatencion Set id_depenori=Null Where id=". $id_atencion .";";
		} else {
			$this->sql = "Update lab.tbl_labatencion Set id_depenori='" . $id_dep_ori . "' Where id=". $id_atencion .";";
		}
		$this->rs = $this->db->query($this->sql);
		$this->db->closeConnection();
		return $this->rs;
    }
	
    public function get_ultimo_nro_atencion($id_dep) {
      $this->db->getConnection();
      $aparam = array($id_dep);
      $this->sql = "Select nro_atencion, anio_atencion From lab.tbl_labatencion Where id_dependencia=$1 order by id desc limit 1;";
      $this->rs = $this->db->query_params($this->sql, $aparam);
      $this->db->closeConnection();
	  if(isset($this->rs[0])){
		return $this->rs[0];
	  } else {
		  return "";
	  }
    }
	
    public function get_id_atencion_procesa_resultado($id_dep, $nro_atencion_manual) {
      $this->db->getConnection();
      $aparam = array($id_dep, $nro_atencion_manual);
      $this->sql = "Select id id_atencion From lab.tbl_labatencion Where id_dependencia=$1 And nro_atencion_manual=$2 And id_estado_reg<>0;";
      $this->rs = $this->db->query_params($this->sql, $aparam);
      $this->db->closeConnection();
	  if(isset($this->rs[0])){
		return $this->rs[0]['id_atencion'];
	  } else {
		  return "";
	  }
    }

	public function post_reg_orden_producto_atencion($paramReg) {
		$this->db->getConnection();
		$aparam = array($paramReg[0]['accion'], $paramReg[0]['id_atencion'], $paramReg[0]['id_producto'], $paramReg[0]['userIngreso']);
		$this->sql = "Select * From lab.sp_reg_orden_producto_atencion($1, $2, $3, $4);";
		$this->rs = $this->db->query_params($this->sql, $aparam);
		$this->db->closeConnection();
		return $this->rs[0][0];
	}
	  
    public function get_datosUtimas20AtencionPorIdDep($id_dependencia) {
      $conet = $this->db->getConnection();
      $this->sql = "SELECT la.id, la.nro_atencion, la.anio_atencion, la.nro_atencion_manual, tdp.abreviatura abrev_tipodoc, nrodoc, 
Case When primer_ape isNull Then '' Else primer_ape End||' '||Case When segundo_ape isNull Then '' Else segundo_ape End ||' '||nombre_rs nombre_rs,
la.id_estado_reg, la.id_estado_resul, estlabrs.abreviatura_estado nom_estadoresul
FROM lab.tbl_labatencion la
Inner Join tbl_persona p On la.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join lab.tbl_estado_lab estlab On la.id_estado_reg = estlab.id
Inner join lab.tbl_estado_lab_resultado estlabrs On la.id_estado_resul = estlabrs.id
WHERE id_dependencia=" . $id_dependencia . " And la.id_estado_reg<>0
ORDER BY anio_atencion desc, nro_atencion desc
OFFSET 0 LIMIT 20;";
      $this->rs = $this->db->query($this->sql);
      $this->db->closeConnection();
      return $this->rs;
    }
}
