<?php
header('Content-Type: application/json');
include('../includes/connection.php');

$request = isset($_GET["request"]) ? $_GET["request"] : "";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;
$offset = ($page - 1) * $limit;
$limitQuery = ($page > 0) ? " LIMIT $limit OFFSET $offset" : "";

if ($request === 'category') {
    $query = "SELECT * FROM categories WHERE archive_status = 1";
    
    $whereQuery = '';
    $search = isset($_GET["search"]) ? $_GET["search"] : '';
    $id = isset($_GET["id"]) ? $_GET["id"] : '';
    
    $whereQuery .= ($search !== '') ? " AND category_name LIKE '%$search%'" : '';
    $whereQuery .= ($id !== '') ? " AND id = $id" : '';

    $finalquery = $query.$whereQuery.$limitQuery;
    $result = $conn->query($finalquery);

    $data = []; 
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $data[] = [
            "id" => $row["id"],
            "category_name" => $row["category_name"],
            "add_ons" => $row["add-ons"],
            "archive_status" => $row["archive_status"]
        ];
    }

    $dataCount = $conn->query("SELECT COUNT(*) as data_count FROM categories WHERE archive_status = 1 AND category_name LIKE '%$search%'")->fetch_assoc()["data_count"];

    echo json_encode([
        "data" => $data,
        "data_count" => $dataCount
    ]);
}
?>
