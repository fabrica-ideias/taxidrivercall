<?php 
	require_once("model/fachada.class.php");
	$dispositivo = $_GET['mac'];
	$fachada = new fachada();
	$fachada->alteraStatusTaxi($dispositivo,"presente");
?>