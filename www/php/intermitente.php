<?php 
require_once("model/fachada.class.php");
$fachada = new fachada();
$dispositivo = $_GET["mac"];
$taxis = json_decode(file_get_contents('arquivo.json'));


if(property_exists($taxis,'posto3')){
	if((strlen($dispositivo) > 0) && ($fachada->existBeacon($dispositivo) == 1)){
		$fp = fopen('teste.json', 'a');
		fwrite($fp,$dispositivo."\n");
		fclose($fp);
		foreach ($taxis->posto1 as $taxi) {
			$status = "";
			if($taxi->dispositivo == $dispositivo){
				if($taxi->status == "ausente"){
					$taxi->status = "presente";
					break;
				}else{
					$taxi->status = "ausente";
					break;
				}
			}
		}
		foreach ($taxis->posto2 as $taxi) {
			if($taxi->dispositivo == $dispositivo){
				if($taxi->status == "ausente"){
					$taxi->status = "presente";
					break;
				}else{
					$taxi->status = "ausente";
					break;
				}
			}
		}
		foreach ($taxis->posto3 as $taxi) {
			if($taxi->dispositivo == $dispositivo){
				if($taxi->status == "ausente"){
					$taxi->status = "presente";
					break;
				}else{
					$taxi->status = "ausente";
					break;
				}
			}
		}

		$taxis->alteracao =  rand(0,100);

		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($taxis));
		fclose($fp);
		echo json_encode($taxis);
	}
}
?>