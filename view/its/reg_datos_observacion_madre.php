<div class="row">
	<div class="col-sm-7">
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
	</div>
	<div class="col-sm-5">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>CULMINACIÓN DEL EMBARAZO</strong></h3>
			</div>
			<div class="panel-body" style="padding-top: 11px !important;">
					<div class="radio"style="padding-top: 1px; margin-top: 1px;">
						<label><input type="radio" class="opt_tipoCulmiEmbarazo" name="txt_tipoCulmiEmbarazo" id="txt_tipoCulmiEmbarazo1" value="1"/><b>VIVO Y/O MORTINADO U ÓBITO FETAL</b></label>
					</div>
					<div class="radio">
						<label><input type="radio" class="opt_tipoCulmiEmbarazo" name="txt_tipoCulmiEmbarazo" id="txt_tipoCulmiEmbarazo2" value="2"/><b>ABORTO</b></label>
					</div>
					<div style="display:none;" id="div_aborto">
						<div class="form-group">
						  <div class="row">
							<div class="col-md-4">
								<label for="txt_fecaborto" class="control-label">Fecha:</label>
								<input type="text" name="txt_fecaborto" id="txt_fecaborto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);"/>
								<label class="checkbox-inline"><input type="checkbox" class="chk_fecaborto" name="chk_fecaborto" id="chk_fecaborto" value="1"/>Desconocido</label>
							</div>
							<div class="col-md-4">
								<label for="txt_pesoaborto" class="control-label">Peso:</label>
								<input type="text" name="txt_pesoaborto" id="txt_pesoaborto" class="form-control" maxlength="5" value=""/>
								<label class="checkbox-inline"><input type="checkbox" class="chk_pesoaborto" name="chk_pesoaborto" id="chk_pesoaborto" value="1"/>Desconocido</label>
							</div>
						  </div>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>