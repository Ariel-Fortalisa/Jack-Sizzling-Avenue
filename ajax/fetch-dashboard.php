<?php
header('Content-Type: application/json');
include('../includes/connection.php');
date_default_timezone_set('Asia/Manila');


$request = isset($_GET["request"]) ? $_GET["request"] : "";


if ($request == "dashboard") {

    $query = "SELECT tr.*
            FROM transactions tr
            WHERE DATE(tr.date_created) = CURDATE()
            ORDER BY tr.date_created DESC
            LIMIT 10
    ";

    // $whereQuery = 'WHERE 1';

    // $finalQuery = $query . $whereQuery;

    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        array_push($data, [
            "tr_id" => $row["transaction_id"],
            "total_amount" => $row["total_amount"],
            "amount_tendered" => $row["amount_tendered"],
            "vat_amount" => $row["vat_amount"],
            "vat_sales" => $row["vat_sales"],
            "change" => $row["change_amount"],
            "discount" => $row["discount"],
            "date" => $row["date_created"],
            "added_by" => $row["added_by"]
        ]);

    }

    $product_count = $conn->query("SELECT COUNT(*) AS prd_count FROM products WHERE archive_status = 'unarchived'")->fetch_assoc()["prd_count"];
    $MonthSale = $conn->query("SELECT SUM(total_amount) AS month_sale FROM transactions WHERE MONTH(date_created) = MONTH(CURDATE()) AND YEAR(date_created) = YEAR(CURDATE());")->fetch_assoc()["month_sale"];
    $sale = $conn->query("SELECT SUM(total_amount) AS today_sale FROM transactions WHERE DATE(date_created) = CURDATE()")->fetch_assoc()["today_sale"];
    $transaction_count = $conn->query("SELECT COUNT(*) AS total_transaction FROM transactions WHERE DATE(date_created) = CURDATE()")->fetch_assoc()["total_transaction"];
    
    $month_sale = ($MonthSale == NULL) ? "0" : $MonthSale;
    $today_sale = ($sale == NULL) ? "0": $sale;

    echo json_encode([
        "data" => $data,
        "prd_count" => $product_count,
        "month_sale" => $month_sale,
        "today_sale" => $today_sale,
        "total_transaction" => $transaction_count
    ]);
}
