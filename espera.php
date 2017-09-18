<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Tela de Espera</title>
<!-- Compiled and minified CSS -->
  	<link rel="stylesheet" href="materialize/css/materialize.min.css">
  	<!-- Compiled and minified JavaScript -->
  	<link rel="stylesheet" href="css/style.css" />
  	<link rel="stylesheet" href="css/infraero.css" />
  	<link href="css/icon.css" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="css/font_roboto.css"/>
  	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
  	<script src="materialize/js/materialize.min.js"></script>
  	<script src="js/function.js"></script>
  	<script src="js/infraero.js"></script>
</head>
<body onload="init();">
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col s12 l6 subcontainer">
					<h3 class="titulochamada">POSTO 1</h3>
					<h1 id="saida_posto1"></h1>
					<ul class="proximo" id="fila_posto1">
						
					</ul>
				</div>
				<div class="col s12 l6 subcontainer ">
					<h3 class="titulochamada">CONTROLE DE FILA</h3>
					<h1 id="saida_posto2"></h1>
					<ul class="proximo" id="fila_posto2">
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col s12 subcontainer " style="padding:0px 30px;">
					<ul class="fila" id="fila_posto3">
					</ul>
				</div>
			</div>
		</div>
		<div class="observacao" style="border:none;">
			<ul id="fila_posto3"> 
				<li><i class="small material-icons presente">crop_free</i> Presente</li>
				<li><i class="small material-icons ausente">crop_free</i> Ausente</li>
				<li><i class="small material-icons problema">crop_free</i> Parado</li>
			</ul>
		</div>
		<audio  id="audio">
	   		<source src="assets/sons/alert.mp3" type="audio/mp3" />
		</audio>
	</div>
	<div class="row">
		<div class="col l5"></div>
		<div class="col s12 l2"><a  class="col s12 l2 waves-effect waves-light btn modal-trigger btnbottom" href="#infraero">Consultar Voos</a></div>
		<div class="col l5"></div>
	</div>
	<div id="infraero" class="modal bottom-sheet">
		<?php require_once("infraero.php");?>
	</div>
</body>
</html>