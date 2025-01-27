<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $editId = $_POST["editStock-id"];
    $editName = $_POST["editStock-Item_name"];
    $editCost = $_POST["editStock-cost"];
    $editUnit = $_POST["editunit_stock"];
    $editCritical = $_POST["editStock-critical"];

   $stockSQL = "UPDATE `stocks`
                        SET
                        `stock_name`='$editName',
                        `cost`='$editCost',
                        `unit`='$editUnit',
                        `crit`='$editCritical',
                        `edit_by`='1',
                        `edit_date`='$date'
                        WHERE 
                            stock_id = '$editId'";
    $stockresult = $conn->query($stockSQL);

    if (!$stockresult) {
        die("Stock edit failed: " . $conn->error);
    }

    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Updated the details of $editName',
        '$date',
        '$user_id')
");


    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");

    $_SESSION['success_message'] = 'Ingredient successfully Updated!';
    header("location: ./ingredients.php");
    exit();

} else {
    $_SESSION["error_message"] = "Something went wrong!";
    header("location: ./ingredients.php");
    exit();
}
