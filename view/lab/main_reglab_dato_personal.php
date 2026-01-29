<input type="hidden" id="txt_id_ubigeo_temp" value=""/>
<input type="hidden" id="txt_direccion_temp" value=""/>
<div class="form-group">
  <div class="row">
	<div class="col-sm-8">
	  <div class="row">
		<div class="col-sm-12">
		  <label for="txtIdTipDocPac">Doc. de identidad <span class="text-danger">(*)</span>:</label>
		</div>
	  </div>
	  <div class="row">
		<div class="col-xs-4" style="padding-right: 0!important;">
		  <?php $rsT = $t->get_ListaTipoDocPerNatu();?>
		  <select class="form-control input-lg" name="txtIdTipDocPac" id="txtIdTipDocPac" onchange="maxlength_doc_bus()">
			<?php
			foreach ($rsT as $row) {
			  echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . ": ".$row['descripcion']."</option>";
			}
			?>
		  </select>
		</div>
		<div class="col-xs-8" style="padding-left: 0!important;">
		  <div class="input-group input-group-lg">
			<input type="text" name="txtNroDocPac" id="txtNroDocPac" onfocus="this.select()" autocomplete="OFF" class="form-control input-lg" maxlength="8" onkeydown="campoSiguiente('btnPacSearch', event);" value="<?php if(isset($rsA[0]['nro_docpac'])) echo $rsA[0]['nro_docpac'];?>"/>
			<div class="input-group-btn">
				<?php if(isset($rsA[0])){ ?>
					<button class="btn btn-info" type="button" id="btnPacSearch" onclick="buscar_datos_personales('editlaboratorio')"><i class="fa fa-search"></i></button>
				<?php } else { ?>
					<button class="btn btn-info" type="button" id="btnPacSearch" onclick="buscar_datos_personales('reglaboratorio')"><i class="fa fa-search"></i></button>				
				<?php }?>
			</div>
		  </div>
		</div>
	  </div>
	</div>
		<div class="col-sm-4">
	  <label for="txtNroHCPac"><small>Nro. H.C. <span class="text-danger">(*)</span>:</small></label>
	  <input type="text" name="txtNroHCPac" class="form-control input-lg" id="txtNroHCPac" maxlength="10" onkeydown="campoSiguiente('txtPriApePac', event);" disabled/>
	</div>
  </div>
</div>
<div class="form-group">
  <div class="row">
	<div class="col-sm-6">
	  <label for="txtPriApePac">Apellido paterno <span class="text-danger">(*)</span>:</label>
	  <input type="text" name="txtPriApePac" class="form-control input-lg" id="txtPriApePac" maxlength="75" onkeydown="campoSiguiente('txtSegApePac', event);" readonly/>
	</div>
	<div class="col-sm-6">
	  <label for="txtSegApePac">Apellido materno:</label>
	  <input type="text" name="txtSegApePac" class="form-control input-lg" id="txtSegApePac" maxlength="75" onkeydown="campoSiguiente('txtNomPac', event);"/>
	</div>
  </div>
</div>
<div class="form-group">
  <label for="txtNomPac">Nombre(s) <span class="text-danger">(*)</span>:</label>
  <input type="text" name="txtNomPac" class="form-control input-lg" id="txtNomPac" maxlength="180" onkeydown="campoSiguiente('txtIdSexoPac', event);" readonly/>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-sm-3 col-md-4">
			<label for="txtIdSexoPac"><small>Sexo <span class="text-danger">(*)</span>:</small></label>
			  <select class="form-control input-lg" name="txtIdSexoPac" id="txtIdSexoPac" onkeydown="campoSiguiente('txtFecNacPac', event);" disabled>
				<option value="">Seleccione</option>
				<option value="1">M</option>
				<option value="2">F</option>
			</select>
		</div>
		<div class="col-sm-5 col-md-5">
			<!--<label for="txtFecNacPac"><small>Fecha Nac. <span class="text-danger">(*)</span>:</small></label>
			<input type="text" name="txtFecNacPac" id="txtFecNacPac" placeholder="DD/MM/AAAA" autofocus="" class="form-control input-lg" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtEdadPac', event);" disabled/>-->
			
			<!--<label for="txtFecNacPac">Fecha Nac. <span class="text-danger">(*)</span>:</label>
			<div class="input-group input-group-lg">
				<div class="input-group-addon" for="txtFecNacPac"><i class="fa fa-calendar" id="datepicker" for="txtFecNacPac"></i></div>
				<input type="text" name="txtFecNacPac" id="txtFecNacPac" placeholder="DD/MM/AAAA" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtEdadPac', event);" disabled/>
			</div>-->
			
            <label for="txtFecNacPac"><i class="fa fa-calendar" id="datepicker"></i> Fecha Nac.:</label>
			<input type="text" name="txtFecNacPac" id="txtFecNacPac" placeholder="DD/MM/AAAA" autofocus="" class="form-control input-lg" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d" onkeydown="campoSiguiente('txtEdadPac', event);" disabled/>
			
			
		</div>
		<div class="col-sm-4 col-md-3">
		  <label for="txtEdadPac">Edad <span class="text-danger">(*)</span>:</label>
		  <input type="text" class="form-control input-lg" name="txtEdadPac" id="txtEdadPac" onkeydown="campoSiguiente('txtIdPaisNacPac', event);" <?php if($labIdDepUser <> "67"){ echo " readonly";}?>/>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group col-sm-12">
	  <label for="txtIdPaisNacPac">País de nacimiento </label>
	  <select class="form-control input-lg" style="width: 100%" name="txtIdPaisNacPac" id="txtIdPaisNacPac" onkeydown="campoSiguiente('txtNroTelMovilPac', event);" disabled>
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
<div class="form-group">
	<label for="txtNroTelMovilPac">Teléfono fijo o celular:</label>
	<div class="input-group input-group-lg">
		<div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
		<input type="text" name="txtNroTelMovilPac" placeholder="999-99999 / 999999999" id="txtNroTelMovilPac" onfocus="this.select()" class="form-control input-lg" maxlength="20" value="" onkeydown="campoSiguiente('txtEmailPac', event);" disabled/>
	</div>
</div>
<!--<span class="help-block">Es obligatorio ingresar almenos un número telefónico <span class="text-danger">(*)</span></span>-->

<fieldset class="scheduler-border">
	<legend class="scheduler-border" style="margin-bottom: 0px;">Datos adicionales (<span class="text-primary" id="show-datos-adicionales-pac" style="cursor: pointer;" onclick="show_datos_adicionales_pac()">Mostrar</span>)</legend>
	<div id="datos-adicionales-pac" style="display: none;">
		<div class="form-group">
		  <select class="form-control input-sm" style="width: 100%" name="txtIdEtniaPac" id="txtIdEtniaPac">
			<option value="">-- Seleccione --</option>
			<?php
			$rsTE = $t->get_listaEtnia();
			foreach ($rsTE as $rowTE) {
			  echo "<option value='" . $rowTE['id_etnia'] . "'"; if($rowTE['id_etnia']=="58"){ echo " selected";} echo ">" . $rowTE['nom_etnia'] . "</option>";
			}
			?>
		  </select>
		</div>
		<input type="hidden" name="txtNroTelFijoPac" id="txtNroTelFijoPac" maxlength="9" value=""/>
		<div class="form-group">
		  <?php $rsUb = $ub->get_listaUbigeoLimaCallaoPeru(); ?>
		  <select class="form-control input-sm" style="width: 100%" name="txtUBIGEOPac" id="txtUBIGEOPac" onkeydown="campoSiguiente('txtDirPac', event);" onchange="habilita_atencionubi();" disabled>
			<option value="">-- Distrito domicilio --</option>
			<?php
			foreach ($rsUb as $rowUb) {
			  echo "<option value='" . $rowUb['id_ubigeo'] . "'>" . $rowUb['departamento'] . " - " . $rowUb['provincia'] . " - " . $rowUb['distrito'] . "</option>";
			}
			?>
		  </select>
		</div>
		<div style="display: none;">
			<div class="row">
			  <div class="col-sm-4">
				<label for="txtIdAvDirPac">Tipo vía</label>
				<select class="form-control input-sm" name="txtIdAvDirPac" id="txtIdAvDirPac" onkeydown="campoSiguiente('txtNomAvDirPac', event);" disabled>
				  <option value="">Seleccione</option>
				  <option value="1#AV.">AVENIDA</option>
				  <option value="2#JR.">JIRON</option>
				  <option value="3#CL.">CALLE</option>
				  <option value="4#PAS.">PASAJE</option>
				  <option value="5#ALAMEDA">ALAMEDA</option>
				  <option value="6#MAL.">MALECON</option>
				  <option value="7#OVALO">OVALO</option>
				  <option value="8#PQUE.">PARQUE</option>
				  <option value="9#PZA.">PLAZA</option>
				  <option value="10#CARR.">CARRETERA</option>
				  <option value="11#BLOQUE">BLOQUE</option>
				</select>
			  </div>
			  <div class="col-sm-5">
				<div class="form-group">
				  <label for="txtNomAvDirPac">Nombre</label>
				  <input type="text" name="txtNomAvDirPac" id="txtNomAvDirPac" placeholder="" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="150" value="" onkeydown="campoSiguiente('txtNroDirPac', event);" onkeyup="compledir('1')" disabled/>
				</div>
			  </div>
			  <div class="col-sm-3">
				<div class="form-group">
				  <label for="txtNroDirPac">Nro.</label>
				  <input type="text" name="txtNroDirPac" id="txtNroDirPac" placeholder="" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="50" value="" onkeydown="campoSiguiente('txtIntDirPac', event);" onkeyup="compledir('2')" disabled/>
				</div>
			  </div>
			</div>
			<div class="row">
			  <div class="col-sm-3">
				<div class="form-group">
				  <label for="txtIntDirPac">Interior</label>
				  <input type="text" name="txtIntDirPac" id="txtIntDirPac" placeholder="" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="50" value="" onkeydown="campoSiguiente('txtDptoDirPac', event);" onkeyup="compledir('3')" disabled/>
				</div>
			  </div>
			  <div class="col-sm-3">
				<div class="form-group">
				  <label for="txtDptoDirPac">Dpto.</label>
				  <input type="text" name="txtDptoDirPac" id="txtDptoDirPac" placeholder="" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="50" value="" onkeydown="campoSiguiente('txtMzDirPac', event);" onkeyup="compledir('4')" disabled/>
				</div>
			  </div>
			  <div class="col-sm-3">
				<div class="form-group">
				  <label for="txtMzDirPac">Mz.</label>
				  <input type="text" name="txtMzDirPac" id="txtMzDirPac" placeholder="" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="50" value="" onkeydown="campoSiguiente('txtLtDirPac', event);" onkeyup="compledir('5')" disabled/>
				</div>
			  </div>
			  <div class="col-sm-3">
				<div class="form-group">
				  <label for="txtLtDirPac">Lt.</label>
				  <input type="text" name="txtLtDirPac" id="txtLtDirPac" placeholder="" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="50" value="" onkeydown="campoSiguiente('txtIdPoblaDirPac', event);" onkeyup="compledir('6')" disabled/>
				</div>
			  </div>
			</div>
			<div class="row">
			  <div class="col-sm-5">
				<label for="txtIdPoblaDirPac">Población</label>
				<select class="form-control input-sm" style="width: 100%" name="txtIdPoblaDirPac" id="txtIdPoblaDirPac" onkeydown="campoSiguiente('txtNomPoblaDirPac', event);" disabled>
				  <option value="">Seleccione</option>
				  <option value="1#URB.">URBANIZACIÓN</option>
				  <option value="2#PBLO. JOVEN">PUEBLO JOVEN</option>
				  <option value="3#UNID. VECINAL">UNIDAD VECINAL</option>
				  <option value="4#CONJ. HAB.">CONJUNTO HABITACIONAL</option>
				  <option value="5#ATO. HUMA.">ASENTAMIENTO HUMANO</option>
				  <option value="6#COOP.">COOPERATIVA</option>
				  <option value="7#RESID.">RESIDENCIAL</option>
				  <option value="8#ZONA IND.">ZONA INDUSTRIAL</option>
				  <option value="9#GPO">GRUPO</option>
				  <option value="10#CAS.">CASERIO</option>
				  <option value="11#FUNDO">FUNDO</option>
				</select>
			  </div>
			  <div class="col-sm-7">
				<div class="form-group">
				  <label for="txtNomPoblaDirPac">Nombre:</label>
				  <input type="text" name="txtNomPoblaDirPac" id="txtNomPoblaDirPac" placeholder="" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="50" value="" onkeydown="campoSiguiente('txtDirRefPac', event);" onkeyup="compledir('7')" disabled/>
				</div>
			  </div>
			</div>
			<div class="form-group">
			  <label for="txtDirPac">Dirección:</label>
			  <input type="text" name="txtDirPac" id="txtDirPac" placeholder="" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="185" value="" readonly/>
			</div>
		</div>
		<div class="form-group">
		  <input type="text" name="txtDirRefPac" id="txtDirRefPac" placeholder="Dirección domicilio" onfocus="this.select()" class="form-control input-sm text-uppercase" maxlength="185" value="" onkeydown="campoSiguiente('txtIdTipDocSoli', event);" readonly/>
		</div>
		<div class="form-group">
		  <div class="input-group input-group-sm">
			<div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
			<input type="text" name="txtEmailPac" placeholder="Correo electrónico" id="txtEmailPac" onfocus="this.select()" class="form-control" maxlength="50" value="" onkeydown="campoSiguiente('txtUBIGEOPac', event);" disabled/>
		  </div>
		</div>
	</div>
</fieldset>
<!--<fieldset class="scheduler-border">
	<legend class="scheduler-border" style="margin-bottom: 0px;">Datos del apoderado (<span class="text-primary" id="show-datos-soli" style="cursor: pointer;" onclick="show_datos_soli()">Mostrar</span>)</legend>-->
	<div id="datos-soli" style="display: none;">
		<?php 
		include __DIR__ . '/../lab/main_reglab_dato_apoderado.php';
		?>
	</div>
<!--</fieldset>-->