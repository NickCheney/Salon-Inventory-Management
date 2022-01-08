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
<div class='message'>
<?php
    if ($_POST['atype'] == 'insert'){
    if ($_POST['prod-name']) {
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
        echo "</div><a href='index.php'><div class='home'>
        <h4>Ok</h4></div></a>";
    } else {
        echo "<h4>Please include product name.</h4></div>
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
        echo "</div><a href='index.php'><div class='home'>
        <h4>Ok</h4></div></a>";
    } else {
        if ($_POST['prod-name']) {
            $ID = $_POST['ID'];
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
                $sql = "update item set name = ".$name.", description = ".$description.",
                size = ".$size.", img_url = ".$img_url." where ID = ".$ID;
                #echo $sql;
                $dbh->exec($sql);
                echo '<h4>Product "'.$name.'" updated successfully!</h4>';
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
            $dbh=null;
            echo "</div><a href='index.php'><div class='home'>
            <h4>Ok</h4></div></a>";
        } else {
            echo "<h4>Please include product name.</h4></div>
            <a onclick='history.go(-1)'><div class='home'>
            <h4>Back</h4></div></a>";
        }
    }
?>
</body>
</html>