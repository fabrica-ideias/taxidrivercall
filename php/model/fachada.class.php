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
	function existBeacon($dispositivo){
		$verificar = 0;
		$taxis = json_decode(file_get_contents('arquivo.json'));
		foreach ($taxis->posto1 as $taxi) {
			if($taxi->dispositivo == $dispositivo){
				$verificar =	 1;
				break;
			}
		}
		foreach ($taxis->posto2 as $taxi) {
			if($taxi->dispositivo == $dispositivo){
				$verificar = 1;
				break;
			}
		}
		foreach ($taxis->posto3 as $taxi) {
			if($taxi->dispositivo == $dispositivo){
				$verificar = 1;
				break;
			}
		}
		return $verificar;
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
		$biqueira = [];
		$plantao = [];
		$status = "presente";
		for ($i=0; $i < $confFila->qtdemaxima; $i++) { 
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
			if($taxi->getTipo() == "biqueira"){
				$biqueira[] = $taxi;
			}else{
				$plantao[] = $taxi;
			}
		}
		$alteracao = rand(0,100); 
		$ordem = array("posto1" => [] , "posto2" =>[], "posto3" => [],"problemas" =>[],"id"=>1,"alteracao"=>$alteracao,
			"opcaofila"=>$confFila->tipo_fila,"plantao"=> $plantao,
			"biqueira"=>$biqueira,"dia"=>date("d-m-Y"),"contadorBiqueira"=>0,"contadorPlantao"=>0);
		$fp = fopen('principal.json', 'w');
		fwrite($fp, json_encode($ordem));
		fclose($fp);
	}

	function getHorarioFila(){
		include("conexao.php");
		$result = mysqli_query($con,"SELECT * FROM Controle_Fila");
		$opcao = 1;
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

	function iniciarFiladoDia(){
		$taxis = json_decode(file_get_contents('principal.json'));
		$ultimodia = strtotime($taxis->dia);
		$hoje = strtotime(date('d-m-Y'));
		if(!file_exists('arquivo.json')){
			$this->reiniciaFila($taxis);
		}

		if($ultimodia != $hoje){
			$taxi = $taxis->plantao[0];
			for($i = 0; $i < count($taxis->plantao);$i++){
				if($i + 1 != count($taxis->plantao)){
					$taxis->plantao[$i]->tipo = "biqueira";
					$aux = $taxis->plantao[$i + 1];
					$taxis->plantao[$i + 1] = $taxi;
					$taxi = $aux;
				}
			}
			$taxi->tipo ="biqueira";
			$taxis->plantao[0] = $taxi;
			foreach($taxis->biqueira as $biqueira){
				$biqueira->tipo = "plantao";
			}
			$biqueira = $taxis->plantao;
			$taxis->plantao = $taxis->biqueira;
			$taxis->biqueira = $biqueira;
			$this->reiniciaFila($taxis);
		}
	}
	function reiniciaFila($taxis){
		$confFila = json_decode($this->getConfiguracaoFila());
		$posto1 = [];
		$posto2 = [];
		$posto3 = [];
		$problema = [];

		$plantao = 0;
		$p = 0;
		$biqueira = 0;
		$b = 0;
		for($i = 0; count($posto1) < $confFila->qtde_taxi_fila1; $i++){
			$posto1[] = $taxis->plantao[$plantao];
			$plantao++; 
			$p++;
		}
		for($i = 0; count($posto2) < $confFila->qtde_taxi_fila2; $i++){
			if($p == 10 && $b == 3){
				$b = 0;
				$p = 0;
			}
			if($p < 10){
				$posto2[] = $taxis->plantao[$plantao];
				$plantao++; 
				$p++;
			}else if($p == 10 && $b < 3){
				$posto2[] = $taxis->biqueira[$biqueira];
				$biqueira++; 
				$b++;
			}
		}
		for($i = $plantao; $i < count($taxis->plantao);$i++){
			$posto3[] = $taxis->plantao[$i];
		}
		for($i = $biqueira; $i < count($taxis->biqueira);$i++){
			$posto3[] = $taxis->biqueira[$i];
		}

		$alteracao = rand(0,100);
		$ordem = array("posto1" => $posto1 , "posto2" => $posto2, "posto3" => $posto3,"problemas" =>$problema,"id"=>1,"alteracao"=>$alteracao,
			"opcaofila"=>1,"plantao"=> $p, "biqueira"=>$b,"dia"=>date("d-m-Y"),"chamados"=>[]);
		$fp = fopen('arquivo.json', 'w');
		fwrite($fp, json_encode($ordem));
		fclose($fp);
		$this->AtualizaDataFila($taxis);
	}

	function AtualizaDataFila($fila){
		$fila->dia = date('d-m-Y');
		$ordem = array("posto1" => $fila->posto1 , "posto2" => $fila->posto2, "posto3" => $fila->posto3,"problemas" =>$fila->problemas,"id"=>1,"alteracao"=>$fila->alteracao,
			"opcaofila"=>$fila->opcaofila,"plantao"=> 0, "biqueira"=>0,"dia"=>date("d-m-Y"));
		$fp = fopen('principal.json', 'w');
		fwrite($fp, json_encode($fila));
		fclose($fp);
	}
}
?>