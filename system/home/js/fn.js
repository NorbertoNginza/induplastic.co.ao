// ****************************__ HOME / MODAL __*********************************//
// Aqui inicializa um array de EMAILS, para envio dos mesmos 
var arrayEmails = [];

// Aqui vai ser gerado um modelo de relatório de baixa dos contratos, onde será enviado aos destinatários que constam na tabela
window.fnHM.enviaRelatorioBaixas = function() {
  // Chamando null & null -> Para aproveitamento da função, null é para não cair nas outras alternativas de envemail
  envia(null, null);
}

// Essa função desempenha o papel de pegar os dados e passar para a API do envio dos emails
window.fnHM.enviaEmail = function() {

    if (isEmptyTable('table-destinatarios')) {
      var d = {tipo: 'notice', titulo: 'Seleção vazia', mensagem: 'Selecione pelo menos um Destinatário!'};
      fn.toast(d); return false;
    }

    var arrayDestinatarios = arrayEmails;
    var assunto = document.getElementById('assunto-caixa-email').value;
    var mensagem = document.getElementById('mensagem-caixa-email').value;

    // Aqui pega o corretor selecionado no select
    var cod = document.getElementById('select-filtro').value;
    // Aqui pega uma das opções selecionadas do radio button
    // @1 -> Todas os contratos
    // @2 -> Todas os contratos em aberto
    // @3 -> Todas os contratos com baixa
    var option = fnHM.getValueRadio('radio-filtro');

    var carrega_url = "envemail";
    carrega_url = "financeiro/" + carrega_url + ".php";

    var dados = {'CT_CORRETOR': cod, 'option': option, 'arrayDestinatarios': arrayDestinatarios, 'pin': null, 'corretor': null, 'assunto': assunto, 'mensagem': mensagem, flag: 1};

    console.log(dados);

    var count = Object.keys(dados).length;
    var url   = "";

    for (var key in dados) {
       url += key +'='+dados[key]; 
       url += (Object.keys(dados).indexOf(key) < count-1)? '&': '';
    }

    // Aqui gera a interface da tabela de baixas e salva o pdf e envia o email 
    window.location = 'financeiro/envemail.php?'+url;

} 

// Aqui verifica se elemento da existe no array
window.fnHM.isExists = function(item, array) {
  if (array.indexOf(item) > -1) {
    return true;
  } else {
    return false;
  }
}

// Aqui pega quantos elementos há na tabela
window.fnHM.contTrsTable = function(table) {
    return $("#"+table+" tr").length - 1;

}

// Aqui serve para validar um email a partir de uma String
window.fnHM.validacaoEmail = function(field) {
  usuario = field.substring(0, field.indexOf("@"));
  dominio = field.substring(field.indexOf("@")+ 1, field.length);
   
  if ((usuario.length >=1) &&
      (dominio.length >=3) && 
      (usuario.search("@")==-1) && 
      (dominio.search("@")==-1) &&
      (usuario.search(" ")==-1) && 
      (dominio.search(" ")==-1) &&
      (dominio.search(".")!=-1) &&      
      (dominio.indexOf(".") >=1)&& 
      (dominio.lastIndexOf(".") < dominio.length - 1)) {
    
    return true;
  } else{
    return false;
  }
}

// Essa função serve para a chamada da função principal da criação da tabela html para a geração do pdf  
window.fnHM.createViewPdf = function() {
  if (isEmptyTable('table-destinatarios')) {
      var d = {tipo: 'notice', titulo: 'Seleção vazia', mensagem: 'Selecione pelo menos um Destinatário!'};
      fn.toast(d); return false;
  }

    var arrayDestinatarios = arrayEmails;
    var assunto = document.getElementById('assunto-caixa-email').value;
    var mensagem = document.getElementById('mensagem-caixa-email').value;

    // Aqui pega o corretor selecionado no select
    var cod = document.getElementById('select-filtro').value;
    // Aqui pega uma das opções selecionadas do radio button
    // @1 -> Todas os contratos
    // @2 -> Todas os contratos em aberto
    // @3 -> Todas os contratos com baixa
    var option = fnHM.getValueRadio('radio-filtro');

    var carrega_url = "envemail";
    carrega_url = "financeiro/" + carrega_url + ".php";

    var dados = {'CT_CORRETOR': cod, 'option': option, 'arrayDestinatarios': arrayDestinatarios, 'pin': null, 'corretor': null, 'assunto': assunto, 'mensagem': mensagem, flag: 1};

    console.log(dados);

    var count = Object.keys(dados).length;
    var url   = "";

    for (var key in dados) {
       url += key +'='+dados[key]; 
       url += (Object.keys(dados).indexOf(key) < count-1)? '&': '';
    }

  // Aqui gera a interface da tabela de baixas e gera o pdf
  window.location = 'financeiro/createPdf.php?'+url;

}

window.fnHM.initDadosCaixaEmail = function(arrayDestinatarios, assunto, mensagem) {
  // Aqui zera o email para receber os email passados por URL 
  arrayEmails = []; 
  $("#conteudo-table-destinatarios").html('');
  fnHM.openModalCaixaEmail();
  arrayDestinatarios = arrayDestinatarios.split(",");
  console.log(arrayDestinatarios);

  // Aqui coloca os dados recebidos da url para os seus devidos campos
  document.getElementById('assunto-caixa-email').value = assunto;
  document.getElementById('mensagem-caixa-email').value = mensagem;

  fnHM.addDestinatariosTable(arrayDestinatarios);

}

window.fnHM.addDestinatariosTable = function(arrayDestinatarios) {
  for (var i = arrayDestinatarios.length - 1; i >= 0; i--) {
    var td = "<tr>";
    td += "<td>"+arrayDestinatarios[i]+"</td>";
    td += "<td><button style='float: left;' id='"+i+"' class='btn btn-primary' type='button' onclick='fnHM.remove(this)' value='"+arrayDestinatarios[i]+"'><span class='glyphicon glyphicon-remove'></span></button></td>";
    td += "</tr>";
    $("#table-destinatarios").append(td);
    // Aqui adiciona o(s) email(s) ao array principal para as requisições futuras dos emails
    arrayEmails.push(arrayDestinatarios[i]);
  }
}

window.fnHM.createAlert = function(msg, tipo, div) {
  var alertMsg = "<div class='alert alert-"+tipo+" alert-dismissible show' role='alert'>"+msg+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='false'>&times;</span></button></div>";
  $("#"+div).html(alertMsg);
}

// Adiciona o email na tabela(na vdd sempre atualiza com base no array de emails)
window.fnHM.addItemTable = function() {
  var carrega_url = "destinatarios";
  carrega_url = "system/home/" + carrega_url + ".php";

  var dados = {'emails': arrayEmails};

//  A função Ajax jah dah o retorno da requisição através da variavel data
  $.ajax({

      url: carrega_url,
      type: "POST",
      data: dados,

      success: function (data) {
          $("#conteudo-table-destinatarios").html(data);

      },

      beforeSend: function () {
      
      },

      complete: function () {

      }
  }); 
}

// Aqui faz a validação para adicionar o email no array e na tabela com base na function fnHM.addItemTable(); 
window.fnHM.addEmailTable = function() {
  var email = document.getElementById('destinatario-caixa-email').value;
  $('#destinatario-caixa-email').css('border-color', '#b3d4fc');
  
  if (fnHM.validacaoEmail(email)) {
    if (arrayEmails.length >= 100) {
      var d = {tipo: 'notice', titulo: 'ERRO', mensagem: 'Limite máximo de destinatários excedido.'};
      fn.toast(d); return false;
    } else if (!fnHM.isExists(email, arrayEmails)) {
      arrayEmails.push(email);
      fnHM.addItemTable();

      console.log(arrayEmails);
      document.getElementById('destinatario-caixa-email').value = "";
    } else {
      var d = {tipo: 'notice', titulo: 'Seleção inválida', mensagem: 'Destinatário já existente para o envio.'};
      fn.toast(d); return false;
    }
  } else {
    $('#destinatario-caixa-email').css('border-color', 'red');
  }
}

// Remove o item da tabela correspondente
window.fnHM.remove = function(item) {
    var index = arrayEmails.indexOf(item.value);
    if (index > -1) {
      arrayEmails.splice(index, 1);
    }
    var tr = $(item).closest('tr');
    tr.fadeOut(400, function() {
        tr.remove();
    });

    console.log(arrayEmails);
  return false;
}

// Remove da tabela o email passado como parametro
window.fnHM.removeEmailTable = function(email) {
    var index = arrayEmails.indexOf(email);
    if (index > -1) {
      // Aqui deleta do ARRAY
      arrayEmails.splice(index, 1); 
    }

    // Aqui deleta da Interface
    fnCC.deleteRowTable(email);

    console.log(arrayEmails);
  return false;
}

window.fnCC.deleteRowTable = function(rowid) {  
  var row = document.getElementById(rowid);
  row.parentNode.removeChild(row);
}

// Function com relação a o modal adicionado para o envio dos emails
window.fnHM.openModalCaixaEmail = function() {
  // Get the modal
  var modal = document.getElementById('modalCaixaEmail');
  modal.style.display = "block";
  // Aqui verifica se é mobile ou se a tela do dispositivo é pequena, para ajustar o modal a tela 
  if (fnHM.mobilecheck() || fnHM.mobilecheckWidth()) {
    $(".modalCaixaEmail-content").css("width", '100%')
  } 

}

window.fnHM.closeModalCaixaEmail = function() {
  // Get the modal
  fnCC.ajusteInterfaceDialogSmallPadrao();
  
  var modal = document.getElementById('modalCaixaEmail');
  modal.style.display = "none";

}

// Detectar se é dispositivo móvel
window.fnHM.mobilecheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
};

window.fnHM.mobilecheckWidth = function() {
   if(window.innerWidth <= 800 && window.innerHeight <= 700) {
     return true;
   } else {
     return false;
   }
}

window.fnHM.closeNotifications = function(){
  $("#conteudo-noty").hide();
} 