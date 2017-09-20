<?php 
	require_once("model/fachada.class.php");
	$fachada = new Fachada();
	$mac = $_GET['mac'];
	$fachada->alteraStatusTaxi($mac);

?>