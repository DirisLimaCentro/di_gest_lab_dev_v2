<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title"><strong>Momento del Diagnóstico</strong></h3>
  </div>
  <div class="panel-body" style="padding-bottom: 0px; padding-top: 5px;">
	<div class="form-group">
	  <div class="radio" style="margin-top: 0px !important;">
		<label>
		  <input type="radio" name="txtDiagnostico" id="txtDiagnostico1" class="opt_diagnostico" value="1" disabled/>
		  <b>DX Previo</b>
		</label>
	  </div>
	  <div class="row">
		<div class="col-md-6">
			<label for="txt_aniodx" class="control-label">Año diagnósticado:</label>
		</div>
		<div class="col-md-6" style="padding-left: 5px;">
			<input type="text" name="txt_aniodx" id="txt_aniodx" onfocus="this.select()" class="form-control text-uppercase" maxlength="4" value="" disabled/>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-6">
			<label for="txtDetIPRESDiag" class="control-label">Recibió tratamiento:</label>    
		</div>
		<div class="col-md-6" style="padding-left: 5px;">
			<label class="radio-inline"><input type="radio" name="txt_tratamientodx" id="txt_tratamientodx1" class="opt_tratamientodx" value="0" disabled/>No</label>
			<label class="radio-inline"><input type="radio" name="txt_tratamientodx" id="txt_tratamientodx0" class="opt_tratamientodx" value="1" disabled/>Si</label>
		</div>
	  </div>
	  <div class="radio">
		<label>
		  <input type="radio" name="txtDiagnostico" id="txtDiagnostico2" class="opt_diagnostico" value="2" disabled> <b>APN</b>
		</label>
	  </div>
	  <div class="row">
		<div class="col-md-6">
			<label for="txtEGAPNDiag" class="control-label">Anotar en semanas:</label>
		</div>
		<div class="col-md-6">
			<select name="txtEGAPNDiag" id="txtEGAPNDiag" class="form-control" disabled>
			  <option value="0"></option>
			  <?php
			  for ($i = 1; $i <= 42; $i++) {
				?>
				<option value="<?php echo $i?>"><?php echo $i?></option>
				<?php
			  }
			  ?>
			</select>
		</div>
	  </div>
	  <div class="radio">
		<label>
		  <input type="radio" name="txtDiagnostico" id="txtDiagnostico3" class="opt_diagnostico" value="3" disabled/>
		  <b>Trabajo de parto</b>
		</label>
	  </div>
	  <div class="radio">
		<label>
		  <input type="radio" name="txtDiagnostico" id="txtDiagnostico4" class="opt_diagnostico" value="4" disabled/>
		  <b>Puerperio</b>
		</label>
	  </div>
	</div>
  </div>
</div>
