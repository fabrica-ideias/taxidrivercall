<?php 
require_once("model/fachada.class.php");
$fachada = new fachada();
$dispositivo = rand(25,130);
$taxis = json_decode(file_get_contents('arquivo.json'));

$ausentes = [];
$presentes = [];
foreach ($taxis->posto3 as $taxi) {
	if($taxi->status == "ausente"){
		$ausentes[] = $taxi;
	}else{
		$presentes[] = $taxi;
	}
}

$p = $presentes[rand(0,count($presentes))];
$a = $ausentes[rand(0,count($ausentes))];

foreach ($taxis->posto3 as $taxi) {
	if(($taxi->numero == $p->numero) || ($taxi->numero == $a->numero)){
		if($taxi->status == "ausente"){
			$taxi->status = "presente";
		}else{
			$taxi->status = "ausente";
		}
	}
}

$taxis->alteracao =  rand(0,100);

$fp = fopen('arquivo.json', 'w');
fwrite($fp, json_encode($taxis));
fclose($fp);
echo json_encode($taxis);
?>