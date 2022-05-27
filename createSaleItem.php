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
<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ 
    $data = unserialize($_POST['data']);
    $S_ID = $data['ID'];
    ?>
    <form action='createSaleItemResult.php' method='post'>
    <input type='hidden' name='S_ID' value='<?php echo $S_ID?>'/>
    <input type='hidden' name='data' value='<?php echo $_POST['data']?>'/>
    <div class='order-wrap'>
        <div>
            <h3>Add new item details below:</h3>
            <table class="text-input">
                <tr>
                    <td>
                        Product Name <span style='color: red'>*</span>:
                    </td>
                    <td>
                        <select name="item_info" required>
                            <?php 
                                $sql = "select * from item";
                                if($stmt = $pdo->prepare($sql)){
                                    if ($stmt->execute()){
                                        if($stmt->rowCount() > 0){
                                            foreach($stmt as $row) {

                                                echo "<option value='".serialize($row)."'>".$row['name']." - ".$row['size']."</option>";
                                            }
                                        }
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                    Quantity <span style='color: red'>*</span>:         
                    </td>
                    <td>
                        <input type='number' name='quantity' step='1' required>
                    </td>
                </tr>
                <tr>
                    <td>
                    Unit price ($) <span style='color: red'>*</span>: 
                    </td>
                    <td>
                        <input type='number' name='unit_price' step='0.01' required>
                    </td>
                </tr>
            </table>
            <a href='./sales.php'>
                <div class='cancel'>
                    <h4>Cancel</h4>
                </div>
            </a>
            <input class='complete' type='submit' value='Create' name='create'>
        </div>
    </div>
    </form>
    <?php
} else {
    echo "<h4>Data error...</h4>"; ?>
    <a href='./sales.php'>
	<div class='home'>
		<h4>Back to Sales</h4>
	</div>
    </a>
<?php } ?>

</body>
</html>