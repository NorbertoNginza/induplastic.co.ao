<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Cadastro de Cliente</h3>
      </div>

    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">

            <form id="form-cadastro" class="form-horizontal form-label-left" novalidate>

              <?php 
                // Essa chamada aponta para ServiceCliente a partir dessa página ('cliente/index.php')
                require_once('ServiceClientes.class.php');
                // Aqui cria o objeto Service para pegar os dados retornados do banco
                $service = new ServiceClientes();

              ?>

              <!-- <span class="section">Personal Info</span> -->
              <div class="item form-group" style="display: none">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CL_CODIGO">Código <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="CL_CODIGO" class="form-control col-md-7 col-xs-12" name="CL_CODIGO" placeholder="" readonly="true" required="false" type="number" value="0">
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-7 col-sm-7 col-xs-12 form-group has-feedback">
                  <input class="form-control has-feedback-left" type="text" id="CL_NOME" name="CL_NOME" placeholder="Nome *" maxlength="150" required="required" maxlength="100">
                  <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <!-- ********************************** -->
              <div class="item form-group">
                <div class="col-md-7 col-sm-7 col-xs-12 form-group has-feedback">
                  <input class="form-control has-feedback-left" type="email" id="CL_EMAIL" name="CL_EMAIL" placeholder="Email *" maxlength="150" required="required" maxlength="150">
                  <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-7 col-sm-7 col-xs-12 form-group has-feedback">
                  <input type="text" class="form-control has-feedback-left" data-inputmask="'mask' : '(99) 99999-9999'" type="text" id="CL_TELEFONE" name="CL_TELEFONE" placeholder="Telefone *" maxlength="20" required>
                  <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <div class="item form-group">
                <label class="" for="PL_INICIO_VIGENCIA">Início da vigência<span class="required">*</span>
                </label><br>
                <div>
                  <fieldset class="col-md-7 col-sm-7 col-xs-12">
                          <div class="control-group">
                            <div class="controls">
                              <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="PL_INICIO_VIGENCIA" placeholder="First Name" aria-describedby="inputSuccess2Status">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status" class="sr-only">(success)</span>

                                <script type="text/javascript">
                                  $('#PL_INICIO_VIGENCIA').daterangepicker({
                                    singleDatePicker: true,
                                    singleClasses: "picker_3",
                                    locale: {
                                      format: 'DD/MM/YYYY'
                                    }
                                  }, function(start, end, label) {
                                    console.log(start.toISOString(), end.toISOString(), label);
                                  });
                                </script>
                              </div>
                            </div>
                          </div>
                        </fieldset>

                </div>
              </div>

              <div class="item form-group">
                <label class="" for="PL_FIM_VIGENCIA">Fim da vigência<span class="required">*</span>
                </label><br>
                <div>
                  <fieldset class="col-md-7 col-sm-7 col-xs-12">
                          <div class="control-group">
                            <div class="controls">
                              <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                                <input type="text" class="form-control has-feedback-left" id="PL_FIM_VIGENCIA" placeholder="First Name" aria-describedby="inputSuccess2Status">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status" class="sr-only">(success)</span>

                                <script type="text/javascript">
                                  $('#PL_FIM_VIGENCIA').daterangepicker({
                                    singleDatePicker: true,
                                    singleClasses: "picker_4",
                                    locale: {
                                      format: 'DD/MM/YYYY'
                                    }
                                  });
                                </script>
                              </div>
                            </div>
                          </div>
                        </fieldset>

              </div>
                <!-- <div class="col-md-7 col-sm-7 col-xs-12">
                  <select id="CL_VALIDACAO" class="form-control" required>
                    <option value="-1">-- Selecione --</option>
                    <option value="30">30 dias</option>
                    <option value="6">6 meses</option>
                    <option value="1">1 ano</option>
                  </select>
                </div> -->
              </div>

              <div class="item form-group">
                <label class="control-label" for="PL_OBSERVACOES">Observações <span class=""></span>
                </label><br>
                <div class="col-md-7 col-sm-7 col-xs-12">
                  <textarea id="PL_OBSERVACOES" name="PL_OBSERVACOES" class="form-control col-md-7 col-xs-12" maxlength="250"></textarea>
                </div>
              </div>

              <!-- ****************CONTATO****************** -->

              <div class="form-group">

                <div class="col-md-6 col-md-offset-3">
                  <button onclick="fn.viewLtCliente()" type="button" class="btn btn-primary">Cancelar</button>

                  <?php 

                    if (isset($_POST['CL_CODIGO'])) {
                          // Se o codigo foi passado, faz uma busca com ele, retornando o array com os dados do cliente
                          $result = $service->getCliente($_POST['CL_CODIGO'], 'CL_CODIGO');

                          // Se tiver retornado vazio, passa para a função colocar cada dado no seu devido campo
                          if (!empty($result)) {
                            // print_r($result);
                            // Aqui coloca cada dado no seu devido lugar
                            $service->setDadosInputs($result);

                            $cod = $result[0]["CL_CODIGO"];
                            print "<button onclick='fnCC.atualizarCliente(\"{$cod}\")' id='btn-salvar' type='button' class='btn btn-success'>Salvar</button>";
                          } 
                        } else {
                          print '<button onclick="fnCC.gravarCliente()" id="btn-gravar" type="button" class="btn btn-success">Gravar</button>';
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

