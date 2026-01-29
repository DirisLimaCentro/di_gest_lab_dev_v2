<div class="panel panel-info">
  <div class="panel-heading">
	<h3 class="panel-title"><strong>Tamizaje de cuello uterino anterior</strong></h3>
  </div>
  <div class="panel-body">
	<div class="row">
	  <div class="col-sm-3">
		<div class="form-group">
		  <label for="txtPAPANte"><b>Tamizaje anterior</b></label>
		  <select class="form-control" name="txtPAPANte" id="txtPAPANte" disabled>
			<option value=""> -- Seleccione  -- </option>
			<option value="1">PAP</option>
			<option value="3">IVAA</option>
			<option value="4">PM-VPH</option>
			<option value="0">NINGUNO</option>
		  </select>
		</div>
		<div class="form-group">
		  <label for="txtResultadoAnte" style="margin-bottom: 0px;"><b>Resultado</b></label>
		  <div class="radio" style="margin-bottom: 0px; margin-top: 0px;">
			<label>
			  <input type="radio" name="txtResultadoAnte" id="txtResultadoAnte1" value="1" class="opt_resulante" disabled/>
			  Positivo
			</label>
		  </div>
		  <div class="row">
			  <div class="col-sm-12" id="show-resultadoanteexa" style="display: none;">
				<span>Procedimiento realizado después del resultado:</span><br/>
				 <label class="checkbox-inline">
				  <input type="checkbox" name="txtResultadoAnteExa" id="txtResultadoAnteExa1" class="opt_resulanteexa" value="1" disabled> Colposcopia
				</label>
				<label class="checkbox-inline">
				  <input type="checkbox" name="txtResultadoAnteExa" id="txtResultadoAnteExa2" class="opt_resulanteexa" value="2" disabled> Biopsia
				</label>
			  </div>
		  </div>
		  <div class="radio">
			<label>
			  <input type="radio" name="txtResultadoAnte" id="txtResultadoAnte2" value="2" class="opt_resulante" disabled/>
			  Negativo
			</label>
		  </div>
		</div>
		<div class="form-group">
		  <label for=""><b>Año del último tamizaje</b></label>
		  <input type="text" name="txAnioResulAnte" id="txAnioResulAnte" onfocus="this.select()" class="form-control" maxlength="4" value=""  onkeydown="campoSiguiente('txtDetResultadoAnte', event);" disabled/>
		</div>
	  </div>
	  <div class="col-sm-4">
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title"><strong>Anormalidad de células epiteliales escamosas</strong></h3>
		  </div>
		  <div class="panel-body">
			<div class="form-group">
			  <div class="radio" style="margin-top: 0px !important;">
				<label>
				  <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa1" class="opt_anorescamosa" value="1" disabled/>
				  ASCUS
				</label>
			  </div>
			  <div class="radio">
				<label>
				  <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa2" class="opt_anorescamosa" value="2" disabled/>
				  L.I.E. de bajo grado
				</label>
			  </div>
			  <div class="radio">
				<label>
				  <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa3" class="opt_anorescamosa" value="3" disabled/>
				  ASCH
				</label>
			  </div>
			  <div class="radio">
				<label>
				  <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa4" class="opt_anorescamosa" value="4" disabled/>
				  L.I.E. de alto grado
				</label>
			  </div>
			  <div class="radio">
				<label>
				  <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa5" class="opt_anorescamosa" value="5" disabled/>
				  CARCINOMA IN SITU
				</label>
			  </div>
			  <div class="radio">
				<label>
				  <input type="radio" name="txtAnorEscamosa" id="txtAnorEscamosa6" class="opt_anorescamosa" value="6" disabled/>
				  CARCINOMA INVASOR
				</label>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="col-sm-4">
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title"><strong>Anormalidad de células epiteliales Glandulares</strong></h3>
		  </div>
		  <div class="panel-body">
			<div class="form-group">
			  <div class="radio">
				<label>
				  <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular1" class="opt_anorglandular" value="1" disabled/>
				  Celulas glandulares atipicas
				</label>
			  </div>
			  <div class="radio">
				<label>
				  <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular2" class="opt_anorglandular" value="2" disabled/>
				  Celulas glandulares atipicas sugestivas de neoplasia
				</label>
			  </div>
			  <div class="radio">
				<label>
				  <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular3" class="opt_anorglandular" value="3" disabled/>
				  Adenocarcinoma in situ
				</label>
			  </div>
			  <div class="radio">
				<label>
				  <input type="radio" name="txtAnorGlandular" id="txtAnorGlandular4" class="opt_anorglandular" value="4" disabled/>
				  Adenocarcinoma
				</label>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
