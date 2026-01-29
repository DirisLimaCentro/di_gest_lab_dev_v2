<?
session_start();
if (!isset($_SESSION["accessauthority"])){
	header("location:../index.php");
	exit();}
	/*require_once '../model/Equipos.php';*/
	require_once '../model/Dependencias.php';
	require_once '../model/Tablas.php';
	/*require_once '../model/Personal.php';
	$equ = new Equipos();*/
	$dep = new Dependencia();
	$tab = new Tablas();
	//$per = new Personal();
	?>
	<!DOCTYPE html>
	<html><head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>DIRIS</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="../bootstrap/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="../bootstrap/css/ionicons.min.css">
		<!-- daterange picker -->
		<link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
		<!-- bootstrap datepicker -->
		<link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
		<!-- iCheck for checkboxes and radio inputs -->
		<link rel="stylesheet" href="../plugins/iCheck/all.css">
		<!-- Bootstrap Color Picker -->
		<link rel="stylesheet" href="../plugins/colorpicker/bootstrap-colorpicker.min.css">
		<!-- Bootstrap time Picker -->
		<link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
		<!-- Select2 -->
		<link rel="stylesheet" href="../plugins/select2/select2.min.css">
		<!-- DataTables -->
		<link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
		<link rel="stylesheet" href="../plugins/datatables/extensions/Responsive/css/dataTables.responsive.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
		<!--<link rel="stylesheet" href="../dist/css/theme_1.css">-->
		<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
		<!-- dropzone -->
		<link href="../plugins/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
		<!-- multiselect -->
		<!--<link rel="stylesheet" href="../plugins/multiselect/jquery.multiselect.css">-->
		<link rel="stylesheet" href="../plugins/multiselect/bootstrap-multiselect.css">

		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- JQUERY -->
		<script type="text/javascript" language="javascript" src="../plugins/datatables/jquery.js"></script>
		<!-- Optional theme -->
		<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript
		<script src="../bootstrap/js/bootstrap.min.js"></script>-->
		<link rel="stylesheet" href="../dist/css/sweetalert.css">
		<link rel="stylesheet" href="../dist/css/Montserrat.css?family=Montserrat:400,700,200"  />
		<style>
		body{color:#2c2c2c;font-size:14px;font-family:Montserrat,Helvetica Neue,Arial,sans-serif;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased}
		.navbar {
    	background-color: #e05a48   !important;
		}

		li.user-header {
    	background-color: #e05a48   !important;
		}


		input,textarea {
			text-transform: uppercase;
		}
		.modal-header-success {
			color:#fff;
			padding:9px 15px;
			border-bottom:1px solid #eee;
			background-color: #e05a48;
		}

		.select2{
			line-height:1.42857  !important;
		}

		.modal-lg {
			width: 1270px;
		}
		</style>
		<!-- DataTables
		<link rel="stylesheet" type="text/css" href="../plugins/datatables/dataTables.bootstrap.css">-->
		<script type="text/javascript" language="javascript" src="../plugins/datatables/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="../plugins/datatables/extensions/Responsive/js/dataTables.responsive.js"></script>
		<script type="text/javascript" language="javascript" src="../plugins/datatables/dataTables.bootstrap.js"></script>
		<script type="text/javascript" language="javascript" src="../dist/js/common.js"></script>


		<body class="skin-blue sidebar-mini sidebar-collapse">
			<div class="wrapper">
				<? include "mainHeader.php"; ?>
				<!-- Left side column. contains the logo and sidebar -->
				<? include "mainMenu.php"; ?>
				<!-- Content Wrapper. Contains page content -->
				<div class="content-wrapper">
					<section class="content-header">
			      <h1>
			        Derivación de HT
			        <small></small>
			      </h1>
			      <ol class="breadcrumb" style="font-size:14px;">
							<label class="text-red">Acciones :</label>
							<li><a href="#"><i class="fa fa-flag"></i> = Finalizar HT </a></li>
							<li><a href="#"><i class="fa fa-eye"></i> = Mostrar Traza de HT </a></li>
							<li><a href="#"><i class="fa fa-cog"></i> = Agregar Observación </a></li>
			      </ol>
			    </section>
					<!-- Content Header (Page header) -->
					<section class="content">
						<div class="box box-default">
							<div class="box-header with-border">
								<!--<h3 class="box-title">Derivación de HT</h3>-->
								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
									<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-md-12">
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<form class="" id="formUser">
											<div class="">
											<table id="tblenvios" class="display" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th><input name="select_all" value="1" id="tblenvios-select-all" type="checkbox" /></th>
														<th>Nro HT</th>
														<th>Tipo tramite</th>
														<th>Tipo Doc.</th>
														<th>Documento</th>
														<th>Fecha Deriva</th>
														<th>Asunto</th>
														<th>Solicitante</th>
														<th>Remitente</th>
														<th>Dep. Deriva</th>
														<th>Folios</th>
														<th>Acción</th>
														<th>Estado</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
												<tfoot>
													<tr>
														<th></th>
														<th>Nro HT</th>
														<th>Tipo tramite</th>
														<th>Tipo Doc.</th>
														<th>Documento</th>
														<th>Fecha Deriva</th>
														<th>Asunto</th>
														<th>Solicitante</th>
														<th>Remitente</th>
														<th>Dep. Deriva</th>
														<th>Folios</th>
														<th>Acción</th>
														<th>Estado</th>
													</tr>
												</tfoot>
											</table>
										</div>
											<button id="showmodal" type="button" onClick="ShowEnvio();" class="btn btn-default">Derivar HT</button>
											<button id="showmodal" type="button" onClick="showFinishBlock();" class="btn btn-default">Finalizar en bloque</button>
											<button id="showmodal" type="button" onClick="xlsrecibidos();" class="btn btn-default">Descargar Lista</button>
											<a style="visibility:hidden;" target="_blank" id="aDwn" name="aDwn"  href="#" accesskey="j"></a>
										</form>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</body>
		<div id="div_error"></div>

		<div id="myModal_sendall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title  text-green"><i class="fa fa-warning"></i> Envio en bloque </h4>
					</div>
					<div class="modal-body">
						<div class="modal-body">
							<div class="row text-center">
								<h4 id="myModalLabelupd" ></h4>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label class="control-label" for="inputWarning">Usuario: </label>
									<? echo $_SESSION['login']; ?>
									<input type="hidden" id="txtidusuario" name="txtidusuario"class="form-control input-sm" value="<? echo $_SESSION['id_usuario'];?>" >
									<input type="hidden" id="txtlogin" name="txtlogin"class="form-control input-sm" value="<? echo $_SESSION['login'];?>" >
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label" for="inputWarning">Acción</label>
										<select class="form-control  input-sm" style="width: 100%;" name="cbotipoaccionall" id="cbotipoaccionall" >
											<!--<option value="*">--Seleccione Acción--</option>-->
											<option value='3'>Derivar</option>
											<option value='4'>Observar</option>
											<option value='7'>Subsanar</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label" for="inputWarning">Destinatario Oficina &nbsp;&nbsp;&nbsp; </label>
										<select id="cbodestinatarioall" name="cbodestinatarioall" class="form-control  input-sm" >
											<option value="*">--Seleccione Destinatario--</option>
											<?
											$rs=$dep->listaDependencias('');
											//$rs=$dep->listaDependencias($_SESSION["peso"]);
											foreach ($rs as $row) {
												echo "<option value='".$row['id_dep']."'>".$row['nom_dep']."</option>";}  ?>
											</select><? //echo $_SESSION["peso"]."-".$_SESSION["id_dep"];?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label" for="inputWarning">Personal </label>
											<div id="region_personalall">
												<select class="form-control input-sm js-personal" style="width: 100%;" name="cboidpersonalall" id="cboidpersonalall" >
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
							<button type="button" id="submit-detail" onclick="sendAllPer();" class="btn btn-success">Enviar</button>
						</div>
					</div>
				</div>
			</div>

			<div id="ModalFinishHT" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-m">
					<div class="modal-content">
						<div class="modal-header modal-header-success">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" id="titlefinish">Archivar</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<div class="togglebutton">
										<label> Activalo si es un Pago !
											<input id="chkdoc" class="blank" onclick="acti_inputs();"  type="checkbox" value="true"   name="chkdoc" data-val="false" >
											<span class="toggle"></span>
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label class="control-label" for="inputWarning">Nro Doc. Pago</label>
									<input disabled name="txtnrodocpago" id="txtnrodocpago" type="text" value="" class="form-control">
								</div>
								<div class="col-md-6">
									<label class="control-label" for="inputWarning">Fecha de Pago </label><br>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" disabled class="form-control pull-right input-sm" id="idfecregister" >
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<label class="control-label" for="inputWarning">Observación</label>
									<input  name="txtnrohtfinish" id="txtnrohtfinish" type="hidden" value="">
									<textarea  id="txtobsarchivo" name="txtobsarchivo"  class="form-control" rows="3" placeholder=""></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
								<button type="button" onclick="savefinishHt();" class="btn btn-default" >Grabar</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="ModalFinishHTall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-m">
					<div class="modal-content">
						<div class="modal-header modal-header-success">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" id="titlefinishall">Finalizar en Bloque</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<label class="control-label" for="inputWarning">Observación </label>
									<input  name="txtnrohtfinishall" id="txtnrohtfinishall" type="hidden" value="">
									<textarea  id="txtobsarchivoall" name="txtobsarchivoall"  class="form-control" rows="3" placeholder="Observacion ..."></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-danger" data-dismiss="modal" type="button">Cerrar</button>
								<button type="button" onclick="saveFinishBlock();" class="btn btn-success" >Grabar</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="ModalObs" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-m">
					<div class="modal-content">
						<div class="modal-header modal-header-success">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" id="titleObs">Observar</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<label class="control-label" for="inputWarning">Ingresar Observacion</label>
									<input  name="txtnrohtobs" id="txtnrohtobs" type="hidden" value="">
									<input  name="txtaction" id="txtaction" type="hidden" value="">
									<textarea  id="txtobsarchivoo" name="txtobsarchivoo"  class="form-control" rows="3" placeholder=""></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
								<button type="button" onclick="saveObsHt();" class="btn btn-default" >Grabar</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="myModal_Envios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header modal-header-success">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Derivar HT N° <label id="lbltitltederivados"></label></h4>
						</div>
						<form name="wcaptcha" method="post">
							<div class="modal-body">
								<div class="row column-seperation">
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<form class="" id="formUser">
													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<label class="control-label" for="inputWarning">Tipo de Tramite </label>
																<input  name="txtidproc_ht" id="txtidproc_ht" type="hidden" value="">
																<input  name="txtanio_ht" id="txtanio_ht" type="hidden" value="">
																<input  name="txtnro_ht" id="txtnro_ht" type="hidden" value="">
																<input  name="txtnro_mov" id="txtnro_mov" type="hidden" value="">
																<input  name="txtiddeporigen" id="txtiddeporigen" type="hidden" value="<? echo $_SESSION['id_dep']; ?>">
																<input  name="txtidusrorigen" id="txtidusrorigen" type="hidden" value="<? echo $_SESSION['id_usuario']; ?>">
																<input  name="txtidNewFile" id="txtidNewFile" type="hidden" value="<? echo date('Ymdhis'); ?>" readonly>
																<input  name="txtcantUploads" id="txtcantUploads" type="hidden" value="0" readonly>
																<select class="selectpicker show-tick form-control input-sm" data-live-search="true" name="cbotipotramite" id="cbotipotramite" >
																	<option value="*">--Seleccione Tramite--</option>
																	<option value="0" selected>No TUPA</option>
																</select>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label class="control-label" for="inputWarning">Tipo de Documento </label>
																<select class="selectpicker show-tick form-control input-sm" data-live-search="true" name="cbotipodoc" id="cbotipodoc" >
																	<option value="*">--Seleccione Documento--</option>
																	<?
																	$rs=$tab->listaTablas('11');
																	foreach ($rs as $row) {
																		echo "<option value='".$row['id_tipo']."'>".$row['descripcion']."</option>";} ?>
																	</select>
																</div>
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label class="control-label" for="inputWarning">Nro Documento</label>
																	<input class="form-control  input-sm" placeholder="Nro Documento" id="txtnrodocumento" name="txtnrodocumento" type="text">
																</div>
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label class="control-label" for="inputWarning">Acción</label>
																	<select class="form-control" style="width: 100%;" name="cbotipoaccion" id="cbotipoaccion" >
																		<!--<option value="*">--Seleccione Acción--</option>-->
																		<option value='3'>Derivar</option>
																		<option value='4'>Observar</option>
																		<option value='7'>Subsanar</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label" for="inputWarning">Asunto</label>
																	<textarea  id="txtasunto" name="txtasunto"  class="form-control" rows="3" placeholder="Asunto ..."></textarea>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label" for="inputWarning">Observación</label>
																	<textarea  id="txtobservacion" name="txtobservacion"  class="form-control" rows="3" placeholder="Observación ...">.</textarea>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-4">
																<div class="form-group">
																	<!--<label class="control-label" for="inputWarning">Destinatario Oficina &nbsp;&nbsp;&nbsp; <? if($_SESSION['id_rol']!=5){ echo "/ &nbsp;&nbsp;&nbsp;[CC]&nbsp;&nbsp;";}?></label>-->
																	<label class="control-label" for="inputWarning">D. Destino  <? if($_SESSION['id_rol']!=5){ echo "/ [CC]";}?></label>
																	<!--<select class="form-control input-sm js-destino" style="width: 100%;"  name="cbodestinatario" id="cbodestinatario" >-->
																	<? if($_SESSION['id_rol']!=5){ ?>
																		<label class="control-label" for="inputWarning">
																			<div class="togglebutton">
																				<label>
																					<input id="chkdoccp" class="blank" onclick="refresh_cboidep();"    type="checkbox" value="true"   name="chkdoccp" data-val="false" >
																					<span class="toggle"></span>
																				</label>
																			</div>
																		</label>
																	<? } ?>
																	<select id="cbodestinatario" name="cbodestinatario" class="form-control  input-sm" multiple="">
																		<!--<option value="*">--Seleccione Destinatario--</option>-->
																		<?
																		$rs=$dep->listaDependencias();
																		//$rs=$dep->listaDependencias($_SESSION["peso"]);
																		foreach ($rs as $row) {
																			echo "<option value='".$row['id_dep']."'>".$row['nom_dep']."</option>";}  ?>
																		</select><? //echo $_SESSION["peso"]."-".$_SESSION["id_dep"];?>
																	</div>
																</div>
																<div class="col-md-3">
																	<div class="form-group">
																		<label class="control-label" for="inputWarning">Personal </label>
																		<div id="region_personal">
																			<select class="form-control input-sm js-personal" style="width: 100%;" name="cboidpersonal" id="cboidpersonal" >
																			</select>
																		</div>
																	</div>
																</div>
																<div class="col-md-5">
																	<div class="form-group">
																		<label class="control-label" for="inputWarning">Indicación</label>
																		<select class="form-control" style="width: 100%;" multiple="multiple" name="cboaccion" id="cboaccion" >
																			<!--<option value="*">--Seleccione Acción--</option>-->
																			<?
																			$rs=$tab->listaTablasRegister('18');
																			foreach ($rs as $row) {
																				echo "<option value='".$row['id_tipo']."'>".$row['id_tipo']."-".$row['descripcion']."</option>";}  ?>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="row">
																	<div class="col-md-3">
																		<div class="form-group">
																			<label class="control-label" for="inputWarning">Prioridad </label>
																			<select class="selectpicker show-tick form-control input-sm" data-live-search="true" name="cboprioridad" id="cboprioridad" >
																				<option value="*">--Seleccione Prioridad--</option>
																				<?
																				$rs=$tab->listaTablas('13');
																				foreach ($rs as $row) {
																					echo "<option value='".$row['id_tipo']."'>".$row['descripcion']."</option>";} ?>
																				</select>
																			</div>
																		</div>
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="control-label" for="inputWarning">Folios </label>
																				<input class="form-control text-right input-sm" placeholder="" id="txtfolio" name="txtfolio" type="number">
																			</div>
																		</div>
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="control-label" for="inputWarning">Clasificación </label>
																				<select class="selectpicker show-tick form-control input-sm" data-live-search="true" name="cboclasificacion" id="cboclasificacion" >
																					<option value="*">--Seleccione Clasificación--</option>
																					<?
																					$rs=$tab->listaTablas('12');
																					foreach ($rs as $row) {
																						echo "<option value='".$row['id_tipo']."'>".$row['descripcion']."</option>";} ?>
																					</select>
																				</div>
																			</div>
																			<div class="col-md-3">
																				<div class="form-group">
																					<label class="control-label" for="inputWarning">Nro HT Externo </label>
																					<input class="form-control text-right input-sm" placeholder="Nro HT Externo" id="txtnromparte" name="txtnromparte" type="number">
																				</div>
																			</div>
																		</div>
																		<div class="row" style="display:none;">
																			<div class="col-md-2">
																				<div class="form-group">
																					<label class="control-label" for="inputWarning">Monto </label>
																					<input class="form-control text-right input-sm" id="txtpenpago_mov" name="txtpenpago_mov">
																				</div>
																			</div>
																			<div class="col-md-2">
																				<div class="form-group">
																					<label class="control-label" for="inputWarning">Total CG </label>
																					<input class="form-control text-right input-sm" id="txttotcgar_mov" name="txttotcgar_mov">
																				</div>
																			</div>
																		</div>
																	</form>
																</div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="image_upload_div">
																<form action="" method="post" class="dropzone" id="my-dropzone">
																</form>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button class="btn btn-danger" data-dismiss="modal" type="button">Cerrar</button>
														<button type="button" id="submit-detail" onclick="saveMovimiento();" class="btn btn-success" >Grabar</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>

									<!-- jQuery 2.2.3 -->
									<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
									<!-- Bootstrap 3.3.6 -->
									<script src="../bootstrap/js/bootstrap.min.js"></script>
									<!-- Select2 -->
									<script src="../plugins/select2/select2.full.min.js"></script>
									<!-- InputMask -->
									<script src="../plugins/input-mask/jquery.inputmask.js"></script>
									<script src="../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
									<script src="../plugins/input-mask/jquery.inputmask.extensions.js"></script>
									<!-- date-range-picker -->
									<script src="../dist/js/moment.min.js"></script>
									<script src="../plugins/daterangepicker/daterangepicker.js"></script>
									<!-- bootstrap datepicker -->
									<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
									<!-- bootstrap color picker -->
									<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
									<!-- bootstrap time picker -->
									<script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
									<!-- DataTables -->
									<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
									<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
									<script src="../plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
									<!-- SlimScroll 1.3.0 -->
									<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
									<!-- iCheck 1.0.1 -->
									<script src="../plugins/iCheck/icheck.min.js"></script>
									<!-- FastClick -->
									<script src="../plugins/fastclick/fastclick.js"></script>
									<!-- AdminLTE App -->
									<script src="../dist/js/app.min.js"></script>
									<!-- AdminLTE for demo purposes -->
									<script src="../dist/js/demo.js"></script>
									<!-- dropzone -->
									<script src="../plugins/dropzone/dropzone.js"></script>
									<!-- multiselect -->
									<!--<script src="../plugins/multiselect/jquery.multiselect.js"></script>-->
									<script src="../plugins/multiselect/bootstrap-multiselect.js"></script>

									<script src="../dist/js/funcionesjava.js"></script>
									<!--<script src="../dist/js/main.js"></script>-->
									<script src="../dist/js/envio.js"></script>
									<link href="../plugins/datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet"/>
									<script src="../plugins/datetimepicker/moment-with-locales.js"></script>
									<script src="../plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script>
									<script type='text/javascript'>//<![CDATA[

										$(document).ready(function (){
											var table = $('#tblenvios').DataTable({
												"lengthMenu": [[10, 25, 50, 100 ,250], [10, 25, 50, 100 ,250, "All"]],
												"sAjaxSource": "ajaxEnvio.php", // Load Data
												"language": {
													"url": "../plugins/datatables/Spanish.json",
													"lengthMenu": '_MENU_ entries per page',
													"search": '<i class="fa fa-search"></i>',
													"paginate": {
														"previous": '<i class="fa fa-angle-left"></i>',
														"next": '<i class="fa fa-angle-right"></i>'
													}
												},
												initComplete: function () {
													table.columns().every( function () {
														var that = this;
														$( 'input', this.footer() ).on( 'keyup change', function () {
															that
															.search( this.value )
															.draw();
														} );
													} );
							},
												'columnDefs': [{
													'targets': 0,
													'searchable':false,
													'orderable':false,
													'className': 'dt-body-center',
													/*'checkboxes': {
													'selectRow': true
												},*/
												'columnDefs': [
													{"orderable": false, "targets": 0, "searchable": false},
													{"orderable": true, "targets": 1, "searchable": true},
													{"orderable": true, "targets": 2, "searchable": true},
													{"orderable": true, "targets": 3, "searchable": true},
													{"orderable": true, "targets": 4, "searchable": true}
												],
												'render': function (data, type, full, meta){
													return '<input type="checkbox" onclick="this.parentNode.parentNode.style.backgroundColor = this.checked ? \'#88b3d6\' : \'#ffffff\';" name="chk_idht[]" value="' + $('<div/>').text(data).html() + '">';
													//return '<button>Click!</button>';
												}
											}],
											'order': [1, 'asc']
										});
										/*$('#tblenvios tbody').on( 'click', 'button', function () {
										var data = table.row( $(this).parents('tr') ).data();
										alert( data[1] +"'aaa"+ data[ 3 ] );
									} );*/
									// Handle click on "Select all" control
									$('#tblenvios-select-all').on('click', function(){
										// Check/uncheck all checkboxes in the table
										var rows = table.rows({ 'search': 'applied' }).nodes();
										$('input[type="checkbox"]', rows).prop('checked', this.checked);
									});

									// Handle click on checkbox to set state of "Select all" control
									$('#tblenvios tbody').on('change', 'input[type="checkbox"]', function(){
										// If checkbox is not checked
										if(!this.checked){
											var el = $('#tblenvios-select-all').get(0);
											// If "Select all" control is checked and has 'indeterminate' property
											if(el && el.checked && ('indeterminate' in el)){
												// Set visual state of "Select all" control
												// as 'indeterminate'
												el.indeterminate = true;
											}
										}
									});
									$('#tblenvios').removeClass('display').addClass('table table-striped table-bordered');
									$('#tblenvios tfoot th').each(function () {
										//Agar kolom Action Tidak Ada Tombol Pencarian
										if ($(this).text() != "" && $(this).text() != "Acción" && $(this).text() != "Fecha Deriva" && $(this).text() != "Folios" && $(this).text() != "Estado" && $(this).text() != "Estado") {
											var title = $('#tblenvios thead th').eq($(this).index()).text();
											$(this).html('<input class="form-control input-sm" type="text" placeholder="Buscar ' + title + '" style="width:100%;" />');
										}
									});
									// Untuk Pencarian, di kolom paling bawah

									$('#formUser').on('submit', function(e){
										var form = this;
										// Iterate over all checkboxes in the table
										table.$('input[type="checkbox"]').each(function(){
											// If checkbox doesn't exist in DOM
											if(!$.contains(document, this)){
												// If checkbox is checked
												if(this.checked){
													// Create a hidden element
													$(form).append(
														$('<input>')
														.attr('type', 'hidden')
														.attr('name', this.name)
														.val(this.value)
													);
												}
											}
										});
										// FOR TESTING ONLY
										/*// Output form data to a console*/
										$('#tblenvios-console').text($(form).serialize());
										console.log("Form submission", $(form).serialize());
										//alert("Form submission"+ $(form).serialize());
										// Prevent actual form submission
										e.preventDefault();
									});
								});
								//]]>
								</script>
							</body>
							</html>
