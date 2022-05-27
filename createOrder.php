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
<form action='createOrderResult.php' method='post'>
<div class='order-wrap'>
	<div>
	<h3>Add new order details below:</h3>
	<table class="text-input">
		<tr>
			<td>
				Date <span style='color: red'>*</span>:
			</td>
			<td>
				<input type='date' name='order-date' required />
			</td>
		</tr>
		<tr>
			<td>
				Time <span style='color: red'>*</span>:
			</td>
			<td>
				<input type='time' name='order-time' required />
			</td>
		</tr>
		<tr>
			<td>
				Discount (%)<span style='color: red'>*</span>:
			</td>
			<td>
				<input type='number' name='order-discount' step='1' required />
			</td>
		</tr>
		<tr>
			<td>
				Supplier:
			</td>
			<td>
				<input type='text' name='order-supplier' />
			</td>
		</tr>
	</table>
	<a href='./orders.php'>
		<div class='cancel'>
			<h4>Cancel</h4>
		</div>
	</a>
	<input class='complete' type='submit' value='Create' name='create'>
</div>
</div>
</form>

</body>
</html>