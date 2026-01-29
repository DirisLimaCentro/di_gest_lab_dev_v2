<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximugm-scale=1, user-scalable=no" name="viewport">
  <title>DIRIS - SRALAB</title>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="./assets/css/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css"/>
  <!-- Theme style -->
  <link rel="stylesheet" href="./assets/css/adminlte/2.3.2/AdminLTE.min.css" type="text/css"/>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./assets/font-awesome/css/font-awesome.min.css" type="text/css"/>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./assets/css/style.css" type="text/css"/>
  <style>
  .login-page, .register-page {
    background-image: url("./assets/images/company.jpg");
    height: 100%;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;

  }

  .login-box-body {
    background: rgba(255, 255, 255, 0.8) none repeat scroll 0 0;
    border-radius: 4px;
    bottom: -8px;
    content: "";
    left: -8px;
    right: -8px;
    top: -8px;
    z-index: -1;
  }

  .img-responsive {
    margin: 0 auto;
  }

  .btn-primary {
    background-color: #1D71B8;
    border-color: #1D71B8;
    color: #fff;
  }

  .btn-primary.focus, .btn-primary:focus {
    background-color: #1D71B8;
    border-color: #1D71B8;
    color: #fff;
  }
  .btn-primary:hover {
    background-color: #1D71B8;
    border-color: #1D71B8;
    color: #fff;
  }

  .login-box-body, .register-box-body {
    color: #40AB4B;
  }

  .login-box-body {
    background: #fff none repeat scroll 0 0;
    border-radius: 0px;
    bottom: -8px;
    content: "";
    left: -8px;
    right: -8px;
    top: -8px;
    z-index: -1;
  }

  .form-control::-moz-placeholder {
    color: #1D71B8;
    opacity: 1;
  }

  .login-box-body .form-control-feedback, .register-box-body .form-control-feedback {
    color: #1D71B8;
  }

  </style>
</head>
<body class="hold-transition login-page">
  <div class="login-box partLogin">
    <div class="login-logo">
      <img class="img-responsive" src="./assets/images/logo_diris.png"/>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg"><b>Registro de Análisis de laboratorio</b></p>
      <form action="controller/ctrlLogin.php" method="post" autocomplete="off" id="form_login">
        <input type="hidden" name="accion"  value="login">
        <input type="hidden" name="url_bak" value="1" id="url_bak">
        <div class="input-group" style="padding-bottom:15px;">
          <input id="txtUser" type="text" class="form-control" name="txtUser" placeholder="Usuario" required="" maxlength="25" onkeydown="campoSiguiente('txtPass', event);"/>
          <div class="input-group-addon" style="cursor: pointer;" id="div-eye-passwd"><i class="glyphicon glyphicon-user" id="eye-addon"></i></div>
        </div>
        <div class="input-group" style="padding-bottom:15px;">
          <input id="txtPass" type="password" class="form-control" name="txtPass" placeholder="Contraseña" required="" maxlength="25" onkeydown="campoSiguiente('btnLogin', event);"/>
          <div class="input-group-addon" style="cursor: pointer;" id="div-eye-passwd"><i class="glyphicon glyphicon-lock" id="eye-addon"></i></div>
        </div>
        <div class="alert alert-danger">
          <span class="body-message">Usuario o contraseña no son válidos, intente nuevamente.</span>
        </div>
        <div>
          <button class="btn btn-primary btn-block" type="button" id="btnLogin" onclick="login();">Ingresar &nbsp;</button>
        </div>
      </form>
    </div><!-- /.login-box-body -->
  </div><!-- /.login-box -->
</body>

<!-- jQuery 2.1.4 -->
<script src="./assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="./assets/css/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script Language="JavaScript">

function campoSiguiente(campo, evento) {
  if (evento.keyCode == 13 || evento.keyCode == 9) {
    if (campo == 'btnLogin') {
      login();
    } else {
      document.getElementById(campo).focus();
      evento.preventDefault();
    }
  }
}

function login() {
  $.ajax({
    type: "POST",
    url: "controller/ctrlLogin.php",
    data: {
      accion: 'POST_LOGIN', nomUser: $("#txtUser").val(), passUser: $("#txtPass").val(),
    },
    success: function (data) {
      if(isNaN(data)){
        $(".alert").html(data);
      }else{
        //window.location = "view/pages/index.php";
        return document.querySelector("#form_login").submit();
      }
    }
  });
}

$(document).ready(function() {
  $(".alert").hide();
  $("#txtUser").focus();
});
</script>
</html>
