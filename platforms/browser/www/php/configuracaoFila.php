<?php
	session_start();
	require_once("model/fachada.class.php");
	require_once("conexao.php");

	$tipofila = $_POST['tipofila'];
	$qtdemaxima = $_POST['qtdeMaxima'];
	$qtdeFila1 = $_POST['qtdeFila1'];
	$qtdeFila2 = $_POST['qtdeFila2'];

	$result = mysqli_query($con,"SELECT * FROM Configuracao_Fila WHERE idconfig='1'");
	if(mysqli_num_rows($result) > 0){
		mysqli_query($con,"UPDATE Configuracao_Fila SET tipo_fila='$tipofila', qtde_taxi_fila1='$qtdeFila1',
			qtde_taxi_fila2='$qtdeFila2',qtdemaxima='$qtdemaxima' WHERE idconfig='1'");
		echo "1";
	}else{
		mysqli_query($con,"INSERT INTO Configuracao_Fila (tipo_fila, qtde_taxi_fila1,
			qtde_taxi_fila2,qtdemaxima) VALUES ('$tipofila','$qtdeFila1','$qtdeFila2','$qtdemaxima')");
		echo "2";
	}
	$fachada = new Fachada();
	$fachada->configuraFila();
	echo "ok";

	/*if (file_exists('arquivo.json')) {
		$fila = json_decode(file_get_contents('arquivo.json'));
		$fila->opcaofila = $_POST['tipofila'];
		$fila->alteracao +=  1;
		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($fila));
		fclose($fp);	
		echo "ok";	
	}*/
?>