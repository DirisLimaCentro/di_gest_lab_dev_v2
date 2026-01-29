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
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title text-center"><strong>REGISTRO DE ATENCIÓN VIH</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmSolicitud" id="frmSolicitud">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="0"/>
        <input type="hidden" name="txtIdPac" id="txtIdPac" value="0"/>
        <input type="hidden" name="txtIdNino" id="txtIdNino" value="0"/>
          <?php include "reg_datos_paciente.php"; ?>
		  <?php include "reg_datos_atencion.php"; ?>
		<div id="div-datos-atencion" style="display: none;">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>DIAGNÓSTICO</strong></h3>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-5">
				<?php include "reg_datos_momento_diagnostico_vih.php"; ?>
              </div>
              <div class="col-sm-7">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><strong>Laboratorio</strong></h3>
                  </div>
                  <div class="panel-body">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><strong>Tamizaje</strong></h3>
                  </div>
                  <div class="panel-body">
                    <div class="col-sm-6">
                      <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="margin-bottom: 2px;">PR 3ra Generación</legend>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-sm-12 col-md-7">
                              <label for="txtFechaL1t3ra" class="control-label">Fecha:</label>
                                <input type="text" name="txtFechaL1t3ra" id="txtFechaL1t3ra" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtL2t3ra', event);" disabled/>
                            </div>
                            <div class="col-sm-12 col-md-5">
                              <label for="txtL1t3ra" class="control-label">Lote 1:</label>
                              <input type="text" name="txtL1t3ra" id="txtL1t3ra" class="form-control" maxlength="4" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtFechaL1t3ra', event);" disabled/>
                            </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
								<div class="col-sm-12 col-md-7">
									<label for="txtFechaL2t3ra" class="control-label">Fecha:</label>
									<input type="text" name="txtFechaL2t3ra" id="txtFechaL2t3ra" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtFechaElisa', event);" disabled/>
                                </div>
								<div class="col-sm-12 col-md-5">
									<label for="txtL2t3ra" class="control-label">Lote 2:</label>
									<input type="text" name="txtL2t3ra" id="txtL2t3ra" class="form-control" maxlength="4" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtFechaL2t3ra', event);" disabled/>
								</div>
                            </div>
                            </div>
                      </fieldset>
                      <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="margin-bottom: 2px;">ELISA</legend>
                        <div class="form-group">
                          <div class="row">
								<div class="col-sm-4">
									<label for="txtFechaElisa" class="control-label">Fecha:</label>
								</div>
								<div class="col-sm-8">
									<input type="text" name="txtFechaElisa" id="txtFechaElisa" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtL1t4ta', event);" disabled/>
								</div>
                            </div>
                          </div>
                      </fieldset>
                    </div>
                    <div class="col-sm-6">
                      <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="margin-bottom: 2px;">PR 4ta Generación</legend>
                        <div class="form-group">
                          <div class="row">
								<div class="col-sm-12 col-md-7">
									<label for="txtFechaL1t4ta" class="control-label">Fecha:</label>
									<input type="text" name="txtFechaL1t4ta" id="txtFechaL1t4ta" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtNroDLS3', event);" disabled/>
								</div>
								<div class="col-sm-12 col-md-5">
									<label for="txtL1t4ta" class="control-label">Lote 1:</label>
									<input type="text" name="txtL1t4ta" id="txtL1t4ta" class="form-control" maxlength="4" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtFechaDLS2', event);" disabled/>
								</div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
								<div class="col-sm-12 col-md-7">
									<label for="txtFechaL2t4ta" class="control-label">Fecha:</label>
									<input type="text" name="txtFechaL2t4ta" id="txtFechaL2t4ta" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtFechaConfir', event);" disabled/>
                                </div>
								<div class="col-sm-12 col-md-5">
									<label for="txtL2t4ta" class="control-label">Lote 2:</label>
									<input type="text" name="txtL2t4ta" id="txtL2t4ta" class="form-control" maxlength="4" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtFechaDLS2', event);" disabled/>
								</div>
                              </div>
                            </div>
                      </fieldset>
						<div class="form-group">
						  <div class="col-sm-12 text-center">
							<br/>
						  <span class="help-block-display">¿Referida?</span>
						  <label class="radio-inline"><input type="radio" class="opt_tamizajeref" name="txtPruebaSenciRefe" id="txtPruebaSenciRefe1" value="1" disabled/>Si</label>
						  <label class="radio-inline"><input type="radio" class="opt_tamizajeref" name="txtPruebaSenciRefe" id="txtPruebaSenciRefe0" value="0" disabled/>No</label>
						</div>
						</div>
                    </div>


                  </div>
                </div>
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><strong>Examen confirmatorio</strong></h3>
                  </div>
                  <div class="panel-body">
                    <div class="col-sm-4">
                      <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="margin-bottom: 2px;">Carga viral</legend>
                        <div class="form-group">
                          <label for="txtFechaCargaV" class="control-label">Fecha:</label>
                          <input type="text" name="txtFechaCargaV" id="txtFechaCargaV" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtNroDLS3', event);" disabled/>
                          </div>
                          <div class="form-group">
                            <label for="txtNroCargaV" class="control-label">Resultado:</label>
                            <input type="text" name="txtNroCargaV" id="txtNroCargaV" class="form-control" maxlength="4" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtNroDLS3', event);" disabled/>
                            <span class="help-block">Nro. Copias</span>
                            </div>
                      </fieldset>
                    </div>
                    <div class="col-sm-4">
                      <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="margin-bottom: 2px;">IFI</legend>
                        <div class="form-group">
                          <label for="txtFechaIFI" class="control-label">Fecha:</label>
                          <input type="text" name="txtFechaIFI" id="txtFechaIFI" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtNroDLS3', event);" disabled/>
                          </div>
                          <div class="form-group">
                            <div class="radio" style="margin-top: 0px !important;">
                              <label>
                                <input type="radio" name="txtIFI" id="txtIFI1" class="opt_ifi" value="1" disabled="">
                                Positivo
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="txtIFI" id="txtIFI0" class="opt_ifi" value="0" disabled="">
                                Negativo
                              </label>
                            </div>
                          </div>
                      </fieldset>
                    </div>
                    <div class="col-sm-4">
                      <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="margin-bottom: 2px;">CD4</legend>
                        <div class="form-group">
                          <label for="txtFechaCD4" class="control-label">Fecha:</label>
                          <input type="text" name="txtFechaCD4" id="txtFechaCD4" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtNroCD4', event);" disabled/>
                          </div>
                          <div class="form-group">
                            <label for="txtNroCD4" class="control-label">Resultado:</label>
                            <input type="text" name="txtNroCD4" id="txtNroCD4" class="form-control" maxlength="4" value="" onfocus="this.select()" disabled/>
                            <span class="help-block">Nro. Cel/mm3</span>
                            </div>
                      </fieldset>
                    </div>
                  </div>
                </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>

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
					<?php include "reg_datos_menor_1_vih.php"; ?>
				</div>
				<div role="tabpanel" class="tab-pane" id="profile">
					<br/>
					<?php include "reg_datos_menor_2_vih.php"; ?>
				</div>
				<div role="tabpanel" class="tab-pane" id="messages">
				<br/>
					<?php include "reg_datos_menor_3_vih.php"; ?>
				</div>
			</div>
		  </div>
		</div>

        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div id="saveSolicitud">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-lg" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Guardar Atención</button>
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
<script type="text/javascript" src="vih.js"></script>
<script Language="JavaScript">

$(function() {


    $('[name="txtTARGA"]').change(function()
    {
      if ($(this).is(':checked')) {
        if($(this).val() == "1"){
          $('#txtAnioTarga').prop("disabled", true);
          $('.opt_zidovudina').prop("disabled", true);
          $('#txtFechaAban').prop("disabled", true);
          $('#txtEGEmba').prop("disabled", true);
          $('#txtFechaIniEmba').prop("disabled", true);
        } else if($(this).val() == "2") {
          $('#txtAnioTarga').prop("disabled", false);
          $('.opt_zidovudina').prop("disabled", true);
          $('#txtFechaAban').prop("disabled", true);
          $('#txtEGEmba').prop("disabled", true);
          $('#txtFechaIniEmba').prop("disabled", true);
        } else if($(this).val() == "3") {
          $('#txtAnioTarga').prop("disabled", true);
          $('.opt_zidovudina').prop("disabled", false);
          $('#txtFechaAban').prop("disabled", true);
          $('#txtEGEmba').prop("disabled", true);
          $('#txtFechaIniEmba').prop("disabled", true);
        } else if($(this).val() == "4") {
          $('#txtAnioTarga').prop("disabled", true);
          $('.opt_zidovudina').prop("disabled", true);
          $('#txtFechaAban').prop("disabled", false);
          $('#txtEGEmba').prop("disabled", true);
          $('#txtFechaIniEmba').prop("disabled", true);
        } else if($(this).val() == "5") {
          $('#txtAnioTarga').prop("disabled", true);
          $('.opt_zidovudina').prop("disabled", true);
          $('#txtFechaAban').prop("disabled", true);
          $('#txtEGEmba').prop("disabled", false);
          $('#txtFechaIniEmba').prop("disabled", false);
        }
        $("#txtAnioTarga").val('');
        $(".opt_zidovudina").prop('checked', false);
        $("#txtFechaAban").val('');
        $("#txtEGEmba").val('');
        $("#txtFechaIniEmba").val('');

      }
    });

});
$(document).ready(function() {

  $('#txtIdPaisNacPac').select2();
  $('#txtIdEtniaPac').select2();
  $('#txtIdDepPac').select2();
  $('#txtUBIGEOPac').select2();
  $('#txtIdParenSoli').select2();

  $('#txtIdDepRef').select2();
  $('#txtIdDepTargaRef').select2();
  $('#txtIdDepNacNi').select2();

  $('#txtEGCPN').select2();
  $('#txtEGNi').select2();
});
</script>
<?php require_once '../include/masterfooter.php'; ?>
