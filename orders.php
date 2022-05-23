<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
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
<a href="./products.php">
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

<?php 
$dbh = new PDO('mysql:host=localhost;dbname=inventory', 'nick', 'Fringe2022!');
$rows = $dbh->query("select * from order_");
if ($rows->rowCount() == 0)
	echo "<p>No orders to show...</p>";
else {
	echo "<div class='order-wrapper'>
    <div class='order-header'>
    <span></span>
    <span><h4>Order #</h4></span>
    <span><h4>Date</h4></span>
    <span><h4>Time</h4></span>
    </div>";
	foreach($rows as $row) {
        $date = explode(" ",$row['dt'])[0];
        $time = explode(" ",$row['dt'])[1];
		echo "<div class='order-box'>
                <span>
                <img class='icon' src='./resources/images/drop-arrow2.png' style='transform: rotate(270deg); width: 30px;'/>
                </span>
                <span>
                <h5>".$row['ID']."</h5>
                </span>
                <span>
                <h5>".$date."</h5>
                </span>
                <span>
                <h5>".$time."</h5>
                </span>
			</div>
		     ";
	}
	unset($row);
    echo "</div>";
}

$dbh = null;

?>

</body>
</html>

