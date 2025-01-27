<?php
header('Content-Type: application/json');
include("../includes/connection.php");
date_default_timezone_set('Asia/Manila');

$basis = isset($_GET["basis"]) ? $_GET["basis"] : "Daily";
$month = isset($_GET['month']) ? $_GET['month'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';

$dateArray = [];
$totalArray = [];
$data = [];


if ($basis == "Daily") {
    // $year = date("Y");
    // $month = date("m");
    $maxDay = $month === date("m") ? date("d"): date("t", strtotime("$year-$month-1"));

    for ($x = 1; $x <= $maxDay; $x++) {
        $sql = "SELECT SUM(`total_amount`) AS `total`
                FROM transactions
                WHERE YEAR(`date_created`) = '$year' 
                  AND MONTH(`date_created`) = '$month' 
                  AND DAY(`date_created`) = $x";
        $result = $conn->query($sql);

        $date = date("M d", strtotime("$year-$month-$x"));
        $total = 0;
        $row = $result->fetch_assoc();
        if ($row) {
            $value = ($row["total"] == NULL) ? 0 : $row["total"];
            $total = $value;
        }

        $dateArray[] = $date;
        $totalArray[] = $total;
    }
} else if ($basis == "Weekly") {
    $days = [0, 7, 14, 21, 28, 31];
    for ($x = 0; $x < 4; $x++) {
        $startDay = $days[$x] + 1;
        $endDay = $days[$x + 1];

        $sql = "SELECT IFNULL(SUM(`total_amount`), 0) AS `total`
                FROM transactions
                WHERE YEAR(`date_created`) = '$year'
                  AND MONTH(`date_created`) = '$month' 
                  AND DAY(`date_created`) BETWEEN $startDay AND $endDay";
        $result = $conn->query($sql);

        if (!$result) {
            die("Invalid query: " . $conn->error);
        }

        $date = "Week " . ($x + 1);
        $total = 0;
        $row = $result->fetch_assoc();
        if ($row) {
            $value = ($row["total"] == NULL) ? 0 : $row["total"];
            $total = $row["total"];
        }

        $dateArray[] = $date;
        $totalArray[] = $total;
    }
} else if ($basis == "Monthly") {
    for ($x = 1; $x <= $month; $x++) {
    $sql = "SELECT SUM(total_amount) AS `total`
        FROM transactions
        WHERE YEAR(`date_created`) = '$year'
            AND MONTH(`date_created`) = $x";
    $result = $conn->query($sql);

      $date = date("M", strtotime("$year-$x"));
      $total = 0;
      while ($row = $result->fetch_assoc()) {
        $total += $row["total"];
      }
      $dateArray[] = $date;
      $totalArray[] = $total;
  }
 
}else if($basis == "Yearly"){
    $minYear = $conn->query("SELECT YEAR(MIN(date_created)) AS min_year FROM transactions")->fetch_assoc()["min_year"];
    $maxYear  = $conn->query("SELECT YEAR(MAX(date_created)) AS min_year FROM transactions")->fetch_assoc()["min_year"];
    for ($x = $minYear; $x <= $maxYear; $x++) {
     $sql = "SELECT SUM(total_amount) AS `total`
            FROM transactions
            WHERE YEAR(`date_created`) = $x";
    $result = $conn->query($sql);

    $date = date("Y", strtotime("$x-01-01"));
    $total = 0;
    while($row = $result->fetch_assoc()){
        $total += $row["total"];
    }
    $dateArray[] = $date;
    $totalArray[] = $total;
    }
}

$data[] = [
    "total_array" => $totalArray,
    "date_array" => $dateArray
];

echo json_encode([
    "data" => $data
]);
