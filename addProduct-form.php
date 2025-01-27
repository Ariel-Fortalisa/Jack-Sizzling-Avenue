<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productName = $_POST["addProduct-productName"];
    $productCategory = $_POST["addProduct-category"];

    // Insert product information
    $productSQL = "
        INSERT INTO `products`(
        `product_name`,
        `category`, 
        `product_status`, 
        `archive_status`,
        `date_added`, 
        `added_by`, 
        `date_archived`, 
        `archived_by`) 
        VALUES (
        '$productName',
        '$productCategory',
        'available',
        'unarchived',
        '$date',
        '1',
        '0000-00-00',
        '0'
    )";
    $productResult = $conn->query($productSQL);

    if (!$productResult) {
        die("Product insertion failed: " . $conn->error);
    }

    $productId = $conn->query("SELECT MAX(id) AS id FROM products")->fetch_assoc()["id"];

    // Upload product image and move to upload folder
    if (isset($_FILES["productImage"])) {
        $uploaddir = './upload/products/';
        $uploadfile = $uploaddir . 'product_' . $productId . '.png';
        move_uploaded_file($_FILES["productImage"]['tmp_name'], $uploadfile);
    }

    // Process and insert size, ingredients, and price
    $sizes = $_POST['sizeProduct-name'];
    $prices = $_POST['productPrice'];
    $sizeCount = count($sizes);

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

    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");


    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Added a new product named $productName.',
        '$date',
        '$user_id')

");

    $_SESSION['success_message'] = 'New Product successfully Added!'; 
    header("location: ./products.php");
    exit();
} else {
    $_SESSION["error_message"] = "Something went wrong Please try again!";
    header("location: ./products.php");
    exit();
}
