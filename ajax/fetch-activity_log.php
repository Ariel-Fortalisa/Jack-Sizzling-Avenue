<?php
header('Content-Type: application/json');
include('../includes/connection.php');

$request = isset($_GET["request"]) ? $_GET["request"] : "";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;
$offset = ($page - 1) * $limit;
$limitQuery = ($page > 0) ? " LIMIT $limit OFFSET $offset" : "";


if($request === 'activity'){
    $query = "SELECT *,
               users.username,
               users.user_role
              FROM activity_logs 
              INNER JOIN users ON users.user_id = activity_logs.added_by
              WHERE 1
              ORDER BY
              log_id DESC";

    $result = $conn->query($query.$limitQuery);

    
    $data = [];
    while($row = $result->fetch_assoc()){
        $log_id = $row["log_id"];

        $data[] = [
            "id" => $log_id,
            "username" => $row["username"],
            "user_role" => $row["user_role"],
            "activity" => $row["activity_logs"],
            "date" => $row["date_created"], 

        ];
    }

          //get total data of the table for pagination
          $dataCount = $conn->query("SELECT COUNT(*) as data_count FROM activity_logs WHERE 1")->fetch_assoc()["data_count"];
        
          echo json_encode([
              "data" => $data,
              "data_count" => $dataCount
          ]);
}


?>