<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="" style="margin-left: 20px" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Simple</h3>
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
              <th>Maquina</th>
              <th>Descricao do problema</th>
              <th>Status</th>
              <th>Operador</th>
              
            </tr>
          </thead>

          <tfoot>
            <tr>
              <th>Controle</th>
              <th>Data</th>
              <th>Maquina</th>
              <th>Descricao do problema</th>
              <th>Status</th>
              <th>Operador</th>
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
                      print '<td>'.$codigo.'</td>';
                      print '<td>'.$data.'</td>';
                      print '<td>'.$maquina.'</td>';
                      print '<td>'.$problema.'</td>';
                      print '<td style="text-align: center">'.$status.'</td>';
                      print '<td>'.$operador.'</td>';
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