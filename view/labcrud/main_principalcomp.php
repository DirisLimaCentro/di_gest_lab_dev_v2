<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php';
require_once '../../model/UnidadMedida.php';
$um = new UnidadMedida();
require_once '../../model/Componente.php';
$co = new Componente();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>Mantenimiento de Componentes de Laboratorio Clínico</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-4">
          <div class="box box-success">
            <br/>
            <div class="box-body box-profile">
              <h3 class="profile-username text-center" id="titleAcc">Nuevo Componente</h3>
              <form id="frmComp" name="frmComp">
                <input type="hidden" name="txtIdComp" id="txtIdComp" value="0"/>
                <div class=" form-group col-xs-12 col-xs-12">
                  <label for="txtNomComp">Nombre</label>
                  <input type="text" class="form-control input-sm" name="txtNomComp" id="txtNomComp" autocomplete="off" maxlength="500"/>
                  <span class="help-block">Considere mayúsculas y minúsculas</span>
                </div>
				<div class="row  col-xs-12">
					<div class="col-sm-10 form-group">
					  <label for="txtIdUnidMed">Unidad de medida</label>
					  <?php $rsUM = $um->get_listaUnidadMedida(); ?>
					  <select name="txtIdUnidMed" id="txtIdUnidMed" class="form-control input-sm" style="width: 100%">
						<option value="" selected>-- Seleccione --</option>
						<option value="0"> SIN UNID. MEDIDA</option>
						<?php
						foreach ($rsUM as $rowUM) {
						  echo "<option value='" . $rowUM['id_unimedida'] . "'>" . $rowUM['descrip_unimedida'] . "</option>";
						}
						?>
					  </select>
					</div>
					<div class="form-group col-xs-12 col-sm-2"><br/>
						<button type="button" class="btn btn-success btn-block" id="btnAddUnidMed" onclick="open_reg_unidmedida()"><i class="fa fa-plus"></i></button>
					</div>
				</div>
                <div class="col-xs-12 form-group">
                  <label for="txtValRefComp">Valor referencial normal</label>
                  <textarea class="form-control" rows="3" name="txtValRefComp" id="txtValRefComp"></textarea>
                </div>
                <div class="col-xs-12 form-group">
                  <label for="txtIngSoluComp">Casilla ingreso resultado</label>
                  <select name="txtIngSoluComp" id="txtIngSoluComp" class="form-control input-sm" onchange="habilita_tipo_ingreso()">
                    <option value="" selected>-- Seleccione --</option>
                    <option value="1">LINEA</option>
                    <option value="2">MULTILINEA</option>
					<option value="3">SELECCION</option>
                  </select>
                </div>
                <div class="col-xs-12 form-group">
					  <label for="optTipoCaracResult">Tipo ingreso caracter resultado</label>
					  <div class="radio">
						<label><input type="radio" class="optTipoCarac" name="optTipoCaracResult" id="optTipoCaracResult1" value="1" disabled> Letras y números</label>
					  </div>
					  <div class="radio">
						<label><input type="radio" class="optTipoCarac" name="optTipoCaracResult" id="optTipoCaracResult2" value="2" disabled> Solo letras</label>
					  </div>
					  <div class="radio" style="margin-bottom: 0px;">
						<label><input type="radio" class="optTipoCarac" name="optTipoCaracResult" id="optTipoCaracResult3" value="3" disabled> Número enteros</label>
					  </div>
					  <div class="row">
					  <div class="col-xs-12 col-sm-8">
					  <div class="radio">
						<div class="input-group input-group-xs">
						  <span class="input-group-addon">
							<label class="radio-inline">
							  <input type="radio" class="optTipoCarac" name="optTipoCaracResult" id="optTipoCaracResult4" value="4" disabled> Número decimal
							</label>
						  </span>
						  <input class="form-control input-xs" type="text" name="txtDetCaracResul" id="txtDetCaracResul" placeholder="" maxlength="10" value=""  disabled/>
						</div>
						<span class="help-block">Ingresar cantidad de Decimales (1-4)</span>
					  </div>
					</div>
					</div>
                </div>
				<div class="row  col-xs-12">
					<div class="form-group col-xs-12 col-sm-10">
					  <label for="txtIngSeleccion">Tipo selección resultado</label>
					  <?php $rsCo = $co->get_listaTipoSeleccionResultado(); ?>
					  <select name="txtIngSeleccion" id="txtIngSeleccion" class="form-control input-sm" onchange="show_seleccion_resul()" disabled>
						<option value="" selected>-- Seleccione --</option>
						<?php
						foreach ($rsCo as $row) {
						  echo "<option value='" . $row['id'] . "'>" . $row['tipo'] . "</option>";
						}
						?>
					  </select>
					</div>
					<div class="form-group col-xs-12 col-sm-2"><br/>
						<button type="button" class="btn btn-success btn-block" id="btnOpenSeleccion" onclick="open_reg_seleccion_resul('IT')" disabled><i class="fa fa-plus"></i></button>
					</div>
					<div id="show-seleccion-resul"></div>
				</div>
				
				<hr/>
				<br/>
				<div class="col-xs-12">
					<button type="button" class="btn btn-primary btn-block" id="btnValidForm" onclick="validForm()"><i class="fa fa-save"></i> Guardar </button>
					<div id="show-new" style="display:none; margin-top:5px;">
					  <button type="button" class="btn btn-success btn-block" id="btnNewForm" onclick="nuevo_registro()"><i class="glyphicon glyphicon-plus"></i> Nuevo Componente </button>
					</div>
				</div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="box box-primary">
			  <div class="box-body box-profile">
				<br/>
				<table id="tblAtencion" class="display" cellspacing="0" width="100%">
				  <thead>
					<tr>
					  <th>Nombre</th>
					  <th>Unid. Medidad</th>
					  <th>Valor Ref.</th>
					  <th>Ingreso Resul.</th>
					  <th>Tipo Caracter<br/>Soluc.</th>
					  <th>Tipo Selección<br/>Soluc.</th>
					  <th>Estado</th>
					  <th><i class="fa fa-cogs"></i></th>
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
    <div class="modal-footer">
      <button type="button" class="btn btn-info pull-right" id="btnBackForm" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Ir al Menú</button>
    </div>
  </div>
</div>

<div class="modal fade" id="showMetCompModal" tabindex="-1" role="dialog" aria-labelledby="showMetCompModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showMetCompModalLabel"></h4>
      </div>
	  <div class="modal-body">
		<form id="frmCompMetodo" name="frmCompMetodo" class="form-horizontal">
			<input type="hidden" name="txt_id_comp_metodo" id="txt_id_comp_metodo" value="0"/>
			<div class="form-group">
			  <div class="col-sm-3">
				<br/>
				<button type="button" class="btn btn-success btn-sm" onclick="open_lista_metodos()"><i class="glyphicon glyphicon-plus"></i> Mantenimiento de método</button>
			  </div>
			  <div class="col-sm-3">
				  <label for="txt_abrev_plan">Método</label>
				  <?php $rsMet = $co->get_listaMetodos(0,1); ?>
				  <select name="txt_select_id_metodo" id="txt_select_id_metodo" class="form-control input-sm">
					<option value="" selected>-- Seleccione --</option>
					<?php
					foreach ($rsMet as $rowM) {
					  echo "<option value='" . $rowM['id'] . "'>" . $rowM['nombre_metodo'] . "</option>";
					}
					?>
					</select>
			  </div>
			  <div class="col-sm-3">
				  <label for="txt_id_tipo_val_ref">Tipo Ing. Valor Ref.</label>
				  <select class="form-control input-sm" name="txt_id_tipo_val_ref" id="txt_id_tipo_val_ref">
					<option value="" selected>-- Seleccione --</option>
					<option value="1">POR EDAD</option>
					<option value="2">POR PORCENTAJE</option>
				  </select/>
			  </div>
			  <div class="col-sm-2">
					<br/>
					<button type="button" class="btn btn-primary btn-block" id="btnSaveCompMet" onclick="save_form_comp_metodo()"><i class="fa fa-save"></i> Guardar </button>
				</div>
			</div>
			<hr>
		  </form>
        <div id="datos-tabla-met">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th><small>Método</small></th>
				<th><small>Tipo ing. valor ref.</small></th>
                <th><small>Descripción</small></th>
                <th><small>Cnt. Valores</small></th>
                <th><small>Estado</small></th>
                <th><small>&nbsp;</small></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
		<small>
			<div class="alert alert-warning">
				- <b>Tipo Ing. Valor Ref. - POR EDAD:</b> Indica que los valores refereciales se ingresarán por edades, Ejemplo: HEMOGLOBINA.<br/>
				- <b>Tipo Ing. Valor Ref. - POR PORCENTAJE:</b> Puede ser la misma edad, pero en los limites Inf. y Sup. se pone el rango del porcentaje y en la descripción se pone la condición, Ejemplo: HEMOGLOBINA GLICOSILADA HbA1c<br/>
			</div>
		</small>
		
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Aceptar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
	</div>
</div>

<div class="modal fade" id="showMetodoModal" tabindex="-1" role="dialog" aria-labelledby="showMetodoModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showMetodoModalLabel">MANTENIMIENTO DE METODOS</h4>
      </div>
      <div class="modal-body">
        <form id="frmMetodo" name="frmMetodo" class="form-horizontal">
			<input type="hidden" name="txt_id_metodo" id="txt_id_metodo" value="0">
			<p><span><b>Acción:</b> <span id="titleAccMetodo">NUEVO METODO</span></p>
			<div class="form-group">
			  <div class="col-sm-3">
				  <label for="txt_abrev_metodo">Abreviatura</label>
				  <input type="text" class="form-control input-sm" name="txt_abrev_metodo" id="txt_abrev_metodo" autocomplete="off" maxlength="25">
				  <span class="help-block">Hasta 25 caracteres</span>
			  </div>
			  <div class="col-sm-3">
				  <label for="txt_nombre_metodo">Nombre</label>
				  <input type="text" class="form-control input-sm" name="txt_nombre_metodo" id="txt_nombre_metodo" autocomplete="off" maxlength="75">
				  <span class="help-block">Hasta 75 caracteres</span>
			  </div>
			  <div class="col-sm-4">
				  <label for="txt_descrip_metodo">Descripción</label>
				  <textarea class="form-control input-sm" name="txt_descrip_metodo" id="txt_descrip_metodo" autocomplete="off"></textarea>
			  </div>
				<div class="col-sm-2">
					<br/>
					<button type="button" class="btn btn-primary btn-block" id="btnSaveMetodo" onclick="save_form_metodo()"><i class="fa fa-save"></i> Guardar </button>
				</div>
			</div>
			<hr>
		  </form>
        <div id="datos-lista-met" style="height: 250px;">
          <table id="fixTableMetodo" class="table table-bordered table-hover">
            <thead>
              <tr>
				<th><small>Abreviatura</small></th>
                <th><small>Nombre</small></th>
                <th><small>Descripción</small></th>
                <th><small>Estado</small></th>
                <th><small>&nbsp;</small></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Aceptar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
	</div>
</div>

<div class="modal fade" id="showValCompModal" tabindex="-1" role="dialog" aria-labelledby="showValCompModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showValCompModalLabel"></h4>
      </div>
      <div class="modal-body">
        <div style="margin-bottom: 5px;">
          <button class="btn btn-primary btn-sm" onclick="reg_valores()"><i class="glyphicon glyphicon-plus"></i> Agregar Valor Referencial</button>
        </div>
        <div id="datos-tabla">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th><small>Sexo</small></th>
                <th><small>Edad Mínima</small></th>
                <th><small>Edad Máxima</small></th>
                <th><small>Lim. Inf.</small></th>
                <th><small>Lim. Sup.</small></th>
                <th><small>Descripción</small></th>
                <th><small>Estado</small></th>
                <th><small>&nbsp;</small></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Aceptar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
	</div>
</div>

  <div class="modal fade" id="showValorModal" role="dialog" aria-labelledby="showValorModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showValorModalLabel">Agregar Valor Referencial</h4>
        </div>
        <div class="modal-body">
          <form name="frmValor" id="frmValor">
            <input type="hidden" name="txtIdComp" id="txtIdComp" value="0"/>
			<input type="hidden" name="txt_id_comp_metodo" id="txt_id_comp_metodo" value="0"/>
            <input type="hidden" name="txtIdValComp" id="txtIdValComp" value="0"/>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					  <div class="row">
						<div class="col-sm-12">
						  <label for="txtIdArea">Sexo</label>
							<select class="form-control input-sm" name="txtIdSexo" id="txtIdSexo">
							  <option value="">-- Seleccione --</option>
							  <option value="A">AMBOS</option>
							  <option value="F">FEMENINO</option>
							  <option value="M">MASCULINO</option>
							</select>
						</div>
					  </div>
					</div>
					<h4 class="modal-title">Edad Mínima</h4>
					<div class="form-group">
					  <div class="row">
						<div class="col-sm-3">
						  <label for="txtAnioMin">Años</label>
						  <input type="text" class="form-control input-sm" name="txtAnioMin" id="txtAnioMin" value="0" onfocus="this.select()"/>
						</div>
						<div class="col-sm-3">
						  <label for="txtMesMin">Meses</label>
						  <input type="text" class="form-control input-sm" name="txtMesMin" id="txtMesMin" value="0" onfocus="this.select()"/>
						</div>
						<div class="col-sm-3">
						  <label for="txtDiaMin">Días</label>
						  <input type="text" class="form-control input-sm" name="txtDiaMin" id="txtDiaMin" value="0" onfocus="this.select()"/>
						</div>
					  </div>
					</div>
					<h4 class="modal-title">Edad Máxima</h4>
					<div class="form-group">
					  <div class="row">
						<div class="col-sm-3">
						  <label for="txtAnioMax">Años</label>
						  <input type="text" class="form-control input-sm" name="txtAnioMax" id="txtAnioMax" value="0" onfocus="this.select()"/>
						</div>
						<div class="col-sm-3">
						  <label for="txtMesMax">Meses</label>
						  <input type="text" class="form-control input-sm" name="txtMesMax" id="txtMesMax" value="0" onfocus="this.select()"/>
						</div>
						<div class="col-sm-3">
						  <label for="txtDiaMax">Días</label>
						  <input type="text" class="form-control input-sm" name="txtDiaMax" id="txtDiaMax" value="0" onfocus="this.select()"/>
						</div>
					  </div>
					</div>
					<h4 class="modal-title">Límites</h4>
					<div class="form-group">
					  <div class="row">
						<div class="col-sm-4">
						  <label for="txtLimInf">Lim. Inf.</label>
						  <input type="text" class="form-control input-sm" name="txtLimInf" id="txtLimInf" value="0" onfocus="this.select()"/>
						</div>
						<div class="col-sm-4">
						  <label for="txtLimSup">Lim. Sup.</label>
						  <input type="text" class="form-control input-sm" name="txtLimSup" id="txtLimSup" value="0" onfocus="this.select()"/>
						</div>
					  </div>
					</div>
					<div class="form-group">
						  <label for="txtIdGrupoArea">Descripción</label>
						  <textarea class="form-control" name="txtDescrip" id="txtDescrip" ></textarea>
					</div>
				</div>
				<div class="col-sm-6">
					<small>
						<div class="alert alert-warning">
							- Como valor mínimo en <b>MESES</b> es 0 y como máximo 12.<br/>
							- Como valor mínimo en <b>DIAS</b> es 0 y como máximo 31.
						</div>
						<div class="alert alert-success">
							- Si desea que el valor ref. se muestre de esta manera <b>" > 12.5 "</b>, deberá poner como Lim. Inf. <b>12.5</b> y como Lim. Sup. <b>99999</b><br/>
							- Si desea que el valor ref. se muestre de esta manera <b>" < 12.5 "</b>, deberá poner como Lim. Inf. <b>-1</b> y como Lim. Sup. <b>12.5</b><br/>
						</div>
					</small>
				</div>
			</div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-continuar" id="btnValidFormVal" onclick="save_formVal()"><i class="fa fa-save"></i> Guardar </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
<div class="modal fade" id="showRegUniMedModal" role="dialog" aria-labelledby="showRegUniMedModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showUniMedModalLabel">REGISTRAR UNID. MEDIDA </h4>
        </div>
        <div class="modal-body">
          <form name="frmUnidMedida" id="frmUnidMedida">
              <div class="row">
                <div class="form-group col-sm-12">
                  <label for="txtAnioMin">Descripción:</label>
                  <input type="text" class="form-control input-sm text-uppercase" name="txt_nombre_unimedida" id="txt_nombre_unimedida" value="" onfocus="this.select()"/>
                </div>
                <div class="form-group col-sm-6">
                  <label for="txtAnioMin">Abreviatura:</label>
                  <input type="text" class="form-control input-sm" name="txt_descrip_unimedida" id="txt_descrip_unimedida" value="" onfocus="this.select()"/>
                </div>
              </div>
          </form>
			<div class="alert alert-warning">
				- Para la <b>ABREVIATURA</b>, considere mayúsculas y minúsculas<br/>
				- La <b>ABREVIATURA</b>, es el que se mostrará en la ficha de resultado.
			</div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-continuar" id="btnValidUnidMedida" onclick="save_reg_unidmedida()"><i class="fa fa-save"></i> Guardar </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
  
<div class="modal fade" id="showResulSelectModal" role="dialog" aria-labelledby="showResulSelectModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showResulSelectModalLabel"></h4>
        </div>
        <div class="modal-body">
          <form name="frmResulSelect" id="frmResulSelect">
			<input type="hidden" name="txt_accion_selectresul" id="txt_accion_selectresul" value=""/>
			<input type="hidden" name="txtIngSeleccionDet" id="txtIngSeleccionDet" value=""/>
              <div class="row">
                <div class="form-group col-sm-12">
                  <label for="txt_nombre_selectresul">Descripción:</label>
                  <input type="text" class="form-control input-sm text-uppercase" name="txt_nombre_selectresul" id="txt_nombre_selectresul" value="" onfocus="this.select()" maxlength="150"/>
                </div>
                <div class="form-group col-sm-7">
                  <label for="txt_abreviatura_selectresul">Abreviatura:</label>
                  <input type="text" class="form-control input-sm text-uppercase" name="txt_abreviatura_selectresul" id="txt_abreviatura_selectresul" value="" onfocus="this.select()" maxlength="35"/>
                </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-continuar" id="btnValidSelecResul" onclick="save_reg_seleccion_resul()"><i class="fa fa-save"></i> Guardar </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">

function show_seleccion_resul(){
  $.ajax({
    url: "../../controller/ctrlComponente.php",
    type: "POST",
	dataType: "json",
    data: {
      accion: 'GET_SHOW_DETSELECCIONRESULTADOPORIDSELECCION', id_comp_seleccion: $("#txtIngSeleccion").val()
    },
    success: function (result) {
      var newOption = "<table class='table table-bordered'><thead><th>RESULTADOS</th><th>D</th><th>N</th><th>ORD</th><th></th></thead><tbody>";
      $(result).each(function (ii, oo) {
		newOption += "<tr>";
        newOption += "<td><small>" + oo.nombre + "</small></td>";
		newOption += "<td class='text-center'><small>" + oo.valor_defecto_resul + "</small></td>";
		newOption += "<td class='text-center'><small>" + oo.negrita + "</small></td>";
		newOption += "<td class='text-center'><small>" + oo.orden_muestra_resul + "</small></td>";
		newOption += "<td><small><button type='button' class='btn btn-primary btn-xs' onclick='cambio_orden_seleccion(" + oo.id + ",\"BD\"," + oo.orden_muestra_resul + ");'><i class='glyphicon glyphicon-circle-arrow-up'></i></button> <button type='button' class='btn btn-primary btn-xs' onclick='cambio_orden_seleccion(" + oo.id + ",\"SD\"," + oo.orden_muestra_resul + ");'><i class='glyphicon glyphicon-circle-arrow-down'></i></button> <button type='button' class='btn btn-success btn-xs' onclick='open_edit_seleccion_resul(" + JSON.stringify(oo) + ");'><i class='glyphicon glyphicon-pencil'></i></button> <button type='button' class='btn btn-warning btn-xs' onclick='cambio_negrita_seleccion(" + oo.id + ");'><i class='fa fa-bold'></i></button> <button type='button' class='btn btn-primary btn-xs' onclick='cambio_default_seleccion(" + oo.id + ");'><i class='fa fa-arrow-circle-left'></i></button> <button type='button' class='btn btn-danger btn-xs' onclick='cambio_estado_seleccion(" + oo.id + ");'><i class='glyphicon glyphicon-trash'></i></button></small></td>";
		newOption += "<tr>";
		
      });
	  newOption += "</tbody><tfoot><tr><td colspan='5'><button type='button' class='btn btn-success btn-block' id='btnAddDetCompResul' onclick='open_reg_seleccion_resul()'><i class='fa fa-plus'></i> Agregar otro resultado</button></td></tr></tfoot></table>";
      $("#show-seleccion-resul").html(newOption);
    }
  });
}

function open_reg_seleccion_resul(accion){
  if(accion){
	  $('#txt_accion_selectresul').val(accion);
  } else {
	  $('#txt_accion_selectresul').val('ID');
  }
	  

  $('#showResulSelectModal').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });

  $('#showResulSelectModal').on('shown.bs.modal', function (e) {
    var modal = $(this);
	if(accion){
		modal.find('.modal-title').text('REGISTRAR TIPO DE RESULTADO')
	} else {
		var combo = document.getElementById("txtIngSeleccion");
		modal.find('.modal-title').text('REGISTRAR RESULTADO: ' + combo.options[combo.selectedIndex].text)
	}
  })
  
   $("#txt_nombre_selectresul").val('');
   $("#txt_abreviatura_selectresul").val('');
}

function open_edit_seleccion_resul(data){
	$('#txt_accion_selectresul').val('AD');

	$("#txtIngSeleccionDet").val(data.id);
	$("#txt_nombre_selectresul").val(data.nombre);
	$("#txt_abreviatura_selectresul").val(data.abreviatura);
	
   
	$('#showResulSelectModal').modal({
		show: true,
		backdrop: 'static',
		focus: true,
	});

	$('#showResulSelectModal').on('shown.bs.modal', function (e) {
		var modal = $(this);
		var combo = document.getElementById("txtIngSeleccion");
		modal.find('.modal-title').text('EDITAR RESULTADO: ' + combo.options[combo.selectedIndex].text)
	})
}


function save_reg_seleccion_resul() {
	$('#btnValidSelecResul').prop("disabled", true);
	var msg = "";
	var sw = true;
	var id = 0;

	var nombre = $('#txt_nombre_selectresul').val();
	var abreviatura = $('#txt_abreviatura_selectresul').val().trim();
	var accion_proc = $('#txt_accion_selectresul').val().trim();

	if(accion_proc == "ID"){
		if($('#txtIngSeleccion').val() == ""){
			msg+= "Seleccione Tipo selección resultado<br/>";
			sw = false;
		}
		id = $('#txtIngSeleccion').val();
	} else if (accion_proc == "AD"){
		id = $('#txtIngSeleccionDet').val();
	}

  if(nombre.length <= 2){
    msg+= "Ingrese DESCRIPCIÓN<br/>";
    sw = false;
  }
  if(abreviatura.length <= 2){
    msg+= "Ingrese ABREVIATURA<br/>";
    sw = false;
  }

  if (sw == false) {
	showMessage(msg, "error");
    $('#btnValidSelecResul').prop("disabled", false);
    return false;
  }

  bootbox.confirm({
    message: "Se registrará los datos ingresados, ¿Está seguro de continuar?",
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
        var myRand = parseInt(Math.random() * 999999999999999);
        var form_data = new FormData();
        form_data.append('accion', 'POST_ADD_REGSELECCIONRESULTADO');
		form_data.append('accion_proc', accion_proc);
		form_data.append('id', id);
        form_data.append('abreviatura', $('#txt_abreviatura_selectresul').val().trim());
        form_data.append('nombre', $('#txt_nombre_selectresul').val().trim());

        form_data.append('rand', myRand);
        $.ajax( {
          url: '../../controller/ctrlComponente.php',
          dataType: 'text', // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'POST',
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $("#showResulSelectModal").modal('hide');
				if(accion_proc == 'IT'){
					carga_select_tiposelectresul();
					$("#show-seleccion-resul").html('');
					showMessage("Registrado ingresado correctamente.", "success");
				} else if(accion_proc == 'ID') {
					show_seleccion_resul();
					showMessage("Registrado ingresado correctamente.", "success");
				} else {
					showMessage("Registrado actualizado correctamente.", "success");
					show_seleccion_resul();
				}
            } else {
			  showMessage(msg, "error");
			  $('#btnValidSelecResul').prop("disabled", false);
              return false;
            }
            $('#btnValidSelecResul').prop("disabled", false);
          }
        });
      } else {
        $('#btnValidSelecResul').prop("disabled", false);
      }
    }
  });
}

function cambio_negrita_seleccion(id) {
	bootbox.confirm({
	  message: "Esto hará que resalte el resultado en la ficha de resultado, ¿Está seguro de continuar?",
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
		  var myRand = parseInt(Math.random() * 999999999999999);
		  var form_data = new FormData();
		  form_data.append('accion', 'POST_ADD_REGSELECCIONRESULTADO');
		  form_data.append('accion_proc', 'EN');
		  form_data.append('id', id);
		  form_data.append('rand', myRand);
		  $.ajax( {
			url: '../../controller/ctrlComponente.php',
			dataType: 'text', // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
			  var tmsg = data.substring(0, 2);
			  var lmsg = data.length;
			  var msg = data.substring(3, lmsg);
			  if(tmsg == "OK"){
				show_seleccion_resul();
				showMessage("Registrado actualizado correctamente.", "success");
			  } else {
				bootbox.alert(msg);
				return false;
			  }
			}
		  });
		} else {
		  
		}
	  }
	});
}

function cambio_default_seleccion(id) {
	bootbox.confirm({
	  message: "Esto hará que cambie el valor por defecto en el resultado del examen, ¿Está seguro de continuar?",
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
		  var myRand = parseInt(Math.random() * 999999999999999);
		  var form_data = new FormData();
		  form_data.append('accion', 'POST_ADD_REGSELECCIONRESULTADO');
		  form_data.append('accion_proc', 'VDD');
		  form_data.append('id', id);
		  form_data.append('rand', myRand);
		  $.ajax( {
			url: '../../controller/ctrlComponente.php',
			dataType: 'text', // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
			  var tmsg = data.substring(0, 2);
			  var lmsg = data.length;
			  var msg = data.substring(3, lmsg);
			  if(tmsg == "OK"){
				show_seleccion_resul();
				showMessage("Registrado actualizado correctamente.", "success");
			  } else {
				bootbox.alert(msg);
				return false;
			  }
			}
		  });
		} else {
		  
		}
	  }
	});
}


function cambio_orden_seleccion(id,opt,ord) {
	bootbox.confirm({
	  message: "Esto hará que cambie el orden al momento de mostrar los resultados, ¿Está seguro de continuar?",
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
		  var myRand = parseInt(Math.random() * 999999999999999);
		  var form_data = new FormData();
		  form_data.append('accion', 'POST_ADD_REGSELECCIONRESULTADO');
		  form_data.append('accion_proc', opt);
		  form_data.append('id', id);
		  form_data.append('nro_orden_actu', ord);
		  form_data.append('rand', myRand);
		  $.ajax( {
			url: '../../controller/ctrlComponente.php',
			dataType: 'text', // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
			  var tmsg = data.substring(0, 2);
			  var lmsg = data.length;
			  var msg = data.substring(3, lmsg);
			  if(tmsg == "OK"){
				show_seleccion_resul();
				showMessage("Registrado actualizado correctamente.", "success");
			  } else {
				bootbox.alert(msg);
				return false;
			  }
			}
		  });
		} else {
		  
		}
	  }
	});
}

function cambio_estado_seleccion(id) {
	bootbox.confirm({
	  message: "Se cambiará el estado, ¿Está seguro de continuar?",
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
		  var myRand = parseInt(Math.random() * 999999999999999);
		  var form_data = new FormData();
		  form_data.append('accion', 'POST_ADD_REGSELECCIONRESULTADO');
		  form_data.append('accion_proc', 'ED');
		  form_data.append('id', id);
		  form_data.append('rand', myRand);
		  $.ajax( {
			url: '../../controller/ctrlComponente.php',
			dataType: 'text', // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
			  var tmsg = data.substring(0, 2);
			  var lmsg = data.length;
			  var msg = data.substring(3, lmsg);
			  if(tmsg == "OK"){
				show_seleccion_resul();
				showMessage("Registrado eliminado correctamente.", "success");
			  } else {
				bootbox.alert(msg);
				return false;
			  }
			}
		  });
		} else {
		  
		}
	  }
	});
}

function carga_select_tiposelectresul(){
	$.ajax({
		  url: "../../controller/ctrlComponente.php",
		  type: "POST",
		  dataType: "json",
		  data: {
			accion: 'GET_SHOW_LISTATIPOSELECCIONRESULTADO',
		  },
		  success: function (result) {
			var newOption = "";
			newOption = "<option value='' selected>--Seleccionar-</option>";
			$(result).each(function (ii, oo) {
				newOption += "<option value='" + oo.id + "'>" + oo.tipo + "</option>";
			});
			$('#txtIngSeleccion').html(newOption);
		}
	});
}


function open_reg_unidmedida(){
	$('#showRegUniMedModal').modal({
		show: true,
		backdrop: 'static',
		focus: true,
	});
}


function save_reg_unidmedida() {
	$('#btnValidUnidMedida').prop("disabled", true);
  var msg = "";
  var sw = true;

  var nombre_unimedida = $('#txt_nombre_unimedida').val();
  var descrip_unimedida = $('#txt_descrip_unimedida').val().trim();

  if(nombre_unimedida.length <= 2){
    msg+= "Ingrese DESCRIPCIÓN de la Unid. Medida<br/>";
    sw = false;
  }
  if(descrip_unimedida == ""){
    msg+= "Ingrese ABREVIATURA de la Unid. Medida<br/>";
    sw = false;
  }

  if (sw == false) {
	showMessage(msg, "error");
    $('#btnValidUnidMedida').prop("disabled", false);
    return false;
  }

  bootbox.confirm({
    message: "Se registrará LA UNIDAD DE MEDIDA, ¿Está seguro de continuar?",
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
        var myRand = parseInt(Math.random() * 999999999999999);
        var form_data = new FormData();
        form_data.append('accion', 'POST_ADD_REGUNIDADMEDIDA');
        form_data.append('nombre_unimedida', $('#txt_nombre_unimedida').val().trim());
        form_data.append('descrip_unimedida', $('#txt_descrip_unimedida').val().trim());

        form_data.append('rand', myRand);
        $.ajax( {
          url: '../../controller/ctrlUnidadMedida.php',
          dataType: 'text', // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'POST',
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $("#showRegUniMedModal").modal('hide');
				showMessage("Unidad de medida registrado correctamente.", "success");
				carga_select_unidmedida();
            } else {
			  showMessage(msg, "error");
			  $('#btnValidUnidMedida').prop("disabled", false);
              return false;
            }
            $('#btnValidUnidMedida').prop("disabled", false);
          }
        });
      } else {
        $('#btnValidUnidMedida').prop("disabled", false);
      }
    }
  });
}

function carga_select_unidmedida(){
	$.ajax({
		  url: "../../controller/ctrlUnidadMedida.php",
		  type: "POST",
		  dataType: "json",
		  data: {
			accion: 'GET_SHOW_LISTAUNIDADMEDIDA', labIdDep: '1'
		  },
		  success: function (result) {
			var newOption = "";
			newOption = "<option value=''>--Seleccionar-</option><option value='0'> SIN UNID. MEDIDA</option>";
			$(result).each(function (ii, oo) {
				newOption += "<option value='" + oo.id_unimedida + "'>" + oo.descrip_unimedida + "</option>";
			});
			$('#txtIdUnidMed').html(newOption);
		}
	});
}

function open_lista_metodos(){
  $('#showMetodoModal').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });
  carga_lista_metodo();
}

function carga_lista_metodo(){
  $.ajax({
    url: "../../controller/ctrlMetodo.php",
    type: "POST",
    data: {
      accion: 'GET_SHOW_METODOS'
    },
    success: function (registro) {
      $("#datos-lista-met").html(registro);
    }
  });
}

function carga_select_metodos(){
	$.ajax({
		  url: "../../controller/ctrlMetodo.php",
		  type: "POST",
		  dataType: "json",
		  data: {
			accion: 'GET_SHOW_LISTAMETODOSACTIVO',
		  },
		  success: function (result) {
			var newOption = "";
			newOption = "<option value='' selected>--Seleccionar-</option>";
			$(result).each(function (ii, oo) {
				newOption += "<option value='" + oo.id + "'>" + oo.nombre_metodo + "</option>";
			});
			$('#txt_select_id_metodo').html(newOption);
		}
	});
}

function edit_registro_metodo(id) {
  $.ajax({
    url: "../../controller/ctrlMetodo.php",
    type: "POST",
    dataType: 'json',
    data: {
      accion: 'GET_SHOW_DETMETODO', id: id
    },
    success: function (registro) {
      var datos = eval(registro);
      $('#titleAccMetodo').text('EDITAR METODO');
      document.frmMetodo.txt_id_metodo.value = datos[0];
      document.frmMetodo.txt_abrev_metodo.value =  datos[1];
	  document.frmMetodo.txt_nombre_metodo.value =  datos[2];
	  document.frmMetodo.txt_descrip_metodo.value =  datos[3];
      document.frmMetodo.txt_abrev_metodo.focus();
    }
  });
}

function save_form_metodo() {
	$('#btnSaveMetodo').prop("disabled", false);
	var msg = "";
	var sw = true;

	var abrev_metodo = $('#txt_abrev_metodo').val();
	var nombre_metodo = $('#txt_nombre_metodo').val().trim();
	var descrip_metodo = $('#txt_descrip_metodo').val();

	if(nombre_metodo == ""){
		msg+= "Ingrese el nombre de método<br/>";
		sw = false;
	}

	if (sw == false) {
		bootbox.alert(msg);
		$('#btnSaveMetodo').prop("disabled", disabled);
		return false;
	}

  bootbox.confirm({
    message: "Se registrará el MÉTODO, ¿Está seguro de continuar?",
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
        var myRand = parseInt(Math.random() * 999999999999999);
        var form_data = new FormData();
        form_data.append('accion', 'POST_ADD_REGMETODO');
        form_data.append('accion_sp', 'M');
		form_data.append('id_metodo', document.frmMetodo.txt_id_metodo.value);
		form_data.append('abrev_metodo', document.frmMetodo.txt_abrev_metodo.value);
        form_data.append('nombre_metodo', document.frmMetodo.txt_nombre_metodo.value);
        form_data.append('descrip_metodo', document.frmMetodo.txt_descrip_metodo.value);
        form_data.append('rand', myRand);
        $.ajax( {
          url: '../../controller/ctrlComponente.php',
          dataType: 'text', // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'POST',
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
			  $('#titleAccMetodo').text('NUEVO METODO');
			  document.frmMetodo.txt_id_metodo.value = '0';
			  document.frmMetodo.txt_abrev_metodo.value = '';
			  document.frmMetodo.txt_nombre_metodo.value = '';
			  document.frmMetodo.txt_descrip_metodo.value = '';
              carga_lista_metodo();
			  carga_select_metodos();
			  carga_valores_metodo(document.frmValor.txtIdComp.value);
			  showMessage("Registro ingresado correctamente.", "success");
            } else {
              showMessage(msg, "error");
              return false;
            }
            $('#btnSaveMetodo').prop("disabled", false);
          }
        });
      } else {
        $('#btnSaveMetodo').prop("disabled", false);
      }
    }
  });
}

function cambio_estado_metodo(id,estado) {
	bootbox.confirm({
	  message: "Se cambiará el estado, ¿Está seguro de continuar?",
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
		  var myRand = parseInt(Math.random() * 999999999999999);
		  var form_data = new FormData();
		  form_data.append('accion', 'POST_ADD_REGMETODO');
		  form_data.append('accion_sp', 'ELI');
		  form_data.append('id_metodo', id);
		  form_data.append('rand', myRand);
		  $.ajax( {
			url: '../../controller/ctrlComponente.php',
			dataType: 'text', // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
			  var tmsg = data.substring(0, 2);
			  var lmsg = data.length;
			  var msg = data.substring(3, lmsg);
			  if(tmsg == "OK"){
				carga_lista_metodo();
				carga_select_metodos();
				if (estado == "1"){
					showMessage("Registro eliminado correctamente.", "success");
				} else {
					showMessage("Registro activado correctamente.", "success");
				}
			  } else {
                showMessage(msg, "error");
				return false;
			  }
			}
		  });
		} else {
		  
		}
	  }
	});
}

function open_metodos(idcomp, nomcomp){
  document.frmValor.txtIdComp.value = idcomp;
  carga_valores_metodo(idcomp);

  $('#showMetCompModal').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });

  $('#showMetCompModal').on('shown.bs.modal', function (e) {
    var modal = $(this)
    modal.find('.modal-title').text(nomcomp)
  })
}

function carga_valores_metodo(idcomp){
  $.ajax({
    url: "../../controller/ctrlMetodo.php",
    type: "POST",
    data: {
      accion: 'GET_SHOW_COMPMETODOPORCOMP', id_componente: idcomp
    },
    success: function (registro) {
      $("#datos-tabla-met").html(registro);
    }
  });
}

function save_form_comp_metodo() {
	$('#btnSaveCompMet').prop("disabled", false);
	var msg = "";
	var sw = true;

	var id_metodo = $('#txt_select_id_metodo').val();
	var id_tipo_valref = $('#txt_id_tipo_val_ref').val();

	if(id_metodo == ""){
		msg+= "Seleccione Método<br/>";
		sw = false;
	}
	if(id_tipo_valref == ""){
		msg+= "Seleccione el tipo de ingreso que tendrá los valores referenciales<br/>";
		sw = false;
	}

	if (sw == false) {
		bootbox.alert(msg);
		$('#btnSaveCompMet').prop("disabled", disabled);
		return false;
	}

  bootbox.confirm({
    message: "Se registrará el MÉTODO para este componente, ¿Está seguro de continuar?",
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
        var myRand = parseInt(Math.random() * 999999999999999);
        var form_data = new FormData();
        form_data.append('accion', 'POST_ADD_REGCOMPONENTEMETODO');
        form_data.append('accion_sp', 'M');
		form_data.append('id_componente', document.frmValor.txtIdComp.value);
        form_data.append('id_comp_metodo', document.frmCompMetodo.txt_id_comp_metodo.value);
        form_data.append('id_metodo', id_metodo);
        form_data.append('id_tipo_ing_valref', id_tipo_valref);
        form_data.append('rand', myRand);
        $.ajax( {
          url: '../../controller/ctrlComponente.php',
          dataType: 'text', // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'POST',
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $("#tblAtencion").dataTable().fnDraw();
			  document.frmCompMetodo.txt_id_comp_metodo.value = '0';
			  $('#txt_select_id_metodo').val('');
			  $('#txt_id_tipo_val_ref').val('');
              carga_valores_metodo(document.frmValor.txtIdComp.value);
			  showMessage("Registro ingresado correctamente.", "success");
            } else {
              showMessage(msg, "error");
              return false;
            }
            $('#btnSaveCompMet').prop("disabled", false);
          }
        });
      } else {
        $('#btnSaveCompMet').prop("disabled", false);
      }
    }
  });
}

function cambio_estado_comp_metodo(id,estado) {
	bootbox.confirm({
	  message: "Se cambiará el estado, ¿Está seguro de continuar?",
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
		  var myRand = parseInt(Math.random() * 999999999999999);
		  var form_data = new FormData();
		  form_data.append('accion', 'POST_ADD_REGCOMPONENTEMETODO');
		  form_data.append('accion_sp', 'ELI');
		  form_data.append('id_comp_metodo', id);
		  form_data.append('rand', myRand);
		  $.ajax( {
			url: '../../controller/ctrlComponente.php',
			dataType: 'text', // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
			  var tmsg = data.substring(0, 2);
			  var lmsg = data.length;
			  var msg = data.substring(3, lmsg);
			  if(tmsg == "OK"){
				carga_valores_metodo(document.frmValor.txtIdComp.value);
				if(estado == "1"){
					showMessage("Registro inhabilitado correctamente.", "success");
				} else {
					showMessage("Registro habilitado correctamente.", "success");
				}
			  } else {
                showMessage(msg, "error");
				return false;
			  }
			}
		  });
		} else {
		  
		}
	  }
	});
}


function open_valores(idcompmet, nomcomp){
  document.frmValor.txt_id_comp_metodo.value = idcompmet;
  carga_valores(idcompmet);

  $('#showValCompModal').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });

  $('#showValCompModal').on('shown.bs.modal', function (e) {
    var modal = $(this)
    modal.find('.modal-title').text(nomcomp)
  })
}

function carga_valores(idcompmet){
  $.ajax({
    url: "../../controller/ctrlComponente.php",
    type: "POST",
    data: {
      accion: 'GET_SHOW_COMPVALORREFPORIDCOMP', id_comp_metodo: idcompmet
    },
    success: function (registro) {
      $("#datos-tabla").html(registro);
    }
  });
}

function reg_valores(){
  document.frmValor.txtIdValComp.value = '0';
  /*$("#txtIdArea").val('').trigger("change");
  $("#txtIdGrupoArea").val('').trigger("change");
  $('#txtIdGrupoArea').prop("disabled", true);
  $("#txtIdCompDet").val('').trigger("change");
  $('#txtIdCompDet').prop("disabled", true);*/
  $('#showValorModal').modal({
    show: true,
    backdrop: 'static',
    focus: true,
  });
}

function save_formVal() {
  var msg = "";
  var sw = true;

  var idSexo = $('#txtIdSexo').val();
  var diaMin = $('#txtDiaMin').val();
  var mesMin = $('#txtMesMin').val();
  var anioMin = $('#txtAnioMin').val();
  var diaMax = $('#txtDiaMax').val();
  var mesMax = $('#txtMesMax').val();
  var anioMax = $('#txtAnioMax').val();
  var limInf = $('#txtLimInf').val();
  var limSup = $('#txtLimSup').val();
  var descrip = $('#txtDescrip').val();

  /*if(diaMin+mesMin+anioMin == diaMax+mesMax+anioMax){
    msg+= "Los valores minimos y maximos no pueden ser iguales.<br/>";
    sw = false;
  }*/

  if(idSexo == ""){
    msg+= "Seleccione Sexo<br/>";
    sw = false;
  }
  if(diaMin == ""){
    msg+= "Ingrese el dia de la edad mínima<br/>";
    sw = false;
  }
  if(mesMin == ""){
    msg+= "Ingrese el mes de la edad mínima<br/>";
    sw = false;
  }
  if(anioMin == ""){
    msg+= "Ingrese el año de la edad mínima<br/>";
    sw = false;
  }
  if(diaMax == ""){
    msg+= "Ingrese el dia de la edad máxima<br/>";
    sw = false;
  }
  if(mesMax == ""){
    msg+= "Ingrese el mes de la edad máxima<br/>";
    sw = false;
  }
  if(anioMax == ""){
    msg+= "Ingrese el año de la edad máxima<br/>";
    sw = false;
  }
  if(limInf == ""){
    msg+= "Ingrese el limite inferior<br/>";
    sw = false;
  }
  if(limSup == ""){
    msg+= "Ingrese el limite superior<br/>";
    sw = false;
  }

  if (sw == false) {
    bootbox.alert(msg);
    $('#btnValidFormVal').prop("disabled", false);
    return false;
  }

  bootbox.confirm({
    message: "Se registrará el valor referencial seleccionado, ¿Está seguro de continuar?",
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
        var myRand = parseInt(Math.random() * 999999999999999);
        var form_data = new FormData();
        form_data.append('accion', 'POST_ADD_REGCOMPVALREFERENCIAL');
        form_data.append('txtTipIng', 'C');

        form_data.append('id_comp_metodo', document.frmValor.txt_id_comp_metodo.value);
        form_data.append('txtIdValComp', $("#txtIdValComp").val());
        form_data.append('txtIdSexo', $("#txtIdSexo").val());
        form_data.append('txtDiaMin', $("#txtDiaMin").val());
        form_data.append('txtMesMin', $("#txtMesMin").val());
        form_data.append('txtAnioMin', $("#txtAnioMin").val());
        form_data.append('txtDiaMax', $("#txtDiaMax").val());
        form_data.append('txtMesMax', $("#txtMesMax").val());
        form_data.append('txtAnioMax', $("#txtAnioMax").val());
        form_data.append('txtLimInf', $("#txtLimInf").val());
        form_data.append('txtLimSup', $("#txtLimSup").val());
        form_data.append('txtDescrip', $("#txtDescrip").val());

        form_data.append('rand', myRand);
        $.ajax( {
          url: '../../controller/ctrlComponente.php',
          dataType: 'text', // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'POST',
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $("#showValorModal").modal('hide');
              //$("#tblAtencion").dataTable().fnDraw();
              carga_valores_metodo(document.frmValor.txtIdComp.value);
			  carga_valores(document.frmValor.txt_id_comp_metodo.value);
			  showMessage("Registro ingresado correctamente.", "success");
            } else {
              showMessage(msg, "error");
              return false;
            }
            $('#btnValidFormVal').prop("disabled", false);
          }
        });
      } else {
        $('#btnValidFormVal').prop("disabled", false);
      }
    }
  });
}

function habilita_tipo_ingreso(){
	var id_tipo_ingreso = $('#txtIngSoluComp').val();
	if(id_tipo_ingreso == "1"){
		$('input[name=optTipoCaracResult]').prop("disabled",false);
		$('#txtIngSeleccion').prop("disabled", true);
		$('#txtIngSeleccion').val('');
		$('#txtDetCaracResul').prop("disabled", false);
		$('#btnOpenSeleccion').prop("disabled", true);
		$("#show-seleccion-resul").html('');
	} else if(id_tipo_ingreso == "2"){
		$('input[name=optTipoCaracResult]').prop("disabled",true);
		$('#txtIngSeleccion').prop("disabled", true);
		$('#txtIngSeleccion').val('');
		$('#txtDetCaracResul').prop("disabled", true);
		$('#btnOpenSeleccion').prop("disabled", true);
		$("#show-seleccion-resul").html('');
		$('.optTipoCarac').prop('checked', false);
	} else {
		$('input[name=optTipoCaracResult]').prop("disabled",true);
		$('#txtIngSeleccion').prop("disabled", false);
		$('#txtIngSeleccion').val('');
		$('#txtDetCaracResul').prop("disabled", true);
		$('#btnOpenSeleccion').prop("disabled", false);
		$('.optTipoCarac').prop('checked', false);
	}
}

function edit_registro(idcomp) {
  $('input[name=optTipoCaracResult]').prop("disabled",true);
  $('input[name=optTipoCaracResult]').prop('checked', false);
  $('#txtIngSeleccion').prop("disabled", true);
  $('#btnOpenSeleccion').prop("disabled", true);
  $("#show-seleccion-resul").html('');
  $.ajax({
    url: "../../controller/ctrlComponente.php",
    type: "POST",
    dataType: 'json',
    data: {
      accion: 'GET_SHOW_DETCOMPONENTE', idComp: idcomp
    },
    success: function (registro) {
      var datos = eval(registro);
      $('#show-new').show();
      $('#titleAcc').text('Editar Componente');
      document.frmComp.txtIdComp.value = datos[0];
      document.frmComp.txtNomComp.value =  datos[1];
      var idUniMed = 0;
      if (datos[2] != ""){idUniMed = datos[2]};
      $("#txtIdUnidMed").val(idUniMed).trigger("change");
      document.frmComp.txtValRefComp.value =  datos[4];
      document.frmComp.txtIngSoluComp.value = datos[5];
      document.frmComp.txtDetCaracResul.value = datos[9];
	  document.frmComp.txtIngSeleccion.value = datos[10];
	  if(datos[5] == "1"){
		  $('input[name=optTipoCaracResult]').prop("disabled",false);
		  $("#optTipoCaracResult"+datos[7]).prop('checked', true);
	  }
	  if(datos[5] == "3"){
		  $('#txtIngSeleccion').prop("disabled", false);
		  $('#btnOpenSeleccion').prop("disabled", false);
		  show_seleccion_resul(datos[5]);
	  }
      document.frmComp.txtNomComp.focus();
    }
  });
}

function nuevo_registro(){
  $('#show-new').hide();
  $('#titleAcc').text('Nuevo Componente');
  document.frmComp.txtIdComp.value = 0;
  document.frmComp.txtNomComp.value = '';
  $("#txtIdUnidMed").val('').trigger("change");
  document.frmComp.txtValRefComp.value = '';
  document.frmComp.txtIngSoluComp.value = '';
  $('.optTipoCarac').prop('checked', false);
  document.frmComp.txtDetCaracResul.value = '';
  document.frmComp.txtIngSeleccion.value = '';
  document.frmComp.txtNomComp.focus();
  $('#txtIngSeleccion').prop("disabled", true);
  $('#btnOpenSeleccion').prop("disabled", true);
  $("#show-seleccion-resul").html('');
}

function cambio_estado_valorref(idcompvalref,estado) {
	bootbox.confirm({
	  message: "Se cambiará el estado, ¿Está seguro de continuar?",
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
		  var myRand = parseInt(Math.random() * 999999999999999);
		  var form_data = new FormData();
		  form_data.append('accion', 'POST_ADD_REGCOMPVALREFERENCIAL');
		  form_data.append('txtTipIng', 'ELI');
		  form_data.append('id_valor_referencial', idcompvalref);
		  form_data.append('rand', myRand);
		  $.ajax( {
			url: '../../controller/ctrlComponente.php',
			dataType: 'text', // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
			  var tmsg = data.substring(0, 2);
			  var lmsg = data.length;
			  var msg = data.substring(3, lmsg);
			  if(tmsg == "OK"){
				carga_valores_metodo(document.frmValor.txtIdComp.value);
				carga_valores(document.frmValor.txt_id_comp_metodo.value);
				showMessage("Registro eliminado correctamente.", "success");
			  } else {
                showMessage(msg, "error");
				return false;
			  }
			}
		  });
		} else {
		  
		}
	  }
	});
}


function validForm() {
	//$('#btnValidForm').prop("disabled", true);
	var msg = "";
	var sw = true;

	var nomComp = $('#txtNomComp').val();
	var idUnidMed = $('#txtIdUnidMed').val();
	var ingSoluComp = $('#txtIngSoluComp').val();
	var idtipoingresolactu = $('#txtIngSoluComp').val();


	if(nomComp == ""){msg+= "Ingrese nombre del Componente<br/>"; sw = false;}
	if(idUnidMed == ""){msg+= "Seleccione Unidad de Medida<br/>"; sw = false;}
	if(ingSoluComp == ""){msg+= "Seleccione Casilla Ingreso Resultado<br/>";sw = false;}
	if(idtipoingresolactu != "3"){
		if(idtipoingresolactu == "1"){
			if ($('.optTipoCarac').is(':checked')) { } else {
				msg+= "Seleccione un Tipo de ingreso caracter resultado<br/>"; sw = false;
			}
		}
	} else {
		if($('#txtIngSeleccion').val() == ""){msg+= "Seleccione Tipo selección resultado<br/>";sw = false;}
	}

	if (sw == false) {
		bootbox.alert(msg);
		$('#btnValidForm').prop("disabled", false);
		return sw;
	} else {
		save_form();
	}
	return false;
}

function save_form() {
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
        var myRand = parseInt(Math.random() * 999999999999999);
        var form_data = new FormData();
        form_data.append('accion', 'POST_ADD_REGCOMPONENTE');
        form_data.append('txtIdComp', document.frmComp.txtIdComp.value);
        form_data.append('txtNomComp', document.frmComp.txtNomComp.value);
        form_data.append('txtIdUnidMed', $("#txtIdUnidMed").val());
        form_data.append('txtValRefComp', document.frmComp.txtValRefComp.value);
        form_data.append('txtIngSoluComp', document.frmComp.txtIngSoluComp.value);
        form_data.append('optTipoCaracResult', document.frmComp.optTipoCaracResult.value);
        form_data.append('txtDetCaracResul', document.frmComp.txtDetCaracResul.value);
		form_data.append('txtIngSeleccion', document.frmComp.txtIngSeleccion.value);
        form_data.append('rand', myRand);
        $.ajax( {
          url: '../../controller/ctrlComponente.php',
          dataType: 'text', // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'POST',
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $("#tblAtencion").dataTable().fnDraw();
              if($("#").val() == "0"){
				showMessage("Componente ingresado correctamente", "success");
              } else {
				showMessage("Componente actualizado correctamente", "success");
              }
              nuevo_registro();
            } else {
              bootbox.alert(msg);
              return false;
            }
            $('#btnValidForm').prop("disabled", false);
          }
        });
      } else {
        $('#btnValidForm').prop("disabled", false);
      }
    }
  });
}

function back() {
  window.location = '../pages/';
}
$(function() {

	$('[name="optTipoCaracResult"]').change(function(){
		if($(this).val() == "4"){
			$('#txtDetCaracResul').prop("disabled", false);
			$("#txtDetCaracResul").val('');
		} else {
			$('#txtDetCaracResul').prop("disabled", true);
			$("#txtDetCaracResul").val('');
		}
	});
	
});

$(document).ready(function () {
  $("#txtIdUnidMed").select2();
  
  $("#fixTableMetodo").tableHeadFixer();
  
  var dTable = $('#tblAtencion').DataTable({
  "bLengthChange": true, //Paginado 10,20,50 o 100
  "bProcessing": true,
  "bServerSide": true,
  "bJQueryUI": false,
  "responsive": true,
  "bInfo": true,
  "bFilter": true,
  "sAjaxSource": "tbl_principalcomp.php", // Load Data
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
    aoData.push({"name": "idEstado", "value": $("#txtBusIdEstado").val()});

  },
  /*"fnServerParams": function ( aoData ) {
  aoData.push( { "name": "id_tabla", "value": $('#cboiddep').val() } );
},*/

"columnDefs": [
  {"orderable": true, "targets": 0, "searchable": true, "class": "small"},
  {"orderable": true, "targets": 1, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 2, "searchable": false, "class": "small"},
  {"orderable": true, "targets": 3, "searchable": false, "class": "small"},
  {"orderable": true, "targets": 4, "searchable": false, "class": "small"},
  {"orderable": false, "targets": 5, "searchable": false, "class": "small"},
  {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
  {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"}
]
});

$('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');
});
</script>
<?php require_once '../include/masterfooter.php'; ?>
