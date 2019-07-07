<?php
session_start();
require_once('../controls/Service.class.php');
require_once('../class/User.class.php');

class ServiceLogin extends Service {

	//	construtor da classe(Default)
	function __construct() {

	}

	public function login($login, $senha) {
		$this->openRequisitionDb();

    	$db = new Db();

		$sql = "SELECT FU_EMAIL, FU_SENHA, FU_NOME, FU_CODIGO, FU_TIPO, FU_ATIVO, FU_ADMINISTRADOR FROM funcionarios WHERE FU_EMAIL = '$login' and FU_SENHA = md5('$senha')";
		$result = $db->execSql($sql);

		if (!empty($result)) {
			$this->toast('success', 'Login com sucesso', 'Redirecionando...');
			$user = new User($result[0]['FU_EMAIL'], $result[0]['FU_SENHA'], $result[0]['FU_SENHA'], $result[0]['FU_CODIGO'], $result[0]['FU_ADMINISTRADOR'], $result[0]['FU_TIPO'], $result[0]['FU_ATIVO']);
			// aqui cria a sessão 
			$_SESSION['user'] = '';
			// Aqui salva um usuário serializado para solicitações futuras 
    		$_SESSION['user'] = serialize($user);
    		// Aqui redireciona o user para a HOME
    		// print_r($_SESSION['user']);
			$this->redirecionarLogin();
		} else {
			// toast vem da classe Service
			$this->toast('error', 'Login inválido', 'Verifique os dados, e tente novamente!');
			return false;
		}

	}

	public function logOut() {
		if (!empty(unserialize($_SESSION['user']))) {
			$_SESSION['user'] = '';
			session_destroy();
			$this->toast('error', 'LogOut', "Fazendo logOut no sistema!");			
			$this->redirecionarLogOut();

		} else {
			$this->toast('error', 'LogOut', "Fazendo logOut no sistema!");			
			$this->redirecionarLogOut();
		}
	}

	public function redirecionarLogin() {
		print "<script> setTimeout(function(){ 
			                window.location = 'index.php';
			            }, 2500); </script>";
	}

	public function redirecionarLogOut() {
		print "<script> setTimeout(function(){ 
			                window.location = 'login.php';
			            }, 1500); </script>";
	}


}