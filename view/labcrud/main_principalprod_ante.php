<?php require_once '../include/masterheader.php'; ?>
<?php require_once '../include/header.php'; ?>
<?php require_once '../include/sidebar.php'; ?>
<?php
require_once '../../model/Area.php';
$a = new Area();
require_once '../../model/Grupo.php';
$g = new Grupo();
require_once '../../model/Componente.php';
$c = new Componente();
require_once '../../model/Dependencia.php';
$d = new Dependencia();
require_once '../../model/Producto.php';
$p = new Producto();
?>
<div class="container-fluid">
  <div class="panel-prime">
    <div class="panel-heading">
      <h3 class="panel-title"><strong>MANTENIMIENTO DE PRODUCTOS DE LABORATORIO</strong></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3">
          <div class="box box-success">
            <br/>
            <div class="box-body box-profile">
              <h3 class="profile-username text-center" id="titleAcc">Nuevo Producto</h3>
              <form id="frmProd" name="frmProd">
                <input type="hidden" name="txtIdProd" id="txtIdProd" value="0"/>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="txtCodProd">Codigo</label>
                      <input type="text" class="form-control input-sm" name="txtCodProd" id="txtCodProd" autocomplete="off" maxlength="500"/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="txtIdTipProd">Tipo Producto</label>
						<?php $rsTP = $p->get_listaTipoProducto(); ?>
						<select name="txtIdTipProd" id="txtIdTipProd" class="form-control input-sm">
							<option value="" selected>-- Seleccione --</option>
							<?php
								foreach ($rsTP as $row) {
									echo "<option value='" . $row['id'] . "'>" . $row['abrev_tipo_producto'] . "</option>";
								}
							?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="txtNomProd">Nombre</label>
                  <input type="text" class="form-control input-sm" name="txtNomProd" id="txtNomProd" autocomplete="off" maxlength="500"/>
                  <span class="help-block">Considere mayúsculas y minúsculas</span>
                </div>
                <div class="form-group">
                  <label for="txtPrepaProd">Preparación del paciente</label>
                  <textarea class="form-control" rows="3" name="txtPrepaProd" id="txtPrepaProd"></textarea>
                </div>
                <div class="form-group">
                  <label for="txtInsuProd">Insumos</label>
                  <textarea class="form-control" rows="3" name="txtInsuProd" id="txtInsuProd"></textarea>
                </div>
                <div class="form-group">
                  <label for="txtValRefComp">Observaciones</label>
                  <textarea class="form-control" rows="3" name="txtObsProd" id="txtObsProd"></textarea>
                </div>
                <button type="button" class="btn btn-primary btn-block" id="btnValidForm" onclick="save_form()"><i class="fa fa-save"></i> Guardar </button>
                <div id="show-new" style="display:none; margin-top:5px;">
                  <button type="button" class="btn btn-success btn-block" id="btnNewForm" onclick="nuevo_registro()"><i class="glyphicon glyphicon-plus"></i> Nuevo Producto </button>
                </div>
				<hr/>
				<button type="button" class="btn btn-success btn-block" id="btnValidForm" onclick="orden_producto('1','HEMATOLOGICOS')"><i class="glyphicon glyphicon-arrow-up"></i><i class="glyphicon glyphicon-arrow-down"></i> ORDEN HEMATOLOGICOS </button>
				<button type="button" class="btn btn-warning btn-block" id="btnValidForm" onclick="orden_producto('2','BIOQUIMICOS')"><i class="glyphicon glyphicon-arrow-up"></i><i class="glyphicon glyphicon-arrow-down"></i> ORDEN BIOQUIMICOS </button>
				<button type="button" class="btn btn-info btn-block" id="btnValidForm" onclick="orden_producto('3','INMUNOLOGICOS')"><i class="glyphicon glyphicon-arrow-up"></i><i class="glyphicon glyphicon-arrow-down"></i> ORDEN INMUNOLOGICOS </button>
				<button type="button" class="btn btn-danger btn-block" id="btnValidForm" onclick="orden_producto('4','MICROBIOLOGICOS')"><i class="glyphicon glyphicon-arrow-up"></i><i class="glyphicon glyphicon-arrow-down"></i> ORDEN MICROBIOLOGICOS </button>
				<button type="button" class="btn btn-block" id="btnValidForm" onclick="orden_producto('6','PERFILES/PAQUETES')"><i class="glyphicon glyphicon-arrow-up"></i><i class="glyphicon glyphicon-arrow-down"></i> ORDEN PERFILES/PAQUETES </button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="box box-primary">
            <br/>
            <table id="tblAtencion" class="display" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Tipo</th>
                  <th>Producto</th>
                  <th>Preparación Paciente</th>
                  <th style="width: 60px;">Cnt.<br/>Dependencia</th>
                  <th style="width: 60px;">Cnt.<br/>Componente</th>
                  <th style="width: 50px;">Estado</th>
                  <th style="width: 60px;"><i class="fa fa-cogs"></i></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-info pull-right" id="btnBackForm" onclick="back()"><i class="glyphicon glyphicon-log-out"></i> Ir al Menú</button>
    </div>
  </div>
</div>


<div class="modal fade" id="showCompCptModal" tabindex="-1" role="dialog" aria-labelledby="showCompCptModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showCompCptModalLabel"></h4>
      </div>
      <div class="modal-body">
        <div style="margin-bottom: 5px;">
          <button class="btn btn-primary btn-sm" onclick="reg_registro()"><i class="glyphicon glyphicon-plus"></i> Agregar Componente</button>
        </div>
        <div id="datos-tabla" style="height: 250px;">
          <table id="fixTable" class="table table-bordered table-hover">
            <thead>
              <tr>
				<th><small>Producto</small></th>
                <th><small>Componente</small></th>
                <th><small>Grupo</small></th>
                <th><small>Area</small></th>
                <th><small>Estado</small></th>
                <th><small>&nbsp;</small></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Aceptar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="showComponenteModal" role="dialog" aria-labelledby="showComponenteModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showComponenteModalLabel">Agregar Componente</h4>
        </div>
        <div class="modal-body">
          <form name="frmProdProd" id="frmProdProd">
            <input type="hidden" name="txtIdProd" id="txtIdProd" value="0"/>
            <input type="hidden" name="txtIdCompProd" id="txtIdCompProd" value="0"/>

            <div class="tabbable-panel">
              <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                  <li class="active">
                    <a href="#tab_default_1" data-toggle="tab">Específico</a>
                  </li>
                  <li>
                    <a href="#tab_default_2" data-toggle="tab">Producto</a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_default_1">
                    <br/>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-12">
                          <label for="txtIdArea">Área:</label>
                          <?php $rsA = $a->get_listaArea(); ?>
                          <select class="form-control input-xs" style="width: 100%" name="txtIdArea" id="txtIdArea" onchange="get_listaGrupoArea()">
                            <option value="" selected>-- Seleccione --</option>
                            <?php
                            foreach ($rsA as $rowA) {
                              echo "<option value='" . $rowA['id_area'] . "'>" . $rowA['area'] . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-12">
                          <label for="txtIdGrupoArea">Grupo:</label>
                          <select class="form-control input-xs" style="width: 100%" name="txtIdGrupoArea" id="txtIdGrupoArea" onchange="get_listaCompGrupoArea()">
                            <option value="" selected>-- Seleccione --</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-sm-12">
                          <label for="txtIdCompDet">Componente:</label>
                          <select class="form-control input-xs" style="width: 100%" name="txtIdCompDet" id="txtIdCompDet">
                            <option value="" selected>-- Seleccione --</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab_default_2">
                    <br/>
                    <div class="form-group">
                      <select class="form-control" name="txtIdProducto" id="txtIdProducto" required="" style="width: 100%">
                        <option value="">--Seleccione--</option>
                        <?php
                        $rsP = $p->get_listaProductoLaboratorioPorIdDep($labIdDepUser);
                        foreach ($rsP as $rowP) {
                          echo "<option value='" . $rowP['id_producto'] . "'>" . $rowP['nom_producto'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-continuar" id="btnValidFormComp" onclick="save_form_comp()"><i class="fa fa-save"></i> Guardar </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="showLisDepModal" tabindex="-1" role="dialog" aria-labelledby="showLisDepModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="showLisDepModalLabel"></h4>
        </div>
        <div class="modal-body">
          <div style="margin-bottom: 5px;">
            <button class="btn btn-primary btn-sm" onclick="reg_dependencia()"><i class="glyphicon glyphicon-plus"></i> Agregar Dependencia</button>
          </div>
          <div id="datos-lis-dep" style="height: 250px;">
            <table id="fixTableDep" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><small>Dependencia</small></th>
                  <th><small>Precio SIS</small></th>
                  <th><small>Precio Part.</small></th>
                  <th><small>Estado</small></th>
                  <th><small>&nbsp;</small></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Aceptar</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="showDepModal" role="dialog" aria-labelledby="showDepModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="showDepModalLabel">Agregar Dependencia</h4>
          </div>
          <div class="modal-body">
            <form name="frmDepProd" id="frmDepProd">
              <input type="hidden" name="txtIdProdDep" id="txtIdProdDep" value="0"/>
              <div class="form-group">
                <label for="txtIdDep">Dependencia:</label>
                <?php $rsD = $d->get_listaDepenInstitucion(); ?>
                <select name="txtIdDep" id="txtIdDep" class="form-control select" multiple data-mdb-clear-button="true">
                  <?php
                  foreach ($rsD as $row) {
                    echo "<option value='" . $row['id_dependencia'] . "'>" . $row['nom_depen'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-6">
                    <label for="txtPrePart">Precio Particular</label>
                    <input type="text" class="form-control input-sm" name="txtPrePart" id="txtPrePart" autocomplete="off" maxlength="15" onfocus="this.select()" value="0.0000"/>
                  </div>
                  <div class="col-sm-6">
                    <label for="txtPreSIS">Precio SIS</label>
                    <input type="text" class="form-control input-sm" name="txtPreSIS" id="txtPreSIS" autocomplete="off" maxlength="15" onfocus="this.select()" value="0.0000"/>
                  </div>
                </div>
                <span class="help-block">Para el precio puede considerar hasta 4 decimales</span>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-primary btn-continuar" id="btnValidFormDep" onclick="save_form_dep()"><i class="fa fa-save"></i> Guardar </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="showOrderProdModal" tabindex="-1" role="dialog" aria-labelledby="showOrderProdModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showCompCptModalLabel"></h4>
      </div>
      <div class="modal-body">
        <div id="datos-tabla-prod" style="height: 250px;">
          <table id="fixTable1" class="table table-bordered table-hover">
            <thead>
              <tr>
				  <th>Orden</th>
				  <th><i class="fa fa-cogs"></i></th>
                  <th>Código</th>
                  <th>Producto</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="btn-group">
              <button class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Aceptar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once '../include/footer.php'; ?>
  <script src="../../assets/plugins/multiselect/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="../../assets/plugins/multiselect/bootstrap-multiselect.css" type="text/css"/>
  <script Language="JavaScript">

  /***********************************************************************************************************/
  /////////////////////////////////////////// Componente ////////////////////////////////////////////
  /**********************************************************************************************************/
  function open_comp(idprod, nomprod){
    document.frmProd.txtIdProd.value = idprod;
    carga_grupoarea(idprod);

    $('#showCompCptModal').modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });

    $('#showCompCptModal').on('shown.bs.modal', function (e) {
      var modal = $(this)
      modal.find('.modal-title').text(nomprod)
    })
  }

  function carga_grupoarea(idprod){
    $.ajax({
      url: "../../controller/ctrlComponente.php",
      type: "POST",
      data: {
        accion: 'GET_SHOW_COMPPORIDPRODUCTO', idProd: idprod
      },
      success: function (registro) {
        $("#datos-tabla").html(registro);
        $("#fixTable").tableHeadFixer();
      }
    });
  }
  
  function orden_producto(idtipo, nomtipo){
    carga_producto(idtipo);

    $('#showOrderProdModal').modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });

    $('#showOrderProdModal').on('shown.bs.modal', function (e) {
      var modal = $(this)
      modal.find('.modal-title').text(nomtipo)
    })
  }

  function carga_producto(idtipo){
    $.ajax({
      url: "../../controller/ctrlProducto.php",
      type: "POST",
      data: {
        accion: 'GET_SHOW_ORDENPRODUCTOPORTIPOPRODUCTO', idtipo: idtipo
      },
      success: function (registro) {
        $("#datos-tabla-prod").html(registro);
		$("#fixTable1").tableHeadFixer();
      }
    });
  }
  

	function cambiar_orden(idtipo,accion,idprod) {
		$.ajax({
			url: "../../controller/ctrlProducto.php",
			type: "POST",
			data: {
				accion: 'GET_REG_CAMBIOORDENPRODUCTOPORTIPOPRODUCTO', idtipo: idtipo, accion_proc:accion, idprod: idprod
			},
			success: function (registro) {
				carga_producto(idtipo);
			}
		});
	}

  function reg_registro(){
    document.frmProdProd.txtIdCompProd.value = '0';
    $("#txtIdArea").val('').trigger("change");
    $("#txtIdGrupoArea").val('').trigger("change");
    $('#txtIdGrupoArea').prop("disabled", true);
    $("#txtIdCompDet").val('').trigger("change");
    $('#txtIdCompDet').prop("disabled", true);
    $('#showComponenteModal').modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });
  }

  function get_listaGrupoArea() {
    var idArea = $('#txtIdArea').val();
    if (idArea == "") {
      $("#txtIdGrupoArea").val('').trigger("change");
      $('#txtIdGrupoArea').prop("disabled", true);
      $("#txtIdCompDet").val('').trigger("change");
      $('#txtIdCompDet').prop("disabled", true);
      return false;
    }
    $.ajax({
      url: "../../controller/ctrlGrupo.php",
      type: "POST",
      dataType: "json",
      data: {
        accion: 'GET_SHOW_LISTAGRUPOPORIDAREA', idArea: idArea
      },
      success: function (result) {
        $('#txtIdGrupoArea').prop("disabled", false);
        $("#txtIdCompDet").val('').trigger("change");
        $('#txtIdCompDet').prop("disabled", true);
        var newOption = "";
        newOption = "<option value=''>--Seleccionar-</option>";
        $(result).each(function (ii, oo) {
          newOption += "<option value='" + oo.id_grupoarea + "'>" + oo.grupo + "</option>";
        });
        $('#txtIdGrupoArea').html(newOption);
        $("#txtIdGrupoArea").select2({max_selected_options: 4});
      }
    });
  }

  function get_listaCompGrupoArea() {
    var txtIdGrupoArea = $('#txtIdGrupoArea').val();
    if (txtIdGrupoArea == ""){
      $("#txtIdCompDet").val('').trigger("change");
      $('#txtIdCompDet').prop("disabled", true);
      return false;
    }
    $.ajax({
      url: "../../controller/ctrlComponente.php",
      type: "POST",
      dataType: "json",
      data: {
        accion: 'GET_SHOW_LISTACOMPDETPORIDGRUPOAREA', txtIdGrupoArea: txtIdGrupoArea
      },
      success: function (result) {
        $('#txtIdCompDet').prop("disabled", false);
        var newOption = "";
        newOption = "<option value=''>--Seleccionar-</option>";
        $(result).each(function (ii, oo) {
          newOption += "<option value='" + oo.id_componentedet + "'>" + oo.componente + " - U.M.: " + oo.uni_medida + "</option>";
        });
        $('#txtIdCompDet').html(newOption);
        $("#txtIdCompDet").select2({max_selected_options: 4});
      }
    });
  }

  function save_form_comp() {
    var msg = "";
    var sw = true;

    if($('#tab_default_1').is(":visible")) {
      var idArea = $('#txtIdArea').val();
      var idGrupoArea = $('#txtIdGrupoArea').val();
      var idCompGrupo = $('#txtIdCompDet').val();

      var txtTipIng = 'CC';

      if(idArea == ""){
        msg+= "Seleccione un Área<br/>";
        sw = false;
      }

      if(idGrupoArea == ""){
        msg+= "Seleccione un Grupo<br/>";
        sw = false;
      }

      if(idCompGrupo == ""){
        msg+= "Seleccione un Componente<br/>";
        sw = false;
      }
    } else {
      var txtIdProducto = $('#txtIdProducto').val();
      var txtTipIng = 'CP';

      if(txtIdProducto == ""){
        msg+= "Seleccione un Producto<br/>";
        sw = false;
      }
    };


    if (sw == false) {
      bootbox.alert(msg);
      $('#btnValidFormComp').prop("disabled", false);
      return false;
    }

    bootbox.confirm({
      message: "Se registrará el componente seleccionado, ¿Está seguro de continuar?",
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
          form_data.append('accion', 'POST_ADD_REGCOMPPORPRODUCTO');
          form_data.append('txtTipIng', txtTipIng);
          form_data.append('txtIdProd', $("#txtIdProd").val());
          form_data.append('txtIdCompDet', $("#txtIdCompDet").val());
          form_data.append('txtIdPerfil', $("#txtIdProducto").val());
          form_data.append('rand', myRand);
          $.ajax( {
            url: '../../controller/ctrlComponente.php',
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
                $("#showComponenteModal").modal('hide');
                $("#tblAtencion").dataTable().fnDraw();
                carga_grupoarea($("#txtIdProd").val());
                //bootbox.alert("Registro ingresado correctamente.");
              } else {
                bootbox.alert(msg);
                return false;
              }
              $('#btnValidFormComp').prop("disabled", false);
            }
          });
        } else {
          $('#btnValidFormComp').prop("disabled", false);
        }
      }
    });
  }

  function cambio_estado(compdetprod,estado) {
    bootbox.confirm({
      message: "Se cambiará el estado, ¿Está seguro de continuar?",
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
          form_data.append('accion', 'POST_ADD_REGCOMPPORPRODUCTO');
          form_data.append('txtTipIng', 'E');
          form_data.append('txtIdProd', estado);
          form_data.append('txtIdCompDet', compdetprod);
          form_data.append('rand', myRand);
          $.ajax( {
            url: '../../controller/ctrlComponente.php',
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
                $("#showComponenteModal").modal('hide');
                $("#tblAtencion").dataTable().fnDraw();
                carga_grupoarea($("#txtIdProd").val());
                //bootbox.alert("Registro ingresado correctamente.");
              } else {
                bootbox.alert(msg);
                return false;
              }
              $('#btnValidFormComp').prop("disabled", false);
            }
          });
        } else {
          $('#btnValidFormComp').prop("disabled", false);
        }
      }
    });
  }


  /***********************************************************************************************************/
  /////////////////////////////////////////// Dependencia ////////////////////////////////////////////
  /**********************************************************************************************************/
  function open_dependencia(idprod, nomprod){
    document.frmProd.txtIdProd.value = idprod;
    carga_dependencia(idprod);

    $('#showLisDepModal').modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });

    $('#showLisDepModal').on('shown.bs.modal', function (e) {
      var modal = $(this)
      modal.find('.modal-title').text(nomprod)
    })
  }

  function carga_dependencia(idprod){
    $.ajax({
      url: "../../controller/ctrlProducto.php",
      type: "POST",
      data: {
        accion: 'GET_SHOW_DEPPORIDPRODUCTO', idProd: idprod
      },
      success: function (registro) {
        $("#datos-lis-dep").html(registro);
      }
    });
  }

  function reg_dependencia(){
    $('#btnValidFormDep').prop("disabled", false);
    document.frmDepProd.txtIdProdDep.value = '0';
	$('#txtIdDep').multiselect('deselectAll', false);
	$('#txtIdDep').multiselect('updateButtonText');
	$('#txtIdDep').multiselect('enable');
    document.frmDepProd.txtPreSIS.value = '0.0000';
    document.frmDepProd.txtPrePart.value = '0.0000';
    $('#showDepModal').modal({
      show: true,
      backdrop: 'static',
      focus: true,
    });

    $('#showDepModal').on('shown.bs.modal', function (e) {
      //$('#txtIdDep').select2('open');
    });
  }

  function edit_dependencia(id) {
    $('#btnValidFormDep').prop("disabled", false);
    $.ajax({
      url: "../../controller/ctrlProducto.php",
      type: "POST",
      dataType: 'json',
      data: {
        accion: 'GET_SHOW_DETDEPPRODUCTO', txtIdProdDep: id
      },
      success: function (registro) {
        var datos = eval(registro);
        document.frmDepProd.txtIdProdDep.value =  datos[0];
		$('#txtIdDep').multiselect('deselectAll', false);
		$('#txtIdDep').multiselect('updateButtonText');
		$('#txtIdDep').multiselect('disable');
		$('#txtIdDep').multiselect('select', [datos[2]], true);
        document.frmDepProd.txtPreSIS.value =  datos[7];
        document.frmDepProd.txtPrePart.value =  datos[8];

        $('#showDepModal').modal({
          show: true,
          backdrop: 'static',
          focus: true,
        });

        $('#showDepModal').on('shown.bs.modal', function (e) {
          $("#txtPrePart").trigger('focus');
        });

      }
    });
  }

  function save_form_dep() {
    $('#btnValidFormDep').prop("disabled", true);
    var msg = "";
    var sw = true;

    var idDep = $('#txtIdDep').val();
    var preSIS = $('#txtPreSIS').val();
    var prePart = $('#txtPrePart').val();

    if(idDep === null){ msg+= "Seleccione una Depedencia<br/>"; sw = false;}

    if(preSIS == ""){ msg+= "Ingrese precio SIS del producto<br/>"; sw = false;}

    if(prePart == ""){ msg+= "Ingrese precio particular del producto<br/>"; sw = false;}

    if (sw == false) {
      bootbox.alert(msg);
      $('#btnValidFormDep').prop("disabled", false);
      return false;
    }
	//alert(idDep);
    bootbox.confirm({
      message: "Se registrará la Depedencia seleccionada, ¿Está seguro de continuar?",
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
          form_data.append('accion', 'POST_ADD_REGDEPPORPRODUCTO');
          form_data.append('txtTipIng', 'C');
          form_data.append('txtIdProdDep', $("#txtIdProdDep").val());
          form_data.append('txtIdProd', $("#txtIdProd").val());
          form_data.append('txtIdDep', idDep.join());
          form_data.append('txtPreSIS', $("#txtPreSIS").val());
          form_data.append('txtPrePart', $("#txtPrePart").val());
          form_data.append('rand', myRand);
          $.ajax( {
            url: '../../controller/ctrlProducto.php',
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
                $("#showDepModal").modal('hide');
                $("#tblAtencion").dataTable().fnDraw();
                carga_dependencia($("#txtIdProd").val());
                //bootbox.alert("Registro ingresado correctamente.");
              } else {
                bootbox.alert(msg);
				$('#btnValidFormDep').prop("disabled", false);
                return false;
              }
              $('#btnValidFormDep').prop("disabled", false);
            }
          });
        } else {
          $('#btnValidFormDep').prop("disabled", false);
        }
      }
    });
  }

  function cambio_estado_dep(id,estado) {
    bootbox.confirm({
      message: "Se cambiará el estado, ¿Está seguro de continuar?",
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
          form_data.append('accion', 'POST_ADD_REGDEPPORPRODUCTO');
          form_data.append('txtTipIng', 'E');
          form_data.append('txtIdProdDep', id);
          form_data.append('txtIdEstProdDep', estado);
          form_data.append('rand', myRand);
          $.ajax( {
            url: '../../controller/ctrlProducto.php',
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
                $("#tblAtencion").dataTable().fnDraw();
                carga_dependencia($("#txtIdProd").val());
                //bootbox.alert("Registro ingresado correctamente.");
              } else {
                bootbox.alert(msg);
                return false;
              }
              $('#btnValidFormComp').prop("disabled", false);
            }
          });
        } else {
          $('#btnValidFormComp').prop("disabled", false);
        }
      }
    });
  }
  /**********************************************************************************************************************/
  ////////////////////////////////////////////// Mantenimiento ///////////////////////////////////////////////
  /**********************************************************************************************************************/

  function edit_registro(idprod) {
    $.ajax({
      url: "../../controller/ctrlProducto.php",
      type: "POST",
      dataType: 'json',
      data: {
        accion: 'GET_SHOW_DETPRODUCTO', txtIdProd: idprod
      },
      success: function (registro) {
        var datos = eval(registro);
        $('#show-new').show();
        $('#titleAcc').text('Editar Producto');
        document.frmProd.txtIdProd.value = datos[0];
        document.frmProd.txtCodProd.value =  datos[1];
        document.frmProd.txtIdTipProd.value =  datos[6];
        document.frmProd.txtNomProd.value = datos[2];
        document.frmProd.txtPrepaProd.value = datos[3];
        document.frmProd.txtInsuProd.value = datos[4];
        document.frmProd.txtObsProd.value = datos[5];
        document.frmProd.txtCodProd.focus();
      }
    });
  }

  function nuevo_registro(){
    $('#show-new').hide();
    $('#titleAcc').text('Nuevo Producto');
    document.frmProd.txtIdProd.value = 0;
    document.frmProd.txtCodProd.value = '';
    document.frmProd.txtIdTipProd.value = '';
    document.frmProd.txtNomProd.value = '';
    document.frmProd.txtPrepaProd.value = '';
    document.frmProd.txtInsuProd.value = '';
    document.frmProd.txtObsProd.value = '';
    document.frmProd.txtNomProd.focus();
  }

  function save_form() {
    //$('#btnValidForm').prop("disabled", true);
    var msg = "";
    var sw = true;

    var txtCodProd = $('#txtCodProd').val();
    var txtIdTipProd = $('#txtIdTipProd').val();
    var txtNomProd = $('#txtNomProd').val();
    var txtPrepaProd = $('#txtPrepaProd').val();
    var txtInsuProd = $('#txtInsuProd').val();
    var txtObsProd = $('#txtObsProd').val();

    if(txtNomProd == ""){
      msg+= "Ingrese nombre del Componente<br/>";
      sw = false;
    }

    if(txtIdTipProd == ""){
      msg+= "Seleccione Tipo de Producto<br/>";
      sw = false;
    }

    if (sw == false) {
      bootbox.alert(msg);
      $('#btnValidForm').prop("disabled", false);
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
          var myRand = parseInt(Math.random() * 999999999999999);
          var form_data = new FormData();
          form_data.append('accion', 'POST_ADD_REGPRODUCTO');
          form_data.append('txtIdProd', document.frmProd.txtIdProd.value);
          form_data.append('txtCodProd', document.frmProd.txtCodProd.value);
          form_data.append('txtIdTipProd', document.frmProd.txtIdTipProd.value);
          form_data.append('txtNomProd', document.frmProd.txtNomProd.value);
          form_data.append('txtPrepaProd', document.frmProd.txtPrepaProd.value);
          form_data.append('txtInsuProd', document.frmProd.txtInsuProd.value);
          form_data.append('txtObsProd', document.frmProd.txtObsProd.value);
          form_data.append('rand', myRand);
          $.ajax( {
            url: '../../controller/ctrlProducto.php',
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
                $("#tblAtencion").dataTable().fnDraw();
                if($("#").val() == "0"){
                  bootbox.alert("Registro ingresado correctamente.");
                } else {
                  //bootbox.alert("Registro actualizado correctamente.");
                }
                nuevo_registro();
              } else {
                bootbox.alert(msg);
                return false;
              }
              $('#btnValidForm').prop("disabled", false);
            }
          });
        } else {
          $('#btnValidForm').prop("disabled", false);
        }
      }
    });
  }

  function back() {
    window.location = '../pages/';
  }

  $(document).ready(function () {
    $("#txtIdUnidMed").select2();
    //$("#txtIdDep").select2();
    $("#txtIdProducto").select2();
    $("#fixTable").tableHeadFixer();
	$("#fixTable1").tableHeadFixer();
	$("#fixTableDep").tableHeadFixer();

    var dTable = $('#tblAtencion').DataTable({
      "lengthMenu": [[15, 25, 50, 100 ,250], [15, 25, 50, 100 ,250]],
      "bLengthChange": true, //Paginado 10,20,50 o 100
      "bProcessing": true,
      "bServerSide": true,
      "bJQueryUI": false,
      "responsive": true,
      "bInfo": true,
      "bFilter": true,
      "sAjaxSource": "tbl_principalprod.php", // Load Data
      "language": {
        "url": "../../assets/plugins/datatables/Spanish.json",
        "lengthMenu": '_MENU_ entries per page',
        "search": '<i class="fa fa-search"></i>',
        "paginate": {
          "previous": '<i class="fa fa-angle-left"></i>',
          "next": '<i class="fa fa-angle-right"></i>'
        }
      },
      "sServerMethod": "POST",
      "fnServerParams": function (aoData)
      {
        aoData.push({"name": "idEstado", "value": $("#txtBusIdEstado").val()});
      },
      "columnDefs": [
        {"orderable": false, "targets": 0, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 1, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 2, "searchable": true, "class": "small"},
        {"orderable": false, "targets": 3, "searchable": false, "class": "small"},
        {"orderable": false, "targets": 4, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 5, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 6, "searchable": false, "class": "small text-center"},
        {"orderable": false, "targets": 7, "searchable": false, "class": "small text-center"}
      ]
    });

    $('#tblAtencion').removeClass('display').addClass('table table-hover table-bordered');
	
	var multiselect_options = {
		enableFiltering: true,
		includeSelectAllOption: true,
		selectAllName: 'select-all-name',
		nSelectedText: 'Seleccionados',
		nonSelectedText: 'Seleccionar',
		allSelectedText: 'TODOS',
		filterPlaceholder: 'Buscar',
		selectAllText: 'SELECCIONAR TODOS',
		buttonClass: 'btn input-sm',
		inheritClass: true,
		maxHeight: 170,
		buttonWidth: '100%',
		widthSynchronizationMode: 'ifPopupIsSmaller'
	};
	$('#txtIdDep').multiselect(multiselect_options);
  });
  </script>
  <?php require_once '../include/masterfooter.php'; ?>
