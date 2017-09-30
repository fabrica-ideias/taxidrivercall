<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i:s');
$depois = date("Y-m-d H:i:s",strtotime($date." +5 minutes"));
 $tempoDepois = strtotime($depois);
 $tempoAgora = strtotime($date);
 echo $tempoAgora." ".$tempoDepois;

?>