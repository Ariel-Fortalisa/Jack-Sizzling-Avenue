<?php
session_start();
require("./includes/connection.php");

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

$user_id = $_SESSION["user_id"];

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $unit_name = $_POST["measurement_name"];

    $conn->query("INSERT INTO `unit_of_measurement`
                    (`unit_name`,
                    `archive_status`) 
                    VALUES 
                    ('$unit_name',
                    '0')
                    
    "); 
    
    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Added a new unit of measurement named $unit_name.',
        '$date',
        '$user_id')
    ");

    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");

      $_SESSION['success_message'] = 'Unit of Measurement successfully added!';
      header("Location: ./measurement.php");
      exit();
}


?>