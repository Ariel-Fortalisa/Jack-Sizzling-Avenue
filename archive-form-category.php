<?php
session_start();
require("./includes/connection.php");


$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $category_id = $_POST["archivecategory_id"];
    $category_name = $_POST["archivecategory_name"];

    $conn->query("
         UPDATE `categories`
                SET 
                `archive_status`='1'
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
        ('Archived the category named $category_name.',
        '$date',
        '$user_id')

");


    $_SESSION['success_message'] = 'Category successfully Archive!';
    header("location: ./category.php");
    exit();

}


?>