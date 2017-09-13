<?php 
	require_once("model/Usuario.php");
	require_once("model/Configuracao.class.php");
	class Fachada{	
		//Usuario
		function getUsuarioPorId($idusuario){
			include("conexao.php");
			$result = mysqli_query($con,"SELECT * FROM du31xu75psg7waby.Usuario where idusuario='$idusuario'");
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
			$result = mysqli_query($con,"SELECT * FROM du31xu75psg7waby.Configuracao where idconfig='1'");
			if( mysqli_num_rows($result) > 0){
				$dados =  mysqli_fetch_array($result);
				return json_encode($dados);
			}
			return null;
		}

		function getUsuarioEmail($email){
			include("conexao.php");
			$result = mysqli_query($con,"SELECT * FROM du31xu75psg7waby.Usuario WHERE email='$email'");
			if(mysqli_num_rows($result)>0){
				$dados =  mysqli_fetch_array($result);
				echo json_encode($dados);
			}else{
				echo "0";
			}
		}

		function salvaUsuario($usuario){
			include("conexao.php");
			mysqli_query($con,"insert into du31xu75psg7waby.Usuario (nome,email,senha,perfil) values ('".$usuario->getNome()."','".$usuario->getEmail()."','".$usuario->getSenha()."','".$usuario->getPerfil()."')");
			$fachada = new Fachada();
			$fachada->startSession('false','idusuario',mysqli_insert_id($con));
			echo "0";
		}
		function salvaConfiguracao($config){
			include("conexao.php");
			mysqli_query($con,"UPDATE du31xu75psg7waby.Configuracao SET cor_fundo = '$config->cor_fundo', cor_conteudo = '$config->cor_conteudo', cor_menu = '$config->cor_menu'  WHERE idconfig='1'");
			echo "ok";
		}
		
		function startSession($manterConectado,$session,$valor){	
			session_start();
			$_SESSION[$session] = $valor;
			if($manterConectado == "true"){
				setcookie($session, $_SESSION[$session], PHP_INT_MAX);
			}
		}
		function alteraStatusTaxi($dispositivo,$status){
			$taxis = json_decode(file_get_contents('arquivo.json'));
			foreach ($taxis->posto1 as $taxi) {
				if($taxi->dispositivo == $dispositivo){
					$taxi->status = $status;
					break;
				}
			}
			foreach ($taxis->posto2 as $taxi) {
				if($taxi->dispositivo == $dispositivo){
					$taxi->status = $status;
					break;
				}
			}
			foreach ($taxis->posto3 as $taxi) {
				if($taxi->dispositivo == $dispositivo){
					$taxi->status = $status;
					break;
				}
			}

			$taxis->alteracao +=  1;
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
	}
?>