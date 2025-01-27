<?php
require("./includes/connection.php");

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $archiveProductid = $_POST["archiveProduct-id"];
    $archiveProduct_status = $_POST["archiveProduct-status"];

  $conn->query("
            UPDATE `products` 
                SET
             `archive_status`='archived',
             `date_archived`='$date',
             `archived_by`='1'
              WHERE `id` = '$archiveProductid'
  ");
  

}
include("./includes/updateStockStatus.php");
include("./includes/updateExpirationStatus.php");
  $_SESSION["message"] = "error";
  header("location: ./product-page.php");
  exit();

?>

?>