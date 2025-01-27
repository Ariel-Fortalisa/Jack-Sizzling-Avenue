<?php
header('Content-Type: application/json');
include('../includes/connection.php');

$request = isset($_GET["request"]) ? $_GET["request"] : "";
$page = isset($_GET["page"]) ? $_GET["page"] : 1; 
$limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;
$offset = ($page - 1) * $limit;
$limitQuery = ($page > 0) ? " LIMIT $limit OFFSET $offset" : "";


if ($request === "items") {

    $query = "
   SELECT *,
   (SELECT SUM(qty) FROM batch WHERE stock_id = stock.stock_id AND batch.archive_status = 0) as quantity,
    unit_of_measurement.unit_id,
    unit_of_measurement.unit_name AS UOM
    FROM stocks stock
    INNER JOIN unit_of_measurement ON stock.unit = unit_of_measurement.unit_id
    ";

    $search = isset($_GET["search"]) ? $_GET["search"] : '';
    $id = isset($_GET["id"]) ? $_GET["id"] : '';
    $stock_status = isset($_GET["stock_status"]) ? $_GET["stock_status"] : '';
    
    $whereQuery = 'WHERE 1=1 AND stock.archive_status = 0';
    $whereQuery .= ($search !== '') ? " AND stock_name LIKE '%$search%'" : '';
    $whereQuery .= ($id !== '') ? " AND stock.stock_id = $id" : '';
    if ($stock_status !== '') {
        $whereQuery .= " AND stock.stock_status = $stock_status";
    }
    
    $finalQuery = $query . $whereQuery . $limitQuery;

    $result = $conn->query($finalQuery);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $id = $row["stock_id"];
        $batch = [];
        // Update the batch query to include the filters and ordering
        $batchSQL = $conn->query("
        SELECT *
        FROM batch 
        WHERE stock_id = $id AND archive_status = 0 AND qty > 0
        ORDER BY expiration_date ASC
        ");

        while ($bdc = $batchSQL->fetch_assoc()) {
            array_push($batch, [
                "batch_id" => $bdc["batch_id"],
                "qty" => $bdc["qty"],
                "cost" => $bdc["cost"],
                "expiration_date" => date('Y-m-d', strtotime($bdc["expiration_date"])),
                "expiration_status" => $bdc["expiration_status"],
                "archive_status" => $bdc["archive_status"]
            ]);
        } 

        array_push($data, [
            "id" => $row["stock_id"],
            "item_name" => $row["stock_name"],
            "cost" => $row["cost"],
            "unit_id" => $row["unit_id"],
            "qty" => $row["quantity"],
            "unit" => $row["UOM"],
            "critical" => $row["crit"],
            "archive_status" => $row["archive_status"],
            "stock_status" => $row["stock_status"],
            "date_added" => $row["date_added"],
            "batch" => $batch,
        ]);
    }

    $inStockCount = $conn->query("SELECT COUNT(*) as inStockCount FROM stocks WHERE archive_status = 0 AND stock_status = 1")->fetch_assoc()["inStockCount"];
    $LowStockCount = $conn->query("SELECT COUNT(*) as LowStockCount FROM stocks WHERE archive_status = 0 AND stock_status = 2")->fetch_assoc()["LowStockCount"];
    $OutofStockCount = $conn->query("SELECT COUNT(*) as OutofStockCount FROM stocks WHERE archive_status = 0 AND stock_status = 3")->fetch_assoc()["OutofStockCount"];
    $overall_items = $conn->query("SELECT COUNT(*) as overall_items FROM stocks WHERE archive_status = 0")->fetch_assoc()["overall_items"];
    $inventory_cost = $conn->query("SELECT SUM(cost)  AS `cost` FROM batch WHERE archive_status = 0 AND qty > 0")->fetch_assoc()["cost"];
    
    echo json_encode([
        "data" => $data,
        "inStockCount" => $inStockCount,
        "LowStockCount" => $LowStockCount,
        "OutofStockCount" => $OutofStockCount,
        "overall_items" => $overall_items,
        "inventory_cost" => $inventory_cost
    ]);
}
?>