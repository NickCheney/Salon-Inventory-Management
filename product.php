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
<a href="./products.php">
<div id="banner">
	<div id="banner2">
		<h1>FRINGE HAIR SALON</h1>
		<h2>Inventory management system</h2>
	</div>
</div>
</a>
<?php 
if ($_POST['data']) {
	$data = unserialize($_POST['data']);
	$in_stock = 0;
	$sql = "select b - s as ist from (select sum(quantity) as b from buys where I_ID = " .
			":ID group by I_ID) as bt,  (select sum(quantity) as s from sells where I_ID" .
			" = :ID group by I_ID) as sd";

	if($stmt = $pdo->prepare($sql)){
		// Bind variables to the prepared statement as parameters
		$stmt->bindParam(":ID", $prod_id, PDO::PARAM_STR);
		$prod_id = $data['ID'];
		if($stmt->execute()){
			if($stmt->rowCount() == 1){
				if($row = $stmt->fetch()){
					if (isset($row['ist'])){
						$in_stock = $row['ist'];
					}
				}
			}
		}
		unset($stmt);
	}
	$pdo = null;
	echo "<div class='prod-wrap'>
	<div>
		<img class='product' src='./resources/images/".$data['img_url']."'>
	</div>
	<div>
		<h3>".$data['brand']." ".$data['name']."</h3>
		<h4>".$data['size']."</h4>
		<h4>$".$data['price']."</h4>
		<h4>".$in_stock." in stock</h4>
		<br/>
		<h2>".$data['description']."</h2>
	</div>
	<div>
		<form method='post' action='updateProduct.php'>
			<input type='hidden' name='data' value='".serialize($data)."' />
			<button>
				<img class='icon' src='resources/images/edit.png' />
			</button>
		</form>
		<br/>
		<form method='post' action='deleteConfirm.php'>
			<input type='hidden' name='data' value='".serialize($data)."' />
			<button>
				<img class='icon' src='resources/images/delete.png'/>
			</button>
		</form>
	</div>
</div>";

} else {
	echo "<h4>Data error...</h4>";
}
?>

<a href='./products.php'>
	<div class='home'>
		<h4>Back to Products</h4>
	</div>
</a>

</body>
</html>

