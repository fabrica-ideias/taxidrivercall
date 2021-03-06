function initLogin(){
	var verificarEmail = false;
	var usuario = null;
	var config = null;
	var validaEmail = false;
	var qtdeChamada = 1;
	function login(){
		if(verificarEmail == false){
			var email = document.getElementById("email").value;
			if(email.indexOf("@") >= 0 && email.indexOf(".com") >= 0 ){
				verificaEmail(email);
			}
		}else{
			verificaSenha(document.getElementById("password").value);
		}
	}

	//Verifica o E-mail 
	function verificaEmail(email){
		if(email.indexOf("@") >= 0 && email.indexOf(".com") >= 0 ){
			request = $.ajax({
				url: "php/consultaEmail.php",
				type: "post",	
				data: "email="+email	
			});	
			request.done(function (response, textStatus, jqXHR){
				document.getElementById("progress").style.display = "block";
				if(response != "0"){
					usuario = JSON.parse(response);
					document.getElementById("checkConect").innerHTML = "<p><input type='checkbox' id='manterConectado' /><label for='manterConectado'>Manter conectado</label></p>";
					document.getElementById("nameLogin").innerHTML = "<label class='namePerson'>"+usuario.nome+"</label>";
					document.getElementById("progress").style.display = "none";
					document.getElementById("fieldEmail").style.display = "none";
					document.getElementById("fieldPassword").style.display = "block";
					document.getElementById("imgUser").style.backgroundImage = "url('uploads/"+usuario.perfil+"')";
					document.getElementById("password").focus();
					verificarEmail = true;
				}else{
					document.getElementById("progress").style.display = "none";
					document.getElementById("lEmail").setAttribute("data-error", "Não foi possível encontrar sua conta");
					document.getElementById("email").setAttribute("class", "validate invalid");
				}
			});
			request.fail(function (jqXHR, textStatus, errorThrown){
				console.error(
					"The following error occurred: "+
					textStatus, errorThrown
					);
			});
		}else{
			document.getElementById("email").focus();
			document.getElementById("lEmail").setAttribute("data-error","E-mail Invalido");
			document.getElementById("email").setAttribute("class", "validate invalid");

		}
	}
	function verificaEmailCadastro(){
		var email = document.getElementById("emailUser").value;
		validaEmailUser(email);
		if(email.indexOf("@") >= 0 && email.indexOf(".com") >= 0 ){
			request = $.ajax({
				url: "php/consultaEmail.php",
				type: "post",
				data: "email="+email
			});
			request.done(function (response, textStatus, jqXHR){
				if(response != "0"){
					document.getElementById("emailUser").focus();
					document.getElementById("lEmailUser").setAttribute("data-error","E-mail já possui cadastro");
					document.getElementById("emailUser").setAttribute("class", "validate invalid");
					validaEmail = false;
				}else{
					validaEmail = true;
					//document.getElementById("senhaUser").focus();
				}
			});
			request.fail(function (jqXHR, textStatus, errorThrown){
				console.error(
					"The following error occurred: "+
					textStatus, errorThrown
					);
			});
		}else{
			document.getElementById("emailUser").focus();
			document.getElementById("lEmailUser").setAttribute("data-error","E-mail Invalido");
			document.getElementById("emailUser").setAttribute("class", "validate invalid");
		}
	}

	//Verifica a Senha 
	function verificaSenha(senha){
		document.getElementById("progress").style.display = "block";
		if(usuario.senha == senha){
			var conexao = document.getElementById("manterConectado").checked;
			document.getElementById("checkConect").innerHTML = "";
			document.getElementById("progress").style.display = "none";
			document.getElementById("password").value = "";
			document.getElementById("containerLogin").style.display = "none";
			startSession(conexao);
		}else{
			document.getElementById("password").value = "";
			document.getElementById("progress").style.display = "none";
			document.getElementById("password").setAttribute("class", "validate invalid");
			document.getElementById("password").focus();
		}
	}
	//checa se  tem error de digitação
	function validaEmailUser(email){
		var dominio = email.split("@");
		var subdominio = dominio[1].split(".");
		var error_subdominio = [];
		error_subdominio.push(["","mail","gmeil","gmal","gml","gmil","hotmeil","hot","yaho","yaoo","yao"],["con","cn","cm","co"],["b","or","og","rg"]);
		var result = 4;
		for(var i = 0; i < subdominio.length; i++){
			if(!error_subdominio[i].indexOf(subdominio[i])){
				result = i;
				break;
			}
		}
		switch(result){
			case 0: 
			document.getElementById("emailUser").focus();
			document.getElementById("lEmailUser").setAttribute("data-error","Possivel erro de digitação: hotmail,yahoo,gmail");
			document.getElementById("emailUser").setAttribute("class", "validate invalid");
			break;
			case 1:
			document.getElementById("emailUser").focus();
			document.getElementById("lEmailUser").setAttribute("data-error","Possivel erro de digitação: com");
			document.getElementById("emailUser").setAttribute("class", "validate invalid");
			break;
			case 2:
			document.getElementById("emailUser").focus();
			document.getElementById("lEmailUser").setAttribute("data-error","Possivel erro de digitação: br,org");
			document.getElementById("emailUser").setAttribute("class", "validate invalid");
			break;
		}

	}

	//inicia a sessao
	function startSession(conectado){
		request = $.ajax({
			url: "php/startSession.php",
			type: "get",
			data: "idusuario="+usuario.idusuario+"&conexao="+conectado
		});
		request.done(function (response, textStatus, jqXHR){
			//checa se o usuario esta logado
			verificaLogin();
			console.log("Sessao Iniciada");
		});
		request.fail(function (jqXHR, textStatus, errorThrown){
			console.error(
				"The following error occurred: "+
				textStatus, errorThrown
				);
		});
	}
	//verifica se esta logado
	function verificaLogin(){
		request = $.ajax({
			url: "php/checkSession.php",
			type: "post"
		});
		request.done(function(response, textStatus, jqXHR){
			usuario = JSON.parse(response);
			if(usuario !=  "0"){
				document.getElementById("containerLogin").style.display = "none";
				incluirPainel();
				document.title = "Taxi Driver";
			}else{
				document.title = "Login";
				document.getElementById("checkConect").innerHTML = "";
				document.getElementById("nameLogin").innerHTML = "<h4> Login</h4>";
				document.getElementById("progress").style.display = "none";
				document.getElementById("fieldEmail").style.display = "block";
				document.getElementById("fieldPassword").style.display = "none";
				document.getElementById("fLogin").style.display = "block";
				document.getElementById("fCadastro").style.display = "none";
				document.getElementById("containerLogin").style.display = "block";
				verificarEmail = false;
				document.getElementById("email").addEventListener("keypress", function(){
					if(event.keyCode == 13) login();
				});
				document.getElementById("password").addEventListener("keypress", function(){
					if(event.keyCode == 13) login();
				});
				document.getElementById("logar").addEventListener("click",function(){
					login();
				});	
				document.getElementById("cadastro").addEventListener("click",function(){
					cadastro();
				});
				document.getElementById("nome").addEventListener("keydown",function(){
					EnterTab('sobrenome',event);
				});
				document.getElementById("sobrenome").addEventListener("keydown",function(){
					EnterTab('emailUser',event)
				});
				document.getElementById("emailUser").addEventListener("keydown",function(){
					if(event.keyCode == 13) verificaEmailCadastro();
				});
				document.getElementById("salvaUsuario").addEventListener("click",function(){
					salvaUsuario();
				});
				document.getElementById("file").addEventListener("change",function(){
					var img;
					var  input = document.getElementById("file");
					if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = function (e) {
							img = new FormData(input);
							document.getElementById("imgNewUser").style.backgroundImage = "url('"+e.target.result+"')";
							document.getElementById("nome").focus();
						}
						reader.readAsDataURL(input.files[0]);
					} 
				});
			}
			console.log("Sessao Verificada");
		});
		request.fail(function (jqXHR, textStatus, errorThrown){
			console.error(
				"The following error occurred: "+
				textStatus, errorThrown
				);
		});
	}
	//logout
	function logout(){
		request = $.ajax({
			url: "php/logout.php",
			type: "post"
		});
		request.done(function (response, textStatus, jqXHR){
			desativar();
			verificaLogin();
			console.log("Verificando Login");
		});	
	}
	//Chama a tela de cadastro
	function cadastro(){
		document.getElementById("nameLogin").innerHTML = "<h4>Cadastro</h4>";
		document.getElementById("fLogin").style.display = "none";
		document.getElementById("fCadastro").style.display = "block";
		document.getElementById("nome").focus();
	}

	function EnterTab(InputId,Evento){
		if(Evento.keyCode == 13){		
			document.getElementById(InputId).focus();
		}
	}
	
	//Salva o usuario
	function salvaUsuario(){
		var x = document.getElementById("file");
		var file_data =x.files[0];
		var form_data = new FormData();
		form_data.append('file', file_data);
		form_data.append('nome',  $('#nome').val()+" "+$('#sobrenome').val());
		form_data.append('email', $('#emailUser').val());
		form_data.append('senha', $('#senhaUser').val());
		request = $.ajax({
			type:"POST",
			url:"php/salvaUsuario.php",
						type: "POST",             // Type of request to be send, called as method
						data: form_data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						contentType: false,       // The content type used when sending data to the server.
						cache: false,             // To unable request pages to be cached
						processData:false,        // To send DOMDocument or non processed data file it is set to false
						success: function(data) {
							console.log(data);
							usuario= JSON.parse(data);
							document.getElementById("containerLogin").style.display = "none";
							incluirPainel();
						}
					});
	}

	function incluirPainel(){
		document.getElementById("container").style.display = "block";
		$(document).ready(function(){
			$('.collapsible').collapsible();
			$('.modal').modal();
			$(".button-collapse").sideNav();
			//init();
			$('ul.tabs').tabs('select_tab', 'home');
		});
		initConfiguracao();
		
	}
	verificaLogin();

	//Ativa as Configuração de Layout e Eventos
	function initConfiguracao(){
		request = $.ajax({
			url: "php/configuracao.php",
			type: "POST"
		});
		request.done(function (response, textStatus, jqXHR){
			//pega a configuração e colocar e jogar na tela
			config = JSON.parse(response);
			document.getElementById("menu_painel").style.background = config.cor_menu;
			document.getElementById("conteudo_painel").style.background = config.cor_conteudo;
			document.getElementById("container").style.background = config.cor_fundo;
			document.getElementsByTagName("body")[0].style.background = config.cor_fundo;
			document.getElementById("logo").src = "assets/icon/"+config.logo;
			document.getElementById("btnConfiguracao").addEventListener("click",function(){
				abrirConfiguracao();
			});
			document.getElementById("logout").addEventListener("click",function(){
				logout();
			});
			//abri as configuração de cores da tela
			document.getElementById("btnConfiguracaoMobile").addEventListener("click",function(){
				$('.button-collapse').sideNav('hide');
				abrirConfiguracao();
			});
		 	//Faz logout 
		 	document.getElementById("logoutMobile").addEventListener("click",function(){
		 		$('.button-collapse').sideNav('hide');
		 		logout();
		 	});

		 	//salva configuração de fila

		 	if(document.getElementById("salvaConfiguracaoFila") != null){
		 		document.getElementById("salvaConfiguracaoFila").addEventListener("click",function(){
		 			var opcao = 0;
		 			if(document.getElementById("fila1").checked == true){
		 				opcao = 0;
		 			}else{
		 				opcao = 1;
		 			}
		 			var qtdefila1 = document.getElementById("qtdeFila1").value;
		 			var qtdefila2 = document.getElementById("qtdeFila2").value;
		 			var qtdeMaxima = document.getElementById("qtdemaxima").value;
		 			$.ajax({
		 				type:"POST",
		 				url:"php/configuracaoFila.php",
		 				type: "POST",             
		 				data: {"tipofila":opcao,"qtdeFila1":qtdefila1,"qtdeFila2":qtdefila2,"qtdeMaxima":qtdeMaxima}, 
		 				success: function(data) {
		 					alert("Tipo de fila Alterada");
		 					console.log(data);
		 				}
		 			});
		 		});
		 	}
		 	// Habilita o painel
		 	if(document.getElementById("painelConfigFila") != null){
		 		document.getElementById("painelConfigFila").addEventListener("click",function(){
		 			document.getElementById("configFila").style.display = "block";
		 			document.getElementById("horarioFila").style.display = "none";
		 			document.getElementById("configPosicao").style.display = "none";
		 		});
		 	}
		 	if(document.getElementById("painelHorarioFila") != null){ 
		 		document.getElementById("painelHorarioFila").addEventListener("click",function(){
		 			document.getElementById("horarioFila").style.display = "block";
		 			document.getElementById("configFila").style.display = "none";
		 			document.getElementById("configPosicao").style.display = "none";
		 		});
		 	}
		 	if(document.getElementById("painelConfigPosicao") != null){ 
		 		document.getElementById("painelConfigPosicao").addEventListener("click",function(){
		 			document.getElementById("horarioFila").style.display = "none";
		 			document.getElementById("configFila").style.display = "none";
		 			document.getElementById("configPosicao").style.display = "block";
		 		});
		 	}
		 	if(document.getElementById("salvaHorario") != null){ 
			 	//salva o horario
			 	document.getElementById("salvaHorario").addEventListener("click",function(){
			 		var opcao = 0;
			 		if(document.getElementById("tipofila1").checked == true){
			 			opcao = 0;
			 		}else{
			 			opcao = 1;
			 		}
			 		var tempoInicial = document.getElementById("tempoInicial").value;
			 		var tempoFinal = document.getElementById("tempoFinal").value;

			 		console.log(opcao+" "+tempoInicial+" - "+tempoFinal);
			 		$.ajax({
			 			type:"POST",
			 			url:"php/salvaControle.php",
			 			type: "POST",             
			 			data: {"opcao":opcao,"tempoInicial":tempoInicial,"tempoFinal":tempoFinal}, 
			 			success: function(data) {
			 				var lista = JSON.parse(data);
			 				mostraHorariosFila(lista);
			 			}
			 		});
			 	});
			 }
			 document.getElementById("qtdeChamada").innerHTML = qtdeChamada;
			 document.getElementById("addChamado").addEventListener("click",function(){
			 	qtdeChamada++;
			 	document.getElementById("qtdeChamada").innerHTML = qtdeChamada;
			 });
			 document.getElementById("removeChamado").addEventListener("click",function(){
			 	if(qtdeChamada != 1){
			 		qtdeChamada--;
			 		document.getElementById("qtdeChamada").innerHTML = qtdeChamada;
			 	}
			 });
			 $("#modalConfiguracao").modal();
			 document.getElementById("closeConfiguracaoModal").addEventListener("click",function(){
			 	$("#modalConfiguracao").modal('close');
			 });
		 	// controleFila();
		 	// consultaConfiguracaoFila();
		 	if(document.getElementById("posicao_posto1")){
		 		Sortable.create(document.getElementById("posicao_posto1"), {animation: 150, group: "omega",dragClass: "sortable-drag",});
		 		Sortable.create(document.getElementById("posicao_posto2"), {animation: 150, group: "omega",dragClass: "sortable-drag",});
		 		Sortable.create(document.getElementById("posicao_posto3"), {animation: 150, group: "omega",dragClass: "sortable-drag", });
		 	}
		 	init();
		 });

}

function abrirConfiguracao(){
	document.getElementById("configuracao").style.display = "block";
	document.getElementById("cor_menu").value = config.cor_menu;
	document.getElementById("cor_fundo").value = config.cor_fundo;
	document.getElementById("cor_conteudo").value = config.cor_conteudo;
	document.getElementById("cor_menu").addEventListener("change",function(){
		document.getElementById("menu_painel").style.background = document.getElementById("cor_menu").value;
	});
	document.getElementById("cor_conteudo").addEventListener("change",function(){
		document.getElementById("conteudo_painel").style.background = document.getElementById("cor_conteudo").value;
	});
	document.getElementById("cor_fundo").addEventListener("change",function(){
		document.getElementById("container").style.background = document.getElementById("cor_fundo").value;
		document.getElementsByTagName("body")[0].style.background = document.getElementById("cor_fundo").value;
	});
	document.getElementById("btnSalvaConfig").addEventListener("click",function(){
		var file_data = document.getElementById("fileLogo").files[0];
		var form_data = new FormData();
		form_data.append('file', file_data);
		form_data.append('cor_fundo',  document.getElementById("cor_fundo").value);
		form_data.append('cor_conteudo', document.getElementById("cor_conteudo").value);
		form_data.append('cor_menu', document.getElementById("cor_menu").value);
		request = $.ajax({
			type:"POST",
			url:"php/salvaConfiguracao.php",
								type: "POST",             // Type of request to be send, called as method
								data: form_data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
								contentType: false,       // The content type used when sending data to the server.
								cache: false,             // To unable request pages to be cached
								processData:false,        // To send DOMDocument or non processed data file it is set to false
								success: function(data) {
									document.getElementById("configuracao").style.display = "none";
								}
							});
	});
	document.getElementById("cancelar").addEventListener("click",function(){
		document.getElementById("configuracao").style.display = "none";
	});
	document.getElementById("fileLogo").addEventListener("change",function(){
		var img;
		var  input = document.getElementById("fileLogo");
		console.log("teste");
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				img = new FormData(input);
				document.getElementById("logo").src = ""+e.target.result;
				document.getElementById("nome").focus();
			}
			reader.readAsDataURL(input.files[0]);
		} 
	});
}
function desativar(){
	if(document.getElementById("configuracao") != null){
		document.getElementById("configuracao").style.display = "none";
	}
	if(document.getElementById("container") != null){
		document.getElementById("container").style.display = "none";
	}
}
function controleFila(){
	$.ajax({
		type:"POST",
		url:"php/listaControle.php",
		type: "POST",              
		success: function(data) {
			var lista = JSON.parse(data);
			mostraHorariosFila(lista);
		}
	});
}
function mostraHorariosFila(lista){
	var controles = "";
	for(var i = 0 ; i < lista.length; i++){
		controles += '<tr>';
		if(lista[i].tipofila == 0){
			controles += '<td>Fila Principal</td>';
		}else{
			controles += '<td>Fila Alternativa</td>';
		}
		controles += '<td>'+lista[i].tempoInicial+'</td>';
		controles += '<td>'+lista[i].tempoFinal+'</td>';
		controles += '<td><a class="removeHorario" id="'+lista[i].idcontrole+'" href="#">X</a></td>';
		controles += '</tr>';
	}
	document.getElementById("listaControle").innerHTML = controles;
	$(".removeHorario").click(function(){
		removeHorario(this.id);
	});
}

function consultaConfiguracaoFila(){
	$.ajax({
		type:"POST",
		url:"php/getConfiguracaoFila.php",
		type: "POST",        
		success: function(data) {
			var config = JSON.parse(data);
			if(config.tipo_fila == 0){
				document.getElementById("fila1").checked = true;
			}else{
				document.getElementById("fila2").checked = true;
			}
			document.getElementById("qtdeFila1").value = config.qtde_taxi_fila1;
			document.getElementById("qtdeFila2").value = config.qtde_taxi_fila2;
			document.getElementById("qtdemaxima").value = config.qtdemaxima;
		}
	});
}

function removeHorario(id){
	$.ajax({
		type:"POST",
		url:"php/removeHorario.php",
		type: "POST", 
		data:{"id":id},             
		success: function(data) {
			var lista = JSON.parse(data);
			mostraHorariosFila(lista);
		}
	})
}
}