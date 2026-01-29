<?php

session_start();
if (!isset($_SESSION["labAccess"])) {
  header("location:../../");
  exit();
}
if ($_SESSION["labAccess"] <> "Yes") {
  header("location:../../");
  exit();
}

if ($_SESSION['labIdDepUser'] <> "") {
  header("location:./");
  exit();
}

require_once '../../model/Usuario.php';
$u = new Usuario();

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximugm-scale=1, user-scalable=no" name="viewport">
		<title>DIRIS - SRALAB</title>
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="../../assets/css/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css"/>
		<!-- Font Awesome -->
		<link rel="stylesheet" href="../../assets/font-awesome/css/font-awesome.min.css" type="text/css"/>
		<!-- CSS Core Style -->
		<link rel="stylesheet" href="../../assets/css/style.css" type="text/css"/>
		<style>
			.bodyLogin {
			  background-color: #367fa9;
			}
			.login-box, .register-box {
				margin: 7% auto;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid">
		  <div class="col-sm-12">
			<div class="col-md-offset-3 col-md-6">
			<div class="login-box">
			  <div class="panel-prime">
				<div class="panel-body">
					<h3 class="display-1 text-bold text-center" style="color: #40AB4B;">BIENVENIDA(O) <?php echo "(".$_SESSION['labNomUser']. ")";?></h3>
					<hr/>
					<form action="controller/ctrlLogin.php" method="post" autocomplete="off" id="form_login">
						<label for="txtIdDep">Seleccione dependencia:</label>
						<div class="input-group" style="padding-bottom:15px;">
							<select id="txt_id_dependencia" class="form-control" onchange="">
							<?php $rsD = $u->get_RolUserPorDep($_SESSION['labIdUser']); ?>
							  <option value="" selected="">-- Seleccione --</option>
							  <?php
							  foreach ($rsD as $row) {
								echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
							  }
							  ?>
							</select>
							<div class="input-group-addon"><i class="fa fa-university"></i></div>
						</div>
						<!--<label for="txtIdDep">Seleccione servicio:</label>
							<div class="input-group" style="padding-bottom:15px;">
							<select id="txt_id_servicio_profesional" class="form-control">
								<option> -- Seleccione --</option>
							</select>
							<div class="input-group-addon"><i class="fa fa-user-md"></i></div>
							</div>-->
						<div>
							<button class="btn btn-primary btn-block" type="button" id="btnLogin" onclick="login();">Ingresar &nbsp;</button>
						</div>
					</form>
				</div>
			  </div>
			  </div>
			</div>
		  </div>
			<footer>
				<div class="col-sm-12 text-center">
					<strong>Copyright &copy; 2019 <a href="#">DIRIS - LIMA CENTRO</a></strong> todos los derechos reservados.<br/>
					<strong>Oficina de Tecnologías de la Información<br/></strong>
				</div>
			</footer>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script type="text/javascript" src="../../assets/css/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!--bootbox-->
		<script type="text/javascript" src="../../assets/plugins/bootbox/bootbox.min.js"></script>
		<script>
			function login() {
				$('#btnLogin').prop("disabled", true);
				var id_dependencia = $('#txt_id_dependencia').val();

				if (id_dependencia == ""){
					bootbox.alert("Sellecione una dependencia");
					$('#btnLogin').prop("disabled", false);
					return false;
				}
				$.ajax({
					url: "../../controller/ctrlLogin.php",
					type: "POST",
					data: {
						accion: 'POST_LOGIN_ROLPORDEP', id_dependencia: id_dependencia
					},
					success: function (result) {
						if(result == ""){
							window.location = "./index.php";
						} else {
							bootbox.alert("Ocurrio un error...");
							$('#btnLogin').prop("disabled", false);
						}
					}
				});
			}
		</script>
	</body>
</html>
