<?php
class Taxi{
    var $numero;
    var $status;
    var $dispositivo;
    var $tipo;
    var $qtdeviajem;

    function setNumero($numero){
    	$this->numero = $numero;
    }
    function getNumero(){
    	return $this->numero;
    }
    function setStatus($status){
    	$this->status = $status;
    }
    function getStatus(){
    	return $this->status;
    }
    function setDispositivo($dispositivo){
        $this->dispositivo = $dispositivo;
    }
    function getDispositivo(){
        return $this->dispositivo;
    }
    function setTipo($tipo){
        $this->tipo = $tipo;
    }
    function getTipo(){
        return $this->tipo;
    }
    function setQtdeViajem($qtdeviajem){
        $this->qtdeviajem = $qtdeviajem;
    }
    function getQtdeViajem($qtdeviajem){
        return $this->qtdeviajem;
    }
}
?>