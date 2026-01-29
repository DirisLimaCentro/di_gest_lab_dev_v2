<?php
include('../assets/lib/nusoap/lib/nusoap.php');
/*switch ($_POST['accion']) {
//GENERA EL KEY
case 'loadkeyPide':*/
$usr = "DIRLICE";
$pwd = "i2gcFi24Dt";
$client = new nusoap_client("http://app.sis.gob.pe/sisWSAFI/Service.asmx?WSDL", true); //array("connection_timeout"=>20));
$headers = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sis="http://sis.gob.pe/">
   <soapenv:Header/>
   <soapenv:Body>
      <sis:GetSession>
         <!--Optional:-->
         <sis:strUsuario>DIRLICE</sis:strUsuario>
         <!--Optional:-->
         <sis:strClave>i2gcFi24Dt</sis:strClave>
      </sis:GetSession>
   </soapenv:Body>
</soapenv:Envelope>';
$client->setHeaders($headers);
//echo($client);exit();
$err = $client->getError();
if ($err) {
  echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
$param = array('strUsuario' => $usr, 'strClave' => $pwd);
$result = $client->call('GetSession', $param);
if ($client->fault) {
  echo 'Fallo';
  print_r($result);
} else { // Chequea errores
  $err = $client->getError();
  if ($err) {  // Muestra el error
    echo 'Error' . $err;
  } else {  // Muestra el resultado
    //print_r($result);
    if($result['GetSessionResult']){
      //Aquí va
    } else {
      echo 'Error';
    };
    //$_SESSION['saaKeyPIDE'] = $result;
  }
}

$tipDoc = $_POST['tipDoc'];
$nroDoc = $_POST['nroDoc'];
/*
$tipDoc = '1';
$nroDoc = '47625270'; //Activo
//$nroDoc = '45690716'; //Fallecido
/**/
$key = $result['GetSessionResult'];
$param = '';
//ini_set('max_execution_time', 600);
//ini_set('default_socket_timeout', 600);
//set_time_limit(600);
//$ini = ini_set("soap.wsdl_cache_enabled","0");
//$client = new nusoap_client("http://pruebaapp.sis.gob.pe/sisWSAFI/Service.asmx?WSDL", true);
$client->charencoding = false;
$client->soap_defencoding = 'utf-8';  //ISO-8859-1
$client->decode_utf8 = false;
//echo($client);exit();

$headers = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sis="http://sis.gob.pe/">
   <soapenv:Header/>
   <soapenv:Body>
      <sis:ConsultarAfiliadoFuaE>
         <sis:intOpcion>1</sis:intOpcion>
         <!--Optional:-->
         <sis:strAutorizacion>'.$key.'</sis:strAutorizacion>
         <!--Optional:-->
         <sis:strDni>16718068</sis:strDni>
         <!--Optional:-->
         <sis:strTipoDocumento>'.$tipDoc.'</sis:strTipoDocumento>
         <!--Optional:-->
         <sis:strNroDocumento>'.$nroDoc.'</sis:strNroDocumento>
         <!--Optional:-->
         <sis:strDisa>?</sis:strDisa>
         <!--Optional:-->
         <sis:strTipoFormato>?</sis:strTipoFormato>
         <!--Optional:-->
         <sis:strNroContrato>?</sis:strNroContrato>
         <!--Optional:-->
         <sis:strCorrelativo>?</sis:strCorrelativo>
      </sis:ConsultarAfiliadoFuaE>
   </soapenv:Body>
</soapenv:Envelope>';
$err = $client->getError();
if ($err) {
  $datos = array(
    0 => "-01|ERROR EN EL SERVIDOR" . $err
  );
}
$param = array('intOpcion' => '1', 'strAutorizacion' => $key, 'strDni' => '16718068', 'strTipoDocumento' => $tipDoc, 'strNroDocumento' => $nroDoc);
$soapResponse = $client->call('ConsultarAfiliadoFuaE', $param);
//print_r($soapResponse);
//echo $soapResponse['ConsultarAfiliadoFuaEResult']['IdError'];
if(isset($soapResponse['ConsultarAfiliadoFuaEResult']['IdError'])){
  if($soapResponse['ConsultarAfiliadoFuaEResult']['IdError'] == "14"){
    $datos = array(
      0 => 'N',
      1 => 'EL DNI CONSULTADO NO CUENTA AFILIACION SIS' //trim($soapResponse['ConsultarAfiliadoFuaEResult']['Resultado'])
    );
    echo json_encode($datos);
    exit();
  } else if ($soapResponse['ConsultarAfiliadoFuaEResult']['IdError'] == "0"){

    $contratoSis = explode("-", trim($soapResponse['ConsultarAfiliadoFuaEResult']['Contrato']));
    $codSis = $contratoSis[0]; // porción1
    $nroSis = $contratoSis[1]; // porción2

    if(trim($soapResponse['ConsultarAfiliadoFuaEResult']['FecAfiliacion']) == ""){
      $fecIniSis = "";
    } else {
      //echo $soapResponse['ConsultarAfiliadoFuaEResult']['FecAfiliacion'];
      ;
      //$fecIniSis = date_create($soapResponse['ConsultarAfiliadoFuaEResult']['FecAfiliacion']);
      //$fecIniSis = date_format($fecIniSis, "d/m/Y");
      $fecIniSis = date("d/m/Y", strtotime($soapResponse['ConsultarAfiliadoFuaEResult']['FecAfiliacion']));
    }

    if(trim($soapResponse['ConsultarAfiliadoFuaEResult']['FecCaducidad']) == ""){
      $fecFinSis = "";
    } else {
      //$fecFinSis = date_create($soapResponse['ConsultarAfiliadoFuaEResult']['FecCaducidad']);
      //$fecFinSis = date_format($fecIniSis, "d/m/Y");
      $fecFinSis = date("d/m/Y", strtotime($soapResponse['ConsultarAfiliadoFuaEResult']['FecCaducidad']));
    }

    $datos = array(
      0 => $codSis,
      1 => $nroSis,
      2 => $fecIniSis,
      3 => $fecFinSis
    );
    echo json_encode($datos);
    exit();
  } else {
    $datos = array(
      0 => 'E',
      1 => trim($soapResponse['ConsultarAfiliadoFuaEResult']['Resultado'])
    );
    echo json_encode($datos);
  }
} else {
  $datos = array(
    0 => 'E',
    1 => trim('SERVICIO CONSULTA SIS NO DISPONIBLE')
  );
  echo json_encode($datos);
}
?>
