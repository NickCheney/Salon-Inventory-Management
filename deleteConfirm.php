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
<?php 
    if ($_POST['data']) {
        $data = unserialize($_POST['data']);
        echo "<div class='confirm'>
        <div>
        <h4>Are you sure you want to delete '".$data['name']."'?</h4>
        <h5>(This will delete all associated order data for this product)</h5>
        </div>
        <div>
        <form id='del-con' method='post' action='result.php'>
            <input type='hidden' name='atype' value='delete' />
            <input type='hidden' name='data' value='".serialize($data)."' />
            <input class='complete' type='submit' value='Confirm'>
        </form>
        <a onclick='history.go(-1)'><div class='home'>
        <h4>Cancel</h4></div></a>
        </div>
        </div>";
    } else {
        echo "<div class='message'>
        <h4>Data error...</h4>
        </div>";
    }
?>

</body>
</html>