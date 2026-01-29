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
                <h3 class="panel-title"><strong>LABORATORIO</strong></h3>
            </div>
            <div class="panel-body">
                  <div class="form-group">
                    <div class="row">
					  <div class="col-sm-4">
                        <label for="txtFechaDLSNi21" class="control-label">Fecha de examen 1:</label>
                        <div class="input-group">
                          <input type="text" name="txtFechaDLSNi21" id="txtFechaDLSNi21" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask disabled/>
                          <span class="input-group-addon my-addon">
                            <input type="checkbox" class="check_labni2" name="txtAsisFechaDLSNi2" id="txtAsisFechaDLSNi21" value="1" disabled>
                          </span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtNroDLSNi21" class="control-label">N° Diluciones:</label>
                        <input type="text" name="txtNroDLSNi21" id="txtNroDLSNi21" class="form-control" maxlength="4" value="" onfocus="this.select()" disabled/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label for="txtFechaDLSNi22" class="control-label">Fecha de examen 2:</label>
                        <div class="input-group">
                          <input type="text" name="txtFechaDLSNi22" id="txtFechaDLSNi22" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask disabled/>
                          <span class="input-group-addon my-addon">
                            <input type="checkbox" class="check_labni2" name="txtAsisFechaDLSNi2" id="txtAsisFechaDLSNi22" value="2" disabled>
                          </span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtNroDLSNi22" class="control-label">N° Diluciones:</label>
                        <input type="text" name="txtNroDLSNi22" id="txtNroDLSNi22" class="form-control" maxlength="4" value="" onfocus="this.select()" disabled/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label><b>PUNCIÓN LUMBAR?:</b> </label><br/>
						<label class="radio-inline"><input type="radio" class="opt_puncionlumbar2" name="txt_puncionlumbar2" id="txt_puncionlumbar21" value="1" disabled/>SI</label>
						<label class="radio-inline"><input type="radio" class="opt_puncionlumbar2" name="txt_puncionlumbar2" id="txt_puncionlumbar20" value="0" disabled/>NO</label>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtFechaPuncionNi2" class="control-label">Fecha:</label>
                        <input type="text" name="txtFechaPuncionNi2" id="txtFechaPuncionNi2" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtResulPuncionNi2" class="control-label">Resultado:</label>
                        <input type="text" name="txtResulPuncionNi2" id="txtResulPuncionNi2" class="form-control" maxlength="150" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtGest', event);" disabled/>
                      </div>
                    </div>
                  </div>
				  </div>
			</div>
			<div class="panel panel-warning">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>TRATAMIENTO DEL MENOR</strong></h3>
              </div>
              <div class="panel-body">
				<div class="radio" style="margin-top: 2px;">
					<label><input type="radio" class="opt_tratamientomenor2" name="txt_tratamientomenor2" id="txt_tratamientomenor21" value="1"><b> Si</b></label>
				</div>
				<div class="row" style="display: none;" id="div_tratamientomenor2">
					<div class="col-sm-1">
						&nbsp;
					</div>
					<div class="col-sm-11">
						<div class="row">
							<div class="col-sm-7">
								<label for="txt_idtratamientomenorsi2" class="control-label" >Tratamiento:</label>
								<select class="form-control" name="txt_idtratamientomenorsi2" id="txt_idtratamientomenorsi2">
									<option value="">-- Seleccione tratamiento --</option>
									<option value="1">Con Penicilina G Sódica o Penicilina G Procaínica por ≥ 10 días</option>
									<option value="2">Con Penicilina Benzatínica x 1 dosis</option>
									<option value="2">Con otro tratamiento</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="txt_fechainitratamientomenorsi2" class="control-label">Inicio tratamiento:</label>
								<input type="text" name="txt_fechainitratamientomenorsi2" id="txt_fechainitratamientomenorsi2" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
							</div>
						</div>
					</div>
				</div>
				<div class="radio" style="margin-top: 2px;">
					<label><input type="radio" class="opt_tratamientomenor2" name="txt_tratamientomenor2" id="txt_tratamientomenor22" value="2"><b> No</b></label>
				</div>
				<div class="radio" style="margin-top: 2px;">
					<label><input type="radio" class="opt_tratamientomenor2" name="txt_tratamientomenor2" id="txt_tratamientomenor23" value="3"><b> Desconocido</b></label>
				</div>
			  </div>
			</div>
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>CRITERIOS PARA CONSIDERAR SÍFILIS CONGÉNITA</strong></h3>
				</div>
				<div class="panel-body">
					<div class="checkbox">
						<label><input class="chk_criteriomenor2" name="chk_criteriomenor2" id="chk_criteriomenor21" type="checkbox" value="1">Madre con sífilis, que no recibió tratamiento o fue tratada inadecuadamente.</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor2" name="chk_criteriomenor2" id="chk_criteriomenor22" type="checkbox" value="2">Resultado de títulos de análisis no treponémicos cuatro veces mayor que los títulos de la madre.</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor2" name="chk_criteriomenor2" id="chk_criteriomenor23" type="checkbox" value="3">Niño con manifestaciones clínicas sugestivas de sífilis congénita (al examen físico o evidencia radiográfica)</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor2" name="chk_criteriomenor2" id="chk_criteriomenor24" type="checkbox" value="4">Demostración de Treponema Pallidum en lesiones, placenta, cordón umbilical o material de autopsia.</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor2" name="chk_criteriomenor2" id="chk_criteriomenor25" type="checkbox" value="5">Niño mayor de 2 años de edad; con signos clínicos de sífilis secundaria en el que se ha descartado el antecedente de abuso sexual o contacto sexual.</label>
					</div>
				</div>
			</div>
            <div class="panel panel-warning">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>CLASIFICACIÓN FINAL DEL NIÑO, MORTINATO O ABORTO</strong></h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                    <label class="radio-inline"><input type="radio" class="opt_estafinalnino2" name="txtEstFinalNino2" id="txtEstFinalNino21" value="1" disabled/><b>SÍFILIS CONGÉNITA</b></label>
                    <label class="radio-inline"><input type="radio" class="opt_estafinalnino2" name="txtEstFinalNino2" id="txtEstFinalNino22" value="2" disabled/><b>NIÑO EXPUESTO A SÍFILIS, NO INFECTADO</b></label>
                    <label class="radio-inline"><input type="radio" class="opt_estafinalnino2" name="txtEstFinalNino2" id="txtEstFinalNino23" value="3" disabled/><b>FALLECIDO</b></label>
                </div>
				<br/>
				<div id="datos-nino-fallecido-2" style="display: none;">
					<div class="row">
					  <div class="col-sm-3">
						<label for="txtFechaNiFalle" class="control-label">Fec. fallecimiento:</label>
						<input type="text" name="txtFechaNiFalle2" id="txtFechaNiFalle2" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
					  </div>
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>
</div>