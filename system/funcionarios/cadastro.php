<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Cadastro de Funcionário</h3>
      </div>

    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">

            <form id="form-cadastro" class="form-horizontal form-label-left" novalidate>

              <?php 
                // Essa chamada aponta para ServiceFuncionarios a partir dessa página ('cliente/index.php')
                require_once('ServiceFuncionarios.class.php');
                // Aqui cria o objeto Service para pegar os dados retornados do banco
                $service = new ServiceFuncionarios();

              ?>

              <div class="item form-group">
                <div class="col-md-7 col-sm-7 col-xs-12 form-group has-feedback">
                  <input class="form-control has-feedback-left" type="text" id="FU_NOME" name="FU_NOME" placeholder="Nome *" maxlength="100" required="required">
                  <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <!-- ********************************** -->
              <div class="item form-group">
                <div class="col-md-7 col-sm-7 col-xs-12 form-group has-feedback">
                  <input class="form-control has-feedback-left" type="email" id="FU_EMAIL" name="FU_EMAIL" placeholder="Email *" maxlength="100" required="required">
                  <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <div id="div_FU_SENHA" class="item form-group">
                <div class="col-md-7 col-sm-7 col-xs-12 form-group has-feedback">
                  <input type="text" class="form-control has-feedback-left"  type="text" id="FU_SENHA" name="FU_SENHA" placeholder="Senha *" required>
                  <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-7 col-sm-7 col-xs-12 form-group has-feedback">
                  <label style="width: 100%">Operador <button style="float: right;" onclick="fnFN.viewAddOperador()" type="button" class="btn btn-round btn-info"><i class="glyphicon glyphicon-plus"></i></button></label>
                  <select id="FU_TIPO" class="form-control" required>
                  </select>

                  <script type="text/javascript">
                    fnFN.initSelectOperador();
                  </script>
                </div>
              </div>

              <!-- ****************CONTATO****************** -->

              <div class="form-group">

                <div class="col-md-6 col-md-offset-3">
                  <button onclick="fn.viewLtFuncionario()" type="button" class="btn btn-primary">Cancelar</button>

                  <?php 

                    if (isset($_POST['FU_CODIGO_ID'])) {
                          // Se o codigo foi passado, faz uma busca com ele, retornando o array com os dados do cliente
                          $result = $service->getFuncionario($_POST['FU_CODIGO_ID'], 'FU_CODIGO');

                          // Se tiver retornado vazio, passa para a função colocar cada dado no seu devido campo
                          if (!empty($result)) {
                            // print_r($result);
                            // Aqui coloca cada dado no seu devido lugar
                            $service->setDadosInputs($result);

                            $FU_CODIGO = $result[0]["FU_CODIGO"];
                            print "<button onclick='fnFN.atualizarFuncionario(\"{$FU_CODIGO}\")' id='btn-salvar' type='button' class='btn btn-success'>Salvar</button>";
                          } 
                        } else {
                          print '<button onclick="fnFN.gravarFuncionario()" id="btn-gravar" type="button" class="btn btn-success">Gravar</button>';
                        }
                  ?>
                  
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  </div>
</div>

