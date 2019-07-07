<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Cadastro de Máquinas</h3>
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
                require_once('ServiceMaquinas.class.php');
                // Aqui cria o objeto Service para pegar os dados retornados do banco
                $service = new ServiceMaquinas();

              ?>

              <div class="item form-group">
                <div class="col-md-7 col-sm-7 col-xs-12 form-group has-feedback">
                  <input class="form-control has-feedback-left" type="text" id="MA_NOME" name="MA_NOME" placeholder="Nome *" maxlength="100" required="required">
                  <span class="fa fa-inbox form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <!-- ********************************** -->
              <div class="item form-group">
                <div class="col-md-7 col-sm-7 col-xs-12 form-group has-feedback">
                  <input class="form-control has-feedback-left" type="email" id="MA_DESCRICAO" name="MA_DESCRICAO" placeholder="Descrição *" maxlength="150" required="required">
                  <span class="fa fa-align-left form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <!-- ****************CONTATO****************** -->

              <div class="form-group">

                <div class="col-md-6 col-md-offset-3">
                  <button onclick="fn.viewLtMaquina()" type="button" class="btn btn-primary">Cancelar</button>

                  <?php 

                    if (isset($_POST['MA_CODIGO_ID'])) {
                          // Se o codigo foi passado, faz uma busca com ele, retornando o array com os dados do cliente
                          $result = $service->getMaquina($_POST['MA_CODIGO_ID'], 'MA_CODIGO');

                          // Se tiver retornado vazio, passa para a função colocar cada dado no seu devido campo
                          if (!empty($result)) {
                            // Aqui coloca cada dado no seu devido lugar
                            $service->setDadosInputs($result);

                            $MA_CODIGO = $result[0]["MA_CODIGO"];
                            print "<button onclick='fnMA.atualizarMaquina(\"{$MA_CODIGO}\")' id='btn-salvar' type='button' class='btn btn-success'>Salvar</button>";
                          } 
                        } else {
                          print '<button onclick="fnMA.gravarMaquina()" id="btn-gravar" type="button" class="btn btn-success">Gravar</button>';
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

