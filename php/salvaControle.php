<?php
	session_start();
	require_once("model/fachada.class.php");
	require_once("conexao.php");

	$opcao = $_POST['opcao'];
	$tempoFinal = $_POST['tempoFinal'];
	$tempoInicial = $_POST['tempoInicial'];

	mysqli_query($con,"INSERT INTO du31xu75psg7waby.Controle_Fila(tipofila, tempoInicial,
			tempoFinal) VALUES ('$opcao','$tempoInicial','$tempoFinal')");
	
	$result = mysqli_query($con,"SELECT * FROM du31xu75psg7waby.Controle_Fila");
	$controles = array();
	while($dado = mysqli_fetch_array($result)){
		$controles[] = $dado;
	}

	echo json_encode($controles);
?>