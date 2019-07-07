// ****************************__ FUNCIONARIOS __*********************************//

window.fnFN.gravarFuncionario = function() {
	// Dados da tabela Cliente
	var FU_NOME = $('#FU_NOME').val();
	var FU_EMAIL = $('#FU_EMAIL').val();
	var FU_SENHA = $('#FU_SENHA').val();
	var FU_TIPO = $('#FU_TIPO').val();
	
	v = true;

	// aqui somente verifica os campos se estão vazios para executar a ação do cadastro
	if (FU_NOME == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o nome'};
		v = false;
	} else if (FU_EMAIL == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o email'};
		v = false;
	} else if (FU_SENHA == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite a senha'};
		v = false;
	} if (FU_TIPO == -1) {
		var d = {tipo: 'notice', titulo: 'Campo inválido', mensagem: 'Selecione uma opção'};
		v = false;
	}

	// Aqui verifica se tem algo salvo na variável d para jogar no toast - que siginifica que ela caiu em alguma das opções acima.
	if (v == false) {
		fn.toast(d);
		return false;
	} else {
		// Dbug
		var carrega_url = "actions";
		carrega_url = "system/funcionarios/" + carrega_url + ".php";

		// Todas as requisições para actions, deverá ser passada uma flag
		// @flag -> 1
		var flag = 1;

		dados = {flag: flag, "FU_NOME": FU_NOME, "FU_EMAIL": FU_EMAIL, "FU_SENHA": FU_SENHA, "FU_TIPO": FU_TIPO};
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

window.fnFN.viewEditaFuncionario = function () {
	// Aqui pega o valor selecionado dos registros da tabela dos funcionários
	var FU_CODIGO_ID = fn.getValueRadio('funcionarios');
	if (FU_CODIGO_ID === undefined) {
		var d = {tipo: 'notice', titulo: 'Seleção', mensagem: 'Selecione um registro!'};
		fn.toast(d);
		return false;
	}

	// Passando o código de identificação do funcionário
	var dado = {FU_CODIGO_ID: FU_CODIGO_ID};

	var carrega_url = "cadastro";
	carrega_url = "system/funcionarios/" + carrega_url + ".php";
	  
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
	      NProgress.done();

	    }
	});
}

window.fnFN.atualizarFuncionario = function(FU_CODIGO_ID) {
	// Dados da tabela Cliente
	var FU_NOME = $('#FU_NOME').val();
	var FU_EMAIL = $('#FU_EMAIL').val();
	var FU_TIPO = $('#FU_TIPO').val();
	
	v = true;

	// aqui somente verifica os campos se estão vazios para executar a ação do cadastro
	if (FU_NOME == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o nome'};
		v = false;
	} else if (FU_EMAIL == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o email'};
		v = false;
	} if (FU_TIPO == -1) {
		var d = {tipo: 'notice', titulo: 'Campo inválido', mensagem: 'Selecione uma opção'};
		v = false;
	}

	// Aqui verifica se tem algo salvo na variável d para jogar no toast - que siginifica que ela caiu em alguma das opções acima.
	if (v == false) {
		fn.toast(d);
		return false;
	} else {
		
		var carrega_url = "actions";
		carrega_url = "system/funcionarios/" + carrega_url + ".php";

		// Todas as requisições para actions, deverá ser passada uma flag
		// @flag -> 2 -> Atualização do funcionário
		var flag = 2;
		
		dados = {flag: flag, "FU_CODIGO_ID": FU_CODIGO_ID, "FU_NOME": FU_NOME, "FU_EMAIL": FU_EMAIL, "FU_TIPO": FU_TIPO};

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

// viewAddOperador
window.fnFN.viewAddOperador = function() {
	// Aqui da um loading de UX na interface
	NProgress.start();

	$("#dialog-large-home").modal("toggle");
	
	$("#titulo-dialog-large").html('<b>Adicionar tipo de Operador</b>');

	var carrega_url = "actions";
	carrega_url = "system/funcionarios/" + carrega_url + ".php";

	var flag = 44;
	var dados = {flag: flag};

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

	      $("#conteudo-dialog-large").html(data);
	      buttons = "<button type='button' class='btn btn-danger' class='close' data-dismiss='modal'><i class='glyphicon glyphicon-remove'></i> Cancelar</button>"
	      +"<button onclick='fnFN.addOperador()' type='button' class='btn btn-primary'><i class='glyphicon glyphicon-file'></i> Gravar</button>";
	      
	      $("#footer-dialog-large").html(buttons);
		  NProgress.start();
	    },

	    beforeSend: function () {
	    },

	    complete: function () {
 	      NProgress.done();

	    }
	});		

	// Aqui para um loading de UX na interface
	NProgress.done();
}

// Aqui adiciona os tipos de funcionário no banco
window.fnFN.addOperador = function() {
	// Aqui da um loading de UX na interface
	var carrega_url = "actions";
	carrega_url = "system/funcionarios/" + carrega_url + ".php";

	var OP_NOME = $("#OP_NOME").val();	
	var OP_FUNCAO = $("#OP_FUNCAO").val();	

	if (OP_NOME == "") {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o nome'};
		fn.toast(d);
		return false;
	} else if (OP_FUNCAO == "") {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite a função'};
		fn.toast(d);
		return false;
	}
	var flag = 11;
	var dados = {flag: flag, "OP_NOME": OP_NOME, "OP_FUNCAO": OP_FUNCAO};

	//  A função Ajax jah dah o retorno da requisição através da variavel data
	$.ajax({

	    url: carrega_url,
	    type: "POST",
	    data: dados,

	    success: function (data) {
	      $("#conteudo-dialog-large").html(data);
		  NProgress.start();
	    },

	    beforeSend: function () {
	    },

	    complete: function () {
		  $("#dialog-large-home").modal("hide");
		  fnFN.initSelectOperador();
 	      NProgress.done();

	    }
	});		

	// Aqui para um loading de UX na interface
	NProgress.done();
}

window.fnFN.initSelectOperador = function() {
	// Aqui da um loading de UX na interface
	var carrega_url = "actions";
	carrega_url = "system/funcionarios/" + carrega_url + ".php";

	var flag = 55;
	var dados = {flag: flag};

	//  A função Ajax jah dah o retorno da requisição através da variavel data
	$.ajax({

	    url: carrega_url,
	    type: "POST",
	    data: dados,

	    success: function (data) {
	      $("#FU_TIPO").html(data);
		  NProgress.start();
	    },

	    beforeSend: function () {
	    },

	    complete: function () {
		  $("#dialog-large-home").modal("hide");
 	      NProgress.done();

	    }
	});	
}


