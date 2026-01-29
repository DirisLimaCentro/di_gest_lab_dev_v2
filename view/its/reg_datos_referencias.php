<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title"><strong>REFERENCIAS</strong></h3>
  </div>
  <div class="panel-body">
	<div class="row">
	  <div class="col-sm-6 col-md-2">
		<label for="txtfechaRef">Fecha</label>
		<input type="text" name="txtfechaRef" id="txtfechaRef" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
	  </div>
	  <div class="col-sm-6 col-md-2">
		<label for="txtNroRef"># Referencia</label>
		<input type="text" name="txtNroRef" class="form-control input-sm" id="txtNroRef" maxlength="6" onkeydown="campoSiguiente('txtIdSexoSoli', event);" disabled/>
	  </div>
	  <div class="col-sm-12 col-md-3">
		<label for="txtIdDepRef">lugar de referencia</label>
		<div class="input-group">
		  <select class="form-control" style="width: 100%" name="txtIdDepRef" id="txtIdDepRef" onkeydown="campoSiguiente('txtIdEtniaNi', event);" disabled>
			<option value="">-- Seleccione --</option>
			<?php
			$rsD = $d->get_listaDepenInstitucion();
			foreach ($rsD as $row) {
			  echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
			}
			?>
		  </select>
		  <div class="input-group-btn">
			<button id="btnAddDepRef" class="btn btn-success" type="submit" disabled><i class="glyphicon glyphicon-plus"></i></button>
		  </div>
		</div>
	  </div>
	  <div class="col-sm-9  col-md-3">
		<label for="txtDetDiagRef">Diagnóstico</label>
		<input type="text" name="txtDetDiagRef" class="form-control input-sm" id="txtDetDiagRef" maxlength="180" onkeydown="campoSiguiente('txtIdSexoSoli', event);" disabled/>
	  </div>
	  <div class="col-sm-3 col-md-2">
		<br/>
		<button type="button" id="btnAddReferencia" class="btn btn-primary btn-block" onclick="add_referencia()" disabled>Agregar</button>
	  </div>
	</div>
	<br/>
	<div class="table-responsive">
	  <table class="table table-bordered">
		<thead>
		  <tr class="active">
			<th>Fecha</th>
			<th># Referencia EESS</th>
			<th>Lugar</th>
			<th>Diagnóstico</th>
			<th></th>
		  </tr>
		</thead>
		<tbody id="det-referencia">
		  <tr>
			<td colspan="5"><small>No se encontraron referencias</small></td>
		  </tr>
		</tbody>
	  </table>
	</div>
  </div>
</div>