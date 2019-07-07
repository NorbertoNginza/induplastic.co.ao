<?php 
	class Service {

		//	construtor da classe(Default)
		function __construct() {
		
		}

		// Aqui abre uma requisição com as funções do banco de dados
		public function openRequisitionDb() {
			return require_once('DB.class.php');
		}

		// Aqui abre uma requisição com a classe USER
		public function openRequisitionUserClass() {
			return require_once('../../php/class/User.class.php');
		}

		public function soNumero($str) {
	        return preg_replace("/[^0-9]/", "", $str);
	    }

	    public function formatMoedaBr($num) {
	    	return number_format($num, 2, ',', '.'); 
	    }

	    public function formatMoedaDataBase($num) {
	    	return number_format($num, 2, '.', ','); 
	    }

	    public function formatFloat($num) {
	    	return number_format($num, 2, '.', ','); 
	    }

	    public function formatDataDataBR($data) {
	    	return date("d/m/Y", strtotime(str_replace('/','-',$data)));  
	    }

	    public function formatDateDataBase($data) {
	    	return date("Y-m-d", strtotime(str_replace('/','-',$data)));  
	    }

	    // Verifica se o email é válido
	    public function validaemail($email) {
	        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	            return true;
	        } else {
	            return false;
	        }
	    }

	    // Redireciona Usuário
		public function verifySessionUser($sessionUser) {
			// Aqui encontra-se o user->login passado pela SESSION
	        if (!empty($sessionUser)) {
	    		return unserialize($sessionUser); 
	        } else {
	            // Aqui verifica se o usuário está logado. caso não redireciona para a tela de login   
	            return $this->redirecionaIndexLogin();
	        }
		}

		public function redirecionaIndexLogin() {
			return '<script>'.'window.location = "login.php"'.'</script>';
		}

	    // toast desempenha a mesma função javascript para dar alertas ao usuário
	    public function toast($tipo, $titulo, $mensagem) {
			print "<script> 
						var d = {
					    	tipo: '$tipo',
					    	titulo: '$titulo',
					    	mensagem: '$mensagem'
					    }
					    fn.toast(d);
				    </script>"; 
		}

	    // Aqui processa o retorno do sql, primeiro parametro o resultado da consulta sql retornada pela função ExecSQL e o segundo o tipo de dado ao qual foi retornar, somente como resposta para o User. 
    	// Para simplificar o processo as funções abaixo são praticamene iguais com a diferenção de mostrar para o usuário final o texto formatado corretamente, tanto no Marsculino quanto no feminino;
	    public function processReturnSqlM($result, $tipo) {
			if ($result == 1064) {
				$this->toast('error', 'Erro', "Código de erro SQL de erro SQL dinâmico = 1064");
				return false; 
			} else if ($result == -104) {
				$this->toast('error', 'Erro', "Pedido inválido BLR no gerador offset");
				return false; 
			}
			// violation of FOREIGN KEY constraint "FK_FIN_ARDOC_1" on table "FIN_ARDOC" Foreign key references are present for the record Problematic key value is
			else if ($result == -803) {
				$this->toast('error', 'Erro', "$tipo já cadastrado!");
				return false; 
			} else {
				$this->toast('success', 'Sucesso', "$tipo cadastrado com sucesso!");
				return true; 
			}
		}

		public function processReturnSqlUpdateM($result, $tipo) {
			if ($result == 1064) {
				$this->toast('error', 'Erro', "Código de erro SQL de erro SQL dinâmico = 1064");
				return false; 
			} else if ($result == -104) {
				$this->toast('error', 'Erro', "Pedido inválido BLR no gerador offset");
				return false; 
			} else if ($result == -530) {
				$this->toast('error', 'Erro', "$tipo não pode excluído!");
				return false; 
			} else {
				$this->toast('success', 'Sucesso', "$tipo atualizado com sucesso!");
				return true; 
			}
		}

		public function processReturnSqlDeleteM($result, $tipo) {
			// print_r($result);
			if ($result == 1064) {
				$this->toast('error', 'Erro', "Código de erro SQL de erro SQL dinâmico = 1064");
				return false; 
			} else if ($result == -104) {
				$this->toast('error', 'Erro', "Pedido inválido BLR no gerador offset");
				return false; 
			} else if ($result == -803) {
				$this->toast('error', 'Erro', "$tipo já cadastrado!");
				return false; 
			} else if ($result == -530) {
				$this->toast('error', 'Erro', "$tipo não pode excluído!");
				return false; 
			} else {
				$this->toast('success', 'Sucesso', "$tipo excluído com sucesso!");
				return true; 
			}
		}

		// Se o atribulo for NULO seta uma string vazia
		public function ajustAtribute($atribute) {
			if ($atribute == null and $atribute != 0) {
				$atribute = '';
			}
			return $atribute;
		}

		// Formatação para CPF e/ou CNPJ 
		public function formataCpfCnpj($cpfCnpj) {
			if ((float) strlen($cpfCnpj) <= 11) {
				$cpfCnpj = $this->mask($cpfCnpj, '###.###.###-##');
			} else {
				$cpfCnpj = $this->mask($cpfCnpj,'##.###.###/####-##');
			}
	        return $cpfCnpj;
		}

		// Mask- Formatação de strings
		public function mask($val, $mask) {
	        $maskared = '';
	        $k = 0;
	        for($i = 0; $i<=strlen($mask)-1; $i++){
	            if($mask[$i] == '#'){
	               if(isset($val[$k]))
	                   $maskared .= $val[$k++];
	            } else {
	            if(isset($mask[$i]))
	               $maskared .= $mask[$i]; 
	            }
	        }
	        return $maskared;
	    }

	    // Comparação de datas
	    // data => String da data para verificao
	    // today => Data de hoje
	    public function comparaDatas($data, $today) {
	       $data = date("Y-m-d", strtotime($data)); 
		   if($data >= $today){
		    return true;
		   } else {
		   	return false;
		   }
	    }

	    // Retorna um array com os dados das ocorrências
		public function getDataOcorrencias() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT * FROM ocorrencias AS oc LEFT JOIN maquinas AS ma ON(oc.OC_MAQUINA = ma.MA_CODIGO) LEFT JOIN funcionarios AS fu ON(oc.OC_OPERADOR = fu.FU_CODIGO) LEFT JOIN problemas AS pr ON(oc.OC_PROBLEMA = pr.PR_CODIGO) WHERE 1";

			return $db->execSql($sql);
		}

	    // Retorn um array com os dados das máquinas
		public function getDataMaquinas() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT * FROM `maquinas`  
							ORDER BY MA_CODIGO ASC";

			return $db->execSql($sql);
		}

		// Retorn um array com os dados dos problemas
		public function getDataProblemas() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT * FROM `problemas`  
							ORDER BY PR_DESCRICAO DESC";

			return $db->execSql($sql);
		}

		// Retorn um array com os dados dos Operador
		public function getDataOperador() {
	    	$this->openRequisitionDb();
	    	$db = new Db();

	    	$sql = "SELECT * FROM operador";
	    	$result = $db->execSql($sql);

	    	return $result;
	    }

	    public function getFuncionariosFull() {
	    	// Retorn um array com os dados dos clientes
			$this->openRequisitionDb();
	    	$db = new Db();
			
			$sql = "SELECT * FROM `funcionarios` AS fu 
								JOIN operador AS op ON(FU_TIPO = OP_CODIGO)
							ORDER BY FU_CODIGO ASC";
			return $db->execSql($sql);
	    }

	    // Basicamente para esse sistema, pega somente os usuários pendentes e imprime para o user
	    public function getNotificatios() {
	    	$this->openRequisitionDb();

	    	$db = new Db();

	    	$sql = "SELECT COUNT(*) FROM `clientes` WHERE CL_ATIVO = 2";
			return $db->execSql($sql);
	    }

	}
?>
