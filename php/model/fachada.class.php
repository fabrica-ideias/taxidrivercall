<?php 
require_once("model/Usuario.php");
require_once("model/Configuracao.class.php");
require_once("model/Taxi.class.php");
class Fachada{	
		//Usuario
	function getUsuarioPorId($idusuario){
		include("conexao.php");
		$result = mysqli_query($con,"SELECT * FROM Usuario where idusuario='$idusuario'");
		if( mysqli_num_rows($result) > 0){
			$dados =  mysqli_fetch_array($result);
			$usuario = new Usuario();
			$usuario-> setUsuario($dados);
			return $usuario;
		}
		return null;
	}
	function getConfiguracao(){
		include("conexao.php");
		$result = mysqli_query($con,"SELECT * FROM Configuracao where idconfig='1'");
		if( mysqli_num_rows($result) > 0){
			$dados =  mysqli_fetch_array($result);
			return json_encode($dados);
		}
		return null;
	}
	function getConfiguracaoFila(){
		include("conexao.php");
		$result = mysqli_query($con,"SELECT * FROM Configuracao_Fila where idconfig='1'");
		if( mysqli_num_rows($result) > 0){
			$dados =  mysqli_fetch_array($result);
			return json_encode($dados);
		}
		return null;
	}

	function getUsuarioEmail($email){
		include("conexao.php");
		$result = mysqli_query($con,"SELECT * FROM Usuario WHERE email='$email'");
		if(mysqli_num_rows($result)>0){
			$dados =  mysqli_fetch_array($result);
			echo json_encode($dados);
		}else{
			echo "0";
		}
	}

	function salvaUsuario($usuario){
		include("conexao.php");
		mysqli_query($con,"INSERT INTO Usuario (nome,email,senha,perfil) values ('".$usuario->getNome()."','".$usuario->getEmail()."','".$usuario->getSenha()."','".$usuario->getPerfil()."')");
		$fachada = new Fachada();
		$fachada->startSession('false','idusuario',mysqli_insert_id($con));
		echo "0";
	}
	function salvaConfiguracao($config){
		include("conexao.php");
		mysqli_query($con,"UPDATE Configuracao SET cor_fundo = '$config->cor_fundo', cor_conteudo = '$config->cor_conteudo', cor_menu = '$config->cor_menu'  WHERE idconfig='1'");
		echo "ok";
	}

	function startSession($manterConectado,$session,$valor){	
		session_start();
		$_SESSION[$session] = $valor;
		if($manterConectado == "true"){
			setcookie($session, $_SESSION[$session], PHP_INT_MAX);
		}
	}
	function alteraStatusTaxi($dispositivo){
		$taxis = json_decode(file_get_contents('arquivo.json'));
		foreach ($taxis->posto1 as $taxi) {
			if($taxi->dispositivo == $dispositivo){
				if($taxi->status == "presente"){
					$taxi->status = "ausente";
				}else{
					$taxi->status = "presente";
				}
				break;
			}
		}
		foreach ($taxis->posto2 as $taxi) {
			if($taxi->dispositivo == $dispositivo){
				if($taxi->status == "presente"){
					$taxi->status = "ausente";
				}else{
					$taxi->status = "presente";
				}
				break;
			}
		}
		foreach ($taxis->posto3 as $taxi) {
			if($taxi->dispositivo == $dispositivo){
				if($taxi->status == "presente"){
					$taxi->status = "ausente";
				}else{
					$taxi->status = "presente";
				}
				break;
			}
		}

		$taxis->alteracao =  rand(0,100); ;
		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($taxis));
		fclose($fp);	
		echo json_encode($taxis);
	}
	function alteraBeaconTaxi($numero,$dispositivo){
		$taxis = json_decode(file_get_contents('arquivo.json'));
		foreach ($taxis->posto1 as $taxi) {
			if($taxi->numero == $numero){
				$taxi->dispositivo = $dispositivo;
				break;
			}
		}
		foreach ($taxis->posto2 as $taxi) {
			if($taxi->numero == $numero){
				$taxi->dispositivo = $dispositivo;
				break;
			}
		}
		foreach ($taxis->posto3 as $taxi) {
			if($taxi->numero == $numero){
				$taxi->dispositivo = $dispositivo;
				break;
			}
		}
		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($taxis));
		fclose($fp);	
		echo json_encode($taxis);
	}
	function ordenarFila($fila,$id){
		$posto1 = [];
		$posto2 = [];
		$posto3 = [];
		$problema = [];
		for ($i=0; $i < count($fila); $i++) { 
			if(count($posto1) < 6){
				if($fila[$i]->status == "presente"){
					$posto1[] = $fila[$i];
				}else{
					if($fila[$i]->status == "problema"){
						$problema[] = $fila[$i];
					}else{
						$posto3[] = $fila[$i];
					}
				}
			}elseif(count($posto2) < 6 && count($posto1) == 6){
				if( $fila[$i]->status == "presente"){
					$posto2[] = $fila[$i];
				}else{
					if($fila[$i]->status == "problema"){
						$problema[] = $fila[$i];
					}else{
						$posto3[] = $fila[$i];
					}
				}
			}else if(count($posto2) == 6 & count($posto1) == 6){
				if($fila[$i]->status == "presente" || $fila[$i]->status == "ausente" ){
					$posto3[] = $fila[$i];
				}else{
					$problema[] = $fila[$i];
				}
			}
		}
		$ordem = array("posto1" => $posto1 , "posto2" => $posto2, "posto3" => $posto3,"problemas" =>$problema,"id"=>$id);
		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($ordem));
		fclose($fp);
		echo json_encode($ordem);
	}

	function configuraFila(){
		$fachada = new Fachada();
		$confFila = json_decode($fachada->getConfiguracaoFila());
		$fila = array();
		$status = "presente";
		for ($i=0; $i < $confFila->qtdemaxima; $i++) { 
			$random_keys=array_rand($status,2);
			$taxi = new Taxi();
			$taxi->setNumero(($i + 1));
			$taxi->setStatus($status);
			if($i%2 == 0){
				$taxi->setTipo("plantao");
			}else{
				$taxi->setTipo("biqueira");
			}
			$taxi->setDispositivo("");
			$taxi->setQtdeViajem(0);
			$fila[] = $taxi;
		}
		$posto1 = [];
		$posto2 = [];
		$posto3 = [];
		$problema = [];
		for ($i=0; $i < count($fila); $i++) { 
			if(count($posto1) < $confFila->qtde_taxi_fila1){
				if($fila[$i]->status == "presente"){
					$posto1[] = $fila[$i];
				}else{
					if($fila[$i]->status == "problema"){
						$problema[] = $fila[$i];
					}else{
						$posto3[] = $fila[$i];
					}
				}
			}elseif(count($posto2) < $confFila->qtde_taxi_fila2 && count($posto1) == $confFila->qtde_taxi_fila1){
				if( $fila[$i]->status == "presente"){
					$posto2[] = $fila[$i];
				}else{
					if($fila[$i]->status == "problema"){
						$problema[] = $fila[$i];
					}else{
						$posto3[] = $fila[$i];
					}
				}
			}else if(count($posto2) == $confFila->qtde_taxi_fila2 && count($posto1) == $confFila->qtde_taxi_fila1){
				if($fila[$i]->status == "presente" || $fila[$i]->status == "ausente" ){
					$posto3[] = $fila[$i];
				}else{
					$problema[] = $fila[$i];
				}
			}
		}
		$alteracao = rand(0,100); 
		$ordem = array("posto1" => $posto1 , "posto2" => $posto2, "posto3" => $posto3,"problemas" =>$problema,"id"=>1,"alteracao"=>$alteracao,
			"opcaofila"=>$confFila->tipo_fila,"plantao"=> 0, "biqueira"=>0,"dia",date("d-m-Y"));
		$fp = fopen('principal.json', 'w');
		fwrite($fp, json_encode($ordem));
		fclose($fp);
		echo json_encode($ordem);
	}

	function getHorarioFila(){
		include("conexao.php");
		$result = mysqli_query($con,"SELECT * FROM Controle_Fila");
		$opcao = 0;
		if(mysqli_num_rows($result) > 0){
			$tempo = strtotime(date("H:i:s"));
			while($dado = mysqli_fetch_array($result)){
				$t1 = strtotime($dado['tempoInicial']);
				$t2 = strtotime($dado['tempoFinal']);	
				if(($t1 <= $tempo) && ($tempo <=$t2)) {
					$opcao = $dado['tipofila'];
				}
			}
		}
		return $opcao;
	}
}
?>