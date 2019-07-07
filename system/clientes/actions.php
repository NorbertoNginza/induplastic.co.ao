<!-- Aqui vão constar todas as ações referente ao item de menu Cd. Cliente a partir das flags passadas pelo POST -->
<!-- ########## Flags Para as ações  ##########-->
<!-- @1 -> Cadastro -->
<!-- @2 -> Editar -->
<!-- @3 -> Remover -->
<!-- @4 -> gera Tabela pela pesquisa de 1 ou mais clientes-->
<!-- @5 -> gera Tabela pela pesquisa com um único cliente -->
<!-- @6 -> Alteração de STATUS -->

<?php 
	
	require_once('ServiceClientes.class.php');

	$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$service = new ServiceClientes();

	// ###########################__ CADASTRO __################################### //
	if ($dados['flag'] == 1) {
		$service->InsertCliente($dados);
		$service->redirecionaTableCLientes('cliente');

	} else if ($dados['flag'] == 2) {
		$service->UpdateCliente($dados['ID'], $dados);
		$service->redirecionaTableCLientes('cliente');

	} else if ($dados['flag'] == 3) {
		$service->DeleteCliente($dados['CL_CODIGO']);
		$service->redirecionaTableCLientes('cliente');

	} else if ($dados['flag'] == 4) { // Pesquisa de clientes
		$service->geraTabelaClientesComPesquisa($dados['t']);

	} else if ($dados['flag'] == 5) { // Pesquisa de clientes
		$service->geraTabelaCliente($dados['CL_CODIGO']);

	} else if ($dados['flag'] == 6) { // Pesquisa de clientes
		if ($dados['CL_ATIVO'] == 0) {
			$service->inativaCliente($dados['CL_CODIGO'], $dados['CL_ATIVO']);
			$service->toast('success', 'Sucesso', "Alteração feita com sucesso!");
		} else if ($dados['CL_ATIVO'] == 1) {
			$service->ativaCliente($dados['CL_CODIGO'], $dados['CL_ATIVO']);
			$service->toast('success', 'Sucesso', "Alteração feita com sucesso!");
		} else if ($dados['CL_ATIVO'] == 3) {
			$service->pedenciaCliente($dados['CL_CODIGO'], $dados['CL_ATIVO']);
			$service->toast('success', 'Sucesso', "Alteração feita com sucesso!");
		}

	} 

?>