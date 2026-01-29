<?
session_start();
require_once '../model/Persona.php';
require_once '../model/Expediente.php';
require_once '../model/Dependencias.php';
require_once '../model/Usuario.php';
require_once '../model/Accesos.php';
require_once '../model/Menu.php';
require_once '../model/Tablas.php';
require_once '../model/Padron.php';

require_once '../lib/nusoap/lib/nusoap.php';

$per = new Persona();
$exp = new Expediente();
$dep = new Dependencia();
$usu = new Usuario();
$acc = new Accesos();
$men = new Menu();
$tab = new Tablas();
$pad = new Padron();
//include '../db/ConectaDb.php';
//$cn=conectar();

function to_pg_array($set) {
  settype($set, 'array'); // can be called with a scalar or array
  $result = array();
  foreach ($set as $t) {
    if (is_array($t)) {
      $result[] = to_pg_array($t);
    } else {
      $t = str_replace('"', '\\"', $t); // escape double quote
      if (! is_numeric($t)) // quote only non-numeric values
      $t = '"' . $t . '"';
      $result[] = $t;
    }
  }
  return '{' . implode(",", $result) . '}'; // format
}

if (isset($_POST['action'])) {
  $proceso = $_POST['action'];
}
if (isset($_GET['action'])) {
  $proceso = $_GET['action'];
}
if(!empty($_GET["term"])){
  $search_word = strtoupper($_GET["term"]);
  //$rsb=$per->searchPersona($search_word,$_GET["tipo"]);
  $rsb=$per->searchPersona($search_word);
}

switch($proceso){

    case 'loadtupas':
      echo'<select class="selectpicker show-tick form-control " data-live-search="true" name="cbotipotupa" id="cbotipotupa">';
      $rs=$tab->listaTablasTupa('23',$_GET["tipotramite"]);
      	echo '<option value="*">--Seleccione --</option>';
      foreach ($rs as $row) {
      echo "<option value='".$row['id_tipo']."'>".$row['descripcion']."</option>";}
      echo "</select>";
    break;

    case 'loadfechaPlazo':

    function sumasdiasemana($fecha,$dias)
    {
      $datestart= strtotime($fecha);
      $datesuma = 15 * 86400;
      $diasemana = date('N',$datestart);
      $totaldias = $diasemana+$dias;
      $findesemana = intval( $totaldias/5) *2 ;
      $diasabado = $totaldias % 5 ;
      if ($diasabado==6) $findesemana++;
      if ($diasabado==0) $findesemana=$findesemana-2;

      $total = (($dias+$findesemana) * 86400)+$datestart ;
      return $twstart=date('Y-m-d', $total);
    }
    $fecha=date('Y-m-d');

    if($_GET['idprioridad']=='1'){
      $dias="2";
    }else if($_GET['idprioridad']=='2'){
      $dias="1";
    }else if($_GET['idprioridad']=='3'){
      $dias="1";
    }else if($_GET['idprioridad']=='4'){
      $dias="4";
    }else if($_GET['idprioridad']=='5'){
      $dias="7";
    }


    $hora=date('H');
    if($hora>='16'){
      $dias=$dias+1;
      //echo "<br>";
      //echo $fecha."|".$dias."|".$hora."|1";
      //echo "<br>";
      $fechafinal= sumasdiasemana($fecha,$dias);
    }else {
      $dias=$dias;
      //echo "<br>";
      //echo $fecha."|".$dias."|".$hora."|2";
      //echo "<br>";
      $fechafinal= sumasdiasemana($fecha,$dias);
    }

    echo $fechafinal;

    break;


    case 'totalPersonaList':

    $rs = $usu->totalPersonaList('', $_GET['q']);
    //$json[]='';
    foreach ($rs as $row) {
      $lon=strlen($row["id_persona"]);
      $lon1=strlen($row["completo"]);
      $pad=13-$lon;
      $pad1=55-$lon1;
      $idu=$row['id_persona'];
      $com=$row['completo'];
      $json[] = array('id' => $idu, 'text' => $com);
    }
    //print_r($json);
    echo json_encode($json);
    break;

    case 'GetListuser':

    $rs = $usu->cbousuarioList('', $_GET['q']);
    //$json[]='';
    foreach ($rs as $row) {
      $lon=strlen($row["id_usuario"]);
      $lon1=strlen($row["completo"]);
      $pad=13-$lon;
      $pad1=55-$lon1;
      $idu=$row['id_usuario'];
      $com=$row['completo'];
      $json[] = array('id' => $idu, 'text' => $com);
    }
    //print_r($json);
    echo json_encode($json);
    break;

    case 'loadPersonaLast':

    $result=$per->loadPersonaLast($_GET['dnipersona']);
    $nr=count($result);
    if($nr>0){


      echo'<select id="cboidpersonal" name="cboidpersonal" multiple="multiple" class="form-control input-sm">';

      $rs=$per->personalQryMain();
      foreach ($rs as $row) {

        if($result[0]['id_persona']==$row['id_persona']){$sel=" selected='selected' ";}else {$sel=" ";}
        echo "<option value='".$row['id_persona']."' ".$sel.">".$row['persona']."</option>";}
        echo "</select>";
        ?>
        <input type="hidden" name="idpersonaselect" id="idpersonaselect" value="<? echo $result[0]['usuario'];?>"/>
        <input type="hidden" name="nrodnipersona" id="nrodnipersona" value="<? echo $result[0]['nro_documento'];?>"/>
        <?
      }

      break;

      case 'findPadron':

      $rs=$pad->findPadron($_GET['txtnro_doc']);
      $cnt=count($rs);
      $afi=array();
      if ($cnt>0){
        $fn=$rs[0]['fec_nac'];
        $afi['dni']=$rs[0]['dni'];
        $afi['nombres']=$rs[0]['nombres'];
        $afi['ape_pat']=$rs[0]['ape_pat'];
        $afi['ape_mat']=$rs[0]['ape_mat'];
        $afi['sexo']=$rs[0]['sexo'];
        $afi['fec_nac']=substr($fn,6,2).'/'.substr($fn,4,2).'/'.substr($fn,0,4);

      }else{
        $afi['msj']='01';
      }
      echo json_encode($afi);

      break;

      case 'findPadronPersona':

      $rs=$pad->findPadron($_GET['txtnro_doc']);
      $cnt=count($rs);
      $afi=array();
      if ($cnt>0){
        $fn=$rs[0]['fec_nac'];
        $afi['dni']=$rs[0]['dni'];
        $afi['nombres']=$rs[0]['nombres'];
        $afi['ape_pat']=$rs[0]['ape_pat'];
        $afi['ape_mat']=$rs[0]['ape_mat'];
        $afi['sexo']=$rs[0]['sexo'];
        $afi['fec_nac']=substr($fn,6,2).'/'.substr($fn,4,2).'/'.substr($fn,0,4);

      }else{
        $afi['msj']='01';
      }
      echo json_encode($afi);

      break;

      case 'searchPersonaJ':
      class ElementoAutocompletar {
        //propiedades de los elementos
        var $value;
        var $label;
        var $id_persona;
        var $nombre_rs;
        var $nro_documento;

        //constructor que recibe los datos para inicializar los elementos
        function __construct($label, $value, $id_persona, $nombre_rs, $nro_documento){
          $this->label = $label;
          $this->value = $value;
          $this->id_persona = $id_persona;
          $this->nombre_rs= $nombre_rs;
          $this->nro_documento = $nro_documento;
        }
      }
      //recibo el dato que deseo buscar sugerencias segun los caracteres iniciales para el filtro de contenido de data
      $arrayElementos = array();
      foreach ($rsb as $rowb) {
        $lon=strlen($rowb["id_persona"]);
        $lon1=strlen($rowb["nombre_rs"]);
        $lon2=strlen($rowb["nro_documento"]);
        $pad=15-$lon;
        $pad1=70-$lon1;
        $pad2=15-$lon2;
        $med=$rowb["id_persona"].str_repeat("-", $pad).$rowb["nombre_rs"].str_repeat("-", $pad1).$rowb["nro_documento"];
        array_push($arrayElementos, new ElementoAutocompletar($med,$rowb["nombre_rs"],$rowb["id_persona"],$rowb["nombre_rs"], $rowb["nro_documento"] ));
      }

      print_r(json_encode($arrayElementos));

      break;


      case 'searchJuridica':
      class ElementoAutocompletar {
        //propiedades de los elementos
        var $value;
        var $label;
        var $id_persona;
        var $nombre_rs;
        var $nro_documento;

        //constructor que recibe los datos para inicializar los elementos
        function __construct($label, $value, $id_persona, $nombre_rs, $nro_documento){
          $this->label = $label;
          $this->value = $value;
          $this->id_persona = $id_persona;
          $this->nombre_rs= $nombre_rs;
          $this->nro_documento = $nro_documento;
        }
      }
      //recibo el dato que deseo buscar sugerencias segun los caracteres iniciales para el filtro de contenido de data
      $arrayElementos = array();
      foreach ($rsb as $rowb) {
        $lon=strlen($rowb["id_persona"]);
        $lon1=strlen($rowb["nombre_rs"]);
        $lon2=strlen($rowb["nro_documento"]);
        $pad=15-$lon;
        $pad1=70-$lon1;
        $pad2=15-$lon2;
        $med=$rowb["id_persona"].str_repeat("-", $pad).$rowb["nombre_rs"].str_repeat("-", $pad1).$rowb["nro_documento"];
        array_push($arrayElementos, new ElementoAutocompletar($med,$rowb["nombre_rs"],$rowb["id_persona"],$rowb["nombre_rs"], $rowb["nro_documento"] ));
      }

      print_r(json_encode($arrayElementos));

      break;

      case 'searchPersonaN':
      class ElementoAutocompletar {
        //propiedades de los elementos
        var $value;
        var $label;
        var $id_persona;
        var $nombre_rs;
        var $nro_documento;
        var $primer_ape;
        var $segundo_ape;

        //constructor que recibe los datos para inicializar los elementos
        function __construct($label, $value, $id_persona, $nombre_rs, $nro_documento,$primer_ape,$segundo_ape){
          $this->label = $label;
          $this->value = $value;
          $this->id_persona = $id_persona;
          $this->nombre_rs= $nombre_rs;
          $this->nro_documento = $nro_documento;
          $this->primer_ape = $primer_ape;
          $this->segundo_ape = $segundo_ape;
        }
      }
      //recibo el dato que deseo buscar sugerencias segun los caracteres iniciales para el filtro de contenido de data
      $arrayElementos = array();
      foreach ($rsb as $rowb) {
        $lon=strlen($rowb["id_persona"]);
        $lon1=strlen($rowb["nombre_rs"]);
        $lon2=strlen($rowb["nro_documento"]);
        $pad=15-$lon;
        $pad1=60-$lon1;
        $pad2=15-$lon2;
        $persona=$rowb["primer_ape"]." ".$rowb["segundo_ape"].", ".$rowb["nombre_rs"];
        $med=$rowb["id_persona"].str_repeat("-", $pad).$persona.str_repeat("-", $pad1).$rowb["nro_documento"];
        array_push($arrayElementos, new ElementoAutocompletar($med,$persona,$rowb["id_persona"],$rowb["nombre_rs"],$rowb["nombre_rs"],$rowb["nombre_rs"], $rowb["nro_documento"] ));
      }

      print_r(json_encode($arrayElementos));

      break;

      case 'LoadCaptcha':
      $url="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias?accion=consPorRuc&razSoc=&nroRuc=".$_GET['txtruc']."&nrodoc=&contexto=ti-it&tQuery=on&search1=".$_GET['txtruc']."&codigo=".strtoupper($_GET['txtcaptcha'])."&tipdoc=1&search2=&coddpto=&codprov=&coddist=&search3=";
      $ch = curl_init();
      $timeout = 0;
      curl_setopt($ch, CURLOPT_COOKIESESSION, false);
      curl_setopt($ch, CURLOPT_COOKIE, "ITMRCONSRUCSESSION=".$_GET['txtsesionruc']);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_REFERER, $url);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
      //curl_setopt($ch, CURLOPT_DECODING,"");
      curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
      curl_setopt($ch, CURLOPT_AUTOREFERER,true);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      $data = curl_exec($ch);
      curl_close($ch);

      //$data= mb_convert_encoding($data,"utf-8","ISO-8859-1");
      //$data=htmlspecialchars_decode(utf8_decode(htmlentities($data, ENT_COMPAT, 'utf-8', false)));
      $data= iconv("ISO-8859-1","UTF-8",$data);

      $chars = preg_split('/<[^>]*[^\/]>/i', $data, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

      /*Manejando errores*/
      /*Si el captcha es el incorrecto*/
      $clave = array_search('El codigo ingresado es incorrecto', $chars);
      if (!empty($clave)){
        echo '01';
        exit();
      }else{
        /*Nro de ruc no existe*/
        $searchword = 'Debe verificar';
        $matches = array();
        foreach($chars as $k=>$v) {
          if(preg_match("/\b$searchword\b/i", $v)) {
            $matches[$k] = $v;
          }
        }
        $cnt=count($matches);
        if($cnt>0){
          echo '02';
          exit();
        }else{
          /*Si existe un error execption*/
          $searchword = 'Surgieron problemas al procesar la consulta';
          $matches = array();
          foreach($chars as $k=>$v) {
            if(preg_match("/\b$searchword\b/i", $v)) {
              $matches[$k] = $v;
            }
          }
          $cnt=count($matches);
          if ($cnt>0){
            echo '03';
            exit();
          }
        }
      }

      $raz=$chars[18];
      $raz=substr($raz,strpos($raz,'-')+2,500);

      $searchword = 'Domicilio Fiscal';
      $matches = array();
      foreach($chars as $k=>$v) {
        if(preg_match("/\b$searchword\b/i", $v)) {
          $matches[$k] = $v;
          break;
        }
      }
      ?>
      <input type="hidden" name="nom_raz_soc_w" id="nom_raz_soc_w" value="<? echo $raz; ?>"  />
      <input type="hidden" name="direccion_w" id="direccion_w" value="<? echo $chars[$k+2]; ?>" >
      <?
      break;











      case 'loadeqhali':
      //$url="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias?accion=consPorRuc&razSoc=&nroRuc=".$_GET['txtruc']."&nrodoc=&contexto=ti-it&tQuery=on&search1=".$_GET['txtruc']."&codigo=".strtoupper($_GET['txtcaptcha'])."&tipdoc=1&search2=&coddpto=&codprov=&coddist=&search3=";
      $url="http://limacentro.login.minsa.gob.pe/api/v1/ciudadano/01/".$_GET['txtnro_doc']."/";
      $ch = curl_init();
      $timeout = 0;
      curl_setopt($ch, CURLOPT_COOKIESESSION, false);
      curl_setopt($ch, CURLOPT_COOKIE, "csrftoken=p3YObet9f5WwBZYbXMWzgs92Q1ED2Xuj3GVcmyPbt4iAzFrfIk1pQlOnI5pbv5oW ; sessionid=.eJxdj8uOwyAMRf-F9STiYSDusvt-AwIbJpmpEomE1Wj-vaTqppWX5x77-k9QqzWvR-ClLnugjbO4COPE1wdpbeFOtFNJOUiDNiYPwN4PmKwfMk5IRZpsUXU3tmMOx_ab1-5kg1J7kA4sgzSSmGRi6woRTF6xKgQy0umFp9j2XEOK1PXzJv_E9XsbaVuPuqTxjIwvuo-33vh-fWXfFsxxn7tdel_m1Aes1YixZIVEE6PVSjETxWTA0Lv8fNbIyYL4fwCMMF1r:1guldZ:l5T6_H1dKYx_kns-xeFboCZ9giU");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_REFERER, $url);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
      //curl_setopt($ch, CURLOPT_DECODING,"");
      curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
      curl_setopt($ch, CURLOPT_AUTOREFERER,true);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      $data = curl_exec($ch);
      curl_close($ch);

      //$data= mb_convert_encoding($data,"utf-8","ISO-8859-1");
      //$data=htmlspecialchars_decode(utf8_decode(htmlentities($data, ENT_COMPAT, 'utf-8', false)));
      $data= iconv("ISO-8859-1","UTF-8",$data);
      $chars = preg_split('/<[^>]*[^\/]>/i', $data, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

      $convert= $chars[0];
      $result=json_decode($convert);
      $var=(array)$result;
      //print_r($var);
      if (isset($var['nombres'])){
        if($var['sexo']=='1'){$varsexo='1';}else{$varsexo='2';}
        if($var['domicilio_direccion_actual']==''){$vardir=  $var['domicilio_direccion']; }else{$vardir=$var['domicilio_direccion_actual'];}
        ?>
        <input type="hidden" name="namepersona" id="namepersona" value="<? echo utf8_decode($var['nombres']); ?>"/>
        <input type="hidden" name="paternopersona" id="paternopersona" value="<? echo utf8_decode($var['apellido_paterno']); ?>"/>
        <input type="hidden" name="maternopersona" id="maternopersona" value="<? echo utf8_decode($var['apellido_materno']); ?>"/>
        <input type="hidden" name="sexpersona" id="sexpersona" value="<? echo $varsexo; ?>"/>
        <input type="hidden" name="direccionpersona" id="direccionpersona" value="<? echo utf8_decode($vardir); ?>"/>
        <input type="hidden" name="edadpersona" id="edadpersona" value="<? echo utf8_decode($var['edad_anios']); ?>"/>
        <input type="hidden" name="fotopersona" id="fotopersona" value="<? echo $var['foto']; ?>"/>
        <input type="hidden" name="nacimientopersona" id="nacimientopersona" value="<? echo $var['fecha_nacimiento']; ?>"/>
        <img src="data:image/png;base64, <? echo $var['foto']; ?>" />

        <?

      }else{
        echo "NO";
      }


      break;


      case 'reloadeqhali':
      $url="http://logincentral.minsa.gob.pe";
      $ch = curl_init();
      $timeout = 60;
      curl_setopt($ch, CURLOPT_COOKIESESSION, true);
      curl_setopt($ch, CURLOPT_COOKIE, "csrftoken=CqpqIojatsMIUk0IOwJ3W1s0JiYJjsGzbOlOoCKpBnVu8H6JrknS9ZHjrREXLODo");
      //curl_setopt($ch, CURLOPT_COOKIE, "JSESSIONID=97657851cea76682ed7514148f6919dea3d82fdda54.mALvn6iL-B9zpAzzmMTBpQ8Iq6iUaNaKbxD3lN4PagSLa34Iah8K-xuL-AeSa69zaMSLa6aPa64Obh0QawSHc30Ka2bEaAjzawTwp65ynh4IqAjIokjx-ArJmwTKngaLbxuSc3mObhmxf2bQmkLMnkqxn6jAmljGr5XDqQLvpAe_");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "csrfmiddlewaretoken=99xrVKNnO6TUaYnUy42ugNxVOc2EgRS1IxtPBYeCW12GoltVbSGjtLMewLISIdPQ&username=16718068&password=cuzquen16&app_identifier=pe.gob.minsa.citas&login_uuid=");
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);/*verificar y cambiar a false para que funcione*/
      //curl_setopt ($ch, CURLOPT_SAFE_UPLOAD, false);
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_HEADER, true);
      curl_setopt($ch, CURLOPT_REFERER, $url);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
      //curl_setopt($ch, CURLOPT_DECODING,"");
      curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
      curl_setopt($ch, CURLOPT_AUTOREFERER,true);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      $data = curl_exec($ch);
      //curl_close($ch);

      $data= iconv("ISO-8859-1","UTF-8",$data);
      $chars = preg_split('/<[^>]*[^\/]>/i', $data, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);


      $csrftoken=substr($chars[0],strpos($chars[0],'csrftoken')+10,64);
      $sessionid=substr($chars[0],strpos($chars[0],'sessionid')+10,400);
      $separator=strpos($sessionid,'Domain')-2;
      $sessionidfinal=substr($sessionid,0,$separator);


      //$sessionid=substr($chars[0],strpos($chars[0],'sessionid')+10,302);
      //$csrftoken=substr($chars[0],strpos($chars[0],'csrftoken')+10,64);



      $urlki="http://limacentro.login.minsa.gob.pe/api/v1/ciudadano/01/".$_GET['txtnro_doc']."/";
      $chki = curl_init();
      $timeout = 0;
      curl_setopt($chki, CURLOPT_COOKIESESSION, false);
      curl_setopt($chki, CURLOPT_COOKIE, "csrftoken=".$csrftoken."; sessionid=".$sessionidfinal);
      curl_setopt($chki, CURLOPT_URL, $urlki);
      curl_setopt($chki, CURLOPT_POST, 0);
      curl_setopt($chki, CURLOPT_SSL_VERIFYHOST,false);
      curl_setopt($chki, CURLOPT_SSL_VERIFYPEER,false);
      curl_setopt($chki, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($chki, CURLOPT_HEADER, false);
      curl_setopt($chki, CURLOPT_REFERER, $urlki);
      curl_setopt($chki, CURLOPT_AUTOREFERER, true);
      //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($chki, CURLOPT_FOLLOWLOCATION,true);
      //curl_setopt($ch, CURLOPT_DECODING,"");
      curl_setopt($chki, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
      curl_setopt($chki, CURLOPT_AUTOREFERER,true);
      curl_setopt($chki, CURLOPT_CONNECTTIMEOUT, $timeout);
      $dataki = curl_exec($chki);
      curl_close($chki);

      //$data= mb_convert_encoding($data,"utf-8","ISO-8859-1");
      //$data=htmlspecialchars_decode(utf8_decode(htmlentities($data, ENT_COMPAT, 'utf-8', false)));
      $dataki= iconv("ISO-8859-1","UTF-8",$dataki);
      $charski = preg_split('/<[^>]*[^\/]>/i', $dataki, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

      $error=strpos($charski[0],'Bad Request');
      echo $error;
      //echo $charski[0];exit();

      if (empty($error)){
        $convert= $charski[0];
        $result=json_decode($convert);
        $var=(array)$result;
        //print_r($var);
        if($var['sexo']=='1'){$varsexo='1';}else{$varsexo='2';}
        if($var['domicilio_direccion_actual']==''){$vardir=  $var['domicilio_direccion']; }else{$vardir=$var['domicilio_direccion_actual'];}
        ?>
        <input type="hidden" name="namepersona" id="namepersona" value="<? echo utf8_decode($var['nombres']); ?>"/>
        <input type="hidden" name="paternopersona" id="paternopersona" value="<? echo utf8_decode($var['apellido_paterno']); ?>"/>
        <input type="hidden" name="maternopersona" id="maternopersona" value="<? echo utf8_decode($var['apellido_materno']); ?>"/>
        <input type="hidden" name="sexpersona" id="sexpersona" value="<? echo $varsexo; ?>"/>
        <input type="hidden" name="direccionpersona" id="direccionpersona" value="<? echo utf8_decode($vardir); ?>"/>
        <input type="hidden" name="edadpersona" id="edadpersona" value="<? echo utf8_decode($var['edad_anios']); ?>"/>
        <input type="hidden" name="fotopersona" id="fotopersona" value="<? echo $var['foto']; ?>"/>
        <input type="hidden" name="nacimientopersona" id="nacimientopersona" value="<? echo $var['fecha_nacimiento']; ?>"/>
        <img src="data:image/png;base64, <? echo $var['foto']; ?>" />
      <?
      }else {echo "error"; }


      break;


      case 'ReLoadCaptchaSunat':
      $ckfile = tempnam(sys_get_temp_dir(), "CURLCOOKIE");
      $ch = curl_init ();
      //curl_setopt($ch, CURLOPT_URL, "http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image");
      curl_setopt($ch, CURLOPT_URL, "http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image&nmagic=0");
      curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
      curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
      $output = curl_exec ($ch);
      $saveto="../dist/img/generado.jpg";
      $fp = fopen($saveto,'w');
      fwrite($fp, $output);
      fclose($fp);
      curl_close( $ch );
      $focont='';
      $fp = fopen($ckfile, "r");
      while(!feof($fp))
      {
        $focont .= fread($fp, 8192);
      }
      fclose($fp);
      $key='ITMRCONSRUCSESSION';
      $rucses=substr($focont,(strpos($focont,$key)+strlen($key)),500);
      ?>
      <img src="../dist/img/generado.jpg?rand<? echo rand();?>" name="img_captcha" ><input type="hidden" name="txtsesionruc" id="txtsesionruc" value="<? echo $rucses; ?>" >
      <?
      break;

      case 'LoadImgReniec':

      $ckfile = tempnam(sys_get_temp_dir(), "CURLCOOKIE");
      $ch = curl_init ();
      //curl_setopt($ch, CURLOPT_URL, "http://www.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image");
      curl_setopt($ch, CURLOPT_URL, "https://cel.reniec.gob.pe/valreg/codigo.do");
      curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
      curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); /*agregar para que funcione*/
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); /*agregar para que funcione*/
      //curl_setopt ($ch, CURLOPT_SAFE_UPLOAD, false);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $output = curl_exec($ch);
      $saveto="../dist/img/imgreniec.jpg";
      $fp = fopen($saveto,'w');
      fwrite($fp, $output);
      fclose($fp);
      curl_close($ch);
      $focont='';
      $fp = fopen($ckfile, "r");
      while(!feof($fp))
      {
        $focont .= fread($fp, 8192);
      }
      fclose($fp);
      unlink($ckfile);
      //$key='ITMRCONSRUCSESSION';
      $key='JSESSIONID';

      $rucses=substr($focont,(strpos($focont,$key)+strlen($key)),500);
      ?>
      <img style="width:102px; height:28px;" src="../dist/img/imgreniec.jpg?rand<? echo rand();?>" name="img_captcha">
      <input  type="hidden" name="txtsesion_reniec" id="txtsesion_reniec" value="<? echo $rucses; ?>" >
      <?

      break;

      case 'LoadDataReniec':
      //echo $_POST['txtsession_reniec'].'<br>';
      $url="https://cel.reniec.gob.pe/valreg/valreg.do?accion=buscar&tecla_0=&tecla_1=&tecla_2=&tecla_3=&tecla_4=&tecla_5=&tecla_6=&tecla_7=&tecla_8=&tecla_9&nuDni=".$_POST['nro_doc']."&imagen=".strtoupper($_POST['txtimg'])."&bot_consultar.x=130&bot_consultar.y=14";
      $ch = curl_init();
      $timeout = 60;
      curl_setopt($ch, CURLOPT_COOKIESESSION, false);
      curl_setopt($ch, CURLOPT_COOKIE, "JSESSIONID=".trim($_POST['txtsession_reniec']));
      //curl_setopt($ch, CURLOPT_COOKIE, "JSESSIONID=97657851cea76682ed7514148f6919dea3d82fdda54.mALvn6iL-B9zpAzzmMTBpQ8Iq6iUaNaKbxD3lN4PagSLa34Iah8K-xuL-AeSa69zaMSLa6aPa64Obh0QawSHc30Ka2bEaAjzawTwp65ynh4IqAjIokjx-ArJmwTKngaLbxuSc3mObhmxf2bQmkLMnkqxn6jAmljGr5XDqQLvpAe_");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);/*verificar y cambiar a false para que funcione*/
      //curl_setopt ($ch, CURLOPT_SAFE_UPLOAD, false);
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_REFERER, $url);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
      //curl_setopt($ch, CURLOPT_DECODING,"");
      curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
      curl_setopt($ch, CURLOPT_AUTOREFERER,true);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      $data = curl_exec($ch);
      curl_close($ch);
      //echo $data;
      $data= iconv("ISO-8859-1","UTF-8",$data);
      $chars = preg_split('/<[^>]*[^\/]>/i', $data, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

      $searchword = 'No se encuentra en el Archivo';
      $matches = array();
      foreach($chars as $k=>$v) {
        if(preg_match("/\b$searchword\b/i", $v)) {
          $matches[$k] = $v;
          break;
        }
      }
      $cnt=count($matches);
      if($cnt>0){
        echo '01';
      }else{
        $searchword = 'expirado';
        $matches = array();
        foreach($chars as $k=>$v) {
          if(preg_match("/\b$searchword\b/i", $v)) {
            $matches[$k] = $v;
            break;
          }
        }
        $cnt=count($matches);
        if ($cnt>0){
          echo '02';
        }else{
          $searchword = 'aparece en la imagen';
          $matches = array();
          foreach($chars as $k=>$v) {
            if(preg_match("/\b$searchword\b/i", $v)) {
              $matches[$k] = $v;
              break;
            }
          }
          $cnt=count($matches);
          if ($cnt>0){
            echo '03';
          }else{
            if (isset($chars[146])){
              $rpta=trim($chars[146]);
              echo str_replace("        ","|",$rpta);
            }else{
              echo '04';
            }
          }
        }
      }


      break;

      case 'Find_PersonaJ':

      $rs=$per->QryPersonaJ($_GET['PerJu']);
      $aj=array();
      $aj['id_persona']=$rs[0]['id_persona'];
      $aj['nombre_rs']=$rs[0]['nombre_rs'];
      echo json_encode($aj);
      break;

      case 'Find_PersonaN':

      $rs=$per->QryPersonaN($_GET['PerNa']);
      $aj=array();
      $aj['id_persona']=$rs[0]['id_persona'];
      $aj['nombre_rs']=$rs[0]['primer_ape']." ".$rs[0]['segundo_ape'].", ".$rs[0]['nombre_rs'];
      echo json_encode($aj);
      break;

      case 'LoadHt':

      $result=$exp->QryLoadHt($_GET['tipo'],$_GET['anio'],$_GET['nro_ht']);
      $nr=count($result);
      if($nr>0){
        $datos=array(
          0 => $result[0]['idtipo_doc_ht'],
          1 => $result[0]['nro_doc_ht'],
          2 => $result[0]['asunto_ht'],
          3 => $result[0]['obs_ht'],
          //4 => $result[0]['nro_folio_mov'],
          5 => $result[0]['id_clasificacion'],
          6 => $result[0]['id_prioridad'],
          7 => $result[0]['idproc_ht'],
          8 => $result[0]['anio_ht'],
          9 => $result[0]['nro_ht'],
          10 => $result[0]['nro_ht_externo'],
          11 => $result[0]['anio_deuda'],
          12 => $result[0]['cantidad_cgar'],
          13 => $result[0]['monto_pago'],
        );
      }
      //$result = pg_fetch_array($result);
      echo json_encode($datos);
      /*$rResultd=$exp->QryLoadHt($_GET['tipo'],$_GET['anio'],$_GET['nro_ht']);
      $arr = array();
      $arr['idtipo_doc_ht']=$rResultd[0]['idtipo_doc_ht'];
      $arr['nro_doc_ht']=$rResultd[0]['nro_doc_ht'];
      echo json_encode($arr);*/

      break;


      case 'load_estados':

      echo "<select class='form-control input-sm ' name='cboestadoht' id='cboestadoht' multiple='multiple' >";
      $rs=$tab->listaTablas('15');
      foreach ($rs as $row) {
        if($_GET['id_situacion']=='1'){
          if($row['id_tipo']=='1'||$row['id_tipo']=='2'){$sel=" selected='selected' ";}else {$sel=" ";}
          if($row['id_tipo']=='3'||$row['id_tipo']=='4'||$row['id_tipo']=='5'||$row['id_tipo']=='6'||$row['id_tipo']=='7'){$dis=" disabled='disabled' ";}else {$dis="";}
        }else{
          if($row['id_tipo']=='3'){$sel=" selected='selected' ";}else {$sel=" ";}
          if($row['id_tipo']!='3'){$dis=" disabled='disabled' ";}else {$dis="";}
        }
        //if($row['id_tipo']=='1'||$row['id_tipo']=='2'){$sel=" selected='selected' ";}else {$sel=" ";}
        //if($row['id_tipo']=='3'||$row['id_tipo']=='4'||$row['id_tipo']=='5'||$row['id_tipo']=='6'||$row['id_tipo']=='7'){$dis=" disabled='disabled' ";}else {$dis="";}
        echo "<option value='".$row['id_tipo']."' ".$dis.$sel.">".$row['descripcion']."</option>";}
        echo "</select>";

        break;

        case 'load_personal':

        $aides= $_GET['id_dep'];
        //$a=array();
        if($_GET['id_dep']!=$_SESSION['id_dep'] || $_SESSION['id_rol']=='5')
        { $disabled="disabled='disabled'"; } else{ $disabled ="";}
        echo "<select class='form-control input-sm ' name='cboidpersonal' id='cboidpersonal' multiple='multiple' >";
        for ($i=0;$i< count($aides);$i++)
        {
          $a=array();
          $a[0]=$aides[$i];
          $rs=$per->personalQry($a);
          //  $a[$i]['persona']=$rs[0]['persona'];
          //$rs=$per->personalQry($_GET['id_dep']);
          //echo "<option value=''>--Seleccione Personal--</option>";
          //foreach ($rs as $row) {
          if ($rs[0]['id_rol']!='5') $sel=" selected='selected' "; else $sel="";
          echo "<option ".$sel." data-email='".$rs[0]['email_persona']."' data-idper='".$rs[0]['id_usuario']."' value='".$rs[0]['id_usuario']."'>".$rs[0]['persona']."</option>";
        }
        //}
        echo "</select>";
        break;

        case 'load_personalder':
        $aides= $_GET['id_dep'];
        //$a=array();

        if($_GET['id_dep']!=$_SESSION['id_dep'] || $_SESSION['id_rol']=='5')
        { $disabled="disabled='disabled'"; } else{ $disabled ="";}
        echo "<select class='form-control input-sm ' name='cboidpersonal' id='cboidpersonal' multiple='multiple' >";
        for ($i=0;$i< count($aides);$i++)
        {
          $a=array();
          $a[0]=$aides[$i];
          $rs=$per->personalQryder($a);
          //  $a[$i]['persona']=$rs[0]['persona'];
          //$rs=$per->personalQry($_GET['id_dep']);
          //echo "<option value=''>--Seleccione Personal--</option>";
          foreach ($rs as $row) {

            if ($row['id_dep']!=$_SESSION['id_dep'] && $row['id_rol']!='2') { $disabled=" disabled='disabled' "; } else{ $disabled ="";}
            if ($row['id_dep']!=$_SESSION['id_dep'] && $row['id_rol']=='2') { $sel=" selected='selected' "; }else{ $sel="";}
            if ($row['id_usuario'] != $_SESSION['id_usuario'] ) {
              echo "<option ".$sel.$disabled." data-email='".$row['email_persona']."' data-idper='".$row['id_usuario']."' value='".$row['id_usuario']."'>".$row['persona']."</option>";
            }
          }
        }
        echo "</select>";
        //echo $row['id_dep']."-".$_SESSION['id_dep']."---".$row['id_rol'];
        break;

        case 'load_personalder_mr':
        $aides= $_GET['id_dep'];
        if($_GET['id_dep']!=$_SESSION['id_dep'] || $_SESSION['id_rol']=='5')
        { $disabled="disabled='disabled'"; } else{ $disabled ="";}
        echo "<select class='form-control input-sm ' name='cboidpersonal_mr' id='cboidpersonal_mr' multiple='multiple' >";
        for ($i=0;$i< count($aides);$i++)
        {
          $a=array();
          $a[0]=$aides[$i];
          $rs=$per->personalQryder($a);
          foreach ($rs as $row) {
            if ($row['id_dep']!=$_SESSION['id_dep'] && $row['id_rol']!='2') { $disabled=" disabled='disabled' "; } else{ $disabled ="";}
            if ($row['id_dep']!=$_SESSION['id_dep'] && $row['id_rol']=='2') { $sel=" selected='selected' "; }else{ $sel="";}
            if ($row['id_usuario'] != $_SESSION['id_usuario'] ) {
              echo "<option ".$sel.$disabled." data-email='".$row['email_persona']."' data-idper='".$row['id_usuario']."' value='".$row['id_usuario']."'>".$row['persona']."</option>";
            }
          }
        }
        echo "</select>";
        break;

        case 'load_personalder_m':

        $aides= $_GET['id_dep'];
        //$a=array();

        if($_GET['id_dep']!=$_SESSION['id_dep'] || $_SESSION['id_rol']=='5')
        { $disabled="disabled='disabled'"; } else{ $disabled ="";}
        echo "<select class='form-control input-sm ' name='cboidpersonal_m' id='cboidpersonal_m' multiple='multiple' >";
        for ($i=0;$i< count($aides);$i++)
        {
          $a=array();
          $a[0]=$aides[$i];
          $rs=$per->personalQryder($a);
          //  $a[$i]['persona']=$rs[0]['persona'];
          //$rs=$per->personalQry($_GET['id_dep']);
          //echo "<option value=''>--Seleccione Personal--</option>";
          foreach ($rs as $row) {
            if ($row['id_dep']!=$_SESSION['id_dep'] && $row['id_rol']!='2') { $disabled=" disabled='disabled' "; } else{ $disabled ="";}
            if ($row['id_dep']!=$_SESSION['id_dep'] && $row['id_rol']=='2') { $sel=" selected='selected' "; }else{ $sel="";}
            if ($row['id_usuario'] != $_SESSION['id_usuario'] ) {
              echo "<option ".$sel.$disabled." data-email='".$row['email_persona']."' data-idper='".$row['id_usuario']."' value='".$row['id_usuario']."'>".$row['persona']."</option>";
            }
          }
        }
        echo "</select>";
        //echo $row['id_dep']."-".$_SESSION['id_dep']."---".$row['id_rol'];

        break;

        case 'load_personalall':

        $aides= $_GET['id_dep'];
        //$a=array();

        if($_GET['id_dep']!=$_SESSION['id_dep'] || $_SESSION['id_rol']=='5')
        { $disabled="disabled='disabled'"; } else{ $disabled ="";}
        echo "<select class='form-control input-sm ' name='cboidpersonalall' id='cboidpersonalall' multiple='multiple' >";
        for ($i=0;$i< count($aides);$i++)
        {
          $a=array();
          $a[0]=$aides[$i];
          $rs=$per->personalQryder($a);
          //  $a[$i]['persona']=$rs[0]['persona'];
          //$rs=$per->personalQry($_GET['id_dep']);
          //echo "<option value=''>--Seleccione Personal--</option>";
          foreach ($rs as $row) {

            if ($row['id_dep']!=$_SESSION['id_dep'] && $row['id_rol']!='2') { $disabled=" disabled='disabled' "; } else{ $disabled ="";}
            if ($row['id_dep']!=$_SESSION['id_dep'] && $row['id_rol']=='2') { $sel=" selected='selected' "; }else{ $sel="";}
            if ($row['id_usuario'] != $_SESSION['id_usuario'] ) {
              echo "<option ".$sel.$disabled." data-email='".$row['email_persona']."' data-idper='".$row['id_usuario']."' value='".$row['id_usuario']."'>".$row['persona']."</option>";
            }
          }
        }
        echo "</select>";
        //echo $row['id_dep']."-".$_SESSION['id_dep']."---".$row['id_rol'];

        break;

        case 'reloadPersona':

        echo'<select id="cboidpersonal" name="cboidpersonal" multiple="multiple" class="form-control input-sm">';

        $rs=$per->personalQryMain();
        foreach ($rs as $row) {
          echo "<option value='".$row['id_persona']."'>".$row['persona']."</option>";}
          echo "</select>";

          break;


          case 'load_personalmp':
          //$aides= $_GET['id_dep'];
          //$a=array();
          echo "<select class='form-control input-sm ' name='cboidpersonal' id='cboidpersonal' multiple='multiple' >";
          //for ($i=0;$i< count($aides);$i++)
          //  {
          //  $a=array();
          //  $a[0]=$aides[$i];
          $rs=$per->personalQrymp($_GET['id_dep']);
          //  $a[$i]['persona']=$rs[0]['persona'];
          //$rs=$per->personalQry($_GET['id_dep']);
          //echo "<option value=''>--Seleccione Personal--</option>";
          //foreach ($rs as $row) {
          if ($rs[0]['id_rol']=='5') $sel=" selected='selected' "; else $sel="";
          echo "<option ".$sel." data-email='".$rs[0]['email_persona']."' data-idper='".$rs[0]['id_usuario']."' value='".$rs[0]['id_usuario']."'>".$rs[0]['persona']."</option>";
          //  }
          //}
          echo "</select>";
          break;

          case 'cboOfi':
          $rs=$dep->listOfiCbo($_GET['id_equipo']);
          echo "<option value=''>--Seleccione--</option>";
          foreach ($rs as $row) {
            //if ($_GET['id_default']==$row['id_organo']) $sel=" selected='selected' "; else $sel="";
            echo "<option value='".$row['id_dep']."'>".$row['nom_dep']."</option>";
          }
          break;

          case 'cbodeptipo_____':
          $rs=$dep->listDepTipo($_GET['idtipo']);
          echo "<option value=''>--Seleccione--</option>";
          foreach ($rs as $row) {
            //if ($_GET['id_default']==$row['id_organo']) $sel=" selected='selected' "; else $sel="";
            echo "<option value='".$row['id_dep']."'>".$row['nom_dep']."</option>";
          }
          break;

          case 'cbodeptipo':

          $rs=$dep->listDepTipo($_GET['idtipo']);
          echo "<select class='form-control input-sm ' name='cbodeppadre' id='cbodeppadre' >";
          foreach ($rs as $row)
          {
            if ($row['idestado_dep']=='2') $dis=" disabled='disabled' "; else $dis="";
            echo "<option ".$dis." value='".$row['id_dep']."'>".$row['nom_dep']."</option>";
          }
          //}
          echo "</select>";
          break;

          case 'RefreshDate':
          echo date('Ymdhis');
          break;

          case 'FindAfiliado': //Busca en data
          $rs=$per->PersonaNaturalGet($_GET['nro_doc']);
          $cnt=count($rs);
          $afi=array();
          if ($cnt>0){
            //echo $afi['nro_documento']=$rs[0]['nro_documento'];
            $afi['nro_documento']=$rs[0]['nro_documento'];
            $afi['id_persona']=$rs[0]['id_persona'];
            $afi['nombre']=$rs[0]['nombre'];
            $afi['ape_pat']=$rs[0]['ape_pat'];
            $afi['ape_mat']=$rs[0]['ape_mat'];
          }else{
            $afi['msj']='01';
          }
          echo json_encode($afi);
          break;


          case 'FindAfiliado_': //Busca en data
          $rs=$per->PersonaNaturalGet($_GET['nro_doc']);
          $cnt=count($rs);
          $afi=array();
          if ($cnt>0){
            //echo $afi['nro_documento']=$rs[0]['nro_documento'];
            $afi['nro_documento']=$rs[0]['nro_documento'];
            $afi['id_persona']=$rs[0]['id_persona'];
            $afi['nombre']=$rs[0]['nombre'];
            $afi['ape_pat']=$rs[0]['ape_pat'];
            $afi['ape_mat']=$rs[0]['ape_mat'];
          }else{
            $lerror=false;
            ini_set("default_socket_timeout", 5);
            $client=new nusoap_client("http://wsdl.saludpol.gob.pe:8083/ws/ws_AfiliadoSALUDPOL.php?wsdl",true);

            $client->soap_defencoding='utf-8';  //ISO-8859-1
            $client->decodeUTF8(false);
            $err=$client->getError();
            if ($err) {
              $lerror=true;
            }
            $param=array('nroDoc'=>$_GET['nro_doc']);
            $client->setCredentials("userafis@ludpol", "WS@ludPol@fi", "basic");
            $result=$client->call('get_busafi_activo',$param);
            if ($client->fault) {
              $lerror=true;
            } else {
              $err=$client->getError();
              if ($err) {
                $lerror=true;
              }
            }
            if ($lerror==false){
              //print_r($result);exit();
              $cntarray=count($result);
              if($cntarray>0){
                //echo $result[0]['apepatafiliado']." ".$result[0]['apematafiliado'].", ".$result[0]['nomafiliado'];
                $afiws=$result;
                $afi['msj']='';
                $afi['nro_documento']=$afiws[0]['nrodocafiliado'];
                $afi['id_persona']=$afiws[0]['nrodocafiliado'];
                $afi['nombre']=$afiws[0]['nomafiliado'];
                $afi['ape_pat']=$afiws[0]['apepatafiliado'];
                $afi['ape_mat']=$afiws[0]['apematafiliado'];
              }else {
                $afi['msj']='01';
              }

            }else {
              $afi['msj']='02';
            }
          }
          echo json_encode($afi);
          break;



          case 'FindJuridica': //Busca en data
          $rs=$per->PersonaJuridicaGet($_GET['nro_doc']);
          $cnt=count($rs);
          $afi=array();
          if ($cnt>0){
            //echo $afi['nro_documento']=$rs[0]['nro_documento'];
            $afi['nro_documento']=$rs[0]['nro_documento'];
            $afi['id_persona']=$rs[0]['id_persona'];
            $afi['nombre']=$rs[0]['nombre'];
            $afi['ape_pat']=$rs[0]['ape_pat'];
            $afi['ape_mat']=$rs[0]['ape_mat'];
          }else{
            $afi['msj']='01';
          }
          echo json_encode($afi);
          break;
          case 'LOAD_MENUS':
          ?>
          <select multiple="multiple" name="lstsubmenus" style="height:200px; width:280px; font-size:14px;" class="form-control input-sm" id="lstsubmenus" >
            <? $rs=$acc->submenuList($_GET['cboidpad']);
            foreach ($rs as $row) {
              echo "<option  value='".$row['id_menu']."' >".$row['bar_name']."</option>";
            }
            echo "</select>";
            break;

            case 'LOAD_ACCESOS':
            ?>
            <select multiple="multiple" name="lstaccesos" style="height:200px; width:280px; font-size:14px;" class="form-control input-sm" id="lstaccesos" >
              <? $rs=$acc->accesosList($_GET['cboiduser']);
              foreach ($rs as $row) {
                echo "<option  value='".$row['id_menu']."' >".$row['bar_name']."</option>";
              }
              echo "</select>";
              break;

              case 'CRUD_ACCESOS':
              $a=array();
              //$ai=explode(',',$_GET['id_menu']);
              //echo $_GET['id_menu'];
              $ai=$_GET['id_menu'];
              $a[0]['ope']=$_GET['ope'];
              $a[0]['cnt_records']=count($ai);
              $a[0]['id_usuario']=$_GET['id_usuario'];
              $a[0]['id_menu']=to_pg_array($ai);
              $a[0]['cboidpad']=$_GET['cboidpad'];
              $a[0]['usr_id']=$_SESSION['usr_id'];
              $rs=$acc->accesosCrud($a);
              //echo 'texto de rueba';
              break;

              case 'cboloadDep':
              ?>
              <select id="cbodestinatario" name="cbodestinatario" multiple="multiple"  class="form-control  input-sm">
                <?
                if($_GET['iddep']==''){
                  if($_SESSION['id_rol']!=5){
                    $rs=$dep->listaDependencias($_SESSION["peso"]);
                  }else{
                    $rs=$dep->listaDependenciasmp();
                  }
                }else{
                  $rs=$dep->listaEspecial($_GET['iddep']);
                }
                foreach ($rs as $row) {
                  echo "<option value='".$row['id_dep']."'>".$row['nom_dep']."</option>";}  ?>
                </select>
                <?
                break;


                case 'loadorder':
                //$fechaActual = date ( 'Y-m-d H:i:s');
                //$nuevafecha = strtotime ( '-30 second' , strtotime ( $fechaActual ) ) ;
                $rs=$men->nextOrder($_GET['idmenu']);
                foreach ($rs as $row) {
                  echo $row['maximo'];
                }
                //echo  date('Y-m-d', $nuevafecha);
                break;

                case 'loadExpeRefresh':
                //$fechaActual = date ( 'Y-m-d H:i:s');
                //$nuevafecha = strtotime ( '-30 second' , strtotime ( $fechaActual ) ) ;
                $rs=$exp->listaLastExpediente();
                foreach ($rs as $row) {
                  echo $row['total'];
                }
                //echo  date('Y-m-d', $nuevafecha);
                break;


                case 'EDIT_HT':
                $datos=array();
                $result=$exp->QryEditHt($_GET['id'],$_GET['anio'],$_GET['nroht'],$_GET['nromov']);
                $nr=count($result);
                if($nr>0){
                  $datos=array(
                    0 => $result[0]['idproc_ht'],
                    1 => $result[0]['tipo_doc'],
                    2 => $result[0]['anio_ht'],
                    3 => $result[0]['nro_ht'],
                    4 => $result[0]['idtipo_doc_ht'],
                    5 => $result[0]['nro_doc_ht'],
                    6 => $result[0]['asunto_ht'],
                    7 => $result[0]['nro_folio'],
                    8 => $result[0]['anio_ht'],
                    9 => $result[0]['obs_mov'],
                    10 => $result[0]['dep_recibe'],
                    11 => $result[0]['usu_recibe'],
                    12 => $result[0]['nro_mov'],
                  );
                }
                //$result = pg_fetch_array($result);
                echo json_encode($datos);
                //echo $result;
                break;

                case 'load_validHT':
                $rs=$exp->QrySearchHT($_GET['cbtipodoc'],$_GET['cboanio'],$_GET['txtnro_ht'],$_GET['txtnro_doc'],strtoupper($_GET['txtrazonsocial']),strtoupper($_GET['txtapepat']),strtoupper($_GET['txtapemat'])  ,$_GET['cbotipodocht'] ,$_GET['txtnrodoc_ht']  ,strtoupper($_GET['txtasunto']));
                $j=0;
                echo "<div class='box-body table-responsive no-padding'>";
                echo "<br>";
                echo "<span class='label-success-search'>Principal</span>&nbsp;";
                echo "<span class='label-info-search'>Copias</span>&nbsp;";
                echo "<span class='label-danger-search'>Anulado</span>";
                echo "<span class=''>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><label><b>Nota </b>: Solo se genera copia del HT Principal</label></em></span>";
                echo "<table class='table table-hover'>";
                echo "<tr>
                <th>ID</th>
                <th>Procedimiento</th>
                <th>Fecha Registro</th>
                <th>HT</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Asunto</th>
                <th>Folios</th>
                <th>Acción</th>
                </tr>";
                for ($i=0;$i< count($rs);$i++)
                {
                  $findme   = '-';
                  $pos = strpos($rs[$i]['nro_ht'],$findme);
                  if ($rs[$i]['idestado_ht']=='1'){
                    if ($pos === false) { $class_copy=" class='success' ";}else { $class_copy=" class='info' ";}
                  }else {
                    $class_copy=" class='danger' ";
                  }
                  $j++;
                  echo "<tr $class_copy >";
                  echo "<td>".$j."</td>";
                  echo "<td>".$rs[$i]['tipo_doc']."</td>";
                  echo "<td>".$rs[$i]['fecha_doc']."</td>";
                  echo "<td><b>".$rs[$i]['nro_ht']."</b></td>";
                  echo "<td>".$rs[$i]['origen']."</td>";
                  echo "<td>".$rs[$i]['destino']."</td>";
                  echo "<td>".$rs[$i]['asunto_ht']."</td>";
                  echo "<td><b>".$rs[$i]['nro_folio']."</b></td>";
                  if ($rs[$i]['idestado_ht']=='1'){
                    echo '<td>
                    <a href="#" onClick="ShowRuta(\''.$rs[$i]['idproc_ht']."|".$rs[$i]['anio_ht']."|".$rs[$i]['nro_ht'].'\')"><i class="fa fa-eye"></i></a> &nbsp; ';
                    if ($pos === false) { echo '<a href="#" onClick="showgeneraCopy(\''.$rs[$i]['nro_htr'].'\' ,\''.$rs[$i]['idproc_ht']."|".$rs[$i]['anio_ht']."|".$rs[$i]['nro_ht'].'\')"><i class="fa fa-copy"></i></a>&nbsp;';
                    }else { echo '&nbsp;&nbsp;&nbsp;&nbsp;';}
                    echo '<a href="#" onClick="PrintHtblank(\''.$rs[$i]['idproc_ht'].'\',\''.$rs[$i]['anio_ht'].'\',\''.$rs[$i]['nro_ht'].'\')"><i class="fa fa-file-o"></i></a> &nbsp;';
                    echo '<a href="#" onClick="PrintHtMove(\''.$rs[$i]['idproc_ht'].'\',\''.$rs[$i]['anio_ht'].'\',\''.$rs[$i]['nro_ht'].'\')"><i class="fa fa-outdent"></i></a> &nbsp;
                    </td>';
                  }else {
                    echo '<td class="danger"></td>';
                  }
                  echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
                break;

                case 'load_settingHT':
                $rs=$exp->QrySearchHT($_GET['cbtipodoc'],$_GET['cboanio'],$_GET['txtnro_ht'],$_GET['txtnro_doc'],strtoupper($_GET['txtrazonsocial']),strtoupper($_GET['txtapepat']),strtoupper($_GET['txtapemat'])  ,$_GET['cbotipodocht'] ,strtoupper($_GET['txtnrodoc_ht']) ,strtoupper($_GET['txtasunto']));
                $j=0;
                echo "<div class='box-body table-responsive no-padding'>";
                echo "<br>";
                echo "<span class='label-success-search'>Principal</span>&nbsp;";
                echo "<span class='label-info-search'>Copias</span>&nbsp;";
                echo "<span class='label-danger-search'>Anulado</span>";
                echo "<span class=''>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><label><b>Nota </b>: Solo se genera copia del HT Principal</label></em></span>";
                echo "<table class='table table-hover'>";
                echo "<tr>
                <th>ID</th>
                <th>Fecha Registro</th>
                <th>HT</th>
                <th>Destino</th>
                <th>Asunto</th>
                <th>Folios</th>
                <th>Accion</th><input type='hidden' name='div_name' value='' id='div_name'>
                </tr>";
                for ($i=0;$i< count($rs);$i++)
                {
                  $findme   = '-';
                  $pos = strpos($rs[$i]['nro_ht'],$findme);
                  if ($rs[$i]['idestado_ht']=='1'){
                    if ($pos === false) { $class_copy=" class='success' ";}else { $class_copy=" class='info' ";}
                  }else {
                    $class_copy=" class='danger' ";
                  }
                  $j++;
                  echo "<tr $class_copy >";
                  echo "<td>".$j."</td>";
                  echo "<td>".$rs[$i]['fecha_doc']."</td>";
                  echo "<td>".$rs[$i]['nro_htr']."</td>";
                  echo "<td>".$rs[$i]['destino']."</td>";
                  echo "<td>".$rs[$i]['asunto_ht']."</td>";
                  echo "<td>".$rs[$i]['nro_folio']."</td>";
                  //echo '<td><a href="#" onClick="ShowRuta(\''.$rs[$i]['idproc_ht']."|".$rs[$i]['anio_ht']."|".$rs[$i]['nro_ht'].'\')"><i class="fa fa-eye"></i></a> - <a href="#" onClick="showDetail(\''.$rs[$i]['idproc_ht']."|".$rs[$i]['anio_ht']."|".$rs[$i]['nro_ht'].'\')"><i class="fa fa-files-o"></i></a></td>';
                  ?>
                  <td class="text-left resized-ver-20"><a href="#" onClick="$( '#<? echo 'toogle_'.$j; ?>').toggle('slide', {}, 400 ); showDetail('<? echo $rs[$i]['idproc_ht']."|".$rs[$i]['anio_ht']."|".$rs[$i]['nro_ht']; ?>','<? echo 'toogle_'.$j; ?>','<? echo 'img_'.$j; ?>');return false;">
                    <span id="<? echo 'img_'.$j; ?>" class="fa fa-plus-square"></span></a> &nbsp;
                    <a href="#" onClick="showgeneraCopy('<? echo $rs[$i]['nro_htr'];?>','<? echo $rs[$i]['idproc_ht']."|".$rs[$i]['anio_ht']."|".$rs[$i]['nro_ht']; ?>')";><i class="fa fa-copy"></i></a> &nbsp;
                    <a href="#" onClick="ShowRuta('<? echo $rs[$i]['idproc_ht']."|".$rs[$i]['anio_ht']."|".$rs[$i]['nro_ht']; ?>')";><i class="fa fa-eye"></i></a>
                    <a href="#" onClick="show_remit('<? echo $rs[$i]['idproc_ht']; ?>','<? echo $rs[$i]['anio_ht']; ?>','<? echo $rs[$i]['nro_ht']; ?>')";><i class="fa fa-users"></i></a>
                    <? if($rs[$i]['idestado_ht']=='1'){ ?>
                      <a href="#" onClick="acti_anula_ht('1','<? echo $rs[$i]['idproc_ht']; ?>','<? echo $rs[$i]['anio_ht']; ?>','<? echo $rs[$i]['nro_ht']; ?>')";><i class="fa fa-times"></i></a>
                    <? } else {  ?>
                      <a href="#" onClick="acti_anula_ht('2','<? echo $rs[$i]['idproc_ht']; ?>','<? echo $rs[$i]['anio_ht']; ?>','<? echo $rs[$i]['nro_ht']; ?>')";><i class="fa fa-check"></i></a>
                    <? }
                    if($rs[$i]['idestado_ht']=='1'){
                      echo '<a href="#" onClick="PrintHtblank(\''.$rs[$i]['idproc_ht'].'\',\''.$rs[$i]['anio_ht'].'\',\''.$rs[$i]['nro_ht'].'\')"><i class="fa fa-file-o"></i></a> &nbsp;';
                      echo '<a href="#" onClick="PrintHtMove(\''.$rs[$i]['idproc_ht'].'\',\''.$rs[$i]['anio_ht'].'\',\''.$rs[$i]['nro_ht'].'\')"><i class="fa fa-outdent"></i></a> &nbsp;';
                    }else{echo '&nbsp;&nbsp;&nbsp;&nbsp;';}
                    ?>
                  </td>
                  <?
                  echo "</tr>";?>
                  <tr>
                    <td colspan="13" ><div id="<? echo 'toogle_'.$j; ?>" style="display:none;" ></div></td>
                  </tr>
                  <?
                }
                echo "</table>";
                echo "</div>";
                break;

                case 'load_detailHt':
                $rs=$exp->QrySearchdetailHT($_GET['tipodoc'],$_GET['anio'],$_GET['nro_ht']);
                $j=0;
                echo "<div class='box-body table-responsive no-padding'>";
                echo "<table class='table table-condensed table-striped  table-hover table-fit' style='background-color:#beddf7;'>";
                echo "<tr>
                <th><i class='fa fa-angle-double-right'></i></th>
                <th>Nro Mov</th>
                <th>Documento</th>
                <th>N° Documento</th>
                <th>Origen</th>
                <th>Usr Deriva</th>
                <th>Fecha Deriva</th>
                <th>Destino</th>
                <th>Usr. Recibe</th>
                <th>Fecha Recibe</th>

                </tr>";
                for ($i=0;$i< count($rs);$i++)
                {
                  $j++;
                  echo "<tr>";
                  echo '<td><a href="#" onClick="editmoveHt(\''.$rs[$i]['idproc_ht'].'\',\''.$rs[$i]['anio_ht'].'\',\''.$rs[$i]['nro_ht'].'\',\''.$rs[$i]['idtipo_doc_ht'].'\',\''.$rs[$i]['nro_doc_ht'].'\',
                  \''.$rs[$i]['asunto_ht'].'\',\''.$rs[$i]['obs_mov'].'\',\''.$rs[$i]['id_dep_origen'].'\',\''.$rs[$i]['id_dep_destino'].'\',\''.$rs[$i]['fec_deriva'].'\',\''.$rs[$i]['accion_deriva'].'\',
                  \''.$rs[$i]['id_prioridad_mov'].'\',\''.$rs[$i]['nro_folio'].'\',\''.$rs[$i]['nro_mov'].'\',\''.$rs[$i]['fec_recibe'].'\',\''.$rs[$i]['id_usrderiva'].'\',\''.$rs[$i]['id_usrrecibe'].'\')"><i class="fa fa-edit"></i></a> </td>';
                  echo "<td>".$j."</td>";
                  echo "<td>".$rs[$i]['des_tipdoc_ht']."</td>";
                  echo "<td>".$rs[$i]['nro_doc_ht']."</td>";
                  echo "<td>".$rs[$i]['origen']."</td>";
                  echo "<td>".$rs[$i]['usrderiva']."</td>";
                  echo "<td>".$rs[$i]['fec_deriva']."</td>";
                  echo "<td>".$rs[$i]['destino']."</td>";
                  echo "<td>".$rs[$i]['usrrecibe']."</td>";
                  echo "<td>".$rs[$i]['fec_recibe']."</td>";
                  //echo '<td><a href="#" onClick="ShowRuta(\''.$rs[$i]['des_tipdoc_ht']."|".$rs[$i]['anio_ht']."|".$rs[$i]['nro_ht'].'\')"><i class="fa fa-eye"></i></a> - <a href="#" onClick="showDetail(\''.$rs[$i]['idproc_ht']."|".$rs[$i]['anio_ht']."|".$rs[$i]['nro_ht'].'\')"><i class="fa fa-plus"></i></a></td>';
                  echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
                break;

                case 'EDIT_PER':
                $datos=array();
                $result=$per->QryEditPer($_GET['idpersona']);
                $nr=count($result);
                if($nr>0){
                  $datos=array(
                    0 => $result[0]['idtipo_persona'],
                    1 => $result[0]['id_persona'],
                    2 => $result[0]['nombre_rs'],
                    3 => $result[0]['primer_ape'],
                    4 => $result[0]['segundo_ape'],
                    5 => $result[0]['nro_documento'],
                    6 => $result[0]['direccion'],
                    7 => $result[0]['email_persona'],
                    8 => $result[0]['nro_telefono'],
                    9 => $result[0]['idsexo_persona'],
                    10 => $result[0]['idcategoria_persona'],
                    11 => $result[0]['idcateinstitucion_persona'],
                    12 => base64_decode($result[0]['foto_persona']),
                  );
                }
                //$result = pg_fetch_array($result);
                echo json_encode($datos);

                //echo "<img src='data:image/png;base64,".base64_decode($result[0]['foto_persona'])."' width='550' height='126'/>"."<br />";

                //echo $result;
                break;

                case 'LoadDataReniecPide':
                $usr=$_GET['nro_doc'];
                //$pwd="5784905794";
                $key=$_GET['txtkeypide'];
                ini_set('max_execution_time', 600);
                ini_set('default_socket_timeout', 600);
                //set_time_limit(600);
                //$ini = ini_set("soap.wsdl_cache_enabled","0");
                $client=new nusoap_client("http://ws2.pide.gob.pe/reniec/WSDataVerificationBinding?wsdl",false);
                $client->soap_defencoding='utf-8';  //ISO-8859-1
                $client->decode_utf8 = false;
                //echo($client);exit();
                $headers = "<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns:wsd='http://WSDataVerification_wsdl.wsauth.reniec.gob.pe/'>
                <soapenv:Header/>
                <soapenv:Body>
                <wsd:getDatavalidate>
                <!--Optional:-->
                <xmlDocumento><![CDATA[<IN>
                <CONSULTA>
                <DNI>".$usr."</DNI>
                </CONSULTA>
                <IDENTIFICACION>
                <CODUSER>N00003</CODUSER>
                <CODTRANSAC>5</CODTRANSAC>
                <CODENTIDAD>03</CODENTIDAD>
                <SESION>".$key."</SESION>
                </IDENTIFICACION>
                </IN>]]>
                </xmlDocumento>
                </wsd:getDatavalidate>
                </soapenv:Body>
                </soapenv:Envelope>";
                $client->setHeaders($headers);
                //$client->setCredentials($usr,"thepassword","basic");
                $err=$client->getError();
                if ($err) {
                  echo '<h2>Constructor error</h2><pre>'.$err.'</pre>';
                }
                // print_r($client);
                $param=array('DNI'=>$usr,'CODUSER'=>'N00003','CODTRANSAC'=>'5','CODENTIDAD'=>'03','SESION'=>$key);
                $result=$client->call('getDatavalidateResponse',$param);
                //$result=$client->call('getTicket');
                //print_r($param);exit();
                if ($client->fault) {
                  echo 'Fallo';
                  print_r($result);
                } else {	// Chequea errores
                  $err = $client->getError();
                  if ($err) {		// Muestra el error
                    echo 'Error' . $err ;
                  } else {		// Muestra el resultado
                    //  echo 'Resultado';
                    //  $result= mb_convert_encoding($result,"utf-8","ISO-8859-1");
                    if($result=='-1'){ echo "-1";}
                    else if($result=='-2'){ echo "-2";}
                    else if($result=='-3'){ echo "-3";}
                    else if($result=='-4'){ echo "-4";}
                    else if($result=='-5'){ echo "-5";}
                    else if($result=='-6'){ echo "-6";}
                    else if($result=='-7'){ echo "-7";}
                    else if($result=='-8'){ echo "-8";}
                    else if($result=='-9'){ echo "-9";}
                    else if($result=='-10'){ echo "-10";}
                    else {
                      $result = preg_split('/<[^>]*[^\/]>/i', $result, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
                      echo trim($result[3])."|".trim($result[5])."|".trim($result[7])."|".trim($result[9])."|".trim($result[11]);
                    }
                  }
                }
                break;

                case 'loadkeyPide':
                $usr="3405897345";
                $pwd="5784905794";
                //ini_set('max_execution_time', 600);
                //ini_set('default_socket_timeout', 600);
                //set_time_limit(600);
                //$ini = ini_set("soap.wsdl_cache_enabled","0");
                $client=new nusoap_client("http://ws2.pide.gob.pe/reniec2/WSAuthentication?wsdl",false);
                //echo($client);exit();
                $headers = "<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns:wsa='http://WSAuthentication_wsdl.wsauth.reniec.gob.pe/'>
                <soapenv:Header/>
                <soapenv:Body>
                <wsa:getTicket>
                <user>3405897345</user>
                <password>5784905794</password>
                </wsa:getTicket>
                </soapenv:Body>
                </soapenv:Envelope>";
                $client->setHeaders($headers);
                $err=$client->getError();
                if ($err) {
                  echo '<h2>Constructor error</h2><pre>'.$err.'</pre>';
                }
                $param=array('user'=>$usr,'password'=>$pwd);
                $result=$client->call('getTicket',$param);
                if ($client->fault) {
                  echo 'Fallo';
                  print_r($result);
                } else {	// Chequea errores
                  $err = $client->getError();
                  if ($err) {		// Muestra el error
                    echo 'Error' . $err ;
                  } else {		// Muestra el resultado
                    //echo 'Resultado';
                    print_r($result);
                  }
                }
                break;

                case 'LoadDataSunatPide':
                $ruc=$_GET['nro_ruc'];
                ini_set('max_execution_time', 600);
                ini_set('default_socket_timeout', 600);
                //set_time_limit(600);
                //$ini = ini_set("soap.wsdl_cache_enabled","0");
                $client=new nusoap_client("http://ws.pide.gob.pe/ConsultaRuc?wsdl",false);
                $headers = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.consultaruc.registro.servicio2.sunat.gob.pe">
                <soapenv:Header/>
                <soapenv:Body>
                <ser:getDatosPrincipales soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                <numruc xsi:type="xsd:string">'.$ruc.'</numruc>
                </ser:getDatosPrincipales>
                </soapenv:Body>
                </soapenv:Envelope>';
                $client->setHeaders($headers);
                $err=$client->getError();
                if ($err) {
                  echo '<h2>Constructor error</h2><pre>'.$err.'</pre>';
                }
                $param=array('ruc'=>$ruc);
                $result=$client->call('getDatosPrincipales',$param);
                $resultdf=$client->call('getDomicilioLegal',$param);
                //print_r($result);exit();
                if ($client->fault) {
                  echo 'Fallo';
                  print_r($result);
                } else {	// Chequea errores
                  $err = $client->getError();
                  if ($err) {		// Muestra el error
                    echo 'Error' . $err ;
                  } else {		// Muestra el resultado
                    //echo 'Resultado';
                    //print_r($result);
                    //echo utf8_encode($result['ddp_nombre'])."|".utf8_encode($resultdf);
                    //$result = preg_split('/<[^>]*[^\/]>/i', $result, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
                    echo trim(utf8_encode($result['ddp_nombre']))."|".trim(utf8_encode($resultdf));
                  }
                }
                break;


                case 'LoadInfoPersona':
                $rs=$per->InfoPer($_POST['idpersona']);
                if (empty($rs) ) {
                  exit();
                } else{
                  $claves = array();
                  $informacion = array();
                  $nh = 1;
                  foreach ($rs as $row)
                  {
                    $claves = explode(",", $row['auditoria_persona']);
                    $count = count($claves);
                    for ($f = 0; $f < $count; $f ++) {
                      $informacion = explode("|", $claves[$f]);
                      $rsu=$usu->searchuserId($informacion[1]);
                      if($informacion[0]=='I'){$actividad="Registro";}else{$actividad="Actualizacion";}
                      echo "Acción : Nro (" . $nh++ . ") ".$actividad ;
                      echo "<br/>";
                      echo " Usuario : ".$rsu[0]['login'];
                      echo "<br/>";
                      echo " Fecha : ".$informacion[2];
                      echo "<br/>";
                      echo " IP : ".$informacion[3];
                      echo "<hr/>";
                    }
                  }
                }
                break;

                case 'FindHtExterno':
                $datos=array();
                $result=$exp->Qrysearchhtexterno($_GET['txtnroht']);
                $nr=count($result);
                if($nr>0){
                  if($result[0]['nombre_rs']=''||$result[0]['nombre_rs']='null'){$rsresult=$result[0]['origen'];}else{{$rsresult=$result[0]['nombre_rs'];}}
                  $datos=array(
                    0 => $result[0]['fec_deriva'],
                    1 => $result[0]['origen'],
                    2 => $result[0]['destino'],
                    3 => $result[0]['usr_envia'],
                    4 => $result[0]['usr_recibe'],
                    5 => $result[0]['estado'],
                    6 => $rsresult,
                    7 => $result[0]['nro_ht'],
                  );
                }else{
                  $datos=array(
                    0 => "-1",
                  );
                }
                //$result = pg_fetch_array($result);
                echo json_encode($datos);
                //echo $result;
                break;

                case 'SEND_HT_CGAR': //Busca en data

                $client = new nusoap_client("http://wsdl.saludpol.gob.pe:8083/ws/ws_Cgarantia.php");
                //$client = new nusoap_client("http://192.168.0.33:8098/views/ws/wscgarantia.php");
                $nroHT = substr($_GET['nro_ht'], 0, -1);
                $rs=$exp->buscaHTwssendcgar($nroHT);

                $anio   = $rs[0]['anio_ht'];
                $rzs    = $rs[0]['nombre_rs'];
                $nrodoc = $rs[0]['nro_documento'];
                $reg    = $rs[0]['region'];
                $ht     = $rs[0]['nro_ht'];
                $tipodoc= $rs[0]['idtipo_doc_ht'];

                $param = array('nro_ht' => $ht,'anio_ht' => $anio ,'rzs' =>$rzs ,'nrodoc' => $nrodoc,'reg' => $reg,'tipodoc' => $tipodoc);
                $client->setCredentials("userreembolso@ludpol", "R33Mb0l50", "basic");
                $response = $client->call('get_buscaht', $param);
                if ($client->fault) {
                  echo "FAULT: <p>Code: (" . $client->faultcode . ")</p>";
                  echo "String: " . $client->faultstring;
                  exit();
                }
                $a = $response;
                //print_r($a);
                //echo json_encode($afi);
                break;

                case 'SEND_HT_REEMBOLSO': //Busca en data
                $client = new nusoap_client("http://wsdl.saludpol.gob.pe:8083/ws/wsreembolso.php");
                //$client = new nusoap_client("http://192.168.0.33:8098/views/ws/wsreembolso.php");
                $porciones = explode("|", $_GET['txtnrohtfinish']);

                $param = array('nro_ht' => $porciones[2],'txtnrodocpago' => $_GET['txtnrodocpago'] ,'idfecregister' => $_GET['idfecregister'] ,'txtlogin' => $_GET['txtlogin']);
                $client->setCredentials("userreembolso@ludpol", "R33Mb0l50", "basic");
                $response = $client->call('get_update_ht', $param);

                if ($client->fault) {
                  echo "FAULT: <p>Code: (" . $client->faultcode . ")</p>";
                  echo "String: " . $client->faultstring;
                  exit();
                }
                $a = $response;
                //print_r($a);
                //echo json_encode($afi);
                break;

                case 'SEND_HT_CGARANTIA': //Busca en data
                $client = new nusoap_client("http://wsdl.saludpol.gob.pe:8083/ws/wsUpdGarantia.php");
                //$client = new nusoap_client("http://192.168.0.33:8098/views/ws/wsUpdGarantia.php");
                $porciones = explode("|", $_GET['txtnrohtfinish']);

                $param = array('nro_ht' => $porciones[2],'txtnrodocpago' => $_GET['txtnrodocpago'] ,'idfecregister' => $_GET['idfecregister'] ,'txtlogin' => $_GET['txtlogin']);
                $client->setCredentials("userreembolso@ludpol", "R33Mb0l50", "basic");
                $response = $client->call('get_update_ht_cgar', $param);


                if ($client->fault) {
                  echo "FAULT: <p>Code: (" . $client->faultcode . ")</p>";
                  echo "String: " . $client->faultstring;
                  exit();
                }
                $a = $response;
                //print_r($a);
                //echo json_encode($afi);
                break;

                case 'GET_LISTA_PERSONA':
                $rs = $per->get_listaPersonaIpress('', $_POST['q']);
                //$json = [];
                foreach ($rs as $row) {
                  $json[] = array('id' => $row['id_persona'], 'text' => $row['persona']);
                }
                //print_r($json);
                echo json_encode($json);
                break;


                case 'GET_LISTA_PERSONA_ANULA':
                $rs = $per->get_listaPersonaAnula('', $_POST['q']);
                //$json = [];
                foreach ($rs as $row) {
                  $json[] = array('id' => $row['id_persona'], 'text' => $row['persona']);
                }
                //print_r($json);
                echo json_encode($json);
                break;


                case 'load_dependencias_usuarios':
                 $rs=$usu->load_dependencias_usuarios($_GET['cboiduser']);
                  foreach ($rs as $row) {
                    echo "<option  value='".$row['id_dep']."' >".$row['nom_dep']."</option>";
                  }

                break;


              }
              ?>
