	<div class="panel panel-info">
	  <div class="panel-heading">
		<h3 class="panel-title"><strong>DATOS DE FILIACIÓN</strong></h3>
	  </div>
	  <div class="panel-body">
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-3 col-md-3">
				<label style="font-weight: bold !important;">Financiador:</label>
				<div class="input-group">
					<span class="input-group-addon">
					  <label><input type="radio" name="txtTipPac" id="txtTipPac1" class="opt_txtTipPac" value="1"/> SIS </label> &nbsp;&nbsp;&nbsp;
					  <label><input type="radio" name="txtTipPac" id="txtTipPac2" class="opt_txtTipPac" value="0"/> NO SIS</label>
					</span>
					<select class="form-control" name="txtIdTipPacParti" id="txtIdTipPacParti" onkeydown="campoSiguiente('txtNroDocPac', event);" disabled>
						<?php $rsTF = $t->get_listaFinanciadorSinSIS(); ?>
						<option value=""> -- Seleccione --</option>
						<?php
						foreach ($rsTF as $row) {
						  echo "<option value='" . $row['id'] . "'>" . $row['nom_financiador'] . "</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="col-sm-3 col-md-3">
			<label for="txtIdTipDocPac">Doc. de identidad:</label>
			  <div class="row">
				<div class="col-sm-4" style="padding-right: 0!important;">
				  <?php $rsT = $t->get_listaTipoDocPerNatuSinDocAndConDocAdulto(); ?>
				  <select class="form-control" name="txtIdTipDocPac" id="txtIdTipDocPac" onchange="maxlength_doc_bus()" disabled>
					<?php
					foreach ($rsT as $row) {
					  echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . ": " . $row['descripcion'] . "</option>";
					}
					?>
				  </select>
				</div>
				<div class="col-sm-8" style="padding-left: 0!important;">
				  <div class="input-group input-group">
					<input type="text" name="txtNroDocPac" id="txtNroDocPac" placeholder="Número de documento" onfocus="this.select()" autocomplete="OFF" class="form-control" maxlength="8" onkeydown="campoSiguiente('btnPacSearch', event);" disabled/>
					<div class="input-group-btn">
					  <button class="btn btn-info" type="button" id="btnPacSearch" onclick="buscar_datos_personales()" disabled><i class="fa fa-search"></i></button>
					</div>
				  </div>
				</div>
			  </div>
			</div>
			<div class="col-sm-3 col-md-2">
			  <label for="txtNroHCPac"> Nro. H.C.: </label>
			  <input type="text" name="txtNroHCPac" id="txtNroHCPac" class="form-control text-uppercase" maxlength="10" onkeydown="campoSiguiente('txtPriApePac', event);" disabled>
			</div>
			<div class="col-sm-3 col-md-2">
			  <label for="txtIdPaisNacPac">País de nacimiento</label>
			  <select class="form-control" style="width: 100%" name="txtIdPaisNacPac" id="txtIdPaisNacPac" onkeydown="campoSiguiente('txtIdEtniaPac', event);" disabled>
				<option value="">-- Seleccione --</option>
				<?php
				$rsPP = $ub->get_listaPais();
				foreach ($rsPP as $rowPP) {
				  echo "<option value='" . $rowPP['id_pais'] . "'>" . $rowPP['nom_pais'] . "</option>";
				}
				?>
			  </select>
			</div>
			<div class="col-sm-3 col-md-2">
			  <label for="txtIdEtniaPac">ETNIA</label>
			  <select class="form-control" style="width: 100%" name="txtIdEtniaPac" id="txtIdEtniaPac" onkeydown="campoSiguiente('txtUBIGEOPac', event);" disabled>
				<option value="">-- Seleccione --</option>
				<?php
				$rsTE = $t->get_listaEtnia();
				foreach ($rsTE as $rowTE) {
				  echo "<option value='" . $rowTE['id_etnia'] . "'>" . $rowTE['nom_etnia'] . "</option>";
				}
				?>
			  </select>
			</div>
		  </div>
		</div>
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-4">
			  <label for="txtPriApePac">Apellido paterno</label>
			  <input type="text" name="txtPriApePac" class="form-control text-uppercase" id="txtPriApePac" maxlength="75" onkeydown="campoSiguiente('txtSegApePac', event);" readonly/>
			</div>
			<div class="col-sm-4">
			  <label for="txtSegApePac">Apellido materno</label>
			  <input type="text" name="txtSegApePac" class="form-control text-uppercase" id="txtSegApePac" maxlength="75" onkeydown="campoSiguiente('txtNomPac', event);" readonly/>
			</div>
			<div class="col-sm-4">
		  <label for="txtNomPac">Nombre(s)</label>
		  <input type="text" name="txtNomPac" class="form-control text-uppercase" id="txtNomPac" maxlength="180" onkeydown="campoSiguiente('txtFecNacPac', event);" readonly/>
			</div>
		  </div>
		</div>
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-2">
			  <label for="txtIdSexoPac">Sexo</label>
			  <select class="form-control" name="txtIdSexoPac" id="txtIdSexoPac" onkeydown="campoSiguiente('txtFecNacPac', event);" disabled>
				<option value="2">F</option>
			  </select>
			</div>
			<div class="col-sm-2">
			  <label for="txtFecNacPac">Fecha Nac.</label>
			  <div class="input-group input-group">
				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				<input type="text" name="txtFecNacPac" id="txtFecNacPac" placeholder="DD/MM/AAAA" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtIdPaisNacPac', event);" disabled/>
			  </div>
			</div>
			<div class="col-sm-2">
			  <label for="txtEdadPac">Edad</label>
			  <input type="text" class="form-control" name="txtEdadPac" id="txtEdadPac" disabled/>
			</div>
			<div class="col-sm-3">
			  <label for="txtIdDepPac">UBIGEO (Departamento)</label>
			  <?php $rsUb = $ub->get_listaUbigeoDepartamentosPeru(); ?>
			  <select class="form-control" style="width: 100%" name="txtIdDepPac" id="txtIdDepPac" onchange="get_listaProvinciaAndDistrito('', '')" disabled>
				<option value="">-- Seleccione --</option>
				<?php
				foreach ($rsUb as $rowUb) {
				  echo "<option value='" . $rowUb['id_ubigeo'] . "'";
				  if($rowUb['id_ubigeo'] == "14") echo " selected";
				  echo ">" . $rowUb['departamento'] . "</option>";
				}
				?>
			  </select>
			</div>
			<div class="col-sm-3">
				<label for="txtUBIGEOPac">UBIGEO (Provincia - Distrito)</label>
				<?php $rsUb = $ub->get_listaUbigeoLimaPeru(); ?>
				<select class="form-control" style="width: 100%" name="txtUBIGEOPac" id="txtUBIGEOPac" disabled>
					<option value="">-- Seleccione --</option>
					<?php
					foreach ($rsUb as $rowUb) {
					  echo "<option value='" . $rowUb['id_ubigeo'] . "'>" . $rowUb['provincia'] . " - " . $rowUb['distrito'] . "</option>";
					}
					?>
				</select>
			</div>
		  </div>
		</div>
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-3">
				<label for="txtDirPac">Dirección:</label>
				<input type="text" name="txtDirPac" id="txtDirPac" onfocus="this.select()" class="form-control text-uppercase" maxlength="185" value="" onkeydown="campoSiguiente('txtDirRefPac', event);" readonly/>
			</div>
			<div class="col-sm-3">
				<label for="txtDirRefPac">Referencia:</label>
				<input type="text" name="txtDirRefPac" id="txtDirRefPac" onfocus="this.select()" class="form-control text-uppercase" maxlength="185" value="" onkeydown="campoSiguiente('txtNroTelFijoPac', event);" readonly/>
			</div>
			<div class="col-sm-2">
				<label for="txtNroTelFijoPac">Telf. Fijo</label>
				<input type="text" name="txtNroTelFijoPac" placeholder="999999999" id="txtNroTelFijoPac" onfocus="this.select()" class="form-control" maxlength="9" value="" onkeydown="campoSiguiente('txtNroTelMovilPac', event);" disabled/>
			</div>
			<div class="col-sm-2">
			<label for="txtNroTelMovilPac">Telf. Móvil</label>
			<input type="text" name="txtNroTelMovilPac" placeholder="999999999" id="txtNroTelMovilPac" onfocus="this.select()" class="form-control" maxlength="9" value="" onkeydown="campoSiguiente('txtEmailPac', event);" disabled/>
			</div>
			<div class="col-sm-2">
			<label for="txtEmailPac">Email</label>
			<input type="text" name="txtEmailPac" placeholder="@example.com" id="txtEmailPac" onfocus="this.select()" class="form-control" maxlength="50" value="" disabled/>
			</div>
		  </div>
		</div>
	  </div>
	</div>