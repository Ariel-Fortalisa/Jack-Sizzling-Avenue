<?php
header('Content-Type: application/json');
include("../includes/connection.php");
date_default_timezone_set('Asia/Manila');

$last7days = isset($_GET["last7days"]) ? $_GET["last7days"] : "current";

$totalArray = [];
$dateArray  = [];

if ($last7days == "current") {
    for ($x = 7; $x >= 1; $x--) {
        $dateLabels = date("Y-m-d", strtotime("-" . ($x - 1) . " days"));
        
        $sql = "SELECT SUM(total_amount) AS total, tr.date_created
                FROM transactions tr
                WHERE YEAR(`date_created`) = YEAR('$dateLabels') AND MONTH(`date_created`) = MONTH('$dateLabels') AND DAY(`date_created`) = DAY('$dateLabels')";
        
        $result = $conn->query($sql);
        
        // Prepare the date and total sales
        $date = date("M d Y", strtotime($dateLabels));
        $total = 0;
        
        // Sum the total sales for that specific day
        while ($row = $result->fetch_assoc()) {
            $total += $row["total"];
        }

        $totalArray[] = $total;
        $dateArray[] = $date;
    }
    
    echo json_encode([
        'total_sales' => $totalArray,
        'dates' => $dateArray
    ]);
}
?>
