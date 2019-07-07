<?php 
	require_once('../../php/controls/Service.class.php');

	class ServiceMaquinas extends Service {

		//	construtor da classe(Default)
		function __construct() {
		
		}

		public function InsertMaquina($dados) {
			$this->openRequisitionDb();
			$db = new DB();
			$sql = "INSERT INTO `maquinas`(`MA_NOME`, 
										   `MA_DESCRICAO`, 
										   `MA_ATIVO`) 
							 VALUES ("."'".$dados['MA_NOME']."', ".
	                        		   "'".$dados['MA_DESCRICAO']."', ".
	                       			       "1);";


	        $result = $db->execInsertUpdate($sql);
			
			return $this->processReturnSqlM($result, "Máquina");

		}

		public function UpdateMaquina($FU_CODIGO_ID, $dados) {
			$this->openRequisitionDb();
			$db = new DB();

			$sql = "UPDATE maquinas
				        SET MA_NOME = "."'".$dados['MA_NOME']."', ".
				            "MA_DESCRICAO = "."'".$dados['MA_DESCRICAO']."' ".
				        " WHERE MA_CODIGO = $FU_CODIGO_ID;";

			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlUpdateM($result, 'Máquina');
		}

		// Aqui deleta uma ocorrência pelo código
		public function DeleteMaquina($MA_CODIGO_ID) {
			$this->openRequisitionDb();
			$db = new DB();
			
			$sql = "DELETE FROM maquinas WHERE MA_CODIGO = $MA_CODIGO_ID";
			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlDeleteM($result, 'Máquina');
		}

		// Aqui deleta um cliente pelo código
		public function DeleteFuncionario($cod) {
			$this->openRequisitionDb();
			$db = new DB();
			
			$sql = "DELETE FROM clientes WHERE CL_CODIGO = $cod";
			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlDeleteM($result, 'Cliente');
		}

		// Aqui redireciona para visualização dos registros dos máquinas
		public function redirecionaTableMaquinas() {
			print "<script> setTimeout(function(){ 
				                fn.viewLtMaquina();
				            }, 1000); </script>";
		}

		// Aqui pega uma unica máquina pelo código
		public function getMaquina($MA_CODIGO) {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT * FROM `maquinas` WHERE `MA_CODIGO` = $MA_CODIGO";

			return $db->execSql($sql);
		}

		// Aqui retorna os dados do cliente nos seus devidos campos, para a alteração do User
		public function setDadosInputs($data) {
            $MA_NOME = $this->ajustAtribute($data[0]['MA_NOME']);
            $MA_DESCRICAO = $this->ajustAtribute($data[0]['MA_DESCRICAO']);

			if($data) {
				print "<script>
						document.getElementById('MA_NOME').value = '".$MA_NOME."';
						document.getElementById('MA_DESCRICAO').value = '".$MA_DESCRICAO."';
					  </script>";
			}
		}

	    public function removeSpecials($frase){

	        $search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,ã,Ã,Ç,Á,É,Í,Ó,Ú,À,È,Ì,Ò,Ù,Ä,Ë,Ï,Ö,Ü,Ÿ,Â,Ê,Î,Ô,Û,Å,E,I,Ø,U");
	        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,A,C,A,E,I,O,U,A,E,I,O,U,A,E,I,O,U,Y,A,E,I,O,U,A,E,I,O,U,A");

	        $frase = str_replace($search, $replace, $frase);

	        return $frase;
	    }

	}

?>
