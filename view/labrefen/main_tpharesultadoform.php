<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<style>
#parent {
  height: 450px;
}
</style>
<?php
require_once '../../model/Producton.php';
$pn = new Producton();
require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/Atencion.php';
$at = new Atencion();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/LabRef.php';
$labr = new LabRef();

$idAtencion = $_GET['nroSoli'];
$rsA = $at->get_datosAtencion($idAtencion);
//print_r($rsA);
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <div class="row">
		<div class="col-sm-6">
			<h3 class="panel-title"><strong>REGISTRAR O MODIFICAR RESULTADO DE TPHA</strong></h3>
		</div>
		<div class="col-sm-6 text-right">
			<h3 class="panel-title"><a href="#" onclick="event.preventDefault(); open_ayuda()">Ayuda <i class="fa fa-question-circle-o" aria-hidden="true"></i></a></h3>
		</div>
	  </div>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-6">
          <form name="frmPaciente" id="frmPaciente">
            <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="<?php echo $_GET['nroSoli']?>"/>
			<input type="hidden" name="txt_id_dependencia" id="txt_id_dependencia" value="<?php echo $rsA[0]['id_dependencia'];?>"/>
            <input type="hidden" name="txtIngResul" id="txtIngResul" value="NO"/>
            <input type="hidden" name="txtShowOptPrint" id="txtShowOptPrint" value=""/>
			<?php if(isset($_GET['id_prod'])){$id_producto=$_GET['id_prod'];} else {$id_producto = 0;} ?>
			<input type="hidden" name="txt_id_producto_selec" id="txt_id_producto_selec" value="<?php echo $id_producto;?>"/>
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>DATOS DE PROCEDENCIA</strong></h3>
              </div>
              <div class="panel-body">
                <div class="row">
				  <div class="col-sm-12">
                    <label for="txtHCPac">Procedencia</label>
                    <input type="text" name="txtNroAtencion" id="txtNroAtencion" class="form-control input-xs" value="<?php echo $rsA[0]['nom_depen']?>" disabled/>
                  </div>
                  <div class="col-sm-4">
                    <label for="txtHCPac">Documento</label>
                    <input type="text" name="txtNroAtencion" id="txtNroAtencion" class="form-control input-xs" value="<?php echo $rsA[0]['abrev_tipodocpac'].": ".$rsA[0]['nro_docpac']?>" disabled/>
                  </div>
                  <div class="col-sm-12 col-md-8">
                    <label for="txtNomPac">Paciente</label>
                    <input type="text" name="txtNomPac" id="txtNomPac" class="form-control input-xs" value="<?php echo $rsA[0]['nombre_rspac']?>" disabled/>
                  </div>
                  <!--<div class="col-sm-1 text-center">
                  <label>Detalle</label><br/>
                  <button type="button" class="btn btn-primary btn-xs" onclick="open_fua('<?php echo $_GET['nroSoli']?>');"><i class="fa fa-h-square"></i></button>
                </div>-->
                <div class="col-sm-8 col-md-4">
                  <label for="txtEdadDiaPac">Edad</label>
                  <input type="text" name="txtDetEdadPac" id="txtDetEdadPac" class="form-control input-xs" value="<?php echo $rsA[0]['edad_anio']." años ". $rsA[0]['edad_mes']. " meses ". $rsA[0]['edad_dia']. " dias."?>" disabled/>
                  <input type="hidden" name="txtEdadAnioPac" id="txtEdadAnioPac" value="<?php echo $rsA[0]['edad_anio'];?>"/>
                  <input type="hidden" name="txtEdadMesPac" id="txtEdadMesPac" value="<?php echo $rsA[0]['edad_mes'];?>"/>
                  <input type="hidden" name="txtEdadDiaPac" id="txtEdadDiaPac" value="<?php echo $rsA[0]['edad_dia'];?>"/>
                </div>
				<div class="col-sm-3 col-md-2">
                  <label for="txtSexoPac">Sexo</label>
                  <input type="text" name="txtSexoPac" id="txtSexoPac" class="form-control input-xs" value="<?php echo $rsA[0]['nom_sexopac']?>" disabled/>
                </div>
              </div>
              <?php
              $nomSexo = $rsA[0]['nom_sexopac'];
              $edadAnio = $rsA[0]['edad_anio'];
              $edadMes =  $rsA[0]['edad_mes'];
              $edadDia =  $rsA[0]['edad_dia'];
              ?>
			</div>
			</div>
        </form>
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title"><strong>DATOS DE ATENCION</strong></h3>
		  </div>
		  <div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
                  <label for="txt_fecha_recepcion"><i class="fa fa-calendar" id="datepicker"></i>Fecha recepción:</label>
				  <input type="text" name="txt_txt_fecha_recepcion" placeholder="DD/MM/AAAA" id="txt_txt_fecha_recepcion" autofocus="" class="form-control input-xs" maxlength="10" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value=""/>
                </div>
				<div class="col-sm-4">
                  <label for="txt_fecha_to_muestra"><i class="fa fa-calendar" id="datepicker"></i>Fecha toma muestra:</label>
				  <input type="text" name="txt_fecha_to_muestra" placeholder="DD/MM/AAAA" id="txt_fecha_to_muestra" autofocus="" class="form-control input-xs" maxlength="10" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value=""/>
                </div>
				<div class="col-sm-4">
                  <label for="txt_fecha_resultado"><i class="fa fa-calendar" id="datepicker"></i>Fecha resultado:</label>
				  <input type="text" name="txt_fecha_resultado" placeholder="DD/MM/AAAA" id="txt_fecha_resultado" autofocus="" class="form-control input-xs" maxlength="10" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value=""/>
                </div>
                <div class="col-sm-6">
                    <label for="txtNroAtencion">Código Generado Netlabv1.:</label>
                    <input type="text" name="txtNroAtencion" id="txtNroAtencion" class="form-control input-sm" value=""/>
                </div>
                <div class="col-sm-6">
                    <label for="txt_id_tipo_poblacion">Tipo población:</label>
                    <?php $rsLR = $labr->get_listaPoblacionTPHA(); ?>
					<select name="txt_id_tipo_poblacion" id="txt_id_tipo_poblacion" style="width:100%;">
					  <option value="" selected="">-- SELECCIONE --</option>
					  <?php
					  foreach ($rsLR as $row) {
						echo "<option value='" . $row['id'] . "'>" . $row['abreviatura_poblacion'] . ": " . $row['nombre_poblacion'] . "</option>";
					  }
					  ?>
					</select>
				</div>
            </div>
			<h5 class="text-bold">PRUEBA DE TAMIZAJE:</h5>
			<div class="row">
                <div class="col-sm-6">
                    <label for="txtNroAtencion">MARCA DE LA PRUEBA</label>
                    <input type="text" name="txtNroAtencion" id="txtNroAtencion" class="form-control" value=""/>
                </div>
                <div class="col-sm-6">
                    <label for="txtNomPac">RESULTADO PRUEBA RÁPIDA</label>
					<?php $rsLR = $labr->get_listaResultadoDetallePorExamen(47); ?>
                    <select name=""  class="form-control">
						<option value=""></option>
						<?php
						  foreach ($rsLR as $row) {
							echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
						  }
						?>
					</select>
				</div>
            </div>
			<h5 class="text-bold">RPR CUALITATIVO Y CUANTITATIVO:</h5>
			<div class="row">
                <div class="col-sm-4">
                    <label for="txtNroAtencion">MARCA DE LA PRUEBA</label>
                    <input type="text" name="txtNroAtencion" id="txtNroAtencion" class="form-control" value=""/>
                </div>
                <div class="col-sm-4">
                    <label for="txtNomPac">RESULTADO DE RPR</label>
					<?php $rsLR = $labr->get_listaResultadoDetallePorExamen(50); ?>
                    <select name=""  class="form-control">
						<option value=""></option>
						<?php
						  foreach ($rsLR as $row) {
							echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
						  }
						?>
					</select>
				</div>
				<div class="col-sm-4">
                    <label for="txtNomPac">DILS</label>
					<?php $rsLR = $labr->get_listaResultadoDetallePorExamen(51); ?>
                    <select name=""  class="form-control">
						<option value=""></option>
						<?php
						  foreach ($rsLR as $row) {
							echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
						  }
						?>
					</select>
				</div>
            </div>
		</div>
		</div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>DATOS DE EXAMENES</strong></h3>
          </div>
          <div class="panel-body">
            <form name="frmArea" id="frmArea">
              <div id="parent">
                <table id="fixTable" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Examen</th>
                      <th>Resultado</th>
                      <th>Valor de referencia</th>
                    </tr>
                  </thead>
                  <tbody>
					<tr>
						<td colspan="3"><b><ins>TPHA:</ins></b></td>
					</tr>
					<tr class="">
						<td style="padding-top: 1px; padding-bottom: 1px;">TPHA</td>
						<td style="padding-top: 1px; padding-bottom: 1px;">
						<?php $rsLR = $labr->get_listaResultadoDetallePorExamen(52); ?>
						<select class="form-control input-sm" id="txt_77_fecha" name="txt_77_fecha">
						<option value=""></option>
						<?php
						  foreach ($rsLR as $row) {
							echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
						  }
						?>
						</select>
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="3" class="success"><b><ins>CONTROL CALIDAD R.P.R.:</ins></b></td>
					</tr>
					<tr class="success">
						<td style="padding-top: 1px; padding-bottom: 1px;">RPR</td>
						<td style="padding-top: 1px; padding-bottom: 1px;">
						<?php $rsLR = $labr->get_listaResultadoDetallePorExamen(50); ?>
						<select class="form-control input-sm" id="txt_77_fecha" name="txt_77_fecha">
							<option value=""></option>
							<?php
							  foreach ($rsLR as $row) {
								echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
							  }
							?>
						</select>
						</td>
						<td></td>
					</tr>
					<tr class="success">
						<td style="padding-top: 1px; padding-bottom: 1px;">DLS</td>
						<td style="padding-top: 1px; padding-bottom: 1px;">
						<?php $rsLR = $labr->get_listaResultadoDetallePorExamen(51); ?>
						<select class="form-control input-sm" id="txt_77_fecha" name="txt_77_fecha">
							<option value=""></option>
							<?php
							  foreach ($rsLR as $row) {
								echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
							  }
							?>							
						</select>
						</td>
						<td></td>
					</tr>
					<tr class="success">
						<td style="padding-top: 1px; padding-bottom: 1px;">GOTAS DE CARBON</td>
						<td style="padding-top: 1px; padding-bottom: 1px;">
							<input type="text"  class="form-control" name="txtNroAtencion" id="txtNroAtencion" value=""/>
						</td>
						<td></td>
					</tr>
					<tr class="">
						<td style="padding-top: 1px; padding-bottom: 1px;">Observaciones</td>
						<td style="padding-top: 1px; padding-bottom: 1px;" colspan="2">
						<textarea class="form-control" id="txt_23_420" name="txt_23_420" rows="3"></textarea>
						</td>
					</tr>
                  </tfoot>
                </table>
              </div>
            </form>
          </div>
			<div class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-center">
				  <div id="saveAtencion">
					<div class="btn-group">
					  <button class="btn btn-info btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="save_atencion('E')"><i class="fa fa-save"></i>  Guardar </button>
					  <button class="btn btn-success btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="save_atencion('EV')"><i class="fa fa-save"></i>  Guardar y validar</button>
					</div>
				  </div>
				  <div id="impriAtencion" style="display: none;">
					<div class="btn-group">
						<button class="btn btn-lg btn-success" id="btn-edit-otro-prod" onclick="open_edit()"  style="display: none;"><i class="glyphicon glyphicon-pencil"></i> Editar resultados</button>
						<button class="btn btn-lg btn-success" id="btn-edit" onclick="open_edit()"  style="display: none;"><i class="glyphicon glyphicon-pencil"></i> Editar resultados</button>
					</div>
				  </div>
				</div>
			  </div>
			</div>
        </div><!-- Fin Datos de Parentesco -->
      </div>
    </div>
  </form>
</div>
<div class="panel-footer">
  <div class="row">
    <div class="col-md-12 text-center">
		<a href="./main_tpharegresultado.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
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
			<p class="text-left small" style="margin: 0 0 0px;"><b>Botones de acción</b>:<br/> <button class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eject"></i></button>=Seleccionar examen para ingresar resultado | <button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-pencil"></i></button>=Seleccionar examen  para editar resultado | <button class="btn btn-warning btn-xs"><i class="fa fa-file-text-o"></i></button>=Imprimir Resultado</p>
			<hr/>
			<h5>Leyenda:</h5>
				<div class="table-responsive">
				  <table class="table table-bordered table-hover">
					<thead>
					  <tr><th><small>COLOR</small></th><th><small>DESCRIPCIÓN</small></th></tr>
					</thead>
					<tbody>
						<tr><td class="active"><small>Plomo</small></td><td><small>Muestra no recibida</small></td></tr>
						<tr><td class="info"><small>Celeste</small></td><td><small>Muestra recibida</small></td></tr>
						<tr><td class="primary"><small>Azul</small></td><td><small>Resultado ingresado pero sin validar</small></td></tr>
						<tr><td class="success"><small>Verde</small></td><td><small>Resultado validado</small></td></tr>
						<tr><td class="warning"><small>Amarrillo</small></td><td><small>Muestra derivada o referenciada a otro EESS</small></td></tr>
					</tbody>
				  </table>
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

function sumComponenteBiliAndProte(id){
	//Alburrina
	if(id == 'txt_53_112' || id == 'txt_53_41'){
		var c = parseFloat($("#txt_53_112").val());
		var r = parseFloat($("#txt_53_41").val());
		var total = c - r;
		if (isNaN(total)){
			total='';
		} else {
			total=total.toFixed(2);
		}
		$("#txt_53_42").val(total);
	}
	
	if(id == 'txt_23_27' || id == 'txt_23_28'){
		var c = parseFloat($("#txt_23_27").val());
		var r = parseFloat($("#txt_23_28").val());
		var total = c - r;
		if (isNaN(total)){
			total='';
		} else {
			total=total.toFixed(2);
		}
		$("#txt_23_29").val(total); //parseInt
	}
	
	//Proteina
	if(id == 'txt_53_113' || id == 'txt_53_140'){
		var c = parseFloat($("#txt_53_113").val());
		var r = parseFloat($("#txt_53_140").val());
		var total = c - r;
		if (isNaN(total)){
			total='';
		} else {
			total=total.toFixed(1);
		}
		$("#txt_53_45").val(total);
	}
	
	if(id == 'txt_22_24' || id == 'txt_22_25'){
		var c = parseFloat($("#txt_22_24").val());
		var r = parseFloat($("#txt_22_25").val());
		var total = c - r;
		if (isNaN(total)){
			total='';
		} else {
			total=total.toFixed(1);
		}
		$("#txt_22_26").val(total);
	}	
}

function open_ayuda(){
  $('#mostrar_ayuda').modal();
}

function reg_resultado(idatencion,id_prod) {
	if(id_prod == ""){
		window.location = './main_editresultadoprod.php?nroSoli='+idatencion;
	} else {
		window.location = './main_editresultadoprod.php?nroSoli='+idatencion + '&id_prod=' + id_prod;
	}
}

function imprime_resultado(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorioprodn.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
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

function imprime_resultado_area(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorio_area.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
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

function open_pdf(idAten, opt, idAreaProd) {
  if(opt == "1"){
    var urlwindow = "pdf_laboratorio.php?id_atencion=" + idAten +"&id_area=" + idAreaProd;
  } else {
    var urlwindow = "pdf_laboratorioprod.php?id_atencion=" + idAten +"&id_prod=0";
  }
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function open_fua(id) {
  window.location = '../fua/genera_fuaxls.php?nroAtencion='+id;
}

function open_edit() {
  var id = $('#txtIdAtencion').val();
  window.location = './main_editresultadoprod.php?nroSoli='+id;
}

function load_focus_inicio(){
  var nameInput = '';
  var AnameInput = $('#frmArea').serializeArray();
  nameInput = AnameInput[0]['name'];
  $("#" + nameInput).trigger('focus');
}

function keyValidValRef(id) {
  var valIng = $('#' + id).val();
  if (valIng != ""){
    valIng = $('#' + id).val();
    var valInf = $('#' + id + "_inf").val();
    var valSup = $('#' + id + "_sup").val();
    valIng = Number(valIng);
    valInf = Number(valInf);
    valSup = Number(valSup);
    if(valIng < valInf){//Menor
      $('#' + id).closest(".form-group").removeClass("has-warning");
      $('#' + id).closest(".form-group").addClass("has-error");
    }
    if(valIng > valSup) {//Mayor
      $('#' + id).closest(".form-group").removeClass("has-error");
      $('#' + id).closest(".form-group").addClass("has-warning");
    }
    if(valIng >= valInf && valIng <= valSup){
      $('#' + id).closest(".form-group").removeClass("has-error");
      $('#' + id).closest(".form-group").removeClass("has-warning");
    }
  } else {
    $('#' + id).closest(".form-group").removeClass("has-error");
    $('#' + id).closest(".form-group").removeClass("has-warning");
  }
}

function reg_recepcionmuestra(id, pac, opt, cntprod) {
	if(opt == "0"){
		bootbox.confirm({
		message: "Se <b class='text-danger'>recibirá</b> todas las muestras de los examenes solicitados. <br/>Paciente: <b>"+pac+"</b><br/>¿Está seguro de continuar?",
		buttons: {
		  confirm: {
			label: '<i class="fa fa-check"></i> Si',
			className: 'btn-success'
		  },
		  cancel: {
			label: '<i class="fa fa-times"></i> No',
			className: 'btn-danger'
		  }
		},
		callback: function (result) {
		  if (result == true) {
			var parametros = {
			  "accion": "POST_REG_RECEPCIONMUESTRA",
			  "id_atencion": id,
			  "id_productoaten": 0,
			  "cnt_producto": cntprod
			};
			$.ajax({
			  data: parametros,
			  url: '../../controller/ctrlAtencion.php',
			  type: 'post',
			  success: function (rs) {
					window.location = './main_editresultadoprod.php?nroSoli='+id;
			  }
			});
		  } else {
			$('#btn-submit').prop("disabled", false);
		  }
		}
		});
	} else {
		var parametros = {
		  "accion": "POST_REG_RECEPCIONMUESTRA",
		  "id_atencion": id,
		  "id_productoaten": opt,
		  "cnt_producto": cntprod
		};
		$.ajax({
		  data: parametros,
		  url: '../../controller/ctrlAtencion.php',
		  type: 'post',
		  success: function (rs) {
			window.location = './main_editresultadoprod.php?nroSoli='+id + '&id_prod=' + pac;
		  }
		});
	}
}

function save_atencion(opt) {
  $('#btn-submit').prop("disabled", true);
  var msg = "";
  var sw = true;

  var AnameInput = $('#frmArea').serializeArray();
  var ing = "";
  len = AnameInput.length;
  for (i=0; i<len; i++) {
    nameInput = AnameInput[i]['name'];
    var arrayCadenas = nameInput.split('_');
    if(arrayCadenas.length == 3){
      if($("#" + nameInput).val().trim() != ""){
        ing = "1";
        break;
      }
    }
  }

  if(ing == ""){
    msg += "Ingrese la información de almenos un exámen<br/>";
    sw = false;
  }

  if (sw == false) {
    bootbox.alert(msg);
    $('#btn-submit').prop("disabled", false);
    return false;
  }

  bootbox.confirm({
    message: "Se registrarán los registros ingresados, ¿Está seguro de continuar?",
    buttons: {
      confirm: {
        label: 'Si',
        className: 'btn-success'
      },
      cancel: {
        label: 'No',
        className: 'btn-danger'
      }
    },
    callback: function (result) {
      if (result == true) {

        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlLab.php',
          data: $('#frmArea').serialize()
          + "&id_atencion=" + $('#txtIdAtencion').val() + "&id_dependencia=" + $('#txt_id_dependencia').val() + "&txt_id_producto_selec=" + $('#txt_id_producto_selec').val() + "&txtNroRefAtencion=" + $('#txtNroRefAtencion').val() + "&accion_sp=" + opt
          + "&accion=POST_EDIT_RESULTADOLAB",
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
				var id = $('#txtIdAtencion').val();
				window.location = './main_editresultadoprod.php?nroSoli='+id;
              /*var AnameInput = $('#frmArea').serializeArray();
              var ing = "";
              len = AnameInput.length;
              for (i=0; i<len; i++) {
                nameInput = AnameInput[i]['name'];
                $("#" + nameInput).prop("disabled", true);
              }
			  $(".tbn-ing-producto").prop("disabled", true);

              $("#saveAtencion").hide();
              $("#impriAtencion").show();
			  if (opt == 'E'){
				  $("#btn-edit").show();
				  $("#btn-imrimirall").hide();
			  } else {
				   if($('#txt_id_producto_selec').val() != "0"){
					  $("#btn-edit-otro-prod").show();
				   }
				  $("#btn-edit").hide();
			  }
              bootbox.alert("El resultado se guardo correctamente.");
              return false;*/
            } else {
              $('#btn-submit').prop("disabled", false);
              showMessage(msg, "error");
              return false;
            }
          }
        });
      } else {
        $('#btn-submit').prop("disabled", false);
      }
    }
  });
}

function show_datos_adicionales(opt) {
  if($('#show-datos-adicionales-'+opt).text() == "+"){
    $('#datos-adicionales-'+opt).show();
    $('#show-datos-adicionales-'+opt).text("-");
  } else {
    $('#datos-adicionales-'+opt).hide();
    $('#show-datos-adicionales-'+opt).text("+");
  }
}

$(document).ready(function() {
  $("#fixTable").tableHeadFixer();
  setTimeout(function(){load_focus_inicio();}, 2);
  $('#txt_id_tipo_poblacion').select2()
});

</script>
<?php require_once '../include/masterfooter.php'; ?>
