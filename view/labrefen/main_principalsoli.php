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

.loader_modal{
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	background: rgba(255,255,255,.5);
	z-index: 12000;
	display: none;
}
.loader_modal_content{
	width: 100%;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
}

</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
		<div class="row">
			<div class="col-sm-8">
				<h3 class="panel-title"><strong>BUSCAR MUESTRA / REGISTRO DE RECEPCIÓN Y OBTENCIÓN DE MUESTRAS (LABORATORIO DE REFERENCIA)</strong></h3>
			</div>
			<div class="col-sm-4 text-right">
				<h3 class="panel-title"><a href="#" onclick="event.preventDefault(); open_ayuda()">Ayuda <i class="fa fa-question-circle-o" aria-hidden="true"></i></a></h3>
				<span>Última atención registrada: <span id="nro_ulti_atencion"></span></span>
			</div>
		</div>
    </div>
    <div class="panel-body">
	  <form class="form-horizontal" name="frmAccion" id="frmAccion" onsubmit="return false;">
		<input type="hidden" name="txt_id_atencion" id="txt_id_atencion" value=""/>
		<input type="hidden" name="txt_accion" id="txt_accion" value=""/>
	  </form>
      <table id="tblAtencion" class="display" cellspacing="0" width="100%">
        <thead class="bg-aqua">
          <tr>
            <th></th>
            <th>N°<br/>Atención</th>
            <th>Nombre de Paciente</th>
            <th>Documento<br/>Identidad</th>
            <th>EESS<br/>Procedencia</th>
            <th>Tipo<br/>Atención</th>
			<th>Fecha<br/>Recepción</th>
            <th>Fecha<br/>Toma Muestra</th>
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

<div class="modal fade" id="showDerivarModal" role="dialog" aria-labelledby="showDerivarModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showDerivarModalLabel">Registro de Profesional</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" name="frmDeriva" id="frmDeriva" onsubmit="return false;">
		<div class="row">
		  <div class="col-sm-12">
			<label for="txtIdDepRef">Seleccione EESS origen</label>
			<?php $rsD = $d->get_listaDepenInstitucion(); ?>
			<select name="txtIdDepRef" id="txtIdDepRef" style="width:100%;" class="form-control input-sm">
			  <option value="" selected>-- Seleccione --</option>
			  <?php
			  foreach ($rsD as $row) {
				echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
			  }
			  ?>
			</select>
		  </div>
		  </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
				<div id="btn_derivar_agregar">
				<button type="button" class="btn btn-primary btn-continuar" id="btn_id_dep_refef_add" onclick="reg_dependencia_ref('I')"><i class="glyphicon glyphicon-share-alt"></i> Guardar referencia </button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar</button>
				</div>
				<div id="btn_derivar_quitar">
				<button type="button" class="btn btn-danger btn-continuar" id="btn_id_dep_refef_rem" onclick="reg_dependencia_ref('Q')"><i class="glyphicon glyphicon-share-alt"></i> Quitar referencia </button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar</button>
				</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="showBuscarModal" role="dialog" aria-labelledby="showBuscarModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showBuscarModalLabel">Búsqueda de pacientes</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" name="frmRepPrin" id="frmRepPrin" onsubmit="return false;">
		  <div class="form-group">
            <div class="col-sm-6">
              <label for="txtBusNroAten">Nro Atención:</label>
              <input type="text" class="form-control input-sm" name="txtBusNroAten" id="txtBusNroAten" autocomplete="OFF" maxlength="10" value="" onkeydown="campoSiguiente('btnBus', event);"/>
            </div>
			<div class="col-sm-6">
              <label for="txtIdTipDoc">Documento de identidad del paciente:</label>
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
		  <div class="form-group">
			<div class="col-sm-12">
              <label for="txtBusNomRS">Nombres o apellidos del paciente:</label>
              <input class="form-control input-sm" type="text" name="txtBusNomRS" id="txtBusNomRS" autocomplete="OFF" maxlength="150" required="" tabindex="0" onkeydown="campoSiguiente('btnBus', event);"/>
			</div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              <label for="txtBusAnioAsis">Fecha desde recepción:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </div>
					<?php
						$fecha = date('Y-m-d');
						$nuevaFecha = date("Y-m-d",strtotime ( '-10 day' , strtotime ( $fecha ) ) );
						$fechaIni = date("d/m/Y", strtotime($nuevaFecha));
					?>
                <input type="text" class="form-control pull-right input-sm" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo $fechaIni; ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtBusFecFin', event);"/>
              </div>
            </div>
            <div class="col-sm-6">
              <label for="txtBusAnioAsis">Fecha hasta recepción:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right input-sm" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask data-mask onkeydown="campoSiguiente('btnBus', event);"/>
              </div>
            </div>
		  </div>
        </form>
      </div>
      <div class="modal-footer" style="padding-bottom: 7px !important; padding-top: 7px !important;">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button type="button" class="btn btn-primary btn-continuar" id="btnValidForm" onclick="buscar_datos()"><i class="glyphicon glyphicon-search"></i> Buscar </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="showBuscarValidModal" role="dialog" aria-labelledby="showBuscarValidModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showBuscarValidModalLabel">Exportar examenes validados</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" name="frmRepPrinValid" id="frmRepPrin" onsubmit="return false;">
          <div class="form-group">
            <div class="col-sm-12">
              <label for="txtBusFecIniValid">Fecha desde:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right input-sm" name="txtBusFecIniValid" id="txtBusFecIniValid" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y"); ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtBusFecFin', event);"/>
              </div>
            </div>
            <div class="col-sm-12">
              <label for="txtBusFecFinValid">Fecha hasta:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right input-sm" name="txtBusFecFinValid" id="txtBusFecFinValid" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask data-mask onkeydown="campoSiguiente('btnBus', event);"/>
              </div>
            </div>
		  </div>
        </form>
      </div>
      <div class="modal-footer" style="padding-bottom: 7px !important; padding-top: 7px !important;">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button type="button" class="btn btn-success btn-continuar" id="btnReporValidExa" onclick="expor_buscar_validados()"><i class="glyphicon glyphicon-search"></i> Exportar </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="showComenModal" role="dialog" aria-labelledby="showComenModalLabel">
	<div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showComenModalLabel"></h4>
        </div>
        <div class="modal-body">
          <form name="frmComentario" id="frmComentario">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  <label for="txtDetObsLabEnv">Motivo:</label>
                  <textarea class="form-control" name="txtDetComen" id="txtDetComen" rows="3"></textarea>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-primary btn-continuar" id="btnFrmSaveComen" onclick="save_formaccion()"><i class="fa fa-save"></i> Continuar </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="mostrar_opc_expor_lis" role="dialog" data-backdrop="static">
	<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h2 class="modal-title">OPCIONES DE IMPRESION DE LISTA</h2>
		</div>
		<div class="modal-body">
			<div class="row">
			<div class="col-sm-6">
				<button type="button" class="btn btn-success btn-block" onclick="exporbuscar_datos('S');">Sin examenes</button>
			</div>
			<div class="col-sm-6">
				<button type="button" class="btn btn-primary btn-block" onclick="exporbuscar_datos('T');">Con examenes</button>
			</div>
			</div>
		</div>
		<div class="modal-footer">
		<button class="btn btn-default btn-block" type="button" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar Ventana</button>
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
			<p class="text-left small" style="margin: 0 0 0px;"><b>Leyenda de botones de acción</b>:<br/> <img src="../../assets/images/details_open.png"/>=Mostrar productos solicitados | <button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-pencil"></i></button>=Editar Atención | <button class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>=Eliminar atención  | <button class="btn btn-info btn-xs"><i class="fa fa-share"></i></button>=Ingresar resultado <br/><button class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-ok"></i></button>=Recibir todas las muestras | <button class="btn btn-info btn-xs"><i class="glyphicon glyphicon-ok"></i></button>=Recibir muestra <!--| <button class="btn btn-success btn-xs"><i class="fa fa-h-square"></i></button>=Generar FUA | <button class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-print"></i></button>=Imprimir FUA -->| <button class="btn btn-warning btn-xs"><i class="fa fa-file-text-o"></i></button>=Imprimir Resultado | <button class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-user"></i></button>=Entregar a Paciente | <button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-home"></i></button>=EESS de Referencia</p>
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
							<tr><td style="padding-top: 0px; padding-bottom: 2px;"><small>Sin color</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Registrado</small></td></tr>
							<tr><td class="active" style="padding-top: 0px; padding-bottom: 2px;"><small>Plomo</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Muestra recibido en parte</small></td></tr>
							<tr><td class="info" style="padding-top: 0px; padding-bottom: 2px;"><small>Celeste</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Muestra(s) recibido completo</small></td></tr>
							<tr><td class="success" style="padding-top: 0px; padding-bottom: 2px;"><small>Verde</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Resultado(s) entregado a paciente</small></td></tr>
							<tr><td class="warning" style="padding-top: 0px; padding-bottom: 2px;"><small>Amarrillo</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Muestra(s) derivada o referenciada a otro EESS</small></td></tr>
							<tr><td class="danger" style="padding-top: 0px; padding-bottom: 2px;"><small>Rojo</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Atención anulada</small></td></tr>
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
							<tr><td style="padding-top: 0px; padding-bottom: 2px;"><small>Sin color</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Pendiente de resultado o resultado pendiente de validar</small></td></tr>
							<tr><td class="primary" style="padding-top: 0px; padding-bottom: 2px;"><small>Azul</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Cuenta con almenos un resultado validado</small></td></tr>
							<tr><td class="success" style="padding-top: 0px; padding-bottom: 2px;"><small>Verde</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Resultado(s) validado completo</small></td></tr>
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

<div class="modal fade" id="id_modal_env_orion" role="dialog" data-backdrop="static">
	<div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
			<div class="color-palette-set">
				<div id="env_orion_correcto" style="display: none">
					<div class="bg-green-active color-palette" style="height: 35px; text-align: center;"><span style="color: #fff">Registrado correctamente</span></div>
				</div>
				<div id="env_orion_error" style="display: none">
					<div class="bg-red-active color-palette" style="height: 35px; text-align: center;"><span style="color: #fff">Error al registrar</span></div>
				</div>
			</div>
			<h2 id="env_orion_contenido"></h2>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default btn-block" type="button" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar Ventana</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="uploadHorarioModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Cargar Datos Desde Excel</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body py-0">

                <form action="" id="formUpdHorarioDetalle">
                    <div class="row">
                        <div class="form-group col-12 col-sm-6">
                            <label for="fl_load_dat" class="d-block">Cargar Datos </label>
                            <input class="input-file-excel" type="file" id="fl_load_dat"/>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="formUpdHorarioDetalle" onclick="saveProgramacionFromExcel(event)"
                        class="btn btn-primary">
                    Procesar
                </button>
            </div>
        </div>
    </div>
</div>

<div id="mostrar_anexos_d" class="modal fade" role="dialog" data-backdrop="static"></div>

<div class="loader_modal" id="loaderModal" tabindex="-1" >
    <div class="loader_modal_content">
        Cargando...       
    </div>
</div>
<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">

function maxlength_doc_bus() {
    if ($("#txtBusIdTipDoc").val() == "1"){
      $("#txtBusNroDoc").attr('maxlength', '8');
    } else {
      $("#txtBusNroDoc").attr('maxlength', '15');
    }
    setTimeout(function(){$('#txtBusNroDoc').trigger('focus');}, 2);
}

function open_modal_import_resultado(){
  $('#uploadHorarioModal').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });
}

function saveProgramacionFromExcel(e) {

    if (e) e.preventDefault();

    var file_xls = $("#fl_load_dat")[0].files[0];
    var msg = "";

    if (msg !== "") return showMessage(msg, "error");
    
	if (file_xls) {
		$("#loaderModal").show();
		
        var fd = new FormData();
        fd.append('accion', 'POST_REG_RESULTADOLAB_DENGUE');
        fd.append('file_xls', file_xls);
        $.ajax({
            url: "../../controller/ctrlLabCargaExcel.php",
            dataType: "json",
            type: "post",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
			success: function (response) {
                $("#loaderModal").hide();			
				// Manejar la respuesta del servidor
				var errores = response.errores;

				// Generar un archivo de texto con los errores
				var blob = new Blob([errores], { type: 'text/plain' });
				var url = window.URL.createObjectURL(blob);

				// Crear un enlace de descarga y hacer clic en él para descargar automáticamente
				var a = document.createElement('a');
				a.href = url;
				a.download = 'errores.txt';
				document.body.appendChild(a);
				a.click();
				window.URL.revokeObjectURL(url);

				$("#uploadHorarioModal").modal("hide");
				return showMessage("Se guardaron los datos correctamente", "success");
            },
            timeout: 120000, // sets tiempo de respuesta
            error: function (request, status, err) {
                //$("#loaderModal").hide();
                if (status == "timeout") {
					$("#uploadHorarioModal").modal("hide");
                    showMessage("Su petición demoro mas de lo permitido", "error");
                } else {
                    showMessage("ocurrio un error.", "error");
                }
            }
        });
    } else {
        showMessage("Seleccione un archivo", "error");
    }
}

function reg_resultado(idatencion) {
	window.location = '../lab/main_regresultadoprod2.php?nroSoli='+idatencion+'&ori=LR';
}

function open_ayuda(){
  $('#mostrar_ayuda').modal();
}

function open_fua(){
  $('#modal_reg_fua').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });

  /*$('#modal_reg_fua').on('shown.bs.modal', function (e) {
    $("#txtBusNroAten").trigger('focus');

  })*/
}

function acc_registro(idpap, nroreg, opt){
	document.frmAccion.txt_id_atencion.value = idpap;
	document.frmAccion.txt_accion.value = opt; //A anular; R//Rechazar; E Entregado a paciente

	if(opt == 'A'){
	  $("#showComenModalLabel").text("Anular atención Nro: " + nroreg);
	} else if(opt == 'R'){
	  $("#showComenModalLabel").text("Rechazar muestra - Código  Nro: " + nroreg);
	} else {
	  $("#showComenModalLabel").text("Entregar resultado, atención: " + nroreg + " a paciente");
	}
	$("#showComenModal").modal({
		show: true,
		backdrop: 'static',
		focus: true,
	});
	$('#showComenModal').on('shown.bs.modal', function (e) {
		document.frmComentario.txtDetComen.value = '';
		$('#txtDetComen').trigger('focus');
	})
}

function save_formaccion(){
    $('#btnFrmSaveComen').prop("disabled", true);
    var isValid = true;
    var msgobs = '';
    var txtIdPap = document.frmAccion.txt_id_atencion.value;
    var txtTipAcc = document.frmAccion.txt_accion.value;
	var txtDetComen = document.frmComentario.txtDetComen.value;

    if(txtTipAcc == "A"){
		if(txtDetComen.length <= 2){
			msgobs+='Ingrese Motivo...';
			isValid = false;
		}
		msgconfir = 'Se anulará la muestra. ¿Está seguro de continuar?';
    } else {
		/*if(txtDetComen.length <= 2){
			msgobs+='Ingrese Comentario';
			isValid = false;
		}*/
		msgconfir = 'Se cambiará el estado a <b>ENTREGADO A PACIENTE</b>. ¿Está seguro de continuar?';
    }

    if (isValid == false){
		bootbox.alert(msgobs);
		$('#btnFrmSaveComen').prop("disabled", false);
		return false;
    }

    bootbox.confirm({
      message: msgconfir,
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
          $.ajax({
            url: "../../controller/ctrlAtencion.php",
            type: "POST",
            data: {
              accion: 'POST_ADD_REG_ACCION_COMPLEMENTARIA', id_atencion: document.frmAccion.txt_id_atencion.value, accion_sp: document.frmAccion.txt_accion.value, detalle: document.frmComentario.txtDetComen.value,
            },
            success: function (data) {
              if(data == ""){
					$("#tblAtencion").dataTable().fnDraw();
					$('#showComenModal').modal("hide");
					$('#btnFrmSaveComen').prop("disabled", false);
              } else {
                bootbox.alert(msg);
                return false;
              }
            }
          });
        } else {
          $('#btnFrmSave').prop("disabled", false);
        }
      }
    });
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

function open_deriva(idAten,iddepori,nomPac){
	if(iddepori != ''){
		$('#btn_derivar_quitar').show();
		$('#btn_derivar_agregar').hide();
		$('#txtIdDepRef').prop("disabled", true);
	} else {
		$('#btn_derivar_agregar').show();
		$('#btn_derivar_quitar').hide();
		$('#txtIdDepRef').prop("disabled", false);
	}
	
	$('#txt_id_atencion').val(idAten);
	$('#showDerivarModal').modal({
		show: true,
		backdrop: 'static',
		focus: true,
	});
	$('#showDerivarModal').on('shown.bs.modal', function (e) {
		$("#showDerivarModalLabel").text(nomPac);
		$("#txtIdDepRef").val(iddepori).trigger("change");
	});
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
  var fecIni = $("#txtBusFecIni").val();
  var fecFin = $("#txtBusFecFin").val();
  var nomRS = $("#txtBusNomRS").val();
  nomRS = nomRS.replace("%", "");

  $('#titleModalAlert').text('Mensaje de Alerta ...');
  if (nomRS == "") {
    if (fecFin == "") {
      $('#infoModalAlert').text('Ingrese almenos un parametro de ingreso: Nombre o Raz\xf3n Social o Rango de Fechas.');
      $('#alertModal').modal("show");
      return false;
    }
  }

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
  }

  $("#tblAtencion").dataTable().fnDraw();
}

function open_exporbuscar(){
	$("#mostrar_opc_expor_lis").modal({
		show: true,
		backdrop: 'static',
		focus: true,
	});
}

function exporbuscar_datos(opt) {
    var fecIni = $("#txtBusFecIni").val();
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
    }

    var urlwindow = "../lab/pdf_principalsoli.php?opt="+ opt +"&idTipDoc="+ $("#txtBusIdTipDoc").val() + "&nroDoc=" + $("#txtBusNroDoc").val() + "&nomRS=" + $("#txtBusNomRS").val() + "&fecIni=" + fecIni + "&fecFin=" + fecFin + "&nroAte=" + $("#txtBusNroAten").val();
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
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

function reg_solicitud() {
  window.location = './main_regsolicitudsinfua.php';
}
function reg_solicitud_labref() {
  window.location = './main_regsolicitudlabref.php';
}

function open_edit(id) {
  window.location = './main_editsolicitud.php?nroSoli='+id;
}

function imprime_fua(id) {
  window.location = '../fua/genera_fuaxls.php?nroAtencion='+id;
}

function back() {
  window.location = '../pages/';
}

function habilita_datos_apoderado() {
	
}

function reg_dependencia_ref(opt) {
	if(opt == "I"){
		$('#btn_id_dep_refef_add').prop("disabled", true);
		id_dep_ori = $('#txtIdDepRef').val();
		
		if(id_dep_ori == ""){
			$('#btn_id_dep_refef_add').prop("disabled", false);
			showMessage("Seleccione EESS de origen.", "error");
			return false;
		}
	} else {
		$('#btn_id_dep_refef_rem').prop("disabled", true);
		id_dep_ori = 0;
	}

	var parametros = {
		  "accion": "POST_REG_DEP_ORIGEN",
		  "id_atencion": $('#txt_id_atencion').val(),
		  "id_dep_ori": id_dep_ori
		};
		$.ajax({
		  data: parametros,
		  url: '../../controller/ctrlAtencion.php',
		  type: 'post',
		  success: function (rs) {
			$('#showDerivarModal').modal('hide');
			if(opt == "I"){
				$('#btn_id_dep_refef_add').prop("disabled", false);
			} else {
				$('#btn_id_dep_refef_rem').prop("disabled", false);
			}
			$("#tblAtencion").dataTable().fnDraw();
			showMessage("Registro actualizado correctamente.", "success");
		  }
	});
}


function nro_ultima_atencion(){
  $.ajax({
    url: '../../controller/ctrlAtencion.php',
    type: 'POST',
    data: 'accion=GET_SHOW_ULTIMONROATENCION_REGISTRADO',
    success: function(data){
      $('#nro_ulti_atencion').text(data);
    }
  });
}

function open_buscar_validados(){
  $('#showBuscarValidModal').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });
}

function expor_buscar_validados() {
	var msg = "";
	var sw = true;
  
    var fecIni = $("#txtBusFecIniValid").val();
    var fecFin = $("#txtBusFecFinValid").val();
	
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
	
	if (sw == false) {
		bootbox.alert(msg);
		return false;
	} 

	window.location = "./xls_repproduccion_dengue.php?fecIni="+ fecIni + "&fecFin=" + fecFin;
}


var dTable;
//var id_dep= document.getElementById('cboiddep').value;
// #areas-grid adalah id pada table
$(document).ready(function () {
  $("#txtBusIdTipDoc").select2();
	$("#txtIdDepRef").select2();
  $("#txtBusFecIni").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });
  $("#txtBusFecFin").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });
  
  $("#txtBusFecIniValid").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });
  $("#txtBusFecFinValid").datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
  });
  
  
  nro_ultima_atencion();

  dTable = $('#tblAtencion').DataTable({
    dom: 'Bltip',
    "buttons": [
	<?php if ($_SESSION['labIdRolUser'] <> "2") { ?>
      {
        text: '<i class="glyphicon glyphicon-plus"></i> Nueva Atención',
        className: "btn btn-primary btn-lg",
        action: function ( e, dt, node, config ) {
		<?php if($labIdDepUser <> "67") { ?>
			reg_solicitud();
		<?php } else { ?>
			reg_solicitud_labref();
		<?php }?>
        }
      },
	<?php }?>
      {
        text: '<i class="glyphicon glyphicon-search"></i> Búsqueda de pacientes',
        className: "btn btn-success btn-lg",
        action: function ( e, dt, node, config ) {
          open_buscar();
        }

      },
	<?php if (($_SESSION['labIdRolUser'] == "1") Or ($_SESSION['labIdRolUser'] == "5") Or ($_SESSION['labIdRolUser'] == "14") Or ($_SESSION['labIdRolUser'] == "15") Or ($_SESSION['labIdRolUser'] == "16") Or ($_SESSION['labIdRolUser'] == "17") Or ($_SESSION['labIdRolUser'] == "10")) { ?>
	  {
        text: '<i class="glyphicon glyphicon-open"></i> Exportar lista',
        className: "btn btn-warning btn-lg",
        action: function ( e, dt, node, config ) {
          open_exporbuscar();
        }
      },
	<?php } if (($_SESSION['labIdRolUser'] == "1") Or ($_SESSION['labIdRolUser'] == "5") Or ($_SESSION['labIdRolUser'] == "14") Or ($_SESSION['labIdRolUser'] == "15") Or ($_SESSION['labIdRolUser'] == "16") Or ($_SESSION['labIdRolUser'] == "10")) { ?>
	{
        text: 'Carga resultados desde Excel .XLSX',
        className: "btn btn-info btn-lg",
        action: function ( e, dt, node, config ) {
          open_modal_import_resultado();
        }
      },
	<?php }?>
	<?php  if (($_SESSION['labIdRolUser'] == "1") Or ($_SESSION['labIdRolUser'] == "5") Or ($_SESSION['labIdRolUser'] == "14") Or ($_SESSION['labIdRolUser'] == "15") Or ($_SESSION['labIdRolUser'] == "2") Or ($_SESSION['labIdRolUser'] == "16") Or ($_SESSION['labIdRolUser'] == "10")) { ?>
	{
        text: '<i class="glyphicon glyphicon-open"></i> Exportar examenes validados',
        className: "btn btn-success btn-lg",
        action: function ( e, dt, node, config ) {
          open_buscar_validados();
        }
      }
	<?php }?>
		
    ],
    "lengthMenu": [[15, 25, 50, 100 ,250], [15, 25, 50, 100 ,250]],
    "bLengthChange": true,
    "bProcessing": true,
    "bServerSide": true,
    "bJQueryUI": false,
    "responsive": false,
    "bInfo": true,
    "bFilter": false,
    "sAjaxSource": "tbl_principalsoli.php", // Load Data
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
		aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
		aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
		aoData.push({"name": "nroAte", "value": $("#txtBusNroAten").val()});

    },
	"createdRow": function(row, data, index) {
		if (data[9] == "VALID./PARTE" ){
			$('td:eq(9)', row).addClass('primary');
		} else if (data[9] == "VALID./COMPL" ){
			$('td:eq(9)', row).addClass('success');
		}
		
		if (data[8] == "RECIB./PARTE" ){
			$('td:eq(8)', row).addClass('active');
		} else if(data[8] == "RECIB./COMPL."){
			$('td:eq(8)', row).addClass('info');
		}
	},
    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
      /* Append the grade to the default row class name */
     if ( aData[8] == "ENTREGRADO PAC." ){
        $('td', nRow).addClass('success');
      } else if ( aData[8] == "RECHAZADO" ){
        $('td', nRow).addClass('warning');
      } else if ( aData[8] == "ANULADO" ){
        $('td', nRow).addClass('danger');
      }
    },
    "columnDefs": [
      {"orderable": false, "targets": 0, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 1, "searchable": false, "class": "text-center font-weit"},
      {"orderable": false, "targets": 2, "searchable": false, "class": ""},
      {"orderable": false, "targets": 3, "searchable": false, "class": ""},
      {"orderable": false, "targets": 4, "searchable": false, "class": ""},
      {"orderable": false, "targets": 5, "searchable": false, "class": "text-center font-weit"},
      {"orderable": false, "targets": 6, "searchable": false, "class": "text-center font-weit"},
      {"orderable": false, "targets": 7, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 8, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 9, "searchable": false, "class": "text-center"},
	  {"orderable": false, "targets": 10, "searchable": false, "class": "text-center"}
    ],
    "columns": [
      {
        className: 'details-control',
        defaultContent: '',
        data: null,
        orderable: false,
        defaultContent: ''
      },
      { aTargets: 'nroate' },
      { aTargets: 'pac' },
      { aTargets: 'idenpac'},
      { aTargets: 'hcpac'},
      { aTargets: 'servi'},
      { aTargets: 'fecreg'},
      { aTargets: 'estate'},
      { aTargets: 'estresul'},
      { aTargets: 'acc'}
    ],
    //"order": [[1, 'desc']]
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
  //console.log(d[0]);

  var idate = d[0];
  var parametros = {
    "accion": "SHOW_DETPRODUCTOATENCION",
    "idAten": idate
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
				$("#tblAtencion").dataTable().fnDraw();
			  }
			});
		  } else {
			$('#btn-submit').prop("disabled", false);
		  }
		}
		});
	} else {
		bootbox.confirm({
		message: "Se <b class='text-info'>recibirá</b> la muestra del examen solicitado. <br/>Examen: <b>"+pac+"</b><br/>¿Está seguro de continuar?",
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
			  "id_productoaten": opt,
			  "cnt_producto": cntprod
			};
			$.ajax({
			  data: parametros,
			  url: '../../controller/ctrlAtencion.php',
			  type: 'post',
			  success: function (rs) {
				$("#tblAtencion").dataTable().fnDraw();
			  }
			});
		  } else {
			$('#btn-submit').prop("disabled", false);
		  }
		}
		});
	}
}

function envia_datos_reg_orion(id) {
  bootbox.confirm({
    title: "Mensaje",
    message: "Enviar datos de atención?",
    buttons: {
      cancel: {
        label: '<i class="fa fa-times"></i> No'
      },
      confirm: {
        label: '<i class="fa fa-check"></i> Si'
      }
    },
    callback: function (result) {
		if (result){
		  $("#loaderModal").show();
		  var parametros = {
			"accion": "POST_REG_ATENCION",
			"id_atencion": id
		  };
		  $.ajax({
			data: parametros,
			url: '../../controller/ctrlWSOrion.php',
			type: 'post',
			dataType: 'json',
			success: function (result) {
			  $("#loaderModal").hide();
			  var datos = eval(result);
			  if(datos[0] == "RC"){
				  $("#env_orion_correcto").show();
				  $("#env_orion_error").hide();
				  $("#env_orion_contenido").text("CODIGO: " + datos[2]);
			  } else {
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_orion_contenido").text(datos[1]);
			  }
			  //console.log(result)
			  $('#id_modal_env_orion').modal({
				show: true,
				backdrop: 'static',
				focus: true,
			  });
			  buscar_datos();
			}
		  });
		}
	}
  });
}
</script>
<?php require_once '../include/masterfooter.php'; ?>
