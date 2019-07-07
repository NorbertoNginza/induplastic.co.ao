<!-- #################### __ LogOut do Sistema __#################### -->
<?php 
	
	// Importando a classe controladora do login
	require_once('ServiceLogin.class.php');

	// ############ Declaração de Objetos ############## //
	$service = new ServiceLogin();

	// ############ Processamento #############

	print_r($service->logOut());
	
?>