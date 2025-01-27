<?php
session_start();
require("./includes/connection.php");

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");


$user_id = $_SESSION["user_id"];

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $category_id = $_POST["restorecategory_id"];
    $category_name = $_POST["restorecategory_name"];

    $conn->query("
         UPDATE `categories`
                SET 
                `archive_status`='0'
                 WHERE 
                 `id` = $category_id
    ");

    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");

    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Restored the category named $category_name.',
        '$date',
        '$user_id')

");

    $_SESSION['success_message'] = 'Category successfully Restored!';
    header("location: ./archive-category.php");
    exit();

}


?>