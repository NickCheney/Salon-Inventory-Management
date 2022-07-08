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
<a href="">
<div id="banner">
	<div id="banner2">
		<h1>FRINGE HAIR SALON</h1>
		<h2>Inventory management system</h2>
	</div>
</div>
</a>

<div class='header'>
	<a class='item-on' href="">
		<h3>Products</h3>
</a>
<a class='item-off' href='orders.php'>
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
<div class="wrapper">

<a href='createProduct.php'>
	<button class='add'>
	<div class='prod-img' style='background-image: url(./resources/images/plus-icon3.png);'></div>
	</button>
</a>

<?php
$sql = "select * from item order by brand, name";

if($stmt = $pdo->prepare($sql)){
	if($stmt->execute()){
		if($stmt->rowCount() > 0){
			foreach($stmt as $row) {
				$prod_image_path = './resources/images/'.$row['img_url'];
				echo "
<form method='post' action='product.php'>
	<input type='hidden' name='data' value='".serialize($row)."' />
	<button class='box'>
			<div class='prod-img' style='background-image: url(".$prod_image_path.");'></div>
			<div style='padding-top: 15px;'>
				<h4>".$row["brand"]." ".$row["name"]."</h4>
				<h5 style='padding-top: 10px;'>
			";
				if ($row['size']) {
					echo $row['size']."&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			echo "$".$row['price']."</h5>
			</div>
	</button>
</form>
					 ";
			}
			unset($row);
		} else {
			echo "<p>No products to show...</p>";
		}
	}
	unset($stmt);
}
unset($pdo);
?>


</div>
</body>
</html>

