<?php
header('Content-Type: application/json');
include('../includes/connection.php');

$request = isset($_GET["request"]) ? $_GET["request"] : "";
$page = isset($_GET["page"]) ? $_GET["page"] : 1; 
$limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;
$offset = ($page - 1) * $limit;
$limitQuery = ($page > 0) ? " LIMIT $limit OFFSET $offset" : "";

if ($request === "batch") {

    $search = isset($_GET["search"]) ? $_GET["search"] : '';
    $stockId = isset($_GET["stock_id"]) ? $_GET["stock_id"] : '';
    $expirationStatus = isset($_GET["expiration_status"]) ? $_GET["expiration_status"] : '';

    // Build the base query for fetching batches with stock name
    $query = "
    SELECT 
        batch.batch_id, 
        batch.stock_id, 
        batch.qty, 
        batch.cost, 
        batch.expiration_date, 
        batch.expiration_status, 
        batch.archive_status,
        stocks.stock_name,
        unit_of_measurement.unit_name
    FROM batch
    INNER JOIN stocks ON batch.stock_id = stocks.stock_id
    INNER JOIN unit_of_measurement ON unit_of_measurement.unit_id = stocks.unit
    WHERE batch.archive_status = 0 AND batch.qty > 0
    ";

    // Add conditions for filtering
    $query .= ($stockId !== '') ? " AND batch.stock_id = $stockId" : '';
    $query .= ($search !== '') ? " AND stocks.stock_name LIKE '%$search%'" : '';
    $query .= ($expirationStatus !== '') ? " AND batch.expiration_status = $expirationStatus" : '';
    $query .= " ORDER BY batch.expiration_date ASC";
    $query .= $limitQuery;

    $result = $conn->query($query);

    $batches = [];
    while ($row = $result->fetch_assoc()) {
        array_push($batches, [
            "batch_id" => $row["batch_id"],
            "stock_id" => $row["stock_id"],
            "stock_name" => $row["stock_name"],
            "qty" => $row["qty"],
            "unit" => $row["unit_name"],
            "cost" => $row["cost"],
            "expiration_date" => date('Y-m-d', strtotime($row["expiration_date"])),
            "expiration_status" => $row["expiration_status"],
            "archive_status" => $row["archive_status"]
        ]);
    }

    // Fetch the total count for pagination
    $Goodcount = $conn->query("
    SELECT COUNT(*) as Goodcount 
    FROM batch 
    INNER JOIN stocks ON batch.stock_id = stocks.stock_id
    WHERE batch.expiration_status = 1 AND batch.qty > 0 AND batch.archive_status = 0
")->fetch_assoc()["Goodcount"];


    $NearlyExpireCount = $conn->query("
    SELECT COUNT(*) as NearlyExpireCount 
    FROM batch 
    INNER JOIN stocks ON batch.stock_id = stocks.stock_id
    WHERE batch.expiration_status = 2 AND batch.qty > 0 AND batch.archive_status = 0
")->fetch_assoc()["NearlyExpireCount"];

    $expirecount = $conn->query("
        SELECT COUNT(*) as expirecount 
        FROM batch 
        INNER JOIN stocks ON batch.stock_id = stocks.stock_id
        WHERE batch.expiration_status = 3 AND batch.qty > 0 AND batch.archive_status = 0
    ")->fetch_assoc()["expirecount"];

    $dataCount = $conn->query("SELECT COUNT(*) as data_count FROM batch INNER JOIN stocks ON batch.stock_id = stocks.stock_id WHERE batch.archive_status = 0 AND qty > 0 AND stock_name LIKE '%$search%'")->fetch_assoc()["data_count"];

    echo json_encode([
        "data" => $batches,
        "data_count" => $dataCount,
        "Goodcount" => $Goodcount,
        "NearlyExpireCount" => $NearlyExpireCount,
        "expired_count" => $expirecount
    ]);
}
?>
