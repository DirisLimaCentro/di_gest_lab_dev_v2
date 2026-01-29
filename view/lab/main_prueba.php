<?php

echo "<style> table, th, td {
  border: 1px solid;
} </style>";

require_once '../../model/Lab.php';
$lab = new Lab();

$anio = 2024;
$mes = 6;

$nombresDias = array("Do","Lu","Ma","Mi","Ju","Vi","Sa");
$date='2024-06-19';
$cant_dias_mes = cal_days_in_month(CAL_GREGORIAN, 6, 2024);

echo "<table><tr>";
$contador_fecha = 0;
$rsP = $lab->get_CantidadFechaCitadosPorAnioMes(54,2024,6);
//print_r($rsP);
for ($i = 1; $i <= $cant_dias_mes; $i++) {
	$fecha_for = $anio . "-" . str_pad($mes,2,"0", STR_PAD_LEFT) . "-" . str_pad($i,2,"0", STR_PAD_LEFT);
	$contador_fecha	++;
    $nom_dia = $nombresDias[date('w', strtotime($fecha_for))];
	
	$key = array_search($fecha_for, array_column($rsP, 'fecha_cita'));
	
	echo "<td>";
		echo $nom_dia . " - " . str_pad($i,2,"0", STR_PAD_LEFT);
		//echo var_dump($key);
		if ($key !== FALSE){
			echo "<br/><span class='label bg-yellow'>".$rsP[$key]['ctn_total']."</span> <span class='label bg-yellow'>".$rsP[$key]['atendidos']."</span> <span class='label bg-yellow'>".$rsP[$key]['pendientes']."</span>";
		}
	echo "</td>";
	if(($nom_dia=='Do')){ echo "</tr>";}
	if(($nom_dia=='Do')){ echo "<tr>";}
	
}
//style="width: 80%; max-width: 1768px;"
echo "</tr></table>";
?>