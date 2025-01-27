<?php
session_start();
require("./includes/connection.php");

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST["archiveIngredients_id"];

  $stock_name = $conn->query("SELECT * FROM stocks WHERE stock_id = '$id'")->fetch_assoc()["stock_name"];

  $conn->query("
            UPDATE `stocks` 
                SET
             `archive_status`='0',
             `date_archived`='$date',
             `date_added`='1'
              WHERE stock_id = '$id'
  ");
}

include("./includes/updateStockStatus.php");
include("./includes/updateExpirationStatus.php");

$conn->query("
INSERT INTO `activity_logs`
        (`activity_logs`, 
        `date_created`, 
        `added_by`) 
    VALUES 
    ('Restored the Ingredient named $stock_name.',
    '$date',
    '$user_id')
");


$_SESSION['success_message'] = 'Ingredient successfully Restored!';
header("location: ./archive-ingredients.php");
exit();
