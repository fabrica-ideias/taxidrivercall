<?php
	session_start();
	require_once("model/fachada.class.php");
	require_once("conexao.php");
	$result = mysqli_query($con,"SELECT * FROM Configuracao_Fila WHERE idconfig='1'");

	echo json_encode(mysqli_fetch_array($result));

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