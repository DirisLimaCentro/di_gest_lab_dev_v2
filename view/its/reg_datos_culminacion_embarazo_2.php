<div class="row">
	<div class="col-sm-12">
	<div class="panel panel-warning">
	  <div class="panel-heading">
		<h3 class="panel-title"><strong>ESTADO DEL MENOR 2</strong></h3>
	  </div>
	  <div class="panel-body" style="padding-top: 11px !important;">
		<div class="form-group">
			<label class="radio-inline"><input type="radio" class="opt_tipoCulmiEmbarazoNino2" name="txt_tipoCulmiEmbarazoNino2" id="txt_tipoCulmiEmbarazoNino21" value="1"/><b>Parto</b></label>
			<label class="radio-inline"><input type="radio" class="opt_tipoCulmiEmbarazoNino2" name="txt_tipoCulmiEmbarazoNino2" id="txt_tipoCulmiEmbarazoNino22" value="2"/><b>Mortinato u Óbito Fetal</b></label>
		</div>
	<div style="display:none;" id="div_culminaembarazo_parto2">
		<div class="form-group">
			<select name="txt_culmi_embarazoparto2" id="txt_culmi_embarazoparto2" class="form-control" onchange="enabled_datos_menor('2')">
				<option value="">SELECCIONE</option>
				<option value="1">Vivo</option>
				<option value="2">Nació vivo y falleció</option>
				<!--<option value="3">Aborto </option>
				<option value="4">Mortinato u Óbito Fetal</option>-->
			</select>
		</div>
		<div class="form-group">
			<label for="opt_tiparto" class="control-label"><b>Tipo de parto:</b></label> 
			<label class="radio-inline"><input type="radio" class="opt_tiparto2" name="opt_tiparto2" id="opt_tiparto21" value="1"/>Vaginal</label>
			<label class="radio-inline"><input type="radio" class="opt_tiparto2" name="opt_tiparto2" id="opt_tiparto22" value="2"/>Cesárea</label>
		</div>
		<div style="display:none;" id="div_culminaembarazo_parto_cesarea2">
			<div class="form-group">
			  <div class="row">
				<div class="col-md-4">
					<label for="txt_fecnacfallecido2" class="control-label">Fecha Nacimiento:</label>
					<input type="text" name="txt_fecnacfallecido2" id="txt_fecnacfallecido2" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txt_pesonacfallecido2', event);"/>
				</div>
				<div class="col-md-4">
					<label for="txt_pesonacfallecido2" class="control-label">Peso al nacer:</label>
					<input type="text" name="txt_pesonacfallecido2" id="txt_pesonacfallecido2" class="form-control" maxlength="5" value="" onkeydown="campoSiguiente('txt_fecfallefellecido2', event);"/>
				</div>
				<div class="col-md-4">
					<label for="txt_fecfallefellecido2" class="control-label">Fecha Fallecimiento:</label>
					<input type="text" name="txt_fecfallefellecido2" id="txt_fecfallefellecido2" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
				</div>
			  </div>
			</div>
		</div>
	</div>
	<div style="display:none;" id="div_culminaembarazo_otro2">
		<div class="form-group">
		  <div class="row">
			<div class="col-md-4">
				<label for="txtFechaOtro2" class="control-label">Fecha:</label>
				<input type="text" name="txtFechaOtro2" id="txtFechaOtro2" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);"/>
				<label class="checkbox-inline"><input type="checkbox" class="chk_fecotro2" name="chk_fecotro2" id="chk_fecotro2" value="1"/>Desconocido</label>
			</div>
			<div class="col-md-4">
				<label for="txt_pesootro2" class="control-label">Peso:</label>
				<input type="text" name="txt_pesootro2" id="txt_pesootro2" class="form-control" maxlength="5" value=""/>
				<label class="checkbox-inline"><input type="checkbox" class="chk_pesootro2" name="chk_pesootro2" id="chk_pesootro2" value="1"/>Desconocido</label>
			</div>
		  </div>
		</div>
	</div>
	  </div>
	</div>
	</div>
</div>