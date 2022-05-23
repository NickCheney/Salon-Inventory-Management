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

<div class='prod-wrap'>
    <div>
        <?php
        $target_name = "default-product.jpg";
        if ($_POST['data']){
            $data = unserialize($_POST['data']);
            $ID = $data['ID'];
            $brand = $data['brand'];
            $name = $data['name'];
            $description = $data['description'];
            $size = $data['size'];
            $price = $data['price'];
            $target_name = $data['img_url'];
        } 
        $target_dir = "resources/images/";
        $target_file = $target_dir . $target_name;

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $target_name = basename($_FILES["fileToUpload"]["name"]);
            $target_file = $target_dir . $target_name;
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "<img class='product' src='".$target_file."'>";
            } 
        } else {
            echo "<img class='product' src='".$target_file."'>";
            

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 5000000) {
            echo "Sorry, image exceeds max size of 5 Mb.";
            } else {
                echo "Sorry, there was an error uploading your image.";
            }
        }
    } else {
        echo "<img class='product' src='".$target_file."'>";
    }
        ?>
        <form action='' method='post' enctype='multipart/form-data'>
            <h5>Select a product image:</h5>
            <input type='hidden' name='data' value='<?php echo serialize($data); ?>' />
            <input type='file' name='fileToUpload' id='fileToUpload'>
            <input type='submit' value='Upload Image' name='submit'>
        </form>
    </div>

    <div>
        <h3>Add the following information:</h3>
        <form action='result.php' method='post'>
            <table class="text-input">
                <tr>
                    <td>
                        Product Name <span style='color: red'>*</span>:
                    </td>
                    <td>
                        <input type='text' name='prod-name' value='<?php echo $name; ?>'>
                    </td>
                </tr>
                <tr>
                    <td>
                        Brand (optional):
                    </td>
                    <td>
                        <input type='text' name='prod-brand' value='<?php echo $brand; ?>'>
                    </td>
                </tr>
                <tr>
                    <td>
                        Size (optional):
                    </td>
                    <td>
                        <input type='text' name='prod-size' value='<?php echo $size; ?>'>
                    </td>
                </tr>
                <tr>
                    <td>
                        Price <span style='color: red'>*</span>:
                    </td>
                    <td>
                        <input type='number' name='prod-price' step='0.01' value='<?php echo $price; ?>'>
                    </td>
                </tr>
                <tr>
                    <td>
                        Description (optional):
                    </td>
                    <td>
                        <textarea name='prod-desc' rows='5' cols='50'><?php echo $description; ?></textarea>
                    </td>
                </tr>
            </table>
            <input type='hidden' name='prod-img' value='<?php echo $target_name;?>'>
            <input type='hidden' name='ID' value='<?php echo $ID;?>'>
            <a href='./products.php'>
	            <div class='cancel'>
                    <h4>Cancel</h4>
                </div>
            </a>
            <input type='hidden' name='atype' value='update'>
            <input class='complete' type='submit' value='Update'>
        </form>
    </div>
</div>

</body>
</html>