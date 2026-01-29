<div id="modal_edit_persona" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showBuscarModalLabel">Editar datos personales de pacientes</h4>
      </div>
      <div class="modal-body">
		<input type="hidden" name="txt_edit_id_paciente" id="txt_edit_id_paciente" value=""/>
		<div class="form-group">
		  <div class="row">
			<div class="col-sm-6">
			  <div class="row">
				<div class="col-sm-12">
				  <label for="txt_edit_id_tipo_doc_pac">Doc. de identidad <span class="text-danger">(*)</span>:</label>
				</div>
			  </div>
			  <div class="row">
					<div class="col-xs-4" style="padding-right: 0!important;">
					  <?php $rsT = $t->get_ListaTipoDocPerNatu();?>
					  <select class="form-control" name="txt_edit_id_tipo_doc_pac" id="txt_edit_id_tipo_doc_pac" disabled>
						<?php
						foreach ($rsT as $row) {
						  echo "<option value='" . $row['id_tipodoc'] . "'>" . $row['abreviatura'] . ": ".$row['descripcion']."</option>";
						}
						?>
					  </select>
					</div>
					<div class="col-xs-8" style="padding-left: 0!important;">
					  <div class="input-group">
						<input type="text" name="txt_edit_nro_doc_pac" id="txt_edit_nro_doc_pac" onfocus="this.select()" autocomplete="OFF" class="form-control" value="" disabled/>
						<div class="input-group-btn">
						  <button class="btn btn-info" type="button" id="btnPacSearch" onclick="buscar_datos_personales()" disabled><i class="fa fa-search"></i></button>
						</div>
					  </div>
					</div>
				  </div>
				</div>
				<div class="col-sm-3">
				  <label for="txt_edit_nro_hc_pac"><small>Nro. H.C. <span class="text-danger">(*)</span>:</small></label>
				  <input type="text" name="txt_edit_nro_hc_pac" class="form-control" id="txt_edit_nro_hc_pac" maxlength="10"/>
				</div>
				<div class="col-sm-3">
				  <label for="txt_edit_id_pais_pac">País de nacimiento <span class="text-danger">(*)</span>:</label>
				  <select class="form-control" style="width: 100%" name="txt_edit_id_pais_pac" id="txt_edit_id_pais_pac">
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
				<div class="col-sm-6">
				  <label for="txt_edit_primer_ape_pac">Primer apellido <span class="text-danger">(*)</span>:</label>
				  <input type="text" name="txt_edit_primer_ape_pac" class="form-control" id="txt_edit_primer_ape_pac" maxlength="75">
				</div>
				<div class="col-sm-6">
				  <label for="txt_edit_segundo_ape_pac">Segundo apellido:</label>
				  <input type="text" name="txt_edit_segundo_ape_pac" class="form-control" id="txt_edit_segundo_ape_pac" maxlength="75"/>
				</div>
			  </div>
			</div>
			<div class="form-group">
			  <label for="txt_edit_nombres_pac">Nombre(s) <span class="text-danger">(*)</span>:</label>
			  <input type="text" name="txt_edit_nombres_pac" class="form-control" id="txt_edit_nombres_pac" maxlength="180"/>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						<label for="txt_edit_id_sexo_pac"><small>Sexo <span class="text-danger">(*)</span>:</small></label>
						  <select class="form-control" name="txt_edit_id_sexo_pac" id="txt_edit_id_sexo_pac">
							<option value="">Seleccione</option>
							<option value="1">M</option>
							<option value="2">F</option>
						</select>
					</div>
					<div class="col-sm-4">
						<label for="txt_edit_fec_nac_pac"><i class="fa fa-calendar" id="datepicker"></i> Fecha Nacimiento <span class="text-danger">(*)</span>:</label>
						<input type="text" name="txt_edit_fec_nac_pac" id="txt_edit_fec_nac_pac" placeholder="DD/MM/AAAA" autofocus="" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask  data-date-end-date="0d"/>
						<input type="hidden" name="txt_edit_edad_pac" id="txt_edit_edad_pac" value=""/>
					</div>
					<div class="col-sm-6">
						<label for="txt_id_etnia_pac">Etnia:</label>
						<select class="form-control" name="txt_id_etnia_pac" id="txt_id_etnia_pac" style="width: 100%">
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
					<div class="col-sm-6">
						<label for="txt_edit_tel_mov_pac">Teléfono fijo o celular:</label>
						<div class="input-group">
							<div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
							<input type="text" class="form-control" name="txt_edit_tel_mov_pac" id="txt_edit_tel_mov_pac" placeholder="999-99999 / 999999999" onfocus="this.select()" maxlength="20" value=""/>
							<input type="hidden" name="txt_edit_tel_fij_pac" id="txt_edit_tel_fij_pac" value=""/>
						</div>
					</div>
					<div class="col-sm-6">
						<label for="txt_edit_email_pac">Correo electrónico:</label>
						<div class="input-group">
							<div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
							<input type="text"  class="form-control" name="txt_edit_email_pac" id="txt_edit_email_pac" placeholder="correo@example.com" onfocus="this.select()" maxlength="75" value=""/>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-4">
						<label for="txt_edit_id_ubigeo_pac">Distrito domicilio:</label>
						<?php $rsUb = $ub->get_listaUbigeoLimaCallaoPeru(); ?>
						  <select class="form-control input-sm" style="width: 100%" name="txt_edit_id_ubigeo_pac" id="txt_edit_id_ubigeo_pac">
							<option value="">-- Seleccione --</option>
							<?php
							foreach ($rsUb as $rowUb) {
							  echo "<option value='" . $rowUb['id_ubigeo'] . "'>" . $rowUb['departamento'] . " - " . $rowUb['provincia'] . " - " . $rowUb['distrito'] . "</option>";
							}
							?>
						  </select>
					</div>
					<div class="col-sm-8">
						<label for="txt_edit_direccion_pac">Dirección domicilio:</label>
						<input type="text" class="form-control input-sm" name="txt_edit_direccion_pac" id="txt_edit_direccion_pac" maxlength="180"/>
						<input type="hidden" name="txt_edit_ref_direccion_pac" id="txt_edit_ref_direccion_pac"/>
					</div>
				</div>
			</div>
		</div>
      <div class="modal-footer" style="padding-bottom: 7px !important; padding-top: 7px !important;">
		<div class="row">
		  <div class="col-md-12 text-center">
			<div class="btn-group">
			  <button type="button" class="btn btn-primary btn-continuar" id="btn_frm_edit_pac" onclick="save_personales_editar('LAB')"><i class="fa fa-save"></i> Guardar </button>
			  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
			</div>
		  </div>
		</div>
      </div>
      </div>
	</div>
 </div>