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
require_once '../../model/Producto.php';
$pr = new Producto();
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

.text-inmuno {
  color: #fdc500 !important;
}

.btn-yelow {
  color: #fff;
  background-color: #fdc500;
  border-color: #fdc500;
}

.btn-yelow.focus, .btn-yelow:focus, .btn-yelow:hover {
  color: #fff;
  text-decoration: none;
}

.btn-env-diagnostica {
  color: #fff;
  background-color: #709dbf;
  border-color: #709dbf;
}

.btn-env-diagnostica.focus, .btn-env-diagnostica:focus, .btn-env-diagnostica:hover {
  color: #fff;
  text-decoration: none;
}

.btn-env-diagnostica_edit {
  color: #fff;
  background-color: #213b5d;
  border-color: #213b5d;
}

.btn-env-diagnostica_edit.focus, .btn-env-diagnostica_edit:focus, .btn-env-diagnostica_edit:hover {
  color: #fff;
  text-decoration: none;
}

</style>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
		<div class="row">
			<div class="col-sm-6">
				<h3 class="panel-title"><strong>BUSCAR ATENCION / REGISTRO DE ATENCION</strong></h3>
			</div>
			<div class="col-sm-6 text-right">
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
            <th>N°<br/>ATENCION</th>
            <th>DATOS DEL PACIENTE</th>
            <th>HC</th>
            <th>Tipo<br/>Atención</th>
			<th>Fecha<br/>Registro</th>
            <th>Fecha<br/>Cita / Atención</th>
            <th>Estado<br/>Atención</th>
            <th>Estado<br/>Resultado</th>
            <th style="width: 55px;"><i class="fa fa-cogs"></i>ACCIONES</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
	  
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-info pull-right" id="btnBackForm" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Ir al inicio</button>
    </div>
  </div>
</div>

<div class="modal fade" id="showDerivarModal" role="dialog" aria-labelledby="showDerivarModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showDerivarModalLabel">Registro de EESS procedencia</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" name="frmDeriva" id="frmDeriva" onsubmit="return false;">
		<div class="row">
		  <div class="col-sm-12">
			<label for="txtIdDepRef">Seleccione EESS procedencia</label>
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
  <div class="modal-dialog" role="document" style="width: 80%; max-width: 1768px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showBuscarModalLabel">Búsqueda de pacientes</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" name="frmRepPrin" id="frmRepPrin" onsubmit="return false;">
<div class="row">
	<div class="col-sm-5">
		  <div class="form-group">
            <div class="col-sm-6">
              <label for="txtBusNroAten">Nro. Atención (Nro.-Año):</label>
              <input type="text" class="form-control input-sm" name="txtBusNroAten" id="txtBusNroAten" autocomplete="OFF" maxlength="10" value="" onkeydown="campoSiguiente('btnBus1', event);"/>
            </div>
			<div class="col-sm-6">
              <label for="txtBusNroAten">Nro. Sistema externo:</label>
              <input type="text" class="form-control input-sm" name="txtBusNroAtenOrion" id="txtBusNroAtenOrion" autocomplete="OFF" maxlength="10" value="" onkeydown="campoSiguiente('btnBus1', event);"/>
            </div>
          </div>
		  <div class="form-group">
			<div class="col-sm-6">
              <label for="txtBusNomRS">Nombres o apellidos del paciente:</label>
              <input class="form-control input-sm" type="text" name="txtBusNomRS" id="txtBusNomRS" autocomplete="OFF" maxlength="150" required="" tabindex="0" onkeydown="campoSiguiente('btnBus', event);"/>
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
                <input type="text" name="txtBusNroDoc" placeholder="Número de documento" required="" id="txtBusNroDoc" class="form-control input-sm" maxlength="8" onkeydown="campoSiguiente('btnBus1', event);"/>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              <label for="txtBusAnioAsis">Fecha inicio cita:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </div>
					<?php
						$fecha = date('Y-m-d');
						$nuevaFecha = date("Y-m-d",strtotime ( '-4 day' , strtotime ( $fecha ) ) );
						$fechaIni = date("d/m/Y", strtotime($nuevaFecha));
					?>
                <input type="text" class="form-control pull-right input-sm" name="txtBusFecIni" id="txtBusFecIni" autocomplete="OFF" maxlength="10" value="<?php echo $fechaIni; ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtBusFecFin', event);"/>
              </div>
            </div>
            <div class="col-sm-6">
              <label for="txtBusAnioAsis">Fecha fin cita:</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right input-sm" name="txtBusFecFin" id="txtBusFecFin" autocomplete="OFF" maxlength="10" value="<?php echo date("d/m/Y") ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask data-mask onkeydown="campoSiguiente('btnBus', event);"/>
              </div>
            </div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-8">
				<div class="radio">
					<label class="radio-inline">
					  <input type="radio" name="opt_bus_urgente" value="" checked> Todos
					</label>
					<label class="radio-inline">
					  <input type="radio" name="opt_bus_urgente" value="1"> Urgente
					</label>
					<label class="radio-inline">
					  <input type="radio" name="opt_bus_urgente" value="2"> No urgente
					</label>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="checkbox">
					<label class="checkbox-inline">
					  <input type="checkbox" id="chk_bus_gestante" value="1"> Gestante
					</label>
				</div>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-12">
				<label for="txt_bus_id_producto"><small>Análisis clínico solicitado:</small></label>
				<?php $rsP = $pr->get_listaProductoLaboratorio(); ?>
				<select name="txt_bus_id_producto" id="txt_bus_id_producto" class="form-control select" multiple data-mdb-clear-button="true">
				  <?php
				  foreach ($rsP as $row) {
					echo "<option value='" . $row['id_producto'] . "'>" . $row['nom_producto'] . "</option>";
				  }
				  ?>
				</select>
			</div>
		  </div>
		  <hr/>
		  <div class="row">
			  <div class="col-md-12 text-right">
				<div class="btn-group">
				  <button type="button" class="btn btn-primary btn-continuar" id="btnValidForm" onclick="buscar_datos()"><i class="glyphicon glyphicon-search"></i> Buscar </button>
				  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar</button>
				</div>
			  </div>
          </div>
	</div>
	<div class="col-sm-7">
		<div class="form-group">
			<div class="col-sm-2">
				<select class="form-control" name="txtBusAnio" id="txtBusAnio" onchange="busca_calendariocita_mes_anio();">
				<?php
					$year_init = 2022;
					$year_curent = date('Y') + 1;
					for ($i = $year_init; $i <= $year_curent; $i++) {
						echo "<option value='$i'"; if(date('Y') == $i){ echo " selected";}  echo ">$i</option>";
					}
				?>
				</select>
			</div>
			<div class="col-sm-3">
				<select class="form-control" name="txtBusMes" id="txtBusMes" onchange="busca_calendariocita_mes_anio();">
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
			<div class="col-sm-7 pull-right text-right">
				<span>
					<small class="label bg-blue" style="margin-right: 5px;">Cnt. Citados</small>
					<small class="label bg-green" style="margin-right: 5px;">Atendidos</small> 
					<small class="label bg-yellow" style="margin-right: 5px;">No atendidos</small> 
				</span>
			</div>
		</div>
		<div class="table-responsive" id="calendario"></div>
	</div>
</div>
        </form>
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
			<h2 class="modal-title">OPCIONES DE IMPRESION DE BUSQUEDA DE PACIENTES</h2>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-sm-6">
					<button type="button" class="btn btn-success btn-block" onclick="exporbuscar_datos('S');">Lista sin productos</button>
				</div>
				<div class="col-sm-6">
					<button type="button" class="btn btn-primary btn-block" onclick="exporbuscar_datos('T');">Lista con productos</button>
				</div>
			</div>
			<hr style="margin: 5px 0px 5px 0px;"/>
			<div class="row">
				<div class="col-sm-12">
					<div class="radio">
						<label class="radio-inline">
						  <input type="radio" name="opt_impresion_lista" value="H" checked> Impresión horizontal
						</label>
						<label class="radio-inline">
						  <input type="radio" name="opt_impresion_lista" value="V"> Impresión vertical
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<button type="button" class="btn btn-info btn-block" onclick="exporhoja_trabajo();">Lista de hoja de trabajo</button>
				</div>
				<div class="col-sm-6">
				  <?php $rsT = $pr->get_listaTipoProducto(); ?>
				  <select name="txtBusTipoProducto" id="txtBusTipoProducto" class="form-control">
					<option value='' selected>-- AREA EXAMEN (TODOS) --</option>
					<?php
					foreach ($rsT as $row) {
					  echo "<option value='" . $row['id'] . "'>" . $row['abrev_tipo_producto'] . "</option>";
					}
					?>
				  </select>
				</div>
			</div>
		</div>
		<div class="modal-footer">
		<button class="btn btn-default btn-block" type="button" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar Ventana</button>
		</div>
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
			<div class="col-sm-12">
				<div class="col-sm-6">
				<?php include './main_reglab_dato_apoderado.php'?>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<div class="col-md-5">
							<label for="txtNroFUA">Nro. FUA <span class="text-danger">(*)</span>:</label>
							<input type="text" name="txtNroFUA" id="txtNroFUA" class="form-control input-sm" maxlength="20"/>
						</div>
						<div class="col-md-4">
							<label for="txtNroFUA">Año FUA <span class="text-danger">(*)</span>:</label>
							<input type="text" name="txtNroFUA" id="txtNroFUA" class="form-control input-sm" maxlength="4"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-5">
						<label for="txtCodSIS">Tipo de Seguro <span class="text-danger">(*)</span>:</label>
						<select class="form-control input-sm" name="txtCodSIS" id="txtCodSIS" onkeydown="campoSiguiente('txtNroSIS', event);" onchange="change_codis()">
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
					  <div class="col-md-4">
						  <label for="txtNroSIS">Número SIS <span class="text-danger">(*)</span>:</label>
						  <input type="text" name="txtNroSIS" id="txtNroSIS" class="form-control input-sm" maxlength="25" onkeydown="campoSiguiente('txtNroFUA', event);"/>
					  </div>
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<div class="checkbox">
							<label>
							<input type="checkbox" name="txtIdGestante" id="txtIdGestante" value="1" disabled> ¿Es<br/>gestante?
							</label>
							</div>
						</div>
						<div class="col-sm-3">
							<label for="txtEdadGest">Edad Gest.:</label>
							<input type="text" name="txtEdadGest" id="txtEdadGest" class="form-control input-sm" maxlength="25" onkeydown="campoSiguiente('txtFechaParto', event);" disabled="">
						</div>
						<div class="col-sm-6">
							<label for="txtFechaParto">Fec. Prob. de parto:</label>
							<div class="input-group input-group-sm">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" name="txtFechaParto" id="txtFechaParto" placeholder="DD/MM/AAAA" class="form-control" maxlength="20" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" data-date-end-date="0d" disabled="">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<label for="txtIdProfesional"><small>Realizado Por <span class="text-danger">(*)</span>:</small></label>
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
					</div>
				</div>
			</div>
			</div>
		  </form>
		</div>
		<div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-primary btn-continuar" id="btnFrmSaveComen" onclick="save_formaccion()"><i class="fa fa-save"></i> Guardar </button>
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
							<tr><td style="padding-top: 0px; padding-bottom: 2px;"><small>Sin color</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Pendiente de resultado</small></td></tr>
							<tr><td class="warning" style="padding-top: 0px; padding-bottom: 2px;"><small>Amarrillo</small></td><td style="padding-top: 0px; padding-bottom: 2px;"><small>Resultado pendiente de validar</small></td></tr>
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
			<h6 id="env_diagnostica_contenido"></h6>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default btn-block" type="button" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar Ventana</button>
        </div>
      </div>
    </div>
</div>

<div id="mostrar_anexos_d" class="modal fade" role="dialog" data-backdrop="static"></div>
<?php include __DIR__ . '/../lab/main_principalsoli_modal_persona.php';?>

<div class="loader_modal" id="loaderModal" tabindex="-1" >
    <div class="loader_modal_content">
        <!--Cargando...-->
		<img src="../../assets/images/load_cargando.gif" />		
    </div>
</div>
<?php require_once '../include/footer.php'; ?>
<script src="../../assets/plugins/multiselect/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="../../assets/plugins/multiselect/bootstrap-multiselect.css" type="text/css"/>
<script src="../../assets/js/consulta_persona.js"></script>
<script Language="JavaScript">

function open_edit_persona(id_atencion){
	$("#txt_id_atencion").val(id_atencion);
	buscar_datos_personales_editar(id_atencion, 'LAB');
	$('#modal_edit_persona').modal({
		show: true,
		backdrop: 'static',
		focus: true,
	});
}

function maxlength_doc_bus() {
    if ($("#txtBusIdTipDoc").val() == "1"){
      $("#txtBusNroDoc").attr('maxlength', '8');
    } else {
      $("#txtBusNroDoc").attr('maxlength', '15');
    }
    setTimeout(function(){$('#txtBusNroDoc').trigger('focus');}, 2);
}

function reg_resultado(idatencion) {
	window.location = './main_regresultadoprod2.php?nroSoli=' + idatencion + '&ori=';
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
	//Acciones: A: Anular, NA: Paciente No Asistió
	document.frmAccion.txt_id_atencion.value = idpap;
	document.frmAccion.txt_accion.value = opt; //A anular; E Entregado a paciente

	if(opt == 'PNA'){
		save_accion_directo(idpap, 'PNA');
	} else if(opt == 'PA'){
		save_accion_directo(idpap, 'PA');
	} else {
		if(opt == 'A'){
		  $("#showComenModalLabel").text("Anular atención Nro: " + nroreg);
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
}

function save_accion_directo(id_atencion, AccSP){
	$.ajax({
		url: "../../controller/ctrlAtencion.php",
		type: "POST",
		data: {
			accion: 'POST_ADD_REG_ACCION_COMPLEMENTARIA', id_atencion: id_atencion, accion_sp: AccSP, detalle: '',
		},
		success: function (data) {
			if(data == ""){
				$("#tblAtencion").dataTable().fnDraw();
			} else {
				bootbox.alert(msg);
				return false;
			}
		}
	});
}
function save_formaccion(){
    $('#btnFrmSaveComen').prop("disabled", true);
    var isValid = true;
    var msgobs = '';
	var txtTipAccSP = '';
    var id_atencion = document.frmAccion.txt_id_atencion.value;
    var txtTipAcc = document.frmAccion.txt_accion.value;
	var txtDetComen = document.frmComentario.txtDetComen.value;

    if(txtTipAcc == "A"){
		if(txtDetComen.length <= 2){
			msgobs+='Ingrese Motivo...';
			isValid = false;
		}
		msgconfir = 'Se anulará la atención. ¿Está seguro de continuar?';
		txtTipAccSP = 'A';
    } else if(txtTipAcc == "AoS"){
		if(txtDetComen.length <= 2){
			msgobs+='Ingrese Motivo...';
			isValid = false;
		}
		msgconfir = 'Se anulará la atención en ambos sistemas. ¿Está seguro de continuar?';
		txtTipAccSP = 'A';
    } else {
		/*if(txtDetComen.length <= 2){
			msgobs+='Ingrese Comentario';
			isValid = false;
		}*/
		msgconfir = 'Se cambiará el estado a <b>ENTREGADO A PACIENTE</b>. ¿Está seguro de continuar?';
		txtTipAccSP = txtTipAcc;
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
              accion: 'POST_ADD_REG_ACCION_COMPLEMENTARIA', id_atencion: document.frmAccion.txt_id_atencion.value, accion_sp: txtTipAccSP, detalle: document.frmComentario.txtDetComen.value,
            },
            success: function (data) {
              if(data == ""){
					$('#showComenModal').modal("hide");
					if (txtTipAcc == "AoS"){
						envia_datos_elim_orion(id_atencion);
					} else {
						$("#tblAtencion").dataTable().fnDraw();
					}
              } else {
                bootbox.alert(msg);
                return false;
              }
			  $('#btnFrmSaveComen').prop("disabled", false);
            }
          });
        } else {
          $('#btnFrmSave').prop("disabled", false);
        }
      }
    });
  }

function imprime_orden(idaten, iddep) {
	var urlwindow = "pdf_laboratorio_orden.php?p=" + iddep + "&valid=" + idaten;
	day = new Date();
	id = day.getTime();
	Xpos = (screen.width / 2) - 390;
	Ypos = (screen.height / 2) - 300;
	eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function imprime_ticket(idaten, nroAte) {
	/* Esto es para generar ZPL y que se descargue
	var urlwindow = "pdf_laboratorio_ticket.php?valid=" + idaten;
	day = new Date();
	id = day.getTime();
	Xpos = (screen.width / 2) - 390;
	Ypos = (screen.height / 2) - 300;
	eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
	*/

    bootbox.confirm({
      message: "Se va a imprimir esta orden, ¿Está seguro de continuar?",
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
            url: "../../controller/ctrlLab.php",
            type: "POST",
            data: {
              accion: 'REG_IMPRIME_TICKET', id_atencion: idaten,
            },
            success: function (data) {
              if(data == ""){

              } else {
                bootbox.alert(msg);
                return false;
              }
			  //$('#btnFrmSaveComen').prop("disabled", false);
            }
          });
        } else {
          //$('#btnFrmSave').prop("disabled", false);
        }
      }
    });
}


function imprime_resultado(idaten, iddep, idprod) {
	//if(iddep != "735b90b4568125ed6c3f678819b6e058") {
		var urlwindow = "pdf_laboratorioprodn.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
	/*} else {
		var urlwindow = "pdf_laboratorio_labref.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
	}*/
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
	
	if($("#txt_bus_id_producto").val() !== null){
		var id_producto = $("#txt_bus_id_producto").val().join();
	} else {
		var id_producto = "";
	}
		
    var urlwindow = "pdf_principalsoli.php?opt="+ opt +"&idTipDoc="+ $("#txtBusIdTipDoc").val() + "&nroDoc=" + $("#txtBusNroDoc").val() + "&nomRS=" + $("#txtBusNomRS").val() + "&fecIni=" + fecIni + "&fecFin=" + fecFin + "&nroAte=" + $("#txtBusNroAten").val() + "&nroAteOtro=" + $("#txtBusNroAtenOrion").val() + "&optUrgente=" + $("input[type=radio][name=opt_bus_urgente]:checked").val() + "&idProducto=" + id_producto;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function exporhoja_trabajo() {
    var fecIni = $("#txtBusFecIni").val();
    var fecFin = $("#txtBusFecFin").val();
	var id_tipoprod = $("#txtBusTipoProducto").val();

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
	
	if($("#txt_bus_id_producto").val() !== null){
		var id_producto = $("#txt_bus_id_producto").val().join();
	} else {
		var id_producto = "";
	}

    var urlwindow = "pdf_hoja_trabajo.php?idTipDoc="+ $("#txtBusIdTipDoc").val() + "&nroDoc=" + $("#txtBusNroDoc").val() + "&nomRS=" + $("#txtBusNomRS").val() + "&fecIni=" + fecIni + "&fecFin=" + fecFin + "&nroAte=" + $("#txtBusNroAten").val() + "&nroAteOtro=" + $("#txtBusNroAtenOrion").val() + "&optUrgente=" + $("input[type=radio][name=opt_bus_urgente]:checked").val() + "&idProducto=" + id_producto + "&opt_impresion_lista=" + $("input[type=radio][name=opt_impresion_lista]:checked").val() + "&id_tipoprod=" + id_tipoprod;
    day = new Date();
    id = day.getTime();
    Xpos = (screen.width / 2) - 390;
    Ypos = (screen.height / 2) - 300;
    eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function campoSiguiente(campo, evento) {
  if (evento.keyCode == 13) {
    if (campo == 'btnBus1') {
		buscar_datos();
		setTimeout(function(){
		  $('#showBuscarModal').modal('hide');
		  $("#txtBusNroAten").val('');
		  $("#txtBusNroAtenOrion").val('');
		  $("#txtBusNroDoc").val('');
		}, 1);
    } else if (campo == 'btnBus') {
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

function busca_calendariocita_mes_anio(){
  $.ajax({
    url: '../../controller/ctrlLab.php',
    type: 'POST',
    data: 'accion=SHOW_CALENDARIOPORMESYANIO&anio=' + $('#txtBusAnio').val() + '&mes=' + $('#txtBusMes').val() + '&origen=LIS',
    success: function(data){
      $('#calendario').html(data);
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

var dTable;
//var id_dep= document.getElementById('cboiddep').value;
// #areas-grid adalah id pada table
$(document).ready(function () {
	$("#txtBusIdTipDoc").select2();
	$("#txtIdDepRef").select2();
	
	$("#txt_edit_id_pais_pac").select2();
	$("#txt_id_etnia_pac").select2();
	$("#txt_edit_id_ubigeo_pac").select2();
  
	let fechaInput = $("#txtBusFecIni").val(); // Suponiendo que contiene "dd/mm/yyyy"
	let partes = fechaInput.split("/");
	let oldDate = new Date(partes[2], partes[1] - 1, partes[0]);
	
	$("#txtBusFecIni").datepicker({
	format: 'dd/mm/yyyy',
	autoclose: true,
	todayHighlight: true,//Resalta la fecha actual
	}).on('changeDate', function (e) {//esto lo hago para que no se borre cuando doy clic en la misma fecha seleccionada
		if (e.date === undefined){ return $(this).datepicker("update", oldDate)};
		oldDate = e.date;
	});
	
	let fechaInputF = $("#txtBusFecFin").val(); // Suponiendo que contiene "dd/mm/yyyy"
	let partesF = fechaInputF.split("/");
	let oldDateF = new Date(partesF[2], partesF[1] - 1, partesF[0]);
	
	$("#txtBusFecFin").datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true,
		todayHighlight: true,
	}).on('changeDate', function (e) {
		if (e.date === undefined){ return $(this).datepicker("update", oldDateF)};
		oldDateF = e.date;
	});
  
  nro_ultima_atencion();
  busca_calendariocita_mes_anio();

  dTable = $('#tblAtencion').DataTable({
    dom: 'Bltip',
    "buttons": [
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
      {
        text: '<i class="glyphicon glyphicon-search"></i> Búsqueda de pacientes',
        className: "btn btn-success btn-lg",
        action: function ( e, dt, node, config ) {
          open_buscar();
        }

      },
	  {
        text: '<i class="glyphicon glyphicon-open"></i> Exportar lista',
        className: "btn btn-warning btn-lg",
        action: function ( e, dt, node, config ) {
          open_exporbuscar();
        }
      }
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
		
		if($("#txt_bus_id_producto").val() !== null){
			var id_producto = $("#txt_bus_id_producto").val().join();
		} else {
			var id_producto = "";
		}
		aoData.push({"name": "idTipDoc", "value": $("#txtBusIdTipDoc").val()});
		aoData.push({"name": "nroDoc", "value": $("#txtBusNroDoc").val()});
		aoData.push({"name": "nomRS", "value": $("#txtBusNomRS").val()});
		aoData.push({"name": "fecIni", "value": $("#txtBusFecIni").val()});
		aoData.push({"name": "fecFin", "value": $("#txtBusFecFin").val()});
		aoData.push({"name": "nroAte", "value": $("#txtBusNroAten").val()});
		aoData.push({"name": "nroAteOtro", "value": $("#txtBusNroAtenOrion").val()});
		aoData.push({"name": "optUrgente", "value": $("input[type=radio][name=opt_bus_urgente]:checked").val()});
		aoData.push({"name": "idProducto", "value": id_producto});

    },
	"createdRow": function(row, data, index) {
		if (data[8] == "VALID./PARTE" ){
			console.log(row);
			$('td:eq(8)', row).addClass('primary');
		} else if (data[8] == "VALID./COMPL" ){
			$('td:eq(8)', row).addClass('success');
		} else if (data[8] == "PEND. VALID." ){
			$('td:eq(8)', row).addClass('warning');
		}
		
		if (data[7] == "RECIB./PARTE" ){
			$('td:eq(7)', row).addClass('active');
		} else if(data[7] == "RECIB./COMPL."){
			$('td:eq(7)', row).addClass('info');
		} else if(data[7] == "NO ASISTIO"){
			$('td:eq(7)', row).addClass('warning');
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
      {"orderable": false, "targets": 0, "searchable": false, "class": "text-center"},
      {"orderable": true, "targets": 1, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 2, "searchable": false, "class": ""},
      {"orderable": false, "targets": 3, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 4, "searchable": false, "class": "text-center font-weit"},
      {"orderable": false, "targets": 5, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 6, "searchable": false, "class": "text-center font-weit"},
      {"orderable": true, "targets": 7, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 8, "searchable": false, "class": "text-center"},
      {"orderable": false, "targets": 9, "searchable": false, "class": "text-center"}
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
  
  var multiselect_options = {
	enableFiltering: true,
	includeSelectAllOption: true,
	selectAllName: 'select-all-name',
	nSelectedText: 'Seleccionados',
	nonSelectedText: 'Seleccionar',
	allSelectedText: 'TODOS',
	filterPlaceholder: 'Buscar',
	selectAllText: 'SELECCIONAR TODOS',
	buttonClass: 'btn input-sm',
	enableFiltering: true,
	enableCaseInsensitiveFiltering: true,
	inheritClass: true,
	maxHeight: 200,
	buttonWidth: '100%',
	widthSynchronizationMode: 'ifPopupIsSmaller'
  };
  $('#txt_bus_id_producto').multiselect(multiselect_options);
  
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
	$("#env_orion_correcto").hide();
	$("#env_orion_error").hide();
	$("#env_diagnostica_contenido").hide();
  bootbox.confirm({
    title: "Mensaje",
    message: "Enviar datos de atención al otro sistema?",
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
			  if(datos[0] == "NEA"){
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_orion_contenido").text('No Existe Atencion');
			  } else if(datos[0] == "NEE"){
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_orion_contenido").text('No existen examenenes homologados con el interfaz.');
			  } else if(datos[0] == "RC"){
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

function formatJson(json) {
  var formatted = '<ul>';
  for (const key in json) {
    if (json.hasOwnProperty(key)) {
      const value = json[key];
      if (typeof value === 'object' && value !== null) {
        // Si es un objeto o arreglo, llama recursivamente
        formatted += `<li><strong>${key}:</strong> ${formatJson(value)}</li>`;
      } else {
        // Si es un valor primitivo, simplemente lo muestra
        formatted += `<li><strong>${key}:</strong> ${value}</li>`;
      }
    }
  }
  formatted += '</ul>';
  return formatted;
}

function envia_datos_reg_diagnostica(id) {
  bootbox.confirm({
    title: "Mensaje",
    message: "Enviar datos de atención al otro sistema?",
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
			"accion": "REG_ORDEN_DIAGNOSTICA",
			"id_atencion": id
		  };
		  $.ajax({
			data: parametros,
			url: '../../controller/ctrlWSOtraEmpresa.php',
			type: 'post',
			dataType: 'json',
			success: function (result) {
			  $("#loaderModal").hide();
			  var datos = eval(result);
			  var formattedData = '';
			if (result && typeof result === 'object') {
				formattedData = formatJson(result);
            }            
			  
			  //$("#env_diagnostica_contenido").html(formattedData);
			  if(datos[0] == "NET"){
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_diagnostica_contenido").text('Error al obtener Token (Diagnóstica)');
			  } else if(datos[0] == "NEA"){
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_diagnostica_contenido").text('No Existe Atencion');
			  } else if(datos[0] == "NEE"){
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_diagnostica_contenido").text('No existen examenenes homologados con el interfaz.');
			  } else if(datos[0] == "RC"){
				  $("#env_orion_correcto").show();
				  $("#env_orion_error").hide();
				  $("#env_diagnostica_contenido").text("CODIGO: " + datos[2]);
			  } else {
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_diagnostica_contenido").text(datos[1]);
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
  }).on('shown.bs.modal', function () {
  // Cambiar el color de la cabecera del modal
  $('.bootbox .modal-header').css({
    'background-color': '#fdc500', // Cambiar a tu color preferido
    'color': '#fff', // Cambiar el color del texto si es necesario
	'border-bottom': '1px solid #fdc500'
  });
});
}

function envia_datos_edit_orion(id) {
  bootbox.confirm({
    title: "Mensaje",
    message: "Enviar datos de atención al otro sistema?",
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
			"accion": "POST_EDIT_ATENCION",
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
			  if(datos[0] == "NEA"){
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_orion_contenido").text('No Existe Atencion');
			  } else if(datos[0] == "NEE"){
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_orion_contenido").text('No existen examenenes homologados con el interfaz.');
			  } else if(datos[0] == "RC"){
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


function envia_datos_edit_diagnostica(id) {
	$("#env_orion_correcto").hide();
	$("#env_orion_error").hide();
	$("#env_diagnostica_contenido").hide();
  bootbox.confirm({
    title: "Mensaje",
    message: "Enviar datos de atención al otro sistema?",
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
			"accion": "EDIT_ORDEN_DIAGNOSTICA",
			"id_atencion": id
		  };
		  $.ajax({
			data: parametros,
			url: '../../controller/ctrlWSOtraEmpresa.php',
			type: 'post',
			dataType: 'json',
			success: function (result) {
			  $("#loaderModal").hide();
			  var datos = eval(result);
			  if(datos[0] == "NEA"){
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_orion_contenido").text('No Existe Atencion');
			  } else if(datos[0] == "NEE"){
				  $("#env_orion_error").show();
				  $("#env_orion_correcto").hide();
				  $("#env_orion_contenido").text('No existen examenenes homologados con el interfaz.');
			  } else if(datos[0] == "RC"){
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

function envia_datos_elim_orion(id) {
	$("#loaderModal").show();
	var parametros = {
		"accion": "POST_ELIM_ATENCION",
		"id_atencion": id,
		"motivo": document.frmComentario.txtDetComen.value,
	};
	$.ajax({
		data: parametros,
		url: '../../controller/ctrlWSOrion.php',
		type: 'post',
		dataType: 'json',
		success: function (result) {
			$("#loaderModal").hide();
			buscar_datos();
		}
	});
}


function envia_datos_elim_diagnostica(id) {
	$("#loaderModal").show();
	var parametros = {
		"accion": "ELIM_ORDEN_DIAGNOSTICA",
		"id_atencion": id,
		"motivo": document.frmComentario.txtDetComen.value,
	};
	$.ajax({
		data: parametros,
		url: '../../controller/ctrlWSOtraEmpresa.php',
		type: 'post',
		dataType: 'json',
		success: function (result) {
			$("#loaderModal").hide();
			buscar_datos();
		}
	});
}
</script>
<?php require_once '../include/masterfooter.php'; ?>
