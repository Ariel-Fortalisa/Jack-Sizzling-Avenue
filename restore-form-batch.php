<?php
session_start();

$user_id = $_SESSION["user_id"];

require("./includes/connection.php");

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $batch_id = $_POST["restore_batch_id"];
    $restore_stock_id = $_POST["restore_stock_id"];

    $conn->query("
         UPDATE `batch`
                SET 
                `archive_status`='0'
                 WHERE 
                 `batch_id` = $batch_id
    ");

    $stock_name = $conn->query("SELECT stock_name FROM stocks WHERE stock_id = '$restore_stock_id'")->fetch_assoc()["stock_name"]; 

    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");

    $conn->query("
    INSERT INTO `activity_logs`
        (`activity_logs`, 
        `date_created`, 
        `added_by`) 
    VALUES 
    ('Restored the batch $stock_name with batch ID $batch_id.',
    '$date',
    '$user_id')

");

    $_SESSION['success_message'] = 'Batch successfully Restored!';
    header("location: ./archive-batch.php");
    exit();
}
