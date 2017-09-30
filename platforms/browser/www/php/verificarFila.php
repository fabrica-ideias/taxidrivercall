<?php
session_start();
require_once("conexao.php");
require_once("model/fachada.class.php");
date_default_timezone_set('America/Sao_Paulo');
if (file_exists('principal.json')) {
    $fachada = new Fachada();
    $fachada->iniciarFiladoDia();
    if (!file_exists('arquivo.json')) {
        $fachada->iniciarFiladoDia();
    }else{
        $fila = json_decode(file_get_contents('arquivo.json'));
        $result = mysqli_query($con, "SELECT * FROM Controle_Fila");
        $opcao = 1;
        if (mysqli_num_rows($result) > 0) {
            $tempo = strtotime(date("H:i:s"));
            while ($dado = mysqli_fetch_array($result)) {
                $t1 = strtotime($dado['tempoInicial']);
                $t2 = strtotime($dado['tempoFinal']);

                if (($t1 <= $tempo) && ($tempo <= $t2)) {
                    $opcao = $dado['tipofila'];
                }
            }
            if($fila->opcaofila != $opcao){
                $fila->alteracao = rand(0,100);
            }
        }
        if($fila->opcaofila != 0 && $opcao == 0){
            $fp = fopen('anterior.json', 'w');
            fwrite($fp, json_encode($fila));
            fclose($fp);
            $inicio = json_decode(file_get_contents('principal.json'));
            $fila->opcaofila = $opcao;
            $posto3 = [];
            $plantao_on = [];
            $plantao_off = [];
            $biqueira = [];
            foreach ($inicio->biqueira as $taxi) {
                $biqueira[] = $taxi;
            }
            foreach($fila->posto3 as $taxi){
                if($taxi->tipo == "plantao"){
                    if($taxi->status == "presente"){
                        $plantao_on[] = $taxi; 
                    }else{
                        $plantao_off[] = $taxi;
                    }
                }
            }
            foreach ($plantao_off as $taxi) {
                $posto3[] = $taxi;
            }
            foreach ($biqueira as $taxi) {
                $posto3[] = $taxi;
            }
            foreach ($plantao_on as $taxi) {
                $posto3[] = $taxi;
            }
            
            $fila->posto3 = $posto3;
            $fp = fopen('arquivo.json', 'w');
            fwrite($fp, json_encode($fila));
            fclose($fp);
        }else if($opcao == 1 && $fila->opcaofila != $opcao){
            $inicio = json_decode(file_get_contents('anterior.json'));
            $inicio->opcaofila = $opcao;
            $fp = fopen('arquivo.json', 'w');
            fwrite($fp, json_encode($inicio));
            fclose($fp);
        }
        echo json_encode($fila);
    }
} else {
    require_once("model/Taxi.class.php");
    require_once("model/fachada.class.php");
    $fachada = new Fachada();
    $fachada->configuraFila();
}
?>