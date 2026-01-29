<div class="row">
	<!--<div class="col-sm-7">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>OBSERVACIONES DE LA MADRE</strong></h3>
			</div>
			<div class="panel-body" style="padding-top: 5px !important; padding-bottom: 5px !important;">
				<div class="form-group">
				  <textarea name="txtObsMadre" id="txtObsMadre" class="form-control" rows="4" disabled></textarea>
				</div>
			</div>
		</div>
	</div>-->
	<div class="col-sm-12">
	<div class="panel panel-info">
	  <div class="panel-heading">
		<h3 class="panel-title"><strong>CULMINACIÓN DEL EMBARAZO</strong></h3>
	  </div>
	  <div class="panel-body" style="padding-top: 11px !important;">
		<div class="form-group">
			<label class="radio-inline"><input type="radio" class="opt_tipoCulmiEmbarazo" name="txt_tipoCulmiEmbarazo" id="txt_tipoCulmiEmbarazo1" value="1" disabled/><b>PARTO</b></label>
			<label class="radio-inline"><input type="radio" class="opt_tipoCulmiEmbarazo" name="txt_tipoCulmiEmbarazo" id="txt_tipoCulmiEmbarazo2" value="2" disabled/><b>OTROS</b></label>
		</div>
	  
	<div style="display:none;" id="div_culminaembarazo_parto">
		<div class="form-group">
			<select name="txt_culmi_embarazoparto" id="txt_culmi_embarazoparto" class="form-control" onchange="enabled_datos_menor()">
				<option value="">SELECCIONE</option>
				<option value="1">Vivo</option>
				<option value="2">Nació vivo y falleció</option>
			</select>
		</div>
		<div class="form-group">
			<label for="opt_tiparto" class="control-label"><b>Tipo de parto:</b></label> 
			<label class="radio-inline"><input type="radio" class="opt_tiparto" name="opt_tiparto" id="opt_tiparto1" value="1"/>Vaginal</label>
			<label class="radio-inline"><input type="radio" class="opt_tiparto" name="opt_tiparto" id="opt_tiparto2" value="2"/>Cesárea</label>
		</div>
		<div style="display:none;" id="div_culminaembarazo_parto_cesarea">
			<div class="form-group">
			  <div class="row">
				<div class="col-md-4">
					<label for="txtFechaDosisPac1" class="control-label">Fecha Nacimiento:</label>
					<input type="text" name="txt_fecnacfallecido" id="txt_fecnacfallecido" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txt_pesonacfallecido', event);"/>
				</div>
				<div class="col-md-4">
					<label for="txtFechaDosisPac1" class="control-label">Peso al nacer:</label>
					<input type="text" name="txt_pesonacfallecido" id="txt_pesonacfallecido" class="form-control" maxlength="5" value="" onkeydown="campoSiguiente('txt_fecfallefellecido', event);"/>
				</div>
				<div class="col-md-4">
					<label for="txtFechaDosisPac1" class="control-label">Fecha Fallecimiento:</label>
					<input type="text" name="txt_fecfallefellecido" id="txt_fecfallefellecido" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
				</div>
			  </div>
			</div>
		</div>
	</div>
	<div style="display:none;" id="div_culminaembarazo_otro">
		<div class="form-group">
			<select name="txt_culmi_embarazootro" id="txt_culmi_embarazootro" class="form-control">
				<option value="">SELECCIONE</option>
				<option value="3">Aborto </option>
				<option value="4">Mortinato u Óbito Fetal</option>
			</select>
		</div>
		<div class="form-group">
		  <div class="row">
			<div class="col-md-4">
				<label for="txtFechaOtro" class="control-label">Fecha:</label>
				<input type="text" name="txtFechaOtro" id="txtFechaOtro" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);"/>
				<label class="checkbox-inline"><input type="checkbox" class="chk_fecotro" name="chk_fecotro" id="chk_fecotro" value="1"/>Desconocido</label>
			</div>
			<div class="col-md-4">
				<label for="txt_pesootro" class="control-label">Peso:</label>
				<input type="text" name="txt_pesootro" id="txt_pesootro" class="form-control" maxlength="5" value=""/>
				<label class="checkbox-inline"><input type="checkbox" class="chk_pesootro" name="chk_pesootro" id="chk_pesootro" value="1"/>Desconocido</label>
			</div>
		  </div>
		</div>
	</div>
	  </div>
	</div>
	</div>
</div>