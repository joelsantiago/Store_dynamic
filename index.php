<?php
session_start();
require_once('php/mysql.php');
require_once('php/functions.php');
require_once('php/global.php');
$cart = $_SESSION['cart'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="HandheldFriendly" content="true"/>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.ico">

    <title>Product Database UI</title>

    <!-- Custom styles for the grid display -->
    <link href="css/offcanvas.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">

		<!-- Connection for 'Open Sans' font -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Store UI</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          	<li class="vertical-divider hidden-xs"></li>
	          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories<b class="caret"></b></a>
              <ul class="dropdown-menu">

							<?php echo displayCategories(); ?>

              </ul>
            </li>
          	<li class="vertical-divider hidden-xs"></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          	<li class="vertical-divider hidden-xs"></li>
          	<li class="nav-divider"></li>

          	<?php echo displayUserName(); ?>

          	<li class="vertical-divider hidden-xs"></li>
          	<li class="nav-divider"></li>

	          <?php echo displayCart(); ?>

          	<li class="vertical-divider hidden-xs"></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
     <!--
 <div class="jumbotron">
        <h1>Product Database UI</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ac molestie ante. Nulla a adipiscing enim. Quisque nulla massa, faucibus sed laoreet sit amet, convallis.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
-->
			<?php
			if (isset($_GET['Department_id'])) {
			  echo displayHeader($_GET['Department_id']);
			} else {
					echo displayHeader();
			} ?>

			<div class="row">

				<?php
				if (isset($_GET['Department_id'])) {
				  echo displayGrid($_GET['Department_id']);
				} else {
						echo displayGrid();
				} ?>

			</div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
