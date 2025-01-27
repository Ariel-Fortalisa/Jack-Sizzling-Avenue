<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $archiveBatchid = $_POST["archivebatch_id"];
    $archiveBatch_status = $_POST["archivebatch_status"];
    $archivebatch_stock_id = $_POST["archivebatch_stock_id"];

  $conn->query("
            UPDATE `batch` 
                SET
             `archive_status`='1',
             `date_archived`='$date',
             `archived_by`='1'
              WHERE `batch_id` = '$archiveBatchid'
  ");
}

$stock_name = $conn->query("SELECT stock_name FROM stocks WHERE stock_id = '$archivebatch_stock_id'")->fetch_assoc()["stock_name"]; 

include("./includes/updateStockStatus.php");
include("./includes/updateExpirationStatus.php");

$conn->query("
INSERT INTO `activity_logs`
        (`activity_logs`, 
        `date_created`, 
        `added_by`) 
    VALUES 
    ('Archived the batch $stock_name with batch ID $archiveBatchid.',
    '$date',
    '$user_id')

");

include("./includes/updateStockStatus.php");
include("./includes/updateExpirationStatus.php");

  $_SESSION['success_message'] = 'Batch successfully Archived!';
  header("location: ./ingredients.php");
  exit();

?>
