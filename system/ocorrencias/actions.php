<!-- Aqui vão constar todas as ações referente ao item de menu Cd. Ocorrencias a partir das flags passadas pelo POST -->
<!-- ########## Flags Para as ações  ##########-->
<!-- @1 -> Cadastro --> 
<!-- @2 -> Editar -->
<!-- @3 -> Remover -->
<!-- @4 -> View Dados da Ocorrência -->

<!-- @55 -> Init Select com as options das máquinas, problemas -->

<?php 
	
	require_once('ServiceOcorrencias.class.php');

	$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$service = new ServiceOcorrencias();

	// ###########################__ CADASTRO __################################### //
	if ($dados['flag'] == 1) {
		$service->InsertOcorrencia($dados);
		$service->redirecionaTableOcorrencias();

	} else if ($dados['flag'] == 2) {
		$service->UpdateOcorrencia($dados['OC_CODIGO_ID'], $dados);
		$service->redirecionaTableOcorrencias();

	} else if ($dados['flag'] == 3) {
		$service->DeleteOcorrencia($dados['OC_CODIGO_ID']);
		$service->redirecionaTableOcorrencias();

	}  else if ($dados['flag'] == 4) {
		$service->viewModalData($dados['OC_CODIGO_ID']);

	} else if ($dados['flag'] == 55) {
		$service->geraOptions($dados['select']);

	} 
?>