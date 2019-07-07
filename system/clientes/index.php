<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="right_col" style="margin-left: 20px" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Lista de Clientes</h3>
      </div>

    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <button onclick="fn.viewCdCliente()" type="button" class="btn btn-primary" style="float: right;">Incluir novo cadastro</button>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <button onclick="fnCC.pesquisaClientes(-1)" type="button" class="btn btn-round btn-primary">Todos</button>
          <button onclick="fnCC.pesquisaClientes(1)" type="button" class="btn btn-round btn-success">Ativos</button>
          <button onclick="fnCC.pesquisaClientes(0)" type="button" class="btn btn-round btn-danger">Inativos</button>
        </div>
        <div class="x_panel">
            <table id="datatable-responsive" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
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
              </thead>

              <tfoot>
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
              </tfoot>

              <tbody id="conteudo-table-cliente">

                <?php 
                  // Essa chamada aponta para ServiceCadastros a partir dessa página ('cliente/index.php')
                  require_once('ServiceClientes.class.php');
                  // Aqui cria o objeto Service para pegar os dados retornados do banco
                  $service = new ServiceClientes();
                  $clientes = $service->getDataClientes();
                  foreach ($clientes as $cliente) {
                    $codigo = $service->ajustAtribute($cliente['CL_CODIGO']);
                    $nome = $service->ajustAtribute($cliente['CL_NOME']);
                    $email = $service->ajustAtribute($cliente['CL_EMAIL']);
                    $telefone = $service->mask($service->ajustAtribute($cliente['CL_TELEFONE']), '(##) #####-####');
                    $ativo = $service->ajustAtribute($cliente['CL_ATIVO']);
                    if ($ativo == 1) {
                      $ativo = '<img style="width: 20px; height: 20px;" src="img/ativo.png" data-toggle="tooltip" data-placement="top" title="Ativo!"';
                    } else if ($ativo == 0) {
                      $ativo = '<img style="width: 20px; height: 20px;" src="img/inativo.png" data-toggle="tooltip" data-placement="top" title="Inativo!"';
                    } else {
                      $ativo = '<img style="width: 20px; height: 20px;" src="img/pendente.png" data-toggle="tooltip" data-placement="top" title="pendente!"';
                    }

                    $observacoes = $service->ajustAtribute($cliente['PL_OBSERVACOES']);
                    $inicioVigencia = $service->formatDataDataBR($service->ajustAtribute($cliente['PL_INICIO_VIGENCIA']));
                    $fimVigencia = $service->formatDataDataBR($service->ajustAtribute($cliente['PL_FIM_VIGENCIA']));

                    // Aqui verifica seo cliente está pendente
                    if ($service->comparaDatas($cliente['PL_FIM_VIGENCIA'], date("Y-m-d")) == false) {
                      $service->pedenciaCliente($cliente['CL_CODIGO']);
                      $ativo = '<img style="width: 20px; height: 20px;" src="img/pendente.png" data-toggle="tooltip" data-placement="top" title="Fim da vigência Terminou!"';
                    }

                    print '<tr>';
                        print '<td>'.$codigo.'</td>';
                        print '<td>'.$nome.'</td>';
                        print '<td>'.$email.'</td>';
                        print '<td>'.$telefone.'</td>';
                        print '<td>'.$inicioVigencia .' - '. $fimVigencia.'</td>';
                        print '<td>'.$observacoes.'</td>';
                        print '<td style="text-align: center">'.$ativo.'</td>';
                        print '<td style="text-align: center;">'.'<button onclick="fnCC.viewEditaCliente(\''.$codigo.'\')" class="glyphicon glyphicon glyphicon-pencil btn btn-round" aria-hidden=""></button>'.'</td>';
                        print '<td style="text-align: center;">'.'<button data-toggle="modal" data-target=".dialog-home" onclick="fnCC.viewModalExcluiCliente(\''.$codigo.'\', \''.$nome.'\')" class="glyphicon glyphicon glyphicon-trash btn btn-round" aria-hidden=""></button>'.'</td>';
                        print '<td style="text-align: center;">'.'<button onclick="fnCC.viewModalEnviaEmail(\''.$email.'\')" class="glyphicon glyphicon glyphicon-send btn btn-round" aria-hidden=""></button>'.'</td>';
                        print '<td style="text-align: center;">'.'<button data-toggle="modal" data-target=".dialog-home"  onclick="fnCC.viewCliente('.$codigo.', \''.$nome.'\')"  class="glyphicon glyphicon glyphicon-eye-open btn btn-round" aria-hidden=""></button>'.'</td>';
                        
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