<?php
	session_start();
	require_once("model/Taxi.class.php");
	if (file_exists('arquivo.json')) {
		$fila = json_decode(file_get_contents('arquivo.json'));
		$posto1 = [];
		$posto2 = [];
		$posto3 = [];
		$problema = [];
		$paraPosto3 = $fila->posto1[0];
		$paraPosto1 = $fila->posto2[0];
		$paraPosto2 	= null;
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
		$fila->posto3[count($fila->posto3)-1] = $paraPosto3 ;
		$fila->posto2[count($fila->posto2)-1] = $paraPosto2;
		$fila->posto1[count($fila->posto1)-1] = $paraPosto1;
		$fila->id +=  1;
		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($fila));
		fclose($fp);	
		echo json_encode($fila);	
	}else{
		$fila = array();
		$status = array("presente","ausente","problema","");
		for ($i=0; $i < 100; $i++) { 
			$random_keys=array_rand($status,2);
			$taxi = new Taxi();
			$taxi->setNumero(($i + 1));
			$taxi->setStatus($status[$random_keys[0]]);
			$taxi->setDispositivo("");
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
		$ordem = array("posto1" => $posto1 , "posto2" => $posto2, "posto3" => $posto3,"problemas" =>$problema,"id" => 1);
		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($ordem));
		fclose($fp);
		echo json_encode($ordem);
	}
?>