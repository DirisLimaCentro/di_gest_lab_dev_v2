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
	  <h3 class="panel-title text-center"><strong>REGISTRO DE ATENCIÓN HVB</strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmSolicitud" id="frmSolicitud">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="0"/>
        <input type="hidden" name="txtIdPac" id="txtIdPac" value="0"/>
        <input type="hidden" name="txtIdNino" id="txtIdNino" value="0"/>
          <?php include "reg_datos_paciente.php"; ?>
		  <?php include "reg_datos_atencion.php"; ?>

	  <div class="row">
		<div class="col-sm-8">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>LABORATORIO / DIAGNÓSTICO</strong></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-6">
                  <?php include "reg_datos_momento_diagnostico.php"; ?>
                </div>
                <div class="col-sm-6">
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h3 class="panel-title"><strong>Laboratorio</strong></h3>
                    </div>
                    <div class="panel-body">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-4">
                            <label for="txtGest" class="control-label">Fecha de prueba rápida:</label>
                            <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-5">
                            <label for="txtGest" class="control-label">Carga viral 1er trimestre:</label>
                            <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                          </div>
                          <div class="col-sm-7">
                            <label for="txtGest" class="control-label">Fecha de examen:</label>
                            <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-5">
                            <label for="txtGest" class="control-label">Carga viral 2do trimestre:</label>
                            <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                          </div>
                          <div class="col-sm-7">
                            <label for="txtGest" class="control-label">Fecha de examen:</label>
                            <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
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
		<div class="col-sm-4">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>MANEJO DE HVB</strong></h3>
            </div>
            <div class="panel-body">
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h3 class="panel-title"><strong>Tratamiento (TENOFOVIR)</strong></h3>
                    </div>
                    <div class="panel-body">

                      <div class="input-group input-group">
                        <div class="input-group-addon">
                          <label class="checkbox-inline" style="margin-left:0px !important; padding-left:0px !important;">
                            <input type="radio" class="check_gestante" name="txtIdGestante" id="txtIdGestante1" value="1" disabled> <b>SI</b>
                            <input type="radio" class="check_gestante" name="txtIdGestante" id="txtIdGestante1" value="1" disabled> <b>NO</b>
                          </label>
                        </div>
                        FECHA INICIO
                        <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                        EG(semana de inicio de tratamiento)
                        <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
		</div>
		</div>
			<?php include "reg_datos_referencias.php"; ?>
			<?php include "reg_datos_seguimiento_visita.php"; ?>
			<?php include "reg_datos_culminacion_embarazo.php"; ?>

          <div class="row">
            <div class="col-sm-4">
              <?php include "reg_datos_menor.php"; ?>
            </div>
            <div class="col-sm-8">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title"><strong>Prueba de ELISA HBsAg y Anti HBs</strong></h3>
                </div>
                <div class="panel-body">


                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-5">
                        <label for="txtGest" class="control-label">1er examen:</label>
                        <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                        colocar fecha
                      </div>
                      <div class="col-sm-4">
                        <label for="txtGest" class="control-label"><br/></label>
                        <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                        colocar edad del menor
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-5">
                        <label for="txtGest" class="control-label">2do examen:</label>
                        <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                        colocar fecha
                      </div>
                      <div class="col-sm-4">
                        <label for="txtGest" class="control-label"><br/></label>
                        <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                        colocar edad del menor
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-5">
                        <label for="txtGest" class="control-label">3er examen:</label>
                        <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                        colocar fecha
                      </div>
                      <div class="col-sm-4">
                        <label for="txtGest" class="control-label"><br/></label>
                        <input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                        colocar edad del menor
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title"><strong>Manejo del niño expuesto a hepatitis B</strong></h3>
                </div>
                <div class="panel-body">
                  <div class="form-group">
                    <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo5" value="1" disabled/>Administración de vacuna contra hepatitis B al RN</label><br/>
                    <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo2" value="0" disabled/>Administración de inmunoglobulina</label>
                  </div>

                </div>
              </div>
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title"><strong>Más información del niño</strong></h3>
                </div>
                <div class="panel-body">
                  <fieldset class="scheduler-border">
                    <legend class="scheduler-border" style="margin-bottom: 2px;">Estado final del niño expuesto a hepatitis B</legend>
                    <div class="form-group">
                      <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo5" value="1" disabled/>INFECTADO</label>
                      <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo2" value="0" disabled/>NO INFECTADO</label>
                      <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo2" value="0" disabled/>FALLECIDO</label>
                      <label class="radio-inline"><input type="radio" class="check_anticonceptivo" name="txtAnticonceptivo" id="txtAnticonceptivo2" value="0" disabled/>PERDIDO</label>
                    </div>
                  </fieldset>
                  <fieldset class="scheduler-border">
                    <legend class="scheduler-border" style="margin-bottom: 2px;">Observaciones del niño</legend>
                    <div class="form-group">
                      <textarea name="txtObsSoli" id="txtObsSoli" class="form-control" rows="3" disabled></textarea>
                    </div>
                  </fieldset>
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

  <div class="modal fade" id="showSoliModal" role="dialog" aria-labelledby="showSoliModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showSoliModalLabel">Registro de apoderado</h4>
        </div>
        <div class="modal-body">
          <form name="frmSolicitante" id="frmSolicitante">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-7">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="txtIdTipDocSoli">Documento de identidad</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-4" style="padding-right: 0!important;">
                      <?php $rsT = $t->get_listaTipoDocPerNatuConDocAdulto(); ?>
                      <select class="form-control input-sm" name="txtIdTipDocSoli" id="txtIdTipDocSoli" onchange="maxlength_doc_bus_soli()" disabled>
                        <?php
                        foreach ($rsT as $row) {
                          echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . ": " . $row['descripcion'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-xs-8" style="padding-left: 0!important;">
                      <div class="input-group input-group-sm">
                        <input type="text" name="txtNroDocSoli" id="txtNroDocSoli" class="form-control input-sm" maxlength="8" onkeydown="campoSiguiente('btnSoliSearch', event);" disabled/>
                        <div class="input-group-btn">
                          <button class="btn btn-success" type="button" id="btnSoliSearch" onclick="buscar_datos_personales_soli('2')" disabled><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <label for="txtPriApeSoli">Apellido paterno</label>
                  <input type="text" name="txtPriApeSoli" id="txtPriApeSoli" class="form-control input-sm" maxlength="75" onkeydown="campoSiguiente('txtSegApeSoli', event);" readonly/>
                </div>
                <div class="col-sm-6">
                  <label for="txtSegApeSoli">Apellido materno</label>
                  <input type="text" name="txtSegApeSoli" id="txtSegApeSoli" class="form-control input-sm" maxlength="75" onkeydown="campoSiguiente('txtNomSoli', event);" readonly/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="txtNomSoli">Nombre(s)</label>
              <input type="text" name="txtNomSoli" class="form-control input-sm" id="txtNomSoli" maxlength="180" onkeydown="campoSiguiente('txtIdSexoSoli', event);" readonly/>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6 col-md-3">
                  <label for="txtIdSexoSoli">Sexo</label>
                  <select class="form-control input-sm" name="txtIdSexoSoli" id="txtIdSexoSoli" onkeydown="campoSiguiente('txtFecNacSoli', event);" disabled>
                    <option value="">Seleccione</option>
                    <option value="1">M</option>
                    <option value="2">F</option>
                  </select>
                </div>
                <div class="col-sm-6 col-md-4">
                  <label for="txtFecNacSoli">Fecha Nac.</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" name="txtFecNacSoli" id="txtFecNacSoli" placeholder="DD/MM/AAAA" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtIdParenSoli', event);" disabled/>
                  </div>
                </div>
                <div class="col-sm-6 col-md-5">
                  <label for="txtIdParenSoli">Parentesco</label>
                  <?php $rsTP = $t->get_listaParentesco(); ?>
                  <select class="form-control input-sm" name="txtIdParenSoli" id="txtIdParenSoli" style="width: 100%" onkeydown="campoSiguiente('txtIdPaisNacSoli', event);" disabled>
                    <option value="">Seleccione</option>
                    <?php
                    foreach ($rsTP as $row) {
                      echo "<option value='" . $row['id_parentesco'] . "'>" . $row['nom_parentesco'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <label for="txtIdPaisNacSoli">País de nacimiento</label>
                  <select class="form-control" style="width: 100%" name="txtIdPaisNacSoli" id="txtIdPaisNacSoli" onkeydown="campoSiguiente('txtIdEtniaSoli', event);" disabled>
                    <option value="">-- Seleccione --</option>
                    <?php
                    $rsPP = $ub->get_listaPais();
                    foreach ($rsPP as $rowPP) {
                      echo "<option value='" . $rowPP['id_pais'] . "'>" . $rowPP['nom_pais'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-sm-6">
                  <label for="txtIdEtniaSoli">ETNIA</label>
                  <select class="form-control" style="width: 100%" name="txtIdEtniaSoli" id="txtIdEtniaSoli" onkeydown="campoSiguiente('txtNroTelFijoSoli', event);" disabled>
                    <option value="">-- Seleccione --</option>
                    <?php
                    $rsTE = $t->get_listaEtnia();
                    foreach ($rsTE as $rowTE) {
                      echo "<option value='" . $rowTE['id_etnia'] . "'>" . $rowTE['nom_etnia'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6">
                  <label for="txtNroTelFijoSoli">Telf. Fijo</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></div>
                    <input type="text" name="txtNroTelFijoSoli" placeholder="999999999" id="txtNroTelFijoSoli" class="form-control input-sm" maxlength="9" value="" onkeydown="campoSiguiente('txtNroTelMovilSoli', event);"/>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label for="txtNroTelMovilSoli">Telf. Móvil</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
                    <input type="text" name="txtNroTelMovilSoli" placeholder="999999999" id="txtNroTelMovilSoli" class="form-control input-sm" maxlength="9" value="" onkeydown="campoSiguiente('txtEmailSoli', event);"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="txtEmailSoli">Email</label>
              <div class="input-group input-group-sm">
                <div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
                <input type="text" name="txtEmailSoli" placeholder="@example.com" id="txtEmailSoli" class="form-control input-sm" maxlength="50" value="" onkeydown="campoSiguiente('btnValidFormSoli', event);"/>
              </div>
              <span class="help-block">Para el Email, considere mayúsculas y minúsculas</span>
            </div>

          </form>
        </div>
        <div class="modal-footer" style="padding-bottom: 7px !important; padding-top: 7px !important;">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-continuar" id="btnValidFormSoli" onclick="validFormSoli('1')"><i class="fa fa-save"></i> Aceptar </button>
                <button type="button" class="btn btn-default" onclick="validFormSoli('2')"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="mostrar_datospac" class="modal fade" role="dialog" data-backdrop="static"></div>
  <?php require_once '../include/footer.php'; ?>
  <script type="text/javascript" src="its.js"></script>
  <script type="text/javascript" src="../../assets/js/canvasregpap.js"></script>
  <script Language="JavaScript">

  $(document).ready(function() {
    /*
    $('#txtFecNacPac,#txtFechaCPN,#txtFechaPP,#txtfechaRef,#txtFechaPruRapLab,#txtFechaDLS1,#txtFechaDLS2,#txtFechaDLS3,#txtFechaDosisPac1,#txtFechaDosisPac2,#txtFechaDosisPac3,#txtFechaDosisCon1,#txtFechaDosisCon2,#txtFechaDosisCon3,#txtFechaParto,#txtFechaAborto,#txtFecNacNi').datetimepicker({
    locale: 'es',
    format: 'L'
  });
  */

  $('#txtIdPaisNacPac, #txtIdEtniaPac, #txtIdDepPac, #txtUBIGEOPac, #txtIdParenSoli, #txtIdDepRef, #txtIdDepNacNi').select2();

  $('#txtEGCPN').select2();
  $('#txtEGNi').select2();


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


  });
  </script>
  <?php require_once '../include/masterfooter.php'; ?>
