// ########################__ Folha de requisição para sair do sistema __################################ //

// aqui declara o array onde ficará gravado as funcões de logOut
fnLogOut = {};

window.fnLogOut.logOut = function() {
    var carrega_url = "logOut";
    carrega_url = "php/acesso/" + carrega_url + ".php";

    //  A função Ajax jah dah o retorno da requisição através da variavel data
    $.ajax({

        url: carrega_url,
        type: "POST",

        success: function (data) {
            NProgress.start();
            $("#conteudo-noty").html(data);
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

 
