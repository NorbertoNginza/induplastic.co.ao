<!-- Aqui vão constar todas as ações referente ao envio dos lembretes -->
<!-- ########## Flags Para as ações  ##########-->
<!-- @1 -> Seleção para envio dos emails  -->

<?php 
	
	require_once('ServiceClientes.class.php');

	$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$service = new ServiceClientes();

	// ###########################__ CADASTRO __################################### //
	if ($dados['flag'] == 1) {
		$service->geraListClientes($dados);

	} 
?>