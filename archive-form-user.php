<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $Archiveuser_id = $_POST["Archive_userId"];

    $conn->query("
         UPDATE `users`
                SET 
                `archive_status`='1'
                 WHERE 
                 `user_id` = $Archiveuser_id
    ");

    $username = $conn->query("SELECT * FROM users WHERE user_id = '$Archiveuser_id'")->fetch_assoc()["username"];

    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Archived the Account of username $username.',
        '$date',
        '$user_id')

");

include("./includes/updateStockStatus.php");
include("./includes/updateExpirationStatus.php");

    $_SESSION['success_message'] = 'User account successfully Archived!'; 
    header("location: ./user-management.php");
    exit();

}
?>