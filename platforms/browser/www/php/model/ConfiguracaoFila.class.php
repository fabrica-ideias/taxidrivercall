<?php
class ConfiguracaoFila{
    var $idconfig;
    var $qtde_taxi_fila1;
    var $qtde_taxi_fila2;
    var $qtdemaxima;
    var $tipo_fila;
    function setConfiguracao($dados){
    	$this->idconfig = $dados['idconfig'];
    	$this->qtde_taxi_fila1 = $dados['qtde_taxi_fila1'];
    	$this->qtde_taxi_fila2 = $dados['qtde_taxi_fila2'];
    	$this->qtdemaxima = $dados['qtdemaxima'];
        $this->tipo_fila = $dados['tipo_fila'];
    }

    function setIdconfig($idconfig){
    	$this->idconfig = $idconfig;
    }
    function getIdconfig(){
        return $this->idconfig;
    }
    function getQtdeTaxiFila1(){
    	return $this->qtde_taxi_fila1;
    }
    function setQtdeTaxiFila1($qtde_taxi_fila1){
        $this->qtde_taxi_fila1 = $qtde_taxi_fila1;
    }
    function getQtdeTaxiFila2(){
        return $this->qtde_taxi_fila2;
    }
    function setQtdeTaxiFila2($qtde_taxi_fila2){
        $this->qtde_taxi_fila2 = $qtde_taxi_fila2;
    }
    function getQtdeMaxima(){
        return $this->qtdemaxima;
    }
    function setQtdeMaxima($qtdemaxima){
        $this->qtdemaxima = $qtdemaxima;
    }
    function getTipoFila(){
        return $this->tipo_fila;
    }
    function setTipoFila($tipo_fila){
        $this->tipo_fila = $tipo_fila;
    }
    
    


}
?>