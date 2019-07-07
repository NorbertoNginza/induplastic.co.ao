// ****************************__ MAQUINAS __*********************************//

window.fnMA.gravarMaquina = function() {
	// Dados da tabela Cliente
	var MA_NOME = $('#MA_NOME').val();
	var MA_DESCRICAO = $('#MA_DESCRICAO').val();
	
	v = true;

	// aqui somente verifica os campos se estão vazios para executar a ação do cadastro
	if (MA_NOME == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o nome'};
		v = false;
	} else if (MA_DESCRICAO == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite a descrição'};
		v = false;
	}

	// Aqui verifica se tem algo salvo na variável d para jogar no toast - que siginifica que ela caiu em alguma das opções acima.
	if (v == false) {
		fn.toast(d);
		return false;
	} else {
		// Dbug
		var carrega_url = "actions";
		carrega_url = "system/maquinas/" + carrega_url + ".php";

		// Todas as requisições para actions, deverá ser passada uma flag
		// @flag -> 1
		var flag = 1;

		dados = {flag: flag, "MA_NOME": MA_NOME, "MA_DESCRICAO": MA_DESCRICAO};
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

window.fnMA.viewEditaMaquina = function () {
	// Aqui pega o valor selecionado dos registros da tabela dos funcionários
	var MA_CODIGO_ID = fn.getValueRadio('maquinas');
	if (MA_CODIGO_ID === undefined) {
		var d = {tipo: 'notice', titulo: 'Seleção', mensagem: 'Selecione um registro!'};
		fn.toast(d);
		return false;
	}

	// Passando o código de identificação do funcionário
	var dado = {"MA_CODIGO_ID": MA_CODIGO_ID};

	var carrega_url = "cadastro";
	carrega_url = "system/maquinas/" + carrega_url + ".php";
	  
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

window.fnMA.atualizarMaquina = function(MA_CODIGO_ID) {
	// Dados da tabela de máquinas
	var MA_NOME = $('#MA_NOME').val();
	var MA_DESCRICAO = $('#MA_DESCRICAO').val();
	
	v = true;

	// aqui somente verifica os campos se estão vazios para executar a ação do cadastro
	if (MA_NOME == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o nome'};
		v = false;
	} else if (MA_DESCRICAO == '') {
		var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite a descrição'};
		v = false;
	}

	// Aqui verifica se tem algo salvo na variável d para jogar no toast - que siginifica que ela caiu em alguma das opções acima.
	if (v == false) {
		fn.toast(d);
		return false;
	} else {
		
		var carrega_url = "actions";
		carrega_url = "system/maquinas/" + carrega_url + ".php";

		// Todas as requisições para actions, deverá ser passada uma flag
		// @flag -> 2 -> Atualização da máquina
		var flag = 2;
		
		dados = {flag: flag, "MA_CODIGO_ID": MA_CODIGO_ID, "MA_NOME": MA_NOME, "MA_DESCRICAO": MA_DESCRICAO};

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

window.fnMA.viewModalExluiMaquina = function() {
  var MA_CODIGO_ID = fn.getValueRadio('maquinas');
  if (MA_CODIGO_ID === undefined) {
	var d = {tipo: 'notice', titulo: 'Seleção', mensagem: 'Selecione um registro!'};
	fn.toast(d);
	return false;
  }

  $(".dialog-home").modal("toggle");
  $("#titulo-dialog").html('Exclusão');
  $("#conteudo-dialog").html('Deseja realmente excluir a maquina?');
  var buttons = "<button type='button' class='btn btn-danger' class='close' data-dismiss='modal'><i class='glyphicon glyphicon-remove'></i> Cancelar</button>"
        +"<button onclick='fnMA.excluirMaquina("+MA_CODIGO_ID+")' type='button' class='btn btn-primary'><i class='glyphicon glyphicon-ok'></i> sim</button>";

  $("#footer-dialog").html(buttons);

}

window.fnMA.excluirMaquina = function(MA_CODIGO_ID) {
  var carrega_url = "actions";
  carrega_url = "system/maquinas/" + carrega_url + ".php";
    // Passando o código de identificação do Máquina
    //  Flag == 3 -> Remoção de maquinas cadatradas
  var flag = 3;

  var dados = {flag: flag, "MA_CODIGO_ID": MA_CODIGO_ID};

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
      $(".dialog-home").modal("hide");
    
      NProgress.done();
    }
  }); 
}

// viewAddOperador
window.fnMA.viewAddOperador = function() {
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
	      +"<button onclick='fnMA.addOperador()' type='button' class='btn btn-primary'><i class='glyphicon glyphicon-file'></i> Gravar</button>";
	      
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
window.fnMA.addOperador = function() {
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
		  fnMA.initSelectOperador();
 	      NProgress.done();

	    }
	});		

	// Aqui para um loading de UX na interface
	NProgress.done();
}

window.fnMA.initSelectOperador = function() {
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


