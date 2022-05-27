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

<div class='message'>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$data = unserialize($_POST['data']);
    $O_ID = trim($data['ID']);
    $I_ID = $_POST['I_ID'];
	$item_name = $_POST['item_name'];
	
    $sql = "delete from buys where I_ID = :I_ID and O_ID = :O_ID";
    
    if($stmt = $pdo->prepare($sql)){
        
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":I_ID", $I_ID, PDO::PARAM_INT);
		$stmt->bindParam(":O_ID", $O_ID, PDO::PARAM_INT);

        try {
            $stmt->execute();
            echo '<h4>Product "'.$item_name.'" successfully deleted from Order '.$O_ID.'!</h4>';
        } catch (PDOException $e) {
            echo "Error! ".$e->getMessage();
        }
        unset($stmt);
	
    } else {
        echo "Internal error...";
    }
} else {
    echo "Data error...";
}
unset($pdo);
?>
</div>
<form action='updateOrder.php' method='post'>
	<input type='hidden' name='data' value='<?php echo serialize($data)?>'/>
	<button class='home'>
		<h4>Ok</h4>
	</button>
</form>

</body>
</html>
