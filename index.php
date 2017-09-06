<?php session_start(); ?>
<!DOCTYPE html>
<html >
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"/>
	<title>Login</title>
	<!-- Compiled and minified CSS -->
  	<link rel="stylesheet" href="materialize/css/materialize.min.css">
  	<!-- Compiled and minified JavaScript -->
  	<link rel="stylesheet" href="css/login.css" />
  	<link href="css/icon.css" rel="stylesheet">
  	<link rel="stylesheet" href="css/style.css" />
  	<link rel="stylesheet" type="text/css" href="css/font_roboto.css"/>
  	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
  	<script src="materialize/js/materialize.min.js"></script>
	<script src="js/login.js" type="text/javascript"></script>
	<script src="js/function.js"></script>
</head>
<body onload="initLogin()">
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
	<nav class="nav-extended" id="conteudo">
		<div class="nav-wrapper">
			<a href="#" data-activates="mobile-demo" class="button-collapse">
				<i class="material-icons">menu</i>
			</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<li><a id="logout">Sair</a></li>
			</ul>
			<ul class="side-nav" id="mobile-demo">
				<li><a id="logout">Sair</a></li>
			</ul>
		</div>
	    <div class="nav-content">
	      <ul class="tabs tabs-transparent">
	        <li class="tab"><a href="#test1">HOME</a></li>
	        <li class="tab"><a  class="active" href="#test2" id="btnTaxi">TAXIS</a></li>
	      </ul>
	    </div>
  	</nav>
  	<div id="test1" class="col s12">
 	</div>
  	<div id="test2" class="col s12">
  		<div class="row">
			<div class="col s2">
				<ul class="collapsible" data-collapsible="accordion">
					<li>
						<div class="collapsible-header">
							<i class="material-icons">list</i>Lista
						</div>
						<div class="collapsible-body">
							<ul>
								<li><a href="telaespera.php">Lista de espera</a></li>
								<li><a href="configurafila.php">Ordenar fila de Taxi</a></li>
							</ul>
						</div>
					</li>
					<li>
						<div class="collapsible-header">
							<i class="material-icons">settings</i>
							Configuração</div>
						<div class="collapsible-body">
							<span>Lorem ipsum dolor sit amet.</span>
						</div>
					</li>
				</ul>
			</div>
			<div class="col s12">
				<?php require_once("fila.php");?>
			</div>
		</div>
  	</div>	
</body> 
</html>