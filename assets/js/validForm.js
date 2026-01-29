
function showMessage(message, type, duplicate) {

    if (duplicate == undefined) duplicate = true;

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": !duplicate,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    toastr[type](message);

}


function change_clave() {
	$('#cha_nclave').val('');
	$('#cha_repitnclave').val('');
	
	$('#showChangeClaveUser').modal({
	  show: true,
	  backdrop: 'static',
	  focus: true,
	});

	$('#showChangeClaveUser').on('shown.bs.modal', function (e) {
	  $("#cha_nclave").trigger('focus');
	})
}

function validChangeClaveUser() {
	//$('#btnChangeClaveUser').prop("disabled", true);
	var msg = "";
	var sw = true;

	var pass_usuario = $('#cha_nclave').val();
	var rpass_usuario = $('#cha_repitnclave').val();

	if(pass_usuario.length < 6){
		msg += "Ingrese la contraseña como mínimo 6 caracteres<br/>";
		sw = false;
	}
	
	if(pass_usuario != rpass_usuario){
		msg += "Las contraseñas ingresadas no coindicen, vuleva a ingresarlos<br/>";
		sw = false;
	}

	if (sw == false) {
		bootbox.alert(msg);
		$('#btnChangeClaveUser').prop("disabled", false);
		return false;
	}
  
  bootbox.confirm({
    message: "Se cambiará la contraseña, ¿Está seguro de continuar?",
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
        var myRand = parseInt(Math.random() * 999999999999999);
        var form_data = new FormData();
        form_data.append('accion', 'POST_ADD_PWDUSUARIO');
        form_data.append('pass_usuario', pass_usuario);

        form_data.append('rand', myRand);
        $.ajax( {
          url: '../../controller/ctrlUsuario.php',
          dataType: 'text', // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'POST',
          success: function(data) {
            var tmsg = data.substring(0, 2);
            var lmsg = data.length;
            var msg = data.substring(3, lmsg);
            //console.log(tmsg);
            if(tmsg == "OK"){
              $("#showChangeClaveUser").modal('hide');
            } else {
              bootbox.alert(msg);
              return false;
            }
            $('#btnChangeClaveUser').prop("disabled", false);
          }
        });
      } else {
        $('#btnChangeClaveUser').prop("disabled", false);
      }
    }
  });
}

function validarFormatoFecha(campo) {
  var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
  if ((campo.match(RegExPattern)) && (campo != '')) {
    return true;
  } else {
    return false;
  }
}

function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test($email);
}

function soloNumeros(e)
{
  var key = window.Event ? e.which : e.keyCode;
  //alert(key);
  return ((key >= 48 && key <= 57) || key == 0 || key == 8)
  /*tecla = e.which || e.keyCode;
  patron = /\d/; // Solo acepta n�meros
  te = String.fromCharCode(key);
  return (patron.test(te) || tecla == 9 || tecla == 8);*/
}

function validateNumber(valor){
  var num=parseFloat(valor);
  if(isNaN(num))
  return 0;
  else
  return num;
}

function filterFloat(evt,input){


  var pos= document.getElementById(input.id).selectionStart ;

  // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
  var key = window.Event ? evt.which : evt.keyCode;
  var chark = String.fromCharCode(key);


  var point= input.value.indexOf('.');

  var cadIni=input.value.substring(0,pos);
  var cadFin=input.value.substring(pos);


  var tempValue = cadIni + chark + cadFin ; //input.value+chark;


  if(key >= 48 && key <= 57){
    if(filter(tempValue)=== false){
      return false;
    }else{
      return true;
    }
  }else{
    if(key == 8 || key == 13 || key == 0) {
      return true;
    }else if(key == 46){
      if(filter(tempValue)=== false){
        return false;
      }else{
        return true;
      }
    }else{
      return false;
    }
  }
}



function keyValidLetter(id) {
  jQuery('#'+id).keypress(function (tecla) {
    if ((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45) && (tecla.charCode <= 192 || tecla.charCode >= 255) && (tecla.charCode != 0) && (tecla.charCode != 32) && (tecla.charCode != 39))
    return false;
  });
}

function keyValidNumber(id) {
  jQuery('#'+id).keypress(function (tecla) {
    if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 0))//(Solo Numeros)(0=borrar)
    return false;
  });
}

function keyValidNumberDecimalOne(id) {
  //PARA LLAMARLO EN EL OBJETO ---> onkeypress="solo_JQdecimal(this.id)"
  $('#'+id).on('keypress', function (e) {
    // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
    var field = $(this);
    key = e.keyCode ? e.keyCode : e.which;

    if (key == 8) return true;
    if (key > 47 && key < 58) {
      if (field.val() === "") return true;
      var existePto = (/[.]/).test(field.val());
      if (existePto === false){
        regexp = /.[0-9]{5}$/; //PARTE ENTERA 10
      }
      else {
        regexp = /.[0-9]{1}$/; //PARTE DECIMAL2  {2}
      }
      return !(regexp.test(field.val()));
    }
    if (key == 46) {
      if (field.val() === "") return false;
      regexp = /^[0-9]+$/;
      return regexp.test(field.val());
    }
    return false;
  });
}

function keyValidNumberDecimalTwo(id) {
  //PARA LLAMARLO EN EL OBJETO ---> onkeypress="solo_JQdecimal(this.id)"
  $('#'+id).on('keypress', function (e) {
    // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
    var field = $(this);
    key = e.keyCode ? e.keyCode : e.which;

    if (key == 8) return true;
    if (key > 47 && key < 58) {
      if (field.val() === "") return true;
      var existePto = (/[.]/).test(field.val());
      if (existePto === false){
        regexp = /.[0-9]{5}$/; //PARTE ENTERA 10
      }
      else {
        regexp = /.[0-9]{2}$/; //PARTE DECIMAL2  {2}
      }
      return !(regexp.test(field.val()));
    }
    if (key == 46) {
      if (field.val() === "") return false;
      regexp = /^[0-9]+$/;
      return regexp.test(field.val());
    }
    return false;
  });
}

function keyValidNumberDecimalThree(id) {
  //PARA LLAMARLO EN EL OBJETO ---> onkeypress="solo_JQdecimal(this.id)"
  $('#'+id).on('keypress', function (e) {
    // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
    var field = $(this);
    key = e.keyCode ? e.keyCode : e.which;

    if (key == 8) return true;
    if (key > 47 && key < 58) {
      if (field.val() === "") return true;
      var existePto = (/[.]/).test(field.val());
      if (existePto === false){
        regexp = /.[0-9]{5}$/; //PARTE ENTERA 10
      }
      else {
        regexp = /.[0-9]{3}$/; //PARTE DECIMAL2  {2}
      }
      return !(regexp.test(field.val()));
    }
    if (key == 46) {
      if (field.val() === "") return false;
      regexp = /^[0-9]+$/;
      return regexp.test(field.val());
    }
    return false;
  });
}

function keyValidNumberDecimalFour(id) {
  //PARA LLAMARLO EN EL OBJETO ---> onkeypress="solo_JQdecimal(this.id)"
  $('#'+id).on('keypress', function (e) {
    // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
    var field = $(this);
    key = e.keyCode ? e.keyCode : e.which;

    if (key == 8) return true;
    if (key > 47 && key < 58) {
      if (field.val() === "") return true;
      var existePto = (/[.]/).test(field.val());
      if (existePto === false){
        regexp = /.[0-9]{10}$/; //PARTE ENTERA 10
      }
      else {
        regexp = /.[0-9]{4}$/; //PARTE DECIMAL2  {2}
      }
      return !(regexp.test(field.val()));
    }
    if (key == 46) {
      if (field.val() === "") return false;
      regexp = /^[0-9]+$/;
      return regexp.test(field.val());
    }
    return false;
  });
}

function calcular_fecha(fecha,cantidaddia) {
  var parts = fecha.split('/');
  //la fecha
  var TuFecha = new Date(parts[2], parts[1] - 1, parts[0]);
  //dias a sumar
  var dias = parseInt(cantidaddia);
  //nueva fecha sumada
  TuFecha.setDate(TuFecha.getDate() + dias);
  //formato de salida para la fecha
  return TuFecha.getDate() + '/' + (TuFecha.getMonth() + 1) + '/' + TuFecha.getFullYear();
}


$(function () {
  //Datemask dd/mm/yyyy
  $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
  //Money Euro
  $("[data-mask]").inputmask();
});
