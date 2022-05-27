<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Fringe Inventory Management</title>
	<link rel="stylesheet" href="./resources/css/index.css">
</head>
<body>
<a href="./orders.php">
<div id="banner">
	<div id="banner2">
		<h1>FRINGE HAIR SALON</h1>
		<h2>Inventory management system</h2>
	</div>
</div>
</a>

<div class='header'>
	<a class='item-off' href="products.php">
		<h3>Products</h3>
</a>
<a class='item-on' href='orders.php'>
		<h3>Orders</h3>
</a>
<a class='item-off' href='sales.php'>
		<h3>Sales</h3>
</a>
<div id='user-info'>
	<div>
		<img style='width: 25px;' src='resources/images/user-icon2.png'/>
		<h2>
		<?php 
		session_start();
		echo htmlspecialchars($_SESSION['username']);
		?>
		</h2>
	</div>

	<div>
	<a href='logout.php' style='float: right;'>
		<h5 style='color:white;'>Log out</h5>
	</a>
	</div>
</div>

</div>
<div class='order-wrapper'>
			<div class='order-header'>
			<span><h4>Order #</h4></span>
			<span><h4>Date</h4></span>
			<span><h4>Time</h4></span>
			<span><h4>Order Total</h4></span>
			</div>
<?php
$sql =  "select *, round(order_total * (1 - discount/100),2) as order_total_ad 
		from (select O_ID, sum(quantity * unit_price) as order_total from buys group by O_ID) 
		as t1 right join order_ as t2 on t1.O_ID = t2.ID";
if($stmt = $pdo->prepare($sql)){
	if($stmt->execute()){
		if($stmt->rowCount() > 0){
			?>
			<?php
			foreach($stmt as $row) {
			?>
			<form method='post' action='order.php'>
				<input type='hidden' name='data' value='<?php echo serialize($row)?>' />
				<button class='order-box'>
					<span>
						<h5><?php echo $row['ID']?></h5>
					</span>
					<span>
						<h5><?php echo $row['date'] ?></h5>
					</span>
					<span>
						<h5><?php echo $row['time'] ?></h5>
					</span>
					<span>
						<h5>
							<?php 
							if (!empty($row['order_total_ad'])){ 
								echo "$";
							} 
							echo $row['order_total_ad']; 
							?>
						</h5>
					</span>
				</button>
			</form>
			<?php
			}
			unset($row);
		} else {
			echo "<p>No orders to show...</p>";
		}
	}
	unset($stmt);
}
unset($pdo);
?>
<form method='post' action='createOrder.php'>
	<div class='order-add'>
		<button>
			<img class='icon' style='max-width: 30px;' src='./resources/images/plus-icon3.png' />
		</button>
	</div>
</form>
</div>

</body>
</html>

