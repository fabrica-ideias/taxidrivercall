<?php
$con = mysqli_connect("localhost", "root", "", "taxi_driver");
if (!$con) {
    die('Erro ao conectar ao banco: ' . mysql_error());
}

?>