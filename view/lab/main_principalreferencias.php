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
require_once '../../model/Profesional.php';
$prof = new Profesional();
?>
<style>

td.details-control {
  background: url('../../assets/images/details_open.png') no-repeat center center;
  cursor: pointer;
}
tr.shown td.details-control {
  background: url('../../assets/images/details_close.png') no-repeat center center;
}

.table.dataTable tbody tr.active:hover td, .table.dataTable tbody tr.active:hover th {
  background-color: #a7a7a7 !important;
}

.table.dataTable tbody tr.active td, .table.dataTable tbody tr.active th {
  background-color: #cecece;
  color: #333;
}

</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
		<div class="row">
			<div class="col-sm-6">
				<h3 class="panel-title"><strong>REGISTRO DE FUA Y/O DATOS DE CONTRAREFERENCIA</strong></h3>
			</div>
			<div class="col-sm-6 text-right">
				<h3 class="panel-title"><a href="#" onclick="event.preventDefault(); open_ayuda()">Ayuda <i class="fa fa-question-circle-o" aria-hidden="true"></i></a></h3>
			</div>
		</div>
	</div>
    <div class="panel-body">
      <fieldset class="scheduler-border">
        <legend class="scheduler-border" style="margin-bottom: 5px;">Buscar atención</legend>
        <form class="form-horizontal" name="frmRepPrin" id="frmRepPrin" onsubmit="return false;">
			<input type="hidden" name="txt_id_atencion" id="txt_id_atencion" value="0"/>
			<input type="hidden" name="txt_id_fua" id="txt_id_fua" value="0"/>
          <div class="form-group">
			<div class="col-sm-2">
				<label for="txtBusNroAten">Nro Atención:</label>
				<input type="text" class="form-control input-sm" name="txtBusNroAten" id="txtBusNroAten" autocomplete="OFF" maxlength="10" value="" onkeydown="campoSiguiente('btnBus', event);"/>
				<span class="help-block">Ingresar el número seguido del guión "-" y finalmente el año: 1-2023</span>
			</div>
            <div class="col-sm-4">
              <label for="txtBusNomRS">Nombres o Apellidos del paciente:</label>
              <input class="form-control input-sm" type="text" name="txtBusNomRS" id="txtBusNomRS" autocomplete="OFF" maxlength="150" required="" tabindex="0" onkeydown="campoSiguiente('btnBus', event);">
            </div>
            <div class="col-md-2">
              <div class="row">
                <div class="col-md-12">
                  <label for="txtIdTipDoc">Documento de identidad</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="input-group input-group-sm">
                    <div class="input-group-addon" style="padding: 0!important;">
                      <?php $rsT = $t->get_ListaTipoDocPerNatu(); ?>
                      <select name="txtvIdTipDoc" style="width:100%;" id="txtBusIdTipDoc" onchange="maxlength_doc_bus()">
                        <?php
                        foreach ($rsT as $row) {
                          echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <input type="text" name="txtBusNroDoc" placeholder="Número de documento" required="" id="txtBusNroDoc" class="form-control input-sm" maxlength="8" onkeydown="campoSiguiente('btnBus', event);"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-1 col-md-1">
              <br/>
              <button class="btn btn-success btn-sm btn-block" type="button" id="btnBus" onclick="buscar_datos();" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar</button>
            </div>
            <!--<div class="col-sm-4 col-md-4">
            <br/>
            <button id="btnRegistrarAsis" class="btn btn-warning btn-sm" type="button" onclick="exportar_busqueda();" tabindex="0"><i class="glyphicon glyphicon-open"></i> Exportar a Excel</button>
          </div>-->
        </div>
      </form>
    </fieldset>
	<br/>
    <table id="tblAtencion" class="display" cellspacing="0" width="100%">
      <thead class="bg-aqua">
        <tr>
          <th></th>
          <th>N° Atención</th>
          <th>Tipo<br/>Atención</th>
          <th>Nombre de Paciente</th>
          <th>Documento<br/>Identidad</th>
          <th>HC</th>
          <th>Fecha<br/>Registro</th>
          <th>Estado<br/>Atención</th>
          <th>Estado<br/>Resultado</th>
          <th style="width: 55px;"><i class="fa fa-cogs"></i></th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
 </div>
</div>


<div class="modal fade" id="modal_reg_fua" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h2 class="modal-title">REGISTRO DATOS FUA</h2>
		</div>
		<div class="modal-body">
			<form id="frmFUA" name="frmFUA" class="form-horizontal">
				<div class="row">
					<div class="col-sm-9">
						<div class="form-group">
							<div class="col-md-6">
								<small><label for="txt_fua_ape_pac">Apellidos:</label></small>
								<input type="text" name="txt_fua_ape_pac" id="txt_fua_ape_pac" class="form-control input-sm" value="" disabled/>
							</div>
							<div class="col-md-3">
								<small><label for="txt_fua_primer_nom">Primer nombre <span class="text-danger">(*)</span>:</label></small>
								<input type="text" name="txt_fua_primer_nom" id="txt_fua_primer_nom" class="form-control input-sm" maxlength="100" onkeydown="campoSiguiente('txt_fua_otro_nom', event);" value=""/>
							</div>
							<div class="col-md-3">
								<small><label for="txt_fua_otro_nom">Otro nombre:</label></small>
								<input type="text" name="txt_fua_otro_nom" id="txt_fua_otro_nom" class="form-control input-sm" maxlength="100" onkeydown="campoSiguiente('txt_fua_cod_diresa', event);" value="" value=""/>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3">
								<small><label for="txt_fua_cod_diresa">DIRESA<span class="text-danger">(*)</span>:</label></small>
								<input type="text" name="txt_fua_cod_diresa" id="txt_fua_cod_diresa" class="form-control input-sm" maxlength="15" onkeydown="campoSiguiente('txt_fua_nro', event);" value=""/>
							</div>
							<div class="col-md-6">
								<small><label for="txt_fua_nro">Nro. FUA <span class="text-danger">(*)</span>:</label></small>
								<input type="text" name="txt_fua_nro" id="txt_fua_nro" class="form-control input-sm" maxlength="20" onkeydown="campoSiguiente('txt_fua_anio', event);" value=""/>
							</div>
							<div class="col-md-3">
								<small><label for="txt_fua_anio">Año FUA <span class="text-danger">(*)</span>:</label></small>
								<input type="text" name="txt_fua_anio" id="txt_fua_anio" class="form-control input-sm" maxlength="4" value=""/>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-3">
							<small><label for="txt_id_tipo_sis">Tipo de Seguro <span class="text-danger">(*)</span>:</label></small>
							<select class="form-control input-sm" name="txt_id_tipo_sis" id="txt_id_tipo_sis"><!-- onchange="change_codis()">-->
							  <option value="">Seleccione</option>
							  <option value="2">2: Documento Nacional de Identidad-DNI</option>
							  <option value="3">3: Carnet de extrangería-CE</option>
							  <option value="E">E: Afiliación temporal</option>
							  <option value="9">9: SIS independiente</option>
							  <option value="8">8: Microempresas</option>
							  <option value="R">R: NRUS</option>
							  <option value="N">N: No es paciente SIS</option>
							</select>
						  </div>
						  <div class="col-md-3">
							  <small><label for="txt_nro_sis">Número SIS <span class="text-danger">(*)</span>:</label></small>
							  <input type="text" name="txt_nro_sis" id="txt_nro_sis" class="form-control input-sm" maxlength="25" onkeydown="campoSiguiente('txtNroFUA', event);" value=""/>
						  </div>
						  <div class="col-md-3">
							<small><label for="txt_fua_id_cod_prestacional">Cod. Prestacional <span class="text-danger">(*)</span>:</label></small>
							<?php $rsCPR = $t->get_listaCodPrestacional(1); ?>
							<select class="form-control input-sm" name="txt_fua_id_cod_prestacional" id="txt_fua_id_cod_prestacional">
							  <option value="">Seleccione</option>
								  <?php
								  foreach ($rsCPR as $row) {
									echo "<option value='" . $row['id'] . "'"; if($row['codigo_referencial'] == "071") echo " selected"; echo ">" . $row['codigo_referencial'] . " - " . $row['nombre'] . "</option>";
								  }
								  ?>
							</select>
						  </div>
						  <div class="col-md-3">
							<small><label for="txt_fua_id_cie">CIE 10 <span class="text-danger">(*)</span>:</label></small>
							<select class="form-control input-sm" name="txt_fua_id_cie" id="txt_fua_id_cie">
							  <option value="Z017">Z017 - EXAMEN DE LABORATORIO</option>

							</select>
						  </div>
						</div>
						<div class="form-group">
							<div class="col-sm-3">
								<div class="checkbox">
								<small><label><input type="checkbox" name="txt_fua_chk_gestante" id="txt_fua_chk_gestante" value="1"> ¿Es<br/>gestante?</label></small>
								</div>
							</div>
							<div class="col-sm-3">
								<small><label for="txt_fua_edad_gest">Edad Gest.:</label></small>
								<input type="text" name="txt_fua_edad_gest" id="txt_fua_edad_gest" class="form-control input-sm" maxlength="2" onkeydown="campoSiguiente('txt_fua_fecha_parto', event);" disabled="">
							</div>
							<div class="col-sm-6">
								<small><label for="txt_fua_fecha_parto">Fec. Prob. de parto:</label></small>
								<div class="input-group input-group-sm">
								<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								<input type="text" name="txt_fua_fecha_parto" id="txt_fua_fecha_parto" placeholder="DD/MM/AAAA" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" data-date-end-date="0d" disabled="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label for="txt_fua_id_resp_atencion"><small>Responsable de la atención <span class="text-danger">(*)</span>:</small></label>
								<?php $rsP = $prof->get_ListaProfesionalPoridServicioAndIdDependencia($labIdDepUser, 9); ?>
								<select name="txt_fua_id_resp_atencion" id="txt_fua_id_resp_atencion" class="form-control input-sm">
								  <option value="">Todos</option>
								  <?php
								  foreach ($rsP as $row) {
									echo "<option value='" . $row['id_usuario'] . "'>" . $row['primer_ape'] . " " . $row['segundo_ape'] . " " . $row['nombre_rs'] . " (" . $row['estado_usuario'] . ")</option>";
								  }
								  ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div id="ver_btn_fua" style="display: none;">
							<button type="button" class="btn btn-warning btn-block" id="btn_fua_1" onclick="expor_fua('F')"><i class="glyphicon glyphicon-open"></i> Imprimer FUA </button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-primary btn-continuar" id="btn_save_fua_F" onclick="save_fua('F')"><i class="fa fa-save"></i> Guardar </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
            </div>
          </div>
        </div>
	</div>
	</div>
</div>

<div class="modal fade" id="modal_reg_ref" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h2 class="modal-title">REGISTRO DATOS DE CONTRAREFERENCIA</h2>
		</div>
		<div class="modal-body">
			<form id="frmFUA" name="frmFUA" class="form-horizontal">
					<div class="row">
						<div class="col-sm-9">
						<div class="form-group">
							<div class="col-md-3">
								<small><label for="txt_ref_nro_ref">Nro. Referencia<span class="text-danger">(*)</span>:</label></small>
								<input type="text" name="txt_ref_nro_ref" id="txt_ref_nro_ref" class="form-control input-sm" maxlength="15" onkeydown="campoSiguiente('txt_anio_ref', event);" value=""/>
							</div>
							<div class="col-md-3">
								<small><label for="txt_anio_ref">Año Referencia <span class="text-danger">(*)</span>:</label></small>
								<input type="text" name="txt_anio_ref" id="txt_anio_ref" class="form-control input-sm" maxlength="4" value=""/>
							</div>
							<div class="col-md-6">
								<small><label for="txt_ref_id_dep_origen">Establecimiento origen <span class="text-danger">(*)</span>:</label></small>
								<?php $rsD = $d->get_listaDepenInstitucion(); ?>
								<select name="txt_ref_id_dep_origen" id="txt_ref_id_dep_origen" style="width:100%;" class="form-control input-sm">
								  <option value="" selected>-- Seleccione --</option>
								  <?php
								  foreach ($rsD as $row) {
									echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
								  }
								  ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4">
								<small><label for="txt_nro_contraref">Nro. Contraref.<span class="text-danger">(*)</span>:</label></small>
								<input type="text" name="txt_nro_contraref" id="txt_nro_contraref" class="form-control input-sm" maxlength="15" onkeydown="campoSiguiente('txt_anio_contraref', event);" value=""/>
							</div>
							<div class="col-md-4">
								<small><label for="txt_anio_contraref">Año Contraref <span class="text-danger">(*)</span>:</label></small>
								<input type="text" name="txt_anio_contraref" id="txt_anio_contraref" class="form-control input-sm" maxlength="4" value=""/>
							</div>
							<div class="col-md-4">
								<small><label for="txt_ref_id_regimen">Régimen <span class="text-danger">(*)</span>:</label></small>
								<select class="form-control input-sm" name="txt_ref_id_regimen" id="txt_ref_id_regimen"><!-- onchange="change_codis()">-->
								  <option value="">Seleccione</option>
								  <option value="2">SUBSIDIADO</option>
								  <option value="9">INDEPENDIENTE</option>
								  <option value="R">NRUS</option>
								  <option value="N">OTROS</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="checkbox">
								<small><label><input type="checkbox" name="txt_ref_chk_fua" id="txt_ref_chk_fua" value="1"> ¿Generar FUA?</label></small>
								</div>
							</div>
						</div>
						  <fieldset class="scheduler-border">
							<legend class="scheduler-border" style="margin-bottom: 5px;">DATOS FUA</legend>
							<div class="form-group">
								<div class="col-md-6">
									<small><label for="txt_ref_ape_pac">Apellidos:</label></small>
									<input type="text" name="txt_ref_ape_pac" id="txt_ref_ape_pac" class="form-control input-sm" value="" disabled/>
								</div>
								<div class="col-md-3">
									<small><label for="txt_ref_primer_nom">Primer nombre <span class="text-danger">(*)</span>:</label></small>
									<input type="text" name="txt_ref_primer_nom" id="txt_ref_primer_nom" class="form-control input-sm" maxlength="100" onkeydown="campoSiguiente('txt_fua_otro_nom', event);" value=""/>
								</div>
								<div class="col-md-3">
									<small><label for="txt_ref_otro_nom">Otro nombre:</label></small>
									<input type="text" name="txt_ref_otro_nom" id="txt_ref_otro_nom" class="form-control input-sm" maxlength="100" onkeydown="campoSiguiente('txt_fua_cod_diresa', event);" value="" value=""/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<small><label for="txt_ref_cod_diresa">DIRESA<span class="text-danger">(*)</span>:</label></small>
									<input type="text" name="txt_ref_cod_diresa" id="txt_ref_cod_diresa" class="form-control input-sm" maxlength="15" onkeydown="campoSiguiente('txt_fua_nro', event);" value=""/>
								</div>
								<div class="col-md-6">
									<small><label for="txt_ref_nro_fua">Nro. FUA <span class="text-danger">(*)</span>:</label></small>
									<input type="text" name="txt_ref_nro_fua" id="txt_ref_nro_fua" class="form-control input-sm" maxlength="20" onkeydown="campoSiguiente('txt_fua_anio', event);" value=""/>
								</div>
								<div class="col-md-3">
									<small><label for="txt_ref_anio_fua">Año FUA <span class="text-danger">(*)</span>:</label></small>
									<input type="text" name="txt_ref_anio_fua" id="txt_ref_anio_fua" class="form-control input-sm" maxlength="4" value=""/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
								<small><label for="txt_id_tipo_sis_ref">Tipo de Seguro <span class="text-danger">(*)</span>:</label></small>
								<select class="form-control input-sm" name="txt_id_tipo_sis_ref" id="txt_id_tipo_sis_ref"><!-- onchange="change_codis()">-->
								  <option value="">Seleccione</option>
								  <option value="2">2: Documento Nacional de Identidad-DNI</option>
								  <option value="3">3: Carnet de extrangería-CE</option>
								  <option value="E">E: Afiliación temporal</option>
								  <option value="9">9: SIS independiente</option>
								  <option value="8">8: Microempresas</option>
								  <option value="R">R: NRUS</option>
								  <option value="N">N: No es paciente SIS</option>
								</select>
							  </div>
							  <div class="col-md-3">
								  <small><label for="txt_nro_sis_ref">Número SIS <span class="text-danger">(*)</span>:</label></small>
								  <input type="text" name="txt_nro_sis_ref" id="txt_nro_sis_ref" class="form-control input-sm" maxlength="25" onkeydown="campoSiguiente('txtNroFUA', event);" value=""/>
							  </div>
							  <div class="col-md-3">
								<small><label for="txt_ref_id_cod_prestacional">Cod. Prestacional <span class="text-danger">(*)</span>:</label></small>
								<?php $rsCPR = $t->get_listaCodPrestacional(1); ?>
								<select class="form-control input-sm" name="txt_ref_id_cod_prestacional" id="txt_ref_id_cod_prestacional">
								  <option value="">Seleccione</option>
									  <?php
									  foreach ($rsCPR as $row) {
										echo "<option value='" . $row['id'] . "'"; if($row['codigo_referencial'] == "071") echo " selected"; echo ">" . $row['codigo_referencial'] . " - " . $row['nombre'] . "</option>";
									  }
									  ?>
								</select>
							  </div>
							  <div class="col-md-3">
								<small><label for="txt_ref_id_cie">CIE 10 <span class="text-danger">(*)</span>:</label></small>
								<select class="form-control input-sm" name="txt_ref_id_cie" id="txt_ref_id_cie">
								  <option value="Z017">Z017 - EXAMEN DE LABORATORIO</option>
								</select>
							  </div>
							</div>
							<div class="form-group">
								<div class="col-sm-3">
									<div class="checkbox">
									<small><label><input type="checkbox" name="txt_ref_chk_gestante" id="txt_ref_chk_gestante" value="1"> ¿Es<br/>gestante?</label></small>
									</div>
								</div>
								<div class="col-sm-3">
									<small><label for="txt_ref_edad_gest">Edad Gest.:</label></small>
									<input type="text" name="txt_ref_edad_gest" id="txt_ref_edad_gest" class="form-control input-sm" maxlength="2" onkeydown="campoSiguiente('txt_fua_fecha_parto', event);" disabled="">
								</div>
								<div class="col-sm-6">
									<small><label for="txt_ref_fecha_parto">Fec. Prob. de parto:</label></small>
									<div class="input-group input-group-sm">
									<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
									<input type="text" name="txt_ref_fecha_parto" id="txt_ref_fecha_parto" placeholder="DD/MM/AAAA" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" data-date-end-date="0d" disabled="">
									</div>
								</div>
							</div>
							</fieldset>
							<div class="form-group">
								<div class="col-sm-12">
									<label for="txt_ref_id_resp_atencion"><small>Responsable de la atención <span class="text-danger">(*)</span>:</small></label>
									<?php $rsP = $prof->get_ListaProfesionalPoridServicioAndIdDependencia($labIdDepUser, 9); ?>
									<select name="txt_ref_id_resp_atencion" id="txt_ref_id_resp_atencion" class="form-control input-sm">
									  <option value="">Todos</option>
									  <?php
									  foreach ($rsP as $row) {
										echo "<option value='" . $row['id_usuario'] . "'>" . $row['primer_ape'] . " " . $row['segundo_ape'] . " " . $row['nombre_rs'] . " (" . $row['estado_usuario'] . ")</option>";
									  }
									  ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div id="ver_btn_fua_2" style="display: none;">
								<button type="button" class="btn btn-warning btn-block" id="btn_fua_2" onclick="expor_fua('2')"><i class="glyphicon glyphicon-open"></i> Imprimir FUA </button>
							</div>
							<div id="ver_btn_ref_2" style="display: none;">
							<br/>
								<button type="button" class="btn btn-success btn-block" id="btn_ref" onclick="expor_ref('1')"><i class="glyphicon glyphicon-open"></i> Imprimir<br/>CONTRAREFERENCIA </button>
							</div>
						</div>
					</div>
			</form>
		</div>
		<div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-primary btn-continuar" id="btn_save_fua_R" onclick="save_ref('R')"><i class="fa fa-save"></i> Guardar </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
            </div>
          </div>
        </div>
	</div>
	</div>
</div>

<div class="modal fade" id="mostrar_ayuda" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h2 class="modal-title">AYUDA</h2>
		</div>
		<div class="modal-body">
			<p class="text-left small" style="margin: 0 0 0px;"><b>Botones de acción</b>:<br/><img src="../../assets/images/details_open.png"/>=Mostrar examen solicitados | <button class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eject"></i></button>=Registrar o editar resultados | <button class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-check"></i></button>=Editar resultados validados | <button class="btn btn-warning btn-xs"><i class="fa fa-file-text-o"></i></button>=Imprimir Resultado</p>
			<hr/>
			<div class="row">
				<div class="col-sm-6">
					<h5><i class="fa fa-bars"></i> Colores estado atención:</h5>
					<div class="table-responsive">
					  <table class="table table-bordered table-hover">
						<thead>
						  <tr><th><small>COLOR</small></th><th><small>DESCRIPCIÓN</small></th></tr>
						</thead>
						<tbody>
							<tr><td><small>Sin color</small></td><td><small>Recibido completo</small></td></tr>
							<tr><td class="active"><small>Plomo</small></td><td><small>Muestra recibido en parte</small></td></tr>
							<tr><td class="info"><small>Celeste</small></td><td><small>Muestra recibido completo</small></td></tr>
							<tr><td class="success"><small>Verde</small></td><td><small>Resultado(s) entregado a paciente</small></td></tr>
							<tr><td class="warning"><small>Amarrillo</small></td><td><small>Muestra(s) derivada o referenciada a otro EESS</small></td></tr>
						</tbody>
					  </table>
					</div>
				</div>
				<div class="col-sm-6">
					<h5><i class="fa fa-bars"></i> Colores estado resultado:</h5>
					<div class="table-responsive">
					  <table class="table table-bordered table-hover">
						<thead>
						  <tr><th><small>COLOR</small></th><th><small>DESCRIPCIÓN</small></th></tr>
						</thead>
						<tbody>
							<tr><td><small>Sin color</small></td><td><small>Pendiente de resultado</small></td></tr>
							<tr><td class="primary"><small>Celeste</small></td><td><small>Resultado(s) validado en parte</small></td></tr>
							<tr><td class="success"><small>Verde</small></td><td><small>Resultado(s) validado completo</small></td></tr>
						</tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
		<button class="btn btn-default btn-block" type="button" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar Ventana</button>
		</div>
	</div>
	</div>
</div>

<div id="mostrar_anexos_d" class="modal fade" role="dialog" data-backdrop="static"></div>


<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">

function open_ayuda(){
  $('#mostrar_ayuda').modal();
}

function imprime_resultado(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorioprodn.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function imprime_resultado_area(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorio_area.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function imprime_resultado_unido(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorion.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function imprime_resultado_unido_check(idaten) {
	if ($('input.check_atencion_' + idaten).is(':checked')) {
	  var id_producto = [];
	  $.each($('input.check_atencion_' + idaten), function() {
		if( $('#txt_'+idaten+'_'+$(this).val()).is(':checked') ){
			id_producto.push($(this).val());
		}
	  });
	} else {
	  var id_producto = '';
	}
  var urlwindow = "pdf_laboratorion_check.php?p=&valid=" + idaten + "&pr=" + id_producto;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function print_resul(idAten, idDep, idProd, nomPac){
  $('#mostrar_anexos_d').modal('show');
  $.ajax({
    url: '../../controller/ctrlAtencion.php',
    type: 'POST',
    data: 'accion=GET_SHOW_PDFATENCION&idAten=' + idAten +'&idDep=' + idDep +'&idProd=' + idProd +'&nomPac=' + nomPac,
    success: function(data){
      $('#mostrar_anexos_d').html(data);
    }
  });
}

function open_pdf(idAten, opt) {
  if(opt == "1"){
    var urlwindow = "pdf_laboratorio.php?id_atencion=" + idAten +"&id_area=0";
  } else {
    var urlwindow = "pdf_laboratorioprod.php?id_atencion=" + idAten +"&id_prod=0";
  }
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function open_buscar(){
  $('#showBuscarModal').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });

  $('#showBuscarModal').on('shown.bs.modal', function (e) {
    $("#txtBusNroAten").trigger('focus');

  })
}

function buscar_datos() {
  var nomRS = $("#txtBusNomRS").val();
  nomRS = nomRS.replace("%", "");

  var msg = "";
  var sw = true;
/*
  if((idEstAte == "2") || (idEstAte == "")){
    if (fecIni == "") {
      msg+= "Para realizar la busqueda de Atenciones en el estado FINALIZADOS ó TODOS LOS ESTADOS, debe ingresar la Fecha de Incio y Fin.<br/>";
      sw = false;
    }
  }
*/
  if (sw == false) {
    bootbox.alert(msg);
    return false;
  }

  $("#tblAtencion").dataTable().fnDraw()
}

function campoSiguiente(campo, evento) {
  if (evento.keyCode == 13 || evento.keyCode == 9) {
    if (campo == 'btnBus') {
      buscar_datos();
    } else {
      document.getElementById(campo).focus();
      evento.preventDefault();
    }
  }
}

function reg_analisis() {
  window.location = './main_laboratorio.php';
}

$(function() {
	$('[name="txt_fua_chk_gestante"]').change(function(){
		if ($(this).is(':checked')) {
			$("#txt_fua_edad_gest").prop('disabled', false);
			$("#txt_fua_fecha_parto").prop('disabled', false);		
			setTimeout(function(){$('#txt_fua_edad_gest').trigger('focus');}, 2);
		} else {
			$("#txt_fua_edad_gest").val('');
			$("#txt_fua_fecha_parto").val('');
			$("#txt_fua_edad_gest").prop('disabled', true);
			$("#txt_fua_fecha_parto").prop('disabled', true);
		};
	});
	
});

function open_fua(idaten){
	$.ajax({
		url: "../../controller/ctrlLab.php",
		type: "POST",
		dataType: 'json',
		data: {
			accion: 'POST_SHOW_REFERENCIAANDFUAPORIDATENCION', id_atencion: idaten
		},
		success: function (registro) {
			var datos = eval(registro);
			$("#txt_id_atencion").val(datos[0]);
			$("#txt_id_fua").val(datos[1]);
			$("#txt_fua_ape_pac").val(datos[22] + " " + datos[23]);
			$("#txt_fua_cod_diresa").val(datos[18]);
			$("#txt_fua_nro").val(datos[14]);
			$("#txt_fua_anio").val(datos[15]);
			$("#txt_fua_primer_nom").val(datos[25]);
			$("#txt_fua_otro_nom").val(datos[26]);
			
			if(datos[2] == "1"){
				$("#txt_id_tipo_sis").val(datos[16]);
				$("#txt_nro_sis").val(datos[17]);
				$("#txt_fua_id_cod_prestacional").val('1');
				$("#txt_fua_id_resp_atencion").val(datos[40]);
				$('#ver_btn_fua').hide();
			} else {
				$("#txt_id_tipo_sis").val(datos[19]);
				$("#txt_nro_sis").val(datos[21]);
				$("#txt_fua_id_cod_prestacional").val(datos[35]);
				$("#txt_fua_id_resp_atencion").val(datos[41]);
				$('#ver_btn_fua').show();
			}
			if(datos[27] == "2"){
				if(datos[29] == "t"){
					$("#txt_fua_chk_gestante").prop("checked", true);
					$('#txt_fua_edad_gest').prop("disabled", false);
					$('#txt_fua_fecha_parto').prop("disabled", false);
					
				} else {
					$("#txt_fua_chk_gestante").prop("checked", false);
					$('#txt_fua_edad_gest').prop("disabled", true);
					$('#txt_fua_fecha_parto').prop("disabled", true);
				}
				$('#txt_fua_chk_gestante').prop("disabled", false);
				$("#txt_fua_edad_gest").val(datos[30]);
				$("#txt_fua_fecha_parto").val(datos[31]);
			} else {
				$("#txt_fua_chk_gestante").prop("checked", false);
				$('#txt_fua_chk_gestante').prop("disabled", true);
				$("#txt_fua_edad_gest").val('');
				$("#txt_fua_fecha_parto").val('');
			}
						
			$('#modal_reg_fua').modal({
				show: true,
				backdrop: 'static',
				focus: true,
			});
			$('#modal_reg_fua').on('shown.bs.modal', function (e) {
				setTimeout(function(){$('#txt_fua_cod_diresa').trigger('focus');}, 3);
			})
			
		}
	});
}

function open_ref(idaten){
	$.ajax({
		url: "../../controller/ctrlLab.php",
		type: "POST",
		dataType: 'json',
		data: {
			accion: 'POST_SHOW_REFERENCIAANDFUAPORIDATENCION', id_atencion: idaten
		},
		success: function (registro) {
			var datos = eval(registro);
			$("#txt_id_atencion").val(datos[0]);
			$("#txt_id_fua").val(datos[1]);
			
			$("#txt_ref_nro_ref").val(datos[6]);
			$("#txt_anio_ref").val(datos[7]);
			$("#txt_ref_id_dep_origen").val(datos[8]).trigger("change");
			$("#txt_nro_contraref").val(datos[10]);
			$("#txt_anio_contraref").val(datos[11]);
			$("#txt_ref_id_regimen").val(datos[12]);
			$('#ver_btn_ref_2').hide();
			
			$("#txt_ref_ape_pac").val(datos[22] + " " + datos[23]);
			$("#txt_ref_cod_diresa").val(datos[18]);
			$("#txt_ref_nro_fua").val(datos[14]);
			$("#txt_ref_anio_fua").val(datos[15]);
			$("#txt_ref_primer_nom").val(datos[25]);
			$("#txt_ref_otro_nom").val(datos[26]);
			
			if(datos[2] == "1"){
				$("#txt_id_tipo_sis_ref").val(datos[16]);
				$("#txt_nro_sis_ref").val(datos[17]);
				$("#txt_ref_id_cod_prestacional").val('1');
				$("#txt_ref_id_resp_atencion").val(datos[40]);
				$('#ver_btn_fua_2').hide();
				$("#txt_ref_chk_gestante").prop("checked", false);
			} else {
				$("#txt_id_tipo_sis_ref").val(datos[19]);
				$("#txt_nro_sis_ref").val(datos[21]);
				$("#txt_ref_id_cod_prestacional").val(datos[35]);
				$("#txt_ref_id_resp_atencion").val(datos[41]);
				if(datos[2] === "2" || datos[2] === "4"){
					$('#ver_btn_fua_2').show();
					if(datos[2] === "4"){
						$('#ver_btn_ref_2').show();
					}
					$("#txt_ref_chk_fua").prop("checked", true);
				}
			}
			if(datos[27] == "2"){
				if(datos[29] == "t"){
					$("#txt_ref_chk_gestante").prop("checked", true);
					$('#txt_ref_edad_gest').prop("disabled", false);
					$('#txt_ref_fecha_parto').prop("disabled", false);
					
				} else {
					$("#txt_ref_chk_gestante").prop("checked", false);
					$('#txt_ref_edad_gest').prop("disabled", true);
					$('#txt_ref_fecha_parto').prop("disabled", true);
				}
				$('#txt_ref_chk_gestante').prop("disabled", false);
				$("#txt_ref_edad_gest").val(datos[30]);
				$("#txt_ref_fecha_parto").val(datos[31]);
			} else {
				$("#txt_ref_chk_gestante").prop("checked", false);
				$('#txt_ref_chk_gestante').prop("disabled", true);
				$("#txt_ref_edad_gest").val('');
				$("#txt_ref_fecha_parto").val('');
			}
						
			$('#modal_reg_ref').modal({
				show: true,
				backdrop: 'static',
				focus: true,
			});
			$('#modal_reg_ref').on('shown.bs.modal', function (e) {
				setTimeout(function(){$('#txt_ref_nro_ref').trigger('focus');}, 3);
			})
			
		}
	});
}

function save_fua(opt){
	$('#btn_save_fua_' + opt).prop("disabled", true);
	var chk_gestante = 0;
	var txt_EdadGest = "";
	var txt_FechaParto = "";
	if ($("input[name='txt_fua_chk_gestante']").is(':checked')) {
		chk_gestante = 1;
		txt_EdadGest = $('#txt_fua_edad_gest').val();
		txt_FechaParto = $('#txt_fua_fecha_parto').val();
	}
	
	$.ajax( {
	  type: 'POST',
	  url: '../../controller/ctrlLab.php',
	  data: "id_atencion=" + $('#txt_id_atencion').val() 
	  + "&id_fua=" + $('#txt_id_fua').val() + "&fua_primer_nom=" + $('#txt_fua_primer_nom').val() + "&fua_otro_nom=" + $('#txt_fua_otro_nom').val() + "&fua_cod_diresa=" + $('#txt_fua_cod_diresa').val() + "&fua_nro=" + $('#txt_fua_nro').val() + "&fua_anio=" + $('#txt_fua_anio').val() + "&id_tipo_sis=" + $('#txt_id_tipo_sis').val() + "&nro_sis=" + $('#txt_nro_sis').val() + "&fua_id_cod_prestacional=" + $('#txt_fua_id_cod_prestacional').val() + "&fua_id_cie=" + $('#txt_fua_id_cie').val() + "&fua_chk_gestante=" + chk_gestante + "&fua_edad_gest=" + txt_EdadGest + "&fua_fecha_parto=" + txt_FechaParto
	  + "&id_resp_atencion=" + $('#txt_fua_id_resp_atencion').val() + "&accion_sp=" + opt
	  + "&accion=POST_ADD_REGREFERENCIAFUA",
	  success: function(data) {
		var tmsg = data.substring(0, 2);
		var lmsg = data.length;
		var msg = data.substring(3, lmsg);
		//console.log(tmsg);
		$('#btn_save_fua_' + opt).prop("disabled", false);
		if(tmsg == "OK"){
			$('#ver_btn_fua').show();
			showMessage("Registro guardado correctamente", "success");
			return false;
		} else {
			showMessage(msg, "error");
			return false;
		}
		
	  }
	});
}

function save_ref(opt){
	$('#btn_save_fua_' + opt).prop("disabled", true);
	var chk_gestante = 0;
	var txt_EdadGest = "";
	var txt_FechaParto = "";
	var chk_fua = 0;
	if ($("input[name='txt_ref_chk_gestante']").is(':checked')) {
		chk_gestante = 1;
		txt_EdadGest = $('#txt_ref_edad_gest').val();
		txt_FechaParto = $('#txt_ref_fecha_parto').val();
	}
	if ($("input[name='txt_ref_chk_fua']").is(':checked')) {
		chk_fua = 1;
	}
	
	$.ajax( {
	  type: 'POST',
	  url: '../../controller/ctrlLab.php',
	  data: "id_atencion=" + $('#txt_id_atencion').val() 
	  + "&nro_ref=" + $('#txt_ref_nro_ref').val() + "&anio_ref=" + $('#txt_anio_ref').val() + "&id_dep_origen=" + $('#txt_ref_id_dep_origen').val() + "&nro_contraref=" + $('#txt_nro_contraref').val() + "&anio_contraref=" + $('#txt_anio_contraref').val() + "&id_regimen=" + $('#txt_ref_id_regimen').val()
	  + "&chk_tiene_fua=" + chk_fua
	  + "&id_fua=" + $('#txt_id_fua').val() + "&fua_primer_nom=" + $('#txt_ref_primer_nom').val() + "&fua_otro_nom=" + $('#txt_ref_otro_nom').val() + "&fua_cod_diresa=" + $('#txt_ref_cod_diresa').val() + "&fua_nro=" + $('#txt_ref_nro_fua').val() + "&fua_anio=" + $('#txt_ref_anio_fua').val() + "&id_tipo_sis=" + $('#txt_id_tipo_sis_ref').val() + "&nro_sis=" + $('#txt_nro_sis_ref').val() + "&fua_id_cod_prestacional=" + $('#txt_ref_id_cod_prestacional').val() + "&fua_id_cie=" + $('#txt_ref_id_cie').val() + "&fua_chk_gestante=" + chk_gestante + "&fua_edad_gest=" + txt_EdadGest + "&fua_fecha_parto=" + txt_FechaParto
	  + "&id_resp_atencion=" + $('#txt_ref_id_resp_atencion').val() + "&accion_sp=" + opt
	  + "&accion=POST_ADD_REGREFERENCIAFUA",
	  success: function(data) {
		var tmsg = data.substring(0, 2);
		var lmsg = data.length;
		var msg = data.substring(3, lmsg);
		//console.log(tmsg);
		$('#btn_save_fua_' + opt).prop("disabled", false);
		if(tmsg == "OK"){
			$('#ver_btn_ref_2').show();
			if ($("input[name='txt_ref_chk_fua']").is(':checked')) {
				$('#ver_btn_fua_2').show();
			}
			showMessage("Registro guardado correctamente", "success");
			return false;
		} else {
			showMessage(msg, "error");
			return false;
		}
		
	  }
	});
}

function expor_fua(opt) {
	var urlwindow = "pdf_lab_fua.php?id_atencion=" + $('#txt_id_atencion').val() +"&opt=" + opt;
	day = new Date();
	id = day.getTime();
	Xpos = (screen.width / 2) - 390;
	Ypos = (screen.height / 2) - 300;
	eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function expor_ref(opt) {
	var urlwindow = "pdf_lab_contraref.php?id_atencion=" + $('#txt_id_atencion').val() +"&opt=" + opt;
	day = new Date();
	id = day.getTime();
	Xpos = (screen.width / 2) - 390;
	Ypos = (screen.height / 2) - 300;
	eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}


function back() {
  window.location = '../pages/';
}

var dTable;
//var id_dep= document.getElementById('cboiddep').value;
// #areas-grid adalah id pada table
$(document).ready(function () {
  $("#txtBusIdTipDoc").select2();
  $("#txt_ref_id_dep_origen").select2();

  $("#txtBusFecIni").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });
  $("#txtBusFecFin").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });

  dTable = $('#tblAtencion').DataTable({
    "lengthMenu": [[25, 50, 100 ,250], [25, 50, 100 ,250]],
    "bLengthChange": true,
    "bProcessing": true,
    "bServerSide": true,
    "bJQueryUI": false,
    "responsive": true,
    "bInfo": true,
    "bFilter": false,
    "sAjaxSource": "tbl_principalreferencias.php", // Load Data
    "language": {
      "url": "../../assets/plugins/datatables/Spanish.json",
      "lengthMenu": '_MENU_ entries per page',
      "search": '<i class="fa fa-search"></i>',
      "paginate": {
        "previous": '<i class="fa fa-angle-left"></i>',
        "next": '<i class="fa fa-angle-right"></i>'
      }
    },
    "sServerMethod": "POST",
    "fnServerParams": function (aoData)
    {
      aoData.push({"name": "idTipDoc", "value": $("#txtBusIdTipDoc").val()});
      aoData.push({"name": "nroDoc", "value": $("#txtBusNroDoc").val()});
      aoData.push({"name": "nomRS", "value": $("#txtBusNomRS").val()});
      aoData.push({"name": "nroAte", "value": $("#txtBusNroAten").val()});
    },
	"createdRow": function(row, data, index) {
		if (data[8] == "VALID./PARTE" ){
			$('td:eq(8)', row).addClass('primary');
		} else if (data[8] == "VALID./COMPL" ){
			$('td:eq(8)', row).addClass('success');
		}
		
		if (data[7] == "RECIB./PARTE" ){
			$('td:eq(7)', row).addClass('active');
		} else if(data[7] == "RECIB./COMPL."){
			$('td:eq(7)', row).addClass('info');
		}
	},
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
      /* Append the grade to the default row class name */
		if ( aData[7] == "ENTREGRADO PAC." ){
			$('td', nRow).addClass('success');
		} else if ( aData[7] == "ANULADO" ){
			$('td', nRow).addClass('danger');
		}
    },
    "columnDefs": [
      {"orderable": true, "targets": 0, "searchable": false, "class": "small text-center"},
      {"orderable": false, "targets": 1, "searchable": false, "class": "small text-center font-weit"},
      {"orderable": false, "targets": 2, "searchable": false, "class": "small text-center font-weit"},
      {"orderable": false, "targets": 3, "searchable": false, "class": "small"},
      {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
      {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
      {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
      {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"},
      {"orderable": false, "targets": 8, "searchable": false, "class": "small text-center"},
      {"orderable": false, "targets": 9, "searchable": false, "class": "small text-center"}
    ],
    "columns": [
      {
        className: 'details-control',
        defaultContent: '',
        data: null,
        orderable: false,
        defaultContent: ''
      },
      { aTargets: 'nroate' }
    ],
    "order": [[1, 'desc']]
  });

  $('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');

  $('#tblAtencion tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = dTable.row(tr);
    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
    }
    else {
      row.child(det_producto(row.data())).show();
      tr.addClass('shown');
    }
  });
});

// https://pastebin.com/PePH1NGn
function det_producto(d) {
	console.log(d);
  var idate = d[0];
  var parametros = {
    "accion": "SHOW_DETPRODUCTOATENCION",
    "idAten": idate,
	"origen": "R"
  };
  var div = $("<div id='row_"+d[0]+"' style='width: 50%;'>").addClass( 'Cargando' ).text( 'Cargando...' );
  $.ajax({
    data: parametros,
    url: '../../controller/ctrlAtencion.php',
    type: 'post',
    dataType: 'html',
    success: function (result) {
      div.html(result).removeClass('loading');
    }
  });
  return div;
}
</script>
<?php require_once '../include/masterfooter.php'; ?>
