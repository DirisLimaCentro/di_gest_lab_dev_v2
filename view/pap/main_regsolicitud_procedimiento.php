<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title"><strong>Procedimientos realizados</strong></h3>
  </div>
  <div class="panel-body">
	<div class="row" id="diag-1">
	  <div class="col-md-2">
		<label for="txtIdDepOri">Código:</label>
	  </div>
	  <div class="col-md-3">
		<label for="txtIdDepOri">Nombre:</label>
	  </div>
	  <div class="col-md-1"></div>
	  <div class="col-md-2">
		<label for="txtIdDepOri">Código:</label>
	  </div>
	  <div class="col-md-4">
		<label for="txtIdDepOri">Nombre:</label>
	  </div>
	</div>
	<div class="row" id="diag-1">
	  <div class="col-md-2">
		<input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="88141" disabled/>
	  </div>
	  <div class="col-md-3">
		<div class="form-group">
		  <input type="text" name="txtNomDiagnostico" placeholder="Ingrese descripción" id="txtNomDiagnostico" class="form-control" maxlength="500" value="TOMA DE PAPANICOLAOU" disabled/>
		</div>
	  </div>
	  <div class="col-md-1"></div>
	  <div class="col-md-2">
		<input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="Z01.4" disabled/>
	  </div>
	  <div class="col-md-4">
		<div class="form-group">
		  <input type="text" name="txtNomDiagnostico" placeholder="Ingrese descripción" id="txtNomDiagnostico" class="form-control" maxlength="500" value="EXAMEN GINECOLÓGICO (GENERAL) (DE RUTINA)" disabled/>
		</div>
	  </div>
	</div>
	<br/>
	<div class="row">
	  <div class="col-sm-6">
	  
<div class=" panel panel-info">
<div class="panel-heading">
	<h5 class="panel-title"><strong>Diagnóstico clínico</strong></h5>
</div>
<div id="collapseDiagnosticos" data-parent="#accordion" aria-labelledby="heading1">
	<div class="panel-body">
		<div class="row">
			<div class="form-group col-md-9">
				<label for="txt_id_cie">Argegar diagnóstico</label>
				<select id="txt_id_cie" name="txt_id_cie" class="form-control" style="width: 100%" disabled>
					<?php $rsTC = $t->get_listaCie10PAP(); ?>
					<option value=""> -- Seleccione --</option>
					<?php
					foreach ($rsTC as $row) {
					  echo "<option value='" . $row['id_cie'] . "'>" . $row['id_cie'] . " - " . $row['nom_cie'] . "</option>";
					}
					?>
				</select>
			</div>
			<div class="form-group col-md-2">
				<label for="txt_stock_maximo" style="opacity: 0;display: block;">
					.... </label>
				<button type="button" id="btn_adddiag" class="btn btn-success" onclick="addItemDetalleDiagnostico(event)" disabled> <i class="fa fa-plus"></i> Agregar </button>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<div class="table-responsive w-100 text-sm">
					<table id="lista_datatables_cie10" class=" w-100 table table-bordered table-hover">
						<thead>
						<tr>
							<th><i class="fa fa-cogs"></i></th>
							<th>Cie10</th>
							<th>Descripción</th>
						</tr>
						</thead>
						<tbody id="tbl_items_diagnosticos">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
	  </div>
	  <div class="col-sm-6">
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title"><strong>Insumos</strong></h3>
		  </div>
		  <div class="panel-body">
			<div class="row" style="padding-top: 5px;" id="diag-4">
			  <div class="col-sm-3 col-md-2">
				<input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="24878" disabled/>
				<input type="hidden" name="lbl24878" id="lbl24878" value="1"/>
			  </div>
			  <div class="col-sm-9 col-md-10">
				<div class="input-group input-group">
				  <div class="input-group-btn">
					<button type="button" class="btn btn-success" id="btnDelet24878" onclick="delete_diag('24878')" disabled><i class="fa fa-remove"></i> Quitar</button>
				  </div>
				  <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="LÁMINA PORTA OBJETO" disabled/>
				</div>
			  </div>
			</div>
			<div class="row" style="padding-top: 5px;" id="diag-4">
			  <div class="col-sm-3 col-md-2">
				<input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="23904" disabled/>
				<input type="hidden" name="lbl23904" id="lbl23904" value="1"/>
			  </div>
			  <div class="col-sm-9 col-md-10">
				<div class="input-group input-group">
				  <div class="input-group-btn">
					<button type="button" class="btn btn-success" id="btnDelet23904" onclick="delete_diag('23904')" disabled><i class="fa fa-remove"></i> Quitar</button>
				  </div>
				  <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="CITOCEPILLO PARA PAPANICOLAOU" disabled/>
				</div>
			  </div>
			</div>
			<div class="row" style="padding-top: 5px;" id="diag-5">
			  <div class="col-sm-3 col-md-2">
				<input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="29448" disabled/>
				<input type="hidden" name="lbl29448" id="lbl29448" value="1"/>
			  </div>
			  <div class="col-sm-9 col-md-10">
				<div class="input-group input-group">
				  <div class="input-group-btn">
					<button type="button" class="btn btn-success" id="btnDelet29448" onclick="delete_diag('29448')" disabled><i class="fa fa-remove"></i> Quitar</button>
				  </div>
				  <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="GUANTES DESCARTABLES TALLA M" disabled/>
				</div>
			  </div>
			</div>
			<div class="row" style="padding-top: 5px;" id="diag-6">
			  <div class="col-sm-3 col-md-2">
				<input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="25122" disabled/>
				<input type="hidden" name="lbl25122" id="lbl25122" value="1"/>
			  </div>
			  <div class="col-sm-9 col-md-10">
				<div class="input-group input-group">
				  <div class="input-group-btn">
					<button type="button" class="btn btn-success" id="btnDelet25122" onclick="delete_diag('25122')" disabled><i class="fa fa-remove"></i> Quitar</button>
				  </div>
				  <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="ESPECULO VAGINAL DESCARTABLE MEDIANO" disabled/>
				</div>
			  </div>
			</div>
			<div class="row" style="padding-top: 5px;" id="diag-7">
			  <div class="col-sm-3 col-md-2">
				<input type="text" name="txtIdDiagnostico" placeholder="Ingrese descripción" id="txtIdDiagnostico" class="form-control" maxlength="18" value="25391" disabled/>
				<input type="hidden" name="lbl25391" id="lbl25391" value="1"/>
			  </div>
			  <div class="col-sm-9 col-md-10">
				<div class="input-group input-group">
				  <div class="input-group-btn">
					<button type="button" class="btn btn-success" id="btnDelet25391" onclick="delete_diag('25391')" disabled><i class="fa fa-remove"></i> Quitar</button>
				  </div>
				  <input type="text" name="txtNomDiagnostico" id="txtNomDiagnostico" class="form-control" maxlength="500" value="ESPATULA DE AYRE DE MADERA" disabled/>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
