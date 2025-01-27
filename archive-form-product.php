<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $product_id = $_POST["archiveProduct-id"];
    $archive_Status = $_POST["archiveProduct-status"];

    $conn->query("
         UPDATE `products`
                SET 
                `archive_status`='archived'
                 WHERE 
                 `id` = $product_id
    ");

    $product_name = $conn->query("SELECT * FROM products WHERE id = '$product_id'")->fetch_assoc()["product_name"];

    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Archived the product named $product_name.',
        '$date',
        '$user_id')
");
    

    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");


    $_SESSION['success_message'] = 'Product successfully Archived!'; 
    header("location: ./products.php");
    exit();

}


?>