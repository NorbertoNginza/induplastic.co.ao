<!-- View content -->
<!-- Título padrão para Cadastros -->
<div class="right_col" style="margin-left: 20px" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Planilhas</h3>
      </div>

    </div>

    <div class="clearfix"></div>

    <?php 
      // Essa chamada aponta para ServiceCadastros a partir dessa página ('cliente/index.php')
      require_once('ServicePlanilhas.class.php');
      // Aqui cria o objeto Service para pegar os dados retornados do banco
      $service = new ServicePlanilhas();
      $ocorrencias = $service->getDataOcorrencias(); 

      $totalOcorrências = $service->totalOcorrências()[0]['total'];
    ?>

    <div class="row tile_count">
      <!-- <div class="col-md-12 col-sm-12 col-xs-12">
        <a><label onclick="fnHM.closeNotifications()" style="float: right;">x</label></a>
      </div> -->

      <div onclick="fnPL.viewPlanilhas('full', 0)" class="col-md-6 col-sm-6 col-xs-6 tile_stats_count pointer">
        <span class="count_top" style="color: #2e6da4;"><i class="fa fa-cog"></i> Relatório FULL</span>
        <div class="count"><?= $totalOcorrências; ?> ocorrências</div>
        <span class="count_bottom"><i class="green">100% </i> das ocorrências</span>
      </div>

      <div onclick="fnPL.viewPlanilhas('simple', 0)" class="col-md-6 col-sm-6 col-xs-6 tile_stats_count pointer">
        <span class="count_top" style="color: #2e6da4;"><i class="fa fa-cog"></i> Relatório SIMPLE</span>
        <div class="count"><?= $totalOcorrências; ?> ocorrências</div>
        <span class="count_bottom"><i class="green">100% </i> das ocorrências</span>
      </div>

      <div onclick="fnPL.viewPlanilhas('controleXR', 0)" class="col-md-6 col-sm-6 col-xs-6 tile_stats_count pointer">
        <span class="count_top" style="color: #2e6da4;"><i class="fa fa-cog"></i> Controle X R</span>
        <div class="count"><?= $totalOcorrências; ?> ocorrências</div>
        <span class="count_bottom"><i class="green">100% </i> das ocorrências</span>
      </div>

      <style type="text/css">
        ul.list-group:after {
          clear: both;
          display: block;
          content: "";
        }

        .list-group-item {
            float: left;
        }
        .pointer {
          cursor: pointer;
        }
      </style>
      
      <script type="text/javascript">
          $(function () {
            $('[data-toggle="tooltip"]').tooltip()
          })

          fnPL.viewPlanilhas('controleXR', 0);
      </script>

    </div>

  </div>
</div>
      
<!-- /page content