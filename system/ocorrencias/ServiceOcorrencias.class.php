<?php 
	require_once('../../php/controls/Service.class.php');

	class ServiceOcorrencias extends Service {

		//	construtor da classe(Default)
		function __construct() {
		
		}

		public function InsertOcorrencia($dados) {
			$this->openRequisitionDb();
			$db = new DB();
			$sql = "INSERT INTO `ocorrencias`(`OC_MAQUINA`, 
											  `OC_DATA`, 
											  `OC_PROBLEMA`, 
											  `OC_ORDEM_PRODUCAO`, 
											  `OC_INICIO`, 
											  `OC_FIM`, 
											  `OC_STATUS`, 
											  `OC_ACAO`, 
											  `OC_OPERADOR`, 
											  `OC_TEMPO`) 
								 VALUES ("."'".$dados['OC_MAQUINA']."', ".
	                        		       "'".$this->formatDateDataBase($dados['OC_DATA'])."', ".
	                        		       "'".$dados['OC_PROBLEMA']."', ".
	                        		       "'".$dados['OC_ORDEM_PRODUCAO']."', ".
	                        		       "'".$dados['OC_INICIO']."', ".
	                        		       "'".$dados['OC_FIM']."', ".
	                        		       "'".$dados['OC_STATUS']."', ".
	                        		       "'".$dados['OC_ACAO']."', ".
	                        		       "'".$dados['OC_OPERADOR']."', ".
	                        		       "'".$dados['OC_TEMPO']."');";

	        $result = $db->execInsertUpdate($sql);
			return $this->processReturnSqlM($result, "Ocorrencia");

		}

		public function UpdateOcorrencia($OC_CODIGO_ID, $dados) {
			$this->openRequisitionDb();
			$db = new DB();
											// OC_MAQUINA`, 
											//   `OC_DATA`, 
											//   `OC_PROBLEMA`, 
											//   `OC_ORDEM_PRODUCAO`, 
											//   `OC_INICIO`, 
											//   `OC_FIM`, 
											//   `OC_STATUS`, 
											//   `OC_ACAO`, 
											//   `OC_OPERADOR`, 
											//   `OC_TEMPO`
			$sql = "UPDATE ocorrencias
				        SET OC_MAQUINA = "."'".$dados['OC_MAQUINA']."', ".
				           "OC_DATA = "."'".$dados['OC_DATA']."', ".
				           "OC_PROBLEMA = "."'".$dados['OC_PROBLEMA']."', ".
				           "OC_ORDEM_PRODUCAO = "."'".$dados['OC_ORDEM_PRODUCAO']."', ".
				           "OC_INICIO = "."'".$dados['OC_INICIO']."', ".
				           "OC_FIM = "."'".$dados['OC_FIM']."', ".
				           "OC_STATUS = "."'".$dados['OC_STATUS']."', ".
				           "OC_ACAO = "."'".$dados['OC_ACAO']."', ".
				           "OC_OPERADOR = "."'".$dados['OC_OPERADOR']."', ".
				           "OC_TEMPO = "."'".$dados['OC_TEMPO']."' ".
				        " WHERE OC_CODIGO = $OC_CODIGO_ID;";

			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlUpdateM($result, 'Ocorrência');
		}

		// Aqui deleta uma ocorrência pelo código
		public function DeleteOcorrencia($OC_CODIGO_ID) {
			$this->openRequisitionDb();
			$db = new DB();
			
			$sql = "DELETE FROM ocorrencias WHERE OC_CODIGO = $OC_CODIGO_ID";
			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlDeleteM($result, 'Ocorrência');
		}


		// Aqui redireciona para visualização dos registros dos máquinas
		public function redirecionaTableOcorrencias() {
			print "<script> setTimeout(function(){ 
				                fn.viewLtOcorrencias();
				            }, 1000); </script>";
		}

		// Aqui pega uma unica ocorrência pelo código
		public function getOcorrencia($OC_CODIGO) {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT * FROM `ocorrencias` WHERE `OC_CODIGO` = $OC_CODIGO";

			return $db->execSql($sql);
		}

		// Aqui retorna os dados do cliente nos seus devidos campos, para a alteração da ocorrênica
		public function setDadosInputs($data) {
            $OC_MAQUINA = $this->ajustAtribute($data[0]['OC_MAQUINA']);
            $OC_PROBLEMA = $this->ajustAtribute($data[0]['OC_PROBLEMA']);
            $OC_DATA = $this->ajustAtribute($data[0]['OC_DATA']);
            $OC_ORDEM_PRODUCAO = $this->ajustAtribute($data[0]['OC_ORDEM_PRODUCAO']);
            $OC_INICIO = $this->ajustAtribute($data[0]['OC_INICIO']);
            $OC_FIM = $this->ajustAtribute($data[0]['OC_FIM']);
            $OC_STATUS = $this->ajustAtribute($data[0]['OC_STATUS']);
            $OC_ACAO = $this->ajustAtribute($data[0]['OC_ACAO']);
            $OC_OPERADOR = $this->ajustAtribute($data[0]['OC_OPERADOR']);
            $OC_TEMPO = $this->ajustAtribute($data[0]['OC_TEMPO']);

			if($data) {
				print "<script>

						setTimeout(function() {
							document.getElementById('OC_MAQUINA').value = '".$OC_MAQUINA."';
							document.getElementById('OC_PROBLEMA').value = '".$OC_PROBLEMA."';
							document.getElementById('OC_DATA').value = '".$OC_DATA."';
							document.getElementById('OC_ORDEM_PRODUCAO').value = '".$OC_ORDEM_PRODUCAO."';
							document.getElementById('OC_INICIO').value = '".$OC_INICIO."';
							document.getElementById('OC_FIM').value = '".$OC_FIM."';
							document.getElementById('OC_STATUS').value = '".$OC_STATUS."';
							document.getElementById('OC_ACAO').value = '".$OC_ACAO."';
							document.getElementById('OC_OPERADOR').value = '".$OC_OPERADOR."';
							document.getElementById('OC_TEMPO').value = '".$OC_TEMPO."';

							}, 1500);

					  </script>";
			}
		}

	    public function removeSpecials($frase){

	        $search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,ã,Ã,Ç,Á,É,Í,Ó,Ú,À,È,Ì,Ò,Ù,Ä,Ë,Ï,Ö,Ü,Ÿ,Â,Ê,Î,Ô,Û,Å,E,I,Ø,U");
	        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,A,C,A,E,I,O,U,A,E,I,O,U,A,E,I,O,U,Y,A,E,I,O,U,A,E,I,O,U,A");

	        $frase = str_replace($search, $replace, $frase);

	        return $frase;
	    }

	    public function geraOptions($select) {
	    	$html = "";
	    	if ($select == "OC_MAQUINA") {
	    		$data = $this->getDataMaquinas();
	    		$value = "MA_CODIGO";
	    		$name = "MA_NOME";
	    	} else if($select == "OC_PROBLEMA") {
	    		$data = $this->getDataProblemas();
	    		$value = "PR_CODIGO";
	    		$name = "PR_DESCRICAO";
	    	} else if($select == "OC_OPERADOR") {
	    		$data = $this->getFuncionariosFull();
	    		$value = "FU_CODIGO";
	    		$name = "FU_NOME";
	    	} 

	    	if (!empty($data)) {
		    	foreach ($data as $d) {
		    		$html .= "<option value='".$d["$value"]."'>".$d["$name"]."</option>";
		    	}
	    	}

	    	print $html;
	    }

	}

?>
