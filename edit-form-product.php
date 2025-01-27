<?php
session_start();
require("./includes/connection.php");

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productName = $_POST["editproduct_name"];
    $productCategory = $_POST["editProduct-category"];
    $productId = $_POST["editproduct_id"];
    $currentImage = $_POST["currentImage"];
    $editsize_id = $_POST["editsize_id"];
    $editingredients_id = $_POST["editingredients_id"];

    // Update product information
    $productSQL = "
        UPDATE `products` 
        SET 
            `product_name`='$productName',
            `category`='$productCategory'
        WHERE 
            `id` = $productId
    ";

    $productResult = $conn->query($productSQL);

    if (!$productResult) {
        die("Product update failed: " . $conn->error);
    }

    // Upload product image and move to upload folder
    if (isset($_FILES["editImage"]) && $_FILES["editImage"]["error"] == UPLOAD_ERR_OK) {
        $uploaddir = './upload/products/';
        $uploadfile = $uploaddir . 'product_' . $productId . '.png';
        move_uploaded_file($_FILES["editImage"]['tmp_name'], $uploadfile);
    } else {
        // Use the current image if no new image is uploaded
        $uploadfile = $currentImage;
    }

    // Process and update size, ingredients, and price
    $sizes = $_POST['sizeProduct-name'];
    $prices = $_POST['productPrice'];
    $sizeCount = count($sizes);

    //delete previous sizes and ingredients
    $conn->query("DELETE FROM product_size WHERE product_id = $productId");
    $conn->query("DELETE FROM product_ingredients WHERE product_id = $productId");
    $conn->query("DELETE FROM add_ons WHERE product_id = $productId");

    // Loop through each size
    for ($i = 0; $i < $sizeCount; $i++) {
        $sizeName = $sizes[$i];
        $sizePrice = $prices[$i];

        // Insert each size and price into the database
        $sizeSQL = "INSERT INTO `product_size`
                    (`product_id`, 
                    `size_name`, 
                    `price`) 
                    VALUES 
                    ('$productId',
                     '$sizeName', 
                     '$sizePrice')";
        $sizeResult = $conn->query($sizeSQL);

        $size_id = $conn->query("SELECT MAX(size_id) AS id FROM product_size")->fetch_assoc()["id"];

        if (!$sizeResult) {
            die("Size insertion failed: " . $conn->error);
        }


        // Loop through each key in $_POST that starts with 'stockQty_'
        $ingredientsResult = $conn->query('
            SELECT * FROM stocks 
            WHERE 1
        ');

        while ($ingR = $ingredientsResult->fetch_assoc()) {
            if ((isset($_POST["stockQty_" . $ingR["stock_id"]][$i]) and $_POST["stockQty_" . $ingR["stock_id"]][$i] > 0)) {
                $stock_id = $ingR["stock_id"];
                $stockQTY =  $_POST["stockQty_" . $ingR["stock_id"]][$i];
                
                $ingredientSQL = "INSERT INTO `product_ingredients`
                    (`product_id`, 
                    `stock_id`, 
                    `size_id`,
                    `quantity`)
                    VALUES 
                        ('$productId',
                        '$stock_id',
                        '$size_id',
                        '$stockQTY')";
                $ingredientResult = $conn->query($ingredientSQL);
            }
        }

        

        // foreach ($_POST as $key => $stockqty) {
        //     if (strpos($key, 'stockQty_') === 0) {
        //         $stock_id = explode('_', $key)[1]; // Extract stock_id from the key name

        //         // Loop through each quantity value in the stock array
        //         foreach ($stockqty as $stockQTY) {
        //             // Only insert if stock quantity is greater than 0
        //             if ($stockQTY > 0) {
        //                 // Insert the stock quantity and stock_id into product_ingredients
        //                 $ingredientSQL = "INSERT INTO `product_ingredients`
        //                           (`product_id`, 
        //                            `stock_id`, 
        //                            `size_id`,
        //                            `quantity`)
        //                           VALUES 
        //                           ('$productId',
        //                            '$stock_id',
        //                            '$size_id',
        //                            '$stockQTY')";
        //                 $ingredientResult = $conn->query($ingredientSQL);

        //                 if (!$ingredientResult) {
        //                     die("Ingredient insertion failed: " . $conn->error);
        //                 }
        //             }
        //         }
        //     }
        // }
    }

    if(isset($_POST["addons-Price"]) && isset($_POST["addons-Name"])){
        $addonsName = $_POST["addons-Name"];
        $addonsPrice = $_POST["addons-Price"];
        

        for($x = 0; $x < count($addonsName); $x++){
            $conn->query("
                INSERT INTO `add_ons`
                    (`product_id`, 
                    `addons_name`, 
                    `price`) 
                VALUES
                    ('$productId',
                    '".$addonsName[$x]."',
                    '".$addonsPrice[$x]."')
            ");
        }

    }

    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Update the details of product named $productName.',
        '$date',
        '$user_id')
    ");

    $_SESSION["success_message"] = "Product Successfully Updated!";
    header("location: ./products.php");
    exit();
} else {
    $_SESSION["error_message"] = "Invalid request method";
    header("location: ./products.php");
    exit();
}
