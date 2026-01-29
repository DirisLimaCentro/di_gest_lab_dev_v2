<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Tipo.php';
$t = new Tipo();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Area.php';
$a = new Area();
require_once '../../model/Grupo.php';
$g = new Grupo();
require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/Cpt.php';
$cpt = new Cpt();
require_once '../../model/Ubigeo.php';
$ub = new Ubigeo();
require_once '../../model/Producto.php';
$p = new Producto();
require_once '../../model/Servicio.php';
$se = new Servicio();
require_once '../../model/Tarifa.php';
$ta = new Tarifa();
require_once '../../model/Atencion.php';
$at = new Atencion();
$idAtencion = $_GET['nroSoli'];
$rsA = $at->get_datosAtencion($idAtencion);
//print_r($rsA);
?>
<style>
.panel-prime {
  background-color: #ecf0f5 !important;
}
.box-body {
  padding: 15px;
}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    padding-top: 3px !important;
    padding-bottom: 3px !important;
}

.ui-autocomplete {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    float: left;
    display: none;
    min-width: 160px;   
    padding: 4px 0;
    margin: 0 0 10px 25px;
    list-style: none;
    background-color: #ffffff;
    border-color: #ccc;
    border-color: rgba(0, 0, 0, 0.2);
    border-style: solid;
    border-width: 1px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -webkit-background-clip: padding-box;
    -moz-background-clip: padding;
    background-clip: padding-box;
    *border-right-width: 2px;
    *border-bottom-width: 2px;
	cursor:pointer; cursor: hand;
}

.ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
    text-decoration: none;
	cursor:pointer; cursor: hand;
}

.ui-state-hover, .ui-state-active {
    color: #ffffff;
    text-decoration: none;
    background-color: #0088cc;
    border-radius: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    background-image: none;
	cursor:pointer; cursor: hand;
}
</style>
<?php 
	if($rsA[0]['id_tipo_genera_correlativo'] == "1"){
		$nro_atencion = $rsA[0]['nro_atencion'] . "-". $rsA[0]['anio_atencion'];
	} else {
		$nro_atencion = substr($rsA[0]['nro_atencion'], 0, 6).substr($rsA[0]['nro_atencion'],6);
	}
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>EDITAR ATENCIÓN N°- <?php echo $nro_atencion;?></strong></h3>
    </div>
    <div class="panel-body">
      <form name="frmPaciente" id="frmPaciente">
        <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="<?php echo $idAtencion;?>"/>
        <input type="hidden" name="txtShowOptPrint" id="txtShowOptPrint" value=""/>
        <input type="hidden" name="txtIdPer" id="txtIdPer" value="0"/>
        <input type="hidden" name="txtIdSoli" id="txtIdSoli" value="0"/>

        <div class="row">
          <div class="col-sm-5 col-md-4">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"><strong>Datos del paciente</strong></h3>
              </div>
              <div class="box-body">
				<?php include './main_reglab_dato_personal.php';?>
              </div>
            </div>
          </div><!-- Fin Datos Personales -->
		  <div class="col-sm-7 col-md-8">
            <div class="box box-primary" style="margin-bottom: 2px !important;">
              <div class="box-header with-border">
                <h3 class="box-title"><strong>Datos de la atención</strong></h3>
              </div>
              <div class="box-body" style="padding-top: 0px !important; padding-bottom: 2px !important;">
                <div class="row">
                  <div class="form-group col-sm-4 col-md-3">
                    <label for="txtIdPlanTari"><small>Origen de atención <span class="text-danger">(*)</span>:</small></label>
                    <select class="form-control input-lg" name="txtIdPlanTari" id="txtIdPlanTari" onkeydown="campoSiguiente('txtFechaAten', event);">
                      <option value="">-- Seleccione --</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-4 col-md-3">
                    <label for="txtFechaAten">Fecha cita <span class="text-danger">(*)</span>:</label>
                    <div class="input-group input-group-lg">
                      <div class="input-group-addon" for="txtFechaAten"><i class="fa fa-calendar" for="txtFechaAten"></i></div>
                      <input type="text" name="txtFechaAten" placeholder="DD/MM/AAAA" id="txtFechaAten" autofocus="" class="form-control" maxlength="10" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtIdTipAtencion', event);" value="<?php echo $rsA[0]['fec_cita']?>" data-date-start-date="+1d"/>
                      <input type="hidden" name="txtHoraAten" placeholder="HH:MM" required="" id="txtHoraAten" onfocus="this.select()" class="form-control" maxlength="5" value="<?php echo date("h:i") ?>" data-inputmask="'mask': '99:99'" onkeydown="campoSiguiente('txtPesoPac', event);"/>
                    </div>
                  </div>
                  <div class="form-group col-sm-4 col-md-2">
                    <label for="txtNroRefAtencion"><small>Cnt. cita fec. <span class="text-danger">(*)</span>:</small></label>
                    <?php
                    $nroAtedia = $rsA[0]['nro_citadia'];//str_replace("/", "", $rsA[0]['fec_atencion'])."-".$rsA[0]['fec_atencion'];
                    ?>
                    <input type="text" name="txtNroRefAtencion" id="txtNroRefAtencion" class="form-control input-lg" maxlength="12" value="<?php echo $nroAtedia?>" disabled/>
                  </div>
				  <div class="form-group col-sm-12 col-md-4">
					<div class="checkbox">
					<label>
						<input type="checkbox" name="txtPersonalSalud" id="txtPersonalSalud" value="1" <?php if( $rsA[0]['check_personal_salud'] == "t") echo " checked";?>> ¿Paciente es<br/>personal de salud?
					</label>
					</div>
				  </div>
                </div>
				<div style="display: none;">
					<div class="row">
					  <div class="form-group col-sm-6 col-md-3">
						<label for="txtIdTipAtencion">Origen de atención <span class="text-danger">(*)</span>:</label>
						<select class="form-control input-sm" name="txtIdTipAtencion" id="txtIdTipAtencion" onchange="change_tipoatencion()" onkeydown="campoSiguiente('txtAtenUrgente', event);">
						  <option value="">-- Seleccione --</option>
						  <option value="1" <?php if($rsA[0]['id_tipatencion'] == "1") echo " selected"?>>AMBULATORIA</option>
						  <option value="2" <?php if($rsA[0]['id_tipatencion'] == "2") echo " selected"?>>REFERENCIA EXTERNA</option>
						  <option value="4" <?php if($rsA[0]['id_tipatencion'] == "4") echo " selected"?>>REFERENCIA INTERNA</option>
						  <option value="3" <?php if($rsA[0]['id_tipatencion'] == "3") echo " selected"?>>URGENCIA</option>
						</select>
					  </div>
					  <div class="col-sm-6 col-md-2">
						<label for="txtNroRefDep">Nro. referencia</label>
						<input type="text" name="txtNroRefDep" id="txtNroRefDep" class="form-control input-sm" maxlength="20" readonly value="<?php echo $rsA[0]['nro_refdepenori']?>"/>
					  </div>
					  <div class="col-sm-6 col-md-2">
						<label for="txtAnioRefDep">Año referencia</label>
						<input type="text" name="txtAnioRefDep" id="txtAnioRefDep" class="form-control input-sm" maxlength="20" readonly/>
					  </div>
					</div>
				</div>
				<div class="row">
				 <div class="form-group col-sm-12 col-md-3">
                    <label for="txtIdServicio">Servicio de procedencia:</label>
                    <select class="form-control input-sm" style="width: 100%" name="txtIdServicio" id="txtIdServicio" onkeydown="campoSiguiente('txtDirPac', event);" disabled>
                      <option value="" selected>-- Seleccione --</option>
                      <?php
                      $rsSe = $se->get_listaServicioPorIdDep($labIdDepUser);
                      foreach ($rsSe as $rowSe) {
                        echo "<option value='" . $rowSe['id_servicio'] . "'";
                        if($rowSe['id_servicio'] == $rsA[0]['id_servicioori']) echo " selected";
                        echo ">" . $rowSe['nom_servicio'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
				  <div class="form-group col-sm-6 col-md-6">
                    <label for="txtNombreMedico">Nombre(s) del médico:</label>
                    <input type="text" name="txtNombreMedico" id="txtNombreMedico" class="form-control input-sm text-uppercase" maxlength="170" value="<?php echo $rsA[0]['nombre_medico']?>"/>
					<span class="help-block">Ingrese primero los apellidos luego los nombres</span>
                  </div>
				  <div class="form-group col-sm-6 col-md-3">
                    <label for="txtFechaPedido">Fecha orden médico:</label>
                    <div class="input-group input-group-sm">
                      <div class="input-group-addon" for="txtFechaPedido"><i class="fa fa-calendar" for="txtFechaPedido"></i></div>
                      <input type="text" name="txtFechaPedido" placeholder="DD/MM/AAAA" id="txtFechaPedido" autofocus="" class="form-control" maxlength="10" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtNombreMedico', event);" value="<?php echo $rsA[0]['fecha_pedido']?>"/>
                    </div>
                  </div>
                </div>
				<fieldset class="scheduler-border">
				<legend class="scheduler-border" style="margin-bottom: 0px;">Datos adicionales (<span class="text-primary" id="show-datos-adicionales-aten" style="cursor: pointer;" onclick="show_datos_adicionales_aten()">Mostrar</span>)</legend>
				<div id="datos-adicionales-aten" style="display: none;">
					<div class="row">
						<div class="col-sm-6">
						<label for="txtIdDepRef">EESS Origen</label>
						<?php $rsD = $d->get_listaDepenInstitucion(); ?>
						<select name="txtIdDepRef" id="txtIdDepRef" style="width:100%;" class="form-control input-sm"  onkeydown="campoSiguiente('txtNroRefDep', event);">
						  <option value="" selected>-- Seleccione --</option>
						  <?php
						  foreach ($rsD as $row) {
							echo "<option value='" . $row['id_dependencia'] . "'";
							if($row['id_dependencia'] == $rsA[0]['id_depenori']) echo " selected";
							echo ">" . $row['nom_depen'] . "</option>";
						  }
						  ?>
						</select>
					  </div>
					</div>
					<div class="row">
					  <div class="col-sm-3 col-md-2">
						<div class="checkbox">
						  <label>
							<input type="checkbox" name="txtIdGestante" id="txtIdGestante" value="1" <?php if( $rsA[0]['check_gestante'] == "t") echo " checked";?> <?php if($rsA[0]['id_sexopac'] == "1") echo " disabled"?>> ¿Es gestante?
						  </label>
						</div>
					  </div>
					  <div class="col-sm-4 col-md-2">
						<label for="txtEdadGest">Edad Gest.:</label>
						<input type="text" name="txtEdadGest" id="txtEdadGest" class="form-control input-sm" maxlength="25" onkeydown="campoSiguiente('txtFechaParto', event);" value="<?php echo $rsA[0]['edad_gestacional']?>" <?php if($rsA[0]['edad_gestacional'] == "") {echo " disabled";}?>>
					  </div>
					  <div class="col-sm-5 col-md-3">
						<label for="txtFechaParto">Fec. Prob. de parto:</label>
						<div class="input-group input-group-sm">
						  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
						  <input type="text" name="txtFechaParto" id="txtFechaParto" placeholder="DD/MM/AAAA" class="form-control" maxlength="20" value="<?php echo $rsA[0]['fecha_prob_parte']?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" data-date-end-date="0d" <?php if($rsA[0]['fecha_prob_parte'] == "") {echo " disabled";}?>>
						</div>
					  </div>
					</div>
					<div class="row">
						<div class="col-sm-3 col-md-2">
							<label for="txtPesoPac">Peso (<span class="text-danger"><b>Kg</b></span>):</label>
							<input type="text" name="txtPesoPac" id="txtPesoPac" onfocus="this.select()" class="form-control" maxlength="6" onkeydown="campoSiguiente('txtTallaPac', event);" onkeypress="keyValidNumberDecimalTwo(this.id);" onblur="keyValidNumberDecimalTwo(this.id);" value="<?php echo $rsA[0]['peso_pac'];?>"/>
						</div>
						<div class="col-sm-3 col-md-2">
							<label for="txtTallaPac">Talla (<span class="text-danger"><b>Cm</b></span>):</label>
							<input type="text" name="txtTallaPac" id="txtTallaPac" onfocus="this.select()" class="form-control" maxlength="3" onkeydown="campoSiguiente('txtPAPac', event);" onkeypress="keyValidNumber(this.id);" onblur="keyValidNumber(this.id);" value="<?php echo $rsA[0]['talla_pac'];?>"/>
						</div>
						<div class="col-sm-3 col-md-3"><br/>
							<div class="checkbox">
							  <label>
								<input type="checkbox" name="txtAtenUrgente" id="txtAtenUrgente" value="1" onkeydown="campoSiguiente('txtCodSIS', event);" <?php if( $rsA[0]['check_urgente'] == "t") echo " checked";?>> ¿Atención urgente?
							  </label>
							</div>
						</div>
					</div>
				</div>
				</fieldset><!-- fin datos de atención-->
              </div>
            </div><!--Fin datos de atención-->
			<div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title"><strong>Lista de examenes solicitados <span class="text-danger">(*)</span>:</strong></h3>
              </div>
              <div class="box-body" style="padding-top: 0px !important;">
                <div class="row">
                  <div class="col-sm-8 col-md-9">
                    <select class="form-control" name="txtIdProducto" id="txtIdProducto" required="" style="width: 100%">
                      <option value="">--Seleccione--</option>
                      <?php
                      $rsP = $p->get_listaProductoLaboratorioPorIdDep($labIdDepUser, '1');
                      foreach ($rsP as $rowP) {
                        echo "<option value='" . $rowP['id_producto'] . "#".$rowP['codref_producto']."#".$rowP['nomtipo_producto']."#".$rowP['prec_sis']."#".$rowP['prec_parti']."'>". $rowP['nom_producto'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-sm-4 col-md-3">
                    <button type="button" class="btn btn-sm pull-left" style="margin-bottom: 15px;" onclick="addRow('')"><i class="glyphicon glyphicon-plus"></i> Agregar Exámen</button>
                  </div>
                </div>
                <table class="table table-striped table-bordered table-hover" id="tblDet">
                  <thead class="bg-green">
                    <tr>
                      <th>Código CPMS</th>
                      <th>Exámen solicitado</th>
                      <th>Tipo</th>
                      <th>Precio</th>
                      <th class="text-center" style="width: 45px;"><i class="fa fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <!--<td colspan="3">Agrégue un exámen</td>-->
                  </tbody>
                  <tfoot>
                    <th colspan="3" class="text-center"><small>Sub Total</small></th>
                    <th class="text-right"><small>S/ <span id="totPrecProd"><?php echo number_format(($rsA[0]['total_descuento'] + $rsA[0]['total_valor']),4,'.','')?></span></small></th>
                    <th>&nbsp;</th>
                  </tfoot>
                </table>
				<div class="row">
				  <div class="col-sm-3">
				  <br/>
					<b><i id="nro_examen">0</i></b> Items
				  </div>
                  <div class="col-sm-3">
                    <label for="txtPorDescuentoMonto"><small>% Descuento <span class="text-danger">(*)</span></small></label>
                    <div class="input-group input-group-sm">
                      <div class="input-group-addon" for="txtPorDescuentoMonto">%</div>
                      <input type="text" name="txtPorDescuentoMonto" id="txtPorDescuentoMonto" onfocus="this.select()" class="form-control" maxlength="6" value="<?php echo $rsA[0]['porcentaje_descuento']?>" onkeypress="return keyValidNumberDecimalTwo('txtPorDescuentoMonto');" onkeyup="tot_con_descuento();" onblur="poner_cero('txtPorDescuentoMonto')"/>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <label for="txtDescuentoMonto"><small>Descuento <span class="text-danger">(*)</span></small></label>
                    <div class="input-group input-group-sm">
                      <div class="input-group-addon" for="txtDescuentoMonto"><i class="glyphicon glyphicon-triangle-bottom" for="txtDescuentoMonto"></i></div>
                      <input type="text" name="txtDescuentoMonto" id="txtDescuentoMonto" onfocus="this.select()" class="form-control" maxlength="7" value="<?php echo $rsA[0]['total_descuento']?>" onkeypress="return keyValidNumberDecimalFour('txtDescuentoMonto');" onkeyup="tot_con_descuento_manual();" onblur="poner_cero('txtDescuentoMonto')"/>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <label for="txtTotalMonto"><small><b> Val. total S/. <span class="text-danger">(*)</span></b></small></label>
                    <div class="input-group input-group-sm">
                      <div class="input-group-addon" for="txtTotalMonto"><i class="glyphicon glyphicon-text-size" for="txtTotalMonto"></i></div>
                      <input type="text" name="txtTotalMonto" id="txtTotalMonto" class="form-control" maxlength="7" value="<?php echo $rsA[0]['total_valor']?>" disabled/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		</div>

        <div class="row" style="display: none;">
          <div class="col-sm-12">
            <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title"><strong>Detalle de examen</strong></h3>
              </div>
              <div class="box-body">
                <table class="table table-striped table-bordered table-hover">
                  <thead class="bg-yellow">
                    <tr>
                      <th>CPT</th>
                      <th>Preparación del paciente</th>
                      <th>Insumos</th>
                      <th>Observación</th>
                    </tr>
                  </thead>
                  <tbody id="det-producto">
                    <tr>
                      <td colspan="4">Seleccione un exámen</td>
                    </tr>
                  </tbody>
                </table>
				<div class="col-xs-12">
					<div id="det-examen-producto"></div>
				</div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="panel-footer">
      <div class="row">
        <div class="col-md-12 text-center">
          <div id="saveAtencion">
            <div class="btn-group">
              <button class="btn btn-primary btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="validForm('E')" disabled><i class="fa fa-save"></i>  Guardar  </button>
              <a href="./main_principalsoli.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="mostrar_datospac" class="modal fade" role="dialog" data-backdrop="static"></div>
<?php require_once '../include/footer.php'; ?>
<script src="../../assets/plugins/jQuery/jquery.ui.autocomplete.js"></script>
<script src="../../assets/plugins/jQuery/jquery-ui.js"></script>
<script src="../../assets/js/consulta_persona.js?v=<?php echo rand(); ?>"></script>
<script src="main_reglab.js?v=<?php echo rand(); ?>"></script>




<script Language="JavaScript">
function compledir(ord){
  var txtIdAvDirPac = "";
  var txtNomAvDirPac = "";
  var txtNroDirPac = "";
  var txtIntDirPac = "";
  var txtDptoDirPac = "";
  var txtMzDirPac = "";
  var txtLtDirPac = "";
  var txtIdPoblaDirPac = "";
  var txtNomPoblaDirPac = "";

  if($("#txtNomAvDirPac").val() != "") {
    var cmbid_av = $("#txtIdAvDirPac option:selected").val();
    var datos = cmbid_av.split("#");
    var id_av = datos[0];
    var abrev_av = datos[1];
    txtNomAvDirPac = abrev_av + " "+$("#txtNomAvDirPac").val();
  }

  if($("#txtNroDirPac").val() != "") {
    txtNroDirPac =  " NRO. " + $("#txtNroDirPac").val();
  }

  if($("#txtIntDirPac").val() != "") {
    txtIntDirPac =  " INT. " + $("#txtIntDirPac").val();
  }

  if($("#txtDptoDirPac").val() != "") {
    txtDptoDirPac =  " DTO. " + $("#txtDptoDirPac").val();
  }

  if($("#txtMzDirPac").val() != "") {
    txtMzDirPac =  " MZ. " + $("#txtMzDirPac").val();
  }

  if($("#txtLtDirPac").val() != "") {
    txtLtDirPac =  " LT. " + $("#txtLtDirPac").val();
  }

  if($("#txtNomPoblaDirPac").val() != "") {
    var cmbid_po = $("#txtIdPoblaDirPac option:selected").val();
    var datospo = cmbid_po.split("#");
    var id_po = datospo[0];
    var abrev_po = datospo[1];
    txtNomPoblaDirPac =  " " + abrev_po + " "+$("#txtNomPoblaDirPac").val();
  }

  var dirpac = txtNomAvDirPac + txtNroDirPac + txtIntDirPac + txtDptoDirPac + txtMzDirPac + txtLtDirPac + txtNomPoblaDirPac;
  dirpac = dirpac.trim();
  $("#txtDirPac").val(dirpac);
}

function maxlength_doc_bus() {
  if ($("#txtIdTipDoc").val() == "1") {
    $("#txtNroDocPac").attr('maxlength', '8');
  } else {
    $("#txtNroDocPac").attr('maxlength', '15');
  }
  $("#txtNroDocPac").val('');
  $("#txtNroDocPac").focus();
  $('#txtNroDocPac').trigger('focus');
  setTimeout(function(){$('#txtNroDocPac').trigger('focus');}, 2);
}

function campoSiguiente(campo, evento) {
  if (evento.keyCode == 13 || evento.keyCode == 9) {
    if (campo == 'btnPacSearch') {
      buscar_datos_personales('editlaboratorio');
    } else if (campo == 'btnSoliSearch') {
      buscar_datos_personalessoli('editlaboratorio');
    } else if (campo == 'txtUBIGEOPac') {
      $('#txtUBIGEOPac').select2('open');
    } else if (campo == 'txtAtenUrgente') {
      //$('#txtIdProducto').select2('open');
    } else if (campo == 'txtFechaAten') {
      //buscar_datos_sis();
      setTimeout(function(){$('#txtIdTipAtencion').trigger('focus');}, 2);
    } else if (campo == 'txtIdSexoPac') {
      if ($('#txtIdSexoPac').val() == ""){
        setTimeout(function(){$('#txtIdSexoPac').trigger('focus');}, 2);
      } else {
        if ($('#txtFecNacPac').val() == ""){
          setTimeout(function(){$('#txtFecNacPac').trigger('focus');}, 2);
        } else {
          if ($('#txtNomPac').val() != ""){
            setTimeout(function(){$('#txtNroTelFijoPac').trigger('focus');}, 2);
          } else {
            document.getElementById(campo).focus();
            evento.preventDefault();
          }
        }
      }
    } else if (campo == 'txtNomPac') {
      if ($('#txtNomPac').val() != ""){
        setTimeout(function(){$('#txtNroTelFijoPac').trigger('focus');}, 2);
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    } else if (campo == 'txtIdTipDocSoli') {
      if ($('#txtEdadPac').val() != "") {
        var edad = parseInt($('#txtEdadPac').val(), 10);
        if (edad >= 17){
          habilita_atencion();
        } else {
          document.getElementById(campo).focus();
          evento.preventDefault();
        }
      } else {
        document.getElementById(campo).focus();
        evento.preventDefault();
      }
    }  else if (campo == 'txtIdPlanTari') {
      habilita_atencion();
    } else {
      document.getElementById(campo).focus();
      evento.preventDefault();
    }
  }
}

function habilita_atencionubi(){
  //$('#txtIdPlanTari').prop("disabled", false);
  //$('#txtFechaAten').prop("disabled", false);
  $('#txtIdTipAtencion').prop("disabled", false);
  if($("#txtIdSexoPac").val() == "1"){
	  $('#txtIdGestante').prop("disabled", true); 
  } else {
	 $('#txtIdGestante').prop("disabled", false); 
  }
  
  setTimeout(function(){$('#txtIdAvDirPac').trigger('focus');}, 2);
}

function habilita_atencion(){
  $('#txtIdPlanTari').prop("disabled", false);
  $('#txtFechaAten').prop("disabled", false);
  $('#txtIdTipAtencion').prop("disabled", false);
  setTimeout(function(){$('#txtIdPlanTari').trigger('focus');}, 2);
}

function buscar_datos_sis(){
}

$(document).ready(function() {

	$.ajax({
		  url: "../../controller/ctrlAtencion.php",
		  type: "POST",
		  dataType: "json",
		  data: {
			accion: 'GET_SHOW_LISTATARIFADEPPORIDTIPPLAN', labIdDep: "<?php echo $rsA[0]['id_dependencia'];?>"
		  },
		  success: function (result) {
			var newOption = "";
			newOption = "<option value=''>--Seleccionar-</option>";
			$(result).each(function (ii, oo) {
				newOption += "<option value='" + oo.id_plan + "#" + oo.check_precio + "'"
				if(oo.id_plan + "#" + oo.check_precio == "<?php echo $rsA[0]['id_plantarifario']."#".$rsA[0]['checkprecio_plan']?>"){
					newOption += " selected";
				}
				newOption += ">" + oo.nom_plan + "</option>";
			});
			$('#txtIdPlanTari').html(newOption);
		}
	});
	
	$('#txtIdTipDocPac').val('<?php echo $rsA[0]["id_tipodocpac"]; ?>');
	$('#txtNroDocPac').val('<?php echo $rsA[0]["nro_docpac"]; ?>');

	<?php if($rsA[0]["id_tipodocsoli"] <> ""){ ?>
		$('#txtIdTipDocSoli').val('<?php echo $rsA[0]["id_tipodocsoli"]; ?>');
	<?php } ?>
	$('#txtNroDocSoli').val('<?php echo $rsA[0]["nrodoc_soli"]; ?>');
	
	setTimeout(function(){buscar_datos_personales('editlaboratorio');}, 2);
  
	$('#txtFecNacPac').datetimepicker({
		locale: 'es',
		format: 'L'
    });
    $('#txtFecNacPac').inputmask();

	var date = new Date();
    date.setDate(date.getDate() - 7);

    $('#txtFechaAten').datetimepicker({
		locale: 'es',
		format: 'L',		
    });
    $('#txtFechaAten').inputmask();

	$("#txtIdPaisNacPac").select2();
	$("#txtIdEtniaPac").select2();
    $("#txtUBIGEOPac").select2();
    $("#txtIdServicio").select2();
    $("#txtIdDepRef").select2();
    $("#txtIdProducto").select2({
		tags: true
	});
    $("#txtIdParenSoli").select2();

    //setTimeout(function(){$('#txtNroDoc').trigger('focus');}, 2);

    $("body").tooltip({ selector: '[data-toggle=tooltip]' });

    $("#txtFechaAten").focusout(function () {
		fechaaten = $(this).val();
		if(fechaaten != ""){
			obtener_nroatencion(fechaaten);
		} else {
			$("#txtNroRefAtencion").val('');
		}
    });
  
	setTimeout(function(){
		if($('#txtNroDocSoli').val() != ""){
			buscar_datos_personalessoli('editlaboratorio');
			$("#txtIdParenSoli").val('<?php echo $rsA[0]["id_parentescosoli"]; ?>').trigger("change");
		}

		$('#txtIdServicio').prop("disabled", false);
		$('#txtDirRefPac').prop("readonly", false);
		/*if($("#txtIdTipAtencion").val() == "2"){
			$('#txtIdDepRef').prop("disabled", false);
			$('#txtNroRefDep').prop("readonly", false);
			$('#txtAnioRefDep').prop("readonly", false);
			$('#txtIdServicio').prop("disabled", false);
		} else if($("#txtIdTipAtencion").val() == "4"){
			$('#txtIdDepRef').prop("disabled", true);
			$('#txtNroRefDep').prop("readonly", true);
			$('#txtAnioRefDep').prop("readonly", true);
			$('#txtIdServicio').prop("disabled", false);
		} else {
			$("#txtIdDepRef").val('').trigger("change");
			$('#txtIdDepRef').prop("disabled", true);
			$('#txtNroRefDep').prop("readonly", true);
			$('#txtAnioRefDep').prop("readonly", true);
			$('#txtIdServicio').prop("disabled", true);
		}*/
	}, 3);
	
	setTimeout(function(){
		$('#txtSegApePac').prop("readonly", true);
		<?php
		$rsCtp = $at->get_datosProductoPorIdAtencion($idAtencion);
		foreach ($rsCtp as $rowP) {
		  ?>
		  addRow('<?php echo $rowP['id_producto'] . "#".$rowP['codref_producto']."#".$rowP['nomtipo_producto']."#".$rowP['precio']."#".$rowP['precio']."#".$rowP['nom_producto']?>');
		  <?php
		}
		?>
	}, 1000);
		
	$("#txtFecNacPac").focusout(function () {
		//alert(<?php echo $rsA[0]["fec_atencion"]?>);
	fecha_fin = '<?php echo $rsA[0]["fec_atencion"]?>';//$("#txtFecNacPac").val();
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
	
	$("#txtNombreMedico").autocomplete({
		source: "../../controller/ctrlLab.php?accion=GET_MEDICO_POR_EESS",
		minLength: 3,
		select: function (event, ui) {
		}
	});
	$("#txtNroDocPac").attr('maxlength', '15');
});
</script>
<?php require_once '../include/masterfooter.php'; ?>
