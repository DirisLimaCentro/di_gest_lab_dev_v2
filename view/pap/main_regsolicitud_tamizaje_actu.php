<div class="col-sm-4">
	<div class="panel panel-info" style="margin-bottom: 5px;">
	  <div class="panel-heading">
		<h3 class="panel-title"><strong>Condición de la paciente</strong></h3>
	  </div>
	  <div class="panel-body" style="padding-bottom: 5px; padding-top: 5px;">
	  <div class="row">
	  <div class="col-sm-6">
		<div class="form-group">
		  <label for="txtIdCondiDepen">En el EESS</label>
		  <select class="form-control" name="txtIdCondiDepen" id="txtIdCondiDepen" onkeydown="campoSiguiente('txtIdCondiServ', event);" disabled>
			<option value="">-- Seleccione --</option>
			<option value="1">NUEVO</option>
			<option value="2">CONTINUADOR</option>
			<option value="3">REINGRESO</option>
		  </select>
		</div>
		</div>
		<div class="col-sm-6">
		<div class="form-group">
		  <label for="txtIdCondiServ">En el Servicio</label>
		  <select class="form-control" name="txtIdCondiServ" id="txtIdCondiServ" onkeydown="campoSiguiente('txtIRS', event);" disabled>
			<option value="">-- Seleccione --</option>
			<option value="1">NUEVO</option>
			<option value="2">CONTINUADOR</option>
			<option value="3">REINGRESO</option>
		  </select>
		</div>
		</div>
		</div>
	 </div>
	</div>
	<div class="panel panel-info" style="margin-bottom: 5px;">
	  <div class="panel-heading">
		<h3 class="panel-title"><strong>Antecedentes Gineco – Obstétricos</strong></h3>
	  </div>
	  <div class="panel-body" style="padding-bottom: 5px; padding-top: 5px;">
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-4">
			  <label for="txtIRS" class="control-label">Edad IRS:</label>
			  <input type="text" class="form-control" name="txtIRS" id="txtIRS" onfocus="this.select()" maxlength="2" value="" onkeydown="campoSiguiente('txtFUR', event);" disabled/>
			</div>
			<div class="col-sm-8">
			  <label for="txtFechaFUR" class="control-label">FUR:</label>
			  <div class="input-group input-group">
				<div class="input-group-addon">
				  <label class="checkbox-inline" style="margin-left:0px !important; padding-left:0px !important;">
					<input type="radio" class="check_fur" name="txtFUR" id="txtFUR1" value="1" disabled> Si
				  </label>
				  <label class="checkbox-inline" style="margin-left:0px !important">
					<input type="radio" class="check_fur" name="txtFUR" id="txtFUR2" value="0" disabled> No
				  </label>
				</div>
				<input type="text" name="txtFechaFUR" id="txtFechaFUR" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtIdGestante', event);" disabled/>
			  </div>
			</div>
		  </div>
		</div>

		<div class="form-group">
		  <div class="row">
			<div class="col-sm-2">
			  <label for="txtGest" class="control-label">GEST:</label>
			  <input type="text" class="form-control" name="txtGest" id="txtGest" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA1', event);" disabled/>
			</div>
			<div class="col-sm-10">
			  <div class="row">
				<div class="col-sm-12">
				  <div class="row">
					<label for="txtPARA1" class="col-sm-3 control-label">PARA:</label>
				  </div>
				</div>
				<div class="col-sm-12">
				  <div class="row">
					<div class="col-sm-3">
					  <input type="text" class="form-control" name="txtPARA1" id="txtPARA1" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA2', event);" disabled/>
					</div>
					<div class="col-sm-3">
					  <input type="text" class="form-control" name="txtPARA2" id="txtPARA2" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA3', event);" disabled/>
					</div>
					<div class="col-sm-3">
					  <input type="text" class="form-control" name="txtPARA3" id="txtPARA3" onfocus="this.select()" maxlength="2" value="0" onkeydown="campoSiguiente('txtPARA4', event);" disabled/>
					</div>
					<div class="col-sm-3">
					  <input type="text" class="form-control" name="txtPARA4" id="txtPARA4" onfocus="this.select()" maxlength="2" value="0" disabled/>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-8">
			  <label for="txtFechaFUR" class="control-label">Gestante/FPP:</label>
			  <div class="input-group input-group">
				<div class="input-group-addon">
				  <label class="checkbox-inline" style="margin-left:0px !important; padding-left:0px !important;">
					<input type="radio" class="check_gestante" name="txtIdGestante" id="txtIdGestante1" value="1" disabled> Si
				  </label>
				  <label class="checkbox-inline" style="margin-left:0px !important">
					<input type="radio" class="check_gestante" name="txtIdGestante" id="txtIdGestante2" value="0" disabled> No
				  </label>
				</div>
				<input type="text" name="txtFechaParto" id="txtFechaParto" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
			  </div>
			</div>
		  </div>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="col-sm-8">
	<div class="panel panel-info">
	  <div class="panel-heading">
		<h3 class="panel-title"><strong>Evaluación antropométrica</strong></h3>
	  </div>
	  <div class="panel-body" style="padding-bottom: 5px; padding-top: 5px;">
		<div class="form-group">
		  <div class="row">
			<div class="col-md-6">
			  <label for="txtPesoPac">PESO (<span class="text-danger"><b>Kg</b></span>):</label>
				<input type="text" name="txtPesoPac" id="txtPesoPac" onfocus="this.select()" class="form-control" maxlength="6" value="" onkeydown="campoSiguiente('txtTallaPac', event);" disabled/>
			</div>
			<div class="col-md-6">
			  <label for="txtTallaPac">Talla (<span class="text-danger"><b>Mts</b></span>):</label>
				<input type="text" name="txtTallaPac" id="txtTallaPac" onfocus="this.select()" class="form-control" maxlength="4" value="" onkeydown="campoSiguiente('txtPAPac', event);" disabled/>
			</div>
			<div class="col-sm-6">
			  <label for="txtIMCPac">IMC:</label>
				<input type="text" name="txtIMCPac" id="txtIMCPac" onfocus="this.select()" class="form-control" maxlength="5" value="" onkeydown="campoSiguiente('txtPAPac', event);" disabled/>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	</div>
	<div class="col-sm-4">
	<div class="panel panel-info">
	  <div class="panel-heading">
		<h3 class="panel-title"><strong>Presión arterial</strong></h3>
	  </div>
	  <div class="panel-body" style="padding-bottom: 5px; padding-top: 5px;">
		<div class="form-group">
			  <label for="txtPAPac">(mmHg):</label>
			  <input type="text" name="txtPAPac" id="txtPAPac" onfocus="this.select()" class="form-control" maxlength="7" value="" onkeydown="campoSiguiente('txtPAPANte', event);" disabled/>
		  </div>
		  </div>
		  </div>
		  </div>
		  </div>
	  
	<div id="div_btn_atencion" style="display: none;">
		<button type='button' class='btn btn-info btn-block' onclick='open_pdfatenciones()'><i class='glyphicon glyphicon-eye-open'></i> Ver atenciones anteriores</button>
	</div>
</div>
