// ****************************__ CLIENTES __*********************************//
// t -> tipo de user: Ativo, Inativo ou todos.
window.fnCC.pesquisaClientes = function(t) {
	var carrega_url = "actions";
	carrega_url = "system/clientes/" + carrega_url + ".php";

	// Todas as requisições para actions, deverá ser passada uma flag
	// @flag -> 4
	var flag = 4;

	dados = {flag: flag, t: t};
	  
	//  A função Ajax jah dah o retorno da requisição através da variavel data
	$.ajax({

	    url: carrega_url,
	    type: "POST",
	    data: dados,

	    success: function (data) {
		  NProgress.start();
	      $(".x_panel").html(data);
	    },

	    beforeSend: function () {
	    },

	    complete: function () {
          fn.viewNotificacoes();

	      $(function () {
	        $('[data-toggle="tooltip"]').tooltip()
	      })
	      setTimeout(function() {init_DataTables()}, 50);
	      NProgress.done();

	    }
	});


	return true;
}

window.fnCC.gravarCliente = function() {
	// Dados da tabela Cliente
	var nome = document.getElementById('CL_NOME').value;
	var email = document.getElementById('CL_EMAIL').value;
	var telefone = document.getElementById('CL_TELEFONE').value;

	// Dados da tabela Plano
	var observacoes = document.getElementById('PL_OBSERVACOES').value;
	var inicioVigencia = document.getElementById('PL_INICIO_VIGENCIA').value;
	var fimVigencia = document.getElementById('PL_FIM_VIGENCIA').value;

	var v = true;

	// aqui somente verifica os campos se estão vazios para executar a ação do cadastro
	if (nome == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o nome'};
		v = false;
	} else if (email == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o email'};
		v = false;
	} else if (telefone == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o n° do telefone'};
		v = false;
	} else if (inicioVigencia == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Insira o início da vigência'};
		v = false;
	} else if (fimVigencia == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Insira o fim da vigência'};
		v = false;
	} 

	if (telefone.indexOf('_') != -1) {
		var d = {tipo: 'notice', titulo: 'Campo inválido', mensagem: 'Digite corretamente o n° do telefone'};
		v = false;
	}

	// Aqui verifica se o fim da vigencia é maior que o início 
	if (fnCC.comparaDatas(inicioVigencia, fimVigencia) == false) {
		var d = {tipo: 'notice', titulo: 'Campo inválido', mensagem: 'Data de início deve ser menor que a do fim da vigência'};
		v = false;
	}

	// Aqui verifica se tem algo salvo na variável d para jogar no toast - que siginifica que ela caiu em alguma das opções acima.
	if (v == false) {
		fn.toast(d);
		return false;
	} else {
		// Dbug
		var carrega_url = "actions";
		carrega_url = "system/clientes/" + carrega_url + ".php";

		// Todas as requisições para actions, deverá ser passada uma flag
		// @flag -> 1
		var flag = 1;

		// Aqui passa codigo como String "SERIAL" Para ajuste na requisição responsável
		codigo = "SERIAL";
		
		dados = {flag: flag, CL_CODIGO: codigo, CL_NOME: nome, CL_EMAIL: email, CL_TELEFONE: telefone, PL_OBSERVACOES: observacoes, PL_INICIO_VIGENCIA: inicioVigencia, PL_FIM_VIGENCIA: fimVigencia};
		console.log(dados);		  
		//  A função Ajax jah dah o retorno da requisição através da variavel data
		$.ajax({

		    url: carrega_url,
		    type: "POST",
		    data: dados,

		    success: function (data) {
			  NProgress.start();
		      $("#conteudo-page").html(data);
		    },

		    beforeSend: function () {
		    },

		    complete: function () {
		      NProgress.done();

		    }
		});


		return true;
	}
}

// Comparação da vigência
window.fnCC.comparaDatas = function(datainicial, datafinal) {
	// Dbug
	// alert(fnCC.gerarData(datainicial) < fnCC.gerarData(datafinal));
	return fnCC.gerarData(datainicial) < fnCC.gerarData(datafinal);
}

window.fnCC.gerarData = function(str) {
    var partes = str.split("/");
    return new Date(partes[2], partes[1] - 1, partes[0]);
}	

window.fnCC.atualizarCliente = function(id) {
	// Dados da tabela Cliente
	var codigo = document.getElementById('CL_CODIGO').value;
	var nome = document.getElementById('CL_NOME').value;
	var email = document.getElementById('CL_EMAIL').value;
	var telefone = document.getElementById('CL_TELEFONE').value;

	// Dados da tabela Plano
	var observacoes = document.getElementById('PL_OBSERVACOES').value;
	var inicioVigencia = document.getElementById('PL_INICIO_VIGENCIA').value;
	var fimVigencia = document.getElementById('PL_FIM_VIGENCIA').value;

	var v = true;

	// aqui somente verifica os campos se estão vazios para executar a ação do cadastro
	if (nome == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o nome'};
		v = false;
	} else if (email == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o email'};
		v = false;
	} else if (telefone == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o n° do telefone'};
		v = false;
	} else if (inicioVigencia == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Insira o início da vigência'};
		v = false;
	} else if (fimVigencia == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Insira o fim da vigência'};
		v = false;
	} 

	if (telefone.indexOf('_') != -1) {
		var d = {tipo: 'notice', titulo: 'Campo inválido', mensagem: 'Digite corretamente o n° do telefone'};
		v = false;
	}

	// Aqui verifica se o fim da vigencia é maior que o início 
	if (fnCC.comparaDatas(inicioVigencia, fimVigencia) == false) {
		var d = {tipo: 'notice', titulo: 'Campo inválido', mensagem: 'Data de início deve ser menor que a do fim da vigência'};
		v = false;
	}

	// Aqui veridica se tem algo salvo na variável d para jogar no toast - que siginifica que ela caiu em alguma das opções acima.
	if (v == false) {
		fn.toast(d);
		return false;
	} else {
		
		var carrega_url = "actions";
		carrega_url = "system/clientes/" + carrega_url + ".php";

		// Todas as requisições para actions, deverá ser passada uma flag
		// @flag -> 2 -> Atualização do cliente
		var flag = 2;
		
		dados = {flag: flag, ID: id, CL_CODIGO: codigo, CL_NOME: nome, CL_EMAIL: email, CL_TELEFONE: telefone, PL_OBSERVACOES: observacoes, PL_INICIO_VIGENCIA: inicioVigencia, PL_FIM_VIGENCIA: fimVigencia};

		//  A função Ajax jah dah o retorno da requisição através da variavel data
		$.ajax({

		    url: carrega_url,
		    type: "POST",
		    data: dados,

		    success: function (data) {
			  NProgress.start();
		      $("#conteudo-page").html(data);
		    },

		    beforeSend: function () {
		    },

		    complete: function () {
              fn.viewNotificacoes();

		      NProgress.done();

		    }
		});


		return true;
	}

}

window.fnCC.viewEditaCliente = function (codigo) {
	// Passando o código de identificação do Cliente
	var dado = {CL_CODIGO: codigo};

	var carrega_url = "cadastro";
	carrega_url = "system/clientes/" + carrega_url + ".php";
	  
	//  A função Ajax jah dah o retorno da requisição através da variavel data
	$.ajax({

	    url: carrega_url,
	    type: "POST",
	    data: dado,

	    success: function (data) {
		  NProgress.start();
	      $("#conteudo-page").html(data);
	    },

	    beforeSend: function () {

	    },

	    complete: function () {
	      // A chamada desse scripts são para processar os novos dados adicionados ao DOM
	      // Necessariamente tem que ser chamados
	      NProgress.done();
	      init_validator();
	      init_InputMask();

		  if ($("input.flat")[0]) {
		      $(document).ready(function () {
		          $('input.flat').iCheck({
		              checkboxClass: 'icheckbox_flat-green',
		              radioClass: 'iradio_flat-green'
		          });

		          $("input[id*='CL_CNPJ']").inputmask({
	                  mask: ['999.999.999-99', '99.999.999/9999-99'],
	                  keepStatic: true
	              });
		      });
		  }

		  $('#PL_INICIO_VIGENCIA').daterangepicker({
	        singleDatePicker: true,
	        singleClasses: "picker_3",
	        locale: {
	          format: 'DD/MM/YYYY'
	        }
	      }, function(start, end, label) {
	        console.log(start.toISOString(), end.toISOString(), label);
	      });

	      $('#PL_FIM_VIGENCIA').daterangepicker({
	        singleDatePicker: true,
	        singleClasses: "picker_4",
	        locale: {
	          format: 'DD/MM/YYYY'
	        }
	      });

	    }
	});
}

// Aqui abre a caixa de email para envio das mensagens aos Clientes
window.fnCC.viewModalEnviaEmail = function(email) {
	fnCC.openModalCaixaEmail(email);
}

window.fnCC.openModalCaixaEmail = function(email) {
	// Get the modal
	var modal = document.getElementById('modalCaixaEmail');
	modal.style.display = "block";
	// Aqui verifica se é mobile ou se a tela do dispositivo é pequena, para ajustar o modal a tela 
	if (fnHM.mobilecheck() || fnHM.mobilecheckWidth()) {
		$(".modalCaixaEmail-content").css("width", '100%')
	} 

	document.getElementById('destinatario-caixa-email').value = email;
	fnHM.addEmailTable();
} 

// Essa função desempenha o papel de pegar os dados e passar para a API do envio dos emails
window.fnCC.enviaEmail = function(){
    if (fnCC.isEmptyTable('table-destinatarios')) {
		var d = {tipo: 'notice', titulo: 'Seleção inválida', mensagem: 'Selecione pelo menos um Destinatário!'};
		fn.toast(d); return false;
    }

    var arrayDestinatarios = arrayEmails;
    var assunto = document.getElementById('assunto-caixa-email').value;
    var mensagem = document.getElementById('mensagem-caixa-email').value;

    var carrega_url = "envemail";
    carrega_url = "financeiro/" + carrega_url + ".php";

    var flag = 1;

    var dados = {'arrayDestinatarios': arrayDestinatarios, 'assunto': assunto, 'mensagem': mensagem, flag: flag};

    console.log(dados);

    var count = Object.keys(dados).length;
    var url   = "";

    for (var key in dados) {
       url += key +'='+dados[key]; 
       url += (Object.keys(dados).indexOf(key) < count-1)? '&': '';
    }

    // Aqui gera a interface da tabela de baixas e salva o pdf e envia o email 
    window.location = 'system/clientes/envemail.php?'+url;

}

window.fnCC.contTrsTable = function(table) {
    return $("#"+table+" tr").length - 1;

}

window.fnCC.isEmptyTable = function(table) {
    if (fnCC.contTrsTable(table) == 0) {
        return true;
    }

    return false;
}

// Aqui abre um modal com uma lista de clientes para seleção dos mesmos para envio dos lembretes
window.fnCC.listClientes = function() {
	// Aqui da um loading de UX na interface
	NProgress.start();
	// Aqui ajusta a interface para o estilo de listagem para envio de email  
	fnCC.ajusteInterfaceDialogListSendEmail();

	// Aqui chama a função do carregamento
	setTimeout(function(){ fnCC.listClientesfull(); }, 50);	

	// Aqui para um loading de UX na interface
	NProgress.done();
	
}

// Aqui abre um modal com dados do cliente e possíveis alterações
window.fnCC.viewCliente = function(codigo, nome) {
	// Aqui da um loading de UX na interface
	NProgress.start();
	
	// Aqui chama a função do carregamento
	setTimeout(function(){ fnCC.viewClienteFull(codigo, nome); }, 50);	

	// Aqui para um loading de UX na interface
	NProgress.done();
	
}

window.fnCC.viewClienteFull = function(codigo, nome) {
	$("#titulo-dialog").html('<b>'+nome+'</b>');

	var carrega_url = "actions";
	carrega_url = "system/clientes/" + carrega_url + ".php";
    // Passando o código de identificação do Cliente
    //  Flag == 5 -> Gera uma interface com alguns dados e alguma possíveis alterações
	var flag = 5;

	var dados = {flag: flag, CL_CODIGO: codigo};

	//  A função Ajax jah dah o retorno da requisição através da variavel data
	$.ajax({

	    url: carrega_url,
	    type: "POST",
	    data: dados,

	    success: function (data) {
		  if (fn.mobilecheck()) {
		  	  console.log("Dialog Mobile");
		  	  $(".modal-dialog").css('margin-left', '0%');
		  	  $(".modal-dialog").css('margin-right', '0%');
		      $(".modal-dialog").css("width", "98%");
		  } else {
		  	  console.log("Dialog Desktop");
			  $(".modal-dialog").css('margin-left', '20%');
		      $(".modal-dialog").css("width", "70%");
		  }
	      $("#conteudo-dialog").html(data);
		  NProgress.start();
	    },

	    beforeSend: function () {
	    },

	    complete: function () {
		  $("#titulo-footer").html('');
 	      NProgress.done();

	    }
	});	
}

// so a chamada da função para carregamento do DOM do Dialog
window.fnCC.viewModalExcluiCliente = function(codigo, nome) {
	// Aqui da um loading de UX na interface
	NProgress.start();
	// Aqui chama a função do carregamento
	setTimeout(function(){ fnCC.viewModalExcluiClienteFull(codigo, nome); }, 50);	
	// Aqui para um loading de UX na interface
	NProgress.done();
	
}

// Padronização na criação do Dialog SMALL
// @título do Dialog -> id = #titulo-dialog
// @conteúdo do Dialog -> id = #conteudo-dialog
// @Footer do Dialog -> id = #footer-dialog - Aqui vai os botões de ação do mesmo
// Aqui adiciona o conteúdo ao dialog para fazer a restrição de usuário
window.fnCC.listClientesfull = function() {
	$("#titulo-dialog").html('Lista de Clientes');

	var carrega_url = "lista";
	carrega_url = "system/clientes/" + carrega_url + ".php";
    // Passando o código de identificação do Cliente
    //  Flag == 1 -> Seleção de clientes cadatrados, para envio de lembretes por email
	var flag = 1;

	var dados = {flag: flag};

	//  A função Ajax jah dah o retorno da requisição através da variavel data
	$.ajax({

	    url: carrega_url,
	    type: "POST",
	    data: dados,

	    success: function (data) {
	      $("#conteudo-dialog").html(data);
		  NProgress.start();
	    },

	    beforeSend: function () {
	    },

	    complete: function () {
		  $("#titulo-footer").html('');

 	      $('input.flat').iCheck({
	            checkboxClass: 'icheckbox_flat-green',
	            radioClass: 'iradio_flat-green'
	        });
 	     
 	      NProgress.done();

	    }
	});	
}

window.fnCC.alteraStatusCliente = function(codigo, status) {
	var carrega_url = "actions";
	carrega_url = "system/clientes/" + carrega_url + ".php";
    // Passando o código de identificação do Cliente
    //  Flag == 6 -> Seleção de STATUS
	var flag = 6;

	var dados = {flag: flag, CL_CODIGO: codigo, CL_ATIVO: status};

	//  A função Ajax jah dah o retorno da requisição através da variavel data
	$.ajax({

	    url: carrega_url,
	    type: "POST",
	    data: dados,

	    success: function (data) {
	      $("#conteudo-page").html(data);
	 	  NProgress.start();
	    },

	    beforeSend: function () {
	    },

	    complete: function () {
          fn.viewNotificacoes();
 	      fn.viewLtCliente();
 	      NProgress.done();

	    }
	});	
}

// Aqui seleciona e adiciona
window.fnCC.selecionaClienteEmailSend = function(email, idCheck) {
    if($('#'+idCheck).is(':checked')){
    	fnHM.removeEmailTable(email);
    } else {
    	document.getElementById('destinatario-caixa-email').value = email;
		fnHM.addEmailTable();
    }

	return true;
}

// Aqui Seleciona e adiciona todos os emails ou cancelas todas de uma vez

	/**
* Js Função JavaScript que faz check e uncheck de todos os campos checkbox da página.
*/
window.fnCC.checkedOrUnCheckedAll = function(field) {
	alert(field);             
    if (field.checked) {//se o checkbox estiver checkado eh true
        //"input[type=checkbox]" eh o seletor do jquery, diz pro jquery procurar campos de input aonde o type eh checkbox
        $("input[type=checkbox]").attr('checked', true);//marca all check
    }else {
        $("input[type=checkbox]").attr('checked', false);//desmarca all check
    }
}

window.fnCC.ajusteInterfaceDialogListSendEmail = function () {
	$(".modal-dialog").css('margin-left', '0%');
	$(".modal-dialog").css('float', 'left');
	$(".modal-dialog").css('width', '40%');
	// $(".fade").css("background-color", "rgba(0,0,0,.0001) !important");
	// $(".in").css("background-color", "rgba(0,0,0,.0001) !important");
}

window.fnCC.ajusteInterfaceDialogSmallPadrao = function () {
	if (fn.mobilecheck()) {
  	  console.log("Dialog Mobile");
  	  $(".modal-dialog").css('margin-left', '0%');
  	  $(".modal-dialog").css('margin-right', '0%');
      $(".modal-dialog").css("width", "98%");
  	} else {
		$(".modal-dialog").css('float', 'center');
		$(".modal-dialog").css('margin-left', '35%');
		$(".modal-dialog").css('width', '35%');
	}
}	

window.fnCC.viewModalExcluiClienteFull = function(codigo, nome) {
	fnCC.ajusteInterfaceDialogSmallPadrao();
	$("#titulo-dialog").html('Cliente');
	$("#conteudo-dialog").html('Tem certeza que deseja excluir <b>'+nome+'</b>?');
	var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>'+
                 '<button onclick="fnCC.excluirCliente('+codigo+')" type="button" class="btn btn-primary" data-dismiss="modal">Sim</button>' 
	$("#footer-dialog").html(footer);
}

// #############################__ Actions Modals __ ################################ //
window.fnCC.excluirCliente = function(codigo) {
	var carrega_url = "actions";
	carrega_url = "system/clientes/" + carrega_url + ".php";
    // Passando o código de identificação do Cliente
	var flag = 3;

	var dados = {flag: flag, CL_CODIGO: codigo};

	//  A função Ajax jah dah o retorno da requisição através da variavel data
	$.ajax({

	    url: carrega_url,
	    type: "POST",
	    data: dados,

	    success: function (data) {
		  NProgress.start();
	      $("#conteudo-page").html(data);
	    },

	    beforeSend: function () {
	    },

	    complete: function () {
          fn.viewNotificacoes();
	      NProgress.done();

	    }
	});	

}

// ****************************__ END CLIENTES __*********************************//


