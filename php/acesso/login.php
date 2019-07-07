<!-- #################### __ Login no Sistema __#################### -->
<?php 
	
	// Importando a classe controladora do login
	require_once('ServiceLogin.class.php');

	// ############ Declaração de variáveis ############## //
	
	// Atributos vindos da requisição AJAX
	$login = $_POST['login'];
	$senha = $_POST['senha'];

	// ############ Declaração de Objetos ############## //
	$service = new ServiceLogin();

	// ############ Processamento #############

	print_r($service->login($login, $senha));
?>