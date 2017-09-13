<?php
	require_once("model/fachada.class.php");
	$fachada = new fachada();
	$fachada->alteraBeaconTaxi($_POST['taxi'],$_POST['beacon']);
?>