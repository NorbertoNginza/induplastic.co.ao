<?php 
	
    require_once('../../lib/phpmailer/class.phpmailer.php');

    require_once('ServiceClientes.class.php');
    $service = new ServiceClientes();
	
    $emails = explode(',', $_GET['arrayDestinatarios']);
	$tituloEmail = (isset($_GET['assunto'])) ? $_GET['assunto'] : '';
	$msgEmail = (isset($_GET['mensagem'])) ? $_GET['mensagem'] : '';

	// @emails -> Array com os emails a serem enviados
    // @tituloEmail -> Título a ser exibido na caixa de email
    // @msgEmail -> Mensagem a ser exibido na caixa de email
	if ($service->enviaBaixas($emails, $tituloEmail, $msgEmail)) {
        $this->toast('success', 'Sucesso', "Mensagem enviada ao(s) destinatário(s).");
        $service->redirecionaTableCLientes('cliente');
    } else {
        // Ocorreu ERRO
        $this->toast('error', 'Erro', "Ocorreu algum erro no envio");
		$service->redirecionaTableCLientes('cliente');
	}

//============================================================+
// END OF FILE
//============================================================+

?>

