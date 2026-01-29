<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Ups.php';
$ups = new ups();
require_once '../../model/Ubigeo.php';
$ub = new Ubigeo();
$labIdDepUser = $_SESSION['labIdDepUser'];
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>REGISTRO DE SOLICITUD DE INVESTIGACIÓN BACTERIOLÓGICA</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmSolicitud" id="frmSolicitud" onsubmit="return false;">
        <input type="hidden" name="txtIdPac" id="txtIdPac" value="0"/>
        <input type="hidden" name="txtIdSoli" id="txtIdSoli" value="0"/>
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="0"/>
		<input type="hidden" name="txtFecObtencion" id="txtFecObtencion" maxlength="10" value="<?php echo date("d/m/Y");?>">
		<input type="hidden" name="txtIdEESS" id="txtIdEESS" value="<?php echo $_SESSION['labIdDepUser'];?>"/>
        <div class="row">
			<?php require_once 'main_regsolicitud_paciente.php'; ?>
			<div class="col-sm-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>2. Servicio</strong></h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
						  <div class="row">
							<div class="col-sm-9">
							  <label for="txtIdServicio">Servicio</label>
								<?php $rsUps = $ups->get_listaUps(); ?>
							  <select class="form-control" style="width: 100%" name="txtIdServicio" id="txtIdServicio" onkeydown="campoSiguiente('txtNroCama', event);" disabled="">
								<option value="">Seleccione</option>
								<?php
								foreach ($rsUps as $row) {
								  echo "<option value='" . $row['id_ups'] . "'>" . $row['id_ups'] . ": " . $row['descripcion'] . "</option>";
								}
								?>
							  </select>
							</div>
							<div class="col-sm-3">
							  <label for="txtNroCama">Cama N°</label>
							  <input type="text" name="txtNroCama" id="txtNroCama" placeholder="Ingrese Nro." required="" class="form-control input-sm" maxlength="8" onkeydown="campoSiguiente('txtIdTipMuestra', event);" disabled=""/>
							</div>
						  </div>
						</div>
					</div>
				</div>
				<br/>
				<div class="panel panel-info">
				  <div class="panel-heading">
					<h3 class="panel-title"><strong>4. Tipo de muestra</strong></h3>
				  </div>
				  <div class="panel-body">
					<div class="form-group">
						<?php $rsAM = $t->get_listaBACTipoMuestra(); ?>
						<select class="form-control input-xs" style="width: 100%" name="txtIdTipMuestra" id="txtIdTipMuestra" onkeydown="campoSiguiente('txtIdAntecedente', event);" disabled="">
							<option value="" selected>Seleccione</option>
							<?php
							foreach ($rsAM as $rowAM) {
							echo "<option value='" . $rowAM['id'] . "'>" . $rowAM['tipo'] . "</option>";
							}
							?>
						</select>
					</div>
				  </div>
				</div>
				<br/>
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>5. Antecedente de tratamiento</strong></h3>
					</div>
					<div class="panel-body">
						<div class="radio" style="margin-top: 2px;">
						<label>
							<input type="radio" name="txtIdAntecedente" id="txtIdAntecedente1" class="txtIdAntecedente" value="1" disabled=""> Nunca tratado
						</label>
						</div>
						<div class="radio" style="margin-bottom: 1px;">
						<label>
							<input type="radio" name="txtIdAntecedente" id="txtIdAntecedente2" class="txtIdAntecedente" value="2" disabled=""> Antes tratado:
						</label>
						</div>
						(<label class="radio-inline">
							<input type="radio" name="txtIdDetAntecedente" id="txtIdDetAntecedente1" class="txtIdDetAntecedente" value="1" disabled=""> Recaída
						</label>
						<label class="radio-inline">
							<input type="radio" name="txtIdDetAntecedente" id="txtIdDetAntecedente2" class="txtIdDetAntecedente" value="2" disabled=""> Abandono Recup
						</label>
						<label class="radio-inline">
							<input type="radio" name="txtIdDetAntecedente" id="txtIdDetAntecedente3" class="txtIdDetAntecedente" value="3" disabled=""> Fracaso&nbsp;
						</label>)
					</div>
				</div>
			</div>
        </div>
		<div class="row">
			<div class="col-sm-4">
			<div class="row">
				<div class="col-md-12">
				<label for="txtMesTratamiento"><b>Seleccione:</b></label>
					<label class="radio-inline">
					  <input type="radio" name="opt_diag_control" class="opt_diag_control" id="opt_diag_control6" value="6"> Diagnóstico(6)
					</label>
					<label class="radio-inline">
					  <input type="radio" name="opt_diag_control" class="opt_diag_control" id="opt_diag_control7" value="7"> Control(7)
					</label>
				</div>
			</div>
			<br/>
			<div id="show_diagnostico" style="display: none;">
				<div class="panel panel-info">
				  <div class="panel-heading">
					<h3 class="panel-title"><strong>6. Diagnóstico</strong></h3>
				  </div>
				  <div class="panel-body" style="padding-top: 5px; padding-bottom: 5px;">
	                <div class="row">
                      <div class="col-md-6">
						<div class="checkbox" style="margin-top: 2px;">
							<label><input type="checkbox" name="txtIdDiagnostico" id="txtIdDiagnostico1" class="txtIdDiagnostico" value="1" disabled=""/> S.R.</label>
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="checkbox" style="margin-top: 2px;">
							<label><input type="checkbox" name="txtIdDiagnostico" id="txtIdDiagnostico2" class="txtIdDiagnostico" value="2" disabled=""/> Seg. Diagnóstico</label>
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="checkbox" style="margin-top: 2px; margin-bottom: 1px;">
							<label><input type="checkbox" name="txtIdDiagnostico" id="txtIdDiagnostico3" class="txtIdDiagnostico" value="3" disabled=""/> Rx Anormal</label>
						</div>
					  </div>
					  <div class="col-md-6">
						<div class="checkbox" style="margin-top: 2px; margin-bottom: 1px;">
							<label><input type="checkbox" name="txtIdDiagnostico" id="txtIdDiagnostico99" class="txtIdDiagnostico" value="99" disabled=""/> Otro:</label>
						</div>
					  </div>
					</div>
					<div class="form-group">
						<input type="text" name="txtDetDiagnostico" id="txtDetDiagnostico" class="form-control input-sm" maxlength="150" value="" autocomplete="OFF" placeholder="Ingrese otro diagnóstico" onkeydown="campoSiguiente('txtMesTratamiento', event);" disabled=""/>
					</div>
				  </div>
				</div>
			</div>
			<div id="show_control" style="display: none;">
			<div class="panel panel-info">
			  <div class="panel-heading">
				<h3 class="panel-title"><strong>7. Control de tratamiento</strong></h3>
			  </div>
			  <div class="panel-body">
				<div class="form-group">
					<label for="txtMesTratamiento"><b>Mes:</b></label>
					<select class="form-control input-xs" style="width: 100%" name="txtMesTratamiento" id="txtMesTratamiento" onkeydown="campoSiguiente('txtNroCama', event);" disabled="">
						<option value="" selected>Seleccione</option>
						<?php
						for ($i = 1; $i <= 36; $i++) {
							echo "<option value='".$i."'>".$i."</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label><b>Esquemas:</b></label>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="radio" style="margin-top: 2px;">
							<label><input type="radio" name="txtIdTratamiento" id="txtIdTratamiento1" class="txtIdTratamiento" value="1" disabled=""> TB sencible</label>
						</div>
					</div>
					<div class="col-md-6">
							<div class="radio" style="margin-top: 2px;">
								<label><input type="radio" name="txtIdTratamiento" id="txtIdTratamiento2" class="txtIdTratamiento" value="2" disabled=""> DR</label>
							</div>
					</div>
					<div class="col-md-6">
							<div class="radio" style="margin-top: 2px; margin-bottom: 1px;">
								<label><input type="radio" name="txtIdTratamiento" id="txtIdTratamiento3" class="txtIdTratamiento" value="3" disabled=""> MDR</label>
							</div>
					</div>
					<div class="col-md-6">
							<div class="radio" style="margin-top: 2px;">
								<label><input type="radio" name="txtIdTratamiento" id="txtIdTratamiento4" class="txtIdTratamiento" value="4" disabled=""> XDR</label>
							</div>
					</div>
					<div class="col-md-12">
					<div class="input-group input-group">
						<span class="input-group-addon">
						  <label class="radio-inline">
							<input type="radio" name="txtIdTratamiento" id="txtIdTratamiento99" class="txtIdTratamiento" value="99" disabled=""> Otro:
						  </label>
						</span>
						<input class="form-control input-sm" type="text" name="txtDetTratamiento" id="txtDetTratamiento" placeholder="Ingrese otro esquema" required="" maxlength="185" value="" onkeydown="campoSiguiente('txtNroMuestra', event);" disabled=""/>
					</div>
					</div>
				  </div>
				  <br/>
			  </div>
			</div>
			</div>
			</div>
			<div class="col-sm-4">
			<div class="panel panel-info">
			  <div class="panel-heading">
				<h3 class="panel-title"><strong>8. Examen solicitado</strong></h3>
			  </div>
			  <div class="panel-body">
					<div class="form-group">
						<label for="txtIdTipExamen">Tipo de examen:</label>
						<?php $rsBTE = $t->get_listaBACTipoExamen(); ?>
						<select class="form-control input-xs" style="width: 100%" name="txtIdTipExamen" id="txtIdTipExamen" onchange="select_examen();" disabled="">
							<option value="">SELECCIONE</option>
							<?php
							foreach ($rsBTE as $rowBTE) {
							echo "<option value='" . $rowBTE['id'] . "'>" . $rowBTE['tipo'] . "</option>";
							}
							?>
						</select>
					</div>
					<div id="show-hide-pru-rapida" style="display: none;">
						<div class="form-group">
							<label for="txtIdTipoPruRapida">Tipo Prueba:</label>
							<?php $rsBPR = $t->get_listaBACPruebaRapida(); ?>
							<select class="form-control input-xs" style="width: 100%" name="txtIdTipoPruRapida" id="txtIdTipoPruRapida" disabled="">
								<option value="">SELECCIONE</option>
								<?php
								foreach ($rsBPR as $rowBPR) {
								echo "<option value='" . $rowBPR['id'] . "'>" . $rowBPR['tipo'] . "</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div id="show-hide-pru-convencional" style="display: none;">
						<div class="form-group">
							<label for="txtIdMetodoPruConvencional">Tipo Prueba:</label>
							<?php $rsBPC = $t->get_listaBACPruebaConvencional(); ?>
							<select class="form-control input-xs" style="width: 100%" name="txtIdMetodoPruConvencional" id="txtIdMetodoPruConvencional" disabled="">
								<option value="">SELECCIONE</option>
								<?php
								foreach ($rsBPC as $rowBPC) {
								echo "<option value='" . $rowBPC['id'] . "'>" . $rowBPC['tipo'] . "</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
					 <div class="row">
						<div class="col-sm-6">
							<label for="txtNroMuestra">Baciloscopia (N° muestra)</label>
							<input type="text" name="txtNroMuestra" id="txtNroMuestra" placeholder="" required="" class="form-control input-xs" maxlength="185" value="" onkeydown="campoSiguiente('txtDetCultivo', event);" disabled=""/>
						</div>
					 </div>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="col-sm-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>9. Factores de riesgo TB resistente a medicamentos</strong></h3>
					</div>
					<div class="panel-body">
						<textarea name="txtDetFactores" id="txtDetFactores" class="form-control" rows="3" disabled=""></textarea>
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>11. Calidad de muestra</strong></h3>
					</div>
					<div class="panel-body">
						<label class="radio-inline">
							<input type="radio" name="txtIdCaliMuestra" id="txtIdCaliMuestra1" class="txtIdCaliMuestra" value="1" disabled=""> Adecuada
						</label>
						<label class="radio-inline">
							<input type="radio" name="txtIdCaliMuestra" id="txtIdCaliMuestra2" class="txtIdCaliMuestra" value="2" disabled=""> Inadecuada
						</label>
					</div>
				</div>
			  </div>
			</div>
		  
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>13. Observaciones</strong></h3>
					</div>
					<div class="panel-body">
						<textarea class="form-control" name="txtObsSoli" id="txtObsSoli" rows="2" disabled=""></textarea>
					</div>
					</div>
				</div>
			</div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <div id="saveSolicitud">
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="validForm()" disabled=""><i class="fa fa-save"></i> Grabar </button>
                    <button type="button" class="btn btn-default btn-lg" id="btnBackForm" onclick="back()"><i class="fa fa-times"></i> Cancelar</button>
                  </div>
                </div>
                <div id="impriSolicitud" style="display: none;">
                  <div class="btn-group">
                    <button type="button" class="btn btn-lg btn-success" id="btn-imrimirall" onclick="open_pdfsolisinvalor();"><i class="fa fa-file-pdf-o"></i> Imprimir Solicitud</button>
                    <a href="./main_principalresul.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Salir</a>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
<?php require_once 'main_regsolicitud_apoderado.php'; ?>
<div id="mostrar_datospac" class="modal fade" role="dialog" data-backdrop="static"></div>
<?php require_once '../include/footer.php'; ?>
<script type="text/javascript" src="main_principalsoli.js"></script>
<script Language="JavaScript">

$(document).ready(function() {

  $("#txtFecNacPac").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });
  $('#txtFecNacPac').inputmask();

  $("#txtFecNacSoli").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });
  $('#txtFecNacSoli').inputmask();

  $("#txtIdDepPac").select2();
  $('#txtUBIGEOPac').select2();
  $('#txtUBIGEOPac').select2();
  $("#txtIdServicio").select2();
  $("#txtIdTipMuestra").select2();
  $("#txtMesTratamiento").select2();
  $("#txtIdTipExamen").select2();
  $("#txtIdTipoPruRapida").select2();
  $("#txtIdMetodoPruConvencional").select2();
  $("#txtIdPerfilMetodoConvencional").select2();

  setTimeout(function(){$('#txtIdServicio').trigger('focus');}, 2);
});

  </script>
  <?php require_once '../include/masterfooter.php'; ?>
