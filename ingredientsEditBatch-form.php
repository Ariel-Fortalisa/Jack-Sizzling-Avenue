<?php
session_start();
include("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $editBatch_id = $_POST["editBatch-batch_id"];
    $editBatch_qty = $_POST["editBatch-qty"];
    $editBatch_cost = $_POST["editBatch-cost"];
    $editBatch_expdate = $_POST["editexpiration_date"] !== "" ? $_POST["editexpiration_date"] : "0000-00-00";
    $editbatch_stock_id = $_POST["editbatch-stock_id"];

   $editBatchSQL = "UPDATE `batch`
                        SET
                        `qty`='$editBatch_qty',
                        `cost`='$editBatch_cost',
                        `expiration_date` = '$editBatch_expdate'
                        WHERE 
                            batch_id = '$editBatch_id'
                        ";
    $batchresult = $conn->query($editBatchSQL);

    if (!$batchresult) {
        die("batch edit failed: " . $conn->error);
    }

    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");

    $stock_name = $conn->query("SELECT stock_name FROM stocks WHERE stock_id = '$editbatch_stock_id'")->fetch_assoc()["stock_name"]; 

    $conn->query("
    INSERT INTO `activity_logs`
        (`activity_logs`, 
        `date_created`, 
        `added_by`) 
    VALUES 
    ('Updated batch details for $stock_name with Batch ID #$editBatch_id',
    '$date',
    '$user_id')");

    $_SESSION['success_message'] = 'Batch successfully Updated!';
    header("location: ./ingredients.php");
    exit();
} else {
    $_SESSION["message"] = "error";
    header("location: ./ingredients.php");
    exit();
}



?>