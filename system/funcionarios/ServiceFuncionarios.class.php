<?php 
	require_once('../../php/controls/Service.class.php');

	class ServiceFuncionarios extends Service {

		//	construtor da classe(Default)
		function __construct() {
		
		}

		public function InsertFuncionario($dados) {
			$this->openRequisitionDb();
			$db = new DB();
			$sql = "INSERT INTO funcionarios(`FU_NOME`, 
											 `FU_EMAIL`, 
											 `FU_SENHA`, 
											 `FU_TIPO`, 
											 `FU_ATIVO`, 
											 `FU_ADMINISTRADOR`)
									VALUES ("."'".$dados['FU_NOME']."', ".
	                        				"'".$dados['FU_EMAIL']."', ".
	                        				"md5('".$dados['FU_SENHA']."'), ".
	                        				"'".$dados['FU_TIPO']."', ".
	                        				"1,".
	                       					"0);";

	        $result = $db->execInsertUpdate($sql);
			
			return $this->processReturnSqlM($result, "Funcionário");

		}

		public function UpdateFuncionario($FU_CODIGO_ID, $dados) {
			$this->openRequisitionDb();
			$db = new DB();

			$sql = "UPDATE funcionarios
				        SET FU_NOME = "."'".$dados['FU_NOME']."', ".
				            "FU_EMAIL = "."'".$dados['FU_EMAIL']."', ".
				            "FU_TIPO = "."'".$dados['FU_TIPO']."'".
				        " WHERE FU_CODIGO = $FU_CODIGO_ID;";

			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlUpdateM($result, 'Funcionário');
		}

		// Aqui deleta um cliente pelo código
		public function DeleteFuncionario($cod) {
			$this->openRequisitionDb();
			$db = new DB();
			
			$sql = "DELETE FROM clientes WHERE CL_CODIGO = $cod";
			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlDeleteM($result, 'Cliente');
		}

		// Aqui redireciona para visualização dos registros dos clientes
		public function redirecionaTableFuncionarios() {
			print "<script> setTimeout(function(){ 
				                fn.viewLtFuncionario();
				            }, 1000); </script>";
		}

		// Retorn um array com os dados dos clientes
		public function getDataFuncionarios() {
			session_start();
			$this->openRequisitionDb();
			$this->openRequisitionUserClass();

			$db = new Db();

			$FU_CODIGO = unserialize($_SESSION['user'])->getCodigo();

			$sql = "SELECT * FROM `funcionarios` AS fu 
								JOIN operador AS op ON(FU_TIPO = OP_CODIGO)
							WHERE FU_CODIGO != $FU_CODIGO 
							ORDER BY FU_CODIGO ASC";
			return $db->execSql($sql);
		}

		// Aqui pega um unico funcionário pelo código
		public function getFuncionario($FU_CODIGO) {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT * FROM `funcionarios` WHERE `FU_CODIGO` = $FU_CODIGO";

			return $db->execSql($sql);
		}

		// Aqui retorna uma consulta de um cliente em especifico procurando por 
		// CL_CODIGO  
		// Poderá ser utilizado com outros atributos também
		public function getCliente($pesquisa, $atr) {
	    	$this->openRequisitionDb();
	    	$db = new Db();

			$sql = "SELECT * FROM clientes join plano ON (CL_CODIGO = PL_CODIGO) ";
			if ($atr == 'CL_CODIGO') {
				$sql.= "WHERE CL_CODIGO = $pesquisa";
			} 
			return $db->execSql($sql);	
		}

		// Aqui retorna os dados do cliente nos seus devidos campos, para a alteração do User
		public function setDadosInputs($data) {
            $FU_NOME = $this->ajustAtribute($data[0]['FU_NOME']);
            $FU_SENHA = $this->ajustAtribute($data[0]['FU_SENHA']);
            $FU_EMAIL = $this->ajustAtribute($data[0]['FU_EMAIL']);
            $FU_TIPO = $this->soNumero($this->ajustAtribute($data[0]['FU_TIPO']));

			if($data) {
				print "<script>
						document.getElementById('FU_NOME').value = '".$FU_NOME."';
						document.getElementById('FU_EMAIL').value = '".$FU_EMAIL."';
						document.getElementById('FU_TIPO').value = '".$FU_TIPO."';

						$('#div_FU_SENHA').html('');
					  </script>";
			}
		}

		public function geraTabelaClientesComPesquisa($t) {
			$this->openRequisitionDb();
	    	$db = new Db();

			$sql = "SELECT * FROM clientes join plano ON (CL_CODIGO = PL_CODIGO) ";
			if ($t != -1) {
				$sql .= "WHERE CL_ATIVO = $t";
	    	}

			$clientes = $db->execSql($sql);	
			print $this->geraTabelaClientes($clientes);
		}

		// Aqui gera a tabela completa com os dados dos clients
		public function geraTabelaClientes($clientes) {
			$html = $this->geraHeaderTableClientes();
			$html .= $this->geraConteudoTableClintes($clientes);
			$html .= $this->geraFooterTableClientes();

			return $html;
		}

		public function geraHeaderTableClientes() {
			$html = '<table id="datatable-responsive" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
		              <thead>
		                <tr>
		                  <th>Código</th>
		                  <th>Nome</th>
		                  <th>Email</th>
		                  <th>Telefone</th>
		                  <th>Vigência</th>
		                  <th>Obs</th>
		                  <th>Ativo</th>
		                  <th></th>
		                  <th></th>
		                  <th></th>
		                  <th></th>
		                  
		                </tr>
		              </thead>';

		    return $html;
		}

		public function geraFooterTableClientes() {
			$html = '<tfoot>
		                <tr>
		                  <th>Código</th>
		                  <th>Nome</th>
		                  <th>Email</th>
		                  <th>Telefone</th>
		                  <th>Vigência</th>
		                  <th>Obs</th>
		                  <th>Ativo</th>
		                  <th></th>
		                  <th></th>
		                  <th></th>
		                  <th></th>

		                </tr> 
		              </tfoot></table>';
		              
		    return $html;
		}

		public function geraConteudoTableClintes($clientes) {
			$html = "";

			foreach ($clientes as $cliente) {
	            $codigo = $this->ajustAtribute($cliente['CL_CODIGO']);
                $nome = $this->ajustAtribute($cliente['CL_NOME']);
                $email = $this->ajustAtribute($cliente['CL_EMAIL']);
                $telefone = $this->mask($this->ajustAtribute($cliente['CL_TELEFONE']), '(##) #####-####');
                $ativo = $this->ajustAtribute($cliente['CL_ATIVO']);
                if ($ativo == 1) {
                  $ativo = '<img style="width: 20px; height: 20px;" src="img/ativo.png" data-toggle="tooltip" data-placement="top" title="Ativo!"';
                } else {
                  $ativo = '<img style="width: 20px; height: 20px;" src="img/inativo.png" data-toggle="tooltip" data-placement="top" title="Inativo!"';
                }
                $observacoes = $this->ajustAtribute($cliente['PL_OBSERVACOES']);
                $inicioVigencia = $this->formatDataDataBR($this->ajustAtribute($cliente['PL_INICIO_VIGENCIA']));
                $fimVigencia = $this->formatDataDataBR($this->ajustAtribute($cliente['PL_FIM_VIGENCIA']));

                // Aqui verifica seo cliente está pendente
                if ($this->comparaDatas($cliente['PL_FIM_VIGENCIA'], date("Y-m-d")) == false) {
                  $ativo = '<img style="width: 20px; height: 20px;" src="img/pendente.png" data-toggle="tooltip" data-placement="top" title="Fim da vigência Terminou!"';
                }

	            $html .= '<tr>';
				$html .= '<td>'.$codigo.'</td>';
	                $html .= '<td>'.$nome.'</td>';
	                $html .= '<td>'.$email.'</td>';
	                $html .= '<td>'.$telefone.'</td>';
	                $html .= '<td>'.$inicioVigencia .' - '. $fimVigencia.'</td>';
	                $html .= '<td style="text-align: center">'.$ativo.'</td>';
	                $html .= '<td>'.$observacoes.'</td>';
	                $html .= '<td style="text-align: center;">'.'<button onclick="fnCC.viewEditaCliente(\''.$codigo.'\')" class="glyphicon glyphicon glyphicon-pencil btn btn-round" aria-hidden=""></button>'.'</td>';
	                $html .= '<td style="text-align: center;">'.'<button data-toggle="modal" data-target=".dialog-home" onclick="fnCC.viewModalExcluiCliente(\''.$codigo.'\', \''.$nome.'\')" class="glyphicon glyphicon glyphicon-trash btn btn-round" aria-hidden=""></button>'.'</td>';
                    $html .= '<td style="text-align: center;">'.'<button onclick="fnCC.viewModalEnviaEmail(\''.$codigo.'\', \''.$nome.'\')" class="glyphicon glyphicon glyphicon-send btn btn-round" aria-hidden=""></button>'.'</td>';
                    $html .= '<td style="text-align: center;">'.'<button data-toggle="modal" data-target=".dialog-home"  onclick="fnCC.viewCliente('.$codigo.', \''.$nome.'\')"  class="glyphicon glyphicon glyphicon-eye-open btn btn-round" aria-hidden=""></button>'.'</td>';
	                
	            $html .= '</tr>';
	        }

	        return $html;
		}

		// Aqui gera a interface da lista de clientes referente a seleção para envio dos lembretes
		public function geraListClientes() {
			$clientes = $this->getDataClientes();
			$html = '<ul style="margin-left: 25px;" class="nav">';
			foreach ($clientes as $cliente) {
				$html .= "<li>
							<div class='checkbox'>
		                        <label onclick='fnCC.selecionaClienteEmailSend(\"".$cliente['CL_EMAIL']."\", \"check-".$cliente['CL_CODIGO']."\")' style='font-size: 22px;'>    
		                          <input id='check-".$cliente['CL_CODIGO']."' name='options-acesso-menu' class='flat check' type='checkbox' value='". $cliente['CL_CODIGO']."'> ".$cliente['CL_NOME']."
		                        </label>
		                    </div>

		                 </li>";
			}

			$html .= "</ul>";
			
			print $html;
		}

		// Aqui gera uma tabela de um cliente apenas, podendo fazer possíveis açterações
		public function geraTabelaCliente($codigo) {
			$clientes = $this->getCliente($codigo, 'CL_CODIGO');
			$html = $this->geraHeaderButtons($codigo);
			$html .= $this->geraHeaderTableMinCliente();
			$html .= $this->geraConteudoMinTableClinte($clientes);
			$html .= $this->geraFooterTableMinCliente();

			print $html;
		}

		public function geraHeaderButtons($codigo) {
			$html = '
		    <div class="col-md-12 col-sm-12 col-xs-12">
	          <button onclick="fnCC.alteraStatusCliente('.$codigo.', 1)" type="button" class="btn btn-round btn-success">Ativa</button>
	          <button onclick="fnCC.alteraStatusCliente('.$codigo.', 0)" type="button" class="btn btn-round btn-danger">Inativa</button>
        	</div>';

        	return $html;
		}

		public function geraConteudoMinTableClinte($clientes) {
			$html = "<tbody>";

			foreach ($clientes as $cliente) {
	            $codigo = $this->ajustAtribute($cliente['CL_CODIGO']);
                $nome = $this->ajustAtribute($cliente['CL_NOME']);
                $email = $this->ajustAtribute($cliente['CL_EMAIL']);
                $telefone = $this->mask($this->ajustAtribute($cliente['CL_TELEFONE']), '(##) #####-####');
                $observacoes = $this->ajustAtribute($cliente['PL_OBSERVACOES']);
                $inicioVigencia = $this->formatDataDataBR($this->ajustAtribute($cliente['PL_INICIO_VIGENCIA']));
                $fimVigencia = $this->formatDataDataBR($this->ajustAtribute($cliente['PL_FIM_VIGENCIA']));

	            $html .= '<tr>';
	                $html .= '<td>'.$nome.'</td>';
	                $html .= '<td>'.$email.'</td>';
	                $html .= '<td>'.$telefone.'</td>';
	                $html .= '<td>'.$inicioVigencia .' - '. $fimVigencia.'</td>';
	                $html .= '<td>'.$observacoes.'</td>';
                    $html .= '<td style="text-align: center;">'.'<button onclick="fnCC.viewModalEnviaEmail(\''.$email.'\')" class="glyphicon glyphicon glyphicon-send btn btn-round" aria-hidden=""></button>'.'</td>';

	                
	            $html .= '</tr>';
	        }
	        $html .= '</tbody>';
	        $html .= '</table>';
	        $html .= $this->geraScriptTableResponsiveMin();

	        return $html;
		}

		private function geraScriptTableResponsiveMin() {
			$html = '<script>
						$("#datatable-responsive-min").DataTable({
					        "language": {
					            "sEmptyTable": "Nenhum registro encontrado",
					            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
					            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
					            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
					            "sInfoPostFix": "",
					            "sInfoThousands": ".",
					            "sLengthMenu": "_MENU_ resultados por página",
					            "sLoadingRecords": "Carregando...",
					            "sProcessing": "Processando...",
					            "sZeroRecords": "Nenhum registro encontrado",
					            "sSearch": "Pesquisar",
					            "oPaginate": {
					                "sNext": "Próximo",
					                "sPrevious": "Anterior",
					                "sFirst": "Primeiro",
					                "sLast": "Último"
					            },
					            "oAria": {
					                "sSortAscending": ": Ordenar colunas de forma ascendente",
					                "sSortDescending": ": Ordenar colunas de forma descendente"
					            }
					        }
					    });
					</script>';
			return $html;
		}

		public function geraHeaderTableMinCliente() {
			$html = '<table id="datatable-responsive-min" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
		              <thead>
		                <tr>
		                  <th>Nome</th>
		                  <th>Email</th>
		                  <th>Telefone</th>
		                  <th>Vigência</th>
		                  <th>Observações</th>
		                  <th></th>
		                  
		                </tr>
		              </thead>';
		    return $html;

		}

		public function geraFooterTableMinCliente() {
			$html = '<tfoot>
		                <tr>
		                  <th>Nome</th>
		                  <th>Email</th>
		                  <th>Telefone</th>
		                  <th>Vigência</th>
		                  <th>Observações</th>
		                  <th></th>
		                  
		                </tr>
		              </tfoot>
		        </table>';

		    return $html;

		}

		// @emails -> Array com os emails a serem enviados
	    // @tituloEmail -> Título a ser exibido na caixa de email
	    // @msgEmail -> Mensagem a ser exibido na caixa de email
	    // @caminhoArquivo -> Caminho do arquivo a ser enviado
	    public function enviaBaixas($emails, $tituloEmail, $msgEmail) {
	        if ($tituloEmail == '') {
	            $titulo = "NO replay";
	        } if ($msgEmail == '') {
	            $msgEmail = "Texto padrão a combinar";
	        } 

	        $mail = new PHPMailer;
	        $mail->CharSet = 'UTF-8';
	        $mail->IsSMTP();        // Ativar SMTP
	        $mail->SMTPDebug = 1;       // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	        $mail->SMTPSecure = 'tls';  // SSL REQUERIDO pelo GMAIL
	        $mail->Host = 'smtp.gmail.com.br'; // SMTP utilizado
	        $mail->Port = 587; 
	        // Maxximusbank@maxximusbank.com.br
	        $mail->Username = 'Jéfter Lucas';
	        $mail->Password = 'luccas8956';
	        $mail->SetFrom('jeftertecinfo@gmail.com', 'JÉFTER LUCAS');
	        $mail->SMTPAuth = true;     // Autenticação ativada
	        foreach ($emails as $email) {
	            $destinatario = trim($email);
	            // echo $destinatario;
	            if ($this->validaemail($destinatario)) {
	                $mail->addAddress($destinatario, '');
	            } 
	            // Dbug
	            // else {

	            //  // print '<script>'.'console.log(\'Esse aqui não foi enviado "'.$destinatario.'"); </script>';
	            // }
	        }
	        // ************************************ // 

	        $mail->Subject=(utf8_decode($this->removeSpecials($tituloEmail)));
	        $mail->msgHTML(utf8_decode($this->removeSpecials($msgEmail)));
	        
	        if(!$mail->send()) {
	            // aqui eh para o debug
	            echo 'Erro: ' . $mail->ErrorInfo;
	            return false;
	        } else {
	            echo "Sucess";
	            return true;
	        }
	    }

	    public function removeSpecials($frase){

	        $search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,ã,Ã,Ç,Á,É,Í,Ó,Ú,À,È,Ì,Ò,Ù,Ä,Ë,Ï,Ö,Ü,Ÿ,Â,Ê,Î,Ô,Û,Å,E,I,Ø,U");
	        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,A,C,A,E,I,O,U,A,E,I,O,U,A,E,I,O,U,Y,A,E,I,O,U,A,E,I,O,U,A");

	        $frase = str_replace($search, $replace, $frase);

	        return $frase;
	    }

	    public function ativaCliente($codigo) {
	    	$this->openRequisitionDb();
			$db = new DB();

			$sql = "UPDATE `clientes` 
						SET `CL_ATIVO` = '1' 
					WHERE `CL_CODIGO` = $codigo;";

			$db->execInsertUpdate($sql);
	    }

	    public function inativaCliente($codigo) {
	    	$this->openRequisitionDb();
			$db = new DB();

			$sql = "UPDATE `clientes` 
						SET `CL_ATIVO` = '0' 
					WHERE `CL_CODIGO` = $codigo;";

			$db->execInsertUpdate($sql);
	    }

	    public function pedenciaCliente($codigo) {
	    	$this->openRequisitionDb();
			$db = new DB();

			$sql = "UPDATE `clientes` 
						SET `CL_ATIVO` = '2' 
					WHERE `CL_CODIGO` = $codigo;";

			$db->execInsertUpdate($sql);
	    }

	    public function InsertOperador($dados) {
	    	$this->openRequisitionDb();
			$db = new DB();

			$sql = "INSERT INTO `operador`(`OP_NOME`, 
										  `OP_FUNCAO`) 
								VALUES ('".$dados['OP_NOME']."', 
										'".$dados['OP_FUNCAO']."')";

			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlM($result, "Tipo de Operador");
	    }

	    public function geraOptionsOperador() {
	    	$html = "";
	    	$operadores = $this->getDataOperador();
	    	foreach ($operadores as $operador) {
	    		$html .= "<option value='".$operador['OP_CODIGO']."'>".$operador['OP_NOME']."</option>";
	    	}

	    	print $html;
	    }

		// View para adicionar tipo de operadores
		public function geraViewOperador() {
			$html = "<div class='row'>";
				$html .= "<div class='form-group'>
				                <div class='col-md-12 col-sm-12 col-xs-12 form-group'>
				                  <label>Nome</label>
				                  <input class='form-control' type='text' id='OP_NOME' name='OP_NOME' placeholder='Nome *' maxlength='100' required='required'>
				                </div>
				              </div>
							  <div class='form-group'> 
				                <div class='col-md-12 col-sm-12 col-xs-12 form-group'>
				                    <label>Função</label>
				                	<input class='form-control' type='text' id='OP_FUNCAO' name='OP_FUNCAO' placeholder='Função *' maxlength='150' required='required'>
				                </div>
				           </div>";
			$html .= "</div>";

			print $html;
		}

	}

?>
