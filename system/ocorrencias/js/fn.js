// ****************************__ OCORRENCIA __*********************************//

window.fnOC.gravarOcorrencia = function() {
  // Dados da tabela Ocorrências
  var OC_MAQUINA = $('#OC_MAQUINA').val();
  var OC_PROBLEMA = $('#OC_PROBLEMA').val();
  var OC_DATA = $('#OC_DATA').val();
  var OC_ORDEM_PRODUCAO = $('#OC_ORDEM_PRODUCAO').val();
  var OC_INICIO = $('#OC_INICIO').val();
  var OC_FIM = $('#OC_FIM').val();
  var OC_STATUS = $('#OC_STATUS').val();
  var OC_ACAO = $('#OC_ACAO').val();
  var OC_OPERADOR = $('#OC_OPERADOR').val();
  var OC_TEMPO = $('#OC_TEMPO').val();
  
  v = true;

  // aqui somente verifica os campos se estão vazios para executar a ação do cadastro
  if (OC_MAQUINA === undefined) {
    var d = {tipo: 'notice', titulo: 'Seleção de campo', mensagem: 'Selecione a máquina'};
    v = false;
  } else if (OC_PROBLEMA === undefined) {
    var d = {tipo: 'notice', titulo: 'Seleção de campo', mensagem: 'Selecione o problema'};
    v = false;
  } else if (OC_DATA == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite a data'};
    v = false;
  } else if (OC_ORDEM_PRODUCAO == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite a ordem de produção'};
    v = false;
  } else if (OC_INICIO == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o hórario do início'};
    v = false;
  } else if (OC_FIM == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o hórario de fim'};
    v = false;
  } else if (OC_STATUS === undefined) {
    var d = {tipo: 'notice', titulo: 'Seleção de campo', mensagem: 'Selecione o status'};
    v = false;
  } else if (OC_ACAO == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite a ação'};
    v = false;
  } else if (OC_OPERADOR === undefined) {
    var d = {tipo: 'notice', titulo: 'Seleção de campo', mensagem: 'Selecione o operador'};
    v = false;
  } else if (OC_TEMPO == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Ajuste o horário de início e fim para continuar'};
    v = false;
  }

  if (fn.compararHora(OC_INICIO, OC_FIM) === true) {
    var d = {tipo: 'notice', titulo: 'Dados inválidos', mensagem: 'Hora fim é menor q a de inicio'};
    v = false;
    fn.toast(d);
    return false;
  }

  OC_INICIO = OC_INICIO.replace("--", '');
  OC_FIM = OC_FIM.replace("--", '');

  if (OC_INICIO.length < 5) {
    var d = {tipo: 'notice', titulo: 'Dados inválidos', mensagem: 'Hora inicio está incompleto'};
    v = false;
    fn.toast(d);
    return false;
  }

  if (OC_FIM.length < 5) {
    var d = {tipo: 'notice', titulo: 'Dados inválidos', mensagem: 'Hora fim está incompleto'};
    v = false;
    fn.toast(d);
    return false;
  }

  // Aqui verifica se tem algo salvo na variável d para jogar no toast - que siginifica que ela caiu em alguma das opções acima.
  if (v == false) {
    fn.toast(d);
    return false;
  } else {
    // Dbug
    var carrega_url = "actions";
    carrega_url = "system/ocorrencias/" + carrega_url + ".php";

    // Todas as requisições para actions, deverá ser passada uma flag
    // @flag -> 1
    var flag = 1;

    dados = {flag: flag, "OC_MAQUINA": OC_MAQUINA, "OC_PROBLEMA": OC_PROBLEMA, "OC_DATA": OC_DATA, "OC_ORDEM_PRODUCAO": OC_ORDEM_PRODUCAO, "OC_INICIO": OC_INICIO, "OC_FIM": OC_FIM, "OC_STATUS": OC_STATUS, "OC_ACAO": OC_ACAO, "OC_OPERADOR": OC_OPERADOR, "OC_TEMPO": OC_TEMPO};
 
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

window.fnOC.viewEditaOcorrencia = function () {
  // Aqui pega o valor selecionado dos registros da tabela dos funcionários
  var OC_CODIGO_ID = fn.getValueRadio('ocorrencias');
  if (OC_CODIGO_ID === undefined) {
    var d = {tipo: 'notice', titulo: 'Seleção', mensagem: 'Selecione um registro!'};
    fn.toast(d);
    return false;
  }

  // Passando o código de identificação do funcionário
  var dado = {"OC_CODIGO_ID": OC_CODIGO_ID};

  var carrega_url = "cadastro";
  carrega_url = "system/ocorrencias/" + carrega_url + ".php";
    
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

window.fnOC.atualizarOcorrencia = function(OC_CODIGO_ID) {
  // Dados da tabela Ocorrências
  var OC_MAQUINA = $('#OC_MAQUINA').val();
  var OC_PROBLEMA = $('#OC_PROBLEMA').val();
  var OC_DATA = $('#OC_DATA').val();
  var OC_ORDEM_PRODUCAO = $('#OC_ORDEM_PRODUCAO').val();
  var OC_INICIO = $('#OC_INICIO').val();
  var OC_FIM = $('#OC_FIM').val();
  var OC_STATUS = $('#OC_STATUS').val();
  var OC_ACAO = $('#OC_ACAO').val();
  var OC_OPERADOR = $('#OC_OPERADOR').val();
  var OC_TEMPO = $('#OC_TEMPO').val();
  
  v = true;

  // aqui somente verifica os campos se estão vazios para executar a ação do cadastro
  if (OC_MAQUINA === undefined) {
    var d = {tipo: 'notice', titulo: 'Seleção de campo', mensagem: 'Selecione a máquina'};
    v = false;
  } else if (OC_PROBLEMA === undefined) {
    var d = {tipo: 'notice', titulo: 'Seleção de campo', mensagem: 'Selecione o problema'};
    v = false;
  } else if (OC_DATA == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite a data'};
    v = false;
  } else if (OC_ORDEM_PRODUCAO == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite a ordem de produção'};
    v = false;
  } else if (OC_INICIO == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o hórario do início'};
    v = false;
  } else if (OC_FIM == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite o hórario de fim'};
    v = false;
  } else if (OC_STATUS === undefined) {
    var d = {tipo: 'notice', titulo: 'Seleção de campo', mensagem: 'Selecione o status'};
    v = false;
  } else if (OC_ACAO == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Digite a ação'};
    v = false;
  } else if (OC_OPERADOR === undefined) {
    var d = {tipo: 'notice', titulo: 'Seleção de campo', mensagem: 'Selecione o operador'};
    v = false;
  } else if (OC_TEMPO == '') {
    var d = {tipo: 'notice', titulo: 'Campo vazio', mensagem: 'Ajuste o horário de início e fim para continuar'};
    v = false;
  }

  if (fn.compararHora(OC_INICIO, OC_FIM) === true) {
    var d = {tipo: 'notice', titulo: 'Dados inválidos', mensagem: 'Hora fim é menor q a de inicio'};
    v = false;
    fn.toast(d);
    return false;
  }

  OC_INICIO = OC_INICIO.replace("--", '');
  OC_FIM = OC_FIM.replace("--", '');

  if (OC_INICIO.length < 5) {
    var d = {tipo: 'notice', titulo: 'Dados inválidos', mensagem: 'Hora inicio está incompleto'};
    v = false;
    fn.toast(d);
    return false;
  }

  if (OC_FIM.length < 5) {
    var d = {tipo: 'notice', titulo: 'Dados inválidos', mensagem: 'Hora fim está incompleto'};
    v = false;
    fn.toast(d);
    return false;
  }

  // Aqui verifica se tem algo salvo na variável d para jogar no toast - que siginifica que ela caiu em alguma das opções acima.
  if (v == false) {
    fn.toast(d);
    return false;
  } else {
    
    var carrega_url = "actions";
    carrega_url = "system/ocorrencias/" + carrega_url + ".php";

    // Todas as requisições para actions, deverá ser passada uma flag
    // @flag -> 2 -> Atualização da máquina
    var flag = 2;
      

    dados = {flag: flag, "OC_CODIGO_ID": OC_CODIGO_ID, "OC_MAQUINA": OC_MAQUINA, "OC_PROBLEMA": OC_PROBLEMA, "OC_DATA": OC_DATA, "OC_ORDEM_PRODUCAO": OC_ORDEM_PRODUCAO, "OC_INICIO": OC_INICIO, "OC_FIM": OC_FIM, "OC_STATUS": OC_STATUS, "OC_ACAO": OC_ACAO, "OC_OPERADOR": OC_OPERADOR, "OC_TEMPO": OC_TEMPO};

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

// Padronização na criação do Dialog SMALL
// @título do Dialog -> id = #titulo-dialog
// @conteúdo do Dialog -> id = #conteudo-dialog
// @Footer do Dialog -> id = #footer-dialog - Aqui vai os botões de ação do mesmo
// Aqui adiciona o conteúdo ao dialog para fazer a restrição de usuário
window.fnOC.viewModalExluiOcorrencia = function() {
  // Aqui pega o valor selecionado dos registros da tabela dos funcionários
  var OC_CODIGO_ID = fn.getValueRadio('ocorrencias');
  if (OC_CODIGO_ID === undefined) {
    var d = {tipo: 'notice', titulo: 'Seleção', mensagem: 'Selecione um registro!'};
    fn.toast(d);
    return false;
  }

  $(".dialog-home").modal("toggle");
  $("#titulo-dialog").html('Exclusão');
  $("#conteudo-dialog").html('Deseja realmente excluir a ocorrência?');
  var buttons = "<button type='button' class='btn btn-danger' class='close' data-dismiss='modal'><i class='glyphicon glyphicon-remove'></i> Cancelar</button>"
        +"<button onclick='fnOC.excluirOcorrencia("+OC_CODIGO_ID+")' type='button' class='btn btn-primary'><i class='glyphicon glyphicon-ok'></i> sim</button>";

  $("#footer-dialog").html(buttons);

}

window.fnOC.excluirOcorrencia = function(OC_CODIGO_ID) {

  var carrega_url = "actions";
  carrega_url = "system/ocorrencias/" + carrega_url + ".php";
    // Passando o código de identificação do Cliente
    //  Flag == 3 -> Remoção de ocorrências cadatradas
  var flag = 3;

  var dados = {flag: flag, "OC_CODIGO_ID": OC_CODIGO_ID};

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

window.fnOC.initSelect = function(select) {
  // Aqui da um loading de UX na interface
  var carrega_url = "actions";
  carrega_url = "system/ocorrencias/" + carrega_url + ".php";

  var dados = {flag: 55, "select": select};

  //  A função Ajax jah dah o retorno da requisição através da variavel data
  $.ajax({

      url: carrega_url,
      type: "POST",
      data: dados,

      success: function (data) {
        $("#"+select).html(data);
        NProgress.start();
      },

      beforeSend: function () {
      },

      complete: function () {
        NProgress.done();

      }
  }); 
}

window.fnOC.viewModalData = function($OC_CODIGO_ID) {

  alert("TODO: "+$OC_CODIGO_ID);
  return false;
  // Aqui da um loading de UX na interface
  NProgress.start();

  $("#dialog-large-home").modal("toggle");
  
  $("#titulo-dialog-large").html('<b>Dados da Ocorrência</b>');

  var carrega_url = "actions";
  carrega_url = "system/ocorrencias/" + carrega_url + ".php";

  var flag = 4;
  var dados = {flag: flag, "OC_CODIGO_ID": OC_CODIGO_ID};

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

        // $("#conteudo-dialog-large").html(data);
        // buttons = "<button type='button' class='btn btn-danger' class='close' data-dismiss='modal'><i class='glyphicon glyphicon-remove'></i> Cancelar</button>"
        // +"<button onclick='fnFN.addOperador()' type='button' class='btn btn-primary'><i class='glyphicon glyphicon-file'></i> Gravar</button>";
        
        // $("#footer-dialog-large").html(buttons);
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

window.fnOC.calcTime = function() {
  OC_INICIO = $("#OC_INICIO").val();
  OC_FIM = $("#OC_FIM").val();

  if (OC_INICIO != '' && OC_FIM != '') {
    m = fnOC.converteMinutos(OC_INICIO, OC_FIM); 
  } else {
    $("#OC_TEMPO").val("0");
  }
}

window.fnOC.converteMinutos = function(OC_INICIO, OC_FIM) {
  var diferenca = fnOC.timeDiff(OC_FIM, OC_INICIO);
  hora = diferenca.split(":");

  horas = Number(hora[0] * 60);
  minutos = Number(hora[1]);

  m = horas + minutos;
  
  $("#OC_TEMPO").val(m);
  return m;
}

window.fnOC.timeDiff = function(hora1, hora2) {
  var hora1  = "06/07/2019 "+hora1+":00";
  var hora2 = "06/07/2019 "+hora2+":00";

  var ms = moment(hora1,"DD/MM/YYYY HH:mm:ss").diff(moment(hora2,"DD/MM/YYYY HH:mm:ss"));
  var d = moment.duration(ms);
  var diff = Math.floor(d.asHours()) + ":" + moment.utc(ms).format("mm");

  return diff;
}




