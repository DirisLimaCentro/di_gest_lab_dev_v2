<div class="row">
	<div class="col-sm-12">
	<div class="panel panel-primary">
	  <div class="panel-heading">
		<h3 class="panel-title"><strong>ESTADO DEL MENOR 3</strong></h3>
	  </div>
	  <div class="panel-body" style="padding-top: 11px !important;">
		<div class="form-group">
			<label class="radio-inline"><input type="radio" class="opt_tipoCulmiEmbarazoNino3" name="txt_tipoCulmiEmbarazoNino3" id="txt_tipoCulmiEmbarazoNino31" value="1"/><b>Parto</b></label>
			<label class="radio-inline"><input type="radio" class="opt_tipoCulmiEmbarazoNino3" name="txt_tipoCulmiEmbarazoNino3" id="txt_tipoCulmiEmbarazoNino32" value="2"/><b>Mortinato u Óbito Fetal</b></label>
		</div>
	<div style="display:none;" id="div_culminaembarazo_parto3">
		<div class="form-group">
			<select name="txt_culmi_embarazoparto3" id="txt_culmi_embarazoparto3" class="form-control" onchange="enabled_datos_menor('3')">
				<option value="">SELECCIONE</option>
				<option value="1">Vivo</option>
				<option value="2">Nació vivo y falleció</option>
				<!--<option value="3">Aborto </option>
				<option value="4">Mortinato u Óbito Fetal</option>-->
			</select>
		</div>
		<div class="form-group">
			<label for="opt_tiparto" class="control-label"><b>Tipo de parto:</b></label> 
			<label class="radio-inline"><input type="radio" class="opt_tiparto3" name="opt_tiparto3" id="opt_tiparto31" value="1"/>Vaginal</label>
			<label class="radio-inline"><input type="radio" class="opt_tiparto3" name="opt_tiparto3" id="opt_tiparto32" value="2"/>Cesárea</label>
		</div>
		<div style="display:none;" id="div_culminaembarazo_parto_cesarea3">
			<div class="form-group">
			  <div class="row">
				<div class="col-md-4">
					<label for="txt_fecnacfallecido3" class="control-label">Fecha Nacimiento:</label>
					<input type="text" name="txt_fecnacfallecido3" id="txt_fecnacfallecido3" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txt_pesonacfallecido3', event);"/>
				</div>
				<div class="col-md-4">
					<label for="txt_pesonacfallecido3" class="control-label">Peso al nacer:</label>
					<input type="text" name="txt_pesonacfallecido3" id="txt_pesonacfallecido3" class="form-control" maxlength="5" value="" onkeydown="campoSiguiente('txt_fecfallefellecido', event);"/>
				</div>
				<div class="col-md-4">
					<label for="txt_fecfallefellecido3" class="control-label">Fecha Fallecimiento:</label>
					<input type="text" name="txt_fecfallefellecido3" id="txt_fecfallefellecido3" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
				</div>
			  </div>
			</div>
		</div>
	</div>
	<div style="display:none;" id="div_culminaembarazo_otro3">
		<div class="form-group">
		  <div class="row">
			<div class="col-md-4">
				<label for="txtFechaOtro3" class="control-label">Fecha:</label>
				<input type="text" name="txtFechaOtro3" id="txtFechaOtro3" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txt_pesootro3', event);"/>
				<label class="checkbox-inline"><input type="checkbox" class="chk_fecotro3" name="chk_fecotro3" id="chk_fecotro3" value="1"/>Desconocido</label>
			</div>
			<div class="col-md-4">
				<label for="txt_pesootro3" class="control-label">Peso:</label>
				<input type="text" name="txt_pesootro3" id="txt_pesootro3" class="form-control" maxlength="5" value=""/>
				<label class="checkbox-inline"><input type="checkbox" class="chk_pesootro3" name="chk_pesootro3" id="chk_pesootro3" value="1"/>Desconocido</label>
			</div>
		  </div>
		</div>
	</div>
	  </div>
	</div>
	</div>
</div>