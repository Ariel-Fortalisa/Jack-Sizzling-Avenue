<?php
session_start();
require("./includes/connection.php");

$user_id = $_SESSION["user_id"];

date_default_timezone_set('Asia/Manila');
$date = date("Y-m-d H:i:s");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $unit_id = $_POST["editmeasurement_id"];
        $unit_name = $_POST["editmeasurement_name"];

        $old_name = $conn->query("SELECT * FROM unit_of_measurement WHERE unit_id = $unit_id")->fetch_assoc()["unit_name"];

        $conn->query("
        INSERT INTO `activity_logs`
                (`activity_logs`, 
                `date_created`, 
                `added_by`) 
            VALUES 
            ('Edited the unit of measurement from $old_name to $unit_name.',
            '$date',
            '$user_id')
    ");
    
        $unitSQL = $conn->query("
                UPDATE `unit_of_measurement` 
                    SET 
                    `unit_name` = '$unit_name'
                    WHERE 
                    unit_id = $unit_id
        ");
    }
    

$_SESSION['success_message'] = 'Unit of measurement successfully Updated!';
header("location: ./measurement.php");
exit();


?>
