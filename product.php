<?php
session_start();
require_once('php/mysql.php');
require_once('php/functions.php');
require_once('php/global.php');

$Product_id = $_GET['Product_id'];
global $db;

$sql = 'SELECT * FROM Product WHERE Product_id = "'.$Product_id.'"';
$result = $db->query($sql);
$row = $result->fetch();
extract($row);

$search = mysql_query('SELECT Rating FROM Review WHERE Product_id = "'.$Product_id.'"');
if (($rows = mysql_num_rows($search)) > 0) {
	$query = mysql_query('SELECT CAST(AVG(Rating) AS DECIMAL(2,1)) AS Rating FROM Review WHERE Product_id ="'.$Product_id.'"');
	if (!$query) { // add this check.
	    die('Invalid query: ' . mysql_error());
	}
	$avg = mysql_fetch_array($query);
	$RatingAvg = $avg['Rating']." / 5";
} else {
	$RatingAvg = "Not Rated";
}
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

    <title><?php echo $Title; ?></title>

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
		if (!empty($_POST['review_title']) && !empty($_POST['review_content']) && !empty($_POST['review_rating']) && !empty($_SESSION['LoggedIn'])) {
			$review_title = mysql_real_escape_string($_POST['review_title']);
			$review_content = mysql_real_escape_string($_POST['review_content']);
			$review_rating = (int)$_POST['review_rating'];
			$date = date('F j, Y');
			$User_id = $_SESSION['User_id'];

			$sql = 'INSERT INTO Review (Date, Rating, Title, ReviewContent, Product_id, User_id) VALUES ("'.$date.'",'.$review_rating.',"'.$review_title.'","'.$review_content.'","'.$Product_id.'",'.$User_id.')';

			if (!mysql_query($sql)) {
			?>
				<div class="container">
					<div class="jumbotron">
						<h2 class="text-center">Your review submission didn't work</h2>
						<p class="text-center">You'll now be redirected back to the product page. Please create your product review again.</p>
					</div>
				</div>
	  	  <meta http-equiv="refresh" content="1; url=product.php?Product_id=<?php echo $Product_id; ?>">
	  	<?php
	  	} else {
		  	?>
				<div class="container">
					<div class="jumbotron">
						<h2 class="text-center">Your review has been submitted successfully</h2>
						<p class="text-center">You'll now be redirected back to the product page in a few seconds.</p>
					</div>
				</div>
	  	  <meta http-equiv="refresh" content="1; url=product.php?Product_id=<?php echo $Product_id; ?>">
		  	<?php
	  	}
		}
		else if (!empty($_POST['review_title']) && !empty($_POST['review_content']) && !empty($_POST['review_rating']) && empty($_SESSION['LoggedIn'])) {
			?>
	  	<div class="container">
				<div class="jumbotron">
					<h2 class="text-center">You're not logged in right now</h2>
					<p class="text-center">You need to be logged in to post a review. Please log in first.</p>
				</div>
			</div>
  	  <meta http-equiv="refresh" content="1; url=login.php">
	  	<?php
		}
		else {
		?>
    <div class="container">

      <div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<img src="<?php echo $Image; ?>" class="img-responsive">
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="bordered-box-product">
						<h1><?php echo $Title; ?></h1>
						<sub>by <?php echo $Brand; ?></sub><hr>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor tincidunt eleifend. Curabitur et rutrum ante. Vestibulum fermentum facilisis volutpat. Nullam pellentesque leo nec lectus accumsan, ut scelerisque sapien imperdiet. Donec id leo gravida, posuere metus id, rutrum dolor. Aenean turpis massa, adipiscing facilisis erat a, convallis faucibus lacus. In elementum lectus sit amet cursus faucibus. Phasellus auctor nunc felis, ut accumsan sem vulputate nec. In hendrerit tincidunt orci, quis cursus leo hendrerit ac. Praesent eu felis interdum, consequat odio vitae, aliquet velit. Sed at dolor lorem. Curabitur at orci eu sem mattis sagittis. Proin faucibus feugiat nulla, sed porta justo accumsan in. Suspendisse nec metus quam.</p>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
					<div class="bordered-box-product">
						<h4>Options</h4>
						<ul>
							<li>Option 1</li>
							<li>Option 2</li>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
					<div class="bordered-box-product">
						<h4 class="text-success">Price: $<?php echo $Price; ?></h4>
						<h5>Rating: <?php echo $RatingAvg; ?></h5>
					</div>
				</div>
				<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
					<div class="bordered-box-product">
					<form action="cart.php?action=add&Product_id=<?php echo $Product_id; ?>" method="post">
						<div class="form-group">
					    <label class="control-label">Quantity:</label>
							<select class="form-control input-sm" name="qty">
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
						    <option value="13">13</option>
						    <option value="14">14</option>
						    <option value="15">15</option>
							</select>
						</div>
						<a href="cart.php?action=add&Product_id=<?php echo $Product_id; ?>" class="btn btn-primary btn-block">Add to Cart</a>
					</div>
				</div>
      </div>

			<h3>Additional Details</h3>
      <div class="div-line"></div>

      <div class="row">
      	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      		<div class="bordered-box-product">
						<img src="http://fakeimg.pl/600x600/?text=Detail 1" class="img-responsive">
						<h4>Detail 1</h4><hr>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor tincidunt eleifend. Curabitur et rutrum ante. Vestibulum fermentum facilisis volutpat. Nullam pellentesque leo nec lectus accumsan, ut scelerisque sapien imperdiet. Donec id leo gravida, posuere metus id, rutrum dolor. Aenean turpis massa, adipiscing facilisis erat a, convallis faucibus lacus.</p>
      		</div>
      	</div>
      	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      		<div class="bordered-box-product">
						<img src="http://fakeimg.pl/600x600/?text=Detail 2" class="img-responsive">
						<h4>Detail 2</h4><hr>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor tincidunt eleifend. Curabitur et rutrum ante. Vestibulum fermentum facilisis volutpat. Nullam pellentesque leo nec lectus accumsan, ut scelerisque sapien imperdiet. Donec id leo gravida, posuere metus id, rutrum dolor. Aenean turpis massa, adipiscing facilisis erat a, convallis faucibus lacus.</p>
      		</div>
      	</div>
      	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      		<div class="bordered-box-product">
						<img src="http://fakeimg.pl/600x600/?text=Detail 3" class="img-responsive">
						<h4>Detail 3</h4><hr>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor tincidunt eleifend. Curabitur et rutrum ante. Vestibulum fermentum facilisis volutpat. Nullam pellentesque leo nec lectus accumsan, ut scelerisque sapien imperdiet. Donec id leo gravida, posuere metus id, rutrum dolor. Aenean turpis massa, adipiscing facilisis erat a, convallis faucibus lacus.</p>
      		</div>
      	</div>
      </div>

      <h3>Customer Reviews</h3>
      <div class="div-line"></div>

      <div class="row">

	      <?php

				if (isset($_GET['Product_id'])) {
				  echo displayReviews($_GET['Product_id']);
				} else {
						echo displayReviews();
				}
				?>

      </div>

			<h3>Write a review</h3>
			<div class="div-line"></div>

			<div class="row">
				<form method="get" action="product.php?Product_id=<?php echo $Product_id; ?>">
				<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
					<input type="text" class="input-text" placeholder="Enter review title" name="review_title">
				</div>
			</div>
			<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
						<textarea class="form-control" rows="6" placeholder="Enter review content" name="review_content"></textarea>
					</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
					<h5><strong>Select your rating:</h5><strong></h5>
					<select class="form-control" name="review_rating">
					  <option value="0">0 stars</option>
					  <option value="1">1 star</option>
					  <option value="2">2 stars</option>
					  <option value="3">3 stars</option>
					  <option value="4">4 stars</option>
					  <option value="5">5 stars</option>
					</select>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
					<input type="hidden" name="writeReview" value="review">
					<button class="btn btn-primary btn-block" type="submit" name="review">Publish Review</button>
				</div>
				</form>
      </div>

	    <h3>Other Products</h3>
	    <div class="div-line"></div>

	    <div class="row">
	    	<?php
	    		echo displayOtherProducts();
	    	?>
			</div>

    </div> <!-- container -->
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