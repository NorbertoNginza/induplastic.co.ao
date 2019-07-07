// ########################__ Folha de requisição para acessar o sistema __################################ //

// aqui declara o array onde ficará gravado as funcoes de login 
fnLogin = {};

// aqui trata o evento ENTER da página de Login - somente chama a função login
$(document).keypress(function(e){
    if(e.wich == 13 || e.keyCode == 13){
    	fnLogin.login();
   	}
});

window.fnLogin.login = function() {
	var login = document.getElementById('login').value; 
	var senha = document.getElementById('senha').value;

	var dados = {'login': login, 'senha': senha};

	var carrega_url = "login";
    carrega_url = "php/acesso/" + carrega_url + ".php";

    if (login == '') {
    	var d = {
	    	tipo: 'notice',
	    	titulo: 'Campo vazio',
	    	mensagem: 'Digite um login'
	    }
	    fn.toast(d);

	    return false;

    } else if (senha == '') {
		var d = {
	    	tipo: 'notice',
	    	titulo: 'Campo vazio',
	    	mensagem: 'Digite uma senha',
	    }
	    fn.toast(d);
    	return false;
    }    

    //  A função Ajax jah dah o retorno da requisição através da variavel data
    $.ajax({

        url: carrega_url,
        type: "POST",
        data: dados,

        success: function (data) {
        	NProgress.start();
            $("#verificaLogin").html(data);
        },

        beforeSend: function () {
            $('#loading').css({display: "block"});
        },

        complete: function () {
            $('#loading').css({display: "none"});                    
			NProgress.done();

        }
    });

}
