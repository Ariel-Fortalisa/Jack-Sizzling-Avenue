<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stock_id = $_POST["addnewBatch-stock_id"];
    $batch_qty = $_POST["addnewBatch-qty"];
    $batch_cost = $_POST["addNewBatch-cost"];
    $batch_expdate = $_POST["addnewBatch-expdate"];
      
        //get the expiration status of the expiration date
        $expirationStatus = "";
        if($batch_expdate  === "0000-00-00"){
            $expirationStatus = "0";
        }
        elseif($date >= $batch_expdate ){
            $expirationStatus = "3";
        }
        elseif($date >= date("Y-m-d", strtotime("-3 months", strtotime($batch_expdate ))) ){
            $expirationStatus = "2";
        }
        else{
            $expirationStatus = "1";
        }


    $batchSQL = "INSERT INTO `batch`(
                    `batch_id`,
                    `stock_id`,
                    `qty`, 
                    `cost`, 
                    `expiration_date`, 
                    `expiration_status`,
                    `date_created`, 
                    `archive_status`,
                    `date_archived`,
                    `archived_by`) 
                VALUES (
                    '0',
                    '$stock_id',
                    '$batch_qty',
                    '$batch_cost',
                    '$batch_expdate',
                    '$expirationStatus',
                    '$date',
                    '0',
                    '0000-00-00 00:00:00',
                    '1')";
                    
    $batchresult = $conn->query($batchSQL);

    if (!$batchresult) {
        die("Batch insertion failed: " . $conn->error);
    }

    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");

    $maxId = $conn->query("SELECT MAX(batch_id) as id FROM batch")->fetch_assoc()["id"];
    $stock_name = $conn->query("SELECT stock_name FROM stocks WHERE stock_id = '$stock_id'")->fetch_assoc()["stock_name"]; 

    $conn->query("
    INSERT INTO `activity_logs`
        (`activity_logs`,
        `date_created`, 
        `added_by`) 
    VALUES 
    ('Added a new batch for $stock_name with Batch ID #$maxId',
    '$date',
    '$user_id')
");

    $_SESSION['success_message'] = 'Stock In successfully Added!';
    header("location: ./ingredients.php");
    exit();
} else {
    $_SESSION["error_message"] = "Something went wrong!";
    header("location: ./ingredients.php");
    exit();
}


?>