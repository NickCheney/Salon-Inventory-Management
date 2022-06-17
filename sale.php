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
<a href="./sales.php">
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
?>
<div class='order-wrap'>
    <table class="text-input">
        <tr>
            <td>
                <h3>Sale #<?php echo $data['ID']?><h3>
            </td>
        </tr>    
        <tr>
            <td>
                <h4>Date: </h4>
            </td>
            <td>
                <h4><?php echo $data['date']?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Time: </h4>
            </td>
            <td>
                <h4><?php echo $data['time']?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Discount: </h4>
            </td>
            <td>
                <h4><?php echo $data['discount']?>%</h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Sale Total: </h4>
            </td>
            <td>
                <h4>$<?php echo $data['sale_total_ad']?></h4>
            </td>
        </tr>
    </table>
    <div>
		<form method='post' action='updateSale.php'>
			<input type='hidden' name='data' value='<?php echo serialize($data)?>' />
			<button>
				<img class='icon' src='resources/images/edit.png' />
			</button>
		</form>
		<br/>
		<form method='post' action='deleteSaleConfirm.php'>
			<input type='hidden' name='data' value='<?php echo serialize($data)?>' />
			<button>
				<img class='icon' src='resources/images/delete.png'/>
			</button>
		</form>
	</div>
</div>

<div class='order-prodlist-wrapper'>
    <div class='order-prodlist-header'>
        <span><h4>Product</h4></span>
        <span><h4>Size</h4></span>
        <span><h4>Quantity</h4></span>
        <span><h4>Unit Price</h4></span>
        <span><h4>Subtotal</h4></span>
    </div>
<?php
$sql = "select * from item join sells on item.ID = sells.I_ID where sells.S_ID = :ID";
if ($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
    $ID = $data['ID'];
    if($stmt->execute()){
        if($stmt->rowCount() > 0){
            ?>
 
                <?php 
                foreach ($stmt as $row) { 
                ?>
                <div class = 'order-prodlist-box'>
                    <span><?php echo $row['name']?></span>
                    <span><?php echo $row['size']?></span>
                    <span><?php echo $row['quantity']?></span>
                    <span>$<?php echo $row['unit_price']?></span>
                    <span>$<?php echo number_format($row['quantity']*$row['unit_price']*
                    (1-$data['discount']/100),2)?></span>
                </div>
                <?php } 
        } 
    } 
    unset($stmt);
}
unset($pdo);

} else {
    echo "<h4>Data error...</h4>";
} ?>
</div>
<a href='./sales.php'>
	<div class='home'>
		<h4>Back to Sales</h4>
	</div>
</a>