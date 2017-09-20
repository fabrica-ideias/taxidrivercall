<?php
session_start();
require_once("model/Taxi.class.php");
require_once("model/fachada.class.php");
if (file_exists('arquivo.json')) {
	$fila = json_decode(file_get_contents('arquivo.json'));
	$posto1 = [];
	$posto2 = [];
	$posto3 = [];
	$problema = [];
	$fachada = new fachada();

	$opcao = $fachada->getHorarioFila();

	if($opcao == 0){
		$paraPosto3 = $fila->posto1[0];
		$paraPosto1 = $fila->posto2[0];
		$paraPosto2  = null;
		for ($i=0; $i < count($fila->posto1) -1 ; $i++) { 
			$fila->posto1[$i] = $fila->posto1[$i+1];
		}
		for ($i=0; $i < count($fila->posto2) -1 ; $i++) { 
			$fila->posto2[$i] = $fila->posto2[$i+1];
		}
		$enfrente = false;
		for ($i=0; $i < count($fila->posto3) -1 ; $i++) { 
			if($fila->posto3[$i]->status == "presente" && $paraPosto2 == null){
				$paraPosto2 = $fila->posto3[$i];
				$fila->posto3[$i] = $fila->posto3[$i+1];
				$enfrente = true;
			}
			if($enfrente == true){
				$fila->posto3[$i] = $fila->posto3[$i+1];
			}
		}
		$paraPosto3->status = "ausente";
		if($paraPosto3  != null){
			$fila->posto3[count($fila->posto3)-1] = $paraPosto3 ;
		}
		if($paraPosto2 != null){
			$fila->posto2[count($fila->posto2)-1] = $paraPosto2;
		}
		if($paraPosto1 != null){
			$fila->posto1[count($fila->posto1)-1] = $paraPosto1;
		}
		$fila->id +=  1;
		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($fila));
		fclose($fp);	
		echo json_encode($fila);
	}else{

		$paraPosto3 = null;
		if(count($fila->posto1)){
			$paraPosto3 = $fila->posto1[0];
		}
		$paraPosto1 = $fila->posto2[0];
		$paraPosto2  = null;
		//Anda o posto 1
		for ($i=0; $i < count($fila->posto1) -1 ; $i++) { 
			$fila->posto1[$i] = $fila->posto1[$i+1];
		}
		//Anda o posto 2
		for ($i=0; $i < count($fila->posto2) -1 ; $i++) { 
			$fila->posto2[$i] = $fila->posto2[$i+1];
		}
		//anda o posto 3
		$enfrente = false;
		for ($i=0; $i < count($fila->posto3) -1 ; $i++) { 
			if($fila->posto3[$i]->status == "presente" && $paraPosto2 == null){
				if($fila->plantao < 10){
					if($fila->posto3[$i]->tipo == "plantao"){
						$fila->plantao += 1;
						$paraPosto2 = $fila->posto3[$i];
						$fila->posto3[$i] = $fila->posto3[$i+1];
						$enfrente = true;
					}
				}else{
					if($fila->posto3[$i]->tipo == "biqueira"){
						$fila->biqueira += 1;
						$paraPosto2 = $fila->posto3[$i];
						$fila->posto3[$i] = $fila->posto3[$i+1];
						$enfrente = true;
					}
				}
			}
			if($enfrente == true){
				$fila->posto3[$i] = $fila->posto3[$i+1];
			}
		}
		if(!is_null($paraPosto3)){
			$paraPosto3->qtdeviajem += 1;
			$fila->posto3[count($fila->posto3)-1] = $paraPosto3 ;
		}
		if($paraPosto2 != null){
			$fila->posto2[count($fila->posto2)-1] = $paraPosto2;
		}
		if($paraPosto1 != null){
			$fila->posto1[count($fila->posto1)-1] = $paraPosto1;
		}

		if($fila->plantao == 10 && $fila->biqueira == 3){
			$fila->plantao = 0;
			$fila->biqueira = 0;
		}
		$fila->id =   rand(0,100);
		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($fila));
		fclose($fp);	
		echo json_encode($fila);
	}	
}
?>