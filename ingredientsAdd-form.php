<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $itemName = $_POST["newitemStock_name"];
    $cost = $_POST["new-cost"];
    $qty = $_POST["addnew-qty"];
    $unit = $_POST["unit"];
    $critical = $_POST["addnew-crit"] !== "" ? $_POST["addnew-crit"] : 0;
    $expdate = $_POST["addnew-expdate"] !== "" ? $_POST["addnew-expdate"] : "0000-00-00";

    $stockSQL = "INSERT INTO `stocks`(
                        `stock_id`,
                        `stock_name`, 
                        `cost`, 
                        `unit`,
                        `crit`,
                        `archive_status`, 
                        `date_archived`,
                        `stock_status`, 
                        `date_added`) 
                 VALUES (
                        '0',
                        '$itemName',
                        '$cost',
                        '$unit',
                        '$critical',
                        '0',
                        '0000-00-00 00:00:00',
                        '1',
                        '$date')";
    $stockresult = $conn->query($stockSQL);

    if (!$stockresult) {
        die("Stock insertion failed: " . $conn->error);
    }

    $stockId = $conn->query("SELECT MAX(`stock_id`) AS `maxStock_id` FROM `stocks`")->fetch_assoc()["maxStock_id"];

    $batchSQL = "INSERT INTO `batch`(
                    `batch_id`,
                    `stock_id`,
                    `qty`, 
                    `cost`, 
                    `expiration_date`, 
                    `date_created`, 
                    `archive_status`,
                    `date_archived`,
                    `archived_by`) 
                VALUES (
                    '0',
                    '$stockId',
                    '$qty',
                    '$cost',
                    '$expdate',
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

    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Added a new ingredients named $itemName',
        '$date',
        '$user_id')
");

    $_SESSION['success_message'] = 'Ingredient successfully Added!';
    header("location: ./ingredients.php");
    exit();
} else {
    $_SESSION["error_message"] = "Something went wrong!";
    header("location: ./ingredients.php");
    exit();
}
