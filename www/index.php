<?php session_start(); ?>
<!DOCTYPE html>
<html >
<head>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta charset="utf-8"/>
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
	<title>Login</title>
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="materialize/css/materialize.min.css">
	<!-- Compiled and minified JavaScript -->
	<link rel="stylesheet" href="css/login.css" />
	<link href="css/icon.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style_tablet.css" />
	<link rel="stylesheet" type="text/css" href="css/font_roboto.css"/>
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="materialize/js/materialize.min.js"></script>
	<!-- Latest Sortable -->
	<script src="//rubaxa.github.io/Sortable/Sortable.js"></script>
	<!-- <script src="js/function.js"></script> -->
	<script src="js/function.js" type="text/javascript"></script>
	<script src="js/login.js" type="text/javascript"></script>

</head>
<body onload="initLogin()">
	<!-- Login -->
	<div class="row" id="containerLogin">
		<div class="col s12 m4 l4"></div>
		<div class="col s12 m12 l4" id="form">
			<form method="POST" class="col s12 m12 l12" id="fLogin">
				<div class="row">
					<div class="col s4 m5 l4"></div>
					<div class="col s4 m2 l4 z-depth-4" id="imgUser"></div>
					<div class="col s4 m5 l4"></div>
				</div>	
				<div id="nameLogin"></div>
				<div class="progress" id="progress">
					<div class="indeterminate"></div>
				</div>
				<div class="row" id="fieldEmail">
					<div class="input-field col s12">
						<input id="email"  type="email"  class="validate" required="true" />
						<label for="email" id="lEmail" data-error="E-mail Invalido" >E-mail</label>
					</div>
				</div>
				<div class="row" id="fieldPassword">
					<div class="input-field col s12">
						<input id="password" type="password" class="validate"/>
						<label for="password" data-error="Senha incorreta">Senha</label>
					</div>
				</div>
				<div class="row">
					<div class="col s12" id="checkConect" style="margin-bottom: 5px"></div>
					<a  class="s12 btn" id="logar" style="margin-bottom: 5px">PRÓXIMO</a>
					<div class="col s12"><a  id="cadastro" style="margin-bottom: 5px">Cadastre-se</a></div>
				</div>		
			</form>
			<?php require_once("cadastro.php");?>
		</div>
		<div class="col s12 m4 l4"></div>
	</div>

	<!-- Painel de Controlle -->
	<div class="row" id="container">
		<nav class="nav-extended" id="menu_painel">
			<div class="nav-wrapper">
				<img src="" height="100%" id="logo" class="brand-logo">
				<a href="#" id="mobile" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li><a id="btnConfiguracao" href="#">Configuração de Tela</a></li>
					<li><a id="logout" href="#">Sair</a></li>
				</ul>
				<ul class="side-nav" id="mobile-demo">
					<li><a id="btnConfiguracaoMobile" href="#">Configuração de Tela</a></li>
					<li><a id="logoutMobile" href="#">Sair</a></li>
				</ul>
			</div>
		</nav>	
		<div class="row">
			<div class="col s12 l12" id="conteudo_painel">
				<div id="home" class="col s12">
					<div class="row">
						<div class="row">
							<div class="col s12 subcontainer ">
								<div class="row">
									<div class="col s12 m6">
										<div class="col s12" style="padding: 10px" >
											<div class="bloco_fila z-depth-2">
												<a><i class="material-icons icons_list">info</i></a>
												<h3 class="titulochamada">POSTO 1</h3>
												<p style="text-align:center">Ultimo taxi chamado</p>
												<h1 id="saida_posto1">-</h1>
												<div class="lista_taxi">
													<div class="tamanhoMaximo"	>
														<ul class="proximo" id="fila_posto1">
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col s12 m6">
										<div class="col s12 " style="padding: 10px">
											<div class="bloco_fila z-depth-2">
												<a><i class="material-icons icons_list">info</i></a>
												<h3 class="titulochamada">POSTO 2</h3>
												<p style="text-align:center">Corrida Bônus</p>
												<h1 id="saida_posto2">-</h1>
												<div class="lista_taxi">
													<div class="tamanhoMaximo">
														<ul class="proximo" id="fila_posto2">
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col s12 bloco_fila media z-depth-5" id="filaprincipal">
						<p style="font-size: 2em;text-align: center;">FILA UNICA</p>
						<div class="lista_taxi">
							<div class="tamanhoMaximo"	>
								<ul class="fila" id="fila_posto3">
								</ul>
							</div>
						</div>
					</div>
					<div class="col s12 bloco_fila media z-depth-5" id="filapratao">
						<p style="font-size: 2em;text-align: center;">PLANTÃO</p>
						<div class="lista_taxi">
							<div class="tamanhoMaximo">
								<ul class="fila" id="plantao">
								</ul>

							</div>
						</div>
						<p style="font-size: 2em;text-align: center;">BIQUEIRA</p>
						<div class="lista_taxi">
							<div class="tamanhoMaximo">
								<ul class="fila" id="biqueira">
								</ul>	
							</div>
						</div>	
					</div>

					<div class="row">
						<div class="col s12 m12 l12">
							<a class="btn_modal modal-trigger z-depth-5" href="#modalChamada"><i class="material-icons ">record_voice_over</i> CHAMAR TAXI</a>
							<a class="btn_modal modal-trigger z-depth-5" href="#modalConfiguracao"><i class="material-icons ">settings</i> CONFIGURAÇÃO</a>
						</div>
					</div>
				</div>

				<!-- Modal do dados do taxi -->
				<div id="modal1" class="modal">
					<div class="modal-content">
						<div class="row">
							<div class="input-field col s12">
								<input disabled id="taxista" value="ZE" type="text" class="validate">
								<label for="taxista">Taxista</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s4">
								<input disabled value="" id="numtaxi" type="number" class="validate">
								<label for="numtaxi">NUMERO DO TAXI</label>
							</div>
							<div class="input-field col s4">
								<input disabled value="" id="ultimadeteccao" type="text" class="validate">
								<label for="ultimadeteccao">Ultima Detecção</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
					</div>
				</div>
				<!--  Modal de chamada -->
				
				<div class="row">
					<div class="col s5"></div>
					<div class="col s2">
						<div id="modalChamada" class="modal">
							<div class="modal-content">
								<div class="container_modalChamada">
									<div class="container_btn_float">
										<button type="button" id="removeChamado" class="col s12 btn">-</button></br>
										<button type="button" id="addChamado" class="col s12 btn">+</button>
									</div>
									<h1 id="qtdeChamada"></h1>
									
								</div>
								<div class="row">
									<button class="input-field col s12 btn" id="btnChamar" style="background-color: #0fc11f;">CHAMAR</button>
								</div>
							</div>
							<div class="col s5"></div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row" >
		<div class="col s12">
			<div class="configuracao" id="configuracao">
				<a id="cancelar">X</a>
				<div class="col s4">
					<p>Cor do Menu</p><input type="color" id="cor_menu"/>
					<p>Cor do Painel de Conteudo</p><input type="color" id="cor_conteudo"/>
					<p>Cor do Fundo</p><input type="color" id="cor_fundo"/>
				</div>
				<div class="col s8 l4">
					<form action="#">
						<div class="file-field input-field">
							<div class="btn">
								<span>File</span>
								<input type="file" accept="image/*" class="fileImg" name="file" id="file">
							</div>
							<div class="file-path-wrapper">
								<input type="file" accept="image/*" class="fileImg" name="fileLogo" id="fileLogo">
								<input class="file-path validate" type="text" placeholder="Upload one or more files">
							</div>
						</div>
					</form>
					<div class="col s2 l5"></div>
					<button class="col s8 l2 btn" id="btnSalvaConfig">Salvar</button>
					<div class="col s2 l5"></div>
				</div>
			</div>
		</div>
	</div>
	<!--  Modal de Load -->
	<div id="modalLoad" class="">
		<div class="preloader-wrapper big active">
			<div class="spinner-layer spinner-blue-only">
				<div class="circle-clipper left">
					<div class="circle"></div>
				</div><div class="gap-patch">
					<div class="circle"></div>
				</div><div class="circle-clipper right">
					<div class="circle"></div>
				</div>
			</div>
		</div>
	</div>
	<!--  Modal de Configuração -->
	<div id="modalConfiguracao" class="">
		<div class="list_config">
			
			<div class="row">
				<nav>
					<div class="nav-wrapper" style=" text-transform: uppercase;">
						<ul>
							<li id="painelConfigFila"><a>Fila</a></li>
							<li id="painelHorarioFila"><a>Horários</a></li>
							<li id="painelConfigPosicao"><a>Posição</a></li>
							<li id="closeConfiguracaoModal"><i class="material-icons">close</i></li>
						</ul>
					</div>
				</nav>
			</div>
			<div class="row conteudoConfiguracao">
				<div class="col s12">
					<!-- Posicao -->
					<div class="row"  id="configPosicao">
						<div class="row">
							<div class="col s12 subcontainer" id="multposicao">
								<div> 
									<ul class="ordemFila" id="posicao_posto1">
									</ul>
									<ul class="ordemFila" id="posicao_posto2">
									</ul>
									<ul class="ordemFila" id="posicao_posto3">
									</ul>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col s4"></div>
							<button class="col s4 btn" style="position: absolute;">Salva Ordem</button>
							<div class="col s4"></div>
						</div>
					</div>
					<!-- Configuração de fila -->
					<div class="row" id="configFila">
						<div class="row">
							<div class="input-field col s5">
								<input id="qtdeFila1" placeholder=" "  type="number" class="validate">
								<label for="qtdeFila1" class="active">Quantidade Taxi Fila 1</label>
							</div>
							<div class="input-field col s1"></div>
							<div class="input-field col s5">
								<input id="qtdeFila2" placeholder=" " type="number" class="validate">
								<label for="qtdeFila2" class="active">Quantidade Taxi Fila 2</label>
							</div>
						</div>
						<div class="input-field col s11">
							<input id="qtdemaxima" type="number" placeholder=" "  class="validate">
							<label for="disabled" class="active">Quantidade Maxima de Taxi</label>
						</div>
						<div class="row">
							<div class="input-field col s2">
								<p>Presente</p><input id="corPresente" type="color">
							</div>
							<div class="input-field col s2">
								<p>Ausente</p><input id="corAusente" type="color">
							</div>
							<div class="input-field col s2">
								<p>Problema</p><input id="corProblema" type="color">
							</div>
							<div class="input-field col s2">
								<p>Plantão</p><input id="corPlantao" type="color">
							</div>
							<div class="input-field col s2">
								<p>Biqueira</p><input id="corBiqueira" type="color">
							</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<div class="col l4"></div>
							<button class="col s12 l4 btn" id="salvaConfiguracaoFila">Salva Alteracao</button>
							<div class="col l4"></div>
						</div>
					</div>

					<!-- Configuração de horario -->
					<div class="col s12 l4" id="horarioFila">
						<div class="row">
							<div class="input-field col s3">
								<input id="tempoInicial" type="time" class="validate">
							</div>
							<div class="input-field col s1">
								<label>A</label>
							</div>
							<div class="input-field col s3">
								<input id="tempoFinal" type="time" class="validate">
							</div>
						</div>
						<div class="row">
							<div class="col 5">
								<input name="opcaofila" type="radio" id="tipofila1" />
								<label for="tipofila1">Fila Principal</label>
							</div>
							<div class="input-field col s1"></div>
							<div class="col 5">
								<input name="opcaofila" type="radio" id="tipofila2" />
								<label for="tipofila2">Fila Alternativa</label>
							</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<div class="col l4"></div>
							<button class="col s12 l4 btn" id="salvaHorario">Salva</button>
							<div class="col l4"></div>
						</div>
						<table>
							<thead>
								<tr>
									<th>Tipo Fila</th>
									<th>Horario Inicial</th>
									<th>Horario Final</th>
									<th><th>
									</tr>
								</thead>

								<tbody id="listaControle">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body> 
</html>