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

    <title>Amazon Product Database UI - New User</title>

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
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <?php
	  if(!empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['email2']) && !empty($_POST['password']) && !empty($_POST['password2'])) {

	  	if (($_POST['password'] != $_POST['password2']) || ($_POST['email'] != $_POST['email2'])) {
		  	?>
				<div class="container">
					<div class="jumbotron">
						<h1 class="text-center">Oops!</h1>
						<p class="text-center">Something was entered incorrectly. Please try again.</p>
					</div>
				</div>
	  	  <meta http-equiv="refresh" content="1; url=create_account.php">
	  	  <?php
	  	}
	  	else {
				$firstname = mysql_real_escape_string($_POST['firstName']);
			  $lastname = mysql_real_escape_string($_POST['lastName']);
			  $password = hash('sha256', mysql_real_escape_string($_POST['password']));
			  $email = mysql_real_escape_string($_POST['email']);

			  $checkemail = mysql_query("SELECT COUNT(User_id) FROM User WHERE Email = '".$email."'");

	  	  if($checkemail == 1) {
			  	?>
					<div class="container">
						<div class="jumbotron">
							<h1 class="text-center">Oops!</h1>
							<p class="text-center">Sorry, that email is taken. Please try again with a different e-mail.</p>
						</div>
					</div>
		  	  <meta http-equiv="refresh" content="1; url=create_account.php">
		  	  <?php
			  }
			  else {
				$registerquery = mysql_query('INSERT INTO User (FirstName, LastName, Email, Password) VALUES ("'.$firstname.'","'.$lastname.'","'.$email.'", "'.$password.'")');

					if($registerquery) {

					  $_SESSION['FirstName'] = $firstname;
					  $_SESSION['LoggedIn'] = 1;

					  ?>
						<div class="container">
							<div class="jumbotron">
								<h1 class="text-center">Success!</h1>
								<p class="text-center">Your account was created successfully.</p>
							</div>
						</div>
			  	  <meta http-equiv="refresh" content="1; url=index.php">
			  	  <?php
					}
					else {
					  ?>
						<div class="container">
							<div class="jumbotron">
								<h1 class="text-center">Error!</h1>
								<p class="text-center">Sorry, your registration failed. Please try again.</p>
							</div>
						</div>
			  	  <meta http-equiv="refresh" content="1; url=create_account.php">
			  	  <?php
					}
				}
			}
		}
		else {
			?>
			<div class="container">

	      <form method="post" action="create_account.php" class="form-signin clearfix">
	        <h2 class="form-signin-heading bottom">Enter your information</h2>
	        <input type="text" class="form-control" placeholder="First Name" name="firstName">
	        <input type="text" class="form-control" placeholder="Last Name" name="lastName">
	        <input type="text" class="form-control" placeholder="Email address" name="email">
	        <input type="text" class="form-control" placeholder="Confirm Email address" name="email2">
	        <input type="password" class="form-control" placeholder="Password" name="password">
	        <input type="password" class="form-control" placeholder="Confirm Password" name="password2">
	        <button class="btn btn-primary pull-right" type="submit">Create account</button>
	      </form>

	    </div> <!-- /container -->
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