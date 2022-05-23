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
<div class='message'>
<?php
    if ($_POST['atype'] == 'insert'){
    if ($_POST['prod-name'] && $_POST['prod-price']) {
        $name = "'".$_POST['prod-name']."'";
        if ($_POST['prod-size']){
            $size = "'".$_POST['prod-size']."'";
        } else {
            $size = "null";
        }
        if ($_POST['prod-desc']){
            $description = "'".$_POST['prod-desc']."'";
        } else {
            $description = "null";
        }
        $img_url = "'".$_POST['prod-img']."'";

        try {
            $dbh = new PDO('mysql:host=localhost;dbname=inventory', 'nick', 'Fringe2022!');
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "insert into item values (null,".$name.",".$description.",".$size.",".$img_url.")";
            $dbh->exec($sql);
            echo '<h4>Product "'.$name.'" created successfully!</h4>';
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        $dbh=null;
        echo "</div><a href='products.php'><div class='home'>
        <h4>Ok</h4></div></a>";
    } else {
        echo "<h4>Missing product name or price.</h4></div>
        <a onclick='history.go(-1)'><div class='home'>
        <h4>Back</h4></div></a>";
    }
    } elseif ($_POST['atype'] == 'delete'){
        $data = unserialize($_POST['data']);
        $ID = $data['ID'];
        $name = $data['name'];
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=inventory', 'nick', 'Fringe2022!');
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "delete from item where ID = ".$ID;
            $dbh->exec($sql);
            echo '<h4>Product "'.$name.'" deleted successfully!</h4>';
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        $dbh=null;
        echo "</div><a href='products.php'><div class='home'>
        <h4>Ok</h4></div></a>";
    } else {

        if ($_POST['prod-name'] && $_POST['prod-price']) {
            $ID = $_POST['ID'];

            $name = "'".$_POST['prod-name']."'";

            if ($_POST['prod-brand']){
                $brand = "'".$_POST['prod-brand']."'";
            } else {
                $brand = "null";
            }

            if ($_POST['prod-size']){
                $size = "'".$_POST['prod-size']."'";
            } else {
                $size = "null";
            }

            $price = $_POST['prod-price'];

            if ($_POST['prod-desc']){
                $description = "'".$_POST['prod-desc']."'";
            } else {
                $description = "null";
            }

            $img_url = "'".$_POST['prod-img']."'";
    
            try {
                $dbh = new PDO('mysql:host=localhost;dbname=inventory', 'nick', 'Fringe2022!');
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "update item set name = ".$name.", description = ".$description.",
                size = ".$size.", price = ".$price.", brand = ".$brand.", 
                img_url = ".$img_url." where ID = ".$ID;
                $dbh->exec($sql);
                echo '<h4>Product "'.$name.'" updated successfully!</h4>';
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
            $dbh=null;
            echo "</div><a href='products.php'><div class='home'>
            <h4>Ok</h4></div></a>";
        } else {
            echo "<h4>Please fill out all required fields.</h4></div>
            <a onclick='history.back()'><div class='home'>
            <h4>Back</h4></div></a>";
        }
    }
?>
</body>
</html>