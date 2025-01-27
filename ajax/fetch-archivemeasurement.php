<?php
header('Content-Type: application/json');
include('../includes/connection.php');

$request = isset($_GET["request"]) ? $_GET["request"] : "";
$page = isset($_GET["page"]) ? $_GET["page"] : 1; 
$limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;
$offset = ($page - 1) * $limit;
$limitQuery = ($page > 0) ? " LIMIT $limit OFFSET $offset" : "";

if ($request === "unit") {

    $query = "
    SELECT *
    FROM unit_of_measurement
    ";

    $search = isset($_GET["search"]) ? $_GET["search"] : '';
    $id = isset($_GET["id"]) ? $_GET["id"] : '';
    
    $whereQuery = 'WHERE 1=1 AND archive_status = 1';
    $whereQuery .= ($search !== '') ? " AND unit_name LIKE '%$search%'" : '';
    $whereQuery .= ($id !== '') ? " AND unit_id = $id" : '';
    
    $finalQuery = $query . $whereQuery . $limitQuery;

    $result = $conn->query($finalQuery);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $id = $row["unit_id"];
        array_push($data, [
            "id" => $row["unit_id"],
            "unit_name" => $row["unit_name"]
        ]);
    }

    $dataCount = $conn->query("SELECT COUNT(*) as data_count FROM unit_of_measurement WHERE archive_status = 1 AND unit_name LIKE '%$search%'")->fetch_assoc()["data_count"];

    echo json_encode([
        "data" => $data,
        "data_count" => $dataCount
    ]);
}
?>
