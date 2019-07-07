<?php 
	require_once('../../php/controls/Service.class.php');

	class ServiceClientes extends Service {

		//	construtor da classe(Default)
		function __construct() {
		
		}

		public function getTotalClientes() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT COUNT(*) FROM clientes";
			return $db->execSql($sql);
		}

		public function getTotalClientesAtivo() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT COUNT(*) FROM clientes WHERE CL_ATIVO = 1";
			return $db->execSql($sql);
		}

		public function getTotalClientesInativo() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT COUNT(*) FROM clientes WHERE CL_ATIVO = 0";
			return $db->execSql($sql);
		}

		public function getTotalClientesPendentes() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT COUNT(*) FROM clientes WHERE CL_ATIVO = 2";
			return $db->execSql($sql);
		}

		public function getDadosClientesPendentes() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT * FROM clientes WHERE CL_ATIVO = 2";
			return $db->execSql($sql);
		}

		public function geraListUsersPendentesNotifications (){
			$clientes = $this->getDadosClientesPendentes();
			foreach ($clientes as $cliente) {
				$html = '<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
					        <div class="d-flex w-100 justify-content-between" data-toggle="tooltip" data-placement="bottom" title="pendente!">
					          <h5 class="mb-1"><b>'.$this->ajustAtribute($cliente['CL_NOME']).'</b></h5>
					          <br>
					          <br>
					          <button data-toggle="modal" data-target=".dialog-home" onclick="fnCC.viewCliente('.$cliente['CL_CODIGO'].', \''.$cliente['CL_NOME'].'\')" class="btn btn-info btn-xs" style="float: right; margin-top: -35px;"><span class="glyphicon glyphicon-eye-open"></span> Visualizar</button>
					        </div>
					      </a>';
				print $html; 
			}

		}

		public function porcentagem_nx ( $valor, $total ) {
			if ($valor != 0) {
				return ( $valor * 100 ) / $total;
			} else {
				return 0;
			} 
		}

	}
?>
