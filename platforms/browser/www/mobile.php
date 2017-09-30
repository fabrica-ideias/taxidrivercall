<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Tela de Espera</title>
<!-- Compiled and minified CSS -->
  	<link rel="stylesheet" href="materialize/css/materialize.min.css">
  	<!-- Compiled and minified JavaScript -->
  	<link rel="stylesheet" href="css/style.css" />
  	<link href="css/icon.css" rel="stylesheet">
  	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
  	<script src="materialize/js/materialize.min.js"></script>
  	<script src="js/function.js"></script>
</head>
<body onload="init();">
	<div class="row container">
		<div class="row">
			<div class="col s12">
				<div class="row">
					<div class="col s6 subcontainer">
						<h3 >POSTO 1</h3>
						<h1 id="saida_posto1"></h1>
						<ul class="proximo" id="fila_posto1">
						</ul>
					</div>
					<div class="col s6 subcontainer ">
						<h3>CONTROLE DE FILA</h3>
						<h1 id="saida_posto2"></h1>
						<ul class="proximo" id="fila_posto2">
						</ul>
					</div>
				</div>
				<div class="row">
						<div class="col s12 subcontainer ">
						<ul class="fila p" id="fila_posto3">
						</ul>
					</div>
				</div>
			</div>
			<div class="col s12">
				<div class="row" >
					<div class="col s12 subcontainer" style="position: absolute;bottom: 0;">
						<button id="proximo" class="btn" style="position: relative;margin: auto;width: 100%;height: 200px;font-size: 4em;">Proximo</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>