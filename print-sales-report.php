<?php
session_start();
date_default_timezone_set('Asia/Manila');
include("./includes/connection.php");

include('./includes/userValidate.php');
userAllow(1);

include ("./includes/log_check.php");

$first_name = $_SESSION["first_name"];
$Last_name = $_SESSION["last_name"];

$date = date("Y-m-d H:i:s");
$date_timestamp = strtotime($date);
$dt = date('M. j, Y', $date_timestamp);
$time_part = date('h:i A', $date_timestamp);

$storedetails = $conn->query("SELECT * FROM system WHERE 1");

while ($row = $storedetails->fetch_assoc()) {
  $storeName = $row["store_name"];
  $storeAddress = $row["store_address"];
  $contact = $row["contact"];
}

$basis = isset($_GET["basis"]) ? $_GET["basis"] : "Daily";
$year = isset($_GET["year"]) ? $_GET["year"] : date("Y");
$month = isset($_GET["month"]) ? $_GET["month"] : date("m");

$salesGraphtable = "";
$Count = 1;

//initial value for Header
$totalSales = 0;
$totalTransactions = 0;


if ($basis == "Daily") {

  $maxDay = ($year == date("Y") and $month == date("m")) ? date("d") : date("t", strtotime("$year-$month-1"));

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

    $salesGraphtable .= '
        <tr>
            <th class="text-center">' . $Count . '</th>
            <td class="text-center">' . $date . '</td>
            <td class="text-center">₱ ' . number_format($total, 2) . '</td>
        </tr>
    ';
    $Count++;
  }

  $totalSales = $conn->query("
  SELECT SUM(`total_amount`) AS `total`
  FROM `transactions`
  WHERE YEAR(`date_created`) = '$year' AND MONTH(`date_created`) = '$month'
")->fetch_assoc()["total"];

$totalTransactions = $conn->query("
  SELECT COUNT(*) AS `total_transaction`
  FROM `transactions`
  WHERE YEAR(`date_created`) = '$year' AND MONTH(`date_created`) = '$month'
  ")->fetch_assoc()["total_transaction"];

  $salesHeader = "Daily Sales " . date("F", strtotime("$year-$month-01")) . " " . date("Y", strtotime("$year-$month-01"));
} else if ($basis == "Weekly") {
  $days = [0, 7, 14, 21, 28, 31];
  for ($x = 0; $x < 4; $x++) {
    $startDay = $days[$x] + 1;
    $endDay = $days[$x + 1];

    $sql = "SELECT SUM(`total_amount`) AS `total`
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
    $salesGraphtable .= '
      <tr>
          <th class="text-center">' . $Count . '</th>
          <td class="text-center">' . $date . '</td>
          <td class="text-center">₱ ' . number_format($total, 2) . '</td>
      </tr>
  ';
    $Count++;
  }

  $totalSales = $conn->query("
  SELECT SUM(`total_amount`) AS `total`
  FROM `transactions`
  WHERE YEAR(`date_created`) = '$year' AND MONTH(`date_created`) = '$month'
")->fetch_assoc()["total"];

  $totalTransactions = $conn->query("
  SELECT COUNT(*) AS `total_transaction`
  FROM `transactions`
  WHERE YEAR(`date_created`) = '$year' AND MONTH(`date_created`) = '$month'
")->fetch_assoc()["total_transaction"];

  $salesHeader = "Weekly Sales " . date("F", strtotime("$year-$month-01")) . " " . date("Y", strtotime("$year-$month-01"));
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
    $salesGraphtable .= '
    <tr>
        <th class="text-center">' . $Count . '</th>
        <td class="text-center">' . $date . '</td>
        <td class="text-center">₱ ' . number_format($total, 2) . '</td>
    </tr>
';
    $Count++;
  }

  $totalSales = $conn->query("
  SELECT SUM(`total_amount`) AS `total`
  FROM `transactions`
  WHERE YEAR(`date_created`) = '$year' AND MONTH(`date_created`)
")->fetch_assoc()["total"];

  $totalTransactions = $conn->query("
  SELECT COUNT(*) AS `total_transaction`
  FROM `transactions`
  WHERE YEAR(`date_created`) = '$year' AND MONTH(`date_created`)
")->fetch_assoc()["total_transaction"];

  $salesHeader = "Monthly Sales " . date("Y", strtotime("$year-$month-01"));

} else if ($basis == "Yearly") {
  $minYear = $conn->query("SELECT YEAR(MIN(date_created)) AS min_year FROM transactions")->fetch_assoc()["min_year"];
  $maxYear  = $conn->query("SELECT YEAR(MAX(date_created)) AS min_year FROM transactions")->fetch_assoc()["min_year"];
  for ($x = $minYear; $x <= $maxYear; $x++) {
    $sql = "SELECT SUM(total_amount) AS `total`
          FROM transactions
          WHERE YEAR(`date_created`) = $x";
    $result = $conn->query($sql);

    $date = date("Y", strtotime("$x-01-01"));
    $total = 0;
    while ($row = $result->fetch_assoc()) {
      $total += $row["total"];
    }
    $salesGraphtable .= '
    <tr>
        <th class="text-center">' . $Count . '</th>
        <td class="text-center">' . $date . '</td>
        <td class="text-right">₱ ' . number_format($total, 2) . '</td>
    </tr>
';
    $Count++;
  }

  $totalSales = $conn->query("
  SELECT SUM(`total_amount`) AS `total`
  FROM `transactions`
  WHERE 1
")->fetch_assoc()["total"];

  $totalTransactions = $conn->query("
  SELECT COUNT(*) AS `total_transaction`
  FROM `transactions`
  WHERE 1
")->fetch_assoc()["total_transaction"];

  $salesHeader = "Yearly Sales";
}


//top selling
$type = $_GET["sort"];
$sort = $type == "top" ? "DESC" : "ASC";

$productSalesHeader = ($type == "top") ? "Top Selling Products" : "Least Selling Products";

$result = $conn->query("
             SELECT ti.tp_id, p.product_name, SUM(ti.subtotal) AS total
        FROM transaction_items ti
            INNER JOIN products p ON p.id = ti.product_id
            INNER JOIN transactions tr ON tr.transaction_id = ti.transaction_id
        WHERE 1
        GROUP BY
            ti.product_id
        ORDER BY
            total $sort
        LIMIT 7
    ");

$topSellingRows = "";
if ($result->num_rows > 0) {
  $rowCount = 1;
  while ($row = $result->fetch_assoc()) {
    $topSellingRows .= '
                <tr>
                    <td class="text-center">' . $rowCount . '</td>
                    <td class="text-left">' . $row["product_name"] . '</td>
                    <td class="text-center">₱ ' . number_format($row["total"], 2) . '</td>
                </tr>
            ';

    $rowCount++;
  }
} else {
  $topSellingRows .= '
            <tr>
                <td colspan="3" style="height: 300px">There are no product sales yet</td>
            </tr>
        ';
}



//list of transaction
$today = date("Y-m-d");

$result = $conn->query("
     SELECT tr.* 
    FROM transactions tr 
    WHERE DATE(tr.date_created) = '$today'
    ORDER BY tr.date_created DESC
");

$transactionListHeader = "Transactions for " . date("M d, Y", strtotime($today));

$transactionListRow = "";

$rowCount = 1;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $id = $row["transaction_id"];
    $total = $row["total_amount"];
    $amount_tendered = $row["amount_tendered"];
    $change = $row["change_amount"];
    $discount = $row["discount"];
    $vatsales = $row["vat_sales"];
    $vat_amount = $row["vat_amount"];

    // Construct the row for each transaction
    $transactionListRow .= '
            <tr>
                <th class="text-center">' . $rowCount . '</th>
                <td class="text-center">' . $id . '</td>
                <td class="text-center">₱ ' . number_format($total, 2) . '</td>
                <td class="text-center">₱ ' . number_format($amount_tendered, 2) . '</td>
                <td class="text-center">₱ ' . number_format($vat_amount, 2) . '</td>
                <td class="text-center">₱ ' . number_format($vatsales, 2) . '</td>
                <td class="text-center">₱ ' . number_format($change, 2) . '</td>
                <td class="text-center">' . $discount . '%</td>
            </tr>
        ';

    $rowCount++;
  }
} else {
  // If no transactions exist today
  $transactionListRow .= '
        <tr>
            <th colspan="8" class="text-center" style="height: 350px; vertical-align: middle">There are no transactions today</th>
        </tr>
    ';
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Jquery -->
  <script src="./js/jquery.min.js"></script>

  <!-- chart js -->
  <script src="./js/chart.js"></script>

  <!-- BOOTSTRAP -->
  <link rel="stylesheet" href="./bootstrap/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="./bootstrap/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>



  <!-- Unicons -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

  <!-- My CSS -->
  <!-- <link rel="stylesheet" href="./css/tablestyle.css">
  <link rel="stylesheet" href="style.css"> -->

  <!-- Page Transition -->
  <link rel="stylesheet" href="page_transition.css">






  <title>Sales Report</title>


  
</head>
<style>
    /* .row {
    display: flex;                
    justify-content: space-between; 
    margin-top: 20px;             /
}

    .col {
        padding: 0 10px;            
    }

    .col-7 {
        flex: 0 0 70%;               
    }

    .col-5 {
        flex: 0 0 30%;                
    } */

    .store-logo {
      width: 200px;
      height: 90px;
      margin: 0 auto;
      display: block;
      margin-bottom: 10px;

    }

    p {
      padding: 0;
      margin: 0;
    }

    .title-report {
      text-align: center;
    }

    @page {
        size: A4;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }

    body {
        margin: 0;
        padding: 0;
        font-family: "Work Sans", sans-serif;
    }

    .page {
        margin: auto;
        width: 210mm;
        /*height: 297mm;
        border: 1px solid lightgray;*/
    }
  </style>
<body>


  <div id="buttonDiv" style="margin: 30px auto; display: flex; justify-content: center">
    <a href="./sales.php"><button type="button" class="btn btn-secondary m-3">Back</button></a>
    <div class="add-stock"><button type="button" class="btn btn-primary m-3" onclick="hideButtons()">Print</button></div>
  </div>
  <!-- daily weekly monthly and yearly sale -->
  <div class="page">
    <div class="header" style="margin: auto;">
      <p class="text-center"><img class="store-logo" src="./asset/logo_1.png"></p>
      <h2 class="title-report">Sales Reports</h2>
      <div class="row">
        <div class="col col-6">
          <h5><b class="text-bold"><?= $storeName ?></b></h5>
          <p><?= $storeAddress ?></p>
          <p><?= $contact ?></p>
          <p><b>Prepared by:</b>&emsp;<?= $Last_name . ', ' . $first_name ?></p>
        </div>
        <div class="col col-3"></div>
        <div class="col col-3">
          <h6><b>Date:</b></h6>
          <p>&emsp;<?= $dt ?></p>
          <p>&emsp;<?= $time_part ?></p>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col col-7 d-flex align-items-center">
        <!--Sales Graph Header-->
        <h5><?= $salesHeader ?></h5>
      </div>
      <div class="col col-5">
        <p><b>Total Sales:&emsp;</b>₱ <?= number_format($totalSales, 2) ?></p>
        <b>Total Transactions:&emsp;</b><?= number_format($totalTransactions) ?> transactions
      </div>
    </div>
    <table class="table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
      <thead>
        <tr>
          <th class="text-center">#</th>
          <th class="text-center">DATE</th>
          <th class="text-center">TOTAL SALES</th>
        </tr>
      </thead>
      <tbody>
        <?= $salesGraphtable ?>
      </tbody>
    </table>
  </div>
  <!-- daily weekly monthly and yearly sale -->

  <!-- top sales -->
  <div class="page">
    <p class="text-center"><img class="store-logo" src="./asset/logo_1.png"></p>
    <h2 class="title-report"><?= $productSalesHeader ?></h2>
    <div style="display: flex; justify-content: space-between;">
    </div>
    <hr>
    <table class="table" style="width: 100%; margin-top: 20px;">
      <thead>
        <th class="text-center">#</th>
        <th class="text-center">PRODUCT NAME</th>
        <th class="text-center">TOTAL</th>
      </thead>
      <tbody>
        <?= $topSellingRows ?>
      </tbody>
    </table>
  </div>
  <!-- top sales -->

  <!-- List of transaction -->
 <div class="page">
    <p class="text-center"><img class="store-logo" src="./asset/logo_1.png"></p>
    <h2 class="title-report">List of Transactions</h2>
    <div style="display: flex; justify-content: space-between;">
  </div>
  <hr>
  <div>
    <h5><?= $transactionListHeader ?></h5>
  </div>
  <table class="table" style="width: 100%; margin-top: 20px;">
    <thead>
      <th class="text-center">#</th>
      <th class="text-center">REFERENCE</th>
      <th class="text-center">TOTAL AMOUNT</th>
      <th class="text-center">AMOUNT TENDERED</th>
      <th class="text-center">VAT AMOUNT</th>
      <th class="text-center">VAT SALES</th>
      <th class="text-center">CHANGE</th>
      <th class="text-center">DISCOUNT</th>
    </thead>
    <tbody>
      <?= $transactionListRow ?>
    </tbody>
  </table>
  </div>
  <!-- List of transaction -->




</body>

<script>
  function hideButtons() {
    $("#buttonDiv").css("display", "none");
    window.print();
    $("#buttonDiv").css("display", "flex");
  }
</script>


</html>