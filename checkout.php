<?php
session_start();
require_once('php/mysql.php');
require_once('php/functions.php');
require_once('php/global.php');

$shortnum = substr($_SESSION['bill_card_num'], -4);
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

    <title>Product Database UI - Checkout</title>

    <!-- Custom styles for the grid display -->
    <link href="css/offcanvas.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for navbar -->
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
			<div class="bordered-box-product">
				<h2>Review your order</h2><hr>

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-6  col-md-6  col-sm-6  col-xs-12 col-divider">
							<h4><strong>Shipping Information</strong></h4>

							<address>
							  <?php echo $_SESSION['FirstName'].' '.$_SESSION['LastName']; ?><br>
							  <?php echo $_SESSION['ship_addr']; ?><br>
								<?php echo $_SESSION['ship_city'].', '.$_SESSION['ship_state'].' '.$_SESSION['ship_zip'];  ?><br>
							</address>

							<h4><strong>Shipping Option</strong></h4>
							<?php echo $_SESSION['ship_option']; ?>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<h4><strong>Billing Information</strong></h4>

							<address>
							  <?php echo $_SESSION['bill_name']; ?><br>
							  <?php echo $_SESSION['bill_addr']; ?><br>
								<?php echo $_SESSION['bill_city'].', '.$_SESSION['bill_state'].' '.$_SESSION['bill_zip'];  ?><br>
							</address>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

							<h4><strong>Payment Information</strong></h4>

							<address>
								<label>Card No:</label>
							  <?php echo 'XXXXXXXXXXXX'.$shortnum; ?><br>
							  <label>Exp. Date:</label>
								<?php echo $_SESSION['bill_exp_month'].' / '.$_SESSION['bill_exp_year'];  ?><br>
							</address>
						</div>
					</div>
				</div>

				<div class="spacer-lg"></div>
				<h4><strong>Product Information<strong></h4>
				<hr>

				<?php
					echo displayCartContents();
				?>
			</div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>