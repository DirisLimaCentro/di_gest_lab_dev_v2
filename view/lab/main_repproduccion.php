<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';

require_once '../../model/Profesional.php';
$prof = new Profesional();
require_once '../../model/Producto.php';
$pr = new Producto();

$a_date = date("Y-m-d");
$fecIni = date("01/m/Y", strtotime($a_date));
?>
<style>
div.dt-buttons {
  float: left;
}
div.dataTables_length {
  float: right;
  text-align: right;
}
div.dataTables_info {
  float: left;
}
div.dataTables_paginate paging_simple_numbers {
  float: right;
  text-align: right;
}

@media screen and (max-width: 450px) {
  div.dt-buttons {
    float: none;
    text-align: center;
  }
  div.dataTables_length {
    float: none;
  }
  div.dataTables_info {
    float: none;
  }
  div.dataTables_paginate paging_simple_numbers {
    float: none;
  }
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
      <h3 class="panel-title"><strong>REPORTE DE PRODUCCIÓN</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3">
          <div class="box box-success">
            <br/>
            <div class="box-body box-profile">
				<div class="col-xs-12">
				<h3 class="profile-username text-center">Año y mes seleccionado</h3>
				  <div class="form-group">
					<div class="row">
					  <div class="col-sm-6">
						<label for="txt_bus_anio">Año</label>
						<select class="form-control" name="txt_bus_anio" id="txt_bus_anio" onchange="buscar_cnt_produccion_por_mes()">
							<option value=""> -- Seleccione -- </option>
							<?php
								$year_init = 2022;
								$year_curent = (int)(date('Y')) + 1;
								for ($i = $year_init; $i <= $year_curent; $i++) {
									echo "<option value='$i'"; if($i == date('Y')) echo " selected";
									echo ">$i</option>";
								}
							?>
						</select>
					  </div>
					  <div class="col-sm-6">
						<label for="txt_bus_mes">Mes</label>
						<select class="form-control" name="txt_bus_mes" id="txt_bus_mes" onchange="buscar_cnt_produccion_por_mes()">
							<option value=""> -- Seleccione -- </option>
							<?php
								$month_curent = date('m');
								$meses_arr = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
								"Agosto","Setiembre","Octubre","Noviembre","Diciembre"];

								for ($i = 1; $i <= count($meses_arr); $i++) {
									echo "<option value='$i'"; if($month_curent == $i){ echo " selected";}  echo ">" . $meses_arr[$i - 1] . "</option>";
								}
							?>
						</select>
					  </div>
					</div>
				  </div>
				  <hr/>
				  <h3 class="profile-username text-center">Pacientes atendidos en admisión</h3>
				  <div id="cntSIS"></div>
				  <button type="button" class="btn btn-primary btn-block" id="btnOpenIng" onclick="open_ing_cantidad()"><i class="glyphicon glyphicon-plus"></i> Ingresar cantidad de un examen </button>
				  <button type="button" class="btn btn-warning btn-block" id="btnExportCnt" onclick="expor_cantidad()"><i class="glyphicon glyphicon-open"></i> Exportar cantidad mensual </button>
				  <button type="button" class="btn btn-info btn-block" id="btnOpenBac" onclick="open_expor_bac()"><i class="glyphicon glyphicon-open"></i> Exportar informe Bacteriologico </button>
				</div>
            </div>
		  </div>
        </div>
        <div class="col-sm-9">
			  <div class="box box-primary">
				  <div class="box-body box-profile">
						<form name="frmBus" id="frmBus" class="form-horizontal">
							  <label class="radio-inline">
								<input type="radio" name="chk_tipo_resultado" id="chk_tipo_resultado" value="1" checked> VALIDADOS
							  </label>
							  <label class="radio-inline">
								<input type="radio" name="chk_tipo_resultado" id="chk_tipo_resultado" value="0"> INGRESO RESULTADO
							  </label>
							<div class="form-group">
							  <div class="col-sm-2 col-md-2">
								<label for="txtBusAnioAsis"><small>Fecha Inicio:</small></label>
								<div class="input-group date">
								  <div class="input-group-addon">
									<i class="glyphicon glyphicon-calendar"></i>
								  </div>
								  <input type="text" class="form-control pull-right input-sm" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo $fecIni ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguientePersona('txtBusFecFin', event);"/>
								</div>
							  </div>
							  <div class="col-sm-2 col-md-2">
								<label for="txtBusAnioAsis"><small>Fecha Final:</small></label>
								<div class="input-group date">
								  <div class="input-group-addon">
									<i class="glyphicon glyphicon-calendar"></i>
								  </div>
								  <input type="text" class="form-control pull-right input-sm" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
								</div>
							  </div>
							  <div class="col-sm-4 col-md-4">
								<br/>
								<label class="radio-inline">
								  <input type="radio" name="opt_gestante" id="opt_gestante99" value="99" checked> Todos
								</label>
								<label class="radio-inline">
								  <input type="radio" name="opt_gestante" id="opt_gestante1" value="1"> Gestante
								</label>
								<label class="radio-inline">
								  <input type="radio" name="opt_gestante" id="opt_gestante0" value="0"> No gestante
								</label>
							  </div>
							  <div class="col-sm-4 col-md-3">
								  <div class="row">
									<div class="col-sm-12">
									  <label for="txt_condicion_eg">Edad gestacional:</label>
									</div>
								  </div>
								  <div class="row">
									<div class="col-xs-4" style="padding-right: 0!important;">
									  <select class="form-control input-sm" name="txt_condicion_eg" id="txt_condicion_eg" disabled>
										<option value="">Todas las EG</option>
										<option value="<">EG menor a </option>
										<option value="=">EG igual a </option>
										<option value=">">EG mayor a</option>
									  </select>
									</div>
									<div class="col-xs-8" style="padding-left: 0!important;">
										<input type="text" class="form-control input-sm" id="txt_nro_eg" disabled>
									</div>
								  </div>
							   </div>
								<div class="col-sm-3">
									<label for="txt_bus_id_producto"><small>Examen/Perfil:</small></label>
									<?php $rsP = $pr->get_listaProductoLaboratorio(); ?>
									<select name="txt_bus_id_producto" id="txt_bus_id_producto" class="form-control">
									  <option value="">-- Todos --</option>
									  <?php
									  foreach ($rsP as $row) {
										echo "<option value='" . $row['id_producto'] . "'>" . $row['nom_producto'] . "</option>";
									  }
									  ?>
									</select>
								</div>
								<div class="col-sm-3 col-md-3">
								<div class="row">
									<div class="col-sm-12">
									  <small><label class="checkbox-inline"><input type="checkbox" name="chk_condicion_edad" id="chk_condicion_edad" value="1"> Por edades?</label></small>
									</div>
								  </div>
								  <div class="row">
									<div class="col-xs-6" style="padding-right: 0!important;">
										<input type="text" class="form-control input-sm" id="txt_edad_desde" placeholder="Desde" value="" disabled>
									</div>
									<div class="col-xs-6" style="padding-left: 0!important;">
										<input type="text" class="form-control input-sm" id="txt_edad_hasta" placeholder="Hasta" value="" disabled>
									</div>
								  </div>
							  </div>
							  <div class="col-sm-3">
									<label for="txtIdProfesional"><small>Procesado por:</small></label>
									<?php $rsP = $prof->get_ListaProfesionalPoridServicioAndIdDependencia($labIdDepUser, 9); ?>
									<select name="txtBusIdProfe" id="txtBusIdProfe" class="form-control input-sm"  <?php if($labIdRolUser == "9") echo " disabled"?>>
									  <option value="">Todos</option>
									  <?php
									  foreach ($rsP as $row) {
										echo "<option value='" . $row['id_usuario'] . "'"; if($labIdRolUser == "9") if($row['id_usuario'] == $labIdUser) echo "selected"; echo ">" . $row['primer_ape'] . " " . $row['segundo_ape'] . " " . $row['nombre_rs'] . " (" . $row['estado_usuario'] . ")</option>";
									  }
									  ?>
									</select>
							  </div>
							  <div class="col-sm-2">
								<br/>
								<button class="btn btn-success btn-sm" type="button" id="btnCon" onclick="buscar_datos();" tabindex="0" style="width: 100%"><i class="glyphicon glyphicon-search"></i> Buscar</button>
							  </div>
							</div>
						</form>
					<br/>
						<div class="row">
							<div class="col-xs-12">
							<table id="tblAtencion" class="display" cellspacing="0" width="100%">
							  <thead class="bg-aqua">
								<tr>
								  <th>PRODUCTO</th>
								  <th>#<br/>ATENCION</th>
								  <th>PLAN<br/>TARIFARIO</th>
								  <th>FECHA<br/>ATENCION</th>
								  <th>FECHA<br/>RESULTADO</th>
								  <th>USUARIO<br/>RESULTADO</th>
								  <th>FECHA<br/>VALIDACION</th>
								  <th>USUARIO<br/>VALIDACION</th>
								</tr>
							  </thead>
							  <tbody>
							  </tbody>
							</table>
							</div>
					  </div>
				</div>
			</div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-info pull-right" id="btnBackForm" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Ir al Menú</button>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_add_examen" role="dialog" data-backdrop="static">
	<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h2 class="modal-title">AGREGAR CANTIDAD DE EXAMEN</h2>
		</div>
		<div class="modal-body">
		<input type="hidden" name="txt_id_cnt_prod_mes" id="txt_id_cnt_prod_mes" value="0"/>
		<div class="row">
		 <div class="form-group">
			<div class="col-sm-6">
				<label for="txt_cnt_anio">AÑO</label>
				<select class="form-control" name="txt_cnt_anio" id="txt_cnt_anio">
					<option value=""> -- Seleccione -- </option>
					<?php
						$year_init = 2022;
						$year_curent = (int)(date('Y')) + 1;
						for ($i = $year_init; $i <= $year_curent; $i++) {
							echo "<option value='$i'"; if($i == date('Y')) echo " selected";
							echo ">$i</option>";
						}
					?>
				</select>
			</div>
			<div class="col-sm-6">
				<label for="txt_cnt_mes">MES</label>
				<select class="form-control" name="txt_cnt_mes" id="txt_cnt_mes">
					<option value=""> -- Seleccione -- </option>
					<?php
						$month_curent = date('m');
						$meses_arr = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
						"Agosto","Setiembre","Octubre","Noviembre","Diciembre"];

						for ($i = 1; $i <= count($meses_arr); $i++) {
							echo "<option value='$i'"; if($month_curent == $i){ echo " selected";}  echo ">" . $meses_arr[$i - 1] . "</option>";
						}
					?>
				</select>
			</div>
		  </div>
		 </div>
		 <div class="row">
			 <div class="form-group">
			 <div class="col-sm-12">
			 <label for="txt_id_producto">EXAMEN:</label>
				<select class="form-control" name="txt_id_producto" id="txt_id_producto" style="width: 100%">
				  <option value="">--Seleccione--</option>
				  <?php
				  $rsP = $pr->get_listaProductoLaboratorioPorIdDep($labIdDepUser);
				  foreach ($rsP as $rowP) {
					echo "<option value='" . $rowP['id_producto'] ."'>" . $rowP['nom_producto'] . "</option>";
				  }
				  ?>
				</select>
			 </div>
			 </div>
		 </div>
		 <div class="row">
			 <div class="form-group">
				<div class="col-sm-3">
					<label for="txt_cnt_sis_producto">AUS:</label>
					<input type="text" name="txt_cnt_sis_producto" id="txt_cnt_sis_producto" class="form-control input-sm" onfocus="this.select()" maxlength="4" onkeyup="totales();" value="0"/>
				</div>
				<div class="col-sm-3">
					<label for="txt_cnt_pag_producto">PAGANTE:</label>
					<input type="text" name="txt_cnt_pag_producto" id="txt_cnt_pag_producto" class="form-control input-sm" onfocus="this.select()" maxlength="4" onkeyup="totales();" value="0"/>
				</div>
				<div class="col-sm-3">
					<label for="txt_cnt_est_producto">ESTRATEGIA:</label>
					<input type="text" name="txt_cnt_est_producto" id="txt_cnt_est_producto" class="form-control input-sm" onfocus="this.select()" maxlength="4" onkeyup="totales();" value="0"/>
				</div>
				<div class="col-sm-3">
					<label for="txt_cnt_exo_producto">EXONERADO:</label>
					<input type="text" name="txt_cnt_exo_producto" id="txt_cnt_exo_producto" class="form-control input-sm" onfocus="this.select()" maxlength="4" onkeyup="totales();" value="0"/>
				</div>
			 </div>
			 <hr/>
			 <br/>
			 <div class="form-group">
				<div class="col-sm-9 text-right">
					<label class="">TOTAL:</label>
				</div>
				<div class="col-sm-3">
					<input type="text" name="txt_cnt_total" id="txt_cnt_total" class="form-control input-sm" maxlength="4" value="0" disabled/>
				</div>
			 </div>
		 </div>
		</div>
		<div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-primary btn-continuar" id="btnFrmSaveIngExa" onclick="save_ing_cantidad()"><i class="fa fa-save"></i> Guardar </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
            </div>
          </div>
        </div>
	</div>
	</div>
</div>

<div class="modal fade" id="modal_rep_bac" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h2 class="modal-title">EXPORTAR INFORME BACTERIOLOGICO</h2>
		</div>
		<div class="modal-body">
			<button type="button" class="btn btn-success btn-block" id="btn_conso_bac" onclick="expor_bac('1')"> Exportar consolidado </button>
			<button type="button" class="btn btn-info btn-block" id="btn_det_bac" onclick="expor_bac('2')"> Exportar detalle </button>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar</button>
        </div>
	</div>
	</div>
</div>


<?php require_once '../include/footer.php'; ?>
<script src="../../assets/plugins/multiselect/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="../../assets/plugins/multiselect/bootstrap-multiselect.css" type="text/css"/>
<script Language="JavaScript">

$(function() {
	jQuery('#txt_cnt_sis_producto').keypress(function (tecla) {
		if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
		return false;
	});
	jQuery('#txt_cnt_parti_producto').keypress(function (tecla) {
		if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
		return false;
	});
	jQuery('#txt_cnt_est_producto').keypress(function (tecla) {
		if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
		return false;
	});
	jQuery('#txt_cnt_exo_producto').keypress(function (tecla) {
		if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
		return false;
	});
	
	/*$('#txt_id_producto').on("change", function(e) { 
		$('#txt_cnt_sis_producto').trigger('focus');
	});*/

	$('[name="opt_gestante"]').change(function(){
		if ($(this).is(':checked')) {
		  if($(this).val() == "1"){
			$("#txt_condicion_eg").prop('disabled', false);
			$("#txt_nro_eg").prop('disabled', false);
			$("#txt_condicion_eg").val('');
			$("#txt_nro_eg").val('');
		  } else {
			$("#txt_condicion_eg").prop('disabled', true);
			$("#txt_nro_eg").prop('disabled', true);
			$("#txt_condicion_eg").val('');
			$("#txt_nro_eg").val('');
		  }
		};
	});

	$('[name="chk_condicion_edad"]').change(function(){
		if ($(this).is(':checked')) {
			$("#txt_edad_desde").prop('disabled', false);
			$("#txt_edad_desde").val('');
			$("#txt_edad_hasta").prop('disabled', false);
			$("#txt_edad_hasta").val('');
			setTimeout(function(){$('#txt_edad_desde').trigger('focus');}, 2);
		} else {
			$("#txt_edad_desde").prop('disabled', true);
			$("#txt_edad_desde").val('');
			$("#txt_edad_hasta").prop('disabled', true);
			$("#txt_edad_hasta").val('');			
		}
	});
});

function totales() {
  var a = parseInt($("#txt_cnt_sis_producto").val());
  var b = parseInt($("#txt_cnt_pag_producto").val());
  var c = parseInt($("#txt_cnt_est_producto").val());
  var d = parseInt($("#txt_cnt_exo_producto").val());
  var total = a + b + c + d;
  $("#txt_cnt_total").val(total);
}


function open_ing_cantidad(){
	$("#txt_id_producto").val('').trigger("change");
	$("#txt_cnt_sis_producto").val('0');
	$("#txt_cnt_pag_producto").val('0');
	$("#txt_cnt_est_producto").val('0');
	$("#txt_cnt_exo_producto").val('0');
	$("#txt_cnt_total").val('0');
	
	$('#modal_add_examen').modal({
		show: true,
		backdrop: 'static',
		focus: true,
	});
}

function open_expor_bac(){
	$('#modal_rep_bac').modal({
		show: true,
		backdrop: 'static',
		focus: true,
	});
}

function save_ing_cantidad() {
	$.ajax( {
		type: 'POST',
		url: '../../controller/ctrlLab.php',
		data: "id_cnt_prod_mes=" + $('#txt_id_cnt_prod_mes').val() + "&id_producto=" + $('#txt_id_producto').val() + "&anio=" + $('#txt_cnt_anio').val() + "&mes=" + $('#txt_cnt_mes').val() 
		+ "&cnt_sis_producto=" + $('#txt_cnt_sis_producto').val() + "&cnt_pag_producto=" + $('#txt_cnt_pag_producto').val() + "&cnt_est_producto=" + $('#txt_cnt_est_producto').val() + "&cnt_exo_producto=" + $('#txt_cnt_exo_producto').val() 
		+ "&cnt_total=" + $('#txt_cnt_total').val() + "&txtTipIng=S&accion=POST_ADD_REGCNTEXAMENPORMESANIO",
		success: function(data) {
			var tmsg = data.substring(0, 2);
			var lmsg = data.length;
			var msg = data.substring(3, lmsg);
			//console.log(tmsg);
			if(tmsg == "OK"){
				$('#modal_add_examen').modal("hide");
				buscar_cnt_produccion_por_mes();
			} else {
			  $('#btn-submit').prop("disabled", false);
			  showMessage(msg, "error");
			  return false;
			}
		}
	});
}

function buscar_datos() {
  var fecIni = $("#txtBusFecIni").val();
  var fecFin = $("#txtBusFecFin").val();

  var msg = "";
  var sw = true;

  if (fecIni != "") {
    if (fecFin == "") {
      msg+= "Ingrese Fecha Final<br/>";
      sw = false;
    }
  }

  if (fecIni != "") {
    if (validarFormatoFecha(fecIni) == false) {
      msg+= "Ingrese Fecha de Inicio Correctamente<br/>";
      sw = false;
    }
  }
  if (fecFin != "") {
    if (validarFormatoFecha(fecFin) == false) {
      msg+= "Ingrese Fecha Final Correctamente<br/>";
      sw = false;
    }
  }

  f1 = fecIni.split("/");
  f2 = fecFin.split("/");

  var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
  var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

  if (f1 > f2) {
    msg+= "La Fecha de Incio debe ser menor o igual a la fecha Final<br/>";
    sw = false;
  }

  if (sw == false) {
    bootbox.alert(msg);
    return false;
  }

  //buscar_datossis();
  $("#tblAtencion").dataTable().fnDraw();
}


function expor_bac(opt) {
    var anio = $("#txt_bus_anio").val();
    var mes = $("#txt_bus_mes").val();

    $('#titleModalAlert').text('Mensaje de Alerta ...');

	if (anio == "") {
		$('#infoModalAlert').text('Seleccione anio');
		$('#alertModal').modal("show");
		return false;
	}
	if (mes == "") {
		$('#infoModalAlert').text('Seleccione mes');
		$('#alertModal').modal("show");
		return false;
	}

	if(opt == "1"){
		var urlwindow = "pdf_produccion_bac_con.php?anio="+ anio + "&mes=" + mes;
	} else {
		var urlwindow = "pdf_produccion_bac_det.php?anio="+ anio + "&mes=" + mes;
	}
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}


function exporbuscar_datos() {
	var msg = "";
	var sw = true;
  
    var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();
	var chk_gestante = $("input[type=radio][name=opt_gestante]:checked").val();
	var condicion_eg = $("#txt_condicion_eg").val();
	var nro_eg = $("#txt_nro_eg").val();
	if($("#txt_bus_id_producto").val() !== null){
		var id_producto = $("#txt_bus_id_producto").val();
	} else {
		var id_producto = "";
	}
	if(document.getElementById("chk_condicion_edad").checked==true){
		var condicion_edad="1";
	}else{
		var condicion_edad='';
	}
	var edad_desde = $("#txt_edad_desde").val();
	var edad_hasta = $("#txt_edad_hasta").val();

    if (fecIni != "") {
      if (fecFin == "") {
        msg+= 'Ingrese Fecha Final.';
		sw = false;
      }
    }

    if (fecIni != "") {
      if (validarFormatoFecha(fecIni) == false) {
        msg+= 'Ingrese Fecha de Inicio Correctamente.';
		sw = false;
      }
    }
    if (fecFin != "") {
      if (validarFormatoFecha(fecFin) == false) {
        msg+= 'Ingrese Fecha Final Correctamente.';
		sw = false;
      }
    }

    f1 = fecIni.split("/");
    f2 = fecFin.split("/");

    var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
    var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

    if (f1 > f2) {
		msg+= 'La Fecha de Incio debe ser menor o igual a la fecha Final.';
		sw = false;
    }
	
    if (id_producto == "") {
		msg+= 'Seleccione almenos un examen.';
		sw = false;
    }
	
	if (sw == false) {
		bootbox.alert(msg);
		return false;
	} 

	window.location = "./xls_repproduccion.php?tipo_resultado=" + $("#chk_tipo_resultado").val() + "&id_usuprofesional=" + $("#txtBusIdProfe").val() + "&fecIni="+ fecIni + "&fecFin=" + fecFin + "&chk_gestante=" + chk_gestante + "&condicion_eg=" + condicion_eg + "&nro_eg=" + nro_eg + "&id_producto=" + id_producto + "&condicion_edad=" + condicion_edad + "&edad_desde=" + edad_desde + "&edad_hasta=" + edad_hasta + "&nom_producto=" + $('select[name="txt_bus_id_producto"] option:selected').text();
}

function buscar_cnt_produccion_por_mes(){
  $.ajax({
    url: "../../controller/ctrlAtencion.php",
    type: "POST",
    data: {
      accion: 'GET_CNTRESULTADOSPORANIOMESANDPLANTARIFARIO', anio: $("#txt_bus_anio").val(), mes: $("#txt_bus_mes").val()
    },
    success: function (registro) {
      $("#cntSIS").html(registro);
    }
  });
}

function save_delet_cantidad(id, cnt) {
	bootbox.confirm({
		message: "Se <b class='text-danger'>eliminará</b> la cantidad (<b>" + cnt + "</b>) del examen seleccionado.<br/>¿Está seguro de continuar?",
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
			  "accion": "POST_DELET_REGCNTEXAMENPORMESANIO",
			  "id_cnt_prod_mes": id
			};
			$.ajax({
			  data: parametros,
			  url: '../../controller/ctrlLab.php',
			  type: 'post',
			  success: function (rs) {
				buscar_cnt_produccion_por_mes();
			  }
			});
		  } else {
			
		  }
		}
	});
}


function expor_cantidad(id) {
	//btnExportCnt
	/*var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();

    $('#titleModalAlert').text('Mensaje de Alerta ...');

    if (fecIni != "") {
      if (fecFin == "") {
        $('#infoModalAlert').text('Ingrese Fecha Final.');
        $('#alertModal').modal("show");
        return false;
      }
    }

    if (fecIni != "") {
      if (validarFormatoFecha(fecIni) == false) {
        $('#infoModalAlert').text('Ingrese Fecha de Inicio Correctamente.');
        $('#alertModal').modal("show");
        return false;
      }
    }
    if (fecFin != "") {
      if (validarFormatoFecha(fecFin) == false) {
        $('#infoModalAlert').text('Ingrese Fecha Final Correctamente.');
        $('#alertModal').modal("show");
        return false;
      }
    }

    f1 = fecIni.split("/");
    f2 = fecFin.split("/");

    var f1 = new Date(parseInt(f1[2]), parseInt(f1[1] - 1), parseInt(f1[0]));
    var f2 = new Date(parseInt(f2[2]), parseInt(f2[1] - 1), parseInt(f2[0])); //30 de noviembre de 2014

    if (f1 > f2) {
      $('#infoModalAlert').text('La Fecha de Incio debe ser menor o igual a la fecha Final.');
      $('#alertModal').modal("show");
      return false;
    }*/
	
  //window.location = './xls_cnt_produccion.php?fecIni='+$("#txtBusFecIni").val()+'&fecFin='+$("#txtBusFecFin").val();
  window.location = './xls_cnt_produccion.php?anio='+$("#txt_bus_anio").val()+'&mes='+$("#txt_bus_mes").val();
}


function back() {
  window.location = '../pages/';
}

var dTable;

$(document).ready(function () {
  buscar_cnt_produccion_por_mes();
  
  $("#txt_id_producto").select2();
  $("#txt_bus_id_producto").select2();
  
  $("#txtBusFecIni").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });
  $("#txtBusFecFin").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });

	dTable = $('#tblAtencion').DataTable({
		//dom: 'Bltip',
	dom: 'Bltip',
	"buttons": [
	  {
		text: '<i class="glyphicon glyphicon-open"></i> Exportar examen con resultado',
		className: "btn btn-success btn-sm",
		action: function ( e, dt, node, config ) {
		  exporbuscar_datos();
		}
	  }
	],
	//"lengthMenu": [[25, 50, 100 ,250], [25, 50, 100 ,250]],
	"bLengthChange": true, //Paginado 10,20,50 o 100
	"bProcessing": true,
	"bServerSide": true,
	"bJQueryUI": false,
	"responsive": true,
	"bInfo": true,
	"bFilter": false,
	"sAjaxSource": "tbl_repproduccion.php", // Load Data
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
		if(document.getElementById("chk_condicion_edad").checked==true){
			var condicion_edad="1";
		}else{
			var condicion_edad='';
		}
		if($("#txt_bus_id_producto").val() !== null){
			var id_producto = $("#txt_bus_id_producto").val();
		} else {
			var id_producto = "";
		}
		aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
		aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
		aoData.push({"name": "id_usuprofesional", "value": $("#txtBusIdProfe").val()});
		aoData.push({"name": "tipo_resultado", "value": $("#chk_tipo_resultado").val()});
		
		aoData.push({"name": "chk_gestante", "value": $("input[type=radio][name=opt_gestante]:checked").val()});
		aoData.push({"name": "condicion_eg", "value": $("#txt_condicion_eg").val()});
		aoData.push({"name": "nro_eg", "value": $("#txt_nro_eg").val()});
		aoData.push({"name": "id_producto", "value": id_producto});
		aoData.push({"name": "condicion_edad", "value": condicion_edad});
		aoData.push({"name": "edad_desde", "value": $("#txt_edad_desde").val()});
		aoData.push({"name": "edad_hasta", "value": $("#txt_edad_hasta").val()});
	},
	"columnDefs": [
		{"orderable": false, "targets": 0, "searchable": true, "class": "small"},
		{"orderable": false, "targets": 1, "searchable": false, "class": "small text-center"},
		{"orderable": false, "targets": 2, "searchable": false, "class": "small text-center"},
		{"orderable": false, "targets": 3, "searchable": false, "class": "small"},
		{"orderable": false, "targets": 4, "searchable": false, "class": "small"},
		{"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
		{"orderable": false, "targets": 6, "searchable": false, "class": "small"},
		{"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"}
	]
});

$('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');

});
</script>
<?php require_once '../include/masterfooter.php'; ?>
