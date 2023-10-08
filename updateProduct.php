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

<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ ?>
<div class='prod-wrap'>
    
    <div>
        <?php
        $target_dir = "resources/images/";
        $name_err = $price_err = "";
        //first time accessing page
        if (isset($_POST['data'])) {
            $data = unserialize($_POST['data']);
            $ID = $data['ID'];
            $brand = $data['brand'];
            $name = $data['name'];
            $description = $data['description'];
            $size = $data['size'];
            $price = $data['price'];
            $quantity = $data['quantity'];
            $target_name = $data['img_url'];
            $target_file = $target_dir . $target_name;
            $old_quantity = $quantity;
        } //new product image was uploaded 
        else if (isset($_POST["upload_image"])) {
            //get fields from previous form
            $ID = $_POST['ID'];
            $brand = $_POST['prod-brand'];
            $name = $_POST['prod-name'];
            $description = $_POST['prod-desc'];
            $size = $_POST['prod-size'];
            $price = $_POST['prod-price'];
            $quantity = $data['prod-qnty'];
            $target_name = $_POST['prod-img'];
            $target_file = $target_dir . $target_name;
            $old_quantity = $_POST['prod-old-qnty'];
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $target_name = $ID . "_" . str_replace(" ","_",basename($_FILES["fileToUpload"]["name"]));
                $target_file = $target_dir . $target_name;
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            } else {  
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 5000000) {
                    echo "Sorry, image exceeds max size of 5 Mb.";
                } else {
                    echo "Sorry, there was an error uploading your image.";
                }
            }
        } else {//update button is clicked, should attempt to update product
            if(empty(trim($_POST["prod-name"]))){
                $name_err = "Product name required.";
            }
            if(empty(trim($_POST["prod-price"]))){
                $price_err = "Product price required.";
            }
            if($_POST["prod-qnty"] == ""){
                $quantity_err = "Product quantity required.";
            }

            if(empty($name_err) && empty($price_err) && empty($quantity_err)){
                //required fields satisfied, redirect to result page
                ?>
            <form id='updateForm' action='updateProductResult.php' method='post'>
                <input type='hidden' name='prod-data' value='<?php echo serialize($_POST)?>'>     
            </form>
            <script>
                document.getElementById("updateForm").submit();
            </script>
                <?php
            } else {
                //show form again with error messages
                $ID = $_POST['ID'];
                $brand = $_POST['prod-brand'];
                $name = $_POST['prod-name'];
                $description = $_POST['prod-desc'];
                $size = $_POST['prod-size'];
                $price = $_POST['prod-price'];
                $quantity = $_POST['prod-qnty'];
                $target_name = $_POST['prod-img'];
                $target_file = $target_dir . $target_name;
                $old_quantity = $_POST['prod-old-qnty'];
            }

        }
        echo "<img class='product' src='".$target_file."'>"; ?>
        <form action='' method='post' enctype='multipart/form-data'> 
            <h5>Select a product image:</h5>
            <input type='file' name='fileToUpload' id='fileToUpload'>
            <input type='submit' value='Upload Image' name='upload_image'>
       </div>
    
        <div>
            <h3>Add the following information:</h3>
                <table class="text-input">
                <?php 
                if (!empty($name_err)) {
                    echo '<tr><td><span class="prod-err">'.$name_err.'</span></td></tr>';
                } ?>
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
                    <?php 
                    if (!empty($price_err)) {
                        echo '<tr><td><span class="prod-err">'.$price_err.'</span></td></tr>';
                    } ?>
                    <tr>
                        <td>
                            Price <span style='color: red'>*</span>:
                        </td>
                        <td>
                            <input type='number' name='prod-price' step='0.01' value='<?php echo $price; ?>'>
                        </td>
                    </tr>
                    <?php 
                    if (!empty($quantity_err)) {
                        echo '<tr><td><span class="prod-err">'.$quantity_err.'</span></td></tr>';
                    } ?>
                    <tr>
                        <td>
                            Quantity <span style='color: red'>*</span>:
                        </td>
                        <td>
                            <input type='number' name='prod-qnty' step='1' value='<?php echo $quantity; ?>'>
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
                <input type='hidden' name='prod-old-qnty' value='<?php echo $old_quantity;?>'>
                <a href='./products.php'>
                    <div class='cancel'>
                        <h4>Cancel</h4>
                    </div>
                </a>
                <input class='complete' type='submit' value='Update' name='update'>
            
            </div>
        </form>
    </div>
<?php } else {
    echo "<h4>Data error...</h4>"; ?>
    <a href='./products.php'>
	<div class='home'>
		<h4>Back to Products</h4>
	</div>
    </a>
<?php } ?>

</body>
</html>