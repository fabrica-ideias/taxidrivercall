<?php
	date_default_timezone_set('America/Sao_Paulo');
	$con = mysqli_connect("179.180.130.13", "root", "fi2108", "du31xu75psg7waby");
	if (!$con) {
	    die('Erro ao conectar ao banco: ' . mysql_error());
	}
?>