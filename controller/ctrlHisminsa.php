<?php
if (!isset($_SESSION["labAccess"])) {
  header("location:../index.php");
  exit();
}
if ($_SESSION["labAccess"] <> "Yes") {
  header("location:../index.php");
  exit();
}

	$rs = $pap->post_datosEnvioHISMINSAporIdPAP(173);
	$nr = count($rs);
	//print_r($rs);
	if ($nr > 0) {
		header('Content-Type: application/json');
		// personal_registra
        $pr_nrodocumento = $rs["pr_nrodocumento"];//1
        $pr_apematerno = $rs["pr_apematerno"];//2
        $pr_idpais = $rs["pr_idpais"];//3
        $pr_idprofesion = $rs["pr_idprofesion"];//4
        $pr_fechanacimiento = $rs["pr_fechanacimiento"];//5
        $pr_nombres = $rs["pr_nombres"];//6
        $pr_idtipodoc = $rs["pr_idtipodoc"];//7
        $pr_apepaterno = $rs["pr_apepaterno"];//8
        $pr_idsexo = $rs["pr_idsexo"];//9
        $pr_idcondicion = $rs["pr_idcondicion"];//10
        // personal_atiende
        $pa_nrodocumento = $rs["pa_nrodocumento"];//11
        $pa_apematerno = $rs["pa_apematerno"];//12
        $pa_idpais = $rs["pa_idpais"];//13
        $pa_idprofesion = $rs["pa_idprofesion"];//14
        $pa_fechanacimiento = $rs["pa_fechanacimiento"];//15
        $pa_nombres = $rs["pa_nombres"];//16
        $pa_idtipodoc = $rs["pa_idtipodoc"];//17
        $pa_apepaterno = $rs["pa_apepaterno"];//18
        $pa_idsexo = $rs["pa_idsexo"];//19
        $pa_idcondicion = $rs["pa_idcondicion"];//20
        // paciente
        $p_nrodocumento = $rs["p_nrodocumento"];//21
        $p_apematerno = $rs["p_apematerno"];//22
        $p_idflag = $rs["p_idflag"];//23
        $p_nombres = $rs["p_nombres"];//24
        $p_nrohistoriaclinica = $rs["p_nrohistoriaclinica"];//25
        $p_idtipodoc = $rs["p_idtipodoc"];//26
        $p_apepaterno = $rs["p_apepaterno"];//27
        $p_idetnia = $rs["p_idetnia"];//28
        $p_fechanacimiento = $rs["p_fechanacimiento"];//29
        $p_idestablecimiento = $rs["p_idestablecimiento"];//30
        $p_idpais = $rs["p_idpais"];//31
        $p_idsexo = $rs["p_idsexo"];//32
        // citas
        $numeroafiliacion = $rs["numeroafiliacion"];//33
        $fechaatencion = $rs["fechaatencion"];//34
        $estadoregistro = $rs["estadoregistro"];//35
        $idups = $rs["idups"];//36
        $idestablecimiento = $rs["p_idestablecimiento"];//37
        $diaedad = $rs["diaedad"];//38
        $edadregistro = $rs["edadregistro"];//39
        $idturno = $rs["idturno"];//40
        $idtipedadregistro = $rs["idtipedadregistro"];//41
        $fgdiag = $rs["fgdiag"];//42
        $mesedad = $rs["mesedad"];//43
        $componente = $rs["componente"];//44
        $idfinanciador = $rs["idfinanciador"];//45
        $annioedad = $rs["annioedad"];//46
        $peso = $rs["ef_peso"];//47
        $talla = $rs["ef_talla"];//48
        $hemoglobina = $rs["ef_hemoglobina"];//49 
        //$IdAtencion = $rs["idAtencion"];//50
		
		//Diagnosticos
		header('Content-Type: application/json');
		$datosDiagnostico = "";
        $cadena = "";
        $cadena .= "["; 
		$cntdor = 0;
		$rsD = $pap->post_datosDiagnosticoEnvioHISMINSAporIdPAP(173);
		//print_r($rsD);
		$nrD = count($rsD);
		$r = 0;
		while ($r < $nrD) {
                $CodigoDx = $rsD[$r]["tipodiagnostico"];
                $CodigoCIE = $rsD[$r]["codigo"];
                $Tipoitem = $rsD[$r]["tipoitem"];
                $valor = $rsD[$r]["valor_lab"];
                $CodigoVal = $rsD[$r]["id_lab"];
                if($cntdor > 0) {
                    $cadena .= ",";
                }
				$r ++;
                $cntdor++;
				$cadena .= "\r\n\t\t\t{\r\n\t\t\t\t\"tipodiagnostico\": \"".$CodigoDx."\",\r\n\t\t\t\t\"codigo\": \"".$CodigoCIE."\",\r\n\t\t\t\t\"tipoitem\": \"".$Tipoitem."\"".($valor == '' ? "": ",\r\n\t\t\t\t\"labs\":[\r\n\t\t\t\t\t{\r\n\t\t\t\t\t\t\"codigo\": \"".$CodigoVal."\",\r\n\t\t\t\t\t\t\"valor\": \"".$valor."\"\r\n\t\t\t\t\t}\r\n\t\t\t\t]" )."}"; 
		}
		$cadena .= "\r\n\t\t]"; 
		$datosDiagnostico = $cadena;
		
		//echo $msje = "{\r\n\t\"cita\": {\r\n\t\t\"numeroafiliacion\": \"".$numeroafiliacion."\",\r\n\t\t\"fechaatencion\": \"".$fechaatencion."\",\r\n\t\t\"estadoregistro\": \"".$estadoregistro."\",\r\n\t\t\"items\": ".$datosDiagnostico.", \r\n\t\t\"idups\": \"".$idups."\",\r\n\t\t\"idestablecimiento\": \"".$idestablecimiento."\",\r\n\t\t\"diaedad\": \"".$diaedad."\",\r\n\t\t\"edadregistro\": \"".$edadregistro."\",\r\n\t\t\"idturno\": \"".$idturno."\",\r\n\t\t\"idtipedadregistro\": \"".$idtipedadregistro."\",\r\n\t\t\"fgdiag\": \"".$fgdiag."\",\r\n\t\t\"mesedad\": \"".$mesedad."\",\r\n\t\t\"componente\": \"".$componente."\",\r\n\t\t\"idfinanciador\": \"".$idfinanciador."\",\r\n\t\t\"annioedad\": \"".$annioedad."\",\r\n\t\t\"examenfisico\": {\r\n\t\t\t\"peso\": \"".$peso."\",\r\n\t\t\t\"talla\": \"".$talla."\",\r\n\t\t\t\"hemoglobina\": \"".$hemoglobina."\"\r\n\t\t}\r\n\t},\r\n\t\"personal_registra\": {\r\n\t\t\"nrodocumento\": \"".$pr_nrodocumento."\",\r\n\t\t\"apematerno\": \"".$pr_apematerno."\",\r\n\t\t\"idpais\": \"".$pr_idpais."\",\r\n\t\t\"idprofesion\": \"".$pr_idprofesion."\",\r\n\t\t\"fechanacimiento\": \"".$pr_fechanacimiento."\",\r\n\t\t\"nombres\": \"".$pr_nombres."\",\r\n\t\t\"idtipodoc\": \"".$pr_idtipodoc."\",\r\n\t\t\"apepaterno\": \"".$pr_apepaterno."\",\r\n\t\t\"idsexo\": \"".$pr_idsexo."\",\r\n\t\t\"idcondicion\": \"".$pr_idcondicion."\"\r\n\t},\r\n\t\"personal_atiende\": {\r\n\t\t\"nrodocumento\": \"".$pa_nrodocumento."\",\r\n\t\t\"apematerno\": \"".$pa_apematerno."\",\r\n\t\t\"idpais\": \"".$pa_idpais."\",\r\n\t\t\"idprofesion\": \"".$pa_idprofesion."\",\r\n\t\t\"fechanacimiento\": \"".$pa_fechanacimiento."\",\r\n\t\t\"nombres\": \"".$pa_nombres."\",\r\n\t\t\"idtipodoc\": \"".$pa_idtipodoc."\",\r\n\t\t\"apepaterno\": \"".$pa_apepaterno."\",\r\n\t\t\"idsexo\": \"".$pa_idsexo."\",\r\n\t\t\"idcondicion\": \"".$pa_idcondicion."\"\r\n\t},\r\n\t\"paciente\": {\r\n\t\t\"nrodocumento\": \"".$p_nrodocumento."\",\r\n\t\t\"apematerno\": \"".$p_apematerno."\",\r\n\t\t\"idflag\": \"".$p_idflag."\",\r\n\t\t\"nombres\": \"".$p_nombres."\",\r\n\t\t\"nrohistoriaclinica\": \"".$p_nrohistoriaclinica."\",\r\n\t\t\"idtipodoc\": \"".$p_idtipodoc."\",\r\n\t\t\"apepaterno\": \"".$p_apepaterno."\",\r\n\t\t\"idetnia\": \"".$p_idetnia."\",\r\n\t\t\"fechanacimiento\": \"".$p_fechanacimiento."\",\r\n\t\t\"idestablecimiento\": \"".$p_idestablecimiento."\",\r\n\t\t\"idpais\": \"".$p_idpais."\",\r\n\t\t\"idsexo\": \"".$p_idsexo."\"\r\n\t}\r\n}";
		
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_PORT => "18080",//Puerto prueba
          //CURLOPT_PORT => "18061",//Puerto de producción
          CURLOPT_URL => "http://dpidesalud.minsa.gob.pe:18080/mcs-sihce-hisminsa/integracion/v1.0/paquete/actualizar",//url prueba
		  //CURLOPT_URL => "http://pidesalud.minsa.gob.pe.gob.pe:18061/mcs-sihce-hisminsa/integracion/v1.0/paquete/actualizar/",//url produccion
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_SSL_VERIFYHOST => false,

          CURLOPT_POSTFIELDS => "{\r\n\t\"cita\": {\r\n\t\t\"numeroafiliacion\": \"".$numeroafiliacion."\",\r\n\t\t\"fechaatencion\": \"".$fechaatencion."\",\r\n\t\t\"estadoregistro\": \"".$estadoregistro."\",\r\n\t\t\"items\": ".$datosDiagnostico.", \r\n\t\t\"idups\": \"".$idups."\",\r\n\t\t\"idestablecimiento\": \"".$idestablecimiento."\",\r\n\t\t\"diaedad\": \"".$diaedad."\",\r\n\t\t\"edadregistro\": \"".$edadregistro."\",\r\n\t\t\"idturno\": \"".$idturno."\",\r\n\t\t\"idtipedadregistro\": \"".$idtipedadregistro."\",\r\n\t\t\"fgdiag\": \"".$fgdiag."\",\r\n\t\t\"mesedad\": \"".$mesedad."\",\r\n\t\t\"componente\": \"".$componente."\",\r\n\t\t\"idfinanciador\": \"".$idfinanciador."\",\r\n\t\t\"annioedad\": \"".$annioedad."\",\r\n\t\t\"examenfisico\": {\r\n\t\t\t\"peso\": \"".$peso."\",\r\n\t\t\t\"talla\": \"".$talla."\",\r\n\t\t\t\"hemoglobina\": \"".$hemoglobina."\"\r\n\t\t}\r\n\t},\r\n\t\"personal_registra\": {\r\n\t\t\"nrodocumento\": \"".$pr_nrodocumento."\",\r\n\t\t\"apematerno\": \"".$pr_apematerno."\",\r\n\t\t\"idpais\": \"".$pr_idpais."\",\r\n\t\t\"idprofesion\": \"".$pr_idprofesion."\",\r\n\t\t\"fechanacimiento\": \"".$pr_fechanacimiento."\",\r\n\t\t\"nombres\": \"".$pr_nombres."\",\r\n\t\t\"idtipodoc\": \"".$pr_idtipodoc."\",\r\n\t\t\"apepaterno\": \"".$pr_apepaterno."\",\r\n\t\t\"idsexo\": \"".$pr_idsexo."\",\r\n\t\t\"idcondicion\": \"".$pr_idcondicion."\"\r\n\t},\r\n\t\"personal_atiende\": {\r\n\t\t\"nrodocumento\": \"".$pa_nrodocumento."\",\r\n\t\t\"apematerno\": \"".$pa_apematerno."\",\r\n\t\t\"idpais\": \"".$pa_idpais."\",\r\n\t\t\"idprofesion\": \"".$pa_idprofesion."\",\r\n\t\t\"fechanacimiento\": \"".$pa_fechanacimiento."\",\r\n\t\t\"nombres\": \"".$pa_nombres."\",\r\n\t\t\"idtipodoc\": \"".$pa_idtipodoc."\",\r\n\t\t\"apepaterno\": \"".$pa_apepaterno."\",\r\n\t\t\"idsexo\": \"".$pa_idsexo."\",\r\n\t\t\"idcondicion\": \"".$pa_idcondicion."\"\r\n\t},\r\n\t\"paciente\": {\r\n\t\t\"nrodocumento\": \"".$p_nrodocumento."\",\r\n\t\t\"apematerno\": \"".$p_apematerno."\",\r\n\t\t\"idflag\": \"".$p_idflag."\",\r\n\t\t\"nombres\": \"".$p_nombres."\",\r\n\t\t\"nrohistoriaclinica\": \"".$p_nrohistoriaclinica."\",\r\n\t\t\"idtipodoc\": \"".$p_idtipodoc."\",\r\n\t\t\"apepaterno\": \"".$p_apepaterno."\",\r\n\t\t\"idetnia\": \"".$p_idetnia."\",\r\n\t\t\"fechanacimiento\": \"".$p_fechanacimiento."\",\r\n\t\t\"idestablecimiento\": \"".$p_idestablecimiento."\",\r\n\t\t\"idpais\": \"".$p_idpais."\",\r\n\t\t\"idsexo\": \"".$p_idsexo."\"\r\n\t}\r\n}\r\n}",
          CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            "Connection: keep-alive",
            "Content-Type: application/json",
            "Host: dpidesalud.minsa.gob.pe:18080",
            //"Host: pidesalud.minsa.gob.pe:18061",
            "cache-control: no-cache"
          ),
        ));
		
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        echo $response;
        //var_dump($response);
        //var_dump($err);
		
	}

?>
