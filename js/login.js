function initLogin(){
	var verificarEmail = false;
	var usuario = null;
	var validaEmail = false;
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
	//checa se  tem erro de digitação
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
			incluirPainel();
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
			}else{
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
			verificaLogin();
			
			document.getElementById("conteudo").style.display = "none";
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
		if(validaEmail == true){
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
		}else{
			document.getElementById("emailUser").focus();
			document.getElementById("emailUser").setAttribute("class", "validate invalid");
		}

	}

	function incluirPainel(){
		document.getElementById("conteudo").style.display = "block";
		//document.getElementById("nomeUser").innerHTML = usuario.nome;
		//document.getElementById("mUser").style.backgroundImage = "url('uploads/"+usuario.perfil+"')";
		document.getElementById("logout").addEventListener("click",function(){
			logout();
		});


		$(document).ready(function(){
		  $('.dropdown-button').dropdown({
			      inDuration: 300,
			      outDuration: 225,
			      constrainWidth: false, // Does not change width of dropdown to that of the activator
			      hover: false, // Activate on hover
			      gutter: 0, // Spacing from edge
			      belowOrigin: false, // Displays dropdown below the button
			      alignment: 'left', // Displays dropdown with edge aligned to the left of button
			      stopPropagation: false // Stops event propagation
	    		}
	  		);
		   $('.collapsible').collapsible();
		   $('.modal').modal();
  			init();
		});
		
	}
	verificaLogin();
}