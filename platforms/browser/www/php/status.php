<?php 
require_once("conexao.php");
require_once("model/fachada.class.php");
$fachada = new fachada();
$dispositivo = $_GET["mac"];
$taxis = json_decode(file_get_contents('arquivo.json'));
// $fp = fopen('teste.json', 'a');
// fwrite($fp,$_GET["mac"]."\n");
// fclose($fp);
// echo json_encode($taxis);
if(property_exists($taxis,'posto3')){
	if((strlen($dispositivo) > 0) && ($fachada->existBeacon($dispositivo) == 1)){
		$beacon = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Beacon WHERE mac='$dispositivo'"));
		$ultimo = strtotime($beacon['proxima_deteccao']);
		$tempoAgora = strtotime(date('Y-m-d H:i:s'));
		if($tempoAgora >= $ultimo){
			$fp = fopen('teste.json', 'a');
			fwrite($fp,date("s")." segundos\n");
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
			if(property_exists($taxis,'posto3')){
				$fp = fopen('arquivo.json', 'w');
				fwrite($fp, json_encode($taxis));
				fclose($fp);
				echo json_encode($taxis);
			}
			$date = date('Y-m-d H:i:s');
			$novaData = date("Y-m-d H:i:s",strtotime($date." +5 minutes"));
			mysqli_query($con,"UPDATE Beacon SET ultimadeteccao ='$date' ,proxima_deteccao = '$novaData' WHERE mac='$dispositivo'");
		}
	}
}
?>