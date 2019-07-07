<!-- Aqui está a classe onde são serializados os dados para saerem usados no decorrer do sistema -->
<?php
class User {
	private $login;
	private $email;
	private $senha;
	private $nome;
	private $codigo;
	private $admin;
	private $ativo;
	
//construtor da classe
	function __construct($login, $senha, $nome, $codigo, $admin, $tipo, $ativo){
		$this->login = $login;
		$this->email = $login;
		$this->senha = $senha;
		$this->nome = $nome;
		$this->codigo = $codigo;
		$this->admin = $admin;
		$this->tipo = $tipo;
		$this->ativo = $ativo;
	}

	public function getLogin(){
		return $this->login;
	}
	
	public function getSenha(){
		return $this->senha;
	}

	public function getNome(){
		return $this->nome;
	}

	public function getEmail(){
		return $this->email;
	}
	
	public function getCodigo(){
		return $this->codigo;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function getAtivo(){
		return $this->codigo;
	}

	public function getAdmin (){
		return $this->admin;
	}
	

} ?>
