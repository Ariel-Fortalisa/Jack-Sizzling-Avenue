<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST["archivestock_id"];
  $archive_status = $_POST["archivestock_status"];

  $stock_name = $conn->query("SELECT * FROM stocks WHERE stock_id = '$id'")->fetch_assoc()["product_name"];

  $conn->query("
            UPDATE `stocks` 
                SET
             `archive_status`='1',
             `date_archived`='$date',
             `date_added`='1'
              WHERE stock_id = '$id'
  ");
}

$conn->query("
INSERT INTO `activity_logs`
        (`activity_logs`, 
        `date_created`, 
        `added_by`) 
    VALUES 
    ('Archived the Ingredients named $stock_name.',
    '$date',
    '$user_id')
");

$_SESSION['success_message'] = 'Ingredient successfully Archived!';
header("location: ./ingredients.php");
exit();
