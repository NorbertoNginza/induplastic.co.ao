<?php 
	require_once('../../php/controls/Service.class.php');

	class ServiceClientes extends Service {

		//	construtor da classe(Default)
		function __construct() {
		
		}

		public function InsertCliente($dados) {
			$this->openRequisitionDb();
			$db = new DB();
			$dados = $this->setAjustaDados($dados);

			$sql = "INSERT INTO clientes (CL_NOME,
	                      CL_TELEFONE,
	                      CL_EMAIL)
	                   VALUES("."'".$dados['CL_NOME']."',".
	                        "'".$dados['CL_TELEFONE']."',".
	                        "'".$dados['CL_EMAIL']."');";

			$db->execInsertUpdate($sql);
	        
			$dados['CL_CODIGO'] = $db->execSql("SELECT MAX(`CL_CODIGO`) FROM clientes")[0]['MAX(`CL_CODIGO`)'];

	        $sql = "
	        		INSERT INTO plano (`PL_CODIGO`, `PL_INICIO_VIGENCIA`, `PL_FIM_VIGENCIA`, `PL_OBSERVACOES`) VALUES (".$dados['CL_CODIGO'].", ".
	                        	"'".$dados['PL_INICIO_VIGENCIA']."',".
	                        	"'".$dados['PL_FIM_VIGENCIA']."',".
	                        	"'".$dados['PL_OBSERVACOES']."')";
			
			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlM($result, "Cliente");

		}

		public function UpdateCliente($ID, $dados) {
			$dados = $this->setAjustaDados($dados);

			$this->openRequisitionDb();
			$db = new DB();

			$sql = "UPDATE clientes
				        set CL_NOME = "."'".$dados['CL_NOME']."', ".
				            "CL_TELEFONE = "."'".$dados['CL_TELEFONE']."', ".
				            "CL_EMAIL = "."'".$dados['CL_EMAIL']."'".

				        " WHERE CL_CODIGO = $ID;".
				        "
				    UPDATE plano
						set "."PL_OBSERVACOES = "."'".$dados['PL_OBSERVACOES']."', ".
						"PL_INICIO_VIGENCIA = "."'".$dados['PL_INICIO_VIGENCIA']."', ".
						"PL_FIM_VIGENCIA = "."'".$dados['PL_FIM_VIGENCIA']."'".
						" WHERE PL_CODIGO = $ID;";

			// print $sql;
			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlUpdateM($result, 'Cliente');
		}

		// Aqui deleta um cliente pelo código
		public function DeleteCliente($cod) {
			$this->openRequisitionDb();
			$db = new DB();
			
			$sql = "DELETE FROM clientes WHERE CL_CODIGO = $cod";
			$result = $db->execInsertUpdate($sql);

			return $this->processReturnSqlDeleteM($result, 'Cliente');
		}

		// Aqui seta os campos vazios e ajustas outros dados do array para salvamento no DB, destinado ao Cliente
		private function setAjustaDados($dados) {
			if ($dados['PL_OBSERVACOES'] == null) {
				$dados['PL_OBSERVACOES'] = 'NULL';
			} else {
				$dados['PL_OBSERVACOES'] = $dados['PL_OBSERVACOES'];
			}
			$dados['CL_NOME'] = trim($dados['CL_NOME']);
			$dados['CL_EMAIL'] = trim($dados['CL_EMAIL']);
			$dados['CL_TELEFONE'] = $this->soNumero($dados['CL_TELEFONE']);
			$dados['PL_OBSERVACOES'] = trim($dados['PL_OBSERVACOES']);
			$dados['PL_INICIO_VIGENCIA'] = $this->formatDataDataBase($dados['PL_INICIO_VIGENCIA']);
			$dados['PL_FIM_VIGENCIA'] = $this->formatDataDataBase($dados['PL_FIM_VIGENCIA']);
			return $dados;
		}

		// Aqui redireciona para visualização dos registros dos clientes
		public function redirecionaTableCLientes($view) {
			print "<script> setTimeout(function(){ 
				                fn.viewLtCliente();
				            }, 1000); </script>";
		}

		// Retorn um array com os dados dos clientes
		public function getDataClientes() {
			$this->openRequisitionDb();
			$db = new Db();

			$sql = "SELECT * FROM `clientes` JOIN `plano` ON (CL_CODIGO = PL_CODIGO)
	    				ORDER BY CL_CODIGO DESC";
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
			$codigo = $this->ajustAtribute($data[0]['CL_CODIGO']);
            $nome = $this->ajustAtribute($data[0]['CL_NOME']);
            $email = $this->ajustAtribute($data[0]['CL_EMAIL']);
            $telefone = $this->soNumero($this->ajustAtribute($data[0]['CL_TELEFONE']));

            $inicioVigencia = $this->ajustAtribute($this->formatDataDataBR($data[0]['PL_INICIO_VIGENCIA']));
            $fimVigencia = $this->ajustAtribute($this->formatDataDataBR($data[0]['PL_FIM_VIGENCIA']));

            $ativo = $this->ajustAtribute($data[0]['CL_ATIVO']);
            $observacoes = $this->ajustAtribute($data[0]['PL_OBSERVACOES']);
			if($data) {
				print "<script>
						document.getElementById('CL_CODIGO').value = '".$codigo."';
						document.getElementById('CL_NOME').value = '".$nome."';
						document.getElementById('CL_EMAIL').value = '".$email."';
						document.getElementById('CL_TELEFONE').value = '".$telefone."';
						document.getElementById('PL_INICIO_VIGENCIA').value = '".$inicioVigencia."';
						document.getElementById('PL_FIM_VIGENCIA').value = '".$fimVigencia."';
						document.getElementById('PL_OBSERVACOES').value = '".$observacoes."';
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

	}
?>
