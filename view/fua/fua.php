<?
session_start();
?>
<HTML><HEAD><title>.:.<?=$_SESSION[datos_empresa][0]?>.:.</title>
<META http-equiv="Pragma" content="no-cache">
<META http-equiv="Cache-Control" content="no-cache">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"> 
<META NAME="ROBOTS" CONTENT="NOARCHIVE">
<meta http-equiv=Content-Language content=es-pe>
<meta http-equiv=Content-Type content=text/html; charset=windows-1252>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/fua_ce.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?
require_once("../Modelo/M_Datos.php");
$sql="SELECT cp.* , hc.idHistoria, hc.nrohistoria, hc.tipo_documento, hc.nrodocumento, hc.ape_paterno, hc.ape_materno, hc.nombres, hc.seguro, hc.sexo, hc.fecha_nac, hc.tipo_sis, hc.cod_afiliacion, tp.idServicio, t.desc_servs, tm.des, tm.cod, e.desc_estab, e.cod_estab_au, u.usuario, m.nombre AS Profesional, m.nrodocumento AS DNI, m.colegiatura, tu.turno, tp.ncupos, ce.fechaRegistro AS FechaReg FROM cita_paciente cp LEFT JOIN historia_clinica hc ON cp.idHistoria=hc.idHistoria LEFT JOIN turno_profesional tp ON cp.idCitaRegistro=tp.idTurnoP LEFT JOIN tablaups t ON tp.idServicio=t.cod_servsa LEFT JOIN t_mae_maestra tm ON hc.seguro=tm.cod LEFT JOIN usuarios u ON cp.idUsuario=u.idUsuario LEFT JOIN establec e ON cp.cod_establecimiento=e.cod_estab LEFT JOIN mstrpers m ON tp.idProfesional=m.codpsal LEFT JOIN turno tu ON tp.idTurno=tu.idTurno LEFT JOIN consulta_externa ce ON cp.idCitaP=ce.idCitaP WHERE tm.tabcod='52' AND cp.idCitaP='$_GET[idCitaP]'";//echo $sql;
$datos=new M_Datos();
$Pre=$datos->listar($sql);

$nombres=$Pre[0][nombres];
$pnombre=explode(" ",$nombres);

$anionac=date("Y", strtotime($Pre[0][fecha_nac]));
$mesnac=date("m", strtotime($Pre[0][fecha_nac]));
$dianac=date("d", strtotime($Pre[0][fecha_nac]));

/*$cadena=explode(" ",$Pre[0][FechaReg]);
$cadena2=explode(":",$cadena[1]);
$horaate=$cadena2[0];*/

$anioate=substr(date("Y", strtotime($Pre[0][FechaReg])),-2);
$mesate=date("m", strtotime($Pre[0][FechaReg]));
$diaate=date("d", strtotime($Pre[0][FechaReg]));
$horaate=date("H", strtotime($Pre[0][FechaReg]));
$minutoate=date("i", strtotime($Pre[0][FechaReg]));
?>
<div class="imagenFondo"><img src="images/space.gif" width="1040" height="655" /></div>
<div class="clase1"><?=$Pre[0][cod_estab_au]?></div>
<div class="clase2"><?=$Pre[0][desc_estab]?></div>
<div class="clase3"><?=$Pre[0][nrodocumento]?></div>
<div class="clase4" align="center"><?=$Pre[0][ape_paterno]?></div>
<div class="clase5" align="center"><?=$Pre[0][ape_materno]?></div>
<div class="clase6"><?=$pnombre[0]?></div>
<div class="clase7"><?=$pnombre[1]?></div>
<div class="clase8"><?=$Pre[0][nrohistoria]?></div>
<? //if($Pre[0][sexo]=="M"){?>
<div class="clase9">X</div>
<? //}else{?>
<div class="clase10">X</div>
<? //}?>
<div class="clase11"><?=$dianac?></div>
<div class="clase12"><?=$mesnac?></div>
<div class="clase13"><?=$anionac?></div>
<div class="clase14"><?=$_GET[codigo_prestacion]?></div>
<div class="clase15"><?=$Pre[0][DNI]?></div>
<div class="clase16"><?=$Pre[0][Profesional]?></div>
<div class="clase17"><?=$Pre[0][colegiatura]?></div>
<div class="clase18"><?=$Pre[0][desc_servs]?></div>
<table border="0" cellpadding="0" cellspacing="0" align="left" class="clase19" width="923">
<?
$dia="SELECT diagnostico, tipo_diagnostico, cie FROM consulta_externa_diagnostico WHERE idCitaP='".$_GET[idCitaP]."' ORDER BY idConsultaDiagnostico ASC LIMIT 5";
$Dia=$datos->listar($dia);//echo $dia;
	foreach($Dia as $diag){
?>
	<tr>
    	<td width="684" align="left" class="clase20" style="height:2px;"><?=$diag[diagnostico]?></td>
        <td width="23" align="center" class="clase20"><? if($diag[tipo_diagnostico]=="P"){echo "X";}?></td>
        <td width="23" align="center" class="clase20"><? if($diag[tipo_diagnostico]=="D"){echo "X";}?></td>
        <td width="22" align="center" class="clase20"><? if($diag[tipo_diagnostico]=="R"){echo "X";}?></td>
        <td width="131" align="center" class="clase20"><?=$diag[cie]?></td>
    </tr>
<? 
	}
?>
</table>
<div class="clase44"><?=$Pre[0][cod_afiliacion]?></div>
<div class="clase45">X</div>
<div class="clase46"><?=$diaate?></div>
<div class="clase47"><?=$mesate?></div>
<div class="clase48"><?=$anioate?></div>
<div class="clase49"><?=$horaate?></div>
<div class="clase50"><?=$minutoate?></div>
<div class="clase51">X</div>
<div class="clase52">X</div>
<? //if($Pre[0][idReferencia]==0){?>
<div class="clase53">X</div>
<? //}else{?>
<div class="clase54">X</div>
<? //}?>
<div class="clase61"><?=$Pre[0][tipo_documento]?></div>
<div class="clase62">X</div>
<?
if($Pre[0][seguro]==2){
	//if($Pre[0][tipo_sis]==1){//subsidiado?>
<div class="clase63">X</div>
<?	//}elseif($Pre[0][tipo_sis]==2 || $Pre[0][tipo_sis]==3){//semisubsidiado?>
<div class="clase64">X</div>
<?	//}
}
?>
<script language="JavaScript" type="text/javascript">
<!--
/*
var da = (document.all) ? 1 : 0;
var pr = (window.print) ? 1 : 0;
var mac = (navigator.userAgent.indexOf("Mac") != -1);

function printWin()
{
    if (pr) {
        // NS4+, IE5+
        window.print();
    } else if (!mac) {
        // IE3 and IE4 on PC
        VBprintWin();
    } else {
        // everything else
        handle_error();
    }
}

window.onerror = handle_error;
window.onafterprint = function() {window.close()}

function handle_error()
{
    window.alert('Su navegador no admite la opcion. Presione Control/Opcin + P para imprimir.');
    return true;
}

if (!pr && !mac) {
    if (da) {
        // This must be IE4 or greater
        wbvers = "8856F961-340A-11D0-A96B-00C04FD705A2";
    } else {
        // this must be IE3.x
        wbvers = "EAB22AC3-30C1-11CF-A7EB-0000C05BAE0B";
    }

    document.write("<OBJECT ID=\"WB\" WIDTH=\"0\" HEIGHT=\"0\" CLASSID=\"CLSID:");
    document.write(wbvers + "\"> </OBJECT>");
}

// -->
</script>
  <script language="VBSCript" type="text/vbscript">
<!--

sub window_onunload
    on error resume next
    ' Just tidy up when we leave to be sure we arent
    ' keeping instances of the browser control in memory
    set WB = nothing
end sub

sub VBprintWin
    OLECMDID_PRINT = 6
    on error resume next

    ' IE4 object has a different command structure
    if da then
        call WB.ExecWB(OLECMDID_PRINT, 1)
    else
        call WB.IOleCommandTarget.Exec(OLECMDID_PRINT, 1, "", "")
    end if
end sub

' -->
</script>
<script language="JavaScript" type="text/javascript">
<!--
printWin();
// -->*/
</script>
</body>
</html>