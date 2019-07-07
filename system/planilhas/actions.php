<!-- Aqui vão constar todas as ações referente ao item de menu Cd. Ocorrencias a partir das flags passadas pelo POST -->
<!-- ########## Flags Para as ações  ##########-->
<!-- @1 -> View Full das Ocorrencias --> 


<?php 
	
	require_once('ServiceOcorrencias.class.php');

	$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$service = new ServiceOcorrencias();

	// ###########################__ CADASTRO __################################### //
	if ($dados['flag'] == 1) {
		$service->geraViewFull();

	} else if ($dados['flag'] == 2) {
		$service->UpdateOcorrencia($dados['OC_CODIGO_ID'], $dados);

	} 
?>