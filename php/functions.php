<?php
session_start();
$Department_id = $_GET['Department_id'];
$Product_id = $_GET['Product_id'];

//$date = date('F j, Y');

/*
*
*/
function displayCart() {
	$cart = $_SESSION['cart'];
	if (!$cart) {
		return '<li><a href="cart.php">Cart: 0 items</a></li>';
	} else {
		$items = explode(',',$cart);
		$s = (count($items) > 1) ? 's':'';
		return '<li><a href="cart.php">Cart: '.count($items).' item'.$s.'</a></li>';
	}
}

/*
*
*/
function displayCategories() {
	global $db;
	$categories = array();

	$sql = mysql_query('SELECT Department_id FROM Department');

	while ($row = mysql_fetch_array($sql)) {
		$categories[] = $row['Department_id'];
	}

	foreach ($categories as $id) {
		$sql = 'SELECT * FROM Department WHERE Department_id = '.$id;
		$result = $db->query($sql);
		$row = $result->fetch();
		extract($row);

		$output[] = '<li>';
		$output[] = '<a href="index.php?Department_id='.$Department_id.'">'.$Title.'</a>';
		$output[] = '</li>';
	}
	return join('', $output);
}

/*
*
*/
function displayGrid($Department_id = 0) {
	global $db;
	$product = array();

	if ($Department_id > 0) {
		$sql = mysql_query('SELECT P.Product_id, P.Title FROM Product AS P INNER JOIN SubDepartment_has_Products AS SP ON P.Product_id = SP.Product_id INNER JOIN SubDepartment AS S ON SP.SubDepartment_id = S.SubDepartment_id INNER JOIN Department AS D ON S.Department_id = D.Department_id WHERE D.Department_id = '.$Department_id.'');
	}
	else {
		$sql = mysql_query('SELECT Product_id FROM Product ORDER BY RAND()');
	}

	while ($row = mysql_fetch_array($sql)) {
		$product[] = $row['Product_id'];
	}

	foreach ($product as $id) {
		$sql = 'SELECT * FROM Product WHERE Product_id = "'.$id.'"';
		$result = $db->query($sql);
		$row = $result->fetch();
		extract($row);

		$output[] = '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">';
		$output[] = '<div class="bordered-box">';
	  $output[] = '<a href="product.php?Product_id='.$Product_id.'"><img src="'.$Image.'" class="img-responsive"></a>';

		$count = mb_strlen($Title);
	  if ($count > 25) {
		  $TempTitle = substr($Title, 0, 22);
		  $TempTitle .= '...';
		  $output[] = '<a href="product.php?Product_id='.$Product_id.'"><h4>'.$TempTitle.'</h4></a>';
	  } else {
  		$output[] = '<a href="product.php?Product_id='.$Product_id.'"><h4>'.$Title.'</h4></a>';
	  }
		$output[] = '<h5>Price: $'.$Price.'</h5>';
		$output[] = '</div></div>';
	}
	return join('', $output);
}

/*
*
*/
function displayHeader($Department_id = 0) {
	global $db;

	if ($Department_id > 0) {
		$sql = 'SELECT Title FROM Department WHERE Department_id = '.$Department_id.'';
		$result = $db->query($sql);
		$row = $result->fetch();
		extract($row);
	}
	else {
		$Title = 'Product Database UI';
	}

	$output[] = '<div class="jumbotron">';
	$output[] = '<h1 class="text-center">'.$Title.'</h1>';
	$output[] = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ac molestie ante. Nulla a adipiscing enim. Quisque nulla massa, faucibus sed laoreet sit amet, convallis.</p>';
	$output[] = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>';
	$output[] = '</div>';
	return join('', $output);
}

function displayOtherProducts() {
	global $db;
	$products = array();

	$sql = 'SELECT Product_id FROM Product ORDER BY RAND() LIMIT 4';
	$result = mysql_query($sql);

	while ($row = mysql_fetch_assoc($result)) {
		$products[] = $row['Product_id'];
	}

	foreach ($products as $id) {
		$sql = 'SELECT * FROM Product WHERE Product_id = "'.$id.'"';
		$result = $db->query($sql);
		$row = $result->fetch();
		extract($row);

		$output[] = '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">';
		$output[] = '<div class="bordered-box-product">';
	  $output[] = '<a href="product.php?Product_id='.$Product_id.'"><img src="'.$Image.'" class="img-responsive"></a>';
		$count = mb_strlen($Title);
	  if ($count > 25) {
		  $TempTitle = substr($Title, 0, 19);
		  $TempTitle .= '...';
		  $output[] = '<a href="product.php?Product_id='.$Product_id.'"><h4>'.$TempTitle.'</h4></a>';
	  } else {
  		$output[] = '<a href="product.php?Product_id='.$Product_id.'"><h4>'.$Title.'</h4></a>';
	  }
		$output[] = '<h5>Price: $'.$Price.'</h5>';
		$output[] = '</div></div>';
	}
	return join('', $output);
}

/*
*
*/
function displayProductTable() {
	global $db;
	$product = array();

	$sql = mysql_query('SELECT Product_id FROM Product ORDER BY Product_id ASC');

	while ($row = mysql_fetch_array($sql)) {
		$product[] = $row['Product_id'];
	}

	$output[] = '<div class="table-responsive">';
	$output[] = '<table class="table table-bordered">';
	$output[] = '<tr><th>#</th>';
	$output[] = '<th>Product</th>';
	$output[] = '<th>Brand</th>';
	$output[] = '<th>List Price</th>';
	$output[] = '<th>Price</th>';
	$output[] = '<th>ASIN#</th></tr>';

	$i = 1;
	foreach ($product as $id) {
		$sql = 'SELECT * FROM Product WHERE Product_id = "'.$id.'"';
		$result = $db->query($sql);
		$row = $result->fetch();
		extract($row);

		$output[] = '<tr><td>'.$i.'</td>';
		$output[] = '<td>'.$Title.'</td>';
		$output[] = '<td>'.$Brand.'</td>';
		$output[] = '<td>'.$MSRP.'</td>';
		$output[] = '<td>'.$Price.'</td>';
		$output[] = '<td>'.$Product_id.'</td></tr>';
		$i++;
	}
	$output[] = '</table></div>';
	return join('', $output);
}

/*
*
*/
function displayReviews($Product_id = 0) {
	global $db;
	$reviews = array();
	$i = 0;

	if ($Product_id === 0) {
	  echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
	  break;
	} else {
		$sql = mysql_query('SELECT COUNT(Review_id) FROM Review WHERE Product_id = "'.$Product_id.'"');
		$count = mysql_result($sql, 0);
		$_SESSION['count'] = $count;

		if ($count == 0) {
			$output[] = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			$output[] = '<div class="bordered-box-product">';
			$output[] = '<h4 class="text-center">This product has not been reviewed yet</h4>';
			$output[] = '</div></div>';
		}
		else {
			$sql = mysql_query('SELECT Review_id FROM Review WHERE Product_id = "'.$Product_id.'"');

			if ($sql == FALSE) {
				die(mysql_error());
			}

			while ($row = mysql_fetch_array($sql)) {
				$reviews[] = $row['Review_id'];
			}

			foreach ($reviews as $id) {
				if ($i == 10) {
					break;
				}

				$i++;
				$sql = 'SELECT Review.*, User.FirstName, User.LastName FROM Review INNER JOIN User ON Review.User_id = User.User_id AND Review.Review_id = '.$id;
				$result = $db->query($sql);
				$row = $result->fetch();
				extract($row);
				$s = ($Rating != 1) ? 's':'';

				$output[] = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
		    $output[] = '<div class="bordered-box-product">';
		    $output[] = '<ul class="list-inline">';
		    $output[] = '<li><h5 class="text-warning"><strong>Rating: '.$Rating.' star'.$s.'</strong></h5></li>';
		    $output[] = '<li><h5><strong>'.$Title.'</strong></h5></li>';
			  $output[] = '<li><small>'.$Date.'</small></li></ul>';
		    $output[] = '<div class="small-sub">by '.$FirstName.' '.$LastName.'</div><hr>';
		    $output[] = '<p>'.$ReviewContent.'</p></div></div>';

		 		if ($i == 10) {
			 		$output[] = '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">';
		      $output[] = '<a href="#">View all reviews</a></div>';
		 		}
			}
		}
	}
	return join('', $output);
}

/*
*
*/
function displayUserName() {
	if (empty ($_SESSION['LoggedIn']) && empty($_SESSION['FirstName'])) {
		return '<li><a href="login.php">Sign in</a></li>';
	} else {
		?>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi <?php echo $_SESSION['FirstName']; ?><b class="caret"></b></a>
    		<ul class="dropdown-menu">
    			<li><a href="#">View Profile</a></li>
					<li><a href="logout.php">Log Out</a></li>
				</ul>
    </li>
		<?php
    }
}

/*
*
*/
function displayCartContents() {
	global $db;
	$cart = $_SESSION['cart'];

	$filename = basename($_SERVER['SCRIPT_NAME']);

	if ($cart) {
		$items = explode(',',$cart);
		$contents = array();
		foreach ($items as $item) {
			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		}

		$output[] = '<form action="cart.php?action=update" method="post" id="cart">';
		foreach ($contents as $id=>$qty) {
			$sql = 'SELECT * FROM Product WHERE Product_id = "'.$id.'"';
			$result = $db->query($sql);
			$row = $result->fetch();
			extract($row);

			$output[] = '<div class="row"><div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">';
			$output[] = '<img src="'.$Image.'" class="img-responsive"></div>';
			$output[] = '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">';
			$output[] = '<h4>'.$Title.'</h4><h5>Price: $'.$Price.'</h5></div>';
			$output[] = '<div class="col-lg-1 col-lg-offset-5 col-md-1 col-md-offset-5 col-sm-2 col-sm-offset-3 col-xs-4-og">';
			$output[] = '<div class="form-group">';
			$output[] = '<label class="col-md-push-12 control-label" for="quantity">Quantity:</label>';
			$output[] = '<input type="text" name="qty'.$Product_id.'" value="'.$qty.'">';
			$output[] = '</div></div><div class="col-lg-3 col-lg-offset-6 col-md-10 col-sm-9 col-xs-4-og pull-right">';
			$output[] = '<h5 class="text-right"><strong>Qty Price:</strong> $'.number_format(($Price * $qty), 2, '.',',').'</h5>';
			$output[] = '<h5 class="text-right"><primary><strong><a href="cart.php?action=delete&Product_id='.$Product_id.'">Remove Item</a></strong></primary></h5>';
			$output[] = '</div></div><hr>';
			$total += $Price * $qty;
		}
		$output[] = '<div class="row">';
		$output[] = '<div class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-3 col-sm-offset-9 bottom">';
		$output[] = '<button class="btn btn-primary pull-right btn-block" type="submit">Update Cart</button></div></div></form>';
		$output[] = '<div class="row spacer">';
		if (empty ($_SESSION['LoggedIn'])) {
			$output[] = '<div class="col-lg-3 col-lg-offset-9">';
			$output[] = '<h3 class="text-right"><strong>SubTotal: $'.$total.'<strong></h3></div>';
			$output[] = '<div class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-3 col-sm-offset-9">';
			$output[] = '<a href="login.php" class="btn btn-block btn-success pull-right" type="submit">Continue</a></div></div>';
		} else if ($filename == "checkout.php") {
				$_SESSION['TotalCost'] = $total;
				$output[] = '<div class="col-lg-4 col-lg-offset-8">';
				$output[] = '<h3 class="text-right"><strong>Order Total: $'.$total.'<strong></h3></div>';
				$output[] = '<div class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-3 col-sm-offset-9">';
				$output[] = '<a href="complete.php" class="btn btn-block btn-success pull-right" type="submit">Process Order</a></div></div>';
		} else {
				$output[] = '<div class="col-lg-3 col-lg-offset-9">';
				$output[] = '<h3 class="text-right"><strong>SubTotal: $'.$total.'<strong></h3></div>';
				$output[] = '<div class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-3 col-sm-offset-9">';
				$output[] = '<a href="order_info.php" class="btn btn-block btn-success pull-right" type="submit">Continue</a></div></div>';
		}
	} else {
		$output[] = '<h2 class="text-center">Your shopping cart is empty</h2>';
	}
	return join('',$output);
}

/*
*
*/
function processCart() {
	$cart = $_SESSION['cart'];
	$action = $_GET['action'];
	switch ($action) {
	  case 'add':
	    if ($cart) {
	      $cart .= ','.$_GET['Product_id'];
	    } else {
	      $cart = $_GET['Product_id'];
	    }
	    break;
	  case 'delete':
	    if ($cart) {
	      $items = explode(',',$cart);
	      $newcart = '';
	      foreach ($items as $item) {
	        if ($_GET['Product_id'] != $item) {
	          if ($newcart != '') {
	            $newcart .= ','.$item;
	          } else {
	            $newcart = $item;
	          }
	        }
	      }
	      $cart = $newcart;
	    }
	    break;
	  case 'update':
	  if ($cart) {
	    $newcart = '';
	    foreach ($_POST as $key=>$value) {
	      if (stristr($key,'qty')) {
	        $id = str_replace('qty','',$key);
	        $items = ($newcart != '') ? explode(',',$newcart) : explode(',',$cart);
	        $newcart = '';
	        foreach ($items as $item) {
	          if ($id != $item) {
	            if ($newcart != '') {
	              $newcart .= ','.$item;
	            } else {
	              $newcart = $item;
	            }
	          }
	        }
	        for ($i=1;$i<=$value;$i++) {
	          if ($newcart != '') {
	            $newcart .= ','.$id;
	          } else {
	            $newcart = $id;
	          }
	        }
	      }
	    }
	  }
	  $cart = $newcart;
	  break;
	}
	$_SESSION['cart'] = $cart;
}

function processOrder() {
		global $db;
		$cart = $_SESSION['cart'];
		$date = date('F j, Y');

		$sql = 'INSERT INTO Orders (Date, ShippingAddress, ShippingCity, ShippingState, ShippingZip, BillingName, BillingAddress, BillingCity, BillingState, BillingZip, CardType, CardNumber, CardSecCode, CardExpMonth, CardExpYear, TotalCost, ShippingOption, User_id) VALUES ("'.date.'", "'.$_SESSION['ship_addr'].'", "'.$_SESSION['ship_city'].'", "'.$_SESSION['ship_state'].'", "'.$_SESSION['ship_zip'].'", "'.$_SESSION['bill_name'].'", "'.$_SESSION['bill_addr'].'", "'.$_SESSION['bill_city'].'", "'.$_SESSION['bill_state'].'", "'.$_SESSION['bill_zip'].'", "'.$_SESSION['bill_card_type'].'", "'.$_SESSION['bill_card_num'].'", "'.$_SESSION['bill_sec_code'].'", "'.$_SESSION['bill_exp_month'].'", "'.$_SESSION['bill_exp_year'].'", "'.$_SESSION['TotalCost'].'", "'.$_SESSION['ship_option'].'", "'.$_SESSION['User_id'].'")';
		$result = mysql_query($sql);

	if ($cart) {
		$items = explode(',',$cart);
		$contents = array();
		foreach ($items as $item) {
			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		}

		$order_id = mysql_insert_id();
		foreach ($contents as $id=>$qty) {
			$sql = mysql_query('INSERT INTO Order_has_Products (Order_id, Product_id) VALUES ('.$order_id.',"'.$id.'")');
		}
	}
}
?>