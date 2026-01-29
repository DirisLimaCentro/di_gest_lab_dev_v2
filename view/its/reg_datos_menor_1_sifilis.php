<div class="row">
	<div class="col-sm-5">
		<?php require 'reg_datos_culminacion_embarazo_1.php'?>
		<?php include "reg_datos_menor_1.php"; ?>
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>OBSERVACIONES DEL NIÑO</strong></h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<textarea name="txtObsNino" id="txtObsNino" class="form-control" rows="3" disabled></textarea>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-7">
		<div id="div_laboratorio_menor" style="display: none;">
			<div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>LABORATORIO</strong></h3>
            </div>
            <div class="panel-body">
                  <div class="form-group">
                    <div class="row">
					  <div class="col-sm-4">
                        <label for="txtFechaDLSNi1" class="control-label">Fecha de examen 1:</label>
                        <div class="input-group">
                          <input type="text" name="txtFechaDLSNi1" id="txtFechaDLSNi1" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                          <span class="input-group-addon my-addon">
                            <input type="checkbox" class="check_labni" name="txtAsisFechaDLSNi" id="txtAsisFechaDLSNi1" value="1" disabled>
                          </span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtNroDLSNi1" class="control-label">N° Diluciones:</label>
                        <input type="text" name="txtNroDLSNi1" id="txtNroDLSNi1" class="form-control" maxlength="4" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtFechaDLS1', event);" disabled/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label for="txtFechaDLSNi2" class="control-label">Fecha de examen 2:</label>
                        <div class="input-group">
                          <input type="text" name="txtFechaDLSNi2" id="txtFechaDLSNi2" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                          <span class="input-group-addon my-addon">
                            <input type="checkbox" class="check_labni" name="txtAsisFechaDLSNi" id="txtAsisFechaDLSNi2" value="2" disabled>
                          </span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtNroDLSNi2" class="control-label">N° Diluciones:</label>
                        <input type="text" name="txtNroDLSNi2" id="txtNroDLSNi2" class="form-control" maxlength="4" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtFechaDLS1', event);" disabled/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label><b>PUNCIÓN LUMBAR?:</b> </label><br/>
						<label class="radio-inline"><input type="radio" class="opt_puncionlumbar" name="txt_puncionlumbar" id="txt_puncionlumbar1" value="1" disabled/>SI</label>
						<label class="radio-inline"><input type="radio" class="opt_puncionlumbar" name="txt_puncionlumbar" id="txt_puncionlumbar0" value="0" disabled/>NO</label>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtFechaPuncionNi" class="control-label">Fecha:</label>
                        <input type="text" name="txtFechaPuncionNi" id="txtFechaPuncionNi" class="form-control" maxlength="10" value="" onfocus="this.select()" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtGest', event);" disabled/>
                      </div>
                      <div class="col-sm-3">
                        <label for="txtResulPuncionNi" class="control-label">Resultado:</label>
                        <input type="text" name="txtResulPuncionNi" id="txtResulPuncionNi" class="form-control" maxlength="150" value="" onfocus="this.select()" onkeydown="campoSiguiente('txtGest', event);" disabled/>
                      </div>
                    </div>
                  </div>
				  </div>
			</div>
			<div class="panel panel-success">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>TRATAMIENTO DEL MENOR</strong></h3>
              </div>
              <div class="panel-body">
				<div class="radio" style="margin-top: 2px;">
					<label><input type="radio" class="opt_tratamientomenor" name="txt_tratamientomenor" id="txt_tratamientomenor1" value="1"><b> Si</b></label>
				</div>
				<div class="row" style="display: none;" id="div_tratamientomenor">
					<div class="col-sm-1">
						&nbsp;
					</div>
					<div class="col-sm-11">
						<div class="row">
							<div class="col-sm-7">
								<label for="txt_idtratamientomenorsi" class="control-label" >Tratamiento:</label>
								<select class="form-control" name="txt_idtratamientomenorsi" id="txt_idtratamientomenorsi">
									<option value="">-- Seleccione tratamiento --</option>
									<option value="1">Con Penicilina G Sódica o Penicilina G Procaínica por ≥ 10 días</option>
									<option value="2">Con Penicilina Benzatínica x 1 dosis</option>
									<option value="2">Con otro tratamiento</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="txt_fechainitratamientomenorsi" class="control-label">Inicio tratamiento:</label>
								<input type="text" name="txt_fechainitratamientomenorsi" id="txt_fechainitratamientomenorsi" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
							</div>
						</div>
					</div>
				</div>
				<div class="radio" style="margin-top: 2px;">
					<label><input type="radio" class="opt_tratamientomenor" name="txt_tratamientomenor" id="txt_tratamientomenor2" value="2"><b> No</b></label>
				</div>
				<div class="radio" style="margin-top: 2px;">
					<label><input type="radio" class="opt_tratamientomenor" name="txt_tratamientomenor" id="txt_tratamientomenor3" value="3"><b> Desconocido</b></label>
				</div>
			  </div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>CRITERIOS PARA CONSIDERAR SÍFILIS CONGÉNITA</strong></h3>
				</div>
				<div class="panel-body">
					<div class="checkbox">
						<label><input class="chk_criteriomenor" name="chk_criteriomenor" id="chk_criteriomenor1" type="checkbox" value="1">Madre con sífilis, que no recibió tratamiento o fue tratada inadecuadamente.</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor" name="chk_criteriomenor" id="chk_criteriomenor2" type="checkbox" value="2">Resultado de títulos de análisis no treponémicos cuatro veces mayor que los títulos de la madre.</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor" name="chk_criteriomenor" id="chk_criteriomenor3" type="checkbox" value="3">Niño con manifestaciones clínicas sugestivas de sífilis congénita (al examen físico o evidencia radiográfica)</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor" name="chk_criteriomenor" id="chk_criteriomenor4" type="checkbox" value="4">Demostración de Treponema Pallidum en lesiones, placenta, cordón umbilical o material de autopsia.</label>
					</div>
					<div class="checkbox">
						<label><input class="chk_criteriomenor" name="chk_criteriomenor" id="chk_criteriomenor5" type="checkbox" value="5">Niño mayor de 2 años de edad; con signos clínicos de sífilis secundaria en el que se ha descartado el antecedente de abuso sexual o contacto sexual.</label>
					</div>
				</div>
			</div>
            <div class="panel panel-success">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>CLASIFICACIÓN FINAL DEL NIÑO, MORTINATO O ABORTO</strong></h3>
              </div>
              <div class="panel-body">
                <div class="form-group">
                    <label class="radio-inline"><input type="radio" class="opt_estafinalnino" name="txtEstFinalNino" id="txtEstFinalNino1" value="1" disabled/><b>SÍFILIS CONGÉNITA</b></label>
                    <label class="radio-inline"><input type="radio" class="opt_estafinalnino" name="txtEstFinalNino" id="txtEstFinalNino2" value="2" disabled/><b>NIÑO EXPUESTO A SÍFILIS, NO INFECTADO</b></label>
                    <label class="radio-inline"><input type="radio" class="opt_estafinalnino" name="txtEstFinalNino" id="txtEstFinalNino3" value="3" disabled/><b>FALLECIDO</b></label>
                </div>
				<br/>
				<div id="datos-nino-fallecido" style="display: none;">
					<div class="row">
					  <div class="col-sm-3">
						<label for="txtFechaNiFalle" class="control-label">Fec. fallecimiento:</label>
						<input type="text" name="txtFechaNiFalle" id="txtFechaNiFalle" class="form-control" maxlength="10" value="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask onkeydown="campoSiguiente('txtObsNino', event);"/>
					  </div>
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>
</div>