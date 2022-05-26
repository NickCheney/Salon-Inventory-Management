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
<div class='message'>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $prod_data = unserialize($_POST['prod-data']);
    
    $ID = trim($prod_data['ID']);

    $name = trim($prod_data['name']);

    $sql = "delete from item where ID = :ID";
    
    if($stmt = $pdo->prepare($sql)){
        
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);

        try {
            $stmt->execute();
            echo '<h4>Product '.$name.' successfully deleted!</h4>';
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
echo "</div><a href='products.php'><div class='home'>
<h4>Ok</h4></div></a>";
?>
</body>
</html>