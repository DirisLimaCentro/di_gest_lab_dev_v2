<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>DATOS DE LA PRIMERA ATENCIÓN</strong></h3>
	</div>
	<div class="panel-body" style="padding-bottom: 10px;">
		<div class="form-group">
		  <label class="radio-inline"><input type="radio" class="opt_estadopac" name="txtEstadoPac" id="txtEstadoPac1" value="1" disabled/><b>GESTANTE</b></label>
		  <label class="radio-inline"><input type="radio" class="opt_estadopac" name="txtEstadoPac" id="txtEstadoPac0" value="0" disabled/><b>PUÉRPERA</b></label>
		</div>
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-2">
				<label for="txt_fur">FUR:</label>
				<input type="text" name="txt_fur" id="txt_fur" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txt_fpp', event);" disabled/>
				<label class="checkbox-inline"><input type="checkbox" class="chk_fur" name="chk_fur" id="chk_fur" value="1" disabled/>Desconocido</label>
			</div>
			<div id="datos-gestante" style="display: none;">
				<div class="col-sm-2">
					<label for="txt_fpp">FPP</label>
					<input type="text" name="txt_fpp" id="txt_fpp" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtFechaCPN', event);" disabled/>
				</div>
			</div>
			<div class="col-sm-2">
				<label for="txtFechaCPN" class="control-label">Fecha de 1° CPN:</label>
				<input type="text" name="txtFechaCPN" id="txtFechaCPN" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtEGCPN', event);" disabled/>
				<label class="checkbox-inline"><input type="checkbox" class="chk_fechacpn" name="chk_fechacpn" id="chk_fechacpn" value="1" disabled/>Sin CPN</label>
			  </div>
			  <div class="col-sm-2">
				<label for="txtEGCPN" class="control-label">Edad Gestacional:</label>
				<select name="txtEGCPN" id="txtEGCPN" class="form-control" style="width: 100%" disabled>
				  <option value="0"></option>
				  <?php
				  for ($i = 1; $i <= 42; $i++) {
					?>
					<option value="<?php echo $i?>"><?php echo $i?></option>
					<?php
				  }
				  ?>
				</select>
				<span class="help-block">Seleccionar semana</span>
			  </div>
			  <div class="col-sm-2">
			  <label for="txtIPRESDiag" class="control-label">Diagnosticada en:</label>
				<select name="txtIPRESDiag" id="txtIPRESDiag" class="form-control" disabled>
					<option value="1">MINSA</option>
					<option value="2">ESSALUD</option>
					<option value="3">FAP</option>
					<option value="4">MILITAR</option>
					<option value="5">PNP</option>
					<option value="6">PRIVADOS</option>
				</select>
			  </div>
			  <div class="col-sm-2">
					<label for="txtDetIPRESDiag" class="control-label">IPRESS:</label>
					<input type="text" name="" id="txtDetIPRESDiag" class="form-control" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtGest', event);" disabled/>
			  </div>
		  </div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-12 text-right">
					<label style="font-weight: bold !important;">GESTACIÓN MULTIPLE: </label>
					<label class="radio-inline">
						<input type="radio" class="opt_gestmultiple" name="txt_gestmultiple" id="txt_gestmultiple1" value="1"> Si
					</label>
					<label class="radio-inline">
						<input type="radio" class="opt_gestmultiple" name="txt_gestmultiple" id="txt_gestmultiple0" value="0"> No
					</label>
				  </div>
			  </div>
		  </div>
		</div>
	</div>
        
