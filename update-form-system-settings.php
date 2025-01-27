<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $store_name = $_POST["store_name"];
    $address = $_POST["address"];
    $tin = $_POST["tin"];
    $contact = $_POST["contact"];
    $id = $_POST["id"];

    $categorySQL = $conn->query("
            UPDATE `system` 
                SET 
                `store_name` = '$store_name',
                `store_address`= '$address',
                `tin-number`= '$tin',
                `contact` = '$contact'
                WHERE 
                system_id = '$id'
    ");
}

$conn->query("
INSERT INTO `activity_logs`
        (`activity_logs`, 
        `date_created`, 
        `added_by`) 
    VALUES 
    ('Updated the details of the store.',
    '$date',
    '$user_id')
");

include("./includes/updateStockStatus.php");
include("./includes/updateExpirationStatus.php");

$_SESSION['success_message'] = 'Store details successfully Updated!';
header("location: ./system-settings.php");
exit();
