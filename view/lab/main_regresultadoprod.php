<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<style>
#parent {
  height: 450px;
}
</style>
<?php
require_once '../../model/Producton.php';
$pn = new Producton();
require_once '../../model/Componente.php';
$c = new Componente();
?>
<?php
require_once '../../model/Atencion.php';
$at = new Atencion();
$idAtencion = $_GET['nroSoli'];
$rsA = $at->get_datosAtencion($idAtencion);
//print_r($rsA);
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
	  <div class="row">
		<div class="col-sm-6">
			<h3 class="panel-title"><strong>REGISTRAR O MODIFICAR RESULTADO DE EXAMEN</strong></h3>
		</div>
		<div class="col-sm-6 text-right">
			<h3 class="panel-title"><a href="#" onclick="event.preventDefault(); open_ayuda()">Ayuda <i class="fa fa-question-circle-o" aria-hidden="true"></i></a></h3>
		</div>
	 </div>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-5 col-md-4">
          <form name="frmPaciente" id="frmPaciente">
            <input type="hidden" name="txtIdAtencion" id="txtIdAtencion" value="<?php echo $_GET['nroSoli']?>"/>
            <input type="hidden" name="txtIngResul" id="txtIngResul" value="NO"/>
            <input type="hidden" name="txtShowOptPrint" id="txtShowOptPrint" value=""/>
			<?php if(isset($_GET['id_prod'])){$id_producto=$_GET['id_prod'];} else {$id_producto = 0;} ?>
			<input type="hidden" name="txt_id_producto_selec" id="txt_id_producto_selec" value="<?php echo $id_producto;?>"/>
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title"><strong>Datos de la referencia</strong></h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-4 col-md-2">
                    <label for="txtHCPac">Atención</label>
                    <input type="text" name="txtNroAtencion" id="txtNroAtencion" class="form-control input-xs" value="<?php echo $rsA[0]['nro_atencion']." - ".$rsA[0]['anio_atencion']?>" disabled/>
                  </div>
                  <div class="col-sm-4 col-md-2">
                    <label for="txtHCPac">HCL.</label>
                    <input type="text" name="txtHCPac" id="txtHCPac" class="form-control input-xs" value="<?php echo $rsA[0]['nro_hcpac']?>" disabled/>
                  </div>
                  <div class="col-sm-12 col-md-8">
                    <label for="txtNomPac">Paciente</label>
                    <input type="text" name="txtNomPac" id="txtNomPac" class="form-control input-xs" value="<?php echo $rsA[0]['nombre_rspac']?>" disabled/>
                  </div>
                  <!--<div class="col-sm-1 text-center">
                  <label>Detalle</label><br/>
                  <button type="button" class="btn btn-primary btn-xs" onclick="open_fua('<?php echo $_GET['nroSoli']?>');"><i class="fa fa-h-square"></i></button>
                </div>-->
                <div class="col-sm-8 col-md-4">
                  <label for="txtEdadDiaPac">Edad</label>
                  <input type="text" name="txtDetEdadPac" id="txtDetEdadPac" class="form-control input-xs" value="<?php echo $rsA[0]['edad_anio']." años ". $rsA[0]['edad_mes']. " meses ". $rsA[0]['edad_dia']. " dias."?>" disabled/>
                  <input type="hidden" name="txtEdadAnioPac" id="txtEdadAnioPac" value="<?php echo $rsA[0]['edad_anio'];?>"/>
                  <input type="hidden" name="txtEdadMesPac" id="txtEdadMesPac" value="<?php echo $rsA[0]['edad_mes'];?>"/>
                  <input type="hidden" name="txtEdadDiaPac" id="txtEdadDiaPac" value="<?php echo $rsA[0]['edad_dia'];?>"/>
                </div>
				<div class="col-sm-3 col-md-2">
                  <label for="txtSexoPac">Sexo</label>
                  <input type="text" name="txtSexoPac" id="txtSexoPac" class="form-control input-xs" value="<?php echo $rsA[0]['nom_sexopac']?>" disabled/>
                </div>
              </div>
              <?php
              $nomSexo = $rsA[0]['nom_sexopac'];
              $edadAnio = $rsA[0]['edad_anio'];
              $edadMes =  $rsA[0]['edad_mes'];
              $edadDia =  $rsA[0]['edad_dia'];
              ?>
              <h4>Examen(es) solicitado(s)</h4>
              <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><small>&nbsp</small></th>
                        <th><small>Nombre</small></th>
						<th><small>&nbsp</small></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ip = (int)1;
                      $rsCtp = $at->get_datosProductoPorIdAtencion($idAtencion);
					  $cnt_productos = count($rsCtp);
					  $cnt_validado = (int)0;
					  $cnt_sin_muestra = (int)0;
                      foreach ($rsCtp as $rowCpt) {
						$btnIng = '';
						$btnImpr = '';
						if($rowCpt['id_estado_envio'] == "1"){
							if($rowCpt['fec_recepciontoma'] == ""){
								$colorstyle = "active";
								$cnt_sin_muestra ++;
							} else {
								if($rowCpt['id_estado_resul'] == "1"){
									$colorstyle = "info";
									if($cnt_productos <> 1){
										$btnIng = '<button type="button" class="btn btn-primary btn-xs tbn-ing-producto" onclick="reg_resultado(\'' . $idAtencion . '\',\'' . $rowCpt['id_producto'] . '\');"><i class="glyphicon glyphicon-eject"></i></button>';
									}
								} else if($rowCpt['id_estado_resul'] == "2"){
									if($cnt_productos <> 1){
										$btnIng = '<button type="button" class="btn btn-success btn-xs tbn-ing-producto" onclick="reg_resultado(\'' . $idAtencion . '\',\'' . $rowCpt['id_producto'] . '\');"><i class="glyphicon glyphicon-pencil"></i></button>';
									}
									$colorstyle = "primary";
								} else {
									$colorstyle = "success";
									$btnImpr = '<button type="button" class="btn btn-warning btn-xs" onclick="imprime_resultado(\'' . md5($idAtencion) . '\',\'' . md5($rsA[0]['id_dependencia']) . '\',\'' . $rowCpt['id_producto'] . '\');"><i class="fa fa-file-text-o"></i></button>';
									$cnt_validado ++;
								}
							}
						} else {
							$colorstyle = "warning";
						}
						
                        echo "<tr>";
                        echo "<td class=\"text-center\">".$ip ++."</td>";
						echo "<td class='" . $colorstyle . "'><b>" . $rowCpt['nom_producto'] . "</b>";
						?>
						(<span style="font-weight: bold; cursor: pointer;" id="show-datos-adicionales-<?php echo $rowCpt['id_producto']?>" onclick="show_datos_adicionales(<?php echo $rowCpt['id_producto']?>)">+</span>)
						<div id="datos-adicionales-<?php echo $rowCpt['id_producto']?>" style="display: none;">
							<?php
								if($rowCpt['fec_recepciontoma'] <> ""){
								echo "<small>Recibido: " . $rowCpt['fec_recepciontoma']. "</small>"; 
								if($rowCpt['id_estado_resul'] == "2" OR $rowCpt['id_estado_resul'] == "4"){
									echo "<br/><small>Ing. Resul.: (" . $rowCpt['user_ing_resul'] . ") " . $rowCpt['fec_ing_resul'] . "</small>";
										if($rowCpt['user_modif_resul'] <> ""){echo "<br/><small>Mod. Resul.: (" . $rowCpt['user_modif_resul'] . ") " . $rowCpt['fec_modif_resul'] . "</small>";}
										if($rowCpt['user_valid_resul'] <> ""){echo "<br/><small>Val. Resul.: (" . $rowCpt['user_valid_resul'] . ") " . $rowCpt['fec_valid_resul'] . "</small>";}
									}
								} 
							?>
						</div>
						<?php
						echo "</td>";
						echo "<td class=\"text-center\">" . $btnIng . $btnImpr;
						if($rowCpt['fec_recepciontoma'] == ""){
						?>
							<button type="button" class="btn btn-info btn-xs" onclick="reg_recepcionmuestra('<?php echo $idAtencion?>', '<?php echo $rowCpt['id_producto']?>', <?php echo $rowCpt['id']?>, <?php echo $cnt_productos?>);"><i class="glyphicon glyphicon-ok"></i></button>
						<?php 
						}
						echo "</td>";
                        echo "</tr>";
					  }
						if($cnt_productos <> 1){
							echo "<td colspan='2'><b>Ingresar o editar resultado de todos los productos que no fueron validados</b></td>";
							
							if($cnt_validado <> $cnt_productos){
								if($cnt_sin_muestra <> $cnt_productos){
									$btnIng = '<button type="button" class="btn btn-primary btn-xs tbn-ing-producto" onclick="reg_resultado(\'' . $idAtencion . '\',\'\');"><i class="glyphicon glyphicon-eject"></i></button>';
								}
							}
							echo "<td class=\"text-center\">";
							if($cnt_sin_muestra > 1){
								?>
								<button type="button" class="btn btn-primary btn-xs" onclick="reg_recepcionmuestra('<?php echo $idAtencion?>', '', '0', <?php echo $cnt_productos?>);"><i class="glyphicon glyphicon-ok"></i></button>
								<?php
							}
							echo $btnIng."</td>";
						}
                      ?>
                    </tbody>
                  </table>
                </div>
            </div>
          </div><!-- Fin Datos Personales -->
        </form>
      </div>
      <div class="col-sm-7 col-md-8">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>DATOS DE EXAMENES</strong></h3>
          </div>
          <div class="panel-body">
            <form name="frmArea" id="frmArea">
              <div id="parent">
                <table id="fixTable" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Examen</th>
                      <th>Resultado</th>
                      <th>Valor de referencia</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php
					$countP = 0;
					$rsCtp = $at->get_datosProductoPorIdAtencion($idAtencion, $id_producto, 'R');
					$ctn_producto_ing = count($rsCtp);
					foreach ($rsCtp as $rowP) {
						$countP++;
						if($countP%2==0){
							$trPColor = "success";
						} else {
							$trPColor = "";
						}
						echo '<tr class="'.$trPColor.'"><td colspan="3"><b><ins>'.$rowP['nom_producto'].':</ins></b></td></tr>';
						
						$rsG = $pn->get_datosGrupoPorIdProducto($rowP['id_producto'], 1); //Aquí valida en editar si existe o coge esta funcion
						
						foreach ($rsG as $rowG) {
							if($rowG['nom_visible'] == "SI"){
								echo '<tr class="'.$trPColor.'"><td colspan="3"><small><b>&nbsp; '.$rowG['descripcion_grupo'].'</b></small></td></tr>';
							}
							
							$rsC = $pn->get_datosComponentePorIdGrupoProdAndIdDependenciaActivo($rowG['id'], $rsA[0]['id_dependencia']); //Aquí valida en editar si existe o coge esta funcion
							
                            foreach ($rsC as $rowC) {
								$idVal = "";
								$valMin = "";
								$valMax = "";
								$desVal = "";
								$totVal = "";
                              if ($rowC['idtipo_ingresol'] == "1"){
                                echo '<tr class="'.$trPColor.'"><td style="padding-top: 1px; padding-bottom: 1px;">'.$rowC['componente'].'</td><td style="padding-top: 1px; padding-bottom: 1px;">';
                                ?>
                                <div class="form-group" style="margin-bottom: 1px;">
                                  <div class="input-group input-group-sm">
                                    <?php
									$id_compgrupoprod = $rowC['id'];
									$id_tipoingvalref = $rowC['id_tipo_val_ref'];
                                    $rsVC = $c->get_datosValidaValReferencialComp($rowC['id'], $rowC['id_tipo_val_ref'], 0, $edadAnio, $edadMes, $edadDia, $nomSexo);
									//print_r($rsVC);
                                    switch($rowC['idtipocaracter_ingresul']){
                                      case "1":
                                      $nameFunValida="";
                                      $nameFunValRef="";
                                      $totVal = nl2br($rowC['valor_ref']);
                                      break;
                                      case "2":
                                      $nameFunValida="keyValidLetter(this.id);";
                                      $nameFunValRef="";
                                      $totVal = nl2br($rowC['valor_ref']);
                                      break;
                                      case "3":
                                      $nameFunValida="keyValidNumber(this.id);";
                                      if(isset($rsVC[0][0])) {
                                        $idVal = $rsVC[0]['idcompvalref'];
                                        $valMin = $rsVC[0]['liminf'];
                                        $valMax = $rsVC[0]['limsup'];
                                        $desVal = $rsVC[0]['descripvalref'];
										if ($rsVC[0]['limsup'] == 99999){
											$totVal = "> " . number_format($rsVC[0]['liminf']) . "<br/>" . $rsVC[0]['descripvalref'];
										} else {
											if ($rsVC[0]['liminf'] == -1){
											$totVal = "< " . number_format($rsVC[0]['limsup']) . "<br/>" . $rsVC[0]['descripvalref'];
											} else {
												$totVal = number_format($rsVC[0]['liminf']) . " - " . number_format($rsVC[0]['limsup']) . "<br/>" . $rsVC[0]['descripvalref'];
											}
										}
                                        $nameFunValRef="keyValidValRef(this.id);";
                                      } else {
                                        $totVal = nl2br($rowC['valor_ref']);
                                        $nameFunValRef="";
                                      }
                                      break;
                                      case "4":
                                      switch($rowC['detcaracter_ingresul']){
                                        case "1":
                                        $nameFunValida="keyValidNumberDecimalOne(this.id);";
                                        break;
                                        case "2":
                                        $nameFunValida="keyValidNumberDecimalTwo(this.id);";
                                        break;
                                        case "3":
                                        $nameFunValida="keyValidNumberDecimalThree(this.id);";
                                        break;
                                        case "4":
                                        $nameFunValida="keyValidNumberDecimalFour(this.id);";
                                        break;
                                      }
                                      if(isset($rsVC[0][0])) {
                                        $idVal = $rsVC[0]['idcompvalref'];
                                        $valMin = $rsVC[0]['liminf'];
                                        $valMax = $rsVC[0]['limsup'];
                                        $desVal = $rsVC[0]['descripvalref'];
										if ($rsVC[0]['limsup'] == 99999){
											$totVal = "> " . number_format($rsVC[0]['liminf'], $rowC['detcaracter_ingresul'], '.', '') . "<br/>" . $rsVC[0]['descripvalref'];
										} else {
											if ($rsVC[0]['liminf'] == -1){
												$totVal = "< " . number_format($rsVC[0]['limsup'], $rowC['detcaracter_ingresul'], '.', '') . "<br/>" . $rsVC[0]['descripvalref'];
											} else {
												$totVal = number_format($rsVC[0]['liminf'], $rowC['detcaracter_ingresul'], '.', '') . " - " . number_format($rsVC[0]['limsup'], $rowC['detcaracter_ingresul'], '.', '') . "<br/>" . $rsVC[0]['descripvalref'];	
											}
										}
                                        $nameFunValRef="keyValidValRef(this.id);";
                                      } else {
                                        $totVal = nl2br($rowC['valor_ref']);
                                        $nameFunValRef="";
                                      }
                                      break;
                                      default:
                                      $nameFunValida="";
                                      $nameFunValRef="";
                                      $totVal = nl2br($rowC['valor_ref']);
                                      break;
                                    }
									if($id_tipoingvalref == "2"){
										$nameFunValRefPorcentaje = "validValRefPorcentaje(this.id);";
									} else {
										$nameFunValRefPorcentaje = "";
									}
                                    ?>
                                    <input type="text" class="form-control input-sm" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>" placeholder="" onfocus="this.select()" onkeypress="<?php echo $nameFunValida . " " . $nameFunValRefPorcentaje;?>" onblur="<?php echo trim($nameFunValRef . " " . $nameFunValRefPorcentaje);?>" value=""/>
                                    <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_idval" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_idval" value="<?php echo $idVal;?>"/>
                                    <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_inf" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_inf" value="<?php echo $valMin;?>"/>
                                    <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_sup" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_sup" value="<?php echo $valMax;?>"/>
                                    <div class="input-group-addon"><?php echo $rowC['uni_medida']?></div>
                                  </div>
                                </div>
                                <?php
                                echo '</td><td style="padding-top: 1px; padding-bottom: 1px;"><p class="help-block">'.$totVal.'</p></td></tr>';
                              } elseif ($rowC['idtipo_ingresol'] == "2") {
                                echo '<tr class="'.$trPColor.'"><td style="padding-top: 1px; padding-bottom: 1px;">'.$rowC['componente'].'</td><td style="padding-top: 1px; padding-bottom: 1px;" colspan="2">';
                                ?>
                                <div class="form-group" style="margin-bottom: 1px;">
                                  <textarea class="form-control" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>" rows="4"></textarea>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_idval" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_idval" value="<?php echo $idVal;?>"/>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_inf" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_inf" value="<?php echo $valMin;?>"/>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_sup" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_sup" value="<?php echo $valMax;?>"/>
                                </div>
                                <?php
                                echo '</td></tr>';
                              } else {
                                    $idVal = "";
                                    $valMin = "";
                                    $valMax = "";
                                    $desVal = "";
                                    $totVal = "";
								echo '<tr class="'.$trPColor.'"><td style="padding-top: 1px; padding-bottom: 1px;">'.$rowC['componente'].'</td><td style="padding-top: 1px; padding-bottom: 1px;">';
                                ?>
                                <div class="form-group" style="margin-bottom: 1px;">
								  <?php $rsSel = $c->get_listaSeleccionResultadoPorTipo($rowC['idseleccion_ingresul']); ?>
								  <select class="form-control input-sm" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>">
									<option value="" selected>-- Seleccione --</option>
									<?php
									foreach ($rsSel as $rowSel) {
									  echo "<option value='" . $rowSel['id'] . "'>" . $rowSel['nombre'] . "</option>";
									}
									?>
								  </select>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_idval" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_idval" value="<?php echo $idVal;?>"/>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_inf" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_inf" value="<?php echo $valMin;?>"/>
                                  <input type="hidden" id="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_sup" name="txt_<?php echo $rowP['id_producto']."_".$rowC['id']?>_sup" value="<?php echo $valMax;?>"/>
                                </div>
                                <?php
								$totVal = nl2br($rowC['valor_ref']);
                                echo '</td><td style="padding-top: 1px; padding-bottom: 1px;"><p class="help-block">'.$totVal.'</p></td></tr>';
                              }
                            }
						}
					}
                    ?>
                  </tfoot>
                </table>
              </div>
            </form>
          </div>
		  <div class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-center">
				  <div id="saveAtencion">
					<div class="btn-group">
					  <button class="btn btn-info btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="save_atencion('I')"><i class="fa fa-save"></i>  Guardar </button>
					  <button class="btn btn-success btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="save_atencion('IV')"><i class="fa fa-save"></i>  Guardar y validar</button>
					  <?php if($ctn_producto_ing == $rsA[0]['cnt_producto']){?>
						<button class="btn btn-primary btn-lg" id="btn-submit" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Espere" data-done-text="<i class='fa fa-save'></i> Guardar" onclick="save_atencion('IVEP')"><i class="fa fa-save"></i>  Guardar, validar y entregar a paciente</button>
					  <?php } ?>
					</div>
				  </div>
				  <div id="impriAtencion" style="display: none;">
					<div class="btn-group">
						<button class="btn btn-lg btn-success" id="btn-edit-otro-prod" onclick="open_edit()"  style="display: none;"><i class="glyphicon glyphicon-pencil"></i> Editar resultados</button>
						<button class="btn btn-lg btn-success" id="btn-edit" onclick="open_edit()"  style="display: none;"><i class="glyphicon glyphicon-pencil"></i> Editar resultados</button>
						<button class="btn btn-lg btn-primary" id="btn-imrimirall" onclick="print_resul('<?php echo md5($rsA[0]['id']);?>','<?php echo md5($rsA[0]['id_dependencia']);?>','0','<?php echo $rsA[0]['nombre_rspac']?>')"><i class="fa fa-file-pdf-o"></i> imprimir ficha de resultado</button>
					</div>
				  </div>
				</div>
			  </div>
		  </div>
        </div><!-- Fin Datos de  -->
      </div>
    </div>
  </form>
</div>
<div class="panel-footer">
  <div class="row">
    <div class="col-md-12 text-center">
		<a href="./main_principallab.php" class="btn btn-lg btn-default"><i class="glyphicon glyphicon-log-out"></i> Cancelar</a>
    </div>
  </div>
</div>
</div>
</div>

<div class="modal fade" id="mostrar_ayuda" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h2 class="modal-title">AYUDA</h2>
		</div>
		<div class="modal-body">
			<p class="text-left small" style="margin: 0 0 0px;"><b>Botones de acción</b>:<br/> <button class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-eject"></i></button>=Seleccionar producto para ingresar resultado | <button class="btn btn-success btn-xs"><i class="glyphicon glyphicon-pencil"></i></button>=Editar resultado | <button class="btn btn-warning btn-xs"><i class="fa fa-file-text-o"></i></button>=Imprimir Resultado</p>
			<hr/>
			<h5>Leyenda:</h5>
				<div class="table-responsive">
				  <table class="table table-bordered table-hover">
					<thead>
					  <tr><th><small>COLOR</small></th><th><small>DESCRIPCIÓN</small></th></tr>
					</thead>
					<tbody>
						<tr><td class="active"><small>Plomo</small></td><td><small>Muestra no recibida</small></td></tr>
						<tr><td class="info"><small>Celeste</small></td><td><small>Muestra recibida</small></td></tr>
						<tr><td class="primary"><small>Azul</small></td><td><small>Resultado ingresado pero sin validar</small></td></tr>
						<tr><td class="success"><small>Verde</small></td><td><small>Resultado validado</small></td></tr>
						<tr><td class="warning"><small>Amarrillo</small></td><td><small>Muestra derivada o referenciada a otro EESS</small></td></tr>
					</tbody>
				  </table>
				</div>
		</div>
		<div class="modal-footer">
		<button class="btn btn-default btn-block" type="button" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cerrar Ventana</button>
		</div>
	</div>
	</div>
</div>

<div id="mostrar_anexos_d" class="modal fade" role="dialog" data-backdrop="static"></div>
<?php require_once '../include/footer.php'; ?>
<script Language="JavaScript">

function open_ayuda(){
  $('#mostrar_ayuda').modal();
}

function reg_resultado(idatencion,id_prod) {
	if(id_prod == ""){
		window.location = './main_regresultadoprod.php?nroSoli='+idatencion;
	} else {
		window.location = './main_regresultadoprod.php?nroSoli='+idatencion + '&id_prod=' + id_prod;
	}
}

function imprime_resultado(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorioprodn.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function imprime_resultado_unido(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorion.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function imprime_resultado_area(idaten, iddep, idprod) {
    var urlwindow = "pdf_laboratorio_area.php?p=" + iddep + "&valid=" + idaten + "&pr=" + idprod;
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function print_resul(idAten, idDep, idProd, nomPac){
  $('#mostrar_anexos_d').modal('show');
  $.ajax({
    url: '../../controller/ctrlAtencion.php',
    type: 'POST',
    data: 'accion=GET_SHOW_PDFATENCION&idAten=' + idAten +'&idDep=' + idDep +'&idProd=' + idProd +'&nomPac=' + nomPac,
    success: function(data){
      $('#mostrar_anexos_d').html(data);
    }
  });
}

function open_pdf(idAten, opt, idAreaProd) {
  if(opt == "1"){
    var urlwindow = "pdf_laboratorio.php?id_atencion=" + idAten +"&id_area=" + idAreaProd;
  } else {
    var urlwindow = "pdf_laboratorioprod.php?id_atencion=" + idAten +"&id_prod=0";
  }
  day = new Date();
  id = day.getTime();
  Xpos = (screen.width / 2) - 390;
  Ypos = (screen.height / 2) - 300;
  eval("page" + id + " = window.open(urlwindow, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=780,height=600,left = '+Xpos+',top = '+Ypos);");
}

function open_fua(id) {
  window.location = '../fua/genera_fuaxls.php?nroAtencion='+id;
}

function open_edit() {
  var id = $('#txtIdAtencion').val();
  window.location = './main_editresultadoprod.php?nroSoli='+id;
}

function load_focus_inicio(){
  var nameInput = '';
  var AnameInput = $('#frmArea').serializeArray();
  nameInput = AnameInput[0]['name'];
  $("#" + nameInput).trigger('focus');
}

function keyValidValRef(id) {
  var valIng = $('#' + id).val();
  if (valIng != ""){
    valIng = $('#' + id).val();
    var valInf = $('#' + id + "_inf").val();
    var valSup = $('#' + id + "_sup").val();
    valIng = Number(valIng);
    valInf = Number(valInf);
    valSup = Number(valSup);
    if(valIng < valInf){//Menor
      $('#' + id).closest(".form-group").removeClass("has-warning");
      $('#' + id).closest(".form-group").addClass("has-error");
    }
    if(valIng > valSup) {//Mayor
      $('#' + id).closest(".form-group").removeClass("has-error");
      $('#' + id).closest(".form-group").addClass("has-warning");
    }
    if(valIng >= valInf && valIng <= valSup){
      $('#' + id).closest(".form-group").removeClass("has-error");
      $('#' + id).closest(".form-group").removeClass("has-warning");
    }
  } else {
    $('#' + id).closest(".form-group").removeClass("has-error");
    $('#' + id).closest(".form-group").removeClass("has-warning");
  }
}

function validValRefPorcentaje(id){
	//alert(id);
	/*var sexo = $('#txtSexoPac').val();
	var edad_anio = $('#txtEdadAnioPac').val();
	var edad_mes = $('#txtEdadMesPac').val();
	var edad_dia = $('#txtEdadDiaPac').val();
	$.post("../../controller/ctrlTipo.php", { fecha_ini: fecha_ini, fecha_fin: fecha_fin, accion: "GET_FUNC_CALCULAEDAD" }, function(data){
		var datos = eval(data);
		$("#txtEdadPac").val(datos[0]);
	});*/
}

function reg_recepcionmuestra(id, pac, opt, cntprod) {
	if(opt == "0"){
		bootbox.confirm({
		message: "Se <b class='text-danger'>recibirá</b> todas las muestras de los examenes solicitados. <br/>Paciente: <b>"+pac+"</b><br/>¿Está seguro de continuar?",
		buttons: {
		  confirm: {
			label: '<i class="fa fa-check"></i> Si',
			className: 'btn-success'
		  },
		  cancel: {
			label: '<i class="fa fa-times"></i> No',
			className: 'btn-danger'
		  }
		},
		callback: function (result) {
		  if (result == true) {
			var parametros = {
			  "accion": "POST_REG_RECEPCIONMUESTRA",
			  "id_atencion": id,
			  "id_productoaten": 0,
			  "cnt_producto": cntprod
			};
			$.ajax({
			  data: parametros,
			  url: '../../controller/ctrlAtencion.php',
			  type: 'post',
			  success: function (rs) {
					window.location = './main_editresultadoprod.php?nroSoli='+id;
			  }
			});
		  } else {
			$('#btn-submit').prop("disabled", false);
		  }
		}
		});
	} else {
		var parametros = {
		  "accion": "POST_REG_RECEPCIONMUESTRA",
		  "id_atencion": id,
		  "id_productoaten": opt,
		  "cnt_producto": cntprod
		};
		$.ajax({
		  data: parametros,
		  url: '../../controller/ctrlAtencion.php',
		  type: 'post',
		  success: function (rs) {
			window.location = './main_editresultadoprod.php?nroSoli='+id + '&id_prod=' + pac;
		  }
		});
	}
}

function save_atencion(opt) {
  $('#btn-submit').prop("disabled", true);
  var msg = "";
  var sw = true;

  var AnameInput = $('#frmArea').serializeArray();
  var ing = "";
  len = AnameInput.length;
  for (i=0; i<len; i++) {
    nameInput = AnameInput[i]['name'];
    var arrayCadenas = nameInput.split('_');
    if(arrayCadenas.length == 3){
      if($("#" + nameInput).val().trim() != ""){
        ing = "1";
        break;
      }
    }
  }

  if(ing == ""){
    msg += "Ingrese la información de almenos un exámen<br/>";
    sw = false;
  }

  if (sw == false) {
    bootbox.alert(msg);
    $('#btn-submit').prop("disabled", false);
    return false;
  }

  bootbox.confirm({
    message: "Se registrarán los registros ingresados, ¿Está seguro de continuar?",
    buttons: {
      confirm: {
        label: 'Si',
        className: 'btn-success'
      },
      cancel: {
        label: 'No',
        className: 'btn-danger'
      }
    },
    callback: function (result) {
      if (result == true) {

        $.ajax( {
          type: 'POST',
          url: '../../controller/ctrlLab.php',
          data: $('#frmArea').serialize()
          + "&id_atencion=" + $('#txtIdAtencion').val() + "&txt_id_producto_selec=" + $('#txt_id_producto_selec').val() + "&txtNroRefAtencion=" + $('#txtNroRefAtencion').val() + "&accion_sp=" + opt
          + "&accion=POST_REG_RESULTADOLAB",
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
			  window.location = './main_editresultadoprod.php?nroSoli=' + $('#txtIdAtencion').val();
              /*var AnameInput = $('#frmArea').serializeArray();
              var ing = "";
              len = AnameInput.length;
              for (i=0; i<len; i++) {
                nameInput = AnameInput[i]['name'];
                $("#" + nameInput).prop("disabled", true);
              }
			  $(".tbn-ing-producto").prop("disabled", true);

              $("#saveAtencion").hide();
              $("#impriAtencion").show();
			  if (opt == 'I'){
				  $("#btn-edit").show();
				  $("#btn-imrimirall").hide();
			  } else {
				   if($('#txt_id_producto_selec').val() != "0"){
					  $("#btn-edit-otro-prod").show();
				   }
				  $("#btn-edit").hide();
			  }
              bootbox.alert("El resultado se guardo correctamente.");
              return false;*/
            } else {
              $('#btn-submit').prop("disabled", false);
              showMessage(msg, "error");
              return false;
            }
          }
        });
      } else {
        $('#btn-submit').prop("disabled", false);
      }
    }
  });
}

$(document).ready(function() {
  $("#fixTable").tableHeadFixer();
  setTimeout(function(){load_focus_inicio();}, 2);
});

</script>
<?php require_once '../include/masterfooter.php'; ?>
