<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Ubigeo.php';
$ub = new Ubigeo();

if(isset($_GET['id'])){
	require_once '../../model/ITS.php';
	$ate = new ITS();
	$rs = $ate->get_datos_itssifilis(0,$_GET['id']);
	$rsJS = json_encode($rs);
	//print_r($rs);
	//echo $rsJS;
}

?>
<style>
body{
	font-size: 13px;
}
</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title text-center"><strong>REGISTRO DE ATENCIÓN SIFILIS MATERNA</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmSolicitud" id="frmSolicitud">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="0"/>
        <input type="hidden" name="txtIdPac" id="txtIdPac" value="0"/>
        <input type="hidden" name="txtIdNino" id="txtIdNino" value="0"/>
		<input type="hidden" name="txtIdNino" id="txtIdNino2" value="0"/>
		<input type="hidden" name="txtIdNino" id="txtIdNino3" value="0"/>
          <?php include "reg_datos_paciente.php"; ?>
		  <?php include "reg_datos_atencion.php"; ?>
		<div id="div-datos-atencion" style="display: none;">
			<div class="row">
			  <div class="col-sm-7">
				<div class="panel panel-info" style="padding-bottom: 0px; margin-bottom: 10px;">
				  <div class="panel-heading">
					<h3 class="panel-title"><strong>DIAGNÓSTICO / LABORATORIO</strong></h3>
				  </div>
				  <div class="panel-body" style="padding-bottom: 0px;">
								  <br/>
				<div class="row">
				  <div class="col-sm-6">
				  <?php include "reg_datos_momento_diagnostico.php"; ?>
				  </div>
				  <div class="col-md-6">
					<div class="panel panel-info" style="padding-bottom: 0px;">
					  <div class="panel-heading">
						<h3 class="panel-title"><strong>Laboratorio</strong></h3>
					  </div>
					  <div class="panel-body" style="padding-bottom: 0px; padding-top: 5px;">
					  
					  
					  <div class="panel panel-info" style="padding-bottom: 0px;">
					  <div class="panel-heading">
						<h3 class="panel-title"><strong>Prueba Treponémica</strong></h3>
					  </div>
					  <div class="panel-body" style="padding-bottom: 0px; padding-top: 5px;">
					  
						<div class="form-group">
						  <div class="row">
							<div class="col-md-7" style="padding-left: 5px;">
							  <label for="txtFechaPruRapLab" class="control-label">Fecha de prueba rápida:</label>
							  <input type="text" name="txtFechaPruRapLab" id="txtFechaPruRapLab" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtFechaTPHA', event);" disabled/>
							</div>
						  </div>
						</div>
						<div class="form-group">
						  <div class="row">
							<div class="col-md-12" style="padding-left: 5px;">
							  <label for="txt_fectpha" class="control-label">Fecha TPHA, TPPA, FTA Abs o ELISA:</label>
							  <input type="text" name="txt_fectpha" id="txt_fectpha" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtFechaDLS1', event);" disabled/>
							</div>
						  </div>
						</div>
						
						</div>
						</div>
						
					  <div class="panel panel-info" style="padding-bottom: 0px;">
					  <div class="panel-heading">
						<h3 class="panel-title"><strong>Prueba No Treponémica</strong></h3>
					  </div>
					  <div class="panel-body" style="padding-bottom: 0px; padding-top: 5px;">
						
						<div class="form-group">
						  <div class="row">
							<div class="col-sm-7" style="padding-left: 5px;">
							  <label for="txtFechaDLS1" class="control-label">Fecha RPR o VDRL 1:</label>
							  <div class="input-group">
								<input type="text" name="txtFechaDLS1" id="txtFechaDLS1" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtNroDLS2', event);" disabled/>
								<span class="input-group-addon my-addon">
								  <input type="checkbox" class="check_lab" name="txtAsisFechaDLS" id="txtAsisFechaDLS1" value="1" disabled>
								</span>
							  </div>
							</div>
							<div class="col-sm-5" style="padding-left: 5px; padding-right: 5px;">
							  <label for="txtNroDLS1" class="control-label">N° Diluciones:</label>
							  <input type="text" name="txtNroDLS1" id="txtNroDLS1" class="form-control" maxlength="4" value="" onkeydown="campoSiguiente('txtFechaDLS1', event);" disabled/>
							</div>
						  </div>
						</div>
						<div class="form-group">
						  <div class="row">
							<div class="col-sm-7" style="padding-left: 5px;">
							  <label for="txtFechaDLS2" class="control-label">Fecha RPR o VDRL 2:</label>
							  <div class="input-group">
								<input type="text" name="txtFechaDLS2" id="txtFechaDLS2" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtNroDLS3', event);" disabled/>
								<span class="input-group-addon my-addon">
								  <input type="checkbox" class="check_lab" name="txtAsisFechaDLS" id="txtAsisFechaDLS2" value="2" disabled>
								</span>
							  </div>
							</div>
							<div class="col-sm-5" style="padding-left: 5px; padding-right: 5px;">
							  <label for="txtNroDLS2" class="control-label">N° Diluciones:</label>
							  <input type="text" name="txtNroDLS2" id="txtNroDLS2" class="form-control" maxlength="4" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtFechaDLS2', event);" disabled/>
							</div>
						  </div>
						</div>
						<div class="form-group">
						  <div class="row">
							<div class="col-sm-7" style="padding-left: 5px;">
							  <label for="txtFechaDLS3" class="control-label">Fecha RPR o VDRL 3:</label>
							  <div class="input-group">
								<input type="text" name="txtFechaDLS3" id="txtFechaDLS3" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask disabled/>
								<span class="input-group-addon my-addon">
								  <input type="checkbox" class="check_lab" name="txtAsisFechaDLS" id="txtAsisFechaDLS3" value="3" disabled>
								</span>
							  </div>
							</div>
							<div class="col-sm-5" style="padding-left: 5px; padding-right: 5px;">
							  <label for="txtNroDLS3" class="control-label">N° Diluciones:</label>
							  <input type="text" name="txtNroDLS3" id="txtNroDLS3" class="form-control" maxlength="4" value="" onfocus="this.select()" disabled/>
							</div>
						  </div>
						</div>
						
						</div>
						</div>
						
					  </div>
					</div>
					</div>
				  </div>
				</div>
				<br/>
				</div>
			  </div>
			  <div class="col-sm-5">
				<div class="panel panel-info">
				  <div class="panel-heading">
					<h3 class="panel-title"><strong>MANEJO DE LA SIFILIS MATERNA</strong></h3>
				  </div>
				  <div class="panel-body" style="padding-bottom: 5px; padding-top: 2px;">
					<div class="form-group">
						<b>¿ES ALERGICA A LA PENICILINA?: </b><br/>
						<label class="radio-inline"><input type="radio" class="opt_alergicopene" name="txt_alergicopene" id="txt_alergicopene1" value="1" disabled/><b>SI</b></label>
						<label class="radio-inline"><input type="radio" class="opt_alergicopene" name="txt_alergicopene" id="txt_alergicopene0" value="0" checked disabled/><b>NO</b></label>
					</div>
						<div id="datos-si-alergica" style="display: none;">
						<div class="panel panel-info">
						  <div class="panel-heading">
							<h3 class="panel-title"><strong>Alergia a la PENICILINA</strong></h3>
						  </div>
						  <div class="panel-body" style="padding-bottom: 5px; padding-top: 2px;">
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6">
										<label for="txtFechaPruSensi" class="control-label">Prueba de sensibilidad:</label>
										<input type="text" name="txtFechaPruSensi" id="txtFechaPruSensi" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtFechaDesensi', event);" disabled/>
										<span class="help-block">(Fecha)</span>
									</div>
									<div class="col-sm-6">
										<label for="txtFechaDesensi" class="control-label">Desensibilización:</label>
										<input type="text" name="txtFechaDesensi" id="txtFechaDesensi" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask disabled/>								
										<span class="help-block">(Fecha)</span>
									</div>
								</div>
							</div>
							<div class="form-group">
							  <label>¿Referida?</label>
							  <label class="radio-inline"><input type="radio" class="opt_pruebarefere" name="txtPruebaSenciRefe" id="txtPruebaSenciRefe1" value="1" disabled/>Si</label>
							  <label class="radio-inline"><input type="radio" class="opt_pruebarefere" name="txtPruebaSenciRefe" id="txtPruebaSenciRefe0" value="0" checked disabled/>No</label>
							</div>
							<div class="form-group">
								<b>Tratamiento final: </b>
								<label class="radio-inline"><input type="radio" class="opt_alergicopenetrata" name="txt_alergicopenetrata" id="txt_alergicopenetrata1" value="1"/><b>PENICILINA</b></label>
								<label class="radio-inline"><input type="radio" class="opt_alergicopenetrata" name="txt_alergicopenetrata" id="txt_alergicopenetrata0" value="0"/><b>OTROS</b></label>
							</div>
							<div id="datos-alergia-sifilis-tratamientopenecilina" style="display: none;">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="txt_fec_1radosis_hosp" class="control-label">Fec. 1ra Dosis:</label>
										<div class="input-group">
											<input type="text" name="txt_fec_1radosis_hosp" id="txt_fec_1radosis_hosp" placeholder="DD/MM/AAAA" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txt_fec_2dadosis_hosp', event);"/>
											<span class="input-group-addon my-addon" style="padding-right: 5px; padding-left: 5px;">
											<input type="checkbox" class="check_dosistratapene_hosp" name="txt_asis_dosistratapene_hosp" id="txt_asis_dosistratapene_hosp1" value="1">
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="txt_fec_2dadosis_hosp" class="control-label">Fec. 2da Dosis:</label>
										<div class="input-group">
											<input type="text" name="txt_fec_2dadosis_hosp" id="txt_fec_2dadosis_hosp" placeholder="DD/MM/AAAA" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txt_fec_3radosis_hosp', event);"/>
											<span class="input-group-addon my-addon" style="padding-right: 5px; padding-left: 5px;">
											<input type="checkbox" class="check_dosistratapene_hosp" name="txt_asis_dosistratapene_hosp" id="txt_asis_dosistratapene_hosp2" value="1">
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="txt_fec_3radosis_hosp" class="control-label">Fec. 3ra Dosis:</label>
										<div class="input-group">
											<input type="text" name="txt_fec_3radosis_hosp" id="txt_fec_3radosis_hosp" placeholder="DD/MM/AAAA" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d"/>
											<span class="input-group-addon my-addon" style="padding-right: 5px; padding-left: 5px;">
											<input type="checkbox" class="check_dosistratapene_hosp" name="txt_asis_dosistratapene_hosp" id="txt_asis_dosistratapene_hosp3" value="1">
											</span>
										</div>
									</div>
								</div>
							</div>
					</div>
					<div id="datos-alergia-sifilis-tratamientootro" style="display: none;">
							<div class="form-group">
							  <label for="txtDetOtroTrata" class="control-label">Especifique tratamiento:</label>
							  <input type="text" name="txtDetOtroTrata" id="txtDetOtroTrata" class="form-control" maxlength="75" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtGest', event);"/>
							</div>
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
									<label for="txt_fec_iniotradosis_hosp" class="control-label">Fec. inicio dosis:</label>
									<input type="text" name="txt_fec_iniotradosis_hosp" id="txt_fec_iniotradosis_hosp" onfocus="this.select()" placeholder="DD/MM/AAAA" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d"/>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
									<label for="txt_total_otrodosis_hosp" class="control-label">Total dosis aplicadas:</label>
									<input type="text" name="txt_total_otrodosis_hosp" id="txt_total_otrodosis_hosp" onfocus="this.select()" placeholder="#" class="form-control text-uppercase" maxlength="2" value=""/>
									</div>
								</div>
							</div>
					</div>
						  </div>
						</div>
						</div>
						<div id="datos-no-alergica">
							<div class="panel panel-info" style="margin-bottom: 5px;">
							  <div class="panel-heading">
								<h3 class="panel-title"><strong>Tratamiento con PENICILINA</strong></h3>
							  </div>
							  <div class="panel-body" style="padding-bottom: 5px; padding-top: 2px;">
								<div class="form-group">
								  <label for="txtFechaDosisPac1" class="control-label">Fecha 1ra dosis:</label>
								  <div class="input-group">
									<input type="text" name="txtFechaDosisPac1" id="txtFechaDosisPac1" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtFechaDosisPac2', event);" disabled/>
									<span class="input-group-addon my-addon">
									  <input type="checkbox" class="check_dosispac" name="txtAsisDosisPac" id="txtAsisDosisPac1" value="1" disabled>
									</span>
								  </div>
								</div>
								<div class="form-group">
								  <label for="txtFechaDosisPac2" class="control-label">Fecha 2da dosis:</label>
								  <div class="input-group">
									<input type="text" name="txtFechaDosisPac2" id="txtFechaDosisPac2" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtFechaDosisPac3', event);" disabled/>
									<span class="input-group-addon my-addon">
									  <input type="checkbox" class="check_dosispac" name="txtAsisDosisPac" id="txtAsisDosisPac2" value="2" disabled>
									</span>
								  </div>
								</div>
								<div class="form-group">
								  <label for="txtFechaDosisPac3" class="control-label">Fecha 3ra dosis:</label>
								  <div class="input-group">
									<input type="text" name="txtFechaDosisPac3" id="txtFechaDosisPac3" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask disabled/>
									<span class="input-group-addon my-addon">
									  <input type="checkbox" class="check_dosispac" name="txtAsisDosisPac" id="txtAsisDosisPac3" value="3" disabled>
									</span>
								  </div>
								</div>
							  </div>
							</div>
						</div>
						
							<div class="panel panel-info" style="margin-bottom: 5px;">
							  <div class="panel-heading">
								<h3 class="panel-title"><strong>TRATAMIENTO ADECUADO</strong></h3>
							  </div>
							  <div class="panel-body" style="padding-bottom: 5px; padding-top: 2px;">
								<div class="radio" style="margin-top: 2px;">
								  <label><input type="radio" class="opt_trataadecuado" name="txt_trataadecuado" id="txt_trataadecuado1" value="1"><b> Si</b></label>
								</div>
								<div class="radio" style="margin-top: 2px;">
								  <label><input type="radio" class="opt_trataadecuado" name="txt_trataadecuado" id="txt_trataadecuado2" value="2"><b> No</b></label>
								</div>
								<div class="row" style="display:none;" id="div_trataadeciadono">
									<div class="col-sm-1">
									&nbsp;
									</div>
									<div class="col-sm-11">
										<div class="radio" style="margin-top: 0px;">
										  <label><input type="radio" class="opt_notrataadecuado" name="txt_notrataadecuado" id="txt_notrataadecuado1" value="1">Tratamiento sin penicilina</label>
										</div>
										<div class="radio">
										  <label><input type="radio" class="opt_notrataadecuado" name="txt_notrataadecuado" id="txt_notrataadecuado2" value="2">Tratamiento durante los 30 días previos al parto.</label>
										</div>
										<div class="radio">
										  <label><input type="radio" class="opt_notrataadecuado" name="txt_notrataadecuado" id="txt_notrataadecuado3" value="3">No inició tratamiento durante la gestación</label>
										</div>
										<div class="radio">
										  <label><input type="radio" class="opt_notrataadecuado" name="txt_notrataadecuado" id="txt_notrataadecuado4" value="4">Tratamiento incompleto (1 ó 2 dosis)</label>
										</div>
									</div>
								</div>

								<div class="radio" style="margin-top: 2px;">
								  <label><input type="radio" class="opt_trataadecuado" name="txt_trataadecuado" id="txt_trataadecuado3" value="3"><b> Desconocido</b></label>
								</div>
								
							  </div>
							</div>
						
						
							<div class="panel panel-info" style="margin-bottom: 5px;">
							  <div class="panel-heading">
								<h3 class="panel-title"><strong>Contacto(s) sexual(es) tratado(s)</strong></h3>
							  </div>
							  <div class="panel-body" style="padding-bottom: 5px; padding-top: 2px;">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="txt_nro_contacto_1" class="control-label">Sí:</label>
											<div class="input-group">
												<input type="text" name="txt_nro_contacto_1" id="txt_nro_contacto_1" onfocus="this.select()" class="form-control text-uppercase" maxlength="2" value="0" onkeydown="campoSiguiente('txt_nro_contacto_2', event);" disabled/>
												<span class="input-group-addon my-addon" style="padding-right: 5px; padding-left: 5px;">
													<input type="checkbox" class="check_nro_contacto_1" name="check_nro_contacto_1" id="check_nro_contacto_1" value="1">
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="txt_nro_contacto_2" class="control-label">No:</label>
											<div class="input-group">
												<input type="text" name="txt_nro_contacto_2" id="txt_nro_contacto_2" onfocus="this.select()" class="form-control text-uppercase" maxlength="2" value="0" onkeydown="campoSiguiente('txt_nro_contacto_0', event);" disabled/>
												<span class="input-group-addon my-addon" style="padding-right: 5px; padding-left: 5px;">
													<input type="checkbox" class="check_nro_contacto_2" name="check_nro_contacto_2" id="check_nro_contacto_2" value="1">
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="txt_nro_contacto_0" class="control-label">Desconocido:</label>
											<div class="input-group">
												<input type="text" name="txt_nro_contacto_0" id="txt_nro_contacto_0" onfocus="this.select()" class="form-control text-uppercase" maxlength="2" value="0" disabled/>
												<span class="input-group-addon my-addon" style="padding-right: 5px; padding-left: 5px;">
													<input type="checkbox" class="check_nro_contacto_0" name="check_nro_contacto_0" id="check_nro_contacto_0" value="0">
												</span>
											</div>
										</div>
									</div>
								</div>
							  </div>
							</div>
				  </div>
				</div>
			  </div>
			</div>
			
			<div class="panel panel-info" style="margin-bottom: 5px;">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>CLASIFICACIÓN DE CASO SÍFILIS EN LA GESTANTE</strong></h3>
				</div>
				<div class="panel-body" style="padding-bottom: 5px; padding-top: 2px;">
					<div class="radio">
						<label><input type="radio" class="opt_clasigestante" name="txt_clasigestante" id="txt_clasigestante1" value="1" checked><b> Probable</b></label>
					</div>
					<div class="radio">
						<label><input type="radio" class="opt_clasigestante" name="txt_clasigestante" id="txt_clasigestante2" value="2" checked><b> Confirmado</b></label>
					</div>
					<div class="radio">
						<label><input type="radio" class="opt_clasigestante" name="txt_clasigestante" id="txt_clasigestante3" value="3" checked><b> Descartado (Falso Positivo)</b></label>
					</div>
					<div class="radio">
						<label><input type="radio" class="opt_clasigestante" name="txt_clasigestante" id="txt_clasigestante4" value="4" checked><b> Descartado (Sífilis de Memoria)</b></label>
					</div>
				</div>
			</div>
			<br/>  
		<div>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#obsmadre" aria-controls="obsmadre" role="tab" data-toggle="tab"><b>OBSERVACIONES DE LA MADRE / CULMINACION DEL EMBARAZO</b></a></li>
				<li role="presentation"><a href="#referencia" aria-controls="referencia" role="tab" data-toggle="tab"><b>REFERENCIAS A OTRO ESTABLECIMIENTO</b></a></li>
				<li role="presentation"><a href="#seguimiento" aria-controls="seguimiento" role="tab" data-toggle="tab"><b>SEGUIMIENTOS</b></a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="obsmadre">
					<br/>
					<?php include "reg_datos_observacion_madre.php"; ?>
				</div>
				<div role="tabpanel" class="tab-pane" id="referencia">
					<br/>
					<?php include "reg_datos_referencias.php"; ?>
				</div>
				<div role="tabpanel" class="tab-pane" id="seguimiento">
					<br/>
					<?php include "reg_datos_seguimiento_visita.php"; ?>
				</div>
			</div>
		</div>
	   </div>
		<div>
		<div id="div-datos-menor" style="display: none;">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><b>DATOS DEL MENOR 1</b></a></li>
				<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><b>DATOS DEL MENOR 2</b></a></li>
				<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><b>DATOS DEL MENOR 3</b></a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="home">
					<br/>
					<?php include "reg_datos_menor_1_sifilis.php"; ?>
				</div>
				<div role="tabpanel" class="tab-pane" id="profile">
					<br/>
					<?php include "reg_datos_menor_2_sifilis.php"; ?>
				</div>
				<div role="tabpanel" class="tab-pane" id="messages">
				<br/>
					<?php include "reg_datos_menor_3_sifilis.php"; ?>
				</div>
			</div>
		</div>
		</div>
    </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div id="saveSolicitud">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="save_atencion()"><i class="fa fa-save"></i> Guardar Atención</button>
                <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="fa fa-times"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
<?php require_once '../include/footer.php'; ?>
<script type="text/javascript" src="its.js"></script>
<script type="text/javascript" src="menor.js"></script>
<script type="text/javascript" src="sifilis.js"></script>
<script Language="JavaScript">

<?php
	if(isset($_GET['id'])){
?>
		var atencion = <?php echo $rsJS;?>;
<?php
	}
?>

$(document).ready(function() {

$('#txtIdPaisNacPac, #txtIdEtniaPac, #txtIdDepPac, #txtUBIGEOPac, #txtIdParenSoli, #txtIdDepRef, #txtIdDepNacNi').select2();

$('#txtEGCPN').select2();
$('#txtEGNi').select2();
$('#txtNroDLS1').inputmask("1/99");
$('#txtNroDLS2').inputmask("1/99");
$('#txtNroDLS3').inputmask("1/99");
$('#txtNroDLSNi1').inputmask("1/99");
$('#txtNroDLSNi2').inputmask("1/99");
$('#txtNroDLSNi21').inputmask("1/99");
$('#txtNroDLSNi22').inputmask("1/99");
$('#txtNroDLSNi31').inputmask("1/99");
$('#txtNroDLSNi32').inputmask("1/99");

$("#txtFecNacPac").focusout(function () {
  fecha_fin = '<?php echo date("d/m/Y")?>';//$("#txtFecNacPac").val();
  fecha_ini = $(this).val();
  if(fecha_ini != ""){
    $.post("../../controller/ctrlTipo.php", { fecha_ini: fecha_ini, fecha_fin: fecha_fin, accion: "GET_FUNC_CALCULAEDAD" }, function(data){
      var datos = eval(data);
      $("#txtEdadPac").val(datos[0]);
    });
  } else {
    //setTimeout(function(){$('#txtFecNacPac').trigger('focus');}, 2);
  }
});

/*
$("#txtFechaDLS1").focusout(function () {
  fecha_lab('1');
});
$("#txtFechaDLS2").focusout(function () {
  fecha_lab('2');
});
$("#txtFechaDLS3").focusout(function () {
  fecha_lab('3');
});

$("#txtFechaDosisPac1").focusout(function () {
  fecha_trata('1');
});
$("#txtFechaDosisPac2").focusout(function () {
  //fecha_trata('2');
});
$("#txtFechaDosisPac3").focusout(function () {
  //fecha_trata('3');
});
*/


});
</script>
<?php
	if(isset($_GET['id'])){
?>
		<script type="text/javascript" src="sifilis_edit.js"></script>
<?php
	}
?>
<?php require_once '../include/masterfooter.php'; ?>
