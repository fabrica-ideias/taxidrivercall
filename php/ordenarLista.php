<?php 
	require_once("model/fachada.class.php");
	$lista = json_decode($_POST['ordem']);
	$fila = json_decode(file_get_contents('arquivo.json'));
	$novalista = array();
	for ($i = 0 ; $i < count($lista);$i++) {
		$result = false;
		foreach ($fila->posto1 as $taxip) {
			if($taxip->numero == $lista[$i]){
				$novalista[] = $taxip;
				$result = true;
				break; 
			}
		}
		if($result == false){
			foreach ($fila->posto2 as $taxip) {
				if($taxip->numero == $lista[$i]){
					$novalista[] = $taxip;
					$result = true;
					break; 
				}
			}	
		}
		if($result == false){
			foreach ($fila->posto3 as $taxip) {
				if($taxip->numero == $lista[$i]){
					$novalista[] = $taxip;
					$result = true;
					break; 
				}
			}	
		}
	}
	foreach ($fila->problemas as $taxip) {
		$novalista[] = $taxip;
	}
	$fila->id += 1;
	$fachada = new fachada();
	$fachada->ordenarFila($novalista,$fila->id);
?>