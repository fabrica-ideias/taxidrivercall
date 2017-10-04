function init(){
	var mostraTela = false;
	var id = 0;
	var alteracao = 0;
	var efeitochamada = false;
	var url = "";//"http://taxidrivercall.000webhostapp.com/"

	function checaOrdemDaFila(){
		request = $.ajax({
			url: url+"php/verificarFila.php",
			type: "post"
		});
		request.done(function (response, textStatus, jqXHR){
			result = JSON.parse(response);
			if(id != result.id){
				id = result.id;
				mostraFila(result);
				if(mostraTela == true){
					if(document.getElementById("audio") != null){
						//document.getElementById('audio').play();
						var msg = "";
						var msgMostrada = "";
						for (var i = 0; i < result.chamados.length; i++) {
							msg += "Taxi numero "+result.chamados[i].numero+" - ";
							msgMostrada += "Taxi numero "+result.chamados[i].numero+"</br>";
						}
						var toastContent = $('<span>'+msgMostrada+'</span>');
						// Materialize.toast(toastContent, 10000);
						responsiveVoice.speak(msg,"Brazilian Portuguese Female",{rate: 1.0});
						responsiveVoice.speak(msg,"Brazilian Portuguese Female",{rate: 0.8});
						efeitochamada = true;
					}
				} 
				mostraTela = true;
				console.log(result.plantao+" - "+result.biqueira);
			}
			if(alteracao != result.alteracao){
				alteracao = result.alteracao;
				mostraFila(result);
			}

		});
		request.fail(function (jqXHR, textStatus, errorThrown){
			console.error(
				"The following error occurred: "+
				textStatus, errorThrown
				);
		});
	}
	function exibirTaxiSaida(taxis){
		var msg = " - ";
		if(taxis.length > 0){
			msg  = " ";
			for(var i = 0; i < taxis.length;i++){
				if(i > 0){
					msg += " | ";
				}
				msg += taxis[i].numero;
			}
		}
		if(document.getElementById("saida_posto1") != null){
			document.getElementById("saida_posto1").innerHTML = msg;			
		}
	}

	function mostraFila(taxis){
		var filaPosto1 = [];
		var filaPosto2 = [];
		var filaPosto3 = [];

		exibirTaxiSaida(taxis.chamados);
		for (var i = 0; i < taxis.posto1.length; i++) {
			filaPosto1.push(taxis.posto1[i]);
		}
		preencherFilas(filaPosto1,"saida_posto1","fila_posto1",false,0);
		//opção de fila 1
		if(taxis.opcaofila == 0){
			for (var i = 0; i < taxis.posto2.length; i++) {
				filaPosto2.push(taxis.posto2[i]);
			}
			for (var i = 0; i < taxis.posto3.length; i++) {
				filaPosto3.push(taxis.posto3[i]);
			}
			for (var i = 0; i < taxis.problemas.length; i++) {
				filaPosto3.push(taxis.problemas[i]);
			}
			if(fila_posto2.length < 7){
				preencherFilas(filaPosto2,"saida_posto2","fila_posto2",false,0);
			}else{
				preencherFilas(filaPosto2,"saida_posto2","fila_posto2",false,1);
			}
			preencherFilas(filaPosto3,"","fila_posto3",true,0);
			document.getElementById("filaprincipal").style.display = "block";
			document.getElementById("filapratao").style.display = "none";
			if(document.getElementById("filabiqueira") != null){
				document.getElementById("filabiqueira").style.display = "none";
			}
			document.getElementById("plantao").innerHTML = "";
			document.getElementById("biqueira").innerHTML = "";
		}else{
			//opção de fila 2
			for (var i = 0; i < taxis.posto2.length; i++) {
				filaPosto2.push(taxis.posto2[i]);
			}
			for (var i = 0; i < taxis.posto3.length; i++) {
				if(filaPosto2.length < 15){
					if(taxis.posto3[i].status == "presente"){
						filaPosto2.push(taxis.posto3[i]);
					}else{
						filaPosto3.push(taxis.posto3[i]);
					}
				}else{
					filaPosto3.push(taxis.posto3[i]);	
				}
			}
			for (var i = 0; i < taxis.problemas.length; i++) {
				filaPosto3.push(taxis.problemas[i]);
			}
			if(fila_posto2.length < 7){
				preencherFilas(filaPosto2,"saida_posto2","fila_posto2",false,0);
			}else{
				preencherFilas(filaPosto2,"saida_posto2","fila_posto2",false,1);
			}
			preencherSegundaFila(filaPosto3);
			document.getElementById("filaprincipal").style.display = "none";
			document.getElementById("filapratao").style.display = "block";
			if(document.getElementById("filabiqueira") != null){	
				document.getElementById("filabiqueira").style.display = "block";
			}
		}
	}
	function preencherSegundaFila(taxis){
		var plantao = "";
		var biqueira = "";
		for (var i = 0; i < taxis.length; i++) {
			if(taxis[i] != null){
				if(taxis[i].tipo == "plantao"){
					plantao +="<li class='"+taxis[i].status+" "+taxis[i].tipo+"'><a class='"+taxis[i].status+"_taxi modal-trigger' href='#modal1'>"+taxis[i].numero+"</a></li>";
				}else{
					biqueira += "<li class='"+taxis[i].status+" "+taxis[i].tipo+"'><p class='"+taxis[i].status+"_taxi modal-trigger' href='#modal1'>"+taxis[i].numero+"</p></li>";
				}
				
			}
		}
		document.getElementById("fila_posto3").innerHTML = "";
		document.getElementById("plantao").innerHTML = plantao;
		document.getElementById("biqueira").innerHTML = biqueira;
	}
	function preencherFilas(taxis,saida,lista,restante,tipofila){
		var fila = "";
		for (var i = 0; i < taxis.length; i++) {
			if(taxis[i] != null){
				if(tipofila == 0){
					if(restante == false){
						fila += "<li class='"+taxis[i].status+" "+taxis[i].tipo+"'  style='width: 100px;text-align: center;text-shadow: 2px 2px 5px #000;border-radius: 4px;box-shadow: 5px 5px 5px #b2b0b0;margin-bottom: 20px;' class='"+taxis[i].status+"'>"+taxis[i].numero+"</li>";
						if(i + 1 != taxis.length){
							fila += "<li ><</li>";
						}
					}else{
						fila += "<li class='"+taxis[i].status+" "+taxis[i].tipo+"'>"+taxis[i].numero+"</li>";
					}
				}else{
					fila += "<li id='listafila2' class='"+taxis[i].status+" "+taxis[i].tipo+"'>"+taxis[i].numero+"</li>";
					if(i + 1 != taxis.length){
						fila += "<li id='listafila2' ><</li>";
					}
				}
			}
		}
		if(document.getElementById(lista) != null){
			document.getElementById(lista).innerHTML = fila;
		}
	}
	setInterval(function(){ 
		checaOrdemDaFila();
	},500);

	//  setInterval(function(){ 
	//  	$.ajax({
	//  		url: "php/statusTest.php",
	//  		type: "post",
	//  		success:function(response){
	//  		}
	//  	});
	// },3000);

	if(document.getElementById("btnChamar") != null){
		$('#modalLoad').modal({
		      dismissible: false, // Modal can be dismissed by clicking outside of the modal
		      opacity: .5, // Opacity of modal background
		      inDuration: 300, // Transition in duration
		      outDuration: 200, // Transition out duration
		      startingTop: '4%', // Starting top style attribute
		      endingTop: '10%', // Ending top style attribute
		      ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
		      },
		      complete: function() {

		      } // Callback for Modal close
		  }
		  );
		document.getElementById("btnChamar").addEventListener("click",function(){
			var qtde = parseInt(document.getElementById("qtdeChamada").innerHTML);
			$('#modalChamada').modal('close');
			$('#modalLoad').modal('open');
			if(qtde > 0){
				$.ajax({
					url: "php/chamaTaxi.php",
					type: "post",
					data: {"quantidade":qtde},
					success:function(response){
						$('#modalLoad').modal('close');
					}
				});
			}else{
				document.getElementById("qtdeTaxi").setAttribute("class", "validate invalid");
				document.getElementById("qtdeTaxi").focus();
			}
		});
	}
	
	if(document.getElementById("proximo") != null){
		btnProxmoTaxi = document.getElementById("proximo");
		btnProxmoTaxi.addEventListener("click",function(){
			request = $.ajax({
				url: url+"php/chamaTaxi.php",
				type: "post"
			});
			request.done(function (response, textStatus, jqXHR){
				console.log(response);
				mostraFila(JSON.parse(response));

			});
			request.fail(function (jqXHR, textStatus, errorThrown){
				console.error(
					"The following error occurred: "+
					textStatus, errorThrown
					);
			});
		});
	}
	$('.modal').modal();

}

function initOrdemFila(){
	console.log("iniciar ordenamento de lista");
	$(function() {
		var ordem = [];
		$( "ul.filaordem" ).sortable();
		$( "ul.filaordem" ).disableSelection();
		$('.btnSalvaOrdem').click(function(){
			console.log("salva ordem fila");
			ordem = [];
			$( "li" ).each(function( index ) {
				ordem.push($( this ).text());

			});
			request = $.ajax({
				url: url+"php/ordenarLista.php",
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

}