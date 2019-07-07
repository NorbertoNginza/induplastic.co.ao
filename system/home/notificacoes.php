<!-- View content -->
<!-- Título padrão para Cadastros -->
<?php 
  // Essa chamada aponta para ServiceCliente a partir dessa página ('cliente/index.php')
  require_once('ServiceHome.class.php');
  // Aqui cria o objeto Service para pegar os dados retornados do banco
  $service = new ServiceClientes();
  $totalUsersResult = $service->getTotalClientes();
  $totalUsersAtivoResult = $service->getTotalClientesAtivo();
  $totalUsersPendentesResult = $service->getTotalClientesPendentes();
  $totalUsersInativoResult = $service->getTotalClientesInativo();

  $totalUsers = 'NULL'; 
  $totalUsersAtivo = 'NULL'; 
  $totalUsersPendentes = 'NULL'; 
  $totalUsersInativo = 'NULL'; 

  $porcentagemAtivos = "NULL";
  $porcentagemInativos = "NULL";
  
  if ($totalUsersResult) {
    $totalUsers = $totalUsersResult[0]['COUNT(*)'];
  }

  if ($totalUsersResult) {
    $totalUsersAtivo = $totalUsersAtivoResult[0]['COUNT(*)'];
    $porcentagemAtivos = $service->porcentagem_nx($totalUsersAtivo, $totalUsers);
  }

  if ($totalUsersPendentesResult) {
    $totalUsersPendentes = $totalUsersPendentesResult[0]['COUNT(*)'];
    $porcentagemPendentes = $service->porcentagem_nx($totalUsersPendentes, $totalUsers);

  }

  if ($totalUsersResult) {
    $totalUsersInativo = $totalUsersInativoResult[0]['COUNT(*)'];
    $porcentagemInativos = $service->porcentagem_nx($totalUsersInativo, $totalUsers);

  }
?>

<div class="row tile_count">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <a><label onclick="fnHM.closeNotifications()" style="float: right;">x</label></a>
  </div>
  <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top" style="color: #2e6da4;"><i class="fa fa-user"></i> Total Users</span>
    <div class="count"><?php print $totalUsers; ?></div>
    <span class="count_bottom"><i class="green">100% </i> dos users</span>
  </div>

  <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top" style="color: #5cb85c;"><i class="fa fa-user"></i> Clientes ativos</span>
    <div class="count"><?php print $totalUsersAtivo; ?></div>
    <span class="count_bottom"><i class="green"><?php print $porcentagemAtivos."%"; ?> </i> estão ativos</span>
  </div>

  <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top" style="color: #d43f3a;"><i class="fa fa-user"></i> Clientes inativos</span>
    <div class="count"><?php print $totalUsersInativo; ?></div>
    <span class="count_bottom"><i class="green"><?php print $porcentagemInativos."%"; ?> </i> estão inativos</span>
  </div>

  <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top" style="color: #ff4e00;"><i class="fa fa-user"></i> Clientes pendentes</span>
    <div class="count"><?php print $totalUsersPendentes; ?></div>
    <span class="count_bottom"><i class="green"><?php print $porcentagemPendentes."%"; ?> </i> estão pendentes</span>
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
  </style>
  <div class="col-md-12 col-sm-12 col-xs-12 tile_stats_count">
    <div class="list-group">
      <?php $service->geraListUsersPendentesNotifications(); ?>
      
    </div>

    <script type="text/javascript">
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    </script>

  </div>
  
</div>