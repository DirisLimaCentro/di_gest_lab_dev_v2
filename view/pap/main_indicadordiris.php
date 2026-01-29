<?php require_once '../include/masterheader.php'; ?>
<style>
.panel-body {
  background-color: #ecf0f5;
}

.box-body {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-bottom-right-radius: 3px;
  border-bottom-left-radius: 3px;
  padding: 10px;
}

.info-box-number{
	margin-bottom: 10px;
}
</style>
<?php require_once '../include/header.php'; ?>
<?php
require_once '../include/sidebar.php';

require_once '../../model/Pap.php';
$pap = new Pap();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Indicadores</strong></h3>
    </div>
    <div class="panel-body">
	  <input type="hidden" id="txtBusAnio" value=""/>
	  <input type="hidden" id="txtBusDep" value=""/>
	  <input type="hidden" id="txtBusProf" value=""/>
	  
		<div class="row">
			<div class="col-sm-2">
				<div class="form-group">
					<label for="anio">Año:</label>
					<?php $rsPAPA = $pap->get_repDatosPAPAnioRegistro(); ?>
					<select class="form-control" name="anio" id="anio" onchange="change_anio();">
						<?php
						foreach ($rsPAPA as $rowA) {
						  echo "<option value='" . $rowA['anio'] . "'>" . $rowA['anio'] . "</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label for="mes">Mes:</label>
					<select class="form-control" name="mes" id="mes" onchange="change_anio();" multiple="multiple">
						<option value="1">ENERO</option>
						<option value="2">FEBRERO</option>
						<option value="3">MARZO</option>
						<option value="4">ABRIL</option>
						<option value="5">MAYO</option>
						<option value="6">JUNIO</option>
						<option value="7">JULIO</option>
						<option value="8">AGOSTO</option>
						<option value="9">SETIEMBRE</option>
						<option value="10">OCTUBRE</option>
						<option value="11">NOVIEMBRE</option>
						<option value="12">DICIEMBRE</option>
					</select>
				</div>
			</div>
			<input type="hidden" name="txtBusIdRis" id="txtBusIdRis" value=""/>
			<!--<div class="col-sm-2">
				<div class="form-group">
					<label for="txtBusIdRis">RIS:</label>
					<select class="form-control" name="txtBusIdRis" id="txtBusIdRis" onchange="change_anio();">
						<option value="" selected="">-- Todos --</option>
						<option value="1">RIS I</option>
						<option value="2">RIS II</option>
						<option value="3">RIS III</option>
						<option value="4">RIS VI</option>
						<option value="5">RIS V</option>
						<option value="6">RIS VI</option>
						<option value="7">RIS VII</option>
					</select>
				</div>
			</div>-->
			<div class="col-sm-3">
				<div class="form-group">
					<label for="anio">Establecimiento de procedencia</label>
					<?php $rsD = $d->get_listaDepenInstitucion(); ?>
					<select name="txtBusIdDep" id="txtBusIdDep" style="width:100%;" class="form-control" onchange="change_anio();">
					  <option value="" selected="">-- Todos --</option>
					  <?php
					  foreach ($rsD as $row) {
						echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
					  }
					  ?>
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label for="txtBusIdEstado">Estado muestra</label>
					<select name="txtBusIdEstado" id="txtBusIdEstado" style="width:100%;" class="form-control" onchange="change_anio();">
					  <option value="" selected="">-- Todos --</option>
					  <option value="1">POSITIVO</option>
					  <option value="2">NEGATIVO</option>
					  <option value="3">INSATISFACTORIA</option>
					  <option value="4">RECHAZADA</option>
					  <option value="0">ANULADA</option>
					  <option value="5">ENTREGADA A PACIENTE</option>
					</select>
				</div>
			</div>
			<div class="col-sm-2">
				<label for="">&nbsp;</label>
				<button type="button" class="btn btn-success btn-block" onclick="exportar_detalle('det')"><i class="fa fa-file-excel-o"></i> Exportar detalle</button>
			</div>
		
		</div>
	<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">R</span>
            <div class="info-box-content">
              <span class="info-box-text">REGISTRADAS</span>
              <span class="info-box-number" id="pap_muestraR"></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-default">A</span>
            <div class="info-box-content">
              <span class="info-box-text">ANULADAS</span>
              <span class="info-box-number" id="pap_anulada"></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green">T</span>
            <div class="info-box-content">
              <span class="info-box-text">MUESTRAS</span>
              <span class="info-box-number" id="pap_muestra"></span>
			  <span class="info-box-text text-success text-bold" id="pap_muestrapor">100%</span>
            </div>
          </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-default">SR</span>
            <div class="info-box-content">
              <span class="info-box-text">SIN RESULTADO</span>
              <span class="info-box-number" id="pap_sinresultado"></span>
			  <span class="info-box-text text-default text-bold" id="pap_sinresultadopor"></span>
            </div>
          </div>
        </div>
      </div>
		
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green">N</span>
            <div class="info-box-content">
              <span class="info-box-text">NEGATIVOS</span>
              <span class="info-box-number" id="pap_negativo"></span>
			  <span class="info-box-text text-default text-bold" id="pap_negativopor"></span>
            </div>
          </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-2 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red">P</span>
            <div class="info-box-content">
              <span class="info-box-text">POSITIVOS</span>
              <span class="info-box-number" id="pap_positivo"></span>
			  <span class="info-box-text text-default text-bold" id="pap_positivopor"></span>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow">I</span>
            <div class="info-box-content">
              <span class="info-box-text">INSATISFACTORIAS</span>
              <span class="info-box-number" id="pap_insatisfatorio"></span>
			  <span class="info-box-text text-default text-bold" id="pap_insatisfatoriopor"></span>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red">R</span>
            <div class="info-box-content">
              <span class="info-box-text">RECHAZADAS</span>
              <span class="info-box-number" id="pap_rechazado"></span>
			  <span class="info-box-text text-default text-bold" id="pap_rechazadopor"></span>
            </div>
          </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green">EP</span>
            <div class="info-box-content">
              <span class="info-box-text">ENTREGADO A PACIENTE</span>
              <span class="info-box-number" id="pap_entregadoapac"></span>
			  <span class="info-box-text text-success text-bold" id="pap_entregadoapacpor"></span>
            </div>
          </div>
        </div>
      </div>
	  
	  <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">T</span>
            <div class="info-box-content">
              <span class="info-box-text">< DE 15</span>
              <span class="info-box-number" id="pap_muestra15"></span>
			  <span class="info-box-text text-warning text-bold" id="pap_muestra15por"></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green">T</span>
            <div class="info-box-content">
              <span class="info-box-text">15 - 29</span>
              <span class="info-box-number" id="pap_muestra29"></span>
			  <span class="info-box-text text-warning text-bold" id="pap_muestra29por"></span>
            </div>
          </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-default">T</span>
            <div class="info-box-content">
              <span class="info-box-text">30 - 49</span>
              <span class="info-box-number" id="pap_muestra49"></span>
			  <span class="info-box-text text-warning text-bold" id="pap_muestra49por"></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow">T</span>
            <div class="info-box-content">
              <span class="info-box-text">> DE 50</span>
              <span class="info-box-number" id="pap_muestra50"></span>
			  <span class="info-box-text text-warning text-bold" id="pap_muestra50por"></span>
            </div>
          </div>
        </div>
      </div>
	  
	<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow">S</span>
            <div class="info-box-content">
              <span class="info-box-text">SIS</span>
              <span class="info-box-number" id="pap_muestrasis"></span>
			  <span class="info-box-text text-info text-bold" id="pap_muestrasispor"></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red">PA</span>
            <div class="info-box-content">
              <span class="info-box-text">PARTICULAR</span>
              <span class="info-box-number" id="pap_muestranosis"></span>
			  <span class="info-box-text text-info text-bold" id="pap_muestranosispor"></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">TA</span>
            <div class="info-box-content">
              <span class="info-box-text">TAMIZAJE ANTERIOR</span>
              <span class="info-box-number" id="pap_muestraTA"></span>
			  <span class="info-box-text text-bold" id="pap_muestraTApor"></span>
            </div>
          </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green">PN</span>
            <div class="info-box-content">
              <span class="info-box-text">PACIENTE NUEVA</span>
              <span class="info-box-number" id="pap_muestraPN"></span>
			  <span class="info-box-text text-bold" id="pap_muestraPNpor"></span>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="box box-aqua">
            <div class="box-header with-border">
              <h3 class="box-title">Establecimientos</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="tblEESS" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Establecimiento</th>
                      <th>M</th>
                      <th>N</th>
                      <th>P</th>
                      <th>I</th>
					  <th>R</th>
					  <th>EP</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-left">...</a>
			  <button type="button" class="btn btn-sm btn-success btn-flat pull-right" onclick="exportar_detalle('est')"><i class="fa fa-file-excel-o"></i> Exportar</button>
            </div>
            <!-- /.box-footer -->
          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Reporte mensual</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="tblEESSMes" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Mes</th>
                      <th>M</th>
                      <th>N</th>
                      <th>P</th>
                      <th>I</th>
					  <th>R</th>
					  <th>EP</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-left">...</a>
			  <button type="button" class="btn btn-sm btn-success btn-flat pull-right" onclick="exportar_detalle('men')"><i class="fa fa-file-excel-o"></i> Exportar</button>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Reporte de profesionales</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="tblEESSProf" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
					  <th>Establecimiento de Salud</th>
                      <th>Profesional</th>
                      <th>M</th>
                      <th>N</th>
                      <th>P</th>
                      <th>I</th>
					  <th>R</th>
					  <th>EP</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-left">...</a>
			  <button type="button" class="btn btn-sm btn-success btn-flat pull-right" onclick="exportar_detalle('prof')"><i class="fa fa-file-excel-o"></i> Exportar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
	<form name="send_tabla_xls" id="send_tabla_xls" method="post" action="./xls_indicadordiris.php"></form>
  </div>
</div>
<?php require_once '../include/footer.php'; ?>
<script>

function porcentaje(total, parte, redondear) {
    var total = (parseInt(parte) / parseInt(total) * 100);
	return total.toFixed(redondear) + "%";
}

function loadEESSMes(iddep){
  $("#txtBusDep").val(iddep);
  $("#lblNomBusDep").text(iddep);
  setTimeout(function(){$('#tblEESSMes').DataTable().ajax.reload();}, 2);

  $("#lblNomBusProf").text('TODOS LOS MESES');
  setTimeout(function(){$('#tblEESSProf').DataTable().ajax.reload();}, 2);

  $("#profesional").show();
}

function loadEESSProf(nommes){
  $("#txtBusProf").val(nommes);
  $("#lblNomBusProf").text(nommes);
  setTimeout(function(){$('#tblEESSProf').DataTable().ajax.reload();}, 2);
  $("#profesional").show();
}

function load_totales(){
	anio = $('#anio').val();
	var mes = "";
	if ($('#mes').val() != null) {
		mes = $('#mes').val().join(',');
	}
	id_ris = $('#txtBusIdRis').val();
	id_dependencia = $('#txtBusIdDep').val();
	id_estado = $('#txtBusIdEstado').val();
	$.ajax({
	  type: 'POST',
	  url: '../../controller/ctrlPAP.php',
	  data: "anio=" + anio + "&mes=" + mes + "&id_ris=" + id_ris +  "&id_dependencia=" + id_dependencia + "&id_estado=" + id_estado + "&accion=GET_SHOW_INDICADOR_TOTAL",
	  dataType: 'json',
	  success: function(data) {
		  var datos = eval(data);
		$('#pap_muestraR').text(datos[0]);
		$('#pap_anulada').text(datos[1]);
		$('#pap_muestra').text(datos[2]);
		$('#pap_negativo').text(datos[3]);
		$('#pap_positivo').text(datos[4]);
		$('#pap_insatisfatorio').text(datos[5]);
		$('#pap_rechazado').text(datos[6]);
		$('#pap_entregadoapac').text(datos[7]);
		$('#pap_muestra15').text(datos[8]);
		$('#pap_muestra29').text(datos[9]);
		$('#pap_muestra49').text(datos[10]);
		$('#pap_muestra50').text(datos[11]);
		$('#pap_muestrasis').text(datos[12]);
		$('#pap_muestranosis').text(datos[13]);
		$('#pap_muestraTA').text(datos[14]);
		$('#pap_muestraPN').text(datos[15]);
		$('#pap_sinresultado').text(datos[16]);
		
		$('#pap_sinresultadopor').text(porcentaje(datos[2], datos[16], 1));
		$('#pap_negativopor').text(porcentaje(datos[2], datos[3], 1));
		$('#pap_positivopor').text(porcentaje(datos[2], datos[4], 1));
		$('#pap_insatisfatoriopor').text(porcentaje(datos[2], datos[5], 1));
		$('#pap_rechazadopor').text(porcentaje(datos[2], datos[6], 1));
		$('#pap_entregadoapacpor').text(porcentaje(datos[2], datos[7], 1));
		
		$('#pap_muestra15por').text(porcentaje(datos[2], datos[8], 1));
		$('#pap_muestra29por').text(porcentaje(datos[2], datos[9], 1));
		$('#pap_muestra49por').text(porcentaje(datos[2], datos[10], 1));
		$('#pap_muestra50por').text(porcentaje(datos[2], datos[11], 1));
		
		$('#pap_muestrasispor').text(porcentaje(datos[2], datos[12], 1));
		$('#pap_muestranosispor').text(porcentaje(datos[2], datos[13], 1));
		
		$('#pap_muestraTApor').text(porcentaje(datos[2], datos[14], 1));
		$('#pap_muestraPNpor').text(porcentaje(datos[2], datos[15], 1));
	  }
	});
}


function exportar_detalle(opt) {
	var msg = "";
	var sw = true;
	
	var anio = $("#anio").val();
	var mes = "";
	if ($('#mes').val() != null) {
		mes = $('#mes').val().join(',');
	}
	
	var id_ris = $("#txtBusIdRis").val();
	var id_dependencia = $('#txtBusIdDep').val();
	var id_estado = $("#txtBusIdEstado").val();
	if(opt == 'det'){
		if (id_estado == "") {
			msg+= "Seleccione almenos un estado<br/>";
			sw = false;
		}
	}
	
	if (sw == false) {
		bootbox.alert(msg);
		return false;
	}
	
	if(opt == 'det'){
		window.location = './xls_indicadordetalle.php?anio=' + anio + '&mes=' + mes + '&id_ris=' + id_ris + '&id_dependencia=' + id_dependencia + '&id_estado=' + id_estado;
	} else {
		//window.location = './xls_indicadordiris.php?anio=' + anio + '&mes=' + mes + '&id_ris=' + id_ris + '&id_dependencia=' + id_dependencia + '&id_estado=' + id_estado + '&opt=' + opt;
		
		document.getElementById("send_tabla_xls").reset();

		var input_anio = document.createElement('input');
		input_anio.type="text"; input_anio.name="anio"; input_anio.id="anio"; input_anio.value=anio;
		document.send_tabla_xls.appendChild(input_anio);
		
		var input_mes = document.createElement('input');
		input_mes.type="text"; input_mes.name="mes"; input_mes.id="mes"; input_mes.value=mes;
		document.send_tabla_xls.appendChild(input_mes);
		
		var input_id_ris = document.createElement('input');
		input_id_ris.type="text"; input_id_ris.name="id_ris"; input_id_ris.id="id_ris"; input_id_ris.value=id_ris;
		document.send_tabla_xls.appendChild(input_id_ris);
		
		var input_id_dependencia = document.createElement('input');
		input_id_dependencia.type="text"; input_id_dependencia.name="id_dependencia"; input_id_dependencia.id="id_dependencia"; input_id_dependencia.value=id_dependencia;
		document.send_tabla_xls.appendChild(input_id_dependencia);
		
		var input_id_estado = document.createElement('input');
		input_id_estado.type="text"; input_id_estado.name="id_estado"; input_id_estado.id="id_estado"; input_id_estado.value=id_estado;
		document.send_tabla_xls.appendChild(input_id_estado);
		
		var input_opt = document.createElement('input');
		input_opt.type="text"; input_opt.name="opt"; input_opt.id="opt"; input_opt.value=opt;
		document.send_tabla_xls.appendChild(input_opt);
		
		if (opt == 'est') {
			var input_data = document.createElement('input');
			input_data.type="text"; input_data.name="data"; input_data.id="data"; input_data.value=JSON.stringify(Array.from(dTable.rows().data()));
			document.send_tabla_xls.appendChild(input_data);
		} else if ((opt == 'men')) {
			var input_data = document.createElement('input');
			input_data.type="text"; input_data.name="data"; input_data.id="data"; input_data.value=JSON.stringify(Array.from(dTableM.rows().data()));
			document.send_tabla_xls.appendChild(input_data);			
		} else {
			var input_data = document.createElement('input');
			input_data.type="text"; input_data.name="data"; input_data.id="data"; input_data.value=JSON.stringify(Array.from(dTableP.rows().data()));
			document.send_tabla_xls.appendChild(input_data);
		}
		
		document.send_tabla_xls.submit();
		
		/*$.ajax({
			type: 'POST',
			url: './xls_indicadordiris.php',
			data: "anio=" + anio + "&mes=" + mes + "&id_ris=" + id_ris +  "&id_dependencia=" + id_dependencia + "&id_estado=" + id_estado + '&opt=' + opt + '&data=' + JSON.stringify(Array.from(dTableM.rows().data())),
			//dataType: 'html',
			success: function(data) {

			}
		});*/
		
		/*var form = $(this).closest('form');
		form = form.serializeArray();
		form = form.concat([
			{name: "anio", value: anio},
			{name: "mes", value: mes},
			{name: "id_ris", value: id_ris},
			{name: "id_dependencia", value: id_dependencia},
			{name: "id_estado", value: id_estado},
			{name: "opt", value: opt},
			{name: "data", value: JSON.stringify(Array.from(dTableM.rows().data()))},
		]);
		$.post('./xls_indicadordiris.php', form, function(d) {
			var blob = new Blob([d], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
			let link=document.createElement('a');
			link.href=window.URL.createObjectURL(blob);
			link.download="results.xls";
			link.click();
			
			if (d.error) {
				alert("There was a problem updating your user details")
			} 
		});*/
		
		/*//create an XMLHttpRequest                  
		var xmlhttp;
		if (window.XMLHttpRequest){
			xmlhttp=new XMLHttpRequest();
		}else{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//submit the request to your desired page (user will not be redirected, as this is AJAX request                             
		xmlhttp.open("POST","./xls_indicadordiris.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("anio=" + anio + "&mes=" + mes + "&id_ris=" + id_ris +  "&id_dependencia=" + id_dependencia + "&id_estado=" + id_estado + '&opt=' + opt + '&data=' + JSON.stringify(Array.from(dTableM.rows().data())));*/
		
	}
}

function change_anio(){
	load_totales();
	
	var mes = "";
	if ($('#mes').val() != null) {
		mes = $('#mes').val().join(',');
	}
	
	dTable = $('#tblEESS').DataTable({
		"destroy": true, //Para que no salga error al volver a buscar
		"scrollY": "200px",
		"scrollCollapse": true,
		"paging":         false,
		"bInfo": true,
		"bFilter": true,
		"sAjaxSource": "tbl_indicadordirisxesta.php", // Load Data
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
		  aoData.push({"name": "anio", "value": $("#anio").val()});
		  aoData.push({"name": "mes", "value": mes});
		  aoData.push({"name": "id_ris", "value": $("#txtBusIdRis").val()});
		  aoData.push({"name": "id_dependencia", "value": $('#txtBusIdDep').val()});
		  aoData.push({"name": "id_estado", "value": $("#txtBusIdEstado").val()});
		},
		"order": [[ 3, "desc" ]],
		"columnDefs": [
		  {"orderable": false, "targets": 0, "searchable": true, "class": "small font-weit"},
		  {"orderable": false, "targets": 1, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 2, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 3, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 4, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 5, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 6, "searchable": true, "class": "text-center"}
		]
	});
	
	dTableM = $('#tblEESSMes').DataTable({
		"destroy": true, //Para que no salga error al volver a buscar
		"scrollY": "200px",
		"scrollCollapse": true,
		"paging":         false,
		"bInfo": true,
		"bFilter": false,
		"sAjaxSource": "tbl_indicadordirisxestaaniomes.php", // Load Data
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
		  aoData.push({"name": "anio", "value": $("#anio").val()});
		  aoData.push({"name": "mes", "value": mes});
		  aoData.push({"name": "id_ris", "value": $("#txtBusIdRis").val()});
		  aoData.push({"name": "id_dependencia", "value": $('#txtBusIdDep').val()});
		  aoData.push({"name": "id_estado", "value": $("#txtBusIdEstado").val()});
		},
		//"order": [[ 1, "desc" ]],
		"columnDefs": [
		  {"orderable": false, "targets": 0, "searchable": true, "class": "small font-weit"},
		  {"orderable": true, "targets": 1, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 2, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 3, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 4, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 5, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 6, "searchable": true, "class": "text-center"}
		]
	});	

	dTableP = $('#tblEESSProf').DataTable({
		"destroy": true, //Para que no salga error al volver a buscar
		"scrollY": "200px",
		"scrollCollapse": true,
		"paging":         false,
		"bInfo": true,
		"bFilter": true,
		"sAjaxSource": "tbl_indicadordirisxestamesaniomes.php", // Load Data
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
		  aoData.push({"name": "anio", "value": $("#anio").val()});
		  aoData.push({"name": "mes", "value": mes});
		  aoData.push({"name": "id_ris", "value": $("#txtBusIdRis").val()});
		  aoData.push({"name": "id_dependencia", "value": $('#txtBusIdDep').val()});
		  aoData.push({"name": "id_estado", "value": $("#txtBusIdEstado").val()});
		},
		"order": [[ 1, "desc" ]],
		"columnDefs": [
		  {"orderable": false, "targets": 0, "searchable": true, "class": "small font-weit"},
		  {"orderable": true, "targets": 1, "searchable": true, "class": "small font-weit"},
		  {"orderable": true, "targets": 2, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 3, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 4, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 5, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 6, "searchable": true, "class": "text-center"},
		  {"orderable": true, "targets": 7, "searchable": true, "class": "text-center"}
		]
	});
	
}

$(document).ready(function () {
	$('#tblEESS').removeClass('display').addClass('table table-hover table-bordered');
	$('#tblEESSMes').removeClass('display').addClass('table table-hover table-bordered');
	$('#tblEESSProf').removeClass('display').addClass('table table-hover table-bordered');
	
	$("#mes").select2({
		placeholder: "-- Todos --",
		allowClear: true
	});
	
	$("#txtBusIdDep").select2();
	
	change_anio();

});
</script>
<?php require_once '../include/masterfooter.php'; ?>
