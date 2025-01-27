<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");


$new = '';
$old = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_ID = $_POST["user_id"];
    $role = $_POST["edit_userrole"];

    $old_role = $conn->query("SELECT * FROM users WHERE user_id = '$user_ID'")->fetch_assoc()["user_role"];
    $username = $conn->query("SELECT * FROM users WHERE user_id = '$user_ID'")->fetch_assoc()["username"];

    if($role == 1){
        $new = 'Admin';
    }else if($role == 2){
        $new = 'Inv. Admin';
    }else{
        $new = 'Cashier';
    }

    if($old_role == 1){
        $old = 'Admin';
    }else if($old_role == 2){
        $old = 'Inv. Admin';
    }else{
        $old = 'Cashier';
    }

    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Changed the role of username $username from $old to $new.',
        '$date',
        '$user_id')

");


    $updateSQL = $conn->query("UPDATE `users` SET `user_role` = '$role' WHERE user_id = '$user_ID'");


    $_SESSION['success_message'] = 'User acoount successfully change the Role!'; 
    header("location: ./user-management.php");
    exit();
}

?>