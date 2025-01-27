<?php
header('Content-Type: application/json');
include('../includes/connection.php');

$request = isset($_GET["request"]) ? $_GET["request"] : "";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;
$offset = ($page - 1) * $limit;
$limitQuery = ($page > 0) ? " LIMIT $limit OFFSET $offset" : "";



if($request === 'accounts'){
    $query = "SELECT * FROM users WHERE archive_status = 1";

    $whereQuery = '';
    $search = isset($_GET["search"]) ? $_GET["search"] : '';
    $id = isset($_GET["user_id"]) ? $_GET["user_id"] : '';
    
    $whereQuery .= ($search !== '') ? " AND first_name LIKE '%$search%'" : '';
    $whereQuery .= ($search !== '') ? " OR last_name LIKE '%$search%'" : '';
    $whereQuery .= ($search !== '') ? " OR username LIKE '%$search%'" : '';
    $whereQuery .= ($id !== '') ? " AND user_id = $id" : '';

    $finalquery = $query.$whereQuery.$limitQuery;
    $result = $conn->query($finalquery);

    $data = [];
    while($row = $result->fetch_assoc()){
        $user_id = $row["user_id"];
        $data[] = [
            "id" => $user_id,
            "first_name" => $row["first_name"],
            "last_name" => $row["last_name"],
            "user_name" => $row["username"],
            "role" => $row["user_role"],
            "password" => $row["password"], 
        ];
    }

    $dataCount = $conn->query("SELECT COUNT(*) as data_count FROM users WHERE archive_status = 0 OR first_name OR last_name OR username LIKE '%$search%'")->fetch_assoc()["data_count"];

    
    echo json_encode([
        "data" => $data,
        "data_count" => $dataCount
    ]);
}


?>