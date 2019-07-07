<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <!-- Meta, title, CSS, favicons, etc. -->
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		  <!-- <link rel="icon" href="images/favicon.ico" type="image/ico" /> -->

	    <title>Login Gerenciador</title>

      <!-- jQuery -->
      <script src="vendors/jquery/dist/jquery.min.js"></script>

      <link rel="icon" href="production/images/favicon.ico" type="image/ico" />
      <!-- Custom Theme Style -->
      <link href="build/css/custom.min.css" rel="stylesheet">

      <!-- Bootstrap -->
      <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Font Awesome -->
      <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <!-- NProgress -->
      <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
      <!-- iCheck -->
      <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
      <!-- bootstrap-progressbar -->
      <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
      <!-- JQVMap -->
      <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
      <!-- bootstrap-daterangepicker -->
      <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	    
	</head>

	<?php  
		// require_once('config.php');
	?>

	<body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="index.html">
              <h1>Login</h1>
              <div>
                <input id="login" autofocus onkeyup="" type="text" class="form-control" placeholder="Login" required="" />
              </div>
              <div>
                <input id="senha" onkeyup="" type="password" class="form-control" placeholder="Senha" required="" />
              </div>
              <div>
                <button onclick="fnLogin.login()" type="button" id="btn-login" class="btn btn-default">Login</button>
                <a class="reset_pass" href="#">Esqueceu a senha?</a>

              </div>
              
              <div style="display: block;" id="verificaLogin"></div>

              <div class="clearfix"></div>

              <div class="separator">
               <!--  <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div> -->
                <br />

                <div>
                  <h1><i class="fa fa-briefcase"></i> Fábrica</h1>
                  <p>©2018 All Rights Reserved. Fábrica!</p>
                </div>
              </div>
            </form>
          </section>
        </div>        
      </div>
    </div>

    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Ion.RangeSlider -->
    <script src="vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <!-- Bootstrap Colorpicker -->
    <script src="vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <!-- Notifications -->
    <link href="vendors/pnotify/dist/pnotify.css" media="all" rel="stylesheet">
    <script type="text/javascript" src="vendors/pnotify/dist/pnotify.js"></script>

    <!-- Custom Theme Scripts --> 
    <!-- <script src="build/js/custom.js"></script> -->
    <script src="js/acesso/login.js"></script>
    <script src="js/fn.js"></script>
  </body>

</html>