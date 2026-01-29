<?php

include_once 'ConectaDb.php';

class Pap {

  private $db;
  private $sql;

  public function __construct() {
    $this->db = new ConectaDb();
    $this->rs = array();
  }

  public function post_reg_solicitud($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['paciente'], $paramReg[0]['apoderado'], $paramReg[0]['solicitud'], $paramReg[0]['anticonceptivo'], $paramReg[0]['sintoma'], $paramReg[0]['exaCervico'], $paramReg[0]['diagnostico'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From sp_reg_papsoli($1, $2, $3, $4, $5, $6, $7, $8, $9);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function post_reg_papfinaliza($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['detalle'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From sp_reg_papsolifinaliza($1, $2, $3);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function post_reg_envio($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['envio'], $paramReg[0]['muestra'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From sp_reg_papenvio($1, $2, $3, $4);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function post_reg_envionoconfor($paramReg) {
    $this->db->getConnection();
    $aparam = array($paramReg[0]['accion'], $paramReg[0]['detalle'], $paramReg[0]['userIngreso']);
    $this->sql = "Select * From sp_reg_papenvionoconformidad($1, $2, $3);";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0][0];
  }

  public function get_datosSolicitud($idSolicitud, $tipo=0) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_papsoli(" . $tipo ."," . $idSolicitud .", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_validPAPAnterior($id_tipdoc,$nro_doc) {
    $conet = $this->db->getConnection();
    $this->sql = "Select date_part('year',age(now(), fec_atencion)) anio, date_part('month',age(now(), fec_atencion)) mes, id_dependencia, id_paciente From tbl_persona p
Inner Join tbl_papsoli pap On p.id_persona=pap.id_paciente
Where p.id_tipodoc=" . $id_tipdoc . " And nrodoc='" . $nro_doc . "'
Order By id_papsoli Desc limit 1;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosResultado($idSolicitud) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_papresul(" . $idSolicitud .", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosResultadoIni($idResul) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_papresulini(" . $idResul .", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }


  public function get_repDatosPAPAnioRegistro($dep = 0) {
    $this->db->getConnection();
    $this->sql = "Select extract(year From fec_atencion) anio From tbl_papsoli";
    $this->sql .= " Group By extract(year From fec_atencion) Order By extract(year From fec_atencion) Desc";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }  

  public function get_datosAnticonceptivoPorIdSolicitud($idSolicitud) {
    $conet = $this->db->getConnection();
    $this->sql = "Select id_tipanticonceptivo, det_tipanticonceptivo From tbl_papsoli_anticonceptivo Where id_papsoli = " . $idSolicitud . " And estado=1;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  
  public function get_datosProcedimientoAnteriorPorIdSolicitud($idSolicitud) {
    $conet = $this->db->getConnection();
    $this->sql = "Select id_papprocedimiento From tbl_papsoli_procedimientoante Where id_papsoli = " . $idSolicitud . " And estado=1;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosSintomaPorIdSolicitud($idSolicitud) {
    $conet = $this->db->getConnection();
    $this->sql = "Select id_tipsintoma, det_tipsintoma From tbl_papsoli_sintoma Where id_papsoli = " . $idSolicitud . " And estado=1;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosExaCervicoPorIdSolicitud($idSolicitud) {
    $conet = $this->db->getConnection();
    $this->sql = "Select id_tipexacervico From tbl_papsoli_exacervico Where id_papsoli = " . $idSolicitud . " And estado=1;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosDiagnosticoPorIdSolicitud($idSolicitud) {
    $conet = $this->db->getConnection();
    $this->sql = "Select id_diagnostico, nom_cie From tbl_papsoli_diagnostico pd Inner Join tbl_cie10 ci On pd.id_diagnostico=ci.id_cie Where id_papsoli = " . $idSolicitud . " And estado=1;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosInsumosPorIdSolicitud($idSolicitud) {
    $conet = $this->db->getConnection();
    $this->sql = "Select id_diagnostico From tbl_papsoli_diagnostico Where id_papsoli = " . $idSolicitud . " And estado=1;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosCambioCelPorIdRespuesta($idRespuesta) {
    $conet = $this->db->getConnection();
    $this->sql = "Select id_tipcambiocel, det_tipcambiocel From tbl_papresul_cambiocel Where id_papresul = " . $idRespuesta . " And estado=1;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosCambioCelPorIdResultadoIni($idResultado) {
    $conet = $this->db->getConnection();
    $this->sql = "Select id_tipcambiocel, det_tipcambiocel From tbl_papresulvalid_cambiocel Where id_papresul = " . $idResultado . ";";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaObservadoPorIdEnvDet($idEstEnvDet) {
    $conet = $this->db->getConnection();
    $this->sql = "Select id_tipoobsenvdet, Upper(nom_estado) nom_estado From tbl_papenviodettipoobs Where id_papenvdetestado = " . $idEstEnvDet . ";";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_listaMotivoNoConforPorIdTipo($idTip) {
    $this->db->getConnection();
    $aparam = array($idTip);
    $this->sql = "Select id_papmotivonoconfor id_motivonoconfor, Upper(nom_motivo) nom_motivo From tbl_papmotivonoconfor
    Where id_paptiponoconfor=$1 Order By nom_motivo;";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosEnvio($idEnvio) {
    $conet = $this->db->getConnection();
    $this->sql = "Select * From sp_show_papenvio(" . $idEnvio .", 'ref_cursor'); Fetch All In ref_cursor;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosResponsableAtencionPorIdEnvio($idEnvio) {
    $this->db->getConnection();
    $aparam = array($idEnvio);
    $this->sql = "Select Distinct p.id_persona, pr.id_profesional, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac,
Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rsprof, 
prp.nom_profesion nom_profesion, prp.abreviatura_colegiatura abreviatura_colegiatura, pr.nro_colegiatura
From tbl_papenvio pape
Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
Inner Join tbl_usuario u On pap.user_create_at = u.id_usuario
Inner Join tbl_persona p On u.id_persona = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_profesional pr On  p.id_persona = pr.id_persona
Inner Join tbl_profesion prp On pr.id_profesion = prp.id_profesion--Profesion
Where pape.id_papenvio=$1;";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }


    public function get_datosResponsableValidaLaboratorioPorIdEnvio($idEnvio) {
      $this->db->getConnection();
      $aparam = array($idEnvio);
      $this->sql = "Select pte.id_profesional id_tecnologo, Case When tep.primer_ape isNull Then '' Else tep.primer_ape End||' '||Case When tep.segundo_ape isNull Then '' Else tep.segundo_ape End ||' '||tep.nombre_rs nombre_rstec, ptep.nom_profesion nom_profesiontec, ptep.abreviatura_colegiatura abreviatura_colegiaturatec, pte.nro_colegiatura nro_colegiaturatec,
pen.id_profesional id_encargadolab, Case When enp.primer_ape isNull Then '' Else enp.primer_ape End||' '||Case When enp.segundo_ape isNull Then '' Else enp.segundo_ape End ||' '||enp.nombre_rs nombre_rsenclab, penp.nom_profesion nom_profesionlab, penp.abreviatura_colegiatura abreviatura_colegiaturalab, pen.nro_colegiatura nro_colegiaturaenclab
From tbl_papenvio pape
Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
Inner Join tbl_papresul papr On pap.id_papsoli = papr.id_papsoli
Left Join tbl_usuario ute On papr.user_create_at = ute.id_usuario
Left Join tbl_persona tep On ute.id_persona = tep.id_persona
Left Join tbl_profesional pte On  tep.id_persona = pte.id_persona
Left Join tbl_profesion ptep On pte.id_profesion = ptep.id_profesion--Profesion tecnico medico
Left Join tbl_usuario uen On pap.user_create_valid = uen.id_usuario
Left Join tbl_persona enp On uen.id_persona = enp.id_persona
Left Join tbl_profesional pen On enp.id_persona = pen.id_persona
Left Join tbl_profesion penp On pen.id_profesion = penp.id_profesion--Profesion medico patologo
Where pape.id_papenvio=$1 Order by pap.nro_reglab Desc, pap.anio_reglab Desc Limit 1;";
      $this->rs = $this->db->query_params($this->sql, $aparam);
      $this->db->closeConnection();
      return $this->rs;
    }

  public function get_datosMotivoNoConforPorIdEnv($idEnvio) {
    $this->db->getConnection();
    $aparam = array($idEnvio);
    $this->sql = "Select tenc.id_paptiponoconfor, tenc.nom_tipo, enc.id_papmotivonoconfor id_motivonoconfor, Upper(nom_motivo) nom_motivo, det_noconformidad
    From tbl_papenvionoconformidad enc Inner Join tbl_papmotivonoconfor menc On enc.id_papmotivonoconfor = menc.id_papmotivonoconfor
    Inner Join tbl_paptiponoconfor tenc On menc.id_paptiponoconfor = tenc.id_paptiponoconfor
    Where id_papenvio=$1 Order By tenc.nom_tipo;";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosObsDetEnvPorIdDetEnv($idDetEnv) {
    $this->db->getConnection();
    $aparam = array($idDetEnv);
    $this->sql = "Select ob.id_papenviodetobs, ob.id_papenviodet, tob.id_papenvdetestado id_accion, cob.nom_estado nom_accion,
    ob.id_tipoobsenvdet id_motobs, tob.nom_estado nom_motobs, ob.det_obs, ob.det_sub, ob.estado From tbl_papenviodetobs ob
    Inner Join tbl_papenviodettipoobs tob On ob.id_tipoobsenvdet = tob.id_tipoobsenvdet
    Inner Join tbl_papenviodetestado cob On tob.id_papenvdetestado = cob.id_papenvdetestado
    Where id_papenviodet=$1 And ob.estado=3;";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repDatosSolicitud($param) {
    $this->db->getConnection();
    $this->sql = "Select nro_atencion nro_ordensoli, substring(extract(year from pap.fec_atencion)::Varchar, 3) anio_ordensoli, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac,
    (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc, Case When pap.check_tipopac=True Then 'SI' Else 'NO' End nom_sispac,
    Case When p.primer_ape isNull Then '' Else substring(p.primer_ape,1,1) End||Case When p.segundo_ape isNull Then '' When p.segundo_ape = '' Then  '' Else substring(p.segundo_ape,1,1) End abrev_rspac, p.nombre_rs nombre_pac,
    Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, date_part('year',age(pap.fec_atencion, p.fec_nac)) edad_pac,
    ub.departamento, ub.provincia, ub.distrito, dir.descrip_dir, dir.descrip_ref, telf.nro_telefono telf_fijo, telm.nro_telefono telf_movil, 
    pap.check_fur, pap.fec_fur, pap.check_gestante, Case When pap.check_gestante=True Then 'SI' Else 'NO' End nom_tipgestante, Case When pap.id_tamizajeante=0 Then 'SI' Else 'NO' End primer_pap,
    to_char(pap.fec_atencion, 'DD/MM/YY') fec_atencion, to_char(papr.fecha, 'DD/MM/YYYY') fec_resul, papr.nro_reglab, Case When id_papresul is Not Null Then Case When id_tipinsatisfactoria is Not Null Then 'INSATISFAC.' Else Case When negalesion = 1 Then 'NEGATIVO' Else 'POSITIVO' End End Else '' End nom_resul
    From tbl_papsoli pap Inner Join tbl_serviciodependencia sed On pap.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Left Join  tbl_papresul papr On pap.id_papsoli = papr.id_papsoli
	Left Join tbl_historialtelefono telf On pap.id_telffijopac = telf.id_histotelefono
	Left Join tbl_historialtelefono telm On pap.id_telfmovilpac = telm.id_histotelefono
    Left Join tbl_historialdireccion dir On pap.id_direccionpac = dir.id_histodireccion
    Left Join tbl_ubigeo2019 ub On dir.id_ubigeo = ub.id_ubigeo
    Where pap.estado<>0";
    if (!empty($param[0]['idDepAten'])) {
      $this->sql .= " And d.id_dependencia=" . $param[0]['idDepAten'] . "";
    }
    if (!empty($param[0]['fecFinAte'])) {
      $this->sql .= " And pap.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And p.nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
    if ($param[0]['chk_positivo'] == "1") {
      $this->sql .= " And (pap.estado=3 Or pap.estado=4) And pap.id_estadoresul=3 And pap.id_estadoresulfinal=1";
    }
    if ($param[0]['tipo_repor'] == "2") {
      $this->sql .= " And pap.estado=3 And pap.id_estadoresul=3";
    }
    $this->sql .= " Order By pap.fec_atencion, pap.id_papsoli";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repDatosDetEnviado($idEnv) {
    $this->db->getConnection();
    $this->sql = "Select pap.id_papsoli, nro_atencion nro_ordensoli, substring(extract(year from pap.fec_atencion)::Varchar, 3) anio_ordensoli, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac,
(Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc, Case When pap.check_tipopac = true Then 'SI' Else 'NO' End nom_sispac,
Case When p.primer_ape isNull Then '' Else substring(p.primer_ape,1,1) End||Case When p.segundo_ape isNull Then '' When p.segundo_ape = '' Then  '' Else substring(p.segundo_ape,1,1) End abrev_rspac, p.nombre_rs nombre_pac,
Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, date_part('year',age(pap.fec_atencion, p.fec_nac)) edad_pac,
ub.departamento, ub.provincia, ub.distrito, dir.descrip_dir, dir.descrip_ref,
pap.check_fur, pap.fec_fur, pap.check_gestante, Case When pap.check_gestante = True Then 'SI' Else 'NO' End nom_tipgestante, Case When pap.id_condiservicio = 1 Then 'SI' Else 'NO' End primer_pap,
(Select string_agg(id_tipanticonceptivo::Varchar, ',') FROM tbl_papsoli_anticonceptivo Where id_papsoli=pap.id_papsoli And estado=1) id_mac,
pape.estado idestado_env, epape.nom_estado nomestado_env, paped.estado idestado_envdet, epaped.nom_estado nomestado_envdet, 
Case When id_papresul is Not Null Then Case When id_tipinsatisfactoria is Not Null Then 'INSATISFACTORIA' Else Case When negalesion = 1 Then 'NEGATIVO' Else 'POSITIVO' End End Else Case pape.estado When 4 then 'RECHAZADA' Else '' End End nom_resul,
pap.nro_reglab, substring(pap.anio_reglab::Varchar, 3,2) anio_reglab,
pu.nombre_rs||' '||Case When pu.primer_ape isNull Then '' Else pu.primer_ape End nombre_profe, pr.nro_colegiatura nro_coleprofe
From tbl_papenvio pape
Inner Join tbl_papenvioestado epape On pape.estado = epape.id_papenvestado
Inner Join tbl_papenviodet paped On pape.id_papenvio=paped.id_papenvio
Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
Inner Join tbl_serviciodependencia sed On pap.id_serviciodep = sed.id_serviciodep
Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
Inner Join tbl_persona p On pap.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_usuario u On pap.user_create_at = u.id_usuario
Inner Join tbl_persona pu On u.id_persona = pu.id_persona
Left Join tbl_profesional pr On  pu.id_persona = pr.id_persona
Left Join  tbl_papresul papr On pap.id_papsoli = papr.id_papsoli
Left Join tbl_historialdireccion dir On pap.id_direccionpac = dir.id_histodireccion
Left Join tbl_ubigeo2019 ub On dir.id_ubigeo = ub.id_ubigeo
    Where pape.id_papenvio=" . $idEnv . " Order By extract(year from pap.fec_atencion), pap.nro_atencion";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repDatosEnviadoNoConfor($idEnv) {
    $this->db->getConnection();
    $this->sql = "Select pape.nro_papenv, extract(year from pape.fec_papenvio)::Varchar anio_papenv, d.nom_depen, to_char(fec_papenvio, 'DD/MM/YYYY') fec_papenvio,
    to_char(pape.create_received_at::date, 'DD/MM/YYYY') fec_paprecep, to_char(pape.create_received_at, 'hh24:mi PM') hora_paprecep,
    (Select count(1) From tbl_papenviodet Where id_papenvio=pape.id_papenvio And estado<>0) cnt_papenv,
    (Select count(*) From tbl_papenviodet det Where det.estado=4 And id_papenvio=pape.id_papenvio) cnt_solirechazada,
    to_char(create_finalize_at::date, 'DD/MM/YYYY') fec_papfinal, to_char(create_finalize_at, 'hh24:mi PM') fec_horafinal,
    nro_fichaobsfinal, extract(year from pape.create_finalize_at)::Varchar anio_fichaobsfinal, det_obsfinal
    From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Where pape.id_papenvio=" . $idEnv . "";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repDatosNoConforDocOEmpPorIdEnv($idEnv, $idTip) {
    $this->db->getConnection();
    $this->sql = "Select count(nom_motivoobs) cnt_motnoconfor, menc.nom_motivo From tbl_papmotivonoconfor menc
    Left Join
    (Select enc.id_papmotivonoconfor, nom_motivo nom_motivoobs From tbl_papmotivonoconfor menc
    Inner Join tbl_papenvionoconformidad enc On menc.id_papmotivonoconfor = enc.id_papmotivonoconfor
    Where menc.estado=1 And menc.id_paptiponoconfor=" . $idTip . " And enc.id_papenvio=" . $idEnv . ") enc On menc.id_papmotivonoconfor = enc.id_papmotivonoconfor
    Where menc.estado=1 And menc.id_paptiponoconfor=" . $idTip . "
    Group By menc.nom_motivo";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repDatosRechazadoOPorSubsanarPorIdEnv($idEnv, $idTip) {
    $this->db->getConnection();
    $this->sql = "Select count(paed.id_tipoobsenvdet) cnt_envrechazado, toed.nom_estado From tbl_papenviodettipoobs toed
    Left Join
    (Select id_tipoobsenvdet From tbl_papenviodet paped
    Inner Join tbl_papenviodetobs papeo On paped.id_papenviodet = papeo.id_papenviodet
    Where paped.estado=" . $idTip . " and paped.id_papenvio=$idEnv) paed On toed.id_tipoobsenvdet = paed.id_tipoobsenvdet
    Where toed.estado=1 And toed.id_papenvdetestado=" . $idTip . "
    Group By toed.nom_estado";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repDatosEnviadoNoConforPacientesPorIdEnv($idEnv) {
    $this->db->getConnection();
    $this->sql = "Select Case When p.primer_ape isNull Then '' Else substring(p.primer_ape,1,1) End||Case When p.segundo_ape isNull Then '' When p.segundo_ape = '' Then  '' Else substring(p.segundo_ape,1,1) End abrev_rspac, p.nombre_rs nombre_pac,
    nro_atencion nro_ordensoli, substring(extract(year from pap.fec_atencion)::Varchar, 3) anio_ordensoli
    From tbl_papsoli pap Inner Join tbl_papenviodet epaped On pap.id_papsoli = epaped.id_papsoli
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Where epaped.estado=4 And epaped.id_papenvio=".$idEnv." Order By nro_atencion";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblDatosSolicitud($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select pap.id_papsoli, p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc,
    Case When p.primer_ape isNull Then '' Else substring(p.primer_ape,1,1) End||Case When p.segundo_ape isNull Then '' When p.segundo_ape = '' Then  '' Else substring(p.segundo_ape,1,1) End abrev_rspac, p.nombre_rs nombre_pac,
    Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac,
    to_char(pap.fec_atencion, 'DD/MM/YYYY') fec_atencion, nro_atencion nro_ordensoli, substring(extract(year from pap.fec_atencion)::Varchar, 3) anio_ordensoli, d.nom_depen, to_char(pape.create_finalize_at, 'DD/MM/YYYY') fec_resultado, pap.estado id_estadosolipap, epap.nom_estado nom_estadosolipap,
    pu.nombre_rs||' '||Case When pu.primer_ape isNull Then '' Else pu.primer_ape End nombre_profe,

    Case When (pap.estado = 1 Or pap.estado = 2) Then 'PENDIENTE' Else
    Case When id_papenviodet isNull Then 'PENDIENTE' Else
    Case When id_papresul is Not Null Then Case When id_tipinsatisfactoria is Not Null Then 'INSATISFACTORIA' Else Case When negalesion = 1 Then 'NEGATIVO' Else 'POSITIVO' End End Else Case When (paped.estado = 1 Or paped.estado = 2) Then 'PENDIENTE' Else epaped.nom_estado End End End
    End nom_resul,
    Case When (pap.estado = 1 Or pap.estado = 2) Then '' Else
    Case When id_anorescamosa is Not Null Then
    Case id_anorescamosa When 1 Then 'ASCUS'
    When 2 Then 'L.I.E. de bajo grado'
    When 3 Then 'ASCH'
    When 4 Then 'L.I.E. de alto grado'
    When 5 Then 'CARCINOMA IN SITU'
    When 6 Then 'CARCINOMA INVASOR'
    End
    Else
    Case When id_anorglandular is Not Null Then
    Case id_anorglandular When  1 Then 'Celulas glandulares atipicas'
    When 2 Then 'Celulas glandulares atipicas sugestivas de neoplasia'
    When 3 Then 'Adenocarcinoma in situ'
    When 4 Then 'Adenocarcinoma'
    End
    Else ''
    End
    End
    End nom_bethesa,
    Case When (pap.estado = 1 Or pap.estado = 2) Then Null Else pap.nro_reglab End nro_reglab, Case When (pap.estado = 1 Or pap.estado = 2) Then Null Else substring(extract(year from create_reglab_at)::Varchar, 3) End anio_reglab
    From tbl_papsoli pap
    Inner Join tbl_serviciodependencia sed On pap.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_usuario u On pap.user_create_at = u.id_usuario
    Inner Join tbl_persona pu On u.id_persona = pu.id_persona
    Left Join (Select id_papenviodet,id_papenvio,id_papsoli,estado,user_received_at,create_received_at From tbl_papenviodet Where estado<>0) paped On pap.id_papsoli = paped.id_papsoli
    Left Join tbl_papenvio pape On paped.id_papenvio = pape.id_papenvio
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Left Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Where pap.estado is Not Null";
    if (!empty($param[0]['idDepAten'])) {
      $this->sql .= " And d.id_dependencia=" . $param[0]['idDepAten'] . "";
    }
    if ($param[0]['tipo_repor'] == "2") {
      $this->sql .= " And pap.estado=3 And pap.id_estadoresul=3";
    }
    if (!empty($param[0]['tipo_resul'])) {
      $this->sql .= " And (pap.estado=3 Or pap.estado=4) And pap.id_estadoresul=3 And pap.id_estadoresulfinal=1";
    }
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And pap.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And p.nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountSolicitud($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_papsoli pap
    Inner Join tbl_serviciodependencia sed On pap.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_usuario u On pap.user_create_at = u.id_usuario
    Inner Join tbl_persona pu On u.id_persona = pu.id_persona
    Left Join (Select id_papenviodet,id_papenvio,id_papsoli,estado,user_received_at,create_received_at From tbl_papenviodet Where estado<>0) paped On pap.id_papsoli = paped.id_papsoli
    Left Join tbl_papenvio pape On paped.id_papenvio = pape.id_papenvio
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Left Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Where pap.estado is Not Null";
    if (!empty($param[0]['idDepAten'])) {
      $this->sql .= " And d.id_dependencia=" . $param[0]['idDepAten'] . "";
    }
    if ($param[0]['tipo_repor'] == "2") {
      $this->sql .= " And pap.estado=3 And pap.id_estadoresul=3";
    }
    if (!empty($param[0]['tipo_resul'])) {
      $this->sql .= " And (pap.estado=3 Or pap.estado=4) And pap.id_estadoresul=3 And pap.id_estadoresulfinal=1";
    }
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And pap.fec_atencion::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And p.nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_tblDatosSolicitudNoEnviada($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select pap.id_papsoli, pap.nro_atencion nro_ordensoli, substring(extract(year from pap.fec_atencion)::Varchar, 3) anio_ordensoli, to_char(pap.fec_atencion, 'DD/MM/YYYY') fec_atencion, extract(days from (now()::timestamp - pap.fec_atencion::timestamp)) dias_transcurrido,
    tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac,
    Case When p.primer_ape isNull Then '' Else substring(p.primer_ape,1,1) End||Case When p.segundo_ape isNull Then '' When p.segundo_ape = '' Then  '' Else substring(p.segundo_ape,1,1) End abrev_rspac, p.nombre_rs nombre_pac,
    Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, date_part('year',age(pap.fec_atencion, p.fec_nac)) edad_pac,
    (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc, Case When pap.check_tipopac=True Then 'SI' Else 'NO' End nom_sispac,
    ub.departamento, ub.provincia, ub.distrito, dir.descrip_dir, dir.descrip_ref,
    pap.check_fur, pap.fec_fur, pap.check_gestante, Case When pap.check_gestante = true Then 'SI' Else 'NO' End nom_gestante,
    pu.nombre_rs||' '||Case When pu.primer_ape isNull Then '' Else pu.primer_ape End nombre_profe
    From tbl_papsoli pap Inner Join tbl_serviciodependencia sed On pap.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_usuario u On pap.user_create_at = u.id_usuario
    Inner Join tbl_persona pu On u.id_persona = pu.id_persona
    Left Join tbl_historialdireccion dir On pap.id_direccionpac = dir.id_histodireccion
    Left Join tbl_ubigeo2019 ub On dir.id_ubigeo = ub.id_ubigeo
    Where pap.estado=1 And d.id_dependencia=" . $param[0]['idDepAten'] . " ";
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountSolicitudNoEnviada($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_papsoli pap Inner Join tbl_serviciodependencia sed On pap.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_usuario u On pap.user_create_at = u.id_usuario
    Inner Join tbl_persona pu On u.id_persona = pu.id_persona
    Left Join tbl_historialdireccion dir On pap.id_direccionpac = dir.id_histodireccion
    Left Join tbl_ubigeo2019 ub On dir.id_ubigeo = ub.id_ubigeo
    Where pap.estado=1 And d.id_dependencia=" . $param[0]['idDepAten'] . "";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }


  public function get_tblDatosEnvSolicitud($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select id_papenvio, nro_papenv::Varchar||'-'||extract(year from fec_papenvio)::Varchar nro_papenv, d.id_dependencia, d.nom_depen, 
	to_char(fec_papenvio, 'DD/MM/YYYY') fec_papenvio, 
	to_char(pape.create_sedereceived_at, 'DD/MM/YYYY') fec_paprecepsede, 
	Case When user_sedereceived_at isNull Then '' Else to_char(create_sendlab_at, 'DD/MM/YYYY') End fec_papenviolab,
	to_char(pape.create_received_at, 'DD/MM/YYYY') fec_papreceplab,
	to_char(pape.create_finalize_at, 'DD/MM/YYYY') fec_papfinalizado,
    pape.estado id_estadopapenv, epape.nom_estado nom_estadopapenv, 
    (Select count(*) From tbl_papenviodet Where id_papenvio= pape.id_papenvio) cnt_solienvtot,
    (Select count(*) From tbl_papenviodet det Where det.estado=2 And id_papenvio=pape.id_papenvio) cnt_soliaceptada,
    (Select count(*) From tbl_papenviodet det Where (det.estado=3 OR det.estado=5) And id_papenvio=pape.id_papenvio) cnt_solipormodif,
    (Select count(*) From tbl_papenviodet det Where det.estado=4 And id_papenvio=pape.id_papenvio) cnt_solirechazada,
    (Select count(*) From tbl_papenviodet det Inner Join tbl_papsoli pap On det.id_papsoli = pap.id_papsoli Where det.id_papenvio= pape.id_papenvio And id_estadoresul=3) cnt_soliprocesada,
    (Select count(*) From tbl_papenvionoconformidad Where estado=1 And id_papenvio=pape.id_papenvio) cnt_solinoconfor,
    (Select count(*) From tbl_papenviodet det Inner Join tbl_papsoli pap On det.id_papsoli = pap.id_papsoli Where det.id_papenvio= pape.id_papenvio And pap.estado=4) cnt_solinotif
    From tbl_papenvio pape
    Inner Join tbl_papenvioestado epape On pape.estado = epape.id_papenvestado
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Where pape.id_dependencia=" . $param[0]['idDepAten'] . "";
    if (!empty($param[0]['estEnv'])) {
      if ($param[0]['estEnv'] == "Pro") {
        $this->sql .= " And (pape.estado=2 Or pape.estado=3)";
      } else {
        $this->sql .= " And (pape.estado=4)";
      }
    } else {
      $this->sql .= " And pape.estado In (0,1,5,6,7,8)";
    }
    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And pape.fec_papenvio between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountEnvSolicitud($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_papenvio pape
    Inner Join tbl_papenvioestado epape On pape.estado = epape.id_papenvestado
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Where pape.id_dependencia=" . $param[0]['idDepAten'] . "";

    if (!empty($param[0]['estEnv'])) {
      if ($param[0]['estEnv'] == "Pro") {
        $this->sql .= " And (pape.estado=2 Or pape.estado=3)";
      } else {
        $this->sql .= " And (pape.estado=4)";
      }
    } else {
      $this->sql .= " And (pape.estado=1 Or pape.estado=0)";
    }

    if (!empty($param[0]['fecIniAte'])) {
      $this->sql .= " And pape.fec_papenvio between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_tblDatosRecepSolicitud($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "WITH conteos AS (
    SELECT det.id_papenvio,
	COUNT(*) AS cnt_solienvtot,
	COUNT(CASE WHEN det.estado = 2 THEN 1 END) AS cnt_soliaceptada,
	COUNT(CASE WHEN det.estado IN (3, 5) THEN 1 END) AS cnt_solipormodif,
	COUNT(CASE WHEN det.estado = 4 THEN 1 END) AS cnt_solirechazada,
	COUNT(CASE WHEN pap.id_estadoresul = 3 THEN 1 END) AS cnt_soliprocesada
    FROM tbl_papenviodet det 
	LEFT JOIN tbl_papsoli pap ON det.id_papsoli = pap.id_papsoli
    GROUP BY det.id_papenvio
),
noconformidades AS (
    SELECT id_papenvio, COUNT(*) AS cnt_solinoconfor FROM tbl_papenvionoconformidad
    WHERE estado = 1 GROUP BY id_papenvio
)
SELECT pape.id_papenvio, nro_papenv::VARCHAR || '-' || EXTRACT(YEAR FROM fec_papenvio)::VARCHAR AS nro_papenv, d.id_dependencia, d.nom_depen,
TO_CHAR(fec_papenvio, 'DD/MM/YYYY') AS fec_papenvio, TO_CHAR(create_sedereceived_at, 'DD/MM/YYYY') AS fec_paprecepsede,
CASE WHEN create_sedereceived_at IS NULL THEN '' ELSE TO_CHAR(create_sendlab_at, 'DD/MM/YYYY') END AS fec_papenviosede,
TO_CHAR(pape.create_received_at, 'DD/MM/YYYY') AS fec_papreceplab, TO_CHAR(pape.create_finalize_at, 'DD/MM/YYYY') AS fec_papfinalizado,
pape.estado AS id_estadopapenv, epape.nom_estado AS nom_estadopapenv,
COALESCE(c.cnt_solienvtot, 0) AS cnt_solienvtot,
COALESCE(c.cnt_soliaceptada, 0) AS cnt_soliaceptada,
COALESCE(c.cnt_solipormodif, 0) AS cnt_solipormodif,
COALESCE(c.cnt_solirechazada, 0) AS cnt_solirechazada,
COALESCE(c.cnt_soliprocesada, 0) AS cnt_soliprocesada,
COALESCE(nc.cnt_solinoconfor, 0) AS cnt_solinoconfor
FROM tbl_papenvio pape
INNER JOIN tbl_papenvioestado epape ON pape.estado = epape.id_papenvestado
INNER JOIN tbl_dependencia d ON pape.id_dependencia = d.id_dependencia
LEFT JOIN conteos c ON pape.id_papenvio = c.id_papenvio
LEFT JOIN noconformidades nc ON pape.id_papenvio = nc.id_papenvio";
    if (!empty($param[0]['estEnv'])) {
      if ($param[0]['estEnv'] == "Pro") {
        $this->sql .= " Where (pape.estado=2 Or pape.estado=3)";
      } else {
        $this->sql .= " Where (pape.estado=4)";
      }
    } else {
      $this->sql .= " Where (pape.estado=1)";
    }
    if (!empty($param[0]['idDepRef'])) {
      $this->sql .= " And pape.id_dependencia=" . $param[0]['idDepRef'] . "";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountRecepSolicitud($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_papenvio pape
    Inner Join tbl_papenvioestado epape On pape.estado = epape.id_papenvestado
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia";
    if (!empty($param[0]['estEnv'])) {
      if ($param[0]['estEnv'] == "Pro") {
        $this->sql .= " Where (pape.estado=2 Or pape.estado=3)";
      } else {
        $this->sql .= " Where (pape.estado=4)";
      }
    } else {
      $this->sql .= " Where (pape.estado=1)";
    }
    if (!empty($param[0]['idDepRef'])) {
      $this->sql .= " And pape.id_dependencia=" . $param[0]['idDepRef'] . "";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_tblDatosSolicitudEnviada1($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select pap.id_papsoli, paped.id_papenviodet, pap.nro_atencion nro_ordensoli, substring(extract(year from pap.fec_atencion)::Varchar, 3) anio_ordensoli, extract(year from pape.fec_papenvio)::Varchar anio_papenv, to_char(pap.fec_atencion, 'DD/MM/YYYY') fec_atencion, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac,
    Case When p.primer_ape isNull Then '' Else substring(p.primer_ape,1,1) End||Case When p.segundo_ape isNull Then '' When p.segundo_ape = '' Then  '' Else substring(p.segundo_ape,1,1) End abrev_rspac, p.nombre_rs nombre_pac,
    Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, date_part('year',age(pap.fec_atencion, p.fec_nac)) edad_pac,
    (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc, Case When pap.check_tipopac = True Then 'SI' Else 'NO' End nom_sispac,
    ub.departamento, ub.provincia, ub.distrito, dir.descrip_dir, dir.descrip_ref,
    pap.check_fur, pap.fec_fur, pap.check_gestante, Case When pap.check_gestante = True Then 'SI' Else 'NO' End nom_tipgestante, Case When pap.id_condiservicio = 1 Then 'SI' Else 'NO' End primer_pap,
    pap.estado id_estadosolipap, epap.nom_estado nom_estadosolipap,
    Case When id_papresul is Not Null Then Case When id_tipinsatisfactoria is Not Null Then 'INSATISFACTORIA' Else Case When negalesion = 1 Then 'NEGATIVO' Else 'POSITIVO' End End
    Else Case When (paped.estado = 1 Or paped.estado = 2) Then 'PENDIENTE' Else epaped.nom_estado End End nom_resul,
    Case When id_anorescamosa is Not Null Then
    Case When id_anorescamosa = 1 Then 'ASCUS'
    When id_anorescamosa = 2 Then 'L.I.E. de bajo grado'
    When id_anorescamosa = 3 Then 'ASCH'
    When id_anorescamosa = 4 Then 'L.I.E. de alto grado'
    When id_anorescamosa = 5 Then 'CARCINOMA'
    End
    Else
    Case When id_anorglandular is Not Null Then
    Case When id_anorglandular = 1 Then 'Celulas glandulares atipicas'
    When id_anorglandular = 2 Then 'Celulas glandulares atipicas sugestivas de neoplasia'
    When id_anorglandular = 3 Then 'Adenocarcinoma in situ'
    When id_anorglandular = 4 Then 'Adenocarcinoma'
    End
    Else ''
    End
    End nom_bethesa,
    pap.nro_reglab, substring(extract(year from create_reglab_at)::Varchar, 3) anio_reglab,
    pape.estado idestado_env, paped.estado idestado_envdet, epaped.nom_estado nomestado_envdet, pap.nro_reglab, substring(extract(year from create_reglab_at)::Varchar, 3) anio_reglab,
    pu.nombre_rs||' '||Case When pu.primer_ape isNull Then '' Else pu.primer_ape End nombre_profe,
	papr.id_papresul
    From tbl_papenvio pape Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_serviciodependencia sed On pap.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_usuario u On pap.user_create_at = u.id_usuario
    Inner Join tbl_persona pu On u.id_persona = pu.id_persona
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Left Join tbl_historialdireccion dir On pap.id_direccionpac = dir.id_histodireccion
    Left Join tbl_ubigeo2019 ub On dir.id_ubigeo = ub.id_ubigeo
    Where pape.id_papenvio=" . $param[0]['idPapEnv'] . "";// And pape.estado=1
    if (!empty($param[0]['estPAP'])) {
      $this->sql .= " And pap.estado=" . $param[0]['estPAP'] . "";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountSolicitudEnviada1($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_papenvio pape Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_serviciodependencia sed On pap.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Left Join tbl_historialdireccion dir On pap.id_direccionpac = dir.id_histodireccion
    Left Join tbl_ubigeo2019 ub On dir.id_ubigeo = ub.id_ubigeo
    Where pape.id_papenvio=" . $param[0]['idPapEnv'] . "";
    if (!empty($param[0]['estPAP'])) {
      $this->sql .= " And pap.estado=" . $param[0]['estPAP'] . "";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }


  public function get_tblDatosSolicitudEnviada($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select pap.id_papsoli, paped.id_papenviodet, pap.nro_atencion nro_ordensoli, substring(extract(year from pap.fec_atencion)::Varchar, 3) anio_ordensoli, to_char(pap.fec_atencion, 'DD/MM/YYYY') fec_atencion, extract(days from (now()::timestamp - pap.fec_atencion::timestamp)) dias_transcurrido, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac,
    Case When p.primer_ape isNull Then '' Else substring(p.primer_ape,1,1) End||Case When p.segundo_ape isNull Then '' When p.segundo_ape = '' Then  '' Else substring(p.segundo_ape,1,1) End abrev_rspac, p.nombre_rs nombre_pac,
    (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc, Case When pap.check_tipopac = True Then 'SI' Else 'NO' End nom_sispac,
    Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, date_part('year',age(pap.fec_atencion, p.fec_nac)) edad_pac,
    ub.departamento, ub.provincia, ub.distrito, dir.descrip_dir, dir.descrip_ref,
    pap.check_fur, pap.fec_fur, pap.check_gestante, Case When pap.check_gestante = True Then 'SI' Else 'NO' End nom_tipgestante, Case When pap.id_condiservicio=1 Then 'SI' Else 'NO' End primer_pap,
    (Select string_agg(id_tipanticonceptivo::Varchar, ',') FROM tbl_papsoli_anticonceptivo Where id_papsoli=pap.id_papsoli And estado=1) id_mac,
    paped.estado idestado_envdet, epaped.nom_estado nomestado_envdet, pap.nro_reglab, substring(extract(year from create_reglab_at)::Varchar, 3) anio_reglab,
	rpap.id_papresul
    From tbl_papenvio pape Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_serviciodependencia sed On pap.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Left Join tbl_historialdireccion dir On pap.id_direccionpac = dir.id_histodireccion
    Left Join tbl_ubigeo2019 ub On dir.id_ubigeo = ub.id_ubigeo
	Left Join tbl_papresul rpap On pap.id_papsoli = rpap.id_papsoli
    Where pape.id_papenvio=" . $param[0]['idPapEnv'] . "";
    if (!empty($param[0]['estEnv'])) {
      if ($param[0]['estEnv'] == "obs") {
        $this->sql .= " And (paped.estado=3 OR paped.estado=5 OR paped.estado=4)";
      } else {
        $this->sql .= " And paped.estado=2";
      }
    } else {
      $this->sql .= " And paped.estado=1";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountSolicitudEnviada($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_papenvio pape Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_serviciodependencia sed On pap.id_serviciodep = sed.id_serviciodep
    Inner Join tbl_servicio se On sed.id_servicio = se.id_servicio
    Inner Join tbl_dependencia d On sed.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Left Join tbl_historialdireccion dir On pap.id_direccionpac = dir.id_histodireccion
    Left Join tbl_ubigeo2019 ub On dir.id_ubigeo = ub.id_ubigeo
    Where pape.id_papenvio=" . $param[0]['idPapEnv'] . "";
    if (!empty($param[0]['estEnv'])) {
      if ($param[0]['estEnv'] == "obs") {
        $this->sql .= " And (paped.estado=3 OR paped.estado=5 OR paped.estado=4)";
      } else {
        $this->sql .= " And paped.estado=2";
      }
    } else {
      $this->sql .= " And paped.estado=1";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_tblDatosAceptable($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select pap.id_papsoli, to_char(pap.fec_atencion, 'DD/MM/YYYY') fec_atencion, pap.nro_atencion nro_ordensoli, substring(extract(year from pap.fec_atencion)::Varchar, 3) anio_ordensoli, pap.nro_reglab, substring(extract(year from create_reglab_at)::Varchar, 3) anio_reglab,
    p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc,
    Case When p.primer_ape isNull Then '' Else substring(p.primer_ape,1,1) End||Case When p.segundo_ape isNull Then '' When p.segundo_ape = '' Then  '' Else substring(p.segundo_ape,1,1) End abrev_rspac, p.nombre_rs nombre_pac,
    Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, date_part('year',age(pap.fec_atencion, p.fec_nac)) edad_pac,
    d.nom_depen, pap.estado id_estadosolipap, epap.nom_estado nom_estadosolipap, pap.id_estadoresul id_estadoresulpap, erpap.nom_estado nom_estadosoliresulpap,
    Case When id_papenviodet isNull Then 'PENDIENTE' Else
    Case When id_papresul is Not Null Then Case When id_tipinsatisfactoria is Not Null Then 'INSATISFACTORIA' Else Case When negalesion = 1 Then 'NEGATIVO' Else 'POSITIVO' End End Else Case When (paped.estado = 1 Or paped.estado = 2) Then 'PENDIENTE' Else epaped.nom_estado End End
    End nom_resul,
    Case When id_anorescamosa is Not Null Then
    Case id_anorescamosa When 1 Then 'ASCUS'
    When 2 Then 'L.I.E. de bajo grado'
    When 3 Then 'ASCH'
    When 4 Then 'L.I.E. de alto grado'
    When 5 Then 'CARCINOMA IN SITU'
    When 6 Then 'CARCINOMA INVASOR'
    Else ''
    End
    Else
    Case When id_anorglandular is Not Null Then
    Case id_anorglandular When  1 Then 'Celulas glandulares atipicas'
    When 2 Then 'Celulas glandulares atipicas sugestivas de neoplasia'
    When 3 Then 'Adenocarcinoma in situ'
    When 4 Then 'Adenocarcinoma'
    End
    Else ''
    End
    End nom_bethesa
    From tbl_papsoli pap
    Inner Join tbl_papenviodet paped On pap.id_papsoli = paped.id_papsoli
    Inner Join tbl_dependencia d On pap.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_labestadoresul erpap On pap.id_estadoresul = erpap.id_estadoresul
    Left Join tbl_papresul rpap On pap.id_papsoli = rpap.id_papsoli
    Left Join tbl_papenvio pape On paped.id_papenvio = pape.id_papenvio
    Left Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Where pap.estado=2 And (pap.id_estadoresul=1 OR pap.id_estadoresul=2) And paped.estado=2";
    if (!empty($param[0]['nroOrden'])) {
      $this->sql .= " And pap.nro_reglab='" . $param[0]['nroOrden'] . "'";
		if (!empty($param[0]['bus_anio'])) {
		  $this->sql .= " And pap.anio_reglab='" . $param[0]['bus_anio'] . "'";
		}
    }
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And p.nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountAceptable($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_papsoli pap
    Inner Join tbl_papenviodet paped On pap.id_papsoli = paped.id_papsoli
    Inner Join tbl_dependencia d On pap.id_dependencia = d.id_dependencia
    Inner Join tbl_papestado epap On pap.estado = epap.id_papestado
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_labestadoresul erpap On pap.id_estadoresul = erpap.id_estadoresul
    Left Join tbl_papresul rpap On pap.id_papsoli = rpap.id_papsoli
    Left Join tbl_papenvio pape On paped.id_papenvio = pape.id_papenvio
    Left Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Where pap.estado=2 And (pap.id_estadoresul=1 OR pap.id_estadoresul=2) And paped.estado=2";
    if (!empty($param[0]['nroOrden'])) {
      $this->sql .= " And pap.nro_reglab='" . $param[0]['nroOrden'] . "'";
    }
    if (!empty($param[0]['nroDoc'])) {
      $this->sql .= " And p.id_tipodoc = " . $param[0]['idTipDoc'] . " And p.nrodoc= '" . $param[0]['nroDoc'] . "'";
    }
    if (!empty($param[0]['nomRS'])) {
      $this->sql .= " And Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs Like Upper('%" . $param[0]['nomRS'] . "%')";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_tblRepDatosPAPLaboratorio($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select pap.id_papsoli, pape.nro_papenv, extract(year from pape.fec_papenvio)::Varchar anio_papenv, d.nom_depen, to_char(fec_papenvio, 'DD/MM/YYYY') fec_papenvio,
    to_char(pape.create_received_at::date, 'DD/MM/YYYY') fec_paprecep, to_char(pape.create_received_at, 'hh24:mi PM') hora_paprecep,
    papr.id_papresul, papr.id_tipsatisfactoria, papr.id_tipinsatisfactoria, papr.negalesion, papr.id_anorescamosa, papr.id_anorglandular, to_char(papr.fecha, 'DD/MM/YYYY') fec_resul,
    Case When papr.id_papresul is Not Null Then Case When papr.id_tipinsatisfactoria is Not Null Then 'INSATISFACTORIA' Else Case When papr.negalesion = 1 Then 'NEGATIVO' Else 'POSITIVO' End End
    Else Case When (paped.estado = 1 Or paped.estado = 2) Then 'PENDIENTE' Else epaped.nom_estado End End nom_resul,
    Case When papr.id_anorescamosa is Not Null Then
    Case When papr.id_anorescamosa = 1 Then 'ASCUS'
    When papr.id_anorescamosa = 2 Then 'L.I.E. de bajo grado'
    When papr.id_anorescamosa = 3 Then 'ASCH'
    When papr.id_anorescamosa = 4 Then 'L.I.E. de alto grado'
    When papr.id_anorescamosa = 5 Then 'CARCINOMA IN SITU'
    When papr.id_anorescamosa = 6 Then 'CARCINOMA INVASOR'
    End
    Else
    Case When papr.id_anorglandular is Not Null Then
    Case When papr.id_anorglandular = 1 Then 'Celulas glandulares atipicas'
    When papr.id_anorglandular = 2 Then 'Celulas glandulares atipicas sugestivas de neoplasia'
    When papr.id_anorglandular = 3 Then 'Adenocarcinoma in situ'
    When papr.id_anorglandular = 4 Then 'Adenocarcinoma'
    End
    Else ''
    End
    End nom_bethesa,
    pap.nro_reglab, substring(extract(year from create_reglab_at)::Varchar, 3) anio_reglab,
    to_char(create_finalize_at::date, 'DD/MM/YYYY') fec_papfinal, to_char(create_finalize_at, 'hh24:mi PM') fec_horafinal, pap.id_estadoresul id_estadoresulpap,
    Case When paprv.id_papresul IsNull Then 'NO' else 'SI' End nom_exicambioresulval
    From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Left Join tbl_papresulvalid paprv On papr.id_papresul = paprv.id_papresul
    Where pape.estado <> 1 and paped.estado<>0";
    if ($param[0]['tipoFec'] == "1") {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And pape.create_received_at::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    } else {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And papr.fecha between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    }
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And papr.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountPAPLaboratorio($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Left Join tbl_papresulvalid paprv On papr.id_papresul = paprv.id_papresul
    Where pape.estado <> 1 and paped.estado<>0";
    if ($param[0]['tipoFec'] == "1") {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And pape.create_received_at::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    } else {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And papr.fecha between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    }
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And papr.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_repDatosPAPLaboratorio($param) {
    $this->db->getConnection();
    $this->sql = "Select pap.id_papsoli, pap.id_papsoli, p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc,
    Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, date_part('year',age(pap.fec_atencion, p.fec_nac)) edad_pac,
    pape.nro_papenv, extract(year from pape.fec_papenvio)::Varchar anio_papenv, d.nom_depen, to_char(fec_papenvio, 'DD/MM/YYYY') fec_papenvio, Case When pap.check_tipopac='t' Then 'SI' Else 'NO' End nom_sispac,
    to_char(pape.create_received_at::date, 'DD/MM/YYYY') fec_paprecep, to_char(pape.create_received_at, 'hh24:mi PM') hora_paprecep,
    papr.id_tipsatisfactoria, papr.id_tipinsatisfactoria, papr.negalesion, papr.id_anorescamosa, papr.id_anorglandular, to_char(papr.fecha, 'DD/MM/YYYY') fec_resul,
    Case When id_papresul is Not Null Then Case When id_tipinsatisfactoria is Not Null Then 'INSATISFACTORIA' Else Case When negalesion = 1 Then 'NEGATIVO' Else 'POSITIVO' End End
    Else Case When (paped.estado = 1 Or paped.estado = 2) Then 'PENDIENTE' Else epaped.nom_estado End End nom_resul,
    Case When id_anorescamosa is Not Null Then
    Case When id_anorescamosa = 1 Then 'ASCUS'
    When id_anorescamosa = 2 Then 'L.I.E. de bajo grado'
    When id_anorescamosa = 3 Then 'ASCH'
    When id_anorescamosa = 4 Then 'L.I.E. de alto grado'
    When id_anorescamosa = 5 Then 'CARCINOMA IN SITU'
    When id_anorescamosa = 6 Then 'CARCINOMA INVASOR'
    End
    Else
    Case When id_anorglandular is Not Null Then
    Case When id_anorglandular = 1 Then 'Celulas glandulares atipicas'
    When id_anorglandular = 2 Then 'Celulas glandulares atipicas sugestivas de neoplasia'
    When id_anorglandular = 3 Then 'Adenocarcinoma in situ'
    When id_anorglandular = 4 Then 'Adenocarcinoma'
    End
    Else ''
    End
    End nom_bethesa,
    pap.nro_reglab, substring(extract(year from create_reglab_at)::Varchar, 3) anio_reglab,
    to_char(create_finalize_at::date, 'DD/MM/YYYY') fec_papfinal, to_char(create_finalize_at, 'hh24:mi PM') fec_horafinal
    From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Where pape.estado <> 1 and paped.estado<>0";
    if ($param[0]['tipoFec'] == "1") {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And pape.create_received_at::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    } else {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And papr.fecha between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    }
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And papr.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repDatosPLaboratorioCntLecturaPorFechayProfesional($param) {
    $this->db->getConnection();
    $this->sql = "Select to_char(rpap.fecha, 'DD/MM/YYYY') fecresul, Case When pr.primer_ape isNull Then '' Else pr.primer_ape End||' '||Case When pr.segundo_ape isNull Then '' Else pr.segundo_ape End ||' '||pr.nombre_rs nombre_rsprof,
    d.nom_depen,pape.nro_papenv, extract(year from pape.create_at) anio_papenv,min(rpap.nro_reglab) minreglab, max(rpap.nro_reglab) maxreglab, count(1) cntreglab From tbl_papresul rpap
    Inner Join tbl_papsoli pap On rpap.id_papsoli = pap.id_papsoli
    Inner Join tbl_papenviodet paped On pap.id_papsoli = paped.id_papsoli
    Inner Join tbl_papenvio pape On paped.id_papenvio = pape.id_papenvio
    Inner Join tbl_dependencia d On pap.id_dependencia = d.id_dependencia
    Inner Join tbl_usuario u On rpap.user_create_at = u.id_usuario
    Inner Join tbl_persona pr On u.id_persona = pr.id_persona
    Where rpap.fecha Between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And rpap.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->sql .= " Group By rpap.fecha,pr.primer_ape,pr.segundo_ape,pr.nombre_rs,d.nom_depen,pape.nro_papenv,extract(year from pape.create_at) Order By rpap.fecha";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repCntAtencionEstadoPorFecha($param) {
    $this->db->getConnection();
    $this->sql = "--Pendiente
    Select 'PENDIENTE' nom_estado, count(1) cnt_estado From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Where pape.estado <> 1 And (paped.estado = 1 Or paped.estado = 2) And id_papresul is Null";
    if ($param[0]['tipoFec'] == "1") {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And pape.create_received_at::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    } else {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And papr.fecha between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    }
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And papr.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->sql .= "Union All
    --Negativo
    Select 'NEGATIVO' nom_estado, count(1) cnt_estado From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Where pape.estado <> 1 And id_papresul is Not Null And id_tipinsatisfactoria isNull And negalesion = 1";
    if ($param[0]['tipoFec'] == "1") {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And pape.create_received_at::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    } else {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And papr.fecha between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    }
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And papr.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->sql .= "Union All
    --Positivo
    Select 'POSITIVO' nom_estado, count(1) cnt_estado From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Where pape.estado <> 1 And id_papresul is Not Null And id_tipinsatisfactoria isNull And negalesion = 0";
    if ($param[0]['tipoFec'] == "1") {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And pape.create_received_at::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    } else {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And papr.fecha between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    }
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And papr.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->sql .= "Union All
    --Insatisfactoria
    Select 'INSATISFACTORIA' nom_estado, count(1) cnt_estado From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Where pape.estado <> 1 And id_papresul is Not Null And id_tipinsatisfactoria is Not Null";
    if ($param[0]['tipoFec'] == "1") {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And pape.create_received_at::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    } else {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And papr.fecha between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    }
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And papr.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->sql .= "Union All
    --Rechazados
    Select 'RECHAZADO' nom_estado, count(1) cnt_estado From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Where pape.estado <> 1 And paped.estado = 4 And id_papresul is Null";
    if ($param[0]['tipoFec'] == "1") {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And pape.create_received_at::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    } else {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And papr.fecha between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    }
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And papr.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->sql .= "Union All
    --Para Subsanar
    Select 'POR SUBSANAR' nom_estado, count(1) cnt_estado From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Where pape.estado <> 1 And paped.estado = 3 And id_papresul is Null";
    if ($param[0]['tipoFec'] == "1") {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And pape.create_received_at::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    } else {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And papr.fecha between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    }
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And papr.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->sql .= "Union All
    --Subsanados
    Select 'SUBSANADO' nom_estado, count(1) cnt_estado From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli
    Where pape.estado <> 1 And paped.estado = 5 And id_papresul is Null";
    if ($param[0]['tipoFec'] == "1") {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And pape.create_received_at::date between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    } else {
      if (!empty($param[0]['fecIniAte'])) {
        $this->sql .= " And papr.fecha between '" . $param[0]['fecIniAte'] . "' And '" . $param[0]['fecFinAte'] . "'";
      }
    }
    if (!empty($param[0]['idProfe'])) {
      $this->sql .= " And papr.user_create_at=" . $param[0]['idProfe'] . "";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repDatosPAPEnvioLaboratorio($param) {
    $this->db->getConnection();
    $this->sql = "Select pap.id_papsoli, pap.id_papsoli, p.id_persona id_paciente, p.id_tipodoc id_tipodocpac, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc,
    Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, date_part('year',age(pap.fec_atencion, p.fec_nac)) edad_pac,
    pape.nro_papenv, extract(year from pape.fec_papenvio)::Varchar anio_papenv, d.nom_depen, to_char(fec_papenvio, 'DD/MM/YYYY') fec_papenvio, Case When pap.check_tipopac='t' Then 'SIS' Else 'NO' End nom_sispac,
    to_char(pape.create_received_at::date, 'DD/MM/YYYY') fec_paprecep, extract(month from pape.create_received_at) mes_paprecep,to_char(pape.create_received_at, 'hh24:mi PM') hora_paprecep,
    papr.id_tipsatisfactoria, papr.id_tipinsatisfactoria, papr.negalesion, papr.id_anorescamosa, papr.id_anorglandular, to_char(papr.fecha, 'DD/MM/YYYY') fec_resul,
    Case When id_papresul is Not Null Then Case When id_tipinsatisfactoria is Not Null Then 'INSATISFACTORIA' Else Case When negalesion = 1 Then 'NEGATIVO' Else 'POSITIVO' End End
    Else Case When (paped.estado = 1 Or paped.estado = 2) Then 'PENDIENTE' Else epaped.nom_estado End End nom_resul,
    Case When id_anorescamosa is Not Null Then
    Case When id_anorescamosa = 1 Then 'ASCUS'
    When id_anorescamosa = 2 Then 'L.I.E. de bajo grado'
    When id_anorescamosa = 3 Then 'ASCH'
    When id_anorescamosa = 4 Then 'L.I.E. de alto grado'
    When id_anorescamosa = 5 Then 'CARCINOMA IN SITU'
    When id_anorescamosa = 6 Then 'CARCINOMA INVASOR'
    End
    Else
    Case When id_anorglandular is Not Null Then
    Case When id_anorglandular = 1 Then 'Celulas glandulares atipicas'
    When id_anorglandular = 2 Then 'Celulas glandulares atipicas sugestivas de neoplasia'
    When id_anorglandular = 3 Then 'Adenocarcinoma in situ'
    When id_anorglandular = 4 Then 'Adenocarcinoma'
    End
    Else ''
    End
    End nom_bethesa,
    pap.nro_reglab, substring(extract(year from create_reglab_at)::Varchar, 3) anio_reglab,
    to_char(create_finalize_at::date, 'DD/MM/YYYY') fec_papfinal, to_char(create_finalize_at, 'hh24:mi PM') fec_horafinal,

    to_char(create_valid::date, 'DD/MM/YYYY') fec_validresul,
    pte.id_profesional id_tecnologo, Case When tep.primer_ape isNull Then '' Else tep.primer_ape End||' '||Case When tep.segundo_ape isNull Then '' Else tep.segundo_ape End ||' '||tep.nombre_rs nombre_rstec, pte.nro_colegiatura nro_colegiaturatec,
    pen.id_profesional id_encargadolab, Case When enp.primer_ape isNull Then '' Else enp.primer_ape End||' '||Case When enp.segundo_ape isNull Then '' Else enp.segundo_ape End ||' '||enp.nombre_rs nombre_rsenclab, pen.nro_colegiatura nro_colegiaturaenclab

    From tbl_papenvio pape
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia
    Inner Join tbl_papenviodet paped On pape.id_papenvio = paped.id_papenvio
    Inner Join tbl_papsoli pap On paped.id_papsoli = pap.id_papsoli
    Inner Join tbl_persona p On pap.id_paciente = p.id_persona
    Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
    Inner Join tbl_papenviodetestado epaped On paped.estado = epaped.id_papenvdetestado
    Left Join tbl_papresul papr On paped.id_papsoli = papr.id_papsoli

    Left Join tbl_usuario ute On papr.user_create_at = ute.id_usuario
    Left Join tbl_persona tep On ute.id_persona = tep.id_persona
    Left Join tbl_profesional pte On  tep.id_persona = pte.id_persona

    Left Join tbl_usuario uen On pap.user_create_valid = uen.id_usuario
    Left Join tbl_persona enp On ute.id_persona = enp.id_persona
    Left Join tbl_profesional pen On  enp.id_persona = pen.id_persona

    Where pape.estado <> 1 and paped.estado<>0 And paped.id_papenvio=".$param[0]['idEnv']."
    Order By nro_reglab, anio_reglab";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblDatosRecepSolicitudSede($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
    $this->sql = "Select id_papenvio, nro_papenv::Varchar||'-'||extract(year from fec_papenvio)::Varchar nro_papenv, d.id_dependencia, d.nom_depen, to_char(fec_papenvio, 'DD/MM/YYYY') fec_papenvio, to_char(pape.create_sedereceived_at, 'DD/MM/YYYY') fec_paprecepsede, to_char(pape.create_sendlab_at, 'DD/MM/YYYY') fec_papenviolab,
    pape.estado id_estadopapenv, epape.nom_estado nom_estadopapenv,
    (Select count(*) From tbl_papenviodet Where id_papenvio= pape.id_papenvio) cnt_solienvtot,
    to_char(create_observed_at, 'DD/MM/YYYY') fec_papobssede
    From tbl_papenvio pape
    Inner Join tbl_papenvioestado epape On pape.estado = epape.id_papenvestado
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia";
    if ($param[0]['idEstEnv'] == "5") {
      $this->sql .= " Where pape.estado=5 Or pape.estado=7";
    } else if ($param[0]['idEstEnv'] == "1") {
	  $this->sql .= " Where pape.estado=1 And pape.create_sedereceived_at is Not Null";
	} else {
      $this->sql .= " Where pape.estado=".$param[0]['idEstEnv']."";
    }
    if (!empty($param[0]['idDepRef'])) {
      $this->sql .= " And pape.id_dependencia=" . $param[0]['idDepRef'] . "";
    }
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblCountRecepSolicitudSede($sWhere, $param) {
    $this->db->getConnection();
    $this->sql = "Select count(*) cnt From tbl_papenvio pape
    Inner Join tbl_papenvioestado epape On pape.estado = epape.id_papenvestado
    Inner Join tbl_dependencia d On pape.id_dependencia = d.id_dependencia";
    if ($param[0]['idEstEnv'] == "5") {
      $this->sql .= " Where pape.estado=5 Or pape.estado=7";
    } else if ($param[0]['idEstEnv'] == "1") {
	  $this->sql .= " Where pape.estado=1 And pape.create_sedereceived_at is Not Null";
	} else {
      $this->sql .= " Where pape.estado=".$param[0]['idEstEnv']."";
    }
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs[0]['cnt'];
  }

  public function get_repDatosIndiDirisPorAnio($anio,$mes,$idris,$iddep,$idest) {
    $this->db->getConnection();
	if($mes <> ""){
		$mes = " And extract(month From fec_atencion) in (" . $mes . ")";	
	}
	if($idris <> ""){
		$idris = "";	
	}
	if($iddep <> ""){
		$iddep = " And id_dependencia = ".$iddep;	
	}
	if($idest <> ""){
		if ($idest == 0) {
			$idest = " And pap.estado = 0";	
		} else if ($idest == 5) {
			$idest = " And pap.estado = 4";	
		} else {
			$idest = " And id_estadoresulfinal = ".$idest;
		}
	}
	
    $this->sql = "Select * From (
Select 1 nro, 'registrado' resultado, count(1) as muestra From tbl_papsoli pap Where extract(year From fec_atencion)=".$anio." 
" . $mes . "
" . $iddep . "
" . $idest . "
Union
Select 2 nro, 'anulado' resultado, count(1) as muestra From tbl_papsoli pap Where extract(year From fec_atencion)=".$anio." And estado=0
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 3 nro, 'muestra' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And extract(year From fec_atencion)=".$anio." 
" . $mes . "
" . $iddep . "
" . $idest . "
Union
Select 4 nro, 'negativo' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And extract(year From fec_atencion)=".$anio." And id_estadoresulfinal=2
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 5 nro, 'positivo' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And extract(year From fec_atencion)=".$anio." And id_estadoresulfinal=1
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 6 nro, 'insatisfactorio' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And extract(year From fec_atencion)=".$anio." And id_estadoresulfinal=3
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 7 nro, 'rechazado' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And extract(year From fec_atencion)=".$anio." And id_estadoresulfinal=4
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 8 nro, 'entregadoapac' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And estado=4 And extract(year From fec_atencion)=".$anio."
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 9 nro, 'muestra15' resultado, count(1) as muestra From tbl_papsoli pap Inner Join tbl_persona p On pap.id_paciente=p.id_persona
Where pap.estado<>0 And date_part('year',age(pap.fec_atencion, p.fec_nac)) < 15 And extract(year From pap.fec_atencion)=".$anio."
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 10 nro, 'muestra29' resultado, count(1) as muestra From tbl_papsoli pap Inner Join tbl_persona p On pap.id_paciente=p.id_persona
Where pap.estado<>0 And date_part('year',age(pap.fec_atencion, p.fec_nac)) between 15 And 29 And extract(year From pap.fec_atencion)=".$anio."
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 11 nro, 'muestra49' resultado, count(1) as muestra From tbl_papsoli pap Inner Join tbl_persona p On pap.id_paciente=p.id_persona
Where pap.estado<>0 And date_part('year',age(pap.fec_atencion, p.fec_nac)) between 30 And 49 And extract(year From pap.fec_atencion)=".$anio."
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 12 nro, 'muestra50' resultado, count(1) as muestra From tbl_papsoli pap Inner Join tbl_persona p On pap.id_paciente=p.id_persona
Where pap.estado<>0 And date_part('year',age(pap.fec_atencion, p.fec_nac)) >= 50 And extract(year From pap.fec_atencion)=".$anio."
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 13 nro, 'muestrasis' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And check_tipopac=true And extract(year From fec_atencion)=".$anio."
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 14 nro, 'muestranosis' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And check_tipopac=false And extract(year From fec_atencion)=".$anio."
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 15 nro, 'muestratamiante' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And id_tamizajeante<>0 And extract(year From fec_atencion)=".$anio."
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 16 nro, 'muestrataminue' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And id_tamizajeante=0 And extract(year From fec_atencion)=".$anio."
" . $mes . " 
" . $iddep . "
" . $idest . "
Union
Select 17 nro, 'sinresultado' resultado, count(1) as muestra From tbl_papsoli pap Where estado<>0 And extract(year From fec_atencion)=".$anio." And id_estadoresulfinal=0
" . $mes . " 
" . $iddep . "
" . $idest . "
) a Order By nro";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblDatosIndiDirisPorEstablecimiento($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
	$mes = ""; $dmes = "";
	$idris = ""; $didris = "";
	$iddep = ""; $diddep = "";
	$idest = ""; $didest = "";
	if(!empty($param[0]['mes'])){
		$mes = " And extract(month From fec_atencion) in (" . $param[0]['mes'] . ")";	
	}
	if(!empty($param[0]['id_ris'])){
		$idris = "";
	}
	if(!empty($param[0]['id_dependencia'])){
		$iddep = " And pap.id_dependencia = ".$param[0]['id_dependencia'];	
	}
	if($param[0]['id_estado'] <> ""){
		if ($param[0]['id_estado'] == 0) {
			$idest = " And pap.estado = 0";	
			$didest = " And s.estado = 0";	
		} else if ($param[0]['id_estado'] == 5) {
			$idest = " And pap.estado = 4";	
			$didest = " And s.estado = 4";	
		} else {
			$idest = " And pap.estado <> 0 And id_estadoresulfinal = ".$param[0]['id_estado'];
			$didest = " And s.estado <> 0 And s.id_estadoresulfinal = ".$param[0]['id_estado'];
		}
	} else {
		$idest = " And pap.estado <> 0";
	}
	
    $this->sql = "Select pap.id_dependencia, d.codref_depen, d.nom_depen, count(*) as muestra,
count(case id_estadoresulfinal when 2 then 1 else Null End) negativo,  count(case id_estadoresulfinal when 1 then 1 else Null End) positivo, count(case id_estadoresulfinal when 3 then 1 else Null End) insatisfactorio, count(case id_estadoresulfinal when 4 then 1 else Null End) rechazado, count(case pap.estado when 4 then 1 else Null End) entregadoapac
From tbl_papsoli pap
Inner Join tbl_dependencia d On pap.id_dependencia = d.id_dependencia
Where extract(year From pap.fec_atencion)=".$param[0]['anio']."
	" . $mes . " 
	" . $iddep . "
	" . $idest . "";
    $this->sql .= " Group By pap.id_dependencia, d.codref_depen, d.nom_depen";
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_tblDatosIndiDirisPorEstablecimientoAndAnioMesAtencion($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
	$mes = ""; $dmes = "";
	$idris = ""; $didris = "";
	$iddep = ""; $diddep = "";
	$idest = ""; $didest = "";
	if(!empty($param[0]['mes'])){
		$mes = " And extract(month From fec_atencion) in (" . $param[0]['mes'] . ")";	
	}
	if(!empty($param[0]['id_ris'])){
		$idris = "";
	}
	if(!empty($param[0]['id_dependencia'])){
		$iddep = " And pap.id_dependencia = ".$param[0]['id_dependencia'];
		$diddep = " And s.id_dependencia = ".$param[0]['id_dependencia'];
	}
	if($param[0]['id_estado'] <> ""){
		if ($param[0]['id_estado'] == 0) {
			$idest = " And pap.estado = 0";	
			$didest = " And s.estado = 0";	
		} else if ($param[0]['id_estado'] == 5) {
			$idest = " And pap.estado = 4";	
			$didest = " And s.estado = 4";	
		} else {
			$idest = " And pap.estado <> 0 And id_estadoresulfinal = ".$param[0]['id_estado'];
			$didest = " And s.estado <> 0 And s.id_estadoresulfinal = ".$param[0]['id_estado'];
		}
	} else {
		$idest = " And pap.estado <> 0";
	}

    $this->sql = "Select extract(year From pap.fec_atencion) anio_atencion, extract(month From pap.fec_atencion) mes_atencion, Case extract(month From pap.fec_atencion) When 1 Then 'ENERO' When 2 Then 'FEBRERO' When 3 Then 'MARZO' When 4 Then 'ABRIL' When 5 Then 'MAYO'
When 6 Then 'JUNIO' When 7 Then 'JULIO' When 8 Then 'AGOSTO' When 9 Then 'SETIEMBRE' When 10 Then 'OCTUBRE' When 11 Then 'NOVIEMBRE' ELSE 'DICIEMBRE' End nommes_atencion,
count(*) muestra, count(case id_estadoresulfinal when 2 then 1 else Null End) negativo,  count(case id_estadoresulfinal when 1 then 1 else Null End) positivo, count(case id_estadoresulfinal when 3 then 1 else Null End) insatisfactorio, count(case id_estadoresulfinal when 4 then 1 else Null End) rechazado, count(case pap.estado when 4 then 1 else Null End) entregadoapac 
From tbl_papsoli pap
Where extract(year From pap.fec_atencion)=".$param[0]['anio']."
	" . $mes . " 
	" . $iddep . "
	" . $idest . " Group by extract(year From pap.fec_atencion), extract(month From pap.fec_atencion) ";
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  

  public function get_repDatosDetalleIndicador($param) {
	$where = "";
    $this->db->getConnection();
    $this->sql = "Select d.nom_depen, tdp.abreviatura abrev_tipodocpac, p.nrodoc nro_docpac, Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_rspac, 
date_part('year',age(pap.fec_atencion, p.fec_nac)) edad_pac, (Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=d.id_dependencia) nro_hc, 
Case When check_tipopac = TRUE Then 'SIS' Else 'PARTICULAR' End nom_tipopac, ub.distrito, telf.nro_telefono telf_fijo, telm.nro_telefono telf_movil, 
to_char(pap.fec_atencion, 'DD/MM/YYYY') fec_atencion, to_char(pap.create_valid, 'DD/MM/YYYY') fec_resultado,  --create_valid y create_finalize_at: uno es cuando fue validado y el otro cuando fue finalizado el envío
Case id_estadoresulfinal When 0 Then 'PENDIENTE' When 1 Then 'POSITIVO' When 2 Then 'NEGATIVO' When 3 Then 'INSATISFACTORIA' When 4 Then 'RECHAZADA' End nom_estadoresulfinal, 
to_char(pap.create_notif, 'DD/MM/YYYY') fec_entregapac
From tbl_papsoli pap
Inner Join tbl_dependencia d On pap.id_dependencia = d.id_dependencia
Inner Join tbl_persona p On pap.id_paciente = p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Left Join tbl_historialdireccion dir On pap.id_direccionpac = dir.id_histodireccion
Left Join tbl_ubigeo2019 ub On dir.id_ubigeo = ub.id_ubigeo
Left Join tbl_historialtelefono telf On pap.id_telffijopac = telf.id_histotelefono
Left Join tbl_historialtelefono telm On pap.id_telfmovilpac = telm.id_histotelefono
Where extract(year From pap.fec_atencion)=".$param[0]['anio']."";
	if(!empty($param[0]['mes'])){
		$where .= " And extract(month From fec_atencion) in (" . $param[0]['mes'] . ")";	
	}
	if(!empty($param[0]['id_ris'])){
		$where .= "";
	}
	if(!empty($param[0]['id_dependencia'])){
		$where .= " And pap.id_dependencia = ".$param[0]['id_dependencia'];
	}
	if($param[0]['id_estado'] <> ""){
		if ($param[0]['id_estado'] == 0) {
			$where .= " And pap.estado = 0";	
		} else if ($param[0]['id_estado'] == 5) {
			$where .= " And pap.estado = 4";	
		} else {
			$where .= " And pap.estado <> 0 And id_estadoresulfinal = ".$param[0]['id_estado'];
		}
	} else {
		$where .= " And pap.estado <> 0";
	}
	$this->sql .= $where;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
  

  public function get_tblDatosIndiDirisProfesionalPorEstablecimientoAndAnioMes($sWhere, $sOrder, $sLimit, $param) {
    $this->db->getConnection();
	$mes = ""; $dmes = "";
	$idris = ""; $didris = "";
	$iddep = ""; $diddep = "";
	$idest = ""; $didest = "";
	if(!empty($param[0]['mes'])){
		$mes = " And extract(month From pap.fec_atencion) in (" . $param[0]['mes'] . ")";	
	}
	if(!empty($param[0]['id_ris'])){
		$idris = "";
	}
	if(!empty($param[0]['id_dependencia'])){
		$iddep = " And pap.id_dependencia = ".$param[0]['id_dependencia'];	
	}
	if($param[0]['id_estado'] <> ""){
		if ($param[0]['id_estado'] == 0) {
			$idest = " And pap.estado = 0";	
			$didest = " And s.estado = 0";	
		} else if ($param[0]['id_estado'] == 5) {
			$idest = " And pap.estado = 4";	
			$didest = " And s.estado = 4";	
		} else {
			$idest = " And pap.estado <> 0 And id_estadoresulfinal = ".$param[0]['id_estado'];
			$didest = " And s.estado <> 0 And s.id_estadoresulfinal = ".$param[0]['id_estado'];
		}
	} else {
		$idest = " And pap.estado <> 0";
	}
	
    $this->sql = "Select extract(year From pap.fec_atencion) anio_atencion, d.id_dependencia, d.nom_depen, pap.user_create_at id_usuario, 
	Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_prof,
	count(*) muestra, count(case pap.id_estadoresulfinal when 2 then 1 else Null End) negativo,  count(case pap.id_estadoresulfinal when 1 then 1 else Null End) positivo, count(case pap.id_estadoresulfinal when 3 then 1 else Null End) insatisfactorio, count(case pap.id_estadoresulfinal when 4 then 1 else Null End) rechazado, count(case pap.estado when 4 then 1 else Null End) entregadoapac
	From tbl_papsoli pap
	Inner Join tbl_usuario u On pap.user_create_at = u.id_usuario
	Inner Join tbl_persona p On u.id_persona = p.id_persona
	Inner Join tbl_dependencia d On pap.id_dependencia = d.id_dependencia
	Where extract(year From pap.fec_atencion)=".$param[0]['anio']."
	" . $mes . " 
	" . $iddep . "
	" . $idest . " Group by extract(year From pap.fec_atencion), d.id_dependencia, d.nom_depen,
	pap.user_create_at, p.primer_ape, p.segundo_ape, p.segundo_ape, p.nombre_rs";
    $this->sql .= $sOrder . $sLimit;
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datosPAPAlertaInicial($idDep) {
    $this->db->getConnection();
    $aparam = array($idDep,$idDep);
    $this->sql = "Select 
(Select count(1) cntfi From tbl_papenvio Where estado=4 And id_dependencia=$1 And (select extract(days from (CURRENT_TIMESTAMP - create_finalize_at))) <= 7) cntfi,
(Select count(1) cntpo From tbl_papsoli p Inner Join tbl_papresul pr On p.id_papsoli=pr.id_papsoli Where id_dependencia=$2 And p.estado=3 And id_estadoresul=3 And id_tipsatisfactoria is Not Null And negalesion=0) cntpo;";
    $this->rs = $this->db->query_params($this->sql, $aparam);
    $this->db->closeConnection();
    return $this->rs[0];
  }

  public function get_datosExisteIdLabSinResultadoPorNroRegistroLab($nro, $anio) {
    $this->db->getConnection();
    $this->sql = "Select id_papsoli, nro_reglab, substring(extract(year from create_reglab_at)::Varchar, 3) anio_reglab From tbl_papsoli Where nro_reglab=" . $nro . " And substring(extract(year from create_reglab_at)::Varchar, 3)='" . $anio . "';";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_datoEstadoEnvioDetPorIdSoli($idSolicitud) {
    $this->db->getConnection();
    $this->sql = "Select estado id_estado_detenv From tbl_papenviodet where id_papsoli=" . $idSolicitud . " and estado<>0;";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }

  public function get_repDatosPAPNoficacion($param) {
    $this->db->getConnection();
    $this->sql = "Select tdp.abreviatura abrev_tipodoc, p.nrodoc, Case When p.primer_ape isNull Then '' Else p.primer_ape End||' '||Case When p.segundo_ape isNull Then '' Else p.segundo_ape End ||' '||p.nombre_rs nombre_pac,
(Select nro_hc From tbl_historialhc Where id_persona=p.id_persona And id_dependencia=s.id_dependencia) nro_hc, date_part('year',age(s.fec_atencion, p.fec_nac)) edad_pac,
ema.email, telf.nro_telefono telf_fijo, telm.nro_telefono telf_movil, ub.departamento, ub.provincia, ub.distrito, descrip_dir, descrip_ref,
to_char(s.fec_atencion, 'DD/MM/YYYY') fec_atencion, Case When up.primer_ape isNull Then '' Else up.primer_ape End||' '||Case When up.segundo_ape isNull Then '' Else up.segundo_ape End ||' '||up.nombre_rs nombre_rsprof,
to_char(s.create_notif, 'DD/MM/YYYY') fec_entrega,
Case When s.estado = 3 Then 'FINALIZADO' Else 'ENTRAEGADO A PAC.' End nomestado From tbl_papsoli s
Inner Join tbl_persona p On s.id_paciente= p.id_persona
Inner Join tbl_tipodoc tdp On p.id_tipodoc = tdp.id_tipodoc
Inner Join tbl_usuario u On s.user_create_at = u.id_usuario
Inner Join tbl_persona up On u.id_persona = up.id_persona
Left Join tbl_historialtelefono telf On s.id_telffijopac = telf.id_histotelefono
Left Join tbl_historialtelefono telm On s.id_telfmovilpac = telm.id_histotelefono
Left Join tbl_historialemail ema On s.id_emailpac = ema.id_histoemail
Left Join tbl_historialdireccion dir On s.id_direccionpac = dir.id_histodireccion
Left Join tbl_ubigeo2019 ub On dir.id_ubigeo = ub.id_ubigeo
Where s.estado in (3,4) And id_dependencia=" . $param[0]['iddep'] . " And extract(year From s.fec_atencion)=" . $param[0]['anio'];
	if (isset($param[0]['id_resultado'])) {
      if (!empty($param[0]['id_resultado'])) {
        $this->sql .= " And s.estado=" . $param[0]['id_resultado'] . "";
      }
	}

$this->sql .= " Order By p.nrodoc";
    $this->rs = $this->db->query($this->sql);
    $this->db->closeConnection();
    return $this->rs;
  }
}
