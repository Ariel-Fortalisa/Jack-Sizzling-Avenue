<?php
session_start();
include('includes/connection.php');

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

$user_id = $_SESSION["user_id"];

$conn->query("
INSERT INTO `activity_logs`
        (`activity_logs`, 
        `date_created`, 
        `added_by`) 
    VALUES 
    ('Logout to the system.',
    '$date',
    '$user_id')

");

    session_destroy();
    header("Location: ./login-page.php");
    exit();
?>