<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $unit_id = $_POST["restoremeasurement_id"];

        $unitSQL = $conn->query("
                UPDATE `unit_of_measurement` 
                    SET 
                    `archive_status` = '0'
                    WHERE 
                    unit_id = $unit_id
        ");
    }

    $unit_name = $conn->query("SELECT * FROM unit_of_measurement WHERE unit_id = $unit_id")->fetch_assoc()["unit_name"];

    include("./includes/updateStockStatus.php");
    include("./includes/updateExpirationStatus.php");

    $conn->query("
    INSERT INTO `activity_logs`
            (`activity_logs`, 
            `date_created`, 
            `added_by`) 
        VALUES 
        ('Restored the unit of measurement named $unit_name.',
        '$date',
        '$user_id')

");

$_SESSION['success_message'] = 'Unit of measurement successfully Restored!';    
header("location: ./archive-measurement.php");
exit();



?>

