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
<?php 
if ($_POST['data']) {
	$data = unserialize($_POST['data']);
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=inventory', 'nick', 'Fringe2022!');
		$sql = "select sum(Quantity) as pq from includes where I_ID = ".$data['ID'];
		$rows = $dbh->query($sql);
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
	$pq = $rows->fetch()['pq'];
	if ($pq == null)
		$pq=0;

	$dbh=null;
	echo "<div class='prod-wrap'>
	<div>
		<img class='product' src='./resources/images/".$data['img_url']."'>
	</div>
	<div>
		<h3>".$data['name']."</h3>
		<h4>".$data['size']."</h4>
		<h4>Total Ordered: ".$pq."</h4>
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

<a href='./index.php'>
	<div class='home'>
		<h4>Back to Products</h4>
	</div>
</a>

</body>
</html>

