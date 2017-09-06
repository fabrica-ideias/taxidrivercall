<?php 
	class Produto{
		var $idproduto;
		var $descricao;
		var $marca;
		var $quantidade;
		var $preco;
		var $img;

		 function setIdproduto($idproduto){
	    	$this->idproduto = $idproduto;
	    }
	    function getIdproduto(){
	    	return $this->idproduto;
	    }

	    function setDescricao($descricao){
	    	$this->descricao = $descricao;
	    }
	    function getDescricao(){
	    	return $this->descricao;
	    }
	    function setMarca($marca){
	    	$this->marca = $marca;
	    }
	    function getMarca(){
	        return  $this->marca;
	    }
	    function setQuantidade($quantidade){
	    	$this->quantidade = $quantidade;
	    }
	    function getQuantidade(){
	        return $this->quantidade;
	    }
	    function setPreco($preco){
	        $this->preco = $preco;
	    }
	    function getPreco(){
	        return $this->preco;
	    }
	    function setPerfil($perfil){
	        $this->perfil = $perfil;
	    }
	    function getPerfil(){
	        return $this->perfil;
	    }
	}
	
?>