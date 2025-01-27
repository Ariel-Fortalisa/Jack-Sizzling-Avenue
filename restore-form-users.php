<?php
session_start();
require("./includes/connection.php");

$Restore_user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $user_id = $_POST["restoreuser_id"];

    $conn->query("
         UPDATE `users`
                SET 
                `archive_status`='0'
                 WHERE 
                 `user_id` = $user_id
    ");
}

    $username = $conn->query("SELECT * FROM users WHERE user_id = '$user_id'")->fetch_assoc()["username"];

    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");

    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Restored the Account of username $username.',
        '$date',
        '$Restore_user_id')

");

    $_SESSION['success_message'] = 'User account successfully Restored!';   
    header("location: ./archive-users.php");
    exit();


?>