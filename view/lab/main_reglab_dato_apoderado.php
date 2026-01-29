<div class="form-group">
  <div class="row">
	<div class="col-sm-7">
	  <div class="row">
		<div class="col-md-12">
		  <label for="txtIdTipDocSoli">Documento de identidad</label>
		</div>
	  </div>
	  <div class="row">
		<div class="col-xs-4" style="padding-right: 0!important;">
		  <?php $rsT = $t->get_listaTipoDocPerNatuConDocAdulto(); ?>
		  <select class="form-control input-sm" name="txtIdTipDocSoli" id="txtIdTipDocSoli" onchange="maxlength_doc_bus_soli()" disabled>
			<?php
			foreach ($rsT as $row) {
			  echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . ": " . $row['descripcion'] . "</option>";
			}
			?>
		  </select>
		</div>
		<div class="col-xs-8" style="padding-left: 0!important;">
		  <div class="input-group input-group-sm">
			<input type="text" name="txtNroDocSoli" id="txtNroDocSoli" class="form-control input-sm" maxlength="8" onkeydown="campoSiguiente('btnSoliSearch', event);" onblur="limpia_datos_personalsoli()" value="<?php if(isset($rsA[0]['nrodoc_soli'])) echo $rsA[0]['nrodoc_soli'];?>" disabled/>
			<div class="input-group-btn">
			  <button class="btn btn-success" type="button" id="btnSoliSearch" onclick="buscar_datos_personalessoli()" disabled><i class="fa fa-search"></i></button>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="form-group col-sm-5">
	  <label for="txtIdPaisNacSoli">País de nacimiento</label>
	  <select class="form-control" style="width: 100%" name="txtIdPaisNacSoli" id="txtIdPaisNacSoli" onkeydown="campoSiguiente('txtIdSexoSoli', event);" disabled>
		<option value="">-- Seleccione --</option>
		<?php
		$rsPP = $ub->get_listaPais();
		foreach ($rsPP as $rowPP) {
		  echo "<option value='" . $rowPP['id_pais'] . "'>" . $rowPP['nom_pais'] . "</option>";
		}
		?>
	  </select>
	</div>
  </div>
</div>
<div class="form-group">
  <div class="row">
	<div class="col-sm-6 col-md-3">
	  <label for="txtIdSexoSoli">Sexo</label>
	  <select class="form-control input-sm" name="txtIdSexoSoli" id="txtIdSexoSoli" onkeydown="campoSiguiente('txtFecNacSoli', event);" disabled>
		<option value="">Seleccione</option>
		<option value="1">M</option>
		<option value="2">F</option>
	  </select>
	</div>
	<div class="col-sm-6 col-md-4">
	  <label for="txtFecNacSoli">Fecha Nac.</label>
	  <div class="input-group input-group-sm">
		<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
		<input type="text" name="txtFecNacSoli" id="txtFecNacSoli" placeholder="DD/MM/AAAA" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtPriApeSoli', event);" disabled/>
	  </div>
	</div>
	<div class="col-sm-6 col-md-5">
	  <label for="txtFecNacSoli">Parentesco</label>
	  <?php $rsTP = $t->get_listaParentesco(); ?>
	  <select class="form-control input-sm" name="txtIdParenSoli" id="txtIdParenSoli" style="width: 100%" disabled>
		<option value="">Seleccione</option>
		<?php
		foreach ($rsTP as $row) {
		  echo "<option value='" . $row['id_parentesco'] . "'>" . $row['nom_parentesco'] . "</option>";
		}
		?>
	  </select>
	</div>
  </div>
</div>
<div class="form-group">
  <div class="row">
	<div class="col-sm-6">
	  <label for="txtPriApeSoli">Apellido paterno</label>
	  <input type="text" name="txtPriApeSoli" id="txtPriApeSoli" class="form-control input-sm" maxlength="75" onkeydown="campoSiguiente('txtSegApeSoli', event);" readonly/>
	</div>
	<div class="col-sm-6">
	  <label for="txtSegApeSoli">Apellido materno</label>
	  <input type="text" name="txtSegApeSoli" id="txtSegApeSoli" class="form-control input-sm" maxlength="75" onkeydown="campoSiguiente('txtNroTelFijoSoli', event);" readonly/>
	</div>
  </div>
</div>
<div class="form-group">
  <label for="txtNomSoli">Nombre(s)</label>
  <input type="text" name="txtNomSoli" class="form-control input-sm" id="txtNomSoli" maxlength="180" onkeydown="campoSiguiente('txtNroTelFijoSoli', event);" readonly/>
</div>
<div class="form-group">
  <div class="row">
	<div class="col-sm-6">
	  <label for="txtNroTelFijoSoli">Telf. Fijo</label>
	  <div class="input-group input-group-sm">
		<div class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></div>
		<input type="text" name="txtNroTelFijoSoli" placeholder="999999999" id="txtNroTelFijoSoli" class="form-control input-sm" maxlength="9" value="" onkeydown="campoSiguiente('txtNroTelMovilSoli', event);" disabled/>
	  </div>
	</div>
	<div class="col-sm-6">
	  <label for="txtNroTelMovilSoli">Telf. Móvil</label>
	  <div class="input-group input-group-sm">
		<div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
		<input type="text" name="txtNroTelMovilSoli" placeholder="999999999" id="txtNroTelMovilSoli" class="form-control input-sm" maxlength="9" value="" onkeydown="campoSiguiente('txtEmailSoli', event);" disabled/>
	  </div>
	</div>
  </div>
</div>
<div class="form-group">
  <label for="txtEmailSoli">Email</label>
  <div class="input-group input-group-sm">
	<div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
	<input type="text" name="txtEmailSoli" placeholder="@example.com" id="txtEmailSoli" class="form-control input-sm" maxlength="50" value="" onkeydown="campoSiguiente('txtIdPlanTari', event);" disabled/>
  </div>
</div>
<hr style="margin-bottom: 4px;"/>
<span class="help-block">Si va a ingresar al apoderado, los <span class="text-danger">datos obligatorios</span> son: Documento de identidad, país de nacimiento, sexo, fecha de nacimiento, parentesco con el paciente, nombre(s) y el apellido paterno.</span></span>