<?
include 'clases/clinica.class.php';
require("mem_image.php");
require("qrcode/qrcode.class.php");
session_start();
if (!isset($_SESSION["accessauthority"])) {
    header("location:index.php");
    exit();
}
//define("TEMPIMGLOC", 'uploads/odontogramas/' . $_GET['hc'] . '.jpeg');

class PDF extends PDF_MemImage {

    function print_checkbox($x, $y, $checked = false) {
        $this->Rect($x, $y, 2, 2);
        if ($checked) {
            $this->Line($x, $y, $x + 2, $y + 2);
            $this->Line($x, $y + 2, $x + 2, $y);
        }
    }
    function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '') {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));

        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        if (strpos($corners, '2') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $y) * $k));
        else
            $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);

        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '3') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        if (strpos($corners, '4') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);

        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '1') === false) {
            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $y) * $k));
            $this->_out(sprintf('%.2F %.2F l', ($x + $r) * $k, ($hp - $y) * $k));
        } else
            $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1 * $this->k, ($h - $y1) * $this->k, $x2 * $this->k, ($h - $y2) * $this->k, $x3 * $this->k, ($h - $y3) * $this->k));
    }

    //Cabecera de página
    function Header() {
        
		//$this->Image('imagenes/head_logo_hc.jpg', 6, 3, 184, 12);
		$this->SetDrawColor(0, 0, 0);
		$this->Cell(204,13, "", "LTBR", 0, 'C');
		$this->Image('imagenes/logo_mininter.jpg', 5, 4,100,11);
		$this->Image('imagenes/head_logo_rua.jpg', 162, 4, 40, 11);
		
		
        
		//$this->SetY(48);
		
		
        /*$ti = 'REGISTRO UNICO DE ATENCION';
        $dat = date('d/m/Y');
        //Título
        $this->SetTextColor(1, 165, 177);
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(210, 5, $ti, 0, 1, 'C');
        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(198, 6, 'ESTABLECIMIENTO: ' . $_SESSION['operativo'], 0, 1, 'R');
        $this->SetDrawColor(1, 165, 177);
        $this->SetFont('Arial', '', 8);*/
    }

    function Footer() {
        $this->SetY(-8);
        $this->SetFont('Courier', '', 7);
        if (!empty($_SESSION['s_firma'])) {
            $this->Image($_SESSION['s_firma'], 136, 268, 64, 30);
            $this->SetX(140);
        }
    }

}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->SetAutoPageBreak(true, 3);
$pdf->SetMargins(3, 3, 3);
$pdf->AliasNbPages();
//$pdf->AddPage();
//$pdf->SetDrawColor(177, 165, 169);

$cn = conectar();


$cad = "select t.nro_historia,p.id_paciente,p.nombre,p.ape_paterno,p.ape_materno,ti.val_abr as tipodoc,p.id_usuario_salud as dni,cb.lfirma,
p.fecha_nac,(t.edad||' a. '||t.edad_meses||' m. '||t.edad_dias||' d.') as edad,p.sexo,p.telefono,
c.descripcion as consultorio,t.serie,t.nro_ticket,to_char(t.fecha_emision,'dd/mm/yyyy HH:MI AM') as fecha_emision,cb.cmp,
( p.nombre||' '||p.ape_paterno || ' ' || p.ape_materno)as paciente,to_char(cb.fecha_atencion,'dd/mm/yyyy') as fecha_atencion,
to_char(cb.fecha_atencion,'HH24:MI AM') as hora,t.id_parentesco_tit,me.dni as dni_medico,
tu.descripcion as turno,(me.ape_paterno || ' ' || me.ape_materno || ', ' || me.nombres)as medico,bu.bus,substring(me.tncol,2,8) as tncol,
(meo.ape_paterno || ' ' || meo.ape_materno || ', ' || meo.nombres)as medicoorden,substring(meo.tncol,2,8) as tncolorden,					  
td.descripcion as tipodocumento,s.key_pass as digitador,cb.tiempo_enf,cb.inicio_enf,cb.curso_enf,cb.relato_enf,cb.ant_pat,cb.ant_qx,cb.ant_ale,cb.ant_fam,cb.ant_epi,cb.ant_otros,
cb.peso,cb.talla,cb.presion_art,cb.frecuencia_car,cb.frecuencia_res,cb.temperatura,cb.examen_c_g,cb.examen_c_e,
hg.fur_ant,hg.fur_act,hg.paridad,hg.tipo_parto,hg.fec_aborto,hg.causa_aborto,hg.pin,hg.irs,hg.n_par_sex,hg.pap_ant,hg.result_pap_ant,hg.mac_tipo,hg.tip_consulta,hg.especuloscopia,cb.tratamiento,
ant_epi_lug,ant_epi_otr,ant_fis_ali,ant_fis_sed,ant_fis_diu,ant_fis_cat,ant_fis_sue,ant_fis_otr,peso_habitual,temp_rectal,
imc,nutricional,hidratacion,piel,cabeza,torax,mamas,respiratorio,cardiovascular,pelvis,obstetrico,genito,
nervioso,osteo,motivo,dieta,interconsulta,proxima_cita,cb.id_per,fp.descripcion as forma_pago,  
sed ,  sueno ,  orina ,  apetito ,  ap_cancer ,  ap_acv ,  ap_hipertension ,
ap_diabetes ,  ap_alergia ,  ap_descripcion ,  af_cancer ,  af_acv ,  af_hipertension ,  af_diabetes ,
af_alergia ,  af_descripcion ,  ag_fur ,  ag_pig ,  ag_paridad ,  ag_eg ,  ag_upap ,  ag_rupap , ag_fpp ,  ag_mac ,  ag_otros ,referencia,otros, fa.nombre as nombre_f,fa.ape_paterno as ape_paterno_f,
fa.ape_materno as ape_materno_f,par.descripcion as parentesco_f,substring(fa.id_usuario_salud,2,8) as dni_f,p.historia_old,tp.descripcion as parentesco_titular,tt.descripcion as turno_cita, t.nro_historiacjd canjeado,
o.uni_org,o.renaes,o.region,c.id_alterno as id_ups
from tickets t inner join consultorios c on t.id_consultorio=c.id_consultorio
inner join operativo o on substring(t.nro_historia,1,3)=o.id_oper
inner join tablatipo td on t.dventa=td.id_tipo and td.id_tabla='10'
inner join tablatipo fp on t.forpago=fp.id_tipo and fp.id_tabla='12'
left join pacientes p on t.id_paciente=p.id_paciente	
inner join tablatipo ti on substring(p.id_usuario_salud,1,1)=ti.id_tipo and ti.id_tabla='9'
left join ubigeo2005 u on p.id_distrito=u.id_old	
inner join sysaccusers s on t.digitador=s.id_us 
left join cab_cie10 cb on t.nro_historia=cb.nro_historia
left join tablatipo tu on cb.turno=tu.id_tipo and tu.id_tabla='7'
left join pacientes fa on t.id_titular=fa.id_paciente
left join tablatipo par on t.id_parentesco=par.id_tipo and par.id_tabla='32'
left join sysaccusers ui on cb.user_ins=ui.id_us 
left join sysaccusers um on cb.user_upd=um.id_us 
left join hc_ginecologia hg on t.nro_historia=hg.nro_historia
left join personal me on cb.cmp=me.id_personal
left join personal meo on t.id_medico_cita=meo.id_personal
left join buses bu on cb.id_bus=bu.id_bus 
left join tablatipo tp on t.id_parentesco_tit=tp.id_tipo and tp.id_tabla='86'
left join tablatipo tt on t.id_turno=tt.id_tipo and tt.id_tabla='7' ";

if (isset($_GET['case'])) {
    if ($_GET['hc'] <> '') {
        $cri_fp = "where t.nro_historia<>'' and t.nro_historiacjd in (";
        $ary = explode(',', $_GET['hc']);
        for ($i = 0; $i < count($ary); $i++) {
            $cri_fp.="'" . $ary[$i] . "',";
        }
        $cad.=$cri_fp . "'XXXXX') ";
    }
} else {
    $cad.="where t.nro_historia='" . $_GET['hc'] . "'";
}
//echo $cad;

$rsate = pg_query($cn, $cad);

while ($row = pg_fetch_array($rsate)) {
    $pdf->AddPage();

   // $qrcode = new QRcode($row['nro_historia'] . '|' . substr($row['dni'], 1, 8), "Q");
    //$qrcode->disableBorder();
    //$qrcode->displayPNG(200, array(255, 255, 255), array(0, 0, 0), 'uploads/qr.png', 0);
    // Load an image into a variable
    //$logo = file_get_contents('uploads/qr.png');
    // Output it
    //$pdf->MemImage($logo, 10, 20, 14, 14);
	
	$pdf->SetY(16);
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->MultiCell(51,14, $_SESSION['operativo'], 'LTR', 'C');	
	$pdf->SetY(16);
	$pdf->SetX(54);		
	$pdf->SetFillColor(235,235,235);
	$pdf->Cell(92, 6, 'REGISTRO UNICO DE ATENCION - RUA','LTBR', 0, 'C',true);
	$pdf->Cell(61, 6, 'REGION','LTR', 1, 'C',true);
	$pdf->SetX(54);	
	$pdf->Cell(15, 4, 'UE','LTBR', 0, 'C',true);
	$pdf->Cell(30, 4, 'CODIGO RENAES','LTBR', 0, 'C',true);
	$pdf->Cell(15, 4, 'ANO','LTBR', 0, 'C',true);
	$pdf->Cell(32, 4, 'NUMERO','LTBR', 0, 'C',true);
	$pdf->Cell(61, 4, '','LBR', 1, 'C',true);
	
	$pdf->Cell(1, 6, '','L', 0, 'C',false);
	
	
	
	$pdf->SetX(54);	
	$pdf->Cell(15, 6, $row['uni_org'],'LTBR', 0, 'C',false);
	$pdf->Cell(30, 6, $row['renaes'],'LTBR', 0, 'C',false);
	$pdf->Cell(15, 6, substr($row['fecha_atencion'],8,2),'LTBR', 0, 'C',false);
	$pdf->Cell(32, 6, substr('0000000'.$row['nro_ticket'],-7),'LTBR', 0, 'C',false);
	$pdf->Cell(61, 6, $row['region'],'LTBR', 1, 'C',false);
	
	$pdf->Cell(204,5, '1) DATOS DEL BENEFICIARIO / USUARIO','LTBR', 1, 'C',true);
	
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->Cell(18, 6, 'T Doc','LTBR', 0, 'C',true);
	$pdf->Cell(30, 6, 'N DNI','LTBR', 0, 'C',true);
	$pdf->Cell(116, 6, 'NOMBRES Y APELLIDOS','LTBR', 0, 'C',true);
	
	if ($row['sexo']=='F') { $male='';$fema='X'; } else { $male='X';$fema=''; }
	
	
	$x=$pdf->GetX();
	$pdf->Cell(20, 6, 'SEXO','LTBR', 0, 'C',true);
	$pdf->Cell(20, 6, 'EDAD','LTBR', 1, 'C',true);	
	
	$pdf->Cell(18, 8, '1','LTBR', 0, 'C',false);
	$pdf->Cell(30, 8, substr($row['dni'], 1, 8),'LTBR', 0, 'C',false);
	$pdf->Cell(116, 8, utf8_decode($row['paciente']),'LTBR', 0, 'C',false);
	$pdf->Cell(10, 4, 'M','LTBR', 0, 'C',false);
	$pdf->Cell(10, 4, $male,'LTBR', 0, 'C',false);	
	$pdf->Cell(20, 4, $row['edad'],'LTR', 1, 'C',false);
	$pdf->SetX($x);	
	$pdf->Cell(10, 4, 'F','LTBR', 0, 'C',false);
	$pdf->Cell(10, 4, $fema,'LTBR', 0, 'C',false);	
	$pdf->Cell(20, 4, '','LBR', 1, 'C',false);
	
	$pdf->Cell(204,2, '','LR', 1, 'C',false);	
	$pdf->Cell(140, 8, 'BENEFICIARIOS','LTBR', 0, 'C',true);
	
	$pdf->Cell(6, 8, '','', 0, 'C',false);
	$x=$pdf->GetX();
	$pdf->Cell(58, 4, 'N DE HISTORIA CLINICA','LTBR', 1, 'C',true);
	$pdf->SetX($x);
	$pdf->Cell(32, 4, 'DNI','LTBR', 0, 'C',true);
	$pdf->Cell(26, 4, 'VIGENTE','LTBR', 1, 'C',true);	
	
	
	$pdf->SetFont('Arial', '', 6);
	
	$pdf->SetFillColor(237,238,234);
	
	$_titu='';$_cony='';$_hnin='';$_hest='';$_pama='';$_sob='';$_hinc='';
	
	if ($row['id_parentesco_tit']=='1'){
		$_titu='X';
	}elseif($row['id_parentesco_tit']=='2'){
		$_cony='X';
	}elseif($row['id_parentesco_tit']=='5'){
		$_hnin='X';
	}elseif($row['id_parentesco_tit']=='7'){
		$_pama='X';
	}elseif($row['id_parentesco_tit']=='16'){
		$_sob='X';
	}elseif($row['id_parentesco_tit']=='6'){
		$_hinc='X';
	}
		
	
	$pdf->Cell(9, 4, 'Titular','LTBR', 0, 'C',true);
	$pdf->Cell(8, 4, $_titu,'LTBR', 0, 'C',false);
	$pdf->Cell(11, 4, 'Conyugue','LTBR', 0, 'C',true);
	$pdf->Cell(8, 4, $_cony,'LTBR', 0, 'C',false);
	$pdf->Cell(9, 4, 'Hijo/a','LTBR', 0, 'C',true);
	$pdf->Cell(8, 4, $_hnin,'LTBR', 0, 'C',false);
	$pdf->Cell(14, 4, 'H. estudiante','LTBR', 0, 'C',true);
	$pdf->Cell(8, 4, $_hest,'LTBR', 0, 'C',false);
	$pdf->Cell(9, 4, 'Padre','LTBR', 0, 'C',true);
	$pdf->Cell(8, 4, $_pama,'LTBR', 0, 'C',false);
	$pdf->Cell(14, 4, 'Sobreviviente','LTBR', 0, 'C',true);
	$pdf->Cell(8, 4, $_sob,'LTBR', 0, 'C',false);
	$pdf->Cell(18, 4, 'H. incapacitado','LTBR', 0, 'C',true);
	$pdf->Cell(8, 4, $_hinc,'LTBR', 0, 'C',false);
	$pdf->Cell(6, 8, '','', 0, 'C',false);
	$pdf->Cell(32, 4, substr($row['dni'], 1, 8),'LTBR', 0, 'C',false);
	$pdf->Cell(26, 4, $row['historia_old'],'LTBR', 1, 'C',false);	
	
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->SetFillColor(235,235,235);
	$pdf->Cell(204,2, '','LR', 1, 'C',false);
	$pdf->Cell(204,5, '2) DATOS DE LA INSTITUCION PRESTADORA DE SERVICIOS DE SALUD','LTBR', 1, 'C',true);
	$pdf->Cell(204,2, '','LR', 1, 'C',false);
	
	$pdf->SetFont('Arial', 'B', 6);	
	$pdf->Cell(62, 4, 'ATENCION','LTBR', 0, 'C',true);	
	$pdf->Cell(6, 8, '','', 0, 'C',false);
	$pdf->Cell(136, 4, 'REFERENCIA REALIZADA POR','LTBR', 1, 'C',true);
	$pdf->SetFont('Arial', '', 6);	
	$pdf->Cell(16, 4, 'AMBULATORIA','LTBR', 0, 'C',true);
	$pdf->Cell(5, 4, 'X','LTBR', 0, 'C',false);
	$pdf->Cell(16, 4, 'REFERENCIA','LTBR', 0, 'C',true);
	$pdf->Cell(5, 4, '','LTBR', 0, 'C',false);
	$pdf->Cell(15, 4, 'EMERGENCIA','LTBR', 0, 'C',true);
	$pdf->Cell(5, 4, '','LTBR', 0, 'C',false);
	
	$pdf->Cell(6, 8, '','', 0, 'C',false);	
	$pdf->Cell(20, 4, 'COD RENAES','LTBR', 0, 'C',true);
	$pdf->Cell(32, 4, 'NOMBRE DE LA IPRESS','LTBR', 0, 'C',true);
	$pdf->Cell(32, 4, 'N HOJA REFERENCIA','LTBR', 0, 'C',true);
	$pdf->Cell(20, 4, 'REGION','LTBR', 0, 'C',true);
	$pdf->Cell(32, 4, 'ESPECIALIDAD','LTBR', 1, 'C',true);
	
	
	$pdf->SetFont('Arial', 'B', 6);	
	$pdf->Cell(62, 4, 'PACIENTE','LTBR', 0, 'C',true);	
	
	$pdf->Cell(6, 8, '','', 0, 'C',false);	
	$pdf->Cell(20, 4, '','LR', 0, 'C',false);
	$pdf->Cell(32, 4, '','LR', 0, 'C',false);
	$pdf->Cell(32, 4, '','LR', 0, 'C',false);
	$pdf->Cell(20, 4, '','LR', 0, 'C',false);
	$pdf->Cell(32, 4, '','LR', 1, 'C',false);
	
	
	$sq="select count(cb.nro_historia) as cantidad from cab_cie10 cb 
		inner join tickets t on cb.nro_historia=t.nro_historia where t.id_paciente='".$row['id_paciente']."' and substring(cb.nro_historia,1,3)='".$_SESSION['idoperativo']."'";
	$rscnt=pg_query($cn,$sq);
	$cnt=pg_fetch_result($rscnt,0,'cantidad');	
		
	$pdf->SetFont('Arial', '', 6);	
	$pdf->Cell(26, 4, 'Nuevo','LTBR', 0, 'C',false);
	
	if ($cnt==1){
		$pdf->Image("imagenes/marca.gif", $pdf->GetX()+1.2, $pdf->GetY()+0.5, 3, NULL);		
	}
	
	$pdf->Cell(5, 4, '','LTBR', 0, 'C',false);
	$pdf->Cell(26, 4, 'Continuador','LTBR', 0, 'C',false);
	
	if ($cnt>1){
		$pdf->Image("imagenes/marca.gif", $pdf->GetX()+1.2, $pdf->GetY()+0.5, 3, NULL);		
	}	
	
	$pdf->Cell(5, 4, '','LTBR', 0, 'C',false);	
	
	$pdf->Cell(6, 8, '','', 0, 'C',false);	
	$pdf->Cell(20, 4, '','LRB', 0, 'C',false);
	$pdf->Cell(32, 4, '','LRB', 0, 'C',false);
	$pdf->Cell(32, 4, '','LRB', 0, 'C',false);
	$pdf->Cell(20, 4, '','LRB', 0, 'C',false);
	$pdf->Cell(32, 4, '','LRB', 1, 'C',false);
	
	
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->Cell(204,2, '','LR', 1, 'C',false);
	$pdf->Cell(204,5, '3) DATOS DE LA ATENCION','LTBR', 1, 'C',true);
	
	$pdf->SetFont('Arial', 'B', 6);
	
	$pdf->SetFillColor(237,238,234);
	$pdf->Cell(204,5, 'DEL DESTINO DEL BENEFICIARIO / USUARIO','LTBR', 1, 'C',true);
	$pdf->SetFillColor(235,235,235);
	
	$pdf->Cell(30,3, 'CODIGO RENAES DE','LTR', 0, 'C',true);
	$pdf->Cell(130,3, 'NOMBRE DE LA IPRESS A LA QUE SE REFIERE / CONTRAREFIERE','LTR', 0, 'C',true);
	$pdf->Cell(44,3, 'N HOJA DE REFER / CONTRARR.','LTR', 1, 'C',true);
	$pdf->Cell(30,3, 'LA IPRESS','LBR', 0, 'C',true);
	$pdf->Cell(130,3, '','LBR', 0, 'C',true);
	$pdf->Cell(44,3, '','LBR', 1, 'C',true);
	
	$pdf->Cell(30,4, '','LBR', 0, 'C',false);
	$pdf->Cell(130,4, '','LBR', 0, 'C',false);
	$pdf->Cell(44,4, '','LBR', 1, 'C',false);

	$pdf->Cell(204,2, '','LR', 1, 'C',false);	
	$pdf->Cell(70,5, 'FECHA DE ATENCION','LTBR', 0, 'C',true);	
	$pdf->Cell(4,5, '','', 0, 'C',false);	
	$pdf->Cell(24,5, 'HORA','LTR', 0, 'C',true);	
	$pdf->Cell(4,5, '','', 0, 'C',false);	
	$pdf->Cell(24,5, 'CODIGO','LTR', 0, 'C',true);	
	
	$pdf->Cell(4,5, '','', 0, 'C',false);	
	$pdf->Cell(5,5, '','LTR', 0, 'C',true);	
	$pdf->Cell(25,5, 'FECHA','LTBR', 0, 'C',true);	
	$pdf->Cell(12,5, 'DIA','LTBR', 0, 'C',true);	
	$pdf->Cell(12,5, 'MES','LTBR', 0, 'C',true);	
	$pdf->Cell(20,5, utf8_decode('AÑO'),'LTBR', 1, 'C',true);	
	
	
	$pdf->Cell(20,6, 'DIA','LTBR', 0, 'C',true);	
	$pdf->Cell(15,6, 'MES','LTBR', 0, 'C',true);	
	$pdf->Cell(35,6, utf8_decode('AÑO'),'LTBR', 0, 'C',true);	

	$pdf->Cell(4,6, '','', 0, 'C',false);	
	$pdf->Cell(24,6, '','LBR', 0, 'C',true);	
	$pdf->Cell(4,6, '','', 0, 'C',false);	
	$pdf->Cell(24,6, 'PRESTACIONAL','LBR', 0, 'C',true);	

	$pdf->Cell(4,6, '','', 0, 'C',false);
	$pdf->Cell(5,6, '','LR', 0, 'C',true);	
	$pdf->Cell(25,6, 'DE INGRESO','LTBR', 0, 'C',true);	
	$pdf->Cell(6,6, '','LTR', 0, 'C',false);
	$pdf->Cell(6,6, '','LTR', 0, 'C',false);
	$pdf->Cell(6,6, '','LTR', 0, 'C',false);
	$pdf->Cell(6,6, '','LTR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTR', 1, 'C',false);
	
	
	
	
	$pdf->Cell(10,6, substr($row['fecha_atencion'],0,1),'LTR', 0, 'C',false);	
	$pdf->Cell(10,6, substr($row['fecha_atencion'],1,1),'LTR', 0, 'C',false);	
	$pdf->Cell(7,6, substr($row['fecha_atencion'],3,1),'LTR', 0, 'C',false);	
	$pdf->Cell(8,6, substr($row['fecha_atencion'],4,1),'LTR', 0, 'C',false);	
	
	$pdf->Cell(9,6, substr($row['fecha_atencion'],6,1),'LTR', 0, 'C',false);	
	$pdf->Cell(9,6, substr($row['fecha_atencion'],7,1),'LTR', 0, 'C',false);	
	$pdf->Cell(9,6, substr($row['fecha_atencion'],8,1),'LTR', 0, 'C',false);	
	$pdf->Cell(8,6, substr($row['fecha_atencion'],9,1),'LTR', 0, 'C',false);	
	
	$pdf->Cell(4,6, '','', 0, 'C',false);	
	$pdf->Cell(10,6, substr($row['hora'],0,2),'LTR', 0, 'C',false);	
	$pdf->Cell(4,6, ':','LTR', 0, 'C',false);	
	$pdf->Cell(10,6, substr($row['hora'],3,2),'LTR', 0, 'C',false);	
	
	$pdf->Cell(4,6, '','', 0, 'C',false);	
	$pdf->Cell(24,6, '','LTR', 0, 'C',false);	
	
	$pdf->Cell(4,6, '','', 0, 'C',false);
	$pdf->Cell(5,6, '','LR', 0, 'C',true);	
	$pdf->Cell(25,6, 'DE ALTA','LTBR', 0, 'C',true);	
	$pdf->Cell(6,6, '','LTR', 0, 'C',false);
	$pdf->Cell(6,6, '','LTR', 0, 'C',false);
	$pdf->Cell(6,6, '','LTR', 0, 'C',false);
	$pdf->Cell(6,6, '','LTR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTR', 1, 'C',false);
	
	
	$pdf->Cell(10,6, '','LBR', 0, 'C',false);	
	$pdf->Cell(10,6, '','LBR', 0, 'C',false);	
	$pdf->Cell(7,6, '','LBR', 0, 'C',false);	
	$pdf->Cell(8,6, '','LBR', 0, 'C',false);	
	
	$pdf->Cell(9,6, '','LBR', 0, 'C',false);	
	$pdf->Cell(9,6, '','LBR', 0, 'C',false);	
	$pdf->Cell(9,6, '','LBR', 0, 'C',false);	
	$pdf->Cell(8,6, '','LBR', 0, 'C',false);	
	
	$pdf->Cell(4,6, '','', 0, 'C',false);	
	$pdf->Cell(10,6, '','LBR', 0, 'C',false);	
	$pdf->Cell(4,6, '','LBR', 0, 'C',false);	
	$pdf->Cell(10,6, '','LBR', 0, 'C',false);	
	
	$pdf->Cell(4,6, '','', 0, 'C',false);	
	$pdf->Cell(24,6, '','LBR', 0, 'C',false);	
	
	$pdf->Cell(4,6, '','', 0, 'C',false);
	$pdf->Cell(5,6, '','LBR', 0, 'C',true);	
	$pdf->Cell(25,6, 'CORTE','LTBR', 0, 'C',true);	
	$pdf->Cell(6,6, '','LTBR', 0, 'C',false);
	$pdf->Cell(6,6, '','LTBR', 0, 'C',false);
	$pdf->Cell(6,6, '','LTBR', 0, 'C',false);
	$pdf->Cell(6,6, '','LTBR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTBR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTBR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTBR', 0, 'C',false);
	$pdf->Cell(5,6, '','LTBR', 1, 'C',false);
	
	$pdf->Cell(204,2, '','LR', 1, 'C',false);	
	
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->Cell(204,2, '','LR', 1, 'C',false);
	$pdf->Cell(204,5, '4) DIAGNOSTICOS','LTBR', 1, 'C',true);
	$pdf->SetFont('Arial', 'B', 6);
	$pdf->Cell(4,4, utf8_decode('N°'),'LTBR', 0, 'C',true);
	$pdf->Cell(12,4, 'CIE-10','LTBR', 0, 'C',true);
	$pdf->Cell(170,4, utf8_decode('DESCRIPCIÓN'),'LTBR', 0, 'C',true);
	$pdf->Cell(18,4, 'TIPO DE DX','LTBR', 1, 'C',true);
	
	
	
	$sq = "select d.cie10,c.descripcion,d.tipo from det_cie10 d inner join cie10 c on d.cie10=c.cie10 where d.nro_historia='" . $row['nro_historia'] . "'";
    $rscie = pg_query($cn, $sq);
    $ni = pg_num_rows($rscie);
	$j=0;
    if ($ni > 0) {
		for ($i = 0; $i < $ni; $i++) {
			$j++;
			$pdf->Cell(4,4, $j,'LTBR', 0, 'C',false);
			$pdf->Cell(12,4, pg_fetch_result($rscie, $i, 'cie10'),'LTBR', 0, 'C',false);
			$pdf->Cell(170,4, utf8_decode(pg_fetch_result($rscie, $i, 'descripcion')),'LTBR', 0, 'L',false);
			
			
			$x1=$pdf->GetX();
			$pdf->Cell(6,4, 'P','LTBR', 0, 'C',false);
			$x2=$pdf->GetX();
			$pdf->Cell(6,4, 'D','LTBR', 0, 'C',false);
			$x3=$pdf->GetX();
			$pdf->Cell(6,4, 'R','LTBR', 0, 'C',false);
			
			if (pg_fetch_result($rscie, $i, 'tipo')=='P'){
				$pdf->SetX($x1);
			}elseif(pg_fetch_result($rscie, $i, 'tipo')=='D'){
				$pdf->SetX($x2);
			}else{
				$pdf->SetX($x3);
			}
			//$pdf->Cell(6,4, 'X','', 0, 'C',false);
			$pdf->Image("imagenes/marca.gif", $pdf->GetX()+1.2, $pdf->GetY()+0.5, 3, NULL);			
			$pdf->Cell(1,4, '','', 1, 'C',false);
		}
    } else {
		$pdf->Cell(4,4, '','LTBR', 0, 'C',false);
		$pdf->Cell(12,4, '','LTBR', 0, 'C',false);
		$pdf->Cell(170,4, '','LTBR', 0, 'L',false);
		$pdf->Cell(6,4, '','LTBR', 0, 'C',false);
		$pdf->Cell(6,4, '','LTBR', 0, 'C',false);
		$pdf->Cell(6,4, '','LTBR', 1, 'C',false);
	}
	
	
	$pdf->Cell(204,2, '','LR', 1, 'C',false);
	
	$pdf->Cell(16,4, utf8_decode('N° DE DNI'),'LTBR', 0, 'C',true);
	$pdf->Cell(130,4, utf8_decode('PROFESIONAL DE LA SALUD RESPONSABLE DE LA ATENCION'),'LTBR', 0, 'C',true);
	$pdf->Cell(58,4, 'CONSULTORIO (UPS SUSALUD)','LTBR', 1, 'C',true);
	
	
	$pdf->Cell(16,10, $row['dni_medico'],'LTBR', 0, 'C',false);
	$pdf->Cell(130,10, utf8_decode($row['medico']),'LTBR', 0, 'C',false);
	$pdf->Cell(20,10, 'UPSS'.$row['id_ups'],'LTBR', 0, 'C',false);
	$pdf->Cell(38,10, utf8_decode($row['bus']),'LTBR', 1, 'C',false);
	
	$pdf->Cell(166,2, '','LR', 0, 'C',false);
	$pdf->Cell(38,2, '','LTR', 1, 'C',false);
	
	$pdf->SetFont('Arial', 'B', 6);
	$pdf->Cell(20,4, 'BENEFICIARIO','LR', 0, 'C',false);
	$pdf->Cell(6,4, '','LTBR', 0, 'C',false);
	$pdf->Cell(140,4, '','', 0, 'C',false);
	$pdf->Cell(38,4, '','LR', 1, 'C',false);
	
	$pdf->Cell(20,4, 'PADRE/APO','LR', 0, 'C',false);
	$pdf->Cell(6,4, '','LTBR', 0, 'C',false);
	$pdf->Cell(140,4, '','', 0, 'C',false);
	$pdf->Cell(38,4, '','LR', 1, 'C',false);
	
	$pdf->Cell(20,4, '','L', 0, 'C',false);
	$pdf->Cell(6,4, '','', 0, 'C',false);	
	$pdf->Cell(40,4, '','B', 0, 'C',false);	
	$pdf->Cell(10,4, '','', 0, 'C',false);	
	$pdf->Cell(40,4, '','B', 0, 'C',false);	
	$pdf->Cell(10,4, '','', 0, 'C',false);	
	$pdf->Cell(35,4, '','B', 0, 'C',false);	
	$pdf->Cell(5,4, '','', 0, 'C',false);	
	$pdf->Cell(38,4, '','LBR', 1, 'C',false);
	
	$pdf->SetFont('Arial', 'B', 5);
	$pdf->Cell(20,3, '','L', 0, 'C',false);
	$pdf->Cell(6,3, '','', 0, 'C',false);	
	$pdf->Cell(40,3, 'Nombres y Apellidos','', 0, 'C',false);	
	$pdf->Cell(10,3, '','', 0, 'C',false);	
	$pdf->Cell(40,3, 'Firma','', 0, 'C',false);	
	$pdf->Cell(10,3, '','', 0, 'C',false);	
	$pdf->Cell(35,3, 'DNI o C.E','', 0, 'C',false);	
	$pdf->Cell(5,3, '','', 0, 'C',false);	
	$pdf->Cell(38,3, 'Huella Digital del Beneficiario','R', 1, 'C',false);
	
	$pdf->Cell(20,3, '','LB', 0, 'C',false);
	$pdf->Cell(6,3, '','B', 0, 'C',false);	
	$pdf->Cell(40,3, '','B', 0, 'C',false);	
	$pdf->Cell(10,3, '','B', 0, 'C',false);	
	$pdf->Cell(40,3, '','B', 0, 'C',false);	
	$pdf->Cell(10,3, '','B', 0, 'C',false);	
	$pdf->Cell(35,3, '','B', 0, 'C',false);	
	$pdf->Cell(5,3, '','B', 0, 'C',false);	
	$pdf->Cell(38,3, 'o del Apoderado','BR', 1, 'C',false);
	
	
	
	

    /*$pdf->Cell(198, 4, 'N Historia: ' . substr($row['dni'], 1, 8), 0, 1, 'R');
    $pdf->Cell(198, 4, 'Historia Antigua: ' . $row['historia_old'], 0, 1, 'R');
    $pdf->Cell(198, 4, ucwords(strtolower($row['tipodocumento'])) . ': ' . $row['serie'] . '-' . $row['nro_ticket'], 0, 1, 'R');
    $pdf->Cell(198, 4, utf8_decode('Fecha de Emisión: ') . $row['fecha_emision'], 0, 1, 'R');
    $pdf->SetFont('Arial', '', 5);

    $pdf->Cell(4, 5, '', 0, 0, '');
    $pdf->Cell(10, 4, date('ymdHis'), 0, 1, 'L');

    $pdf->SetTextColor(1, 165, 177);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(4, 5, '1. ', 0, 0, '');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 5, 'FILIACION', 0, 1, '');

    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(10);    
    $pdf->SetFillColor(1, 165, 177);  
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(75, 4, 'Nombres y Apellidos', 'LTBR', 0, 'C', true);
    $pdf->Cell(35, 4, 'Parentesco', 'LTBR', 0, 'C', true);   
    $pdf->Cell(20, 4, $row['tipodoc'], 'LTBR', 0, 'C', true);
    $pdf->Cell(10, 4, 'Sexo', 'LTBR', 0, 'C', true);
    $pdf->Cell(24, 4, 'Edad', 'LTBR', 0, 'C', true);
    $pdf->Cell(30, 4, 'Fecha Hora Atencion', 'LTBR', 1, 'C', true);



    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetX(10);
    $pdf->Cell(75, 4, utf8_decode($row['paciente']), 'LTBR', 0, 'L', false);
    $pdf->Cell(35, 4, utf8_decode($row['parentesco_titular']), 'LTBR', 0, 'L', false);
    
    $pdf->Cell(20, 4, substr($row['dni'], 1, 8), 'LTBR', 0, 'L', true);
    $pdf->Cell(10, 4, $row['sexo'], 'LTBR', 0, 'L', true);
    $pdf->Cell(24, 4, $row['edad'], 'LTBR', 0, 'L', true);
    $pdf->Cell(30, 4, $row['fecha_atencion'] . ' ' . $row['hora'], 'LTBR', 1, 'L', false);

    $pdf->SetFont('Arial', '', 8);
    $pdf->SetX(10);
    $pdf->SetFillColor(1, 165, 177);
    $pdf->SetTextColor(255, 255, 255);
    $meor = '';
    if ($row['medicoorden'] == '') {
        $meor = 'SIN CITA';
    } else {
        $meor = utf8_decode($row['medicoorden']);
        $nroCita = utf8_decode($row['canjeado']);
        if ($nroCita == "") {
            $nroCita = 'ATENCION DEL DIA';
        } else {
            $hnro_cjd_length = strlen($nroCita);
            $nroCita = substr($nroCita, 5, $hnro_cjd_length);
        }

        $pdf->Cell(35, 4, utf8_decode('Número de cita'), 'LTBR', 0, 'C', true);
        $pdf->Cell(129, 4, utf8_decode('Médico Asignado'), 'LTBR', 0, 'C', true);
        $pdf->Cell(30, 4, utf8_decode('Turno Cita'), 'LTBR', 1, 'C', true);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX(10);
        $pdf->Cell(35, 4, $nroCita, 'LTBR', 0, 'C', false);
        $pdf->Cell(129, 4, $meor, 'LTBR', 0, 'L', false);
        $pdf->Cell(30, 4, utf8_decode($row['turno_cita']), 'LTBR', 1, 'C', false);
    }

    $pdf->SetTextColor(1, 165, 177);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 3, '', 0, 1, '');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(80, 4, '   DETALLE', 0, 1, '');
    $pdf->SetFont('Arial', '', 8);

    $sqlEsp = "select c.descripcion as especialidad,p.descripcion as producto, c.formato_espe from detalles d inner join consultorios c on substring(d.id_producto,1,6)=c.id_consultorio
	 inner join productos p on d.id_producto=p.id_producto where d.nro_historia='" . $row['nro_historia'] . "' order by c.descripcion,p.descripcion ";
    $rsEsp = pg_query($cn, $sqlEsp);
    $niEsp = pg_num_rows($rsEsp);

    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    if ($niEsp > 0) {
        for ($i = 0; $i < $niEsp; $i++) {
            $pdf->SetX(10);
            $pdf->Cell(194, 4, pg_fetch_result($rsEsp, $i, 'especialidad') . ' - ' . pg_fetch_result($rsEsp, $i, 'producto'), 'LTBR', 1, 'L', true);
        }
    } else {
        $pdf->SetX(10);
        $pdf->MultiCell(194, 8, '', 'LBTR', 'J', '');
    }

    if ($niEsp > 0) {
        if (pg_fetch_result($rsEsp, 0, 'formato_espe') <> "") {
            require './' . pg_fetch_result($rsEsp, 0, 'formato_espe');
        } else {
            require './pdf_hc_general.php';
        }
    }

    $pdf->SetX(10);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(40, 5, 'Datos del Profesional', 0, 1, '');

    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFillColor(1, 165, 177);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(90, 4, 'Profesional de la Salud', 'LTBR', 0, 'C', true);
    $pdf->Cell(40, 4, 'Colegio Profesional', 'LTBR', 0, 'C', true);
    $pdf->Cell(40, 4, 'Consultorio.', 'LTBR', 0, 'C', true);
    $pdf->Cell(24, 4, 'Turno', 'LBTR', 1, 'C', true);


    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0); 
    $pdf->SetX(10);
    $pdf->Cell(90, 4, $row['medico'], 'LTBR', 0, 'L', true);

    $pdf->Cell(40, 4, $row['tncol'], 'LTBR', 0, 'L', true);
    $pdf->Cell(40, 4, $row['bus'], 'LTBR', 0, 'L', true);

    $pdf->Cell(24, 4, $row['turno'], 'LTBR', 1, 'L', true);
    $pdf->SetX(10);
    $pdf->Cell(170, 4, 'Codigo Personal de Salud', 'LBTR', 0, 'R', true);
    $pdf->Cell(24, 4, '', 'LTRB', 1, 'L', true);*/
}

$pdf->Output();
?>
