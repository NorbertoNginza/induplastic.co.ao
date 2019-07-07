<!-- Aqui vão constar todas as ações referente ao item de menu Cd. Funcionário a partir das flags passadas pelo POST -->
<!-- ########## Flags Para as ações  ##########-->
<!-- @1 -> Cadastro --> 
<!-- @2 -> Editar -->
<!-- @3 -> Remover -->
<!-- @4 -> gera Tabela pela pesquisa de 1 ou mais clientes-->
<!-- @5 -> gera Tabela pela pesquisa com um único cliente -->
<!-- @6 -> Alteração de STATUS -->
<!-- @44 -> gera View cadastrar tipo de Operadores -->
<!-- @55 -> gera as options para seleção do operador -->

<?php 
	
	require_once('ServiceFuncionarios.class.php');

	$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$service = new ServiceFuncionarios();

	// ###########################__ CADASTRO __################################### //
	if ($dados['flag'] == 1) {
		$service->InsertFuncionario($dados);
		$service->redirecionaTableFuncionarios();

	} else if ($dados['flag'] == 2) {
		$service->UpdateFuncionario($dados['FU_CODIGO_ID'], $dados);
		$service->redirecionaTableFuncionarios();

	}  else if ($dados['flag'] == 11) {
		$service->InsertOperador($dados);

	} else if ($dados['flag'] == 44) {
		$service->geraViewOperador();

	}  else if ($dados['flag'] == 55) {
		$service->geraOptionsOperador();
		
	} 

?>