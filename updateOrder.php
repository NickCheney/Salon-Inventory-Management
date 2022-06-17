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

<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ 
	
	$date_err = $time_err = $discount_err = "";

	if (isset($_POST['data'])) { //fresh on update page from order page
		$data = unserialize($_POST['data']);
		$ID = $data['ID'];
		$date = $data['date'];
		$time = $data['time'];
		$discount = $data['discount'];
		$supplier = $data['supplier'];
	} else { //update button clicked, should attempt to update order
		if (empty(trim($_POST['order-date']))) {
			$date_err = "Order date required.";
		}
		if (empty(trim($_POST['order-time']))) {
			$time_err = "Order time required.";
		}
		if (! is_numeric($_POST['order-discount'])) {
			$discount_err = "Order discount required.";
		}

		if (empty($date_err) && empty($time_err) && empty($discount_err)) {
               //required fields satisfied, redirect to result page
		?>
		<form id='updateForm' action='updateOrderResult.php' method='post'>
			<input type='hidden' name='order-data' value='<?php echo serialize($_POST)?>'>     
		</form>
		<script>
			document.getElementById("updateForm").submit();
		</script>
			<?php
		} else {
			//show form again with error messages
			$data = $_POST;
			$ID = $_POST['ID'];
			$date = $_POST['order-date'];
			$time = $_POST['order-time'];
			$discount = $_POST['order-discount'];
			$supplier = $_POST['order-supplier'];
			
		}
	}
?>
<form action='' method='post'>
<div class='order-wrap'>
	<div>
	<h3>Edit Order #<?php echo $ID?>'s details below:</h3>
	<table class="text-input">
		<?php 
		if (!empty($date_err)) {
			echo '<tr><td><span class="prod-err">'.$date_err.'</span></td></tr>';
		} ?>
		<tr>
			<td>
				Date <span style='color: red'>*</span>:
			</td>
			<td>
				<input type='date' name='order-date' value='<?php echo $date ?>'>
			</td>
		</tr>
		<?php 
		if (!empty($time_err)) {
			echo '<tr><td><span class="prod-err">'.$time_err.'</span></td></tr>';
		} ?>
		<tr>
			<td>
				Time <span style='color: red'>*</span>:
			</td>
			<td>
				<input type='time' name='order-time' value='<?php echo $time ?>'>
			</td>
		</tr>
		<?php 
		if (!empty($discount_err)) {
			echo '<tr><td><span class="prod-err">'.$discount_err.'</span></td></tr>';
		} ?>
		<tr>
			<td>
				Discount (%)<span style='color: red'>*</span>:
			</td>
			<td>
				<input type='number' name='order-discount' step='1' value='<?php echo $discount ?>'>
			</td>
		</tr>
		<tr>
			<td>
				Supplier:
			</td>
			<td>
				<input type='text' name='order-supplier' value='<?php echo $supplier ?>'>
			</td>
		</tr>
	</table>
	<input type='hidden' name='ID' value='<?php echo $ID;?>'>
	<a href='./orders.php'>
		<div class='cancel'>
			<h4>Cancel</h4>
		</div>
	</a>
	<input class='complete' type='submit' value='Update' name='update'>
	<h3>Add or remove order items below:</h3>
</div>
</div>
</form>

<div class='order-prodlist-wrapper'>
    <div class='order-prodlist-edit-header'>
        <span><h4>Product</h4></span>
        <span><h4>Size</h4></span>
        <span><h4>Quantity</h4></span>
        <span><h4>Unit Price</h4></span>
        <span><h4>Subtotal</h4></span>
    </div>

<?php 
$sql = "select * from item join buys on item.ID = buys.I_ID where buys.O_ID = :ID";
if ($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
    $ID = $data['ID'];
    if($stmt->execute()){
        if($stmt->rowCount() > 0){
            ?>
 
                <?php 
                foreach ($stmt as $row) { 
                ?>
                <div class = 'order-prodlist-edit-box'>
                    <span><?php echo $row['name']?></span>
                    <span><?php echo $row['size']?></span>
                    <span><?php echo $row['quantity']?></span>
                    <span>$<?php echo $row['unit_price']?></span>
                    <span>$<?php echo number_format($row['quantity']*$row['unit_price']*
                    (1-$data['discount']/100),2)?></span>
					<span>
					<form method='post' action='deleteOrderItemResult.php'>
						<input type='hidden' name='I_ID' value='<?php echo $row['ID'] ?>'/>
						<input type='hidden' name='item_name' value='<?php echo $row['name']?>' />
						<input type='hidden' name='data' value='<?php echo serialize($data)?>'/>
						<button>
							<img class='icon' style='max-width: 25px;' src='resources/images/delete.png'/>
						</button>
					</form>
					<span>
                </div>
                <?php } 
        } 
    } 
    unset($stmt);
}
unset($pdo);
?>
<form method='post' action='createOrderItem.php'>
<input type='hidden' name='data' value='<?php echo serialize($data)?>' />
	<div class = 'order-prodlist-add'>
		<button>
			<img class='icon' style='max-width: 30px;' src='./resources/images/plus-icon3.png' />
		</button>
	</div>
</form>
</div>
<?php } else {
    echo "<h4>Data error...</h4>"; ?>
    <a href='./orders.php'>
	<div class='home'>
		<h4>Back to Orders</h4>
	</div>
    </a>
<?php } ?>