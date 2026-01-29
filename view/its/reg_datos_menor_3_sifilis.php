<div class="row">
	<div class="col-sm-5">
		<?php require 'reg_datos_culminacion_embarazo_3.php'?>
		<?php include "reg_datos_menor_3.php"; ?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>OBSERVACIONES DEL NIÑO</strong></h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<textarea name="txtObsNino3" id="txtObsNino3" class="form-control" rows="3"></textarea>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-7">
		<div id="div_laboratorio_menor3" style="display: none;">
			<div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>LABORATORIO</strong></h3>
            </div>
            <div class="panel-body">
                  <div class="form-group">
                    <div class="row">
					  <div class="col-sm-4">
                        <label for="txtFechaDLSNi31" class="control-label">Fecha de examen 1:</label>
                        <div class="input-group">
                          <input type="text" name="txtFechaDLSNi31" id="txtFechaDLSNi31" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask disabled/>
                          <span class="input-group-addon my-addon">
                            <input type="checkbox" class="check_labni3" name="txtAsisFechaDLSNi3" id="txtAsisFechaDLSNi31" value="1" disabled>
                          </span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtNroDLSNi31" class="control-label">N° Diluciones:</label>
                        <input type="text" name="txtNroDLSNi31" id="txtNroDLSNi31" class="form-control" maxlength="4" value="" onfocus="this.select()" disabled/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label for="txtFechaDLSNi32" class="control-label">Fecha de examen 2:</label>
                        <div class="input-group">
                          <input type="text" name="txtFechaDLSNi32" id="txtFechaDLSNi32" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask disabled/>
                          <span class="input-group-addon my-addon">
                            <input type="checkbox" class="check_labni3" name="txtAsisFechaDLSNi3" id="txtAsisFechaDLSNi32" value="2" disabled>
                          </span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtNroDLSNi32" class="control-label">N° Diluciones:</label>
                        <input type="text" name="txtNroDLSNi32" id="txtNroDLSNi32" class="form-control" maxlength="4" value="" onfocus="this.select()" disabled/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label><b>PUNCIÓN LUMBAR?:</b> </label><br/>
						<label class="radio-inline"><input type="radio" class="opt_puncionlumbar3" name="txt_puncionlumbar3" id="txt_puncionlumbar31" value="1" disabled/>SI</label>
						<label class="radio-inline"><input type="radio" class="opt_puncionlumbar3" name="txt_puncionlumbar3" id="txt_puncionlumbar30" value="0" disabled/>NO</label>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtFechaPuncionNi3" class="control-label">Fecha:</label>
                        <input type="text" name="txtFechaPuncionNi3" id="txtFechaPuncionNi3" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtResulPuncionNi3', event);" disabled/>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtResulPuncionNi3" class="control-label">Resultado:</label>
                        <input type="text" name="txtResulPuncionNi3" id="txtResulPuncionNi3" class="form-control" maxlength="150" value="" onfocus="this.select()" disabled/>
                      </div>
                    </div>
                  </div>
				  </div>
			</div>
			<div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>TRATAMIENTO DEL MENOR</strong></h3>
              </div>
              <div class="panel-body">
				<div class="radio" style="margin-top: 2px;">
					<label><input type="radio" class="opt_tratamientomenor3" name="txt_tratamientomenor3" id="txt_tratamientomenor31" value="1"><b> Si</b></label>
				</div>
				<div class="row" style="display: none;" id="div_tratamientomenor3">
					<div class="col-sm-1">
						&nbsp;
					</div>
					<div class="col-sm-11">
						<div class="row">
							<div class="col-sm-7">
								<label for="txt_idtratamientomenorsi3" class="control-label" >Tratamiento:</label>
								<select class="form-control" name="txt_idtratamientomenorsi3" id="txt_idtratamientomenorsi3">
									<option value="">-- Seleccione tratamiento --</option>
									<option value="1">Con Penicilina G Sódica o Penicilina G Procaínica por ≥ 10 días</option>
									<option value="2">Con Penicilina Benzatínica x 1 dosis</option>
									<option value="2">Con otro tratamiento</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="txt_fechainitratamientomenorsi3" class="control-label">Inicio tratamiento:</label>
								<input type="text" name="txt_fechainitratamientomenorsi3" id="txt_fechainitratamientomenorsi3" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
							</div>
						</div>
					</div>
				</div>
				<div class="radio" style="margin-top: 2px;">
					<label><input type="radio" class="opt_tratamientomenor3" name="txt_tratamientomenor3" id="txt_tratamientomenor32" value="2"><b> No</b></label>
				</div>
				<div class="radio" style="margin-top: 2px;">
					<label><input type="radio" class="opt_tratamientomenor3" name="txt_tratamientomenor3" id="txt_tratamientomenor33" value="3"><b> Desconocido</b></label>
				</div>
			  </div>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>CRITERIOS PARA CONSIDERAR SÍFILIS CONGÉNITA</strong></h3>
				</div>
				<div class="panel-body">
					<div class="checkbox">
						<label><input class="chk_criteriomenor3" name="chk_criteriomenor3" id="chk_criteriomenor31" type="checkbox" value="1">Madre con sífilis, que no recibió tratamiento o fue tratada inadecuadamente.</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor3" name="chk_criteriomenor3" id="chk_criteriomenor32" type="checkbox" value="2">Resultado de títulos de análisis no treponémicos cuatro veces mayor que los títulos de la madre.</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor3" name="chk_criteriomenor3" id="chk_criteriomenor33" type="checkbox" value="3">Niño con manifestaciones clínicas sugestivas de sífilis congénita (al examen físico o evidencia radiográfica)</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor3" name="chk_criteriomenor3" id="chk_criteriomenor34" type="checkbox" value="4">Demostración de Treponema Pallidum en lesiones, placenta, cordón umbilical o material de autopsia.</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor3" name="chk_criteriomenor3" id="chk_criteriomenor35" type="checkbox" value="5">Niño mayor de 2 años de edad; con signos clínicos de sífilis secundaria en el que se ha descartado el antecedente de abuso sexual o contacto sexual.</label>
					</div>
				</div>
			</div>
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>CLASIFICACIÓN FINAL DEL NIÑO, MORTINATO O ABORTO</strong></h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                    <label class="radio-inline"><input type="radio" class="opt_estafinalnino3" name="txtEstFinalNino3" id="txtEstFinalNino31" value="1" disabled/><b>SÍFILIS CONGÉNITA</b></label>
                    <label class="radio-inline"><input type="radio" class="opt_estafinalnino3" name="txtEstFinalNino3" id="txtEstFinalNino32" value="2" disabled/><b>NIÑO EXPUESTO A SÍFILIS, NO INFECTADO</b></label>
                    <label class="radio-inline"><input type="radio" class="opt_estafinalnino3" name="txtEstFinalNino3" id="txtEstFinalNino33" value="3" disabled/><b>FALLECIDO</b></label>
                </div>
				<br/>
				<div id="datos-nino-fallecido-3" style="display: none;">
					<div class="row">
					  <div class="col-sm-3">
						<label for="txtFechaNiFalle3" class="control-label">Fec. fallecimiento:</label>
						<input type="text" name="txtFechaNiFalle3" id="txtFechaNiFalle3" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
					  </div>
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>
</div>