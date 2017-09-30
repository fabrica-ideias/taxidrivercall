<?php
	session_start();
	require_once("model/fachada.class.php");
	require_once("conexao.php");

	$result = mysqli_query($con,"SELECT * FROM Controle_Fila");
	$controles = array();
	while($dado = mysqli_fetch_array($result)){
		$controles[] = $dado;
	}

	echo json_encode($controles);
?>