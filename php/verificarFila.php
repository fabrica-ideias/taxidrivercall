<?php 
	session_start();
	require_once("conexao.php");
	date_default_timezone_set('America/Sao_Paulo');
	if (file_exists('arquivo.json')) {
		$fila = json_decode(file_get_contents('arquivo.json'));
		$result = mysqli_query($con,"SELECT * FROM Controle_Fila");
		if(mysqli_num_rows($result) > 0){
			$tempo = strtotime(date("H:i:s"));
			$opcao = 0;
			while($dado = mysqli_fetch_array($result)){
				$t1 = strtotime($dado['tempoInicial']);
				$t2 = strtotime($dado['tempoFinal']);
				
				if(($t1 <= $tempo) && ($tempo <=$t2)) {
					$opcao = $dado['tipofila'];
				}
			}
			$fila->alteracao = rand(0,100); 
			$fila->opcaofila = $opcao;
		}
		echo json_encode($fila);
	}else{
		require_once("model/Taxi.class.php");
		require_once("model/fachada.class.php");
		$fachada = new Fachada();
		$fachada->configuraFila();
	}
?>