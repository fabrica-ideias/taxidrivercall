<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Controle de Fila</title>
<!-- Compiled and minified CSS -->
  	<link rel="stylesheet" href="materialize/css/materialize.min.css">
  	<!-- Compiled and minified JavaScript -->
  	<link rel="stylesheet" href="css/style.css" />
  	<link href="css/icon.css" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="css/font_roboto.css"/>
  	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
  	<script src="materialize/js/materialize.min.js"></script>
  	<script src="js/jquery-ui.js"></script>
  	<script src="js/function.js"></script>
</head>
<body>
	<div class="container">
		<div class="row" style="margin-top: 5%;">
			<div class="row">
				<div class="col s12 subcontainer " style="padding:0px 30px;">
					<ul class="fila ordemFila" id="fila_posto3">
						<?php
							$fila = json_decode(file_get_contents('php/arquivo.json'));
							foreach ($fila->posto1 as $taxi) {
								echo "<li  class='grabbable  ".$taxi->status."'>".$taxi->numero."</li>";
							}
							foreach ($fila->posto2 as $taxi) {
								echo "<li  class='grabbable  ".$taxi->status."'>".$taxi->numero."</li>";
							}
							foreach ($fila->posto3 as $taxi) {
								echo "<li class='grabbable  ".$taxi->status."'>".$taxi->numero."</li>";
							}
							
						?>
					</ul>
				</div>
			</div>
			<div class="row" style="margin-top:5%;">
				<div class="col s5"></div>
				<div class="col s2"><button class="btn">Salva Ordem</button></div>
				<div class="col s5"></div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function() {
		var ordem = [];
	    $( "ul" ).sortable();
	    $( "ul" ).disableSelection();
	    $('.btn').click(function(){
	    	ordem = [];
		    $( "li" ).each(function( index ) {
				ordem.push($( this ).text());

			});
			request = $.ajax({
		        url: "php/ordenarLista.php",
		        type: "post",
		        data: {'ordem': JSON.stringify(ordem)}
			});
			request.done(function (response, textStatus, jqXHR){
				console.log(response);

			});
			request.fail(function (jqXHR, textStatus, errorThrown){
			    console.error(
			        "The following error occurred: "+
			        textStatus, errorThrown
			    );
			});
	    });

	});
	</script>
</body>
</html>