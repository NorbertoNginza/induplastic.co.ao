<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>

	  <link rel="icon" href="production/images/favicon.ico" type="image/ico" />

    <title>Fábrica </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/blue.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <!-- *************** Scripts das páginas e sub páginas *************** -->
   
  </head>

  <?php 
    session_start();

    require_once('php/controls/Service.class.php');
    require_once('php/class/User.class.php');
    $service = new Service();

    // print_r($_SESSION);
    // Retorna o usuário caso esteja logado
    if (isset($_SESSION['user'])) {
      $service->verifySessionUser($_SESSION['user'])->getLogin();
    } else {
      print_r($_SESSION['user']);
      print $service->redirecionaIndexLogin();
    } 

  ?>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span>Fabrica</span></a>
            </div>

            <div class="clearfix"></div>

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                  <ul class="nav side-menu">
                  <li onclick="window.location = 'index.php'"><a><i class="fa fa-home"></i> Home</a>
                                      </li>
                  <li><a><i class="fa fa-edit"></i> Cadastros <span class="fa fa-chevron-down"></a>
                    <ul class="nav child_menu">
                      <li onclick="fn.viewLtFuncionario()"><a>Funcionários</a></li>
                      <li onclick="fn.viewLtMaquina()"><a>Máquinas</a></li>
                      <li onclick="fn.viewLtOcorrencias()"><a>Ocorrencias</a></li>
                      <li onclick="fn.viewLtProblemas()"><a>Problemas / Falhas</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-th-list"></i> Relatórios <span class="fa fa-chevron-down"></a>
                    <ul class="nav child_menu">
                      <li onclick="fn.viewLtPlanilhas()"><a>Planilhas</a></li>
                      <li onclick="fn.viewLtGraficos()"><a>Gráficos</a></li> 
                    </ul>
                  </li>
                  <!-- <li onclick="fn.viewNotificacoes()"><a><i class="fa fa-bullhorn"></i> Notificações 
                    <span class="badge bg-red">
                      <?php $result = $service->getNotificatios();
                            if($result) {
                              print $result[0]['COUNT(*)'];
                            }
                      ?>
                        
                    </span>
                  </a>
                    <ul class="nav child_menu">
                      <li><a href="tables.html">Fecebook</a></li>
                      <li><a href="tables_dynamic.html">Instagram</a></li>
                    </ul> 
                  </li> -->
                </ul>
              </div>
             <!--  <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                                 
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div> -->

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a onclick="toogleFullScreen()" data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a onclick="fnLogOut.logOut()" data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li onclick="fnLogOut.logOut()"><a><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div style="display: none;" id="conteudo-noty" class="x-content">
            
          </div>
          <div id="conteudo-page" class="x_content">
            <!-- Título padrão para Cadastros -->
            <div class="right_col" style="margin-left: 20px" role="main">
              <div class="">
                <div class="page-title">
                  <div class="title_left">
                    <h3>Seja Bem-Vindo.</h3> 
                  </div>
                </div>

                <h4>Selecione um item de menu para continuar navegando</h3>

                <div class="clearfix"></div>
              </div>
            </div>
          </div>

          </div>
        </div>

        <div id="conteudo-dialogs">
          <!-- Small modal -->
          <div class="modal fade dialog-home" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 id="titulo-dialog" class="modal-title">teste</h4>
                </div>
                <div id="conteudo-dialog" class="modal-body">
                </div>
                <div id="footer-dialog" class="modal-footer">
                </div>

              </div>
            </div>
          </div>

          <!-- Large modal -->
          <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button> -->

          <div id="dialog-large-home" class="modal fade dialog-large-home" style="max-height: 90%;" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 id="titulo-dialog-large" class="modal-title"></h4>
                </div>
                
                <div id="conteudo-dialog-large" class="modal-body">
                 
                </div>
                
                <div id="footer-dialog-large" class="modal-footer">
                  
                </div>

              </div>
            </div>
          </div>

          <style type="text/css">
            .full {
              width: 100%;
              height: 100%;
              background: white;
              padding: 5%;
            }

            .close-dialog {
              float: right;
              font-size: 26px;
            }
          </style>

          <script type="text/javascript">
            
            function toogleFullScreen(classe) {
              $("."+classe).show();
              // var elem = document.getElementById(classe);
              var elem = $("."+classe);
              if (elem.requestFullscreen) {
                elem.requestFullscreen();
              } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
              } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
              } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
              } 
            }

            function toogleExitFullScreen(id) {
              $("#"+id).hide();
              var elem = document.getElementById(id);
                if (document.exitFullscreen) {
                  document.exitFullscreen();
                } else if (document.msExitFullscreen) {
                  document.msExitFullscreen();
                } else if (document.mozCancelFullScreen) {
                  document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                  document.webkitExitFullscreen();
                }
            }
          </script>

          <?php 
            require_once('system/home/modal.php');
          ?>
        </div>


        <!-- footer content -->
        <footer>
          <div class="pull-right">
             Fabrica - Template em desenvolvimento <a href="http://jefterlucas.com">Jéfter Lucas</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <!-- <script src="vendors/Chart.js/dist/Chart.min.js"></script> -->
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

        <!-- ****************************** __Datatables__ *********************************-->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- *************************** __ END Datatables __ *******************************-->

    <!-- Bootstrap -->
    <!-- <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script> -->
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- validator -->
    <script src="vendors/validator/validator.js"></script>
    <!-- jquery.inputmask -->
    <script src="vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <!-- Notifications -->
    <link href="vendors/pnotify/dist/pnotify.css" media="all" rel="stylesheet">
    <script type="text/javascript" src="vendors/pnotify/dist/pnotify.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Ion.RangeSlider -->
    <script src="vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <!-- Bootstrap Colorpicker -->
    <script src="vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Estilização do modal -->
    <link rel="stylesheet" type="text/css" href="css/modalEmail.css">

    <!-- Custom Theme Scripts --> 
    <script src="build/js/custom.js"></script>

     <!-- Script da página index -->
    <script src="js/fn.js"></script>

    <!-- Script da página index -->
    <script src="system/clientes/js/fn.js"></script>

    <!-- Script da página index -->
    <script src="system/funcionarios/js/fn.js"></script>

    <!-- Script da página index -->
    <script src="system/maquinas/js/fn.js"></script>

    <!-- Script da página index -->
    <script src="system/ocorrencias/js/fn.js"></script>
    
    <script src="system/problemas/js/fn.js"></script>

    <!-- Script da página index -->
    <script src="system/planilhas/js/fn.js"></script>
	   
    <!-- Script da página index/model -->
    <script src="system/home/js/fn.js"></script>

    <!-- Script para dar LogOut no sistema-->
    <script src="js/acesso/logOut.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        // fn.viewLtOcorrencias();
      })
    </script>
  </body>
</html>
