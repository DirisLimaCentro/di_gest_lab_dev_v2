<?
//session_start();
if (!isset($_SESSION["accessauthority"])){
	header("location:../index.php");
	exit();}
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
		<!-- BOOTSTRAP -->
		<!-- Latest compiled and minified CSS
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">-->

		<!-- Optional theme -->
		<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript
		<script src="../bootstrap/js/bootstrap.min.js"></script>-->
		<link rel="stylesheet" href="../dist/css/sweetalert.css">
		<link rel="stylesheet" href="../dist/css/Montserrat.css?family=Montserrat:400,700,200"  />
		<style>
		body{color:#2c2c2c;font-size:14px;font-family:Montserrat,Helvetica Neue,Arial,sans-serif;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased}

		.navbar {
    	background-color: #f6bb5a  !important;
		}

		li.user-header {
    	background-color: #f6bb5a   !important;
		}


		.modal-header-success {
			color:#fff;
			padding:9px 15px;
			border-bottom:1px solid #eee;
			background-color: #5cb85c;

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

		<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
		<script type="text/javascript" src="../plugins/datatables/dataTables.checkboxes.min.js"></script>

		<body class="skin-blue sidebar-mini sidebar-collapse">
			<div class="wrapper">
				<? include "mainHeader.php"; ?>
				<!-- Left side column. contains the logo and sidebar -->
				<? include "mainMenu.php"; ?>
				<!-- Content Wrapper. Contains page content -->
				<div class="content-wrapper">
					<!-- Content Header (Page header) -->
					<section class="content-header">
			      <h1>
			        Recepción de HT
			        <small></small>
			      </h1>
			      <ol class="breadcrumb" style="font-size:14px;">
							<label class="text-red">Acciones :</label>
							<li><a href="#"><i class="fa fa-eye"></i> = Mostrar Traza de HT </a></li>
			      </ol>
			    </section>
					<section class="content">
						<div class="box box-default">

							<div class="box-body">
								<div class="row">
									<div class="col-md-12">
										<form class="" id="frm-example" method="POST">
											<div class="">
											<table id="example" class="display" cellspacing="0" width="100%">
												<thead>
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
											<button  class="btn btn-default">Recepcionar HT</button>
											<button onClick="xlsporrecibir();" class="btn btn-default">Descargar Lista</button>
											<a style="visibility:hidden;" target="_blank" id="aDwn" name="aDwn"  href="#" accesskey="j"></a>
											<pre id="example-console-rows" style="display:none;"></pre>
											<pre id="example-console-form" style="display:none;"></pre>
										</form></div>
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</body>
			<!-- jQuery 2.2.3 -->

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


			<script src="../dist/js/funcionesjava.js"></script>
			<!--<script src="../dist/js/main.js"></script>-->
			<script src="../dist/js/recepcion.js"></script>

			<script type='text/javascript'>//<![CDATA[

				$(document).ready(function() {
					var table = $('#example').DataTable({
						"lengthMenu": [[10, 25, 50, 100 ,250], [10, 25, 50, 100 ,250, "All"]],
						"sAjaxSource": "ajaxRecepcion.php", // Load Data
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
						'ajax': 'ajaxRecepcion.php',
						'columnDefs': [
							{
								'targets': 0,
								'checkboxes': {
									'selectRow': true
								}
							}
						],
						'select': {
							'style': 'multi'
						},
						'order': [[1, 'asc']]
					});

					// Handle form submission event
					$('#frm-example').on('submit', function(e){
						var form = this;

						var rows_selected = table.column(0).checkboxes.selected();

						// Iterate over all selected checkboxes
						$.each(rows_selected, function(index, rowId){
							// Create a hidden element
							$(form).append(
								$('<input>')
								.attr('type', 'hidden')
								.attr('name', 'id[]')
								.val(rowId)
							);
						});
						// FOR DEMONSTRATION ONLY
						// The code below is not needed in production
						// Output form data to a console
						$('#example-console-rows').text(rows_selected.join(","));

						// Output form data to a console
						$('#example-console-form').text($(form).serialize());

						// Remove added elements
						$('input[name="id\[\]"]', form).remove();

						// Prevent actual form submission
						e.preventDefault();
						Recepcionar();
					});
					$('#example').removeClass('display').addClass('table table-striped table-bordered');
					$('#example tfoot th').each(function () {

						//Agar kolom Action Tidak Ada Tombol Pencarian
						if ($(this).text() != "" && $(this).text() != "Acción" && $(this).text() != "Fecha Deriva" && $(this).text() != "Folios" && $(this).text() != "Estado" && $(this).text() != "Estado") {
							var title = $('#example thead th').eq($(this).index()).text();
							$(this).html('<input class="form-control input-sm" type="text" placeholder="Buscar ' + title + '" style="width:100%;" />');
						}
					});
					// Untuk Pencarian, di kolom paling bawah
					/*table.columns().every(function () {
						var that = this;
						$('input', this.footer()).on('keyup change', function () {
							that
							.search(this.value)
							.draw();
						});
					});*/
				});
				//]]>
				</script>
				<script>
				// tell the embed parent frame the height of the content
				if (window.parent && window.parent.parent){
					window.parent.parent.postMessage(["resultsFrame", {
						height: document.body.getBoundingClientRect().height,
						slug: "snqw56dw"
					}], "*")
				}
				</script>
			</body>
			</html>
