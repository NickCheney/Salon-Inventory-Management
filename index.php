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
<a href="./index.php">
<div id="banner">
	<div id="banner2">
		<h1>FRINGE HAIR SALON</h1>
		<h2>Inventory management system</h2>
	</div>
</div>
</a>

<div class='header'>
	<a class='item-on' href="index.php">
		<h3>Products</h3>
</a>
<a class='item-off' href='orders.php'>
		<h3>Orders</h3>
</a>
<a class='item-off' href='sales.php'>
		<h3>Sales</h3>
</a>
</div>

<?php 
$dbh = new PDO('mysql:host=localhost;dbname=inventory', 'nick', 'Fringe2022!');
#$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$rows = $dbh->query("select * from item order by name");
if ($rows->rowCount() == 0)
	echo "<p>No products to show...</p>";

else {

	echo '<div class="wrapper">';
	foreach($rows as $row) {
		$prod_image_path = './resources/images/'.$row['img_url'];
		echo "<div class='box'>
				 <form method='post' action='./product.php'>
					<input type='hidden' name='data' value='".serialize($row)."' />
					<button>
						<div class='prod-cont'>
						<div>	
						<img class='product' src='".$prod_image_path."'/>
						</div>
						<div>
						<br>
			     		<h4>".$row["name"]."</h4>";
						if ($row['size']) {
			     		 echo "<h5>".$row['size']."</h5>";
						} else {
							echo "<h5>-</h5>";
						}
						echo "
						</div>
						</div>
					</button>
				 </form>
				 </div>
		     ";
	}
	unset($row);

	echo "<a href='newProduct.php'><div class='box'><button>
			<div class='prod-cont'>
			<div>
			<img class='plus' src='./resources/images/plus-icon3.png'>
			</div>
			<div>
			<h4>Add Product</h4>
			<h5>&nbsp;</h5>
			</div>
			</div>
			</button></div>
			</a>
		</div>";
}

$dbh = null;

?>


</body>
</html>

