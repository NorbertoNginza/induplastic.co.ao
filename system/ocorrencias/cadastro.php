<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Cadastro de Ocorrencias</h3>
      </div>

    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">

            <form id="form-cadastro" class="form-label-left" novalidate>

              <?php 
                // Essa chamada aponta para ServiceOcorrencias a partir dessa página ('ocorrencia/index.php')
                require_once('ServiceOcorrencias.class.php');
                // Aqui cria o objeto Service para pegar os dados retornados do banco
                $service = new ServiceOcorrencias();

              ?>

              <div class="item form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label style="width: 100%">Maquina *</label><br>
                  <select id="OC_MAQUINA" class="form-control" required>
                  </select>

                  <script type="text/javascript">
                    // Flag passada para gerar as options do SELECT da maquina
                    fnOC.initSelect("OC_MAQUINA");
                  </script>

                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label style="width: 100%">Problema *<button style="float: right; margin-top: -20px;" onclick="fnOC.viewAddProblema()" type="button" class="btn btn-round btn-info"><i class="glyphicon glyphicon-plus"></i></button></label>
                  <select id="OC_PROBLEMA" class="form-control" required>
                  </select>

                  <script type="text/javascript">
                    // Flag passada para gerar as options do SELECT do problema
                    fnOC.initSelect("OC_PROBLEMA");
                  </script>

                </div>
              </div>

              <div class="item form-group">
                  <fieldset class="col-md-6 col-sm-6 col-xs-12">
                    <label class="" for="OC_DATA">Data<span class="required">*</span>
                    </label>
                    <div class="control-group">
                      <div class="controls">
                        <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                          <input style="width: 100%;" type="text" class="form-control has-feedback-left" id="OC_DATA" placeholder="First Name" aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                          <span id="inputSuccess2Status" class="sr-only">(success)</span>

                          <script type="text/javascript">
                            $('#OC_DATA').daterangepicker({
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

                  <style type="text/css">
                    .xdisplay_inputx {
                      width: 100%;
                    }
                  </style>
              </div>

              <!-- ********************************** -->
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label style="width: 100%">Ordem de producao *</label><br>
                  
                  <input class="form-control has-feedback-left" type="number" id="OC_ORDEM_PRODUCAO" name="OC_ORDEM_PRODUCAO" placeholder="Ordem de produção " maxlength="100" required="required">
                  <span class="fa fa-th-list form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label style="width: 100%">Inicio *</label><br>
                  
                  <input onchange="fnOC.calcTime()" class="form-control has-feedback-left" type="time" id="OC_INICIO" name="OC_INICIO" placeholder="Inicio " required="required">
                  <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label style="width: 100%">Fim *</label><br>
                  
                  <input  onchange="fnOC.calcTime()" class="form-control has-feedback-left" type="time" id="OC_FIM" name="OC_FIM" placeholder="Fim " required="required">
                  <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label style="width: 100%">Status *</label>
                  <select id="OC_STATUS" class="form-control" required>
                    <option value="1">OK</option>
                    <option value="0">NOK</option>
                  </select>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label style="width: 100%">Acao tomada *</label>
                  <input class="form-control has-feedback-left" type="text" id="OC_ACAO" name="OC_ACAO" placeholder="Ação" required="required">
                  <span class="fa fa-cog form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label style="width: 100%">Operador *</label><br>
                  <select id="OC_OPERADOR" class="form-control" required>
                  </select>

                  <script type="text/javascript">
                    // Flag passada para gerar as options do SELECT da maquina
                    fnOC.initSelect("OC_OPERADOR");
                  </script>
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                  <label style="width: 100%">Tempo <small>(<font color="red">minutos</font>)</small></label><br>
                  
                  <input disabled class="form-control has-feedback-left" type="text" id="OC_TEMPO" name="OC_TEMPO" value="0" placeholder="Tempo" required="required">
                  <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                </div>
              </div>
              
              <div class="form-group">

                <div class="col-md-12 col-md-offset-3">
                  <button onclick="fn.viewLtOcorrencias()" type="button" class="btn btn-primary">Cancelar</button>

                  <?php 

                    if (isset($_POST['OC_CODIGO_ID'])) {
                          // Se o codigo foi passado, faz uma busca com ele, retornando o array com os dados do cliente
                          $result = $service->getOcorrencia($_POST['OC_CODIGO_ID'], 'OC_CODIGO');

                          // Se tiver retornado vazio, passa para a função colocar cada dado no seu devido campo
                          if (!empty($result)) {
                            // Aqui coloca cada dado no seu devido lugar
                            $service->setDadosInputs($result);

                            $OC_CODIGO_ID = $result[0]["OC_CODIGO"];
                            print "<button onclick='fnOC.atualizarOcorrencia(\"{$OC_CODIGO_ID}\")' id='btn-salvar' type='button' class='btn btn-success'>Salvar</button>";
                          } 
                        } else {
                          print '<button onclick="fnOC.gravarOcorrencia()" id="btn-gravar" type="button" class="btn btn-success">Gravar</button>';
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

