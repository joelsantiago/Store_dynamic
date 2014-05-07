<?php
session_start();
require_once('php/mysql.php');
require_once('php/functions.php');
require_once('php/global.php');
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

    <title>Amazon Product Database UI - TEMPLATE</title>

		<!-- Custom styles for signin sheet -->
    <link href="css/signin.css" rel="stylesheet">

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
          <a class="navbar-brand" href="index.php">Amazon</a>
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
		<?php
			global $db;
			$cart = $_SESSION['cart'];
			$date = date('F j, Y');

			$sql = 'INSERT INTO Orders (Date, ShippingAddress, ShippingCity, ShippingState, ShippingZip, BillingName, BillingAddress, BillingCity, BillingState, BillingZip, CardType, CardNumber, CardSecCode, CardExpMonth, CardExpYear, TotalCost, ShippingOption, User_id) VALUES ("'.$date.'", "'.$_SESSION['ship_addr'].'", "'.$_SESSION['ship_city'].'", "'.$_SESSION['ship_state'].'", "'.$_SESSION['ship_zip'].'", "'.$_SESSION['bill_name'].'", "'.$_SESSION['bill_addr'].'", "'.$_SESSION['bill_city'].'", "'.$_SESSION['bill_state'].'", "'.$_SESSION['bill_zip'].'", "'.$_SESSION['bill_card_type'].'", "'.$_SESSION['bill_card_num'].'", "'.$_SESSION['bill_sec_code'].'", "'.$_SESSION['bill_exp_month'].'", "'.$_SESSION['bill_exp_year'].'", "'.$_SESSION['TotalCost'].'", "'.$_SESSION['ship_option'].'", "'.$_SESSION['User_id'].'")';

			$result = mysql_query($sql);

			$_SESSION['Order_num'] = mysql_insert_id();

			if ($cart) {
				$items = explode(',',$cart);
				$contents = array();
				foreach ($items as $item) {
					$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
				}

				foreach ($contents as $id=>$qty) {
					$sql = mysql_query('INSERT INTO Order_has_Products (Order_id, Product_id) VALUES ('.$_SESSION['Order_num'].',"'.$id.'")');
				}

				?>
					<div class="container">
						<div class="jumbotron">
							<h1 class="text-center">Order Complete</h1>
							<p class="text-center">You'll now be redirected back to our homepage in a few seconds.</p>
						</div>
			  	  <meta http-equiv="refresh" content="1; url=index.php">
			    </div>
				<?php
				unset($_SESSION['cart']);
			} else {
				?>
					<div class="container">
						<div class="jumbotron">
							<h1 class="text-center">Error Processing Order</h1>
							<p class="text-center">You'll now be redirected back to your cart in a few seconds.</p>
						</div>
			  	  <meta http-equiv="refresh" content="1; url=index.php">
			    </div>
				<?php
			}
		?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>