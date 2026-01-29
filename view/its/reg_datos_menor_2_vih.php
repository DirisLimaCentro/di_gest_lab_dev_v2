<div class="row">
	<div class="col-sm-5">
		<?php require 'reg_datos_culminacion_embarazo_2.php'?>
		<?php include "reg_datos_menor_2.php"; ?>
		<div class="panel panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>OBSERVACIONES DEL NIÑO</strong></h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<textarea name="txtObsNino2" id="txtObsNino2" class="form-control" rows="3" disabled></textarea>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-7">
	<div id="div_laboratorio_menor2" style="display: none;">
		<div class="panel panel-warning">
		  <div class="panel-heading">
			<h3 class="panel-title"><strong>Manejo del niño expuesto al VIH</strong></h3>
		  </div>
		  <div class="panel-body">
			<fieldset class="scheduler-border">
			  <legend class="scheduler-border" style="margin-bottom: 2px;">Profilaxis ARV</legend>
			  <div class="form-group">
				<label class="radio-inline"><input type="radio" class="opt_profilaxis" name="txtProfilaxis" id="txtProfilaxis1" value="1"/>Recibio</label>
				<label class="radio-inline"><input type="radio" class="opt_profilaxis" name="txtProfilaxis" id="txtProfilaxis0" value="0"/>No recibio</label>
			  </div>
			  <div class="row">
				<div class="col-sm-4">
				  <div class="form-group">
					<label for="txtEGPCR1">Fecha inicio TARV</label>
					<input type="text" name="txt_fur" id="txt_fur" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txt_fpp', event);" disabled/>
				  </div>
				</div>
				<div class="col-sm-5">
				  <label for="txtResulPCR1">¿Abandonó TARV?</label><br/>
				  <div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulpcr1" name="txtResulPCR1" id="txtResulPCR11" value="1" disabled/>Si</label>
					<label class="radio-inline"><input type="radio" class="opt_resulpcr1" name="txtResulPCR1" id="txtResulPCR12" value="2" disabled/>No</label>
				  </div>
				</div>
			  </div>
			</fieldset>
			<fieldset class="scheduler-border">
			  <legend class="scheduler-border" style="margin-bottom: 2px;">ARV</legend>
				<div class="row">
					<div class="col-sm-4">
						<label for=""><b>ARV Recibido:</b></label>
						<div class="radio" style="margin-top: 0px;">
						  <label><input type="radio" name="opt_notrataadecuado" id="opt_notrataadecuado1" value="1">AZT</label>
						</div>
						<div class="radio">
						  <label><input type="radio" name="opt_notrataadecuado" id="opt_notrataadecuado2" value="2">AZT + NVP + 3TC</label>
						</div>
						<div class="radio">
						  <label><input type="radio" name="opt_notrataadecuado" id="opt_notrataadecuado3" value="3">OTRO</label>
						</div>
					</div>
					<div class="col-sm-3">
						<label for=""><b>N° de días que tomó ARV:</b></label>
						<input type="text" name="txtNroDLS1" id="txtNroDLS1" class="form-control" maxlength="4" value="" onkeydown="campoSiguiente('txtFechaDLS1', event);" disabled/>
					</div>
					<div class="col-sm-3">
						<label for=""><b>Profilaxis ARV de acuerdo a NT vigente:</b></label>
						<div class="form-group">
							<label class="radio-inline"><input type="radio" class="opt_resulpcr1" name="txtResulPCR1" id="txtResulPCR11" value="1" disabled/>Si</label>
							<label class="radio-inline"><input type="radio" class="opt_resulpcr1" name="txtResulPCR1" id="txtResulPCR12" value="2" disabled/>No</label>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset class="scheduler-border">
			  <legend class="scheduler-border" style="margin-bottom: 2px;">Lactancia materna</legend>
			  <div class="form-group">
				<label class="radio-inline"><input type="radio" class="opt_lactancia" name="txtLactancia" id="txtLactancia1" value="1" disabled/>Recibio</label>
				<label class="radio-inline"><input type="radio" class="opt_lactancia" name="txtLactancia" id="txtLactancia0" value="0" disabled/>No recibio</label>
			  </div>
			</fieldset>
		  </div>
		</div>
		<div class="panel panel-warning">
		  <div class="panel-heading">
			<h3 class="panel-title"><strong>Pruebas Diagnósticas Del Niño Expuesto</strong></h3>
		  </div>
		  <div class="panel-body">
			<fieldset class="scheduler-border">
			  <legend class="scheduler-border" style="margin-bottom: 2px;">Niños menores de 18 meses de edad</legend>
			  <label><b>Primer PCR:</b></label>
			  <div class="row">
				<div class="col-sm-5">
				  <div class="form-group">
					<label for="txtEGPCR1">Edad en meses del niño</label>
					<select name="txtEGPCR1" id="txtEGPCR1" class="form-control" disabled>
					  <option value="0"></option>
					  <?php
					  for ($i = 1; $i <= 17; $i++) {
						?>
						<option value="<?php echo $i?>"><?php echo $i?></option>
						<?php
					  }
					  ?>
					</select>
				  </div>
				</div>
				<div class="col-sm-7">
				  <label for="txtResulPCR1">Resultado</label><br/>
				  <div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulpcr1" name="txtResulPCR1" id="txtResulPCR11" value="1" disabled/>Positivo</label>
					<label class="radio-inline"><input type="radio" class="opt_resulpcr1" name="txtResulPCR1" id="txtResulPCR12" value="2" disabled/>Negativo</label>
					<label class="radio-inline"><input type="radio" class="opt_resulpcr1" name="txtResulPCR1" id="txtResulPCR13" value="3" disabled/>Indeterminada</label>
				  </div>
				</div>
			  </div>
			  <label><b>Segundo PCR:</b></label>
			  <div class="row">
				<div class="col-sm-5">
				  <div class="form-group">
					<label for="txtEGPCR2">Edad en meses del niño</label>
					<select name="txtEGPCR2" id="txtEGPCR2" class="form-control" disabled>
					  <option value="0"></option>
					  <?php
					  for ($i = 1; $i <= 17; $i++) {
						?>
						<option value="<?php echo $i?>"><?php echo $i?></option>
						<?php
					  }
					  ?>
					</select>
				  </div>
				</div>
				<div class="col-sm-7">
				  <label for="txtResulPCR1">Resultado</label><br/>
				  <div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulpcr2" name="txtResulPCR1" id="txtResulPCR11" value="1" disabled/>Positivo</label>
					<label class="radio-inline"><input type="radio" class="opt_resulpcr2" name="txtResulPCR1" id="txtResulPCR12" value="2" disabled/>Negativo</label>
					<label class="radio-inline"><input type="radio" class="opt_resulpcr2" name="txtResulPCR1" id="txtResulPCR13" value="3" disabled/>Indeterminada</label>
				  </div>
				</div>
			  </div>
			  <label><b>Tercer PCR:</b></label>
			  <div class="row">
				<div class="col-sm-5">
				  <div class="form-group">
					<label for="txtEGPCR3">Edad en meses del niño</label>
					<select name="txtEGPCR3" id="txtEGPCR3" class="form-control" disabled>
					  <option value="0"></option>
					  <?php
					  for ($i = 1; $i <= 17; $i++) {
						?>
						<option value="<?php echo $i?>"><?php echo $i?></option>
						<?php
					  }
					  ?>
					</select>
				  </div>
				</div>
				<div class="col-sm-7">
				  <label for="txtResulPCR3">Resultado</label><br/>
				  <div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulpcr3" name="txtResulPCR3" id="txtResulPCR31" value="1" disabled/>Positivo</label>
					<label class="radio-inline"><input type="radio" class="opt_resulpcr3" name="txtResulPCR3" id="txtResulPCR32" value="2" disabled/>Negativo</label>
				  </div>
				</div>
			  </div>
			</fieldset>
			<fieldset class="scheduler-border">
			  <legend class="scheduler-border" style="margin-bottom: 2px;">Niños mayores de 18 meses de edad</legend>
			  <label><b>Prueba de Elisa:</b></label>
			  <div class="row">
				<div class="col-sm-5">
				  <div class="form-group">
					<label for="txtEGElisaNi">Edad en meses del niño</label>
					<select name="txtEGElisaNi" id="txtEGElisaNi" class="form-control" disabled>
					  <option value="0"></option>
					  <?php
					  for ($i = 18; $i <= 36; $i++) {
						?>
						<option value="<?php echo $i?>"><?php echo $i?></option>
						<?php
					  }
					  ?>
					</select>
				  </div>
				</div>
				<div class="col-sm-7">
				  <label for="txtEdadPac">Resultado</label><br/>
				  <div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulelisani" name="txtResulElisaNi" id="txtResulElisaNi1" value="1" disabled/>Reactivo</label>
					<label class="radio-inline"><input type="radio" class="opt_resulelisani" name="txtResulElisaNi" id="txtResulElisaNi0" value="0" disabled/>No reactivo</label>
				  </div>
				</div>
			  </div>
			  <label><b>Prueba confirmatoria:</b></label>
			  <div class="row">
				<div class="col-sm-5">
				  <div class="form-group">
					<label for="txtFechaIFINi">Fecha</label>
					<input type="text" name="txtFechaIFINi" id="txtFechaIFINi" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
				  </div>
				</div>
				<div class="col-sm-7">
				  <label for="txtEdadPac">Resultado</label><br/>
				  <div class="form-group">
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi1" value="1" disabled/>Positivo</label>
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi2" value="2" disabled/>Negativo</label>
					<label class="radio-inline"><input type="radio" class="opt_resulifini" name="txtResulIFINi" id="txtResulIFINi3" value="3" disabled/>Indeterminada</label>
				  </div>
				</div>
			  </div>
			</fieldset>
		  </div>
		</div>
		<div class="panel panel-warning">
		  <div class="panel-heading">
			<h3 class="panel-title"><strong>Estado Serológico final del niño expuesto</strong></h3>
		  </div>
		  <div class="panel-body">
			  <div class="form-group">
				<label class="radio-inline"><input type="radio" class="opt_estadofinalni" name="txtEstadoFinalNi" id="txtEstadoFinalNi1" value="1" disabled/><b>Estado serológico final</b></label>
				<label class="radio-inline"><input type="radio" class="opt_estadofinalni" name="txtEstadoFinalNi" id="txtEstadoFinalNi2" value="2" disabled/><b>Estado indeterminado</b></label>
			  </div>
			  <div class="form-group">
					<div class="radio" style="margin-top: 0px;">
					  <label><input type="radio" name="opt_notrataadecuado" id="opt_notrataadecuado1" value="1">Infectado por VIH</label>
					</div>
					<div class="radio">
					  <label><input type="radio" name="opt_notrataadecuado" id="opt_notrataadecuado2" value="2">No Infectado por VIH</label>
					</div>
					<div class="radio">
					  <label><input type="radio" name="opt_notrataadecuado" id="opt_notrataadecuado3" value="3">Estado indeterminado</label>
					</div>
					<div class="radio">
					  <label><input type="radio" name="opt_notrataadecuado" id="opt_notrataadecuado3" value="3">Continua con el seguimiento</label>
					</div>
					<div class="radio">
					  <label><input type="radio" name="opt_notrataadecuado" id="opt_notrataadecuado3" value="3">Fallecido antes de poder determinar su estado serológico</label>
					</div>
					<div class="radio">
					  <label><input type="radio" name="opt_notrataadecuado" id="opt_notrataadecuado3" value="3">Abandonó el seguimiento / seguimiento irregular</label>
					</div>
					<div class="radio">
					  <label><input type="radio" name="opt_notrataadecuado" id="opt_notrataadecuado3" value="3">Referido</label>
					</div>
			  </div>
		  </div>
		</div>
		</div>
	  </div>
</div>