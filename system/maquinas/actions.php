<!-- Aqui vão constar todas as ações referente ao item de menu Cd. Maquina a partir das flags passadas pelo POST -->
<!-- ########## Flags Para as ações  ##########-->
<!-- @1 -> Cadastro --> 
<!-- @2 -> Editar -->
<!-- @3 -> Remover -->

<?php 
	
	require_once('ServiceMaquinas.class.php');

	$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$service = new ServiceMaquinas();

	// ###########################__ CADASTRO __################################### //
	if ($dados['flag'] == 1) {
		$service->InsertMaquina($dados);
		$service->redirecionaTableMaquinas();

	} else if ($dados['flag'] == 2) {
		$service->UpdateMaquina($dados['MA_CODIGO_ID'], $dados);
		$service->redirecionaTableMaquinas();

	}  else if ($dados['flag'] == 3) {
		$service->DeleteMaquina($dados['MA_CODIGO_ID']);
		$service->redirecionaTableMaquinas();

	} 

?>