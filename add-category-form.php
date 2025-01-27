<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $category_name = $_POST["addCategory_name"];
    $category_addons = $_POST["addcategory_addons"];

    $conn->query("
          INSERT INTO `categories`
                    (`category_name`, 
                    `archive_status`, 
                    `add-ons`) 
                    VALUES 
                    ('$category_name',
                    '0',
                    '$category_addons')
    ");
    
    $conn->query("
        INSERT INTO `activity_logs`
                (`activity_logs`, 
                `date_created`, 
                `added_by`) 
            VALUES 
            ('Added a new category named $category_name.',
            '$date',
            '$user_id')

    ");

    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");
    
    $_SESSION['success_message'] = 'Category successfully added!';
    header("Location: ./category.php");
    exit();

}

?>