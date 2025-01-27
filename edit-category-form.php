<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $category_id = $_POST["editcategory_id"];
    $category_name = $_POST["editcategory_name"];
    $addons = $_POST["editcategory_addons"];

    $old_name = $conn->query("SELECT * FROM categories WHERE id = $category_id")->fetch_assoc()["category_name"];

    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Edited the category from $old_name to $category_name.',
        '$date',
        '$user_id')
");
    $categorySQL = $conn->query("
            UPDATE `categories` 
                SET 
                `category_name`='$category_name',
                `add-ons`='$addons' 
                WHERE 
                id = $category_id
    ");
}

$_SESSION['success_message'] = 'Category successfully Updated!';
header("location: ./category.php");
exit();





?>