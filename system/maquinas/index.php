<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="right_col" style="margin-left: 20px" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Lista de Máquinas</h3>
      </div>

    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <button onclick="fn.viewCdMaquinas()" type="button" class="btn btn-primary" style="float: right;"><i class="glyphicon glyphicon-plus"></i> Incluir novo cadastro</button>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <button onclick="fnMA.viewEditaMaquina()" type="button" class="btn btn-round btn-primary"><i class="glyphicon glyphicon-edit"></i> Editar</button>
          <button onclick="fnMA.viewModalExluiMaquina()" type="button" class="btn btn-round btn-danger"><i  class="glyphicon glyphicon-trash"></i> Excluir</button>
        </div>
        <div class="x_panel">
            <table id="datatable-responsive" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Código</th>
                  <th>Nome</th>
                  <th>Descrição</th>
                  <th>Ativo</th>
                  
                </tr>
              </thead>

              <tfoot>
                <tr>
                  <th></th>
                  <th>Código</th>
                  <th>Nome</th>
                  <th>Descrição</th>
                  <th>Ativo</th>

                </tr> 
              </tfoot>

              <tbody id="conteudo-table-cliente">

                <?php 
                  // Essa chamada aponta para ServiceCadastros a partir dessa página ('cliente/index.php')
                  require_once('ServiceMaquinas.class.php');
                  // Aqui cria o objeto Service para pegar os dados retornados do banco
                  $service = new ServiceMaquinas();
                  $maquinas = $service->getDataMaquinas();
                  foreach ($maquinas as $maquina) {
                    $codigo = $service->ajustAtribute($maquina['MA_CODIGO']);
                    $nome = $service->ajustAtribute($maquina['MA_NOME']);
                    $descricao = $service->ajustAtribute($maquina['MA_DESCRICAO']);
                    $ativo = $service->ajustAtribute($maquina['MA_ATIVO']);
                    if ($ativo == 1) {
                      $ativo = '<img style="width: 20px; height: 20px;" src="img/ativo.png" data-toggle="tooltip" data-placement="top" title="Ativo!"';
                    } else if ($ativo == 0) {
                      $ativo = '<img style="width: 20px; height: 20px;" src="img/inativo.png" data-toggle="tooltip" data-placement="top" title="Inativo!"';
                    } else {
                      $ativo = '<img style="width: 20px; height: 20px;" src="img/pendente.png" data-toggle="tooltip" data-placement="top" title="pendente!"';
                    }

                    // TODO
                    // onclick="fn.initStyleRadio()"
                    print '<tr>';
                      print '<td align="center"><input type="radio" class="flat" name="maquinas" id="FU_'.$codigo.'" value="'.$codigo.'" /></td>';
                        print '<td>'.$codigo.'</td>';
                        print '<td>'.$nome.'</td>';
                        print '<td>'.$descricao.'</td>';
                        print '<td style="text-align: center">'.$ativo.'</td>';
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