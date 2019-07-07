<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="right_col" style="margin-left: 20px" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Lista de Ocorrencias</h3>
      </div>

    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <button onclick="fn.viewCdOcorrencias()" type="button" class="btn btn-primary" style="float: right;"><i class="glyphicon glyphicon-plus"></i> Incluir novo cadastro</button>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <button onclick="fnOC.viewEditaOcorrencia()" type="button" class="btn btn-round btn-primary"><i class="glyphicon glyphicon-edit"></i> Editar</button>
          <button onclick="fnOC.viewModalExluiOcorrencia()" type="button" class="btn btn-round btn-danger"><i  class="glyphicon glyphicon-trash"></i> Excluir</button>
        </div>
        <div class="x_panel">
            <table id="datatable-responsive" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Código</th>
                  <th>Máquina</th>
                  <th>Descrição do problema</th>
                  <th>Status</th>
                  <th>Operador</th>
                  <th>Acção</th>
                  
                </tr>
              </thead>

              <!--<tfoot>
                <tr>
                  <th></th>
                  <th>Código</th>
                  <th>Máquina</th>
                  <th>Descrição do problema</th>
                  <th>Status</th>
                  <th>Operador</th>
                  <th></th>
                </tr> 
              </tfoot>
                -->
              <tbody id="conteudo-table-cliente">

                <?php 
                  // Essa chamada aponta para ServiceCadastros a partir dessa página ('cliente/index.php')
                  require_once('ServiceOcorrencias.class.php');
                  // Aqui cria o objeto Service para pegar os dados retornados do banco
                  $service = new ServiceOcorrencias();
                  $ocorrencias = $service->getDataOcorrencias();

                  foreach ($ocorrencias as $ocorrencia) {
                    $codigo = $service->ajustAtribute($ocorrencia['OC_CODIGO']);
                    $maquina = $service->ajustAtribute($ocorrencia['MA_NOME']);
                    $problema = $service->ajustAtribute($ocorrencia['PR_DESCRICAO']);
                    $status = $service->ajustAtribute($ocorrencia['OC_STATUS']);
                    $operador = $service->ajustAtribute($ocorrencia['FU_NOME']);

                    if ($status == 1) {
                      $status = '<img style="width: 20px; height: 20px;" src="img/ativo.png" data-toggle="tooltip" data-placement="top" title="Ativo!"';
                    } else if ($status == 0) {
                      $status = '<img style="width: 20px; height: 20px;" src="img/inativo.png" data-toggle="tooltip" data-placement="top" title="Inativo!"';
                    } else {
                      $status = '<img style="width: 20px; height: 20px;" src="img/pendente.png" data-toggle="tooltip" data-placement="top" title="pendente!"';
                    }

                    // TODO
                    // onclick="fn.initStyleRadio()"
                    print '<tr>';
                      print '<td align="center"><input type="radio" class="flat" name="ocorrencias" id="OC_'.$codigo.'" value="'.$codigo.'" /></td>';
                        print '<td>'.$codigo.'</td>';
                        print '<td>'.$maquina.'</td>';
                        print '<td>'.$problema.'</td>';
                        print '<td style="text-align: center">'.$status.'</td>';
                        print '<td>'.$operador.'</td>';
                        print '<td align="center"><button onclick="fn.viewLtPlanilhas()" type="button" class="btn btn-round"><i class="glyphicon glyphicon-eye-open"></i></button></td>';
                    print '</tr>';
                  }

                ?>
              </tbody>
            </table>

        </div>
      </div>
    </div>
  </div>
</div>
      
<!-- /page content