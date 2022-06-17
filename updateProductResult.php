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

    $name = trim($prod_data['prod-name']);

    if ($prod_data['prod-brand']){
        $brand = trim($prod_data['prod-brand']);
    } else {
        $brand = null;
    }

    if ($prod_data['prod-size']){
        $size = trim($prod_data['prod-size']);
    } else {
        $size = null;
    }

    $price = $prod_data['prod-price'];

    if ($prod_data['prod-desc']){
        $description = trim($prod_data['prod-desc']);
    } else {
        $description = null;
    }

    $img_url = trim($prod_data['prod-img']);

    $sql = "UPDATE item SET name = :name, description = :description, 
        size = :size, price = :price, brand = :brand, 
        img_url = :img_url where ID = :ID";
    
    if($stmt = $pdo->prepare($sql)){
        
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":size", $size, PDO::PARAM_STR);
        $stmt->bindParam(":price", $price, PDO::PARAM_STR);
        $stmt->bindParam(":brand", $brand, PDO::PARAM_STR);
        $stmt->bindParam(":img_url", $img_url, PDO::PARAM_STR);
        $stmt->bindParam(":ID", $ID, PDO::PARAM_INT);
  
        try {
            $stmt->execute();
            echo '<h4>Product '.$name.' updated successfully!</h4>';
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