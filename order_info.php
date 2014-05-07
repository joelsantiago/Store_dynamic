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

    <title>Product Database UI - Order Information</title>

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

		<?php

		if (!empty($_POST['ship_addr']) && !empty($_POST['ship_city']) && !empty($_POST['ship_state']) && !empty($_POST['ship_zip']) && !empty($_POST['ship_option']) && !empty($_POST['bill_name']) && !empty($_POST['bill_card_num']) && !empty($_POST['bill_sec_code']) && !empty($_POST['bill_card_type']) && !empty($_POST['bill_exp_month']) && !empty($_POST['bill_exp_year']) && !empty($_POST['bill_addr']) && !empty($_POST['bill_city']) && !empty($_POST['bill_state']) && !empty($_POST['bill_zip'])) {

			$_SESSION['ship_addr'] = $_POST['ship_addr'];
			$_SESSION['ship_city'] = $_POST['ship_city'];
			$_SESSION['ship_state'] = $_POST['ship_state'];
			$_SESSION['ship_zip'] = $_POST['ship_zip'];
			$_SESSION['ship_option'] = $_POST['ship_option'];
			$_SESSION['bill_name'] = $_POST['bill_name'];
			$_SESSION['bill_card_num'] = $_POST['bill_card_num'];
			$_SESSION['bill_sec_code'] = $_POST['bill_sec_code'];
			$_SESSION['bill_card_type'] = $_POST['bill_card_type'];
			$_SESSION['bill_exp_month'] = $_POST['bill_exp_month'];
			$_SESSION['bill_exp_year'] = $_POST['bill_exp_year'];
			$_SESSION['bill_addr'] = $_POST['bill_addr'];
			$_SESSION['bill_city'] = $_POST['bill_city'];
			$_SESSION['bill_state'] = $_POST['bill_state'];
			$_SESSION['bill_zip'] = $_POST['bill_zip'];

			?>
	    <meta http-equiv="refresh" content="0; url=checkout.php">
			<?php
		} else {
		?>

    <div class="container">
			<div class="bordered-box-product">
				<div class="row">
				<div class="col-lg-12 col-xs-12">
					<h2 class="bottom">Order Details</h2>
					<div class="spacer-lg">
						<h4>Shipping Information</h4><hr>
					</div>
				</div>
				<form action="order_info.php" class="form-horizontal" role="form" name="order_info" method="post">
				  <div class="form-group">
				    <label for="ship_addr" class="col-sm-2 control-label">Address</label>
				    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				      <input type="text" class="form-control" name="ship_addr" placeholder="Address">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="ship_city" class="col-sm-2 control-label">City</label>
				    <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
				      <input type="text" class="form-control" name="ship_city" placeholder="City">
				    </div>
				    <label for="ship_state" class="col-sm-1 control-label">State</label>
				    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
							<select class="form-control" name="ship_state">
								<option value="">State</option>
								<option value="AL">AL</option>
								<option value="AK">AK</option>
								<option value="AZ">AZ</option>
								<option value="AR">AR</option>
								<option value="CA">CA</option>
								<option value="CO">CO</option>
								<option value="CT">CT</option>
								<option value="DE">DE</option>
								<option value="FL">FL</option>
								<option value="GA">GA</option>
								<option value="HI">HI</option>
								<option value="ID">ID</option>
								<option value="IL">IL</option>
								<option value="IN">IN</option>
								<option value="IA">IA</option>
								<option value="KS">KS</option>
								<option value="KY">KY</option>
								<option value="LA">LA</option>
								<option value="ME">ME</option>
								<option value="MD">MD</option>
								<option value="MA">MA</option>
								<option value="MI">MI</option>
								<option value="MN">MN</option>
								<option value="MS">MS</option>
								<option value="MO">MO</option>
								<option value="MT">MT</option>
								<option value="NE">NE</option>
								<option value="NV">NV</option>
								<option value="NH">NH</option>
								<option value="NJ">NJ</option>
								<option value="NM">NM</option>
								<option value="NY">NY</option>
								<option value="NC">NC</option>
								<option value="ND">ND</option>
								<option value="OH">OH</option>
								<option value="OK">OK</option>
								<option value="OR">OR</option>
								<option value="PA">PA</option>
								<option value="RI">RI</option>
								<option value="SC">SC</option>
								<option value="SD">SD</option>
								<option value="TN">TN</option>
								<option value="TX">TX</option>
								<option value="UT">UT</option>
								<option value="VT">VT</option>
								<option value="VA">VA</option>
								<option value="WA">WA</option>
								<option value="WV">WV</option>
								<option value="WI">WI</option>
								<option value="WY">WY</option>
							</select>
				    </div>
				    <label for="ship_zip" class="col-sm-1 control-label">Zip</label>
				    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				      <input type="text" class="form-control" name="ship_zip" placeholder="Zip">
				    </div>
				  </div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-xs-12">
						<div class="spacer-lg">
							<h4>Shipping Options</h4><hr>
						</div>
					</div>
			    <label for="ship_option" class="col-sm-2 control-label text-right">Shipping Methods</label>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" name="ship_option">
							<option value="">Select a shipping method</option>
						  <option value="$3.99 Standard Shipping (3-5 Business Days)">$3.99 Standard Shipping (3-5 Business Days)</option>
						  <option value="$7.99 Two-Day Shipping">$7.99 Two-Day Shipping</option>
						  <option value="FREE Standard Shipping (3-5 Business Days) PRIME MEMBERS ONLY" disabled>FREE Standard Shipping (3-5 Business Days) PRIME MEMBERS ONLY</option>
						  <option value="FREE Two-Day Shipping PRIME MEMBERS ONLY" disabled>FREE Two-Day Shipping PRIME MEMBERS ONLY</option>
						  <option value="$3.99 One-Day Shipping PRIME MEMBERS ONLY" disabled>$3.99 One-Day Shipping PRIME MEMBERS ONLY</option>
						</select>
					</div>
				</div>

				<div class="row form-horizontal">
					<div class="col-lg-12 col-xs-12">
						<div class="spacer-lg">
							<h4>Billing Information</h4><hr>
						</div>
					</div>
					<div class="form-group">
				    <label for="bill_name" class="col-sm-2 control-label">Name</label>
				    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				      <input type="text" class="form-control" name="bill_name" placeholder="Cardholder Name">
				    </div>
				  </div>
					<div class="form-group">
				    <label for="bill_card_num" class="col-sm-2 control-label">Card #</label>
				    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				      <input type="text" class="form-control" name="bill_card_num" placeholder="Card Number">
				    </div>
				    <label for="bill_sec_code" class="col-lg-4 col-sm-3 control-label">Security Code</label>
				    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				      <input type="text" class="form-control" name="bill_sec_code" placeholder="Sec. Code">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="bill_card_type" class="col-sm-2 control-label">Card Type</label>
				    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<select class="form-control" name="bill_card_type">
								<option value="">Card Type</option>
								<option value="Visa">Visa</option>
								<option value="American Express">American Express</option>
								<option value="MasterCard">MasterCard</option>
								<option value="Disocver">Discover</option>
							</select>
						</div>
				    <label class="col-lg-3 col-sm-2 control-label">Exp. Date</label>
				    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
							<select class="form-control" name="bill_exp_month">
								<option value="">Mo.</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
				    </div>
				    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
							<select class="form-control" name="bill_exp_year">
								<option value="">Year</option>
								<option value="2013">2013</option>
								<option value="2014">2014</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
								<option value="2020">2020</option>
							</select>
				    </div>
				  </div>
			    <div class="form-group">
				    <label for="bill_addr" class="col-sm-2 control-label">Address </label>
				    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				      <input type="text" class="form-control" name="bill_addr" placeholder="Billing Address">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="bill_city" class="col-sm-2 control-label">City</label>
				    <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
				      <input type="text" class="form-control" name="bill_city" placeholder="City">
				    </div>
				    <label for="bill_state" class="col-sm-1 control-label">State</label>
				    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
							<select class="form-control" name="bill_state">
								<option value="">State</option>
								<option value="AL">AL</option>
								<option value="AK">AK</option>
								<option value="AZ">AZ</option>
								<option value="AR">AR</option>
								<option value="CA">CA</option>
								<option value="CO">CO</option>
								<option value="CT">CT</option>
								<option value="DE">DE</option>
								<option value="FL">FL</option>
								<option value="GA">GA</option>
								<option value="HI">HI</option>
								<option value="ID">ID</option>
								<option value="IL">IL</option>
								<option value="IN">IN</option>
								<option value="IA">IA</option>
								<option value="KS">KS</option>
								<option value="KY">KY</option>
								<option value="LA">LA</option>
								<option value="ME">ME</option>
								<option value="MD">MD</option>
								<option value="MA">MA</option>
								<option value="MI">MI</option>
								<option value="MN">MN</option>
								<option value="MS">MS</option>
								<option value="MO">MO</option>
								<option value="MT">MT</option>
								<option value="NE">NE</option>
								<option value="NV">NV</option>
								<option value="NH">NH</option>
								<option value="NJ">NJ</option>
								<option value="NM">NM</option>
								<option value="NY">NY</option>
								<option value="NC">NC</option>
								<option value="ND">ND</option>
								<option value="OH">OH</option>
								<option value="OK">OK</option>
								<option value="OR">OR</option>
								<option value="PA">PA</option>
								<option value="RI">RI</option>
								<option value="SC">SC</option>
								<option value="SD">SD</option>
								<option value="TN">TN</option>
								<option value="TX">TX</option>
								<option value="UT">UT</option>
								<option value="VT">VT</option>
								<option value="VA">VA</option>
								<option value="WA">WA</option>
								<option value="WV">WV</option>
								<option value="WI">WI</option>
								<option value="WY">WY</option>
							</select>
				    </div>
				    <label for="bill_zip" class="col-sm-1 control-label">Zip</label>
				    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				      <input type="text" class="form-control" name="bill_zip" placeholder="Zip">
				    </div>
				  </div>
				</div>

				<div class="row">
					<div class="col-lg-3 col-lg-offset-8 col-md-3 col-md-offset-8 col-sm-3 col-sm-offset-8 col-xs-12">
						<input type="submit" name="order_info" class="btn btn-lg btn-primary btn-block spacer-bt" value="Continue">
					</div>
				</div>

				</form>
			</div>
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