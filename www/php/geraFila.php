<?php 
	function geraFila(){
		require_once("model/Taxi.class.php");
		$fila = array();
		
		$status = array("presente","ausente","problema","");
		for ($i=0; $i < 100; $i++) { 
			$random_keys=array_rand($status,2);
			$taxi = new Taxi();
			$taxi->setNumero(($i + 1));
			$taxi->setStatus($status[$random_keys[0]]);
			$fila[] = $taxi;
		}
		$posto1 = [];
		$posto2 = [];
		$posto3 = [];
		$problema = [];
		for ($i=0; $i < count($fila); $i++) { 
			if(count($posto1) < 6){
				if($fila[$i]->status == "presente"){
					$posto1[] = $fila[$i];
				}else{
					if($fila[$i]->status == "problema"){
						$problema[] = $fila[$i];
					}else{
						$posto3[] = $fila[$i];
					}
				}
			}elseif(count($posto2) < 6 && count($posto1) == 6){
				if( $fila[$i]->status == "presente"){
					$posto2[] = $fila[$i];
				}else{
					if($fila[$i]->status == "problema"){
						$problema[] = $fila[$i];
					}else{
						$posto3[] = $fila[$i];
					}
				}
			}else if(count($posto2) == 6 & count($posto1) == 6){
				if($fila[$i]->status == "presente" || $fila[$i]->status == "ausente" ){
					$posto3[] = $fila[$i];
				}else{
					$problema[] = $fila[$i];
				}
			}
		}
		$ordem = array("posto1" => $posto1 , "posto2" => $posto2, "posto3" => $posto3,"problemas" =>$problema,"id"=>1);
		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($ordem));
		fclose($fp);
		echo json_encode($ordem);
	}
	geraFila();
?>