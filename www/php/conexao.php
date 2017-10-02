<?php
	date_default_timezone_set('America/Sao_Paulo');
	$con = mysqli_connect("localhost", "root", "", "taxi_driver");
	if (!$con) {
	    die('Erro ao conectar ao banco: ' . mysql_error());
	}
?>