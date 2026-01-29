<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Momento del Diagnóstico</strong></h3>
	</div>
	<div class="panel-body" style="padding-bottom: 0px; padding-top: 5px;">
		<div class="form-group">
			<div class="radio" style="margin-top: 2px;">
				<label><input type="radio" class="opt_tipomomentodiagvih" name="txt_tipomomentodiagvih" id="txt_tipomomentodiagvih1" value="1"/><b>PREVIO A LA GESTACIÓN ACTUAL</b></label>
			</div>
			<div class="radio" style="margin-top: 2px;">
				<label><input type="radio" class="opt_tipomomentodiagvih" name="txt_tipomomentodiagvih" id="txt_tipomomentodiagvih2" value="2"/><b>DURANTE LA GESTACIÓN ACTUAL</b></label>
			</div>
			<div class="row" id="div_trataadeciadono">
				<div class="col-sm-1">
				&nbsp;
				</div>
				<div class="col-sm-11">
					<div class="radio" style="margin-top: 0px;">
					  <label><input type="radio" class="opt_momentodiagvih" name="txt_momentodiagvih" id="txt_momentodiagvih1" value="1">APN</label>
					</div>
					<div class="radio">
					  <label><input type="radio" class="opt_momentodiagvih" name="txt_momentodiagvih" id="txt_momentodiagvih2" value="2">Trabajo de parto.</label>
					</div>
					<div class="radio">
					  <label><input type="radio" class="opt_momentodiagvih" name="txt_momentodiagvih" id="txt_momentodiagvih3" value="3">Puerperio</label>
					</div>
					<div class="radio">
					  <label><input type="radio" class="opt_momentodiagvih" name="txt_momentodiagvih" id="txt_momentodiagvih4" value="4">Posterior al puerperio</label>
					</div>
					<div class="radio">
					  <label><input type="radio" class="opt_momentodiagvih" name="txt_momentodiagvih" id="txt_momentodiagvih5" value="5">Por aborto</label>
					</div>
				</div>
			</div>
		</div>
  </div>
</div>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>TARV</strong></h3>
	</div>
	<div class="panel-body">
	
		<div class="radio" id="div_escenario1" style="display:none;">
		  <label><input type="radio" name="opt_escenario" id="opt_escenario1" value="1"><b>ESCENARIO I</b></label>
		</div>
		<div class="radio" id="div_escenario2" style="display:none;">
		  <label><input type="radio" name="opt_escenario" id="opt_escenario2" value="2"><b>ESCENARIO II</b></label>
		</div>
		<div class="radio" id="div_escenario3" style="display:none;">
		  <label><input type="radio" name="opt_escenario" id="opt_escenario3" value="3"><b>ESCENARIO III</b></label>
		</div>
	
		<div id="div_diag_previoges" style="display:none;">
			<div class="row">
				<div class="col-md-6">
					<label for="txt_aniodx" class="control-label">Año diagnóstico:</label>
				</div>
				<div class="col-md-6" style="padding-left: 5px;">
					<input type="text" name="txt_aniodx" id="txt_aniodx" onfocus="this.select()" class="form-control text-uppercase" maxlength="4" value="" disabled/>
				</div>
			</div>
		</div>
		<div id="div_diag_tarvsineg" style="display:none;">
			<fieldset class="scheduler-border">
				<legend class="scheduler-border" style="margin-bottom: 2px;">¿Recibió TARV?</legend>
				<div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi1" value="1" disabled/>Si</label>
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi2" value="2" disabled/>No</label>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="txt_aniodx" class="control-label">Fecha de inicio:</label>
					</div>
					<div class="col-md-6" style="padding-left: 5px;">
						<input type="text" name="txt_aniodx" id="txt_aniodx" onfocus="this.select()" class="form-control text-uppercase" maxlength="4" value="" disabled/>
					</div>
				</div>
				<div class="form-group">
					<label for="txtIdDepTargaRef" class="control-label">Lugar donde recibe TARV:</label>
					<select class="form-control" style="width: 100%" name="txtIdDepTargaRef" id="txtIdDepTargaRef" onkeydown="campoSiguiente('txtIdEtniaNi', event);" disabled>
						<option value="">-- Seleccione --</option>
						<?php
						$rsD = $d->get_listaDepenInstitucion();
						foreach ($rsD as $row) {
							echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
						}
						?>
					</select>
				</div>
			</fieldset>
		</div>
		<div id="div_diag_tarvconeg" style="display:none;">
			<fieldset class="scheduler-border">
				<legend class="scheduler-border" style="margin-bottom: 2px;">¿Recibió TARV?</legend>
				<div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi1" value="1" disabled/>Si</label>
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi2" value="2" disabled/>No</label>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="txt_aniodx" class="control-label">Fecha de inicio:</label>
							<input type="text" name="txt_aniodx" id="txt_aniodx" onfocus="this.select()" class="form-control text-uppercase" maxlength="4" value="" disabled/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="txt_aniodx" class="control-label">EG:</label>
							<select name="txtEGEmba" id="txtEGEmba" class="form-control" disabled>
							  <option value="0"></option>
							  <?php
							  for ($i = 12; $i <= 42; $i++) {
								?>
								<option value="<?php echo $i?>"><?php echo $i?></option>
								<?php
							  }
							  ?>
							</select>
							<span class="help-block">(Anotar EG en semana)</span>
						</div>							
					</div>
				</div>
				<div class="form-group">
					<label for="txtIdDepTargaRef" class="control-label">Lugar donde recibe TARV:</label>
					<select class="form-control" style="width: 100%" name="txtIdDepTargaRef" id="txtIdDepTargaRef" onkeydown="campoSiguiente('txtIdEtniaNi', event);" disabled>
						<option value="">-- Seleccione --</option>
						<?php
						$rsD = $d->get_listaDepenInstitucion();
						foreach ($rsD as $row) {
							echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
						}
						?>
					</select>
				</div>
			</fieldset>
		</div>
		<div id="div_diag_tarvconegconev" style="display:none;">
			<fieldset class="scheduler-border">
				<legend class="scheduler-border" style="margin-bottom: 2px;">¿Recibió TARV?</legend>
				<div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi1" value="1" disabled/>Si</label>
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi2" value="2" disabled/>No</label>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="txt_aniodx" class="control-label">Fecha de inicio:</label>
							<input type="text" name="txt_aniodx" id="txt_aniodx" onfocus="this.select()" class="form-control text-uppercase" maxlength="4" value="" disabled/>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="txt_aniodx" class="control-label">EG:</label>
							<select name="txtEGEmba" id="txtEGEmba" class="form-control" disabled>
							  <option value="0"></option>
							  <?php
							  for ($i = 12; $i <= 42; $i++) {
								?>
								<option value="<?php echo $i?>"><?php echo $i?></option>
								<?php
							  }
							  ?>
							</select>
							<span class="help-block">(Anotar EG en semana)</span>
						</div>							
					</div>
				</div>
				<div class="form-group">
					<label for="txtIdDepTargaRef" class="control-label">Lugar donde recibe TARV:</label>
					<select class="form-control" style="width: 100%" name="txtIdDepTargaRef" id="txtIdDepTargaRef" onkeydown="campoSiguiente('txtIdEtniaNi', event);" disabled>
						<option value="">-- Seleccione --</option>
						<?php
						$rsD = $d->get_listaDepenInstitucion();
						foreach ($rsD as $row) {
							echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
						}
						?>
					</select>
				</div>
			</fieldset>

			<fieldset class="scheduler-border">
				<legend class="scheduler-border" style="margin-bottom: 2px;">¿Zidovudina EV?</legend>
				<div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi1" value="1" disabled/>Si</label>
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi2" value="2" disabled/>No</label>
				</div>
			</fieldset>
		</div>
		<div id="div_diag_abandonotarv" style="display:none;">
			<fieldset class="scheduler-border">
				<legend class="scheduler-border" style="margin-bottom: 2px;">¿Abandonó TARV?</legend>
				<div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi1" value="1" disabled/>Si</label>
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi2" value="2" disabled/>No</label>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="txt_aniodx" class="control-label">Fecha:</label>
					</div>
					<div class="col-md-6" style="padding-left: 5px;">
						<input type="text" name="txt_aniodx" id="txt_aniodx" onfocus="this.select()" class="form-control text-uppercase" maxlength="4" value="" disabled/>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</div>
