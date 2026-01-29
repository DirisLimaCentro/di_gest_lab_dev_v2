<div id="div_datos_menor" style="display: none;">
	<div class="panel panel-success">
	  <div class="panel-heading">
		<h3 class="panel-title"><strong>DATOS DE FILIACIÓN DEL MENOR 1</strong></h3>
	  </div>
	  <div class="panel-body">
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-12">
			  <div class="row">
				<div class="col-md-12">
				  <label for="txtIdTipDocNi">Doc. de identidad:</label>
				</div>
			  </div>
			  <div class="row">
				<div class="col-sm-4" style="padding-right: 0!important;">
				  <?php $rsT = $t->get_listaTipoDocPerNatuSinDocAndConDocMenor(); ?>
				  <select class="form-control" name="txtIdTipDocNi" id="txtIdTipDocNi" onchange="maxlength_doc_bus_ni()" disabled>
					<?php
					foreach ($rsT as $row) {
					  echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . ": " . $row['descripcion'] . "</option>";
					}
					?>
				  </select>
				</div>
				<div class="col-sm-8" style="padding-left: 0!important;">
				  <div class="input-group input-group">
					<input type="text" name="txtNroDocNi" id="txtNroDocNi" placeholder="Número de documento" onfocus="this.select()" autocomplete="OFF" class="form-control" maxlength="8" onkeydown="campoSiguiente('btnNiSearch', event);" disabled/>
					<div class="input-group-btn">
					  <button class="btn btn-info" type="button" id="btnNiSearch" onclick="buscar_datos_personales_ni('')" disabled><i class="fa fa-search"></i></button>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-12 col-md-6">
			  <label for="txtPriApeNi">Apellido paterno</label>
			  <input type="text" name="txtPriApeNi" class="form-control text-uppercase" id="txtPriApeNi" maxlength="75" onkeydown="campoSiguiente('txtSegApeNi', event);" readonly/>
			</div>
			<div class="col-sm-12 col-md-6">
			  <label for="txtSegApeNi">Apellido materno</label>
			  <input type="text" name="txtSegApeNi" class="form-control text-uppercase" id="txtSegApeNi" maxlength="75" onkeydown="campoSiguiente('txtNomNi', event);" readonly/>
			</div>
		  </div>
		</div>
		<div class="form-group">
		  <label for="txtNomNi">Nombre(s)</label>
		  <input type="text" name="txtNomNi" class="form-control text-uppercase" id="txtNomNi" maxlength="180" onkeydown="campoSiguiente('txtFecNacNi', event);" readonly/>
		</div>
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-7">
			  <label for="txtFecNacNi">Fecha Nac.</label>
			  <div class="input-group input-group">
				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				<input type="text" name="txtFecNacNi" id="txtFecNacNi" placeholder="DD/MM/AAAA" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtIdPaisNacNi', event);" disabled/>
			  </div>
			</div>
			<div class="col-sm-5">
			  <label for="txtIdSexoNi">Sexo</label>
			  <select class="form-control" name="txtIdSexoNi" id="txtIdSexoNi" onkeydown="campoSiguiente('txtFecNacNi', event);" disabled>
				<option value="">-- Seleccione  --</option>
				<option value="1">M</option>
				<option value="2">F</option>
			  </select>
			</div>
			</div>
			</div>
			<div class="form-group">
			  <label for="txtIdDepNacNi">Lugar de nacimiento (IPRESS)</label>
				<select class="form-control" style="width: 100%" name="txtIdDepNacNi" id="txtIdDepNacNi" onkeydown="campoSiguiente('txtIdEtniaNi', event);" disabled>
				  <option value="">-- Seleccione --</option>
				  <option value="1">CM.I. EL PORVENIR</option>
				  <option value="2">C.M.I. SURQUILLO</option>
				  <option value="3">C.M.I. MAGDALENA</option>
				  <option value="4">HOSPITAL NACIONAL ARZOBISPO LOAYZA</option>
				  <option value="5">HOSPITAL DOCENTE MADRE NIÑO SAN BARTOLOMÉ</option>
				  <option value="6">HOSPITAL NACIONAL DOS DE MAYO</option>
				  <option value="7">HOSPITAL SANTA ROSA</option>
				  <option value="8">HOSPITAL SAN JUAN DE LURIGANCHO</option>
				  <option value="9">INSTITUTO NACIONAL MATERNO PERINATAL</option>
				  <option value="10">DOMICILIO</option>
				</select>
			</div>
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-7">
				<label for="txtNroHCNi"> Financiador: </label>
				<select class="form-control" name="txtIdTipPacPartiNi" id="txtIdTipPacPartiNi" onkeydown="campoSiguiente('txtNroHCNi', event);" disabled>
					<?php $rsTF = $t->get_listaFinanciador(); ?>
					<option value=""> -- Seleccione --</option>
					<?php
					foreach ($rsTF as $row) {
					  echo "<option value='" . $row['id'] . "'>" . $row['nom_financiador'] . "</option>";
					}
					?>
				</select>
			</div>
			<div class="col-sm-5">
			  <label for="txtNroHCNi"> Nro. H.C.: </label>
			  <input type="text" name="txtNroHCNi" id="txtNroHCNi" class="form-control text-uppercase" maxlength="10" onkeydown="campoSiguiente('txtPriApeNi', event);" disabled>
			</div>
		  </div>
		</div>
		<div class="form-group">
		  <div class="row">

			<div class="col-sm-4">
			  <label for="txtPesoNi">Peso al nacer</label>
			  <input type="text" class="form-control" name="txtPesoNi" id="txtPesoNi" value="" disabled/>
			</div>
			<div class="col-sm-4">
			  <label for="txtEGNi">EG al nacer</label>
			  <select name="txtEGNi" id="txtEGNi" class="form-control" style="width: 100%" disabled>
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
			<div class="col-sm-4">
			  <label for="txtAPGARNi">APGAR</label>
			  <input type="text" class="form-control" name="txtAPGARNi" id="txtAPGARNi" value="" disabled/>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</div>