<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="" style="margin-left: 20px" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Full</h3>
      </div>

    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <table id="datatable-responsive" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Controle</th>
              <th>Data</th>
              <th>Ordem de produção</th>
              <th>Inicio da ocorrência</th>
              <th>Fim da ocorrência</th>
              <th>Maquina</th>
              <th>Descricao do problema</th>
              <th>Ação tomada</th>
              <th>Status</th>
              <th>Operador</th>
              <th>Tempo gasto(min)</th>
              
            </tr>
          </thead>

          <tfoot>
            <tr>
              <th>Controle</th>
              <th>Data</th>
              <th>Ordem de produção</th>
              <th>Inicio da ocorrência</th>
              <th>Fim da ocorrência</th>
              <th>Maquina</th>
              <th>Descricao do problema</th>
              <th>Ação tomada</th>
              <th>Status</th>
              <th>Operador</th>
              <th>Tempo gasto(min)</th>
            </tr> 
          </tfoot>

          <tbody id="conteudo-table-cliente">

            <?php 
              // Essa chamada aponta para ServicePlanilhas a partir dessa página ('planilhas/view_planilhas/full.php')
              require_once('../ServicePlanilhas.class.php');
              $service = new Service();

              if ($_POST['OC_CODIGO_ID'] != 0) {
                  
              } else {
                $ocorrencias = $service->getDataOcorrencias();
                foreach ($ocorrencias as $ocorrencia) {

                  $codigo = $service->ajustAtribute($ocorrencia['OC_CODIGO']);
                  $data = $service->formatDataDataBR($service->ajustAtribute($ocorrencia['OC_DATA']));
                  $ordemProducao = $service->ajustAtribute($ocorrencia['OC_ORDEM_PRODUCAO']);
                  $inicio = $service->ajustAtribute($ocorrencia['OC_INICIO']);
                  $fim = $service->ajustAtribute($ocorrencia['OC_FIM']);
                  $maquina = $service->ajustAtribute($ocorrencia['MA_NOME'])." (".$service->ajustAtribute($ocorrencia['MA_CODIGO']).")";
                  $acao = $service->ajustAtribute($ocorrencia['OC_ACAO']);
                  $problema = $service->ajustAtribute($ocorrencia['PR_DESCRICAO']);
                  $status = $service->ajustAtribute($ocorrencia['OC_STATUS']);
                  $operador = $service->ajustAtribute($ocorrencia['FU_NOME']);
                  $tempo = $service->ajustAtribute($ocorrencia['OC_TEMPO']);

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
                      print '<td>'.$codigo.'</td>';
                      print '<td>'.$data.'</td>';
                      print '<td>'.$ordemProducao.'</td>';
                      print '<td>'.$inicio.'</td>';
                      print '<td>'.$fim.'</td>';
                      print '<td>'.$maquina.'</td>';
                      print '<td>'.$problema.'</td>';
                      print '<td>'.$acao.'</td>';
                      print '<td style="text-align: center">'.$status.'</td>';
                      print '<td>'.$operador.'</td>';
                      print '<td>'.$tempo.'</td>';
                  print '</tr>';
                }
              }

            ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
      
<!-- /page content